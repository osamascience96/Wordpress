<?php

/*
Widget Name: Testimonials Slider
Description: Display responsive touch friendly slider of testimonials from clients/customers.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/
namespace LivemeshAddons\Widgets;

use  Elementor\Repeater ;
use  Elementor\Controls_Manager ;
use  Elementor\Utils ;
use  Elementor\Scheme_Color ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Scheme_Typography ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Testimonials_Slider_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-testimonials-slider';
    }
    
    public function get_title()
    {
        return __( 'Testimonials Slider', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-testimonials1';
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
            'lae-jquery-slick',
            'lae-frontend-scripts',
            'lae-carousel-helper-scripts',
            'lae-testimonials-slider-scripts'
        ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_testimonials_slider', [
            'label' => __( 'Testimonials Slider', 'livemesh-el-addons' ),
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
            'description' => __( 'The details of the client/customer like company name, position held, company URL etc. HTML accepted.', 'livemesh-el-addons' ),
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
        $this->add_control( 'testimonials', [
            'label'       => __( 'Testimonials', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::REPEATER,
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
        $this->start_controls_section( 'section_settings', [
            'label' => __( 'Slider Settings', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_SETTINGS,
        ] );
        $this->add_control( 'slide_animation', [
            'label'   => __( 'Animation', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => [
            'slide' => __( 'Slide', 'livemesh-el-addons' ),
            'fade'  => __( 'Fade', 'livemesh-el-addons' ),
        ],
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
        $this->add_control( 'slideshow_speed', [
            'label'   => __( 'Slideshow Speed', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 5000,
        ] );
        $this->add_control( 'animation_speed', [
            'label'   => __( 'Animation Speed', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 600,
        ] );
        $this->add_control( 'pause_on_hover', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'separator'    => 'before',
            'default'      => 'yes',
            'label'        => __( 'Pause on Hover?', 'livemesh-el-addons' ),
            'description'  => __( 'Should the slider pause on mouse hover over the slider.', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'pause_on_action', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'label'        => __( 'Pause slider on action?', 'livemesh-el-addons' ),
            'description'  => __( 'Should the slideshow pause once user initiates an action using navigation/direction controls.', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'smooth_height', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'label'        => __( 'Smooth Height?', 'livemesh-el-addons' ),
            'description'  => __( 'Animate the height of the slider smoothly for slides of varying height.', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'direction_nav', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'separator'    => 'before',
            'default'      => 'yes',
            'label'        => __( 'Direction Navigation?', 'livemesh-el-addons' ),
            'description'  => __( 'Should the slider have direction navigation?', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'control_nav', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
            'label'        => __( 'Navigation Controls?', 'livemesh-el-addons' ),
            'description'  => __( 'Should the slider have navigation controls?', 'livemesh-el-addons' ),
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
            'label'      => __( 'Author Thumbnail Border Radius', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-user .lae-image-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'thumbnail_size', [
            'label'      => __( 'Author Thumbnail Size', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ '%', 'px' ],
            'range'      => [
            '%'  => [
            'min' => 10,
            'max' => 100,
        ],
            'px' => [
            'min' => 50,
            'max' => 300,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-user .lae-image-wrapper img' => 'max-width: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_testimonials_text', [
            'label' => __( 'Author Testimonial', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'text_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-text' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'text_typography',
            'selector' => '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-text',
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
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-user .lae-user-text .lae-author-name' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-user .lae-user-text .lae-author-name',
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
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-user .lae-user-text' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'credential_typography',
            'selector' => '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-user .lae-user-text',
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
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-star-rating .lae-testimonial-star-rating-item svg' => 'fill: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'rating_highlight_color', [
            'label'     => __( 'Highlight Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-five .lae-testimonial-star-rating .lae-testimonial-star-rating-item svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-one .lae-testimonial-star-rating .lae-testimonial-star-rating-item:first-child svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-two .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(1) svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-two .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(2) svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-three .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(1) svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-three .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(2) svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-three .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(3) svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-four .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(1) svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-four .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(2) svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-four .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(3) svg,{{WRAPPER}} .lae-testimonials-slider .lae-testimonial.lae-rating-four .lae-testimonial-star-rating .lae-testimonial-star-rating-item:nth-child(4) svg' => 'fill: {{VALUE}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_quote_icon_styling', [
            'label' => __( 'Quote Icon', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'quote_icon_size', [
            'label'      => __( 'Icon size in pixels', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em' ],
            'range'      => [
            'px' => [
            'min' => 10,
            'max' => 128,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-text i' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'quote_icon_color', [
            'label'     => __( 'Icon Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-testimonials-slider .lae-testimonial .lae-testimonial-text i' => 'color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings['slider_id'] = $this->get_id();
        $settings = apply_filters( 'lae_testimonials_slider_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/testimonials-slider/loop', $args );
    }
    
    protected function content_template()
    {
    }

}