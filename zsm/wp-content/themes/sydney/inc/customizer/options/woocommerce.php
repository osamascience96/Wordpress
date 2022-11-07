<?php
/**
 * Woocommerce Customizer options
 *
 * @package Sydney
 */

 //General
$wp_customize->add_section(
	'sydney_section_catalog_general',
	array(
		'title'      => esc_html__( 'General', 'sydney'),
		'panel'      => 'woocommerce',
		'priority'	 => 1
	)
); 
$wp_customize->get_control( 'woocommerce_shop_page_display' )->section  = 'sydney_section_catalog_general';
$wp_customize->get_control( 'woocommerce_category_archive_display' )->section  = 'sydney_section_catalog_general';
$wp_customize->get_control( 'woocommerce_default_catalog_orderby' )->section  = 'sydney_section_catalog_general';

$wp_customize->get_setting( 'woocommerce_catalog_columns' )->priority = 1;
$wp_customize->get_setting( 'woocommerce_catalog_rows' )->priority = 1;

//Catalog
$wp_customize->add_setting(
	'sydney_product_catalog_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
	new Sydney_Tab_Control (
		$wp_customize,
		'sydney_product_catalog_tabs',
		array(
			'label' 				=> '',
			'section'       		=> 'woocommerce_product_catalog',
			'controls_general'		=> json_encode( array( '#customize-control-woocommerce_catalog_rows','#customize-control-woocommerce_catalog_columns','#customize-control-swc_loop_product_alignment','#customize-control-shop_breadcrumbs','#customize-control-accordion_shop_layout','#customize-control-swc_products_number','#customize-control-swc_columns_number','#customize-control-shop_archive_layout','#customize-control-shop_archive_sidebar','#customize-control-shop_archive_divider_1','#customize-control-shop_page_elements_title','#customize-control-shop_page_title','#customize-control-shop_page_description','#customize-control-shop_product_sorting','#customize-control-shop_results_count','#customize-control-accordion_shop_product_card','#customize-control-shop_product_card_layout','#customize-control-shop_product_add_to_cart_layout','#customize-control-shop_product_quickview_layout','#customize-control-shop_card_elements','#customize-control-shop_product_alignment','#customize-control-shop_product_element_spacing','#customize-control-accordion_shop_sale_tag','#customize-control-shop_product_sale_tag_layout','#customize-control-shop_sale_tag_spacing','#customize-control-shop_sale_tag_radius','#customize-control-sale_badge_text','#customize-control-sale_badge_percent','#customize-control-sale_percentage_text','#customize-control-accordion_shop_categories','#customize-control-shop_categories_layout','#customize-control-shop_categories_alignment','#customize-control-shop_categories_radius','#customize-control-shop_cart_layout', '#customize-control-swc_df_checkout','#customize-control-shop_checkout_layout', ) ),
			'controls_design'		=> json_encode( array( '#customize-control-swc_loop_product_price_font_size','#customize-control-swc_loop_product_price_color','#customize-control-swc_archive_button_icon','#customize-control-swc_loop_button_bg','#customize-control-swc_loop_button_color','#customize-control-swc_loop_button_size','#customize-control-swc_loop_button_font_size','#customize-control-accordion_shop_styling_buttons','#customize-control-swc_loop_product_title_color','#customize-control-accordion_shop_styling_card','#customize-control-shop_product_card_style','#customize-control-shop_product_card_radius','#customize-control-shop_product_card_thumb_radius','#customize-control-shop_product_card_background','#customize-control-shop_product_card_border_size','#customize-control-shop_product_card_border_color','#customize-control-accordion_shop_styling_sale','#customize-control-swc_loop_salebadge_bg_color','#customize-control-swc_loop_salebadge_color', ) ),
			'priority' 				=>	-10
		)
	)
);

