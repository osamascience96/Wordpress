<?php
/**
 * Woocommerce Compatibility 
 *
 * @package Sydney Pro
 */


if ( !class_exists('WooCommerce') )
    return;

/**
 * Declare support
 */
function sydney_wc_support() {

    $enable_zoom 	= get_theme_mod( 'single_zoom_effects', 1 );
    $enable_gallery = get_theme_mod( 'single_gallery_slider', 1 );

	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 420,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_columns' => 3,
			),
		)
	);
	
    add_theme_support( 'wc-product-gallery-lightbox' );

    if ( $enable_gallery ) {
		add_theme_support( 'wc-product-gallery-slider' );
	}
}
add_action( 'after_setup_theme', 'sydney_wc_support' );

/**
 * Add and remove actions
 */
function sydney_woo_actions() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
    add_action('woocommerce_before_main_content', 'sydney_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'sydney_wrapper_end', 10);

	$layout			   		= get_theme_mod( 'shop_archive_layout', 'product-grid' );	
	$button_layout     		= get_theme_mod( 'shop_product_add_to_cart_layout', 'layout2' );
	$quick_view_layout 		= get_theme_mod( 'shop_product_quickview_layout', 'layout1' );
	$wishlist_layout 		= get_theme_mod( 'shop_product_wishlist_layout', 'layout1' );

	//Loop image wrapper extra class
	$loop_image_wrap_extra_class = 'sydney-add-to-cart-button-'. $button_layout;
	if( 'layout1' !== $quick_view_layout ) {
		$loop_image_wrap_extra_class .= ' sydney-quick-view-button-'. $quick_view_layout;
	}

	//Remove button
	if( 'layout1' === $button_layout ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	}	

	if( 'layout1' !== $wishlist_layout ) {
		$loop_image_wrap_extra_class .= ' sydney-wishlist-button-'. $wishlist_layout;
	}


	//No sidebar for checkout, cart, account
	if ( is_cart() ) {
		add_filter( 'sydney_content_area_class', function() { 
			$shop_cart_show_cross_sell = get_theme_mod( 'shop_cart_show_cross_sell', 1 );
			$layout                    = get_theme_mod( 'shop_cart_layout', 'layout1' ); 

			if( $layout === 'layout1' && $shop_cart_show_cross_sell && count( WC()->cart->get_cross_sells() ) > 2 ) {
				$layout .= ' has-cross-sells-carousel';
			}
			
			return 'col-md-12 cart-' . esc_attr( $layout ); 
		} );
	} elseif ( is_checkout() ) {
		add_filter( 'sydney_content_area_class', function() { $layout = get_theme_mod( 'shop_checkout_layout', 'layout1' ); return 'col-md-12 checkout-' . esc_attr( $layout ); } );
	}

    //Archive layout
	if ( is_shop() || is_product_category() || is_product_tag()	) {

		if ( 'product-list' === $layout ) {
			add_action( 'woocommerce_before_shop_loop_item', function() use ($loop_image_wrap_extra_class) { echo '<div class="row valign"><div class="col-md-4"><div class="loop-image-wrap '. esc_attr( $loop_image_wrap_extra_class ) .'">'; }, 1 );
			add_action( 'woocommerce_before_shop_loop_item_title', function() { echo '</div></div><div class="col-md-8">'; }, 11 );
			add_action( 'woocommerce_after_shop_loop_item', function() { echo '</div>'; }, PHP_INT_MAX );
		}

		$page_title 		= get_theme_mod( 'shop_page_title', 1 );
		$page_desc 			= get_theme_mod( 'shop_page_description', 1);
		$shop_breadcrumbs 	= get_theme_mod( 'shop_breadcrumbs', 1 );

		if ( !$page_title ) {
			add_filter( 'woocommerce_show_page_title', '__return_false' );
		}
	
		if ( !$page_desc ) {
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
			remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description' );
		}
		
		if ( !$shop_breadcrumbs ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		}

		
		
		//Results and sorting
		$shop_results_count 	= get_theme_mod( 'shop_results_count', 1 );
		$shop_product_sorting 	= get_theme_mod( 'shop_product_sorting', 1 );

		if ( !$shop_product_sorting ) {
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		}

		if ( !$shop_results_count ) {
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		}	

		//Cart cross sell
		$cart_layout               = get_theme_mod( 'shop_cart_layout', 'layout1' );
		$shop_cart_show_cross_sell = get_theme_mod( 'shop_cart_show_cross_sell', 1 );

		if( !$shop_cart_show_cross_sell ) {
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		}
		add_filter( 'woocommerce_cross_sells_columns', function() use ($cart_layout) {
			return 'layout1' === $cart_layout ? 2 : 3;
		} );
		add_filter( 'woocommerce_cross_sells_total', function() use ($cart_layout) {
			return -1;
		} );

		//Cart total sticky
		$shop_cart_sticky_totals_box = get_theme_mod( 'shop_cart_sticky_totals_box', 0 );

		if( $shop_cart_sticky_totals_box && $cart_layout === 'layout2' ) {
			add_action( 'woocommerce_before_cart', function(){ echo '<div class="cart-totals-sticky"></div>'; }, 999 );
		}		

		/**
		 * Loop product structure
		 */

		//Move link close tag
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 12 );

		//Wrap loop image
		if ( 'product-grid' === $layout || is_product() ) {
			//Wrap loop image
			add_action( 'woocommerce_before_shop_loop_item_title', function() use ($loop_image_wrap_extra_class) { echo '<div class="loop-image-wrap '. esc_attr( $loop_image_wrap_extra_class ) .'">'; }, 9 );
			add_action( 'woocommerce_before_shop_loop_item_title', function() { echo '</div>'; }, 11 );
		}

		if ( 'product-grid' === $layout ) {
			//Move button inside image wrap
			if ( 'layout4' === $button_layout && 'layout3' !== $quick_view_layout || 'layout3' === $button_layout && 'layout2' !== $quick_view_layout ) {
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
				add_action( 'woocommerce_before_shop_loop_item_title', function() { sydney_wrap_loop_button_start(); woocommerce_template_loop_add_to_cart(); echo '</div>'; } );
			}
		} else {
			//Move button inside image wrap
			if ( 'layout4' === $button_layout && 'layout3' !== $quick_view_layout || 'layout3' === $button_layout && 'layout2' !== $quick_view_layout ) {
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
				add_action( 'woocommerce_before_shop_loop_item_title', function() { sydney_wrap_loop_button_start(); woocommerce_template_loop_add_to_cart(); echo '</div>'; } );
			}
		}

		//Remove product title, rating, price
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );

		//Add elements from sortable option
		add_action( 'woocommerce_after_shop_loop_item', 'sydney_loop_product_structure', 9 );

	}

	//Single product settings
	if ( is_product() ) {
		$single_breadcrumbs 			= get_theme_mod( 'single_breadcrumbs', 1 );
		$single_tabs					= get_theme_mod( 'single_product_tabs', 1 );
		$single_related					= get_theme_mod( 'single_related_products', 1 );
		$single_upsell					= get_theme_mod( 'single_upsell_products', 1 );
		$single_sticky_add_to_cart		= get_theme_mod( 'single_sticky_add_to_cart', 0 );
		$single_product_gallery         = get_theme_mod( 'single_product_gallery', 'gallery-default' );

		add_action( 'woocommerce_before_add_to_cart_button', 'sydney_single_addtocart_wrapper_open' );
		add_action( 'woocommerce_after_add_to_cart_button', 'sydney_single_addtocart_wrapper_close' );

		//Gallery
		if( 'gallery-grid' === $single_product_gallery || 'gallery-scrolling' === $single_product_gallery ) {
			remove_theme_support( 'wc-product-gallery-slider' );
			remove_theme_support( 'wc-product-gallery-zoom' );
			add_action( 'woocommerce_single_product_summary', function(){ echo '<div class="sticky-entry-summary">'; }, -99 );
			add_action( 'woocommerce_single_product_summary', function(){ echo '</div>'; }, 99 );
			add_filter( 'woocommerce_gallery_image_size', function(){ return 'woocommerce_single'; } );
		}

		if( 'gallery-showcase' === $single_product_gallery ) {
			remove_theme_support( 'wc-product-gallery-zoom' );
			add_action( 'woocommerce_single_product_summary', function(){ echo '<div class="sticky-entry-summary">'; }, -99 );
			add_action( 'woocommerce_single_product_summary', function(){ echo '</div>'; }, 99 );
		}

		if( 'gallery-full-width' === $single_product_gallery ) {
			remove_theme_support( 'wc-product-gallery-zoom' );
			add_action( 'woocommerce_single_product_summary', function(){ echo '<div class="gallery-full-width-title-wrapper">'; }, 0 );
			add_action( 'woocommerce_single_product_summary', function(){ echo '</div><div class="gallery-full-width-addtocart-wrapper">'; }, 20 );
			add_action( 'woocommerce_single_product_summary', function(){ echo '</div>'; }, 99 );
		}

		//Breadcrumbs
		if ( !$single_breadcrumbs ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		}

		//Product tabs
		if ( !$single_tabs ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
		}

		//Related products
		if ( !$single_related ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}	
		
		//Upsell products
		if ( !$single_upsell ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		}	
		add_filter( 'woocommerce_upsells_columns', function() { return 3; } );
		add_filter( 'woocommerce_upsells_total', function() { return -1; } );
		
		//Move sale tag
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
		add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 99 );

		// Sticky add to cart
		if( $single_sticky_add_to_cart ) {
			$single_sticky_add_to_cart_position = get_theme_mod( 'single_sticky_add_to_cart_position', 'bottom' );

			if( $single_sticky_add_to_cart_position === 'bottom' ) {
				add_action( 'sydney_footer_before', 'sydney_single_sticky_add_to_cart' );
			} else {
				add_action( 'sydney_page_header', 'sydney_single_sticky_add_to_cart' );
			}
		}
	}   

	$shop_cart_show_cross_sell = get_theme_mod( 'shop_cart_show_cross_sell', 1 );
	$button_layout     			= get_theme_mod( 'shop_product_add_to_cart_layout', 'layout2' );
	$quick_view_layout 			= get_theme_mod( 'shop_product_quickview_layout', 'layout1' );
	$wishlist_layout 			= get_theme_mod( 'shop_product_wishlist_layout', 'layout1' );

	//Quick view and wishlist buttons
	if ( is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() && $shop_cart_show_cross_sell ) {
		if( 'layout1' !== $quick_view_layout || 'layout1' !== $wishlist_layout ) {
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );
		}

		if( 'layout1' !== $quick_view_layout ) {
			add_action( 'woocommerce_before_shop_loop_item_title', 'sydney_quick_view_button', 10 );
			
			//Quick view popup
			add_action( 'wp_body_open', 'sydney_quick_view_popup' );
			
			// Do not include on single product pages
			if ( current_theme_supports( 'wc-product-gallery-lightbox' ) && false === is_product() ) {
				add_action( 'sydney_footer_after', function(){
					wc_get_template( 'single-product/photoswipe.php' );
				} );
			}
		}

		if( 'layout1' !== $wishlist_layout ) {
			add_action( 'woocommerce_before_shop_loop_item_title', 'sydney_wishlist_button', 10 );
		}
	}	
				
	//Move cart collaterals
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals' );
	add_action( 'woocommerce_before_cart_collaterals', 'woocommerce_cart_totals' );

}
add_action('wp','sydney_woo_actions');

