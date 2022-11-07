<?php

/**
 * Integration with WPML for aThemes: Testimonials block
 */
class Sydney_Pro_WPML_Elementor_Portfolio extends WPML_Elementor_Module_With_Items {
	
 
	/**
	 * @return string
	 */
	public function get_items_field() {
	   return 'portfolio_list';
	}
   
	/**
	 * @return array
	 */
	public function get_fields() {
	   return array( 'title', 'term', 'link' => array( 'url' ), );
	}
   
	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
	   switch( $field ) {
			case 'title':
				return esc_html__( '[aThemes Portfolio] Title', 'sydney' );
   
		  	case 'term':
				return esc_html__( '[aThemes Portfolio] Term', 'sydney' );
   
			case 'link':
				return esc_html__( '[aThemes Portfolio] Link', 'sydney' );
   
			default:
				return '';
	   }
	}
   
	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_editor_type( $field ) {
	   switch( $field ) {
			case 'title':
			case 'term':
			case 'link':	
				return 'LINE';
   
			default:
				return '';
	   }
	}

}