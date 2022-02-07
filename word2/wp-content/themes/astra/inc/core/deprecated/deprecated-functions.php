<?php
/**
 * Deprecated Functions of Astra Theme.
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

if ( ! function_exists( 'astra_blog_post_thumbnai_and_title_order' ) ) :

	/**
	 * Blog post thumbnail & title order
	 *
	 * @since 1.4.9
	 * @deprecated 1.4.9 Use astra_blog_post_thumbnail_and_title_order()
	 * @see astra_blog_post_thumbnail_and_title_order()
	 *
	 * @return void
	 */
	function astra_blog_post_thumbnai_and_title_order() {
		_deprecated_function( __FUNCTION__, '1.4.9', 'astra_blog_post_thumbnail_and_title_order()' );

		astra_blog_post_thumbnail_and_title_order();
	}

endif;

if ( ! function_exists( 'get_astra_secondary_class' ) ) :

	/**
	 * Retrieve the classes for the secondary element as an array.
	 *
	 * @since 1.5.2
	 * @deprecated 1.5.2 Use astra_get_secondary_class()
	 * @param string|array $class One or more classes to add to the class list.
	 * @see astra_get_secondary_class()
	 *
	 * @return array
	 */
	function get_astra_secondary_class( $class = '' ) {
		_deprecated_function( __FUNCTION__, '1.5.2', 'astra_get_secondary_class()' );

		return astra_get_secondary_class( $class );
	}

endif;

if ( ! function_exists( 'deprecated_astra_color_palette' ) ) :

	/**
	 * Depreciating astra_color_palletes filter.
	 *
	 * @since 1.5.2
	 * @deprecated 1.5.2 Use astra_deprecated_color_palette()
	 * @param array $color_palette  customizer color palettes.
	 * @see astra_deprecated_color_palette()
	 *
	 * @return array
	 */
	function deprecated_astra_color_palette( $color_palette ) {
		_deprecated_function( __FUNCTION__, '1.5.2', 'astra_deprecated_color_palette()' );

		return astra_deprecated_color_palette( $color_palette );
	}

endif;

if ( ! function_exists( 'deprecated_astra_sigle_post_navigation_enabled' ) ) :

	/**
	 * Deprecating astra_sigle_post_navigation_enabled filter.
	 *
	 * @since 1.5.2
	 * @deprecated 1.5.2 Use astra_deprecated_sigle_post_navigation_enabled()
	 * @param boolean $post_nav true | false.
	 * @see astra_deprecated_sigle_post_navigation_enabled()
	 *
	 * @return array
	 */
	function deprecated_astra_sigle_post_navigation_enabled( $post_nav ) {
		_deprecated_function( __FUNCTION__, '1.5.2', 'astra_deprecated_sigle_post_navigation_enabled()' );

		return astra_deprecated_sigle_post_navigation_enabled( $post_nav );
	}

endif;

if ( ! function_exists( 'deprecated_astra_primary_header_main_rt_section' ) ) :

	/**
	 * Deprecating astra_primary_header_main_rt_section filter.
	 *
	 * @since 1.5.2
	 * @deprecated 1.5.2 Use astra_deprecated_primary_header_main_rt_section()
	 * @param array  $elements List of elements.
	 * @param string $header Header section type.
	 * @see astra_deprecated_primary_header_main_rt_section()
	 *
	 * @return array
	 */
	function deprecated_astra_primary_header_main_rt_section( $elements, $header ) {
		_deprecated_function( __FUNCTION__, '1.5.2', 'astra_deprecated_primary_header_main_rt_section()' );

		return astra_deprecated_primary_header_main_rt_section( $elements, $header );
	}

endif;

