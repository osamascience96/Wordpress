<?php

/**
 * Settings management panel.
 *
 * @since 1.0.0
 */
class WPForms_Builder_Panel_Settings extends WPForms_Builder_Panel {

	/**
	 * All systems go.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Define panel information.
		$this->name    = esc_html__( 'Settings', 'wpforms-lite' );
		$this->slug    = 'settings';
		$this->icon    = 'fa-sliders';
		$this->order   = 10;
		$this->sidebar = true;
	}

	/**
	 * Output the Settings panel sidebar.
	 *
	 * @since 1.0.0
	 */
	public function panel_sidebar() {

		// Sidebar contents are not valid unless we have a form.
		if ( ! $this->form ) {
			return;
		}

		$sections = [
			'general'       => esc_html__( 'General', 'wpforms-lite' ),
			'notifications' => esc_html__( 'Notifications', 'wpforms-lite' ),
			'confirmation'  => esc_html__( 'Confirmations', 'wpforms-lite' ),
		];
		$sections = apply_filters( 'wpforms_builder_settings_sections', $sections, $this->form_data );

		foreach ( $sections as $slug => $section ) {
			$this->panel_sidebar_section( $section, $slug );
		}
	}

	/**
	 * Output the Settings panel primary content.
	 *
	 * @since 1.0.0
	 */
	public function panel_content() {

		// Check if there is a form created.
		if ( ! $this->form ) {
			echo '<div class="wpforms-alert wpforms-alert-info">';
			echo wp_kses(
				__( 'You need to <a href="#" class="wpforms-panel-switch" data-panel="setup">setup your form</a> before you can manage the settings.', 'wpforms-lite' ),
				[
					'a' => [
						'href'       => [],
						'class'      => [],
						'data-panel' => [],
					],
				]
			);
			echo '</div>';

			return;
		}

		/*
		 * General.
		 */
		echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-general">';
			echo '<div class="wpforms-panel-content-section-title">';
				esc_html_e( 'General', 'wpforms-lite' );
			echo '</div>';

			wpforms_panel_field(
				'text',
				'settings',
				'form_title',
				$this->form_data,
				esc_html__( 'Form Name', 'wpforms-lite' ),
				[
					'default' => $this->form->post_title,
				]
			);
			wpforms_panel_field(
				'textarea',
				'settings',
				'form_desc',
				$this->form_data,
				esc_html__( 'Form Description', 'wpforms-lite' )
			);
			wpforms_panel_field(
				'text',
				'settings',
				'submit_text',
				$this->form_data,
				esc_html__( 'Submit Button Text', 'wpforms-lite' ),
				[
					'default' => esc_html__( 'Submit', 'wpforms-lite' ),
				]
			);
			wpforms_panel_field(
				'text',
				'settings',
				'submit_text_processing',
				$this->form_data,
				esc_html__( 'Submit Button Processing Text', 'wpforms-lite' ),
				[
					'tooltip' => esc_html__( 'Enter the submit button text you would like the button display while the form submit is processing.', 'wpforms-lite' ),
				]
			);

			if ( ! empty( $this->form_data['settings']['honeypot'] ) ) {
				wpforms_panel_field(
					'toggle',
					'settings',
					'honeypot',
					$this->form_data,
					esc_html__( 'Enable anti-spam honeypot', 'wpforms-lite' )
				);
			}

			wpforms_panel_field(
				'toggle',
				'settings',
				'antispam',
				$this->form_data,
				esc_html__( 'Enable anti-spam protection', 'wpforms-lite' )
			);

			$this->general_setting_captcha();

			$this->general_setting_advanced();

		echo '</div>';

		/*
		 * Notifications.
		 */
		echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-notifications" data-panel="notifications">';

			do_action( 'wpforms_form_settings_notifications', $this );

		echo '</div>';

		/*
		 * Confirmations.
		 */
		echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-confirmation" data-panel="confirmations">';

			do_action( 'wpforms_form_settings_confirmations', $this );

		echo '</div>';

		/*
		 * Custom panels can be added below.
		 */
		do_action( 'wpforms_form_settings_panel_content', $this );
	}

	/**
	 * Output the *CAPTCHA settings.
	 *
	 * @since 1.6.8
	 */
	private function general_setting_captcha() {

		$captcha_settings = wpforms_get_captcha_settings();

		if (
			! empty( $captcha_settings['provider'] ) &&
			$captcha_settings['provider'] !== 'none' &&
			! empty( $captcha_settings['site_key'] ) &&
			! empty( $captcha_settings['secret_key'] )
		) {
			$lbl = '';

			switch ( $captcha_settings['recaptcha_type'] ) {
				case 'v2':
					$lbl = esc_html__( 'Enable Google Checkbox v2 reCAPTCHA', 'wpforms-lite' );

					break;

				case 'invisible':
					$lbl = esc_html__( 'Enable Google Invisible v2 reCAPTCHA', 'wpforms-lite' );

					break;

				case 'v3':
					$lbl = esc_html__( 'Enable Google v3 reCAPTCHA', 'wpforms-lite' );

					break;
			}

			$lbl = $captcha_settings['provider'] === 'hcaptcha' ? esc_html__( 'Enable hCaptcha', 'wpforms-lite' ) : $lbl;

			wpforms_panel_field(
				'toggle',
				'settings',
				'recaptcha',
				$this->form_data,
				$lbl,
				[
					'data' => [
						'provider' => $captcha_settings['provider'],
					],
				]
			);
		}
	}

	/**
	 * Output the *CAPTCHA settings.
	 *
	 * @since 1.6.8
	 */
	private function general_setting_advanced() {

		ob_start();

		wpforms_panel_field(
			'text',
			'settings',
			'form_class',
			$this->form_data,
			esc_html__( 'Form CSS Class', 'wpforms-lite' ),
			[
				'tooltip' => esc_html__( 'Enter CSS class names for the form wrapper. Multiple class names should be separated with spaces.', 'wpforms-lite' ),
			]
		);

		wpforms_panel_field(
			'text',
			'settings',
			'submit_class',
			$this->form_data,
			esc_html__( 'Submit Button CSS Class', 'wpforms-lite' ),
			[
				'tooltip' => esc_html__( 'Enter CSS class names for the form submit button. Multiple names should be separated with spaces.', 'wpforms-lite' ),
			]
		);

		wpforms_panel_field(
			'toggle',
			'settings',
			'dynamic_population',
			$this->form_data,
			esc_html__( 'Enable dynamic fields population', 'wpforms-lite' ),
			[
				'tooltip' => '<a href="https://wpforms.com/developers/how-to-enable-dynamic-field-population/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'How to use Dynamic Field Population', 'wpforms-lite' ) . '</a>',
			]
		);

		wpforms_panel_field(
			'toggle',
			'settings',
			'ajax_submit',
			$this->form_data,
			esc_html__( 'Enable AJAX form submission', 'wpforms-lite' ),
			[
				'tooltip' => esc_html__( 'Enables form submission without page reload.', 'wpforms-lite' ),
			]
		);

		do_action( 'wpforms_form_settings_general', $this );

		// Wrap advanced settings to the unfoldable group.
		wpforms_panel_fields_group(
			ob_get_clean(),
			[
				'unfoldable' => true,
				'group'      => 'settings_advanced',
				'title'      => esc_html__( 'Advanced', 'wpforms-lite' ),
			],
			true
		);
	}
}

new WPForms_Builder_Panel_Settings();
