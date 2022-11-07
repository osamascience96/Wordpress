<?php

class Sydney_Facts extends WP_Widget {

// constructor
	public function __construct() {
		$widget_ops = array('classname' => 'sydney_facts_widget', 'description' => __( 'Show your visitors some facts about your company.', 'sydney') );
        parent::__construct(false, $name = __('Sydney FP: Facts', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_facts_widget';
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$fact_one   		= isset( $instance['fact_one'] ) ? esc_html( $instance['fact_one'] ) : '';
		$fact_one_max   	= isset( $instance['fact_one_max'] ) ? esc_html( $instance['fact_one_max'] ) : '';
		$fact_one_icon  	= isset( $instance['fact_one_icon'] ) ? esc_html( $instance['fact_one_icon'] ) : '';		
		$fact_two   		= isset( $instance['fact_two'] ) ? esc_attr( $instance['fact_two'] ) : '';
		$fact_two_max   	= isset( $instance['fact_two_max'] ) ? esc_html( $instance['fact_two_max'] ) : '';
		$fact_two_icon  	= isset( $instance['fact_two_icon'] ) ? esc_html( $instance['fact_two_icon'] ) : '';
		$fact_three   		= isset( $instance['fact_three'] ) ? esc_attr( $instance['fact_three'] ) : '';
		$fact_three_max 	= isset( $instance['fact_three_max'] ) ? esc_html( $instance['fact_three_max'] ) : '';
		$fact_three_icon  	= isset( $instance['fact_three_icon'] ) ? esc_html( $instance['fact_three_icon'] ) : '';
		$fact_four   		= isset( $instance['fact_four'] ) ? esc_attr( $instance['fact_four'] ) : '';		
		$fact_four_max  	= isset( $instance['fact_four_max'] ) ? esc_html( $instance['fact_four_max'] ) : '';
		$fact_four_icon  	= isset( $instance['fact_four_icon'] ) ? esc_html( $instance['fact_four_icon'] ) : '';	
	?>
	<p><?php _e('You can find a list of the available icons ', 'sydney'); ?><a href="http://fortawesome.github.io/Font-Awesome/cheatsheet/" target="_blank"><?php _e('here.', 'sydney'); ?></a>&nbsp;
		<?php 
		if( get_option( 'sydney-fontawesome-v5' ) ) {
			_e( 'Usage example: <strong>fas fa-cloud</strong> (solid). <strong>far fa-building</strong> (regular), <strong>fab fa-android</strong> (brands)', 'sydney' );
		} else {
			_e( 'Usage example: <strong>fa-android</strong>', 'sydney' );
		} ?>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<!-- fact one -->
	<p>
	<label for="<?php echo $this->get_field_id('fact_one'); ?>"><?php _e('First fact name', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_one'); ?>" name="<?php echo $this->get_field_name('fact_one'); ?>" type="text" value="<?php echo $fact_one; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('fact_one_max'); ?>"><?php _e('First fact value', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_one_max'); ?>" name="<?php echo $this->get_field_name('fact_one_max'); ?>" type="text" value="<?php echo $fact_one_max; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('fact_one_icon'); ?>"><?php _e('First fact icon', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_one_icon'); ?>" name="<?php echo $this->get_field_name('fact_one_icon'); ?>" type="text" value="<?php echo $fact_one_icon; ?>" />
	</p>

	<!-- fact two -->
	<p>
	<label for="<?php echo $this->get_field_id('fact_two'); ?>"><?php _e('Second fact name', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_two'); ?>" name="<?php echo $this->get_field_name('fact_two'); ?>" type="text" value="<?php echo $fact_two; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('fact_two_max'); ?>"><?php _e('Second fact value', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_two_max'); ?>" name="<?php echo $this->get_field_name('fact_two_max'); ?>" type="text" value="<?php echo $fact_two_max; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('fact_two_icon'); ?>"><?php _e('Second fact icon', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_two_icon'); ?>" name="<?php echo $this->get_field_name('fact_two_icon'); ?>" type="text" value="<?php echo $fact_two_icon; ?>" />
	</p>	

	<!-- fact three -->
	<p>
	<label for="<?php echo $this->get_field_id('fact_three'); ?>"><?php _e('Third fact name', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_three'); ?>" name="<?php echo $this->get_field_name('fact_three'); ?>" type="text" value="<?php echo $fact_three; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('fact_three_max'); ?>"><?php _e('Third fact value', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_three_max'); ?>" name="<?php echo $this->get_field_name('fact_three_max'); ?>" type="text" value="<?php echo $fact_three_max; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('fact_three_icon'); ?>"><?php _e('Third fact icon', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_three_icon'); ?>" name="<?php echo $this->get_field_name('fact_three_icon'); ?>" type="text" value="<?php echo $fact_three_icon; ?>" />
	</p>	

	<!-- fact four -->
	<p>
	<label for="<?php echo $this->get_field_id('fact_four'); ?>"><?php _e('Fourth fact name', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_four'); ?>" name="<?php echo $this->get_field_name('fact_four'); ?>" type="text" value="<?php echo $fact_four; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('fact_four_max'); ?>"><?php _e('Fourth fact value', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_four_max'); ?>" name="<?php echo $this->get_field_name('fact_four_max'); ?>" type="text" value="<?php echo $fact_four_max; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('fact_four_icon'); ?>"><?php _e('Fourth fact icon', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_four_icon'); ?>" name="<?php echo $this->get_field_name('fact_four_icon'); ?>" type="text" value="<?php echo $fact_four_icon; ?>" />
	</p>							

	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['fact_one'] 		= strip_tags($new_instance['fact_one']);
		$instance['fact_one_max'] 	= strip_tags($new_instance['fact_one_max']);
		$instance['fact_one_icon'] 	= strip_tags($new_instance['fact_one_icon']);
		$instance['fact_two'] 		= strip_tags($new_instance['fact_two']);
		$instance['fact_two_max'] 	= strip_tags($new_instance['fact_two_max']);
		$instance['fact_two_icon'] 	= strip_tags($new_instance['fact_two_icon']);
		$instance['fact_three'] 	= strip_tags($new_instance['fact_three']);
		$instance['fact_three_max']	= strip_tags($new_instance['fact_three_max']);
		$instance['fact_three_icon']= strip_tags($new_instance['fact_three_icon']);
		$instance['fact_four'] 		= strip_tags($new_instance['fact_four']);
		$instance['fact_four_max'] 	= strip_tags($new_instance['fact_four_max']);
		$instance['fact_four_icon'] = strip_tags($new_instance['fact_four_icon']);	  
		  
		return $instance;
	}
		
	// display widget
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		extract($args);

		$icon_prefix = sydney_get_fontawesome_prefix();

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$fact_one   	= isset( $instance['fact_one'] ) ? esc_html( $instance['fact_one'] ) : '';
		$fact_one_max  	= isset( $instance['fact_one_max'] ) ? esc_html( $instance['fact_one_max'] ) : '';
		$fact_one_icon  = isset( $instance['fact_one_icon'] ) ? esc_html( $icon_prefix . $instance['fact_one_icon'] ) : '';
		$fact_two   	= isset( $instance['fact_two'] ) ? esc_attr( $instance['fact_two'] ) : '';
		$fact_two_max  	= isset( $instance['fact_two_max'] ) ? esc_html( $instance['fact_two_max'] ) : '';
		$fact_two_icon  = isset( $instance['fact_two_icon'] ) ? esc_html( $icon_prefix . $instance['fact_two_icon'] ) : '';
		$fact_three   	= isset( $instance['fact_three'] ) ? esc_attr( $instance['fact_three'] ) : '';
		$fact_three_max	= isset( $instance['fact_three_max'] ) ? esc_html( $instance['fact_three_max'] ) : '';
		$fact_three_icon= isset( $instance['fact_three_icon'] ) ? esc_html( $icon_prefix . $instance['fact_three_icon'] ) : '';
		$fact_four   	= isset( $instance['fact_four'] ) ? esc_attr( $instance['fact_four'] ) : '';		
		$fact_four_max 	= isset( $instance['fact_four_max'] ) ? esc_html( $instance['fact_four_max'] ) : '';
		$fact_four_icon = isset( $instance['fact_four_icon'] ) ? esc_html( $icon_prefix . $instance['fact_four_icon'] ) : '';		

		echo $args['before_widget'];
?>

		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<?php if ($fact_one !='') : ?>
		<div class="col-md-3 col-sm-3">
			<div class="roll-counter">
				<i class="<?php echo $fact_one_icon; ?>"></i>
				<div class="name-count"><?php echo $fact_one; ?></div>
				<div class="numb-count" data-from="0" data-to="<?php echo $fact_one_max; ?>" data-speed="2000" data-waypoint-active="yes"><?php echo $fact_one_max; ?></div>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($fact_two !='') : ?>
		<div class="col-md-3 col-sm-3">
			<div class="roll-counter">
				<i class="<?php echo $fact_two_icon; ?>"></i>
				<div class="name-count"><?php echo $fact_two; ?></div>
				<div class="numb-count" data-from="0" data-to="<?php echo $fact_two_max; ?>" data-speed="2000" data-waypoint-active="yes"><?php echo $fact_two_max; ?></div>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($fact_three !='') : ?>
		<div class="col-md-3 col-sm-3">
			<div class="roll-counter">
				<i class="<?php echo $fact_three_icon; ?>"></i>
				<div class="name-count"><?php echo $fact_three; ?></div>
				<div class="numb-count" data-from="0" data-to="<?php echo $fact_three_max; ?>" data-speed="2000" data-waypoint-active="yes"><?php echo $fact_three_max; ?></div>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($fact_four !='') : ?>
		<div class="col-md-3 col-sm-3">
			<div class="roll-counter">
				<i class="<?php echo $fact_four_icon; ?>"></i>
				<div class="name-count"><?php echo $fact_four; ?></div>
				<div class="numb-count" data-from="0" data-to="<?php echo $fact_four_max; ?>" data-speed="2000" data-waypoint-active="yes"><?php echo $fact_four_max; ?></div>
			</div>
		</div>
		<?php endif; ?>

	<?php
		echo $args['after_widget'];

	}
	
}