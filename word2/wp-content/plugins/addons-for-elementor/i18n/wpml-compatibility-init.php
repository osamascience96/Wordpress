<?php

namespace LivemeshAddons\i18n;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !class_exists( 'LAE_WPML_Compatibility_Init' ) ) {
    class LAE_WPML_Compatibility_Init
    {
        public function __construct()
        {
            $this->setup_constants();
            $this->includes();
            $this->hooks();
        }
        
        private function setup_constants()
        {
            // Plugin Folder Path
            if ( !defined( 'LAE_WPML_MODULES_DIR' ) ) {
                define( 'LAE_WPML_MODULES_DIR', LAE_PLUGIN_DIR . 'i18n/wpml/modules/' );
            }
        }
        
        private function includes()
        {
            require_once LAE_WPML_MODULES_DIR . 'wpml-carousel.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-clients.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-odometers.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-piecharts.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-pricing-table.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-services.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-stats-bars.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-team-members.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-testimonials.php';
            require_once LAE_WPML_MODULES_DIR . 'wpml-testimonials-slider.php';
        }
        
        private function hooks()
        {
            add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'wpml_widgets_to_translate_filter' ) );
        }
        
        public function wpml_widgets_to_translate_filter( $widgets )
        {
            $lae_widgets = array(
                'lae-heading'             => array(
                'conditions' => array(
                'widgetType' => 'lae-heading',
            ),
                'fields'     => array( array(
                'field'       => 'heading',
                'type'        => __( 'Heading: Title', 'livemesh-el-addons' ),
                'editor_type' => 'LINE',
            ), array(
                'field'       => 'subtitle',
                'type'        => __( 'Heading: Subheading', 'livemesh-el-addons' ),
                'editor_type' => 'LINE',
            ), array(
                'field'       => 'short_text',
                'type'        => __( 'Heading: Short Text', 'livemesh-el-addons' ),
                'editor_type' => 'AREA',
            ) ),
            ),
                'lae-carousel'            => array(
                'conditions'        => array(
                'widgetType' => 'lae-carousel',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Carousel',
            ),
                'lae-clients'             => array(
                'conditions'        => array(
                'widgetType' => 'lae-clients',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Clients',
            ),
                'lae-odometers'           => array(
                'conditions'        => array(
                'widgetType' => 'lae-odometers',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Odometers',
            ),
                'lae-piecharts'           => array(
                'conditions'        => array(
                'widgetType' => 'lae-piecharts',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Piecharts',
            ),
                'lae-pricing-table'       => array(
                'conditions'        => array(
                'widgetType' => 'lae-pricing-table',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Pricing_Table',
            ),
                'lae-services'            => array(
                'conditions'        => array(
                'widgetType' => 'lae-services',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Services',
            ),
                'lae-stats-bars'          => array(
                'conditions'        => array(
                'widgetType' => 'lae-stats-bars',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Stats_Bars',
            ),
                'lae-team-members'        => array(
                'conditions'        => array(
                'widgetType' => 'lae-team-members',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Team_Members',
            ),
                'lae-testimonials'        => array(
                'conditions'        => array(
                'widgetType' => 'lae-testimonials',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Testimonials',
            ),
                'lae-testimonials-slider' => array(
                'conditions'        => array(
                'widgetType' => 'lae-testimonials-slider',
            ),
                'fields'            => array(),
                'integration-class' => '\\LivemeshAddons\\i18n\\LAE_WPML_Testimonials_Slider',
            ),
            );
            $widgets = array_merge( $widgets, $lae_widgets );
            $lae_widgets = array(
                'lae-portfolio' => array(
                'conditions' => array(
                'widgetType' => 'lae-portfolio',
            ),
                'fields'     => array( array(
                'field'       => 'heading',
                'type'        => __( 'Posts Grid: Heading', 'livemesh-el-addons' ),
                'editor_type' => 'LINE',
            ) ),
            ),
            );
            $widgets = array_merge( $widgets, $lae_widgets );
            return $widgets;
        }
    
    }
}