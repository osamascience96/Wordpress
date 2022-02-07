<?php
/**
 * Load the field types.
 *
 * @since 1.0.0
 */
class WPForms_Fields {

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Load and init the base field class.
	 *
	 * @since 1.2.8
	 */
	public function init() {

		// Parent class template.
		require_once WPFORMS_PLUGIN_DIR . 'includes/fields/class-base.php';

		// Load default fields on WP init.
		add_action( 'init', array( $this, 'load' ) );
	}

	/**
	 * Load default field types.
	 *
	 * @since 1.0.0
	 */
	public function load() {

		$fields = apply_filters(
			'wpforms_load_fields',
			array(
				'text',
				'textarea',
				'select',
				'radio',
				'checkbox',
				'divider',
				'entry-preview',
				'email',
				'url',
				'hidden',
				'html',
				'name',
				'password',
				'address',
				'phone',
				'date-time',
				'number',
				'page-break',
				'rating',
				'file-upload',
				'payment-single',
				'payment-multiple',
				'payment-checkbox',
				'payment-dropdown',
				'payment-credit-card',
				'payment-total',
				'number-slider',
				'richtext',
			)
		);

		// Include GDPR Checkbox field if GDPR enhancements are enabled.
		if ( wpforms_setting( 'gdpr', false ) ) {
			$fields[] = 'gdpr-checkbox';
		}

		foreach ( $fields as $field ) {

			if ( file_exists( WPFORMS_PLUGIN_DIR . 'includes/fields/class-' . $field . '.php' ) ) {
				require_once WPFORMS_PLUGIN_DIR . 'includes/fields/class-' . $field . '.php';
			} elseif ( wpforms()->pro && file_exists( WPFORMS_PLUGIN_DIR . 'pro/includes/fields/class-' . $field . '.php' ) ) {
				require_once WPFORMS_PLUGIN_DIR . 'pro/includes/fields/class-' . $field . '.php';
			}
		}

		new \WPForms_Field_Email();
	}
}
new WPForms_Fields();
