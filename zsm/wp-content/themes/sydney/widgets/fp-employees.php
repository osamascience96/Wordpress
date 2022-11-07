<?php

class Sydney_Employees extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'sydney_employees_widget', 'description' => __( 'Display your team members in a stylish way.', 'sydney') );
        parent::__construct(false, $name = __('Sydney FP: Employees', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_employees_widget';

    }

	function form($instance) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
		$category  = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$see_all   = isset( $instance['see_all'] ) ? esc_url_raw( $instance['see_all'] ) : '';	
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';		
		$center_content	= isset( $instance['center_content'] ) ? (bool) $instance['center_content'] : false;	
	?>

	<p><?php _e('In order to display this widget, you must first add some employees from the dashboard. Add as many as you want and the theme will automatically display them all.', 'sydney'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of employees to show (-1 shows all of them):', 'sydney' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('Enter an URL here if you want to section to link somewhere.', 'sydney'); ?></label>
	<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our employees</em> if left empty]', 'sydney'); ?></label>
	<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>			
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show all employees.', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>
	<p><input class="checkbox" type="checkbox" <?php checked( $center_content ); ?> id="<?php echo $this->get_field_id( 'center_content' ); ?>" name="<?php echo $this->get_field_name( 'center_content' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'center_content' ); ?>"><?php _e( 'Center the employees? (use only if you have 1 or 2 employees)', 'sydney' ); ?></label></p>
	
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['number'] 		= strip_tags($new_instance['number']);		
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );
		$instance['see_all_text'] 	= strip_tags($new_instance['see_all_text']);			
		$instance['category'] 		= strip_tags($new_instance['category']);
		$instance['center_content'] = isset( $new_instance['center_content'] ) ? (bool) $new_instance['center_content'] : false;		

		return $instance;
	}

	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$see_all 		= isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';
		$see_all_text 	= isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : '';		
		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
		if ( ! $number )
			$number = -1;			
		$category 		= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		$center_content	= isset( $instance['center_content'] ) ? $instance['center_content'] : false;

		$r = new WP_Query(array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'employees',
			'posts_per_page'	  => $number,
			'category_name'		  => $category			
		) );

		echo $args['before_widget'];

		// Get fontawesome prefix
		$fa_prefix = sydney_get_fontawesome_prefix( 'fab ' ); 

		if ($r->have_posts()) :
?>

		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<div class="roll-team carousel owl-carousel" data-widgetid="employees-<?php echo $args['widget_id']; ?>">
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<?php //Get the custom field values
					$position = get_post_meta( get_the_ID(), 'wpcf-position', true );
					$facebook = get_post_meta( get_the_ID(), 'wpcf-facebook', true );
					$twitter  = get_post_meta( get_the_ID(), 'wpcf-twitter', true );
					$google   = get_post_meta( get_the_ID(), 'wpcf-google-plus', true );
					$link     = get_post_meta( get_the_ID(), 'wpcf-custom-link', true );
				?>
			<div class="team-item">
			    <div class="team-inner">
			        <div class="pop-overlay">
			            <div class="team-pop">
			                <div class="team-info">
								<div class="name"><?php the_title(); ?></div>
								<div class="pos"><?php echo esc_html($position); ?></div>
								<ul class="team-social">
									<?php if ($facebook != '') : ?>
										<li><a class="facebook" href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="<?php echo esc_attr( $fa_prefix ); ?>fa-facebook"></i></a></li>
									<?php endif; ?>
									<?php if ($twitter != '') : ?>
										<li><a class="twitter" href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="<?php echo esc_attr( $fa_prefix ); ?>fa-twitter"></i></a></li>
									<?php endif; ?>
									<?php if ($google != '') : ?>
										<li><a class="google" href="<?php echo esc_url($google); ?>" target="_blank"><i class="<?php echo esc_attr( $fa_prefix ); ?>fa-google-plus"></i></a></li>
									<?php endif; ?>
								</ul>
			                </div>
			            </div>
			        </div>
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="avatar">
						<?php the_post_thumbnail('sydney-medium-thumb'); ?>
					</div>
					<?php endif; ?>
			    </div>
			    <div class="team-content">
			        <div class="name">
			        	<?php if ($link == '') : ?>
			        		<?php the_title(); ?>
			        	<?php else : ?>
			        		<a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a>
			        	<?php endif; ?>
			        </div>
			        <div class="pos"><?php echo esc_html($position); ?></div>
			    </div>
			</div><!-- /.team-item -->

			<?php endwhile; ?>
		</div>

		<?php if ($see_all != '') : ?>
			<a href="<?php echo esc_url($see_all); ?>" class="roll-button more-button">
				<?php if ($see_all_text) : ?>
					<?php echo $see_all_text; ?>
				<?php else : ?>
					<?php echo __('See all our employees', 'sydney'); ?>
				<?php endif; ?>
			</a>
		<?php endif; ?>	
	
	<?php
		wp_reset_postdata();

		if ($center_content) :

		echo '<style>';
			echo '@media only screen and (min-width: 971px) {';
				echo '[data-widgetid="employees-' . $args['widget_id'] . '"].roll-team .owl-wrapper { text-align: center; width: 100% !important; }';
				echo '[data-widgetid="employees-' . $args['widget_id'] . '"].roll-team.owl-carousel .owl-item { float: none; display: inline-block; }';
			echo '}';
		echo '</style>';
?>

<?php




		endif;
		
		endif;

		echo $args['after_widget'];

	}
	
}