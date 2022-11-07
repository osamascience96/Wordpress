<?php
/**
 * Class for dynamic CSS output
 *
 */

if ( !class_exists( 'Sydney_Custom_CSS' ) ) :

	/**
	 * Sydney_Custom_CSS 
	 */
	Class Sydney_Custom_CSS {

		/**
		 * Instance
		 */		
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {	
			$this->customizer_js = array();

			add_action( 'wp_enqueue_scripts', array( $this, 'print_styles' ) );
		}

		/**
		 * Output all custom CSS
		 */
		public function output_css( $custom = false ) {

            $is_amp = sydney_is_amp();

            $custom = '';
        
            //Woocommerce
            $yith_buttons_visible = get_theme_mod( 'yith_buttons_visible', 0 );
            if ( $yith_buttons_visible ) {
                $custom .= ".yith-placeholder > * { opacity:1!important;left:0!important;}"."\n";
            }
        
            //Get thumbnails for shop and shop archives
            $shop_thumb = get_the_post_thumbnail_url( get_option( 'woocommerce_shop_page_id' ) );
            if ( class_exists( 'Woocommerce' ) && is_product_category() ) {
                global $wp_query;
                $cat 			= $wp_query->get_queried_object();
                $thumbnail_id 	= get_term_meta( $cat->term_id, 'thumbnail_id', true );
                $shop_archive_thumb	= wp_get_attachment_url( $thumbnail_id );
            }
        
            if ( class_exists( 'Woocommerce' ) && is_shop() && $shop_thumb ) {
                $custom .= ".header-image { background-image:url(" . esc_url($shop_thumb) . ")!important;display:block;}"."\n";	
                $custom .= ".site-header { background-color:transparent;}" . "\n";
                $custom .= "@media only screen and (max-width: 1024px) { .sydney-hero-area .header-image { height:300px!important; }}" . "\n";
                $shop_overlay = get_theme_mod( 'hide_overlay_shop' );
                if ( $shop_overlay ) {
                    $custom .= ".header-image .overlay { background-color:transparent;}" . "\n";
                }
            } elseif ( class_exists( 'Woocommerce' ) && is_product_category() && $shop_archive_thumb ) {
                $custom .= ".header-image { background-image:url(" . esc_url($shop_archive_thumb) . ")!important;display:block;}"."\n";	
                if ( !$is_amp ) {
                    $custom .= ".site-header { background-color:transparent;}" . "\n";
                }
                $custom .= "@media only screen and (max-width: 1024px) { .sydney-hero-area .header-image { height:300px!important; }}" . "\n";
            } elseif ( $is_amp || (get_theme_mod('front_header_type','nothing') == 'nothing' && is_front_page()) || (get_theme_mod('site_header_type') == 'nothing' && !is_front_page()) ) {
                $menu_bg_color = get_theme_mod( 'menu_bg_color', '#263246' );
                $rgba 	= $this->hex2rgba($menu_bg_color, 0.9);
                $custom .= ".site-header { background-color:" . esc_attr($rgba) . ";}" . "\n";
            }
        
            $wc_button_hover = get_theme_mod( 'wc_button_hover', 0 );
            if ( $wc_button_hover ) {
                $custom .= "
                @media only screen and (min-width: 1024px) { 
                .loop-button-wrapper {position: absolute;bottom: 0;width: 100%;left: 0;opacity: 0;transition: all 0.3s;}
                .woocommerce ul.products li.product .woocommerce-loop-product__title,
                .woocommerce ul.products li.product .price {transition: all 0.3s;}
                .woocommerce ul.products li.product:hover .loop-button-wrapper {opacity: 1;bottom: 20px;}
                .woocommerce ul.products li.product:hover .woocommerce-loop-product__title,
                .woocommerce ul.products li.product:hover .price {opacity: 0;} }" . "\n";
            }
			
			$loop_product_alignment = get_theme_mod( 'swc_loop_product_alignment', 'center' );
            $custom .= ".woocommerce ul.products li.product { text-align:" . esc_attr( $loop_product_alignment ) . ";}"."\n";

            if ( 'left' === $loop_product_alignment ) {
                $custom .= ".woocommerce ul.products li.product .star-rating { margin-left:0;}"."\n";
            } elseif ( 'right' === $loop_product_alignment ) {
                $custom .= ".woocommerce ul.products li.product .star-rating { margin-right:0;}"."\n";
            }
        
            global $post;
            if ( isset( $post ) ) {
                $elementor_page = get_post_meta( $post->ID, '_elementor_edit_mode', true );
                if ( !$elementor_page ) {
                    $custom .= "html { scroll-behavior: smooth;}" . "\n";
                }
            } else {
                $custom .= "html { scroll-behavior: smooth;}" . "\n";
            }	

            //Header image
            $header_bg_size = get_theme_mod('header_bg_size','cover');	
            $header_height = get_theme_mod('header_height','300');
            $custom .= ".header-image { background-size:" . esc_attr($header_bg_size) . ";}"."\n";
            $custom .= ".header-image { height:" . intval($header_height) . "px; }"."\n";
        
            //Menu style
            $sticky_menu = get_theme_mod('sticky_menu','sticky');
            if ($sticky_menu == 'static') {
                $custom .= ".site-header.fixed { position: absolute;}"."\n";
            }
            $menu_style = get_theme_mod('menu_style','inline');
            if ($menu_style == 'centered') {
                $custom .= ".header-wrap .col-md-4, .header-wrap .col-md-8 { width: 100%; text-align: center;}"."\n";
                $custom .= "#mainnav { float: none;}"."\n";
                $custom .= "#mainnav li { float: none; display: inline-block;}"."\n";
                $custom .= "#mainnav ul ul li { display: block; text-align: left; float:left;}"."\n";
                if( get_bloginfo( 'description' ) || get_bloginfo( 'name' ) || get_theme_mod('site_logo') ) {
                    $custom .= ".site-logo, .header-wrap .col-md-4 { margin-bottom: 15px; }"."\n";
                }
                $custom .= ".btn-menu { margin: 0 auto; float: none; }"."\n";
                $custom .= ".header-wrap .container > .row { display: block; }"."\n";
            }	
        
            //AMP
            if ( 'sticky' == $sticky_menu && $is_amp ) {
                $custom .= ".site-header { position: -webkit-sticky;position: sticky;}"."\n";
            }
        
        
            //__COLORS
            //Primary color
            $primary_color = get_theme_mod( 'primary_color', '#d65050' );
            if ( $primary_color != '#d65050' ) {
            $custom .= ".llms-student-dashboard .llms-button-secondary:hover,.llms-button-action:hover,.read-more-gt,.widget-area .widget_fp_social a,#mainnav ul li a:hover, .sydney_contact_info_widget span, .roll-team .team-content .name,.roll-team .team-item .team-pop .team-social li:hover a,.roll-infomation li.address:before,.roll-infomation li.phone:before,.roll-infomation li.email:before,.roll-testimonials .name,.roll-button.border,.roll-button:hover,.roll-icon-list .icon i,.roll-icon-list .content h3 a:hover,.roll-icon-box.white .content h3 a,.roll-icon-box .icon i,.roll-icon-box .content h3 a:hover,.switcher-container .switcher-icon a:focus,.go-top:hover,.hentry .meta-post a:hover,#mainnav > ul > li > a.active, #mainnav > ul > li > a:hover, button:hover, input[type=\"button\"]:hover, input[type=\"reset\"]:hover, input[type=\"submit\"]:hover, .text-color, .social-menu-widget a, .social-menu-widget a:hover, .archive .team-social li a, a, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,.classic-alt .meta-post a,.single .hentry .meta-post a, .content-area.modern .hentry .meta-post span:before, .content-area.modern .post-cat { color:" . esc_attr($primary_color) . "}"."\n";
            $custom .= ".llms-student-dashboard .llms-button-secondary,.llms-button-action,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.project-filter li a.active, .project-filter li a:hover,.preloader .pre-bounce1, .preloader .pre-bounce2,.roll-team .team-item .team-pop,.roll-progress .progress-animate,.roll-socials li a:hover,.roll-project .project-item .project-pop,.roll-project .project-filter li.active,.roll-project .project-filter li:hover,.roll-button.light:hover,.roll-button.border:hover,.roll-button,.roll-icon-box.white .icon,.owl-theme .owl-controls .owl-page.active span,.owl-theme .owl-controls.clickable .owl-page:hover span,.go-top,.bottom .socials li:hover a,.sidebar .widget:before,.blog-pagination ul li.active,.blog-pagination ul li:hover a,.content-area .hentry:after,.text-slider .maintitle:after,.error-wrap #search-submit:hover,#mainnav .sub-menu li:hover > a,#mainnav ul li ul:after, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"], .panel-grid-cell .widget-title:after, .cart-amount { background-color:" . esc_attr($primary_color) . "}"."\n";
            $custom .= ".llms-student-dashboard .llms-button-secondary,.llms-student-dashboard .llms-button-secondary:hover,.llms-button-action,.llms-button-action:hover,.roll-socials li a:hover,.roll-socials li a,.roll-button.light:hover,.roll-button.border,.roll-button,.roll-icon-list .icon,.roll-icon-box .icon,.owl-theme .owl-controls .owl-page span,.comment .comment-detail,.widget-tags .tag-list a:hover,.blog-pagination ul li,.error-wrap #search-submit:hover,textarea:focus,input[type=\"text\"]:focus,input[type=\"password\"]:focus,input[type=\"datetime\"]:focus,input[type=\"datetime-local\"]:focus,input[type=\"date\"]:focus,input[type=\"month\"]:focus,input[type=\"time\"]:focus,input[type=\"week\"]:focus,input[type=\"number\"]:focus,input[type=\"email\"]:focus,input[type=\"url\"]:focus,input[type=\"search\"]:focus,input[type=\"tel\"]:focus,input[type=\"color\"]:focus, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"], .archive .team-social li a { border-color:" . esc_attr($primary_color) . "}"."\n";
            }
            //Primary color SVGs
            $custom .= ".sydney_contact_info_widget span { fill:" . esc_attr( $primary_color ) . ";}" . "\n";
            $custom .= ".go-top:hover svg { stroke:" . esc_attr( $primary_color ) . ";}" . "\n";
        
            //Menu background
            $menu_bg_color = get_theme_mod( 'menu_bg_color', '#000000' );
            $rgba = $this->hex2rgba($menu_bg_color, 0.9);
            $custom .= ".site-header.float-header { background-color:" . esc_attr($rgba) . ";}" . "\n";
            $custom .= "@media only screen and (max-width: 1024px) { .site-header { background-color:" . esc_attr($menu_bg_color) . ";}}" . "\n";

            //Top level menu items color
            $top_items_color = get_theme_mod( 'top_items_color', '#ffffff' );
			$custom .= "#mainnav ul li a, #mainnav ul li::before { color:" . esc_attr($top_items_color) . "}"."\n";	

            //Sub menu items color
            $submenu_items_color = get_theme_mod( 'submenu_items_color', '#ffffff' );
            $custom .= "#mainnav .sub-menu li a { color:" . esc_attr($submenu_items_color) . "}"."\n";
            //Sub menu background
            $submenu_background = get_theme_mod( 'submenu_background', '#1c1c1c' );
            $custom .= "#mainnav .sub-menu li a { background:" . esc_attr($submenu_background) . "}"."\n";
            //Header slider text
            $slider_text = get_theme_mod( 'slider_text', '#ffffff' );
            $custom .= ".text-slider .maintitle, .text-slider .subtitle { color:" . esc_attr($slider_text) . "}"."\n";
            //Body
            $body_text = get_theme_mod( 'body_text_color' );
            $custom .= "body { color:" . esc_attr($body_text) . "}"."\n";
            //Sidebar background
            $sidebar_background = get_theme_mod( 'sidebar_background', '#ffffff' );
            $custom .= "#secondary { background-color:" . esc_attr($sidebar_background) . "}"."\n";
            //Sidebar color
            $sidebar_color = get_theme_mod( 'sidebar_color', '#737C8C' );
            $custom .= "#secondary, #secondary a { color:" . esc_attr($sidebar_color) . "}"."\n";	
           

            //Mobile menu icon
            $mobile_menu_color = get_theme_mod( 'mobile_menu_color', '#ffffff' );
            $custom .= ".btn-menu .sydney-svg-icon { fill:" . esc_attr($mobile_menu_color) . "}"."\n";
        
            //Menu items hover
            $menu_items_hover = get_theme_mod( 'menu_items_hover', '#d65050' );
            $custom .= "#mainnav ul li a:hover, .main-header #mainnav .menu > li > a:hover { color:" . esc_attr($menu_items_hover) . "}"."\n";

            //Rows overlay
            $rows_overlay = get_theme_mod( 'rows_overlay', '#000000' );
            $custom .= ".overlay { background-color:" . esc_attr($rows_overlay) . "}"."\n";	
        
            //Page wrapper padding
            $pw_top_padding = get_theme_mod( 'wrapper_top_padding', '83' );
            $pw_bottom_padding = get_theme_mod( 'wrapper_bottom_padding', '100' );
            $custom .= ".page-wrap { padding-top:" . intval($pw_top_padding) . "px;}"."\n";	
            $custom .= ".page-wrap { padding-bottom:" . intval($pw_bottom_padding) . "px;}"."\n";	

			if ( is_singular() ) {
                $post_type = get_post_type();

                //Boxed content
                $boxed = get_theme_mod( $post_type . '_boxed_content', 'unboxed' );
                if ( $boxed == 'boxed' ) {
                    $custom .= ".content-inner { padding: 60px; background-color: #fff; box-shadow: 0 0 15px 0 rgba(0,0,0,0.05);}"."\n";
                    $custom .= "@media only screen and (max-width: 767px) { .content-inner {padding: 20px;} }" . "\n";
                }
            }
        
            $text_slide = get_theme_mod('textslider_slide', 0);
            if ( $text_slide ) {
                $custom .= ".slide-inner { display:none;}"."\n";	
                $custom .= ".slide-inner.text-slider-stopped { display:block;}"."\n";	
            }
        
            $mobile_slider = get_theme_mod('mobile_slider', 'responsive');
            if ( $mobile_slider == 'responsive' ) {
                    $custom .= "@media only screen and (max-width: 1025px) {		
                    .mobile-slide {
                        display: block;
                    }
                    .slide-item {
                        background-image: none !important;
                    }
                    .header-slider {
                    }
                    .slide-item {
                        height: auto !important;
                    }
                    .slide-inner {
                        min-height: initial;
                    } 
                }"."\n";     	
            }
        
            if ( $is_amp ) {
                $custom .= ".go-top { bottom: 30px;opacity:1;visibility:visible;}" . "\n";
            }
        
            /* Start porting */
            /* Back to top */
			$scrolltop_radius 			= get_theme_mod( 'scrolltop_radius', 2 );
			$scrolltop_side_offset 		= get_theme_mod( 'scrolltop_side_offset', 20 );
			$scrolltop_bottom_offset 	= get_theme_mod( 'scrolltop_bottom_offset', 10 );
			$scrolltop_icon_size 		= get_theme_mod( 'scrolltop_icon_size', 16 );
			$scrolltop_padding 			= get_theme_mod( 'scrolltop_padding', 15 );

			$custom .= ".go-top.show { border-radius:" . esc_attr( $scrolltop_radius ) . "px;bottom:" . esc_attr( $scrolltop_bottom_offset ) . "px;}" . "\n";
			$custom .= ".go-top.position-right { right:" . esc_attr( $scrolltop_side_offset ) . "px;}" . "\n";
			$custom .= ".go-top.position-left { left:" . esc_attr( $scrolltop_side_offset ) . "px;}" . "\n";
			$custom .= $this->get_background_color_css( 'scrolltop_bg_color', '', '.go-top' );
			$custom .= $this->get_background_color_css( 'scrolltop_bg_color_hover', '', '.go-top:hover' );
			$custom .= $this->get_color_css( 'scrolltop_color', '', '.go-top' );
			$custom .= $this->get_stroke_css( 'scrolltop_color', '', '.go-top svg' );
			$custom .= $this->get_color_css( 'scrolltop_color_hover', '', '.go-top:hover' );
			$custom .= $this->get_stroke_css( 'scrolltop_color_hover', '', '.go-top:hover svg' );
			$custom .= ".go-top .sydney-svg-icon, .go-top .sydney-svg-icon svg { width:" . esc_attr( $scrolltop_icon_size ) . "px;height:" . esc_attr( $scrolltop_icon_size ) . "px;}" . "\n";
			$custom .= ".go-top { padding:" . esc_attr( $scrolltop_padding ) . "px;}" . "\n";
        
            /* Footer */
			$footer_widgets_divider 		= get_theme_mod( 'footer_widgets_divider', 0 );
			$footer_widgets_divider_width 	= get_theme_mod( 'footer_widgets_divider_width', 'contained' );
			$footer_widgets_divider_size 	= get_theme_mod( 'footer_widgets_divider_size', 1 );
			$footer_widgets_divider_color 	= get_theme_mod( 'footer_widgets_divider_color' );

			if ( $footer_widgets_divider ) {
				if ( 'contained' === $footer_widgets_divider_width ) {
					$custom .= ".footer-widgets-grid { border-top:" . esc_attr( $footer_widgets_divider_size ) . 'px solid ' . esc_attr( $footer_widgets_divider_color ) . ";}" . "\n";
				} else {
					$custom .= ".footer-widgets { border-top:" . esc_attr( $footer_widgets_divider_size ) . 'px solid ' . esc_attr( $footer_widgets_divider_color ) . ";}" . "\n";
				}
			}

			$footer_credits_divider 		= get_theme_mod( 'footer_credits_divider', 0 );
			$footer_credits_divider_width 	= get_theme_mod( 'footer_credits_divider_width', 'contained' );
			$footer_credits_divider_size 	= get_theme_mod( 'footer_credits_divider_size', 0 );
			$footer_credits_divider_color 	= get_theme_mod( 'footer_credits_divider_color', 'rgba(33,33,33,0.1)' );			
			if ( $footer_credits_divider ) {
				if ( 'contained' === $footer_credits_divider_width ) {
					$custom .= ".site-info { border-top:" . esc_attr( $footer_credits_divider_size ) . 'px solid ' . esc_attr( $footer_credits_divider_color ) . ";}" . "\n";
				} else {
					$custom .= ".site-footer { border-top:" . esc_attr( $footer_credits_divider_size ) . 'px solid ' . esc_attr( $footer_credits_divider_color ) . ";}" . "\n";
				}
			} else {
				$custom .= ".site-info { border-top:0;}" . "\n";
			}			

			$footer_widgets_column_spacing_desktop = get_theme_mod( 'footer_widgets_column_spacing_desktop', 30 );
			$custom .= ".footer-widgets-grid { gap:" . esc_attr( $footer_widgets_column_spacing_desktop ) . "px;}" . "\n";
			$custom .= $this->get_top_bottom_padding_css( 'footer_widgets_padding', $defaults = array( 'desktop' => 95, 'tablet' => 60, 'mobile' => 60 ), '.footer-widgets-grid' );
			$custom .= $this->get_font_sizes_css( 'footer_widgets_title_size', $defaults = array( 'desktop' => 22, 'tablet' => 22, 'mobile' => 22 ), '.sidebar-column .widget .widget-title' );

			$custom .= $this->get_background_color_css( 'footer_widgets_background', '', '.footer-widgets' );
			$custom .= $this->get_color_css( 'footer_widgets_title_color', '', '.sidebar-column .widget .widget-title' );
			$custom .= $this->get_color_css( 'footer_widgets_headings_color', '', '.sidebar-column .widget h1, .sidebar-column .widget h2, .sidebar-column .widget h3, .sidebar-column .widget h4, .sidebar-column .widget h5, .sidebar-column .widget h6' );
			$custom .= $this->get_color_css( 'footer_widgets_color', '', '.sidebar-column .widget' );
			$custom .= $this->get_color_css( 'footer_widgets_links_color', '', '.sidebar-column .widget a' );
			$custom .= $this->get_color_css( 'footer_widgets_links_hover_color', '', '.sidebar-column .widget a:hover' );
			$custom .= $this->get_background_color_css( 'footer_background', '', '.site-footer' );
			$custom .= $this->get_color_css( 'footer_color', '', '.site-info, .site-info a' );
			$custom .= $this->get_fill_css( 'footer_color', '', '.site-info .sydney-svg-icon svg' );

            $footer_credits_padding = get_theme_mod( 'footer_credits_padding_desktop', 20 );
			$custom .= ".site-info { padding-top:" . esc_attr( $footer_credits_padding ) . 'px;padding-bottom:' . esc_attr( $footer_credits_padding ) . "px;}" . "\n";

			//Buttons
			$custom .= $this->get_top_bottom_padding_css( 'button_top_bottom_padding', $defaults = array( 'desktop' => 12, 'tablet' => 12, 'mobile' => 12 ), 'button,.roll-button,a.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"]' );
			$custom .= $this->get_left_right_padding_css( 'button_left_right_padding', $defaults = array( 'desktop' => 35, 'tablet' => 35, 'mobile' => 35 ), 'button,.roll-button,a.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"]' );

			$buttons_radius = get_theme_mod( 'buttons_radius' );
			$custom .= "button,.roll-button,a.button,.wp-block-button__link,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"] { border-radius:" . intval( $buttons_radius ) . "px;}" . "\n";

			$custom .= $this->get_font_sizes_css( 'button_font_size', $defaults = array( 'desktop' => 14, 'tablet' => 14, 'mobile' => 14 ), 'button,.roll-button,a.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"]' );
			$button_text_transform = get_theme_mod( 'button_text_transform', 'uppercase' );
			$custom .= "button,.roll-button,a.button,.wp-block-button__link,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"] { text-transform:" . esc_attr( $button_text_transform ) . ";}" . "\n";

			$custom .= $this->get_background_color_css( 'button_background_color', '', 'button,div.wpforms-container-full .wpforms-form input[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form .wpforms-page-button,.roll-button,a.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"]' );			
			$custom .= $this->get_background_color_css( 'button_background_color_hover', '', 'button:hover,div.wpforms-container-full .wpforms-form input[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form .wpforms-page-button:hover,.roll-button:hover,a.button:hover,.wp-block-button__link:hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover' );			

			$custom .= $this->get_color_css( 'button_color', '', 'button,div.wpforms-container-full .wpforms-form input[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form .wpforms-page-button,.checkout-button.button,a.button,.wp-block-button__link,input[type="button"],input[type="reset"],input[type="submit"]' );			
			$custom .= $this->get_color_css( 'button_color_hover', '', 'button:hover,div.wpforms-container-full .wpforms-form input[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form .wpforms-page-button:hover,.roll-button:hover,a.button:hover,.wp-block-button__link:hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover' );			

			$button_border_color = get_theme_mod( 'button_border_color', '' );
			$button_border_color_hover = get_theme_mod( 'button_border_color_hover', '' );
			$custom .= ".is-style-outline .wp-block-button__link, div.wpforms-container-full .wpforms-form input[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form .wpforms-page-button, .roll-button, .wp-block-button__link.is-style-outline,button,a.button,.wp-block-button__link,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"] { border-color:" . esc_attr( $button_border_color ) . ";}" . "\n";
			$custom .= "button:hover,div.wpforms-container-full .wpforms-form input[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form .wpforms-page-button:hover,.roll-button:hover,a.button:hover,.wp-block-button__link:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:hover { border-color:" . esc_attr( $button_border_color_hover ) . ";}" . "\n";

            //Blog
            $list_image_size = get_theme_mod( 'archive_featured_image_size_desktop', 30 );
            $custom .= ".posts-layout .list-image { width:" . esc_attr( $list_image_size ) . "%;}" . "\n";
            $custom .= ".posts-layout .list-content { width:" . (100 - esc_attr( $list_image_size ) ) . "%;}" . "\n";

            $image_spacing = get_theme_mod( 'archive_featured_image_spacing_desktop', 24 );
			$custom .= ".content-area:not(.layout4):not(.layout6) .posts-layout .entry-thumb { margin:0 0 " . esc_attr( $image_spacing ) . "px 0;}" . "\n";
            $custom .= ".layout4 .entry-thumb, .layout6 .entry-thumb { margin:0 " . esc_attr( $image_spacing ) . "px 0 0;}" . "\n";
            $custom .= ".layout6 article:nth-of-type(even) .list-image .entry-thumb { margin:0 0 0 " . esc_attr( $image_spacing ) . "px;}" . "\n";

            $archive_title_spacing = get_theme_mod( 'archive_title_spacing', 24 );
            $custom .= ".posts-layout .entry-header { margin-bottom:" . esc_attr( $archive_title_spacing ) . "px;}" . "\n";

            $archive_meta_spacing = get_theme_mod( 'archive_meta_spacing', 15 );
            $custom .= ".posts-layout .entry-meta.below-excerpt { margin:" . esc_attr( $archive_meta_spacing ) . "px 0 0;}" . "\n";
            $custom .= ".posts-layout .entry-meta.above-title { margin:0 0 " . esc_attr( $archive_meta_spacing ) . "px;}" . "\n";

            $custom .= $this->get_color_css( 'single_post_title_color', '', '.single .entry-header .entry-title' );
            $custom .= $this->get_color_css( 'single_post_meta_color', '', '.single .entry-header .entry-meta,.single .entry-header .entry-meta a' );
            $custom .= $this->get_font_sizes_css( 'single_post_meta_size', $defaults = array( 'desktop' => 12, 'tablet' => 12, 'mobile' => 12 ), '.single .entry-meta' );
            $custom .= $this->get_font_sizes_css( 'single_post_title_size', $defaults = array( 'desktop' => 48, 'tablet' => 32, 'mobile' => 32 ), '.single .entry-header .entry-title' );
            $custom .= $this->get_color_css( 'loop_post_text_color', '#233452', '.posts-layout .entry-post' );
            $custom .= $this->get_color_css( 'loop_post_title_color', '#00102E', '.posts-layout .entry-title a' );
            $custom .= $this->get_color_css( 'loop_post_meta_color', '#737C8C', '.posts-layout .author,.posts-layout .entry-meta a' );
            $custom .= $this->get_font_sizes_css( 'loop_post_text_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), '.posts-layout .entry-post' );
            $custom .= $this->get_font_sizes_css( 'loop_post_meta_size', $defaults = array( 'desktop' => 12, 'tablet' => 12, 'mobile' => 12 ), '.posts-layout .entry-meta' );
            $custom .= $this->get_font_sizes_css( 'loop_post_title_size', $defaults = array( 'desktop' => 32, 'tablet' => 32, 'mobile' => 32 ), '.posts-layout .entry-title' );

            //Single 
            $single_post_header_alignment = get_theme_mod( 'single_post_header_alignment', 'left' );
            if ( 'middle' === $single_post_header_alignment ) {
                $custom .= ".single-post .entry-header { text-align:center;} .single-post .entry-header .entry-meta { -webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;}" . "\n";
            }

            $single_post_header_spacing = get_theme_mod( 'single_post_header_spacing', 40 );
            $custom .= ".single .entry-header { margin-bottom:" . esc_attr( $single_post_header_spacing ) . "px;}" . "\n";

            $single_post_image_spacing = get_theme_mod( 'single_post_header_spacing', 38 );
            $custom .= ".single .entry-thumb { margin-bottom:" . esc_attr( $single_post_header_spacing ) . "px;}" . "\n";


            $single_post_meta_spacing = get_theme_mod( 'single_post_meta_spacing', 24 );
            $custom .= ".single .entry-meta-above { margin-bottom:" . esc_attr( $single_post_meta_spacing ) . "px;}" . "\n";
            $custom .= ".single .entry-meta-below { margin-top:" . esc_attr( $single_post_meta_spacing ) . "px;}" . "\n";

            //Header
			$custom .= $this->get_max_width_css( 'site_logo_size', $defaults = array( 'desktop' => 180, 'tablet' => 100, 'mobile' => 100 ), '.custom-logo-link img' );

			$main_header_divider_width 	= get_theme_mod( 'main_header_divider_width', 'fullwidth' );
			$main_header_divider_size 	= get_theme_mod( 'main_header_divider_size', 0 );
			$main_header_divider_color 	= get_theme_mod( 'main_header_divider_color', 'rgba(255,255,255,0.1)' );
            
			if ( 'fullwidth' === $main_header_divider_width ) {
                $custom .= ".main-header, .bottom-header-row { border-bottom:" . esc_attr( $main_header_divider_size ) . 'px solid ' . esc_attr( $main_header_divider_color ) . ";}" . "\n";
				if ( 0 == $main_header_divider_size ) {
					$custom .= ".header_layout_3,.header_layout_4,.header_layout_5 { border-bottom: 1px solid " . esc_attr( $main_header_divider_color ) . ";}" . "\n";
				}            
			} else {
                $custom .= ".top-header-row,.main-header-inner, .bottom-header-inner { border-bottom:" . esc_attr( $main_header_divider_size ) . 'px solid ' . esc_attr( $main_header_divider_color ) . ";} .main-header,.bottom-header-row {border:0;}" . "\n";
				if ( 0 == $main_header_divider_size ) {
					$custom .= ".top-header-row { border-bottom: 1px solid " . esc_attr( $main_header_divider_color ) . ";}" . "\n";
				}            
			}

			$custom .= $this->get_background_color_css( 'main_header_background', '', '.main-header,.header-search-form' );
			$custom .= $this->get_background_color_css( 'main_header_background_sticky', '', '.main-header.sticky-active' );

			$custom .= $this->get_color_css( 'main_header_color', '', '.main-header .site-title a,.main-header .site-description,.main-header #mainnav .menu > li > a, .main-header .header-contact a' );
			$custom .= $this->get_fill_css( 'main_header_color', '', '.main-header .sydney-svg-icon svg, .main-header .dropdown-symbol .sydney-svg-icon svg' );

			$custom .= $this->get_color_css( 'main_header_color_sticky', '', '.sticky-active .main-header .site-title a,.sticky-active .main-header .site-description, .sticky-active .main-header #mainnav .menu > li > a,.sticky-active .main-header .header-contact a,.sticky-active .main-header .logout-link, .sticky-active .main-header .html-item, .sticky-active .main-header .sydney-login-toggle' );
            $custom .= $this->get_fill_css( 'main_header_color_sticky', '', '.sticky-active .main-header .sydney-svg-icon svg,.sticky-active .main-header .dropdown-symbol .sydney-svg-icon svg' );  

			$custom .= $this->get_background_color_css( 'main_header_bottom_background', '', '.bottom-header-row' );
			$custom .= $this->get_color_css( 'main_header_bottom_color', '', '.bottom-header-row, .bottom-header-row .header-contact a,.bottom-header-row #mainnav .menu > li > a' );
			$custom .= $this->get_color_css( 'color_link_hover', '', '.bottom-header-row #mainnav .menu > li > a:hover' );
			$custom .= $this->get_fill_css( 'main_header_bottom_color', '', '.bottom-header-row .header-item svg,.dropdown-symbol .sydney-svg-icon svg' );
			
			$main_header_padding 	= get_theme_mod( 'main_header_padding', 15 );
			$custom .= ".main-header .main-header-inner, .main-header .top-header-row { padding-top:" . esc_attr( $main_header_padding ) . 'px;padding-bottom:' . esc_attr( $main_header_padding ) . "px;}" . "\n";

			$main_header_bottom_padding = get_theme_mod( 'main_header_bottom_padding', 15 );
			$custom .= ".bottom-header-inner { padding-top:" . esc_attr( $main_header_bottom_padding ) . 'px;padding-bottom:' . esc_attr( $main_header_bottom_padding ) . "px;}" . "\n";

			$custom .= $this->get_background_color_css( 'main_header_submenu_background', '', '.bottom-header-row #mainnav ul ul li, .main-header #mainnav ul ul li' );
			$custom .= $this->get_color_css( 'main_header_submenu_color', '', '.bottom-header-row #mainnav ul ul li a,.bottom-header-row #mainnav ul ul li:hover a, .main-header #mainnav ul ul li:hover a,.main-header #mainnav ul ul li a' );
			$custom .= $this->get_fill_css( 'main_header_submenu_color', '', '.bottom-header-row #mainnav ul ul li svg, .main-header #mainnav ul ul li svg' );
			
			//Header mini cart
			$custom .= $this->get_color_css( 'color_body_text', '', '.main-header-cart .count-number' );
			$custom .= $this->get_background_color_rgba_css( 'color_body_text', '#212121', '.main-header-cart .widget_shopping_cart .widgettitle:after, .main-header-cart .widget_shopping_cart .woocommerce-mini-cart__buttons:before', '0.1' );

			//Mobile menu
			$mobile_menu_alignment = get_theme_mod( 'mobile_menu_alignment', 'left' );
			$custom .= ".sydney-offcanvas-menu .mainnav ul li { text-align:" . esc_attr( $mobile_menu_alignment ) . ";}" . "\n";

			$mobile_menu_link_separator 	= get_theme_mod( 'mobile_menu_link_separator', 0 );
			$link_separator_color 			= get_theme_mod( 'link_separator_color', 'rgba(238, 238, 238, 0.14)' );
			$mobile_header_separator_width	= get_theme_mod( 'mobile_header_separator_width', 1 );

			if ( $mobile_menu_link_separator ) {
				$custom .= ".sydney-offcanvas-menu .mainnav ul li { padding-top:5px;border-bottom: " . intval( $mobile_header_separator_width ) . "px solid " . esc_attr( $link_separator_color ) . ";}" . "\n";
			}

			$mobile_menu_link_spacing = get_theme_mod( 'mobile_menu_link_spacing', 20 );
			$custom .= ".sydney-offcanvas-menu .mainnav a { padding:" . esc_attr( $mobile_menu_link_spacing )/2 . "px 0;}" . "\n";

			$custom .= $this->get_background_color_css( 'mobile_header_background', '', '#masthead-mobile' );
			$custom .= $this->get_color_css( 'mobile_header_color', '', '#masthead-mobile .site-description, #masthead-mobile a:not(.button)' );
			$custom .= $this->get_fill_css( 'mobile_header_color', '', '#masthead-mobile svg' );

			$mobile_header_padding = get_theme_mod( 'mobile_header_padding', 15 );
			$custom .= ".mobile-header { padding-top:" . esc_attr( $mobile_header_padding ) . 'px;padding-bottom:' . esc_attr( $mobile_header_padding ) . "px;}" . "\n";

			$custom .= $this->get_background_color_css( 'offcanvas_menu_background', '', '.sydney-offcanvas-menu' );
			$custom .= $this->get_color_css( 'offcanvas_menu_color', '', '.sydney-offcanvas-menu,.sydney-offcanvas-menu #mainnav a:not(.button),.sydney-offcanvas-menu a:not(.button)' );
			$custom .= $this->get_fill_css( 'offcanvas_menu_color', '', '.sydney-offcanvas-menu svg, .sydney-offcanvas-menu .dropdown-symbol .sydney-svg-icon svg' );

			$offcanvas_mode = get_theme_mod( 'header_offcanvas_mode', 'layout1' );
			if ( 'layout2' === $offcanvas_mode ) {
				$custom .= ".sydney-offcanvas-menu {max-width:100%;}" . "\n";
			}            

            $custom .= $this->get_max_height_css( 'site_logo_size', $defaults = array( 'desktop' => 100, 'tablet' => 100, 'mobile' => 100 ), '.site-logo' );      
            
            //Site title
            $site_title = get_theme_mod( 'site_title_color' );
            $custom .= ".site-title a, .site-title a:visited, .main-header .site-title a, .main-header .site-title a:visited  { color:" . esc_attr($site_title) . "}"."\n";
            //Site desc
            $site_desc = get_theme_mod( 'site_desc_color' );
            $custom .= ".site-description, .main-header .site-description { color:" . esc_attr($site_desc) . "}"."\n";

			$custom .= $this->get_font_sizes_css( 'site_title_font_size', $defaults = array( 'desktop' => 32, 'tablet' => 24, 'mobile' => 20 ), '.site-title' );
			$custom .= $this->get_font_sizes_css( 'site_desc_font_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), '.site-description' );

			//Typography 
			$typography_defaults = json_encode(
				array(
					'font' 			=> 'System default',
					'regularweight' => 'regular',
					'category' 		=> 'sans-serif'
				)
			);

			$body_font		= get_theme_mod( 'sydney_body_font', $typography_defaults );
			$headings_font 	= get_theme_mod( 'sydney_headings_font', $typography_defaults );
		
			$body_font 		= json_decode( $body_font, true );
			$headings_font 	= json_decode( $headings_font, true );
			
			if ( 'System default' !== $body_font['font'] ) {
				$custom .= 'body { font-family:' . esc_attr( $body_font['font'] ) . ',' . esc_attr( $body_font['category'] ) . '; font-weight: ' . esc_attr( $body_font['regularweight'] ) . ';}' . "\n";	
			}
			
			if ( 'System default' !== $headings_font['font'] ) {
				$custom .= 'h1,h2,h3,h4,h5,h6,.site-title { font-family:' . esc_attr( $headings_font['font'] ) . ',' . esc_attr( $headings_font['category'] ) . '; font-weight: ' . esc_attr( $headings_font['regularweight'] ) . ';}' . "\n";
			}

            $enable_top_menu_typography = get_theme_mod( 'enable_top_menu_typography', 0 );
            if ( $enable_top_menu_typography ) {

                $menu_font		= get_theme_mod( 'sydney_menu_font', $typography_defaults );
                $menu_font 	    = json_decode( $menu_font, true );

                $menu_text_transform = get_theme_mod( 'menu_items_text_transform' );

                if ( 'System default' !== $menu_font['font'] ) {
                    $custom .= '#mainnav > div > ul > li > a { font-family:' . esc_attr( $menu_font['font'] ) . ',' . esc_attr( $menu_font['category'] ) . '; font-weight: ' . esc_attr( $menu_font['regularweight'] ) . ';}' . "\n";	
                }

                $custom .= "#mainnav > div > ul > li > a { text-transform:" . esc_attr( $menu_text_transform ) . ";}" . "\n";	
       
                $custom .= $this->get_font_sizes_css( 'sydney_menu_font_size', $defaults = array( 'desktop' => 14, 'tablet' => 14, 'mobile' => 14 ), '#mainnav > div > ul > li' );
                $custom .= $this->get_font_sizes_css( 'sydney_menu_font_size', $defaults = array( 'desktop' => 14, 'tablet' => 14, 'mobile' => 14 ), '.header-item' );
            }			

			$headings_font_style 		= get_theme_mod( 'headings_font_style' );
			$headings_line_height 		= get_theme_mod( 'headings_line_height', 1.2 );
			$headings_letter_spacing 	= get_theme_mod( 'headings_letter_spacing' );
			$headings_text_transform 	= get_theme_mod( 'headings_text_transform' );
			$headings_text_decoration 	= get_theme_mod( 'headings_text_decoration' );

			$custom .= "h1,h2,h3,h4,h5,h6,.site-title { text-decoration:" . esc_attr( $headings_text_decoration ) . ";text-transform:" . esc_attr( $headings_text_transform ) . ";font-style:" . esc_attr( $headings_font_style ) . ";line-height:" . esc_attr( $headings_line_height ) . ";letter-spacing:" . esc_attr( $headings_letter_spacing ) . "px;}" . "\n";	

			$custom .= $this->get_font_sizes_css( 'h1_font_size', $defaults = array( 'desktop' => 48, 'tablet' => 42, 'mobile' => 32 ), 'h1:not(.site-title)' );
			$custom .= $this->get_font_sizes_css( 'h2_font_size', $defaults = array( 'desktop' => 38, 'tablet' => 32, 'mobile' => 24 ), 'h2' );
			$custom .= $this->get_font_sizes_css( 'h3_font_size', $defaults = array( 'desktop' => 32, 'tablet' => 24, 'mobile' => 20 ), 'h3' );
			$custom .= $this->get_font_sizes_css( 'h4_font_size', $defaults = array( 'desktop' => 24, 'tablet' => 18, 'mobile' => 16 ), 'h4' );
			$custom .= $this->get_font_sizes_css( 'h5_font_size', $defaults = array( 'desktop' => 20, 'tablet' => 16, 'mobile' => 16 ), 'h5' );
			$custom .= $this->get_font_sizes_css( 'h6_font_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), 'h6' );

            $body_font_style 		= get_theme_mod( 'body_font_style' );
			$body_line_height 		= get_theme_mod( 'body_line_height', 1.68 );
			$body_letter_spacing 	= get_theme_mod( 'body_letter_spacing' );
			$body_text_transform 	= get_theme_mod( 'body_text_transform' );
			$body_text_decoration 	= get_theme_mod( 'body_text_decoration' );

			$custom .= "p, .posts-layout .entry-post { text-decoration:" . esc_attr( $body_text_decoration ) . "}" . "\n";	
			$custom .= "body, .posts-layout .entry-post { text-transform:" . esc_attr( $body_text_transform ) . ";font-style:" . esc_attr( $body_font_style ) . ";line-height:" . esc_attr( $body_line_height ) . ";letter-spacing:" . esc_attr( $body_letter_spacing ) . "px;}" . "\n";	
			$custom .= $this->get_font_sizes_css( 'body_font_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), 'body' );            

			//Woocommerce single
			$single_sku 	 	= get_theme_mod( 'single_product_sku', 1 );
			$single_categories  = get_theme_mod( 'single_product_categories', 1 );
			$single_tags 	 	= get_theme_mod( 'single_product_tags', 1 );
			$single_sticky_add_to_cart_elements_spacing = get_theme_mod( 'single_sticky_add_to_cart_elements_spacing', 35 );

			if( !$single_sku ) {
				$custom .= ".single-product .product_meta .sku_wrapper { display: none }";
			}
			if( !$single_categories ) {
				$custom .= ".single-product .product_meta .posted_in { display: none }";
			}
			if( !$single_tags ) {
				$custom .= ".single-product .product_meta .tagged_as { display: none }";
			}
			if( !$single_sku && !$single_categories && !$single_tags ) {
				$custom .= ".single-product .product_meta { border-top: 0; }";
			}

			$custom .= $this->get_font_sizes_css( 'single_product_title_size', $defaults = array( 'desktop' => 32, 'tablet' => 32, 'mobile' => 32 ), '.woocommerce div.product .product-gallery-summary .entry-title' );
			$custom .= $this->get_font_sizes_css( 'single_product_price_size', $defaults = array( 'desktop' => 24, 'tablet' => 24, 'mobile' => 24 ), '.woocommerce div.product .product-gallery-summary .price .amount' );            

            //Woocommerce loop
            $shop_product_element_spacing = get_theme_mod( 'shop_product_element_spacing', 12 );
			$custom .= ".woocommerce  ul.products li.product .col-md-7 > *,.woocommerce  ul.products li.product .col-md-8 > *,.woocommerce  ul.products li.product > * { margin-bottom:" . esc_attr( $shop_product_element_spacing ) . "px;}" . "\n";

			$shop_product_sale_tag_layout 	= get_theme_mod( 'shop_product_sale_tag_layout', 'layout2' );
			$shop_sale_tag_spacing			= get_theme_mod( 'shop_sale_tag_spacing', 20 );
			$shop_sale_tag_radius			= get_theme_mod( 'shop_sale_tag_radius', 0 );

			$custom .= ".wc-block-grid__product-onsale, span.onsale {border-radius:" . esc_attr( $shop_sale_tag_radius ) . "px;top:" . esc_attr( $shop_sale_tag_spacing ) . "px!important;left:" . esc_attr( $shop_sale_tag_spacing ) . "px!important;}" . "\n";
			if ( 'layout2' === $shop_product_sale_tag_layout ) {
				$custom .= ".wc-block-grid__product-onsale, .products span.onsale {left:auto!important;right:" . esc_attr( $shop_sale_tag_spacing ) . "px;}" . "\n";
			}

			$custom .= $this->get_color_css( 'single_product_sale_color', '', '.wc-block-grid__product-onsale, span.onsale' );
			$custom .= $this->get_background_color_css( 'single_product_sale_background_color', '', '.wc-block-grid__product-onsale, span.onsale' );
			$custom .= $this->get_color_css( 'shop_product_product_title', '', 'ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-title, ul.wc-block-grid__products li.wc-block-grid__product .woocommerce-loop-product__title, ul.wc-block-grid__products li.product .wc-block-grid__product-title, ul.wc-block-grid__products li.product .woocommerce-loop-product__title, ul.products li.wc-block-grid__product .wc-block-grid__product-title, ul.products li.wc-block-grid__product .woocommerce-loop-product__title, ul.products li.product .wc-block-grid__product-title, ul.products li.product .woocommerce-loop-product__title, ul.products li.product .woocommerce-loop-category__title, .woocommerce-loop-product__title .botiga-wc-loop-product__title' );

			$custom .= $this->get_color_css( 'color_body_text', '', 'a.wc-forward:not(.checkout-button)' );
			$custom .= $this->get_color_css( 'color_link_hover', '', 'a.wc-forward:not(.checkout-button):hover' );
			$custom .= $this->get_color_css( 'button_color_hover', '', '.woocommerce-pagination li .page-numbers:hover' );
			$custom .= $this->get_border_color_rgba_css( 'color_body_text', '#212121', '.woocommerce-sorting-wrapper', '0.1' );

            $shop_categories_alignment = get_theme_mod( 'shop_categories_alignment', 'center' );
			$custom .= "ul.products li.product-category .woocommerce-loop-category__title { text-align:" . esc_attr( $shop_categories_alignment ) . ";}" . "\n";

			$shop_categories_layout = get_theme_mod( 'shop_categories_layout', 'layout1' );
			$shop_categories_radius = get_theme_mod( 'shop_categories_radius', 0 );
			$custom .= "ul.products li.product-category > a, ul.products li.product-category > a > img { border-radius:" . esc_attr( $shop_categories_radius ) . "px;}" . "\n";
			if( 'layout4' === $shop_categories_layout ) {
				$custom .= ".product-category-item-layout4 ul.products li.product-category > a h2 { border-radius: 0 0 " . esc_attr( $shop_categories_radius ) . "px " . esc_attr( $shop_categories_radius ) . "px;}" . "\n";
			}

			//Cart display coupon form
			$shop_cart_show_coupon_form = get_theme_mod( 'shop_cart_show_coupon_form', 1 );
			if( !$shop_cart_show_coupon_form ) {
				$custom .= '.woocommerce-cart .coupon { display: none; }';
			}

			//Cart display coupon form
			$shop_checkout_show_coupon_form = get_theme_mod( 'shop_checkout_show_coupon_form', 1 );
			if( !$shop_checkout_show_coupon_form ) {
				$custom .= '.woocommerce-checkout .woocommerce-form-coupon-toggle { display: none; }';
			} 

			$shop_product_card_style 		= get_theme_mod( 'shop_product_card_style', 'layout1' );
			$shop_product_card_border_color = get_theme_mod( 'shop_product_card_border_color', '#eee' );
			$shop_product_card_border_size 	= get_theme_mod( 'shop_product_card_border_size', 1 );
			$shop_product_card_background 	= get_theme_mod( 'shop_product_card_background' );
			$shop_product_card_radius 		= get_theme_mod( 'shop_product_card_radius' );
			$shop_product_card_thumb_radius = get_theme_mod( 'shop_product_card_thumb_radius' );

			if ( 'layout2' === $shop_product_card_style || 'layout3' === $shop_product_card_style ) {
				$custom .= ".woocommerce-page ul.products li.product { background-color: " . esc_attr( $shop_product_card_background ) . ";border-radius: " . intval( $shop_product_card_radius ) . "px; border: " . intval( $shop_product_card_border_size ) . "px solid " . esc_attr( $shop_product_card_border_color ) . ";padding:30px;}" . "\n";			
				$custom .= "ul.products li.wc-block-grid__product .loop-image-wrap, ul.products li.product .loop-image-wrap { overflow:hidden;border-radius:" . esc_attr( $shop_product_card_thumb_radius ) . "px;}" . "\n";
			}

			if ( 'layout3' === $shop_product_card_style ) {
				$custom .= "ul.wc-block-grid__products li.wc-block-grid__product .loop-image-wrap, ul.wc-block-grid__products li.product .loop-image-wrap, ul.products li.wc-block-grid__product .loop-image-wrap, ul.products li.product .loop-image-wrap { margin:-30px -30px 12px;}" . "\n";
			}  
            
            //Global colors
			$custom .= $this->get_color_css( 'color_link_default', '', '.entry-content a:not(.button)' );
			$custom .= $this->get_color_css( 'color_link_hover', '', '.entry-content a:not(.button):hover' );
			$custom .= $this->get_color_css( 'color_heading_1', '', 'h1' );
			$custom .= $this->get_color_css( 'color_heading_2', '', 'h2' );
			$custom .= $this->get_color_css( 'color_heading_3', '', 'h3' );
			$custom .= $this->get_color_css( 'color_heading_4', '', 'h4' );
			$custom .= $this->get_color_css( 'color_heading_5', '', 'h5' );
			$custom .= $this->get_color_css( 'color_heading_6', '', 'h6' );            

			$custom .= $this->get_color_css( 'color_forms_text', '', 'div.wpforms-container-full .wpforms-form input[type=date], div.wpforms-container-full .wpforms-form input[type=datetime], div.wpforms-container-full .wpforms-form input[type=datetime-local], div.wpforms-container-full .wpforms-form input[type=email], div.wpforms-container-full .wpforms-form input[type=month], div.wpforms-container-full .wpforms-form input[type=number], div.wpforms-container-full .wpforms-form input[type=password], div.wpforms-container-full .wpforms-form input[type=range], div.wpforms-container-full .wpforms-form input[type=search], div.wpforms-container-full .wpforms-form input[type=tel], div.wpforms-container-full .wpforms-form input[type=text], div.wpforms-container-full .wpforms-form input[type=time], div.wpforms-container-full .wpforms-form input[type=url], div.wpforms-container-full .wpforms-form input[type=week], div.wpforms-container-full .wpforms-form select, div.wpforms-container-full .wpforms-form textarea,input[type="text"],input[type="email"],input[type="url"],input[type="password"],input[type="search"],input[type="number"],input[type="tel"],input[type="range"],input[type="date"],input[type="month"],input[type="week"],input[type="time"],input[type="datetime"],input[type="datetime-local"],input[type="color"],textarea,select,.woocommerce .select2-container .select2-selection--single,.woocommerce-page .select2-container .select2-selection--single,input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="number"]:focus, input[type="tel"]:focus, input[type="range"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="time"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="color"]:focus, textarea:focus, select:focus, .woocommerce .select2-container .select2-selection--single:focus, .woocommerce-page .select2-container .select2-selection--single:focus,.select2-container--default .select2-selection--single .select2-selection__rendered,.wp-block-search .wp-block-search__input,.wp-block-search .wp-block-search__input:focus' );
			$custom .= $this->get_background_color_css( 'color_forms_background', '', 'div.wpforms-container-full .wpforms-form input[type=date], div.wpforms-container-full .wpforms-form input[type=datetime], div.wpforms-container-full .wpforms-form input[type=datetime-local], div.wpforms-container-full .wpforms-form input[type=email], div.wpforms-container-full .wpforms-form input[type=month], div.wpforms-container-full .wpforms-form input[type=number], div.wpforms-container-full .wpforms-form input[type=password], div.wpforms-container-full .wpforms-form input[type=range], div.wpforms-container-full .wpforms-form input[type=search], div.wpforms-container-full .wpforms-form input[type=tel], div.wpforms-container-full .wpforms-form input[type=text], div.wpforms-container-full .wpforms-form input[type=time], div.wpforms-container-full .wpforms-form input[type=url], div.wpforms-container-full .wpforms-form input[type=week], div.wpforms-container-full .wpforms-form select, div.wpforms-container-full .wpforms-form textarea,input[type="text"],input[type="email"],input[type="url"],input[type="password"],input[type="search"],input[type="number"],input[type="tel"],input[type="range"],input[type="date"],input[type="month"],input[type="week"],input[type="time"],input[type="datetime"],input[type="datetime-local"],input[type="color"],textarea,select,.woocommerce .select2-container .select2-selection--single,.woocommerce-page .select2-container .select2-selection--single,.woocommerce-cart .woocommerce-cart-form .actions .coupon input[type="text"]' );
			$color_forms_borders 	= get_theme_mod( 'color_forms_borders' );
			$custom .= "div.wpforms-container-full .wpforms-form input[type=date], div.wpforms-container-full .wpforms-form input[type=datetime], div.wpforms-container-full .wpforms-form input[type=datetime-local], div.wpforms-container-full .wpforms-form input[type=email], div.wpforms-container-full .wpforms-form input[type=month], div.wpforms-container-full .wpforms-form input[type=number], div.wpforms-container-full .wpforms-form input[type=password], div.wpforms-container-full .wpforms-form input[type=range], div.wpforms-container-full .wpforms-form input[type=search], div.wpforms-container-full .wpforms-form input[type=tel], div.wpforms-container-full .wpforms-form input[type=text], div.wpforms-container-full .wpforms-form input[type=time], div.wpforms-container-full .wpforms-form input[type=url], div.wpforms-container-full .wpforms-form input[type=week], div.wpforms-container-full .wpforms-form select, div.wpforms-container-full .wpforms-form textarea,input[type=\"text\"],input[type=\"email\"],input[type=\"url\"],input[type=\"password\"],input[type=\"search\"],input[type=\"number\"],input[type=\"tel\"],input[type=\"range\"],input[type=\"date\"],input[type=\"month\"],input[type=\"week\"],input[type=\"time\"],input[type=\"datetime\"],input[type=\"datetime-local\"],input[type=\"color\"],textarea,select,.woocommerce .select2-container .select2-selection--single,.woocommerce-page .select2-container .select2-selection--single,.woocommerce-account fieldset,.woocommerce-account .woocommerce-form-login, .woocommerce-account .woocommerce-form-register,.woocommerce-cart .woocommerce-cart-form .actions .coupon input[type=\"text\"],.wp-block-search .wp-block-search__input { border-color:" . esc_attr( $color_forms_borders ) . ";}" . "\n";
			$color_forms_placeholder 	= get_theme_mod( 'color_forms_placeholder' );
			$custom .= "input::placeholder { color:" . esc_attr( $color_forms_placeholder ) . ";opacity:1;}" . "\n";
			$custom .= "input:-ms-input-placeholder { color:" . esc_attr( $color_forms_placeholder ) . ";}" . "\n";
			$custom .= "input::-ms-input-placeholder { color:" . esc_attr( $color_forms_placeholder ) . ";}" . "\n";

            /* End porting */

			//Container widths
			$container_width = get_theme_mod( 'container_width', 1170 );
			if ( 1170 !== $container_width ) {
				$custom .= '@media (min-width: 1200px) { .container { width:100%;max-width: ' . intval( $container_width ) . 'px; } }';
			}

			$narrow_container_width = get_theme_mod( 'narrow_container_width', 860 );
			if ( 860 !== $narrow_container_width ) {
				$custom .= '@media (min-width: 1200px) { .container-narrow { width:100%;max-width: ' . intval( $narrow_container_width ) . 'px; } }';
			}
        
            $custom = apply_filters( 'sydney_custom_css', $custom );

			$custom = $this->minify( $custom );

			return $custom;
		}

		/**
		 * Print styles
		 */
		public function print_styles() {

			$custom = $this->output_css();

			wp_add_inline_style( 'sydney-style-min', $custom );

			wp_localize_script( 'sydney_customizer', 'sydney_theme_options', $this->customizer_js );
		}

		/**
		 * CSS code minification.
		 */
		private function minify( $css ) {
			$css = preg_replace( '/\s+/', ' ', $css );
			$css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );
			$css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );
			$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );
			$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
			$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

			return trim( $css );
		}

		/**
		 * Get color CSS
		 */
		public static function get_background_color_css( $setting, $default, $selector, $important = false ) {
			$mod = get_theme_mod( $setting, $default );

			Sydney_Custom_CSS::get_instance()->mount_customizer_js_options( $selector, $setting, 'background-color', '', $important );

			return $selector . '{ background-color:' . esc_attr( $mod ) . ';}' . "\n";
		}

		/**
		 * Get color CSS
		 */
		public static function get_color_css( $setting, $default, $selector, $important = false ) {
			$mod = get_theme_mod( $setting, $default );

            Sydney_Custom_CSS::get_instance()->mount_customizer_js_options( $selector, $setting, 'color', '', $important );

			return $selector . '{ color:' . esc_attr( $mod ) . ';}' . "\n";
		}		

		/**
		 * Get border color CSS
		 */
		public static function get_border_color_css( $setting, $default, $selector ) {
			$mod = get_theme_mod( $setting, $default );

			return $selector . '{ border-color:' . esc_attr( $mod ) . ';}' . "\n";
		}			
		
		/**
		 * Get fill CSS
		 */
		public static function get_fill_css( $setting, $default, $selector, $important = false ) {
			$mod = get_theme_mod( $setting, $default );

			Sydney_Custom_CSS::get_instance()->mount_customizer_js_options( $selector, $setting, 'fill', '', $important );

			return $selector . '{ fill:' . esc_attr( $mod ) . ';}' . "\n";
		}	
		
		/**
		 * Get stroke CSS
		 */
		public static function get_stroke_css( $setting, $default, $selector ) {
			$mod = get_theme_mod( $setting, $default );

			return $selector . '{ stroke:' . esc_attr( $mod ) . ';}' . "\n";
		}		

		//Font sizes
		public static function get_font_sizes_css( $setting, $defaults, $selector ) {
			$devices 	= array( 
				'desktop' 	=> '@media (min-width: 992px)',
				'tablet'	=> '@media (min-width: 576px) and (max-width:  991px)',
				'mobile'	=> '@media (max-width: 575px)'
			);

			$css = '';

			foreach ( $devices as $device => $media ) {
				$mod = get_theme_mod( $setting . '_' . $device, $defaults[$device] );
				$css .= $media . ' { ' . $selector . ' { font-size:' . intval( $mod ) . 'px;} }' . "\n";	
			}

			return $css;
		}

		public static function mount_customizer_js_options( $selector = '', $setting = '', $prop = '', $opacity = '', $important = false ) {
			$options = array(
				'option'   => $setting,
				'selector' => $selector,
				'prop'     => $prop
			);

			if( $opacity ) {
				$options[ 'rgba' ] = $opacity;
			}

			// if( strpos( $selector, ':after' ) !== FALSE || strpos( $selector, ':before' ) !== FALSE || strpos( $selector, ':hover' ) !== FALSE || $important ) {
				$options[ 'pseudo' ] = true;
			// }
			
			Sydney_Custom_CSS::get_instance()->customizer_js[] = $options;
		}
		
		//Max width
		public static function get_max_width_css( $setting, $defaults, $selector ) {
			$devices 	= array( 
				'desktop' 	=> '@media (min-width: 992px)',
				'tablet'	=> '@media (min-width: 576px) and (max-width:  991px)',
				'mobile'	=> '@media (max-width: 575px)'
			);

			$css = '';

			foreach ( $devices as $device => $media ) {
				$mod = get_theme_mod( $setting . '_' . $device, $defaults[$device] );
				$css .= $media . ' { ' . $selector . ' { max-width:' . intval( $mod ) . 'px;} }' . "\n";	
			}

			return $css;
		}			

		//Max height
		public static function get_max_height_css( $setting, $defaults, $selector ) {
			$devices 	= array( 
				'desktop' 	=> '@media (min-width: 992px)',
				'tablet'	=> '@media (min-width: 576px) and (max-width:  991px)',
				'mobile'	=> '@media (max-width: 575px)'
			);

			$css = '';

			foreach ( $devices as $device => $media ) {
				$mod = get_theme_mod( $setting . '_' . $device, $defaults[$device] );
				$css .= $media . ' { ' . $selector . ' { max-height:' . intval( $mod ) . 'px;} }' . "\n";	
			}

			return $css;
		}	

		//Top bottom padding
		public static function get_top_bottom_padding_css( $setting, $defaults, $selector ) {
			$devices 	= array( 
				'desktop' 	=> '@media (min-width: 992px)',
				'tablet'	=> '@media (min-width: 576px) and (max-width:  991px)',
				'mobile'	=> '@media (max-width: 575px)'
			);

			$css = '';

			foreach ( $devices as $device => $media ) {
				$mod = get_theme_mod( $setting . '_' . $device, $defaults[$device] );
				$css .= $media . ' { ' . $selector . ' { padding-top:' . intval( $mod ) . 'px;padding-bottom:' . intval( $mod ) . 'px;} }' . "\n";	
			}

			return $css;
		}	

		//Left right padding
		public static function get_left_right_padding_css( $setting, $defaults, $selector ) {
			$devices 	= array( 
				'desktop' 	=> '@media (min-width: 992px)',
				'tablet'	=> '@media (min-width: 576px) and (max-width:  991px)',
				'mobile'	=> '@media (max-width: 575px)'
			);

			$css = '';

			foreach ( $devices as $device => $media ) {
				$mod = get_theme_mod( $setting . '_' . $device, $defaults[$device] );
				$css .= $media . ' { ' . $selector . ' { padding-left:' . intval( $mod ) . 'px;padding-right:' . intval( $mod ) . 'px;} }' . "\n";	
			}

			return $css;
		}	

        public function hex2rgba($color, $opacity = false) {

            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            $rgb =  array_map('hexdec', $hex);
            $opacity = 0.9;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    
            return $output;
        }

		/**
		 * Get background color rgba CSS
		 */
		public static function get_background_color_rgba_css( $setting, $default, $selector, $opacity ) {
			$mod = get_theme_mod( $setting, $default );

			return $selector . '{ background-color:' . esc_attr( Sydney_Custom_CSS::get_instance()->hex2rgba( $mod, $opacity ) ) . ';}' . "\n";
		}        

 		/**
		 * Get border color rgba CSS
		 */
		public static function get_border_color_rgba_css( $setting, $default, $selector, $opacity, $important = false ) {
			$mod = get_theme_mod( $setting, $default );

			return $selector . '{ border-color:' . esc_attr( Sydney_Custom_CSS::get_instance()->hex2rgba( $mod, $opacity ) ) . ( $important ? '!important' : '' ) .';}' . "\n";
		}
	}

	/**
	 * Initialize class
	 */
	Sydney_Custom_CSS::get_instance();

endif;