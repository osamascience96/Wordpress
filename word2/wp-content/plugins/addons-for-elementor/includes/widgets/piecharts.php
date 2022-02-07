<?php

/*
Widget Name: Piecharts
Description: Display one or more piecharts depicting a percentage value in a multi-column grid.
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
class LAE_Piecharts_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-piecharts';
    }
    
    public function get_title()
    {
        return __( 'Piecharts', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-piechart3';
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
            'lae-piecharts-scripts'
        ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_piecharts', [
            'label' => __( 'Piecharts', 'livemesh-el-addons' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'stats_title', [
            'label'       => __( 'Stats Title', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'My stats title', 'livemesh-el-addons' ),
            'description' => __( 'The title for the piechart', 'livemesh-el-addons' ),
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
        $this->add_control( 'piecharts', [
            'type'        => Controls_Manager::REPEATER,
            'default'     => [
            [
            'stats_title'      => __( 'Web Design', 'livemesh-el-addons' ),
            'percentage_value' => 87,
        ],
            [
            'stats_title'      => __( 'SEO Services', 'livemesh-el-addons' ),
            'percentage_value' => 76,
        ],
            [
            'stats_title'      => __( 'WordPress Development', 'livemesh-el-addons' ),
            'percentage_value' => 90,
        ],
            [
            'stats_title'      => __( 'Brand Marketing', 'livemesh-el-addons' ),
            'percentage_value' => 40,
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
            'size' => 240,
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
            'label'              => __( 'Piecharts per row', 'livemesh-el-addons' ),
            'type'               => Controls_Manager::SELECT,
            'default'            => '4',
            'tablet_default'     => '2',
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
        $this->start_controls_section( 'section_styling', [
            'label' => __( 'Piechart Styling', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'bar_color', [
            'label'   => __( 'Bar color', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::COLOR,
            'default' => '#f94213',
        ] );
        $this->add_control( 'track_color', [
            'label'   => __( 'Track color', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::COLOR,
            'default' => '#dddddd',
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
            '{{WRAPPER}} .lae-piechart .lae-label' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'stats_title_typography',
            'selector' => '{{WRAPPER}} .lae-piechart .lae-label',
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
            '{{WRAPPER}} .lae-piechart .lae-percentage span' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'stats_percentage_typography',
            'selector' => '{{WRAPPER}} .lae-piechart .lae-percentage span',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_stats_percentage_symbol', [
            'label' => __( 'Stats Percentage Symbol', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'stats_percentage_symbol_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-piechart .lae-percentage sup' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'stats_percentage_symbol_typography',
            'selector' => '{{WRAPPER}} .lae-piechart .lae-percentage sup',
        ] );
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_piecharts_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/piecharts/loop', $args );
    }
    
    protected function content_template()
    {
    }

}