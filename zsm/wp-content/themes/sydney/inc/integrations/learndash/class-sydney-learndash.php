<?php
/**
 * Class to handle LifterLMS integration
 *
 * @package Sydney
 */


if ( !class_exists( 'Sydney_Learndash' ) ) :

	/**
	 * Sydney_Learndash 
	 */
	Class Sydney_Learndash {

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

			//Options
			add_action( 'customize_register', array( $this, 'customizer' ) );

			//Setup
			add_action( 'wp', array( $this, 'setup' ) );

			//Body classes
			add_filter( 'body_class', array( $this, 'body_classes' ) );

			//Custom CSS
			add_filter( 'sydney_custom_css', array( $this, 'custom_css' ) );
		}

		/**
		 * Setup
		 */
		public function setup() {
			if ( is_singular( 'sfwd-courses' ) || is_singular( 'sfwd-lessons' ) || is_singular( 'sfwd-topic' ) || is_singular( 'sfwd-quiz' ) || is_singular( 'sfwd-certificates' ) || is_singular( 'sfwd-assignment' ) ) {
				add_filter( 'sydney_single_post_meta_enable', '__return_false' );
			}

			//Sidebar
			$course_sidebar = get_theme_mod( 'sydney_lifter_single_course_sidebar', 'sidebar-right' );

			if ( is_singular( 'sfwd-courses' ) && 'no-sidebar' === $course_sidebar ) {
				remove_action( 'sydney_get_sidebar', 'sydney_get_sidebar' );
				add_filter( 'sydney_content_area_class', function() { return 'fullwidth'; } );
			}

			if ( ( is_singular( 'sfwd-lessons' ) || is_singular( 'sfwd-topic' ) || is_singular( 'sfwd-quiz' ) || is_singular( 'sfwd-certificates' ) || is_singular( 'sfwd-assignment' ) ) && 'no-sidebar' === $course_sidebar ) {
				remove_action( 'sydney_get_sidebar', 'sydney_get_sidebar' );
				add_filter( 'sydney_content_area_class', function() { return 'fullwidth'; } );
			}			
		}

		/**
		 * Learndash Customizer options
		 */
		public function customizer( $wp_customize ) {
			require get_template_directory() . '/inc/integrations/learndash/customize.php';
		}

		/**
		 * Body classes
		 */
		public function body_classes( $classes ) {
			$course_sidebar = get_theme_mod( 'sydney_lifter_single_course_sidebar', 'sidebar-right' );
			$lesson_sidebar = get_theme_mod( 'sydney_lifter_single_lesson_sidebar', 'sidebar-right' );

			if ( is_singular( 'sfwd-courses' ) ) {
				$classes[] = $course_sidebar;
			}

			if ( is_singular( 'sfwd-lessons' ) || is_singular( 'sfwd-topic' ) || is_singular( 'sfwd-quiz' ) || is_singular( 'sfwd-certificates' ) || is_singular( 'sfwd-assignment' ) ) {
				$classes[] = $lesson_sidebar;
			}
			
			return $classes;
		}

		/**
		 * Custom CSS
		 */
		public function custom_css( $custom ) {

			$custom .= "@media ( min-width: 991px ) {.sidebar-left.single-sfwd-topic .content-area,.sidebar-left.single-sfwd-quiz .content-area,.sidebar-left.single-sfwd-lessons .content-area,.sidebar-left.single-sfwd-courses .content-area {float:right;} .sidebar-left.single-sfwd-topic .post-wrap,.sidebar-left.single-sfwd-quiz .post-wrap,.sidebar-left.single-sfwd-lessons .post-wrap,.sidebar-left.single-sfwd-courses .post-wrap { padding-left: 50px;padding-right:0;} }"."\n";

			return $custom;
		}

	}

	/**
	 * Initialize class
	 */
	Sydney_Learndash::get_instance();

endif;