//Layout
$wp_customize->add_setting( 'accordion_shop_layout', 
	array(
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control(
    new Sydney_Accordion_Control(
        $wp_customize,
        'accordion_shop_layout',
        array(
            'label'         => esc_html__( 'Layout', 'sydney' ),
            'section'       => 'woocommerce_product_catalog',
            'until'         => 'shop_breadcrumbs',
			'priority' =>	-1

        )
    )
);

$wp_customize->add_setting( 'shop_archive_layout',
	array(
		'default' 			=> 'product-grid',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'shop_archive_layout',
	array(
		'label' 	=> esc_html__( 'Layout type', 'sydney' ),
		'section' 	=> 'woocommerce_product_catalog',
		'choices' 	=> array(
			'product-grid' 		=> esc_html__( 'Grid', 'sydney' ),
			'product-list' 		=> esc_html__( 'List', 'sydney' ),
		),
		'priority'	 => 20
	)
) );

$wp_customize->add_setting(
	'shop_archive_sidebar',
	array(
		'default'           => 'sidebar-left',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'shop_archive_sidebar',
		array(
			'label'    => esc_html__( 'Sidebar', 'sydney' ),
			'section'  => 'woocommerce_product_catalog',
			'cols' 		=> 2,
			'choices'  => array(
				'no-sidebar'   => array(
					'label' => esc_html__( 'No Sidebar', 'sydney' ),
					'url'   => '%s/images/customizer/sidebar-disabled.svg'
				),
				'sidebar-left' => array(
					'label' => esc_html__( 'Left', 'sydney' ),
					'url'   => '%s/images/customizer/sidebar-left.svg'
				),
				'sidebar-right' => array(
					'label' => esc_html__( 'Right', 'sydney' ),
					'url'   => '%s/images/customizer/sidebar-right.svg'
				),	
			),
			'priority'	 => 30
		)
	)
);

$wp_customize->add_setting( 'shop_archive_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'shop_archive_divider_1',
		array(
			'section' 			=> 'woocommerce_product_catalog',
			'priority'	 		=> 40
		)
	)
);

//Page elements
$wp_customize->add_setting( 'shop_page_elements_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'shop_page_elements_title',
		array(
			'label'			=> esc_html__( 'Page elements', 'sydney' ),
			'section' 		=> 'woocommerce_product_catalog',
			'priority'	 	=> 50
		)
	)
);

$wp_customize->add_setting(
	'shop_page_title',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'shop_page_title',
		array(
			'label'         	=> esc_html__( 'Page title', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 60
		)
	)
);

$wp_customize->add_setting(
	'shop_page_description',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'shop_page_description',
		array(
			'label'         	=> esc_html__( 'Page Description', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 60
		)
	)
);

$wp_customize->add_setting(
	'shop_product_sorting',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'shop_product_sorting',
		array(
			'label'         	=> esc_html__( 'Product sorting', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 70
		)
	)
);

$wp_customize->add_setting(
	'shop_results_count',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'shop_results_count',
		array(
			'label'         	=> esc_html__( 'Results count', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 80
		)
	)
);

$wp_customize->add_setting(
	'shop_breadcrumbs',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'shop_breadcrumbs',
		array(
			'label'         	=> esc_html__( 'Display breadcrumbs', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 90
		)
	)
);

