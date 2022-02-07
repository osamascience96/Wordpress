<?php

/**
 * The abstract class for creating admin notices.
 */
abstract class LAE_Notice {

	/**
	 * The ID of the notice.
	 */
	protected $notice_id;

	/**
	 * The full path to the notice template file.
	 */
	protected $template_file;

	/**
	 * The delay before displaying the notice at the first time (in seconds).
	 */
	protected $first_time_delay;

	/**
	 * The delay for deferring the notice (in seconds).
	 */
	protected $defer_delay;

	/**
	 * The required user capability to view the notice.
	 */
	protected $capability;

	/**
	 * The name of the option to store dismissed notices.
	 */
	private $option_name;

	/**
	 * Initialize the class and set its properties.
	 */
	protected function __construct( $notice_id, $template_file ) {

		$this->notice_id        = $notice_id;
		$this->template_file    = $template_file;
		$this->first_time_delay = 0;
		$this->defer_delay      = 1 * DAY_IN_SECONDS;
		$this->capability       = 'manage_options';
		$this->option_name      = 'lae_option_dismissed_notices';

	}

	/**
	 * This method should be implemented by childs.
	 */
	abstract function display_notice();

	/**
	 * Include template file.
	 */
	protected function include_template( $data = null ) {

		if ( file_exists( $this->template_file ) ) {
			include $this->template_file;
		}

	}

	/**
	 * Set new status for the notice.
	 */
	protected function update_notice_status( $status ) {

		$dismissed = $this->get_dismissed_notices();
		$id        = $this->notice_id;

		if ( $status === 'dismissed' ) {
			$dismissed[$id] = true;
		}

		elseif ( $status === 'deferred' ) {
			$dismissed[$id] = time() + (int) $this->defer_delay;
		}

		elseif ( is_numeric( $status ) ) {
			$dismissed[$id] = time() + (int) $status;
		}

		update_option( $this->option_name, $dismissed );

	}

	/**
	 * Dismiss the notice.
	 */
	public function dismiss_notice() {

		if ( ! $this->current_user_can_view() ) {
			return;
		}

		if ( ! isset( $_GET['nonce'], $_GET['id'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_GET['nonce'], 'lae_dismiss_notice' ) ) {
			return;
		}

		if ( $_GET['id'] !== $this->notice_id ) {
			return;
		}

		$status = empty( $_GET['defer'] ) ? 'dismissed' : 'deferred';

		$this->update_notice_status( $status );

		if ( isset( $_GET['redirect_to'] ) ) {
			wp_safe_redirect( $_GET['redirect_to'] );
			exit;
		}

		if ( ! wp_get_referer() ) {
			return;
		}

		wp_safe_redirect( wp_get_referer() );
		exit;

	}

	/**
	 * Retrieve the link to dismiss the notice
	 */
	protected function get_dismiss_link( $defer = false, $redirect = '' ) {

		$link = admin_url( sprintf(
				'admin-post.php?action=%s&nonce=%s&id=%s',
				'lae_dismiss_notice',
				wp_create_nonce( 'lae_dismiss_notice' ),
				$this->notice_id
			) );

		if ( $defer ) {
			$link = add_query_arg( 'defer', 1, $link );
		}

		if ( $redirect ) {
			$link = add_query_arg( 'redirect_to', esc_url( $redirect ), $link );
		}

		return $link;

	}

	/**
	 * This conditional tag checks if the notice has been dismissed.
	 */
	protected function is_dismissed() {

		$dismissed = $this->get_dismissed_notices();
		$id        = $this->notice_id;

		// No data about the notice (not dismissed/deferred)
		if ( ! isset( $dismissed[$id] ) ) {
			return false;
		}

		// Notice deferred
		if ( is_numeric( $dismissed[$id] ) && time() < $dismissed[$id] ) {
			return true;
		}

		// Notice dismissed
		if ( $dismissed[$id] === true ) {
			return true;
		}

		// Default behavior
		return false;

	}

	/**
	 * Defer the notice at the first time it should be displayed.
	 */
	public function defer_first_time() {

		$dismissed = $this->get_dismissed_notices();
		$id        = $this->notice_id;

		if ( ! isset( $dismissed[$id] ) ) {
			$this->update_notice_status( $this->first_time_delay );
		}

	}

	/**
	 * Helper function to retrieve dismissed notices.
	 */
	protected function get_dismissed_notices() {
		return get_option( $this->option_name, array() );
	}

	/**
	 * Helper function to retrieve the ID of the current screen.
	 */
	protected function get_current_screen_id() {

		$screen = get_current_screen();
		return $screen->id;

	}

	/**
	 * Check if current user can view the notice.
	 */
	protected function current_user_can_view() {
		return current_user_can( $this->capability );
	}

}
