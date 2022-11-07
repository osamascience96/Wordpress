<?php

/**
 * Starter Register Demos
 */
function airi_demos_list() {

	$plugins = array();

	$plugins[] = array(
		'name'     => 'Elementor',
		'slug'     => 'elementor',
		'path'     => 'elementor/elementor.php',
		'required' => true,
	);

	$plugins[] = array(
		'name'     => 'Kirki',
		'slug'     => 'kirki',
		'path'     => 'kirki/kirki.php',
		'required' => true,
	);

	$plugins[] = array(
		'name'     => 'WPForms',
		'slug'     => 'wpforms-lite',
		'path'     => 'wpforms-lite/wpforms.php',
		'required' => false
	);

	$plugins[] = array(
		'name'     => 'MailChimp for WordPress',
		'slug'     => 'mailchimp-for-wp',
		'path'     => 'mailchimp-for-wp/mailchimp-for-wp.php',
		'required' => false,
	);

	$demos = array(
		'agency'      => array(
			'name'       => esc_html__( 'Agency', 'airi' ),
			'type'       => 'free',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-agency/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/airi/agency/thumb.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/airi/agency/airi-dc-agency.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/airi/agency/airi-w-agency.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/airi/agency/airi-c-agency.dat',
			),
		),
		'startup'     => array(
			'name'       => esc_html__( 'Startup', 'airi' ),
			'type'       => 'free',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-startup/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/airi/startup/thumb.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/airi/startup/airi-dc-startup.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/airi/startup/airi-w-startup.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/airi/startup/airi-c-startup.dat',
			),
		),
		'business2'   => array(
			'name'       => esc_html__( 'Business2', 'airi' ),
			'type'       => 'free',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-business2/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/airi/business2/thumb.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/airi/business2/airi-dc-business2.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/airi/business2/airi-w-business2.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/airi/business2/airi-c-business2.dat',
			),
		),
		'health'      => array(
			'name'       => esc_html__( 'Health', 'airi' ),
			'type'       => 'free',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-health-coach/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/airi/health/thumb.png',
			'plugins'    => array_merge(
				array(
					array(
						'name'     => 'LearnPress',
						'slug'     => 'learnpress',
						'path'     => 'learnpress/learnpress.php',
						'required' => true
					),
				),
				$plugins
			),
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/airi/health/airi-dc-health.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/airi/health/airi-w-health.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/airi/health/airi-c-health.dat',
			),
		),
		'lawyer'      => array(
			'name'       => esc_html__( 'Lawyer', 'airi' ),
			'type'       => 'free',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-lawyer/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/airi/lawyer/thumb.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/airi/lawyer/airi-dc-lawyer.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/airi/lawyer/airi-w-lawyer.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/airi/lawyer/airi-c-lawyer.dat',
			),
		),
		'photography' => array(
			'name'       => esc_html__( 'Photography', 'airi' ),
			'type'       => 'free',
			'categories' => array( 'portfolio' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-photography/',
			'thumbnail'  => 'https://athemes.com/themes-demo-content/airi/photography/thumb.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/airi/photography/airi-dc-photography.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/airi/photography/airi-w-photography.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/airi/photography/airi-c-photography.dat',
			),
		),
		'band'        => array(
			'name'       => esc_html__( 'Band', 'airi' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-band/',
			'thumbnail'  => 'https://athemes.com/wp-content/uploads/band-hero-demo.png',
			'plugins'    => array_merge(
				array(
					array(
						'name'     => 'The Events Calendar',
						'slug'     => 'the-events-calendar',
						'path'     => 'the-events-calendar/the-events-calendar.php',
						'required' => true
					),
				),
				$plugins
			),
			'import'     => array(
				'content'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-dc-band.xml',
				'widgets'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-w-band.wie',
				'customizer' => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-c-band.dat',
			),
		),
		'beauty'      => array(
			'name'       => esc_html__( 'Beauty', 'airi' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-beauty/',
			'thumbnail'  => 'https://athemes.com/wp-content/uploads/beauty-hero-demo.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-dc-beauty.xml',
				'widgets'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-w-beauty.wie',
				'customizer' => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-c-beauty.dat',
			),
		),
		'business'    => array(
			'name'       => esc_html__( 'Business', 'airi' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-business/',
			'thumbnail'  => 'https://athemes.com/wp-content/uploads/business-hero-demo.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-dc-business.xml',
				'widgets'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-w-business.wie',
				'customizer' => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-c-business.dat',
			),
		),
		'logistics'   => array(
			'name'       => esc_html__( 'Logistics', 'airi' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-logistics/',
			'thumbnail'  => 'https://athemes.com/wp-content/uploads/logistics-hero-demo.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-dc-logistics.xml',
				'widgets'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-w-logistics.wie',
				'customizer' => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-c-logistics.dat',
			),
		),
		'portfolio'   => array(
			'name'       => esc_html__( 'Portfolio', 'airi' ),
			'type'       => 'pro',
			'categories' => array( 'portfolio' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-portfolio/',
			'thumbnail'  => 'https://athemes.com/wp-content/uploads/portfolio-hero-demo.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-dc-portfolio.xml',
				'widgets'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-w-portfolio.wie',
				'customizer' => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-c-portfolio.dat',
			),
		),
		'restaurant'  => array(
			'name'       => esc_html__( 'Restaurant', 'airi' ),
			'type'       => 'pro',
			'categories' => array( 'ecommerce' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-restaurant/',
			'thumbnail'  => 'https://athemes.com/wp-content/uploads/restaurant-hero-demo.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-dc-restaurant.xml',
				'widgets'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-w-restaurant.wie',
				'customizer' => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-c-restaurant.dat',
			),
		),
		'shop'        => array(
			'name'       => esc_html__( 'Shop', 'airi' ),
			'type'       => 'pro',
			'categories' => array( 'ecommerce' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-shop/',
			'thumbnail'  => 'https://athemes.com/wp-content/uploads/shop-hero-demo.png',
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
				'content'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-dc-shop.xml',
				'widgets'    => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-w-shop.wie',
				'customizer' => 'https://athemes.com/wp-content/uploads/demo-content/airi/airi-c-shop.dat',
			),
		),
		'yoga'        => array(
			'name'       => esc_html__( 'Yoga', 'airi' ),
			'type'       => 'pro',
			'categories' => array( 'business' ),
			'builders'   => array(
				'elementor',
			),
			'preview'    => 'https://demo.athemes.com/airi-yoga/',
			'thumbnail'  => 'https://athemes.com/wp-content/uploads/yoga-hero-demo.png',
			'plugins'    => $plugins,
			'import'     => array(
				'content'    => 'https://athemes.com/themes-demo-content/airi/yoga/airi-dc-yoga.xml',
				'widgets'    => 'https://athemes.com/themes-demo-content/airi/yoga/airi-w-yoga.wie',
				'customizer' => 'https://athemes.com/themes-demo-content/airi/yoga/airi-c-yoga.dat',
			),
		),
	);

	return $demos;
}
add_filter( 'atss_register_demos_list', 'airi_demos_list' );

