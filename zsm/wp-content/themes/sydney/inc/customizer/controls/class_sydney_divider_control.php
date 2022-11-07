<?php
/**
 * Divider control
 *
 * @package Sydney
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sydney_Divider_Control extends WP_Customize_Control {
		
	/**
	 * The type of control being rendered
	 */
	public $type = 'sydney-divider-control';

	/**
	 * Constructor
	 */
	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the control in the customizer
	 */
	public function render_content() {
	?>
		<hr class="sydney-cust-divider">
	<?php
	}
}
