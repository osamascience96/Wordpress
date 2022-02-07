<?php

namespace WPForms\Lite\Admin;

/**
 * Dashboard Widget shows a chart and the form entries stats in WP Dashboard.
 *
 * @since 1.5.0
 */
class DashboardWidget {

	/**
	 * Widget settings.
	 *
	 * @since 1.5.0
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Constructor.
	 *
	 * @since 1.5.0
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'init' ) );
	}
	/**
	 * Init class.
	 *
	 * @since 1.5.5
	 */
	public function init() {

		// This widget should be displayed for certain high-level users only.
		if ( ! wpforms_current_user_can() ) {
			return;
		}

		if ( ! apply_filters( 'wpforms_admin_dashboardwidget', true ) ) {
			return;
		}

		$this->settings();
		$this->hooks();
	}

	/**
	 * Filterable widget settings.
	 *
	 * @since 1.5.0
	 */
	public function settings() {

		$this->settings = array(

			// Number of forms to display in the forms list before "Show More" button appears.
			'forms_list_number_to_display'     => \apply_filters( 'wpforms_dash_widget_forms_list_number_to_display', 5 ),

			// Allow results caching to reduce DB load.
			'allow_data_caching'               => \apply_filters( 'wpforms_dash_widget_allow_data_caching', true ),

			// Transient lifetime in seconds. Defaults to the end of a current day.
			'transient_lifetime'               => \apply_filters( 'wpforms_dash_widget_transient_lifetime', \strtotime( 'tomorrow' ) - \time() ),

			// Determine if the forms with no entries should appear in a forms list. Once switched, the effect applies after cache expiration.
			'display_forms_list_empty_entries' => \apply_filters( 'wpforms_dash_widget_display_forms_list_empty_entries', true ),
		);
	}

	/**
	 * Widget hooks.
	 *
	 * @since 1.5.0
	 */
	public function hooks() {

		\add_action( 'admin_enqueue_scripts', array( $this, 'widget_scripts' ) );

		\add_action( 'wp_dashboard_setup', array( $this, 'widget_register' ) );

		\add_action( 'admin_init', array( $this, 'hide_widget' ) );

		\add_action( 'wpforms_create_form', __CLASS__ . '::clear_widget_cache' );
		\add_action( 'wpforms_save_form', __CLASS__ . '::clear_widget_cache' );
		\add_action( 'wpforms_delete_form', __CLASS__ . '::clear_widget_cache' );
	}

	/**
	 * Load widget-specific scripts.
	 *
	 * @since 1.5.0
	 */
	public function widget_scripts() {

		$screen = \get_current_screen();
		if ( ! isset( $screen->id ) || 'dashboard' !== $screen->id ) {
			return;
		}

		$min = \wpforms_get_min_suffix();

		\wp_enqueue_style(
			'wpforms-dashboard-widget',
			\WPFORMS_PLUGIN_URL . "assets/css/dashboard-widget{$min}.css",
			array(),
			\WPFORMS_VERSION
		);

		\wp_enqueue_script(
			'wpforms-moment',
			\WPFORMS_PLUGIN_URL . 'assets/js/moment.min.js',
			array(),
			'2.22.2',
			true
		);

		\wp_enqueue_script(
			'wpforms-chart',
			\WPFORMS_PLUGIN_URL . 'assets/js/chart.min.js',
			array( 'wpforms-moment' ),
			'2.7.2',
			true
		);

		\wp_enqueue_script(
			'wpforms-dashboard-widget',
			\WPFORMS_PLUGIN_URL . "lite/assets/js/admin/dashboard-widget{$min}.js",
			array( 'jquery', 'wpforms-chart' ),
			\WPFORMS_VERSION,
			true
		);

		\wp_localize_script(
			'wpforms-dashboard-widget',
			'wpforms_dashboard_widget',
			array(
				'show_more_html' => \esc_html__( 'Show More', 'wpforms-lite' ) . '<span class="dashicons dashicons-arrow-down"></span>',
				'show_less_html' => \esc_html__( 'Show Less', 'wpforms-lite' ) . '<span class="dashicons dashicons-arrow-up"></span>',
				'i18n'           => array(
					'entries' => \esc_html__( 'Entries', 'wpforms-lite' ),
				),
			)
		);
	}

