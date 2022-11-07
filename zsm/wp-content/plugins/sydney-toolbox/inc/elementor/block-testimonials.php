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
class aThemes_Testimonials extends Widget_Base {

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
		return 'athemes-testimonials';
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
		return __( 'aThemes: Testimonials', 'sydney-toolbox' );
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
		return 'eicon-testimonial';
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
			'section_testimonials',
			[
				'label' => __( 'Testimonials', 'sydney-toolbox' ),
			]
		);


		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Client photo', 'sydney-toolbox' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],				
			]
		);

		$repeater->add_control(
			'name',
			[
				'label' => __( 'Client name', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click me', 'sydney-toolbox' ),
				'show_label' => true,
				'placeholder' => __( 'Client name', 'sydney-toolbox' ),
				'default' => __( 'John Doe', 'sydney-toolbox' ),
			]
		);	
		
		$repeater->add_control(
			'position',
			[
				'label' => __( 'Client position', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click me', 'sydney-toolbox' ),
				'show_label' => true,
				'placeholder' => __( 'Client position', 'sydney-toolbox' ),
				'default' => __( 'Manager', 'sydney-toolbox' ),
			]
		);	

		$repeater->add_control(
			'testimonial',
			[
				'label' => __( 'Testimonial', 'sydney-toolbox' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Click me', 'sydney-toolbox' ),
				'show_label' => true,
				'placeholder' => __( 'Testimonial', 'sydney-toolbox' ),
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id purus neque. Curabitur pulvinar elementum neque in dictum. Sed non lectus nec tortor iaculis tincidunt.', 'sydney-toolbox' ),
			]
		);	

		$this->add_control(
			'testimonials_list',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'name' 			=> __( 'John Doe', 'sydney-toolbox' ),
						'position' 		=> __( 'Manager', 'sydney-toolbox' ),
						'testimonial' 	=> __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id purus neque. Curabitur pulvinar elementum neque in dictum. Sed non lectus nec tortor iaculis tincidunt.', 'sydney-toolbox' ),				
					],
					[
						'name' 			=> __( 'James Stevens', 'sydney-toolbox' ),
						'position' 		=> __( 'Manager', 'sydney-toolbox' ),
						'testimonial' 	=> __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id purus neque. Curabitur pulvinar elementum neque in dictum. Sed non lectus nec tortor iaculis tincidunt.', 'sydney-toolbox' ),
					],
				],				
				'title_field' => '{{{ name }}}',
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

		//General styles
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => __( 'General', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'general_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#e64e4e',
				'selectors' => [
					'{{WRAPPER}} .widget_sydney_testimonials .fa-quote-left' => 'color: {{VALUE}};',
					'{{WRAPPER}} .owl-theme .owl-controls .owl-page.active span,{{WRAPPER}} .owl-theme .owl-controls.clickable .owl-page:hover span' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .owl-theme .owl-controls .owl-page:hover span,{{WRAPPER}} .owl-theme .owl-controls .owl-page.active span, {{WRAPPER}} .owl-theme .owl-controls .owl-page span' => 'border-color: {{VALUE}};',					
				],
			]
		);

		$this->end_controls_section();
		//End name styles	

		//Name styles
		$this->start_controls_section(
			'section_name_style',
			[
				'label' => __( 'Name', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'name_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .roll-testimonials .testimonial-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'name_typography',
				'selector' 	=> '{{WRAPPER}} .roll-testimonials .testimonial-name',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End name styles	

		//Position styles
		$this->start_controls_section(
			'section_position_style',
			[
				'label' => __( 'Position', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'position_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .roll-testimonials .testimonial-position' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'position_typography',
				'selector' 	=> '{{WRAPPER}} .roll-testimonials .testimonial-position',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End position styles	

		//Position styles
		$this->start_controls_section(
			'section_testimonial_style',
			[
				'label' => __( 'Testimonial', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'testimonial_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .roll-testimonials .whisper' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'testimonial_typography',
				'selector' 	=> '{{WRAPPER}} .roll-testimonials .whisper',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End position styles	

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

		<div class="widget_sydney_testimonials">
			<i class="fa fa-quote-left"></i>
			<div class="roll-testimonials" data-autoplay="5000">
				<?php foreach ( $settings['testimonials_list'] as $index => $item ) : ?>
                    <div class="customer">
                        <blockquote class="whisper"><?php echo wp_kses_post( $item['testimonial'] ); ?></blockquote>                               
						<?php if ( $item['image']['url'] ) :
						$this->add_render_attribute( 'image-' . $index, 'src', $item['image']['url'] );
						$this->add_render_attribute( 'image-' . $index, 'alt', Control_Media::get_image_alt( $item['image'] ) );							
						?>
                        <div class="avatar">
							<img <?php echo $this->get_render_attribute_string( 'image-' . $index ); ?>/>
                        </div>
                    	<?php endif; ?>
                        <div class="name">
                        	<div class="testimonial-name"><?php echo esc_html( $item['name'] ); ?></div>
                        	<span class="testimonial-position"><?php echo esc_html( $item['position'] ); ?></span>
                        </div>
                    </div>
				<?php endforeach; ?>
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
Plugin::instance()->widgets_manager->register_widget_type( new aThemes_Testimonials() );