<?php

/*
Widget Name: Message Box
Description: Display messages to the user that can be dismissed.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/
namespace LivemeshAddons\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\utils ;
use  Elementor\Scheme_Color ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Scheme_Typography ;
use  Elementor\Icons_Manager ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Message_Box_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-message-box';
    }
    
    public function get_title()
    {
        return __( 'Message Box', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'eicon-alert';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/message-box-addon/';
    }
    
    public function get_script_depends()
    {
        return [ 'lae-frontend-scripts', 'lae-message-box-scripts' ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_message_box', [
            'label' => __( 'Message Box', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'message_title', [
            'label'       => __( 'Message Title', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => __( 'My message title', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'message_text', [
            'label'       => __( 'Message text', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => __( 'Message text goes here', 'livemesh-el-addons' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'icon_type', [
            'label'   => __( 'Icon Type', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'icon',
            'options' => [
            'none'       => __( 'None', 'livemesh-el-addons' ),
            'icon'       => __( 'Icon', 'livemesh-el-addons' ),
            'icon_image' => __( 'Icon Image', 'livemesh-el-addons' ),
        ],
        ] );
        $this->add_control( 'icon_image', [
            'label'       => __( 'Message Image', 'livemesh-el-addons' ),
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
        $this->add_control( 'selected_icon', [
            'label'            => __( 'Message Icon', 'livemesh-el-addons' ),
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
        $this->add_control( 'upgrade_notice', [
            'type'      => Controls_Manager::RAW_HTML,
            'separator' => 'before',
            'raw'       => '<div style="text-align:center;line-height:1.6;"><p>' . __( 'Unlock new possibilities with premium widgets and styles of <strong>Livemesh Addons for Elementor <i>Premium</i></strong>. ', 'livemesh-el-addons' ) . '</p><p style="padding-top:15px;"><a class="elementor-button elementor-button-default elementor-button-go-pro" href="https://livemeshelementor.com/pricing/#pricing-plans" target="_blank"><i class="fa fa-hand-o-right" aria-hidden="true"></i>' . __( 'Go Pro', 'livemesh-el-addons' ) . '</a></p></div>',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_message_box_styling', [
            'label' => __( 'Message Box', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'message_box_background_color', [
            'label'     => __( 'Background Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-message-box' => 'background-color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'message_box_background_image', [
            'label'     => __( 'Background Image', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::MEDIA,
            'selectors' => [
            '{{WRAPPER}} .lae-message-box' => 'background-image: url({{URL}})',
        ],
        ] );
        $this->add_control( 'message_box_background_size', [
            'label'      => __( 'Background Size', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SELECT,
            'default'    => 'cover',
            'options'    => [
            'cover'   => __( 'Cover', 'livemesh-el-addons' ),
            'contain' => __( 'Contain', 'livemesh-el-addons' ),
            'auto'    => __( 'Auto', 'livemesh-el-addons' ),
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-message-box' => 'background-size: {{VALUE}}',
        ],
            'conditions' => [
            'terms' => [ [
            'name'     => 'message_box_background_image[url]',
            'operator' => '!=',
            'value'    => '',
        ] ],
        ],
        ] );
        $this->add_control( 'message_box_border_radius', [
            'label'      => __( 'Border Radius', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-message-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'message_box_padding', [
            'label'      => __( 'Custom Padding', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-message-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_message_title', [
            'label' => __( 'Message Title', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'message_title_tag', [
            'label'   => __( 'Title HTML Tag', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
            'h1'  => __( 'H1', 'livemesh-el-addons' ),
            'h2'  => __( 'H2', 'livemesh-el-addons' ),
            'h3'  => __( 'H3', 'livemesh-el-addons' ),
            'h4'  => __( 'H4', 'livemesh-el-addons' ),
            'h5'  => __( 'H5', 'livemesh-el-addons' ),
            'h6'  => __( 'H6', 'livemesh-el-addons' ),
            'div' => __( 'div', 'livemesh-el-addons' ),
        ],
            'default' => 'h3',
        ] );
        $this->add_control( 'message_title_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-message-box .lae-message-wrap .lae-message-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'message_title_typography',
            'selector' => '{{WRAPPER}} .lae-message-box .lae-message-wrap .lae-message-title',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_message_text', [
            'label' => __( 'Message Text', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'message_text_margin_top', [
            'label'      => __( 'Margin Top', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [
            'px' => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ],
        ],
            'default'    => [
            'unit' => 'px',
            'size' => 10,
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-message-box .lae-message-wrap .lae-message-text' => 'margin-top: {{SIZE}}{{UNIT}}',
        ],
        ] );
        $this->add_control( 'message_text_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-message-box .lae-message-wrap .lae-message-text' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'message_text_typography',
            'selector' => '{{WRAPPER}} .lae-message-box .lae-message-wrap .lae-message-text',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_message_icon', [
            'label'     => __( 'Message Icon', 'livemesh-el-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'icon_type!' => 'none',
        ],
        ] );
        $this->add_responsive_control( 'message_icon_size', [
            'label'      => __( 'Icon or Icon Image size in pixels', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em' ],
            'range'      => [
            'px' => [
            'min' => 10,
            'min' => 10,
            'max' => 300,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-message-box .lae-image-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .lae-message-box .lae-icon-wrapper i'    => 'font-size: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'message_icon_color', [
            'label'     => __( 'Icon Custom Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
            'icon_type' => 'icon',
        ],
            'selectors' => [
            '{{WRAPPER}} .lae-message-box .lae-icon-wrapper i' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_responsive_control( 'message_icon_margin', [
            'label'      => __( 'Margin', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'default'    => [
            'top'      => '',
            'right'    => '20',
            'bottom'   => '0',
            'left'     => '0',
            'unit'     => 'px',
            'isLinked' => false,
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-message-box .lae-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} .lae-message-box .lae-icon-wrapper'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'message_icon_alignment', [
            'type'      => Controls_Manager::SELECT,
            'label'     => __( 'Choose Alignment', 'livemesh-el-addons' ),
            'default'   => 'start',
            'options'   => [
            'start'  => __( 'Top', 'livemesh-el-addons' ),
            'end'    => __( 'Bottom', 'livemesh-el-addons' ),
            'center' => __( 'Center', 'livemesh-el-addons' ),
        ],
            'selectors' => [
            '{{WRAPPER}} .lae-message-box .lae-message-icon' => 'align-self: {{VALUE}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_close_icon', [
            'label' => __( 'Close Icon', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'close_icon_size', [
            'label'      => __( 'Icon or Icon Image size in pixels', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em' ],
            'range'      => [
            'px' => [
            'min' => 10,
            'max' => 300,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-message-box .lae-close-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'close_icon_color', [
            'label'     => __( 'Icon Custom Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-message-box .lae-close-icon i' => 'color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_message_box_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/message-box/content', $args );
    }
    
    protected function content_template()
    {
    }

}