<?php

/**
 * Metabox for the Services custom post type
 *
 * @package    	Sydney_Toolbox
 * @link        http://athemes.com
 * Author:      aThemes
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function sydney_toolbox_services_metabox() {
    new Sydney_Toolbox_Services();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'sydney_toolbox_services_metabox' );
    add_action( 'load-post-new.php', 'sydney_toolbox_services_metabox' );
}

class Sydney_Toolbox_Services {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_services_metabox'
			,__( 'Service info', 'sydney-toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'services'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['sydney_toolbox_services_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sydney_toolbox_services_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'sydney_toolbox_services' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'services' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$icon = isset( $_POST['sydney_toolbox_service_icon'] ) ? sanitize_text_field($_POST['sydney_toolbox_service_icon']) : false;
		$link = isset( $_POST['sydney_toolbox_service_link'] ) ? esc_url_raw($_POST['sydney_toolbox_service_link']) : false;

		update_post_meta( $post_id, 'wpcf-service-icon', $icon );
		update_post_meta( $post_id, 'wpcf-service-link', $link );		
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'sydney_toolbox_services', 'sydney_toolbox_services_nonce' );
		$icon = get_post_meta( $post->ID, 'wpcf-service-icon', true ); //Types generated fields compatibility
		$link = get_post_meta( $post->ID, 'wpcf-service-link', true );		
	?>

		<p><strong><label for="sydney_toolbox_service_icon"><?php _e( 'Service icon', 'sydney-toolbox' ); ?></label></strong></p>
		<?php if( get_option( 'sydney-fontawesome-v5' ) ) : ?>
			<p><em><?php _e('Example: <strong>fab fa-android</strong>. Full list of icons is <a href="http://fortawesome.github.io/Font-Awesome/cheatsheet/" target="_blank">here</a> and a explanation about icons class prefix <a href="https://fontawesome.com/v5.15/how-to-use/on-the-web/setup/upgrading-from-version-4#name-changes" target="_blank">here</a>', 'sydney-toolbox'); ?></em></p>
		<?php else : ?>
			<p><em><?php _e('Example: <strong>fa fa-android</strong>. Full list of icons is <a href="http://fortawesome.github.io/Font-Awesome/cheatsheet/" target="_blank">here</a>.', 'sydney-toolbox'); ?></em></p>
		<?php endif; ?>
		<p><input type="text" class="widefat" id="sydney_toolbox_service_icon" name="sydney_toolbox_service_icon" value="<?php echo esc_html($icon); ?>"></p>

		<p><strong><label for="sydney_toolbox_service_link"><?php _e( 'Service link', 'sydney-toolbox' ); ?></label></strong></p>
		<p><em><?php esc_html_e('You can link your service to a page of your choice by entering the URL in this field', 'sydney-toolbox'); ?></em></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_service_link" name="sydney_toolbox_service_link" value="<?php echo esc_url($link); ?>"></p>		
	<?php
	}
}
