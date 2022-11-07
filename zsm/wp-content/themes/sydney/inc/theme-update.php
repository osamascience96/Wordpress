<?php
/**
 * Theme update functions
 * 
 * to do: use version compare
 *
 */

/**
 * Migrate blog layout
 */
function sydney_migrate_blog_layout() {

    $flag = get_theme_mod( 'sydney_migrate_blog_layout_flag', false );

    if ( true === $flag ) {
        return;
    }

    //Migrate blog layout
    $layout = get_theme_mod( 'blog_layout', 'classic-alt' );

    if ( 'classic' === $layout || 'modern' === $layout ) {
        set_theme_mod( 'blog_layout', 'layout1' );
    } elseif ( 'classic-alt' === $layout ) {
        set_theme_mod( 'blog_layout', 'layout2' );
    } elseif ( 'fullwidth' === $layout ) {
        set_theme_mod( 'blog_layout', 'layout1' );
        set_theme_mod( 'sidebar_archives', 0 );
    } elseif ( 'masonry-layout' === $layout ) {
        set_theme_mod( 'blog_layout', 'layout5' );
        set_theme_mod( 'sidebar_archives', 0 );
    } 

    //Migrate archives sidebar - only pro
    $fullwidth_archives = get_theme_mod( 'fullwidth_archives', 0 );

    if ( $fullwidth_archives ) {
        set_theme_mod( 'sidebar_archives', 0 );
    }

    //Migrate archive meta
    $hide_meta_index = get_theme_mod( 'hide_meta_index', 0 );
    if ( $hide_meta_index ) {
        set_theme_mod( 'archive_meta_elements', array() );
    }   

    //Migrate single post featured image 
    $post_feat_image = get_theme_mod( 'post_feat_image', 0 );
    if ( $post_feat_image ) {
        set_theme_mod( 'single_post_show_featured', 0 );
    }    

    //Migrate single post sidebar
    $fullwidth_single = get_theme_mod( 'fullwidth_single', 0 );
    if ( $fullwidth_single ) {
        set_theme_mod( 'sidebar_single_post', 0 );
    }

    //Migrate single post nav
    $disable_single_post_nav = get_theme_mod( 'disable_single_post_nav', 0 );
    if ( $disable_single_post_nav ) {
        set_theme_mod( 'single_post_show_post_nav', 0 );
    }

    //Migrate single meta
    $hide_meta_single = get_theme_mod( 'hide_meta_single', 0 );
    if ( $hide_meta_single ) {
        set_theme_mod( 'single_post_meta_elements', array() );
    }   

    //Set flag
    set_theme_mod( 'sydney_migrate_blog_layout_flag', true );
}
add_action( 'init', 'sydney_migrate_blog_layout' );

/**
 * Header update notice
 * 
 * @since 1.8.1
 * 
 */
function sydney_header_update_notice_1_8_1() {

    if ( get_option( 'sydney-update-header-dismiss' ) ) {
        return;
    }
    
    if ( !get_option( 'sydney-update-header' ) ) { ?>

    <div class="notice notice-success thd-theme-dashboard-notice-success is-dismissible">
        <h3><?php esc_html_e( 'Sydney Header Update', 'sydney'); ?></h3>
        <p>
            <?php esc_html_e( 'This version of Sydney comes with a new and improved header. Activate it by clicking the button below and you can access new options.', 'sydney' ); ?>
        </p>

        <p>
            <?php esc_html_e( 'Note 1: this upgrade is optional, there is no need to do it if you are happy with your current header.', 'sydney' ); ?>
        </p>         
        <p>
            <?php esc_html_e( 'Note 2: your current header customizations will be lost and you will have to use the new options to customize your header.', 'sydney' ); ?>
        </p>   
        <p>
            <?php esc_html_e( 'Note 3: this upgrade refers only to the header (site identity and menu bar). It does not change any settings regarding your hero area (slider, video etc).', 'sydney' ); ?>
        </p>    
        <p>
            <?php esc_html_e( 'Note 4: Please take a full backup of your website before upgrading.', 'sydney' ); ?>
        </p>             
        <p>
            <?php echo sprintf( esc_html__( 'Want to see the new header options before upgrading? Check out our %s.', 'sydney' ), '<a target="_blank" href="https://docs.athemes.com/collection/370-sydney">documentation</a>' ); ?>
        </p>
        <a href="#" class="button sydney-update-header" data-nonce="<?php echo esc_attr( wp_create_nonce( 'sydney-update-header-nonce' ) ); ?>" style="margin-top: 15px;"><?php esc_html_e( 'Upgrade Theme Header', 'sydney' ); ?></a>
        <a href="#" class="button sydney-update-header-dismiss" data-nonce="<?php echo esc_attr( wp_create_nonce( 'sydney-update-header-dismiss-nonce' ) ); ?>" style="margin-top: 15px;"><?php esc_html_e( 'Continue to use the old header', 'sydney' ); ?></a> 
    </div>
    <?php }
}
add_action( 'admin_notices', 'sydney_header_update_notice_1_8_1' );


/**
 * Header update ajax callback
 * 
 * @since 1.8.1
 */
function sydney_header_update_notice_1_8_1_callback() {
	check_ajax_referer( 'sydney-update-header-nonce', 'nonce' );

	update_option( 'sydney-update-header', true );

	wp_send_json( array(
		'success' => true
	) );
}
add_action( 'wp_ajax_sydney_header_update_notice_1_8_1_callback', 'sydney_header_update_notice_1_8_1_callback' );

/**
 * Header update ajax callback
 * 
 * @since 1.82
 */
