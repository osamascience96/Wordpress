<?php

namespace WPForms\Admin;

/**
 * Notifications.
 *
 * @since 1.6.0
 */
class Notifications {

	/**
	 * Source of notifications content.
	 *
	 * @since 1.6.0
	 *
	 * @var string
	 */
	const SOURCE_URL = 'https://plugin.wpforms.com/wp-content/notifications.json';

	/**
	 * Option value.
	 *
	 * @since 1.6.0
	 *
	 * @var bool|array
	 */
	public $option = false;

	/**
	 * Initialize class.
	 *
	 * @since 1.6.0
	 */
	public function init() {

		$this->hooks();
	}

	/**
	 * Register hooks.
	 *
	 * @since 1.6.0
	 */
	public function hooks() {

		add_action( 'wpforms_overview_enqueue', [ $this, 'enqueues' ] );

		add_action( 'wpforms_admin_overview_before_table', [ $this, 'output' ] );

		add_action( 'wpforms_admin_notifications_update', [ $this, 'update' ] );

		add_action( 'wp_ajax_wpforms_notification_dismiss', [ $this, 'dismiss' ] );
	}

	/**
	 * Check if user has access and is enabled.
	 *
	 * @since 1.6.0
	 *
	 * @return bool
	 */
	public function has_access() {

		$access = false;

		if (
			wpforms_current_user_can( 'view_forms' ) &&
			! wpforms_setting( 'hide-announcements', false )
		) {
			$access = true;
		}

		return apply_filters( 'wpforms_admin_notifications_has_access', $access );
	}

	/**
	 * Get option value.
	 *
	 * @since 1.6.0
	 *
	 * @param bool $cache Reference property cache if available.
	 *
	 * @return array
	 */
	public function get_option( $cache = true ) {

		if ( $this->option && $cache ) {
			return $this->option;
		}

		$option = get_option( 'wpforms_notifications', [] );

		$this->option = [
			'update'    => ! empty( $option['update'] ) ? $option['update'] : 0,
			'events'    => ! empty( $option['events'] ) ? $option['events'] : [],
			'feed'      => ! empty( $option['feed'] ) ? $option['feed'] : [],
			'dismissed' => ! empty( $option['dismissed'] ) ? $option['dismissed'] : [],
		];

		return $this->option;
	}

	/**
	 * Fetch notifications from feed.
	 *
	 * @since 1.6.0
	 *
	 * @return array
	 */
	public function fetch_feed() {

		$res = wp_remote_get( self::SOURCE_URL );

		if ( is_wp_error( $res ) ) {
			return [];
		}

		$body = wp_remote_retrieve_body( $res );

		if ( empty( $body ) ) {
			return [];
		}

		return $this->verify( json_decode( $body, true ) );
	}

