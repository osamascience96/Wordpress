<?php

/*
Widget Name: Team Members
Description: Display a list of your team members optionally in a multi-column grid.
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
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Scheme_Typography ;
use  Elementor\Modules\DynamicTags\Module as TagsModule ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class LAE_Team_Widget extends LAE_Widget_Base
{
    public function get_name()
    {
        return 'lae-team-members';
    }
    
    public function get_title()
    {
        return __( 'Team Members', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-team4';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/team-members/';
    }
    
    public function get_script_depends()
    {
        return [
            'lae-waypoints',
            'lae-jquery-slick',
            'lae-frontend-scripts',
            'lae-carousel-helper-scripts',
            'lae-team-members-scripts'
        ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_team', [
            'label' => __( 'Team', 'livemesh-el-addons' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'member_name', [
            'label'   => __( 'Member Name', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'My team member name', 'livemesh-el-addons' ),
            'dynamic' => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'member_position', [
            'label'   => __( 'Position', 'livemesh-el-addons' ),
            'type'    => Controls_Manager::TEXT,
            'dynamic' => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'member_image', [
            'label'       => __( 'Team Member Image', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'member_link', [
            'label'       => __( 'Team Member URL', 'livemesh-el-addons' ),
            'description' => __( 'The link for the page describing the team member.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::URL,
            'label_block' => true,
            'default'     => [
            'url'         => '',
            'is_external' => 'true',
        ],
            'placeholder' => __( 'http://member-link.com', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'member_details', [
            'label'       => __( 'Team Member details', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => __( 'Details about team member', 'livemesh-el-addons' ),
            'description' => __( 'Provide a short writeup for the team member', 'livemesh-el-addons' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'social_profile', [
            'label'     => __( 'Social Profile', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $repeater->add_control( 'member_email', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Email Address', 'livemesh-el-addons' ),
            'description' => __( 'Enter the email address of the team member.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'facebook_url', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Facebook Page URL', 'livemesh-el-addons' ),
            'description' => __( 'URL of the Facebook page of the team member.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'twitter_url', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Twitter Profile URL', 'livemesh-el-addons' ),
            'description' => __( 'URL of the Twitter page of the team member.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'linkedin_url', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'LinkedIn Page URL', 'livemesh-el-addons' ),
            'description' => __( 'URL of the LinkedIn profile of the team member.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'pinterest_url', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Pinterest Page URL', 'livemesh-el-addons' ),
            'description' => __( 'URL of the Pinterest page for the team member.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'dribbble_url', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Dribbble Profile URL', 'livemesh-el-addons' ),
            'description' => __( 'URL of the Dribbble profile of the team member.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'google_plus_url', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'GooglePlus Page URL', 'livemesh-el-addons' ),
            'description' => __( 'URL of the Google Plus page of the team member.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( 'instagram_url', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Instagram Page URL', 'livemesh-el-addons' ),
            'description' => __( 'URL of the Instagram feed for the team member.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active'     => true,
            'categories' => [ TagsModule::POST_META_CATEGORY ],
        ],
        ] );
        $repeater->add_control( "widget_animation", [
            "type"      => Controls_Manager::SELECT,
            "label"     => __( "Animation Type", "livemesh-el-addons" ),
            'options'   => lae_get_animation_options(),
            'default'   => 'none',
            'separator' => 'before',
        ] );
        $this->add_control( 'team_members', [
            'label'       => __( 'Team Members', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::REPEATER,
            'separator'   => 'before',
            'default'     => [ [
            'member_name'     => __( 'Team Member #1', 'livemesh-el-addons' ),
            'member_position' => __( 'CEO', 'livemesh-el-addons' ),
            'member_details'  => __( 'I am member details. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ], [
            'member_name'     => __( 'Team Member #2', 'livemesh-el-addons' ),
            'member_position' => __( 'Lead Developer', 'livemesh-el-addons' ),
            'member_details'  => __( 'I am member details. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ], [
            'member_name'     => __( 'Team Member #3', 'livemesh-el-addons' ),
            'member_position' => __( 'Finance Manager', 'livemesh-el-addons' ),
            'member_details'  => __( 'I am member details. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'livemesh-el-addons' ),
        ] ],
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ member_name }}}',
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
            'label'   => __( 'Choose Team Style', 'livemesh-el-addons' ),
            'default' => 'style1',
            'options' => [
            'style1' => __( 'Style 1', 'livemesh-el-addons' ),
            'style2' => __( 'Style 2', 'livemesh-el-addons' ),
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
            'style' => [ 'style1' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Image_Size::get_type(), [
            'name'    => 'thumbnail_size',
            'label'   => __( 'Team Member Image Size', 'livemesh-el-addons' ),
            'default' => 'full',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_carousel_settings', [
            'label'     => __( 'Carousel Settings', 'livemesh-el-addons' ),
            'tab'       => Controls_Manager::TAB_SETTINGS,
            'condition' => [
            'style'  => [ 'style1' ],
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
            '{{WRAPPER}} .lae-team-members-carousel .slick-slide' => 'margin: 0 {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .lae-team-members-carousel .slick-list'  => 'margin: 0 -{{SIZE}}{{UNIT}};',
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
            'style'  => [ 'style1' ],
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
            'style'  => 'style1',
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
        $this->start_controls_section( 'section_team_profiles_style', [
            'label'      => __( 'General', 'livemesh-el-addons' ),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ] );
        $this->add_responsive_control( 'team_member_spacing', [
            'label'      => __( 'Team Member Spacing', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-team-members .lae-team-member-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'isLinked'   => false,
            'condition'  => [
            'style' => [ 'style2' ],
        ],
        ] );
        $this->add_responsive_control( 'thumbnail_hover_brightness', [
            'label'     => __( 'Thumbnail Hover Brightness (%)', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::SLIDER,
            'default'   => [
            'size' => 50,
        ],
            'range'     => [
            'px' => [
            'max'  => 100,
            'min'  => 1,
            'step' => 1,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .lae-team-members .lae-team-member:hover .lae-image-wrapper img' => '-webkit-filter: brightness({{SIZE}}%);-moz-filter: brightness({{SIZE}}%);-ms-filter: brightness({{SIZE}}%); filter: brightness({{SIZE}}%);',
        ],
        ] );
        $this->add_control( 'thumbnail_border_radius', [
            'label'      => __( 'Thumbnail Border Radius', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-image-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_team_member_title', [
            'label' => __( 'Member Title', 'livemesh-el-addons' ),
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
            'default' => 'h3',
        ] );
        $this->add_control( 'title_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-team-member-text .lae-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'title_hover_color', [
            'label'     => __( 'Hover Color for Link', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-team-member-text .lae-title-link:hover .lae-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .lae-team-members .lae-team-member .lae-team-member-text .lae-title',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_team_member_position', [
            'label' => __( 'Member Position', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'position_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-team-member-text .lae-team-member-position' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'position_typography',
            'selector' => '{{WRAPPER}} .lae-team-members .lae-team-member .lae-team-member-text .lae-team-member-position',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_team_member_details', [
            'label' => __( 'Member Details', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'text_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-team-member-details' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'text_typography',
            'selector' => '{{WRAPPER}} .lae-team-members .lae-team-member .lae-team-member-details',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_social_icon_styling', [
            'label' => __( 'Social Icons', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'social_icon_size', [
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
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-image-wrapper .lae-social-list i' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'social_icon_spacing', [
            'label'       => __( 'Spacing', 'livemesh-el-addons' ),
            'description' => __( 'Space between icons.', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::DIMENSIONS,
            'size_units'  => [ 'px', '%', 'em' ],
            'default'     => [
            'top'    => 0,
            'right'  => 15,
            'bottom' => 0,
            'left'   => 0,
            'unit'   => 'px',
        ],
            'selectors'   => [
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-social-list .lae-social-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'isLinked'    => false,
        ] );
        $this->add_control( 'social_icon_color', [
            'label'     => __( 'Icon Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-social-list .lae-social-list-item i' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'social_icon_hover_color', [
            'label'     => __( 'Icon Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-team-members .lae-team-member .lae-social-list .lae-social-list-item i:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_team_members_' . $this->get_id() . '_settings', $settings );
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/team-members/loop', $args );
    }
    
    protected function content_template()
    {
    }

}