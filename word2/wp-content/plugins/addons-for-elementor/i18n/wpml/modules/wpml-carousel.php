<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Carousel
     */
    class LAE_WPML_Carousel extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'elements';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('element_title', 'element_content');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'element_title':
                    return esc_html__('Carousel: Title', 'livemesh-el-addons');

                case 'element_content':
                    return esc_html__('Carousel: Content', 'livemesh-el-addons');

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
                case 'element_title':
                    return 'LINE';

                case 'element_content':
                    return 'VISUAL';

                default:
                    return '';
            }
        }

    }
}
