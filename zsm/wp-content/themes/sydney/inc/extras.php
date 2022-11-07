<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Sydney
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function sydney_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$menu_style = get_theme_mod( 'menu_style', 'inline' );
	$classes[] = 'menu-' . esc_attr( $menu_style );

	$sidebar_archives 		= get_theme_mod( 'sidebar_archives', 1 );
	$sidebar_single_post 	= get_theme_mod( 'sidebar_single_post', 1 );

	if ( ( !is_singular() && !$sidebar_archives ) || ( is_singular( 'post' ) && !$sidebar_single_post ) ) {
		$classes[] = 'no-sidebar';
	} 

	//Transparent header
	global $post;
	if ( isset( $post ) ) {
		$transparent_menu = get_post_meta( $post->ID, '_sydney_transparent_menu', true );
		if ( $transparent_menu ) {
			$classes[] = 'transparent-header';
		}
	}

	//Customizer transparent header
	$transparent_header = sydney_get_display_conditions( 'transparent_header', false );
	if ( $transparent_header ) {
		$classes[] = 'transparent-header';
	}
	
	return $classes;
}
add_filter( 'body_class', 'sydney_body_classes' );

/**
 * Support for Yoast SEO breadcrumbs
 */
function sydney_yoast_seo_breadcrumbs() {
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('
		<p class="sydney-breadcrumbs">','</p>
		');
	}
}

/**
 * Additional classes for main content area on pages
 */
function sydney_page_content_classes() {
	global $post;

	if ( class_exists( 'Woocommerce' ) && is_woocommerce() ) {
		$archive_check 			= sydney_wc_archive_check();
		$shop_single_sidebar	= get_theme_mod( 'swc_sidebar_products', 0 );  
		$archive_sidebar 		= get_theme_mod( 'shop_archive_sidebar', 'sidebar-left' );
	
		if ( is_product() ) {
			if ( $shop_single_sidebar ) {
				$cols = 'col-md-12';
			} else {
				$cols = 'col-md-9';
			}
		} elseif ( $archive_check ) {
			$shop_categories_layout = get_theme_mod( 'shop_categories_layout', 'layout1' );
		
			if ( 'no-sidebar' === $archive_sidebar ) {
				remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
				$columns = 'col-md-12';
			} else {
				$columns = 'col-md-9';
			}
		
			if ( 'sidebar-top' === $archive_sidebar ) {
				$shop_archive_sidebar_top_columns = get_theme_mod( 'shop_archive_sidebar_top_columns', '4' );
		
				$archive_sidebar .= ' sidebar-top-columns-' . $shop_archive_sidebar_top_columns;
			}
		
			$archive_sidebar .= ' product-category-item-' . $shop_categories_layout;
			
			$layout = get_theme_mod( 'shop_archive_layout', 'product-grid' );	
		
			$cols = $archive_sidebar . ' ' . $layout . ' ' . $columns;
		}

		
		return $cols;
	}	

	$sidebar_archives = get_theme_mod( 'sidebar_archives', 1 );

	if ( !is_singular() && !$sidebar_archives ) {
		return 'col-md-12';
	} 
	
	$disable_sidebar_pages 	= get_theme_mod( 'fullwidth_pages', 0 );

	if ( is_page() && $disable_sidebar_pages ) {
		return 'no-sidebar';
	} elseif ( is_singular( 'post' ) ) {
		$disable_sidebar 		= get_post_meta( $post->ID, '_sydney_page_disable_sidebar', true );
		$sidebar_single_post 	= get_theme_mod( 'sidebar_single_post', 1 );

		if ( $disable_sidebar || !$sidebar_single_post ) {
			return 'no-sidebar';
		}
	} elseif ( is_singular() ) {

		$post_type = get_post_type();
		$enable = get_theme_mod( 'sidebar_single_' . $post_type, 1 );

		if ( !$enable ) {
			return 'no-sidebar';
		}
	}	

	return 'col-md-9'; //default

}
add_filter( 'sydney_content_area_class', 'sydney_page_content_classes' );

