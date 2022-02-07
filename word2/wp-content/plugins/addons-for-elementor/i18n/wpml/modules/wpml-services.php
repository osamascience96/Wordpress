<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Services
     */
    class LAE_WPML_Services extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'services';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('service_title', 'service_excerpt');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'service_title':
                    return esc_html__('Service: Title', 'livemesh-el-addons');

                case 'service_excerpt':
                    return esc_html__('Service: Description', 'livemesh-el-addons');

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
                case 'service_title':
                    return 'LINE';

                case 'service_excerpt':
                    return 'AREA';

                default:
                    return '';
            }
        }

    }

}