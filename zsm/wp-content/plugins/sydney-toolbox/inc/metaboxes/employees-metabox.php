<?php

/**
 * Metabox for the Employees custom post type
 *
 * @package    	Sydney_Toolbox
 * @link        http://athemes.com
 * Author:      aThemes
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function sydney_toolbox_employees_metabox() {
    new Sydney_Toolbox_Employees();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'sydney_toolbox_employees_metabox' );
    add_action( 'load-post-new.php', 'sydney_toolbox_employees_metabox' );
}

class Sydney_Toolbox_Employees {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_employees_metabox'
			,__( 'Employee info', 'sydney-toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'employees'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['sydney_toolbox_employees_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sydney_toolbox_employees_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'sydney_toolbox_employees' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'employees' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}


		$position 	= isset( $_POST['sydney_toolbox_emp_position'] ) ? sanitize_text_field($_POST['sydney_toolbox_emp_position']) : false;
		$facebook 	= isset( $_POST['sydney_toolbox_emp_facebook'] ) ? esc_url_raw($_POST['sydney_toolbox_emp_facebook']) : false;
		$twitter 	= isset( $_POST['sydney_toolbox_emp_twitter'] ) ? esc_url_raw($_POST['sydney_toolbox_emp_twitter']) : false;
		$google 	= isset( $_POST['sydney_toolbox_emp_google'] ) ? esc_url_raw($_POST['sydney_toolbox_emp_google']) : false;
		$link 	= isset( $_POST['sydney_toolbox_emp_link'] ) ? esc_url_raw($_POST['sydney_toolbox_emp_link']) : false;
		
		update_post_meta( $post_id, 'wpcf-position', $position );
		update_post_meta( $post_id, 'wpcf-facebook', $facebook );
		update_post_meta( $post_id, 'wpcf-twitter', $twitter );
		update_post_meta( $post_id, 'wpcf-google-plus', $google );
		update_post_meta( $post_id, 'wpcf-custom-link', $link );
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'sydney_toolbox_employees', 'sydney_toolbox_employees_nonce' );

		$position = get_post_meta( $post->ID, 'wpcf-position', true );
		$facebook = get_post_meta( $post->ID, 'wpcf-facebook', true );
		$twitter  = get_post_meta( $post->ID, 'wpcf-twitter', true );
		$google   = get_post_meta( $post->ID, 'wpcf-google-plus', true );
		$link     = get_post_meta( $post->ID, 'wpcf-custom-link', true );

	?>
		<p><strong><label for="sydney_toolbox_emp_position"><?php _e( 'Employee position', 'sydney-toolbox' ); ?></label></strong></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_emp_position" name="sydney_toolbox_emp_position" value="<?php echo esc_html($position); ?>"></p>	
		<p><strong><label for="sydney_toolbox_emp_facebook"><?php _e( 'Employee Facebook', 'sydney-toolbox' ); ?></label></strong></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_emp_facebook" name="sydney_toolbox_emp_facebook" value="<?php echo esc_url($facebook); ?>"></p>				
		<p><strong><label for="sydney_toolbox_emp_twitter"><?php _e( 'Employee Twitter', 'sydney-toolbox' ); ?></label></strong></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_emp_twitter" name="sydney_toolbox_emp_twitter" value="<?php echo esc_url($twitter); ?>"></p>
		<p><strong><label for="sydney_toolbox_emp_google"><?php _e( 'Employee Google', 'sydney-toolbox' ); ?></label></strong></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_emp_google" name="sydney_toolbox_emp_google" value="<?php echo esc_url($google); ?>"></p>
		<p><strong><label for="sydney_toolbox_emp_link"><?php _e( 'Employee Link', 'sydney-toolbox' ); ?></label></strong></p>
		<p><em><?php _e('Add a link here if you want the employee name to link somewhere.', 'sdyney-toolbox'); ?></em></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_emp_link" name="sydney_toolbox_emp_link" value="<?php echo esc_url($link); ?>"></p>

	<?php
	}
}
