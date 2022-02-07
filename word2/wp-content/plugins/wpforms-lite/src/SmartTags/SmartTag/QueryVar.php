<?php

namespace WPForms\SmartTags\SmartTag;

/**
 * Class QueryVar.
 *
 * @since 1.6.7
 */
class QueryVar extends SmartTag {

	/**
	 * Get smart tag value.
	 *
	 * @since 1.6.7
	 *
	 * @param array  $form_data Form data.
	 * @param array  $fields    List of fields.
	 * @param string $entry_id  Entry ID.
	 *
	 * @return string
	 */
	public function get_value( $form_data, $fields = [], $entry_id = '' ) {

		$attributes = $this->get_attributes();

		if ( empty( $attributes['key'] ) ) {
			return '';
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return ! empty( $_GET[ $attributes['key'] ] ) ? esc_html( sanitize_text_field( wp_unslash( $_GET[ $attributes['key'] ] ) ) ) : '';
	}
}