if ( ! function_exists( 'astar' ) ) :

	/**
	 * Get a specific property of an array without needing to check if that property exists.
	 *
	 * @since 1.5.2
	 * @deprecated 1.5.2 Use astra_get_prop()
	 * @param array  $array   Array from which the property's value should be retrieved.
	 * @param string $prop    Name of the property to be retrieved.
	 * @param string $default Optional. Value that should be returned if the property is not set or empty. Defaults to null.
	 * @see astra_get_prop()
	 *
	 * @return null|string|mixed The value
	 */
	function astar( $array, $prop, $default = null ) {
		return astra_get_prop( $array, $prop, $default );
	}

endif;

/**
 * Check if we're being delivered AMP.
 *
 * @return bool
 */
function astra_is_emp_endpoint() {
	_deprecated_function( __FUNCTION__, '2.0.1', 'astra_is_amp_endpoint()' );

	return astra_is_amp_endpoint();
}

/**
 * Deprecating footer_menu_static_css function.
 *
 * Footer menu specific static CSS function.
 *
 * @since 3.7.4
 * @deprecated footer_menu_static_css() Use astra_footer_menu_static_css()
 * @see astra_footer_menu_static_css()
 *
 * @return string Parsed CSS
 */
function footer_menu_static_css() {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_footer_menu_static_css()' );
	return astra_footer_menu_static_css();
}

/**
 * Deprecating is_support_footer_widget_right_margin function.
 *
 * Backward managing function based on flag - 'support-footer-widget-right-margin' which fixes right margin issue in builder widgets.
 *
 * @since 3.7.4
 * @deprecated is_support_footer_widget_right_margin() Use astra_support_footer_widget_right_margin()
 * @see astra_support_footer_widget_right_margin()
 *
 * @return bool true|false
 */
function is_support_footer_widget_right_margin() {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_support_footer_widget_right_margin()' );
	return astra_support_footer_widget_right_margin();
}

/**
 * Deprecating is_astra_addon_3_5_0_version function.
 *
 * Checking if Astra Addon is of v3.5.0 or on higher version.
 *
 * @since 3.7.4
 * @deprecated is_astra_addon_3_5_0_version() Use astra_addon_has_3_5_0_version()
 * @see astra_addon_has_3_5_0_version()
 *
 * @return bool true|false based on version_compare of ASTRA_EXT_VER
 */
function is_astra_addon_3_5_0_version() {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_addon_has_3_5_0_version()' );
	return astra_addon_has_3_5_0_version();
}

/**
 * Deprecating prepare_button_defaults function.
 *
 * Default configurations for builder button components.
 *
 * @since 3.7.4
 * @deprecated prepare_button_defaults() Use astra_prepare_button_defaults()
 * @param array  $defaults Button default configs.
 * @param string $index builder button component index.
 * @see astra_prepare_button_defaults()
 *
 * @return array
 */
function prepare_button_defaults( $defaults, $index ) {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_prepare_button_defaults()' );
	return astra_prepare_button_defaults( $defaults, absint( $index ) );
}

/**
 * Deprecating prepare_html_defaults function.
 *
 * Default configurations for builder HTML components.
 *
 * @since 3.7.4
 * @deprecated prepare_html_defaults() Use astra_prepare_html_defaults()
 * @param array  $defaults HTML default configs.
 * @param string $index builder HTML component index.
 * @see astra_prepare_html_defaults()
 *
 * @return array
 */
function prepare_html_defaults( $defaults, $index ) {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_prepare_html_defaults()' );
	return astra_prepare_html_defaults( $defaults, absint( $index ) );
}

/**
 * Deprecating prepare_social_icon_defaults function.
 *
 * Default configurations for builder Social Icon components.
 *
 * @since 3.7.4
 * @deprecated prepare_social_icon_defaults() Use astra_prepare_social_icon_defaults()
 * @param array  $defaults Social Icon default configs.
 * @param string $index builder Social Icon component index.
 * @see astra_prepare_social_icon_defaults()
 *
 * @return array
 */
function prepare_social_icon_defaults( $defaults, $index ) {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_prepare_social_icon_defaults()' );
	return astra_prepare_social_icon_defaults( $defaults, absint( $index ) );
}

