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
class aThemes_Timeline extends Widget_Base {

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
		return 'athemes-timeline';
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
		return __( 'aThemes: Timeline', 'sydney-toolbox' );
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
		return 'eicon-date';
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
			'section_timeline',
			[
				'label' => __( 'Timeline', 'sydney-toolbox' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'sydney-toolbox' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style1' => __( 'Style 1', 'sydney-toolbox' ),
					'style2' => __( 'Style 2', 'sydney-toolbox' ),
				],
				'default' => 'style2',
			]
		);		


		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'label' 		=> __( 'Item name', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'label_block' 	=> true,
				'placeholder' 	=> __( 'Item name', 'sydney-toolbox' ),
				'default' 		=> __( 'Our company was founded', 'sydney-toolbox' ),
			]
		);	

		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'sydney-toolbox' ),
				'type' => Controls_Manager::ICONS,
				'description' => __( 'Available for Style 1', 'sydney-toolbox' ),						
				'label_block' => true,
				'placeholder' => '',					
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);
		
		$repeater->add_control(
			'icon_color',
			[
				'label' => __( 'Icon color', 'sydney-toolbox' ),
				'type' => Controls_Manager::COLOR,
				'description' => __( 'Available for Style 1', 'sydney-toolbox' ),
				'label_block' => true,
				'placeholder' => '',
			]
		);		

		$repeater->add_control(
			'date',
			[
				'label' => __( 'Date', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Event date', 'sydney-toolbox' ),
				'default' => '',
			]
		);		
		
		$repeater->add_control(
			'text',
			[
				'label' => __( 'Event description', 'sydney-toolbox' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'placeholder' => __( 'Description', 'sydney-toolbox' ),
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id purus neque. Curabitur pulvinar elementum neque in dictum. Sed non lectus nec tortor iaculis tincidunt.', 'sydney-toolbox' ),
			]
		);		
		
		$this->add_control(
			'timeline_list',
			[
				'label' => __( 'Timeline events', 'sydney-toolbox' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'name' 	=> __( 'Our company was founded', 'sydney-toolbox' ),
						'icon' 	=> [
							'value' => 'fas fa-star',
							'library' => 'fa-solid',
						],
						'date'	=> '2013-12-11',
						'text' 	=> __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id purus neque. Curabitur pulvinar elementum neque in dictum. Sed non lectus nec tortor iaculis tincidunt.', 'sydney-toolbox' ),				
					],
					[
						'name' 	=> __( 'First contract', 'sydney-toolbox' ),
						'icon' 	=> [
							'value' => 'fas fa-star',
							'library' => 'fa-solid',
						],
						'date'	=> '2014-02-11',
						'text' 	=> __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id purus neque. Curabitur pulvinar elementum neque in dictum. Sed non lectus nec tortor iaculis tincidunt.', 'sydney-toolbox' ),				
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

		//Event title styles
		$this->start_controls_section(
			'section_event_title_style',
			[
				'label' => __( 'Event title', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'event_title_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .timeline-section .timeline-inner h3' => 'color: {{VALUE}};',				
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'event_title_typography',
				'selector' 	=> '{{WRAPPER}} .timeline-section .timeline-inner h3',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End event title styles	

		//Event date styles
		$this->start_controls_section(
			'section_event_date_style',
			[
				'label' => __( 'Event date', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'event_date_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .timeline-date' => 'color: {{VALUE}};',				
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'event_date_typography',
				'selector' 	=> '{{WRAPPER}} .timeline-date',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End event date styles	


		//Event text styles
		$this->start_controls_section(
			'section_event_text_style',
			[
				'label' => __( 'Event description', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'event_text_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .content p' => 'color: {{VALUE}};',				
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'event_text_typography',
				'selector' 	=> '{{WRAPPER}} .content p',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End event text styles	

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
		$settings 	= $this->get_settings();
		$style 		= $settings['style'];
		?>

		<div class="timeline-section <?php echo esc_attr( $style ); ?>">
				<?php foreach ( $settings['timeline_list'] as $index => $item ) : ?>
					<?php $date 	  = $item['date']; ?>
					<?php $icon 	  = $item['icon']; ?>
					<?php $title 	  = $item['name']; ?>
					<?php $text 	  = $item['text']; ?>
					<?php $icon_color = $item['icon_color']; ?>
					<?php $link 	  = ''; ?>
					<?php if ( $index % 2 != 0 ) : ?>
					<div class="timeline timeline-even clearfix">
						<div class="timeline-inner clearfix">						
							<div class="content">
								<?php if ( $style == 'style1' ) : ?>
									<h3><?php echo esc_html( $title ); ?></h3>
									<?php if ($date) : ?>
										<span class="timeline-date"><?php echo $date; ?></span>
									<?php endif; ?>	
								<?php else : ?>
									<?php if ($date) : ?>
										<span class="timeline-date"><?php echo $date; ?></span>
									<?php endif; ?>	
									<h3><?php echo esc_html( $title ); ?></h3>									
								<?php endif; ?>								
								<?php echo wp_kses_post( $text ); ?>
							</div><!--.info-->
							<?php if ( $icon ) : ?>			
								<div class="icon" style="background-color: <?php echo esc_attr($icon_color); ?>;">
									<?php 
									if ( isset( $icon['value'] ) ) {
										echo '<i class="' . esc_html( $icon['value'] ) . '"></i>';
									} else {
										echo '<i class="' . esc_html( $icon ) . '"></i>';
									}
									?>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php else : ?>
					<div class="timeline timeline-odd clearfix">
						<div class="timeline-inner clearfix">									
							<?php if ( $icon ) : ?>			
								<div class="icon" style="background-color: <?php echo esc_attr( $icon_color ); ?>;">
									<?php 
									if ( isset( $icon['value'] ) ) {
										echo '<i class="' . esc_html( $icon['value'] ) . '"></i>';
									} else {
										echo '<i class="' . esc_html( $icon ) . '"></i>';
									}
									?>
								</div>
							<?php endif; ?>													
							<div class="content">
								<?php if ( $style == 'style1' ) : ?>
									<h3><?php echo esc_html( $title ); ?></h3>
									<?php if ( $date ) : ?>
										<span class="timeline-date"><?php echo $date; ?></span>
									<?php endif; ?>	
								<?php else : ?>
									<?php if ( $date ) : ?>
										<span class="timeline-date"><?php echo $date; ?></span>
									<?php endif; ?>	
									<h3><?php echo esc_html( $title ); ?></h3>
								<?php endif; ?>									
								<?php echo wp_kses_post( $text ); ?>
							</div><!--.info-->	
						</div>
					</div>
					<?php endif; ?>									
				<?php endforeach; ?>
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
Plugin::instance()->widgets_manager->register_widget_type( new aThemes_Timeline() );