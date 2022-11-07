<?php
/**
 * Header Customizer options
 *
 * @package Sydney
 */

/**
 * Mobile Header
 */
$wp_customize->add_section(
	'sydney_section_mobile_header',
	array(
		'title'      => esc_html__( 'Mobile header', 'sydney'),
		'panel'      => 'sydney_panel_header',
	)
);

$wp_customize->add_setting(
	'sydney_mobile_header_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
	new Sydney_Tab_Control (
		$wp_customize,
		'sydney_mobile_header_tabs',
		array(
			'label' 				=> '',
			'section'       		=> 'sydney_section_mobile_header',
			'controls_general'		=> json_encode( array( '#customize-control-sydney_upsell_mobile_header','#customize-control-header_layout_mobile','#customize-control-header_components_mobile','#customize-control-mobile_header_divider_1','#customize-control-header_offcanvas_mode','#customize-control-header_components_offcanvas','#customize-control-mobile_header_divider_2','#customize-control-mobile_menu_alignment','#customize-control-mobile_menu_link_separator','#customize-control-mobile_menu_link_spacing','#customize-control-mobile_menu_icon', ) ),
			'controls_design'		=> json_encode( array( '#customize-control-mobile_header_bar_title','#customize-control-mobile_header_offcanvas_title','#customize-control-mobile_header_separator_title','#customize-control-mobile_header_background','#customize-control-mobile_header_color','#customize-control-mobile_header_padding','#customize-control-mobile_header_divider_3','#customize-control-offcanvas_menu_background','#customize-control-offcanvas_menu_color','#customize-control-mobile_header_divider_4','#customize-control-mobile_header_separator_width','#customize-control-link_separator_color', ) ),
		)
	)
);

//Layout
$sydney_choices = sydney_mobile_header_layouts();

$wp_customize->add_setting(
	'header_layout_mobile',
	array(
		'default'           => 'header_mobile_layout_1',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'header_layout_mobile',
		array(
			'label'    	=> esc_html__( 'Layout', 'sydney' ),
			'section'  	=> 'sydney_section_mobile_header',
			'cols'		=> 2,
			'choices'  	=> $sydney_choices
		)
	)
);

$sydney_header_components 	= sydney_header_elements();
$sydney_default_components = sydney_get_default_header_components();

$wp_customize->add_setting( 'header_components_mobile', array(
	'default'  			=> $sydney_default_components['mobile'],
	'sanitize_callback'	=> 'sydney_sanitize_header_components'
) );

$wp_customize->add_control( new \Kirki\Control\Sortable( $wp_customize, 'header_components_mobile', array(
	'label'   			=> esc_html__( 'Additional elements', 'sydney' ),
	'section' 			=> 'sydney_section_mobile_header',
	'choices' 			=> $sydney_header_components,
) ) );

