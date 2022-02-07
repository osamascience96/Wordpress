<?php

namespace WPForms\Admin\Tools\Views;

/**
 * Class ActionScheduler view.
 *
 * @since 1.6.6
 */
class ActionScheduler extends View {

	/**
	 * View slug.
	 *
	 * @since 1.6.6
	 *
	 * @var string
	 */
	protected $slug = 'action-scheduler';

	/**
	 * Init view.
	 *
	 * @since 1.6.6
	 */
	public function init() {

		if ( $this->admin_view_exists() ) {
			\ActionScheduler_AdminView::instance()->process_admin_ui();
		}
	}

	/**
	 * Get link to the view.
	 *
	 * @since 1.6.9
	 *
	 * @return string
	 */
	public function get_link() {

		return add_query_arg(
			[
				's' => 'wpforms',
			],
			parent::get_link()
		);
	}

	/**
	 * Get view label.
	 *
	 * @since 1.6.6
	 *
	 * @return string
	 */
	public function get_label() {

		return esc_html__( 'Scheduled Actions', 'wpforms-lite' );
	}

	/**
	 * Checking user capability to view.
	 *
	 * @since 1.6.6
	 *
	 * @return bool
	 */
	public function check_capability() {

		return wpforms_current_user_can();
	}

	/**
	 * Display view content.
	 *
	 * @since 1.6.6
	 */
	public function display() {

		if ( ! $this->admin_view_exists() ) {
			return;
		}
		?>
		<h1><?php echo esc_html__( 'Scheduled Actions', 'wpforms-lite' ); ?></h1>

		<p>
			<?php
			echo sprintf(
				wp_kses( /* translators: %s - Action Scheduler website URL. */
					__( 'WPForms is using the <a href="%s" target="_blank" rel="noopener noreferrer">Action Scheduler</a> library, which allows it to queue and process bigger tasks in the background without making your site slower for your visitors. Below you can see the list of all tasks and their status. This table can be very useful when debugging certain issues.', 'wpforms-lite' ),
					[
						'a' => [
							'href'   => [],
							'rel'    => [],
							'target' => [],
						],
					]
				),
				'https://actionscheduler.org/'
			);
			?>
		</p>

		<p>
			<?php echo esc_html__( 'Action Scheduler library is also used by other plugins, like WP Mail SMTP and WooCommerce, so you might see tasks that are not related to our plugin in the table below.', 'wpforms-lite' ); ?>
		</p>

		<?php if ( ! empty( $_GET['s'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div id="wpforms-reset-filter">
				<?php
				echo wp_kses(
					sprintf( /* translators: %s - search term. */
						__( 'Search results for <strong>%s</strong>', 'wpforms-lite' ),
						sanitize_text_field( wp_unslash( $_GET['s'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					),
					[
						'strong' => [],
					]
				);
				?>
				<a href="<?php echo esc_url( remove_query_arg( 's' ) ); ?>">
					<i class="reset fa fa-times-circle"></i>
				</a>
			</div>
		<?php endif; ?>

		<?php

		\ActionScheduler_AdminView::instance()->render_admin_ui();
	}

	/**
	 * Check if ActionScheduler_AdminView class exists.
	 *
	 * @since 1.6.6
	 *
	 * @return bool
	 */
	private function admin_view_exists() {

		return class_exists( 'ActionScheduler_AdminView' );
	}

}
