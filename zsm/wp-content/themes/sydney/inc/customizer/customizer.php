<?php
/**
 * Sydney Theme Customizer
 *
 * @package Sydney
 */

function sydney_customize_register( $wp_customize ) {
	$wp_customize->remove_control( 'header_textcolor' );
    $wp_customize->remove_control( 'display_header_text' );
    $wp_customize->get_section( 'header_image' )->panel = 'sydney_panel_hero';
    $wp_customize->get_section( 'header_image' )->priority = 99;
    $wp_customize->get_section( 'title_tagline' )->priority = 9;

    if ( get_option( 'sydney-update-header' ) ) {
        $wp_customize->get_section( 'title_tagline' )->panel = 'sydney_panel_header';
    }

    //Partials
    for ($i = 1; $i < 5; $i++) { 
        $wp_customize->selective_refresh->add_partial( 'slider_title_' . $i, array(
            'selector'          => '.slide-item-' . $i . ' .maintitle',
            'render_callback'   => 'sydney_partial_slider_title_' . $i,
        ) );
        $wp_customize->selective_refresh->add_partial( 'slider_subtitle_' . $i, array(
            'selector'          => '.slide-item-' . $i . ' .subtitle',
            'render_callback'   => 'sydney_partial_slider_subtitle_' . $i,
        ) );        
    }    
    $wp_customize->selective_refresh->add_partial( 'slider_button_text', array(
        'selector'          => '.button-slider',
        'render_callback'   => 'sydney_partial_slider_button_text',
    ) );   

    //Divider
    class Sydney_Divider extends WP_Customize_Control {
         public function render_content() {
            echo '<hr style="margin: 15px 0;border-top: 1px dashed #919191;" />';
         }
    }
    //Titles
    class Sydney_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3 style="padding:12px;color:#000;background:#cbcbcb;text-align:center;text-transform:uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    
    //Titles
    class Sydney_Theme_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }

    /**
     * Callbacks and sanitize
     */
    require get_template_directory() . '/inc/customizer/callbacks.php';
    require get_template_directory() . '/inc/customizer/sanitize.php';

    /**
     * Controls
     */
    require get_template_directory() . '/inc/customizer/controls/typography/class_sydney_typography.php';
    require get_template_directory() . '/inc/customizer/controls/repeater/class_sydney_repeater.php';
    require get_template_directory() . '/inc/customizer/controls/alpha-color/class_sydney_alpha_color.php';
    require get_template_directory() . '/inc/customizer/controls/radio-images/class_sydney_radio_images.php';
    require get_template_directory() . '/inc/customizer/controls/radio-buttons/class_sydney_radio_buttons.php';
    require get_template_directory() . '/inc/customizer/controls/responsive-slider/class_sydney_responsive_slider.php';
    require get_template_directory() . '/inc/customizer/controls/class_sydney_tab_control.php';
    require get_template_directory() . '/inc/customizer/controls/class_sydney_text_control.php';
    //require get_template_directory() . '/inc/customizer/controls/class_sydney_tinymce_control.php';
    require get_template_directory() . '/inc/customizer/controls/class_sydney_divider_control.php';
    require get_template_directory() . '/inc/customizer/controls/toggle/class_sydney_toggle_control.php';
    require get_template_directory() . '/inc/customizer/controls/accordion/class_sydney_accordion_control.php';    
    require get_template_directory() . '/inc/customizer/controls/class_sydney_upsell_message.php';    

    require get_template_directory() . '/inc/customizer/controls/control-checkbox-multiple.php';
    require get_template_directory() . '/inc/customizer/controls/multiple-select/class-control-multiple-select.php';
    $wp_customize->register_control_type( 'Sydney_Select2_Custom_Control' 	);
    $wp_customize->register_control_type( '\Kirki\Control\sortable' );
    require get_template_directory() . '/inc/customizer/controls/display-conditions/class_sydney_display_conditions_control.php';

    /**
     * Options
     */
    require get_template_directory() . '/inc/customizer/options/general.php';
    if ( get_option( 'sydney-update-header' ) ) {
        require get_template_directory() . '/inc/customizer/options/header.php';
        require get_template_directory() . '/inc/customizer/options/header-mobile.php';
    }
    require get_template_directory() . '/inc/customizer/options/typography.php';
    require get_template_directory() . '/inc/customizer/options/footer.php';
    require get_template_directory() . '/inc/customizer/options/blog.php';
    require get_template_directory() . '/inc/customizer/options/blog-single.php';
    require get_template_directory() . '/inc/customizer/options/colors.php';
    require get_template_directory() . '/inc/customizer/options/upsell.php';
    require get_template_directory() . '/inc/customizer/options/performance.php';
    require get_template_directory() . '/inc/customizer/options/cpt-panels.php';
    require get_template_directory() . '/inc/customizer/options/layouts.php';

    if ( class_exists( 'Woocommerce' ) ) {
        require get_template_directory() . '/inc/customizer/options/woocommerce.php';
        require get_template_directory() . '/inc/customizer/options/woocommerce-single.php';
    }
    
    //___Hero slider___//
    require get_template_directory() . '/inc/customizer/options/hero-area.php';
         

    if ( false == get_option( 'sydney-update-header' ) ) {
    //___Menu style___//
    $wp_customize->add_section(
        'sydney_menu_style',
        array(
            'title'         => __('Menu layout', 'sydney'),
            'priority'      => 15,
            'panel'         => 'sydney_panel_hero', 
        )
    );
    //Sticky menu
    $wp_customize->add_setting(
        'sticky_menu',
        array(
            'default'           => 'sticky',
            'sanitize_callback' => 'sydney_sanitize_sticky',
        )
    );
    $wp_customize->add_control(
        'sticky_menu',
        array(
            'type' => 'radio',
            'priority'    => 10,
            'label' => __('Sticky menu', 'sydney'),
            'section' => 'sydney_menu_style',
            'choices' => array(
                'sticky'   => __('Sticky', 'sydney'),
                'static'   => __('Static', 'sydney'),
            ),
        )
    );
    //Menu style
    $wp_customize->add_setting(
        'menu_style',
        array(
            'default'           => 'inline',
            'sanitize_callback' => 'sydney_sanitize_menu_style',
        )
    );
    $wp_customize->add_control(
        'menu_style',
        array(
            'type'      => 'radio',
            'priority'  => 11,
            'label'     => __('Menu style', 'sydney'),
            'section'   => 'sydney_menu_style',
            'choices'   => array(
                'inline'     => __('Inline', 'sydney'),
                'centered'   => __('Centered (menu and site logo)', 'sydney'),
            ),
        )
    );
    //Menu style
    $wp_customize->add_setting(
        'menu_container',
        array(
            'default'           => 'container',
            'sanitize_callback' => 'sydney_sanitize_menu_container',
        )
    );
    $wp_customize->add_control(
        'menu_container',
        array(
            'type'      => 'select',
            'priority'  => 11,
            'label'     => __('Menu container', 'sydney'),
            'section'   => 'sydney_menu_style',
            'choices'   => array(
                'container'         => __('Contained', 'sydney'),
                'fw-menu-container' => __('Full width', 'sydney'),
            ),
        )
    );    
    //Custom menu item
    $wp_customize->add_setting(
        'header_button_html',
        array(
            'default'           => 'nothing',
            'sanitize_callback' => 'sydney_sanitize_header_custom_item',
        )
    );
    $wp_customize->add_control(
        'header_button_html',
        array(
            'type'      => 'select',
            'priority'  => 11,
            'label'     => __('Header custom item', 'sydney'),
            'section'   => 'sydney_menu_style',
            'choices'   => array(
                'nothing'   => __( 'Nothing', 'sydney'  ),
                'button'    => __( 'Button', 'sydney'  ),
                'html'      => __( 'HTML', 'sydney'   ),
            ),
        )
    );    

    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Divider( $wp_customize, 'hcs_sep', array(
            'section' => 'sydney_menu_style',
            'settings' => 'sydney_options[info]',
            'priority' => 11,
            'active_callback' => 'sydney_header_custom_btn_active_callback'
        ) )
    ); 

    $wp_customize->add_setting(
        'header_custom_item_btn_link',
        array(
            'default' => 'https://example.org/',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'header_custom_item_btn_link',
        array(
            'label'     => __( 'Button link', 'sydney' ),
            'section'   => 'sydney_menu_style',
            'type'      => 'text',
            'priority'  => 11,
            'active_callback' => 'sydney_header_custom_btn_active_callback'
        )
    );
    $wp_customize->add_setting(
        'header_custom_item_btn_text',
        array(
            'default'           => __( 'Get in touch', 'sydney' ),
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'header_custom_item_btn_text',
        array(
            'label'     => __( 'Button text', 'sydney' ),
            'section'   => 'sydney_menu_style',
            'type'      => 'text',
            'priority'  => 11,
            'active_callback' => 'sydney_header_custom_btn_active_callback'
        )
    );
    $wp_customize->add_setting(
        'header_custom_item_btn_target',
        array(
            'default'           => 1,
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'header_custom_item_btn_target',
        array(
            'type'              => 'checkbox',
            'label'             => __('Open link in a new tab?', 'sydney'),
            'section'           => 'sydney_menu_style',
            'priority'          => 11,
            'active_callback'   => 'sydney_header_custom_btn_active_callback'
        )
    );  
    $wp_customize->add_setting(
        'header_custom_item_btn_tb_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '12',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'header_custom_item_btn_tb_padding', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Top/bottom button padding', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 40,
            'step'  => 1,
        ),
        'active_callback'   => 'sydney_header_custom_btn_active_callback'
    ) );
    $wp_customize->add_setting(
        'header_custom_item_btn_lr_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '35',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'header_custom_item_btn_lr_padding', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Left/right button padding', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 50,
            'step'  => 1,
        ),
        'active_callback'   => 'sydney_header_custom_btn_active_callback'
    ) );
    //Font size
    $wp_customize->add_setting(
        'header_custom_item_btn_font_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '13',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'header_custom_item_btn_font_size', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Button font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 40,
            'step'  => 1,
        ),
        'active_callback'   => 'sydney_header_custom_btn_active_callback'
    ) ); 
    //Border radius
    $wp_customize->add_setting(
        'header_custom_item_btn_radius',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '3',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'header_custom_item_btn_radius', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Button border radius', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 50,
            'step'  => 1,
        ),
        'active_callback'   => 'sydney_header_custom_btn_active_callback'
    ) );

    //Custom header html
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Divider( $wp_customize, 'hcs_html_sep', array(
            'section' => 'sydney_menu_style',
            'settings' => 'sydney_options[info]',
            'priority' => 11,
            'active_callback' => 'sydney_header_custom_html_active_callback'
        ) )
    );     
    $wp_customize->add_setting(
        'header_custom_item_html',
        array(
            'sanitize_callback' => 'sydney_sanitize_text',
            'default'           => '<a href="#">Your content</a>',
        )       
    );
    $wp_customize->add_control( 'header_custom_item_html', array(
        'type'        => 'textarea',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Custom HTML', 'sydney'),
        'active_callback'   => 'sydney_header_custom_html_active_callback'
    ) );

    }


    //Header image size
    $wp_customize->add_setting(
        'header_bg_size',
        array(
            'default'           => 'cover',
            'sanitize_callback' => 'sydney_sanitize_bg_size',
        )
    );
    $wp_customize->add_control(
        'header_bg_size',
        array(
            'type' => 'radio',
            'priority'    => 10,
            'label' => __('Header background size', 'sydney'),
            'section' => 'header_image',
            'choices' => array(
                'cover'     => __('Cover', 'sydney'),
                'contain'   => __('Contain', 'sydney'),
            ),
        )
    );
    //Header height
    $wp_customize->add_setting(
        'header_height',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '300',
        )       
    );
    $wp_customize->add_control( 'header_height', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'header_image',
        'label'       => __('Header height [default: 300px]', 'sydney'),
        'input_attrs' => array(
            'min'   => 250,
            'max'   => 600,
            'step'  => 5,
        ),
    ) );
    //Disable overlay
    $wp_customize->add_setting(
        'hide_overlay',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'hide_overlay',
        array(
            'type'      => 'checkbox',
            'label'     => __('Disable the overlay?', 'sydney'),
            'section'   => 'header_image',
            'priority'  => 12,
        )
    );    
    //Logo Upload
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your logo', 'sydney' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
               'priority'       => 12,
            )
        )
    );

    //___Theme info___//
    $wp_customize->add_section(
        'sydney_themeinfo',
        array(
            'title' => __('Theme info', 'sydney'),
            'priority' => 139,
            'description' => 
            '<p style="padding-bottom: 10px;border-bottom: 1px solid #d3d2d2">' . __(' 1. Documentation for Sydney can be found ', 'sydney') . '<a target="_blank" href="https://docs.athemes.com/category/8-sydney">here</a></p>' 
            . '<p style="padding-bottom: 10px;border-bottom: 1px solid #d3d2d2">' . __(' 2. All of our starter sites, both free and pro, can be previewed ', 'sydney') . '<a target="_blank" href="https://athemes.com/sydney-demos">here</a></p>'
            . '<p style="padding-bottom: 10px;border-bottom: 1px solid #d3d2d2">' .  __(' 3. You can receive free support on the community forums ', 'sydney') . '<a target="_blank" href="https://wordpress.org/support/theme/sydney/">here</a></p>'
            .  __(' 4. Priority email support is available for our premium users. You can upgrade ', 'sydney') . '<a target="_blank" href="https://athemes.com/sydney-upgrade/?utm_source=theme_customizer_deep&utm_medium=sydney_customizer&utm_campaign=Sydney">here</a>'   
                 
        )
    );
    $wp_customize->add_setting('sydney_theme_docs', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Theme_Info( $wp_customize, 'documentation', array(
        'section' => 'sydney_themeinfo',
        'settings' => 'sydney_theme_docs',
        'priority' => 10
        ) )
    ); 

    //___Pages___//
    $wp_customize->add_section(
        'sydney_cpt_page',
        array(
            'title' => __('Pages', 'sydney'),
            'priority' => 13,
        )
    ); 

}
add_action( 'customize_register', 'sydney_customize_register' );