/**
 * Theme wrappers
 */
function sydney_wrapper_start() {

    echo '<div id="primary" class="content-area ' . esc_attr( apply_filters( 'sydney_content_area_class', '' ) ) . '">';
        echo '<main id="main" class="site-main" role="main">';
}

function sydney_wrapper_end() {
        echo '</main>';
    echo '</div>';
}

/**
 * Remove default WooCommerce CSS
 */
function sydney_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-general'] ); 
    return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'sydney_dequeue_styles' );

/**
 * Enqueue custom CSS for Woocommerce
 */
function sydney_woocommerce_css() {
    wp_enqueue_style( 'sydney-wc-css', get_template_directory_uri() . '/woocommerce/css/wc.min.css', array(), '20220616' );


	//Enqueue gallery scripts for quick view
	$shop_cart_show_cross_sell = get_theme_mod( 'shop_cart_show_cross_sell', 1 );
	
	if ( is_shop() || is_product_category() || is_product_tag() || is_cart() && $shop_cart_show_cross_sell ) {
		$quick_view_layout = get_theme_mod( 'shop_product_quickview_layout', 'layout1' );
		
		if( 'layout1' !== $quick_view_layout ) {
			$register_scripts = array();
			
			if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
				$register_scripts['flexslider'] = array(
					'src'     => plugins_url( 'assets/js/flexslider/jquery.flexslider.min.js', WC_PLUGIN_FILE ),
					'deps'    => array( 'jquery' )
				);
			}
			if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
				$register_styles = array(
					'photoswipe' => array(
						'src'     => plugins_url( 'assets/css/photoswipe/photoswipe.min.css', WC_PLUGIN_FILE ),
						'deps'    => array()
					),
					'photoswipe-default-skin' => array(
						'src'     => plugins_url( 'assets/css/photoswipe/default-skin/default-skin.min.css', WC_PLUGIN_FILE ),
						'deps'    => array( 'photoswipe' )
					)
				);
				foreach ( $register_styles as $name => $props ) {
					wp_enqueue_style( $name, $props['src'], $props['deps'], '20211020' );
				}

				$register_scripts['photoswipe'] = array(
					'src'     => plugins_url( 'assets/js/photoswipe/photoswipe.min.js', WC_PLUGIN_FILE ),
					'deps'    => array()
				);
				$register_scripts['photoswipe-ui-default'] = array(
					'src'     => plugins_url( 'assets/js/photoswipe/photoswipe-ui-default.min.js', WC_PLUGIN_FILE ),
					'deps'    => array( 'photoswipe' )
				);
			}

			$register_scripts['wc-single-product'] = array(
				'src'     => plugins_url( 'assets/js/frontend/single-product.min.js', WC_PLUGIN_FILE ),
				'deps'    => array( 'jquery' )
			);

			if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
				$register_scripts['zoom'] = array(
					'src'     => plugins_url( 'assets/js/zoom/jquery.zoom.min.js', WC_PLUGIN_FILE ),
					'deps'    => array( 'jquery' )
				);
			}

			// Enqueue variation scripts.
			$register_scripts['wc-add-to-cart-variation'] = array(
				'src'     => plugins_url( 'assets/js/frontend/add-to-cart-variation.min.js', WC_PLUGIN_FILE ),
				'deps'    => array( 'jquery', 'wp-util', 'jquery-blockui' )
			);

			foreach ( $register_scripts as $name => $props ) {
				wp_enqueue_script( $name, $props['src'], $props['deps'], '20211020' );
			}

		}
	}

}
add_action( 'wp_enqueue_scripts', 'sydney_woocommerce_css', 1 );

