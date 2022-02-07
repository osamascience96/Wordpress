<?php

/*
Widget Name: Carousel
Description: Display a list of custom HTML content as a carousel.
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
class LAE_Carousel_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-carousel';
    }
    
    public function get_title()
    {
        return __( 'Carousel', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-carousel';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/carousel-addon/';
    }
    
    public function get_script_depends()
    {
        return [
            'lae-jquery-slick',
            'lae-frontend-scripts',
            'lae-carousel-helper-scripts',
            'lae-carousel-scripts'
        ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_carousel', [
            'label' => __( 'Carousel', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'carousel_heading', [
            'label' => __( 'HTML Elements', 'livemesh-el-addons' ),
            'type'  => Controls_Manager::HEADING,
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'element_title', [
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'label'       => __( 'Element Title & HTML Content', 'livemesh-el-addons' ),
            'default'     => __( 'My element title', 'livemesh-el-addons' ),
            'description' => __( 'The title to identify the HTML element', 'livemesh-el-addons' ),
        ] );
        $repeater->add_control( 'element_content', [
            'label'      => __( 'HTML Element Content', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::WYSIWYG,
            'default'    => __( 'The HTML content for the element', 'livemesh-el-addons' ),
            'show_label' => false,
            'dynamic'    => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'elements', [
            'type'        => Controls_Manager::REPEATER,
            'default'     => [
            [
            'element_title'   => 'Aliquam lorem ante',
            'element_content' => 'Suspendisse potenti. Praesent ac sem eget est egestas volutpat. Fusce neque. In hac habitasse platea dictumst. Morbi nec metus.

Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Vestibulum volutpat pretium libero. Nullam accumsan lorem in dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

In consectetuer turpis ut velit. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Vivamus laoreet. Praesent ac massa at ligula laoreet iaculis. Cras non dolor.',
        ],
            [
            'element_title'   => 'Pellentesque commodo eros',
            'element_content' => 'In hac habitasse platea dictumst. Ut a nisl id ante tempus hendrerit. Morbi mattis ullamcorper velit. Nullam sagittis. Sed a libero.

Donec mollis hendrerit risus. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent egestas neque eu enim. Donec mollis hendrerit risus.

Donec orci lectus, aliquam ut, faucibus non, euismod id, nulla. Aenean imperdiet. Nulla consequat massa quis enim. Aenean imperdiet. Fusce commodo aliquam arcu.',
        ],
            [
            'element_title'   => 'Aenean commodo ligula',
            'element_content' => 'Fusce convallis metus id felis luctus adipiscing. Suspendisse faucibus, nunc et pellentesque egestas, lacus ante convallis tellus, vitae iaculis lacus elit id tortor. Sed lectus. Etiam vitae tortor. Praesent adipiscing.

Sed in libero ut nibh placerat accumsan. Pellentesque ut neque. Donec id justo. Phasellus gravida semper nisi. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.

Vestibulum dapibus nunc ac augue. Nam at tortor in tellus interdum sagittis. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Sed lectus. Quisque ut nisi.',
        ],
            [
            'element_title'   => 'Suspendisse pulvinar augue',
            'element_content' => 'Sed aliquam ultrices mauris. Sed mollis, eros et ultrices tempus, mauris ipsum aliquam libero, non adipiscing dolor urna a orci. Etiam feugiat lorem non metus. In turpis. Morbi mattis ullamcorper velit.

Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Maecenas nec odio et ante tincidunt tempus. Ut leo. Praesent vestibulum dapibus nibh. Sed aliquam ultrices mauris.

Nunc interdum lacus sit amet orci. Nunc interdum lacus sit amet orci. Vestibulum facilisis, purus nec pulvinar iaculis, ligula mi congue nunc, vitae euismod ligula urna in dolor. Curabitur at lacus ac velit ornare lobortis. Fusce vulputate eleifend sapien.',
        ],
            [
            'element_title'   => 'Aenean tellus metus',
            'element_content' => 'Vivamus elementum semper nisi. Praesent adipiscing. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Fusce vel dui.

Sed fringilla mauris sit amet nibh. Nunc nonummy metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus blandit leo ut odio. Praesent egestas neque eu enim.

Fusce risus nisl, viverra et, tempor et, pretium in, sapien. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Sed fringilla mauris sit amet nibh. Pellentesque ut neque.',
        ]
        ],
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ element_title }}}',
        ] );
        $this->add_control( 'upgrade_notice', [
            'type'      => Controls_Manager::RAW_HTML,
            'separator' => 'before',
            'raw'       => '<div style="text-align:center;line-height:1.6;"><p>' . __( 'Unlock new possibilities with premium widgets and styles of <strong>Livemesh Addons for Elementor <i>Premium</i></strong>. ', 'livemesh-el-addons' ) . '</p><p style="padding-top:15px;"><a class="elementor-button elementor-button-default elementor-button-go-pro" href="https://livemeshelementor.com/pricing/#pricing-plans" target="_blank"><i class="fa fa-hand-o-right" aria-hidden="true"></i>' . __( 'Go Pro', 'livemesh-el-addons' ) . '</a></p></div>',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_settings', [
            'label' => __( 'Carousel Settings', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_SETTINGS,
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
            '{{WRAPPER}} .lae-carousel .slick-slide' => 'margin: 0 {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .lae-carousel .slick-list'  => 'margin: 0 -{{SIZE}}{{UNIT}};',
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
            'separator'    => 'before',
            'default'      => 'no',
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
        $this->add_control( 'autoplay', [
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'separator'    => 'before',
            'default'      => 'no',
            'label'        => __( 'Autoplay?', 'livemesh-el-addons' ),
            'description'  => __( 'Should the carousel autoplay as in a slideshow.', 'livemesh-el-addons' ),
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
        $this->end_controls_section();
        $this->start_controls_section( 'section_responsive', [
            'label' => __( 'Responsive Options', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_SETTINGS,
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
            'max'     => 25,
            'step'    => 1,
            'default' => 3,
        ] );
        $this->add_control( 'scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 25,
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
            'max'     => 20,
            'step'    => 1,
            'default' => 2,
        ] );
        $this->add_control( 'tablet_scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 20,
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
            'max'     => 10,
            'step'    => 1,
            'default' => 1,
        ] );
        $this->add_control( 'mobile_scroll_columns', [
            'label'   => __( 'Columns to scroll', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 10,
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
        $this->start_controls_section( 'section_carousel_style', [
            'label'      => __( 'Carousel', 'livemesh-el-addons' ),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ] );
        $this->add_control( 'heading_content', [
            'label'     => __( 'Content', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'after',
        ] );
        $this->add_control( 'content_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-carousel .lae-carousel-item' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'content_bg_color', [
            'label'     => __( 'Background Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-carousel .lae-carousel-item' => 'background-color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'content_typography',
            'selector' => '{{WRAPPER}} .lae-carousel .lae-carousel-item',
        ] );
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_carousel_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/carousel/loop', $args );
    }
    
    protected function content_template()
    {
    }

}