//Product card
$wp_customize->add_setting( 'accordion_shop_product_card', 
	array(
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
    new Sydney_Accordion_Control(
        $wp_customize,
        'accordion_shop_product_card',
        array(
            'label'         => esc_html__( 'Product card', 'sydney' ),
            'section'       => 'woocommerce_product_catalog',
            'until'         => 'shop_product_element_spacing',
			'priority'	 	=> 100
        )
    )
);


$wp_customize->add_setting(
	'shop_product_add_to_cart_layout',
	array(
		'default'           => 'layout2',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'shop_product_add_to_cart_layout',
		array(
			'label'    	=> esc_html__( 'Add to cart button', 'sydney' ),
			'section'  	=> 'woocommerce_product_catalog',
			'cols'		=> 3,
			'choices'  => array(
				'layout1' => array(
					'label' => esc_html__( 'Layout 1', 'sydney' ),
					'url'   => '%s/images/customizer/ac1.svg'
				),
				'layout2' => array(
					'label' => esc_html__( 'Layout 2', 'sydney' ),
					'url'   => '%s/images/customizer/ac2.svg'
				),										
			),
			'priority'	 => 120
		)
	)
); 

$wp_customize->add_setting( 'shop_card_elements', array(
	'default'  	=> array( 'woocommerce_template_loop_product_title', 'woocommerce_template_loop_rating', 'woocommerce_template_loop_price' ),
	'sanitize_callback'	=> 'sydney_sanitize_product_loop_components'
) );

$wp_customize->add_control( new \Kirki\Control\Sortable( $wp_customize, 'shop_card_elements', array(
	'label'   			=> esc_html__( 'Card elements', 'sydney' ),
	'section' 			=> 'woocommerce_product_catalog',
	'choices' 			=> array(
		'woocommerce_template_loop_product_title' 	=> esc_html__( 'Title', 'sydney' ),
		'woocommerce_template_loop_rating' 			=> esc_html__( 'Reviews', 'sydney' ),
		'woocommerce_template_loop_price' 			=> esc_html__( 'Price', 'sydney' ),
		'sydney_loop_product_category' 				=> esc_html__( 'Category', 'sydney' ),
		'sydney_loop_product_description' 			=> esc_html__( 'Short description', 'sydney' ),
	),
	'priority'	 => 140
) ) );

$wp_customize->add_setting( 'swc_loop_product_alignment',
	array(
		'default' 			=> 'center',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'swc_loop_product_alignment',
	array(
		'label'   => esc_html__( 'Text alignment', 'sydney' ),
		'section' => 'woocommerce_product_catalog',
		'choices' => array(
			'left' 		=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h10v1H0zM0 4h16v1H0zM0 8h10v1H0zM0 12h16v1H0z"/></svg>',
			'center' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 0h10v1H3zM0 4h16v1H0zM3 8h10v1H3zM0 12h16v1H0z"/></svg>',
			'right' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 0h10v1H6zM0 4h16v1H0zM6 8h10v1H6zM0 12h16v1H0z"/></svg>',
		),
		'priority'	 => 150
	)
) );

$wp_customize->add_setting( 'shop_product_element_spacing', array(
	'default'   		=> 12,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'shop_product_element_spacing',
	array(
		'label' 		=> esc_html__( 'Elements spacing', 'sydney' ),
		'section' 		=> 'woocommerce_product_catalog',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'shop_product_element_spacing',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
		'priority'	 => 160
	)
) );

//Sale tag
$wp_customize->add_setting( 'accordion_shop_sale_tag', 
	array(
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
    new Sydney_Accordion_Control(
        $wp_customize,
        'accordion_shop_sale_tag',
        array(
            'label'         => esc_html__( 'Sale tag', 'sydney' ),
            'section'       => 'woocommerce_product_catalog',
            'until'         => 'sale_badge_text',
			'priority'	 	=> 170
        )
    )
);
$wp_customize->add_setting(
	'shop_product_sale_tag_layout',
	array(
		'default'           => 'layout2',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'shop_product_sale_tag_layout',
		array(
			'label'    	=> esc_html__( 'Layout', 'sydney' ),
			'section'  	=> 'woocommerce_product_catalog',
			'cols'		=> 3,
			'choices'  => array(
				'layout1' => array(
					'label' => esc_html__( 'Layout 1', 'sydney' ),
					'url'   => '%s/images/customizer/sale1.svg'
				),
				'layout2' => array(
					'label' => esc_html__( 'Layout 2', 'sydney' ),
					'url'   => '%s/images/customizer/sale2.svg'
				),											
			),
			'priority'	 => 180
		)
	)
);

$wp_customize->add_setting( 'shop_sale_tag_spacing', array(
	'default'   		=> 20,
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'shop_sale_tag_spacing',
	array(
		'label' 		=> esc_html__( 'Spacing', 'sydney' ),
		'section' 		=> 'woocommerce_product_catalog',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'shop_sale_tag_spacing',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
		'priority'	 => 190
	)
) );

$wp_customize->add_setting( 'shop_sale_tag_radius', array(
	'default'   		=> 0,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'shop_sale_tag_radius',
	array(
		'label' 		=> esc_html__( 'Border radius', 'sydney' ),
		'section' 		=> 'woocommerce_product_catalog',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'shop_sale_tag_radius',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
		'priority'	 => 200
	)
) );

$wp_customize->add_setting(
	'sale_badge_text',
	array(
		'sanitize_callback' => 'sydney_sanitize_text',
		'default'           => esc_html__( 'Sale!', 'sydney' ),
	)       
);
$wp_customize->add_control( 'sale_badge_text', array(
	'label'       => esc_html__( 'Badge text', 'sydney' ),
	'type'        => 'text',
	'section'     => 'woocommerce_product_catalog',
	'priority'	  => 210
) );

//Categories
$wp_customize->add_setting( 'accordion_shop_categories', 
	array(
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
    new Sydney_Accordion_Control(
        $wp_customize,
        'accordion_shop_categories',
        array(
            'label'         => esc_html__( 'Categories', 'sydney' ),
            'section'       => 'woocommerce_product_catalog',
            'until'         => 'shop_categories_radius',
			'priority'	 	=> 240
        )
    )
);
$wp_customize->add_setting(
	'shop_categories_layout',
	array(
		'default'           => 'layout1',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'shop_categories_layout',
		array(
			'label'    	=> esc_html__( 'Layout', 'sydney' ),
			'section'  	=> 'woocommerce_product_catalog',
			'cols'		=> 3,
			'choices'  => array(
				'layout1' => array(
					'label' => esc_html__( 'Layout 1', 'sydney' ),
					'url'   => '%s/images/customizer/pcat1.svg'
				),
				'layout2' => array(
					'label' => esc_html__( 'Layout 2', 'sydney' ),
					'url'   => '%s/images/customizer/pcat2.svg'
				),		
				'layout3' => array(
					'label' => esc_html__( 'Layout 3', 'sydney' ),
					'url'   => '%s/images/customizer/pcat3.svg'
				),			
				'layout4' => array(
					'label' => esc_html__( 'Layout 4', 'sydney' ),
					'url'   => '%s/images/customizer/pcat4.svg'
				),					
				'layout5' => array(
					'label' => esc_html__( 'Layout 5', 'sydney' ),
					'url'   => '%s/images/customizer/pcat5.svg'
				),					
			),
			'priority'	 => 250
		)
	)
);

$wp_customize->add_setting( 'shop_categories_alignment',
	array(
		'default' 			=> 'center',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'shop_categories_alignment',
	array(
		'label'   => esc_html__( 'Text alignment', 'sydney' ),
		'section' => 'woocommerce_product_catalog',
		'choices' => array(
			'left' 		=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h10v1H0zM0 4h16v1H0zM0 8h10v1H0zM0 12h16v1H0z"/></svg>',
			'center' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 0h10v1H3zM0 4h16v1H0zM3 8h10v1H3zM0 12h16v1H0z"/></svg>',
			'right' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 0h10v1H6zM0 4h16v1H0zM6 8h10v1H6zM0 12h16v1H0z"/></svg>',
		),
		'priority'	 => 260
	)
) );

$wp_customize->add_setting( 'shop_categories_radius', array(
	'default'   		=> 0,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'shop_categories_radius',
	array(
		'label' 		=> esc_html__( 'Border radius', 'sydney' ),
		'section' 		=> 'woocommerce_product_catalog',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'shop_categories_radius',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
		'priority'	 => 270
	)
) );

//Cart 
$wp_customize->add_section(
	'sydney_section_shop_cart',
	array(
		'title'      => esc_html__( 'Cart', 'sydney'),
		'panel'      => 'woocommerce',
		'priority'	 => 11
	)
);

$wp_customize->add_setting(
	'shop_cart_layout',
	array(
		'default'           => 'layout1',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'shop_cart_layout',
		array(
			'label'    	=> esc_html__( 'Layout', 'sydney' ),
			'section'  	=> 'sydney_section_shop_cart',
			'cols'		=> 2,
			'choices'  => array(
				'layout1' => array(
					'label' => esc_html__( 'Layout 1', 'sydney' ),
					'url'   => '%s/images/customizer/cart1.svg'
				),
				'layout2' => array(
					'label' => esc_html__( 'Layout 2', 'sydney' ),
					'url'   => '%s/images/customizer/cart2.svg'
				),		
			),
			'priority'	 => 20
		)
	)
);
$wp_customize->add_setting( 'shop_cart_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'shop_cart_divider_1',
		array(
			'section' 			=> 'sydney_section_shop_cart',
			'priority'	 		=> 30
		)
	)
);
$wp_customize->add_setting(
	'shop_cart_show_cross_sell',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'shop_cart_show_cross_sell',
		array(
			'label'         	=> esc_html__( 'Cross Sell', 'sydney' ),
			'section'       	=> 'sydney_section_shop_cart',
			'priority'	 		=> 40
		)
	)
);
$wp_customize->add_setting(
	'shop_cart_show_coupon_form',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'shop_cart_show_coupon_form',
		array(
			'label'         	=> esc_html__( 'Display Coupon Form', 'sydney' ),
			'section'       	=> 'sydney_section_shop_cart',
			'priority'	 		=> 50
		)
	)
);

