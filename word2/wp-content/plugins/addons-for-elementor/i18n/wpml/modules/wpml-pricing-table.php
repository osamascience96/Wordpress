<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Pricing_Table
     */
    class LAE_WPML_Pricing_Table extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'pricing_plans';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('pricing_title', 'tagline', 'price_tag', 'pricing_content', 'button_text', 'button_url' => array('url'));
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'pricing_title':
                    return esc_html__('Pricing: Title', 'livemesh-el-addons');

                case 'tagline':
                    return esc_html__('Pricing: Tagline', 'livemesh-el-addons');

                case 'price_tag':
                    return esc_html__('Pricing: Price Tag', 'livemesh-el-addons');

                case 'button_text':
                    return esc_html__('Pricing: Button Text', 'livemesh-el-addons');

                case 'url':
                    return esc_html__('Pricing: Button URL', 'livemesh-el-addons');

                case 'pricing_content':
                    return esc_html__('Pricing: Content', 'livemesh-el-addons');

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
                case 'pricing_title':
                case 'tagline':
                case 'price_tag':
                case 'button_text':
                    return 'LINE';

                case 'pricing_content':
                    return 'AREA';

                case 'url':
                    return 'LINK';

                default:
                    return '';
            }
        }

    }

}