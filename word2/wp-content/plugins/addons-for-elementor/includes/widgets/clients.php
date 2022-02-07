<?php

/*
Widget Name: Clients
Description: Display one or more clients depicting a percentage value in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/
namespace LivemeshAddons\Widgets;

use  Elementor\Repeater ;
use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Utils ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Scheme_Color ;
use  Elementor\Scheme_Typography ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Clients_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-clients';
    }
    
    public function get_title()
    {
        return __( 'Clients', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-clients';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/clients-addon/';
    }
    
    public function get_script_depends()
    {
        return [
            'lae-waypoints',
            'lae-jquery-slick',
            'lae-frontend-scripts',
            'lae-carousel-helper-scripts',
            'lae-clients-scripts'
        ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_clients', [
            'label' => __( 'Clients', 'livemesh-el-addons' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'client_name', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Client Name', 'livemesh-el-addons' ),
            'label_block' => true,
            'description' => __( 'The name of the client/customer.', 'livemesh-el-addons' ),
            'default'     => __( 'My client name', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'client_link', [
            'label'       => __( 'Client URL', 'livemesh-el-addons' ),
            'description' => __( 'The website of the client/customer.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::URL,
            'label_block' => true,
            'default'     => [
            'url'         => '',
            'is_external' => 'true',
        ],
            'placeholder' => __( 'http://client-link.com', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'client_image', [
            'label'       => __( 'Client Logo/Image', 'livemesh-el-addons' ),
            'description' => __( 'The logo image for the client/customer.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'clients', [
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ client_name }}}',
        ] );
        $this->add_control( 'upgrade_notice', [
            'type'      => Controls_Manager::RAW_HTML,
            'separator' => 'before',
            'raw'       => '<div style="text-align:center;line-height:1.6;"><p>' . __( 'Unlock new possibilities with premium widgets and styles of <strong>Livemesh Addons for Elementor <i>Premium</i></strong>. ', 'livemesh-el-addons' ) . '</p><p style="padding-top:15px;"><a class="elementor-button elementor-button-default elementor-button-go-pro" href="https://livemeshelementor.com/pricing/#pricing-plans" target="_blank"><i class="fa fa-hand-o-right" aria-hidden="true"></i>' . __( 'Go Pro', 'livemesh-el-addons' ) . '</a></p></div>',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_general_settings', [
            'label' => __( 'General Settings', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_SETTINGS,
        ] );
        $this->add_control( 'layout', [
            'type'    => Controls_Manager::SELECT,
            'label'   => __( 'Choose Layout', 'livemesh-el-addons' ),
            'default' => 'grid',
            'options' => [
            'grid'     => __( 'Grid', 'livemesh-el-addons' ),
            'carousel' => __( 'Carousel', 'livemesh-el-addons' ),
        ],
        ] );
        $this->add_control( 'widget_animation', [
            "type"    => Controls_Manager::SELECT,
            "label"   => __( "Animation Type", "livemesh-el-addons" ),
            'options' => lae_get_animation_options(),
            'default' => 'none',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_carousel_settings', [
            'label'     => __( 'Carousel Settings', 'livemesh-el-addons' ),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'condition' => [
            'layout' => [ 'carousel' ],
        ],
        ] );
        $this->add_responsive_control( 'gutter', [
            'label'      => __( 'Spacing between items', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'default'    => [
            'size' => 0,
        ],
            'range'      => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-clients-carousel .slick-slide' => 'margin: 0 {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .lae-clients-carousel .slick-list'  => 'margin: 0 -{{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'arrows', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'label'        => __( 'Prev/Next Arrows?', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'dots', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'label'        => __( 'Show dot indicators for navigation?', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'pause_on_hover', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'label'        => __( 'Pause on Hover?', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'pause_on_action', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            "description"  => __( "Pause the slideshow when interacting with control elements.", "livemesh-el-addons" ),
            "label"        => __( "Pause on action?", "livemesh-el-addons" ),
        ] );
        $this->add_control( 'loop', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            "description"  => __( "Should the animation loop?", "livemesh-el-addons" ),
            "label"        => __( "Loop", "livemesh-el-addons" ),
        ] );
        $this->add_control( 'autoplay', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'label'        => __( 'Autoplay?', 'livemesh-el-addons' ),
            'description'  => __( 'Should the slider autoplay as in a slideshow.', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'autoplay_speed', [
            'label'   => __( 'Autoplay speed in ms', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 3000,
        ] );
        $this->add_control( 'animation_speed', [
            'label'   => __( 'Autoplay animation speed in ms', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 300,
        ] );
        $this->add_control( 'adaptive_height', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'label'        => __( 'Adaptive Height?', 'livemesh-el-addons' ),
            'description'  => __( 'Enables adaptive height for single slide horizontal multisliders.', 'livemesh-el-addons' ),
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_responsive', [
            'label'     => __( 'Responsive Options', 'livemesh-el-addons' ),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'condition' => [
            'layout' => [ 'carousel' ],
        ],
        ] );
        $this->add_control( 'heading_desktop', [
            'label'     => __( 'Desktop', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'after',
        ] );
        $this->add_control( 'display_columns', [
            'label'   => __( 'Columns per row', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 15,
            'step'    => 1,
            'default' => 5,
        ] );
        $this->add_control( 'scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 15,
            'step'    => 1,
            'default' => 5,
        ] );
        $this->add_control( 'heading_tablet', [
            'label'     => __( 'Tablet', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'after',
        ] );
        $this->add_control( 'tablet_display_columns', [
            'label'   => __( 'Columns per row', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 12,
            'step'    => 1,
            'default' => 4,
        ] );
        $this->add_control( 'tablet_scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 12,
            'step'    => 1,
            'default' => 4,
        ] );
        $this->add_control( 'tablet_width', [
            'label'       => __( 'Tablet Resolution', 'livemesh-el-addons' ),
            'description' => __( 'The resolution to treat as a tablet resolution.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 800,
        ] );
        $this->add_control( 'heading_mobile', [
            'label'     => __( 'Mobile Phone', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'after',
        ] );
        $this->add_control( 'mobile_display_columns', [
            'label'   => __( 'Columns per row', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 6,
            'step'    => 1,
            'default' => 2,
        ] );
        $this->add_control( 'mobile_scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 6,
            'step'    => 1,
            'default' => 2,
        ] );
        $this->add_control( 'mobile_width', [
            'label'       => __( 'Mobile Resolution', 'livemesh-el-addons' ),
            'description' => __( 'The resolution to treat as a mobile resolution.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 480,
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_grid_settings', [
            'label'     => __( 'Grid Settings', 'livemesh-el-addons' ),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'condition' => [
            'layout' => [ 'grid' ],
        ],
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
            'label'              => __( 'Columns per row', 'livemesh-el-addons' ),
            'type'               => Controls_Manager::SELECT,
            'default'            => '4',
            'tablet_default'     => '3',
            'mobile_default'     => '2',
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
            'size' => 0,
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
            'size' => 0,
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
            'label' => __( 'Clients', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'heading_client_image', [
            'label'     => __( 'Client Images', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'client_border_color', [
            'label'     => __( 'Client Border Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-clients .lae-client' => 'border-color: {{VALUE}} !important;',
        ],
        ] );
        $this->add_control( 'client_hover_bg_color', [
            'label'     => __( 'Client Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-clients .lae-client .lae-image-overlay' => 'background-color: {{VALUE}};',
        ],
        ] );
        $this->add_responsive_control( 'thumbnail_hover_opacity', [
            'label'     => __( 'Thumbnail Hover Opacity (%)', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::SLIDER,
            'default'   => [
            'size' => 0.7,
        ],
            'range'     => [
            'px' => [
            'max'  => 1,
            'min'  => 0.1,
            'step' => 0.01,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .lae-clients .lae-client:hover .lae-image-overlay' => 'opacity: {{SIZE}};',
        ],
        ] );
        $this->add_control( 'client_padding', [
            'label'       => __( 'Client Padding', 'livemesh-el-addons' ),
            'description' => __( 'Padding for the client images.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::DIMENSIONS,
            'size_units'  => [ 'px', '%', 'em' ],
            'selectors'   => [
            '{{WRAPPER}} .lae-clients .lae-client' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'heading_client_name', [
            'label'     => __( 'Client Name', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'client_name_color', [
            'label'     => __( 'Client Name Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-clients .lae-client .lae-client-name a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'client_name_hover_color', [
            'label'     => __( 'Client Name Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-clients .lae-client .lae-client-name a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'client_name_typography',
            'selector' => '{{WRAPPER}} .lae-clients .lae-client .lae-client-name a',
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_clients_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/clients/loop', $args );
    }
    
    protected function content_template()
    {
    }

}