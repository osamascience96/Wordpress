<?php
/**
 * Pro upsell options
 *
 * @package Sydney
 */

/**
 * Main Header
 */
$wp_customize->add_setting( 
    'sydney_upsell_main_header',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);

$wp_customize->add_control( 
    new Sydney_Upsell_Message( 
        $wp_customize, 
        'sydney_upsell_main_header',
        array(
            'section'     => 'sydney_section_main_header',
            'description' => __( 'More header options are available in Sydney Pro', 'sydney' ),
            'priority'    => 999
        )
    ) 
);

/**
 * Mobile Header
 */
$wp_customize->add_setting( 
    'sydney_upsell_mobile_header',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);

$wp_customize->add_control( 
    new Sydney_Upsell_Message( 
        $wp_customize, 
        'sydney_upsell_mobile_header',
        array(
            'section'     => 'sydney_section_mobile_header',
            'description' => __( 'More header options are available in Sydney Pro', 'sydney' ),
            'priority'    => 999
        )
    ) 
);

/**
 * Footer widgets
 */
$wp_customize->add_setting( 
    'sydney_upsell_footer_widgets',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);

$wp_customize->add_control( 
    new Sydney_Upsell_Message( 
        $wp_customize, 
        'sydney_upsell_footer_widgets',
        array(
            'section'     => 'sydney_section_footer_widgets',
            'description' => __( 'More footer options are available in Sydney Pro', 'sydney' ),
            'priority'    => 999
        )
    ) 
);

/**
 * Footer credits
 */
$wp_customize->add_setting( 
    'sydney_upsell_footer_credits',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);

$wp_customize->add_control( 
    new Sydney_Upsell_Message( 
        $wp_customize, 
        'sydney_upsell_footer_credits',
        array(
            'section'     => 'sydney_section_footer_credits',
            'description' => __( 'More footer options are available in Sydney Pro', 'sydney' ),
            'priority'    => 999
        )
    ) 
);

/**
 * Blog
 */
$wp_customize->add_setting( 
    'sydney_upsell_blog_archives',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);

$wp_customize->add_control( 
    new Sydney_Upsell_Message( 
        $wp_customize, 
        'sydney_upsell_blog_archives',
        array(
            'section'     => 'sydney_section_blog_archives',
            'description' => __( 'More blog options are available in Sydney Pro', 'sydney' ),
            'priority'    => 999
        )
    ) 
);

$wp_customize->add_setting( 
    'sydney_upsell_blog_singles',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);

$wp_customize->add_control( 
    new Sydney_Upsell_Message( 
        $wp_customize, 
        'sydney_upsell_blog_singles',
        array(
            'section'     => 'sydney_section_blog_singles',
            'description' => __( 'More blog options are available in Sydney Pro', 'sydney' ),
            'priority'    => 999
        )
    ) 
);

/**
 * Slider
 */
$wp_customize->add_setting( 
    'sydney_upsell_hero_slider',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);

$wp_customize->add_control( 
    new Sydney_Upsell_Message( 
        $wp_customize, 
        'sydney_upsell_hero_slider',
        array(
            'section'     => 'sydney_slider',
            'description' => __( 'More slider options are available in Sydney Pro', 'sydney' ),
            'priority'    => 999
        )
    ) 
);