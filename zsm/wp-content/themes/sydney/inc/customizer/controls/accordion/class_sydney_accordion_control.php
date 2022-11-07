<?php
/**
 * Sydney Accordion Control
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sydney_Accordion_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 */
	public $type  = 'sydney-accordion';
    public $until = '';

    /**
     * Displays the control content.
     *
     */
    public function render_content() {
    ?>
        <a href="#" class="sydney-accordion-title" data-until="<?php echo esc_attr( $this->until ); ?>"><?php echo esc_html( $this->label ); ?></a>  
    <?php 
    }
}
