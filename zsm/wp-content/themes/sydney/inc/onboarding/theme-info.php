<?php
/**
 * Theme info page
 *
 * @package Sydney
 */

/**
 * Recommended plugins
 */
require get_template_directory() . '/inc/onboarding/plugins/class-sydney-recommended-plugins.php'; 

//Add the theme page
add_action('admin_menu', 'sydney_add_theme_info');
function sydney_add_theme_info(){

	if ( !current_user_can('install_plugins') ) {
		return;
	}

	$theme_info = add_theme_page( __('Sydney Info','sydney'), __('Sydney Info','sydney'), 'manage_options', 'sydney-info.php', 'sydney_info_page' );
	add_action( 'load-' . $theme_info, 'sydney_info_hook_styles' );
}

//Callback
function sydney_info_page() {
	$user = wp_get_current_user();
?>
	<div class="info-container">
		<p class="hello-user"><?php echo sprintf( __( 'Hello, %s,', 'sydney' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?></p>
		<h1 class="info-title"><?php echo __( 'Welcome to Sydney', 'sydney' ); ?><span class="info-version"><?php echo 'v' . esc_html( wp_get_theme()->version ); ?></span></h1>
		<p class="welcome-desc"><?php _e( 'Sydney is now installed and ready to go. To help you with the next step, we’ve gathered together on this page all the resources you might need. We hope you enjoy using Sydney. You can always come back to this page by going to <strong>Appearance > Sydney Info</strong>.', 'sydney' ); ?>
	

		<div class="sydney-theme-tabs">

			<div class="sydney-tab-nav nav-tab-wrapper">
				<a href="#begin" data-target="begin" class="nav-button nav-tab begin active"><?php esc_html_e( 'Getting started', 'sydney' ); ?></a>
				<a href="#support" data-target="support" class="nav-button support nav-tab"><?php esc_html_e( 'Support', 'sydney' ); ?></a>
				<a href="#table" data-target="table" class="nav-button table nav-tab"><?php esc_html_e( 'Free vs Pro', 'sydney' ); ?></a>
			</div>

			<div class="sydney-tab-wrapper">

				<div id="#begin" class="sydney-tab begin show">
					
					<div class="plugins-row">
						<h2><span class="step-number">1</span><?php esc_html_e( 'Install recommended plugins', 'sydney' ); ?></h2>
						<p><?php _e( 'Install one plugin at a time. Wait for each plugin to activate.', 'sydney' ); ?></p>

						<div style="margin: 0 -15px;overflow:hidden;display:flex;">
							<div class="plugin-block">
								<?php $plugin = 'sydney-toolbox'; ?>
								<h3>Sydney Toolbox</h3>
								<p><?php esc_html_e( 'Sydney Toolbox is a free addon for the Sydney WordPress theme. It helps with things like demo import and additional Elementor widgets.', 'sydney' ); ?></p>
								<?php echo Sydney_Recommended_Plugins::instance()->get_button_html( $plugin ); ?>
							</div>

							<div class="plugin-block">
								<?php $plugin = 'elementor'; ?>
								<h3>Elementor</h3>
								<p><?php esc_html_e( 'Elementor will enable you to create pages by adding widgets to them using drag and drop.', 'sydney' ); ?>
								<?php 
								//If Elementor is active, show a link to Elementor's getting started video
								$is_elementor_active = Sydney_Recommended_Plugins::instance()->check_plugin_state( $plugin );
								if ( $is_elementor_active == 'deactivate' ) {
									echo '<a target="_blank" href="https://www.youtube.com/watch?v=nZlgNmbC-Cw&feature=emb_title">' . __( 'First time Elementor user?', 'sydney') . '</a>';
								}; ?>
								</p>
								<?php echo Sydney_Recommended_Plugins::instance()->get_button_html( $plugin ); ?>
							</div>

							<div class="plugin-block">
								<?php $plugin = 'one-click-demo-import'; ?>
								<h3>One Click Demo Import</h3>
								<p><?php esc_html_e( 'This plugin is useful for importing our demos. You can uninstall it after you\'re done with it.', 'sydney' ); ?></p>
								<?php echo Sydney_Recommended_Plugins::instance()->get_button_html( $plugin ); ?>
							</div>
						</div>
					</div>
					<hr style="margin-top:25px;margin-bottom:25px;">
					
					<div class="import-row">
						<h2><span class="step-number">2</span><?php esc_html_e( 'Import demo content (optional)', 'sydney' ); ?></h2>
						<p><?php esc_html_e( 'Importing the demo will make your website look like our website.', 'sydney' ); ?></p>
						<?php 
							$plugin = 'sydney-toolbox';
							$is_sydney_toolbox_active = Sydney_Recommended_Plugins::instance()->check_plugin_state( $plugin );
							$plugin = 'elementor';
							$is_elementor_active = Sydney_Recommended_Plugins::instance()->check_plugin_state( $plugin );
							$plugin = 'one-click-demo-import';
							$is_ocdi_active = Sydney_Recommended_Plugins::instance()->check_plugin_state( $plugin );														
						?>
							<?php if ( $is_sydney_toolbox_active == 'deactivate' && $is_elementor_active == 'deactivate' && $is_ocdi_active == 'deactivate' ) : ?>
								<a class="button button-primary button-large" href="<?php echo admin_url( 'themes.php?page=pt-one-click-demo-import.php' ); ?>"><?php esc_html_e( 'Go to the automatic importer', 'sydney' ); ?></a>
							<?php else : ?>
								<p class="sydney-notice"><?php esc_html_e( 'All recommended plugins need to be installed and activated for this step.', 'sydney' ); ?></p>
							<?php endif; ?>
					</div>
					<hr style="margin-top:25px;margin-bottom:25px;">

					<div class="customizer-row">
						<h2><span class="step-number">3</span><?php esc_html_e( 'Styling with the Customizer', 'sydney' ); ?></h2>
						<p><?php esc_html_e( 'Theme elements can be styled from the Customizer. Use the links below to go straight to the section you want.', 'sydney' ); ?></p>		
						<p><a target="_blank" href="<?php echo esc_url( admin_url( '/customize.php?autofocus[section]=title_tagline' ) ); ?>"><?php esc_html_e( 'Change your site title or add a logo', 'sydney' ); ?></a></p>
						<p><a target="_blank" href="<?php echo esc_url( admin_url( '/customize.php?autofocus[panel]=sydney_header_panel' ) ); ?>"><?php esc_html_e( 'Header options', 'sydney' ); ?></a></p>
						<p><a target="_blank" href="<?php echo esc_url( admin_url( '/customize.php?autofocus[panel]=sydney_colors_panel' ) ); ?>"><?php esc_html_e( 'Color options', 'sydney' ); ?></a></p>
						<p><a target="_blank" href="<?php echo esc_url( admin_url( '/customize.php?autofocus[section]=sydney_fonts' ) ); ?>"><?php esc_html_e( 'Font options', 'sydney' ); ?></a></p>
						<p><a target="_blank" href="<?php echo esc_url( admin_url( '/customize.php?autofocus[section]=blog_options' ) ); ?>"><?php esc_html_e( 'Blog options', 'sydney' ); ?></a></p>		
					</div>


				</div>

				<div id="#support" class="sydney-tab support">
					<div class="column-wrapper">
						<div class="tab-column">
						<span class="dashicons dashicons-sos"></span>
						<h3><?php esc_html_e( 'Visit our forums', 'sydney' ); ?></h3>
						<p><?php esc_html_e( 'Need help? Go ahead and visit our support forums and we\'ll be happy to assist you with any theme related questions you might have', 'sydney' ); ?></p>
							<a href="https://wordpress.org/support/theme/sydney/" target="_blank"><?php esc_html_e( 'Visit the forums', 'sydney' ); ?></a>				
							</div>
						<div class="tab-column">
						<span class="dashicons dashicons-book-alt"></span>
						<h3><?php esc_html_e( 'Documentation', 'sydney' ); ?></h3>
						<p><?php esc_html_e( 'Our documentation can help you learn how to use the theme and also provides you with premade code snippets and answers to FAQs.', 'sydney' ); ?></p>
						<a href="https://docs.athemes.com/category/8-sydney" target="_blank"><?php esc_html_e( 'See the Documentation', 'sydney' ); ?></a>
						</div>
					</div>
				</div>
				<div id="#table" class="sydney-tab table">
				<table class="widefat fixed featuresList"> 
				   <thead> 
					<tr> 
					 <td><strong><h3><?php esc_html_e( 'Feature', 'sydney' ); ?></h3></strong></td>
					 <td style="width:20%;"><strong><h3><?php esc_html_e( 'Sydney', 'sydney' ); ?></h3></strong></td>
					 <td style="width:20%;"><strong><h3><?php esc_html_e( 'Sydney Pro', 'sydney' ); ?></h3></strong></td>
					</tr> 
				   </thead> 
				   <tbody> 
					<tr> 
					 <td><?php esc_html_e( 'Access to all Google Fonts', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Responsive', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Parallax backgrounds', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Social Icons', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Slider, image or video header', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Front Page Blocks', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Translation ready', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Polylang integration', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Color options', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Blog options', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Widgetized footer', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Background image support', 'sydney' ); ?></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Footer Credits option', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Extra widgets (timeline, latest news in carousel, pricing tables, a new employees widget and a new contact widget)', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Extra Customizer Options (Front Page Section Titles, Single Employees, Single Projects, Header Contact Info, Buttons)', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Header support for Crelly Slider', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Header support for shortcodes', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Single Post/Page Options', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'WooCommerce compatible', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( '5 Extra Page Templates (Contact, Featured Header - Default, Featured Header - Wide, No Header - Default, No Header - Wide)', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
					<tr> 
					 <td><?php esc_html_e( 'Priority support', 'sydney' ); ?></td>
					 <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
					 <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
					</tr> 
				   </tbody> 
				  </table>
				  <p style="text-align: right;"><a class="button button-primary button-large" href="https://athemes.com/theme/sydney-pro/?utm_source=theme_table&utm_medium=button&utm_campaign=Sydney"><?php esc_html_e('View Sydney Pro', 'sydney'); ?></a></p>
				</div>		
			</div>
		</div>

		<div class="sydney-theme-sidebar">
			<div class="sydney-sidebar-widget">
				<h3>Review Sydney</h3>
				<p><?php echo esc_html__( 'It makes us happy to hear from our users. We would appreciate a review.', 'sydney' ); ?> </p>	
				<p><a target="_blank" href="https://wordpress.org/support/theme/sydney/reviews/"><?php echo esc_html__( 'Submit a review here', 'sydney' ); ?></a></p>		
			</div>
			<hr style="margin-top:25px;margin-bottom:25px;">
			<div class="sydney-sidebar-widget">
				<h3>Changelog</h3>
				<p><?php echo esc_html__( 'Keep informed about each theme update.', 'sydney' ); ?> </p>	
				<p><a target="_blank" href="https://athemes.com/changelog/sydney"><?php echo esc_html__( 'See the changelog', 'sydney' ); ?></a></p>		
			</div>	
			<hr style="margin-top:25px;margin-bottom:25px;">
			<div class="sydney-sidebar-widget">
				<h3>Upgrade to Sydney Pro</h3>
				<p><?php echo esc_html__( 'Take Sydney to a whole other level by upgrading to the Pro version.', 'sydney' ); ?> </p>	
				<p><a target="_blank" href="https://athemes.com/theme/sydney-pro/?utm_source=theme_info&utm_medium=link&utm_campaign=Sydney"><?php echo esc_html__( 'Discover Sydney Pro', 'sydney' ); ?></a></p>		
			</div>									
		</div>
	</div>
<?php
}

//Styles
function sydney_info_hook_styles(){
	add_action( 'admin_enqueue_scripts', 'sydney_info_page_styles' );
}
function sydney_info_page_styles() {
	wp_enqueue_style( 'sydney-info-style', get_template_directory_uri() . '/inc/onboarding/assets/info-page.css', array(), true );

	wp_enqueue_script( 'sydney-info-script', get_template_directory_uri() . '/inc/onboarding/assets/info-page.js', array('jquery'),'', true );

	wp_enqueue_script( 'plugin-install' );
	wp_enqueue_script( 'updates' );	

}