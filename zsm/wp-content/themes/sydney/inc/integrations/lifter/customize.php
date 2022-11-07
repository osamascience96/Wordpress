<?php
/**
 * Lifter Customizer options
 *
 * @package Sydney
 */


 $wp_customize->add_panel( 'sydney_lifterlms', array(
        'priority'       => 29,
        'theme_supports' => '',
        'title'          => esc_html__( 'LifterLMS', 'sydney' ),
    ) );

	$wp_customize->add_section(
        'sydney_lifterlms_general',
        array(
            'title'         => esc_html__( 'General', 'sydney'),
            'priority'      => 10,
            'panel'         => 'sydney_lifterlms', 
        )
	);
	
	//Courses loop
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'lgc', array(
        	'label' => esc_html__( 'Courses archives', 'sydney'),
        	'section' => 'sydney_lifterlms_general',
        	'settings' => 'sydney_options[info]',
        ) )
    ); 	
    $wp_customize->add_setting(
        'sydney_lifter_course_cols',
        array(
            'default' => 3,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'sydney_lifter_course_cols',
        array(
            'label'         => esc_html__( 'Course catalog columns', 'sydney' ),
            'section'       => 'sydney_lifterlms_general',
            'type'          => 'number',
            'input_attrs' => array(
                'min'   => 2,
                'max'   => 4,
                'step'  => 1,
            ),            
        )
	);

    $wp_customize->add_setting(
        'sydney_lifter_course_loop_sidebar',
        array(
            'default'           => 'no-sidebar',
            'sanitize_callback' => 'sydney_sanitize_selects',
        )
    );
    $wp_customize->add_control(
        'sydney_lifter_course_loop_sidebar',
        array(
            'type'        => 'select',
            'label'       => esc_html__( 'Sidebar layout', 'sydney'),
            'section'     => 'sydney_lifterlms_general',
            'choices' => array(
                'no-sidebar'    => esc_html__( 'No sidebar', 'sydney' ),
                'sidebar-left'  => esc_html__( 'Sidebar left', 'sydney' ),
                'sidebar-right' => esc_html__( 'Sidebar right', 'sydney' ),
            ),
        )
    );	
	
	//Memberships
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'lgm', array(
        	'label' => esc_html__( 'Membership archives', 'sydney'),
        	'section' => 'sydney_lifterlms_general',
        	'settings' => 'sydney_options[info]',
        ) )
    ); 		
    $wp_customize->add_setting(
        'sydney_lifter_membership_cols',
        array(
            'default' => 3,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'sydney_lifter_membership_cols',
        array(
            'label'         => esc_html__( 'Memberships columns', 'sydney' ),
            'section'       => 'sydney_lifterlms_general',
            'type'          => 'number',
            'input_attrs' => array(
                'min'   => 2,
                'max'   => 4,
                'step'  => 1,
            ),            
        )
	);	
	
    $wp_customize->add_setting(
        'sydney_lifter_membership_loop_sidebar',
        array(
            'default'           => 'no-sidebar',
            'sanitize_callback' => 'sydney_sanitize_selects',
        )
    );
    $wp_customize->add_control(
        'sydney_lifter_membership_loop_sidebar',
        array(
            'type'        => 'select',
            'label'       => esc_html__( 'Sidebar layout', 'sydney'),
            'section'     => 'sydney_lifterlms_general',
            'choices' => array(
                'no-sidebar'    => esc_html__( 'No sidebar', 'sydney' ),
                'sidebar-left'  => esc_html__( 'Sidebar left', 'sydney' ),
                'sidebar-right' => esc_html__( 'Sidebar right', 'sydney' ),
            ),
        )
	);		
	//Styling
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'lgs', array(
        	'label' => esc_html__( 'Styling', 'sydney'),
        	'section' => 'sydney_lifterlms_general',
        	'settings' => 'sydney_options[info]',
        ) )
	); 	

    $wp_customize->add_setting(
        'sydney_lifter_loop_title_color',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sydney_lifter_loop_title_color',
            array(
                'label'         => esc_html__( 'Archives titles color', 'sydney' ),
                'section'       => 'sydney_lifterlms_general',
                'settings'      => 'sydney_lifter_loop_title_color',
            )
        )
	);	
	
    $wp_customize->add_setting(
        'sydney_lifter_loop_title_color_hover',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sydney_lifter_loop_title_color_hover',
            array(
                'label'         => esc_html__( 'Archives titles color (hover)', 'sydney' ),
                'section'       => 'sydney_lifterlms_general',
                'settings'      => 'sydney_lifter_loop_title_color_hover',
            )
        )
	);		
	
    $wp_customize->add_setting(
        'sydney_lifter_loop_meta_color',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sydney_lifter_loop_meta_color',
            array(
                'label'         => esc_html__( 'Archives entry meta', 'sydney' ),
                'section'       => 'sydney_lifterlms_general',
                'settings'      => 'sydney_lifter_loop_meta_color',
            )
        )
	);		
	
    $wp_customize->add_setting(
        'sydney_lifter_loop_title_size',
        array(
            'sanitize_callback' => 'absint',
            'default'         	=> 25
        )       
    );
    $wp_customize->add_control( 'sydney_lifter_loop_title_size', array(
        'type'        => 'number',
        'section'     => 'sydney_lifterlms_general',
		'label'       => esc_html__( 'Archives titles font size', 'sydney' ),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 40,
            'step'  => 1,
        ),
    ) ); 	