function sydney_header_update_dismiss_notice_1_8_2_callback() {
	check_ajax_referer( 'sydney-update-header-dismiss-nonce', 'nonce' );

	update_option( 'sydney-update-header-dismiss', true );

	wp_send_json( array(
		'success' => true
	) );
}
add_action( 'wp_ajax_sydney_header_update_dismiss_notice_1_8_2_callback', 'sydney_header_update_dismiss_notice_1_8_2_callback' );

/**
 * Migrate font families and sizes
 * 
 * Sydney free
 */
function sydney_migrate_typography() {

    $flag = get_theme_mod( 'sydney_migrate_typography', false );

    if ( true === $flag ) {
        return;
    }

    //Migrate body fonts 
    $body_font = get_theme_mod( 'body_font', 'Raleway' );

    if ( 'Raleway' !== $body_font ) {

        $body_font_family = json_encode(
            array(
                'font' 			=> $body_font,
                'regularweight' => 'regular',
                'category' 		=> 'sans-serif'
            )
        );        
        
        set_theme_mod( 'sydney_body_font', $body_font_family );
    }

    //Migrate headings fonts
    $headings_font = get_theme_mod( 'headings_font', 'Raleway' );

    if ( 'Raleway' !== $headings_font ) {

        $headings_font_family = json_encode(
            array(
                'font' 			=> $headings_font,
                'regularweight' => '600',
                'category' 		=> 'sans-serif'
            )
        );        
        
        set_theme_mod( 'sydney_headings_font', $headings_font_family );
    }    

    //Font sizes
    $h1_size = get_theme_mod( 'h1_size', 48 );
    set_theme_mod( 'h1_font_size_desktop', $h1_size );
    
    $h2_size = get_theme_mod( 'h2_size', 38 );
    set_theme_mod( 'h2_font_size_desktop', $h2_size );

    $h3_size = get_theme_mod( 'h3_size', 32 );
    set_theme_mod( 'h3_font_size_desktop', $h3_size );

    $h4_size = get_theme_mod( 'h4_size', 24 );
    set_theme_mod( 'h4_font_size_desktop', $h4_size );

    $h5_size = get_theme_mod( 'h5_size', 20 );
    set_theme_mod( 'h5_font_size_desktop', $h5_size );

    $h6_size = get_theme_mod( 'h6_size', 18 );
    set_theme_mod( 'h6_font_size_desktop', $h6_size );

    $body_size = get_theme_mod( 'body_size', 16 );
    set_theme_mod( 'body_font_size_desktop', $body_size );

    $single_post_title_size = get_theme_mod( 'single_post_title_size', 48 );
    set_theme_mod( 'single_post_title_size_desktop', $single_post_title_size );

    $site_title_size = get_theme_mod( 'site_title_size', 32 );
    set_theme_mod( 'site_title_font_size_desktop', $site_title_size );

    $site_desc_size = get_theme_mod( 'site_desc_size', 16 );
    set_theme_mod( 'site_desc_font_size_desktop', $site_desc_size );

    //Set flag
    set_theme_mod( 'sydney_migrate_typography', true );
}
add_action( 'init', 'sydney_migrate_typography' );


/**
 * Migrate Woocommerce options
 * 
 */
function sydney_migrate_woo_options() {

    $flag = get_theme_mod( 'sydney_migrate_woo_options', false );

    if ( true === $flag ) {
        return;
    }

    $swc_sidebar_archives = get_theme_mod( 'swc_sidebar_archives', 0 );
    if ( $swc_sidebar_archives ) {
        set_theme_mod( 'shop_archive_sidebar', 'no-sidebar' );
    }

    //Set flag
    set_theme_mod( 'sydney_migrate_woo_options', true );
}
add_action( 'init', 'sydney_migrate_woo_options' );

/**
 * Update footer colors
 * 
 */
function sydney_footer_default_colors() {

    $flag = get_theme_mod( 'sydney_update_footer_defaults', false );

    if ( true === $flag ) {
        return;
    }

    $footer_widgets_background  = get_theme_mod( 'footer_widgets_background' );
    $footer_widgets_color       = get_theme_mod( 'footer_widgets_color' );
    $footer_widgets_links_color = get_theme_mod( 'footer_widgets_links_color' );
    $footer_background          = get_theme_mod( 'footer_background' );
    $footer_color               = get_theme_mod( 'footer_color' );

    if ( '#252525' !== $footer_widgets_background ) {
        set_theme_mod( 'footer_widgets_background', '#00102E' );
    }
  
    if ( '#666666' !== $footer_widgets_color ) {
        set_theme_mod( 'footer_widgets_color', '#ffffff' );
    }  
    
    if ( '#666666' !== $footer_widgets_links_color ) {
        set_theme_mod( 'footer_widgets_links_color', '#ffffff' );
    }     

    if ( '#1c1c1c' !== $footer_background ) {
        set_theme_mod( 'footer_background', '#00102E' );
    }  
    
    if ( '#666666' !== $footer_color ) {
        set_theme_mod( 'footer_color', '#ffffff' );
    }      

    //enable and configure divider
    set_theme_mod( 'footer_credits_divider', 1 );
    set_theme_mod( 'footer_credits_divider_color', 'rgba(255,255,255,0.1)' );

    //Set flag
    set_theme_mod( 'sydney_update_footer_defaults', true );
}
add_action( 'after_switch_theme', 'sydney_footer_default_colors' );


/**
 * Set local Google Fonts by default
 * 
 */
function sydney_default_local_google_fonts() {
    set_theme_mod( 'perf_google_fonts_local', 1 );
}
add_action( 'after_switch_theme', 'sydney_default_local_google_fonts' );