/**
 * Deprecating prepare_widget_defaults function.
 *
 * Default configurations for builder Widget components.
 *
 * @since 3.7.4
 * @deprecated prepare_widget_defaults() Use astra_prepare_widget_defaults()
 * @param array  $defaults Widget default configs.
 * @param string $index builder Widget component index.
 * @see astra_prepare_widget_defaults()
 *
 * @return array
 */
function prepare_widget_defaults( $defaults, $index ) {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_prepare_widget_defaults()' );
	return astra_prepare_widget_defaults( $defaults, absint( $index ) );
}

/**
 * Deprecating prepare_menu_defaults function.
 *
 * Default configurations for builder Menu components.
 *
 * @since 3.7.4
 * @deprecated prepare_menu_defaults() Use astra_prepare_menu_defaults()
 * @param array  $defaults Menu default configs.
 * @param string $index builder Menu component index.
 * @see astra_prepare_menu_defaults()
 *
 * @return array
 */
function prepare_menu_defaults( $defaults, $index ) {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_prepare_menu_defaults()' );
	return astra_prepare_menu_defaults( $defaults, absint( $index ) );
}

/**
 * Deprecating prepare_divider_defaults function.
 *
 * Default configurations for builder Divider components.
 *
 * @since 3.7.4
 * @deprecated prepare_divider_defaults() Use astra_prepare_divider_defaults()
 * @param array  $defaults Divider default configs.
 * @param string $index builder Divider component index.
 * @see astra_prepare_divider_defaults()
 *
 * @return array
 */
function prepare_divider_defaults( $defaults, $index ) {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_prepare_divider_defaults()' );
	return astra_prepare_divider_defaults( $defaults, absint( $index ) );
}

/**
 * Deprecating is_astra_pagination_enabled function.
 *
 * Checking if Astra's pagination enabled.
 *
 * @since 3.7.4
 * @deprecated is_astra_pagination_enabled() Use astra_check_pagination_enabled()
 * @see astra_check_pagination_enabled()
 *
 * @return bool true|false
 */
function is_astra_pagination_enabled() {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_check_pagination_enabled()' );
	return astra_check_pagination_enabled();
}

/**
 * Deprecating is_current_post_comment_enabled function.
 *
 * Checking if current post's comment enabled and comment section is open.
 *
 * @since 3.7.4
 * @deprecated is_current_post_comment_enabled() Use astra_check_current_post_comment_enabled()
 * @see astra_check_current_post_comment_enabled()
 *
 * @return bool true|false
 */
function is_current_post_comment_enabled() {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_check_current_post_comment_enabled()' );
	return astra_check_current_post_comment_enabled();
}

/**
 * Deprecating ast_load_preload_local_fonts function.
 *
 * Preload Google Fonts - Feature of self-hosting font.
 *
 * @since 3.7.4
 * @deprecated ast_load_preload_local_fonts() Use astra_load_preload_local_fonts()
 * @param string $google_font_url Google Font URL generated by customizer config.
 * @see astra_load_preload_local_fonts()
 *
 * @return string
 */
function ast_load_preload_local_fonts( $google_font_url ) {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_load_preload_local_fonts()' );
	return astra_load_preload_local_fonts( $google_font_url );
}

/**
 * Deprecating ast_get_webfont_url function.
 *
 * Getting webfont based Google font URL.
 *
 * @since 3.7.4
 * @deprecated ast_get_webfont_url() Use astra_get_webfont_url()
 * @param string $google_font_url Google Font URL generated by customizer config.
 * @see astra_get_webfont_url()
 *
 * @return string
 */
function ast_get_webfont_url( $google_font_url ) {
	_deprecated_function( __FUNCTION__, '3.7.4', 'astra_get_webfont_url()' );
	return astra_get_webfont_url( $google_font_url );
}
