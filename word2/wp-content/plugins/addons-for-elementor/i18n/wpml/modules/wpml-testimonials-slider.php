<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Testimonials_Slider
     */
    class LAE_WPML_Testimonials_Slider extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'testimonials';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('client_name', 'credentials', 'testimonial_text');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'client_name':
                    return esc_html__('Testimonial Slide: Name', 'livemesh-el-addons');

                case 'credentials':
                    return esc_html__('Testimonial Slide: Credentials', 'livemesh-el-addons');

                case 'testimonial_text':
                    return esc_html__('Testimonial Slide: Content', 'livemesh-el-addons');

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
                case 'credentials':
                    return 'LINE';

                case 'testimonial_text':
                    return 'VISUAL';

                default:
                    return '';
            }
        }

    }

}
