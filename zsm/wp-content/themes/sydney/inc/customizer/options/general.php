<?php
/**
 * General Customizer options
 *
 * @package Sydney
 */

/**
 * General
 */
$wp_customize->add_panel(
	'sydney_panel_general',
	array(
		'title'         => esc_html__( 'General', 'sydney'),
		'priority'      => 0,
	)
);

/**
 * Layouts
 */
$wp_customize->add_section(
	'sydney_section_layouts',
	array(
		'title'         => esc_html__( 'Layouts', 'sydney'),
		'priority'      => 10,
		'panel'         => 'sydney_panel_general',
	)
);

//Container width
$wp_customize->add_setting(
	'container_width',
	array(
		'default'           => 1170,
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	'container_width',
	array(
		'label'         => esc_html__( 'Container width', 'sydney'),
		'section'       => 'sydney_section_layouts',
		'type'          => 'number',
		'priority'      => 10,
		'input_attrs'   => array(
			'min'   => 600,
			'max'   => 1920,
			'step'  => 5,
		),
	)
);

//Narrow container width
$wp_customize->add_setting(
	'narrow_container_width',
	array(
		'default'           => 860,
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	'narrow_container_width',
	array(
		'label'         => esc_html__( 'Narrow container width', 'sydney'),
		'section'       => 'sydney_section_layouts',
		'type'          => 'number',
		'priority'      => 10,
		'input_attrs'   => array(
			'min'   => 600,
			'max'   => 1920,
			'step'  => 5,
		),
	)
);

//Top padding
$wp_customize->add_setting(
	'wrapper_top_padding',
	array(
		'default' => 83,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'wrapper_top_padding',
	array(
		'label'         => __( 'Page wrapper - top padding', 'sydney' ),
		'section'       => 'sydney_section_layouts',
		'type'          => 'number',
		'description'   => __('Top padding for the page wrapper (the space between the header and the page title)', 'sydney'),       
		'priority'      => 10,
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 160,
			'step'  => 1,
		),            
	)
);
//Bottom padding
$wp_customize->add_setting(
	'wrapper_bottom_padding',
	array(
		'default' => 100,
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'wrapper_bottom_padding',
	array(
		'label'         => __( 'Page wrapper - bottom padding', 'sydney' ),
		'section'       => 'sydney_section_layouts',
		'type'          => 'number',
		'description'   => __('Bottom padding for the page wrapper (the space between the page content and the footer)', 'sydney'),       
		'priority'      => 10,
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 160,
			'step'  => 1,
		),            
	)
);

/**
 * Move existing sections into general panel
 */
$wp_customize->get_section( 'background_image' )->panel = 'sydney_panel_general';

//___General___//
$wp_customize->add_section(
	'sydney_general',
	array(
		'panel'			=> 'sydney_panel_general',
		'title'         => __('Misc', 'sydney'),
		'priority'      => 8,
	)
);

$wp_customize->add_setting(
	'sydney_enable_schema',
	array(
		'default'           => 0,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'sydney_enable_schema',
		array(
			'label'         	=> esc_html__( 'Enable Schema markup', 'sydney' ),
			'section'       	=> 'sydney_general',
		)
	)
);

$wp_customize->add_setting(
	'enable_preloader',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'enable_preloader',
		array(
			'label'         	=> esc_html__( 'Enable preloader', 'sydney' ),
			'section'       	=> 'sydney_general',
		)
	)
);

/**
 * Scroll to top
 */
$wp_customize->add_section(
	'sydney_section_scrolltotop',
	array(
		'title'      => esc_html__( 'Scroll to top', 'sydney'),
		'panel'      => 'sydney_panel_general',
	)
);

$wp_customize->add_setting(
	'sydney_scrolltop_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
	new Sydney_Tab_Control (
		$wp_customize,
		'sydney_scrolltop_tabs',
		array(
			'label' 				=> '',
			'section'       		=> 'sydney_section_scrolltotop',
			'controls_general'		=> json_encode( array( '#customize-control-scrolltop_text','#customize-control-enable_scrolltop','#customize-control-scrolltop_type','#customize-control-scrolltop_icon','#customize-control-scrolltop_radius','#customize-control-scrolltop_divider_1','#customize-control-scrolltop_position','#customize-control-scrolltop_side_offset','#customize-control-scrolltop_bottom_offset','#customize-control-scrolltop_divider_2','#customize-control-scrolltop_visibility',	) ),
			'controls_design'		=> json_encode( array( '#customize-control-scrolltop_color','#customize-control-scrolltop_bg_color','#customize-control-scrolltop_divider_3','#customize-control-scrolltop_color_hover','#customize-control-scrolltop_bg_color_hover','#customize-control-scrolltop_divider_4','#customize-control-scrolltop_icon_size','#customize-control-scrolltop_padding', ) ),
		)
	)
);

$wp_customize->add_setting(
	'enable_scrolltop',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'enable_scrolltop',
		array(
			'label'         	=> esc_html__( 'Enable scroll to top', 'sydney' ),
			'section'       	=> 'sydney_section_scrolltotop',
		)
	)
);