/**
 * Define actions that happen after import
 */
function airi_setup_after_import() {
	
	// Get demo id
	$demo_id = get_transient( 'atss_importer_demo_id' );

	// Assign the menu.
	$main_menu = get_term_by( 'name', 'Menu', 'nav_menu' );
	set_theme_mod(
		'nav_menu_locations',
		array(
			'primary' => $main_menu->term_id,
		)
	);

	// Assign social menu to widgets
	$social_menu = get_term_by( 'name', 'Social', 'nav_menu' );
	if( $social_menu ) {
		$social_widget = get_option( 'widget_athemes_social_widget' );
		foreach( $social_widget as $key => $widget ) {
			if( $key != '_multiwidget' ) {
				if( in_array( $social_widget[ $key ]['title'], array( 'Follow Us', 'Follow us', '' ) ) ) {
					$social_widget[ $key ]['nav_menu'] = $social_menu->term_id;
					update_option( 'widget_athemes_social_widget', $social_widget );
				}
			}
		}
	}

	// "Quick Links" menu (menu name from import)
	$quick_links_menu = get_term_by( 'name', 'Quick links', 'nav_menu' );
	if( $quick_links_menu ) {
		$nav_menu_widget  = get_option( 'widget_nav_menu' );
		foreach( $nav_menu_widget as $key => $widget ) {
			if( $key != '_multiwidget' ) {
				if( in_array( $nav_menu_widget[ $key ]['title'], array( 'Quick Links', 'Quick links', '' ) ) ) {
					$nav_menu_widget[ $key ]['nav_menu'] = $quick_links_menu->term_id;
					update_option( 'widget_nav_menu', $nav_menu_widget );
				}
			}
		}
	}

	// "Footer" menu (menu name from import)
	$footer_menu     = get_term_by( 'name', 'Footer', 'nav_menu' );
	if( $footer_menu ) {
		$nav_menu_widget = get_option( 'widget_nav_menu' );
		foreach( $nav_menu_widget as $key => $widget ) {
			if( $key != '_multiwidget' ) {
				if( in_array( $nav_menu_widget[ $key ]['title'], array( 'Quick Links', 'Quick links', '' ) ) ) {
					$nav_menu_widget[ $key ]['nav_menu'] = $footer_menu->term_id;
					update_option( 'widget_nav_menu', $nav_menu_widget );
				}
			}
		}
	}

	// "Footer 1" menu (menu name from import)
	$footer_menu_one = get_term_by( 'name', 'Footer 1', 'nav_menu' );
	if( $footer_menu_one ) {
		$nav_menu_widget = get_option( 'widget_nav_menu' );
		foreach( $nav_menu_widget as $key => $widget ) {
			if( $key != '_multiwidget' ) {
				if( in_array( $nav_menu_widget[ $key ]['title'], array( 'About Us' ) ) ) {
					$nav_menu_widget[ $key ]['nav_menu'] = $footer_menu_one->term_id;
					update_option( 'widget_nav_menu', $nav_menu_widget );
				}
			}
		}
	}

	// "Footer 2" menu (menu name from import)
	$footer_menu_two = get_term_by( 'name', 'Footer 2', 'nav_menu' );
	if( $footer_menu_two ) {
		$nav_menu_widget = get_option( 'widget_nav_menu' );
		foreach( $nav_menu_widget as $key => $widget ) {
			if( $key != '_multiwidget' ) {
				if( in_array( $nav_menu_widget[ $key ]['title'], array( 'Services' ) ) ) {
					$nav_menu_widget[ $key ]['nav_menu'] = $footer_menu_two->term_id;
					update_option( 'widget_nav_menu', $nav_menu_widget );
				}
			}
		}
	}

	// Handle widget nav menus in specific demos
	if( $demo_id == 'lawyer' ) {
		$nav_menu_widget = get_option( 'widget_nav_menu' );
		foreach( $nav_menu_widget as $key => $widget ) {
			if( $key != '_multiwidget' ) {
				if( in_array( $nav_menu_widget[ $key ]['title'], array( 'Services', 'About Us' ) ) ) {
					$nav_menu_widget[ $key ]['nav_menu'] = $main_menu->term_id;
					update_option( 'widget_nav_menu', $nav_menu_widget );
				}
			}
		}
	}

	// Asign the static front page and the blog page.
	$front_page = get_page_by_title( 'Home' );
	$blog_page  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page->ID );
	update_option( 'page_for_posts', $blog_page->ID );

	// Assign the Front Page template.
	update_post_meta( $front_page->ID, '_wp_page_template', 'page-templates/template_page-builder.php' );

	atss_import_helper( 'airi', $demo_id );

	// Delete the transient for demo id
	delete_transient( 'atss_importer_demo_id' );
}
add_action( 'atss_finish_import', 'airi_setup_after_import' );