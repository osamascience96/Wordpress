<?php
/**
 * Footer Customizer options
 *
 * @package Sydney
 */

/**
 * New controls need to also be specified in the tabs controls
 */
$wp_customize->selective_refresh->add_partial( 'footer_credits', array(
	'selector'          	=> '.sydney-credits',
	'render_callback'   	=> 'sydney_footer_credits',
	'container_inclusive' 	=> false,
) ); 

$wp_customize->selective_refresh->add_partial( 'social_profiles_footer', array(
	'selector'          	=> '.site-info .social-profile',
	'render_callback'   	=> function() { sydney_social_profile( 'social_profiles_footer' ); },
	'container_inclusive' 	=> false,
) );  

/**
 * Footer
 */
$wp_customize->add_panel(
	'sydney_panel_footer',
	array(
		'title'         => esc_html__( 'Footer', 'sydney'),
		'priority'      => 31,
	)
);

/**
 * Footer widgets
 */
$wp_customize->add_section(
	'sydney_section_footer_widgets',
	array(
		'title'      => esc_html__( 'Footer widgets', 'sydney'),
		'panel'      => 'sydney_panel_footer',
	)
);

$wp_customize->add_setting(
	'sydney_footer_widgets_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
	new Sydney_Tab_Control (
		$wp_customize,
		'sydney_footer_widgets_tabs',
		array(
			'label' 				=> '',
			'section'       		=> 'sydney_section_footer_widgets',
			'controls_general'		=> json_encode( array( '#customize-control-sydney_upsell_footer_widgets','#customize-control-footer_widgets_visibility', '#customize-control-footer_widgets_alignment', '#customize-control-footer_widget_sections', '#customize-control-footer_widget_areas', '#customize-control-footer_container', '#customize-control-footer_divider_1', '#customize-control-footer_divider_2') ),
			'controls_design'		=> json_encode( array( '#customize-control-footer_widgets_links_hover_color', '#customize-control-footer_widgets_links_color', '#customize-control-footer_widgets_color', '#customize-control-footer_widgets_headings_color', '#customize-control-footer_widgets_title_color', '#customize-control-footer_widgets_title_size', '#customize-control-footer_divider_5', '#customize-control-footer_widgets_divider_width', '#customize-control-footer_widgets_divider_color', '#customize-control-footer_widgets_divider_size', '#customize-control-footer_divider_3', '#customize-control-footer_divider_4', '#customize-control-footer_widgets_divider', '#customize-control-footer_widgets_column_spacing', '#customize-control-footer_widgets_background', '#customize-control-footer_widgets_padding' ) ),
		)
	)
);