$wp_customize->add_setting( 'scrolltop_type',
	array(
		'default' 			=> 'icon',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'scrolltop_type',
	array(
		'label' 	=> esc_html__( 'Type', 'sydney' ),
		'section' 	=> 'sydney_section_scrolltotop',
		'choices' 	=> array(
			'icon' 		=> esc_html__( 'Icon', 'sydney' ),
			'text' 		=> esc_html__( 'Text + Icon', 'sydney' ),
		),
		'active_callback' => 'sydney_callback_scrolltop',
	)
) );

$wp_customize->add_setting(
	'scrolltop_text',
	array(
		'sanitize_callback' => 'sydney_sanitize_text',
		'default'           => esc_html__( 'Back to top', 'sydney' ),
	)       
);
$wp_customize->add_control( 'scrolltop_text', array(
	'label'       		=> esc_html__( 'Text', 'sydney' ),
	'type'        		=> 'text',
	'section'     		=> 'sydney_section_scrolltotop',
	'active_callback' 	=> 'sydney_callback_scrolltop_text'
) );

$wp_customize->add_setting(
	'scrolltop_icon',
	array(
		'default'           => 'icon2',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'scrolltop_icon',
		array(
			'label'    	=> esc_html__( 'Icon', 'sydney' ),
			'section'  	=> 'sydney_section_scrolltotop',
			'cols'		=> 4,
			'choices'  	=> array(			
				'icon1' 	=> array(
					'label' => esc_html__( 'Icon 1', 'sydney' ),
					'url'   => '%s/images/customizer/st1.svg'
				),
				'icon2' => array(
					'label' => esc_html__( 'Icon 2', 'sydney' ),
					'url'   => '%s/images/customizer/st2.svg'
				),		
				'icon3' => array(
					'label' => esc_html__( 'Icon 3', 'sydney' ),
					'url'   => '%s/images/customizer/st3.svg'
				),				
				'icon4' => array(
					'label' => esc_html__( 'Icon 4', 'sydney' ),
					'url'   => '%s/images/customizer/st4.svg'
				),
			),
			'active_callback' => 'sydney_callback_scrolltop',
		)
	)
); 

$wp_customize->add_setting( 'scrolltop_radius', array(
	'default'   		=> 2,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'scrolltop_radius',
	array(
		'label' 		=> esc_html__( 'Button radius', 'sydney' ),
		'section' 		=> 'sydney_section_scrolltotop',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'scrolltop_radius',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
		'active_callback' => 'sydney_callback_scrolltop',
	)
) );

$wp_customize->add_setting( 'scrolltop_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'scrolltop_divider_1',
		array(
			'section' 		=> 'sydney_section_scrolltotop',
			'active_callback' => 'sydney_callback_scrolltop',
		)
	)
);

$wp_customize->add_setting( 'scrolltop_position',
	array(
		'default' 			=> 'right',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'scrolltop_position',
	array(
		'label' 	=> esc_html__( 'Position', 'sydney' ),
		'section' 	=> 'sydney_section_scrolltotop',
		'choices' 	=> array(
			'left' 		=> esc_html__( 'Left', 'sydney' ),
			'right' 	=> esc_html__( 'Right', 'sydney' ),
		),
		'active_callback' => 'sydney_callback_scrolltop',
	)
) );

