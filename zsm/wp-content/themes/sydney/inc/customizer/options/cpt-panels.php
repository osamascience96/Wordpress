<?php
/**
 * Register panels and sections for all public CPTs
 *
 * @package Sydney
 */

//Get post types
$args       = array(
	'public' => true,
);
$post_types = get_post_types( $args, 'objects' );

//Remove unwanted post types
$unset_types = array(
	'page',
	'post',
	'product',
	'attachment',
	'e-landing-page',
	'elementor_library',
	'athemes_hf',
);

foreach ( $unset_types as $type ) {
	unset( $post_types[ $type ] );
}

//Register panels and sections
foreach ( $post_types as $post_type ) {

	//Panel
	$wp_customize->add_panel(
		'sydney_panel_cpt_' . $post_type->name,
		array(
			'title'     => $post_type->label,
			'priority'  => 50,
		)
	);

	//Singles section
	$wp_customize->add_section(
		'sydney_cpt_' . $post_type->name,
		array(
			'title'     => __( 'Singles', 'sydney' ),
			'panel'     => 'sydney_panel_cpt_' . $post_type->name,
		)
	);

	//Archives section
	$wp_customize->add_section(
		'sydney_cpt_' . $post_type->name . '_archives',
		array(
			'title'     => __( 'Archives', 'sydney' ),
			'panel'     => 'sydney_panel_cpt_' . $post_type->name,
		)
	);
}