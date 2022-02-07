<?php

namespace WPForms\Integrations\WPMailSMTP;

use WPMailSMTP\Options;
use WPForms\Integrations\IntegrationInterface;

/**
 * WP Mail SMTP hints inside form builder notifications.
 *
 * @since 1.4.8
 */
class Notifications implements IntegrationInterface {

	/**
	 * WP Mail SMTP options.
	 *
	 * @since 1.4.8
	 *
	 * @var Options
	 */
	public $options;

	/**
	 * Indicate if current integration is allowed to load.
	 *
	 * @since 1.4.8
	 *
	 * @return bool
	 */
	public function allow_load() {

		return wpforms_is_admin_page( 'builder' ) && function_exists( 'wp_mail_smtp' );
	}

	/**
	 * Load an integration.
	 *
	 * @since 1.4.8
	 */
	public function load() {

		$this->options = new Options();

		$this->hooks();
	}

	/**
	 * Integration filters.
	 *
	 * @since 1.4.8
	 */
	protected function hooks() {

		add_filter( 'wpforms_builder_notifications_from_name_after', [ $this, 'from_name_after' ] );
		add_filter( 'wpforms_builder_notifications_from_email_after', [ $this, 'from_email_after' ] );
	}

	/**
	 * Display hint if WP Mail SMTP is forcing from name.
	 *
	 * @since 1.4.8
	 *
	 * @param string $after Text displayed after setting.
	 *
	 * @return string
	 */
	public function from_name_after( $after ) {

		if ( ! $this->options->get( 'mail', 'from_name_force' ) ) {
			return $after;
		}

		return sprintf(
			wp_kses( /* translators: %s - URL WP Mail SMTP settings. */
				__( 'This setting is disabled because you have the "Force From Name" setting enabled in the <a href="%s" target="_blank">WP Mail SMTP</a> plugin.', 'wpforms-lite' ),
				[
					'a' => [
						'href'   => [],
						'target' => [],
					],
				]
			),
			esc_url( admin_url( 'options-general.php?page=wp-mail-smtp#wp-mail-smtp-setting-row-from_name' ) )
		);
	}

	/**
	 * Display hint if WP Mail SMTP is forcing from email.
	 *
	 * @since 1.4.8
	 *
	 * @param string $after Text displayed after setting.
	 *
	 * @return string
	 */
	public function from_email_after( $after ) {

		if ( ! $this->options->get( 'mail', 'from_email_force' ) ) {
			return $after;
		}

		return sprintf(
			wp_kses( /* translators: %s - URL WP Mail SMTP settings. */
				__( 'This setting is disabled because you have the "Force From Email" setting enabled in the <a href="%s" target="_blank">WP Mail SMTP</a> plugin.', 'wpforms-lite' ),
				[
					'a' => [
						'href'   => [],
						'target' => [],
					],
				]
			),
			esc_url( admin_url( 'options-general.php?page=wp-mail-smtp#wp-mail-smtp-setting-row-from_email' ) )
		);
	}
}
