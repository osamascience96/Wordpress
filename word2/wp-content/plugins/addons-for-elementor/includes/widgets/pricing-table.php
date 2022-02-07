<?php

/*
Widget Name: Pricing Table
Description: Display pricing plans in a multi-column grid.
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
class LAE_Pricing_Table_Widget extends LAE_Widget_Base
{
    public function __construct( $data = array(), $args = null )
    {
        parent::__construct( $data, $args );
        add_shortcode( 'lae_pricing_item', array( $this, 'pricing_item_shortcode' ) );
    }
    
    public function pricing_item_shortcode( $atts, $content = null, $tag = "" )
    {
        $title = $value = '';
        $args = shortcode_atts( array(
            'title' => '',
            'value' => '',
        ), $atts );
        $output = lae_get_template_part( 'addons/pricing-table/pricing-item', $args, true );
        return $output;
    }
    
    public function get_name()
    {
        return 'lae-pricing-table';
    }
    
    public function get_title()
    {
        return __( 'Pricing Table', 'livemesh-el-addons' );
    }
    
    public function get_icon()
    {
        return 'lae-icon-pricing-table';
    }
    
    public function get_categories()
    {
        return array( 'livemesh-addons' );
    }
    
    public function get_custom_help_url()
    {
        return 'https://livemeshelementor.com/docs/livemesh-addons/core-addons/pricing-table/';
    }
    
    public function get_script_depends()
    {
        return [ 'lae-waypoints', 'lae-frontend-scripts' ];
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_pricing_table', [
            'label' => __( 'Pricing Table', 'livemesh-el-addons' ),
        ] );
        $this->add_control( 'pricing_heading', [
            'label' => __( 'Pricing Plans', 'livemesh-el-addons' ),
            'type'  => Controls_Manager::HEADING,
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'pricing_title', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Pricing Plan Title', 'livemesh-el-addons' ),
            'default'     => __( 'My pricing plan title', 'livemesh-el-addons' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'tagline', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Tagline Text', 'livemesh-el-addons' ),
            'description' => __( 'Provide any subtitle or taglines like "Most Popular", "Best Value", "Best Selling", "Most Flexible" etc. that you would like to use for this pricing plan.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'pricing_image', [
            'label'       => __( 'Pricing Image', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [
            'url' => Utils::get_placeholder_image_src(),
        ],
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'price_tag', [
            'type'        => Controls_Manager::TEXT,
            'label'       => __( 'Price Tag', 'livemesh-el-addons' ),
            'description' => __( 'Enter the price tag for the pricing plan. HTML is accepted.', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'button_text', [
            'type'    => Controls_Manager::TEXT,
            'label'   => __( 'Text for Pricing Link/Button', 'livemesh-el-addons' ),
            'dynamic' => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'button_url', [
            'label'       => __( 'URL for the Pricing link/button', 'livemesh-el-addons' ),
            'type'        => Controls_Manager::URL,
            'label_block' => true,
            'default'     => [
            'url'         => '',
            'is_external' => 'true',
        ],
            'placeholder' => __( 'http://your-link.com', 'livemesh-el-addons' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'highlight', [
            'label'        => __( 'Highlight Pricing Plan', 'livemesh-el-addons' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_off'    => __( 'No', 'livemesh-el-addons' ),
            'label_on'     => __( 'Yes', 'livemesh-el-addons' ),
            'return_value' => 'yes',
            'default'      => 'no',
        ] );
        $repeater->add_control( 'pricing_content', [
            'type'        => Controls_Manager::TEXTAREA,
            'label'       => __( 'Pricing Plan Details', 'livemesh-el-addons' ),
            'description' => __( 'Enter the content for the pricing plan that include information about individual features of the pricing plan. For prebuilt styling, enter shortcodes content like - [lae_pricing_item title="Storage Space" value="50 GB"] [lae_pricing_item title="Video Uploads" value="50"][lae_pricing_item title="Portfolio Items" value="20"]', 'livemesh-el-addons' ),
            'show_label'  => true,
            'rows'        => 10,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( "widget_animation", [
            "type"    => Controls_Manager::SELECT,
            "label"   => __( "Animation Type", "livemesh-el-addons" ),
            'options' => lae_get_animation_options(),
            'default' => 'none',
        ] );
        $this->add_control( 'pricing_plans', [
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ pricing_title }}}',
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
            'label'              => __( 'Pricing plans in a row', 'livemesh-el-addons' ),
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
        $this->start_controls_section( 'section_pricing_style', [
            'label' => __( 'Plan Name', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'plan_name_tag', [
            'label'   => __( 'HTML Tag', 'livemesh-el-addons' ),
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
        $this->add_control( 'plan_name_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-pricing-table .lae-top-header .lae-plan-name' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'plan_name_typography',
            'selector' => '{{WRAPPER}} .lae-pricing-table .lae-top-header .lae-plan-name',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_plan_tagline', [
            'label' => __( 'Plan Tagline', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'plan_tagline_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-pricing-table .lae-top-header .lae-tagline' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'plan_tagline_typography',
            'selector' => '{{WRAPPER}} .lae-pricing-table .lae-top-header .lae-tagline',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_plan_price', [
            'label' => __( 'Plan Price', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'plan_price_tag', [
            'label'   => __( 'HTML Tag', 'livemesh-el-addons' ),
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
        $this->add_control( 'plan_price_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-pricing-table .lae-pricing-plan .lae-plan-price span' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'plan_price_typography',
            'selector' => '{{WRAPPER}} .lae-pricing-table .lae-pricing-plan .lae-plan-price span',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_item_title', [
            'label' => __( 'Pricing Item Title', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'item_title_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-pricing-table .lae-plan-details .lae-pricing-item .lae-title' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'item_title_typography',
            'selector' => '{{WRAPPER}} .lae-pricing-table .lae-plan-details .lae-pricing-item .lae-title',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_item_value', [
            'label' => __( 'Pricing Item Value', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'item_value_color', [
            'label'     => __( 'Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-pricing-table .lae-plan-details .lae-pricing-item .lae-value' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'item_value_typography',
            'selector' => '{{WRAPPER}} .lae-pricing-table .lae-plan-details .lae-pricing-item .lae-value',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_purchase_button', [
            'label' => __( 'Purchase Button', 'livemesh-el-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'purchase_button_spacing', [
            'label'      => __( 'Button Spacing', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'default'    => [
            'top'    => 15,
            'right'  => 15,
            'bottom' => 15,
            'left'   => 15,
            'unit'   => 'px',
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-pricing-table .lae-purchase .lae-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'purchase_button_size', [
            'label'      => __( 'Button Size', 'livemesh-el-addons' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'default'    => [
            'top'    => 12,
            'right'  => 25,
            'bottom' => 12,
            'left'   => 25,
            'unit'   => 'px',
        ],
            'selectors'  => [
            '{{WRAPPER}} .lae-pricing-table .lae-purchase .lae-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'isLinked'   => false,
        ] );
        $this->add_control( 'button_custom_color', [
            'label'     => __( 'Button Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-pricing-table .lae-purchase .lae-button' => 'background-color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'button_custom_hover_color', [
            'label'     => __( 'Button Hover Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .lae-pricing-table .lae-purchase .lae-button:hover' => 'background-color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'purchase_button_color', [
            'label'     => __( 'Label Color', 'livemesh-el-addons' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .lae-pricing-table .lae-purchase .lae-button' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'purchase_button_typography',
            'selector' => '{{WRAPPER}} .lae-pricing-table .lae-purchase .lae-button',
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = apply_filters( 'lae_pricing_table_' . $this->get_id() . '_settings', $settings );
        if ( empty($settings['pricing_plans']) ) {
            return;
        }
        $args['settings'] = $settings;
        $args['widget_instance'] = $this;
        lae_get_template_part( 'addons/pricing-table/loop', $args );
    }
    
    protected function content_template()
    {
    }

}