//Layout
$wp_customize->add_setting(
	'footer_widget_areas',
	array(
		'default'           => '3',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'footer_widget_areas',
		array(
			'label'    => esc_html__( 'Footer widgets layout', 'sydney' ),
			'section'  => 'sydney_section_footer_widgets',
			'cols' 		=> 3,
			'choices'  => array(
				'disabled' => array(
					'label' => esc_html__( 'Disabled', 'sydney' ),
					'url'   => '%s/images/customizer/disabled.svg'
				),				
				'1' => array(
					'label' => esc_html__( '1 column', 'sydney' ),
					'url'   => '%s/images/customizer/fl1.svg'
				),
				'2' => array(
					'label' => esc_html__( '2 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl2.svg'
				),		
				'col2-bigleft' => array(
					'label' => esc_html__( '2 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl3.svg'
				),				
				'col2-bigright' => array(
					'label' => esc_html__( '2 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl4.svg'
				),
				'3' => array(
					'label' => esc_html__( '3 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl5.svg'
				),	
				'col3-bigleft' => array(
					'label' => esc_html__( '3 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl6.svg'
				),
				'col3-bigright' => array(
					'label' => esc_html__( '3 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl7.svg'
				),	
				'4' => array(
					'label' => esc_html__( '4 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl8.svg'
				),	
				'col4-bigleft' => array(
					'label' => esc_html__( '4 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl9.svg'
				),
				'col4-bigright' => array(
					'label' => esc_html__( '4 columns', 'sydney' ),
					'url'   => '%s/images/customizer/fl10.svg'
				),
			)
		)
	)
); 

$wp_customize->add_setting( 'footer_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_1',
		array(
			'section' 		=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting( 'footer_container',
	array(
		'default' 			=> 'container',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'footer_container',
	array(
		'label' 		=> esc_html__( 'Container type', 'sydney' ),
		'section' => 'sydney_section_footer_widgets',
		'choices' => array(
			'container' 		=> esc_html__( 'Contained', 'sydney' ),
			'container-fluid' 	=> esc_html__( 'Full-width', 'sydney' ),
		)
	)
) );

$wp_customize->add_setting( 'footer_widgets_alignment',
	array(
		'default' 			=> 'top',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'footer_widgets_alignment',
	array(
		'label' 		=> esc_html__( 'Vertical alignment', 'sydney' ),
		'section' => 'sydney_section_footer_widgets',
		'choices' => array(
			'top' 		=> esc_html__( 'Top', 'sydney' ),
			'middle' 	=> esc_html__( 'Middle', 'sydney' ),
			'bottom' 	=> esc_html__( 'Bottom', 'sydney' ),
		)
	)
) );

$wp_customize->add_setting( 'footer_widgets_visibility', array(
	'sanitize_callback' => 'sydney_sanitize_select',
	'default' 			=> 'all',
) );

$wp_customize->add_control( 'footer_widgets_visibility', array(
	'type' 		=> 'select',
	'section' 	=> 'sydney_section_footer_widgets',
	'label' 	=> esc_html__( 'Visibility', 'sydney' ),
	'choices' => array(
		'all' 			=> esc_html__( 'Show on all devices', 'sydney' ),
		'desktop-only' 	=> esc_html__( 'Desktop only', 'sydney' ),
		'mobile-only' 	=> esc_html__( 'Mobile/tablet only', 'sydney' ),
	),
) );

$wp_customize->add_setting( 'footer_divider_2',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_2',
		array(
			'section' 		=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting( 'footer_widget_sections',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'footer_widget_sections',
		array(
			'description' 	=> '<span class="customize-control-title" style="font-style: normal;">' . esc_html__( 'Footer widget areas', 'sydney' ) . '</span><a class="footer-widget-area-link footer-widget-area-link-1" href="javascript:wp.customize.section( \'sidebar-widgets-footer-1\' ).focus();">' . esc_html__( 'Widget area 1', 'sydney' ) . '<span class="dashicons dashicons-arrow-right-alt2"></span></a><a class="footer-widget-area-link footer-widget-area-link-2" href="javascript:wp.customize.section( \'sidebar-widgets-footer-2\' ).focus();">' . esc_html__( 'Widget area 2', 'sydney' ) . '<span class="dashicons dashicons-arrow-right-alt2"></span></a><a class="footer-widget-area-link footer-widget-area-link-3" href="javascript:wp.customize.section( \'sidebar-widgets-footer-3\' ).focus();">' . esc_html__( 'Widget area 3', 'sydney' ) . '<span class="dashicons dashicons-arrow-right-alt2"></span></a><a class="footer-widget-area-link footer-widget-area-link-4" href="javascript:wp.customize.section( \'sidebar-widgets-footer-4\' ).focus();">' . esc_html__( 'Widget area 4', 'sydney' ) . '<span class="dashicons dashicons-arrow-right-alt2"></span></a>',
			'section' 		=> 'sydney_section_footer_widgets',
		)
	)
);

//Styling
$wp_customize->add_setting(
	'footer_widgets_background',
	array(
		'default'           => '#252525',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_widgets_background',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_widgets_title_color',
		array(
			'label'         	=> esc_html__( 'Widget titles color (deprecated)', 'sydney' ),
			'section'       	=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_headings_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_widgets_headings_color',
		array(
			'label'         	=> esc_html__( 'Headings color', 'sydney' ),
			'section'       	=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_color',
	array(
		'default'           => '#666666',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_widgets_color',
		array(
			'label'         	=> esc_html__( 'Widget text color', 'sydney' ),
			'section'       	=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_links_color',
	array(
		'default'           => '#666666',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_widgets_links_color',
		array(
			'label'         	=> esc_html__( 'Links color', 'sydney' ),
			'section'       	=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_links_hover_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_widgets_links_hover_color',
		array(
			'label'         	=> esc_html__( 'Links color (hover)', 'sydney' ),
			'section'       	=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting( 'footer_divider_3',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_3',
		array(
			'section' 		=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_divider',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'footer_widgets_divider',
		array(
			'label'         	=> esc_html__( 'Enable top divider', 'sydney' ),
			'section'       	=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting( 'footer_widgets_divider_size', array(
	'sanitize_callback' => 'absint',
	'default' 			=> 1,
	'transport'			=> 'postMessage'
) );

$wp_customize->add_control( 'footer_widgets_divider_size', array(
	'type' 				=> 'number',
	'section' 			=> 'sydney_section_footer_widgets',
	'label' 			=> esc_html__( 'Divider size', 'sydney' ),
	'active_callback' 	=> 'sydney_callback_footer_widgets_divider'
) );

$wp_customize->add_setting(
	'footer_widgets_divider_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_widgets_divider_color',
		array(
			'label'         	=> esc_html__( 'Divider color', 'sydney' ),
			'section'       	=> 'sydney_section_footer_widgets',
			'active_callback' 	=> 'sydney_callback_footer_widgets_divider'
		)
	)
);

$wp_customize->add_setting( 'footer_widgets_divider_width',
	array(
		'default' 			=> 'contained',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'footer_widgets_divider_width',
	array(
		'label' 	=> esc_html__( 'Divider width', 'sydney' ),
		'section' 	=> 'sydney_section_footer_widgets',
		'choices' 	=> array(
			'contained' 	=> esc_html__( 'Contained', 'sydney' ),
			'fullwidth' 	=> esc_html__( 'Full-width', 'sydney' ),
		),
		'active_callback' 	=> 'sydney_callback_footer_widgets_divider'
	)
) );

$wp_customize->add_setting( 'footer_divider_4',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_4',
		array(
			'section' 		=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting( 'footer_widgets_padding_desktop', array(
	'default'   		=> 95,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'footer_widgets_padding_tablet', array(
	'default'   		=> 60,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'footer_widgets_padding_mobile', array(
	'default'   		=> 60,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			


$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'footer_widgets_padding',
	array(
		'label' 		=> esc_html__( 'Vertical section padding', 'sydney' ),
		'section' 		=> 'sydney_section_footer_widgets',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'footer_widgets_padding_desktop',
			'size_tablet' 		=> 'footer_widgets_padding_tablet',
			'size_mobile' 		=> 'footer_widgets_padding_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 200
		)		
	)
) );

$wp_customize->add_setting( 'footer_widgets_column_spacing_desktop', array(
	'default'   		=> 30,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'footer_widgets_column_spacing',
	array(
		'label' 		=> esc_html__( 'Column spacing', 'sydney' ),
		'section' 		=> 'sydney_section_footer_widgets',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'footer_widgets_column_spacing_desktop',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		)
	)
) );

$wp_customize->add_setting( 'footer_divider_5',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_5',
		array(
			'section' 		=> 'sydney_section_footer_widgets',
		)
	)
);

$wp_customize->add_setting( 'footer_widgets_title_size_desktop', array(
	'default'   		=> 22,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'footer_widgets_title_size_tablet', array(
	'default'   		=> 22,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'footer_widgets_title_size_mobile', array(
	'default'   		=> 22,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			


$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'footer_widgets_title_size',
	array(
		'label' 		=> esc_html__( 'Widget titles size', 'sydney' ),
		'section' 		=> 'sydney_section_footer_widgets',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'footer_widgets_title_size_desktop',
			'size_tablet' 		=> 'footer_widgets_title_size_tablet',
			'size_mobile' 		=> 'footer_widgets_title_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		)		
	)
) );


/**
 * Footer credits
 */
$wp_customize->add_section(
	'sydney_section_footer_credits',
	array(
		'title'      => esc_html__( 'Copyright area', 'sydney'),
		'panel'      => 'sydney_panel_footer',
	)
);
$wp_customize->add_setting(
	'sydney_footer_credits_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
	new Sydney_Tab_Control (
		$wp_customize,
		'sydney_footer_credits_tabs',
		array(
			'label' 				=> '',
			'section'       		=> 'sydney_section_footer_credits',
			'controls_general'		=> json_encode( array( '#customize-control-sydney_upsell_footer_credits','#customize-control-footer_divider_9', '#customize-control-footer_divider_8', '#customize-control-footer_credits_container', '#customize-control-footer_credits', '#customize-control-social_profiles_footer') ),
			'controls_design'		=> json_encode( array( '#customize-control-footer_credits_divider', '#customize-control-footer_credits_divider_size', '#customize-control-footer_credits_divider_color', '#customize-control-footer_credits_divider_width', '#customize-control-footer_divider_7', '#customize-control-footer_divider_6', '#customize-control-footer_credits_padding_bottom', '#customize-control-footer_credits_padding', '#customize-control-footer_color', '#customize-control-footer_background' ) ),
		)
	)
);

$wp_customize->add_setting( 'footer_credits_container',
	array(
		'default' 			=> 'container',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'footer_credits_container',
	array(
		'label' 		=> esc_html__( 'Container type', 'sydney' ),
		'section' => 'sydney_section_footer_credits',
		'choices' => array(
			'container' 		=> esc_html__( 'Contained', 'sydney' ),
			'container-fluid' 	=> esc_html__( 'Full-width', 'sydney' ),
		)
	)
) );

$wp_customize->add_setting( 'footer_divider_8',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_8',
		array(
			'section' 		=> 'sydney_section_footer_credits',
		)
	)
);

$wp_customize->add_setting(
	'footer_credits',
	array(
		'sanitize_callback' => 'sydney_sanitize_text',
		'default'           => sprintf( esc_html__( '%1$1s. Proudly powered by %2$2s', 'sydney' ), '{copyright} {year} {site_title}', '{theme_author}' ),// phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
		'transport'			=> 'postMessage'
	)       
);
$wp_customize->add_control( 'footer_credits', array(
	'label'       => esc_html__( 'Footer credits', 'sydney' ),
	'description' => esc_html__( 'You can use the following tags: {copyright}, {year}, {site_title}, {theme_author}', 'sydney' ),
	'type'        => 'textarea',
	'section'     => 'sydney_section_footer_credits',
) );

$wp_customize->add_setting( 'footer_divider_9',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_9',
		array(
			'section' 		=> 'sydney_section_footer_credits',
		)
	)
);

$wp_customize->add_setting( 'social_profiles_footer',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'sydney_sanitize_urls',
		'transport'			=> 'postMessage'
	)
);
$wp_customize->add_control( new Sydney_Repeater_Control( $wp_customize, 'social_profiles_footer',
	array(
		'label' 		=> esc_html__( 'Social profile', 'sydney' ),
		'section' 		=> 'sydney_section_footer_credits',
		'button_labels' => array(
			'add' => esc_html__( 'Add new', 'sydney' ),
		),
	)
) );

//Styling
$wp_customize->add_setting(
	'footer_background',
	array(
		'default'           => '#1c1c1c',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_background',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'sydney_section_footer_credits',
		)
	)
);

$wp_customize->add_setting(
	'footer_color',
	array(
		'default'           => '#666666',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_color',
		array(
			'label'         	=> esc_html__( 'Text color', 'sydney' ),
			'section'       	=> 'sydney_section_footer_credits',
		)
	)
);

$wp_customize->add_setting( 'footer_divider_6',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_6',
		array(
			'section' 		=> 'sydney_section_footer_credits',
		)
	)
);

$wp_customize->add_setting(
	'footer_credits_divider',
	array(
		'default'           => 0,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'footer_credits_divider',
		array(
			'label'         	=> esc_html__( 'Enable top divider', 'sydney' ),
			'section'       	=> 'sydney_section_footer_credits',
		)
	)
);

$wp_customize->add_setting( 'footer_credits_divider_size', array(
	'sanitize_callback' => 'absint',
	'default' 			=> 0,
	'transport' 		=> 'postMessage'
) );

$wp_customize->add_control( 'footer_credits_divider_size', array(
	'type' 				=> 'number',
	'section' 			=> 'sydney_section_footer_credits',
	'label' 			=> esc_html__( 'Divider size', 'sydney' ),
	'active_callback' 	=> 'sydney_callback_footer_credits_divider'
) );

$wp_customize->add_setting(
	'footer_credits_divider_color',
	array(
		'default'           => 'rgba(33,33,33,0.1)',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'footer_credits_divider_color',
		array(
			'label'         	=> esc_html__( 'Divider color', 'sydney' ),
			'section'       	=> 'sydney_section_footer_credits',
			'active_callback' 	=> 'sydney_callback_footer_credits_divider'
		)
	)
);

$wp_customize->add_setting( 'footer_credits_divider_width',
	array(
		'default' 			=> 'contained',
		'sanitize_callback' => 'sydney_sanitize_text',
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'footer_credits_divider_width',
	array(
		'label' 	=> esc_html__( 'Divider width', 'sydney' ),
		'section' 	=> 'sydney_section_footer_credits',
		'choices' 	=> array(
			'contained' 	=> esc_html__( 'Contained', 'sydney' ),
			'fullwidth' 	=> esc_html__( 'Full-width', 'sydney' ),
		),
		'active_callback' 	=> 'sydney_callback_footer_credits_divider'
	)
) );

$wp_customize->add_setting( 'footer_divider_7',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'footer_divider_7',
		array(
			'section' 		=> 'sydney_section_footer_credits',
		)
	)
);

$wp_customize->add_setting( 'footer_credits_padding_desktop', array(
	'default'   		=> 20,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'footer_credits_padding',
	array(
		'label' 		=> esc_html__( 'Vertical Padding', 'sydney' ),
		'section' 		=> 'sydney_section_footer_credits',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'footer_credits_padding_desktop',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 200
		)		
	)
) );