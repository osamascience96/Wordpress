<?php

/**
 * Metabox for the single posts/pages
 *
 * @package    	Sydney_Toolbox
 * @link        http://athemes.com
 * Author:      aThemes
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


$theme  = wp_get_theme();
$parent = wp_get_theme()->parent();
if ( ($theme != 'Sydney Pro' ) && ($parent != 'Sydney Pro') )
	return;

function sydney_toolbox_singles_options_metabox() {
    new Sydney_Toolbox_Singles_Options();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'sydney_toolbox_singles_options_metabox' );
    add_action( 'load-post-new.php', 'sydney_toolbox_singles_options_metabox' );
}

class Sydney_Toolbox_Singles_Options {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'color_picker' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
        $post_types = array('post', 'page', 'services', 'employees', 'testimonials', 'projects', 'timeline-events');
        if ( in_array( $post_type, $post_types )) {
			add_meta_box(
				'st_singles_metabox'
				,__( 'Post/page options', 'sydney-toolbox' )
				,array( $this, 'render_meta_box_content' )
				,$post_type
				,'advanced'
				,'high'
			);
		}
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['sydney_toolbox_singles_options_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sydney_toolbox_singles_options_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'sydney_toolbox_singles_options' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$background_image 	= isset( $_POST['sydney_toolbox_background_image'] ) ? esc_url_raw($_POST['sydney_toolbox_background_image']) : false;
		$background_color	= isset( $_POST['sydney_toolbox_background_color'] ) ? sanitize_text_field($_POST['sydney_toolbox_background_color']) : false;
		$title 				= isset( $_POST['sydney_toolbox_hide_title'] ) ? (bool)($_POST['sydney_toolbox_hide_title']) : '';		
		$opacity 			= isset( $_POST['sydney_toolbox_opacity'] ) ? sanitize_text_field($_POST['sydney_toolbox_opacity']) : false;

		update_post_meta( $post_id, 'wpcf-single-background-image', $background_image );
		update_post_meta( $post_id, 'wpcf-single-background-color', $background_color );
		update_post_meta( $post_id, 'wpcf-single-hide-title', $title );		
		update_post_meta( $post_id, 'wpcf-single-content-opacity', $opacity );		
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'sydney_toolbox_singles_options', 'sydney_toolbox_singles_options_nonce' );
		
		$background_image 	= get_post_meta( $post->ID, 'wpcf-single-background-image', true );
    	$background_color 	= get_post_meta( $post->ID, 'wpcf-single-background-color', true );
    	$title 				= get_post_meta( $post->ID, 'wpcf-single-hide-title', true );
    	$opacity  			= get_post_meta( $post->ID, 'wpcf-single-content-opacity', true );
	?>

		<p><em><?php echo __('Here you can control the options just for this page/post.'); ?></em></p>		

		<p><strong><label for="sydney_toolbox_background_image"><?php _e( 'Background image URL', 'sydney-toolbox' ); ?></label></strong></p>
		<p><em><?php echo __('If you want to use this option, make sure you leave the next background color option empty.'); ?></em></p>				
		<p><input type="text" class="widefat" id="sydney_toolbox_background_image" name="sydney_toolbox_background_image" value="<?php echo esc_html($background_image); ?>"></p>
		<p><strong><label for="sydney_toolbox_background_color"><?php _e( 'Background color', 'sydney-toolbox' ); ?></label></strong></p>
		<p><input type="text" class="color-field" id="sydney_toolbox_background_color" name="sydney_toolbox_background_color" value="<?php echo esc_html($background_color); ?>"></p>
		<p><input type="checkbox" id="sydney_toolbox_hide_title" class="checkbox" name="sydney_toolbox_hide_title" <?php checked( $title ); ?> /></p>
		<p><label for="sydney_toolbox_hide_title"><?php _e( 'Check this box to hide the title', 'sydney-toolbox' ); ?></label></p>	
		<p><strong><label for="sydney_toolbox_opacity"><?php _e( 'Content wrapper opacity', 'sydney-toolbox' ); ?></label></strong></p>
		<p><em><?php echo __('Enter a value for the opacity of the white content background. Values from 0 to 1 (example 0.4)'); ?></em></p>		
		<p><input type="text" class="widefat" id="sydney_toolbox_opacity" name="sydney_toolbox_opacity" value="<?php echo esc_html($opacity); ?>"></p>

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