	/**
	 * Verify notification data before it is saved.
	 *
	 * @since 1.6.0
	 *
	 * @param array $notifications Array of notifications items to verify.
	 *
	 * @return array
	 */
	public function verify( $notifications ) { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh

		$data = [];

		if ( ! is_array( $notifications ) || empty( $notifications ) ) {
			return $data;
		}

		$option = $this->get_option();

		foreach ( $notifications as $notification ) {

			// The message and license should never be empty, if they are, ignore.
			if ( empty( $notification['content'] ) || empty( $notification['type'] ) ) {
				continue;
			}

			// Ignore if license type does not match.
			$license = wpforms_get_license_type() ? wpforms_get_license_type() : 'lite';

			if ( ! in_array( $license, $notification['type'], true ) ) {
				continue;
			}

			// Ignore if expired.
			if ( ! empty( $notification['end'] ) && time() > strtotime( $notification['end'] ) ) {
				continue;
			}

			// Ignore if notifcation has already been dismissed.
			if ( ! empty( $option['dismissed'] ) && in_array( $notification['id'], $option['dismissed'] ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
				continue;
			}

			// Ignore if notification existed before installing WPForms.
			// Prevents bombarding the user with notifications after activation.
			$activated = wpforms_get_activated_timestamp();

			if (
				! empty( $activated ) &&
				! empty( $notification['start'] ) &&
				$activated > strtotime( $notification['start'] )
			) {
				continue;
			}

			$data[] = $notification;
		}

		return $data;
	}

	/**
	 * Verify saved notification data for active notifications.
	 *
	 * @since 1.6.0
	 *
	 * @param array $notifications Array of notifications items to verify.
	 *
	 * @return array
	 */
	public function verify_active( $notifications ) {

		if ( ! is_array( $notifications ) || empty( $notifications ) ) {
			return [];
		}

		// Remove notfications that are not active.
		foreach ( $notifications as $key => $notification ) {
			if (
				( ! empty( $notification['start'] ) && time() < strtotime( $notification['start'] ) ) ||
				( ! empty( $notification['end'] ) && time() > strtotime( $notification['end'] ) )
			) {
				unset( $notifications[ $key ] );
			}
		}

		return $notifications;
	}

	/**
	 * Get notification data.
	 *
	 * @since 1.6.0
	 *
	 * @return array
	 */
	public function get() {

		if ( ! $this->has_access() ) {
			return [];
		}

		$option = $this->get_option();

		// Update notifications using async task.
		if ( empty( $option['update'] ) || time() > $option['update'] + DAY_IN_SECONDS ) {

			if ( empty( wpforms()->get( 'tasks' )->is_scheduled( 'wpforms_admin_notifications_update' ) ) ) {

				wpforms()->get( 'tasks' )
					->create( 'wpforms_admin_notifications_update' )
					->async()
					->params()
					->register();
			}
		}

		$events = ! empty( $option['events'] ) ? $this->verify_active( $option['events'] ) : [];
		$feed   = ! empty( $option['feed'] ) ? $this->verify_active( $option['feed'] ) : [];

		return array_merge( $events, $feed );
	}

	/**
	 * Get notification count.
	 *
	 * @since 1.6.0
	 *
	 * @return int
	 */
	public function get_count() {

		return count( $this->get() );
	}

	/**
	 * Add a manual notification event.
	 *
	 * @since 1.6.0
	 *
	 * @param array $notification Notification data.
	 */
	public function add( $notification ) {

		if ( empty( $notification['id'] ) ) {
			return;
		}

		$option = $this->get_option();

		if ( in_array( $notification['id'], $option['dismissed'] ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
			return;
		}

		foreach ( $option['events'] as $item ) {
			if ( $item['id'] === $notification['id'] ) {
				return;
			}
		}

		$notification = $this->verify( [ $notification ] );

		update_option(
			'wpforms_notifications',
			[
				'update'    => $option['update'],
				'feed'      => $option['feed'],
				'events'    => array_merge( $notification, $option['events'] ),
				'dismissed' => $option['dismissed'],
			]
		);
	}

	/**
	 * Update notification data from feed.
	 *
	 * @since 1.6.0
	 */
	public function update() {

		$feed   = $this->fetch_feed();
		$option = $this->get_option();

		update_option(
			'wpforms_notifications',
			[
				'update'    => time(),
				'feed'      => $feed,
				'events'    => $option['events'],
				'dismissed' => $option['dismissed'],
			]
		);
	}

	/**
	 * Admin area Form Overview enqueues.
	 *
	 * @since 1.6.0
	 */
	public function enqueues() {

		if ( ! $this->has_access() ) {
			return;
		}

		$notifications = $this->get();

		if ( empty( $notifications ) ) {
			return;
		}

		$min = wpforms_get_min_suffix();

		wp_enqueue_style(
			'wpforms-admin-notifications',
			WPFORMS_PLUGIN_URL . "assets/css/admin-notifications{$min}.css",
			[],
			WPFORMS_VERSION
		);

		wp_enqueue_script(
			'wpforms-admin-notifications',
			WPFORMS_PLUGIN_URL . "assets/js/admin-notifications{$min}.js",
			[ 'jquery' ],
			WPFORMS_VERSION,
			true
		);
	}

	/**
	 * Output notifications on Form Overview admin area.
	 *
	 * @since 1.6.0
	 */
	public function output() {

		$notifications = $this->get();

		if ( empty( $notifications ) ) {
			return;
		}

		$notifications_html   = '';
		$current_class        = ' current';
		$content_allowed_tags = [
			'em'     => [],
			'strong' => [],
			'span'   => [
				'style' => [],
			],
			'a'      => [
				'href'   => [],
				'target' => [],
				'rel'    => [],
			],
		];

		foreach ( $notifications as $notification ) {

			// Buttons HTML.
			$buttons_html = '';
			if ( ! empty( $notification['btns'] ) && is_array( $notification['btns'] ) ) {
				foreach ( $notification['btns'] as $btn_type => $btn ) {
					$buttons_html .= sprintf(
						'<a href="%1$s" class="button button-%2$s"%3$s>%4$s</a>',
						! empty( $btn['url'] ) ? esc_url( $btn['url'] ) : '',
						$btn_type === 'main' ? 'primary' : 'secondary',
						! empty( $btn['target'] ) && $btn['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '',
						! empty( $btn['text'] ) ? sanitize_text_field( $btn['text'] ) : ''
					);
				}
				$buttons_html = ! empty( $buttons_html ) ? '<div class="wpforms-notifications-buttons">' . $buttons_html . '</div>' : '';
			}

			// Notification HTML.
			$notifications_html .= sprintf(
				'<div class="wpforms-notifications-message%5$s" data-message-id="%4$s">
					<h3 class="wpforms-notifications-title">%1$s</h3>
					<p class="wpforms-notifications-content">%2$s</p>
					%3$s
				</div>',
				! empty( $notification['title'] ) ? sanitize_text_field( $notification['title'] ) : '',
				! empty( $notification['content'] ) ? wp_kses( $notification['content'], $content_allowed_tags ) : '',
				$buttons_html,
				! empty( $notification['id'] ) ? esc_attr( sanitize_text_field( $notification['id'] ) ) : 0,
				$current_class
			);

			// Only first notification is current.
			$current_class = '';
		}
		?>

		<div id="wpforms-notifications">

			<div class="wpforms-notifications-header">
				<div class="wpforms-notifications-bell">
					<svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.8173 8.92686C12.4476 9.01261 12.0624 9.05794 11.6666 9.05794C8.86542 9.05794 6.59455 6.78729 6.59419 3.98616C4.22974 4.54931 2.51043 6.64293 2.51043 9.23824C2.51043 12.4695 1.48985 13.6147 0.849845 14.3328C0.796894 14.3922 0.746548 14.4487 0.699601 14.5032C0.505584 14.707 0.408575 14.9787 0.440912 15.2165C0.440912 15.7939 0.828946 16.3034 1.47567 16.3034H13.8604C14.5071 16.3034 14.8952 15.7939 14.9275 15.2165C14.9275 14.9787 14.8305 14.707 14.6365 14.5032C14.5895 14.4487 14.5392 14.3922 14.4862 14.3328C13.8462 13.6147 12.8257 12.4695 12.8257 9.23824C12.8257 9.13361 12.8229 9.02979 12.8173 8.92686ZM9.72139 17.3904C9.72139 18.6132 8.81598 19.5643 7.68421 19.5643C6.52011 19.5643 5.6147 18.6132 5.6147 17.3904H9.72139Z" fill="#777777"/><path d="M11.6666 7.60868C13.6677 7.60868 15.2898 5.98653 15.2898 3.9855C15.2898 1.98447 13.6677 0.36232 11.6666 0.36232C9.66561 0.36232 8.04346 1.98447 8.04346 3.9855C8.04346 5.98653 9.66561 7.60868 11.6666 7.60868Z" fill="#CA4A1F"/></svg>
				</div>
				<div class="wpforms-notifications-title"><?php esc_html_e( 'Notifications', 'wpforms-lite' ); ?></div>
			</div>

			<div class="wpforms-notifications-body">
				<a class="dismiss" title="<?php echo esc_attr__( 'Dismiss this message', 'wpforms-lite' ); ?>"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

				<?php if ( count( $notifications ) > 1 ) : ?>
					<div class="navigation">
						<a class="prev">
							<span class="screen-reader-text"><?php esc_attr_e( 'Previous message', 'wpforms-lite' ); ?></span>
							<span aria-hidden="true">‹</span>
						</a>
						<a class="next">
							<span class="screen-reader-text"><?php esc_attr_e( 'Next message', 'wpforms-lite' ); ?>"></span>
							<span aria-hidden="true">›</span>
						</a>
					</div>
				<?php endif; ?>

				<div class="wpforms-notifications-messages">
					<?php echo $notifications_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Dismiss notification via AJAX.
	 *
	 * @since 1.6.0
	 */
	public function dismiss() {

		// Run a security check.
		check_ajax_referer( 'wpforms-admin', 'nonce' );

		// Check for access and required param.
		if ( ! $this->has_access() || empty( $_POST['id'] ) ) {
			wp_send_json_error();
		}

		$id     = sanitize_text_field( wp_unslash( $_POST['id'] ) );
		$option = $this->get_option();
		$type   = is_numeric( $id ) ? 'feed' : 'events';

		$option['dismissed'][] = $id;
		$option['dismissed']   = array_unique( $option['dismissed'] );

		// Remove notification.
		if ( is_array( $option[ $type ] ) && ! empty( $option[ $type ] ) ) {
			foreach ( $option[ $type ] as $key => $notification ) {
				if ( (string) $notification['id'] === (string) $id ) {
					unset( $option[ $type ][ $key ] );
					break;
				}
			}
		}

		update_option( 'wpforms_notifications', $option );

		wp_send_json_success();
	}
}
