<?php

class Sydney_Skills extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'sydney_skills_widget', 'description' => __( 'Show your visitors some of your skills.', 'sydney') );
        parent::__construct(false, $name = __('Sydney FP: Skills', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_skills_widget';
    }
	
	function form($instance) {
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$skill_one   		= isset( $instance['skill_one'] ) ? esc_html( $instance['skill_one'] ) : '';
		$skill_one_max   	= isset( $instance['skill_one_max'] ) ? absint( $instance['skill_one_max'] ) : '';
		$skill_two   		= isset( $instance['skill_two'] ) ? esc_attr( $instance['skill_two'] ) : '';
		$skill_two_max   	= isset( $instance['skill_two_max'] ) ? absint( $instance['skill_two_max'] ) : '';
		$skill_three   		= isset( $instance['skill_three'] ) ? esc_attr( $instance['skill_three'] ) : '';
		$skill_three_max 	= isset( $instance['skill_three_max'] ) ? absint( $instance['skill_three_max'] ) : '';
		$skill_four   		= isset( $instance['skill_four'] ) ? esc_attr( $instance['skill_four'] ) : '';		
		$skill_four_max  	= isset( $instance['skill_four_max'] ) ? absint( $instance['skill_four_max'] ) : '';
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<!-- skill one -->
	<p>
	<label for="<?php echo $this->get_field_id('skill_one'); ?>"><?php _e('First skill name', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_one'); ?>" name="<?php echo $this->get_field_name('skill_one'); ?>" type="text" value="<?php echo $skill_one; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('skill_one_max'); ?>"><?php _e('First skill value', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_one_max'); ?>" name="<?php echo $this->get_field_name('skill_one_max'); ?>" type="text" value="<?php echo $skill_one_max; ?>" />
	</p>

	<!-- skill two -->
	<p>
	<label for="<?php echo $this->get_field_id('skill_two'); ?>"><?php _e('Second skill name', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_two'); ?>" name="<?php echo $this->get_field_name('skill_two'); ?>" type="text" value="<?php echo $skill_two; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('skill_two_max'); ?>"><?php _e('Second skill value', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_two_max'); ?>" name="<?php echo $this->get_field_name('skill_two_max'); ?>" type="text" value="<?php echo $skill_two_max; ?>" />
	</p>	

	<!-- skill three -->
	<p>
	<label for="<?php echo $this->get_field_id('skill_three'); ?>"><?php _e('Third skill name', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_three'); ?>" name="<?php echo $this->get_field_name('skill_three'); ?>" type="text" value="<?php echo $skill_three; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('skill_three_max'); ?>"><?php _e('Third skill value', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_three_max'); ?>" name="<?php echo $this->get_field_name('skill_three_max'); ?>" type="text" value="<?php echo $skill_three_max; ?>" />
	</p>

	<!-- skill four -->
	<p>
	<label for="<?php echo $this->get_field_id('skill_four'); ?>"><?php _e('Fourth skill name', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_four'); ?>" name="<?php echo $this->get_field_name('skill_four'); ?>" type="text" value="<?php echo $skill_four; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('skill_four_max'); ?>"><?php _e('Fourth skill value', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_four_max'); ?>" name="<?php echo $this->get_field_name('skill_four_max'); ?>" type="text" value="<?php echo $skill_four_max; ?>" />
	</p>
							

	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['skill_one'] 			= strip_tags($new_instance['skill_one']);
		$instance['skill_one_max'] 		= intval($new_instance['skill_one_max']);
		$instance['skill_two'] 			= strip_tags($new_instance['skill_two']);
		$instance['skill_two_max'] 		= intval($new_instance['skill_two_max']);
		$instance['skill_three'] 		= strip_tags($new_instance['skill_three']);
		$instance['skill_three_max']	= intval($new_instance['skill_three_max']);
		$instance['skill_four'] 		= strip_tags($new_instance['skill_four']);
		$instance['skill_four_max'] 	= intval($new_instance['skill_four_max']);
	  
		return $instance;
	}
	
	// display widget
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		extract($args);

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$skill_one   	= isset( $instance['skill_one'] ) ? esc_html( $instance['skill_one'] ) : '';
		$skill_one_max  = isset( $instance['skill_one_max'] ) ? absint( $instance['skill_one_max'] ) : '';
		$skill_two   	= isset( $instance['skill_two'] ) ? esc_attr( $instance['skill_two'] ) : '';
		$skill_two_max  = isset( $instance['skill_two_max'] ) ? absint( $instance['skill_two_max'] ) : '';
		$skill_three   	= isset( $instance['skill_three'] ) ? esc_attr( $instance['skill_three'] ) : '';
		$skill_three_max= isset( $instance['skill_three_max'] ) ? absint( $instance['skill_three_max'] ) : '';
		$skill_four   	= isset( $instance['skill_four'] ) ? esc_attr( $instance['skill_four'] ) : '';		
		$skill_four_max = isset( $instance['skill_four_max'] ) ? absint( $instance['skill_four_max'] ) : '';

		echo $args['before_widget'];
?>

		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<?php if ($skill_one !='') : ?>
		<div class="roll-progress">
 			<div class="name"><?php echo esc_html($skill_one); ?></div>
			<div class="perc"><?php echo absint($skill_one_max) . '%'; ?></div>
            <div class="progress-bar" data-percent="<?php echo absint($skill_one_max); ?>" data-waypoint-active="yes">
				<div class="progress-animate"></div>
			</div>
		</div>
		<?php endif; ?>   
		<?php if ($skill_two !='') : ?>
		<div class="roll-progress">
 			<div class="name"><?php echo esc_html($skill_two); ?></div>
			<div class="perc"><?php echo absint($skill_two_max) . '%'; ?></div>
            <div class="progress-bar" data-percent="<?php echo absint($skill_two_max); ?>" data-waypoint-active="yes">
				<div class="progress-animate"></div>
			</div>
		</div>
		<?php endif; ?> 
		<?php if ($skill_three !='') : ?>
		<div class="roll-progress">
 			<div class="name"><?php echo esc_html($skill_three); ?></div>
			<div class="perc"><?php echo absint($skill_three_max) . '%'; ?></div>
            <div class="progress-bar" data-percent="<?php echo absint($skill_three_max); ?>" data-waypoint-active="yes">
				<div class="progress-animate"></div>
			</div>
		</div>
		<?php endif; ?> 
		<?php if ($skill_four !='') : ?>
		<div class="roll-progress">
 			<div class="name"><?php echo esc_html($skill_four); ?></div>
			<div class="perc"><?php echo absint($skill_four_max) . '%'; ?></div>
            <div class="progress-bar" data-percent="<?php echo absint($skill_four_max); ?>" data-waypoint-active="yes">
				<div class="progress-animate"></div>
			</div>
		</div>
		<?php endif; ?> 

	<?php
		echo $args['after_widget'];

	}
	
}