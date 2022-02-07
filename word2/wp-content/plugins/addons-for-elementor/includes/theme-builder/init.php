<?php

namespace LivemeshAddons\ThemeBuilder;

use Elementor\Plugin;
use ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager;
use Elementor\Core\Documents_Manager;

use LivemeshAddons\ThemeBuilder\Widgets\Grid_Item_Widget;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('LAE_Theme_Builder_Init')):

    class LAE_Theme_Builder_Init {

        public function __construct() {

            $this->setup_constants();

            $this->includes();

            $this->hooks();
        }

        private function setup_constants() {

            // Plugin Folder Path
            if (!defined('LAE_THEME_BUILDER_DIR')) {
                define('LAE_THEME_BUILDER_DIR', LAE_PLUGIN_DIR . 'includes/theme-builder/');
            }

        }

        private function includes() {

            require_once LAE_THEME_BUILDER_DIR . 'functions/utils.php';

        }

        private function hooks() {

            add_action('elementor_pro/init', array($this, 'initialize_documents'));

            add_action('elementor/theme/register_locations', array($this, 'register_locations'));

            add_action('elementor/documents/register', array($this, 'register_documents'));

            add_action('elementor/widgets/widgets_registered', array($this, 'register_widgets'));
        }

        public function initialize_documents() {

            require_once LAE_THEME_BUILDER_DIR . 'documents/livemesh-item.php';

            require_once LAE_THEME_BUILDER_DIR . 'documents/livemesh-grid.php';

        }

        public function register_documents(Documents_Manager $documents_manager) {

            /* TODO: Look for a different hook to initialize documents - elementor_pro/init hook is not being called for maintenance tasks */
            if (!class_exists('\LivemeshAddons\ThemeBuilder\Livemesh_Item') || !class_exists('\LivemeshAddons\ThemeBuilder\Livemesh_Grid')) {

                $this->initialize_documents();
            }

            $documents_manager->register_document_type('livemesh_item', Livemesh_Item::get_class_full_name());

            $documents_manager->register_document_type('livemesh_grid', Livemesh_Grid::get_class_full_name());

        }

        public function register_locations(Locations_Manager $location_manager) {

            $location_manager->register_location(
                'livemesh_item',
                [
                    'label' => __('Livemesh Item', 'livemesh-el-addons'),
                    'multiple' => true,
                    'edit_in_content' => true,
                ]
            );

            $location_manager->register_location(
                'livemesh_grid',
                [
                    'label' => __('Livemesh Grid', 'livemesh-el-addons'),
                    'multiple' => true,
                    'edit_in_content' => true,
                ]
            );

        }

        public function register_widgets() {

            require_once LAE_THEME_BUILDER_DIR . 'widgets/grid-item.php';

            Plugin::instance()->widgets_manager->register_widget_type(new Grid_Item_Widget());

        }

    }

endif;

new LAE_Theme_Builder_Init();
