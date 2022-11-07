<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function sydney_toolbox_portfolio_options( $wp_customize ) {

    $wp_customize->add_section(
        'sydney_toolbox_portfolio',
        array(
            'title'         => esc_html__('Portfolio', 'sydney' ),
            'priority'      => 40,
        )
    );

	if ( class_exists( 'Sydney_Toggle_Control' ) ) {


		$wp_customize->add_setting( 'sydney_ele_project_cpt_info',
			array(
				'default' 			=> '',
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'sydney_ele_project_cpt_info',
				array(
					'description'   => '<span style="display:block;margin-top:15px">This enables the Portfolio custom post type. This is useful in conjuction with our <strong>aThemes: Portfolio widget</strong> for Elementor.</span><span style="display:block;margin-top:15px;"><strong>Need help or more info?</strong> <a target="_blank" href="https://docs.athemes.com/article/419-portfolio-system-overview">Read our portfolio article.</a></span>',
					'section' 		=> 'sydney_toolbox_portfolio',
				)
			)
		);

		$wp_customize->add_setting( 'sydney_ele_projects_divider1',
			array(
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'sydney_ele_projects_divider1',
				array(
					'section' 		=> 'sydney_toolbox_portfolio',
				)
			)
		);			

		$wp_customize->add_setting(
			'sydney_toolbox_enable_portfolio',
			array(
				'default'           => 0,
				'sanitize_callback' => 'sydney_toolbox_sanitize_checkbox',
				'type'              => 'option',
			)
		);
		$wp_customize->add_control(
			new Sydney_Toggle_Control(
				$wp_customize,
				'sydney_toolbox_enable_portfolio',
				array(
					'label'         => esc_html__( 'Enable portfolio', 'sydney' ),
					'section'       => 'sydney_toolbox_portfolio',
				)
			)
		);	

		$wp_customize->add_setting( 'sydney_ele_projects_divider2',
			array(
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'sydney_ele_projects_divider2',
				array(
					'section' 		=> 'sydney_toolbox_portfolio',
				)
			)
		);		

		$wp_customize->add_setting(
			'sydney_ele_projects_rewrite_slug',
			array(
				'default' 			=> 'portfolio',
				'sanitize_callback' => 'sydney_sanitize_text',
				'type'              => 'option',
			)
		);
		$wp_customize->add_control(
			'sydney_ele_projects_rewrite_slug',
			array(
				'label'     => esc_html__( 'Portfolio base slug', 'sydney' ),
				'section'   => 'sydney_toolbox_portfolio',
				'type'      => 'text',
			)
		);

		$wp_customize->add_setting(
			'sydney_ele_project_cats_rewrite_slug',
			array(
				'default' 			=> 'portfolio-cat',
				'sanitize_callback' => 'sydney_sanitize_text',
				'type'              => 'option',
			)
		);
		$wp_customize->add_control(
			'sydney_ele_project_cats_rewrite_slug',
			array(
				'label'     => esc_html__( 'Portfolio categories base slug', 'sydney' ),
				'section'   => 'sydney_toolbox_portfolio',
				'type'      => 'text',
			)
		);		

		$wp_customize->add_setting( 'sydney_ele_project_rewrite_info',
			array(
				'default' 			=> '',
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'sydney_ele_project_rewrite_info',
				array(
					'description' 	=> __( '<strong>Please note:</strong> if you change the slugs, you need to go in your admin area to <strong>Settings > Permalinks</strong> and click on <strong>Save Changes</strong> in order to flush your permalinks.', 'sydney' ),
					'section' 		=> 'sydney_toolbox_portfolio',
				)
			)
		);

	}
}
add_action( 'customize_register', 'sydney_toolbox_portfolio_options', 99 );

function sydney_toolbox_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}