//Checkout
$wp_customize->add_setting(
	'shop_checkout_layout',
	array(
		'default'           => 'layout1',
		'sanitize_callback' => 'sanitize_key'
	)
);
$wp_customize->add_control(
	new Sydney_Radio_Images(
		$wp_customize,
		'shop_checkout_layout',
		array(
			'label'    	=> esc_html__( 'Layout', 'sydney' ),
			'section'  	=> 'woocommerce_checkout',
			'cols'		=> 2,
			'choices'  => array(
				'layout1' => array(
					'label' => esc_html__( 'Layout 1', 'sydney' ),
					'url'   => '%s/images/customizer/checkout1.svg'
				),
				'layout2' => array(
					'label' => esc_html__( 'Layout 2', 'sydney' ),
					'url'   => '%s/images/customizer/checkout2.svg'
				),		
			),
			'priority'	 => 20
		)
	)
); 
$wp_customize->add_setting(
	'shop_checkout_show_coupon_form',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'shop_checkout_show_coupon_form',
		array(
			'label'         	=> esc_html__( 'Display Coupon Form', 'sydney' ),
			'section'       	=> 'woocommerce_checkout',
			'priority'	 		=> 30
		)
	)
);

/**
 * Styling
 */

//Product card 
$wp_customize->add_setting( 'accordion_shop_styling_card', 
	array(
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
    new Sydney_Accordion_Control(
        $wp_customize,
        'accordion_shop_styling_card',
        array(
            'label'         => esc_html__( 'Product card', 'sydney' ),
            'section'       => 'woocommerce_product_catalog',
            'until'         => 'swc_loop_product_price_color',
			'priority'	 	=> 280
        )
    )
);

$wp_customize->add_setting( 'shop_product_card_thumb_radius', array(
	'default'   		=> 0,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'shop_product_card_thumb_radius',
	array(
		'label' 		=> esc_html__( 'Image radius', 'sydney' ),
		'section' 		=> 'woocommerce_product_catalog',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'shop_product_card_thumb_radius',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 100
		),
		'priority'	 => 310
	)
) );

