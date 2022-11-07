<?php
/**
 *
 * @link              http://athemes.com
 * @since             1.0
 * @package           Sydney_Toolbox
 *
 * @wordpress-plugin
 * Plugin Name:       Sydney Toolbox
 * Plugin URI:        http://athemes.com/plugins/sydney-toolbox
 * Description:       Registers custom post types and custom fields for the Sydney theme
 * Version:           1.23
 * Author:            aThemes
 * Author URI:        http://athemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sydney-toolbox
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Set up and initialize
 */
class Sydney_Toolbox {

	private static $instance;

	/**
	 * Actions setup
	 */
	public function __construct() {

		$theme  = wp_get_theme();
		$parent = wp_get_theme()->parent();
		if ( ( $theme != 'Sydney' ) && ($theme != 'Sydney Pro' ) && ($parent != 'Sydney') && ($parent != 'Sydney Pro') ) {
			return;
		}

		add_action( 'plugins_loaded', array( $this, 'constants' ), 2 );
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 3 );
		add_action( 'plugins_loaded', array( $this, 'includes' ), 4 );
		add_action( 'admin_notices', array( $this, 'admin_notice' ), 4 );

		add_action( 'wp', array( $this, 'single_projects' ) );

		//SVG styles
		add_action( 'wp_head', array( $this, 'svg_styles' ) );

		//Remove archive labels for portfolio
		add_filter( 'get_the_archive_title', array( $this, 'remove_archive_labels' ) );
		add_filter( 'post_class', array( $this, 'post_classes' ) );
		
