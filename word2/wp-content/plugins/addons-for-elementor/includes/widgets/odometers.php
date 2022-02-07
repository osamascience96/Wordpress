<?php

/*
Widget Name: Odometers
Description: Display one or more animated odometer statistics in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/
namespace LivemeshAddons\Widgets;

use  Elementor\Repeater ;
use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Utils ;
use  Elementor\Scheme_Color ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Scheme_Typography ;
use  Elementor\Modules\DynamicTags\Module as TagsModule ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Odometers_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-odometers';
    }
    
    public function get_title()
    {
        return __( 'Odometers', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'eicon-counter';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/statistics-addons/';
    }
    
    public function get_script_depends()
    {
        return [
            'lae-waypoints',
            'jquery-stats',
            'lae-frontend-scripts',
            'lae-odometers-scripts'
        ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_odometers', [
            'label' => __( 'Odometers', 'livemesh-el-addons' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'stats_title', [
            'label'       => __( 'Stats Title', 'livemesh-el-addons' ),
            'default'     => __( 'My stats title', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'start_value', [
            'label'   => __( 'Start Value', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 0,
        ] );
        $repeater->add_control( 'stop_value', [
            'label'   => __( 'Stop Value', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 100,
        ] );
        $repeater->add_control( 'icon_type', [
            'label'   => __( 'Choose Icon Type', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'icon',
            'options' => [
            'icon'       => __( 'Icon', 'livemesh-el-addons' ),
            'icon_image' => __( 'Icon Image', 'livemesh-el-addons' ),
        ],
        ] );
        $repeater->add_control( 'icon_image', [
            'label'       => __( 'Stats Image', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'label_block' => true,
            'condition'   => [
            'icon_type' => 'icon_image',
        ],
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'selected_icon', [
            'label'            => __( 'Stats Icon', 'livemesh-el-addons' ),
            'type'             => Controls_Manager::ICONS,
            'label_block'      => true,
            'condition'        => [
            'icon_type' => 'icon',
        ],
            'fa4compatibility' => 'icon',
        ] );
        $repeater->add_control( 'prefix', [
            'label'       => __( 'Prefix', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'description' => __( 'The prefix string like currency symbols like $ to indicate a monetary value.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'suffix', [
            'label'       => __( 'Suffix', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'description' => __( 'The suffix string like hr for hours or m for million.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $this->add_control( 'odometers', [
            'label'       => __( 'Odometers', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::REPEATER,
            'default'     => [
            [
            'stats_title' => __( 'No of Customers', 'livemesh-el-addons' ),
            'start_value' => 1000,
            'stop_value'  => 65600,
            'prefix'      => '',
            'suffix'      => '',
        ],
            [
            'stats_title' => __( 'Hours Worked', 'livemesh-el-addons' ),
            'start_value' => 1,
            'stop_value'  => 34000,
            'prefix'      => '',
            'suffix'      => '',
        ],
            [
            'stats_title' => __( 'Support Tickets', 'livemesh-el-addons' ),
            'start_value' => 1,
            'stop_value'  => 348,
            'prefix'      => '',
            'suffix'      => 'k',
        ],
            [
            'stats_title' => __( 'Product Revenue', 'livemesh-el-addons' ),
            'start_value' => 1,
            'stop_value'  => 35,
            'prefix'      => '$',
            'suffix'      => 'm',
        ]
        ],
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ stats_title }}}',
        ] );
        $this->add_control( 'upgrade_notice', [
            'type'      => Controls_Manager::RAW_HTML,
            'separator' => 'before',
            'raw'       => '<div style="text-align:center;line-height:1.6;"><p>' . __( 'Unlock new possibilities with premium widgets and styles of <strong>Livemesh Addons for Elementor <i>Premium</i></strong>. ', 'livemesh-el-addons' ) . '</p><p style="padding-top:15px;"><a class="elementor-button elementor-button-default elementor-button-go-pro" href="https://livemeshelementor.com/pricing/#pricing-plans" target="_blank"><i class="fa fa-hand-o-right" aria-hidden="true"></i>' . __( 'Go Pro', 'livemesh-el-addons' ) . '</a></p></div>',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_grid_settings', [
            'label' => __( 'Grid Settings', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_SETTINGS,
        ] );
        $this->add_control( 'column_layout', [
            'label'       => __( 'Column Layout', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => array(
            'auto'   => __( 'Auto', 'livemesh-el-addons' ),
            'custom' => __( 'Custom', 'livemesh-el-addons' ),
        ),
            'default'     => 'auto',
            'description' => __( 'Set column layout to be <strong>Auto</strong> to let the widget auto calculate number of columns based on minimum column size specified. The option <strong>Custom</strong> lets you explicitly control number of columns based on screen width.', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'min_column_size', [
            'label'      => __( 'Minimum Column Size', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'default'    => [
            'size' => 210,
        ],
            'range'      => [
            'px' => [
            'min' => 50,
            'max' => 500,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-uber-grid-container.lae-grid-auto-column-layout' => 'grid-template-columns: repeat(auto-fit, minmax({{SIZE}}{{UNIT}}, 1fr));',
        ],
            'condition'  => [
            'column_layout' => 'auto',
        ],
        ] );
        $this->add_responsive_control( 'per_line', [
            'label'              => __( 'Odometers per row', 'livemesh-el-addons' ),
            'type'               => Controls_Manager::SELECT,
            'default'            => '4',
            'tablet_default'     => '3',
            'mobile_default'     => '1',
            'options'            => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
        ],
            'frontend_available' => true,
            'condition'          => [
            'column_layout' => 'custom',
        ],
        ] );
        $this->add_control( 'column_gap', [
            'label'      => __( 'Column Gap', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'default'    => [
            'size' => 30,
        ],
            'range'      => [
            'px' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-uber-grid-container' => 'column-gap: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'row_gap', [
            'label'      => __( 'Row Gap', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'default'    => [
            'size' => 30,
        ],
            'range'      => [
            'px' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-uber-grid-container' => 'row-gap: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_widget_theme', [
            'label'      => __( 'Widget Theme', 'livemesh-el-addons' ),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ] );
        $this->add_control( 'toggle_dark_mode', [
            'label'        => __( 'Dark Mode', 'elementor-pro' ),
            'description'  => __( 'Enable dark mode when this widget is placed in those pages or sections/rows within a page that have a dark color (such as black) set as background color. ', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'dark-bg',
            'prefix_class' => 'lae-',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_stats_number', [
            'label' => __( 'Stats Number', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'stats_number_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-odometers .lae-odometer .lae-number' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'stats_number_typography',
            'selector' => '{{WRAPPER}} .lae-odometers .lae-odometer .lae-number span',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_stats_prefix_suffix', [
            'label' => __( 'Stats Prefix and Suffix', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'stats_prefix_suffix_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-odometers .lae-odometer .lae-prefix, .lae-odometers .lae-odometer .lae-suffix' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'stats_prefix_suffix_typography',
            'selector' => '{{WRAPPER}} .lae-odometers .lae-odometer .lae-prefix, .lae-odometers .lae-odometer .lae-suffix',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_styling', [
            'label' => __( 'Stats Title', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'stats_title_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-odometers .lae-odometer .lae-stats-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'stats_title_typography',
            'label'    => __( 'Typography', 'livemesh-el-addons' ),
            'selector' => '{{WRAPPER}} .lae-odometers .lae-odometer .lae-stats-title',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_icon_styling', [
            'label' => __( 'Icons', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'icon_size', [
            'label'      => __( 'Icon or Icon Image size in pixels', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em' ],
            'range'      => [
            'px' => [
            'min' => 6,
            'max' => 128,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-odometers .lae-odometer .lae-image-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .lae-odometers .lae-odometer .lae-icon-wrapper'      => 'font-size: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'icon_color', [
            'label'     => __( 'Icon Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-odometers .lae-odometer .lae-stats-title .lae-icon-wrapper' => 'color: {{VALUE}};',
        ],
        ] );
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_odometers_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/odometers/loop', $args );
    }
    
    protected function content_template()
    {
    }

}