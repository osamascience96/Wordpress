<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package    Athemes Starter Sites
 * @subpackage Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Athemes_Starter_Sites' ) ) {
	/**
	 * Main Core Class
	 */
	class Athemes_Starter_Sites {
		/**
		 * The plugin version number.
		 *
		 * @var string $data The plugin version number.
		 */
		public $version;

		/**
		 * The plugin data array.
		 *
		 * @var array $data The plugin data array.
		 */
		public $data = array();

		/**
		 * The plugin settings array.
		 *
		 * @var array $settings The plugin data array.
		 */
		public $settings = array();

		/**
		 * INIT (global theme queue)
		 */
		public function init() {

			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			// Get plugin data.
			$plugin_data = get_plugin_data( ATSS_PATH . '/athemes-starter-sites.php' );

			// Vars.
			$this->version = $plugin_data['Version'];

			// Settings.
			$this->settings = array(
				'name'    => esc_html__( 'Athemes_Starter_Sites', 'athemes-starter-sites' ),
				'version' => $plugin_data['Version'],
			);

			// Constants.
			$this->define( 'ATSS', true );
			$this->define( 'ATSS_VERSION', $plugin_data['Version'] );

			require_once ATSS_PATH . 'core/class-widget-importer.php';
			require_once ATSS_PATH . 'core/class-customizer-importer.php';

			// Include import.
			require_once ATSS_PATH . 'import/class-import.php';

			// Include core.
			require_once ATSS_PATH . 'core/core-api.php';
			require_once ATSS_PATH . 'core/core-helpers.php';

			// Include admin classes.
			require_once ATSS_PATH . 'core/class-demos-page.php';

			// Actions.
			add_action( 'atss_plugin_activation', array( $this, 'activation' ) );
			add_action( 'plugins_loaded', array( $this, 'check_version' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 5 );
			add_action( 'plugins_loaded', array( $this, 'theme_configs' ) );
		}

		/**
		 * Load theme config files
		 */
		public function theme_configs() {

			$theme  = wp_get_theme();
			$parent = wp_get_theme()->parent();

			if ( get_template_directory() !== get_stylesheet_directory() ) {
				$parent = wp_get_theme()->parent();
				$parent = $parent->name;
			}

			if ( 'Sydney' === $theme->name || 'Sydney' === $parent ) {
				require_once ATSS_PATH . 'themes/sydney.php';
			} elseif ( 'Sydney Pro' === $theme->name || 'Sydney Pro' === $parent ) {
				require_once ATSS_PATH . 'themes/sydney-pro.php';
			} elseif ( 'Airi' === $theme->name || 'Airi' === $parent ) {
				require_once ATSS_PATH . 'themes/airi.php';
			} elseif ( 'Botiga' === $theme->name || 'Botiga' === $parent ) {
				require_once ATSS_PATH . 'themes/botiga.php';
			}
		}

		/**
		 * This function will safely define a constant
		 *
		 * @param string $name  The name.
		 * @param mixed  $value The value.
		 */
		public function define( $name, $value = true ) {

			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Returns true if has setting.
		 *
		 * @param string $name The name.
		 */
		public function has_setting( $name ) {
			return isset( $this->settings[ $name ] );
		}

		/**
		 * Returns a setting.
		 *
		 * @param string $name The name.
		 */
		public function get_setting( $name ) {
			return isset( $this->settings[ $name ] ) ? $this->settings[ $name ] : null;
		}

		/**
		 * Updates a setting.
		 *
		 * @param string $name  The name.
		 * @param mixed  $value The value.
		 */
		public function update_setting( $name, $value ) {
			$this->settings[ $name ] = $value;
			return true;
		}

		/**
		 * Returns data.
		 *
		 * @param string $name The name.
		 */
		public function get_data( $name ) {
			return isset( $this->data[ $name ] ) ? $this->data[ $name ] : null;
		}

		/**
		 * Sets data.
		 *
		 * @param string $name  The name.
		 * @param mixed  $value The value.
		 */
		public function set_data( $name, $value ) {
			$this->data[ $name ] = $value;
		}

		/**
		 * Hook activation
		 */
		public function activation() {
			if ( get_option( 'atss_db_version' ) ) {
				return;
			}

			update_option( 'atss_db_version', atss_raw_setting( 'version' ), true );
		}

		/**
		 * Check current version
		 */
		public function check_version() {

			// Version Data.
			$new = atss_raw_setting( 'version' );

			// Get db version.
			$current = get_option( 'atss_db_version', $new );

			// If versions don't match.
			if ( ! empty( $current ) && ! empty( $new ) && $current !== $new ) {
				/**
				 * If different versions call a special hook.
				 *
				 * @param string $current Current version.
				 * @param string $new     New version.
				 */
				do_action( 'atss_plugin_upgrade', $current, $new );

				update_option( 'atss_db_version', $new );

			} elseif ( ! empty( $new ) && $current !== $new ) {

				update_option( 'atss_db_version', $new );
			}
		}

		/**
		 * This function will register scripts and styles for admin dashboard.
		 *
		 * @param string $page Current page.
		 */
		public function admin_enqueue_scripts( $page ) {
			wp_enqueue_script( 'select2', ATSS_URL . 'assets/js/select2.min.js', array( 'jquery' ), '1.0', true );

			wp_enqueue_script( 'stylefire', ATSS_URL . 'assets/js/stylefire.min.js', array( 'jquery' ), '1.0', true );

			wp_enqueue_script( 'popmotion', ATSS_URL . 'assets/js/popmotion.global.min.js', array( 'jquery' ), '1.0', true );

			wp_enqueue_script( 'athemes-starter-sites', ATSS_URL . 'assets/js/athemes-starter-sites.js', array( 'jquery' ), filemtime( ATSS_PATH . 'assets/js/athemes-starter-sites.js' ), true );

			wp_localize_script( 'athemes-starter-sites', 'atss_localize', array(
				'ajax_url'       => admin_url( 'admin-ajax.php' ),
				'nonce'          => wp_create_nonce( 'nonce' ),
				'failed_message' => esc_html__( 'Something went wrong, contact support.', 'athemes-starter-sites' ),
			) );

			// Select2.
			wp_enqueue_style( 'select2', ATSS_URL . 'assets/css/select2.min.css', array(), atss_get_setting( 'version' ) );

			// Styles.
			wp_enqueue_style( 'athemes-starter-sites', atss_style( ATSS_URL . 'assets/css/athemes-starter-sites.css' ), array(), filemtime( ATSS_PATH . 'assets/css/athemes-starter-sites.css' ) );

			// Add RTL support.
			wp_style_add_data( 'athemes-starter-sites', 'rtl', 'replace' );
		}
	}

	/**
	 * The main function responsible for returning the one true atss Instance to functions everywhere.
	 * Use this function like you would a global variable, except without needing to declare the global.
	 *
	 * Example: <?php $atss = atss(); ?>
	 */
	function atss() {

		// Globals.
		global $atss_instance;

		// Init.
		if ( ! isset( $atss_instance ) ) {
			$atss_instance = new Athemes_Starter_Sites();
			$atss_instance->init();
		}

		return $atss_instance;
	}

	// Initialize.
	atss();
}