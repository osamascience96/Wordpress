<?php
/**
 * Premium modules
 *
 * @package Sydney
 */

if ( ! class_exists( 'Sydney_Modules' ) ) {
	/**
	 * Get a svg icon
	 */
	class Sydney_Modules {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'activate_modules' ) );
		}		

		/**
		 * All modules registered in Sydney
		 */
		public static function get_modules() {
			$modules = array(
				array(
					'slug'			=> 'templates',
					'name'          => esc_html__( 'Templates Module', 'sydney' ),
					'type'          => 'pro',
					'link' 			=> 'http://',
					'link_label'	=> esc_html__( 'Build templates', 'sydney' ),
					'activate_uri' 	=> '&amp;activate_module_templates', //param is added in dashboard class
					'text'			=> __( 'Build headers, footers etc. with Elementor.', 'sydney' ) . '<div><a target="_blank" href="https://docs.athemes.com/article/435-templates-system-overview">' . __( 'Documentation article', 'sydney' ) . '</a></div>',
				),		
				array(
					'slug'			=> 'ext-header',
					'name'          => esc_html__( 'Extended Header Module', 'sydney' ),
					'type'          => 'pro',
					'link' 			=> admin_url( '/customize.php?autofocus[panel]=sydney_panel_header' ),
					'link_label'	=> esc_html__( 'Customize', 'sydney' ),
					'activate_uri' 	=> '&amp;activate_module_ext-header', //param is added in dashboard class
					'text'			=> __( 'New features for your header area.', 'sydney' ) . '<div><a target="_blank" href="https://docs.athemes.com/article/436-pro-extended-header-module">' . __( 'Documentation article', 'sydney' ) . '</a></div>',
				),	
				array(
					'slug'			=> 'ext-woocommerce',
					'name'          => esc_html__( 'Extended WooCommerce', 'sydney' ),
					'type'          => 'pro',
					'link' 			=> admin_url( '/customize.php?autofocus[panel]=woocommerce' ),
					'link_label'	=> esc_html__( 'Customize', 'sydney' ),
					'activate_uri' 	=> '&amp;activate_module_ext-woocommerce', //param is added in dashboard class
					'text'			=> __( 'Extra features for WooCommerce', 'sydney' ) . '<div><a target="_blank" href="https://docs.athemes.com/article/444-pro-extended-woocommerce-module">' . __( 'Documentation article', 'sydney' ) . '</a></div>',
				),				
				array(
					'slug'			=> 'ext-blog',
					'name'          => esc_html__( 'Extended Blog Module', 'sydney' ),
					'type'          => 'pro',
					'link' 			=> admin_url( '/customize.php?autofocus[panel]=sydney_panel_blog' ),
					'link_label'	=> esc_html__( 'Customize', 'sydney' ),
					'activate_uri' 	=> '&amp;activate_module_ext-blog', //param is added in dashboard class
					'text'			=> __( 'Extra features for your blog.', 'sydney' ) . '<div><a target="_blank" href="https://docs.athemes.com/article/438-pro-extended-blog-module">' . __( 'Documentation article', 'sydney' ) . '</a></div>',
				),		
				array(
					'slug'			=> 'breadcrumbs',
					'name'          => esc_html__( 'Breadcrumbs Module', 'sydney' ),
					'type'          => 'pro',
					'link' 			=> admin_url( '/customize.php?autofocus[section]=sydney_breadcrumbs' ),
					'link_label'	=> esc_html__( 'Customize', 'sydney' ),
					'activate_uri' 	=> '&amp;activate_module_breadcrumbs', //param is added in dashboard class
					'text'			=> __( 'Breadcrumbs functionality.', 'sydney' ) . '<div><a target="_blank" href="https://docs.athemes.com/article/440-pro-breadcrumbs">' . __( 'Documentation article', 'sydney' ) . '</a></div>',
				),	
				array(
					'slug'			=> 'ext-footer',
					'name'          => esc_html__( 'Extended Footer Module', 'sydney' ),
					'type'          => 'pro',
					'link' 			=> admin_url( '/customize.php?autofocus[panel]=sydney_panel_footer' ),
					'link_label'	=> esc_html__( 'Customize', 'sydney' ),
					'activate_uri' 	=> '&amp;activate_module_ext-footer', //param is added in dashboard class
					'text'			=> __( 'Extra features for your footer', 'sydney' ) . '<div><a target="_blank" href="https://docs.athemes.com/article/442-pro-extended-footer-module">' . __( 'Documentation article', 'sydney' ) . '</a></div>',
				),		
				array(
					'slug'			=> 'quick-links',
					'name'          => esc_html__( 'Quick Links Module', 'sydney' ),
					'type'          => 'pro',
					'link' 			=> admin_url( '/customize.php?autofocus[section]=sydney_quicklinks' ),
					'link_label'	=> esc_html__( 'Customize', 'sydney' ),
					'activate_uri' 	=> '&amp;activate_module_quick-links', //param is added in dashboard class
					'text'			=> __( 'Floating quick links bar (contact, social etc.)', 'sydney' ) . '<div><a target="_blank" href="https://docs.athemes.com/article/443-pro-quick-links-module">' . __( 'Documentation article', 'sydney' ) . '</a></div>',
				),															
			);
		
			return $modules;
		}

		/**
		 * Check if a specific module is activated
		 */
		public static function is_module_active( $module ) {

			$all_modules = get_option( 'sydney-modules' );
			$all_modules = ( is_array( $all_modules ) ) ? $all_modules : (array) $all_modules;

			if ( array_key_exists( $module, $all_modules ) && true === $all_modules[$module] ) {
				return true;
			}
		
			return false;
		}

		/**
		 * Activate modules on click
		 */
		public function activate_modules() {
			$modules = $this->get_modules();

			$all_modules = get_option( 'sydney-modules' );
			$all_modules = ( is_array( $all_modules ) ) ? $all_modules : (array) $all_modules;

			foreach ( $modules as $module ) {
				if ( isset( $_GET['activate_module_' . $module['slug'] ] ) ) {
					if ( '1' == $_GET['activate_module_' . $module['slug'] ] ) {
						update_option( 'sydney-modules', array_merge( $all_modules, array( $module['slug'] => true ) ) );
					} elseif ( '0' == $_GET['activate_module_' . $module['slug'] ] ) {
						update_option( 'sydney-modules', array_merge( $all_modules, array( $module['slug'] => false ) ) );
					}
				}
			}
		}
	}	
}

new Sydney_Modules();