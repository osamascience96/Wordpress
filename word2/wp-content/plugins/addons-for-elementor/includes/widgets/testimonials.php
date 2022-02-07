<?php

/*
Widget Name: Testimonials
Description: Display testimonials from your clients/customers in a multi-column grid.
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
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Testimonials_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-testimonials';
    }
    
    public function get_title()
    {
        return __( 'Testimonials', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-testimonials3';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/testimonials-addons/';
    }
    
    public function get_script_depends()
    {
        return [
            'lae-waypoints',
            'lae-jquery-slick',
            'lae-frontend-scripts',
            'lae-carousel-helper-scripts',
            'lae-testimonials-scripts'
        ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_testimonials', [
            'label' => __( 'Testimonials', 'livemesh-el-addons' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'client_name', [
            'label'       => __( 'Name', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'My client name', 'livemesh-el-addons' ),
            'description' => __( 'The client or customer name for the testimonial', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'credentials', [
            'label'       => __( 'Client Details', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'description' => __( 'The details of the client/customer like company name, credential held, company URL etc. HTML accepted.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'testimonial_rating', [
            'label'   => __( 'Rating', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'rating-none',
            'options' => [
            'rating-none'  => __( 'None', 'livemesh-el-addons' ),
            'rating-one'   => __( '1', 'livemesh-el-addons' ),
            'rating-two'   => __( '2', 'livemesh-el-addons' ),
            'rating-three' => __( '3', 'livemesh-el-addons' ),
            'rating-four'  => __( '4', 'livemesh-el-addons' ),
            'rating-five'  => __( '5', 'livemesh-el-addons' ),
        ],
        ] );
        $repeater->add_control( 'client_image', [
            'label'       => __( 'Customer/Client Image', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'testimonial_text', [
            'label'       => __( 'Testimonials Text', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::WYSIWYG,
            'description' => __( 'What your customer/client had to say', 'livemesh-el-addons' ),
            'show_label'  => false,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( "widget_animation", [
            "type"    => Controls_Manager::SELECT,
            "label"   => __( "Animation Type", "livemesh-el-addons" ),
            'options' => lae_get_animation_options(),
            'default' => 'none',
            'dynamic' => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'testimonials', [
            'label'       => __( 'Testimonials', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::REPEATER,
            'separator'   => 'before',
            'default'     => [ [
            'client_name'        => __( 'Customer #1', 'livemesh-el-addons' ),
            'credentials'        => __( 'CEO, Invision Inc.', 'livemesh-el-addons' ),
            'testimonial_rating' => 'rating-four',
            'testimonial_text'   => __( 'I am testimonial text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ], [
            'client_name'        => __( 'Customer #2', 'livemesh-el-addons' ),
            'credentials'        => __( 'Lead Developer, Automattic Inc', 'livemesh-el-addons' ),
            'testimonial_rating' => 'rating-five',
            'testimonial_text'   => __( 'I am testimonial text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ], [
            'client_name'        => __( 'Customer #3', 'livemesh-el-addons' ),
            'credentials'        => __( 'Store Manager, Walmart Inc', 'livemesh-el-addons' ),
            'testimonial_rating' => 'rating-four',
            'testimonial_text'   => __( 'I am testimonial text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ] ],
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
        $this->add_control( 'style', [
            'type'    => Controls_Manager::SELECT,
            'label'   => __( 'Choose Testimonials Style', 'livemesh-el-addons' ),
            'default' => 'style1',
            'options' => [
            'style1' => __( 'Style 1', 'livemesh-el-addons' ),
            'style2' => __( 'Style 2', 'livemesh-el-addons' ),
            'style3' => __( 'Style 3', 'livemesh-el-addons' ),
            'style4' => __( 'Style 4 (List)', 'livemesh-el-addons' ),
        ],
        ] );
        $this->add_control( 'layout', [
            'type'      => Controls_Manager::SELECT,
            'label'     => __( 'Choose Layout', 'livemesh-el-addons' ),
            'default'   => 'grid',
            'options'   => [
            'grid'     => __( 'Grid', 'livemesh-el-addons' ),
            'carousel' => __( 'Carousel', 'livemesh-el-addons' ),
        ],
            'condition' => [
            'style' => [ 'style1', 'style2', 'style3' ],
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_carousel_settings', [
            'label'     => __( 'Carousel Settings', 'livemesh-el-addons' ),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'condition' => [
            'style'  => [ 'style1', 'style2', 'style3' ],
            'layout' => [ 'carousel' ],
        ],
        ] );
        $this->add_responsive_control( 'gutter', [
            'label'      => __( 'Spacing between items', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'default'    => [
            'size' => 10,
        ],
            'range'      => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-testimonials-carousel .slick-slide' => 'margin: 0 {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .lae-testimonials-carousel .slick-list'  => 'margin: 0 -{{SIZE}}{{UNIT}};',
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
            'default'      => 'no',
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
            'style'  => [ 'style1', 'style2', 'style3' ],
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
            'max'     => 5,
            'step'    => 1,
            'default' => 3,
        ] );
        $this->add_control( 'scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 5,
            'step'    => 1,
            'default' => 3,
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
            'max'     => 5,
            'step'    => 1,
            'default' => 2,
        ] );
        $this->add_control( 'tablet_scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 5,
            'step'    => 1,
            'default' => 2,
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
            'max'     => 3,
            'step'    => 1,
            'default' => 1,
        ] );
        $this->add_control( 'mobile_scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 3,
            'step'    => 1,
            'default' => 1,
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
            'style'  => [ 'style1', 'style2', 'style3' ],
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
            'size' => 300,
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
            'default'            => '3',
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
        $this->start_controls_section( 'section_testimonials_thumbnail', [
            'label'      => __( 'Author Thumbnail', 'livemesh-el-addons' ),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ] );
        $this->add_control( 'thumbnail_border_radius', [
            'label'      => __( 'Thumbnail Border Radius', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial-user .lae-image-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'thumbnail_size', [
            'label'      => __( 'Thumbnail Size', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ '%', 'px' ],
            'range'      => [
            '%'  => [
            'min' => 10,
            'max' => 100,
        ],
            'px' => [
            'min' => 50,
            'max' => 156,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial-user .lae-image-wrapper img' => 'max-width: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_testimonials_text', [
            'label' => __( 'Author Testimonial', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'text_padding', [
            'label'      => __( 'Text Padding', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'isLinked'   => false,
            'condition'  => [
            'style' => [ 'style1', 'style3' ],
        ],
        ] );
        $this->add_control( 'text_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial-text' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'text_border_color', [
            'label'     => __( 'Border Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial-text, {{WRAPPER}} .lae-testimonials .lae-testimonial-text:after' => 'border-color: {{VALUE}};',
        ],
            'condition' => [
            'style' => [ 'style1' ],
        ],
        ] );
        $this->add_control( 'text_border_width', [
            'label'     => __( 'Border Width', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 1,
            'max' => 5,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial-text, {{WRAPPER}} .lae-testimonials .lae-testimonial-text:after' => 'border-width: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'style' => [ 'style1' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'text_typography',
            'selector' => '{{WRAPPER}} .lae-testimonials .lae-testimonial-text',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_testimonials_author_name', [
            'label' => __( 'Author Name', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'title_tag', [
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
            'default' => 'h4',
        ] );
        $this->add_control( 'title_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial-user .lae-user-text .lae-author-name' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .lae-testimonials .lae-testimonial-user .lae-user-text .lae-author-name',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_testimonials_author_credentials', [
            'label' => __( 'Author Credentials', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'credential_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial-user .lae-user-text' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'credential_typography',
            'selector' => '{{WRAPPER}} .lae-testimonials .lae-testimonial-user .lae-user-text',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_testimonials_rating', [
            'label'      => __( 'Author Star Rating', 'livemesh-el-addons' ),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ] );
        $this->add_control( 'rating_color', [
            'label'     => __( 'Default Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial .lae-testimonial-star-rating .lae-testimonial-star-rating-item svg' => 'fill: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'rating_highlight_color', [
            'label'     => __( 'Highlight Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-five .lae-testimonial-star-rating .lae-testimonial-star-rating-item svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-one .lae-testimonial-star-rating .lae-testimonial-star-rating-item:first-child svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-two .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(1) svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-two .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(2) svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-three .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(1) svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-three .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(2) svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-three .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(3) svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-four .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(1) svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-four .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(2) svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-four .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(3) svg,{{WRAPPER}} .lae-testimonials .lae-testimonial.lae-rating-four .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(4) svg' => 'fill: {{VALUE}};',
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_testimonials_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/testimonials/loop', $args );
    }
    
    protected function content_template()
    {
    }

}