<?php

/*
Widget Name: Tab Slider
Description: Display tabbed content as a touch enabled responsive slider.
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
use  Elementor\Utils ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Tab_Slider_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-tab-slider';
    }
    
    public function get_title()
    {
        return __( 'Tab Slider', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-tab-slider1';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/';
    }
    
    public function get_script_depends()
    {
        return [ 'lae-jquery-slick', 'lae-frontend-scripts', 'lae-tab-slider-scripts' ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_tabs', [
            'label' => __( 'Tabs', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'style', [
            'type'    => Controls_Manager::SELECT,
            'label'   => __( 'Choose Style', 'livemesh-el-addons' ),
            'default' => 'style1',
            'options' => [
            'style1' => __( 'Tab Style 1', 'livemesh-el-addons' ),
            'style2' => __( 'Tab Style 2', 'livemesh-el-addons' ),
            'style3' => __( 'Tab Style 3', 'livemesh-el-addons' ),
        ],
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'icon_type', [
            'label'   => __( 'Tab Icon Type', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
            'none'       => __( 'None', 'livemesh-el-addons' ),
            'icon'       => __( 'Icon', 'livemesh-el-addons' ),
            'icon_image' => __( 'Icon Image', 'livemesh-el-addons' ),
        ],
        ] );
        $repeater->add_control( 'icon_image', [
            'label'       => __( 'Tab Image', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'label_block' => true,
            'condition'   => [
            'icon_type' => 'icon_image',
        ],
        ] );
        $repeater->add_control( 'selected_icon', [
            'label'            => __( 'Tab Icon', 'livemesh-el-addons' ),
            'type'             => Controls_Manager::ICONS,
            'label_block'      => true,
            'default'          => [
            'value'   => 'fas fa-home',
            'library' => 'fa-solid',
        ],
            'condition'        => [
            'icon_type' => 'icon',
        ],
            'fa4compatibility' => 'icon',
        ] );
        $repeater->add_control( 'tab_title', [
            'label'       => __( 'Tab Title & Content', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'Tab Title', 'livemesh-el-addons' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'tab_content', [
            'label'      => __( 'Tab Content', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::WYSIWYG,
            'default'    => __( 'Tab Content', 'livemesh-el-addons' ),
            'show_label' => false,
            'dynamic'    => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'tabs', [
            'label'       => __( 'Tab Panes', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::REPEATER,
            'separator'   => 'before',
            'default'     => [ [
            'tab_title'   => __( 'Tab #1', 'livemesh-el-addons' ),
            'tab_content' => __( 'I am tabbed content 1. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ], [
            'tab_title'   => __( 'Tab #2', 'livemesh-el-addons' ),
            'tab_content' => __( 'I am tabbed content 2. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ], [
            'tab_title'   => __( 'Tab #3', 'livemesh-el-addons' ),
            'tab_content' => __( 'I am tabbed content 3. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ] ],
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ tab_title }}}',
        ] );
        $this->add_control( 'upgrade_notice', [
            'type'      => Controls_Manager::RAW_HTML,
            'separator' => 'before',
            'raw'       => '<div style="text-align:center;line-height:1.6;"><p>' . __( 'Unlock new possibilities with premium widgets and styles of <strong>Livemesh Addons for Elementor <i>Premium</i></strong>. ', 'livemesh-el-addons' ) . '</p><p style="padding-top:15px;"><a class="elementor-button elementor-button-default elementor-button-go-pro" href="https://livemeshelementor.com/pricing/#pricing-plans" target="_blank"><i class="fa fa-hand-o-right" aria-hidden="true"></i>' . __( 'Go Pro', 'livemesh-el-addons' ) . '</a></p></div>',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_slider_settings', [
            'label' => __( 'Slider Settings', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_SETTINGS,
        ] );
        $this->add_control( 'autoplay', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'label'        => __( 'Autoplay?', 'livemesh-el-addons' ),
            'description'  => __( 'Should the tabs autoplay as in a slideshow.', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'pause_on_hover', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'label'        => __( 'Pause on Hover?', 'livemesh-el-addons' ),
            'condition'    => [
            'autoplay' => 'yes',
        ],
        ] );
        $this->add_control( 'pause_on_focus', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'label'        => __( 'Pause on Focus?', 'livemesh-el-addons' ),
            'condition'    => [
            'autoplay' => 'yes',
        ],
        ] );
        $this->add_control( 'autoplay_speed', [
            'label'     => __( 'Autoplay speed in ms', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 3000,
            'condition' => [
            'autoplay' => 'yes',
        ],
        ] );
        $this->add_control( 'animation_speed', [
            'label'   => __( 'Autoplay animation speed in ms', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 300,
        ] );
        $this->add_control( 'infinite_looping', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'label'        => __( 'Infinite Looping?', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'adaptive_height', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'label'        => __( 'Adaptive Height?', 'livemesh-el-addons' ),
            'description'  => __( 'Enables adaptive height when tabs are of different heights.', 'livemesh-el-addons' ),
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
        $this->start_controls_section( 'section_tab_title', [
            'label' => __( 'Tab Title', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'title_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-tab-slider .slick-dots li .lae-tab-slide-nav .lae-tab-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'active_title_color', [
            'label'     => __( 'Active Tab Title Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-tab-slider .slick-dots li.slick-active .lae-tab-slide-nav .lae-tab-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'hover_title_color', [
            'label'     => __( 'Tab Title Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-tab-slider .slick-dots li .lae-tab-slide-nav:hover .lae-tab-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'highlight_color', [
            'label'     => __( 'Tab highlight Border color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f94213',
            'selectors' => [
            '{{WRAPPER}} .lae-tab-slider.lae-style1 .slick-dots li.slick-active .lae-tab-slide-nav:before' => 'background: {{VALUE}};',
            '{{WRAPPER}} .lae-tab-slider.lae-style3 .slick-dots li.slick-active .lae-tab-slide-nav'        => 'border-color: {{VALUE}};',
        ],
            'condition' => [
            'style' => [ 'style1', 'style3' ],
        ],
        ] );
        $this->add_control( 'title_spacing', [
            'label'      => __( 'Tab Title Padding', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-tab-slider .slick-dots li .lae-tab-slide-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'isLinked'   => false,
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .lae-tab-slider .slick-dots li .lae-tab-slide-nav .lae-tab-title',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_tab_content', [
            'label' => __( 'Tab Content', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'content_spacing', [
            'label'      => __( 'Tab Content Padding', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-tab-slider .slick-list .lae-tab-slide .lae-tab-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'isLinked'   => false,
        ] );
        $this->add_control( 'content_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-tab-slider .slick-list .lae-tab-slide .lae-tab-slide-content' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'content_typography',
            'selector' => '{{WRAPPER}} .lae-tab-slider .slick-list .lae-tab-slide .lae-tab-slide-content',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_icon_styling', [
            'label'     => __( 'Icons', 'livemesh-el-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'style' => [ 'style2', 'style3' ],
        ],
        ] );
        $this->add_control( 'icon_size', [
            'label'      => __( 'Icon or Icon Image size in pixels', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em' ],
            'range'      => [
            'px' => [
            'min' => 10,
            'max' => 256,
        ],
        ],
            'devices'    => [ 'desktop', 'tablet', 'mobile' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-tab-slider .slick-dots li .lae-tab-slide-nav span.lae-image-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .lae-tab-slider .slick-dots li .lae-tab-slide-nav span.lae-icon-wrapper i'    => 'font-size: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'icon_color', [
            'label'     => __( 'Icon Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-tab-slider .slick-dots li .lae-tab-slide-nav span.lae-icon-wrapper i' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'active_icon_color', [
            'label'     => __( 'Active Tab Icon Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-tab-slider .slick-dots li.slick-active .lae-tab-slide-nav span.lae-icon-wrapper i' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'hover_icon_color', [
            'label'     => __( 'Hover Tab Icon Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-tab-slider .slick-dots li .lae-tab-slide-nav:hover span.lae-icon-wrapper i' => 'color: {{VALUE}};',
        ],
        ] );
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_tab_slider_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/tab-slider/loop', $args );
    }
    
    protected function content_template()
    {
    }

}