$wp_customize->add_setting(
	'shop_product_card_background',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'shop_product_card_background',
		array(
			'label'         	=> esc_html__( 'Card background', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 320
		)
	)
);

$wp_customize->add_setting(
	'swc_loop_product_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'swc_loop_product_title_color',
		array(
			'label'         	=> esc_html__( 'Product title', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 340
		)
	)
);

$wp_customize->add_setting(
	'swc_loop_product_price_font_size',
	array(
		'sanitize_callback' => 'absint',
		'default'           => '18',
		'transport'         => 'postMessage'
	)       
);
$wp_customize->add_control( 'swc_loop_product_price_font_size', array(
	'type'        => 'number',
	'priority'	  => 341,
	'section'     => 'woocommerce_product_catalog',
	'label'       => __('Product prices font size', 'sydney'),
	'input_attrs' => array(
		'min'   => 10,
		'max'   => 36,
		'step'  => 1,
	),
) );
$wp_customize->add_setting(
	'swc_loop_product_price_color',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'swc_loop_product_price_color',
		array(
			'label' => __('Product prices color', 'sydney'),
			'section' => 'woocommerce_product_catalog',
			'priority'	=> 342
		)
	)
);

//Sale tag
$wp_customize->add_setting( 'accordion_shop_styling_sale', 
	array(
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
    new Sydney_Accordion_Control(
        $wp_customize,
        'accordion_shop_styling_sale',
        array(
            'label'         => esc_html__( 'Sale tag', 'sydney' ),
            'section'       => 'woocommerce_product_catalog',
            'until'         => 'swc_loop_salebadge_color',
			'priority'	 	=> 370
        )
    )
);
$wp_customize->add_setting(
	'swc_loop_salebadge_bg_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'swc_loop_salebadge_bg_color',
		array(
			'label'         	=> esc_html__( 'Background color', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 380
		)
	)
);

$wp_customize->add_setting(
	'swc_loop_salebadge_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'swc_loop_salebadge_color',
		array(
			'label'         	=> esc_html__( 'Color', 'sydney' ),
			'section'       	=> 'woocommerce_product_catalog',
			'priority'	 		=> 390
		)
	)
);


