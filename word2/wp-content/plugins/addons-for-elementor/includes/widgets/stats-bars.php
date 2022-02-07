<?php

/*
Widget Name: Stats Bars
Description: Display multiple stats bars that talk about skills or other percentage stats.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/
namespace LivemeshAddons\Widgets;

use  Elementor\Repeater ;
use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Scheme_Color ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Scheme_Typography ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Stats_Bars_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-stats-bars';
    }
    
    public function get_title()
    {
        return __( 'Stats Bars', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-stats-bars';
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
        return [ 'lae-waypoints', 'lae-frontend-scripts', 'lae-stats-bars-scripts' ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_stats_bars', [
            'label' => __( 'Stats Bars', 'livemesh-el-addons' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'stats_title', [
            'label'       => __( 'Stats Title', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'description' => __( 'The title for the stats bar', 'livemesh-el-addons' ),
            'default'     => __( 'My stats title', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'percentage_value', [
            'label'       => __( 'Percentage Value', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::NUMBER,
            'min'         => 1,
            'max'         => 100,
            'step'        => 1,
            'default'     => 30,
            'description' => __( 'The percentage value for the stats.', 'livemesh-el-addons' ),
        ] );
        $repeater->add_control( 'bar_color', [
            'label'   => __( 'Bar Color', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::COLOR,
            'default' => '#f94213',
        ] );
        $this->add_control( 'stats_bars', [
            'type'        => Controls_Manager::REPEATER,
            'default'     => [ [
            'stats_title'      => __( 'Web Design', 'livemesh-el-addons' ),
            'percentage_value' => 87,
        ], [
            'stats_title'      => __( 'SEO Services', 'livemesh-el-addons' ),
            'percentage_value' => 76,
        ], [
            'stats_title'      => __( 'Brand Marketing', 'livemesh-el-addons' ),
            'percentage_value' => 40,
        ] ],
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ stats_title }}}',
        ] );
        $this->add_control( 'upgrade_notice', [
            'type'      => Controls_Manager::RAW_HTML,
            'separator' => 'before',
            'raw'       => '<div style="text-align:center;line-height:1.6;"><p>' . __( 'Unlock new possibilities with premium widgets and styles of <strong>Livemesh Addons for Elementor <i>Premium</i></strong>. ', 'livemesh-el-addons' ) . '</p><p style="padding-top:15px;"><a class="elementor-button elementor-button-default elementor-button-go-pro" href="https://livemeshelementor.com/pricing/#pricing-plans" target="_blank"><i class="fa fa-hand-o-right" aria-hidden="true"></i>' . __( 'Go Pro', 'livemesh-el-addons' ) . '</a></p></div>',
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
        $this->start_controls_section( 'section_stats_bar_styling', [
            'label' => __( 'Stats Bar', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'stats_bar_bg_color', [
            'label'     => __( 'Stats Bar Background Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-bar-bg' => 'background-color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'stats_bar_spacing', [
            'label'      => __( 'Stats Bar Spacing', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'default'    => [
            'size' => 18,
        ],
            'range'      => [
            'px' => [
            'min' => 5,
            'max' => 128,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-stats-bars .lae-stats-bar' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'stats_bar_height', [
            'label'      => __( 'Stats Bar Height', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'default'    => [
            'size' => 10,
        ],
            'range'      => [
            'px' => [
            'min' => 1,
            'max' => 96,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-bar-bg, {{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-bar-content' => 'height: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-bar-bg'                                                                    => 'margin-top: -{{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'stats_bar_border_radius', [
            'label'      => __( 'Stats Bar Border Radius', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-bar-bg, {{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-bar-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_stats_title', [
            'label' => __( 'Stats Title', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'stats_title_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'stats_title_typography',
            'selector' => '{{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-title',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_stats_percentage', [
            'label' => __( 'Stats Percentage', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'stats_percentage_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-title span' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'stats_percentage_typography',
            'selector' => '{{WRAPPER}} .lae-stats-bars .lae-stats-bar .lae-stats-title span',
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_stats_bars_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/stats-bars/loop', $args );
    }
    
    protected function content_template()
    {
    }

}