/**
 * Single course
 */
$wp_customize->add_section(
    'sydney_lifterlms_course',
    array(
        'title'         => esc_html__( 'Single course', 'sydney'),
        'priority'      => 10,
        'panel'         => 'sydney_lifterlms', 
    )
);

$wp_customize->add_setting(
    'sydney_lifter_course_title_color',
    array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'sydney_lifter_course_title_color',
        array(
            'label'         => esc_html__( 'Course title', 'sydney' ),
            'section'       => 'sydney_lifterlms_course',
            'settings'      => 'sydney_lifter_course_title_color',
        )
    )
);	

$wp_customize->add_setting(
    'sydney_lifter_course_title_size',
    array(
        'sanitize_callback' => 'absint',
        'default'         	=> 36
    )       
);
$wp_customize->add_control( 'sydney_lifter_course_title_size', array(
    'type'        => 'number',
    'section'     => 'sydney_lifterlms_course',
    'label'       => esc_html__( 'Course title font size', 'sydney' ),
    'input_attrs' => array(
        'min'   => 10,
        'max'   => 50,
        'step'  => 1,
    ),
) ); 

$wp_customize->add_setting(
    'sydney_lifter_course_accent_color',
    array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'sydney_lifter_course_accent_color',
        array(
            'label'         => esc_html__( 'Course accent color', 'sydney' ),
            'section'       => 'sydney_lifterlms_course',
            'settings'      => 'sydney_lifter_course_accent_color',
        )
    )
);

$wp_customize->add_section(
    'sydney_lifterlms_lesson',
    array(
        'title'         => esc_html__( 'Single lesson', 'sydney'),
        'priority'      => 10,
        'panel'         => 'sydney_lifterlms', 
    )
);

$wp_customize->add_setting(
    'sydney_lifter_lesson_title_color',
    array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'sydney_lifter_lesson_title_color',
        array(
            'label'         => esc_html__( 'Lesson title', 'sydney' ),
            'section'       => 'sydney_lifterlms_lesson',
            'settings'      => 'sydney_lifter_lesson_title_color',
        )
    )
);	

$wp_customize->add_setting(
    'sydney_lifter_lesson_title_size',
    array(
        'sanitize_callback' => 'absint',
        'default'         	=> 36
    )       
);
$wp_customize->add_control( 'sydney_lifter_lesson_title_size', array(
    'type'        => 'number',
    'section'     => 'sydney_lifterlms_lesson',
    'label'       => esc_html__( 'Lesson title font size', 'sydney' ),
    'input_attrs' => array(
        'min'   => 10,
        'max'   => 50,
        'step'  => 1,
    ),
) ); 