$wp_customize->add_setting( 'mobile_header_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'mobile_header_divider_1',
		array(
			'section' 		=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting(
	'header_offcanvas_mode',
	array(
		'default'           => 'layout1',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'header_offcanvas_mode',
		array(
			'label'    	=> esc_html__( 'Off-canvas mode', 'sydney' ),
			'section'  	=> 'sydney_section_mobile_header',
			'cols'		=> 2,
			'choices'  => array(
				'layout1' => array(
					'label' => esc_html__( 'Layout 1', 'sydney' ),
					'url'   => '%s/images/customizer/oc1.svg'
				),
				'layout2' => array(
					'label' => esc_html__( 'Layout 2', 'sydney' ),
					'url'   => '%s/images/customizer/oc2.svg'
				),	
			)
		)
	)
);

$wp_customize->add_setting( 'header_components_offcanvas', array(
	'default'  			=> $sydney_default_components['offcanvas'],
	'sanitize_callback'	=> 'sydney_sanitize_header_components'
) );

$wp_customize->add_control( new \Kirki\Control\Sortable( $wp_customize, 'header_components_offcanvas', array(
	'label'   			=> esc_html__( 'Additional offcanvas elements', 'sydney' ),
	'section' 			=> 'sydney_section_mobile_header',
	'choices' 			=> $sydney_header_components,
) ) );


$wp_customize->add_setting( 'mobile_header_divider_2',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'mobile_header_divider_2',
		array(
			'section' 		=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting( 'mobile_menu_alignment',
	array(
		'default' 			=> 'left',
		'sanitize_callback' => 'sydney_sanitize_text',
		'transport'			=> 'postMessage'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'mobile_menu_alignment',
	array(
		'label'   => esc_html__( 'Link alignment', 'sydney' ),
		'section' => 'sydney_section_mobile_header',
		'choices' => array(
			'left' 		=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h10v1H0zM0 4h16v1H0zM0 8h10v1H0zM0 12h16v1H0z"/></svg>',
			'center' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 0h10v1H3zM0 4h16v1H0zM3 8h10v1H3zM0 12h16v1H0z"/></svg>',
			'right' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 0h10v1H6zM0 4h16v1H0zM6 8h10v1H6zM0 12h16v1H0z"/></svg>',
		)
	)
) );

$wp_customize->add_setting(
	'mobile_menu_link_separator',
	array(
		'default'           => 0,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'mobile_menu_link_separator',
		array(
			'label'         	=> esc_html__( 'Link separator', 'sydney' ),
			'section'       	=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting( 'mobile_menu_link_spacing', array(
	'default'   		=> 20,
	'sanitize_callback' => 'absint',
	'transport'			=> 'postMessage'
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'mobile_menu_link_spacing',
	array(
		'label' 		=> esc_html__( 'Link spacing', 'sydney' ),
		'section' 		=> 'sydney_section_mobile_header',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'mobile_menu_link_spacing',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 50,
			'step'  => 1
		),
	)
) );

$wp_customize->add_setting( 'mobile_menu_icon',
	array(
		'default' 			=> 'mobile-icon2',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'mobile_menu_icon',
	array(
		'label'   => esc_html__( 'Menu icon', 'sydney' ),
		'section' => 'sydney_section_mobile_header',
		'choices' => array(
			'mobile-icon1' 	=> '<svg width="16" height="7" viewBox="0 0 16 7" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="16" height="1"/><rect y="6" width="16" height="1"/></svg>',
			'mobile-icon2' 	=> '<svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="16" height="1"/><rect y="5" width="16" height="1"/><rect y="10" width="16" height="1"/></svg>',
			'mobile-icon3' 	=> '<svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="16" height="1"/><rect y="5" width="10" height="1"/><rect y="10" width="16" height="1"/></svg>',
			'mobile-icon4' 	=> '<svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="7" width="14" height="1"/><rect x="7.5" y="0.5" width="14" height="1" transform="rotate(90 7.5 0.5)"/></svg>',
		)
	)
) );

/**
 * Styling
 */
$wp_customize->add_setting( 'mobile_header_bar_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'mobile_header_bar_title',
		array(
			'label'			=> esc_html__( 'Menu bar', 'sydney' ),
			'section' 		=> 'sydney_section_mobile_header',
		)
	)
);
$wp_customize->add_setting(
	'mobile_header_background',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'mobile_header_background',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting(
	'mobile_header_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'mobile_header_color',
		array(
			'label'         	=> esc_html__( 'Text color', 'sydney' ),
			'section'       	=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting( 'mobile_header_padding', array(
	'default'   		=> 15,
	'sanitize_callback' => 'absint',
	'transport'			=> 'postMessage'
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'mobile_header_padding',
	array(
		'label' 		=> esc_html__( 'Top &amp; bottom padding', 'sydney' ),
		'section' 		=> 'sydney_section_mobile_header',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'mobile_header_padding',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 50,
			'step'  => 1
		),
	)
) );


$wp_customize->add_setting( 'mobile_header_divider_3',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'mobile_header_divider_3',
		array(
			'section' 		=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting( 'mobile_header_offcanvas_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'mobile_header_offcanvas_title',
		array(
			'label'			=> esc_html__( 'Offcanvas menu', 'sydney' ),
			'section' 		=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting(
	'offcanvas_menu_background',
	array(
		'default'           => '#f0f0f0',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'offcanvas_menu_background',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting(
	'offcanvas_menu_color',
	array(
		'default'           => '#233452',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'offcanvas_menu_color',
		array(
			'label'         	=> esc_html__( 'Color', 'sydney' ),
			'section'       	=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting( 'mobile_header_divider_4',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'mobile_header_divider_4',
		array(
			'section' 		=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting( 'mobile_header_separator_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'mobile_header_separator_title',
		array(
			'label'			=> esc_html__( 'Link separator', 'sydney' ),
			'section' 		=> 'sydney_section_mobile_header',
		)
	)
);

$wp_customize->add_setting( 'mobile_header_separator_width', array(
	'default'   		=> 1,
	'sanitize_callback' => 'absint',
	'transport'			=> 'postMessage'
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'mobile_header_separator_width',
	array(
		'label' 		=> esc_html__( 'Separator size', 'sydney' ),
		'section' 		=> 'sydney_section_mobile_header',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'mobile_header_separator_width',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 50,
			'step'  => 1
		),
	)
) );

$wp_customize->add_setting(
	'link_separator_color',
	array(
		'default'           => 'rgba(238, 238, 238, 0.14)',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'link_separator_color',
		array(
			'label'         	=> esc_html__( 'Separator color', 'sydney' ),
			'section'       	=> 'sydney_section_mobile_header',
		)
	)
);