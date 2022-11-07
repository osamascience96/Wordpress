<?php
/**
 * Class for the customizer importer.
 *
 * Code is mostly from the Customizer Export/Import plugin.
 *
 * @see https://wordpress.org/plugins/customizer-export-import/
 * @package Athemes Starter Sites
 */

/**
 * Customizer Importer
 */
class ATSS_Customizer_Importer {
	/**
	 * Import customizer.
	 *
	 * @param array $data The data.
	 */
	public static function import( $data ) {
		// Try to import the customizer settings.
		return self::import_customizer_options( $data );
	}

	/**
	 * Imports uploaded mods and calls WordPress core customize_save actions so
	 * themes that hook into them can act before mods are saved to the database.
	 *
	 * Update: WP core customize_save actions were removed, because of some errors.
	 *
	 * @param array $data The data.
	 * @return void|WP_Error
	 */
	public static function import_customizer_options( $data ) {
		// Setup global vars.
		global $wp_customize;

		// Setup internal vars.
		$template = get_template();

		// Data checks.
		if ( ! is_array( $data ) && ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) ) {
			return new WP_Error(
				'customizer_import_data_error',
				esc_html__( 'Error: The customizer import file is not in a correct format. Please make sure to use the correct customizer import file.', 'athemes-starter-sites' )
			);
		}
		if ( $data['template'] !== $template ) {
			return new WP_Error(
				'customizer_import_wrong_theme',
				esc_html__( 'Error: The customizer import file is not suitable for current theme. You can only import customizer settings for the same theme or a child theme.', 'athemes-starter-sites' )
			);
		}

		// Import images.
		if ( apply_filters( 'atss_customizer_import_images', true ) ) {
			$data['mods'] = self::import_customizer_images( $data['mods'] );
		}

		// Import custom options.
		if ( isset( $data['options'] ) ) {
			// Require modified customizer options class.
			if ( ! class_exists( 'WP_Customize_Setting' ) ) {
				require_once ABSPATH . 'wp-includes/class-wp-customize-setting.php';
			}

			if ( ! class_exists( 'ATSS_Customizer_Option' ) ) {
				require_once ATSS_PATH . 'core/class-customizer-option.php';
			}

			foreach ( $data['options'] as $option_key => $option_value ) {
				$option = new ATSS_Customizer_Option( $wp_customize, $option_key, array(
					'default'    => '',
					'type'       => 'option',
					'capability' => 'edit_theme_options',
				) );

				$option->import( $option_value );
			}
		}

		// Should the customizer import use the WP customize_save* hooks?
		$use_wp_customize_save_hooks = apply_filters( 'atss_enable_wp_customize_save_hooks', false );

		if ( $use_wp_customize_save_hooks ) {
			do_action( 'customize_save', $wp_customize );
		}

		// Loop through the mods and save the mods.
		foreach ( $data['mods'] as $key => $val ) {
			if ( $use_wp_customize_save_hooks ) {
				do_action( 'customize_save_' . $key, $wp_customize );
			}

			set_theme_mod( $key, $val );
		}

		if ( $use_wp_customize_save_hooks ) {
			do_action( 'customize_save_after', $wp_customize );
		}
	}

	/**
	 * Helper function: Customizer import - imports images for settings saved as mods.
	 *
	 * @since 1.1.1
	 * @param array $mods An array of customizer mods.
	 * @return array The mods array with any new import data.
	 */
	private static function import_customizer_images( $mods ) {
		foreach ( $mods as $key => $val ) {
			if ( self::customizer_is_image_url( $val ) ) {
				$data = self::customizer_sideload_image( $val );
				if ( ! is_wp_error( $data ) ) {
					$mods[ $key ] = $data->url;

					// Handle header image controls.
					if ( isset( $mods[ $key . '_data' ] ) ) {
						$mods[ $key . '_data' ] = $data;
						update_post_meta( $data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet() );
					}
				}
			}
		}

		return $mods;
	}

	/**
	 * Helper function: Customizer import
	 * Taken from the core media_sideload_image function and
	 * modified to return an array of data instead of html.
	 *
	 * @since 1.1.1.
	 * @param string $file The image file path.
	 * @return array An array of image data.
	 */
	private static function customizer_sideload_image( $file ) {
		$data = new stdClass();

		if ( ! function_exists( 'media_handle_sideload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}
		if ( ! empty( $file ) ) {
			// Set variables for storage, fix file filename for query strings.
			preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
			$file_array = array();
			$file_array['name'] = basename( $matches[0] );

			// Download file to temp location.
			$file_array['tmp_name'] = download_url( $file );

			// If error storing temporarily, return the error.
			if ( is_wp_error( $file_array['tmp_name'] ) ) {
				return $file_array['tmp_name'];
			}

			// Do the validation and storage stuff.
			$id = media_handle_sideload( $file_array, 0 );

			// If error storing permanently, unlink.
			if ( is_wp_error( $id ) ) {
				unlink( $file_array['tmp_name'] );
				return $id;
			}

			// Build the object to return.
			$meta                = wp_get_attachment_metadata( $id );
			$data->attachment_id = $id;
			$data->url           = wp_get_attachment_url( $id );
			$data->thumbnail_url = wp_get_attachment_thumb_url( $id );
			$data->height        = $meta['height'];
			$data->width         = $meta['width'];
		}

		return $data;
	}

	/**
	 * Checks to see whether a string is an image url or not.
	 *
	 * @since 1.1.1
	 * @param string $string The string to check.
	 * @return bool Whether the string is an image url or not.
	 */
	private static function customizer_is_image_url( $string = '' ) {
		if ( is_string( $string ) ) {
			if ( preg_match( '/\.(jpg|jpeg|png|gif)/i', $string ) ) {
				return true;
			}
		}

		return false;
	}
}
