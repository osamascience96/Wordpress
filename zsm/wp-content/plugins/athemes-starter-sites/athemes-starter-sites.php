<?php
/**
 * Plugin Name:       aThemes Starter Sites
 * Description:       Starter Sites for Sydney, Botiga and Airi
 * Version:           1.0.24
 * Author:            aThemes
 * Author URI:        https://athemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       athemes-starter-sites
 * Domain Path:       /languages
 *
 * @link              https://athemes.com
 * @package           Athemes Starter Sites
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Variables
 */
define( 'ATSS_URL', plugin_dir_url( __FILE__ ) );
define( 'ATSS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin Activation.
 *
 * @param bool $networkwide The networkwide.
 */
function atss_plugin_activation( $networkwide ) {
	do_action( 'atss_plugin_activation', $networkwide );
}
register_activation_hook( __FILE__, 'atss_plugin_activation' );

/**
 * Plugin Deactivation.
 *
 * @param bool $networkwide The networkwide.
 */
function atss_plugin_deactivation( $networkwide ) {
	do_action( 'atss_plugin_deactivation', $networkwide );
}
register_deactivation_hook( __FILE__, 'atss_plugin_deactivation' );

/**
 * Language
 */
load_plugin_textdomain( 'athemes-starter-sites', false, plugin_basename( ATSS_PATH ) . '/languages' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . '/core/class-core.php';