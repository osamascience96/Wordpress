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
class aThemes_Employee_Carousel extends Widget_Base {

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
		return 'athemes-employee-carousel';
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
		return __( 'aThemes: Employee carousel', 'sydney-toolbox' );
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
		return 'eicon-person';
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
				'label' => __( 'Employee Carousel', 'sydney-toolbox' ),
			]
		);



		$repeater = new Repeater();


		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'sydney-toolbox' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);	

		$repeater->add_control(
			'person',
			[
				'label' => __( 'Employee name', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Employee name', 'sydney-toolbox' ),
				'default' => __( 'John Doe', 'sydney-toolbox' ),
			]
		);
		
		$repeater->add_control(
			'position',
			[
				'label' => __( 'Position', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'General Manager', 'sydney-toolbox' ),
				'placeholder' => __( 'Enter the position', 'sydney-toolbox' ),
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'facebook',
			[
				'label' 		=> __( 'Facebook link', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'sydney-toolbox' ),
			]
		);	
		
		$repeater->add_control(
			'twitter',
			[
				'label' 		=> __( 'Twitter link', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'sydney-toolbox' ),
			]
		);		
		
		$repeater->add_control(
			'linkedin',
			[
				'label' 		=> __( 'Linkedin link', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'sydney-toolbox' ),
			]
		);				
		
		$repeater->add_control(
			'link',
			[
				'label' 		=> __( 'Link (for person\'s name)', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'sydney-toolbox' ),
			]
		);
		
		$this->add_control(
			'employee_list',
			[
				'label' => __( 'Employee list', 'sydney-toolbox' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'person' 	=> __( 'John Doe', 'sydney-toolbox' ),
						'position' 	=> __( 'Manager', 'sydney-toolbox' ),
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],	
					[
						'person' 	=> __( 'Billy Johns', 'sydney-toolbox' ),
						'position' 	=> __( 'Developer', 'sydney-toolbox' ),
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],	
					[
						'person' 	=> __( 'Steven Brown', 'sydney-toolbox' ),
						'position' 	=> __( 'Designer', 'sydney-toolbox' ),
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],														
				],				
				'title_field' => '{{{ person }}}',
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
			'event_title_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .roll-team .team-item .team-pop, {{WRAPPER}} .owl-theme .owl-controls .owl-page.active span, {{WRAPPER}} .owl-theme .owl-controls.clickable .owl-page:hover span' => 'background-color: {{VALUE}};',	
					'{{WRAPPER}} .owl-theme .owl-controls .owl-page span' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		//End general styles	

		//Employee name styles
		$this->start_controls_section(
			'section_employee_name_style',
			[
				'label' => __( 'Employee name', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'employee_name_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .roll-team .team-content .name, {{WRAPPER}} .roll-team .team-content .name a' => 'color: {{VALUE}};',				
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'employee_name_typography',
				'selector' 	=> '{{WRAPPER}} .roll-team .team-content .name',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End event date styles	


		//Employee position styles
		$this->start_controls_section(
			'section_employee_position_style',
			[
				'label' => __( 'Employee position', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'employee_position_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '',
				'selectors' => [
					'{{WRAPPER}} .roll-team .team-content .pos' => 'color: {{VALUE}};',				
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'employee_position_typography',
				'selector' 	=> '{{WRAPPER}} .roll-team .team-content .pos',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End employee position styles	
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
		?>

		<div class="roll-team carousel owl-carousel" data-widgetid="employees-<?php //echo $this->get_id(); ?>">
			<?php foreach ( $settings['employee_list'] as $index => $item ) : ?>
				<?php //Get the custom field values
					$name 	  = $item['person'];
					$position = $item['position'];
					$facebook = $item['facebook']['url'];
					$twitter  = $item['twitter']['url'];
					$linkedin   = $item['linkedin']['url'];
					$link     = $item['link']['url'];
				?>
			<div class="team-item">
			    <div class="team-inner">
			        <div class="pop-overlay">
			            <div class="team-pop">
			                <div class="team-info">
								<div class="name"><?php echo esc_html( $name ); ?></div>
								<div class="pos"><?php echo esc_html($position); ?></div>
								<ul class="team-social">
									<?php if ($facebook != '') : ?>
										<li><a class="facebook" href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="sydney-svg-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#fff;"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg></i></a></li>
									<?php endif; ?>
									<?php if ($twitter != '') : ?>
										<li><a class="twitter" href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="sydney-svg-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg></i></a></li>
									<?php endif; ?>
									<?php if ($linkedin != '') : ?>
										<li><a class="linkedin" href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="sydney-svg-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg></i></a></li>
									<?php endif; ?>
								</ul>
			                </div>
			            </div>
			        </div>
					<?php
					if ( ! empty( $item['image']['url'] ) ) {
						$this->add_render_attribute( 'image-' . $index, 'src', $item['image']['url'] );
						$this->add_render_attribute( 'image-' . $index, 'alt', Control_Media::get_image_alt( $item['image'] ) );
					?>
					<div class="avatar">
						<img <?php echo $this->get_render_attribute_string( 'image-' . $index ); ?>/>
					</div>
					<?php
					}
					?>
			    </div>
			    <div class="team-content">
			        <div class="name">
			        	<?php if ( $link == '' ) : ?>
			        		<?php echo esc_html( $name ); ?>
			        	<?php else : ?>
			        		<a href="<?php echo esc_url($link); ?>"><?php echo esc_html( $name ); ?></a>
			        	<?php endif; ?>
			        </div>
			        <div class="pos"><?php echo esc_html( $position ); ?></div>
			    </div>
			</div><!-- /.team-item -->

			<?php endforeach; ?>
		</div>
		<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
		<script>
		if ( jQuery().owlCarouselFork ) {
			jQuery('.roll-team:not(.roll-team.no-carousel)').each(function(index, value) {
				jQuery( this ).owlCarouselFork({
					navigation : false,
					pagination: true,
					responsive: true,
					items: 3,
					itemsDesktopSmall: [1400,3],
					itemsTablet:[970,2],
					itemsTabletSmall: [600,1],
					itemsMobile: [360,1],
					touchDrag: true,
					mouseDrag: true,
					autoHeight: false,
					autoPlay: false,
				}); // end owlCarouselFork
			});
		} // end if  
		</script>
		<?php endif; ?>		
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
Plugin::instance()->widgets_manager->register_widget_type( new aThemes_Employee_Carousel() );