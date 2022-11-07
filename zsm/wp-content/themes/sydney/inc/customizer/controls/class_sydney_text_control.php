<?php
/**
 * Text control
 *
 * @package Sydney
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sydney_Text_Control extends WP_Customize_Control {
		
	/**
	 * The type of control being rendered
	 */
	public $type = 'sydney-text-control';

	public $controls_general;

	public $controls_design;

	
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
		<?php if( !empty( $this->label ) ) { ?>
			<span class="customize-control-title"><?php echo wp_kses_post( $this->label ); ?></span>
		<?php } ?>
		<?php if( !empty( $this->description ) ) { ?>
			<span class="customize-control-description"><?php echo $this->description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php } ?>		
	<?php
	}
}
