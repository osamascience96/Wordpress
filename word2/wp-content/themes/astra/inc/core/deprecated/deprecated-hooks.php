<?php
/**
 * Deprecated Hooks of Astra Theme.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.23
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'astra_do_action_deprecated' ) ) {
	/**
	 * Astra Filter Deprecated
	 *
	 * @since 1.1.1
	 * @param string $tag         The name of the filter hook.
	 * @param array  $args        Array of additional function arguments to be passed to apply_filters().
	 * @param string $version     The version of WordPress that deprecated the hook.
	 * @param string $replacement Optional. The hook that should have been used. Default false.
	 * @param string $message     Optional. A message regarding the change. Default null.
	 */
	function astra_do_action_deprecated( $tag, $args, $version, $replacement = false, $message = null ) {
		if ( function_exists( 'do_action_deprecated' ) ) { /* WP >= 4.6 */
			do_action_deprecated( $tag, $args, $version, $replacement, $message );
		} else {
			do_action_ref_array( $tag, $args ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
		}
	}
}

// Depreciating asta_register_admin_menu hook.
add_action( 'astra_register_admin_menu', 'astra_deprecated_asta_register_admin_menu_hook', 10, 5 );

/**
 * Depreciating 'asta_register_admin_menu' action & replacing with 'astra_register_admin_menu'.
 *
 * @param string   $parent_page        Admin menu page.
 * @param string   $page_title         The text to be displayed in the title tags of the page when the menu is selected.
 * @param string   $capability         The capability required for this menu to be displayed to the user.
 * @param string   $page_menu_slug     The slug name to refer to this menu by (should be unique for this menu).
 * @param callable $page_menu_func     The function to be called to output the content for this page.
 *
 * @since 3.7.4
 */
function astra_deprecated_asta_register_admin_menu_hook( $parent_page, $page_title, $capability, $page_menu_slug, $page_menu_func ) {
	astra_do_action_deprecated( 'asta_register_admin_menu', array( $parent_page, $page_title, $capability, $page_menu_slug, $page_menu_func ), '3.7.4', 'astra_register_admin_menu' );
}