//Buttons
$wp_customize->add_setting( 'accordion_shop_styling_buttons', 
	array(
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
    new Sydney_Accordion_Control(
        $wp_customize,
        'accordion_shop_styling_buttons',
        array(
            'label'         => esc_html__( 'Buttons', 'sydney' ),
            'section'       => 'woocommerce_product_catalog',
            'until'         => 'swc_loop_button_font_size',
			'priority'	 	=> 400
        )
    )
);
$wp_customize->add_setting(
	'swc_archive_button_icon',
	array(
		'sanitize_callback' => 'sydney_sanitize_checkbox',
		'transport'         => 'postMessage'
	)       
);
$wp_customize->add_control(
	'swc_archive_button_icon',
	array(
		'type'      => 'checkbox',
		'label'     => __('Hide button icon', 'sydney'),
		'section'   => 'woocommerce_product_catalog',
		'priority'  => 400
	)
);
$wp_customize->add_setting(
	'swc_loop_button_bg',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'swc_loop_button_bg',
		array(
			'label' => __('Button background color', 'sydney'),
			'section' => 'woocommerce_product_catalog',
			'priority' => 400
		)
	)
); 
$wp_customize->add_setting(
	'swc_loop_button_color',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'swc_loop_button_color',
		array(
			'label' => __('Button color', 'sydney'),
			'section' => 'woocommerce_product_catalog',
			'priority' => 400
		)
	)
); 
$wp_customize->add_setting(
	'swc_loop_button_size',
	array(
		'sanitize_callback' => 'sydney_sanitize_select',
		'default'           => 'small',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	'swc_loop_button_size',
	array(
		'type'        => 'select',
		'label'       => __( 'Loop add to cart button size', 'sydney' ),
		'section'     => 'woocommerce_product_catalog',
		'priority'    => 400,
		'choices' => array(
			'small'     => __( 'Small', 'sydney' ),
			'medium'    => __( 'Medium', 'sydney' ),
			'large'     => __( 'Large', 'sydney' ),
		),
	)
);       
$wp_customize->add_setting(
	'swc_loop_button_font_size',
	array(
		'sanitize_callback' => 'absint',
		'default'           => '13',
		'transport'         => 'postMessage'
	)       
);
$wp_customize->add_control( 'swc_loop_button_font_size', array(
	'type'        => 'number',
	'priority'    => 400,
	'section'     => 'woocommerce_product_catalog',
	'label'       => __('Button font size', 'sydney'),
	'input_attrs' => array(
		'min'   => 10,
		'max'   => 26,
		'step'  => 1,
	),
) );