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
class aThemes_Portfolio_Ext extends Widget_Base {

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
	}

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
		return 'athemes-portfolio-ext';
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
		return __( 'aThemes: Portfolio', 'sydney-toolbox' );
	}

	public function get_script_depends() {
		return [ 'jquery', 'imagesloaded', 'elementor-frontend' ];
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
			'section_portfolio',
			[
				'label' => __( 'Portfolio', 'sydney-toolbox' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'sydney-toolbox' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => __( '1', 'sydney-toolbox' ),
					'2' => __( '2', 'sydney-toolbox' ),
					'3' => __( '3', 'sydney-toolbox' ),
					'4' => __( '4', 'sydney-toolbox' ),
					'5' => __( '5', 'sydney-toolbox' ),
				],
				'desktop_default'=> '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' 		=> 'image',
				'default' 	=> 'large',
				'separator' => 'none',
			]
		);			

		$this->add_responsive_control(
			'gap',
			[
				'label' => __( 'Gap', 'sydney-toolbox' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],				
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 60,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .sydney-portfolio-wrapper' => '--st-portfolio-gap: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'show_all_text',
			[
				'label' 		=> __( 'Show all text', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Show all', 'sydney-toolbox' ),
				'separator'		=> 'before'
			]
		);

		$this->add_control(
			'show_filter',
			[
				'label' => __( 'Show filter', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'sydney-toolbox' ),
				'label_off' => __( 'No', 'sydney-toolbox' ),
				'return_value' => 'yes',
				'default' => 'yes',	
			]
		);

		if ( post_type_exists( 'sydney-projects' ) ) {
			$post_type_default 		= 'sydney-projects';
			$filter_source_default 	= 'project_cats';
		} else {
			$post_type_default = 'post';
			$filter_source_default 	= 'category';
		}

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Post type', 'sydney-toolbox' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'options' => $this->get_all_post_types(),
				'default' => $post_type_default,
				'separator'		=> 'before'
			]
		);

		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

		foreach ( $taxonomies as $taxonomy ) {

			if ( 'post_format' !== $taxonomy->name ) {
				$this->add_control(
					'selected_terms_' . $taxonomy->name,
					[
						'label' 		=> $taxonomy->label,
						'type' 			=> Controls_Manager::SELECT2,
						'label_block' 	=> true,
						'options' 		=> $this->get_selected_terms( $taxonomy->name ),
						'multiple' 		=> true,
						'condition' => [
							'post_type' => $taxonomy->object_type,
						],
					]
				);
			}
		}

		$this->add_control(
			'filter_source',
			[
				'label' => __( 'Filter source', 'sydney-toolbox' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'options' => $this->get_taxonomies(),
				'default' => 'project_cats'
			]
		);			

		$this->add_control(
			'items',
			[
				'label' => __( 'Number of items', 'sydney-toolbox' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
				'separator' => 'before'
			]
		);	
		
		$this->add_control(
			'show_inline_title',
			[
				'label' => __( 'Show inline title', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'sydney-toolbox' ),
				'label_off' => __( 'No', 'sydney-toolbox' ),
				'return_value' => 'yes',
				'default' => 'no',	
				'separator' => 'before'						
			]
		);			
		$this->add_control(
			'inline_title_text',
			[
				'label' 		=> __( 'Inline title', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'My projects', 'sydney-toolbox' ),
				'condition' => [
					'show_inline_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'sydney-toolbox' ),
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show title', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'sydney-toolbox' ),
				'label_off' => __( 'No', 'sydney-toolbox' ),
				'return_value' => 'yes',
				'default' => 'yes',							
			]
		);	

		$this->add_control(
			'title_tag',
			[
				'label' => __('Title tag', 'sydney-toolbox'),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1' 	=> __('H1', 'sydney-toolbox'),
					'h2' 	=> __('H2', 'sydney-toolbox'),
					'h3' 	=> __('H3', 'sydney-toolbox'),
					'h4' 	=> __('H4', 'sydney-toolbox'),
					'h5' 	=> __('H5', 'sydney-toolbox'),
					'h6' 	=> __('H6', 'sydney-toolbox'),
					'span' 	=> __('Span', 'sydney-toolbox'),
					'p' 	=> __('P', 'sydney-toolbox'),
					'div' 	=> __('Div', 'sydney-toolbox'),
				],
			]
		);	

		$this->add_control(
			'show_terms',
			[
				'label' => __( 'Show categories', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'sydney-toolbox' ),
				'label_off' => __( 'No', 'sydney-toolbox' ),
				'return_value' => 'yes',
				'default' => 'yes',		
				'separator' => 'before',						
			]
		);
		
		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Show excerpt', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'sydney-toolbox' ),
				'label_off' => __( 'No', 'sydney-toolbox' ),
				'return_value' => 'yes',
				'default' => 'no',		
				'separator' => 'before',						
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Number of words', 'sydney-toolbox' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);	
		
		$this->add_control(
			'show_arrow',
			[
				'label' => __( 'Show arrow', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'sydney-toolbox' ),
				'label_off' => __( 'No', 'sydney-toolbox' ),
				'return_value' => 'yes',
				'default' => 'yes',		
				'separator' => 'before',						
			]
		);	
		
		$this->add_control(
			'read_more_text',
			[
				'label' 		=> __( 'Read more text', 'sydney-toolbox' ),
				'type' 			=> Controls_Manager::TEXT,
				'separator'		=> 'before'
			]
		);		

		$this->end_controls_section();

		/**
		 * Styling
		 */

		//filter
		$this->start_controls_section(
			'section_filter_style',
			[
				'label' => __( 'Filter', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'portfolio_filter_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sydney-portfolio-filter a:not(.active)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sydney-portfolio-filter a:not(.active):after' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'portfolio_filter_active_color',
			[
				'label' 	=> __( 'Active Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sydney-portfolio-filter a.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .sydney-portfolio-filter a.active:after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'portfolio_filter_typography',
				'selector' 	=> '{{WRAPPER}} .sydney-portfolio-filter a',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_responsive_control(
			'align_filter',
			[
				'label' => esc_html__( 'Alignment', 'sydney-toolbox' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'sydney-toolbox' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'sydney-toolbox' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'sydney-toolbox' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors_dictionary' => [
					'left' 		=> '-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start',
					'center' 	=> '-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center',
					'right' 	=> '-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .sydney-portfolio-filter' => '{{VALUE}}',
				]
			]
		);			

		$this->end_controls_section();
		//end section	

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'titles_heading',
			[
				'label' => __( 'Titles', 'sydney-toolbox' ),
				'type' 	=> Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'portfolio_title_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .item-content .project-title a:not(:hover)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'portfolio_title_typography',
				'selector' 	=> '{{WRAPPER}} .sydney-portfolio-item .item-content .project-title',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'cats_heading',
			[
				'label' 	=> __( 'Categories', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'portfolio_cats_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .term-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'portfolio_cats_typography',
				'selector' 	=> '{{WRAPPER}} .sydney-portfolio-items .sydney-portfolio-item .term-link',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);	
		
		$this->add_control(
			'excerpt_heading',
			[
				'label' 	=> __( 'Excerpt', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);	
		
		$this->add_control(
			'portfolio_excerpt_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sydney-portfolio-item .project-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'portfolio_excerpt_typography',
				'selector' 	=> '{{WRAPPER}} .sydney-portfolio-items .sydney-portfolio-item .project-excerpt',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);	
		
		$this->add_control(
			'arrow_heading',
			[
				'label' 	=> __( 'Arrow', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);	
		
		$this->add_control(
			'portfolio_arrow_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sydney-portfolio-items .portfolio-forward path' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .sydney-portfolio-wrapper:not(.skin-content-classic):not(.skin-content-overlap) .sydney-portfolio-item .portfolio-forward:hover path' => 'fill: #00102E;',
					'{{WRAPPER}} .sydney-portfolio-wrapper.skin-content-classic .sydney-portfolio-item .portfolio-forward:hover path, {{WRAPPER}} .sydney-portfolio-wrapper.skin-content-overlap .sydney-portfolio-item .portfolio-forward:hover path' => 'fill: #fff;',
					'{{WRAPPER}} .sydney-portfolio-items .sydney-portfolio-item .portfolio-forward:after' => 'background-color: {{VALUE}};',
				],
			]
		);	
		
		$this->add_control(
			'images_heading',
			[
				'label' 	=> __( 'Images', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);	
		
		$this->add_control(
			'image_radius',
			[
				'label' => __( 'Radius', 'sydney-toolbox' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],				
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .sydney-portfolio-item ' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);		


		$this->end_controls_section();
		//end section

		//overlay
		$this->start_controls_section(
			'section_overlay_style',
			[
				'label' => __( 'Overlay', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'portfolio_overlay_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default' => 'rgba(0, 16, 46, 0.6)',
				'selectors' => [
					'{{WRAPPER}} .sydney-portfolio-items .sydney-portfolio-item .overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		if ( \Sydney_Toolbox::is_pro() ) {
			$this->add_control(
				'overlay_hover',
				[
					'label' => __( 'Hover Style', 'sydney-toolbox' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'style1' => __( 'Slide from top', 'sydney-toolbox' ),
						'style2' => __( 'Slide from left', 'sydney-toolbox' ),
						'style3' => __( 'Slide from bottom', 'sydney-toolbox' ),
						'style4' => __( 'Slide from right', 'sydney-toolbox' ),
						'style5' => __( 'Fade in', 'sydney-toolbox' ),
						'style6' => __( 'Grow', 'sydney-toolbox' ),
					],
					'default' => 'style1',
				]
			);		
		}

		$this->end_controls_section();
		//end section	
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
		$settings = $this->get_settings_for_display();

		$terms = get_terms( array(
			'taxonomy' => $settings['filter_source'],
		) );


		$args = array( 
			'post_type' 		=> $settings['post_type'],
			'posts_per_page'  	=> $settings['items'],
			'post_status'     	=> 'publish',
			'no_found_rows' 	=> true, 
		);

		//If user wants to display only certain terms
		if ( $settings['filter_source'] && !empty( $settings[ 'selected_terms_' . $settings['filter_source'] ] ) && 'page' !== $settings['post_type'] ) {
			
			$selected_terms = $settings[ 'selected_terms_' . $settings['filter_source'] ];

			$terms = array();

			foreach ( $selected_terms as $selected ) {
				$term = get_term_by( 'slug', $selected, $settings['filter_source'] );

				if ( !empty( $term ) ) {
					$terms[] = $term;
				}
			}

			if ( !empty( $selected_terms ) ) {
				//Merge tax query into $args to only show posts from selected terms
				$args['tax_query'] = array(
					array(
						'taxonomy' => $settings['filter_source'],
						'field'    => 'slug',
						'terms'    =>  $selected_terms,
					),
				);
			}
		}

		//Hover overlay styles
		if ( \Sydney_Toolbox::is_pro() ) {
			$overlay_hover = 'overlay-' . $settings['overlay_hover'];
		} else {
			$overlay_hover = 'overlay-style1';
		}

		//Start query
		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) { ?>
			<div class="sydney-portfolio-wrapper">

				<?php if ( $settings['filter_source'] && $settings['show_filter'] && 'page' !== $settings['post_type'] ) : ?>
				<div class="sydney-portfolio-filter-wrapper <?php echo ( 'yes' == $settings['show_inline_title'] ) ? 'filter-has-inline-title' : ''; ?>">
					<?php if ( $settings['show_inline_title'] ) : ?>
						<h3><?php echo esc_html( $settings['inline_title_text'] ); ?></h3>
					<?php endif; ?>					
					<ul class="sydney-portfolio-filter">
						<li><a href='#' class="active" data-filter="*"><?php echo esc_html( $settings['show_all_text'] ); ?></a></li>

						<?php if ( !empty( $terms ) && !is_wp_error( $terms ) ) : ?>
							<?php foreach ( $terms as $term ) : ?>
								<li><a href='#' data-filter=".<?php echo esc_attr( $term -> slug ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
							<?php endforeach; ?>	
						<?php endif; ?>
					</ul>
				</div>
				<?php endif; ?>

				<?php
				if ( !array_key_exists( 'columns', $settings ) || '' == $settings['columns'] ) {
					$settings['columns'] = 3;
				}				
				if ( !array_key_exists( 'columns_tablet', $settings ) ) {
					$settings['columns_tablet'] = 2;
				}
				if ( !array_key_exists( 'columns_mobile', $settings ) ) {
					$settings['columns_mobile'] = 1;
				}
				?>

				<div class="sydney-portfolio-items sp-columns-<?php echo esc_attr( $settings['columns'] ); ?> sp-columns-tablet-<?php echo esc_attr( $settings['columns_tablet'] ); ?> sp-columns-mobile-<?php echo esc_attr( $settings['columns_mobile'] ); ?>">	
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					$item_terms 	= $this->prepare_terms( $settings['filter_source'] );
					$termsArray 	= get_the_terms( get_the_id(), $settings['filter_source'] );
					?>
					<div class="sydney-portfolio-item <?php echo esc_attr( $item_terms ); ?>">
						<?php the_post_thumbnail( $settings['image_size'] ); ?>						
						<div class="item-content">
							<div>
								<?php if ( $settings['show_terms'] ) : ?>
								<div class="term-links">
									<?php
									if ( !empty( $termsArray ) && !is_wp_error( $termsArray ) ) {
										foreach ( $termsArray as $term ) {
											echo '<a href="' . esc_url( get_term_link( $term->term_id ) ). '" class="term-link">' . esc_html( $term->name ) . '</a>';
										}
									}
									?>
								</div>
								<?php endif; ?>	
								<?php if ( $settings['show_title'] ) {
										the_title( '<' . esc_attr( $settings['title_tag'] ) . ' class="project-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></' . esc_attr( $settings['title_tag'] ) . '>' );
									}
								?>
								<?php if ( 'yes' == $settings['show_excerpt'] ) {
									$excerpt = wp_trim_words( get_the_content(), $settings['excerpt_length'], '&hellip;' );
									echo '<div class="project-excerpt">' . esc_html( $excerpt ) . '</div>';
								}	
								?>	
								<?php if ( $settings['read_more_text'] ) : ?>
									<a class="portfolio-read-more" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
										<?php echo esc_html( $settings['read_more_text'] ); ?>
										<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 5.95041L2.3256 0.639553C1.94111 0.279697 1.34343 0.279697 0.958938 0.639553L0.927438 0.669035C0.505529 1.06391 0.505164 1.73317 0.926643 2.12851L5.00127 5.95041L0.926643 9.77232C0.505164 10.1677 0.505528 10.8369 0.927437 11.2318L0.958937 11.2613C1.34343 11.6211 1.94111 11.6211 2.3256 11.2613L8 5.95041Z"/></svg>
									</a>
								<?php endif; ?>
							</div>
							<?php if ( $settings['show_arrow'] ) : ?>
							<a class="portfolio-forward" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 476.213 476.213" ><path fill="#fff" d="m345.606 107.5-21.212 21.213 94.393 94.394H0v30h418.787L324.394 347.5l21.212 21.213 130.607-130.607z"/></svg>
							</a>
							<?php endif; ?>	
						</div>
						
						<a class="overlay <?php echo esc_attr( $overlay_hover ); ?>" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"></a>
					</div>
					<?php
				} ?>
				</div>
			</div>
		<?php
		}		

		//reset data
		wp_reset_postdata();

	}

	/**
	 * Prepare portfolio item terms
	 */
	public function prepare_terms( $filter_source ) {
		$termsArray 	= get_the_terms( get_the_id(), $filter_source );
		
		$termsString 	= "";
 
		if ( !empty( $termsArray ) && !is_wp_error( $termsArray ) ) {
			foreach ( $termsArray as $term ) {
				$termsString .= $term->slug . ' ';
			}
		}

		return $termsString;
	}

	/**
	 * Return taxonomies
	 */
	protected function get_all_post_types() {
		// Get post types
		$args       = array(
			'public' => true,
		);
		$post_types = get_post_types( $args, 'objects' );

		$results = [ '' => '' ];

		foreach ( $post_types as $post_type ) {
			$results[$post_type->name] = $post_type->label;
		}
		
		unset( $results[ 'attachment' ] ); 
		unset( $results[ 'e-landing-page' ] );
		unset( $results[ 'elementor_library' ] );

		return $results;
	}	

	/**
	 * Get taxonomies for all posts types
	 */
	protected function get_taxonomies() {
		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

		$options = [ '' => '' ];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

	/**
	 * Get terms for selected taxonomy
	 */
	protected function get_selected_terms( $name ) {

		$options = [ '' => '' ];

		$terms = get_terms( array(
			'taxonomy' => $name,
		) );

		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}

		return $options;
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
Plugin::instance()->widgets_manager->register_widget_type( new aThemes_Portfolio_Ext() );