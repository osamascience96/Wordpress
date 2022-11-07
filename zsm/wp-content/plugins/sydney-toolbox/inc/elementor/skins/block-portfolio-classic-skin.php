<?php

/**
 * Skin for Portfolio module
 */
class aThemes_Portfolio_Ext_Classic_Skin extends Elementor\Skin_Base {
	

	public function get_id() {
		return 'athemes-portfolio-ext-classic-skin';
	}

	public function get_title() {
		return __( 'Classic', 'sydney-toolbox' );
	}


	public function render() {
		$settings = $this->parent->get_settings();

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
		
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) { ?>
			<div class="sydney-portfolio-wrapper skin-content-classic">

				<?php if ( $settings['filter_source'] && $settings['show_filter'] && 'page' !== $settings['post_type'] ) : ?>
				<div class="sydney-portfolio-filter-wrapper <?php echo ( 'yes' == $settings['show_inline_title'] ) ? 'filter-has-inline-title' : ''; ?>">
					<?php if ( $settings['show_inline_title'] ) : ?>
						<h3><?php echo esc_html( $settings['inline_title_text'] ); ?></h3>
					<?php endif; ?>					
					<ul class="sydney-portfolio-filter">
						<li><a href='#' class="active" data-filter="*"><?php echo esc_html( $settings['show_all_text'] ); ?></a></li>

						<?php foreach ( $terms as $term ) : ?>
						<li><a href='#' data-filter=".<?php echo esc_attr( $term -> slug ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
						<?php endforeach; ?>	
					</ul>
				</div>
				<?php endif; ?>
				
				<div class="sydney-portfolio-items sp-columns-<?php echo esc_attr( $settings['columns'] ); ?> sp-columns-tablet-<?php echo esc_attr( $settings['columns_tablet'] ); ?> sp-columns-mobile-<?php echo esc_attr( $settings['columns_mobile'] ); ?>">	
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					$item_terms 	= $this->parent->prepare_terms( $settings['filter_source'] );
					$termsArray 	= get_the_terms( get_the_id(), $settings['filter_source'] );
					?>
					<div class="sydney-portfolio-item <?php echo esc_attr( $item_terms ); ?>">
						<a class="thumb-wrapper" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>					
						<div class="item-content">
							<div>
								<div class="term-links">
									<?php
									if ( $termsArray) {
										foreach ( $termsArray as $term ) {
											echo '<a href="' . esc_url( get_term_link( $term->term_id ) ). '" class="term-link">' . esc_html( $term->name ) . '</a>';
										}
									}
									?>
								</div>
								<?php if ( $settings['show_title'] ) {
										the_title( '<' . esc_attr( $settings['title_tag'] ) . ' class="project-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></' . esc_attr( $settings['title_tag'] ) . '>' );
									}
								?>	
								<?php if ( $settings['show_excerpt'] ) {
									$excerpt = wp_trim_words( get_the_content(), $settings['excerpt_length'], '&hellip;' );
									echo '<div class="project-excerpt">' . esc_html( $excerpt ) . '</div>';
								} ?>															
							</div>
							<?php if ( $settings['show_arrow'] ) : ?>
							<a class="portfolio-forward" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 476.213 476.213" ><path fill="#fff" d="m345.606 107.5-21.212 21.213 94.393 94.394H0v30h418.787L324.394 347.5l21.212 21.213 130.607-130.607z"/></svg>
							</a>	
							<?php endif; ?>	
						</div>
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

}

add_action( 'elementor/widget/athemes-portfolio-ext/skins_init', function( $widget ) {
   $widget->add_skin( new aThemes_Portfolio_Ext_Classic_Skin( $widget ) );
} );







