<?php 
/**
 * Page headers module options
 */

$args       = array(
	'public' => true,
);
$post_types = get_post_types( $args, 'objects' );

//Remove unwanted post types
$unset_types = array(
	'product',
	'attachment',
	'e-landing-page',
	'elementor_library',
	'athemes_hf',
);

foreach ( $unset_types as $type ) {
	unset( $post_types[ $type ] );
}

//Loop through the post types
foreach ( $post_types as $post_type ) {

	$section = 'sydney_cpt_' . $post_type->name;
	if ( 'post' === $post_type->name ) {
		$section = 'sydney_section_blog_singles';
	}

	//Title
	$wp_customize->add_setting( $post_type->name . '_layout_title',
		array(
			'default' 			=> '',
			'sanitize_callback' => 'esc_attr'
		)
	);

	$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, $post_type->name . '_layout_title',
			array(
				'label'			=> esc_html__( 'Layout', 'sydney' ),
				'section' 		=> $section,
				'priority' => 1,
			)
		)
	);	

	//Layout
	$wp_customize->add_setting(
		$post_type->name . '_container_layout',
		array(
			'default'           => 'normal',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control(
		new Sydney_Radio_Images(
			$wp_customize,
			$post_type->name . '_container_layout',
			array(
				'label'    => esc_html__( 'Select your layout', 'sydney' ),
				'section'  => $section,
				'cols' 		=> 3,
				'show_labels' => true,
				'choices'  => array( 	
					'normal' => array(
						'label' => esc_html__( 'Normal', 'sydney' ),
						'url'   => '%s/images/customizer/gc1.svg'
					), 
					'narrow' => array(
						'label' => esc_html__( 'Narrow', 'sydney' ),
						'url'   => '%s/images/customizer/gc2.svg'
					), 	
					'stretched' => array(
						'label' => esc_html__( 'Stretched', 'sydney' ),
						'url'   => '%s/images/customizer/gc3.svg'
					), 										
				),
				'priority' => 1,
			)
		)
	);

	//Boxed content
	$wp_customize->add_setting( $post_type->name . '_boxed_content',
		array(
			'default' 			=> 'unboxed',
			'sanitize_callback' => 'sydney_sanitize_text',
			'transport' 		=> 'postMessage'
		)
	);
	$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, $post_type->name . '_boxed_content',
		array(
			'label' 	=> esc_html__( 'Boxed content area', 'sydney' ),
			'section'  => $section,
			'choices' 	=> array(
				'unboxed' 	=> esc_html__( 'Unboxed', 'sydney' ),
				'boxed' 	=> esc_html__( 'Boxed', 'sydney' ),
			),
			'priority' => 1,
		)
	) );	

	//Sidebar
	$wp_customize->add_setting(
		'sidebar_single_' . $post_type->name,
		array(
			'default'           => 1,
			'sanitize_callback' => 'sydney_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		new Sydney_Toggle_Control(
			$wp_customize,
			'sidebar_single_' . $post_type->name,
			array(
				'label'         	=> esc_html__( 'Enable sidebar', 'sydney' ),
				'section'       	=> $section,
				'priority' 			=> 1,
			)
		)
	);
	
	$wp_customize->add_setting( 'sidebar_single_' . $post_type->name . '_position',
		array(
			'default' 			=> 'sidebar-right',
			'sanitize_callback' => 'sydney_sanitize_text'
		)
	);
	$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'sidebar_single_' . $post_type->name . '_position',
		array(
			'label' 	=> esc_html__( 'Sidebar position', 'sydney' ),
			'section'   => $section,
			'choices' 	=> array(
				'sidebar-left' 		=> esc_html__( 'Left', 'sydney' ),
				'sidebar-right' 	=> esc_html__( 'Right', 'sydney' ),
			),
			'active_callback' 	=> function() use ( $post_type ) {
				$enable = get_theme_mod( 'sidebar_single_' . $post_type->name, 1 );

				if ( $enable ) {
					return true;
				} else {
					return false;
				}	
			},
			'priority' => 1,
		)
	) );

	$wp_customize->add_setting( $post_type->name . '_layouts_div_1',
		array(
			'sanitize_callback' => 'esc_attr'
		)
	);

	$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, $post_type->name . '_layouts_div_1',
			array(
				'section' 	=> $section,
				'priority' => 1,
			)
		)
	);	

}