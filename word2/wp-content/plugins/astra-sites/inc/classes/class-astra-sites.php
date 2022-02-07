<?php
/**
 * Astra Sites
 *
 * @since  1.0.0
 * @package Astra Sites
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Sites' ) ) :

	/**
	 * Astra_Sites
	 */
	class Astra_Sites {

		/**
		 * API Domain name
		 *
		 * @var (String) URL
		 */
		public $api_domain;

		/**
		 * API URL which is used to get the response from.
		 *
		 * @since  1.0.0
		 * @var (String) URL
		 */
		public $api_url;

		/**
		 * Search API URL which is used to get the response from.
		 *
		 * @since  2.0.0
		 * @var (String) URL
		 */
		public $search_url;

		/**
		 * API URL which is used to get the response from Pixabay.
		 *
		 * @since  2.0.0
		 * @var (String) URL
		 */
		public $pixabay_url;

		/**
		 * API Key which is used to get the response from Pixabay.
		 *
		 * @since  2.0.0
		 * @var (String) URL
		 */
		public $pixabay_api_key;

		/**
		 * Instance of Astra_Sites
		 *
		 * @since  1.0.0
		 * @var (Object) Astra_Sites
		 */
		private static $instance = null;

		/**
		 * Localization variable
		 *
		 * @since  2.0.0
		 * @var (Array) $local_vars
		 */
		public static $local_vars = array();

		/**
		 * Localization variable
		 *
		 * @since  2.0.0
		 * @var (Array) $wp_upload_url
		 */
		public $wp_upload_url = '';

		/**
		 * Ajax
		 *
		 * @since  2.6.20
		 * @var (Array) $ajax
		 */
		private $ajax = array();

		/**
		 * Instance of Astra_Sites.
		 *
		 * @since  1.0.0
		 *
		 * @return object Class object.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @since  1.0.0
		 */
		private function __construct() {

			$this->set_api_url();

			$this->includes();

			add_action( 'plugin_action_links_' . ASTRA_SITES_BASE, array( $this, 'action_links' ) );
			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 99 );
			add_action( 'wp_enqueue_scripts', array( $this, 'image_search_scripts' ) );
			add_action( 'elementor/editor/footer', array( $this, 'insert_templates' ) );
			add_action( 'admin_footer', array( $this, 'insert_image_templates' ) );
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'insert_image_templates' ) );
			add_action( 'wp_footer', array( $this, 'insert_image_templates_bb_and_brizy' ) );
			add_action( 'elementor/editor/footer', array( $this, 'register_widget_scripts' ), 99 );
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'popup_styles' ) );
			add_action( 'elementor/preview/enqueue_styles', array( $this, 'popup_styles' ) );

			// AJAX.
			$this->ajax = array(
				'astra-required-plugins' => 'required_plugin',
				'astra-required-plugin-activate' => 'required_plugin_activate',
				'astra-sites-backup-settings' => 'backup_settings',
				'astra-sites-set-reset-data' => 'get_reset_data',
				'astra-sites-reset-terms-and-forms' => 'reset_terms_and_forms',
				'astra-sites-reset-posts' => 'reset_posts',
				'astra-sites-activate-theme' => 'activate_theme',
				'astra-sites-create-page' => 'create_page',
				'astra-sites-import-media' => 'import_media',
				'astra-sites-create-template' => 'create_template',
				'astra-sites-create-image' => 'create_image',
				'astra-sites-get-deleted-post-ids' => 'get_deleted_post_ids',
				'astra-sites-search-images' => 'search_images',
				'astra-sites-getting-started-notice' => 'getting_started_notice',
				'astra-sites-favorite' => 'add_to_favorite',
				'astra-sites-api-request' => 'api_request',
				'astra-sites-remote-request' => 'remote_request',
				'astra-page-elementor-batch-process' => 'elementor_batch_process',
				'astra-sites-update-subscription' => 'update_subscription',
				'astra-sites-update-analytics' => 'update_analytics',
			);

			foreach ( $this->ajax as $ajax_hook => $ajax_callback ) {
				add_action( 'wp_ajax_' . $ajax_hook, array( $this, $ajax_callback ) );
			}

			add_action( 'delete_attachment', array( $this, 'delete_astra_images' ) );
			add_filter( 'heartbeat_received', array( $this, 'search_push' ), 10, 2 );
			add_filter( 'status_header', array( $this, 'status_header' ), 10, 4 );
			add_filter( 'wp_php_error_message', array( $this, 'php_error_message' ), 10, 2 );
			add_filter( 'wp_import_post_data_processed', array( $this, 'wp_slash_after_xml_import' ), 99, 2 );
		}

		/**
		 * Add slashes while importing the XML with WordPress Importer v2.
		 *
		 * @param array $postdata Processed Post data.
		 * @param array $data Post data.
		 */
		public function wp_slash_after_xml_import( $postdata, $data ) {
			return wp_slash( $postdata );
		}

		/**
		 * Check is Starter Templates AJAX request.
		 *
		 * @since 2.7.0
		 * @return boolean
		 */
		public function is_starter_templates_request() {

			if ( isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], array_keys( $this->ajax ), true ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				return true;
			}

			return false;
		}

		/**
		 * Filters the message that the default PHP error template displays.
		 *
		 * @since 2.7.0
		 *
		 * @param string $message HTML error message to display.
		 * @param array  $error   Error information retrieved from `error_get_last()`.
		 * @return mixed
		 */
		public function php_error_message( $message, $error ) {

			if ( ! $this->is_starter_templates_request() ) {
				return $message;
			}

			if ( empty( $error ) ) {
				return $message;
			}

			$message = isset( $error['message'] ) ? $error['message'] : $message;

			return $message;
		}

		/**
		 * Filters an HTTP status header.
		 *
		 * @since 2.6.20
		 *
		 * @param string $status_header HTTP status header.
		 * @param int    $code          HTTP status code.
		 * @param string $description   Description for the status code.
		 * @param string $protocol      Server protocol.
		 *
		 * @return mixed
		 */
		public function status_header( $status_header, $code, $description, $protocol ) {

			if ( ! $this->is_starter_templates_request() ) {
				return $status_header;
			}

			$error = error_get_last();
			if ( empty( $error ) ) {
				return $status_header;
			}

			$message = isset( $error['message'] ) ? $error['message'] : $description;

			return "$protocol $code $message";
		}

		/**
		 * Update Analytics Optin/Optout
		 */
		public function update_analytics() {

			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( 'You are not allowed to perform this action', 'astra-sites' );
			}

			$optin_answer = isset( $_POST['data'] ) ? sanitize_text_field( $_POST['data'] ) : 'no';
			$optin_answer = 'yes' === $optin_answer ? 'yes' : 'no';

			update_site_option( 'bsf_analytics_optin', $optin_answer );

			wp_send_json_success();
		}

		/**
		 * Update Subscription
		 */
		public function update_subscription() {

			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( 'You are not allowed to perform this action', 'astra-sites' );
			}

			$arguments = isset( $_POST['data'] ) ? array_map( 'sanitize_text_field', json_decode( stripslashes( $_POST['data'] ), true ) ) : array();

			// Page Builder mapping.
			$page_builder_mapping      = array(
				'Elementor'      => 1,
				'Beaver Builder' => 2,
				'Brizy'          => 3,
				'Gutenberg'      => 4,
			);
			$arguments['PAGE_BUILDER'] = isset( $page_builder_mapping[ $arguments['PAGE_BUILDER'] ] ) ? $page_builder_mapping[ $arguments['PAGE_BUILDER'] ] : '';

			$url = apply_filters( 'astra_sites_subscription_url', $this->api_domain . 'wp-json/starter-templates/v1/subscribe/' );

			$args = array(
				'timeout' => 30,
				'body'    => $arguments,
			);

			$response = wp_remote_post( $url, $args );

			if ( ! is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {
				$response = json_decode( wp_remote_retrieve_body( $response ), true );

				// Successfully subscribed.
				if ( isset( $response['success'] ) && $response['success'] ) {
					update_user_meta( get_current_user_ID(), 'astra-sites-subscribed', 'yes' );
				}
			}
			wp_send_json_success( $response );

		}

		/**
		 * Push Data to Search API.
		 *
		 * @since  2.0.0
		 * @param Object $response Response data object.
		 * @param Object $data Data object.
		 *
		 * @return array Search response.
		 */
		public function search_push( $response, $data ) {

			// If we didn't receive our data, don't send any back.
			if ( empty( $data['ast-sites-search-terms'] ) ) {
				return $response;
			}

			$args = array(
				'timeout'   => 3,
				'blocking'  => true,
				'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
				'body'      => array(
					'search' => $data['ast-sites-search-terms'],
					'builder' => isset( $data['ast-sites-builder'] ) ? $data['ast-sites-builder'] : 'gutenberg',
					'url'    => esc_url( site_url() ),
					'type'   => 'astra-sites',
				),
			);
			$result                             = wp_remote_post( $this->search_url, $args );
			$response['ast-sites-search-terms'] = wp_remote_retrieve_body( $result );

			return $response;
		}

		/**
		 * Before Astra Image delete, remove from options.
		 *
		 * @since  2.0.0
		 * @param int $id ID to deleting image.
		 * @return void
		 */
		public function delete_astra_images( $id ) {

			if ( ! $id ) {
				return;
			}

			// @codingStandardsIgnoreStart
			$saved_images     = get_option( 'astra-sites-saved-images', array() );
			$astra_image_flag = get_post_meta( $id, 'astra-images', true );
			$astra_image_flag = (int) $astra_image_flag;
			if (
				'' !== $astra_image_flag &&
				is_array( $saved_images ) &&
				! empty( $saved_images ) &&
				in_array( $astra_image_flag, $saved_images )
			) {
				$flag_arr = array( $astra_image_flag );
				$saved_images = array_diff( $saved_images, $flag_arr );
				update_option( 'astra-sites-saved-images', $saved_images, 'no' );
			}
			// @codingStandardsIgnoreEnd
		}

		/**
		 * Enqueue Image Search scripts into Beaver Builder Editor.
		 *
		 * @since  2.0.0
		 * @return void
		 */
		public function image_search_scripts() {

			if (
				class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() // BB Builder is on?
				||
				(
					class_exists( 'Brizy_Editor_Post' ) && // Brizy Builder is on?
					( isset( $_GET['brizy-edit'] ) || isset( $_GET['brizy-edit-iframe'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				)
				||
				is_customize_preview() // Is customizer on?
			) {
				// Image Search assets.
				$this->image_search_assets();
			}
		}

		/**
		 * Elementor Batch Process via AJAX
		 *
		 * @since 2.0.0
		 */
		public function elementor_batch_process() {

			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
			}

			$api_url = isset( $_POST['url'] ) ? esc_url_raw( $_POST['url'] ) : '';

			if ( ! astra_sites_is_valid_url( $api_url ) ) {
				wp_send_json_error( __( 'Invalid API URL.', 'astra-sites' ) );
			}

			$response = wp_remote_get( $api_url );

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( wp_remote_retrieve_body( $response ) );
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );
			if ( ! isset( $data['post-meta']['_elementor_data'] ) ) {
				wp_send_json_error( __( 'Invalid Post Meta', 'astra-sites' ) );
			}

			$meta    = json_decode( $data['post-meta']['_elementor_data'], true );
			$post_id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : '';

			if ( empty( $post_id ) || empty( $meta ) ) {
				wp_send_json_error( __( 'Invalid Post ID or Elementor Meta', 'astra-sites' ) );
			}

			if ( isset( $data['astra-page-options-data'] ) && isset( $data['astra-page-options-data']['elementor_load_fa4_shim'] ) ) {
				update_option( 'elementor_load_fa4_shim', $data['astra-page-options-data']['elementor_load_fa4_shim'] );
			}

			$import      = new \Elementor\TemplateLibrary\Astra_Sites_Elementor_Pages();
			$import_data = $import->import( $post_id, $meta );

			wp_send_json_success( $import_data );
		}

		/**
		 * Elementor Templates Request
		 *
		 * @since 2.7.3
		 */
		public function remote_request() {

			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
			}

			$api_url = isset( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : '';

			$api_url = add_query_arg( astra_sites_get_api_params(), $api_url );

			$response = wp_remote_get( $api_url );

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( wp_remote_retrieve_body( $response ) );
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			wp_send_json_success( $data );
		}

		/**
		 * API Request
		 *
		 * @since 2.0.0
		 */
		public function api_request() {

			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			$url = isset( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

			if ( empty( $url ) ) {
				wp_send_json_error(
					array(
						'message' => __( 'Provided API URL is empty! Please try again!', 'astra-sites' ),
						'code'    => 'Error',
					)
				);
			}

			$api_args = apply_filters(
				'astra_sites_api_params', array(
					'template_status' => '',
				)
			);

			$api_url = add_query_arg( $api_args, trailingslashit( self::get_instance()->get_api_domain() ) . 'wp-json/wp/v2/' . $url );

			if ( ! astra_sites_is_valid_url( $api_url ) ) {
				wp_send_json_error(
					array(
						/* Translators: %s is API URL. */
						'message' => sprintf( __( 'Invalid Request URL - %s', 'astra-sites' ), $api_url ),
						'code'    => 'Error',
					)
				);
			}

			Astra_Sites_Error_Handler::get_instance()->start_error_handler();

			$api_args = apply_filters(
				'astra_sites_api_args', array(
					'timeout' => 30,
				)
			);

			$request = wp_remote_get( $api_url, $api_args );

			Astra_Sites_Error_Handler::get_instance()->stop_error_handler();

			if ( is_wp_error( $request ) ) {
				$wp_error_code = $request->get_error_code();
				switch ( $wp_error_code ) {
					case 'http_request_not_executed':
						/* translators: %s Error Message */
						$message = sprintf( __( 'API Request could not be performed - %s', 'astra-sites' ), $request->get_error_message() );
						break;
					case 'http_request_failed':
					default:
						/* translators: %s Error Message */
						$message = sprintf( __( 'API Request has failed - %s', 'astra-sites' ), $request->get_error_message() );
						break;
				}

				wp_send_json_error(
					array(
						'message'       => $request->get_error_message(),
						'code'          => 'WP_Error',
						'response_code' => $wp_error_code,
					)
				);
			}

			$code      = (int) wp_remote_retrieve_response_code( $request );
			$demo_data = json_decode( wp_remote_retrieve_body( $request ), true );

			if ( 200 === $code ) {
				update_option( 'astra_sites_import_data', $demo_data, 'no' );
				wp_send_json_success( $demo_data );
			}

			$message       = wp_remote_retrieve_body( $request );
			$response_code = $code;

			if ( 200 !== $code && is_array( $demo_data ) && isset( $demo_data['code'] ) ) {
				$message = $demo_data['message'];
			}

			if ( 500 === $code ) {
				$message = __( 'Internal Server Error.', 'astra-sites' );
			}

			if ( 200 !== $code && false !== strpos( $message, 'Cloudflare' ) ) {
				$ip = Astra_Sites_Helper::get_client_ip();
				/* translators: %s IP address. */
				$message = sprintf( __( 'Client IP: %1$s </br> Error code: %2$s', 'astra-sites' ), $ip, $code );
				$code    = 'Cloudflare';
			}

			wp_send_json_error(
				array(
					'message'       => $message,
					'code'          => $code,
					'response_code' => $response_code,
				)
			);
		}

		/**
		 * Insert Template
		 *
		 * @return void
		 */
		public function insert_image_templates() {
			ob_start();
			require_once ASTRA_SITES_DIR . 'inc/includes/image-templates.php';
			ob_end_flush();
		}

		/**
		 * Insert Template
		 *
		 * @return void
		 */
		public function insert_image_templates_bb_and_brizy() {

			if (
				class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() // BB Builder is on?
				||
				(
					class_exists( 'Brizy_Editor_Post' ) && // Brizy Builder is on?
					( isset( $_GET['brizy-edit'] ) || isset( $_GET['brizy-edit-iframe'] ) ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				)
			) {
				// Image Search Templates.
				ob_start();
				require_once ASTRA_SITES_DIR . 'inc/includes/image-templates.php';
				ob_end_flush();
			}
		}

		/**
		 * Insert Template
		 *
		 * @return void
		 */
		public function insert_templates() {
			ob_start();
			require_once ASTRA_SITES_DIR . 'inc/includes/templates.php';
			require_once ASTRA_SITES_DIR . 'inc/includes/image-templates.php';
			ob_end_flush();
		}

		/**
		 * Add/Remove Favorite.
		 *
		 * @since  2.0.0
		 */
		public function add_to_favorite() {

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( 'You are not allowed to perform this action', 'astra-sites' );
			}

			$new_favorites = array();
			$site_id       = isset( $_POST['site_id'] ) ? sanitize_key( $_POST['site_id'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

			if ( empty( $site_id ) ) {
				wp_send_json_error();
			}

			$favorite_settings = get_option( 'astra-sites-favorites', array() );

			if ( false !== $favorite_settings && is_array( $favorite_settings ) ) {
				$new_favorites = $favorite_settings;
			}

			if ( 'false' === $_POST['is_favorite'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
				if ( in_array( $site_id, $new_favorites, true ) ) {
					$key = array_search( $site_id, $new_favorites, true );
					unset( $new_favorites[ $key ] );
				}
			} else {
				if ( ! in_array( $site_id, $new_favorites, true ) ) {
					array_push( $new_favorites, $site_id );
				}
			}

			update_option( 'astra-sites-favorites', $new_favorites, 'no' );

			wp_send_json_success(
				array(
					'all_favorites' => $new_favorites,
				)
			);
		}

		/**
		 * Import Template.
		 *
		 * @since  2.0.0
		 */
		public function create_template() {

			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'customize' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
			}

			$content = isset( $_POST['data']['content']['rendered'] ) ? $_POST['data']['content']['rendered'] : '';

			$data = isset( $_POST['data'] ) ? $_POST['data'] : array();

			if ( empty( $data ) ) {
				wp_send_json_error( 'Empty page data.' );
			}

			$page_id = isset( $_POST['data']['id'] ) ? $_POST['data']['id'] : '';

			$title = '';
			if ( isset( $_POST['data']['title']['rendered'] ) ) {
				if ( '' !== $_POST['title'] ) {
					$title = $_POST['title'] . ' - ' . $_POST['data']['title']['rendered'];
				} else {
					$title = $_POST['data']['title']['rendered'];
				}
			}

			$excerpt = isset( $_POST['data']['excerpt']['rendered'] ) ? $_POST['data']['excerpt']['rendered'] : '';

			$post_args = array(
				'post_type'    => 'elementor_library',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_content' => $content,
				'post_excerpt' => $excerpt,
			);

			$new_page_id = wp_insert_post( $post_args );
			update_post_meta( $new_page_id, '_astra_sites_enable_for_batch', true );
			$post_meta = isset( $_POST['data']['post-meta'] ) ? $_POST['data']['post-meta'] : array();

			if ( ! empty( $post_meta ) ) {
				$this->import_template_meta( $new_page_id, $post_meta );
			}

			if ( 'pages' === $_POST['type'] ) {
				update_post_meta( $new_page_id, '_elementor_template_type', 'page' );
				wp_set_object_terms( $new_page_id, 'page', 'elementor_library_type' );
			} else {
				update_post_meta( $new_page_id, '_elementor_template_type', 'section' );
				wp_set_object_terms( $new_page_id, 'section', 'elementor_library_type' );
			}

			update_post_meta( $new_page_id, '_wp_page_template', 'elementor_header_footer' );

			do_action( 'astra_sites_process_single', $new_page_id );

			wp_send_json_success(
				array(
					'remove-page-id' => $page_id,
					'id'             => $new_page_id,
					'link'           => get_permalink( $new_page_id ),
				)
			);
		}

		/**
		 * Import Birzy Media.
		 *
		 * @since  2.0.0
		 */
		public function import_media() {

			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			$image_data = isset( $_POST['media'] ) ? $_POST['media'] : array();

			if ( empty( $image_data ) ) {
				wp_send_json_error();
			}

			$image            = array(
				'url' => $image_data['url'],
				'id'  => $image_data['id'],
			);
			$downloaded_image = Astra_Sites_Image_Importer::get_instance()->import( $image );

			// Set meta data.
			if ( isset( $image_data['meta'] ) && ! empty( $image_data['meta'] ) ) {
				foreach ( $image_data['meta'] as $meta_key => $meta_value ) {
					update_post_meta( $downloaded_image['id'], $meta_key, $meta_value );
				}
			}

			wp_send_json_success();
		}

		/**
		 * Import Page.
		 *
		 * @since  2.0.0
		 */
		public function create_page() {

			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'customize' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
			}

			$default_page_builder = Astra_Sites_Page::get_instance()->get_setting( 'page_builder' );

			$content = isset( $_POST['data']['original_content'] ) ? $_POST['data']['original_content'] : ( isset( $_POST['data']['content']['rendered'] ) ? $_POST['data']['content']['rendered'] : '' );

			if ( 'elementor' === $default_page_builder ) {
				if ( isset( $_POST['data']['astra-page-options-data'] ) && isset( $_POST['data']['astra-page-options-data']['elementor_load_fa4_shim'] ) ) {
					update_option( 'elementor_load_fa4_shim', $_POST['data']['astra-page-options-data']['elementor_load_fa4_shim'] );
				}
			}

			$data = isset( $_POST['data'] ) ? $_POST['data'] : array();

			if ( empty( $data ) ) {
				wp_send_json_error( 'Empty page data.' );
			}

			$page_id = isset( $_POST['data']['id'] ) ? $_POST['data']['id'] : '';
			$title   = isset( $_POST['data']['title']['rendered'] ) ? $_POST['data']['title']['rendered'] : '';
			$excerpt = isset( $_POST['data']['excerpt']['rendered'] ) ? $_POST['data']['excerpt']['rendered'] : '';

			$post_args = array(
				'post_type'    => 'page',
				'post_status'  => 'draft',
				'post_title'   => $title,
				'post_content' => $content,
				'post_excerpt' => $excerpt,
			);

			$new_page_id = wp_insert_post( $post_args );
			update_post_meta( $new_page_id, '_astra_sites_enable_for_batch', true );

			$post_meta = isset( $_POST['data']['post-meta'] ) ? $_POST['data']['post-meta'] : array();

			if ( ! empty( $post_meta ) ) {
				$this->import_post_meta( $new_page_id, $post_meta );
			}

			if ( isset( $_POST['data']['astra-page-options-data'] ) && ! empty( $_POST['data']['astra-page-options-data'] ) ) {

				foreach ( $_POST['data']['astra-page-options-data'] as $option => $value ) {
					update_option( $option, $value );
				}
			}

			if ( 'elementor' === $default_page_builder ) {
				update_post_meta( $new_page_id, '_wp_page_template', 'elementor_header_footer' );
			}

			do_action( 'astra_sites_process_single', $new_page_id );

			wp_send_json_success(
				array(
					'remove-page-id' => $page_id,
					'id'             => $new_page_id,
					'link'           => get_permalink( $new_page_id ),
				)
			);
		}

		/**
		 * Search Images.
		 *
		 * @since 2.7.3.
		 */
		public function search_images() {
			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'upload_files' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
			}

			$params = isset( $_POST['params'] ) ? array_map( 'sanitize_text_field', $_POST['params'] ) : array();

			$params['key'] = $this->pixabay_api_key;

			$api_url = add_query_arg( $params, $this->pixabay_url );

			$response = wp_remote_get( $api_url );

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( wp_remote_retrieve_body( $response ) );
			}

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );

			wp_send_json_success( $data );
		}

		/**
		 * Download and save the image in the media library.
		 *
		 * @since  2.0.0
		 */
		public function create_image() {
			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'upload_files' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
			}

			$url      = isset( $_POST['url'] ) ? esc_url_raw( $_POST['url'] ) : false;
			$name     = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : false;
			$photo_id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

			if ( false === $url ) {
				wp_send_json_error( __( 'Need to send URL of the image to be downloaded', 'astra-sites' ) );
			}

			$image  = '';
			$result = array();

			$name  = preg_replace( '/\.[^.]+$/', '', $name ) . '-' . $photo_id . '.jpg';
			$image = $this->create_image_from_url( $url, $name, $photo_id );

			if ( is_wp_error( $image ) ) {
				wp_send_json_error( $image );
			}

			if ( 0 !== $image ) {
				$result['attachmentData'] = wp_prepare_attachment_for_js( $image );
				if ( did_action( 'elementor/loaded' ) ) {
					$result['data'] = Astra_Sites_Elementor_Images::get_instance()->get_attachment_data( $image );
				}
				if ( 0 === $photo_id ) {
					/**
					 * This flag ensures these files are deleted in the Reset Process.
					 */
					update_post_meta( $image, '_astra_sites_imported_post', true );
				}
			} else {
				wp_send_json_error( __( 'Could not download the image.', 'astra-sites' ) );
			}

			// Save downloaded image reference to an option.
			if ( 0 !== $photo_id ) {
				$saved_images = get_option( 'astra-sites-saved-images', array() );

				if ( empty( $saved_images ) || false === $saved_images ) {
					$saved_images = array();
				}

				$saved_images[] = $photo_id;
				update_option( 'astra-sites-saved-images', $saved_images, 'no' );
			}

			$result['updated-saved-images'] = get_option( 'astra-sites-saved-images', array() );

			wp_send_json_success( $result );
		}

		/**
		 * Set the upload directory
		 */
		public function get_wp_upload_url() {
			$wp_upload_dir = wp_upload_dir();
			return isset( $wp_upload_dir['url'] ) ? $wp_upload_dir['url'] : false;
		}

		/**
		 * Create the image and return the new media upload id.
		 *
		 * @param String $url URL to pixabay image.
		 * @param String $name Name to pixabay image.
		 * @param String $photo_id Photo ID to pixabay image.
		 * @see http://codex.wordpress.org/Function_Reference/wp_insert_attachment#Example
		 */
		public function create_image_from_url( $url, $name, $photo_id ) {
			$file_array         = array();
			$file_array['name'] = wp_basename( $name );

			// Download file to temp location.
			$file_array['tmp_name'] = download_url( $url );

			// If error storing temporarily, return the error.
			if ( is_wp_error( $file_array['tmp_name'] ) ) {
				return $file_array;
			}

			// Do the validation and storage stuff.
			$id = media_handle_sideload( $file_array, 0, null );

			// If error storing permanently, unlink.
			if ( is_wp_error( $id ) ) {
				@unlink( $file_array['tmp_name'] ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
				return $id;
			}

			// Store the original attachment source in meta.
			add_post_meta( $id, '_source_url', $url );

			update_post_meta( $id, 'astra-images', $photo_id );
			update_post_meta( $id, '_wp_attachment_image_alt', $name );

			return $id;
		}

		/**
		 * Import Post Meta
		 *
		 * @since 2.0.0
		 *
		 * @param  integer $post_id  Post ID.
		 * @param  array   $metadata  Post meta.
		 * @return void
		 */
		public function import_post_meta( $post_id, $metadata ) {

			$metadata = (array) $metadata;

			foreach ( $metadata as $meta_key => $meta_value ) {

				if ( $meta_value ) {

					if ( '_elementor_data' === $meta_key ) {

						$raw_data = json_decode( stripslashes( $meta_value ), true );

						if ( is_array( $raw_data ) ) {
							$raw_data = wp_slash( wp_json_encode( $raw_data ) );
						} else {
							$raw_data = wp_slash( $raw_data );
						}
					} else {

						if ( is_serialized( $meta_value, true ) ) {
							$raw_data = maybe_unserialize( stripslashes( $meta_value ) );
						} elseif ( is_array( $meta_value ) ) {
							$raw_data = json_decode( stripslashes( $meta_value ), true );
						} else {
							$raw_data = $meta_value;
						}
					}

					update_post_meta( $post_id, $meta_key, $raw_data );
				}
			}
		}

		/**
		 * Import Post Meta
		 *
		 * @since 2.0.0
		 *
		 * @param  integer $post_id  Post ID.
		 * @param  array   $metadata  Post meta.
		 * @return void
		 */
		public function import_template_meta( $post_id, $metadata ) {

			$metadata = (array) $metadata;

			foreach ( $metadata as $meta_key => $meta_value ) {

				if ( $meta_value ) {

					if ( '_elementor_data' === $meta_key ) {

						$raw_data = json_decode( stripslashes( $meta_value ), true );

						if ( is_array( $raw_data ) ) {
							$raw_data = wp_slash( wp_json_encode( $raw_data ) );
						} else {
							$raw_data = wp_slash( $raw_data );
						}
					} else {

						if ( is_serialized( $meta_value, true ) ) {
							$raw_data = maybe_unserialize( stripslashes( $meta_value ) );
						} elseif ( is_array( $meta_value ) ) {
							$raw_data = json_decode( stripslashes( $meta_value ), true );
						} else {
							$raw_data = $meta_value;
						}
					}

					update_post_meta( $post_id, $meta_key, $raw_data );
				}
			}
		}

		/**
		 * Close getting started notice for current user
		 *
		 * @since 1.3.5
		 * @return void
		 */
		public function getting_started_notice() {
			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'customize' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
			}

			update_option( '_astra_sites_gettings_started', 'yes', 'no' );
			wp_send_json_success();
		}

		/**
		 * Activate theme
		 *
		 * @since 1.3.2
		 * @return void
		 */
		public function activate_theme() {

			// Verify Nonce.
			check_ajax_referer( 'astra-sites', '_ajax_nonce' );

			if ( ! current_user_can( 'customize' ) ) {
				wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
			}

			Astra_Sites_Error_Handler::get_instance()->start_error_handler();

			switch_theme( 'astra' );

			Astra_Sites_Error_Handler::get_instance()->stop_error_handler();

			wp_send_json_success(
				array(
					'success' => true,
					'message' => __( 'Theme Activated', 'astra-sites' ),
				)
			);
		}

		/**
		 * Reset terms and forms.
		 *
		 * @since 3.0.3
		 */
		public function reset_terms_and_forms() {
			if ( wp_doing_ajax() ) {
				check_ajax_referer( 'astra-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
				}
			}

			Astra_Sites_Error_Handler::get_instance()->start_error_handler();

			$terms = astra_sites_get_reset_term_data();

			if ( ! empty( $terms ) ) {
				foreach ( $terms as $key => $term_id ) {
					$term_id = absint( $term_id );
					if ( $term_id ) {
						$term = get_term( $term_id );
						if ( ! is_wp_error( $term ) && ! empty( $term ) && is_object( $term ) ) {

							do_action( 'astra_sites_before_delete_imported_terms', $term_id, $term );

							$message = 'Deleted - Term ' . $term_id . ' - ' . $term->name . ' ' . $term->taxonomy;
							Astra_Sites_Importer_Log::add( $message );
							wp_delete_term( $term_id, $term->taxonomy );
						}
					}
				}
			}

			$forms = astra_sites_get_reset_form_data();

			if ( ! empty( $forms ) ) {
				foreach ( $forms as $key => $post_id ) {
					$post_id = absint( $post_id );
					if ( $post_id ) {

						do_action( 'astra_sites_before_delete_imported_wp_forms', $post_id );

						$message = 'Deleted - Form ID ' . $post_id . ' - ' . get_post_type( $post_id ) . ' - ' . get_the_title( $post_id );
						Astra_Sites_Importer_Log::add( $message );
						wp_delete_post( $post_id, true );
					}
				}
			}

			Astra_Sites_Error_Handler::get_instance()->stop_error_handler();

			if ( wp_doing_ajax() ) {
				wp_send_json_success();
			}
		}

		/**
		 * Reset posts in chunks.
		 *
		 * @since 3.0.8
		 */
		public function reset_posts() {
			if ( wp_doing_ajax() ) {
				check_ajax_referer( 'astra-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
				}
			}

			Astra_Sites_Error_Handler::get_instance()->start_error_handler();

			// Suspend bunches of stuff in WP core.
			wp_defer_term_counting( true );
			wp_defer_comment_counting( true );
			wp_suspend_cache_invalidation( true );

			$all_ids = ( isset( $_POST['ids'] ) ) ? $_POST['ids'] : '';

			$posts = json_decode( stripslashes( $_POST['ids'] ), true );

			if ( ! empty( $posts ) ) {
				foreach ( $posts as $key => $post_id ) {
					$post_id = absint( $post_id );
					if ( $post_id ) {
						$post_type = get_post_type( $post_id );
						$message   = 'Deleted - Post ID ' . $post_id . ' - ' . $post_type . ' - ' . get_the_title( $post_id );

						do_action( 'astra_sites_before_delete_imported_posts', $post_id, $post_type );

						Astra_Sites_Importer_Log::add( $message );
						wp_delete_post( $post_id, true );
					}
				}
			}

			// Re-enable stuff in core.
			wp_suspend_cache_invalidation( false );
			wp_cache_flush();
			foreach ( get_taxonomies() as $tax ) {
				delete_option( "{$tax}_children" );
				_get_term_hierarchy( $tax );
			}

			wp_defer_term_counting( false );
			wp_defer_comment_counting( false );

			Astra_Sites_Error_Handler::get_instance()->stop_error_handler();

			if ( wp_doing_ajax() ) {
				wp_send_json_success();
			}
		}

		/**
		 * Get post IDs to be deleted.
		 */
		public function get_deleted_post_ids() {
			if ( wp_doing_ajax() ) {
				check_ajax_referer( 'astra-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
				}
			}
			wp_send_json_success( astra_sites_get_reset_post_data() );
		}

		/**
		 * Set reset data
		 * Note: This function can be deleted after a few releases since we are performing the delete operation in chunks.
		 */
		public function get_reset_data() {

			if ( wp_doing_ajax() ) {
				check_ajax_referer( 'astra-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_send_json_error( __( 'You are not allowed to perform this action', 'astra-sites' ) );
				}
			}

			Astra_Sites_Error_Handler::get_instance()->start_error_handler();

			$data = array(
				'reset_posts'    => astra_sites_get_reset_post_data(),
				'reset_wp_forms' => astra_sites_get_reset_form_data(),
				'reset_terms'    => astra_sites_get_reset_term_data(),
			);

			Astra_Sites_Error_Handler::get_instance()->stop_error_handler();

			if ( wp_doing_ajax() ) {
				wp_send_json_success( $data );
			}

			return $data;
		}

		/**
		 * Backup our existing settings.
		 */
		public function backup_settings() {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'astra-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_send_json_error( __( 'User does not have permission!', 'astra-sites' ) );
				}
			}

			$file_name    = 'astra-sites-backup-' . gmdate( 'd-M-Y-h-i-s' ) . '.json';
			$old_settings = get_option( 'astra-settings', array() );
			$upload_dir   = Astra_Sites_Importer_Log::get_instance()->log_dir();
			$upload_path  = trailingslashit( $upload_dir['path'] );
			$log_file     = $upload_path . $file_name;
			$file_system  = self::get_instance()->get_filesystem();

			// If file system fails? Then take a backup in site option.
			if ( false === $file_system->put_contents( $log_file, wp_json_encode( $old_settings ), FS_CHMOD_FILE ) ) {
				update_option( 'astra_sites_' . $file_name, $old_settings, 'no' );
			}

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'File generated at ' . $log_file );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success();
			}
		}

		/**
		 * Get theme install, active or inactive status.
		 *
		 * @since 1.3.2
		 *
		 * @return string Theme status
		 */
		public function get_theme_status() {

			$theme = wp_get_theme();

			// Theme installed and activate.
			if ( 'Astra' === $theme->name || 'Astra' === $theme->parent_theme ) {
				return 'installed-and-active';
			}

			// Theme installed but not activate.
			foreach ( (array) wp_get_themes() as $theme_dir => $theme ) {
				if ( 'Astra' === $theme->name || 'Astra' === $theme->parent_theme ) {
					return 'installed-but-inactive';
				}
			}

			return 'not-installed';
		}

		/**
		 * Loads textdomain for the plugin.
		 *
		 * @since 1.0.1
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'astra-sites' );
		}

		/**
		 * Show action links on the plugin screen.
		 *
		 * @param   mixed $links Plugin Action links.
		 * @return  array
		 */
		public function action_links( $links ) {

			$arguments = array(
				'page' => 'starter-templates',
			);

			$url = add_query_arg( $arguments, admin_url( 'themes.php' ) );

			$action_links = array(
				'settings' => '<a href="' . esc_url( $url ) . '" aria-label="' . esc_attr__( 'See Library', 'astra-sites' ) . '">' . esc_html__( 'See Library', 'astra-sites' ) . '</a>',
			);

			return array_merge( $action_links, $links );
		}

		/**
		 * Get the API URL.
		 *
		 * @since  1.0.0
		 */
		public static function get_api_domain() {
			return defined( 'STARTER_TEMPLATES_REMOTE_URL' ) ? STARTER_TEMPLATES_REMOTE_URL : apply_filters( 'astra_sites_api_domain', 'https://websitedemos.net/' );
		}

		/**
		 * Setter for $api_url
		 *
		 * @since  1.0.0
		 */
		public function set_api_url() {
			$this->api_domain = trailingslashit( self::get_api_domain() );
			$this->api_url    = apply_filters( 'astra_sites_api_url', $this->api_domain . 'wp-json/wp/v2/' );

			$this->search_url = apply_filters( 'astra_sites_search_api_url', $this->api_domain . 'wp-json/analytics/v2/search/' );

			$this->pixabay_url     = 'https://pixabay.com/api/';
			$this->pixabay_api_key = '2727911-c4d7c1031949c7e0411d7e81e';
		}

		/**
		 * Enqueue Image Search scripts.
		 *
		 * @since  2.0.0
		 * @return void
		 */
		public function image_search_assets() {

			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'imagesloaded' );

			wp_enqueue_script(
				'astra-sites-images-common',
				ASTRA_SITES_URI . 'inc/assets/js/common.js',
				array( 'jquery', 'wp-util' ), // Dependencies, defined above.
				ASTRA_SITES_VER,
				true
			);

			$data = apply_filters(
				'astra_sites_images_common',
				array(
					'ajaxurl'             => esc_url( admin_url( 'admin-ajax.php' ) ),
					'asyncurl'            => esc_url( admin_url( 'async-upload.php' ) ),
					'is_bb_active'        => ( class_exists( 'FLBuilderModel' ) ),
					'is_brizy_active'     => ( class_exists( 'Brizy_Editor_Post' ) ),
					'is_elementor_active' => ( did_action( 'elementor/loaded' ) ),
					'is_elementor_editor' => ( did_action( 'elementor/loaded' ) ) ? Elementor\Plugin::instance()->editor->is_edit_mode() : false,
					'is_bb_editor'        => ( class_exists( 'FLBuilderModel' ) ) ? ( FLBuilderModel::is_builder_active() ) : false,
					'is_brizy_editor'     => ( class_exists( 'Brizy_Editor_Post' ) ) ? ( isset( $_GET['brizy-edit'] ) || isset( $_GET['brizy-edit-iframe'] ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					'saved_images'        => get_option( 'astra-sites-saved-images', array() ),
					'pixabay_category'    => array(
						'all'            => __( 'All', 'astra-sites' ),
						'animals'        => __( 'Animals', 'astra-sites' ),
						'buildings'      => __( 'Architecture/Buildings', 'astra-sites' ),
						'backgrounds'    => __( 'Backgrounds/Textures', 'astra-sites' ),
						'fashion'        => __( 'Beauty/Fashion', 'astra-sites' ),
						'business'       => __( 'Business/Finance', 'astra-sites' ),
						'computer'       => __( 'Computer/Communication', 'astra-sites' ),
						'education'      => __( 'Education', 'astra-sites' ),
						'feelings'       => __( 'Emotions', 'astra-sites' ),
						'food'           => __( 'Food/Drink', 'astra-sites' ),
						'health'         => __( 'Health/Medical', 'astra-sites' ),
						'industry'       => __( 'Industry/Craft', 'astra-sites' ),
						'music'          => __( 'Music', 'astra-sites' ),
						'nature'         => __( 'Nature/Landscapes', 'astra-sites' ),
						'people'         => __( 'People', 'astra-sites' ),
						'places'         => __( 'Places/Monuments', 'astra-sites' ),
						'religion'       => __( 'Religion', 'astra-sites' ),
						'science'        => __( 'Science/Technology', 'astra-sites' ),
						'sports'         => __( 'Sports', 'astra-sites' ),
						'transportation' => __( 'Transportation/Traffic', 'astra-sites' ),
						'travel'         => __( 'Travel/Vacation', 'astra-sites' ),
					),
					'pixabay_order'       => array(
						'popular'  => __( 'Popular', 'astra-sites' ),
						'latest'   => __( 'Latest', 'astra-sites' ),
						'upcoming' => __( 'Upcoming', 'astra-sites' ),
						'ec'       => __( 'Editor\'s Choice', 'astra-sites' ),
					),
					'pixabay_orientation' => array(
						'any'        => __( 'Any Orientation', 'astra-sites' ),
						'vertical'   => __( 'Vertical', 'astra-sites' ),
						'horizontal' => __( 'Horizontal', 'astra-sites' ),
					),
					'title'               => __( 'Free Images', 'astra-sites' ),
					'search_placeholder'  => __( 'Search - Ex: flowers', 'astra-sites' ),
					'downloading'         => __( 'Downloading...', 'astra-sites' ),
					'validating'          => __( 'Validating...', 'astra-sites' ),
					'empty_api_key'       => __( 'Please enter an API key.', 'astra-sites' ),
					'error_api_key'       => __( 'An error occured with code ', 'astra-sites' ),
					'_ajax_nonce'         => wp_create_nonce( 'astra-sites' ),
				)
			);
			wp_localize_script( 'astra-sites-images-common', 'astraImages', $data );

			wp_enqueue_script(
				'astra-sites-images-script',
				ASTRA_SITES_URI . 'inc/assets/js/dist/main.js',
				array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-api-fetch', 'astra-sites-images-common' ), // Dependencies, defined above.
				ASTRA_SITES_VER,
				true
			);

			wp_enqueue_style( 'astra-sites-images', ASTRA_SITES_URI . 'inc/assets/css/images.css', ASTRA_SITES_VER, true );
			wp_style_add_data( 'astra-sites-images', 'rtl', 'replace' );
		}

		/**
		 * Getter for $api_url
		 *
		 * @since  1.0.0
		 */
		public function get_api_url() {
			return $this->api_url;
		}

		/**
		 * Enqueue admin scripts.
		 *
		 * @since  1.3.2    Added 'install-theme.js' to install and activate theme.
		 * @since  1.0.5    Added 'getUpgradeText' and 'getUpgradeURL' localize variables.
		 *
		 * @since  1.0.0
		 *
		 * @param  string $hook Current hook name.
		 * @return void
		 */
		public function admin_enqueue( $hook = '' ) {

			// Image Search assets.
			if ( 'post-new.php' === $hook || 'post.php' === $hook || 'widgets.php' === $hook ) {
				$this->image_search_assets();
			}

			// Avoid scripts from customizer.
			if ( is_customize_preview() ) {
				return;
			}

			wp_enqueue_script( 'astra-sites-install-theme', ASTRA_SITES_URI . 'inc/assets/js/install-theme.js', array( 'jquery', 'updates' ), ASTRA_SITES_VER, true );
			wp_enqueue_style( 'astra-sites-install-theme', ASTRA_SITES_URI . 'inc/assets/css/install-theme.css', null, ASTRA_SITES_VER, 'all' );
			wp_style_add_data( 'astra-sites-install-theme', 'rtl', 'replace' );

			$data = apply_filters(
				'astra_sites_install_theme_localize_vars',
				array(
					'installed'   => __( 'Installed! Activating..', 'astra-sites' ),
					'activating'  => __( 'Activating...', 'astra-sites' ),
					'activated'   => __( 'Activated!', 'astra-sites' ),
					'installing'  => __( 'Installing...', 'astra-sites' ),
					'ajaxurl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
					'_ajax_nonce' => wp_create_nonce( 'astra-sites' ),
				)
			);
			wp_localize_script( 'astra-sites-install-theme', 'AstraSitesInstallThemeVars', $data );

			if ( 'appearance_page_starter-templates' !== $hook ) {
				return;
			}

			global $is_IE, $is_edge;

			if ( $is_IE || $is_edge ) {
				wp_enqueue_script( 'astra-sites-eventsource', ASTRA_SITES_URI . 'inc/assets/js/eventsource.min.js', array( 'jquery', 'wp-util', 'updates' ), ASTRA_SITES_VER, true );
			}

			// Fetch.
			wp_register_script( 'astra-sites-fetch', ASTRA_SITES_URI . 'inc/assets/js/fetch.umd.js', array( 'jquery' ), ASTRA_SITES_VER, true );

			// History.
			wp_register_script( 'astra-sites-history', ASTRA_SITES_URI . 'inc/assets/js/history.js', array( 'jquery' ), ASTRA_SITES_VER, true );

			// Admin Page.
			wp_enqueue_style( 'astra-sites-admin', ASTRA_SITES_URI . 'inc/assets/css/admin.css', ASTRA_SITES_VER, true );
			wp_style_add_data( 'astra-sites-admin', 'rtl', 'replace' );

			$data = $this->get_local_vars();
		}

		/**
		 * Get CTA link
		 *
		 * @param string $source    The source of the link.
		 * @param string $medium    The medium of the link.
		 * @param string $campaign  The campaign of the link.
		 * @return array
		 */
		public function get_cta_link( $source = '', $medium = '', $campaign = '' ) {
			$default_page_builder = Astra_Sites_Page::get_instance()->get_setting( 'page_builder' );
			$cta_links = $this->get_cta_links( $source, $medium, $campaign );
			return isset( $cta_links[ $default_page_builder ] ) ? $cta_links[ $default_page_builder ] : 'https://wpastra.com/starter-templates-plans/?utm_source=StarterTemplatesPlugin&utm_campaign=WPAdmin';
		}

		/**
		 * Get CTA Links
		 *
		 * @since 2.6.18
		 *
		 * @param string $source    The source of the link.
		 * @param string $medium    The medium of the link.
		 * @param string $campaign  The campaign of the link.
		 * @return array
		 */
		public function get_cta_links( $source = '', $medium = '', $campaign = '' ) {
			return array(
				'elementor' => add_query_arg(
					array(
						'utm_source' => ! empty( $source ) ? $source : 'elementor-templates',
						'utm_medium' => 'dashboard',
						'utm_campaign' => 'Starter-Template-Backend',
					), 'https://wpastra.com/elementor-starter-templates/'
				),
				'beaver-builder' => add_query_arg(
					array(
						'utm_source' => ! empty( $source ) ? $source : 'beaver-templates',
						'utm_medium' => 'dashboard',
						'utm_campaign' => 'Starter-Template-Backend',
					), 'https://wpastra.com/beaver-builder-starter-templates/'
				),
				'gutenberg' => add_query_arg(
					array(
						'utm_source' => ! empty( $source ) ? $source : 'gutenberg-templates',
						'utm_medium' => 'dashboard',
						'utm_campaign' => 'Starter-Template-Backend',
					), 'https://wpastra.com/starter-templates-plans/'
				),
				'brizy' => add_query_arg(
					array(
						'utm_source' => ! empty( $source ) ? $source : 'brizy-templates',
						'utm_medium' => 'dashboard',
						'utm_campaign' => 'Starter-Template-Backend',
					), 'https://wpastra.com/starter-templates-plans/'
				),
			);
		}

		/**
		 * Returns Localization Variables.
		 *
		 * @since 2.0.0
		 */
		public function get_local_vars() {

			$stored_data = array(
				'astra-sites-site-category'        => array(),
				'astra-site-page-builder'    => array(),
				'astra-sites'                => array(),
				'site-pages-category'        => array(),
				'site-pages-page-builder'    => array(),
				'site-pages-parent-category' => array(),
				'site-pages'                 => array(),
				'favorites'                  => get_option( 'astra-sites-favorites' ),
			);

			$favorite_data = get_option( 'astra-sites-favorites' );

			$license_status = false;
			if ( is_callable( 'BSF_License_Manager::bsf_is_active_license' ) ) {
				$license_status = BSF_License_Manager::bsf_is_active_license( 'astra-pro-sites' );
			}

			$default_page_builder = Astra_Sites_Page::get_instance()->get_setting( 'page_builder' );

			$data = apply_filters(
				'astra_sites_localize_vars',
				array(
					'subscribed'                         => get_user_meta( get_current_user_ID(), 'astra-sites-subscribed', true ),
					'debug'                              => defined( 'WP_DEBUG' ) ? true : false,
					'isPro'                              => defined( 'ASTRA_PRO_SITES_NAME' ) ? true : false,
					'isWhiteLabeled'                     => Astra_Sites_White_Label::get_instance()->is_white_labeled(),
					'whiteLabelName'                     => Astra_Sites_White_Label::get_instance()->get_white_label_name(),
					'whiteLabelUrl'                      => Astra_Sites_White_Label::get_instance()->get_white_label_link( 'https://wpastra.com/docs/not-valid-license/' ),
					'ajaxurl'                            => esc_url( admin_url( 'admin-ajax.php' ) ),
					'siteURL'                            => site_url(),
					'getProText'                         => __( 'Get Access!', 'astra-sites' ),
					'getProURL'                          => esc_url( 'https://wpastra.com/starter-templates-plans/?utm_source=demo-import-panel&utm_campaign=astra-sites&utm_medium=wp-dashboard' ),
					'getUpgradeText'                     => __( 'Upgrade', 'astra-sites' ),
					'getUpgradeURL'                      => esc_url( 'https://wpastra.com/starter-templates-plans/?utm_source=demo-import-panel&utm_campaign=astra-sites&utm_medium=wp-dashboard' ),
					'_ajax_nonce'                        => wp_create_nonce( 'astra-sites' ),
					'requiredPlugins'                    => array(),
					'syncLibraryStart'                   => '<span class="message">' . esc_html__( 'Syncing template library in the background. The process can take anywhere between 2 to 3 minutes. We will notify you once done.', 'astra-sites' ) . '</span>',
					'xmlRequiredFilesMissing'            => __( 'Some of the files required during the import process are missing.<br/><br/>Please try again after some time.', 'astra-sites' ),
					'importFailedMessageDueToDebug'      => __( '<p>WordPress debug mode is currently enabled on your website. This has interrupted the import process..</p><p>Kindly disable debug mode and try importing Starter Template again.</p><p>You can add the following code into the wp-config.php file to disable debug mode.</p><p><code>define(\'WP_DEBUG\', false);</code></p>', 'astra-sites' ),
					/* translators: %s is a documentation link. */
					'importFailedMessage'                => sprintf( __( '<p>We are facing a temporary issue in importing this template.</p><p>Read <a href="%s" target="_blank">article</a> to resolve the issue and continue importing template.</p>', 'astra-sites' ), esc_url( 'https://wpastra.com/docs/fix-starter-template-importing-issues/' ) ),
					/* translators: %s is a documentation link. */
					'importFailedRequiredPluginsMessage' => sprintf( __( '<p>We are facing a temporary issue in installing the required plugins for this template.</p><p>Read&nbsp;<a href="%s" target="_blank">article</a>&nbsp;to resolve the issue and continue importing template.</p>', 'astra-sites' ), esc_url( 'https://wpastra.com/docs/plugin-installation-failed-multisite/' ) ),

					'strings'                            => array(
						/* translators: %s are white label strings. */
						'warningBeforeCloseWindow' => sprintf( __( 'Warning! %1$s Import process is not complete. Don\'t close the window until import process complete. Do you still want to leave the window?', 'astra-sites' ), Astra_Sites_White_Label::get_instance()->get_white_label_name() ),
						'viewSite'                 => __( 'Done! View Site', 'astra-sites' ),
						'syncCompleteMessage'      => self::get_instance()->get_sync_complete_message(),
						/* translators: %s is a template name */
						'importSingleTemplate'     => __( 'Import "%s" Template', 'astra-sites' ),
					),
					'log'                                => array(
						'bulkInstall'  => __( 'Installing Required Plugins..', 'astra-sites' ),
						/* translators: %s are white label strings. */
						'themeInstall' => sprintf( __( 'Installing %1$s Theme..', 'astra-sites' ), Astra_Sites_White_Label::get_instance()->get_option( 'astra', 'name', 'Astra' ) ),
					),
					'default_page_builder'               => $default_page_builder,
					'default_page_builder_data'          => Astra_Sites_Page::get_instance()->get_default_page_builder(),
					'default_page_builder_sites'         => Astra_Sites_Page::get_instance()->get_sites_by_page_builder( $default_page_builder ),
					'sites'                              => astra_sites_get_api_params(),
					'allSites'                           => (array) self::get_instance()->get_all_sites(),
					'allCategories'                      => (array) self::get_instance()->get_api_option( 'astra-sites-all-site-categories' ),
					'allCategoriesAndTags'               => (array) self::get_instance()->get_api_option( 'astra-sites-all-site-categories-and-tags' ),
					'categories'                         => array(),
					'page-builders'                      => array(),
					'all_sites'                          => $this->get_all_sites(),
					'all_site_categories'                => get_option( 'astra-sites-all-site-categories', array() ),
					'all_site_categories_and_tags'       => get_option( 'astra-sites-all-site-categories-and-tags', array() ),
					'license_status'                     => $license_status,
					'license_page_builder'               => get_option( 'astra-sites-license-page-builder', '' ),
					'ApiDomain'                          => $this->api_domain,
					'ApiURL'                             => $this->api_url,
					'stored_data'                        => $stored_data,
					'favorite_data'                      => $favorite_data,
					'category_slug'                      => 'astra-sites-site-category',
					'page_builder'                       => 'astra-site-page-builder',
					'cpt_slug'                           => 'astra-sites',
					'parent_category'                    => '',
					'compatibilities'                    => $this->get_compatibilities(),
					'compatibilities_data'               => $this->get_compatibilities_data(),
					'dismiss'                            => __( 'Dismiss this notice.', 'astra-sites' ),
					'headings'                           => array(
						'subscription' => esc_html__( 'One Last Step..', 'astra-sites' ),
						'site_import'  => esc_html__( 'Your Selected Website is Being Imported.', 'astra-sites' ),
						'page_import'  => esc_html__( 'Your Selected Template is Being Imported.', 'astra-sites' ),
					),
					'subscriptionSuccessMessage'         => esc_html__( 'We have sent you a surprise gift on your email address! Please check your inbox!', 'astra-sites' ),
					'first_import_complete'              => get_option( 'astra_sites_import_complete' ),
					'server_import_primary_error'        => __( 'Looks like the template you are importing is temporarily not available.', 'astra-sites' ),
					'client_import_primary_error'        => __( 'We could not start the import process and this is the message from WordPress:', 'astra-sites' ),
					'cloudflare_import_primary_error'    => __( 'There was an error connecting to the Starter Templates API.', 'astra-sites' ),
					'xml_import_interrupted_primary'     => __( 'There was an error while importing the content.', 'astra-sites' ),
					'xml_import_interrupted_secondary'   => __( 'To import content, WordPress needs to store XML file in /wp-content/ folder. Please get in touch with your hosting provider.', 'astra-sites' ),
					'xml_import_interrupted_error'       => __( 'Looks like your host probably could not store XML file in /wp-content/ folder.', 'astra-sites' ),
					/* translators: %s HTML tags */
					'ajax_request_failed_primary'        => sprintf( __( '%1$sWe could not start the import process due to failed AJAX request and this is the message from WordPress:%2$s', 'astra-sites' ), '<p>', '</p>' ),
					/* translators: %s URL to document. */
					'ajax_request_failed_secondary'      => sprintf( __( '%1$sRead&nbsp;<a href="%2$s" target="_blank">article</a>&nbsp;to resolve the issue and continue importing template.%3$s', 'astra-sites' ), '<p>', esc_url( 'https://wpastra.com/docs/internal-server-error-starter-templates/' ), '</p>' ),
					'cta_links' => $this->get_cta_links(),
					'cta_quick_corner_links' => $this->get_cta_links( 'quick-links-corner' ),
					'cta_premium_popup_links' => $this->get_cta_links( 'get-premium-access-popup' ),
					'cta_link' => $this->get_cta_link(),
					'cta_quick_corner_link' => $this->get_cta_link( 'quick-links-corner' ),
					'cta_premium_popup_link' => $this->get_cta_link( 'get-premium-access-popup' ),

					/* translators: %s URL to document. */
					'process_failed_primary'        => sprintf( __( '%1$sWe could not complete the import process due to failed AJAX request and this is the message:%2$s', 'astra-sites' ), '<p>', '</p>' ),
					/* translators: %s URL to document. */
					'process_failed_secondary'      => sprintf( __( '%1$sPlease report this <a href="%2$s" target="_blank">here</a>.%3$s', 'astra-sites' ), '<p>', esc_url( 'https://wpastra.com/starter-templates-support/?url=#DEMO_URL#&subject=#SUBJECT#' ), '</p>' ),
					'st_page_url' => admin_url( 'themes.php?page=starter-templates' ),
					'isRTLEnabled' => is_rtl(),
					/* translators: %s Anchor link to support URL. */
					'support_text' => sprintf( __( 'Please report this error %1$shere%2$s, so we can fix it.', 'astra-sites' ), '<a href="https://wpastra.com/support/open-a-ticket/" target="_blank">', '</a>' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				)
			);

			return $data;
		}

		/**
		 * Display subscription form
		 *
		 * @since 2.6.1
		 *
		 * @return boolean
		 */
		public function should_display_subscription_form() {

			$subscription = apply_filters( 'astra_sites_should_display_subscription_form', null );
			if ( null !== $subscription ) {
				return $subscription;
			}

			// Is WhiteLabel enabled?
			if ( Astra_Sites_White_Label::get_instance()->is_white_labeled() ) {
				return false;
			}

			// Is Premium Starter Templates pluign?
			if ( defined( 'ASTRA_PRO_SITES_NAME' ) ) {
				return false;
			}

			// User already subscribed?
			$subscribed = get_user_meta( get_current_user_ID(), 'astra-sites-subscribed', true );
			if ( $subscribed ) {
				return false;
			}

			return true;
		}

		/**
		 * Import Compatibility Errors
		 *
		 * @since 2.0.0
		 * @return mixed
		 */
		public function get_compatibilities_data() {
			return array(
				'xmlreader'            => array(
					'title'   => esc_html__( 'XMLReader Support Missing', 'astra-sites' ),
					/* translators: %s doc link. */
					'tooltip' => '<p>' . esc_html__( 'You\'re close to importing the template. To complete the process, enable XMLReader support on your website..', 'astra-sites' ) . '</p><p>' . sprintf( __( 'Read an article <a href="%s" target="_blank">here</a> to resolve the issue.', 'astra-sites' ), 'https://wpastra.com/docs/xmlreader-missing/' ) . '</p>',
				),
				'curl'                 => array(
					'title'   => esc_html__( 'cURL Support Missing', 'astra-sites' ),
					/* translators: %s doc link. */
					'tooltip' => '<p>' . esc_html__( 'To run a smooth import, kindly enable cURL support on your website.', 'astra-sites' ) . '</p><p>' . sprintf( __( 'Read an article <a href="%s" target="_blank">here</a> to resolve the issue.', 'astra-sites' ), 'https://wpastra.com/docs/curl-support-missing/' ) . '</p>',
				),
				'wp-debug'             => array(
					'title'   => esc_html__( 'Disable Debug Mode', 'astra-sites' ),
					/* translators: %s doc link. */
					'tooltip' => '<p>' . esc_html__( 'WordPress debug mode is currently enabled on your website. With this, any errors from third-party plugins might affect the import process.', 'astra-sites' ) . '</p><p>' . esc_html__( 'Kindly disable it to continue importing the Starter Template. To do so, you can add the following code into the wp-config.php file.', 'astra-sites' ) . '</p><p><code>define(\'WP_DEBUG\', false);</code></p><p>' . sprintf( __( 'Read an article <a href="%s" target="_blank">here</a> to resolve the issue.', 'astra-sites' ), 'https://wpastra.com/docs/disable-debug-mode/' ) . '</p>',
				),
				'update-available'     => array(
					'title'   => esc_html__( 'Update Plugin', 'astra-sites' ),
					/* translators: %s update page link. */
					'tooltip' => '<p>' . esc_html__( 'Updates are available for plugins used in this starter template.', 'astra-sites' ) . '</p>##LIST##<p>' . sprintf( __( 'Kindly <a href="%s" target="_blank">update</a> them for a successful import. Skipping this step might break the template design/feature.', 'astra-sites' ), esc_url( network_admin_url( 'update-core.php' ) ) ) . '</p>',
				),
				'third-party-required' => array(
					'title'   => esc_html__( 'Required Plugins Missing', 'astra-sites' ),
					'tooltip' => '<p>' . esc_html__( 'This starter template requires premium plugins. As these are third party premium plugins, you\'ll need to purchase, install and activate them first.', 'astra-sites' ) . '</p>',
				),
				'dynamic-page'         => array(
					'title'   => esc_html__( 'Dynamic Page', 'astra-sites' ),
					'tooltip' => '<p>' . esc_html__( 'The page template you are about to import contains a dynamic widget/module. Please note this dynamic data will not be available with the imported page.', 'astra-sites' ) . '</p><p>' . esc_html__( 'You will need to add it manually on the page.', 'astra-sites' ) . '</p><p>' . esc_html__( 'This dynamic content will be available when you import the entire site.', 'astra-sites' ) . '</p>',
				),
			);
		}

		/**
		 * Get all compatibilities
		 *
		 * @since 2.0.0
		 *
		 * @return array
		 */
		public function get_compatibilities() {

			$data = $this->get_compatibilities_data();

			$compatibilities = array(
				'errors'   => array(),
				'warnings' => array(),
			);

			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$compatibilities['warnings']['wp-debug'] = $data['wp-debug'];
			}

			if ( ! class_exists( 'XMLReader' ) ) {
				$compatibilities['errors']['xmlreader'] = $data['xmlreader'];
			}

			if ( ! function_exists( 'curl_version' ) ) {
				$compatibilities['errors']['curl'] = $data['curl'];
			}

			return $compatibilities;
		}

		/**
		 * Register module required js on elementor's action.
		 *
		 * @since 2.0.0
		 */
		public function register_widget_scripts() {

			$page_builders = self::get_instance()->get_page_builders();
			$has_elementor = false;

			// Use this filter to remove the Starter Templates button from Elementor Editor.
			$elementor_add_ast_site_button = apply_filters( 'starter_templates_hide_elementor_button', false );

			foreach ( $page_builders as $page_builder ) {

				if ( 'elementor' === $page_builder['slug'] ) {
					$has_elementor = true;
				}
			}

			if ( ! $has_elementor ) {
				return;
			}

			if ( $elementor_add_ast_site_button ) {
				return;
			}

			wp_enqueue_script( 'astra-sites-helper', ASTRA_SITES_URI . 'inc/assets/js/helper.js', array( 'jquery' ), ASTRA_SITES_VER, true );

			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'imagesloaded' );

			// Image Search assets.
			$this->image_search_assets();

			wp_enqueue_script( 'astra-sites-elementor-admin-page', ASTRA_SITES_URI . 'inc/assets/js/elementor-admin-page.js', array( 'jquery', 'wp-util', 'updates', 'masonry', 'imagesloaded' ), ASTRA_SITES_VER, true );
			wp_add_inline_script( 'astra-sites-elementor-admin-page', sprintf( 'var pagenow = "%s";', ASTRA_SITES_NAME ), 'after' );
			wp_enqueue_style( 'astra-sites-admin', ASTRA_SITES_URI . 'inc/assets/css/admin.css', ASTRA_SITES_VER, true );
			wp_style_add_data( 'astra-sites-admin', 'rtl', 'replace' );

			$license_status = false;
			if ( is_callable( 'BSF_License_Manager::bsf_is_active_license' ) ) {
				$license_status = BSF_License_Manager::bsf_is_active_license( 'astra-pro-sites' );
			}

			/* translators: %s are link. */
			$license_msg = sprintf( __( 'This is a premium template available with Essential Bundle and Growth Bundle. you can purchase it from <a href="%s" target="_blank">here</a>.', 'astra-sites' ), 'https://wpastra.com/starter-templates-plans/' );

			if ( defined( 'ASTRA_PRO_SITES_NAME' ) ) {
				/* translators: %s are link. */
				$license_msg = sprintf( __( 'This is a premium template available with Essential Bundle and Growth Bundle. <a href="%s" target="_blank">Validate Your License</a> Key to import this template.', 'astra-sites' ), esc_url( admin_url( 'plugins.php?bsf-inline-license-form=astra-pro-sites' ) ) );
			}

			$data = apply_filters(
				'astra_sites_render_localize_vars',
				array(
					'plugin_name'                => Astra_Sites_White_Label::get_instance()->get_white_label_name(),
					'sites'                      => astra_sites_get_api_params(),
					'settings'                   => array(),
					'page-builders'              => array(),
					'categories'                 => array(),
					'default_page_builder'       => 'elementor',
					'astra_blocks'               => $this->get_all_blocks(),
					'license_status'             => $license_status,
					'ajaxurl'                    => esc_url( admin_url( 'admin-ajax.php' ) ),
					'default_page_builder_sites' => Astra_Sites_Page::get_instance()->get_sites_by_page_builder( 'elementor' ),
					'ApiURL'                     => $this->api_url,
					'_ajax_nonce'                => wp_create_nonce( 'astra-sites' ),
					'isPro'                      => defined( 'ASTRA_PRO_SITES_NAME' ) ? true : false,
					'license_msg'                => $license_msg,
					'isWhiteLabeled'             => Astra_Sites_White_Label::get_instance()->is_white_labeled(),
					'getProText'                 => __( 'Get Access!', 'astra-sites' ),
					'getProURL'                  => esc_url( 'https://wpastra.com/starter-templates-plans/?utm_source=demo-import-panel&utm_campaign=astra-sites&utm_medium=wp-dashboard' ),
					'astra_block_categories'     => $this->get_api_option( 'astra-blocks-categories' ),
					'siteURL'                    => site_url(),
					'template'                   => esc_html__( 'Template', 'astra-sites' ),
					'block'                      => esc_html__( 'Block', 'astra-sites' ),
					'dismiss_text'               => esc_html__( 'Dismiss', 'astra-sites' ),
					'install_plugin_text'        => esc_html__( 'Install Required Plugins', 'astra-sites' ),
					'syncCompleteMessage'        => self::get_instance()->get_sync_complete_message(),
					/* translators: %s are link. */
					'page_settings'              => array(
						'message'  => __( 'You can locate <strong>Starter Templates Settings</strong> under the <strong>Page Settings</strong> of the Style Tab.', 'astra-sites' ),
						'url'      => '#',
						'url_text' => __( 'Read More →', 'astra-sites' ),
					),
				)
			);

			wp_localize_script( 'astra-sites-elementor-admin-page', 'astraElementorSites', $data );
		}

		/**
		 * Register module required js on elementor's action.
		 *
		 * @since 2.0.0
		 */
		public function popup_styles() {

			wp_enqueue_style( 'astra-sites-elementor-admin-page', ASTRA_SITES_URI . 'inc/assets/css/elementor-admin.css', ASTRA_SITES_VER, true );
			wp_enqueue_style( 'astra-sites-elementor-admin-page-dark', ASTRA_SITES_URI . 'inc/assets/css/elementor-admin-dark.css', ASTRA_SITES_VER, true );
			wp_style_add_data( 'astra-sites-elementor-admin-page', 'rtl', 'replace' );

		}

		/**
		 * Get all sites
		 *
		 * @since 2.0.0
		 * @return array All sites.
		 */
		public function get_all_sites() {
			$sites_and_pages = array();
			$total_requests  = (int) get_site_option( 'astra-sites-requests', 0 );

			for ( $page = 1; $page <= $total_requests; $page++ ) {
				$current_page_data = get_site_option( 'astra-sites-and-pages-page-' . $page, array() );
				if ( ! empty( $current_page_data ) ) {
					foreach ( $current_page_data as $page_id => $page_data ) {
						$sites_and_pages[ $page_id ] = $page_data;
					}
				}
			}

			return $sites_and_pages;
		}

		/**
		 * Get all sites
		 *
		 * @since 2.2.4
		 * @param  array $option Site options name.
		 * @return array Site Option value.
		 */
		public function get_api_option( $option ) {
			return get_site_option( $option, array() );
		}

		/**
		 * Get all blocks
		 *
		 * @since 2.0.0
		 * @return array All Elementor Blocks.
		 */
		public function get_all_blocks() {

			$blocks         = array();
			$total_requests = (int) get_site_option( 'astra-blocks-requests', 0 );

			for ( $page = 1; $page <= $total_requests; $page++ ) {
				$current_page_data = get_site_option( 'astra-blocks-' . $page, array() );
				if ( ! empty( $current_page_data ) ) {
					foreach ( $current_page_data as $page_id => $page_data ) {
						$blocks[ $page_id ] = $page_data;
					}
				}
			}

			return $blocks;
		}

		/**
		 * Load all the required files in the importer.
		 *
		 * @since  1.0.0
		 */
		private function includes() {

			require_once ASTRA_SITES_DIR . 'inc/classes/class-astra-sites-error-handler.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/functions.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/class-astra-sites-white-label.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/class-astra-sites-page.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/class-astra-sites-elementor-pages.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/class-astra-sites-elementor-images.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/compatibility/class-astra-sites-compatibility.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/class-astra-sites-importer.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/class-astra-sites-image-processing.php';
			require_once ASTRA_SITES_DIR . 'inc/classes/class-astra-sites-wp-cli.php';
			require_once ASTRA_SITES_DIR . 'inc/lib/class-astra-sites-ast-block-templates.php';
			require_once ASTRA_SITES_DIR . 'inc/lib/onboarding/class-onboarding.php';

			// Batch Import.
			require_once ASTRA_SITES_DIR . 'inc/classes/batch-import/class-astra-sites-batch-import.php';
		}

		/**
		 * Required Plugin Activate
		 *
		 * @since 2.0.0 Added parameters $init, $options & $enabled_extensions to add the WP CLI support.
		 * @since 1.0.0
		 * @param  string $init               Plugin init file.
		 * @param  array  $options            Site options.
		 * @param  array  $enabled_extensions Enabled extensions.
		 * @return void
		 */
		public function required_plugin_activate( $init = '', $options = array(), $enabled_extensions = array() ) {

			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'astra-sites', '_ajax_nonce' );

				if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
					wp_send_json_error(
						array(
							'success' => false,
							'message' => __( 'Error: You don\'t have the required permissions to install plugins.', 'astra-sites' ),
						)
					);
				}
			}

			Astra_Sites_Error_Handler::get_instance()->start_error_handler();

			$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : $init;
			$activate = activate_plugin( $plugin_init, '', false, false );

			Astra_Sites_Error_Handler::get_instance()->stop_error_handler();

			if ( is_wp_error( $activate ) ) {
				if ( defined( 'WP_CLI' ) ) {
					WP_CLI::error( 'Plugin Activation Error: ' . $activate->get_error_message() );
				} elseif ( wp_doing_ajax() ) {
					wp_send_json_error(
						array(
							'success' => false,
							'message' => $activate->get_error_message(),
						)
					);
				}
			}

			$options = astra_get_site_data( 'astra-site-options-data' );
			$enabled_extensions = astra_get_site_data( 'astra-enabled-extensions' );

			$this->after_plugin_activate( $plugin_init, $options, $enabled_extensions );

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::line( 'Plugin Activated!' );
			} elseif ( wp_doing_ajax() ) {
				wp_send_json_success(
					array(
						'success' => true,
						'message' => __( 'Plugin Activated', 'astra-sites' ),
					)
				);
			}
		}

		/**
		 * Required Plugins
		 *
		 * @since 2.0.0
		 *
		 * @param  array $required_plugins Required Plugins.
		 * @param  array $options            Site Options.
		 * @param  array $enabled_extensions Enabled Extensions.
		 * @return mixed
		 */
		public function required_plugin( $required_plugins = array(), $options = array(), $enabled_extensions = array() ) {

			// Verify Nonce.
			if ( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) {
				check_ajax_referer( 'astra-sites', '_ajax_nonce' );
			}

			$response = array(
				'active'       => array(),
				'inactive'     => array(),
				'notinstalled' => array(),
			);

			$options = astra_get_site_data( 'astra-site-options-data' );
			$enabled_extensions = astra_get_site_data( 'astra-enabled-extensions' );
			$required_plugins = astra_get_site_data( 'required-plugins' );
			$learndash_course_grid = 'https://www.learndash.com/add-on/course-grid/';
			$learndash_woocommerce = 'https://www.learndash.com/add-on/woocommerce/';
			if ( is_plugin_active( 'sfwd-lms/sfwd_lms.php' ) ) {
				$learndash_addons_url  = admin_url( 'admin.php?page=learndash_lms_addons' );
				$learndash_course_grid = $learndash_addons_url;
				$learndash_woocommerce = $learndash_addons_url;
			}

			$third_party_required_plugins = array();
			$third_party_plugins          = array(
				'sfwd-lms'              => array(
					'init' => 'sfwd-lms/sfwd_lms.php',
					'name' => 'LearnDash LMS',
					'link' => 'https://www.learndash.com/',
				),
				'learndash-course-grid' => array(
					'init' => 'learndash-course-grid/learndash_course_grid.php',
					'name' => 'LearnDash Course Grid',
					'link' => $learndash_course_grid,
				),
				'learndash-woocommerce' => array(
					'init' => 'learndash-woocommerce/learndash_woocommerce.php',
					'name' => 'LearnDash WooCommerce Integration',
					'link' => $learndash_woocommerce,
				),
			);

			$plugin_updates          = get_plugin_updates();
			$update_avilable_plugins = array();
			$incompatible_plugins = array();

			if ( ! empty( $required_plugins ) ) {
				$php_version = Astra_Sites_Onboarding_Setup::get_instance()->get_php_version();
				foreach ( $required_plugins as $key => $plugin ) {

					$plugin = (array) $plugin;

					if ( 'woocommerce' === $plugin['slug'] && version_compare( $php_version, '7.0', '<' ) ) {
						$plugin['min_php_version'] = '7.0';
						$incompatible_plugins[] = $plugin;
					}

					if ( 'presto-player' === $plugin['slug'] && version_compare( $php_version, '7.3', '<' ) ) {
						$plugin['min_php_version'] = '7.3';
						$incompatible_plugins[] = $plugin;
					}

					/**
					 * Has Pro Version Support?
					 * And
					 * Is Pro Version Installed?
					 */
					$plugin_pro = $this->pro_plugin_exist( $plugin['init'] );
					if ( $plugin_pro ) {

						if ( array_key_exists( $plugin_pro['init'], $plugin_updates ) ) {
							$update_avilable_plugins[] = $plugin_pro;
						}

						// Pro - Active.
						if ( is_plugin_active( $plugin_pro['init'] ) ) {
							$response['active'][] = $plugin_pro;

							$this->after_plugin_activate( $plugin['init'], $options, $enabled_extensions );

							// Pro - Inactive.
						} else {
							$response['inactive'][] = $plugin_pro;
						}
					} else {
						if ( array_key_exists( $plugin['init'], $plugin_updates ) ) {
							$update_avilable_plugins[] = $plugin;
						}

						// Lite - Installed but Inactive.
						if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin['init'] ) && is_plugin_inactive( $plugin['init'] ) ) {

							$response['inactive'][] = $plugin;

							// Lite - Not Installed.
						} elseif ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin['init'] ) ) {

							// Added premium plugins which need to install first.
							if ( array_key_exists( $plugin['slug'], $third_party_plugins ) ) {
								$third_party_required_plugins[] = $third_party_plugins[ $plugin['slug'] ];
							} else {
								$response['notinstalled'][] = $plugin;
							}

							// Lite - Active.
						} else {
							$response['active'][] = $plugin;

							$this->after_plugin_activate( $plugin['init'], $options, $enabled_extensions );
						}
					}
				}
			}

			// Checking the `install_plugins` and `activate_plugins` capability for the current user.
			// To perform plugin installation process.
			if (
				( ! defined( 'WP_CLI' ) && wp_doing_ajax() ) &&
				( ( ! current_user_can( 'install_plugins' ) && ! empty( $response['notinstalled'] ) ) || ( ! current_user_can( 'activate_plugins' ) && ! empty( $response['inactive'] ) ) ) ) {
				$message               = __( 'Insufficient Permission. Please contact your Super Admin to allow the install required plugin permissions.', 'astra-sites' );
				$required_plugins_list = array_merge( $response['notinstalled'], $response['inactive'] );
				$markup                = $message;
				$markup               .= '<ul>';
				foreach ( $required_plugins_list as $key => $required_plugin ) {
					$markup .= '<li>' . esc_html( $required_plugin['name'] ) . '</li>';
				}
				$markup .= '</ul>';

				wp_send_json_error( $markup );
			}

			$data = array(
				'required_plugins'             => $response,
				'third_party_required_plugins' => $third_party_required_plugins,
				'update_avilable_plugins'      => $update_avilable_plugins,
				'incompatible_plugins'         => $incompatible_plugins,
			);

			if ( wp_doing_ajax() ) {
				wp_send_json_success( $data );
			} else {
				return $data;
			}
		}

		/**
		 * After Plugin Activate
		 *
		 * @since 2.0.0
		 *
		 * @param  string $plugin_init        Plugin Init File.
		 * @param  array  $options            Site Options.
		 * @param  array  $enabled_extensions Enabled Extensions.
		 * @return void
		 */
		public function after_plugin_activate( $plugin_init = '', $options = array(), $enabled_extensions = array() ) {
			$data = array(
				'astra_site_options' => $options,
				'enabled_extensions' => $enabled_extensions,
			);

			do_action( 'astra_sites_after_plugin_activation', $plugin_init, $data );
		}

		/**
		 * Has Pro Version Support?
		 * And
		 * Is Pro Version Installed?
		 *
		 * Check Pro plugin version exist of requested plugin lite version.
		 *
		 * Eg. If plugin 'BB Lite Version' required to import demo. Then we check the 'BB Agency Version' is exist?
		 * If yes then we only 'Activate' Agency Version. [We couldn't install agency version.]
		 * Else we 'Activate' or 'Install' Lite Version.
		 *
		 * @since 1.0.1
		 *
		 * @param  string $lite_version Lite version init file.
		 * @return mixed               Return false if not installed or not supported by us
		 *                                    else return 'Pro' version details.
		 */
		public function pro_plugin_exist( $lite_version = '' ) {

			// Lite init => Pro init.
			$plugins = apply_filters(
				'astra_sites_pro_plugin_exist',
				array(
					'beaver-builder-lite-version/fl-builder.php' => array(
						'slug' => 'bb-plugin',
						'init' => 'bb-plugin/fl-builder.php',
						'name' => 'Beaver Builder Plugin',
					),
					'ultimate-addons-for-beaver-builder-lite/bb-ultimate-addon.php' => array(
						'slug' => 'bb-ultimate-addon',
						'init' => 'bb-ultimate-addon/bb-ultimate-addon.php',
						'name' => 'Ultimate Addon for Beaver Builder',
					),
					'wpforms-lite/wpforms.php' => array(
						'slug' => 'wpforms',
						'init' => 'wpforms/wpforms.php',
						'name' => 'WPForms',
					),
				),
				$lite_version
			);

			if ( isset( $plugins[ $lite_version ] ) ) {

				// Pro plugin directory exist?
				if ( file_exists( WP_PLUGIN_DIR . '/' . $plugins[ $lite_version ]['init'] ) ) {
					return $plugins[ $lite_version ];
				}
			}

			return false;
		}

		/**
		 * Get Default Page Builders
		 *
		 * @since 2.0.0
		 * @return array
		 */
		public function get_default_page_builders() {
			return array(
				array(
					'id'   => 42,
					'slug' => 'gutenberg',
					'name' => 'Gutenberg',
				),
				array(
					'id'   => 33,
					'slug' => 'elementor',
					'name' => 'Elementor',
				),
				array(
					'id'   => 34,
					'slug' => 'beaver-builder',
					'name' => 'Beaver Builder',
				),
				array(
					'id'   => 41,
					'slug' => 'brizy',
					'name' => 'Brizy',
				),
			);
		}

		/**
		 * Get Page Builders
		 *
		 * @since 2.0.0
		 * @return array
		 */
		public function get_page_builders() {
			return $this->get_default_page_builders();
		}

		/**
		 * Get Page Builder Filed
		 *
		 * @since 2.0.0
		 * @param  string $page_builder Page Bulider.
		 * @param  string $field        Field name.
		 * @return mixed
		 */
		public function get_page_builder_field( $page_builder = '', $field = '' ) {
			if ( empty( $page_builder ) ) {
				return '';
			}

			$page_builders = self::get_instance()->get_page_builders();
			if ( empty( $page_builders ) ) {
				return '';
			}

			foreach ( $page_builders as $key => $current_page_builder ) {
				if ( $page_builder === $current_page_builder['slug'] ) {
					if ( isset( $current_page_builder[ $field ] ) ) {
						return $current_page_builder[ $field ];
					}
				}
			}

			return '';
		}

		/**
		 * Get License Key
		 *
		 * @since 2.0.0
		 * @return array
		 */
		public function get_license_key() {
			if ( class_exists( 'BSF_License_Manager' ) ) {
				if ( BSF_License_Manager::bsf_is_active_license( 'astra-pro-sites' ) ) {
					return BSF_License_Manager::instance()->bsf_get_product_info( 'astra-pro-sites', 'purchase_key' );
				}
			}

			return '';
		}

		/**
		 * Get Sync Complete Message
		 *
		 * @since 2.0.0
		 * @param  boolean $echo Echo the message.
		 * @return mixed
		 */
		public function get_sync_complete_message( $echo = false ) {

			$message = __( 'Template library refreshed!', 'astra-sites' );

			if ( $echo ) {
				echo esc_html( $message );
			} else {
				return esc_html( $message );
			}
		}

		/**
		 * Get an instance of WP_Filesystem_Direct.
		 *
		 * @since 2.0.0
		 * @return object A WP_Filesystem_Direct instance.
		 */
		public static function get_filesystem() {
			global $wp_filesystem;

			require_once ABSPATH . '/wp-admin/includes/file.php';

			WP_Filesystem();

			return $wp_filesystem;
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Astra_Sites::get_instance();

endif;
