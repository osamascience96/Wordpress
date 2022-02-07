<?php

namespace LivemeshAddons\ThemeBuilder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Grid_Item_Widget extends Widget_Base {

    public function get_name() {
        return 'livemesh-grid-item';
    }


    public function get_title() {
        return __('Grid Item', 'ele-custom-skin');
    }


    public function get_icon() {
        return 'eicon-info-box';
    }


    public function get_categories() {
        return ['livemesh-grid'];
    }

    protected function display_placeholder() {

        $is_preview = false;

        $document = lae_get_document(get_the_ID());

        if ($document)
            if ('livemesh_grid' == $document->get_location()) {
                if (isset($_GET['action']))
                    $is_preview = $_GET['action'] == 'elementor' ? true : false;
            }
        return $is_preview;
    }

    protected function get_item_template_options() {

        $template_options = array();

        /* Initialize the theme builder templates - Requires elementor pro plugin */
        if (!is_plugin_active('elementor-pro/elementor-pro.php')) {
            $template_options = [0 => __('No templates found. Elementor Pro is not installed/active', 'livemesh-el-addons')];
        }
        else {
            $templates = lae_get_livemesh_item_templates();
            
            foreach ($templates as $template) {
                $template_options[$template->ID] = $template->post_title;
            }
        }

        return $template_options;
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'livemesh-el-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'item_template',
            [
                'label' => __('Select the custom skin template for the grid item', 'livemesh-el-addons'),
                'description' => '<div style="text-align:center;font-style: normal;">'
                    . '<a target="_blank" class="elementor-button elementor-button-default" href="'
                    . esc_url(admin_url('/edit.php?post_type=elementor_library&tabs_group=theme&elementor_library_type=livemesh_item'))
                    . '">'
                    . __('Create/Edit the Item Skin Builder Templates', 'livemesh-el-addons')
                    . '</a>'
                    . '</div>',
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => [],
                'options' => $this->get_item_template_options(),
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $template_id = $settings['item_template'] ? $settings['item_template'] : '';

        echo '[livemesh_grid_item template_id="' . $template_id . '"]';

    }

}
