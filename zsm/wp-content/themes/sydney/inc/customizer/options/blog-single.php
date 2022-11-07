<?php
/**
 * Blog Customizer options
 *
 * @package Sydney
 */

/**
 * Single posts
 */
$wp_customize->add_section(
	'sydney_section_blog_singles',
	array(
		'title'         => esc_html__( 'Single posts', 'sydney'),
		'priority'      => 11,
		'panel'         => 'sydney_panel_blog',
	)
);

$wp_customize->add_setting(
	'sydney_blog_single_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	)
);
$wp_customize->add_control(
	new Sydney_Tab_Control (
		$wp_customize,
		'sydney_blog_single_tabs',
		array(
			'label' 				=> '',
			'section'       		=> 'sydney_section_blog_singles',
			'controls_general'		=> json_encode( array( '#customize-control-post_layout_title','#customize-control-post_container_layout','#customize-control-post_boxed_content','#customize-control-sydney_upsell_blog_singles','#customize-control-related_posts_title','#customize-control-sidebar_single_post','#customize-control-sidebar_single_post_position','#customize-control-blog_single_divider_1','#customize-control-single_post_header_title','#customize-control-single_post_header_alignment','#customize-control-single_post_header_spacing','#customize-control-blog_single_divider_2','#customize-control-single_post_image_title','#customize-control-single_post_show_featured','#customize-control-single_post_image_placement','#customize-control-single_post_image_spacing','#customize-control-blog_single_divider_3','#customize-control-single_post_meta_title','#customize-control-single_post_meta_position','#customize-control-single_post_meta_elements','#customize-control-single_post_meta_spacing','#customize-control-blog_single_divider_4','#customize-control-single_post_elements_title','#customize-control-single_post_show_tags','#customize-control-single_post_show_author_box','#customize-control-single_post_show_post_nav','#customize-control-single_post_show_related_posts', ) ),
			'controls_design'		=> json_encode( array( '#customize-control-single_post_title_size', '#customize-control-single_post_title_color', '#customize-control-single_posts_divider_1', '#customize-control-single_post_meta_size', '#customize-control-single_post_meta_color' ) ),
			'priority'				=> -100
		)
	)
);

//Header
$wp_customize->add_setting( 'single_post_header_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'single_post_header_title',
		array(
			'label'			=> esc_html__( 'Header', 'sydney' ),
			'section' 		=> 'sydney_section_blog_singles',
		)
	)
);

$wp_customize->add_setting( 'single_post_header_alignment',
	array(
		'default' 			=> 'left',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'single_post_header_alignment',
	array(
		'label' 	=> esc_html__( 'Header alignment', 'sydney' ),
		'section' 	=> 'sydney_section_blog_singles',
		'choices' 	=> array(
			'left' 		=> esc_html__( 'Left', 'sydney' ),
			'middle' 	=> esc_html__( 'Middle', 'sydney' ),
		),
	)
) );

$wp_customize->add_setting( 'single_post_header_spacing', array(
	'default'   		=> 40,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'single_post_header_spacing',
	array(
		'label' 		=> esc_html__( 'Header spacing', 'sydney' ),
		'section' 		=> 'sydney_section_blog_singles',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'single_post_header_spacing',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 60,
			'step'  => 1
		),
	)
) );

$wp_customize->add_setting( 'blog_single_divider_2',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'blog_single_divider_2',
		array(
			'section' 		=> 'sydney_section_blog_singles',
		)
	)
);


//Image
$wp_customize->add_setting( 'single_post_image_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'single_post_image_title',
		array(
			'label'			=> esc_html__( 'Image', 'sydney' ),
			'section' 		=> 'sydney_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_show_featured',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_post_show_featured',
		array(
			'label'         	=> esc_html__( 'Show featured image', 'sydney' ),
			'section'       	=> 'sydney_section_blog_singles',
		)
	)
);

$wp_customize->add_setting( 'single_post_image_placement',
	array(
		'default' 			=> 'below',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'single_post_image_placement',
	array(
		'label' 	=> esc_html__( 'Image placement', 'sydney' ),
		'section' 	=> 'sydney_section_blog_singles',
		'choices' 	=> array(
			'below' 	=> esc_html__( 'Below', 'sydney' ),
			'above' 	=> esc_html__( 'Above', 'sydney' ),
		),
	)
) );

$wp_customize->add_setting( 'single_post_image_spacing', array(
	'default'   		=> 38,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'single_post_image_spacing',
	array(
		'label' 		=> esc_html__( 'Image spacing', 'sydney' ),
		'section' 		=> 'sydney_section_blog_singles',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'single_post_image_spacing',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 60,
			'step'  => 1
		),
	)
) );

$wp_customize->add_setting( 'blog_single_divider_3',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'blog_single_divider_3',
		array(
			'section' 		=> 'sydney_section_blog_singles',
		)
	)
);

//Meta
$wp_customize->add_setting( 'single_post_meta_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'single_post_meta_title',
		array(
			'label'			=> esc_html__( 'Meta', 'sydney' ),
			'section' 		=> 'sydney_section_blog_singles',
		)
	)
);

$wp_customize->add_setting( 'single_post_meta_position',
	array(
		'default' 			=> 'below-title',
		'sanitize_callback' => 'sydney_sanitize_text'
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'single_post_meta_position',
	array(
		'label' 	=> esc_html__( 'Position', 'sydney' ),
		'section' 	=> 'sydney_section_blog_singles',
		'choices' 	=> array(
			'above-title' 	=> esc_html__( 'Above title', 'sydney' ),
			'below-title' 	=> esc_html__( 'Below title', 'sydney' ),
		),
	)
) );

