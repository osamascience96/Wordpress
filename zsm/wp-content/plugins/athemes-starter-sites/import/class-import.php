<?php
/**
 * Main class of Suki Sites Import plugin.
 *
 * @package    Athemes Starter Sites
 * @subpackage Core
 */

/**
 * Import Class
 */
class Athemes_Starter_Sites_Import {

	/**
	 * Singleton instance
	 *
	 * @var Athemes_Starter_Sites_Import
	 */
	private static $instance;

	/**
	 * Sites Server API URL
	 *
	 * @var string
	 */
	public $api_url;

	/**
	 * Get singleton instance.
	 *
	 * @return Athemes_Starter_Sites_Import
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Time in milliseconds, marking the beginning of the import.
	 *
	 * @var float
	 */
	private $microtime;

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'init' ) );
	}

	/**
	 * Initialize plugin.
	 */
	public function init() {
		add_action( 'upload_mimes', array( $this, 'add_custom_mimes' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'real_mime_type_for_xml' ), 10, 4 );

		add_action( 'wp_ajax_atss_import_plugin', array( $this, 'ajax_import_plugin' ) );
		add_action( 'wp_ajax_atss_import_contents', array( $this, 'ajax_import_contents' ) );
		add_action( 'wp_ajax_atss_import_customizer', array( $this, 'ajax_import_customizer' ) );
		add_action( 'wp_ajax_atss_import_widgets', array( $this, 'ajax_import_widgets' ) );
		add_action( 'wp_ajax_atss_import_options', array( $this, 'ajax_import_options' ) );
		add_action( 'wp_ajax_atss_import_finish', array( $this, 'ajax_import_finish' ) );
	}

	/**
	 * Add custom mimes for the uploader.
	 *
	 * @param array $mimes The mimes.
	 */
	public function add_custom_mimes( $mimes ) {
		// Allow SVG files.
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';

		// Allow XML files.
		$mimes['xml'] = 'text/xml';

		// Allow JSON files.
		$mimes['json'] = 'application/json';

		return $mimes;
	}

	/**
	 * Filters the "real" file type of the given file.
	 *
	 * @param array  $wp_check_filetype_and_ext The wp_check_filetype_and_ext.
	 * @param string $file                      The file.
	 * @param string $filename                  The filename.
	 * @param array  $mimes                     The mimes.
	 */
	public function real_mime_type_for_xml( $wp_check_filetype_and_ext, $file, $filename, $mimes ) {
		if ( '.xml' === substr( $filename, -4 ) ) {
			$wp_check_filetype_and_ext['ext']  = 'xml';
			$wp_check_filetype_and_ext['type'] = 'text/xml';
		}

		return $wp_check_filetype_and_ext;
	}

	/**
	 * Get plugin status.
	 *
	 * @param string $plugin_path Plugin path.
	 */
	public function get_plugin_status( $plugin_path ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_path ) ) {
			return 'not_installed';
		} elseif ( in_array( $plugin_path, (array) get_option( 'active_plugins', array() ), true ) || is_plugin_active_for_network( $plugin_path ) ) {
			return 'active';
		} else {
			return 'inactive';
		}
	}

	/**
	 * Install a plugin.
	 *
	 * @param string $plugin_slug Plugin slug.
	 */
	public function install_plugin( $plugin_slug ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		if ( false === filter_var( $plugin_slug, FILTER_VALIDATE_URL ) ) {
			$api = plugins_api(
				'plugin_information',
				array(
					'slug'   => $plugin_slug,
					'fields' => array(
						'short_description' => false,
						'sections'          => false,
						'requires'          => false,
						'rating'            => false,
						'ratings'           => false,
						'downloaded'        => false,
						'last_updated'      => false,
						'added'             => false,
						'tags'              => false,
						'compatibility'     => false,
						'homepage'          => false,
						'donate_link'       => false,
					),
				)
			);

			$download_link = $api->download_link;
		} else {
			$download_link = $plugin_slug;
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$install = $upgrader->install( $download_link );

		if ( false === $install ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Activate a plugin.
	 *
	 * @param string $plugin_path Plugin path.
	 */
	public function activate_plugin( $plugin_path ) {

		if ( ! current_user_can( 'install_plugins' ) ) {
			return false;
		}

		$activate = activate_plugin( $plugin_path, '', false, true );

		if ( is_wp_error( $activate ) ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * AJAX callback to install and activate a plugin.
	 */
	public function ajax_import_plugin() {
		check_ajax_referer( 'nonce', 'nonce' );

		// Demo ID
		set_transient( 'atss_importer_demo_id', $_POST['demo_id'] );

		if ( ! isset( $_POST['plugin_slug'] ) || ! $_POST['plugin_slug'] ) {
			wp_send_json_error( esc_html__( 'Unknown slug in a plugin.', 'athemes-starter-sites' ) );
			wp_die();
		}

		if ( ! isset( $_POST['plugin_path'] ) || ! $_POST['plugin_path'] ) {
			wp_send_json_error( esc_html__( 'Unknown path in a plugin.', 'athemes-starter-sites' ) );
			wp_die();
		}

		$plugin_slug = sanitize_text_field( $_POST['plugin_slug'] );
		$plugin_path = sanitize_text_field( $_POST['plugin_path'] );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions to install the plugin.', 'athemes-starter-sites' ) );
			wp_die();
		}

		if ( 'not_installed' === $this->get_plugin_status( $plugin_path ) ) {

			$this->install_plugin( $plugin_slug );

			$this->activate_plugin( $plugin_path );

		} elseif ( 'inactive' === $this->get_plugin_status( $plugin_path ) ) {

			$this->activate_plugin( $plugin_path );
		}

		if ( 'active' === $this->get_plugin_status( $plugin_path ) ) {
			wp_send_json_success();
		}

		/**
		 * Action hook.
		 */
		do_action( 'atss_import_plugin', $plugin_slug, $plugin_path );

		wp_send_json_error( esc_html__( 'Failed to initialize or activate importer plugin.', 'athemes-starter-sites' ) );

		wp_die();
	}

	/**
	 * AJAX callback to import contents and media files from contents.xml.
	 */
	public function ajax_import_contents() {
		check_ajax_referer( 'nonce', 'nonce' );

		// Demo ID
		set_transient( 'atss_importer_demo_id', $_POST['demo_id'] );

		$xml_file_path = get_transient( 'atss_importer_data' );

		if ( ! $xml_file_path ) {
			if ( ! isset( $_POST['url'] ) || ! $_POST['url'] ) {
				wp_send_json_error( esc_html__( 'The url address of the demo content is not specified.', 'athemes-starter-sites' ) );
				wp_die();
			}

			$file_url = sanitize_text_field( $_POST['url'] );

			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_send_json_error( esc_html__( 'You are not permitted to import contents.', 'athemes-starter-sites' ) );
				wp_die();
			}

			if ( ! isset( $file_url ) ) {
				wp_send_json_error( esc_html__( 'No XML file specified.', 'athemes-starter-sites' ) );
				wp_die();
			}

			/**
			 * Download contents.xml
			 */
			if ( ! function_exists( 'download_url' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			// URL to the WordPress logo.
			$url             = wp_unslash( $file_url );
			$timeout_seconds = 5;

			// Download file to temp dir.
			$temp_file = download_url( $url, $timeout_seconds );

			if ( is_wp_error( $temp_file ) ) {
				wp_send_json_error( $temp_file->get_error_message() );
				wp_die();
			}

			// Array based on $_FILE as seen in PHP file uploads.
			$file_args = array(
				'name'     => basename( $url ),
				'tmp_name' => $temp_file,
				'error'    => 0,
				'size'     => filesize( $temp_file ),
			);

			$overrides = array(
				// This tells WordPress to not look for the POST form
				// fields that would normally be present. Default is true.
				// Since the file is being downloaded from a remote server,
				// there will be no form fields.
				'test_form'   => false,

				// Setting this to false lets WordPress allow empty files – not recommended.
				'test_size'   => true,

				// A properly uploaded file will pass this test.
				// There should be no reason to override this one.
				'test_upload' => true,

				'mimes'       => array(
					'xml' => 'text/xml',
				),
			);

			// Move the temporary file into the uploads directory.
			$download_response = wp_handle_sideload( $file_args, $overrides );

			// Error when downloading XML file.
			if ( isset( $download_response['error'] ) ) {
				wp_send_json_error( $download_response['error'] );
				wp_die();
			}

			// Define the downloaded contents.xml file path.
			$xml_file_path = $download_response['file'];

			set_transient( 'atss_importer_data', $xml_file_path, HOUR_IN_SECONDS );
		}

		/**
		 * Import content and media files using WXR Importer.
		 */
		if ( ! class_exists( 'WP_Importer' ) ) {
			if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
				define( 'WP_LOAD_IMPORTERS', true );
			}

			require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		}

		/**
		 * Import Core.
		 */
		require_once ATSS_PATH . 'import/wp-content-importer-v2/WPImporterLogger.php';
		require_once ATSS_PATH . 'import/wp-content-importer-v2/WPImporterLoggerCLI.php';
		require_once ATSS_PATH . 'import/wp-content-importer-v2/WXRImportInfo.php';
		require_once ATSS_PATH . 'import/wp-content-importer-v2/WXRImporter.php';
		require_once ATSS_PATH . 'import/wp-content-importer-v2/Logger.php';

		/**
		 * Prepare the importer.
		 */

		// Time to run the import!
		set_time_limit( 0 );

		$this->microtime = microtime( true );

		// Are we allowed to create users?
		add_filter( 'wxr_importer.pre_process.user', '__return_null' );

		// Check, if we need to send another AJAX request and set the importing author to the current user.
		add_filter( 'wxr_importer.pre_process.post', array( $this, 'ajax_request_maybe' ) );

		// Set the WordPress Importer v2 as the importer used in this plugin.
		// More: https://github.com/humanmade/WordPress-Importer.
		$importer = new WXRImporter( array(
			'fetch_attachments' => true,
			'default_author'    => get_current_user_id(),
		) );

		// Logger options for the logger used in the importer.
		$logger_options = apply_filters( 'atss_logger_options', array(
			'logger_min_level' => 'warning',
		) );

		// Configure logger instance and set it to the importer.
		$logger            = new Logger();
		$logger->min_level = $logger_options['logger_min_level'];

		// Set logger.
		$importer->set_logger( $logger );

		/**
		 * Process import.
		 */
		$importer->import( $xml_file_path );

		// Is error ?.
		if ( is_wp_error( $importer ) ) {
			wp_send_json_error( $importer->get_error_message() );
			wp_die();
		}

		if ( $logger->error_output ) {
			wp_send_json_error( $logger->error_output );
			wp_die();
		}

		/**
		 * Action hook.
		 */
		do_action( 'atss_import_contents' );

		/**
		 * Return successful AJAX.
		 */
		wp_send_json_success();
	}

	/**
	 * Check if we need to create a new AJAX request, so that server does not timeout.
	 *
	 * @param array $data current post data.
	 * @return array
	 */
	public function ajax_request_maybe( $data ) {
		$time = microtime( true ) - $this->microtime;

		// We should make a new ajax call, if the time is right.
		if ( $time > apply_filters( 'atss_time_for_one_ajax_call', 22 ) ) {
			$response = array(
				'success' => true,
				'status'  => 'newAJAX',
				'message' => 'Time for new AJAX request!: ' . $time,
			);

			// Send the request for a new AJAX call.
			wp_send_json( $response );
		}

		// Set importing author to the current user.
		// Fixes the [WARNING] Could not find the author for ... log warning messages.
		$current_user_obj = wp_get_current_user();

		$data['post_author'] = $current_user_obj->user_login;

		return $data;
	}

	/**
	 * AJAX callback to import customizer settings from customizer.json.
	 */
	public function ajax_import_customizer() {
		check_ajax_referer( 'nonce', 'nonce' );

		// Demo ID
		set_transient( 'atss_importer_demo_id', $_POST['demo_id'] );

		if ( ! isset( $_POST['url'] ) || ! $_POST['url'] ) {
			wp_send_json_error( esc_html__( 'The url address of the demo content is not specified.', 'athemes-starter-sites' ) );
			wp_die();
		}

		$file_url = sanitize_text_field( $_POST['url'] );

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_send_json_error( esc_html__( 'You are not permitted to import customizer.', 'athemes-starter-sites' ) );
			wp_die();
		}

		if ( ! isset( $file_url ) ) {
			wp_send_json_error( esc_html__( 'No customizer JSON file specified.', 'athemes-starter-sites' ) );
			wp_die();
		}

		/**
		 * Process customizer.json.
		 */

		// Get JSON data from customizer.json.
		$raw = wp_remote_get( wp_unslash( $file_url ) );

		// Abort if customizer.json response code is not successful.
		if ( 200 != wp_remote_retrieve_response_code( $raw ) ) {
			wp_send_json_error();
			wp_die();
		}

		// Decode raw JSON string to associative array.
		$data = maybe_unserialize( wp_remote_retrieve_body( $raw ), true );

		$customizer = new ATSS_Customizer_Importer();

		// Import.
		$results = $customizer->import( $data );

		if ( is_wp_error( $results ) ) {
			$error_message = $results->get_error_message();

			wp_send_json_error( $error_message );
			wp_die();
		}

		/**
		 * Action hook.
		 */

		do_action( 'atss_import_customizer', $data );

		/**
		 * Return successful AJAX.
		 */

		wp_send_json_success();
	}

	/**
	 * AJAX callback to import widgets on all sidebars from widgets.json.
	 */
	public function ajax_import_widgets() {
		check_ajax_referer( 'nonce', 'nonce' );

		// Demo ID
		set_transient( 'atss_importer_demo_id', $_POST['demo_id'] );

		if ( ! isset( $_POST['url'] ) || ! $_POST['url'] ) {
			wp_send_json_error( esc_html__( 'The url address of the demo content is not specified.', 'athemes-starter-sites' ) );
			wp_die();
		}

		$file_url = sanitize_text_field( $_POST['url'] );

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_send_json_error( esc_html__( 'You are not permitted to import widgets.', 'athemes-starter-sites' ) );
			wp_die();
		}

		if ( ! isset( $file_url ) ) {
			wp_send_json_error( esc_html__( 'No widgets WIE file specified.', 'athemes-starter-sites' ) );
			wp_die();
		}

		/**
		 * Process widgets.json.
		 */

		// Get JSON data from widgets.json.
		$raw = wp_remote_get( wp_unslash( $file_url ) );

		// Abort if customizer.json response code is not successful.
		if ( 200 != wp_remote_retrieve_response_code( $raw ) ) {
			wp_send_json_error();
			wp_die();
		}

		// Decode raw JSON string to associative array.
		$data = json_decode( wp_remote_retrieve_body( $raw ) );

		$widgets = new ATSS_Widget_Importer();

		// Import.
		$results = $widgets->import( $data );

		if ( is_wp_error( $results ) ) {
			$error_message = $results->get_error_message();

			wp_send_json_error( $error_message );
			wp_die();
		}

		/**
		 * Action hook.
		 */
		
		 // Get all available widgets site supports.
		$available_widgets = ATSS_Widget_Importer::available_widgets();

		// Get all existing widget instances.
		$widget_instances = array();

		foreach ( $available_widgets as $widget_data ) {
			$widget_instances[ $widget_data['id_base'] ] = get_option( 'widget_' . $widget_data['id_base'] );
		}

		// Sidebar Widgets
		$sidebar_widgets = get_option( 'sidebars_widgets' );

		do_action( 'atss_import_widgets', $sidebar_widgets, $widget_instances );

		/**
		 * Return successful AJAX.
		 */
		wp_send_json_success();
	}

	/**
	 * AJAX callback to import other options from options.json.
	 */
	public function ajax_import_options() {
		check_ajax_referer( 'nonce', 'nonce' );

		if ( ! isset( $_POST['url'] ) || ! $_POST['url'] ) {
			wp_send_json_error( esc_html__( 'The url address of the demo content is not specified.', 'athemes-starter-sites' ) );
			wp_die();
		}

		$file_url = sanitize_text_field( $_POST['url'] );

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_send_json_error( esc_html__( 'You are not permitted to import options.', 'athemes-starter-sites' ) );
			wp_die();
		}

		if ( ! isset( $file_url ) ) {
			wp_send_json_error( esc_html__( 'No options JSON file specified.', 'athemes-starter-sites' ) );
			wp_die();
		}

		/**
		 * Process options.json.
		 */

		// Get JSON data from options.json.
		$raw = wp_remote_get( wp_unslash( $file_url ) );

		// Abort if customizer.json response code is not successful.
		if ( 200 != wp_remote_retrieve_response_code( $raw ) ) {
			wp_send_json_error();
			wp_die();
		}

		// Decode raw JSON string to associative array.
		$array = json_decode( wp_remote_retrieve_body( $raw ), true );

		/**
		 * Import options to DB.
		 */
		foreach ( $array as $key => $value ) {
			// Skip option key with "__" prefix, because it will be treated specifically via the action hook.
			if ( '__' === substr( $key, 0, 2 ) ) {
				continue;
			}

			// Insert to options table.
			update_option( $key, $value );
		}

		/**
		 * Action hook.
		 */
		do_action( 'atss_import_options', $array );

		/**
		 * Return successful AJAX.
		 */
		wp_send_json_success();
	}

	/**
	 * AJAX callback to finish import.
	 */
	public function ajax_import_finish() {

		/**
		 * Action hook.
		 */
		do_action( 'atss_finish_import' );

		/**
		 * Return successful AJAX.
		 */
		wp_send_json_success();
	}
}

new Athemes_Starter_Sites_Import();
