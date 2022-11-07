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
class aThemes_Portfolio extends Widget_Base {

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
		return 'athemes-portfolio';
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
		return __( 'aThemes: Filterable Gallery', 'sydney-toolbox' );
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
		return 'eicon-gallery-grid';
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
				'label' => __( 'Portfolio', 'sydney-toolbox' ),
			]
		);

		if ( \Sydney_Toolbox::is_pro() ) {
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
		}


		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'sydney-toolbox' ),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);		

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Title', 'sydney-toolbox' ),
				'default' => __( 'Project title', 'sydney-toolbox' ),
			]
		);
		
		$repeater->add_control(
			'term',
			[
				'label' => __( 'Filter term', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Term for the filter', 'sydney-toolbox' ),
				'default' => __( 'Art', 'sydney-toolbox' ),
			]
		);
		
		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'sydney-toolbox' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => __( 'Link for this project', 'sydney-toolbox' ),
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);	
		
		
		$this->add_control(
			'portfolio_list',
			[
				'label' => __( 'Projects list', 'sydney-toolbox' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Site branding', 'sydney-toolbox' ),
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'title' => __( 'Site development', 'sydney-toolbox' ),
						'term' => 'Design',
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],	
					[
						'title' => __( 'Logo design', 'sydney-toolbox' ),
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],										
	
				],				
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'show_all_text',
			[
				'label' => __( 'Show all text', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Show all', 'sydney-toolbox' ),
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
				'label' 	=> __( 'Main color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#e64e4e',
				'selectors' => [
					'{{WRAPPER}} .portfolio-section.style2 .project-filter li a.active,{{WRAPPER}} .portfolio-section.style2 .project-filter li a:hover' 	=> 'color: {{VALUE}};',
					'{{WRAPPER}} .roll-project .project-item .project-pop, {{WRAPPER}} .portfolio-section.style1 .project-filter li a.active, {{WRAPPER}} .portfolio-section.style1 .project-filter li a:hover' 		=> 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		//End general styles	

		//Project title styles
		$this->start_controls_section(
			'section_project_title_style',
			[
				'label' => __( 'Project title', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'project_title_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .roll-project .project-title span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'project_title_typography',
				'selector' 	=> '{{WRAPPER}} .roll-project .project-title',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End project title styles	


		//Filter styles
		$this->start_controls_section(
			'section_filter_style',
			[
				'label' => __( 'Filter', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'filter_typography',
				'selector' 	=> '{{WRAPPER}} .project-filter li a',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End filter styles
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


		if ( \Sydney_Toolbox::is_pro() ) {
			$style = $settings['style'];
		} else {
			$style = 'style1';
		}

		?>

		<div class="project-wrap portfolio-section <?php echo esc_attr( $style ); ?>">

			<ul class="project-filter" id="filters">
				<li><a href="#" data-filter="*"><?php echo esc_html( $settings['show_all_text'] ); ?></a></li>

				<?php $array = array(); ?>

				<?php foreach ( $settings['portfolio_list'] as $index => $item ) : ?>
					<?php
					if ( !in_array( $item['term'], $array ) )
					{
					    $array[] = $item['term']; 
					}
					?>
				<?php endforeach; ?>

				<?php foreach ( $array as $value ) : ?>

					<li><a href='#' data-filter='.<?php echo esc_attr( $this->prepare_term( $value, '' ) ); ?>'><?php echo esc_html( $value ); ?></a></li>

				<?php endforeach; ?>

			</ul>

			<div class="roll-project fullwidth">
				<div class="isotope-container" data-portfolio-effect="fadeInUp">

				<?php $c = 0; ?>
				<?php foreach ( $settings['portfolio_list'] as $index => $item ) : ?>
                    
				<div class="project-item item isotope-item <?php echo esc_attr( $this->prepare_term( $item['term'] ) ); ?>">
					<div class="project-inner">
						
						<?php
							if ( ! empty( $item['link']['url'] ) ) {
								$this->add_render_attribute( 'button-' . $c, 'href', $item['link']['url'] );
								$this->add_render_attribute( 'button-' . $c, 'class', 'project-pop-wrap' );

								if ( $item['link']['is_external'] ) {
									$this->add_render_attribute( 'button-' . $c, 'target', '_blank' );
								}

								if ( $item['link']['nofollow'] ) {
									$this->add_render_attribute( 'button-' . $c, 'rel', 'nofollow' );
								}
							}
						?>

						<a <?php echo $this->get_render_attribute_string( 'button-' . $c ); ?>>
							<div class="project-pop"></div>
							<div class="project-title-wrap">
								<h3 class="project-title">
									<span><?php echo esc_html( $item['title'] ); ?></span>
								</h3>
							</div>							
						</a>
						<a href="#">
							<?php if ( $item['image']['url'] ) :
								$this->add_render_attribute( 'image-' . $index, 'src', $item['image']['url'] );
								$this->add_render_attribute( 'image-' . $index, 'alt', Control_Media::get_image_alt( $item['image'] ) );							
							?>
							<img <?php echo $this->get_render_attribute_string( 'image-' . $index ); ?>/>
							<?php endif; ?>
						</a>
					</div>
				</div>

				<?php $c++; ?>
				<?php endforeach; ?>

				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Prepare filter terms to be inserted as classes
	 *
	 */
	protected function prepare_term( $term ) {
		$prepared 		= str_replace( ' ', '-', $term);
		$prepared 		= strtolower( $prepared );

		return $prepared;
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
Plugin::instance()->widgets_manager->register_widget_type( new aThemes_Portfolio() );