<?php
/**
 * Class to handle LifterLMS integration
 *
 * @package Sydney
 */


if ( !class_exists( 'Sydney_LifterLMS' ) ) :

	/**
	 * Sydney_LifterLMS 
	 */
	Class Sydney_LifterLMS {

		/**
		 * Instance
		 */		
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {

			//Styles
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

			//Options
			add_action( 'customize_register', array( $this, 'customizer' ) );

			//Setup
			add_action( 'wp', array( $this, 'setup' ) );		
			add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
			add_filter( 'llms_get_theme_default_sidebar', array( $this, 'return_sidebar' ) );

			//Change catalog wrappers
			remove_action( 'lifterlms_before_main_content', 'lifterlms_output_content_wrapper', 10 );
			remove_action( 'lifterlms_after_main_content', 'lifterlms_output_content_wrapper_end', 10 );
			add_action( 'lifterlms_before_main_content', array( $this, 'catalog_wrapper_start' ), 10 );
			add_action( 'lifterlms_after_main_content', array( $this, 'catalog_wrapper_end' ), 10 );
			
			remove_action( 'lifterlms_student_dashboard_header', 'lifterlms_template_student_dashboard_title', 20 );

			//Columns
			add_filter( 'lifterlms_loop_columns', array( $this, 'loop_columns' ) );

			//Sidebars
			add_action( 'wp', array( $this, 'remove_loop_sidebar' ) );		

			//Custom CSS
			add_filter( 'sydney_custom_css', array( $this, 'custom_css' ) );

		}

		/**
		 * Setup
		 */
		public function setup() {
			if ( is_course() || is_lesson() || is_membership() ) {
				add_filter( 'sydney_single_post_meta_enable', '__return_false' );
				add_filter( 'sydney_single_post_nav_enable', '__return_false' );				
			}

			if ( is_membership() || is_llms_checkout() || is_llms_account_page() ) {
				remove_action( 'sydney_get_sidebar', 'sydney_get_sidebar' );
				add_filter( 'sydney_content_area_class', function() { return 'fullwidth'; } );
			}
		}

		/**
		 * Declare theme support for all LifterLMS features
		 */
		public function theme_support() {
			add_theme_support( 'lifterlms' );
			add_theme_support( 'lifterlms-quizzes' );
			add_theme_support( 'lifterlms-sidebars' );
		}

		/**
		 * Enqueue custom Lifter styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'sydney-lifter-css', get_template_directory_uri() . '/inc/integrations/lifter/lifter.min.css' );
		}
		
		/**
		 * Replace this sidebar on courses and lessons
		 */
		public function return_sidebar( $id ) {

			$sidebar = 'sidebar-1';
		
			return $sidebar;
		}	
		
		/**
		 * Catalog wrapper start
		 */
		public function catalog_wrapper_start() {

			if ( 'no-sidebar' === $this->loop_sidebars() ) {
				$cols = 'col-md-12';
			} else {
				$cols = 'col-md-9';
			}

			echo '<div id="primary" class="content-area llms-content-area ' . $this->loop_sidebars() . ' ' . $cols . '">';
				echo '<main id="main" class="site-main" role="main">';
		}

		/**
		 * Catalog wrapper end
		 */		
		public function catalog_wrapper_end() {
				echo '</main>';
			echo '</div>';
		}

		/**
		 * Lifter Customizer options
		 */
		public function customizer( $wp_customize ) {
			require get_template_directory() . '/inc/integrations/lifter/customize.php';
		}

		/**
		 * Loop columns
		 */
		public function loop_columns( $cols ) {

			$course_cols 		= get_theme_mod( 'sydney_lifter_course_cols', 3 );
			$membership_cols 	= get_theme_mod( 'sydney_lifter_membership_cols', 3 );

			if ( is_post_type_archive( 'course' ) ) {
				return $course_cols;
			} elseif ( is_post_type_archive( 'llms_membership' ) ) {
				return $membership_cols;
			}
			
			return $cols;
		}
		
		/**
		 * Loop sidebars
		 */
		public function loop_sidebars() {

			$sidebar = '';

			if ( is_post_type_archive( 'course' ) ) {
				$sidebar = get_theme_mod( 'sydney_lifter_course_loop_sidebar', 'no-sidebar' );
			} elseif ( is_post_type_archive( 'llms_membership' ) ) {
				$sidebar = get_theme_mod( 'sydney_lifter_membership_loop_sidebar', 'no-sidebar' );
			}

			return $sidebar;
		}		

		/**
		 * Remove sidebar from course/membership loops
		 */
		public function remove_loop_sidebar() {
			if ( 'no-sidebar' === $this->loop_sidebars() ) {
				remove_action( 'lifterlms_sidebar', 'lifterlms_get_sidebar' );
			}
		}

		/**
		 * Custom CSS
		 */
		public function custom_css( $custom ) {
			$loop_title_color = get_theme_mod( 'sydney_lifter_loop_title_color' );
			$custom .= ".llms-loop-item-content .llms-loop-title { color:" . esc_attr( $loop_title_color ) . ";}"."\n";

			$loop_title_color_hover = get_theme_mod( 'sydney_lifter_loop_title_color_hover' );
			$custom .= ".llms-loop-item-content .llms-loop-title:hover { color:" . esc_attr( $loop_title_color_hover ) . ";}"."\n";
		
			$sydney_lifter_loop_meta_color = get_theme_mod( 'sydney_lifter_loop_meta_color' );
			$custom .= ".llms-loop-item-content .llms-meta, .llms-loop-item-content .llms-author { color:" . esc_attr( $sydney_lifter_loop_meta_color ) . ";}"."\n";

			$sydney_lifter_loop_title_size = get_theme_mod( 'sydney_lifter_loop_title_size', 25 );
			$custom .= "@media (min-width:991px) { .llms-loop-item .llms-loop-title { font-size:" . esc_attr( $sydney_lifter_loop_title_size ) . "px;} }"."\n";

			$sydney_lifter_course_title_color = get_theme_mod( 'sydney_lifter_course_title_color' );
			$custom .= ".single-course .hentry .title-post { color:" . esc_attr( $sydney_lifter_course_title_color ) . ";}"."\n";	
			
			$sydney_lifter_course_title_size = get_theme_mod( 'sydney_lifter_course_title_size', 36 );
			$custom .= "@media (min-width:991px) { .single-course .hentry .title-post { font-size:" . esc_attr( $sydney_lifter_course_title_size ) . "px;} }"."\n";			
			
			$sydney_lifter_course_accent_color = get_theme_mod( 'sydney_lifter_course_accent_color' );
			$custom .= "div.llms-syllabus-wrapper h3,.llms-access-plan-title,.llms-instructor-info .llms-instructors .llms-author .avatar { background-color:" . esc_attr( $sydney_lifter_course_accent_color ) . ";}"."\n";
			$custom .= "div.llms-instructor-info .llms-instructors .llms-author .avatar,.llms-instructor-info .llms-instructors .llms-author { border-color:" . esc_attr( $sydney_lifter_course_accent_color ) . ";}"."\n";

			$sydney_lifter_lesson_title_color = get_theme_mod( 'sydney_lifter_lesson_title_color' );
			$custom .= ".single-lesson .hentry .title-post { color:" . esc_attr( $sydney_lifter_lesson_title_color ) . ";}"."\n";	
			
			$sydney_lifter_lesson_title_size = get_theme_mod( 'sydney_lifter_lesson_title_size', 36 );
			$custom .= "@media (min-width:991px) { .single-lesson .hentry .title-post { font-size:" . esc_attr( $sydney_lifter_lesson_title_size ) . "px;} }"."\n";

			return $custom;
		}
	}

	/**
	 * Initialize class
	 */
	Sydney_LifterLMS::get_instance();

endif;