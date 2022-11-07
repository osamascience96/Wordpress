<?php
/**
 * Typography Customizer options
 *
 * @package Sydney
 */

$wp_customize->add_panel(
	'sydney_panel_typography',
	array(
		'title'         => esc_html__( 'Typography', 'sydney'),
		'priority'      => 11,
	)
);

/**
 * Headings
 */
$wp_customize->add_section(
	'sydney_section_typography_headings',
	array(
		'title'      => esc_html__( 'Headings', 'sydney'),
		'panel'      => 'sydney_panel_typography',
	)
);

$wp_customize->add_setting( 'sydney_headings_font',
	array(
		'default'           => '{"font":"System default","regularweight":"bold","category":"sans-serif"}',
		'sanitize_callback' => 'sydney_google_fonts_sanitize',
		'transport'	 		=> 'postMessage'
	)
);

$wp_customize->add_control( new Sydney_Typography_Control( $wp_customize, 'sydney_headings_font',
	array(
		'section' => 'sydney_section_typography_headings',
		'settings' => array (
			'family' => 'sydney_headings_font',
		),
		'input_attrs' => array(
			'font_count'    => 'all',
			'orderby'       => 'alpha',
			'disableRegular' => false,
		),
	)
) );

$wp_customize->add_setting( 'headings_font_style', array(
	'sanitize_callback' => 'sydney_sanitize_select',
	'default' 			=> 'normal',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'headings_font_style', array(
	'type' 		=> 'select',
	'section' 	=> 'sydney_section_typography_headings',
	'label' 	=> esc_html__( 'Font style', 'sydney' ),
	'choices' => array(
		'normal' 	=> esc_html__( 'Normal', 'sydney' ),
		'italic' 	=> esc_html__( 'Italic', 'sydney' ),
		'oblique' 	=> esc_html__( 'Oblique', 'sydney' ),
	),
) );

$wp_customize->add_setting( 'headings_line_height', array(
	'default'   		=> 1.2,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'sydney_sanitize_text',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'headings_line_height',
	array(
		'label' 		=> esc_html__( 'Line height', 'sydney' ),
		'section' 		=> 'sydney_section_typography_headings',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'headings_line_height',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 5,
			'step'  => 0.01
		)
	)
) );

$wp_customize->add_setting( 'headings_letter_spacing', array(
	'default'   		=> 0,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'sydney_sanitize_text',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'headings_letter_spacing',
	array(
		'label' 		=> esc_html__( 'Letter spacing', 'sydney' ),
		'section' 		=> 'sydney_section_typography_headings',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'headings_letter_spacing',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 5,
			'step'  => 0.5
		)
	)
) );

$wp_customize->add_setting( 'headings_text_transform',
	array(
		'default' 			=> 'none',
		'sanitize_callback' => 'sydney_sanitize_text',
		'transport'			=> 'postMessage',
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'headings_text_transform',
	array(
		'label'   => esc_html__( 'Text transform', 'sydney' ),
		'section' => 'sydney_section_typography_headings',
		'choices' => array(
			'none' 			=> '-',
			'capitalize' 	=> 'Aa',
			'lowercase' 	=> 'aa',
			'uppercase' 	=> 'AA',
		)
	)
) );

$wp_customize->add_setting( 'headings_text_decoration',
	array(
		'default' 			=> 'none',
		'sanitize_callback' => 'sydney_sanitize_text',
		'transport'			=> 'postMessage',
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'headings_text_decoration',
	array(
		'label'   => esc_html__( 'Text decoration', 'sydney' ),
		'section' => 'sydney_section_typography_headings',
		'choices' => array(
			'none' 			=> '-',
			'underline' 	=> '<div style="text-decoration:underline;">U</div>',
			'line-through' 	=> '<div style="text-decoration:line-through;">S</div>',
		)
	)
) );

$wp_customize->add_setting( 'typography_divider_1',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'typography_divider_1',
		array(
			'section' 		=> 'sydney_section_typography_headings',
		)
	)
);

$wp_customize->add_setting( 'h1_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'h1_title',
		array(
			'label'			=> esc_html__( 'Heading 1', 'sydney' ),
			'section' 		=> 'sydney_section_typography_headings',
		)
	)
);

$wp_customize->add_setting( 'h1_font_size_desktop', array(
	'default'   		=> 48,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h1_font_size_tablet', array(
	'default'   		=> 42,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h1_font_size_mobile', array(
	'default'   		=> 32,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'h1_font_size',
	array(
		'label' 		=> esc_html__( 'Font size', 'sydney' ),
		'section' 		=> 'sydney_section_typography_headings',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'h1_font_size_desktop',
			'size_tablet' 		=> 'h1_font_size_tablet',
			'size_mobile' 		=> 'h1_font_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 12,
			'max'	=> 100,
			'step'  => 1
		)
	)
) );

