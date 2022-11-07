<?php
/**
 * Learnpress Customizer options
 *
 * @package Sydney
 */


	$wp_customize->add_section(
        'sydney_learnpress',
        array(
            'title'         => esc_html__( 'Learnpress', 'sydney'),
            'priority'      => 21,
        )
	);

    $wp_customize->add_setting(
        'sydney_learnpress_course_loop_sidebar',
        array(
            'default'           => 'sidebar-right',
            'sanitize_callback' => 'sydney_sanitize_selects',
        )
    );
    $wp_customize->add_control(
        'sydney_learnpress_course_loop_sidebar',
        array(
            'type'        => 'select',
            'label'       => esc_html__( 'Sidebar layout (course archive)', 'sydney'),
            'section'     => 'sydney_learnpress',
            'choices' => array(
                'no-sidebar'    => esc_html__( 'No sidebar', 'sydney' ),
                'sidebar-left'  => esc_html__( 'Sidebar left', 'sydney' ),
                'sidebar-right' => esc_html__( 'Sidebar right', 'sydney' ),
            ),
        )
    );


    $wp_customize->add_setting(
        'sydney_learnpress_single_course_sidebar',
        array(
            'default'           => 'sidebar-right',
            'sanitize_callback' => 'sydney_sanitize_selects',
        )
    );
    $wp_customize->add_control(
        'sydney_learnpress_single_course_sidebar',
        array(
            'type'        => 'select',
            'label'       => esc_html__( 'Sidebar layout (single course)', 'sydney'),
            'section'     => 'sydney_learnpress',
            'choices' => array(
                'no-sidebar'    => esc_html__( 'No sidebar', 'sydney' ),
                'sidebar-left'  => esc_html__( 'Sidebar left', 'sydney' ),
                'sidebar-right' => esc_html__( 'Sidebar right', 'sydney' ),
            ),
        )
    );    