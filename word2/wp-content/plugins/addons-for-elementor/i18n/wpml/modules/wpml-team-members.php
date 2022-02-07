<?php

namespace LivemeshAddons\i18n;

use WPML_Elementor_Module_With_Items;

if (class_exists('WPML_Elementor_Module_With_Items')) {
    /**
     * Class LAE_WPML_Team_Members
     */
    class LAE_WPML_Team_Members extends WPML_Elementor_Module_With_Items {

        /**
         * @return string
         */
        public function get_items_field() {
            return 'team_members';
        }

        /**
         * @return array
         */
        public function get_fields() {
            return array('member_name', 'member_position', 'member_details');
        }

        /**
         * @param string $field
         *
         * @return string
         */
        protected function get_title($field) {
            switch ($field) {
                case 'member_name':
                    return esc_html__('Team Member: Name', 'livemesh-el-addons');

                case 'member_position':
                    return esc_html__('Team Member: Position', 'livemesh-el-addons');

                case 'member_details':
                    return esc_html__('Team Member: Details', 'livemesh-el-addons');

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
                case 'member_name':
                case 'member_position':
                    return 'LINE';

                case 'member_details':
                    return 'AREA';

                default:
                    return '';
            }
        }

    }

}