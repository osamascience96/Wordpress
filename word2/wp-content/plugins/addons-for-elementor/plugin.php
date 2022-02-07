<?php

namespace LivemeshAddons;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Livemesh_Elementor_Addons' ) ) {
    /**
     * Main Livemesh_Elementor_Addons Class
     *
     */
    final class Livemesh_Elementor_Addons
    {
        /** Singleton *************************************************************/
        private static  $instance ;
        /**
         * Main Livemesh_Elementor_Addons Instance
         *
         * Insures that only one instance of Livemesh_Elementor_Addons exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         */
        public static function instance()
        {
            
            if ( !isset( self::$instance ) && !self::$instance instanceof Livemesh_Elementor_Addons ) {
                self::$instance = new Livemesh_Elementor_Addons();
                self::$instance->setup_debug_constants();
                self::$instance->includes();
                self::$instance->hooks();
                self::$instance->template_hooks();
            }
            
            return self::$instance;
        }
        
        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         */
        public function __clone()
        {
            // Cloning instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'livemesh-el-addons' ), '7.1.2' );
        }
        
        /**
         * Disable unserializing of the class
         *
         */
        public function __wakeup()
        {
            // Unserializing instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'livemesh-el-addons' ), '7.1.2' );
        }
        
        private function setup_debug_constants()
        {
            $enable_debug = false;
            $settings = get_option( 'lae_settings' );
            if ( $settings && isset( $settings['lae_enable_debug'] ) && $settings['lae_enable_debug'] == "true" ) {
                $enable_debug = true;
            }
            // Enable script debugging
            if ( !defined( 'LAE_SCRIPT_DEBUG' ) ) {
                define( 'LAE_SCRIPT_DEBUG', $enable_debug );
            }
            // Minified JS file name suffix
            if ( !defined( 'LAE_JS_SUFFIX' ) ) {
                
                if ( $enable_debug ) {
                    define( 'LAE_JS_SUFFIX', '' );
                } else {
                    define( 'LAE_JS_SUFFIX', '.min' );
                }
            
            }
        }
        
        /**
         * Include required files
         *
         */
        private function includes()
        {
            require_once LAE_PLUGIN_DIR . 'includes/helper-functions.php';
            require_once LAE_PLUGIN_DIR . 'includes/query-functions.php';
            if ( is_admin() ) {
                require_once LAE_PLUGIN_DIR . 'admin/admin-init.php';
            }
            if ( !function_exists( 'is_plugin_active' ) ) {
                include_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            /* Ensure WPML String Translation plugin is active */
            if ( is_plugin_active( 'wpml-string-translation/plugin.php' ) ) {
                require_once LAE_PLUGIN_DIR . 'i18n/wpml-compatibility-init.php';
            }
            /* Initialize the theme builder templates - Requires elementor pro plugin */
            if ( is_plugin_active( 'elementor-pro/elementor-pro.php' ) ) {
                require_once LAE_PLUGIN_DIR . 'includes/theme-builder/init.php';
            }
        }
        
        /**
         * Load Plugin Text Domain
         *
         * Looks for the plugin translation files in certain directories and loads
         * them to allow the plugin to be localised
         */
        public function load_plugin_textdomain()
        {
            $lang_dir = apply_filters( 'lae_el_addons_lang_dir', trailingslashit( LAE_PLUGIN_DIR . 'languages' ) );
            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'livemesh-el-addons' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'livemesh-el-addons', $locale );
            // Setup paths to current locale file
            $mofile_local = $lang_dir . $mofile;
            
            if ( file_exists( $mofile_local ) ) {
                // Look in the /wp-content/plugins/livemesh-el-addons/languages/ folder
                load_textdomain( 'livemesh-el-addons', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'livemesh-el-addons', false, $lang_dir );
            }
            
            return false;
        }
        
        /**
         * Setup the default hooks and actions
         */
        private function hooks()
        {
            add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
            // Initialize string translation of plugin elements after String Translation plugin is loaded
            add_action( 'wpml_st_loaded', array( $this, 'init_wpml_compatibility' ) );
            // Filter to exclude images from lazy load using https://wordpress.org/plugins/sg-cachepress/
            add_filter( 'sgo_lazy_load_exclude_classes', array( $this, 'exclude_images_with_specific_class' ) );
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'include_widgets' ) );
            add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_editor_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_frontend_scripts' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_frontend_styles' ) );
            add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_frontend_styles' ) );
            add_action( 'elementor/init', array( $this, 'add_elementor_category' ) );
        }
        
        function exclude_images_with_specific_class( $classes )
        {
            // Add the class name that you want to exclude from lazy load.
            $classes[] = 'skip-lazy';
            return $classes;
        }
        
        function init_wpml_compatibility()
        {
            // Run WPML String Translation dependent actions
            new \LivemeshAddons\i18n\LAE_WPML_Compatibility_Init();
        }
        
        private function template_hooks()
        {
            $addons = array(
                'clients',
                'carousel',
                'heading',
                'odometers',
                'piecharts',
                'posts_grid',
                'posts_carousel',
                'posts_multislider',
                'posts_slider',
                'posts_gridbox_slider',
                'pricing_table',
                'services',
                'message_box',
                'stats_bars',
                'team_members',
                'testimonials',
                'testimonials_slider'
            );
            foreach ( $addons as $addon ) {
                add_filter(
                    'lae_' . $addon . '_output',
                    function ( $default_output, $settings ) use( $addon ) {
                    // Replace underscores with dashes for template file names
                    $template_name = str_replace( '_', '-', $addon );
                    $output = lae_get_template_part( $template_name, array(
                        'settings' => $settings,
                    ) );
                    if ( $output !== null ) {
                        return $output;
                    }
                    return $default_output;
                },
                    10,
                    2
                );
            }
        }
        
        public function add_elementor_category()
        {
            \Elementor\Plugin::instance()->elements_manager->add_category( 'livemesh-addons', array(
                'title' => __( 'Livemesh Addons', 'livemesh-el-addons' ),
                'icon'  => 'fa fa-plug',
            ), 1 );
        }
        
        public function localize_array( $array = array() )
        {
            $array['custom_css'] = lae_get_option( 'lae_custom_css', '' );
            return $array;
        }
        
        /**
         * Load Frontend Scripts
         *
         */
        public function register_frontend_scripts()
        {
            // Use minified libraries if LAE_SCRIPT_DEBUG is turned off
            $suffix = ( defined( 'LAE_SCRIPT_DEBUG' ) && LAE_SCRIPT_DEBUG ? '' : '.min' );
            wp_register_script(
                'lae-waypoints',
                LAE_PLUGIN_URL . 'assets/js/jquery.waypoints' . $suffix . '.js',
                array( 'jquery' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'isotope.pkgd',
                LAE_PLUGIN_URL . 'assets/js/isotope.pkgd' . $suffix . '.js',
                array( 'jquery' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'imagesloaded.pkgd',
                LAE_PLUGIN_URL . 'assets/js/imagesloaded.pkgd' . $suffix . '.js',
                array( 'jquery' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'jquery-stats',
                LAE_PLUGIN_URL . 'assets/js/jquery.stats' . $suffix . '.js',
                array( 'jquery' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-jquery-slick',
                LAE_PLUGIN_URL . 'assets/js/slick' . $suffix . '.js',
                array( 'jquery' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-frontend-scripts',
                LAE_PLUGIN_URL . 'assets/js/lae-frontend' . $suffix . '.js',
                array( 'jquery' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-carousel-helper-scripts',
                LAE_PLUGIN_URL . 'assets/js/lae-carousel-helper' . $suffix . '.js',
                array( 'lae-jquery-slick', 'jquery' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-carousel-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/carousel' . $suffix . '.js',
                array( 'lae-carousel-helper-scripts', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-odometers-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/odometers' . $suffix . '.js',
                array( 'lae-waypoints', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-piecharts-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/piecharts' . $suffix . '.js',
                array( 'lae-waypoints', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-stats-bars-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/stats-bars' . $suffix . '.js',
                array( 'lae-waypoints', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-posts-carousel-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/posts-carousel' . $suffix . '.js',
                array( 'lae-carousel-helper-scripts', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-team-members-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/team-members' . $suffix . '.js',
                array( 'lae-carousel-helper-scripts', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-clients-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/clients' . $suffix . '.js',
                array( 'lae-carousel-helper-scripts', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-services-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/services' . $suffix . '.js',
                array( 'lae-carousel-helper-scripts', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-message-box-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/message-box' . $suffix . '.js',
                array( 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-testimonials-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/testimonials' . $suffix . '.js',
                array( 'lae-carousel-helper-scripts', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-posts-gridbox-slider-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/posts-gridbox-slider' . $suffix . '.js',
                array( 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-posts-multislider-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/posts-multislider' . $suffix . '.js',
                array( 'lae-carousel-helper-scripts', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-posts-slider-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/posts-slider' . $suffix . '.js',
                array( 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-tab-slider-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/tab-slider' . $suffix . '.js',
                array( 'lae-jquery-slick', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-testimonials-slider-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/testimonials-slider' . $suffix . '.js',
                array( 'lae-carousel-helper-scripts', 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            wp_register_script(
                'lae-portfolio-scripts',
                LAE_PLUGIN_URL . 'assets/js/widgets/portfolio' . $suffix . '.js',
                array( 'elementor-frontend' ),
                LAE_VERSION,
                true
            );
            $array = $this->localize_array();
            wp_localize_script( 'lae-frontend-scripts', 'lae_js_vars', $array );
        }
        
        /**
         * Load Frontend Styles
         *
         */
        public function enqueue_editor_styles()
        {
            wp_enqueue_style(
                'lae-icomoon-styles',
                LAE_PLUGIN_URL . 'assets/css/icomoon.css',
                array(),
                LAE_VERSION
            );
        }
        
        /**
         * Load Frontend Styles
         *
         */
        public function register_frontend_styles()
        {
            wp_register_style(
                'animate',
                LAE_PLUGIN_URL . 'assets/css/lib/animate.css',
                array(),
                LAE_VERSION
            );
            wp_register_style(
                'lae-icomoon-styles',
                LAE_PLUGIN_URL . 'assets/css/icomoon.css',
                array(),
                LAE_VERSION
            );
            wp_register_style(
                'lae-sliders-styles',
                LAE_PLUGIN_URL . 'assets/css/lib/sliders.min.css',
                array(),
                LAE_VERSION
            );
            wp_register_style(
                'lae-frontend-styles',
                LAE_PLUGIN_URL . 'assets/css/lae-frontend.css',
                array(),
                LAE_VERSION
            );
            wp_register_style(
                'lae-grid-styles',
                LAE_PLUGIN_URL . 'assets/css/lae-grid.css',
                array(),
                LAE_VERSION
            );
            wp_register_style(
                'lae-widgets-styles',
                LAE_PLUGIN_URL . 'assets/css/widgets/lae-widgets.min.css',
                array( 'lae-frontend-styles' ),
                LAE_VERSION
            );
        }
        
        /**
         * Load Frontend Styles
         *
         */
        public function enqueue_frontend_styles()
        {
            wp_enqueue_style( 'animate' );
            wp_enqueue_style( 'lae-sliders-styles' );
            wp_enqueue_style( 'lae-icomoon-styles' );
            wp_enqueue_style( 'lae-frontend-styles' );
            wp_enqueue_style( 'lae-grid-styles' );
            wp_enqueue_style( 'lae-widgets-styles' );
        }
        
        /**
         * Include required files
         *
         */
        public function include_widgets( $widgets_manager )
        {
            require_once LAE_PLUGIN_DIR . 'includes/base/widget-base.php';
            /* Load Elementor Addon Elements */
            $deactivate_element_team_members = lae_get_option( 'lae_deactivate_element_team', false );
            
            if ( !$deactivate_element_team_members ) {
                require_once LAE_ADDONS_DIR . 'team-members.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Team_Widget() );
            }
            
            $deactivate_element_testimonials = lae_get_option( 'lae_deactivate_element_testimonials', false );
            
            if ( !$deactivate_element_testimonials ) {
                require_once LAE_ADDONS_DIR . 'testimonials.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Testimonials_Widget() );
            }
            
            $deactivate_element_testimonials_slider = lae_get_option( 'lae_deactivate_element_testimonials_slider', false );
            
            if ( !$deactivate_element_testimonials_slider ) {
                require_once LAE_ADDONS_DIR . 'testimonials-slider.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Testimonials_Slider_Widget() );
            }
            
            $deactivate_element_tab_slider = lae_get_option( 'lae_deactivate_element_tab_slider', false );
            
            if ( !$deactivate_element_tab_slider ) {
                require_once LAE_ADDONS_DIR . 'tab-slider.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Tab_Slider_Widget() );
            }
            
            $deactivate_element_stats_bar = lae_get_option( 'lae_deactivate_element_stats_bar', false );
            
            if ( !$deactivate_element_stats_bar ) {
                require_once LAE_ADDONS_DIR . 'stats-bars.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Stats_Bars_Widget() );
            }
            
            $deactivate_element_piecharts = lae_get_option( 'lae_deactivate_element_piecharts', false );
            
            if ( !$deactivate_element_piecharts ) {
                require_once LAE_ADDONS_DIR . 'piecharts.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Piecharts_Widget() );
            }
            
            $deactivate_element_odometers = lae_get_option( 'lae_deactivate_element_odometers', false );
            
            if ( !$deactivate_element_odometers ) {
                require_once LAE_ADDONS_DIR . 'odometers.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Odometers_Widget() );
            }
            
            $deactivate_element_services = lae_get_option( 'lae_deactivate_element_services', false );
            
            if ( !$deactivate_element_services ) {
                require_once LAE_ADDONS_DIR . 'services.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Services_Widget() );
            }
            
            $deactivate_element_message_box = lae_get_option( 'lae_deactivate_element_message_box', false );
            
            if ( !$deactivate_element_message_box ) {
                require_once LAE_ADDONS_DIR . 'message-box.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Message_Box_Widget() );
            }
            
            $deactivate_element_heading = lae_get_option( 'lae_deactivate_element_heading', false );
            
            if ( !$deactivate_element_heading ) {
                require_once LAE_ADDONS_DIR . 'heading.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Heading_Widget() );
            }
            
            $deactivate_element_clients = lae_get_option( 'lae_deactivate_element_clients', false );
            
            if ( !$deactivate_element_clients ) {
                require_once LAE_ADDONS_DIR . 'clients.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Clients_Widget() );
            }
            
            $deactivate_element_pricing_table = lae_get_option( 'lae_deactivate_element_pricing_table', false );
            
            if ( !$deactivate_element_pricing_table ) {
                require_once LAE_ADDONS_DIR . 'pricing-table.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Pricing_Table_Widget() );
            }
            
            $deactivate_element_posts_carousel = lae_get_option( 'lae_deactivate_element_posts_carousel', false );
            
            if ( !$deactivate_element_posts_carousel ) {
                require_once LAE_ADDONS_DIR . 'posts-carousel.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Posts_Carousel_Widget() );
            }
            
            $deactivate_element_carousel = lae_get_option( 'lae_deactivate_element_carousel', false );
            
            if ( !$deactivate_element_carousel ) {
                require_once LAE_ADDONS_DIR . 'carousel.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Carousel_Widget() );
            }
            
            $deactivate_element_portfolio = lae_get_option( 'lae_deactivate_element_portfolio', false );
            
            if ( !$deactivate_element_portfolio ) {
                require_once LAE_ADDONS_DIR . 'portfolio.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Portfolio_Widget() );
            }
            
            $deactivate_element_posts_slider = lae_get_option( 'lae_deactivate_element_posts_slider', false );
            
            if ( !$deactivate_element_posts_slider ) {
                require_once LAE_ADDONS_DIR . 'posts-slider.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Posts_Slider_Widget() );
            }
            
            $deactivate_element_posts_gridbox_slider = lae_get_option( 'lae_deactivate_element_posts_gridbox_slider', false );
            
            if ( !$deactivate_element_posts_gridbox_slider ) {
                require_once LAE_ADDONS_DIR . 'posts-gridbox-slider.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Posts_GridBox_Slider_Widget() );
            }
            
            $deactivate_element_posts_multislider = lae_get_option( 'lae_deactivate_element_posts_multislider', false );
            
            if ( !$deactivate_element_posts_multislider ) {
                require_once LAE_ADDONS_DIR . 'posts-multislider.php';
                $widgets_manager->register_widget_type( new \LivemeshAddons\Widgets\LAE_Posts_Multislider_Widget() );
            }
        
        }
    
    }
    /**
     * The main function responsible for returning the one true Livemesh_Elementor_Addons
     * Instance to functions everywhere.
     *
     * Use this function like you would a global variable, except without needing
     * to declare the global.
     *
     * Example: <?php $lae = LAE(); ?>
     */
    function LAE()
    {
        return Livemesh_Elementor_Addons::instance();
    }
    
    // Get LAE Running
    LAE();
}

// End if class_exists check