	/**
	 * Register the widget.
	 *
	 * @since 1.5.0
	 */
	public function widget_register() {

		global $wp_meta_boxes;

		$widget_key = 'wpforms_reports_widget_lite';

		\wp_add_dashboard_widget(
			$widget_key,
			\esc_html__( 'WPForms', 'wpforms-lite' ),
			array( $this, 'widget_content' )
		);

		// Attempt to place the widget at the top.
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$widget_instance  = array( $widget_key => $normal_dashboard[ $widget_key ] );
		unset( $normal_dashboard[ $widget_key ] );
		$sorted_dashboard = \array_merge( $widget_instance, $normal_dashboard );

		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}

	/**
	 * Load widget content.
	 *
	 * @since 1.5.0
	 */
	public function widget_content() {

		$forms = \wpforms()->form->get( '', array( 'fields' => 'ids' ) );

		echo '<div class="wpforms-dash-widget wpforms-lite">';

		if ( empty( $forms ) ) {
			$this->widget_content_no_forms_html();
		} else {
			$this->widget_content_html();
		}
		$plugins = \get_plugins();

		if (
			! \array_key_exists( 'google-analytics-for-wordpress/googleanalytics.php', $plugins ) &&
			! \array_key_exists( 'google-analytics-premium/googleanalytics-premium.php', $plugins ) &&
			! empty( $forms )
		) {
			$this->recommended_plugin_block_html();
		}

		echo '</div><!-- .wpforms-dash-widget -->';
	}

