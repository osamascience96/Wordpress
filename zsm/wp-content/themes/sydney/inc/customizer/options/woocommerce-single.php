<?php
/**
 * Woocommerce Customizer options
 *
 * @package Sydney
 */

/**
 * General
 */
$wp_customize->add_section(
	'sydney_section_single_product',
	array(
		'title'      => esc_html__( 'Single products', 'sydney'),
		'panel'      => 'woocommerce',
		'priority'	 => 8
	)
); 

$wp_customize->add_setting(
	'sydney_single_product_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
	new Sydney_Tab_Control (
		$wp_customize,
		'sydney_single_product_tabs',
		array(
			'label' 				=> '',
			'section'       		=> 'sydney_section_single_product',
			'controls_general'		=> json_encode( array( '#customize-control-swc_trust_badge_image','#customize-control-swc_repeater_reasons_title','#customize-control-swc_repeater_reasons','#customize-control-swc_gallery_columns','#customize-control-single_product_ratings','#customize-control-swc_sidebar_products','#customize-control-single_gallery_slider','#customize-control-single_product_gallery','#customize-control-single_zoom_effects','#customize-control-single_breadcrumbs','#customize-control-single_product_tabs','#customize-control-single_upsell_products','#customize-control-single_related_products','#customize-control-single_product_sku','#customize-control-single_product_categories','#customize-control-single_product_tags' ) ),
			'controls_design'		=> json_encode( array( '#customize-control-swc_single_product_price_color','#customize-control-swc_single_product_title_color','#customize-control-single_product_title_size','#customize-control-single_product_styling_divider_1','#customize-control-single_product_price_color','#customize-control-single_product_price_size', ) ),
		)
	)
);

$wp_customize->add_setting(
	'swc_sidebar_products',
	array(
		'default'           => 0,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'swc_sidebar_products',
		array(
			'label'     		=> esc_html__( 'Remove sidebar from single products?', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
		)
	)
);

$wp_customize->add_setting(
	'single_product_gallery',
	array(
		'default'           => 'gallery-default',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'single_product_gallery',
		array(
			'label'    	=> esc_html__( 'Product Image', 'sydney' ),
			'section'  	=> 'sydney_section_single_product',
			'cols'		=> 3,
			'choices'  => array(
				'gallery-default' => array(
					'label' => esc_html__( 'Layout 1', 'sydney' ),
					'url'   => '%s/images/customizer/sg1.svg'
				),
				'gallery-single' => array(
					'label' => esc_html__( 'Layout 2', 'sydney' ),
					'url'   => '%s/images/customizer/sg2.svg'
				),	
				'gallery-vertical' => array(
					'label' => esc_html__( 'Layout 3', 'sydney' ),
					'url'   => '%s/images/customizer/sg3.svg'
				),															
			),
			'priority'	 => 20
		)
	)
);

$wp_customize->add_setting(
	'single_gallery_slider',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_gallery_slider',
		array(
			'label'         	=> esc_html__( 'Gallery thumbnail slider', 'sydney' ),
			'description'       => esc_html__( 'Requires page refresh after saving', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 30
		)
	)
);

$wp_customize->add_setting(
	'swc_gallery_columns',
	array(
		'sanitize_callback' => 'absint',
		'default'           => 4,
	)       
);
$wp_customize->add_control( 'swc_gallery_columns', array(
	'type'        => 'number',
	'priority'	  => 30,
	'section'     => 'sydney_section_single_product',
	'label'       => __('Gallery columns', 'sydney'),
	'input_attrs' => array(
		'min'   => 2,
		'max'   => 5,
		'step'  => 1,
	),
) );

$wp_customize->add_setting(
	'single_breadcrumbs',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_breadcrumbs',
		array(
			'label'         	=> esc_html__( 'Breadcrumbs', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 50
		)
	)
);

$wp_customize->add_setting(
	'single_product_sku',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_product_sku',
		array(
			'label'         	=> esc_html__( 'SKU', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 60
		)
	)
);


$wp_customize->add_setting(
	'single_product_ratings',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_product_ratings',
		array(
			'label'         	=> esc_html__( 'Ratings', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 60
		)
	)
);

$wp_customize->add_setting(
	'single_product_categories',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_product_categories',
		array(
			'label'         	=> esc_html__( 'Categories', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 70
		)
	)
);

$wp_customize->add_setting(
	'single_product_tags',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_product_tags',
		array(
			'label'         	=> esc_html__( 'Tags', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 80
		)
	)
);

$wp_customize->add_setting(
	'single_product_tabs',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_product_tabs',
		array(
			'label'         	=> esc_html__( 'Product tabs', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 90
		)
	)
);

$wp_customize->add_setting(
	'single_upsell_products',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_upsell_products',
		array(
			'label'         	=> esc_html__( 'Upsell products', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 100
		)
	)
);

$wp_customize->add_setting(
	'single_related_products',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_related_products',
		array(
			'label'         	=> esc_html__( 'Related products', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 110
		)
	)
);

/**
 * Styling
 */

$wp_customize->add_setting( 'single_product_title_size_desktop', array(
	'default'   		=> 32,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'single_product_title_size_tablet', array(
	'default'   		=> 32,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'single_product_title_size_mobile', array(
	'default'   		=> 32,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			


$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'single_product_title_size',
	array(
		'label' 		=> esc_html__( 'Product title size', 'sydney' ),
		'section' 		=> 'sydney_section_single_product',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'single_product_title_size_desktop',
			'size_tablet' 		=> 'single_product_title_size_tablet',
			'size_mobile' 		=> 'single_product_title_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 200
		),
		'priority'	 => 120
	)
) );

$wp_customize->add_setting(
	'swc_single_product_title_color',
	array(
		'default'           => '#212121',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'swc_single_product_title_color',
		array(
			'label'         	=> esc_html__( 'Product title color', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 130
		)
	)
);

$wp_customize->add_setting( 'single_product_styling_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'single_product_styling_divider_1',
		array(
			'section' 		=> 'sydney_section_single_product',
			'priority'	 	=> 140
		)
	)
);

$wp_customize->add_setting( 'single_product_price_size_desktop', array(
	'default'   		=> 24,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'single_product_price_size_tablet', array(
	'default'   		=> 24,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'single_product_price_size_mobile', array(
	'default'   		=> 24,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'single_product_price_size',
	array(
		'label' 		=> esc_html__( 'Product price size', 'sydney' ),
		'section' 		=> 'sydney_section_single_product',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'single_product_price_size_desktop',
			'size_tablet' 		=> 'single_product_price_size_tablet',
			'size_mobile' 		=> 'single_product_price_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 200
		),
		'priority'	 => 150
	)
) );

$wp_customize->add_setting(
	'swc_single_product_price_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'swc_single_product_price_color',
		array(
			'label'         	=> esc_html__( 'Product price color', 'sydney' ),
			'section'       	=> 'sydney_section_single_product',
			'priority'	 		=> 150
		)
	)
);