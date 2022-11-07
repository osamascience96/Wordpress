<?php
/**
 * Upsell control
 *
 * @package Sydney
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sydney_Upsell_Message extends WP_Customize_Control {
		
	/**
	 * The type of control being rendered
	 */
	public $type 		 = 'sydney-upsell-features';
	public $button_title = '';
	public $button_link  = 'https://athemes.com/sydney-upgrade/?utm_source=theme_customizer_deep&utm_medium=sydney_customizer&utm_campaign=Sydney';

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
		$this->button_title = __( 'Learn More', 'sydney' ); ?>

		<hr class="sydney-cust-divider">
		<div class="sydney-upsell-feature-wrapper">
			<p><em><?php echo esc_html( $this->description ); ?></em></p>
			
			<p>
				<a href="<?php echo esc_url( $this->button_link ) ?>" role="button" class="button-secondary button" target="_blank">
					<?php echo esc_html( $this->button_title ); ?>
				</a>
			</p>
		</div>

	<?php
	}
}
