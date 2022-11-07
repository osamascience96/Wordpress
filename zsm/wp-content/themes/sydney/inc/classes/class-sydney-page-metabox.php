<?php
/**
 * Single page metabox
 *
 * @package Sydney
 */


function sydney_page_metabox_init() {
    new Sydney_Page_Metabox();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'sydney_page_metabox_init' );
    add_action( 'load-post-new.php', 'sydney_page_metabox_init' );
}

class Sydney_Page_Metabox {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
		
		$types = array( 'page' );

        if ( in_array( $post_type, $types ) && ( 'attachment' !== $post_type ) ) {
			add_meta_box(
				'sydney_single_page_metabox'
				,__( 'Sydney page options', 'sydney' )
				,array( $this, 'render_meta_box_content' )
				,$types
				,'side'
				,'low'
			);
        }
	}

	public function save( $post_id ) {
	
		// Check if our nonce is set.
		if ( ! isset( $_POST['sydney_single_page_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sydney_single_page_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'sydney_single_page_box' ) )
			return $post_id;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;


		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	

		//Transparent menu
		if ( 'page' == $_POST['post_type'] ) {
			$transparent_menu_bar = ( isset( $_POST['sydney_transparent_menu'] ) && '1' === $_POST['sydney_transparent_menu'] ) ? 1 : 0;
			update_post_meta( $post_id, '_sydney_transparent_menu', $transparent_menu_bar );
		}
		
	}

	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'sydney_single_page_box', 'sydney_single_page_box_nonce' );
		$merge_top_bar 		= get_post_meta( $post->ID, '_sydney_transparent_menu', true );

	?>
	<?php if ( 'page' == get_post_type( $post ) ) : ?>
	<p>
		<label><input type="checkbox" name="sydney_transparent_menu" value="1" <?php checked( $merge_top_bar, 1 ); ?> /><?php esc_html_e( 'Transparent menu bar', 'sydney' ); ?></label>
	</p>	
	<?php endif; ?>

	<?php
	}

	/**
	 * Function to sanitize selects
	 */
	public function sanitize_selects( $input, $choices ) {

		$input = sanitize_key( $input );

		return ( in_array( $input, $choices ) ? $input : '' );
	}
}