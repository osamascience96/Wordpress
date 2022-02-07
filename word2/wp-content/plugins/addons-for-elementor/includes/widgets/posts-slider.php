<?php

/*
Widget Name: Posts Slider
Description: Display blog posts or custom post types as a slider.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/
namespace LivemeshAddons\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Scheme_Color ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Scheme_Typography ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Posts_Slider_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-posts-slider';
    }
    
    public function get_title()
    {
        return __( 'Posts Slider', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-slider6';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/posts-slider/';
    }
    
    public function get_script_depends()
    {
        return [ 'lae-jquery-slick', 'lae-frontend-scripts', 'lae-posts-slider-scripts' ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_query', [
            'label' => __( 'Posts Query', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'query_type', [
            'label'   => __( 'Source', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::SELECT,
            'options' => array(
            'custom_query'  => __( 'Custom Query', 'livemesh-el-addons' ),
            'current_query' => __( 'Current Query', 'livemesh-el-addons' ),
            'related'       => __( 'Related', 'livemesh-el-addons' ),
        ),
            'default' => 'custom_query',
        ] );
        $this->add_control( 'post_types', [
            'label'     => __( 'Post Types', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::SELECT2,
            'default'   => 'post',
            'options'   => lae_get_all_post_type_options(),
            'multiple'  => true,
            'condition' => [
            'query_type' => 'custom_query',
        ],
        ] );
        $this->add_control( 'taxonomies', [
            'type'        => Controls_Manager::SELECT2,
            'label'       => __( 'Choose the taxonomies to display related posts.', 'livemesh-el-addons' ),
            'label_block' => true,
            'description' => __( 'Choose the taxonomies to be used for displaying posts related to current post, page or custom post type.', 'livemesh-el-addons' ),
            'options'     => lae_get_taxonomies_map(),
            'default'     => 'category',
            'multiple'    => true,
            'condition'   => [
            'query_type' => 'related',
        ],
        ] );
        $this->add_control( 'tax_query', [
            'label'       => __( 'Taxonomies', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::SELECT2,
            'options'     => lae_get_all_taxonomy_options(),
            'multiple'    => true,
            'label_block' => true,
            'condition'   => [
            'query_type' => 'custom_query',
        ],
        ] );
        $this->add_control( 'post_in', [
            'label'       => __( 'Post In', 'livemesh-el-addons' ),
            'description' => __( 'Provide a comma separated list of Post IDs to display in the grid.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'condition'   => [
            'query_type' => 'custom_query',
        ],
        ] );
        $this->add_control( 'posts_per_page', [
            'label'     => __( 'Posts Per Page', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::NUMBER,
            'min'       => 1,
            'max'       => 50,
            'step'      => 1,
            'default'   => 6,
            'condition' => [
            'query_type' => [ 'custom_query', 'related' ],
        ],
        ] );
        $this->add_control( 'advanced', [
            'label'     => __( 'Advanced', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::HEADING,
            'condition' => [
            'query_type' => [ 'custom_query', 'related' ],
        ],
        ] );
        $this->add_control( 'orderby', [
            'label'     => __( 'Order By', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => array(
            'none'          => __( 'No order', 'livemesh-el-addons' ),
            'ID'            => __( 'Post ID', 'livemesh-el-addons' ),
            'author'        => __( 'Author', 'livemesh-el-addons' ),
            'title'         => __( 'Title', 'livemesh-el-addons' ),
            'date'          => __( 'Published date', 'livemesh-el-addons' ),
            'modified'      => __( 'Modified date', 'livemesh-el-addons' ),
            'parent'        => __( 'By parent', 'livemesh-el-addons' ),
            'rand'          => __( 'Random order', 'livemesh-el-addons' ),
            'comment_count' => __( 'Comment count', 'livemesh-el-addons' ),
            'menu_order'    => __( 'Menu order', 'livemesh-el-addons' ),
            'post__in'      => __( 'By include order', 'livemesh-el-addons' ),
        ),
            'default'   => 'date',
            'condition' => [
            'query_type' => [ 'custom_query', 'related' ],
        ],
        ] );
        $this->add_control( 'order', [
            'label'     => __( 'Order', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => array(
            'ASC'  => __( 'Ascending', 'livemesh-el-addons' ),
            'DESC' => __( 'Descending', 'livemesh-el-addons' ),
        ),
            'default'   => 'DESC',
            'condition' => [
            'query_type' => [ 'custom_query', 'related' ],
        ],
        ] );
        $this->add_control( 'exclude_posts', [
            'label'       => __( 'Exclude Posts', 'livemesh-el-addons' ),
            'description' => __( 'Provide a comma separated list of Post IDs to exclude in the slider.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            'condition'   => [
            'query_type' => [ 'custom_query', 'related' ],
        ],
        ] );
        $this->add_control( 'offset', [
            'label'       => __( 'Offset', 'livemesh-el-addons' ),
            'description' => __( 'Number of posts to skip or pass over.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 0,
            'condition'   => [
            'query_type' => 'custom_query',
        ],
        ] );
        $this->add_control( 'upgrade_notice', [
            'type'      => Controls_Manager::RAW_HTML,
            'separator' => 'before',
            'raw'       => '<div style="text-align:center;line-height:1.6;"><p>' . __( 'Unlock new possibilities with premium widgets and styles of <strong>Livemesh Addons for Elementor <i>Premium</i></strong>. ', 'livemesh-el-addons' ) . '</p><p style="padding-top:15px;"><a class="elementor-button elementor-button-default elementor-button-go-pro" href="https://livemeshelementor.com/pricing/#pricing-plans" target="_blank"><i class="fa fa-hand-o-right" aria-hidden="true"></i>' . __( 'Go Pro', 'livemesh-el-addons' ) . '</a></p></div>',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_post_content', [
            'label' => __( 'Post Content', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'taxonomy_chosen', [
            'label'       => __( 'Choose the taxonomy to display info.', 'livemesh-el-addons' ),
            'description' => __( 'Choose the taxonomy to use for display of taxonomy information for posts/custom post types.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::SELECT,
            'label_block' => true,
            'default'     => 'category',
            'options'     => lae_get_taxonomies_map(),
        ] );
        $this->add_control( 'display_thumbnail', [
            'label'        => __( 'Display post thumbnail?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'image_linkable', [
            'label'        => __( 'Link Images to Posts?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => [
            'display_thumbnail' => 'yes',
        ],
        ] );
        $this->add_control( 'post_link_new_window', [
            'label'        => __( 'Open post links in new window?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => '',
        ] );
        $this->add_control( 'display_title', [
            'label'        => __( 'Display posts title?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'display_taxonomy', [
            'label'        => __( 'Display taxonomy info?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'display_author', [
            'label'        => __( 'Display post author info?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'display_post_date', [
            'label'        => __( 'Display post date info?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'display_comments', [
            'label'        => __( 'Display post comments?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'display_summary', [
            'label'        => __( 'Display post excerpt/summary?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
        ] );
        $this->add_control( 'display_read_more', [
            'label'        => __( 'Display read more link to the post/portfolio?', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
        ] );
        $this->add_control( 'read_more_text', [
            'label'       => __( 'Read more text', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXT,
            "description" => __( 'Specify the text for the read more link/button', 'livemesh-el-addons' ),
            'default'     => __( 'Read More', 'livemesh-el-addons' ),
            'condition'   => [
            'display_read_more' => [ 'yes' ],
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_slider_settings', [
            'label' => __( 'Slider Settings', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_SETTINGS,
        ] );
        $slider_styles = array(
            'style-1' => __( 'Slider Style 1', 'livemesh-el-addons' ),
            'style-2' => __( 'Slider Style 2', 'livemesh-el-addons' ),
        );
        $this->add_control( 'slider_style', [
            'type'    => Controls_Manager::SELECT,
            'label'   => __( 'Choose Slider Style', 'livemesh-el-addons' ),
            'options' => $slider_styles,
            'default' => 'style-1',
        ] );
        $this->add_control( 'slider_height', [
            'label'   => __( 'Slider height', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 400,
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
            'description'  => __( 'Enables adaptive height for single slide horizontal sliders.', 'livemesh-el-addons' ),
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_slider_arrows', [
            'label'     => __( 'Slider Arrow Settings', 'livemesh-el-addons' ),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'condition' => [
            'arrows' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'arrows_placement', [
            'type'         => Controls_Manager::SELECT,
            'label'        => __( 'Placement', 'livemesh-el-addons' ),
            'options'      => array(
            'middle-center' => __( 'Middle Center', 'livemesh-el-addons' ),
            'bottom-center' => __( 'Bottom Center', 'livemesh-el-addons' ),
            'top-left'      => __( 'Top Left', 'livemesh-el-addons' ),
            'top-right'     => __( 'Top Right', 'livemesh-el-addons' ),
            'bottom-left'   => __( 'Bottom Left', 'livemesh-el-addons' ),
            'bottom-right'  => __( 'Bottom Right', 'livemesh-el-addons' ),
        ),
            'default'      => 'middle-center',
            'prefix_class' => 'lae-slider-arrow-placement-',
        ] );
        $this->add_control( 'arrows_shape', [
            'type'         => Controls_Manager::SELECT,
            'label'        => __( 'Shape', 'livemesh-el-addons' ),
            'options'      => array(
            'square'          => __( 'Square', 'livemesh-el-addons' ),
            'rounded-corners' => __( 'Square with Rounded Corners', 'livemesh-el-addons' ),
            'circle'          => __( 'Circle', 'livemesh-el-addons' ),
        ),
            'default'      => 'circle',
            'prefix_class' => 'lae-slider-arrow-shape-',
        ] );
        $this->add_control( 'arrows_color', [
            'type'         => Controls_Manager::SELECT,
            'label'        => __( 'Color', 'livemesh-el-addons' ),
            'options'      => array(
            'dark'  => __( 'Dark', 'livemesh-el-addons' ),
            'light' => __( 'Light', 'livemesh-el-addons' ),
        ),
            'default'      => 'dark',
            'prefix_class' => 'lae-slider-arrow-color-',
        ] );
        $this->add_control( 'arrows_visibility', [
            'type'         => Controls_Manager::SELECT,
            'label'        => __( 'Visibility', 'livemesh-el-addons' ),
            'options'      => array(
            'always'   => __( 'Show Always', 'livemesh-el-addons' ),
            'on-hover' => __( 'Show on Hover', 'livemesh-el-addons' ),
        ),
            'default'      => 'always',
            'prefix_class' => 'lae-slider-arrow-visibility-',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_slider_item_taxonomy_terms', [
            'label' => __( 'Post Taxonomy Terms', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'taxonomy_terms_color', [
            'label'     => __( 'Taxonomy Terms Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-terms, {{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-terms a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'taxonomy_terms_hover_color', [
            'label'     => __( 'Taxonomy Terms Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-terms a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'taxonomy_terms_typography',
            'selector' => '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-terms, {{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-terms a',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_entry_title_styling', [
            'label' => __( 'Post Entry Title', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'entry_title_tag', [
            'label'   => __( 'Entry Title HTML Tag', 'livemesh-el-addons' ),
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
        $this->add_control( 'entry_title_color', [
            'label'     => __( 'Entry Title Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-title a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'entry_title_hover_color', [
            'label'     => __( 'Entry Title Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-title a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'entry_title_typography',
            'selector' => '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-title a',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_entry_meta_styling', [
            'label' => __( 'Post Entry Meta', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'entry_meta_color', [
            'label'     => __( 'Entry Meta Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-meta span' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'entry_meta_link_color', [
            'label'     => __( 'Entry Meta Link Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-meta span a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'entry_meta_link_hover_color', [
            'label'     => __( 'Entry Meta Link Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-meta span a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'entry_meta_typography',
            'selector' => '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-meta span, {{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-meta span a',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_entry_summary_styling', [
            'label' => __( 'Post Entry Summary', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'entry_summary_color', [
            'label'     => __( 'Entry Summary Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-summary' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'entry_summary_typography',
            'selector' => '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-post-summary',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_read_more_styling', [
            'label' => __( 'Read More', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'read_more_color', [
            'label'     => __( 'Read More Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-read-more' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'read_more_hover_color', [
            'label'     => __( 'Read More Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-read-more:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'read_more_text_color', [
            'label'     => __( 'Read More Text Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-read-more' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'read_more_hover_text_color', [
            'label'     => __( 'Read More Hover Text Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-read-more:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'read_more_typography',
            'selector' => '{{WRAPPER}} .lae-posts-slider .lae-posts-slider-item .lae-post-text .lae-read-more',
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings['slider_id'] = $this->get_id();
        $settings = apply_filters( 'lae_posts_slider_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        lae_get_template_part( 'addons/posts-slider/loop', $args );
    }
    
    protected function content_template()
    {
    }

}