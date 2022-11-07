<?php

/**
 * Metabox for the Timeline Events custom post type
 *
 * @package    	Sydney_Toolbox
 * @link        http://athemes.com
 * Author:      aThemes
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function sydney_toolbox_timeline_events_metabox() {
    new Sydney_Toolbox_Timeline_Events();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'sydney_toolbox_timeline_events_metabox' );
    add_action( 'load-post-new.php', 'sydney_toolbox_timeline_events_metabox' );
}

class Sydney_Toolbox_Timeline_Events {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'color_picker' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_timeline_metabox'
			,__( 'Timeline info', 'sydney-toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'timeline-events'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['sydney_toolbox_timeline_events_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sydney_toolbox_timeline_events_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'sydney_toolbox_timeline_events' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'timeline-events' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$date 	= isset( $_POST['sydney_toolbox_event_date'] ) ? sanitize_text_field($_POST['sydney_toolbox_event_date']) : false;
		$icon 	= isset( $_POST['sydney_toolbox_event_icon'] ) ? sanitize_text_field($_POST['sydney_toolbox_event_icon']) : false;
		$color 	= isset( $_POST['sydney_toolbox_event_color'] ) ? strip_tags($_POST['sydney_toolbox_event_color']) : '';		
		$link 	= isset( $_POST['sydney_toolbox_event_link'] ) ? esc_url_raw($_POST['sydney_toolbox_event_link']) : false;

		update_post_meta( $post_id, 'wpcf-event-date', $date );
		update_post_meta( $post_id, 'wpcf-event-icon', $icon );
		update_post_meta( $post_id, 'wpcf-event-icon-color', $color );		
		update_post_meta( $post_id, 'wpcf-event-url', $link );		
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'sydney_toolbox_timeline_events', 'sydney_toolbox_timeline_events_nonce' );
		
		$date 	= get_post_meta( $post->ID, 'wpcf-event-date', true );
		$icon 	= get_post_meta( $post->ID, 'wpcf-event-icon', true );
		$color 	= get_post_meta( $post->ID, 'wpcf-event-icon-color', true );		
		$link 	= get_post_meta( $post->ID, 'wpcf-event-url', true );		
	?>

		<p><strong><label for="sydney_toolbox_event_date"><?php _e( 'Event date', 'sydney-toolbox' ); ?></label></strong></p>
		<p><em><?php echo __('Add the date when this timeline event happened.', 'sydney-toolbox'); ?></em></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_event_date" name="sydney_toolbox_event_date" value="<?php echo esc_html($date); ?>"></p>
		
		<p><strong><label for="sydney_toolbox_event_icon"><?php _e( 'Event icon', 'sydney-toolbox' ); ?></label></strong></p>
		<?php if( get_option( 'sydney-fontawesome-v5' ) ) : ?>
			<p><em><?php _e('Example: <strong>fab fa-android</strong>. Full list of icons is <a href="http://fortawesome.github.io/Font-Awesome/cheatsheet/" target="_blank">here</a> and a explanation about icons class prefix <a href="https://fontawesome.com/v5.15/how-to-use/on-the-web/setup/upgrading-from-version-4#name-changes" target="_blank">here</a>', 'sydney-toolbox'); ?></em></p>
		<?php else : ?>
			<p><em><?php _e('Example: <strong>fa-android</strong>. Full list of icons is <a href="http://fortawesome.github.io/Font-Awesome/cheatsheet/" target="_blank">here</a>.', 'sydney-toolbox'); ?></em></p>
		<?php endif; ?>
		<p><input type="text" class="widefat" id="sydney_toolbox_event_icon" name="sydney_toolbox_event_icon" value="<?php echo esc_html($icon); ?>"></p>

		<p><strong><label for="sydney_toolbox_event_color"><?php _e( 'Event color', 'sydney-toolbox' ); ?></label></strong></p>
		<p><em><?php echo __('Select a color for the event icon.', 'sydney-toolbox'); ?></em></p>
		<p><input type="text" class="color-field" id="sydney_toolbox_event_color" name="sydney_toolbox_event_color" value="<?php echo esc_url($color); ?>"></p>	
		<p><strong><label for="sydney_toolbox_event_link"><?php _e( 'Event link', 'sydney-toolbox' ); ?></label></strong></p>
		<p><em><?php echo __('You can link your event to a page of your choice by entering the URL in this field', 'sydney-toolbox'); ?></em></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_event_link" name="sydney_toolbox_event_link" value="<?php echo esc_url($link); ?>"></p>

		<script>
		(function( $ ) {
			$(function() {
			$('.color-field').wpColorPicker();
			});
		})( jQuery );
		</script>

	<?php
	}

	public function color_picker() {
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');		
	}

}
