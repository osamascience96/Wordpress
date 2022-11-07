<?php
/**
 * List widget
 *
 * @package Sydney
 */

class Sydney_List extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_list', 'description' => __('A simple list widget', 'sydney'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('list', __('Sydney FP: List','sydney'), $widget_ops, $control_ops);
	}

	public function widget( $args, $instance ) {

		$title 		= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text 		= isset( $instance['text'] ) ? $instance['text'] : '';
		$list 		= isset( $instance['list'] ) ? $instance['list'] : '';
		$list 		= preg_replace( "/\^+(.*)?/i", "<ul class='roll-list'><li>$1</li></ul>", $list );
		$list 		= preg_replace( "/(\<\/ul\>\n(.*)\<ul class='roll-list'\>*)+/", "", $list );
		$button_url = isset( $instance['button_url'] ) ? esc_url($instance['button_url']) : '';
		$button_text= isset( $instance['button_text'] ) ? esc_html($instance['button_text']) : '';

		echo $args['before_widget'];

		if ( ! empty( $title ) ) { echo $args['before_title'] . $title . $args['after_title']; } ?>

		<?php echo wpautop($text); ?>
		<?php echo $list; ?>
		<?php if ($button_url && $button_text) : ?>
			<a class="roll-button border" href="<?php echo $button_url; ?>"><?php echo $button_text; ?></a>
		<?php endif; ?>
		
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['button_url'] 	= esc_url_raw($new_instance['button_url']);
		$instance['button_text'] 	= strip_tags($new_instance['button_text']);
		if ( current_user_can('unfiltered_html') ) {
			$instance['list'] =  $new_instance['list'];
			$instance['text'] =  $new_instance['text'];
		} else {
			$instance['list'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['list']) ) );
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
		}
		return $instance;
	}

	public function form( $instance ) {
		$instance 	= wp_parse_args( (array) $instance, array( 'title' => '', 'list' => '', 'text' => '', 'button_url' => '', 'button_text' => '' ) );
		$title 		= strip_tags($instance['title']);
		$button_url = esc_url($instance['button_url']);
		$button_text= esc_html($instance['button_text']);
		$text 		= esc_textarea($instance['text']);
		$list 		= esc_textarea($instance['list']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'sydney'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Add a bit of text here. It will be displayed.', 'sydney'); ?></label>
		<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea></p>

		<p><label for="<?php echo $this->get_field_id('list'); ?>"><?php _e('Add your list items here. One item per row, start each row with <strong>^</strong>. Example: <strong>^ list item </strong>', 'sydney'); ?></label>
		<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('list'); ?>" name="<?php echo $this->get_field_name('list'); ?>"><?php echo $list; ?></textarea></p>

		<p><label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e('Call to action button URL:', 'sydney'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo esc_attr($button_url); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e('Call to action button text:', 'sydney'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo esc_attr($button_text); ?>" /></p>

<?php
	}
}