	/**
	 * Widget content HTML if a user has no forms.
	 *
	 * @since 1.5.0
	 */
	public function widget_content_no_forms_html() {

		$create_form_url = \add_query_arg( 'page', 'wpforms-builder', \admin_url( 'admin.php' ) );
		$learn_more_url  = 'https://wpforms.com/docs/creating-first-form/?utm_source=WordPress&utm_medium=link&utm_campaign=liteplugin&utm_content=dashboardwidget';

		?>
		<div class="wpforms-dash-widget-block wpforms-dash-widget-block-no-forms">
			<img class="wpforms-dash-widget-block-sullie-logo" src="<?php echo \esc_url( WPFORMS_PLUGIN_URL . 'assets/images/sullie.png' ); ?>" alt="<?php \esc_attr_e( 'Sullie the WPForms mascot', 'wpforms-lite' ); ?>">
			<h2><?php \esc_html_e( 'Create Your First Form to Start Collecting Leads', 'wpforms-lite' ); ?></h2>
			<p><?php \esc_html_e( 'You can use WPForms to build contact forms, surveys, payment forms, and more with just a few clicks.', 'wpforms-lite' ); ?></p>

			<?php if ( wpforms_current_user_can( 'create_forms' ) ) : ?>
				<a href="<?php echo \esc_url( $create_form_url ); ?>" class="button button-primary">
					<?php \esc_html_e( 'Create Your Form', 'wpforms-lite' ); ?>
				</a>
			<?php endif; ?>

			<a href="<?php echo \esc_url( $learn_more_url ); ?>" class="button" target="_blank" rel="noopener noreferrer">
				<?php \esc_html_e( 'Learn More', 'wpforms-lite' ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Widget content HTML.
	 *
	 * @since 1.5.0
	 */
	public function widget_content_html() {

		?>

		<div class="wpforms-dash-widget-chart-block-container">

			<div class="wpforms-dash-widget-block">
				<h3 id="wpforms-dash-widget-chart-title">
					<?php \esc_html_e( 'Total Entries', 'wpforms-lite' ); ?>
				</h3>
				<select class="wpforms-dash-widget-select-timespan" style="display: none;">
					<option><?php \esc_html_e( 'Last 7 days', 'wpforms-lite' ); ?></option>
				</select>
			</div>

			<div class="wpforms-dash-widget-block wpforms-dash-widget-chart-block">
				<canvas id="wpforms-dash-widget-chart" width="400" height="300"></canvas>
			</div>

			<div class="wpforms-dash-widget-block-upgrade">
				<div class="wpforms-dash-widget-modal">
					<h2><?php \esc_html_e( 'View all Form Entries inside WordPress Dashboard', 'wpforms-lite' ); ?></h2>
					<p><?php \esc_html_e( 'Form entries reports are not available.', 'wpforms-lite' ); ?></p>
					<p><?php \esc_html_e( 'Form entries are not stored in Lite.', 'wpforms-lite' ); ?></p>
					<p><?php \esc_html_e( 'Upgrade to Pro and get access to the reports.', 'wpforms-lite' ); ?></p>
					<p>
						<a href="<?php echo \esc_url( wpforms_admin_upgrade_link( 'dashboard-widget' ) ); ?>" class="wpforms-dash-widget-upgrade-btn" target="_blank" rel="noopener noreferrer">
							<?php \esc_html_e( 'Upgrade to WPForms Pro', 'wpforms-lite' ); ?>
						</a>
					</p>
					<!--
					<p>
						<a href="https://wpforms.com" class="wpforms-dash-widget-site-link">
							<?php \esc_html_e( 'Go to WPForms.com', 'wpforms-lite' ); ?>
						</a>
					</p>
					-->
				</div>
			</div>

		</div>

		<div class="wpforms-dash-widget-block">
			<h3><?php \esc_html_e( 'Total Entries by Form', 'wpforms-lite' ); ?></h3>
		</div>

		<div id="wpforms-dash-widget-forms-list-block" class="wpforms-dash-widget-block wpforms-dash-widget-forms-list-block">
			<?php $this->forms_list_block(); ?>
		</div>

		<?php
	}

	/**
	 * Forms list block.
	 *
	 * @since 1.5.0
	 */
	public function forms_list_block() {

		$forms = $this->get_entries_count_by_form();

		if ( empty( $forms ) ) {
			$this->forms_list_block_empty_html();
		} else {
			$this->forms_list_block_html( $forms );
		}
	}

	/**
	 * Empty forms list block HTML.
	 *
	 * @since 1.5.0
	 */
	public function forms_list_block_empty_html() {

		?>
		<p class="wpforms-error wpforms-error-no-data-forms-list">
			<?php \esc_html_e( 'No entries were submitted yet.', 'wpforms-lite' ); ?>
		</p>
		<?php
	}

	/**
	 * Forms list block HTML.
	 *
	 * @since 1.5.0
	 *
	 * @param array $forms Forms to display in the list.
	 */
	public function forms_list_block_html( $forms ) {

		// Number of forms to display in the forms list before "Show More" button appears.
		$show_forms = $this->settings['forms_list_number_to_display'];

		?>
		<table id="wpforms-dash-widget-forms-list-table" cellspacing="0">
			<?php foreach ( \array_values( $forms ) as $key => $form ) : ?>
				<tr <?php echo $key >= $show_forms ? 'class="wpforms-dash-widget-forms-list-hidden-el"' : ''; ?> data-form-id="<?php echo \absint( $form['form_id'] ); ?>">
					<td><span class="wpforms-dash-widget-form-title"><?php echo \esc_html( $form['title'] ); ?></span></td>
					<td><?php echo \absint( $form['count'] ); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<?php if ( \count( $forms ) > $show_forms ) : ?>
			<button type="button" id="wpforms-dash-widget-forms-more" class="wpforms-dash-widget-forms-more" title="<?php \esc_html_e( 'Show all forms', 'wpforms-lite' ); ?>">
				<?php \esc_html_e( 'Show More', 'wpforms-lite' ); ?> <span class="dashicons dashicons-arrow-down"></span>
			</button>
		<?php endif; ?>

		<?php
	}


	/**
	 * Recommended plugin block HTML.
	 *
	 * @since 1.5.0
	 */
	public function recommended_plugin_block_html() {

		$install_mi_url = \wp_nonce_url(
			\self_admin_url( 'update.php?action=install-plugin&plugin=google-analytics-for-wordpress' ),
			'install-plugin_google-analytics-for-wordpress'
		);

		?>
		<div class="wpforms-dash-widget-recommended-plugin-block">
			<p><?php \esc_html_e( 'Recommended Plugin:', 'wpforms-lite' ); ?>
				<b><?php \esc_html_e( 'MonsterInsights', 'wpforms-lite' ); ?></b> -
				<?php if ( wpforms_can_install( 'plugin' ) ) { ?>
					<a href="<?php echo \esc_url( $install_mi_url ); ?>"><?php \esc_html_e( 'Install', 'wpforms-lite' ); ?></a> &vert;
				<?php } ?>
				<a href="https://www.monsterinsights.com/?utm_source=wpformsplugin&utm_medium=link&utm_campaign=wpformsdashboardwidget"><?php \esc_html_e( 'Learn More', 'wpforms-lite' ); ?></a></p>
		</div>
		<?php
	}

	/**
	 * Get entries count grouped by form.
	 * Main point of entry to fetch form entry count data from DB.
	 * Cache the result.
	 *
	 * @since 1.5.0
	 *
	 * @return array
	 */
	public function get_entries_count_by_form() {

		// Allow results caching to reduce DB load.
		$allow_caching = $this->settings['allow_data_caching'];

		if ( $allow_caching ) {
			$transient_name = 'wpforms_dash_widget_lite_entries_by_form';
			$cache          = \get_transient( $transient_name );
			// Filter the cache to clear or alter its data.
			$cache = \apply_filters( 'wpforms_dash_widget_lite_cached_data', $cache );
		}

		// is_array() detects cached empty searches.
		if ( $allow_caching && \is_array( $cache ) ) {
			return $cache;
		}

		$forms = \wpforms()->form->get( '', array( 'fields' => 'ids' ) );

		if ( empty( $forms ) || ! \is_array( $forms ) ) {
			return array();
		}

		$result = array();

		foreach ( $forms as $form_id ) {
			$count = \absint( \get_post_meta( $form_id, 'wpforms_entries_count', true ) );
			if ( empty( $count ) && empty( $this->settings['display_forms_list_empty_entries'] ) ) {
				continue;
			}
			$result[ $form_id ] = array(
				'form_id' => $form_id,
				'count'   => $count,
				'title'   => \get_the_title( $form_id ),
			);
		}

		if ( ! empty( $result ) ) {
			// Sort forms by entries count (desc).
			\uasort( $result, function ( $a, $b ) {
				return ( $a['count'] > $b['count'] ) ? - 1 : 1;
			} );
		}

		if ( $allow_caching ) {
			// Transient lifetime in seconds. Defaults to the end of a current day.
			$transient_lifetime = $this->settings['transient_lifetime'];
			\set_transient( $transient_name, $result, $transient_lifetime );
		}

		return $result;
	}

	/**
	 * Hide dashboard widget.
	 * Use dashboard screen options to make it visible again.
	 *
	 * @since 1.5.0
	 */
	public function hide_widget() {

		if ( ! \is_admin() || ! \is_user_logged_in() ) {
			return;
		}

		if ( ! isset( $_GET['wpforms-nonce'] ) || ! \wp_verify_nonce( \sanitize_key( \wp_unslash( $_GET['wpforms-nonce'] ) ), 'wpforms_hide_dash_widget' ) ) {
			return;
		}

		if ( ! isset( $_GET['wpforms-widget'] ) || 'hide' !== $_GET['wpforms-widget'] ) {
			return;
		}

		$user_id       = \get_current_user_id();
		$metaboxhidden = \get_user_meta( $user_id, 'metaboxhidden_dashboard', true );

		if ( ! \is_array( $metaboxhidden ) ) {
			\update_user_meta( $user_id, 'metaboxhidden_dashboard', array( 'wpforms_reports_widget_lite' ) );
		}

		if ( \is_array( $metaboxhidden ) && ! \in_array( 'wpforms_reports_widget_lite', $metaboxhidden, true ) ) {
			$metaboxhidden[] = 'wpforms_reports_widget_lite';
			\update_user_meta( $user_id, 'metaboxhidden_dashboard', $metaboxhidden );
		}

		$redirect_url = \remove_query_arg( array( 'wpforms-widget', 'wpforms-nonce' ) );

		\wp_safe_redirect( $redirect_url );
		exit();
	}

	/**
	 * Clear dashboard widget cached data.
	 *
	 * @since 1.5.2
	 */
	public static function clear_widget_cache() {

		delete_transient( 'wpforms_dash_widget_lite_entries_by_form' );
	}
}
