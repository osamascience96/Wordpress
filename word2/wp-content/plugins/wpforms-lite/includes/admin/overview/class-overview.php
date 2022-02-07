<?php

/**
 * Primary overview page inside the admin which lists all forms.
 *
 * @since 1.0.0
 */
class WPForms_Overview {

	/**
	 * Overview Table instance.
	 *
	 * @since 1.7.2
	 *
	 * @var WPForms_Overview_Table
	 */
	private $overview_table;

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Maybe load overview page.
		add_action( 'admin_init', [ $this, 'init' ] );

		// Setup screen options. Needs to be here as admin_init hook it too late.
		add_action( 'load-toplevel_page_wpforms-overview', [ $this, 'screen_options' ] );
		add_filter( 'set-screen-option', [ $this, 'screen_options_set' ], 10, 3 );
		add_filter( 'set_screen_option_wpforms_forms_per_page', [ $this, 'screen_options_set' ], 10, 3 );
	}

	/**
	 * Determine if the user is viewing the overview page, if so, party on.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Only load if we are actually on the overview page.
		if ( ! wpforms_is_admin_page( 'overview' ) ) {
			return;
		}

		// Avoid recursively include _wp_http_referer in the REQUEST_URI.
		$this->remove_referer();

		add_action( 'current_screen', [ $this, 'init_overview_table' ] );

		// Bulk actions.
		add_action( 'load-toplevel_page_wpforms-overview', [ $this, 'notices' ] );
		add_action( 'load-toplevel_page_wpforms-overview', [ $this, 'process_bulk_actions' ] );
		add_filter( 'removable_query_args', [ $this, 'removable_query_args' ] );

		// The overview page leverages WP_List_Table so we must load it.
		if ( ! class_exists( 'WP_List_Table', false ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
		}

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueues' ] );
		add_action( 'wpforms_admin_page', [ $this, 'output' ] );

		// Provide hook for addons.
		do_action( 'wpforms_overview_init' );
	}

	/**
	 * Init overview table class.
	 *
	 * @since 1.7.2
	 */
	public function init_overview_table() {

		// Load the class that builds the overview table.
		require_once WPFORMS_PLUGIN_DIR . 'includes/admin/overview/class-overview-table.php';

		$this->overview_table = new WPForms_Overview_Table();
	}

	/**
	 * Remove previous `_wp_http_referer` variable from the REQUEST_URI.
	 *
	 * @since 1.7.2
	 */
	private function remove_referer() {

		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$_SERVER['REQUEST_URI'] = remove_query_arg( '_wp_http_referer', wp_unslash( $_SERVER['REQUEST_URI'] ) );
		}
	}

	/**
	 * Add per-page screen option to the Forms table.
	 *
	 * @since 1.0.0
	 */
	public function screen_options() {

		$screen = get_current_screen();

		if ( $screen === null || $screen->id !== 'toplevel_page_wpforms-overview' ) {
			return;
		}

		add_screen_option(
			'per_page',
			[
				'label'   => esc_html__( 'Number of forms per page:', 'wpforms-lite' ),
				'option'  => 'wpforms_forms_per_page',
				'default' => apply_filters( 'wpforms_overview_per_page', 20 ),
			]
		);
	}

	/**
	 * Form table per-page screen option value.
	 *
	 * @since 1.0.0
	 *
	 * @param bool   $keep   Whether to save or skip saving the screen option value. Default false.
	 * @param string $option The option name.
	 * @param int    $value  The number of rows to use.
	 *
	 * @return mixed
	 */
	public function screen_options_set( $keep, $option, $value ) {

		if ( $option === 'wpforms_forms_per_page' ) {
			return $value;
		}

		return $keep;
	}

	/**
	 * Enqueue assets for the overview page.
	 *
	 * @since 1.0.0
	 */
	public function enqueues() {

		// Hook for addons.
		do_action( 'wpforms_overview_enqueue' );
	}

	/**
	 * Build the output for the overview page.
	 *
	 * @since 1.0.0
	 */
	public function output() {

		?>
		<div id="wpforms-overview" class="wrap wpforms-admin-wrap">

			<h1 class="page-title">
				<?php esc_html_e( 'Forms Overview', 'wpforms-lite' ); ?>
				<?php if ( wpforms_current_user_can( 'create_forms' ) ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=wpforms-builder&view=setup' ) ); ?>" class="add-new-h2 wpforms-btn-orange">
						<?php esc_html_e( 'Add New', 'wpforms-lite' ); ?>
					</a>
				<?php endif; ?>
			</h1>

			<div class="wpforms-admin-content">

				<?php
				$this->overview_table->prepare_items();

				do_action( 'wpforms_admin_overview_before_table' );

				if (
					empty( $this->overview_table->items ) &&
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended
					! isset( $_GET['search']['term'] )
				) {

					// Output no forms screen.
					echo wpforms_render( 'admin/empty-states/no-forms' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				} else {
				?>
					<form id="wpforms-overview-table" method="get" action="<?php echo esc_url( admin_url( 'admin.php?page=wpforms-overview' ) ); ?>">

						<input type="hidden" name="post_type" value="wpforms" />
						<input type="hidden" name="page" value="wpforms-overview" />

						<?php
							$this->overview_table->views();
							$this->overview_table->search_box( esc_html__( 'Search Forms', 'wpforms-lite' ), 'wpforms-overview-search' );
							$this->overview_table->display();
						?>

					</form>
				<?php } ?>

			</div>

		</div>
		<?php
	}

	/**
	 * Add admin action notices and process bulk actions.
	 *
	 * @since 1.5.7
	 */
	public function notices() {

		$deleted    = ! empty( $_REQUEST['deleted'] ) ? sanitize_key( $_REQUEST['deleted'] ) : false; // phpcs:ignore WordPress.Security.NonceVerification
		$duplicated = ! empty( $_REQUEST['duplicated'] ) ? sanitize_key( $_REQUEST['duplicated'] ) : false; // phpcs:ignore WordPress.Security.NonceVerification
		$notice     = [];

		if ( $deleted && $deleted !== 'error' ) {
			$notice = [
				'type' => 'info',
				/* translators: %s - Deleted forms count. */
				'msg'  => sprintf( _n( '%s form was successfully deleted.', '%s forms were successfully deleted.', $deleted, 'wpforms-lite' ), $deleted ),
			];
		}

		if ( $duplicated && $duplicated !== 'error' ) {
			$notice = [
				'type' => 'info',
				/* translators: %s - Duplicated forms count. */
				'msg'  => sprintf( _n( '%s form was successfully duplicated.', '%s forms were successfully duplicated.', $duplicated, 'wpforms-lite' ), $duplicated ),
			];
		}

		if ( $deleted === 'error' || $duplicated === 'error' ) {
			$notice = [
				'type' => 'error',
				'msg'  => esc_html__( 'Security check failed. Please try again.', 'wpforms-lite' ),
			];
		}

		if ( ! empty( $notice ) ) {
			\WPForms\Admin\Notice::add( $notice['msg'], $notice['type'] );
		}
	}

	/**
	 * Process the bulk table actions.
	 *
	 * @since 1.5.7
	 */
	public function process_bulk_actions() {

		$ids    = isset( $_GET['form_id'] ) ? array_map( 'absint', (array) $_GET['form_id'] ) : []; // phpcs:ignore WordPress.Security.NonceVerification
		$action = ! empty( $_REQUEST['action'] ) ? sanitize_key( $_REQUEST['action'] ) : false; // phpcs:ignore WordPress.Security.NonceVerification

		if ( $action === '-1' ) {
			$action = ! empty( $_REQUEST['action2'] ) ? sanitize_key( $_REQUEST['action2'] ) : false; // phpcs:ignore WordPress.Security.NonceVerification
		}

		// Checking the sortable column link.
		$is_orderby_link = ! empty( $_REQUEST['orderby'] ) && ! empty( $_REQUEST['order'] );

		if ( empty( $ids ) || empty( $action ) || $is_orderby_link ) {
			return;
		}

		// Check exact action values.
		if ( ! in_array( $action, [ 'delete', 'duplicate' ], true ) ) {
			return;
		}

		if ( empty( $_GET['_wpnonce'] ) ) {
			return;
		}

		// Check the nonce.
		if (
			! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'bulk-forms' ) &&
			! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'wpforms_' . $action . '_form_nonce' )
		) {
			return;
		}

		// Check that we have a method for this action.
		if ( ! method_exists( $this, 'bulk_action_' . $action . '_forms' ) ) {
			return;
		}

		$processed_forms = count( $this->{'bulk_action_' . $action . '_forms'}( $ids ) );

		// Unset get vars and perform redirect to avoid action reuse.
		wp_safe_redirect(
			add_query_arg(
				$action . 'd',
				$processed_forms,
				remove_query_arg( [ 'action', 'action2', '_wpnonce', 'form_id', 'paged', '_wp_http_referer' ] )
			)
		);
		exit;
	}

	/**
	 * Delete forms.
	 *
	 * @since 1.5.7
	 *
	 * @param array $ids Form ids to delete.
	 *
	 * @return array List of deleted forms.
	 */
	private function bulk_action_delete_forms( $ids ) {

		if ( ! is_array( $ids ) ) {
			return [];
		}

		$deleted = [];

		foreach ( $ids as $id ) {
			$deleted[ $id ] = wpforms()->form->delete( $id );
		}

		return array_keys( array_filter( $deleted ) );
	}

	/**
	 * Duplicate forms.
	 *
	 * @since 1.5.7
	 *
	 * @param array $ids Form ids to duplicate.
	 *
	 * @return array List of duplicated forms.
	 */
	private function bulk_action_duplicate_forms( $ids ) {

		if ( ! is_array( $ids ) ) {
			return [];
		}

		if ( ! wpforms_current_user_can( 'create_forms' ) ) {
			return [];
		}

		$duplicated = [];

		foreach ( $ids as $id ) {
			if ( wpforms_current_user_can( 'view_form_single', $id ) ) {
				$duplicated[ $id ] = wpforms()->form->duplicate( $id );
			}
		}

		return array_keys( array_filter( $duplicated ) );
	}

	/**
	 * Remove certain arguments from a query string that WordPress should always hide for users.
	 *
	 * @since 1.5.7
	 *
	 * @param array $removable_query_args An array of parameters to remove from the URL.
	 *
	 * @return array Extended/filtered array of parameters to remove from the URL.
	 */
	public function removable_query_args( $removable_query_args ) {

		if ( wpforms_is_admin_page( 'overview' ) ) {
			$removable_query_args[] = 'duplicated';
		}

		return $removable_query_args;
	}
}

new WPForms_Overview();
