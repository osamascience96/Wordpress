<?php
/**
 * Learndash Customizer options
 *
 * @package Sydney
 */


    $wp_customize->add_panel( 'sydney_learndash', array(
        'priority'       => 29,
        'theme_supports' => '',
        'title'          => esc_html__( 'Learndash', 'sydney' ),
    ) );

	$wp_customize->add_section(
        'sydney_learndash_layout',
        array(
            'title'         => esc_html__( 'Layout', 'sydney'),
            'priority'      => 10,
            'panel'         => 'sydney_learndash', 
        )
    );
    

    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'learndashlayoutcourse', array(
        	'label' => esc_html__( 'Single courses', 'sydney'),
        	'section' => 'sydney_learndash_layout',
        	'settings' => 'sydney_options[info]',
        ) )
	); 	
	
    $wp_customize->add_setting(
        'sydney_lifter_single_course_sidebar',
        array(
            'default'           => 'sidebar-right',
            'sanitize_callback' => 'sydney_sanitize_selects',
        )
    );
    $wp_customize->add_control(
        'sydney_lifter_single_course_sidebar',
        array(
            'type'        => 'select',
            'label'       => esc_html__( 'Sidebar layout', 'sydney'),
            'section'     => 'sydney_learndash_layout',
            'choices' => array(
                'no-sidebar'    => esc_html__( 'No sidebar', 'sydney' ),
                'sidebar-left'  => esc_html__( 'Sidebar left', 'sydney' ),
                'sidebar-right' => esc_html__( 'Sidebar right', 'sydney' ),
            ),
        )
    );		
    
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'learndashlayoutqt', array(
        	'label' => esc_html__( 'Single lessons, topics, quizzes etc.', 'sydney'),
        	'section' => 'sydney_learndash_layout',
        	'settings' => 'sydney_options[info]',
        ) )
	); 	
	
    $wp_customize->add_setting(
        'sydney_lifter_single_lesson_sidebar',
        array(
            'default'           => 'sidebar-right',
            'sanitize_callback' => 'sydney_sanitize_selects',
        )
    );
    $wp_customize->add_control(
        'sydney_lifter_single_lesson_sidebar',
        array(
            'type'        => 'select',
            'label'       => esc_html__( 'Sidebar layout', 'sydney'),
            'section'     => 'sydney_learndash_layout',
            'choices' => array(
                'no-sidebar'    => esc_html__( 'No sidebar', 'sydney' ),
                'sidebar-left'  => esc_html__( 'Sidebar left', 'sydney' ),
                'sidebar-right' => esc_html__( 'Sidebar right', 'sydney' ),
            ),
        )
	);		    