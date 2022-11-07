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
class aThemes_Posts extends Widget_Base {

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
		return 'athemes-posts';
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
		return __( 'aThemes: Posts', 'sydney-toolbox' );
	}

	public function get_keywords() {
		return ['posts', 'blog', 'post', 'news', 'articles'];
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
		return 'eicon-posts-carousel';
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
			'section_blog',
			[
				'label' => __( 'Blog', 'sydney-toolbox' ),
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

		$this->add_control(
			'number',
			[
				'label' => __( 'Number of posts', 'sydney-toolbox' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
			]
		);

		$this->add_control(
			'category',
			[
				'label' 	=> __( 'Categories', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::SELECT,
                'options' 	=> $this->get_cats(),
                'multiple' 	=> true,				
				'default' 	=> '',
			]
		);

		$this->add_control(
			'see_all_text',
			[
				'label' => __( 'See all button text', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'See all our news', 'sydney-toolbox' ),
			]
		);

		$this->add_control(
			'show_date',
			[
				'label' => __( 'Show date', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);

		$this->add_control(
			'show_cats',
			[
				'label' => __( 'Show category', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',				
			]
		);		
		
		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Show excerpt', 'sydney-toolbox' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',				
			]
		);
		
		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read more text', 'sydney-toolbox' ),
				'type' => Controls_Manager::TEXT,
				'separator'	=>'before',
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


		//Post titles styles
		$this->start_controls_section(
			'section_post_title_style',
			[
				'label' => __( 'Post title', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'name_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .latest-news-wrapper.carousel h4 a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .latest-news-wrapper.carousel.style2 .blog-post:hover h4 a' => 'color: #fff;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'post_title_typography',
				'selector' 	=> '{{WRAPPER}} .latest-news-wrapper.carousel h4',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End post titles styles	

		//Post meta styles
		$this->start_controls_section(
			'section_post_meta_style',
			[
				'label' => __( 'Post meta', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'post_meta_color',
			[
				'label' 	=> __( 'Meta text', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .latest-news-wrapper.carousel.style2 .meta-post' => 'color: {{VALUE}};',
					'{{WRAPPER}} .latest-news-wrapper.carousel.style2 .blog-post:hover .meta-post' => 'color: #fff;',
				],
			]
		);

		$this->add_control(
			'post_meta_links_color',
			[
				'label' 	=> __( 'Meta links', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .latest-news-wrapper.carousel.style2 .meta-post a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .latest-news-wrapper.carousel.style2 .blog-post:hover .meta-post a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .latest-news-wrapper.carousel.style2 .meta-post a:hover' => 'color: #fff;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'post_meta_typography',
				'selector' 	=> '{{WRAPPER}} .latest-news-wrapper.carousel .meta-post',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End post meta styles	

		//Content styles
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Post content', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .latest-news-wrapper.carousel .blog-post .entry-summary' => 'color: {{VALUE}};',
					'{{WRAPPER}} .latest-news-wrapper.carousel.style2 .blog-post:hover .entry-summary' => 'color: #fff;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'content_typography',
				'selector' 	=> '{{WRAPPER}} .latest-news-wrapper.carousel .blog-post .entry-summary',
				'scheme' 	=> Core\Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->end_controls_section();
		//End content styles	

		//Content styles
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => __( 'Carousel dots', 'sydney-toolbox' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dots_color',
			[
				'label' 	=> __( 'Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .owl-theme .owl-controls .owl-page.active span,{{WRAPPER}} .owl-theme .owl-controls.clickable .owl-page:hover span' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .owl-theme .owl-controls .owl-page:hover span, .owl-theme .owl-controls .owl-page.active span' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		//End content styles		

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
				'selector' => '{{WRAPPER}} a.roll-button, {{WRAPPER}} .roll-button',
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
					'{{WRAPPER}} a.roll-button, {{WRAPPER}} .roll-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' 	=> __( 'Background Color', 'sydney-toolbox' ),
				'type' 		=> Controls_Manager::COLOR,
				'default' 	=> '#e64e4e',
				'selectors' => [
					'{{WRAPPER}} a.roll-button, {{WRAPPER}} .roll-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} a.roll-button:hover, {{WRAPPER}} .roll-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} a.roll-button:hover, {{WRAPPER}} .roll-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} a.roll-button:hover, {{WRAPPER}} .roll-button:hover' => 'border-color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .roll-button',
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
					'{{WRAPPER}} a.roll-button, {{WRAPPER}} .roll-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .roll-button',
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
					'{{WRAPPER}} a.roll-button, {{WRAPPER}} .roll-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
		//End button styles


	}

	protected function get_cats() {
		$items = [ '' => '' ];
		$terms = get_terms('category');
		foreach ( $terms as $term ) {
			$items[ $term->term_id ] = $term->name;
		}
		return $items;
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

		$archive_meta_delimiter = get_theme_mod( 'archive_meta_delimiter', 'dot' );

		if ( \Sydney_Toolbox::is_pro() ) {
			$style = $settings['style'];
		} else {
			$style = 'style1';
		}

		$r = new \WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'cat'		  		  => $settings['category'],
			'posts_per_page'	  => $settings['number']		
		) );

		if ( $r->have_posts() ) :
		?>

		<div class="panel-grid-cell"><?php //Keep the same selectors as SO version ?>
			<div class="latest-news-wrapper carousel owl-carousel row <?php echo esc_attr( $style ); ?>">
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<div class="blog-post col-md-12">
				<?php if ( has_post_thumbnail() && $style == 'style1' ) : ?>
					<div class="entry-thumb">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('medium-thumb'); ?>
						</a>			
					</div>	
				<?php else : ?>
					<?php global $post; ?>
					<?php $image_id = get_post_thumbnail_id( $post->ID ); ?>
					<?php $image_src = wp_get_attachment_image_src( $image_id, 'medium-thumb' ); ?>	
					<div class="post-background" style="background-image: url( <?php echo esc_url($image_src[0]); ?> )"></div>			
				<?php endif; ?>						
				<?php if ( $style == 'style1' ) : ?>
					<div class="entry-meta delimiter-<?php echo esc_attr( $archive_meta_delimiter ); ?>">
						<?php if ( 'yes' === $settings['show_date'] ) : ?>
							<?php sydney_posted_on(); ?>
						<?php endif; ?>
						<?php if ( 'yes' === $settings['show_cats'] ) : ?>
							<?php sydney_get_first_cat(); ?>	
						<?php endif; ?>				
					</div>
				<?php endif; ?>
				<?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
					<div class="entry-summary">
					<?php 
						if ( $style == 'style1' ) {
							if ( $settings['show_excerpt'] ) {
								the_excerpt();
							}
							if ( $settings['read_more_text'] ) {
								echo '<a class="ele-read-more" href="' . get_the_permalink() . '">' . esc_html( $settings['read_more_text' ] ) . '</a>';
							}
						} else {
							echo '<div class="meta-post">';
								sydney_post_date();
								sydney_get_first_cat();
							echo '</div>';
							if ( $settings['show_excerpt'] ) {
								echo esc_html( wp_trim_words( get_the_content(), 12 ) );
							}
						}
					?></div>
				</div>
			<?php endwhile; ?>
			</div>
		</div>

		<?php if ( $settings['see_all_text'] ) : //see all posts button ?>
			<?php $cat = get_term_by('id', $settings['category'], 'category') ?>
			<?php if ( $settings['category'] ) : //Link to the category page instead of blog page if a category is selected ?>
				<a href="<?php echo esc_url(get_category_link(get_cat_ID($cat -> name))); ?>" class="roll-button more-button"><?php echo esc_html( $settings['see_all_text'] ); ?></a>
			<?php elseif ( get_option( 'page_for_posts' ) ) : ?>
				<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="roll-button more-button"><?php echo esc_html( $settings['see_all_text'] ); ?></a>
			<?php endif; ?>	
		<?php endif; ?>	
		<?php 
		wp_reset_postdata();
		endif; //end have_posts() check
		?>

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
Plugin::instance()->widgets_manager->register_widget_type( new aThemes_Posts() );