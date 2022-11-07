<?php
/**
 * Theme activation.
 *
 * @package Sydney
 */

/**
 * Theme Dashboard [Free VS Pro]
 */
function sydney_free_vs_pro_html() {
	ob_start();
	?>
	<div class="thd-heading"><?php esc_html_e( 'Differences between Sydney and Sydney Pro', 'sydney' ); ?></div>
	<div class="thd-description"><?php esc_html_e( 'Here are some of the differences between Sydney and Sydney Pro:', 'sydney' ); ?></div>

	<table class="thd-table-compare">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Feature', 'sydney' ); ?></th>
				<th><?php esc_html_e( 'Sydney', 'sydney' ); ?></th>
				<th><?php esc_html_e( 'Sydney Pro', 'sydney' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php esc_html_e( 'Access to all Google Fonts', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Responsive', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Sticky and transparent menu', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Multiple blog layouts', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>


			<tr>
				<td><?php esc_html_e( 'Type of starter sites', 'sydney' ); ?></td>
				<td><span class="thd-badge">Free</span></td>
				<td><span class="thd-badge">Premium</span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Starter sites', 'sydney' ); ?></td>
				<td><span class="thd-badge">5</span></td>
				<td><span class="thd-badge">18</span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Templates Module', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-warning"><i class="dashicons dashicons-no-alt"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Extended Header Module', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-warning"><i class="dashicons dashicons-no-alt"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Extended WooCommerce Module', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-warning"><i class="dashicons dashicons-no-alt"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Built-in Wishlist, Product Swatch', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-warning"><i class="dashicons dashicons-no-alt"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>							
			<tr>
				<td><?php esc_html_e( 'Extended Blog Module', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-warning"><i class="dashicons dashicons-no-alt"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>					
			<tr>
				<td><?php esc_html_e( 'Breadcrumbs Module', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-warning"><i class="dashicons dashicons-no-alt"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>		
			<tr>
				<td><?php esc_html_e( 'Extended Footer Module', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-warning"><i class="dashicons dashicons-no-alt"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>									
			<tr>
				<td><?php esc_html_e( 'Footer credits', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>
					
			<tr>
				<td><?php esc_html_e( 'Hooks system', 'sydney' ); ?></td>
				<td><span class="thd-badge thd-badge-warning"><i class="dashicons dashicons-no-alt"></i></span></td>
				<td><span class="thd-badge thd-badge-success"><i class="dashicons dashicons-saved"></i></span></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Custom Elementor widgets', 'sydney' ); ?></td>
				<td><span class="thd-badge">5</span></td>
				<td><span class="thd-badge">16</span></td>
			</tr>
		</tbody>
	</table>

	<div class="thd-separator"></div>

	<h4>
		<a href="https://athemes.com/sydney-upgrade/#see-all-features" target="_blank">
			<?php esc_html_e( 'Full list of differences between Sydney and Sydney Pro', 'sydney' ); ?>
		</a>
	</h4>

	<div class="thd-separator"></div>

	<p>
		<a href="https://athemes.com/sydney-upgrade/?utm_source=theme_table&utm_medium=button&utm_campaign=Sydney" class="thd-button button themetable-button">
			<?php esc_html_e( 'Get Sydney Pro Today', 'sydney' ); ?>
		</a>
	</p>
	<?php
	return ob_get_clean();
}

/**
 * Theme Dashboard Settings
 *
 * @param array $settings The settings.
 */
function sydney_dashboard_settings( $settings ) {

	// Starter.
	$settings['starter_plugin_slug'] = 'athemes-starter-sites';

	// Hero.
	$settings['hero_title']       = esc_html__( 'Welcome to Sydney', 'sydney' );
	$settings['hero_themes_desc'] = esc_html__( 'Sydney is now installed and ready to use. Click on Starter Sites to get off to a flying start with one of our pre-made templates, or go to Theme Dashboard to get an overview of everything.', 'sydney' );
	$settings['hero_desc']        = esc_html__( 'Sydney is now installed and ready to go. To help you with the next step, we\'ve gathered together on this page all the resources you might need. We hope you enjoy using Sydney.', 'sydney' );
	$settings['hero_image']       = get_template_directory_uri() . '/theme-dashboard/images/welcome-banner@2x.png';

	// Tabs.
	$settings['tabs'] = array(
		array(
			'name'    => esc_html__( 'Theme Features', 'sydney' ),
			'type'    => 'features',
			'visible' => array( 'free', 'pro' ),
			'data'    => array(
				array(
					'name'          => esc_html__( 'Change Site Title or Logo', 'sydney' ),
					'type'          => 'free',
					'customize_uri' => admin_url( '/customize.php?autofocus[section]=title_tagline' ),
				),
				array(
					'name'          => esc_html__( 'Header Options', 'sydney' ),
					'type'          => 'free',
					'customize_uri' => admin_url( '/customize.php?autofocus[panel]=sydney_header_panel' ),
				),
				array(
					'name'          => esc_html__( 'Color Options', 'sydney' ),
					'type'          => 'free',
					'customize_uri' => admin_url( '/customize.php?autofocus[section]=colors' ),
				),
				array(
					'name'          => esc_html__( 'Font Options', 'sydney' ),
					'type'          => 'free',
					'customize_uri' => admin_url( '/customize.php?autofocus[panel]=sydney_panel_typography' ),
				),
				array(
					'name'          => esc_html__( 'Blog Options', 'sydney' ),
					'type'          => 'free',
					'customize_uri' => admin_url( '/customize.php?autofocus[panel]=sydney_panel_blog' ),
				),
				array(
					'name'          => esc_html__( 'Footer Credits', 'sydney' ),
					'type'          => 'free',
					'customize_uri' => '/wp-admin/customize.php?autofocus[section]=sydney_section_footer_credits',
				),
				array(
					'name'          => esc_html__( 'Buttons', 'sydney' ),
					'type'          => 'free',
					'customize_uri' => '/wp-admin/customize.php?autofocus[section]=sydney_section_buttons',
				),				
			),
		),
		array(
			'name'    => esc_html__( 'Free vs PRO', 'sydney' ),
			'type'    => 'html',
			'visible' => array( 'free' ),
			'data'    => sydney_free_vs_pro_html(),
		),
		array(
			'name'    => esc_html__( 'Performance', 'sydney' ),
			'type'    => 'performance',
			'visible' => array( 'free', 'pro' ),
		),
	);
	
	//Insert modules
	$settings['tabs'][0]['data'] = array_merge( $settings['tabs'][0]['data'], Sydney_Modules::get_modules() );

	$settings['tabs'][0]['data'] = array_merge( $settings['tabs'][0]['data'], array(
		array(
			'name'          => esc_html__( 'Top bar', 'sydney' ),
			'type'          => 'pro',
			'customize_uri' => '/wp-admin/customize.php?autofocus[section]=sydney_contact_info',
		),
		array(
			'name'          => esc_html__( 'Extra Widget Area', 'sydney' ),
			'type'          => 'pro',
			'customize_uri' => '/wp-admin/customize.php?autofocus[section]=sydney_extra_widget_area',
		),
		array(
			'name'          => esc_html__( 'Google Maps', 'sydney' ),
			'type'          => 'pro',
			'customize_uri' => '/wp-admin/customize.php?autofocus[section]=sydney_pro_maps',
		),
	) );

	// Documentation.
	$settings['documentation_link'] = 'https://docs.athemes.com/category/8-sydney';

	// Promo.
	$settings['promo_title']  = esc_html__( 'Upgrade to Pro', 'sydney' );
	$settings['promo_desc']   = esc_html__( 'Take Sydney to a whole other level by upgrading to the Pro version.', 'sydney' );
	$settings['promo_button'] = esc_html__( 'Discover Sydney Pro', 'sydney' );
	$settings['promo_link']   = 'https://athemes.com/sydney-upgrade/?utm_source=theme_info&utm_medium=link&utm_campaign=Sydney';

	// Review.
	$settings['review_link']       = 'https://wordpress.org/support/theme/sydney/reviews/';
	$settings['suggest_idea_link'] = 'https://athemes.com/feature-request/';

	// Support.
	$settings['support_link']     = 'https://wordpress.org/support/theme/sydney/';
	$settings['support_pro_link'] = 'https://athemes.com/sydney-upgrade/?utm_source=theme_support&utm_medium=link&utm_campaign=Sydney';

	// Community.
	$settings['community_link'] = 'https://www.facebook.com/groups/athemes/';

	$theme = wp_get_theme();
	// Changelog.
	$settings['changelog_version'] = $theme->version;
	$settings['changelog_link']    = 'https://athemes.com/changelog/sydney/';

	return $settings;
}
add_filter( 'thd_register_settings', 'sydney_dashboard_settings' );

/**
 * Starter Settings
 *
 * @param array $settings The settings.
 */
function sydney_demos_settings( $settings ) {

	$settings['categories'] = array(
		'business' 	=> 'Business',
		'portfolio' => 'Portfolio',
		'ecommerce' => 'eCommerce',
		'event' 	=> 'Events',
	);	

	$settings['builders'] = array(
		'elementor' => 'Elementor',
	);		

	// Pro.
	$settings['pro_label'] = esc_html__( 'Get Sydney Pro', 'sydney' );
	$settings['pro_link']  = 'https://athemes.com/sydney-upgrade/?utm_source=theme_table&utm_medium=button&utm_campaign=Sydney';

	return $settings;
}
add_filter( 'atss_register_demos_settings', 'sydney_demos_settings' );
