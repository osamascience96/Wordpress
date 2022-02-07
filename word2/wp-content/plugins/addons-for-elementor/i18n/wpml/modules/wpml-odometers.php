<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Odometers
     */
    class LAE_WPML_Odometers extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'odometers';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('stats_title', 'prefix', 'suffix');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'stats_title':
                    return esc_html__('Odometer: Title', 'livemesh-el-addons');

                case 'prefix':
                    return esc_html__('Odometer: Prefix', 'livemesh-el-addons');

                case 'suffix':
                    return esc_html__('Odometer: Suffix', 'livemesh-el-addons');

                default:
                    return '';
            }
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_editor_type($field) {
            switch ($field) {
                case 'stats_title':
                case 'prefix':
                case 'suffix':
                    return 'LINE';

                default:
                    return '';
            }
        }

    }

}