$wp_customize->add_setting( 'h2_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'h2_title',
		array(
			'label'			=> esc_html__( 'Heading 2', 'sydney' ),
			'section' 		=> 'sydney_section_typography_headings',
		)
	)
);

$wp_customize->add_setting( 'h2_font_size_desktop', array(
	'default'   		=> 38,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h2_font_size_tablet', array(
	'default'   		=> 32,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h2_font_size_mobile', array(
	'default'   		=> 24,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'h2_font_size',
	array(
		'label' 		=> esc_html__( 'Font size', 'sydney' ),
		'section' 		=> 'sydney_section_typography_headings',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'h2_font_size_desktop',
			'size_tablet' 		=> 'h2_font_size_tablet',
			'size_mobile' 		=> 'h2_font_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 12,
			'max'	=> 100,
			'step'  => 1
		)
	)
) );

$wp_customize->add_setting( 'h3_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'h3_title',
		array(
			'label'			=> esc_html__( 'Heading 3', 'sydney' ),
			'section' 		=> 'sydney_section_typography_headings',
		)
	)
);

$wp_customize->add_setting( 'h3_font_size_desktop', array(
	'default'   		=> 32,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h3_font_size_tablet', array(
	'default'   		=> 24,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h3_font_size_mobile', array(
	'default'   		=> 20,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'h3_font_size',
	array(
		'label' 		=> esc_html__( 'Font size', 'sydney' ),
		'section' 		=> 'sydney_section_typography_headings',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'h3_font_size_desktop',
			'size_tablet' 		=> 'h3_font_size_tablet',
			'size_mobile' 		=> 'h3_font_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 12,
			'max'	=> 100,
			'step'  => 1
		)
	)
) );

$wp_customize->add_setting( 'h4_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'h4_title',
		array(
			'label'			=> esc_html__( 'Heading 4', 'sydney' ),
			'section' 		=> 'sydney_section_typography_headings',
		)
	)
);

$wp_customize->add_setting( 'h4_font_size_desktop', array(
	'default'   		=> 24,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h4_font_size_tablet', array(
	'default'   		=> 18,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h4_font_size_mobile', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'h4_font_size',
	array(
		'label' 		=> esc_html__( 'Font size', 'sydney' ),
		'section' 		=> 'sydney_section_typography_headings',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'h4_font_size_desktop',
			'size_tablet' 		=> 'h4_font_size_tablet',
			'size_mobile' 		=> 'h4_font_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 12,
			'max'	=> 100,
			'step'  => 1
		)
	)
) );

$wp_customize->add_setting( 'h5_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'h5_title',
		array(
			'label'			=> esc_html__( 'Heading 5', 'sydney' ),
			'section' 		=> 'sydney_section_typography_headings',
		)
	)
);

$wp_customize->add_setting( 'h5_font_size_desktop', array(
	'default'   		=> 18,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h5_font_size_tablet', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h5_font_size_mobile', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'h5_font_size',
	array(
		'label' 		=> esc_html__( 'Font size', 'sydney' ),
		'section' 		=> 'sydney_section_typography_headings',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'h5_font_size_desktop',
			'size_tablet' 		=> 'h5_font_size_tablet',
			'size_mobile' 		=> 'h5_font_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 12,
			'max'	=> 100,
			'step'  => 1
		)
	)
) );

$wp_customize->add_setting( 'h6_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'h6_title',
		array(
			'label'			=> esc_html__( 'Heading 6', 'sydney' ),
			'section' 		=> 'sydney_section_typography_headings',
		)
	)
);

$wp_customize->add_setting( 'h6_font_size_desktop', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h6_font_size_tablet', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'h6_font_size_mobile', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'h6_font_size',
	array(
		'label' 		=> esc_html__( 'Font size', 'sydney' ),
		'section' 		=> 'sydney_section_typography_headings',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'h6_font_size_desktop',
			'size_tablet' 		=> 'h6_font_size_tablet',
			'size_mobile' 		=> 'h6_font_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 12,
			'max'	=> 100,
			'step'  => 1
		)
	)
) );


/**
 * Body
 */
$wp_customize->add_section(
	'sydney_section_typography_body',
	array(
		'title'      => esc_html__( 'Body', 'sydney'),
		'panel'      => 'sydney_panel_typography',
	)
);