		//Elementor actions
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'elementor_includes' ), 4 );
		add_action( 'elementor/init', array( $this, 'elementor_category' ), 4 );
		add_action( 'elementor/init', array( $this, 'elementor_skins' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'scripts' ) );
		add_action( 'init', array( $this, 'flush_permalinks' ) );
	}

	/**
	 * Constants
	 */
	function constants() {

		define( 'ST_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'ST_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
	}

	/**
	 * Includes
	 */
	function includes() {

		if ( did_action( 'elementor/loaded' ) ) {
			require_once( ST_DIR . 'inc/post-type-sydney-projects.php' );
			require_once( ST_DIR . 'inc/customizer/portfolio.php' );
		}

		if ( defined( 'SITEORIGIN_PANELS_VERSION' ) ) {
			//Post types
			require_once( ST_DIR . 'inc/post-type-services.php' );
			require_once( ST_DIR . 'inc/post-type-employees.php' );
			require_once( ST_DIR . 'inc/post-type-testimonials.php' );	
			require_once( ST_DIR . 'inc/post-type-clients.php' );
			require_once( ST_DIR . 'inc/post-type-projects.php' );
			require_once( ST_DIR . 'inc/post-type-timeline.php' );		
			//Metaboxes
			require_once( ST_DIR . 'inc/metaboxes/services-metabox.php' );	
			require_once( ST_DIR . 'inc/metaboxes/employees-metabox.php' );	
			require_once( ST_DIR . 'inc/metaboxes/testimonials-metabox.php' );
			require_once( ST_DIR . 'inc/metaboxes/clients-metabox.php' );
			require_once( ST_DIR . 'inc/metaboxes/projects-metabox.php' );
			require_once( ST_DIR . 'inc/metaboxes/timeline-metabox.php' );
			require_once( ST_DIR . 'inc/metaboxes/singles-metabox.php' );
		}

		/**
		 * Demo content setup
		 * 
		 * @since 1.07
		 */
		if ( !$this->is_pro() ) {
			require_once( ST_DIR . 'demo-content/setup.php' );
		}
	}

	function elementor_includes() {
		if ( !version_compare(PHP_VERSION, '5.4', '<=') ) {
			require_once( ST_DIR . 'inc/elementor/block-testimonials.php' );
			require_once( ST_DIR . 'inc/elementor/block-posts.php' );
			require_once( ST_DIR . 'inc/elementor/block-portfolio.php' );
			require_once( ST_DIR . 'inc/elementor/block-gallery.php' );
			require_once( ST_DIR . 'inc/elementor/block-employee-carousel.php' );	
			require_once( ST_DIR . 'inc/elementor/block-slider.php' );		

			if ( $this->is_pro() ) {
				require_once( ST_DIR . 'inc/elementor/block-employee.php' );
				require_once( ST_DIR . 'inc/elementor/block-pricing.php' );
				require_once( ST_DIR . 'inc/elementor/block-timeline.php' );
			}
		}
	}

	function elementor_skins() {
		if ( $this->is_pro() ) {
			require_once( ST_DIR . 'inc/elementor/skins/block-portfolio-overlap-skin.php' );
			require_once( ST_DIR . 'inc/elementor/skins/block-portfolio-classic-skin.php' );
			require_once( ST_DIR . 'inc/elementor/skins/block-portfolio-metro-skin.php' );
			require_once( ST_DIR . 'inc/elementor/skins/block-testimonials-skin.php' );
		}		
	}

	function elementor_category() {
		if ( !version_compare(PHP_VERSION, '5.4', '<=') ) {
			\Elementor\Plugin::$instance->elements_manager->add_category( 
				'sydney-elements',
				[
					'title' => __( 'Sydney Elements', 'sydney-toolbox' ),
					'icon' => 'fa fa-plug',
				],
				2
			);
		}
	} 

	static function install() {
		if ( version_compare(PHP_VERSION, '5.4', '<=') ) {
			wp_die( __( 'Sydney Toolbox requires PHP 5.4. Please contact your host to upgrade your PHP. The plugin was <strong>not</strong> activated.', 'sydney-toolbox' ) );
		};
	}	

	/**
	 * Translations
	 */
	function i18n() {
		load_plugin_textdomain( 'sydney-toolbox', false, 'sydney-toolbox/languages' );
	}

	/**
	 * Admin notice
	 */
	function admin_notice() {
		$theme  = wp_get_theme();
		$parent = wp_get_theme()->parent();
		if ( ($theme != 'Sydney' ) && ($theme != 'Sydney Pro' ) && ($parent != 'Sydney') && ($parent != 'Sydney Pro') ) {
		    echo '<div class="error">';
		    echo 	'<p>' . __('Please note that the <strong>Sydney Toolbox</strong> plugin is meant to be used only with the <a href="http://wordpress.org/themes/sydney/" target="_blank">Sydney theme</a></p>', 'sydney-toolbox');
		    echo '</div>';			
		}
	}

	/**
	 * SVG styles
	 */
	function svg_styles() {
		?>
			<style>
				.sydney-svg-icon {
					display: inline-block;
					width: 16px;
					height: 16px;
					vertical-align: middle;
					line-height: 1;
				}
				.team-item .team-social li .sydney-svg-icon {
					width: 14px;
				}
				.roll-team:not(.style1) .team-item .team-social li .sydney-svg-icon {
					fill: #fff;
				}
				.team-item .team-social li:hover .sydney-svg-icon {
					fill: #000;
				}
				.team_hover_edits .team-social li a .sydney-svg-icon {
					fill: #000;
				}
				.team_hover_edits .team-social li:hover a .sydney-svg-icon {
					fill: #fff;
				}	
				.single-sydney-projects .entry-thumb {
					text-align: left;
				}	

			</style>
		<?php
	}

	/**
	 * Scripts
	 */	
	function scripts() {

		$forked_owl = get_theme_mod( 'forked_owl_carousel', false );
		if ( $forked_owl ) {
			wp_enqueue_script( 'st-carousel', ST_URI . 'js/main.js', array(), '20211217', true );
		} else {
			wp_enqueue_script( 'st-carousel', ST_URI . 'js/main-legacy.js', array(), '20211217', true );
		}
		
		wp_enqueue_style( 'st-stylesheet', ST_URI . 'css/styles.min.css', [], '20220107' );

	}

	/**
	 * Get current theme
	 */
	public static function is_pro() {
		$theme  = wp_get_theme();
		$parent = wp_get_theme()->parent();
		if ( ( $theme != 'Sydney Pro' ) && ( $parent != 'Sydney Pro') ) {
			return false;
	    } else {
	    	return true;
	    }		
	}

	public function flush_permalinks() {
		if( !get_option( 'st_flushed_permalinks' ) ) {
 
			flush_rewrite_rules( false );
			update_option('st_flushed_permalinks', 1);
		}		
	}

	/**
	 * Single projects setup
	 */
	public function single_projects() {
		if ( is_singular( 'sydney-projects' ) || is_post_type_archive( 'sydney-projects' ) || is_tax( 'project_cats' ) ) {
			remove_action( 'sydney_get_sidebar', 'sydney_get_sidebar' );
			add_filter( 'sydney_content_area_class', function() { return 'fullwidth col-md-12'; } );
		}
	}

	public function remove_archive_labels( $title ) {

		if ( is_tax( 'project_cats' ) ) {
			$title = single_cat_title( '', false );
		} elseif ( is_post_type_archive( 'sydney-projects' ) ) {
			$title = post_type_archive_title( '', false );
		}
		
		return $title;
	}

	public function post_classes( $classes ) {
		
		if ( is_tax( 'project_cats' ) || is_post_type_archive( 'sydney-projects' ) ) {
			$classes[] = 'col-lg-4 col-md-4 col-sm-6';
		}
		
		return $classes;
	}

	/**
	 * Returns the instance.
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

function sydney_toolbox_plugin() {
	return Sydney_Toolbox::get_instance();
}
add_action('plugins_loaded', 'sydney_toolbox_plugin', 1);

//Does not activate the plugin on PHP less than 5.4
register_activation_hook( __FILE__, array( 'Sydney_Toolbox', 'install' ) );