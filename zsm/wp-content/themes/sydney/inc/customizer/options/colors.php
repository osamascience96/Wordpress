<?php
/**
 * Colors Customizer options
 *
 * @package Sydney
 */



//General
$wp_customize->add_setting( 'general_color_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'general_color_title',
		array(
			'label'			=> esc_html__( 'General', 'sydney' ),
			'section' 		=> 'colors',
			'priority'			=> 9
		)
	)
);


$wp_customize->add_setting(
	'primary_color',
	array(
		'default'           => '#e64e4e',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'			=> 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'primary_color',
		array(
			'label'         => __('Primary color', 'sydney'),
			'section'       => 'colors',
		)
	)
);

//Body
$wp_customize->add_setting(
	'body_text_color',
	array(
		'default'           => '#47425d',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'body_text_color',
		array(
			'label' => __('Body text', 'sydney'),
			'section' => 'colors',
		)
	)
);

$wp_customize->add_setting( 'color_divider_2',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'color_divider_2',
		array(
			'section' 		=> 'colors',
		)
	)
);

//Links
$wp_customize->add_setting( 'links_color_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'links_color_title',
		array(
			'label'			=> esc_html__( 'Links', 'sydney' ),
			'section' 		=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'color_link_default',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_link_default',
		array(
			'label'         	=> esc_html__( 'Content links', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'color_link_hover',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_link_hover',
		array(
			'label'         	=> esc_html__( 'Content links hover', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting( 'color_divider_3',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'color_divider_3',
		array(
			'section' 		=> 'colors',
		)
	)
);

//Headings
$wp_customize->add_setting( 'headings_color_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'headings_color_title',
		array(
			'label'			=> esc_html__( 'Headings', 'sydney' ),
			'section' 		=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'color_heading_1',
	array(
		'default'           => '#00102E',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_heading_1',
		array(
			'label'         	=> esc_html__( 'Heading 1', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading_2',
	array(
		'default'           => '#00102E',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_heading_2',
		array(
			'label'         	=> esc_html__( 'Heading 2', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading_3',
	array(
		'default'           => '#00102E',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_heading_3',
		array(
			'label'         	=> esc_html__( 'Heading 3', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading_4',
	array(
		'default'           => '#00102E',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_heading_4',
		array(
			'label'         	=> esc_html__( 'Heading 4', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading_5',
	array(
		'default'           => '#00102E',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_heading_5',
		array(
			'label'         	=> esc_html__( 'Heading 5', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading_6',
	array(
		'default'           => '#00102E',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_heading_6',
		array(
			'label'         	=> esc_html__( 'Heading 6', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting( 'color_divider_4',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'color_divider_4',
		array(
			'section' 		=> 'colors',
		)
	)
);

//Forms
$wp_customize->add_setting( 'forms_color_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'forms_color_title',
		array(
			'label'			=> esc_html__( 'Form fields', 'sydney' ),
			'section' 		=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'color_forms_text',
	array(
		'default'           => '#767676',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_forms_text',
		array(
			'label'         	=> esc_html__( 'Text color', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'color_forms_background',
	array(
		'default'           => '#fafafa',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_forms_background',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'color_forms_borders',
	array(
		'default'           => '#dbdbdb',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_forms_borders',
		array(
			'label'         	=> esc_html__( 'Border color', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'color_forms_placeholder',
	array(
		'default'           => '#dbdbdb',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'color_forms_placeholder',
		array(
			'label'         	=> esc_html__( 'Placeholder color', 'sydney' ),
			'section'       	=> 'colors',
		)
	)
);


if ( false == get_option('sydney-update-header' ) ) {

	$wp_customize->add_setting( 'color_divider_5',
		array(
			'sanitize_callback' => 'esc_attr'
		)
	);

	$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'color_divider_5',
			array(
				'section' 		=> 'colors',
			)
		)
	);

	$wp_customize->add_setting( 'header_old_color_title',
		array(
			'default' 			=> '',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'header_old_color_title',
			array(
				'label'			=> esc_html__( 'Header', 'sydney' ),
				'section' 		=> 'colors',
			)
		)
	);

	//Menu bg
	$wp_customize->add_setting(
		'menu_bg_color',
		array(
			'default'           => '#000000',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_bg_color',
			array(
				'label' => __('Menu background', 'sydney'),
				'section' => 'colors',
			)
		)
	); 

	//Site title
	$wp_customize->add_setting(
		'site_title_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_title_color',
			array(
				'label' => __('Site title', 'sydney'),
				'section' => 'colors',
				'settings' => 'site_title_color',
			)
		)
	);
	//Site desc
	$wp_customize->add_setting(
		'site_desc_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_desc_color',
			array(
				'label' => __('Site description', 'sydney'),
				'section' => 'colors',
			)
		)
	);
	
	//Top level menu items
	$wp_customize->add_setting(
		'top_items_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'top_items_color',
			array(
				'label' => __('Top level menu items', 'sydney'),
				'section' => 'colors',
			)
		)
	);
	//Menu items hover
	$wp_customize->add_setting(
		'menu_items_hover',
		array(
			'default'           => '#e64e4e',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_items_hover',
			array(
				'label' => __('Menu items hover', 'sydney'),
				'section' => 'colors',
			)
		)
	);    
	//Sub menu items color
	$wp_customize->add_setting(
		'submenu_items_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'submenu_items_color',
			array(
				'label' => __('Sub-menu items', 'sydney'),
				'section' => 'colors',
			)
		)
	);
	//Sub menu background
	$wp_customize->add_setting(
		'submenu_background',
		array(
			'default'           => '#1c1c1c',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'submenu_background',
			array(
				'label' => __('Sub-menu background', 'sydney'),
				'section' => 'colors',
			)
		)
	);
	//Mobile menu
	$wp_customize->add_setting(
		'mobile_menu_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'mobile_menu_color',
			array(
				'label' => __('Mobile menu button', 'sydney'),
				'section' => 'colors',
			)
		)
	);     
}








$wp_customize->add_setting( 'color_divider_6',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'color_divider_6',
		array(
			'section' 		=> 'colors',
		)
	)
);

$wp_customize->add_setting( 'sidebar_color_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'sidebar_color_title',
		array(
			'label'			=> esc_html__( 'Sidebar', 'sydney' ),
			'section' 		=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'sidebar_background',
	array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'sidebar_background',
		array(
			'label' => __('Sidebar background', 'sydney'),
			'section' => 'colors',
			'priority' => 20
		)
	)
);
//Sidebar color
$wp_customize->add_setting(
	'sidebar_color',
	array(
		'default'           => '#737C8C',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'sidebar_color',
		array(
			'label' => __('Sidebar color', 'sydney'),
			'section' => 'colors',
			'priority' => 21
		)
	)
);