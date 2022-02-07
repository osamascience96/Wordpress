<?php
/**
 * Intelligent Starter Templates
 *
 * @since  3.0.0-beta.1
 * @package Astra Sites
 */

define( 'IST_VER', '1.0.0-beta.1' );

if ( ! defined( 'STARTER_TEMPLATES_REMOTE_URL' ) ) {
	define( 'STARTER_TEMPLATES_REMOTE_URL', 'https://websitedemos.net/' );
}

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'INTELLIGENT_TEMPLATES_FILE' ) ) {
	define( 'INTELLIGENT_TEMPLATES_FILE', __FILE__ );
}

if ( ! defined( 'INTELLIGENT_TEMPLATES_BASE' ) ) {
	define( 'INTELLIGENT_TEMPLATES_BASE', plugin_basename( INTELLIGENT_TEMPLATES_FILE ) );
}

if ( ! defined( 'INTELLIGENT_TEMPLATES_DIR' ) ) {
	define( 'INTELLIGENT_TEMPLATES_DIR', plugin_dir_path( INTELLIGENT_TEMPLATES_FILE ) );
}

if ( ! defined( 'INTELLIGENT_TEMPLATES_URI' ) ) {
	define( 'INTELLIGENT_TEMPLATES_URI', plugins_url( '/', INTELLIGENT_TEMPLATES_FILE ) );
}

require_once INTELLIGENT_TEMPLATES_DIR . 'class-onboarding-loader.php';