/**
 * Number of related products
 */
function sydney_related_products_args( $args ) {
    $args['posts_per_page'] = 3;
    $args['columns'] = 3;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'sydney_related_products_args' );

/**
 * Variable products button
 */
function sydney_single_variation_add_to_cart_button() {
    global $product;
    ?>
	<div class="woocommerce-variation-add-to-cart variations_button">
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

		<button type="submit" class="single_add_to_cart_button roll-button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />
	</div>

     <?php
}
add_action( 'woocommerce_single_variation', 'sydney_single_variation_add_to_cart_button', 21 );

if ( ! function_exists( 'sydney_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function sydney_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		?>

		<span class="cart-count"><i class="sydney-svg-icon"><?php sydney_get_svg_icon( 'icon-cart', true ); ?></i><span class="count-number"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span></span>

		<?php
		$fragments['.cart-count'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'sydney_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'sydney_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function sydney_woocommerce_cart_link() {

		$link = '<a class="cart-contents" href="' . esc_url( wc_get_cart_url() ) . '" title="' . esc_attr__( 'View your shopping cart', 'sydney' ) . '">';
		$link .= '<span class="cart-count"><i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-cart', false ) . '</i><span class="count-number">' . esc_html( WC()->cart->get_cart_contents_count() ) . '</span></span>';
		$link .= '</a>';

		return $link;
	}
}

if ( ! function_exists( 'sydney_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function sydney_woocommerce_header_cart() {
		$show_cart 		= get_theme_mod( 'enable_header_cart', 1 );
		$show_account 	= get_theme_mod( 'enable_header_account', 1 );

		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>

		<?php if ( $show_account ) : ?>
		<?php echo '<a class="header-item wc-account-link" href="' . esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) . '" title="' . esc_html__( 'Your account', 'sydney' ) . '"><i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-user', false ) . '</i></a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>	

		<?php if ( $show_cart ) : ?>
		<div id="site-header-cart" class="site-header-cart header-item">
			<div class="<?php echo esc_attr( $class ); ?>">
				<?php echo sydney_woocommerce_cart_link();  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<?php
			$instance = array(
				'title' => esc_html__( 'Your cart', 'sydney' ),
			);

			the_widget( 'WC_Widget_Cart', $instance );
			?>
		</div>
		<?php endif; ?>
		<?php
	}
}

