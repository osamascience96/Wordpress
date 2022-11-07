<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class aThemes_Pricing_Table extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve icon list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'athemes-pricing-table';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve icon list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'aThemes: Pricing table', 'sydney-toolbox' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve icon list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-price-table';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the icon list widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'sydney-elements' ];
	}

	/**
	 * Register icon list widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon List', 'sydney-toolbox' ),
			]
		);

		$this->add_control(
			'currency',
			[
				'label' 		=> __( 'Currency', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> '$',
				'placeholder' 	=> '$',
			]
		);		

		$this->add_control(
			'price',
			[
				'label' 		=> __( 'Price', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> '35',
				'placeholder' 	=> __( 'Price', 'sydney-toolbox' ),
			]
		);


		$this->add_control(
			'period',
			[
				'label' 		=> __( 'Period', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'month', 'sydney-toolbox' ),
				'placeholder' 	=> __( 'Period', 'sydney-toolbox' ),
			]
		);

		$this->add_control(
			'name',
			[
				'label' 		=> __( 'Name', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Agency', 'sydney-toolbox' ),
				'placeholder' 	=> __( 'Plan name', 'sydney-toolbox' ),
			]
		);		

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => __( 'Feature name', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Just a feature', 'sydney-toolbox' ),
				'default' => __( 'Just a feature', 'sydney-toolbox' ),
				'label_block' => true,
			]
		);		

		$this->add_control(
			'features_list',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => __( 'Just a feature', 'sydney-toolbox' ),
					],
					[
						'text' => __( 'Just a feature', 'sydney-toolbox' ),
					],
					[
						'text' => __( 'Just a feature', 'sydney-toolbox' ),
					],
				],				
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'button_url',
			[
				'label' 		=> __( 'Button URL', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::URL,
				'default' => [
					'url' => '#',
				],
				'placeholder' 	=> __( 'http://example.org', 'sydney-toolbox' ),
			]
		);			

		$this->add_control(
			'button_text',
			[
				'label' 		=> __( 'Button text', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Click me', 'sydney-toolbox' ),
				'placeholder' 	=> __( 'Button text', 'sydney-toolbox' ),
			]
		);		

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'sydney-toolbox' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();


		//Currency styles
		$this->start_controls_section(
			'section_currency_style',
			[
				'label' => __( 'Currency', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'currency_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-section.style4 .plan-price span:first-of-type' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'currency_size',
			[
				'label' 	=> __( 'Size', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pricing-section.style4 .plan-price span:first-of-type' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		//End currency styles	
		//Price styles
		$this->start_controls_section(
			'section_price_style',
			[
				'label' => __( 'Price', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'price_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-section.style4 .plan-price' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'price_size',
			[
				'label' 	=> __( 'Size', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pricing-section.style4 .plan-price' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		//End price styles
		//Period styles
		$this->start_controls_section(
			'section_period_style',
			[
				'label' => __( 'Period', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'period_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-section.style4 .plan-price span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'period_size',
			[
				'label' 	=> __( 'Size', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pricing-section.style4 .plan-price span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		//End period styles	
		//Header styles
		$this->start_controls_section(
			'section_header_style',
			[
				'label' => __( 'Table header', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'header_background_color',
			[
				'label' 	=> __( 'Background Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-section.style4 .plan-header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label' => __( 'Padding top/bottom', 'sydney-toolbox' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .pricing-section.style4 .plan-header' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 90,
					],
				],
			]
		);
		$this->end_controls_section();
		//End header styles	

		//Button styles
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'sydney-toolbox' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Core\Schemes\Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);
	
		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'sydney-toolbox' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' 	=> __( 'Text Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default' 	=> '#fff',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' 	=> __( 'Background Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default' 	=> '#47425d',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'sydney-toolbox' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' 	=> __( 'Text Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default' 	=> '#47425d',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'default'	=> 'transparent',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'sydney-toolbox' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'sydney-toolbox' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [	'top' => 3,
						'right' => 3,
						'bottom' => 3,
						'left' => 3,
						'unit' => 'px',
						'isLinked' => false,
					],				
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'sydney-toolbox' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [	'top' => 16,
						'right' => 35,
						'bottom' => 16,
						'left' => 35,
						'unit' => 'px',
						'isLinked' => false,
					],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
		//End button styles

	}

	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();

		?>

		<div class="pricing-section style4">
			<div class="plan-item-inner">
			<div class="plan-header">
				<h4><?php echo $settings['name']; ?></h4>
				<div class="plan-price">
					<span><?php echo $settings['currency']; ?></span><?php echo $settings['price']; ?><span>/<?php echo $settings['period']; ?></span>		
				</div>	
			</div>

			<div class="plan-text">
				<?php foreach ( $settings['features_list'] as $index => $item ) :
					?>
					<div class="plan-feature" >
						<?php echo $item['text']; ?>
					</div>
					<?php
				endforeach;
				?>
			</div>

			<?php
				if ( ! empty( $settings['button_url']['url'] ) ) {
					$this->add_render_attribute( 'button', 'href', $settings['button_url']['url'] );
					$this->add_render_attribute( 'button', 'class', 'elementor-button' );

					if ( $settings['button_url']['is_external'] ) {
						$this->add_render_attribute( 'button', 'target', '_blank' );
					}

					if ( $settings['button_url']['nofollow'] ) {
						$this->add_render_attribute( 'button', 'rel', 'nofollow' );
					}
				}
			?>
				<div class="plan-btn">
				<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
					<?php echo $settings['button_text']; ?>
				</a>	
				</div>
			</div>
		</div>	
		<?php
	}

	/**
	 * Render icon list widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new aThemes_Pricing_Table() );