<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Stats_Bars
     */
    class LAE_WPML_Stats_Bars extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'stats_bars';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('stats_title');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'stats_title':
                    return esc_html__('Stats Bar: Title', 'livemesh-el-addons');


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
                    return 'LINE';

                default:
                    return '';
            }
        }

    }

}