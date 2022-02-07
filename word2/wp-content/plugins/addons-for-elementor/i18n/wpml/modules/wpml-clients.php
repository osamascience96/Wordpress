<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Clients
     */
    class LAE_WPML_Clients extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'clients';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('client_name', 'client_link' => array('url'));
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'client_name':
                    return esc_html__('Client: Name', 'livemesh-el-addons');

                case 'url':
                    return esc_html__('Client: Website URL', 'livemesh-el-addons');

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
                case 'client_name':
                    return 'LINE';
                case 'url':
                    return 'LINK';

                default:
                    return '';
            }
        }

    }

}