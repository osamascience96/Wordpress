<?php

/**
 * Starter Register Demos
 */
function sydney_atss_demos_list() {

	$plugins = array();

	if ( ! defined( 'SITEORIGIN_PANELS_VERSION' ) ) {
		$plugins[] = array(
			'name'     => 'Elementor',
			'slug'     => 'elementor',
			'path'     => 'elementor/elementor.php',
			'required' => false,
		);
	}

	if ( ! function_exists( 'wpcf_init' ) ) {
		$plugins[] = array(
			'name'     => 'Sydney Toolbox',
			'slug'     => 'sydney-toolbox',
			'path'     => 'sydney-toolbox/sydney-toolbox.php',
			'required' => false,
		);
	}

	$demos = array(
		'main-free' => array(
			'name'       => esc_html__( 'Main', 'sydney' ),
			'type'       => 'free',
			'categories' => array( 'business', 'portfolio' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sydney-main/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/main-free/thumb.jpg',
			'plugins'    => array_merge(
				array(
					array(
						'name'     => 'WPForms',
						'slug'     => 'wpforms-lite',
						'path'     => 'wpforms-lite/wpforms.php',
						'required' => false
					)
				),
				$plugins
			),
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/main-free/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/main-free/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/main-free/customizer.dat',
			),
		),
		'fashion'     => array(
			'name'       => esc_html__( 'Fashion Shop', 'sydney' ),
			'type'       => 'free',
			'categories' => array( 'ecommerce' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sydney-fashion/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/fashion/thumb.jpg',
			'plugins'    => array_merge(
				array(
					array(
						'name'     => 'WooCommerce',
						'slug'     => 'woocommerce',
						'path'     => 'woocommerce/woocommerce.php',
						'required' => true,
					),
				),
				$plugins
			),
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/fashion/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/fashion/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/fashion/customizer.dat',
			),
		),
		'plumber'     => array(
			'name'       => esc_html__( 'Plumber', 'sydney' ),
			'type'       => 'free',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-plumber/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/plumber/thumb.jpg',
			'plugins'    => array_merge(
				array(
					array(
						'name'     => 'WPForms',
						'slug'     => 'wpforms-lite',
						'path'     => 'wpforms-lite/wpforms.php',
						'required' => false
					)
				),
				$plugins
			),
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/plumber/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/plumber/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/plumber/customizer.dat',
			),
		),
		'main-pro' => array(
			'name'       => esc_html__( 'Agency', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business', 'portfolio' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-main/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/main-pro/thumb.jpg',
			'plugins'    => array_merge(
				array(
					array(
						'name'     => 'WPForms',
						'slug'     => 'wpforms-lite',
						'path'     => 'wpforms-lite/wpforms.php',
						'required' => false
					)
				),
				$plugins
			),
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/main-pro/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/main-pro/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/main-pro/customizer-pro.dat',
			),
		),		
		'construction'   => array(
			'name'       => esc_html__( 'Construction', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/construction/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/construction/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/construction/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/construction/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/construction/customizer.dat',
			),
		),
		'cafe'   => array(
			'name'       => esc_html__( 'Cafe', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/cafe/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/cafe/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/cafe/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/cafe/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/cafe/customizer.dat',
			),
		),				
		'original'   => array(
			'name'       => esc_html__( 'Original', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business', 'portfolio' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sydney-pro/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/original/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/original/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/original/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/original/customizer.dat',
			),
		),
		'finance'    => array(
			'name'       => esc_html__( 'Finance', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-finance/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/finance/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/finance/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/finance/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/finance/customizer.dat',
			),
		),
		'gardening'    => array(
			'name'       => esc_html__( 'Gardening', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/gardening/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/gardening/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/gardening/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/gardening/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/gardening/customizer.dat',
			),
		),
		'leads'    => array(
			'name'       => esc_html__( 'Lead Generation', 'sydney' ),
			'type'       => 'free',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sydney-leads/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/leads/thumb.jpg',
			'plugins'    => array_merge(
				array(
					array(
						'name'     => 'WPForms',
						'slug'     => 'wpforms-lite',
						'path'     => 'wpforms-lite/wpforms.php',
						'required' => false
					),
					array(
						'name'     => 'Hubspot',
						'slug'     => 'leadin',
						'path'     => 'leadin/leadin.php',
						'required' => false
					)					
				),
				$plugins
			),
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/leads/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/leads/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/leads/customizer.dat',
			),
		),			
		'tutor-lms'    => array(
			'name'       => esc_html__( 'eLearning', 'sydney' ),
			'type'       => 'free',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sydney-lms/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/lms/thumb.jpg',
			'plugins'    => array_merge(
				array(
					array(
						'name'     => 'WPForms',
						'slug'     => 'wpforms-lite',
						'path'     => 'wpforms-lite/wpforms.php',
						'required' => false
					),
					array(
						'name'     => 'Tutor',
						'slug'     => 'tutor',
						'path'     => 'tutor/tutor.php',
						'required' => false
					),
					array(
						'name'     => 'Tutor Elementor Addons',
						'slug'     => 'tutor-lms-elementor-addons',
						'path'     => 'tutor-lms-elementor-addons/tutor-lms-elementor-addons.php',
						'required' => false
					)										
				),
				$plugins
			),
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/lms/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/lms/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/lms/customizer.dat',
			),
		),
		'blogpro'   => array(
			'name'       => esc_html__( 'Blog', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'blog' ),
			'preview'    => 'https://demo.athemes.com/sp-blog/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/blogpro/thumb.jpg',
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/blogpro/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/blogpro/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/blogpro/customizer.dat',
			),
		),		
		'podcast'    => array(
			'name'       => esc_html__( 'Podcast', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/podcast/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/podcast/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/podcast/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/podcast/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/podcast/customizer.dat',
			),
		),
		'band'       => array(
			'name'       => esc_html__( 'Band', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'event' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/band/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/band/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/band/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/band/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/band/customizer.dat',
			),
		),
		'restaurant' => array(
			'name'       => esc_html__( 'Restaurant', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business', 'ecommerce' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-restaurant/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/restaurant/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/restaurant/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/restaurant/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/restaurant/customizer.dat',
			),
		),
		'yoga'       => array(
			'name'       => esc_html__( 'Yoga', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-yoga/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/yoga/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/yoga/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/yoga/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/yoga/customizer.dat',
			),
		),
		'business'   => array(
			'name'       => esc_html__( 'Business', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-business/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/business/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/business/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/business/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/business/customizer.dat',
			),
		),
		'coworking'  => array(
			'name'       => esc_html__( 'Coworking', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-coworking/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/coworking/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/coworking/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/coworking/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/coworking/customizer.dat',
			),
		),
		'app'        => array(
			'name'       => esc_html__( 'App', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-app/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/app/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/app/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/app/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/app/customizer.dat',
			),
		),
		'wedding'    => array(
			'name'       => esc_html__( 'Wedding', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'event'),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-wedding/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/wedding/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/wedding/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/wedding/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/wedding/customizer.dat',
			),
		),
		'resume'     => array(
			'name'       => esc_html__( 'Resume', 'sydney' ),
			'type'       => 'pro',
			'categories' => array( 'portfolio' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-resume/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/resume/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/resume/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/resume/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/resume/customizer.dat',
			),
		),
		'saas'       => array(
			'name'       => esc_html__( 'SaaS', 'sydney' ),
			'type'       => 'pro',
			'categories' => array(),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/sp-saas/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/sydney/saas/thumb.jpg',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/sydney/saas/content.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/sydney/saas/widgets.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/sydney/saas/customizer.dat',
			),
		),		
		
	);

	return $demos;
}
add_filter( 'atss_register_demos_list', 'sydney_atss_demos_list' );

/**
 * Define actions that happen after import
 */
function sydney_atss_setup_after_import() {

	// Get demo id
	$demo_id = get_transient( 'atss_importer_demo_id' );

	// Assign the menu.
	$main_menu = get_term_by( 'name', 'Menu 1', 'nav_menu' );
	set_theme_mod(
		'nav_menu_locations',
		array(
			'primary' => $main_menu->term_id,
		)
	);

	// Asign the static front page and the blog page.
	$front_page = get_page_by_title( 'My front page' );
	$blog_page  = get_page_by_title( 'My blog page' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page->ID );
	update_option( 'page_for_posts', $blog_page->ID );

	// Assign the Front Page template.
	update_post_meta( $front_page->ID, '_wp_page_template', 'page-templates/page_front-page.php' );

	atss_import_helper( 'sydney', $demo_id );

	// Delete the transient for demo id
	delete_transient( 'atss_importer_demo_id' );
}
add_action( 'atss_finish_import', 'sydney_atss_setup_after_import' );