$wp_customize->add_setting( 'scrolltop_side_offset', array(
	'default'   		=> 20,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'scrolltop_side_offset',
	array(
		'label' 		=> esc_html__( 'Side offset', 'sydney' ),
		'section' 		=> 'sydney_section_scrolltotop',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'scrolltop_side_offset',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
		'active_callback' => 'sydney_callback_scrolltop',
	)
) );

$wp_customize->add_setting( 'scrolltop_bottom_offset', array(
	'default'   		=> 10,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'scrolltop_bottom_offset',
	array(
		'label' 		=> esc_html__( 'Bottom offset', 'sydney' ),
		'section' 		=> 'sydney_section_scrolltotop',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'scrolltop_bottom_offset',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
		'active_callback' => 'sydney_callback_scrolltop',
	)
) );

$wp_customize->add_setting( 'scrolltop_divider_2',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'scrolltop_divider_2',
		array(
			'section' 		=> 'sydney_section_scrolltotop',
			'active_callback' => 'sydney_callback_scrolltop',
		)
	)
);

$wp_customize->add_setting( 'scrolltop_visibility', array(
	'sanitize_callback' => 'sydney_sanitize_select',
	'default' 			=> 'all',
) );

$wp_customize->add_control( 'scrolltop_visibility', array(
	'type' 		=> 'select',
	'section' 	=> 'sydney_section_scrolltotop',
	'label' 	=> esc_html__( 'Visibility', 'sydney' ),
	'choices' => array(
		'all' 			=> esc_html__( 'Show on all devices', 'sydney' ),
		'desktop-only' 	=> esc_html__( 'Desktop only', 'sydney' ),
		'mobile-only' 	=> esc_html__( 'Mobile/tablet only', 'sydney' ),
	),
	'active_callback' => 'sydney_callback_scrolltop',
) );

/**
 * Style
 */
$wp_customize->add_setting(
	'scrolltop_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'scrolltop_color',
		array(
			'label'         	=> esc_html__( 'Icon color', 'sydney' ),
			'section'       	=> 'sydney_section_scrolltotop',
		)
	)
);

$wp_customize->add_setting(
	'scrolltop_bg_color',
	array(
		'default'           => '#d65050',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'scrolltop_bg_color',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'sydney_section_scrolltotop',
		)
	)
);

$wp_customize->add_setting( 'scrolltop_divider_3',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'scrolltop_divider_3',
		array(
			'section' 		=> 'sydney_section_scrolltotop',
		)
	)
);

$wp_customize->add_setting(
	'scrolltop_color_hover',
	array(
		'default'           => '#d65050',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'scrolltop_color_hover',
		array(
			'label'         	=> esc_html__( 'Icon hover color', 'sydney' ),
			'section'       	=> 'sydney_section_scrolltotop',
		)
	)
);

$wp_customize->add_setting(
	'scrolltop_bg_color_hover',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'scrolltop_bg_color_hover',
		array(
			'label'         	=> esc_html__( 'Background hover color', 'sydney' ),
			'section'       	=> 'sydney_section_scrolltotop',
		)
	)
);

$wp_customize->add_setting( 'scrolltop_divider_4',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'scrolltop_divider_4',
		array(
			'section' 		=> 'sydney_section_scrolltotop',
		)
	)
);

$wp_customize->add_setting( 'scrolltop_icon_size', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'scrolltop_icon_size',
	array(
		'label' 		=> esc_html__( 'Icon size', 'sydney' ),
		'section' 		=> 'sydney_section_scrolltotop',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'scrolltop_icon_size',
		),
		'input_attrs' => array (
			'min'	=> 10,
			'max'	=> 100
		),
	)
) );

$wp_customize->add_setting( 'scrolltop_padding', array(
	'default'   		=> 15,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'scrolltop_padding',
	array(
		'label' 		=> esc_html__( 'Padding', 'sydney' ),
		'section' 		=> 'sydney_section_scrolltotop',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'scrolltop_padding',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
	)
) );


/**
 * Buttons
 */
$wp_customize->add_section(
	'sydney_section_buttons',
	array(
		'title'      => esc_html__( 'Buttons', 'sydney'),
		'panel'      => 'sydney_panel_general',
	)
);

