<?php
/**
 * Functions
 *
 * @since  2.0.0
 * @package Astra Sites
 */

if ( ! function_exists( 'astra_sites_error_log' ) ) :

	/**
	 * Error Log
	 *
	 * A wrapper function for the error_log() function.
	 *
	 * @since 2.0.0
	 *
	 * @param  mixed $message Error message.
	 * @return void
	 */
	function astra_sites_error_log( $message = '' ) {
		if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			if ( is_array( $message ) ) {
				$message = wp_json_encode( $message );
			}

			if ( apply_filters( 'astra_sites_debug_logs', false ) ) {
				error_log( $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			}
		}
	}

endif;

if ( ! function_exists( 'astra_sites_get_suggestion_link' ) ) :
	/**
	 *
	 * Get suggestion link.
	 *
	 * @since 2.6.1
	 *
	 * @return suggestion link.
	 */
	function astra_sites_get_suggestion_link() {
		$white_label_link = Astra_Sites_White_Label::get_option( 'astra-agency', 'licence' );

		if ( empty( $white_label_link ) ) {
			$white_label_link = 'https://wpastra.com/sites-suggestions/?utm_source=demo-import-panel&utm_campaign=astra-sites&utm_medium=suggestions';
		}
		return apply_filters( 'astra_sites_suggestion_link', $white_label_link );
	}
endif;

if ( ! function_exists( 'astra_sites_is_valid_image' ) ) :
	/**
	 * Check for the valid image
	 *
	 * @param string $link  The Image link.
	 *
	 * @since 2.6.2
	 * @return boolean
	 */
	function astra_sites_is_valid_image( $link = '' ) {
		return preg_match( '/^((https?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?\/[\w\-]+\.(jpg|png|gif|jpeg|svg)\/?$/i', $link );
	}
endif;

if ( ! function_exists( 'astra_get_site_data' ) ) :
	/**
	 * Returns the value of the index for the Site Data
	 *
	 * @param string $index  The index value of the data.
	 *
	 * @since 2.6.14
	 * @return mixed
	 */
	function astra_get_site_data( $index = '' ) {
		$demo_data = get_option( 'astra_sites_import_data', array() );
		if ( ! empty( $demo_data ) && isset( $demo_data[ $index ] ) ) {
			return $demo_data[ $index ];
		}
		return '';
	}
endif;

/**
 * Check is valid URL
 *
 * @param string $url  The site URL.
 *
 * @since 2.7.1
 * @return string
 */
function astra_sites_is_valid_url( $url = '' ) {
	if ( empty( $url ) ) {
		return false;
	}

	$parse_url = wp_parse_url( $url );
	if ( empty( $parse_url ) || ! is_array( $parse_url ) ) {
		return false;
	}

	$valid_hosts = array(
		'lh3.googleusercontent.com',
		'pixabay.com',
	);

	$api_domain_parse_url = wp_parse_url( Astra_Sites::get_instance()->get_api_domain() );
	$valid_hosts[] = $api_domain_parse_url['host'];

	// Validate host.
	if ( in_array( $parse_url['host'], $valid_hosts, true ) ) {
		return true;
	}

	return false;
}

/**
 * Get all the posts to be reset.
 *
 * @since 3.0.3
 * @return array
 */
function astra_sites_get_reset_post_data() {
	global $wpdb;

	$post_ids = $wpdb->get_col( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_astra_sites_imported_post'" );

	return $post_ids;
}

/**
 * Get all the forms to be reset.
 *
 * @since 3.0.3
 * @return array
 */
function astra_sites_get_reset_form_data() {
	global $wpdb;

	$form_ids = $wpdb->get_col( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_astra_sites_imported_wp_forms'" );

	return $form_ids;
}

/**
 * Get all the terms to be reset.
 *
 * @since 3.0.3
 * @return array
 */
function astra_sites_get_reset_term_data() {
	global $wpdb;

	$term_ids = $wpdb->get_col( "SELECT term_id FROM {$wpdb->termmeta} WHERE meta_key='_astra_sites_imported_term'" );

	return $term_ids;
}

/**
 * Get API params
 *
 * @since 2.7.3
 * @return array
 */
function astra_sites_get_api_params() {
	return apply_filters(
		'astra_sites_api_params', array(
			'purchase_key' => '',
			'site_url'     => get_site_url(),
			'per-page'     => 15,
			'template_status' => '',
		)
	);
}

/**
 * Check if Import for Astra Site is in progress
 *
 * @since 3.0.21
 * @return array
 */
function astra_sites_has_import_started() {
	$has_import_started = get_transient( 'astra_sites_import_started' );
	if ( 'yes' === $has_import_started ) {
		return true;
	}
	return false;
}