$wp_customize->add_setting( 'single_post_meta_elements', array(
	'default'  			=> array( 'sydney_posted_by', 'sydney_posted_on', 'sydney_post_categories' ),
	'sanitize_callback'	=> 'sydney_sanitize_single_meta_elements'
) );

$wp_customize->add_control( new \Kirki\Control\Sortable( $wp_customize, 'single_post_meta_elements', array(
	'label'   		=> esc_html__( 'Meta elements', 'sydney' ),
	'section' => 'sydney_section_blog_singles',
	'choices' => array(
		'sydney_posted_on' 			=> esc_html__( 'Post date', 'sydney' ),
		'sydney_posted_by' 			=> esc_html__( 'Post author', 'sydney' ),
		'sydney_post_categories'	=> esc_html__( 'Post categories', 'sydney' ),
		'sydney_entry_comments' 	=> esc_html__( 'Post comments', 'sydney' ),
	),
) ) );

$wp_customize->add_setting( 'single_post_meta_spacing', array(
	'default'   		=> 8,
	'sanitize_callback' => 'absint',
	'transport'			=> 'postMessage',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'single_post_meta_spacing',
	array(
		'label' 		=> esc_html__( 'Spacing', 'sydney' ),
		'section' 		=> 'sydney_section_blog_singles',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'single_post_meta_spacing',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 60,
			'step'  => 1
		),
	)
) );

$wp_customize->add_setting( 'blog_single_divider_4',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'blog_single_divider_4',
		array(
			'section' 		=> 'sydney_section_blog_singles',
		)
	)
);

//Elements
$wp_customize->add_setting( 'single_post_elements_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'single_post_elements_title',
		array(
			'label'			=> esc_html__( 'Elements', 'sydney' ),
			'section' 		=> 'sydney_section_blog_singles',
		)
	)
);
$wp_customize->add_setting(
	'single_post_show_tags',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_post_show_tags',
		array(
			'label'         	=> esc_html__( 'Post tags', 'sydney' ),
			'section'       	=> 'sydney_section_blog_singles',
		)
	)
);
$wp_customize->add_setting(
	'single_post_show_author_box',
	array(
		'default'           => 0,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_post_show_author_box',
		array(
			'label'         	=> esc_html__( 'Author box', 'sydney' ),
			'section'       	=> 'sydney_section_blog_singles',
		)
	)
);
$wp_customize->add_setting(
	'single_post_show_post_nav',
	array(
		'default'           => 1,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_post_show_post_nav',
		array(
			'label'         	=> esc_html__( 'Post navigation', 'sydney' ),
			'section'       	=> 'sydney_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_show_related_posts',
	array(
		'default'           => 0,
		'sanitize_callback' => 'sydney_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Sydney_Toggle_Control(
		$wp_customize,
		'single_post_show_related_posts',
		array(
			'label'         	=> esc_html__( 'Related posts', 'sydney' ),
			'section'       	=> 'sydney_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'related_posts_title',
	array(
		'default' 			=> esc_html__( 'You might also like:', 'sydney' ),
		'sanitize_callback' => 'sydney_sanitize_text',
	)
);
$wp_customize->add_control(
	'related_posts_title',
	array(
		'label' 			=> esc_html__( 'Related posts title', 'sydney' ),
		'section' 			=> 'sydney_section_blog_singles',
		'type' 				=> 'text',
		'active_callback' 	=> 'sydney_callback_related_post_title'
	)
); 

/**
 * Styling
 */
$wp_customize->add_setting( 'single_post_title_size_desktop', array(
	'default'   		=> 48,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'single_post_title_size_tablet', array(
	'default'   		=> 32,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'single_post_title_size_mobile', array(
	'default'   		=> 32,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			


$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'single_post_title_size',
	array(
		'label' 		=> esc_html__( 'Post title size', 'sydney' ),
		'section' 		=> 'sydney_section_blog_singles',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'single_post_title_size_desktop',
			'size_tablet' 		=> 'single_post_title_size_tablet',
			'size_mobile' 		=> 'single_post_title_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 200
		)		
	)
) );

$wp_customize->add_setting(
	'single_post_title_color',
	array(
		'default'           => '#00102E',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'single_post_title_color',
		array(
			'label'         	=> esc_html__( 'Title color', 'sydney' ),
			'section'       	=> 'sydney_section_blog_singles',
		)
	)
);


$wp_customize->add_setting( 'single_posts_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'single_posts_divider_1',
		array(
			'section' 		=> 'sydney_section_blog_singles',
		)
	)
);

$wp_customize->add_setting( 'single_post_meta_size_desktop', array(
	'default'   		=> 12,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			

$wp_customize->add_setting( 'single_post_meta_size_tablet', array(
	'default'   		=> 12,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'single_post_meta_size_mobile', array(
	'default'   		=> 12,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );			


$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'single_post_meta_size',
	array(
		'label' 		=> esc_html__( 'Meta size', 'sydney' ),
		'section' 		=> 'sydney_section_blog_singles',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'single_post_meta_size_desktop',
			'size_tablet' 		=> 'single_post_meta_size_tablet',
			'size_mobile' 		=> 'single_post_meta_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 200
		)		
	)
) );

$wp_customize->add_setting(
	'single_post_meta_color',
	array(
		'default'           => '#666666',
		'sanitize_callback' => 'sydney_sanitize_hex_rgba',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new Sydney_Alpha_Color(
		$wp_customize,
		'single_post_meta_color',
		array(
			'label'         	=> esc_html__( 'Meta color', 'sydney' ),
			'section'       	=> 'sydney_section_blog_singles',
		)
	)
);