/**
 * Sidebar output function
 * 
 * hooked into sydney_get_sidebar
 */
function sydney_get_sidebar() {

	if ( false == apply_filters( 'sydney_show_sidebar', true ) ) {
		return;
	}

	if ( apply_filters( 'sydney_disable_cart_checkout_sidebar', true ) && class_exists( 'WooCommerce' ) && ( is_checkout() || is_cart() ) ) {
		return; //we don't want a sidebar on the checkout and cart page
	}

	global $post;

	$sidebar_archives 		= get_theme_mod( 'sidebar_archives', 1 );

	$disable_sidebar_pages 	= get_theme_mod( 'fullwidth_pages', 0 );

	if ( is_page() && $disable_sidebar_pages ) {
		return;
	}

	if ( !is_singular() && !$sidebar_archives ) {
		return;
	} elseif ( is_singular() && isset( $post ) ) {
		$disable_sidebar 			= get_post_meta( $post->ID, '_sydney_page_disable_sidebar', true );
		
		if ( is_singular( 'post' ) ) {
			$sidebar_customizer = get_theme_mod( 'sidebar_single_post', 1 );
		} else {
			$sidebar_customizer = true;
		}

		if ( $disable_sidebar || !$sidebar_customizer ) {
			return;
		}
	}

	get_sidebar();

}
add_action( 'sydney_get_sidebar', 'sydney_get_sidebar' );

/**
 * Custom header button
 */
function sydney_add_header_menu_button( $items, $args ) {

    if ( get_option( 'sydney-update-header' ) ) {
        return $items;
    }	

	$type = get_theme_mod( 'header_button_html', 'nothing' );

    if ( $args -> theme_location == 'primary' ) {
		if ( 'button' == $type ) {
			$link 	= get_theme_mod( 'header_custom_item_btn_link', 'https://example.org/' );
			$text 	= get_theme_mod( 'header_custom_item_btn_text', __( 'Get in touch', 'sydney' ) );
			$target = get_theme_mod( 'header_custom_item_btn_target', 1 );
			if ( $target ) {
				$target = '_blank';
			} else {
				$target = '_self';
			}

			$items .= '<li class="header-custom-item"><a class="header-button roll-button" target="' . $target . '" href="' . esc_url( $link ) . '" title="' . esc_attr( $text ) . '">' . esc_html( $text ) . '</a></li>';
		} elseif ( 'html' == $type ) {
			$content = get_theme_mod( 'header_custom_item_html' );

			$items .= '<li class="header-custom-item">' . wp_kses_post( $content ) . '</li>';
		}
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'sydney_add_header_menu_button', 11, 2 );

/**
 * Menu container
 */
if ( !function_exists( 'sydney_menu_container' ) ) {
	function sydney_menu_container() {
		$type = get_theme_mod( 'menu_container', 'container' );

		return $type;
	}
}

/**
 * Get image alts
 */
function sydney_image_alt( $image ) {
	
	$id 	= attachment_url_to_postid( $image );
	$alt 	= get_post_meta( $id, '_wp_attachment_image_alt', true) ;

	if ( $alt ) {
		return $alt;
	}
}

/**
 * Check AMP endpoint
 */
function sydney_is_amp() {
	return function_exists( 'amp_is_request' ) && amp_is_request();
}

/**
 * Update fontawesome ajax callback
 */
function sydney_update_fontawesome_callback() {
	check_ajax_referer( 'sydney-fa-updt-nonce', 'nonce' );

	update_option( 'sydney-fontawesome-v5', true );

	wp_send_json( array(
		'success' => true
	) );
}
add_action( 'wp_ajax_sydney_update_fontawesome_callback', 'sydney_update_fontawesome_callback' );

/**
 * Check which version of fontawesome is active 
 * and return the needed class prefix
 */
function sydney_get_fontawesome_prefix( $v5_prefix = '' ) {
	$fa_prefix = 'fa '; // v4
	if( get_option( 'sydney-fontawesome-v5' ) ) {
		$fa_prefix = $v5_prefix;
	}

	return $fa_prefix;
}

/*
* Append gotop button html on footer
* Ensure compatibility with plugins that handle with footer like header/footer builders
*/
function sydney_append_gotop_html() {
	
	$enable = get_theme_mod( 'enable_scrolltop', 1 );

	if ( !$enable ) {
		return;
	}

	$type 		= get_theme_mod( 'scrolltop_type', 'icon' );			
	$text 		= get_theme_mod( 'scrolltop_text', esc_html__( 'Back to top', 'sydney' ) );	
	$icon		= get_theme_mod( 'scrolltop_icon', 'icon2' );
	$visibility = get_theme_mod( 'scrolltop_visibility', 'all' );
	$position 	= get_theme_mod( 'scrolltop_position', 'right' );

	echo '<a on="tap:toptarget.scrollTo(duration=200)" class="go-top visibility-' . esc_attr( $visibility ) . ' position-' . esc_attr( $position ) . '">';
	if ( 'text' === $type ) {
		echo '<span>' . esc_html( $text ) . '</span>';
	}
	echo 	'<i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-btt-' . $icon, false ) . '</i>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</a>';

}
add_action('wp_footer', 'sydney_append_gotop_html', 1);

