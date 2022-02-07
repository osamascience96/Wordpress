<?php
/**
 * Content Background - Dynamic CSS
 *
 * @package astra
 * @since 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'astra_dynamic_theme_css', 'astra_content_background_css', 11 );

/**
 * Content Background - Dynamic CSS
 *
 * @param  string $dynamic_css          Astra Dynamic CSS.
 * @return String Generated dynamic CSS for content background.
 *
 * @since 3.2.0
 */
function astra_content_background_css( $dynamic_css ) {

	if ( ! astra_has_gcp_typo_preset_compatibility() ) {
		return $dynamic_css;
	}

	$content_bg_obj = astra_get_option( 'content-bg-obj-responsive' );
	$blog_layout    = astra_get_option( 'blog-layout' );
	$blog_grid      = astra_get_option( 'blog-grid' );

	// Container Layout Colors.
	$separate_container_css = array(
		'.ast-separate-container .ast-article-single:not(.ast-related-post), .ast-separate-container .comments-area .comment-respond,.ast-separate-container .comments-area .ast-comment-list li, .ast-separate-container .ast-woocommerce-container, .ast-separate-container .error-404, .ast-separate-container .no-results, .single.ast-separate-container .ast-author-meta, .ast-separate-container .related-posts-title-wrapper, .ast-separate-container.ast-two-container #secondary .widget,.ast-separate-container .comments-count-wrapper, .ast-box-layout.ast-plain-container .site-content,.ast-padded-layout.ast-plain-container .site-content, .ast-separate-container .comments-area .comments-title' => astra_get_responsive_background_obj( $content_bg_obj, 'desktop' ),
	);
	// Container Layout Colors.
	$separate_container_css_tablet = array(
		'.ast-separate-container .ast-article-single:not(.ast-related-post), .ast-separate-container .comments-area .comment-respond,.ast-separate-container .comments-area .ast-comment-list li, .ast-separate-container .ast-woocommerce-container, .ast-separate-container .error-404, .ast-separate-container .no-results, .single.ast-separate-container .ast-author-meta, .ast-separate-container .related-posts-title-wrapper, .ast-separate-container.ast-two-container #secondary .widget,.ast-separate-container .comments-count-wrapper, .ast-box-layout.ast-plain-container .site-content,.ast-padded-layout.ast-plain-container .site-content, .ast-separate-container .comments-area .comments-title' => astra_get_responsive_background_obj( $content_bg_obj, 'tablet' ),
	);

	// Container Layout Colors.
	$separate_container_css_mobile = array(
		'.ast-separate-container .ast-article-single:not(.ast-related-post), .ast-separate-container .comments-area .comment-respond,.ast-separate-container .comments-area .ast-comment-list li, .ast-separate-container .ast-woocommerce-container, .ast-separate-container .error-404, .ast-separate-container .no-results, .single.ast-separate-container .ast-author-meta, .ast-separate-container .related-posts-title-wrapper, .ast-separate-container.ast-two-container #secondary .widget,.ast-separate-container .comments-count-wrapper, .ast-box-layout.ast-plain-container .site-content,.ast-padded-layout.ast-plain-container .site-content, .ast-separate-container .comments-area .comments-title' => astra_get_responsive_background_obj( $content_bg_obj, 'mobile' ),
	);

	// Blog Pro Layout Colors.
	if ( 'blog-layout-1' == $blog_layout && 1 != $blog_grid ) {
		$blog_layouts        = array(
			'.ast-separate-container .blog-layout-1, .ast-separate-container .blog-layout-2, .ast-separate-container .blog-layout-3' => astra_get_responsive_background_obj( $content_bg_obj, 'desktop' ),
		);
		$blog_layouts_tablet = array(
			'.ast-separate-container .blog-layout-1, .ast-separate-container .blog-layout-2, .ast-separate-container .blog-layout-3' => astra_get_responsive_background_obj( $content_bg_obj, 'tablet' ),
		);
		$blog_layouts_mobile = array(
			'.ast-separate-container .blog-layout-1, .ast-separate-container .blog-layout-2, .ast-separate-container .blog-layout-3' => astra_get_responsive_background_obj( $content_bg_obj, 'mobile' ),
		);
	} else {
		$blog_layouts        = array(
			'.ast-separate-container .ast-article-post' => astra_get_responsive_background_obj( $content_bg_obj, 'desktop' ),
		);
		$blog_layouts_tablet = array(
			'.ast-separate-container .ast-article-post' => astra_get_responsive_background_obj( $content_bg_obj, 'tablet' ),
		);
		$blog_layouts_mobile = array(
			'.ast-separate-container .ast-article-post' => astra_get_responsive_background_obj( $content_bg_obj, 'mobile' ),
		);
		$inner_layout        = array(
			'.ast-separate-container .blog-layout-1, .ast-separate-container .blog-layout-2, .ast-separate-container .blog-layout-3' => array(
				'background-color' => 'transparent',
				'background-image' => 'none',
			),
		);
		$dynamic_css        .= astra_parse_css( $inner_layout );
	}

	$dynamic_css .= astra_parse_css( $blog_layouts );
	/** @psalm-suppress InvalidArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	$dynamic_css .= astra_parse_css( $blog_layouts_tablet, '', astra_get_tablet_breakpoint() );
	/** @psalm-suppress InvalidArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	$dynamic_css .= astra_parse_css( $blog_layouts_mobile, '', astra_get_mobile_breakpoint() );
	$dynamic_css .= astra_parse_css( $separate_container_css );
	/** @psalm-suppress InvalidArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	$dynamic_css .= astra_parse_css( $separate_container_css_tablet, '', astra_get_tablet_breakpoint() );
	/** @psalm-suppress InvalidArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
	$dynamic_css .= astra_parse_css( $separate_container_css_mobile, '', astra_get_mobile_breakpoint() );

	return $dynamic_css;
}
