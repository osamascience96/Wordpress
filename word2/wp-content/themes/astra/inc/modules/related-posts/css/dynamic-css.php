<?php
/**
 * Related Posts - Dynamic CSS
 *
 * @package astra
 * @since 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'astra_dynamic_theme_css', 'astra_related_posts_css', 11 );

/**
 * Related Posts - Dynamic CSS
 *
 * @param  string $dynamic_css          Astra Dynamic CSS.
 * @return String Generated dynamic CSS for Related Posts.
 *
 * @since 3.4.0
 */
function astra_related_posts_css( $dynamic_css ) {

	if ( astra_target_rules_for_related_posts() ) {

		$link_color                    = astra_get_option( 'link-color' );
		$related_posts_title_alignment = astra_get_option( 'releted-posts-title-alignment' );

		// Added RTL language support for title alignment.
		if ( is_rtl() && 'center' !== $related_posts_title_alignment ) {
			$related_posts_title_alignment = ( 'left' === $related_posts_title_alignment ) ? 'right' : 'left';
		}

		// Related Posts Grid layout params.
		$related_posts_grid = astra_get_option( 'related-posts-grid-responsive' );
		$desktop_grid       = ( isset( $related_posts_grid['desktop'] ) ) ? $related_posts_grid['desktop'] : '2-equal';
		$tablet_grid        = ( isset( $related_posts_grid['tablet'] ) ) ? $related_posts_grid['tablet'] : '2-equal';
		$mobile_grid        = ( isset( $related_posts_grid['mobile'] ) ) ? $related_posts_grid['mobile'] : 'full';

		// Related Posts -> Post Title typography dyanamic stylings.
		$related_post_title_font_family    = astra_get_option( 'related-posts-title-font-family' );
		$related_post_title_font_weight    = astra_get_option( 'related-posts-title-font-weight' );
		$related_post_title_font_size      = astra_get_option( 'related-posts-title-font-size' );
		$related_post_title_line_height    = astra_get_option( 'related-posts-title-line-height' );
		$related_post_title_text_transform = astra_get_option( 'related-posts-title-text-transform' );

		// Related Posts -> Post Meta typography dyanamic stylings.
		$related_post_meta_font_family    = astra_get_option( 'related-posts-meta-font-family' );
		$related_post_meta_font_weight    = astra_get_option( 'related-posts-meta-font-weight' );
		$related_post_meta_font_size      = astra_get_option( 'related-posts-meta-font-size' );
		$related_post_meta_line_height    = astra_get_option( 'related-posts-meta-line-height' );
		$related_post_meta_text_transform = astra_get_option( 'related-posts-meta-text-transform' );

		// Related Posts -> Content typography dyanamic stylings.
		$related_post_content_font_family    = astra_get_option( 'related-posts-content-font-family' );
		$related_post_content_font_weight    = astra_get_option( 'related-posts-content-font-weight' );
		$related_post_content_font_size      = astra_get_option( 'related-posts-content-font-size' );
		$related_post_content_line_height    = astra_get_option( 'related-posts-content-line-height' );
		$related_post_content_text_transform = astra_get_option( 'related-posts-content-text-transform' );

		// Related Posts -> Section Title typography dyanamic stylings.
		$related_posts_section_title_font_family    = astra_get_option( 'related-posts-section-title-font-family' );
		$related_posts_section_title_font_size      = astra_get_option( 'related-posts-section-title-font-size' );
		$related_posts_section_title_font_weight    = astra_get_option( 'related-posts-section-title-font-weight' );
		$related_posts_section_title_line_height    = astra_get_option( 'related-posts-section-title-line-height' );
		$related_posts_section_title_text_transform = astra_get_option( 'related-posts-section-title-text-transform' );

		// Setting up container BG color by default to Related Posts's section BG color.
		$content_bg_obj     = astra_get_option( 'content-bg-obj-responsive' );
		$container_bg_color = '#ffffff';
		if ( isset( $content_bg_obj['desktop']['background-color'] ) && '' !== $content_bg_obj['desktop']['background-color'] ) {
			$container_bg_color = $content_bg_obj['desktop']['background-color'];
		}

		// Related Posts -> Color dyanamic stylings.
		$related_posts_title_color = astra_get_option( 'related-posts-title-color' );
		/** @psalm-suppress PossiblyInvalidArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
		$related_posts_bg_color              = astra_get_option( 'related-posts-background-color', $container_bg_color );
		$related_post_text_color             = astra_get_option( 'related-posts-text-color' );
		$related_posts_meta_color            = astra_get_option( 'related-posts-meta-color' );
		$related_posts_link_color            = astra_get_option( 'related-posts-link-color' );
		$related_posts_link_hover_color      = astra_get_option( 'related-posts-link-hover-color' );
		$related_posts_meta_link_hover_color = astra_get_option( 'related-posts-meta-link-hover-color' );

		$css_desktop_output = array(
			'.ast-single-related-posts-container .ast-related-posts-wrapper' => array(
				'grid-template-columns' => Astra_Builder_Helper::$grid_size_mapping[ $desktop_grid ],
			),
			'.ast-related-posts-inner-section .ast-date-meta .posted-on, .ast-related-posts-inner-section .ast-date-meta .posted-on *' => array(
				'background' => esc_attr( $link_color ),
				'color'      => astra_get_foreground_color( $link_color ),
			),
			'.ast-related-posts-inner-section .ast-date-meta .posted-on .date-month, .ast-related-posts-inner-section .ast-date-meta .posted-on .date-year' => array(
				'color' => astra_get_foreground_color( $link_color ),
			),
			'.ast-single-related-posts-container' => array(
				'background-color' => esc_attr( $related_posts_bg_color ),
			),
			/**
			 * Related Posts - Section Title
			 */
			'.ast-related-posts-title'            => array(
				'color'          => esc_attr( $related_posts_title_color ),
				'font-family'    => astra_get_css_value( $related_posts_section_title_font_family, 'font' ),
				'font-weight'    => astra_get_css_value( $related_posts_section_title_font_weight, 'font' ),
				'font-size'      => astra_responsive_font( $related_posts_section_title_font_size, 'desktop' ),
				'line-height'    => esc_attr( $related_posts_section_title_line_height ),
				'text-transform' => esc_attr( $related_posts_section_title_text_transform ),
				'text-align'     => esc_attr( $related_posts_title_alignment ),
			),
			/**
			 * Related Posts - Post Title
			 */
			'.ast-related-post-content .entry-header .ast-related-post-title, .ast-related-post-content .entry-header .ast-related-post-title a' => array(
				'font-family'    => astra_get_css_value( $related_post_title_font_family, 'font' ),
				'font-weight'    => astra_get_css_value( $related_post_title_font_weight, 'font' ),
				'font-size'      => astra_responsive_font( $related_post_title_font_size, 'desktop' ),
				'line-height'    => esc_attr( $related_post_title_line_height ),
				'text-transform' => esc_attr( $related_post_title_text_transform ),
				'color'          => esc_attr( $related_post_text_color ),
			),
			/**
			 * Related Posts - Meta
			 */
			'.ast-related-post-content .entry-meta, .ast-related-post-content .entry-meta *' => array(
				'font-family'    => astra_get_css_value( $related_post_meta_font_family, 'font' ),
				'font-weight'    => astra_get_css_value( $related_post_meta_font_weight, 'font' ),
				'font-size'      => astra_responsive_font( $related_post_meta_font_size, 'desktop' ),
				'line-height'    => esc_attr( $related_post_meta_line_height ),
				'text-transform' => esc_attr( $related_post_meta_text_transform ),
				'color'          => esc_attr( $related_posts_meta_color ),
			),
			'.ast-related-post-content .entry-meta a:hover, .ast-related-post-content .entry-meta span a span:hover' => array(
				'color' => esc_attr( $related_posts_meta_link_hover_color ),
			),
			/**
			 * Related Posts - CTA
			 */
			'.ast-related-post-cta a'             => array(
				'color' => esc_attr( $related_posts_link_color ),
			),
			'.ast-related-post-cta a:hover'       => array(
				'color' => esc_attr( $related_posts_link_hover_color ),
			),
			/**
			 * Related Posts - Content
			 */
			'.ast-related-post-excerpt'           => array(
				'font-family'    => astra_get_css_value( $related_post_content_font_family, 'font' ),
				'font-weight'    => astra_get_css_value( $related_post_content_font_weight, 'font' ),
				'font-size'      => astra_responsive_font( $related_post_content_font_size, 'desktop' ),
				'line-height'    => esc_attr( $related_post_content_line_height ),
				'text-transform' => esc_attr( $related_post_content_text_transform ),
				'color'          => esc_attr( $related_post_text_color ),
			),
		);

		if ( astra_has_global_color_format_support() ) {
			/** @psalm-suppress PossiblyInvalidArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
			$related_posts_bg_color = astra_get_option( 'related-posts-background-color', $content_bg_obj );

			if ( is_array( $related_posts_bg_color ) ) {
				$css_desktop_output['.ast-single-related-posts-container'] = astra_get_responsive_background_obj( $related_posts_bg_color, 'desktop' );
			} else {
				$css_desktop_output['.ast-single-related-posts-container'] = array(
					'background-color' => esc_attr( $related_posts_bg_color ),
				);
			}
		}

		$dynamic_css .= astra_parse_css( $css_desktop_output );

		$css_max_tablet_output = array(
			'.ast-single-related-posts-container .ast-related-posts-wrapper .ast-related-post' => array(
				'width' => '100%',
			),
			'.ast-single-related-posts-container .ast-related-posts-wrapper' => array(
				'grid-template-columns' => Astra_Builder_Helper::$grid_size_mapping[ $tablet_grid ],
			),
			'.ast-related-post-content .ast-related-post-title' => array(
				'font-size' => astra_responsive_font( $related_post_title_font_size, 'tablet' ),
			),
			'.ast-related-post-content .entry-meta *' => array(
				'font-size' => astra_responsive_font( $related_post_meta_font_size, 'tablet' ),
			),
			'.ast-related-post-excerpt'               => array(
				'font-size' => astra_responsive_font( $related_post_content_font_size, 'tablet' ),
			),
			'.ast-related-posts-title'                => array(
				'font-size' => astra_responsive_font( $related_posts_section_title_font_size, 'tablet' ),
			),
		);

		if ( astra_has_global_color_format_support() ) {
			if ( is_array( $related_posts_bg_color ) ) {
				$css_max_tablet_output['.ast-single-related-posts-container'] = astra_get_responsive_background_obj( $related_posts_bg_color, 'desktop' );
			} else {
				$css_max_tablet_output['.ast-single-related-posts-container'] = array(
					'background-color' => esc_attr( $related_posts_bg_color ),
				);
			}
		}

		$dynamic_css .= astra_parse_css( $css_max_tablet_output, '', astra_get_tablet_breakpoint() );

		$css_max_mobile_output = array(
			'.ast-single-related-posts-container .ast-related-posts-wrapper' => array(
				'grid-template-columns' => Astra_Builder_Helper::$grid_size_mapping[ $mobile_grid ],
			),
			'.ast-related-post-content .ast-related-post-title' => array(
				'font-size' => astra_responsive_font( $related_post_title_font_size, 'mobile' ),
			),
			'.ast-related-post-content .entry-meta *' => array(
				'font-size' => astra_responsive_font( $related_post_meta_font_size, 'mobile' ),
			),
			'.ast-related-post-excerpt'               => array(
				'font-size' => astra_responsive_font( $related_post_content_font_size, 'mobile' ),
			),
			'.ast-related-posts-title'                => array(
				'font-size' => astra_responsive_font( $related_posts_section_title_font_size, 'mobile' ),
			),
		);

		if ( astra_has_global_color_format_support() ) {
			if ( is_array( $related_posts_bg_color ) ) {
				$css_max_mobile_output['.ast-single-related-posts-container'] = astra_get_responsive_background_obj( $related_posts_bg_color, 'desktop' );
			} else {
				$css_max_mobile_output['.ast-single-related-posts-container'] = array(
					'background-color' => esc_attr( $related_posts_bg_color ),
				);
			}
		}

		$dynamic_css .= astra_parse_css( $css_max_mobile_output, '', astra_get_mobile_breakpoint() );

		return $dynamic_css;
	}

	return $dynamic_css;
}
