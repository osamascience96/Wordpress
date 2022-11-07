<?php

/**
 * This file registers the Projects custom post type
 *
 * @package    	Sydney_Toolbox
 * @link        https://athemes.com
 * Author:      aThemes
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

$st_enable = get_option( 'sydney_toolbox_enable_portfolio', 0 );

if ( ! $st_enable ) {
	return;
}

if ( ! function_exists('sydney_register_projects_post_type') ) {

	// Register Custom Post Type
	function sydney_register_projects_post_type() {

		$slug = get_option( 'sydney_ele_projects_rewrite_slug', 'portfolio' );
	
		$labels = array(
			'name'                  => _x( 'Portfolio', 'Post Type General Name', 'sydney-toolbox' ),
			'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'sydney-toolbox' ),
			'menu_name'             => __( 'Portfolio', 'sydney-toolbox' ),
			'name_admin_bar'        => __( 'Projects', 'sydney-toolbox' ),
			'archives'              => __( 'Item Archives', 'sydney-toolbox' ),
			'attributes'            => __( 'Item Attributes', 'sydney-toolbox' ),
			'parent_item_colon'     => __( 'Parent Item:', 'sydney-toolbox' ),
			'all_items'             => __( 'All Projects', 'sydney-toolbox' ),
			'add_new_item'          => __( 'Add New Project', 'sydney-toolbox' ),
			'add_new'               => __( 'Add New', 'sydney-toolbox' ),
			'new_item'              => __( 'New Project', 'sydney-toolbox' ),
			'edit_item'             => __( 'Edit Project', 'sydney-toolbox' ),
			'update_item'           => __( 'Update Project', 'sydney-toolbox' ),
			'view_item'             => __( 'View Item', 'sydney-toolbox' ),
			'view_items'            => __( 'View Items', 'sydney-toolbox' ),
			'search_items'          => __( 'Search Item', 'sydney-toolbox' ),
			'not_found'             => __( 'Not found', 'sydney-toolbox' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'sydney-toolbox' ),
			'featured_image'        => __( 'Featured Image', 'sydney-toolbox' ),
			'set_featured_image'    => __( 'Set featured image', 'sydney-toolbox' ),
			'remove_featured_image' => __( 'Remove featured image', 'sydney-toolbox' ),
			'use_featured_image'    => __( 'Use as featured image', 'sydney-toolbox' ),
			'insert_into_item'      => __( 'Insert into item', 'sydney-toolbox' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'sydney-toolbox' ),
			'items_list'            => __( 'Items list', 'sydney-toolbox' ),
			'items_list_navigation' => __( 'Items list navigation', 'sydney-toolbox' ),
			'filter_items_list'     => __( 'Filter items list', 'sydney-toolbox' ),
		);
		$rewrite = array(
			'slug'                  => $slug,
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Project', 'sydney-toolbox' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'            => array( 'project_cats' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 55,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'menu_icon'             => ST_URI . '/img/logo.svg',
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);
		register_post_type( 'sydney-projects', $args );
	
	}
	add_action( 'init', 'sydney_register_projects_post_type', 0 );
	
	}


// Register Custom Taxonomy
function sydney_register_projects_cats() {

	$slug = get_option( 'sydney_ele_project_cats_rewrite_slug', 'portfolio-cat' );

	$labels = array(
		'name'                       => _x( 'Portfolio categories', 'Taxonomy General Name', 'sydney-toolbox' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sydney-toolbox' ),
		'menu_name'                  => __( 'Portfolio Categories', 'sydney-toolbox' ),
		'all_items'                  => __( 'All Categories', 'sydney-toolbox' ),
		'parent_item'                => __( 'Parent Item', 'sydney-toolbox' ),
		'parent_item_colon'          => __( 'Parent Item:', 'sydney-toolbox' ),
		'new_item_name'              => __( 'New Item Name', 'sydney-toolbox' ),
		'add_new_item'               => __( 'Add New Item', 'sydney-toolbox' ),
		'edit_item'                  => __( 'Edit Item', 'sydney-toolbox' ),
		'update_item'                => __( 'Update Item', 'sydney-toolbox' ),
		'view_item'                  => __( 'View Item', 'sydney-toolbox' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'sydney-toolbox' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'sydney-toolbox' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sydney-toolbox' ),
		'popular_items'              => __( 'Popular Items', 'sydney-toolbox' ),
		'search_items'               => __( 'Search Items', 'sydney-toolbox' ),
		'not_found'                  => __( 'Not Found', 'sydney-toolbox' ),
		'no_terms'                   => __( 'No items', 'sydney-toolbox' ),
		'items_list'                 => __( 'Items list', 'sydney-toolbox' ),
		'items_list_navigation'      => __( 'Items list navigation', 'sydney-toolbox' ),
	);
	$rewrite = array(
		'slug'                       => $slug,
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'project_cats', array( 'sydney-projects' ), $args );

}
add_action( 'init', 'sydney_register_projects_cats', 0 );	