<?php
/**
 * Portfolio widget
 *
 * @package Sydney
 */


class Sydney_Portfolio extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'sydney_portfolio_widget', 'description' => __( 'Display your projects in a grid.', 'sydney') );
       parent::__construct(false, $name = __('Sydney FP: Portfolio', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_portfolio_widget';
  }

  public function widget( $args, $instance ) {

    $title 		     = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
    $number         = ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
    $includes       = isset($instance['includes']) ? $instance['includes'] : '';
    $show_filter	   = isset( $instance['show_filter'] ) ? $instance['show_filter'] : false;
		$show_project_title = isset( $instance['show_project_title'] ) ? $instance['show_project_title'] : false;
    $show_all_text  = isset( $instance['show_all_text'] ) ? $instance['show_all_text'] : '';

    echo $args['before_widget'];

    if ( ! empty( $title ) ) { echo $args['before_title'] . $title . $args['after_title']; }

    $options = array(
     'posts'         => $number,
     'post_type'     => 'projects',
     'include'       => $includes,
     'filter'        => $show_filter,
     'show_all_text' => ! empty( $show_all_text ) ? $show_all_text : __('Show all', 'sydney')
    );

    $output = ''; //Start output
    $output .= '<div class="project-wrap">';
    if ($options['include'] && $options['filter'] == 1) {
       $included_terms = explode( ',', $options['include'] );
       $included_ids = array();

       foreach( $included_terms as $term ) {
           $term_obj = get_term_by( 'slug', $term, 'category');
           if (is_object($term_obj)) {
              $term_id  = $term_obj->term_id;
              $included_ids[] = $term_id;
           }
       }

       $id_string = implode( ',', $included_ids );
       $terms = get_terms( 'category', array( 'include' => $id_string ) );

       //Build the filter
       $output .= '<ul class="project-filter" id="filters">';
           $output .= '<li><a href="#" data-filter="*">' . $options['show_all_text'] .'</a></li>';
           $count = count($terms);
           if ( $count > 0 ){
               foreach ( $terms as $term ) {
                   $output .= "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
               }
           }
       $output .= '</ul>';
    }
    //Build the layout
    $output .= '<div class="roll-project fullwidth">';
    $output .= '<div class="isotope-container" data-portfolio-effect="fadeInUp">';

    $the_query = new WP_Query( array (
     'post_type' => $options['post_type'],
     'posts_per_page' => $options['posts'],
     'category_name' => $options['include']
    ) );

    while ( $the_query->have_posts() ):
       $the_query->the_post();
       global $post;
       $id = $post->ID;
       $termsArray = get_the_terms( $id, 'category' );
       $termsString = "";

       if ( $termsArray) {
           foreach ( $termsArray as $term ) {
               $termsString .= $term->slug.' ';
           }
       }

			 $project_title = '<div class="project-title-wrap">';
			 $project_title .= '<div class="project-title">';
			 $project_title .= '<span>'.get_the_title($post->ID).'</span>';
			 $project_title .= '</div>';
			 $project_title .= '</div>';

       if ( has_post_thumbnail() ) {
           $project_url = get_post_meta( get_the_ID(), 'wpcf-project-link', true );
           if ( $project_url ) :
               $output .= '<div class="project-item item isotope-item ' . $termsString . '">';
							 $output .= '<a class="project-pop-wrap" href="' . esc_url($project_url) . '">';
							 $output .= '<div class="project-pop"></div>';
							 $output .= ($show_project_title == 1) ? $project_title : '';
							 $output .= '</a>';
							 $output .= '<a href="' . esc_url($project_url) . '">';
							 $output .= get_the_post_thumbnail($post->ID,'sydney-mas-thumb');
							 $output .= '</a>';
							 $output .= '</div>';
           else :
               $output .= '<div class="project-item item isotope-item ' . $termsString . '">';
							 $output .= '<a class="project-pop-wrap" href="' . get_the_permalink() . '">';
							 $output .= '<div class="project-pop"></div>';
							 $output .= ($show_project_title == 1) ? $project_title : '';
							 $output .= '</a><a href="' . get_the_permalink() . '">';
							 $output .= get_the_post_thumbnail($post->ID,'sydney-mas-thumb');
							 $output .= '</a>';
							 $output .= '</div>';
           endif;
       }
    endwhile;
    wp_reset_postdata();
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div><!-- /.project-wrap -->';
    echo $output;

    echo $args['after_widget'];

  }


  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] 			= strip_tags($new_instance['title']);
    $instance['number'] 		= strip_tags($new_instance['number']);
    $instance['includes']       = sanitize_text_field($new_instance['includes']);
    $instance['show_filter']    = is_null( $new_instance['show_filter'] ) ? 0 : 1;
		$instance['show_project_title'] = is_null( $new_instance['show_project_title'] ) ? 0 : 1;
    $instance['show_all_text']  = sanitize_text_field($new_instance['show_all_text']);

    return $instance;
  }

 function form($instance) {
    $title     		 = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    $number    		 = isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
    $includes      = isset( $instance['includes'] ) ? esc_attr($instance['includes']) : '';
    $show_filter   = isset( $instance['show_filter'] ) ? (bool) $instance['show_filter'] : true;
		$show_project_title = isset( $instance['show_project_title'] ) ? (bool) $instance['show_project_title'] : false;
    $show_all_text = isset( $instance['show_all_text'] )  ? esc_html($instance['show_all_text']) : __('Show all', 'sydney');

	?>

   <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'sydney'); ?></label>
   <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
   <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of projects to show (-1 shows all of them):', 'sydney' ); ?></label>
   <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
   <p><label for="<?php echo $this->get_field_id('includes'); ?>"><?php _e('Enter the slugs (comma separated) for your categories or leave empty to show all projects.', 'sydney'); ?></label>
   <input class="widefat" id="<?php echo $this->get_field_id('includes'); ?>" name="<?php echo $this->get_field_name('includes'); ?>" type="text" value="<?php echo $includes; ?>" /></p>
	 <p><input class="checkbox" type="checkbox" <?php checked( $show_filter ); ?> id="<?php echo $this->get_field_id( 'show_filter' ); ?>" name="<?php echo $this->get_field_name( 'show_filter' ); ?>" />
   <label for="<?php echo $this->get_field_id( 'show_filter' ); ?>"><?php _e( 'Show navigation filter? (Category slugs must be specified).', 'sydney' ); ?></label></p>
	 <p><label for="<?php echo $this->get_field_id('show_all_text'); ?>"><?php _e('"Show all" text:', 'sydney'); ?></label>
   <input class="widefat" id="<?php echo $this->get_field_id('show_all_text'); ?>" name="<?php echo $this->get_field_name('show_all_text'); ?>" type="text" value="<?php echo esc_attr($show_all_text); ?>" /></p>
	 <p><input class="checkbox" type="checkbox" <?php checked( $show_project_title ); ?> id="<?php echo $this->get_field_id( 'show_project_title' ); ?>" name="<?php echo $this->get_field_name( 'show_project_title' ); ?>" />
   <label for="<?php echo $this->get_field_id( 'show_project_title' ); ?>"><?php _e( 'Show project title?', 'sydney' ); ?></label></p>

   <?php

 }


}
