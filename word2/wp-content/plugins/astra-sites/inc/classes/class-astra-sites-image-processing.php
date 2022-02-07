<?php
/**
 * Astra Sites Image Processing
 *
 * @since  3.0.20
 * @package Astra Sites
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Astra Sites Importer
 */
class Astra_Sites_Image_Processing {

	/**
	 * Instance
	 *
	 * @since  3.0.20
	 * @var (Object) Class object
	 */
	public static $instance = null;

	/**
	 * Set Instance
	 *
	 * @since  3.0.20
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
	 * @since  3.0.20
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'defer_image_processing_while_import' ) );
	}

	/**
	 * Add filters to defer image subsizes processing while importing.
	 */
	public function defer_image_processing_while_import() {
		if ( astra_sites_has_import_started() ) {
			$this->defer_image_subsizes();
		}
	}

	/**
	 * Defer image subsizes.
	 *
	 * @return void
	 */
	public function defer_image_subsizes() {
		add_filter( 'intermediate_image_sizes_advanced', array( $this, 'buffer_images_for_processing' ), 10, 3 );
	}

	/**
	 * Force attachment size geenration in the background.
	 *
	 * @param array   $new_sizes       Array of image sizes.
	 * @param array   $image_meta      Metadata of the image.
	 * @param integer $attachment_id Attachment id.
	 *
	 * @return array
	 */
	public function buffer_images_for_processing( $new_sizes, $image_meta, $attachment_id ) {
		$all_attachments = get_option( 'st_attachments', array() );

		// If the cron job is already scheduled, bail.
		if ( in_array( $attachment_id, $all_attachments, true ) ) {
			return $new_sizes;
		}

		$all_attachments[] = $attachment_id;

		update_option( 'st_attachments', $all_attachments, 'no' );

		// Return blank array of sizes to not generate any sizes in this request.
		return array();
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Astra_Sites_Image_Processing::get_instance();