$wp_customize->add_setting( 'sydney_body_font',
	array(
		'default'           => '{"font":"System default","regularweight":"regular","category":"sans-serif"}',
		'sanitize_callback' => 'sydney_google_fonts_sanitize',
		'transport'			=> 'postMessage'
	)
);

$wp_customize->add_control( new Sydney_Typography_Control( $wp_customize, 'sydney_body_font',
	array(
		'section' => 'sydney_section_typography_body',
		'settings' => array (
			'family' => 'sydney_body_font',
		),
		'input_attrs' => array(
			'font_count'    => 'all',
			'orderby'       => 'alpha',
			'disableRegular' => false,
		),
	)
) );

$wp_customize->add_setting( 'body_font_style', array(
	'sanitize_callback' => 'sydney_sanitize_select',
	'default' 			=> 'normal',
) );

$wp_customize->add_control( 'body_font_style', array(
	'type' 		=> 'select',
	'section' 	=> 'sydney_section_typography_body',
	'label' 	=> esc_html__( 'Font style', 'sydney' ),
	'choices' => array(
		'normal' 	=> esc_html__( 'Normal', 'sydney' ),
		'italic' 	=> esc_html__( 'Italic', 'sydney' ),
		'oblique' 	=> esc_html__( 'Oblique', 'sydney' ),
	),
) );

$wp_customize->add_setting( 'body_line_height', array(
	'default'   		=> 1.7,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'sydney_sanitize_text',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'body_line_height',
	array(
		'label' 		=> esc_html__( 'Line height', 'sydney' ),
		'section' 		=> 'sydney_section_typography_body',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'body_line_height',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 5,
			'step'  => 0.01
		)
	)
) );

$wp_customize->add_setting( 'body_letter_spacing', array(
	'default'   		=> 0,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'sydney_sanitize_text',
) );			

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'body_letter_spacing',
	array(
		'label' 		=> esc_html__( 'Letter spacing', 'sydney' ),
		'section' 		=> 'sydney_section_typography_body',
		'is_responsive'	=> 0,
		'settings' 		=> array (
			'size_desktop' 		=> 'body_letter_spacing',
		),
		'input_attrs' => array (
			'min'	=> 0,
			'max'	=> 5,
			'step'  => 0.5
		)
	)
) );

$wp_customize->add_setting( 'body_text_transform',
	array(
		'default' 			=> 'none',
		'sanitize_callback' => 'sydney_sanitize_text',
		'transport'			=> 'postMessage',
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'body_text_transform',
	array(
		'label'   => esc_html__( 'Text transform', 'sydney' ),
		'section' => 'sydney_section_typography_body',
		'choices' => array(
			'none' 			=> '-',
			'capitalize' 	=> 'Aa',
			'lowercase' 	=> 'aa',
			'uppercase' 	=> 'AA',
		)
	)
) );

$wp_customize->add_setting( 'body_text_decoration',
	array(
		'default' 			=> 'none',
		'sanitize_callback' => 'sydney_sanitize_text',
		'transport'			=> 'postMessage',
	)
);
$wp_customize->add_control( new Sydney_Radio_Buttons( $wp_customize, 'body_text_decoration',
	array(
		'label'   => esc_html__( 'Text decoration', 'sydney' ),
		'section' => 'sydney_section_typography_body',
		'choices' => array(
			'none' 			=> '-',
			'underline' 	=> '<div style="text-decoration:underline;">U</div>',
			'line-through' 	=> '<div style="text-decoration:line-through;">S</div>',
		)
	)
) );

$wp_customize->add_setting( 'typography_divider_2',
	array(
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Divider_Control( $wp_customize, 'typography_divider_2',
		array(
			'section' 		=> 'sydney_section_typography_body',
		)
	)
);

$wp_customize->add_setting( 'body_title',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Sydney_Text_Control( $wp_customize, 'body_title',
		array(
			'label'			=> esc_html__( 'Body', 'sydney' ),
			'section' 		=> 'sydney_section_typography_body',
		)
	)
);

$wp_customize->add_setting( 'body_font_size_desktop', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'body_font_size_tablet', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'body_font_size_mobile', array(
	'default'   		=> 16,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Sydney_Responsive_Slider( $wp_customize, 'body_font_size',
	array(
		'label' 		=> esc_html__( 'Font size', 'sydney' ),
		'section' 		=> 'sydney_section_typography_body',
		'is_responsive'	=> 1,
		'settings' 		=> array (
			'size_desktop' 		=> 'body_font_size_desktop',
			'size_tablet' 		=> 'body_font_size_tablet',
			'size_mobile' 		=> 'body_font_size_mobile',
		),
		'input_attrs' => array (
			'min'	=> 10,
			'max'	=> 40,
			'step'  => 1
		)
	)
) );