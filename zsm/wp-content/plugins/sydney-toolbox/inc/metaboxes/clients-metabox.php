<?php

/**
 * Metabox for the Clients custom post type
 *
 * @package    	Sydney_Toolbox
 * @link        http://athemes.com
 * Author:      aThemes
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function sydney_toolbox_clients_metabox() {
    new Sydney_Toolbox_Clients();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'sydney_toolbox_clients_metabox' );
    add_action( 'load-post-new.php', 'sydney_toolbox_clients_metabox' );
}

class Sydney_Toolbox_Clients {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
        global $post;
		add_meta_box(
			'st_clients_metabox'
			,__( 'Client info', 'sydney-toolbox' )
			,array( $this, 'render_meta_box_content' )
			,'clients'
			,'advanced'
			,'high'
		);
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['sydney_toolbox_clients_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sydney_toolbox_clients_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'sydney_toolbox_clients' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'clients' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$link 	= isset( $_POST['sydney_toolbox_clients_info'] ) ? esc_url_raw($_POST['sydney_toolbox_clients_info']) : false;
		update_post_meta( $post_id, 'wpcf-client-link', $link );

	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'sydney_toolbox_clients', 'sydney_toolbox_clients_nonce' );

		$link = get_post_meta( $post->ID, 'wpcf-client-link', true );

	?>
		<p><strong><label for="sydney_toolbox_clients_info"><?php _e( 'Client link', 'sydney-toolbox' ); ?></label></strong></p>
		<p><em><?php _e('Add a link for the client\'s website here [optional]', 'sdyney-toolbox'); ?></em></p>
		<p><input type="text" class="widefat" id="sydney_toolbox_clients_info" name="sydney_toolbox_clients_info" value="<?php echo esc_url($link); ?>"></p>	

	<?php
	}
}
