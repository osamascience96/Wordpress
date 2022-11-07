<?php
/**
 * The api functions for the plugin
 *
 * @package    Athemes Starter Sites
 * @subpackage Core
 * @version    1.0.0
 * @since      1.0.0
 */

/**
 * This function will return true for a non empty array
 *
 * @param array $array Array.
 */
function atss_is_array( $array ) {
	return ( is_array( $array ) && ! empty( $array ) );
}

/**
 * This function will return true for an empty var (allows 0 as true)
 *
 * @param mixed $value Value.
 */
function atss_is_empty( $value ) {
	return ( empty( $value ) && ! is_numeric( $value ) );
}

/**
 * Alias of atss()->has_setting()
 *
 * @param string $name The name.
 */
function atss_has_setting( $name = '' ) {
	return atss()->has_setting( $name );
}

/**
 * Alias of atss()->get_setting()
 *
 * @param string $name The name.
 */
function atss_raw_setting( $name = '' ) {
	return atss()->get_setting( $name );
}

/**
 * Alias of atss()->update_setting()
 *
 * @param string $name The name.
 * @param mixed  $value The value.
 */
function atss_update_setting( $name, $value ) {

	return atss()->update_setting( $name, $value );
}

/**
 * Alias of atss()->get_setting()
 *
 * @param string $name  The name.
 * @param mixed  $value The value.
 */
function atss_get_setting( $name, $value = null ) {

	// Check settings.
	if ( atss_has_setting( $name ) ) {
		$value = atss_raw_setting( $name );
	}

	// Filter.
	$value = apply_filters( "atss_settings_{$name}", $value );

	return $value;
}

/**
 * This function will add a value into the settings array found in the acf object
 *
 * @param string $name  The name.
 * @param mixed  $value The value.
 */
function atss_append_setting( $name, $value ) {

	// Vars.
	$setting = atss_raw_setting( $name );

	// Bail ealry if not array.
	if ( ! is_array( $setting ) ) {
		$setting = array();
	}

	// Append.
	$setting[] = $value;

	// Update.
	return atss_update_setting( $name, $setting );
}

/**
 * Returns data.
 *
 * @param string $name  The name.
 */
function atss_get_data( $name ) {
	return atss()->get_data( $name );
}

/**
 * Sets data.
 *
 * @param string $name  The name.
 * @param mixed  $value The value.
 */
function atss_set_data( $name, $value ) {
	return atss()->set_data( $name, $value );
}