/**
 * Show product descriptions when layout is set to 1 column
 */
function sydney_shop_descriptions() { 
    $number = get_theme_mod( 'swc_columns_number', 3 );

    if ( $number == 1 ) {
        the_excerpt(); 
    }
} 
add_action( 'woocommerce_after_shop_loop_item_title', 'sydney_shop_descriptions', 11, 2); 

/**
 * Returns true if current page is shop, product archive or product tag
 */
function sydney_wc_archive_check() {
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Remove sidebar from all archives
 */
function sydney_remove_wc_sidebar_archives() {
    $archive_check = sydney_wc_archive_check();
    $rs_archives = get_theme_mod( 'swc_sidebar_archives' );
    $rs_products = get_theme_mod( 'swc_sidebar_products' );

    if ( ( $rs_archives && $archive_check ) || ( $rs_products && is_product() ) ) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }   
}
add_action( 'wp', 'sydney_remove_wc_sidebar_archives' );

/**
 * Add SVG cart icon to loop add to cart button
 */
function sydney_add_loop_cart_icon( $icon, $product, $args ) {

    global $product;

    $type = $product->get_type();
    
    if ( 'simple' == $type ) {
        $icon = '<span><i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-add-cart', false ) . '</i></span> ';
    } else {
        $icon = '';
    }

	return sprintf(
		'<div class="loop-button-wrapper"><a href="%s" data-quantity="%s" class="%s" %s>' . $icon . '%s</a></div>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		esc_html( $product->add_to_cart_text() )
    );  

}
if ( !function_exists( 'tutor' ) ) {
	add_filter( 'woocommerce_loop_add_to_cart_link', 'sydney_add_loop_cart_icon', 10, 3 );
}

/**
 * Filter quick view button from YITH to remove the text
 */
function sydney_filter_yith_wcqv_button() {

    global $product;
    
    $product_id = $product->get_id();

    $button = '<a href="#" class="yith-wcqv-button" data-product_id="' . esc_attr( $product_id ) . '">' . sydney_get_svg_icon( 'icon-search', false ) . '</a>';
    return $button;
}
add_filter( 'yith_add_quick_view_button_html', 'sydney_filter_yith_wcqv_button' );

/**
 * Add placeholder for YITH buttons
 */
function sydney_add_yith_placeholder() {
    echo '<div class="yith-placeholder"></div>';
}
add_action( 'woocommerce_before_shop_loop_item', 'sydney_add_yith_placeholder' );

/**
 * Remove additional titles from Woocommerce tabs
 */
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
add_filter( 'woocommerce_product_description_heading', '__return_false' );

/**
 * Set single product gallery thumbnail columns
 */
function sydney_woocommerce_product_thumbnails_columns() { 

    $columns = get_theme_mod( 'swc_gallery_columns', 4 );

    return $columns; 
}; 
add_filter( 'woocommerce_product_thumbnails_columns', 'sydney_woocommerce_product_thumbnails_columns', 10, 1 ); 

/**
 * Remove breadcrumbs on single products (legacy)
 */
function sydney_remove_wc_breadcrumbs() {

    $disable_breadcrumbs = get_theme_mod( 'swc_disable_single_breadcrumbs' );

    if ( is_product() && $disable_breadcrumbs ) {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    }
}
add_action( 'wp', 'sydney_remove_wc_breadcrumbs' );

