<?php

namespace WPForms\Helpers;

/**
 * Template related helper methods.
 *
 * @since 1.5.4
 */
class Templates {

	/**
	 * Return a list of paths to check for template locations
	 *
	 * @since 1.5.4
	 *
	 * @return array
	 */
	public static function get_theme_template_paths() {

		$template_dir = 'wpforms';

		$file_paths = array(
			1   => \trailingslashit( \get_stylesheet_directory() ) . $template_dir,
			10  => \trailingslashit( \get_template_directory() ) . $template_dir,
			100 => \trailingslashit( \WPFORMS_PLUGIN_DIR ) . 'templates',
		);

		$file_paths = \apply_filters( 'wpforms_helpers_templates_get_theme_template_paths', $file_paths );

		// Sort the file paths based on priority.
		\ksort( $file_paths, SORT_NUMERIC );

		return \array_map( 'trailingslashit', $file_paths );
	}

	/**
	 * Locate a template and return the path for inclusion.
	 *
	 * @since 1.5.4
	 *
	 * @param string $template_name Template name.
	 *
	 * @return string
	 */
	public static function locate( $template_name ) {

		// Trim off any slashes from the template name.
		$template_name = \ltrim( $template_name, '/' );

		if ( empty( $template_name ) ) {
			return \apply_filters( 'wpforms_helpers_templates_locate', '', $template_name );
		}

		$located = '';

		// Try locating this template file by looping through the template paths.
		foreach ( self::get_theme_template_paths() as $template_path ) {
			if ( \file_exists( $template_path . $template_name ) ) {
				$located = $template_path . $template_name;
				break;
			}
		}

		return \apply_filters( 'wpforms_helpers_templates_locate', $located, $template_name );
	}

	/**
	 * Include a template.
	 * Use 'require' if $args are passed or 'load_template' if not.
	 *
	 * @since 1.5.4
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments.
	 * @param bool   $extract       Extract arguments.
	 *
	 * @throws \RuntimeException If extract() tries to modify the scope.
	 */
	public static function include_html( $template_name, $args = array(), $extract = false ) {

		$template_name .= '.php';

		// Allow 3rd party plugins to filter template file from their plugin.
		$located = \apply_filters( 'wpforms_helpers_templates_include_html_located', self::locate( $template_name ), $template_name, $args, $extract );
		$args    = \apply_filters( 'wpforms_helpers_templates_include_html_args', $args, $template_name, $extract );

		if ( empty( $located ) || ! \is_readable( $located ) ) {
			return;
		}

		// Load template WP way if no arguments were passed.
		if ( empty( $args ) ) {
			\load_template( $located, false );
			return;
		}

		$extract = \apply_filters( 'wpforms_helpers_templates_include_html_extract_args', $extract, $template_name, $args );

		if ( $extract && \is_array( $args ) ) {

			$created_vars_count = extract( $args, EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract

			// Protecting existing scope from modification.
			if ( count( $args ) !== $created_vars_count ) {
				throw new \RuntimeException( 'Extraction failed: variable names are clashing with the existing ones.' );
			}
		}

		require $located;
	}

	/**
	 * Like self::include_html, but returns the HTML instead of including.
	 *
	 * @since 1.5.4
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments.
	 * @param bool   $extract       Extract arguments.
	 *
	 * @return string
	 */
	public static function get_html( $template_name, $args = array(), $extract = false ) {

		\ob_start();
		self::include_html( $template_name, $args, $extract );
		return \ob_get_clean();
	}
}