$wp_customize->add_setting( 'button_top_bottom_padding_desktop', array(
	'default'   		=> 12,
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'button_top_bottom_padding_tablet', array(
	'default'   		=> 12,
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'button_top_bottom_padding_mobile', array(
	'default'   		=> 12,
	'sanitize_callback' => 'absint',
) );			


$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'button_top_bottom_padding',
	array(
		'label' 		=> esc_html__( 'Top/Bottom padding', 'sydney' ),
		'section' 		=> 'sydney_section_buttons',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'button_top_bottom_padding_desktop',
			'size_tablet' 		=> 'button_top_bottom_padding_tablet',
			'size_mobile' 		=> 'button_top_bottom_padding_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 50
		)		
	)
) );

$wp_customize->add_setting( 'button_left_right_padding_desktop', array(
	'default'   		=> 35,
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'button_left_right_padding_tablet', array(
	'default'   		=> 35,
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'button_left_right_padding_mobile', array(
	'default'   		=> 35,
	'sanitize_callback' => 'absint',
) );			


$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'button_left_right_padding',
	array(
		'label' 		=> esc_html__( 'Left/Right padding', 'sydney' ),
		'section' 		=> 'sydney_section_buttons',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'button_left_right_padding_desktop',
			'size_tablet' 		=> 'button_left_right_padding_tablet',
			'size_mobile' 		=> 'button_left_right_padding_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 50
		)		
	)
) );


$wp_customize->add_setting( 'buttons_radius', array(
	'default'   		=> 3,
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'buttons_radius',
	array(
		'label' 		=> esc_html__( 'Button radius', 'sydney' ),
		'section' 		=> 'sydney_section_buttons',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'buttons_radius',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
	)
) );

$wp_customize->add_setting( 'buttons_divider_0',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'buttons_divider_0',
		array(
			'section' 		=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting( 'button_font_size_desktop', array(
	'default'   		=> 13,
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'button_font_size_tablet', array(
	'default'   		=> 13,
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'button_font_size_mobile', array(
	'default'   		=> 13,
	'sanitize_callback' => 'absint',
) );			


$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'button_font_size',
	array(
		'label' 		=> esc_html__( 'Font size', 'sydney' ),
		'section' 		=> 'sydney_section_buttons',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'button_font_size_desktop',
			'size_tablet' 		=> 'button_font_size_tablet',
			'size_mobile' 		=> 'button_font_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 50
		)		
	)
) );

$wp_customize->add_setting( 'button_text_transform',
	array(
		'default' 			=> 'uppercase',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'button_text_transform',
	array(
		'label'   => esc_html__( 'Text transform', 'sydney' ),
		'section' => 'sydney_section_buttons',
		'choices' => array(
			'none' 			=> '-',
			'capitalize' 	=> 'Aa',
			'lowercase' 	=> 'aa',
			'uppercase' 	=> 'AA',
		)
	)
) );

$wp_customize->add_setting( 'buttons_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'buttons_divider_1',
		array(
			'section' 		=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting( 'buttons_default_state_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'buttons_default_state_title',
		array(
			'label'			=> esc_html__( 'Default state', 'sydney' ),
			'section' 		=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting(
	'button_background_color',
	array(
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'button_background_color',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting(
	'button_color',
	array(
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'button_color',
		array(
			'label'         	=> esc_html__( 'Text Color', 'sydney' ),
			'section'       	=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting(
	'button_border_color',
	array(
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'button_border_color',
		array(
			'label'         	=> esc_html__( 'Border Color', 'sydney' ),
			'section'       	=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting( 'buttons_divider_2',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'buttons_divider_2',
		array(
			'section' 		=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting( 'buttons_hover_state_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'buttons_hover_state_title',
		array(
			'label'			=> esc_html__( 'Hover state', 'sydney' ),
			'section' 		=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting(
	'button_background_color_hover',
	array(
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'button_background_color_hover',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting(
	'button_color_hover',
	array(
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'button_color_hover',
		array(
			'label'         	=> esc_html__( 'Text Color', 'sydney' ),
			'section'       	=> 'sydney_section_buttons',
		)
	)
);

$wp_customize->add_setting(
	'button_border_color_hover',
	array(
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'button_border_color_hover',
		array(
			'label'         	=> esc_html__( 'Border Color', 'sydney' ),
			'section'       	=> 'sydney_section_buttons',
		)
	)
);