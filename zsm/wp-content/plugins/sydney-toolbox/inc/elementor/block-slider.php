<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use ElementorPro\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Slider block
 *
 * @since 1.0.0
 */
class aThemes_Hero_Slider extends Widget_Base {

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
		return 'sydney-hero-slider';
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
		return __( 'aThemes: Slider', 'sydney-toolbox' );
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
		return 'eicon-slider-push';
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
			'section_slider_items',
			[
				'label' => __( 'Slides', 'sydney-toolbox' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_options' );

		$repeater->start_controls_tab( 'slider_content', [ 'label' => __( 'Content', 'sydney-toolbox' ) ] );

		//Start content fields
		$repeater->add_control(
			'slide_heading',
			[
				'label' => __( 'Title & Description', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slide Heading', 'sydney-toolbox' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_description',
			[
				'label' => __( 'Description', 'sydney-toolbox' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'sydney-toolbox' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label' => __( 'Button text', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click me', 'sydney-toolbox' ),
				'show_label' => true,
			]
		);

		$repeater->add_control(
			'button_url',
			[
				'label' => __( 'Button text', 'sydney-toolbox' ),
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '#',
				],
				'show_label' => true,
			]
		);	
		
		$repeater->add_control(
			'content_alignment',
			[
				'label' => __( 'Content alignment', 'sydney-toolbox' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default'	=> 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'sydney-toolbox' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sydney-toolbox' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'sydney-toolbox' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-content-wrapper' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left' 		=> 'margin-right: auto',
					'center' 	=> 'margin: 0 auto;text-align:center',
					'right' 	=> 'margin-left: auto',
				],
			]
		);	
		
		$repeater->add_control(
			'content_animation',
			[
				'label' 	=> __( 'Content Animation', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> '',
				'options' 	=> [
					'' 				=> __( 'None', 'sydney-toolbox' ),
					'fadeInDown' 	=> __( 'Fade in down', 'sydney-toolbox' ),
					'fadeInUp' 		=> __( 'Fade in up', 'sydney-toolbox' ),
					'fadeInRight' 	=> __( 'Fade in right', 'sydney-toolbox' ),
					'fadeInLeft' 	=> __( 'Fade in left', 'sydney-toolbox' ),
					'zoomIn' 		=> __( 'Zoom in', 'sydney-toolbox' ),
				],
			]
		);		
				
		//End content fields

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'slider_style', [ 'label' => __( 'Style', 'sydney-toolbox' ) ] );


		$repeater->add_control(
			'background_color',
			[
				'label' => __( 'Background color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				],
			]
		);	

		$repeater->add_control(
			'background_image',
			[
				'label' => __( 'Background Image', 'sydney-toolbox' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],				
			]
		);

		$repeater->add_control(
			'background_size',
			[
				'label' => __( 'Background size', 'sydney-toolbox' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover' 	=> __( 'Cover', 'sydney-toolbox' ),
					'contain' 	=> __( 'Contain', 'sydney-toolbox' ),
					'auto' 		=> __( 'Auto', 'sydney-toolbox' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-size: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' 		=> 'background_image[url]',
							'operator' 	=> '!=',
							'value' 	=> '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'enable_overlay',
			[
				'label' => __( 'Enable overlay', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'conditions' => [
					'terms' => [
						[
							'name' 		=> 'background_image[url]',
							'operator' 	=> '!=',
							'value' 	=> '',
						],
					],
				],				
			]
		);
		
		$repeater->add_control(
			'overlay_color',
			[
				'label' => __( 'Overlay color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .slide-overlay' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' 		=> 'background_image[url]',
							'operator' 	=> '!=',
							'value' 	=> '',
						],
					],
				],					
			]
		);		

		$repeater->add_control(
			'heading_color',
			[
				'label' => __( 'Heading color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .athemes-hero-wrapper {{CURRENT_ITEM}} .slide-title' => 'color: {{VALUE}}',
				],
			]
		);			

		$repeater->add_control(
			'text_color',
			[
				'label' => __( 'Text color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .athemes-hero-wrapper {{CURRENT_ITEM}} .slide-text' => 'color: {{VALUE}}',
				],
			]
		);			

		$repeater->end_controls_tab();
		
		$repeater->end_controls_tabs();

		$this->add_control(
			'slides_controls',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'slide_heading' => __( 'Welcome to Sydney', 'sydney-toolbox' ),
						'slide_description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum id nunc rutrum libero posuere rutrum vel a nibh. Etiam vulputate, nulla ac dapibus porta, elit mauris sollicitudin nulla, nec mollis urna sem nec justo.', 'sydney-toolbox' ),
						'background_color'	=> '#31608B',
						'heading_color'		=> '#fff',
						'text_color'		=> '#fff',
					],
					[
						'slide_heading' => __( 'We hope you enjoy your stay', 'sydney-toolbox' ),
						'slide_description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum id nunc rutrum libero posuere rutrum vel a nibh. Etiam vulputate, nulla ac dapibus porta, elit mauris sollicitudin nulla, nec mollis urna sem nec justo.', 'sydney-toolbox' ),
						'background_color'	=> '#61CECA',
						'heading_color'		=> '#fff',
						'text_color'		=> '#fff',						
					],
				],				
				'title_field' => '{{{ slide_heading }}}',
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


		$this->start_controls_section(
			'section_slider_settings',
			[
				'label' => __( 'Settings', 'sydney-toolbox' ),
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[
				'label' => __( 'Slider height', 'sydney-toolbox' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 500,
				],
				'range' => [
					'px' => [
						'min' => 400,
						'max' => 1000
					],
				],
				'selectors' => [
					'{{WRAPPER}} .athemes-hero-wrapper .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay speed [ms]', 'sydney-toolbox' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3000,
				'range' => [
						'min' => 500,
						'max' => 10000
				],
			]
		);


		$this->add_control(
			'show_pagination',
			[
				'label' => __( 'Show pagination', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label' => __( 'Show navigation', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'sydney-toolbox' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .athemes-hero-wrapper .slide-title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Core\Schemes\Color::get_type(),
					'value' => Core\Schemes\Color::COLOR_2,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .athemes-hero-wrapper .slide-title',
				'scheme' => Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			[
				'label' => __( 'Text', 'sydney-toolbox' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .athemes-hero-wrapper .slide-text' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Core\Schemes\Color::get_type(),
					'value' => Core\Schemes\Color::COLOR_2,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .athemes-hero-wrapper .slide-text',
				'scheme' => Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();

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
				'selector' => '{{WRAPPER}} a.roll-button',
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
				'label' => __( 'Text Color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.roll-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Core\Schemes\Color::get_type(),
					'value' => Core\Schemes\Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} a.roll-button' => 'background-color: {{VALUE}};',
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
				'label' => __( 'Text Color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.roll-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.roll-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} a.roll-button:hover' => 'border-color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} a.roll-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'sydney-toolbox' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.roll-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} a.roll-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'sydney-toolbox' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.roll-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

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
		$total = count( $settings['slides_controls'] );

		?>

		<div class="swiper-container athemes-hero-slider">
			<div class="swiper-wrapper athemes-hero-wrapper">
				<?php foreach ( $settings['slides_controls'] as $index => $item ) :
					$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'slides_controls', $index );

					$this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-icon-list-text' );

					$this->add_inline_editing_attributes( $repeater_setting_key );
					?>
					<div data-swiper-autoplay="<?php echo esc_attr( $settings['autoplay_speed'] ); ?>" class="swiper-slide elementor-repeater-item-<?php echo $item['_id']; ?>" style="background-image: url('<?php echo $item['background_image']['url']; ?>');">
						<?php if ( $item['enable_overlay'] ) : ?>
						<div class="slide-overlay"></div>
						<?php endif; ?>						
						<div class="hero-slide-inner">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="slide-content-wrapper animated <?php echo esc_attr( $item['content_animation'] ); ?>">
											<h2 class="slide-title"><?php echo esc_html( $item['slide_heading'] ); ?></h2>
											<p class="slide-text"><?php echo wp_kses_post( $item['slide_description'] ); ?></p>

											<?php
											if ( ! empty( $item['button_url']['url'] ) ) {
												$link_key = 'button_url_' . $index;

												$this->add_render_attribute( $link_key, 'href', $item['button_url']['url'] );

												if ( $item['button_url']['is_external'] ) {
													$this->add_render_attribute( $link_key, 'target', '_blank' );
												}

												if ( $item['button_url']['nofollow'] ) {
													$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
												}

												echo '<a class="roll-button" ' . $this->get_render_attribute_string( $link_key ) . '>';
											}
											echo esc_html( $item['button_text'] );
											if ( ! empty( $item['button_url']['url'] ) ) {
												echo '</a>';
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
				endforeach;
				?>
			</div>	
			<?php if ( 'yes' == $settings['show_pagination'] ) : ?>
			<div class="swiper-pagination"></div>
			<?php endif; ?>
			<?php if ( 'yes' == $settings['show_navigation'] ) : ?>
			<div class="swiper-button-next"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"/></svg></div>
			<div class="swiper-button-prev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/></svg></div>			
			<?php endif; ?>
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


Plugin::instance()->widgets_manager->register_widget_type( new aThemes_Hero_Slider() );