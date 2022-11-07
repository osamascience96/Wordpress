<?php
/**
 * Hero area
 *
 * @package Sydney
 */

    //___Header area___//
    $wp_customize->add_panel( 'sydney_panel_hero', array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Hero area', 'sydney'),
    ) );
    //___Header type___//
    $wp_customize->add_section(
        'sydney_header_type',
        array(
            'title'         => __('Hero type', 'sydney'),
            'priority'      => 10,
            'panel'         => 'sydney_panel_hero', 
            'description'   => __('You can select your header type from here. After that, continue below to the next two tabs (Hero Slider and Header Image) and configure them.', 'sydney'),
        )
    );

    if ( !get_option( 'sydney-update-header' ) ) {
        $front_default = 'nothing';
        $site_default = 'image';
    } else {
        $front_default = 'nothing';
        $site_default = 'nothing';
    }    
    //Front page
    $wp_customize->add_setting(
        'front_header_type',
        array(
            'default'           =>  $front_default,
            'sanitize_callback' => 'sydney_sanitize_layout',
        )
    );
    $wp_customize->add_control(
        'front_header_type',
        array(
            'type'        => 'radio',
            'label'       => __('Front page header type', 'sydney'),
            'section'     => 'sydney_header_type',
            'description' => __('Select the header type for your front page', 'sydney'),
            'choices' => array(
                'slider'    => __('Full screen slider', 'sydney'),
                'image'     => __('Image', 'sydney'),
                'core-video'=> __('Video', 'sydney'),
                'nothing'   => __('No header (only menu)', 'sydney')
            ),
        )
    );
    //Site
    $wp_customize->add_setting(
        'site_header_type',
        array(
            'default'           => $site_default,
            'sanitize_callback' => 'sydney_sanitize_layout',
        )
    );
    $wp_customize->add_control(
        'site_header_type',
        array(
            'type'        => 'radio',
            'label'       => __('Site header type', 'sydney'),
            'section'     => 'sydney_header_type',
            'description' => __('Select the hero type for all pages except the front page', 'sydney'),
            'choices' => array(
                'slider'    => __('Full screen slider', 'sydney'),
                'image'     => __('Image', 'sydney'),
                'core-video'=> __('Video', 'sydney'),
                'nothing'   => __('No header (only menu)', 'sydney')
            ),
        )
    );

    //___Slider___//
    $wp_customize->add_section(
        'sydney_slider',
        array(
            'title'         => __('Hero Slider', 'sydney'),
            'priority'      => 11,
            'panel'         => 'sydney_panel_hero',
        )
    );

    //Image 1   
    $wp_customize->add_setting( 'accordion_slider_image_1', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Sydney_Accordion_Control(
            $wp_customize,
            'accordion_slider_image_1',
            array(
                'label'         => esc_html__( 'First slide', 'sydney' ),
                'section'       => 'sydney_slider',
                'until'         => 'slider_subtitle_1',
            )
        )
    );
    $wp_customize->add_setting(
        'slider_image_1',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            //'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_1',
            array(
               'label'          => __( 'Upload your first image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_1',
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_1',
        array(
            'default'           => __('Click the pencil icon to change this text','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        'slider_title_1',
        array(
            'label' => __( 'Title for the first slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_1',
        array(
            'default' => __('or go to the Customizer','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_1',
        array(
            'label' => __( 'Subtitle for the first slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );           
    //Image 2
    $wp_customize->add_setting( 'accordion_slider_image_2', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Sydney_Accordion_Control(
            $wp_customize,
            'accordion_slider_image_2',
            array(
                'label'         => esc_html__( 'Second slide', 'sydney' ),
                'section'       => 'sydney_slider',
                'until'         => 'slider_subtitle_2',
            )
        )
    );    
    $wp_customize->add_setting(
        'slider_image_2',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            //'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_2',
            array(
               'label'          => __( 'Upload your second image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_2',
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_2',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_title_2',
        array(
            'label' => __( 'Title for the second slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_2',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_2',
        array(
            'label' => __( 'Subtitle for the second slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );    
    //Image 3
    $wp_customize->add_setting( 'accordion_slider_image_3', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Sydney_Accordion_Control(
            $wp_customize,
            'accordion_slider_image_3',
            array(
                'label'         => esc_html__( 'Third slide', 'sydney' ),
                'section'       => 'sydney_slider',
                'until'         => 'slider_subtitle_3',
            )
        )
    );  
    $wp_customize->add_setting(
        'slider_image_3',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_3',
            array(
               'label'          => __( 'Upload your third image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_3',
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_3',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_title_3',
        array(
            'label' => __( 'Title for the third slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_3',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_3',
        array(
            'label' => __( 'Subtitle for the third slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );            
    //Image 4
    $wp_customize->add_setting( 'accordion_slider_image_4', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Sydney_Accordion_Control(
            $wp_customize,
            'accordion_slider_image_4',
            array(
                'label'         => esc_html__( 'Fourth slide', 'sydney' ),
                'section'       => 'sydney_slider',
                'until'         => 'slider_subtitle_4',
            )
        )
    ); 
    $wp_customize->add_setting(
        'slider_image_4',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_4',
            array(
               'label'          => __( 'Upload your fourth image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_4',
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_4',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_title_4',
        array(
            'label' => __( 'Title for the fourth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_4',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_4',
        array(
            'label' => __( 'Subtitle for the fourth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );    
    //Image 5
    $wp_customize->add_setting( 'accordion_slider_image_5', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Sydney_Accordion_Control(
            $wp_customize,
            'accordion_slider_image_5',
            array(
                'label'         => esc_html__( 'Fifth slide', 'sydney' ),
                'section'       => 'sydney_slider',
                'until'         => 'slider_subtitle_5',
            )
        )
    );   
    $wp_customize->add_setting(
        'slider_image_5',
        array(
            'default-image'     => '',
            'sanitize_callback'  => 'esc_url_raw',
             'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_5',
            array(
               'label'          => __( 'Upload your fifth image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_5',
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_5',
        array(
            'default'           => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_title_5',
        array(
            'label' => __( 'Title for the fifth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_5',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_5',
        array(
            'label' => __( 'Subtitle for the fifth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );
    //Header button
    $wp_customize->add_setting( 'hero_slider_divider_1',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'hero_slider_divider_1',
            array(
                'section' 		=> 'sydney_slider',
            )
        )
    );	

    $wp_customize->add_setting( 'accordion_hero_slider_button', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Sydney_Accordion_Control(
            $wp_customize,
            'accordion_hero_slider_button',
            array(
                'label'         => esc_html__( 'Slider button', 'sydney' ),
                'section'       => 'sydney_slider',
                'until'         => 'slider_button_text',
            )
        )
    );	    
    $wp_customize->add_setting(
        'slider_button_url',
        array(
            'default' => '#primary',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'                        
        )
    );
    $wp_customize->add_control(
        'slider_button_url',
        array(
            'label' => __( 'URL for your call to action button', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );
    $wp_customize->add_setting(
        'slider_button_text',
        array(
            'default' => __('Click to begin','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_button_text',
        array(
            'label' => __( 'Text for your call to action button', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting( 'hero_slider_divider_2',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'hero_slider_divider_2',
            array(
                'section' 		=> 'sydney_slider',
            )
        )
    );
	
	/**
	 * Slider settings
	 */
    $wp_customize->add_setting( 'accordion_hero_slider_settings', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Sydney_Accordion_Control(
            $wp_customize,
            'accordion_hero_slider_settings',
            array(
                'label'         => esc_html__( 'Slider settings', 'sydney' ),
                'section'       => 'sydney_slider',
                'until'         => 'mobile_slider',
            )
        )
    );

    //Speed
    $wp_customize->add_setting(
        'slider_speed',
        array(
            'default' => __('4000','sydney'),
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'slider_speed',
        array(
            'label' => __( 'Slider speed', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'number',
            'description'   => __('Slider speed in miliseconds. Use 0 to disable [default: 4000]', 'sydney'),       
        )
    );      

    $wp_customize->add_setting(
        'textslider_slide',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Sydney_Toggle_Control(
            $wp_customize,
            'textslider_slide',
            array(
                'label'         => esc_html__( 'Prevent the text from changing?', 'sydney' ),
                'description'   => esc_html__( 'Use this if you want to show the same text on all slides.', 'sydney' ),
                'section'       => 'sydney_slider',
            )
        )
    );
    	
	//Mobile slider
	$wp_customize->add_setting(
		'mobile_slider',
		array(
			'default'           => 'responsive',
			'sanitize_callback' => 'sydney_sanitize_mslider',
		)
	);
	$wp_customize->add_control(
		'mobile_slider',
		array(
			'type'        => 'radio',
			'label'       => esc_html__( 'Mobile behavior for the slider images', 'sydney' ),
			'section'     => 'sydney_slider',
			'choices' => array(
				'fullscreen'    => __('Full screen', 'sydney'),
				'responsive'    => __('Responsive', 'sydney'),
			),
		)
	);

    $wp_customize->add_setting( 'hero_slider_divider_3',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'hero_slider_divider_3',
            array(
                'section' 		=> 'sydney_slider',
            )
        )
    );	

    $wp_customize->add_setting( 'hero_slider_activate_link',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'hero_slider_activate_link',
            array(
                'description' 	=> '<a href="javascript:wp.customize.section( \'sydney_header_type\' ).focus();">' . esc_html__( 'Click here to select where you want to display the slider', 'sydney' ) . '</a>',
                'section' 		=> 'sydney_slider',
            )
        )
    );	