/**
 * Get social network
 */
function sydney_get_social_network( $social ) {

	$networks = array( 'facebook', 'twitter', 'instagram', 'github', 'linkedin', 'youtube', 'xing', 'flickr', 'dribbble', 'vk', 'weibo', 'vimeo', 'mix', 'behance', 'spotify', 'soundcloud', 'twitch', 'bandcamp', 'etsy', 'pinterest', 'amazon', 'tiktok', 'telegram', 'whatsapp', 'wa.me', 't.me' );

	foreach ( $networks as $network ) {
		$found = strpos( $social, $network );

		if ( $found !== false ) {
			return $network;
		}
	}
}

/**
 * Social profile list
 */
function sydney_social_profile( $location ) {
		
	$social_links = get_theme_mod( $location );

	if ( !$social_links ) {
		return;
	}

	$social_links = explode( ',', $social_links );

	$items = '<div class="social-profile">';
	foreach ( $social_links as $social ) {
		$network = sydney_get_social_network( $social );
		if ( $network ) {
			$items .= '<a target="_blank" href="' . esc_url( $social ) . '"><i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-' . esc_html( $network ), false ) . '</i></a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
	$items .= '</div>';

	echo $items; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Footer credits
 */
function sydney_footer_credits() {

	/* translators: %1$1s, %2$2s theme copyright tags*/
	$credits 	= get_theme_mod( 'footer_credits', sprintf( esc_html__( '%1$1s. Proudly powered by %2$2s', 'sydney' ), '{copyright} {year} {site_title}', '{theme_author}' ) );

	$tags 		= array( '{theme_author}', '{site_title}', '{copyright}', '{year}' );
	$replace 	= array( '<a rel="nofollow" href="https://athemes.com/theme/sydney/">' . esc_html__( 'Sydney', 'sydney' ) . '</a>', get_bloginfo( 'name' ), '&copy;', date('Y') );

	$credits 	= str_replace( $tags, $replace, $credits );

	$credits	= '<div class="sydney-credits">' . $credits . '</div>';

	return $credits;
}

/**
 * Masonry data for HTML intialization
 */
function sydney_masonry_data() {

	$layout = get_theme_mod( 'blog_layout', 'layout2' );

	if ( 'layout5' !== $layout ) {
		return; //Output data only for the masonry layout (layout5)
	}

	$data = 'data-masonry=\'{ "itemSelector": "article", "horizontalOrder": true }\'';

	echo apply_filters( 'sydney_masonry_data', wp_kses_post( $data ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Sidebar position
 */
function sydney_sidebar_position() {

	$class = '';

	if ( !is_singular() ) {
		$sidebar_archives_position 	= get_theme_mod( 'sidebar_archives_position', 'sidebar-right' );
		$class = $sidebar_archives_position;
	} elseif ( is_singular() ) {
		global $post;

		if ( !isset( $post ) ) {
			return;
		}

		$post_type 			= get_post_type();
		$sidebar_position 	= get_theme_mod( 'sidebar_single_' . $post_type . '_position', 'sidebar-right' );

		$class = $sidebar_position;
	}

	return esc_attr( $class );
}

/**
 * Post author bio
 */
function sydney_post_author_bio() {

	$single_post_show_author_box = get_theme_mod( 'single_post_show_author_box', 0 );

	if ( !$single_post_show_author_box ) {
		return;
	}

	?>
	<div class="single-post-author">
		<div class="author-avatar vcard">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
		</div>

		<div class="author-content">
			<h3 class="author-name">
				<?php
					printf(
						/* translators: %s: Author name */
						esc_html__( 'By %s', 'sydney' ),
						esc_html( get_the_author() )
					);
				?>
			</h3>		
			<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php
					printf(
						/* translators: %s: Author name */
						__( 'See all posts by %s', 'sydney' ),// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						esc_html( get_the_author() )
					);
				?>
			</a>
		</div>
	</div>
	<?php
}
add_action( 'sydney_after_single_entry', 'sydney_post_author_bio', 21 );

/**
 * Related posts
 */
function sydney_related_posts() {

	$single_post_show_related_posts = get_theme_mod( 'single_post_show_related_posts', 0 );

	if ( !$single_post_show_related_posts ) {
		return;
	}

	$related_title 	= get_theme_mod( 'related_posts_title', esc_html__( 'You might also like:', 'sydney' ) );
    $post_id 		= get_the_ID();
    $cat_ids 		= array();
    $categories 	= get_the_category( $post_id );

    if(	!empty($categories) && !is_wp_error( $categories ) ):
        foreach ( $categories as $category ):
            array_push( $cat_ids, $category->term_id );
        endforeach;
    endif;

    $query_args = array( 
        'category__in'   	=> $cat_ids,
        'post__not_in'    	=> array( $post_id ),
        'posts_per_page'  	=> '3',
     );

    $related_cats_post = new WP_Query( $query_args );

    if( $related_cats_post->have_posts()) :
		echo '<div class="sydney-related-posts">';

			if ( '' !== $related_title ) {
				echo '<h3>' . esc_html( $related_title ) . '</h3>';
			}
			echo '<div class="row">';
			while( $related_cats_post->have_posts() ): $related_cats_post->the_post(); ?>
				<div class="col-md-4">
					<div class="related-post">
						<div class="entry-thumb">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'medium-thumb' ); ?></a>
						</div>	
						<div class="entry-meta">
							<?php sydney_posted_on(); ?>
						</div>
						<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
					</div>
				</div>
			<?php endwhile;
			echo '</div>';
		echo '</div>';

        wp_reset_postdata();
     endif;

}
add_action( 'sydney_after_single_entry', 'sydney_related_posts', 31 );

/**
 * Default header components
 */
function sydney_get_default_header_components() {
	$components = array(
		'l1'		=> array( 'search', 'woocommerce_icons' ),
		'l3left'	=> array( 'search' ),
		'l3right'	=> array( 'woocommerce_icons' ),
		'l4top'		=> array( 'search' ),
		'l4bottom'	=> array( 'woocommerce_icons' ),
		'l5topleft'	=> array(),
		'l5topright'=> array( 'woocommerce_icons' ),
		'l5bottom'	=> array( 'search' ),
		'mobile'	=> array( 'search' ),
		'offcanvas'	=> array()
	);

	return apply_filters( 'sydney_default_header_components', $components );
}

/**
 * Header layouts
 */
function sydney_header_layouts() {
	$choices = array(			
		'header_layout_1' => array(
			'label' => esc_html__( 'Layout 1', 'sydney' ),
			'url'   => '%s/images/customizer/hl1.svg'
		),
		'header_layout_2' => array(
			'label' => esc_html__( 'Layout 2', 'sydney' ),
			'url'   => '%s/images/customizer/hl2.svg'
		),		
		'header_layout_3' => array(
			'label' => esc_html__( 'Layout 3', 'sydney' ),
			'url'   => '%s/images/customizer/hl3.svg'
		),				
		'header_layout_4' => array(
			'label' => esc_html__( 'Layout 4', 'sydney' ),
			'url'   => '%s/images/customizer/hl4.svg'
		),
		'header_layout_5' => array(
			'label' => esc_html__( 'Layout 5', 'sydney' ),
			'url'   => '%s/images/customizer/hl5.svg'
		),
	);

	return apply_filters( 'sydney_header_layout_choices', $choices );
}

/**
 * Mobile header layouts
 */
function sydney_mobile_header_layouts() {
	$choices = array(			
		'header_mobile_layout_1' => array(
			'label' => esc_html__( 'Layout 1', 'sydney' ),
			'url'   => '%s/images/customizer/mhl1.svg'
		),
		'header_mobile_layout_2' => array(
			'label' => esc_html__( 'Layout 2', 'sydney' ),
			'url'   => '%s/images/customizer/mhl2.svg'
		),		
		'header_mobile_layout_3' => array(
			'label' => esc_html__( 'Layout 3', 'sydney' ),
			'url'   => '%s/images/customizer/mhl3.svg'
		),
	);

	return apply_filters( 'sydney_mobile_header_layout_choices', $choices );
}

/**
 * Header elements
 */
function sydney_header_elements() {

	$elements = array(
		'search' 			=> esc_html__( 'Search', 'sydney' ),
		'woocommerce_icons' => esc_html__( 'Cart &amp; account icons', 'sydney' ),
		'button' 			=> esc_html__( 'Button', 'sydney' ),
		'contact_info' 		=> esc_html__( 'Contact info', 'sydney' ),
	);

	return apply_filters( 'sydney_header_elements', $elements );
}

/**
 * Add submenu icons
 */
function sydney_add_submenu_icons( $item_output, $item, $depth, $args ) {

	if ( false == get_option( 'sydney-update-header' ) ) {
		return $item_output;
	}
	
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $item_output;
	}

	if ( ! empty( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
		return $item_output . '<span tabindex=0 class="dropdown-symbol"><i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-down', false ) . '</i></span>';
	}

    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'sydney_add_submenu_icons', 10, 4 );

/**
 * Google Fonts URL
 */
function sydney_google_fonts_url() {
	$fonts_url 	= '';
	$subsets 	= 'latin';

	$defaults = json_encode(
		array(
			'font' 			=> 'System default',
			'regularweight' => '400',
			'category' 		=> 'sans-serif'
		)
	);

	//Get and decode options
	$body_font		= get_theme_mod( 'sydney_body_font', $defaults );
	$headings_font 	= get_theme_mod( 'sydney_headings_font', $defaults );
	$menu_font 		= get_theme_mod( 'sydney_menu_font', $defaults );

	$body_font 		= json_decode( $body_font, true );
	$headings_font 	= json_decode( $headings_font, true );
	$menu_font 		= json_decode( $menu_font, true );

	if ( 'System default' === $body_font['font'] && 'System default' === $headings_font['font'] && 'System default' === $menu_font['font'] ) {
		return; //return early if defaults are active
	}

	$font_families = array();

	if ( 'System default' !== $body_font['font'] ) {
		if ( 'regular' === $body_font['regularweight'] ) {
			$body_font['regularweight'] = '400';
		}

		$font_families[] = $body_font['font'] . ':wght@' . $body_font['regularweight'];
	}

	if ( 'System default' !== $menu_font['font'] ) {

		if ( 'regular' === $menu_font['regularweight'] ) {
			$menu_font['regularweight'] = '400';
		}
				
		$font_families[] = $menu_font['font'] . ':wght@' . $menu_font['regularweight'];
	}	

	if ( 'System default' !== $headings_font['font'] ) {

		$old_weights = get_theme_mod( 'headings_font_weights' );
		
		if ( is_array( $old_weights ) && in_array( '400', $old_weights ) ) {
			$headings_font['regularweight'] = '400';
		}

		if ( 'regular' === $headings_font['regularweight'] ) {
			$headings_font['regularweight'] = '400';
		}		

		$font_families[] = $headings_font['font'] . ':wght@' . $headings_font['regularweight'];
	}
	
	$fonts_url = add_query_arg( array(
		'family' => implode( '&family=', $font_families ),
		'display' => 'swap',
	), 'https://fonts.googleapis.com/css2' );

	// Load google fonts locally
	$load_locally = get_theme_mod( 'perf_google_fonts_local', 0 );
	if( $load_locally ) {
		require_once get_theme_file_path( 'vendor/wptt-webfont-loader/wptt-webfont-loader.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

		return wptt_get_webfont_url( $fonts_url );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Google fonts preconnect
 */
function sydney_preconnect_google_fonts() {

	$load_locally  		= get_theme_mod( 'perf_google_fonts_local', 0 );
	$disable_preconnect = get_theme_mod( 'perf_disable_preconnect', 0 );
	if ( $load_locally || $disable_preconnect ) {
		return;
	}

	//Disable preconnect if popular plugins for local fonts are active
	if ( function_exists( 'omgf_init') || class_exists( 'EverPress\LGF' ) ) {
		return;
	}

	$defaults = json_encode(
		array(
			'font' 			=> 'System default',
			'regularweight' => 'regular',
			'category' 		=> 'sans-serif'
		)
	);	

	$body_font		= get_theme_mod( 'sydney_body_font', $defaults );
	$headings_font 	= get_theme_mod( 'sydney_headings_font', $defaults );

	$body_font 		= json_decode( $body_font, true );
	$headings_font 	= json_decode( $headings_font, true );

	if ( 'System default' === $body_font['font'] && 'System default' === $headings_font['font'] ) {
		return;
	}

	echo '<link rel="preconnect" href="//fonts.googleapis.com">';
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action( 'wp_head', 'sydney_preconnect_google_fonts' );

/**
 * Google fonts preconnect
 */
function sydney_404_page_content() {
	?>
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'sydney' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'sydney' ); ?></p>

			<?php get_search_form(); ?>

		</div><!-- .page-content -->
	</section><!-- .error-404 -->
	<?php
}
add_action( 'sydney_404_content', 'sydney_404_page_content' );

/**
 * Container layouts
 */
function sydney_single_container_layout() {

	if ( !is_singular() ) {
		return;
	}

	$post_type = get_post_type();

	$layout = get_theme_mod( $post_type . '_container_layout', 'normal' );

	//Add container type class
	add_filter( 'sydney_content_area_class', function( $class ) use ( $layout ) {
		$class .= ' container-' . $layout;

		return $class;
	} );

	if ( 'stretched' === $layout ) {
		add_filter( 'sydney_main_container', function() {
			$class = ' container-fluid';

			return $class;
		} );
	}

	//Handle the sidebar
	$enable_sidebar = get_theme_mod( 'sidebar_single_' . $post_type, 1 );
	if ( !$enable_sidebar || 'narrow' === $layout ) {
		add_filter( 'sydney_show_sidebar', '__return_false' );
	}
}
add_action( 'wp', 'sydney_single_container_layout' );