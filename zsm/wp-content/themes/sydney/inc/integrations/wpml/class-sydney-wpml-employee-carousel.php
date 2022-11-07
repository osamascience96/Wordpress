<?php

/**
 * Integration with WPML for aThemes: Testimonials block
 */
class Sydney_Pro_WPML_Elementor_Employees extends WPML_Elementor_Module_With_Items {
	
 
	/**
	 * @return string
	 */
	public function get_items_field() {
	   return 'employee_list';
	}
   
	/**
	 * @return array
	 */
	public function get_fields() {
	   return array( 'person', 'position', 'link' => array( 'url' ), );
	}
   
	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
	   switch( $field ) {
			case 'person':
				return esc_html__( '[aThemes Employees] Name', 'sydney' );
   
		  	case 'position':
				return esc_html__( '[aThemes Employees] Position', 'sydney' );
   
			case 'link':
				return esc_html__( '[aThemes Employees] Link', 'sydney' );
   
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
			case 'person':
			case 'position':
			case 'link':	
				return 'LINE';
   
			default:
				return '';
	   }
	}

}