/**
 * Sanitize
 */
//Header type
function sydney_sanitize_layout( $input ) {
    $valid = array(
        'slider'    => __('Full screen slider', 'sydney'),
        'image'     => __('Image', 'sydney'),
        'core-video'=> __('Video', 'sydney'),
        'nothing'   => __('Nothing (only menu)', 'sydney')
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

//Background size
function sydney_sanitize_bg_size( $input ) {
    $valid = array(
        'cover'     => __('Cover', 'sydney'),
        'contain'   => __('Contain', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Footer widget areas
function sydney_sanitize_fw( $input ) {
    $valid = array(
        '1'     => __('One', 'sydney'),
        '2'     => __('Two', 'sydney'),
        '3'     => __('Three', 'sydney'),
        '4'     => __('Four', 'sydney')
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Sticky menu
function sydney_sanitize_sticky( $input ) {
    $valid = array(
        'sticky'     => __('Sticky', 'sydney'),
        'static'   => __('Static', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Blog Layout
function sydney_sanitize_blog( $input ) {
    $valid = array(
        'classic'    => __( 'Classic', 'sydney' ),
        'classic-alt'    => __( 'Classic (alternative)', 'sydney' ),
        'modern'    => __( 'Modern', 'sydney' ),
        'fullwidth'  => __( 'Full width (no sidebar)', 'sydney' ),
        'masonry-layout'    => __( 'Masonry (grid style)', 'sydney' )

    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Mobile slider
function sydney_sanitize_mslider( $input ) {
    $valid = array(
        'fullscreen'    => __('Full screen', 'sydney'),
        'responsive'    => __('Responsive', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Menu style
function sydney_sanitize_menu_style( $input ) {
    $valid = array(
        'inline'     => __('Inline', 'sydney'),
        'centered'   => __('Centered (menu and site logo)', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Checkboxes
function sydney_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

function sydney_sanitize_font_weights( $input ) {
    if ( is_array( $input ) ) {
        return $input;
    }
}
function sydney_sanitize_header_custom_item( $input ) {
    if ( in_array( $input, array( 'nothing', 'button', 'html' ), true ) ) {
        return $input;
    }
}
function sydney_sanitize_menu_container( $input ) {
    if ( in_array( $input, array( 'container', 'fw-menu-container' ), true ) ) {
        return $input;
    }
}
/**
 * Selects
 */
function sydney_sanitize_selects( $input, $setting ){
          
    $input = sanitize_key($input);

    $choices = $setting->manager->get_control( $setting->id )->choices;
                      
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
      
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sydney_customize_preview_js() {
	wp_enqueue_script( 'sydney_customizer', get_template_directory_uri() . '/js/customizer.min.js', array( 'customize-preview' ), '20221004', true );

    $post_type_array = sydney_get_posts_types_for_js();

    wp_localize_script( 'sydney_customizer', 'syd_data', array( 'post_types' => $post_type_array ) );
}
add_action( 'customize_preview_init', 'sydney_customize_preview_js' );

/**
 * Load display conditions template
 */
require get_template_directory() . '/inc/customizer/controls/display-conditions/display-conditions-script-template.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require get_template_directory() . '/inc/customizer/controls/display-conditions/ajax-callback.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

/**
 * Customizer assets
 */
function sydney_customize_footer_scripts() {
    
    wp_enqueue_style( 'sydney-customizer-styles', get_template_directory_uri() . '/css/customizer.min.css', '', '20221019' );
    wp_enqueue_script( 'sydney-customizer-scripts', get_template_directory_uri() . '/js/customize-controls.min.js', array( 'jquery', 'jquery-ui-core' ), '20221019', true );

    $post_type_array = sydney_get_posts_types_for_js();

    wp_localize_script( 'sydney-customizer-scripts', 'syd_data',
        array( 
            'post_types' => $post_type_array,
            'ajax_url'   => admin_url( 'admin-ajax.php' ),
            'ajax_nonce' => wp_create_nonce( 'sydney_ajax_nonce' ),
    ) );
}
add_action( 'customize_controls_print_footer_scripts', 'sydney_customize_footer_scripts' );

/**
 * Partials callbacks
 */
//Slider titles
function sydney_partial_slider_title_1() {
    return get_theme_mod('slider_title_1', __('Click the pencil icon to change this text','sydney'));
}
function sydney_partial_slider_title_2() {
    return get_theme_mod('slider_title_2');
}
function sydney_partial_slider_title_3() {
    return get_theme_mod('slider_title_3');
}
function sydney_partial_slider_title_4() {
    return get_theme_mod('slider_title_4');
}
function sydney_partial_slider_title_5() {
    return get_theme_mod('slider_title_5');
}
//Slider subtitles
function sydney_partial_slider_subtitle_1() {
    return get_theme_mod('slider_subtitle_1', __('or go to the Customizer','sydney'));
}
function sydney_partial_slider_subtitle_2() {
    return get_theme_mod('slider_subtitle_2');
}
function sydney_partial_slider_subtitle_3() {
    return get_theme_mod('slider_subtitle_3');
}
function sydney_partial_slider_subtitle_4() {
    return get_theme_mod('slider_subtitle_4');
}
function sydney_partial_slider_subtitle_5() {
    return get_theme_mod('slider_subtitle_5');
}
function sydney_partial_slider_button_text() {
    return get_theme_mod('slider_button_text');
}
//Header custom items active callbacks
function sydney_header_custom_btn_active_callback() {
    $type = get_theme_mod( 'header_button_html' );

    if ( 'button' == $type ) {
        return true;
    } else {
        return false;
    }
}

function sydney_header_custom_html_active_callback() {
    $type = get_theme_mod( 'header_button_html' );

    if ( 'html' == $type ) {
        return true;
    } else {
        return false;
    }
}

function sydney_get_posts_types_for_js() {
    //Send post types to js
    $args       = array(
        'public' => true,
    );
    $post_types = get_post_types( $args, 'objects' );
    
    //Remove unwanted post types
    $unset_types = array(
        'product',
        'attachment',
        'e-landing-page',
        'elementor_library',
        'athemes_hf',
    );
    
    foreach ( $unset_types as $type ) {
        unset( $post_types[ $type ] );
    }
    
    $post_type_array = array();
    foreach ( $post_types as $post_type ) {
        $post_type_array[] = $post_type->name;
    }

    return $post_type_array;
}