/**
 * Legacy functions
 */

/**
 * Update cart
 */
function sydney_header_add_to_cart_fragment( $fragments ) {

    ob_start();
    ?>
    <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>"><i class="sydney-svg-icon"><?php sydney_get_svg_icon( 'icon-cart', true ); ?></i><span class="cart-amount"><?php echo WC()->cart->cart_contents_count; ?></span></a>
    <?php
    
    $fragments['a.cart-contents'] = ob_get_clean();
    
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'sydney_header_add_to_cart_fragment' );

/**
 * Add cart to menu
 */
function sydney_nav_cart ( $items, $args ) {

    $swc_show_cart_menu = get_theme_mod('swc_show_cart_menu');
    if ( $swc_show_cart_menu ) {
        if ( $args -> theme_location == 'primary' ) {
            $items .= '<li class="nav-cart"><a class="cart-contents" href="' . wc_get_cart_url() . '"><i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-cart', false ) . '</i><span class="cart-amount">' . WC()->cart->cart_contents_count . '</span></a></li>';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'sydney_nav_cart', 10, 2 );

/**
 * Woocommerce account link in header
 */
function sydney_woocommerce_account_link( $items, $args ) {
    $swc_show_cart_menu = get_theme_mod('swc_show_cart_menu');
    if ( $swc_show_cart_menu && ( $args -> theme_location == 'primary' ) ) {
        if ( is_user_logged_in() ) {
            $account = __( 'My Account', 'sydney' );
        } else {
            $account = __( 'Login/Register', 'sydney' );
        }
        $items .= '<li class="header-account"><a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" title="' . $account . '"><i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-user', false ) . '</i></a></li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'sydney_woocommerce_account_link', 10, 2 );

/**
 * Single product top area wrapper
 */
function sydney_single_product_wrap_before() {
	$single_product_gallery = get_theme_mod( 'single_product_gallery', 'gallery-default' );

	echo '<div class="product-gallery-summary clearfix ' . esc_attr( $single_product_gallery ) . '">';
}
add_action( 'woocommerce_before_single_product_summary', 'sydney_single_product_wrap_before', -99 );

/**
 * Single product top area wrapper
 */
function sydney_single_product_wrap_after() {
	echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary', 'sydney_single_product_wrap_after', 9 );

/**
 * Filter single product Flexslider options
 */
function sydney_product_carousel_options( $options ) {

	$layout = get_theme_mod( 'single_product_gallery', 'gallery-default' );

	if ( 'gallery-single' === $layout ) {
		$options['controlNav'] = false;
		$options['directionNav'] = true;
	}

	if ( 'gallery-showcase' === $layout || 'gallery-full-width' === $layout ) {
		$options['controlNav'] = 'thumbnails';
		$options['directionNav'] = true;
	}

	return $options;
}
add_filter( 'woocommerce_single_product_carousel_options', 'sydney_product_carousel_options' );

/**
 * Single add to cart wrapper
 */
function sydney_single_addtocart_wrapper_open() {
	echo '<div class="sydney-single-addtocart-wrapper">';
}

function sydney_single_addtocart_wrapper_close() {
	echo '</div>';
}

/**
 * Layout shop archive
 */
function sydney_wc_archive_layout() {

	$archive_sidebar 	    = get_theme_mod( 'shop_archive_sidebar', 'no-sidebar' );
	$shop_categories_layout = get_theme_mod( 'shop_categories_layout', 'layout1' );

	if ( 'no-sidebar' === $archive_sidebar ) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	}

	if ( 'sidebar-top' === $archive_sidebar ) {
		$shop_archive_sidebar_top_columns = get_theme_mod( 'shop_archive_sidebar_top_columns', '4' );

		$archive_sidebar .= ' sidebar-top-columns-' . $shop_archive_sidebar_top_columns;
	}

	$archive_sidebar .= ' product-category-item-' . $shop_categories_layout;
	
	$layout = get_theme_mod( 'shop_archive_layout', 'product-grid' );	

	return $archive_sidebar . ' ' . $layout;
}

/**
 * Loop product structure
 */
function sydney_loop_product_structure() {
	$elements 	= get_theme_mod( 'shop_card_elements', array( 'woocommerce_template_loop_product_title', 'woocommerce_template_loop_rating', 'woocommerce_template_loop_price' ) );

	foreach ( $elements as $element ) {

		if ( 'woocommerce_template_loop_product_title' == $element ) { //wrap product title in link
			echo '<a href="' . esc_url( get_the_permalink() ) . '">';
				call_user_func( $element );
			echo '</a>';
		} else {
			call_user_func( $element );
		}
	}
}

/**
 * Loop product category
 */
function sydney_loop_product_category() {
	echo '<div class="product-category">' . wc_get_product_category_list( get_the_id() ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Loop product description
 */
function sydney_loop_product_description() {
	$content = get_the_excerpt();

	echo '<div>' . wp_kses_post( wp_trim_words( $content, 12, '&hellip;' ) ) . '</div>';
}

/**
 * Loop add to cart
 */
function sydney_filter_loop_add_to_cart( $button, $product, $args ) {
	global $product;

	//Return if not button layout 4
	$button_layout 	= get_theme_mod( 'shop_product_add_to_cart_layout', 'layout2' );
	$layout 		= get_theme_mod( 'shop_archive_layout', 'product-grid' );	

	if ( 'layout4' !== $button_layout ) {
		return $button;
	}

	if ( $product->is_type( 'simple' ) ) {
		$text = '<i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-cart', false ) . '</i>';
	} else {
		$text = '<i class="sydney-svg-icon">' . sydney_get_svg_icon( 'icon-eye', false ) . '</i>';
	}

	$button = sprintf(
		'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		$text
	);

	return $button;
}
if ( !function_exists( 'tutor' ) ) {
	add_filter( 'woocommerce_loop_add_to_cart_link', 'sydney_filter_loop_add_to_cart', 10, 3 );
}

/**
 * Wrap loop button
 */
function sydney_wrap_loop_button_start() {
	$button_layout = get_theme_mod( 'shop_product_add_to_cart_layout', 'layout2' );
	echo '<div class="loop-button-wrap button-' . esc_attr( $button_layout ) . '">';
}

/**
 * Quick view button
 */
function sydney_quick_view_button( $product = false, $echo = true ) {
	if( $product == false ) {
		global $product; 
	}

	$product_id        = $product->get_id(); 
	$quick_view_layout = get_theme_mod( 'shop_product_quickview_layout', 'layout1' ); 
	if( 'layout1' == $quick_view_layout ) {
		return '';
	} 
	
	if( $echo == false ) {
		ob_start();
	} ?>

	<a href="#" class="button sydney-quick-view-show-on-hover sydney-quick-view sydney-quick-view-<?php echo esc_attr( $quick_view_layout ); ?>" aria-label="<?php /* translators: %s: quick view product title */ echo sprintf( esc_attr__( 'Quick view the %s product', 'sydney' ), get_the_title( $product_id ) ); ?>" data-product-id="<?php echo absint( $product_id ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'sydney-qview-nonce' ) ); ?>">
		<?php esc_html_e( 'Quick View', 'sydney' ); ?>
	</a>
	<?php
	if( $echo == false ) {
		$output = ob_get_clean();
		return $output;
	}
}

/**
 * Quick view popup
 */
function sydney_quick_view_popup() { ?>
	<div class="single-product sydney-quick-view-popup">
		<div class="sydney-quick-view-loader">
			<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512" aria-hidden="true" focusable="false">
				<path fill="#FFF" d="M288 39.056v16.659c0 10.804 7.281 20.159 17.686 23.066C383.204 100.434 440 171.518 440 256c0 101.689-82.295 184-184 184-101.689 0-184-82.295-184-184 0-84.47 56.786-155.564 134.312-177.219C216.719 75.874 224 66.517 224 55.712V39.064c0-15.709-14.834-27.153-30.046-23.234C86.603 43.482 7.394 141.206 8.003 257.332c.72 137.052 111.477 246.956 248.531 246.667C393.255 503.711 504 392.788 504 256c0-115.633-79.14-212.779-186.211-240.236C302.678 11.889 288 23.456 288 39.056z" />
			</svg>
		</div>
		<div class="sydney-quick-view-popup-content">
			<a href="#" class="sydney-quick-view-popup-close-button">
				<i class="ws-svg-icon"><?php sydney_get_svg_icon( 'icon-cancel', true ); ?></i>
			</a>
			<div class="sydney-quick-view-popup-content-ajax"></div>
		</div>
	</div>
	
	<?php
}

/**
 * Quick view add to cart wrapper
 */
add_action( 'sydney_quick_view_before_add_to_cart_button', 'sydney_single_addtocart_wrapper_open' );
add_action( 'sydney_quick_view_after_add_to_cart_button', 'sydney_single_addtocart_wrapper_close' );

/**
 * Quick view ajax callback
 */
function sydney_quick_view_content_callback_function() {
	check_ajax_referer( 'sydney-qview-nonce', 'nonce' );
	
	if( !isset( $_POST['product_id'] ) ) {
		return;
	}

	$args = array(
		'product_id' => absint( $_POST['product_id'] )
	);
	
	sydney_get_template_part( 'content', 'quick-view', $args );
	
	wp_die();
}
add_action('wp_ajax_sydney_quick_view_content', 'sydney_quick_view_content_callback_function');
add_action( 'wp_ajax_nopriv_sydney_quick_view_content', 'sydney_quick_view_content_callback_function' );

/**
 * sydney output for simple product add to cart area.
 * The purpose is avoid third party plugins hooking here
 */
function sydney_simple_add_to_cart( $product, $hook_prefix = '' ) {
	if ( ! $product->is_purchasable() ) {
		return;
	}
	
	echo wc_get_stock_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	
	if ( $product->is_in_stock() ) : ?>
	
		<?php do_action( "sydney_{$hook_prefix}_before_add_to_cart_form" ); ?>
	
		<form class="cart" action="<?php echo esc_url( apply_filters( "sydney_{$hook_prefix}_add_to_cart_form_action", $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
			<?php do_action( "sydney_{$hook_prefix}_before_add_to_cart_button" ); ?>
	
			<?php
			do_action( "sydney_{$hook_prefix}_before_add_to_cart_quantity" );

			woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters( "sydney_{$hook_prefix}_quantity_input_min", $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( "sydney_{$hook_prefix}_quantity_input_max", $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( absint( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity()
				)
			);
	
			do_action( "sydney_{$hook_prefix}_after_add_to_cart_quantity" );
			?>
	
			<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
	
			<?php do_action( "sydney_{$hook_prefix}_after_add_to_cart_button" ); ?>
		</form>
	
		<?php do_action( "sydney_{$hook_prefix}_after_add_to_cart_form" ); ?>
	
	<?php endif;
}

/**
 * sydney output for grouped product add to cart area.
 * The purpose is avoid third party plugins hooking here
 */
function sydney_grouped_add_to_cart( $product, $hook_prefix = '' ) {
	$products = array_filter( array_map( 'wc_get_product', $product->get_children() ), 'wc_products_array_filter_visible_grouped' );

	if ( $products ) :
		$post               = get_post( $product->get_id() );
		$grouped_product    = $product;
		$grouped_products   = $products;
		$quantites_required = false;

		do_action( "sydney_{$hook_prefix}_before_add_to_cart_form" ); ?>

		<form class="cart grouped_form" action="<?php echo esc_url( apply_filters( "sydney_{$hook_prefix}_add_to_cart_form_action", $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
			<table cellspacing="0" class="woocommerce-grouped-product-list group_table">
				<tbody>
					<?php
					$quantites_required      = false;
					$previous_post           = $post;
					$grouped_product_columns = apply_filters(
						"sydney_{$hook_prefix}_grouped_product_columns",
						array(
							'quantity',
							'label',
							'price',
						),
						$product
					);
					$show_add_to_cart_button = false;

					do_action( "sydney_{$hook_prefix}_grouped_product_list_before", $grouped_product_columns, $quantites_required, $product );

					foreach ( $grouped_products as $grouped_product_child ) {
						$post_object        = get_post( $grouped_product_child->get_id() );
						$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );
						$post               = $post_object;
						setup_postdata( $post );

						if ( $grouped_product_child->is_in_stock() ) {
							$show_add_to_cart_button = true;
						}

						echo '<tr id="product-' . esc_attr( $grouped_product_child->get_id() ) . '" class="woocommerce-grouped-product-list-item ' . esc_attr( implode( ' ', wc_get_product_class( '', $grouped_product_child ) ) ) . '">';

						// Output columns for each product.
						foreach ( $grouped_product_columns as $column_id ) {
							do_action( "sydney_{$hook_prefix}_grouped_product_list_before_" . $column_id, $grouped_product_child );

							switch ( $column_id ) {
								case 'quantity':
									ob_start();

									if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() || ! $grouped_product_child->is_in_stock() ) {
										woocommerce_template_loop_add_to_cart();
									} elseif ( $grouped_product_child->is_sold_individually() ) {
										echo '<input type="checkbox" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" />';
									} else {
										do_action( "sydney_{$hook_prefix}_before_add_to_cart_quantity" );

										woocommerce_quantity_input(
											array(
												'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
												'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ) ) : '', // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
												'min_value'   => apply_filters( "sydney_{$hook_prefix}_quantity_input_min", 0, $grouped_product_child ),
												'max_value'   => apply_filters( "sydney_{$hook_prefix}_quantity_input_max", $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
												'placeholder' => '0',
											)
										);

										do_action( "sydney_{$hook_prefix}_after_add_to_cart_quantity" );
									}

									$value = ob_get_clean();
									break;
								case 'label':
									$value  = '<label for="product-' . esc_attr( $grouped_product_child->get_id() ) . '">';
									$value .= $grouped_product_child->is_visible() ? '<a href="' . esc_url( apply_filters( "sydney_{$hook_prefix}_grouped_product_list_link", $grouped_product_child->get_permalink(), $grouped_product_child->get_id() ) ) . '">' . $grouped_product_child->get_name() . '</a>' : $grouped_product_child->get_name();
									$value .= '</label>';
									break;
								case 'price':
									$value = $grouped_product_child->get_price_html() . wc_get_stock_html( $grouped_product_child );
									break;
								default:
									$value = '';
									break;
							}

							echo '<td class="woocommerce-grouped-product-list-item__' . esc_attr( $column_id ) . '">' . apply_filters( "sydney_{$hook_prefix}_grouped_product_list_column_" . $column_id, $value, $grouped_product_child ) . '</td>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

							do_action( "sydney_{$hook_prefix}_grouped_product_list_after_" . $column_id, $grouped_product_child );
						}

						echo '</tr>';
					}
					$post = $previous_post;
					setup_postdata( $post );

					do_action( "sydney_{$hook_prefix}_grouped_product_list_after", $grouped_product_columns, $quantites_required, $product );
					?>
				</tbody>
			</table>

			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

			<?php if ( $quantites_required && $show_add_to_cart_button ) : ?>

				<?php do_action( "sydney_{$hook_prefix}_before_add_to_cart_button" ); ?>

				<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

				<?php do_action( "sydney_{$hook_prefix}_after_add_to_cart_button" ); ?>

			<?php endif; ?>
		</form>

		<?php do_action( "sydney_{$hook_prefix}_after_add_to_cart_form" ); ?>
	
	<?php endif;
}

/**
 * sydney output for variable product add to cart area.
 * The purpose is avoid third party plugins hooking here
 */
function sydney_variable_add_to_cart( $product, $hook_prefix = '' ) {
	// Get Available variations?
	$get_variations = count( $product->get_children() ) <= apply_filters( "sydney_{$hook_prefix}_ajax_variation_threshold", 30, $product );

	$available_variations = $get_variations ? $product->get_available_variations() : false;
	$attributes           = $product->get_variation_attributes();
	$selected_attributes  = $product->get_default_attributes();

	$attribute_keys  = array_keys( $attributes );
	$variations_json = wp_json_encode( $available_variations );
	$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

	do_action( "sydney_{$hook_prefix}_before_add_to_cart_form" ); ?>

	<form class="variations_form cart" action="<?php echo esc_url( apply_filters( "sydney_{$hook_prefix}_add_to_cart_form_action", $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
		<?php do_action( "sydney_{$hook_prefix}_before_variations_form" ); ?>

		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php echo esc_html( apply_filters( "sydney_{$hook_prefix}_out_of_stock_message", __( 'This product is currently out of stock and unavailable.', 'sydney' ) ) ); ?></p>
		<?php else : ?>
			<table class="variations" cellspacing="0">
				<tbody>
					<?php foreach ( $attributes as $attribute_name => $options ) : ?>
						<tr>
							<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></label></td>
							<td class="value">
								<?php
									wc_dropdown_variation_attribute_options(
										array(
											'options'   => $options,
											'attribute' => $attribute_name,
											'product'   => $product,
										)
									);
									echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( "sydney_{$hook_prefix}_reset_variations_link", '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'sydney' ) . '</a>' ) ) : '';
								?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="single_variation_wrap">
				<?php
					/**
					 * Hook: woocommerce_before_single_variation.
					 */
					do_action( "sydney_{$hook_prefix}_before_single_variation" ); ?>

					<div class="woocommerce-variation single_variation"></div>
					<div class="woocommerce-variation-add-to-cart variations_button">
						<?php do_action( "sydney_{$hook_prefix}_before_add_to_cart_button" ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound ?> 

						<?php
						do_action( "sydney_{$hook_prefix}_before_add_to_cart_quantity" );

						woocommerce_quantity_input(
							array(
								'min_value'   => apply_filters( "sydney_{$hook_prefix}_quantity_input_min", $product->get_min_purchase_quantity(), $product ),
								'max_value'   => apply_filters( "sydney_{$hook_prefix}_quantity_input_max", $product->get_max_purchase_quantity(), $product ),
								'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
							)
						);

						do_action( "sydney_{$hook_prefix}_after_add_to_cart_quantity" );
						?>

						<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

						<?php do_action( "sydney_{$hook_prefix}_after_add_to_cart_button" ); ?>

						<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
						<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
						<input type="hidden" name="variation_id" class="variation_id" value="0" />
					</div>


					<?php
					/**
					 * Hook: woocommerce_after_single_variation.
					 */
					do_action( 'sydney_quick_view_after_single_variation' );
				?>
			</div>
		<?php endif; ?>

		<?php do_action( 'sydney_quick_view_after_variations_form' ); ?>
	</form>

	<?php
	do_action( 'sydney_quick_view_after_add_to_cart_form' );
}


/**
 * sydney output for external product add to cart area.
 * The purpose is avoid third party plugins hooking here
 */
function sydney_external_add_to_cart( $product, $hook_prefix = '' ) {
	if ( ! $product->add_to_cart_url() ) {
		return;
	}

	$product_url = $product->add_to_cart_url();
	$button_text = $product->single_add_to_cart_text();

	do_action( "sydney_{$hook_prefix}_before_add_to_cart_form" ); ?>

	<form class="cart" action="<?php echo esc_url( $product_url ); ?>" method="get">
		<?php do_action( "sydney_{$hook_prefix}_before_add_to_cart_button" ); ?>

		<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></button>

		<?php wc_query_string_form_fields( $product_url ); ?>

		<?php do_action( "sydney_{$hook_prefix}_after_add_to_cart_button" ); ?>
	</form>

	<?php do_action( "sydney_{$hook_prefix}_after_add_to_cart_form" );
}

/**
 * sydney output for product price.
 * The purpose is avoid third party plugins hooking here
 */
function sydney_single_product_price( $hook_prefix = '' ) {
	global $product; ?>

	<p class="<?php echo esc_attr( apply_filters( "sydney_{$hook_prefix}_product_price_class", 'price' ) ); ?>"><?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

<?php
}


/**
 * Sales badge text
 */
function sydney_sale_badge( $html, $post, $product ) {

	if ( !$product->is_on_sale() ) {
		return;
	}	

	$text 			= get_theme_mod( 'sale_badge_text', esc_html__( 'Sale!', 'sydney' ) );
	$badge = '<span class="onsale">' . esc_html( $text ) . '</span>';

	return $badge;
}
add_filter( 'woocommerce_sale_flash', 'sydney_sale_badge', 10, 3 );