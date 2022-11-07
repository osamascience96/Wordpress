<?php

/**
 * Integration with WPML for custom Elementor blocks
 */

class Sydney_WPML {

    public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'translatable_widgets' ) );
	}

	public function translatable_widgets( $widgets ) {

		$widgets[ 'athemes-testimonials' ] = [
			'conditions' => [ 'widgetType' => 'athemes-testimonials' ],
			'fields'     => [],
			'integration-class' => 'Sydney_WPML_Elementor_Testimonials',
		];

		$widgets[ 'athemes-employee-carousel' ] = [
			'conditions' => [ 'widgetType' => 'athemes-employee-carousel' ],
			'fields'     => [],
			'integration-class' => 'Sydney_WPML_Elementor_Employees',
		];
		
		$widgets[ 'athemes-portfolio' ] = [
			'conditions' => [ 'widgetType' => 'athemes-portfolio' ],
			'fields'     => [],
			'integration-class' => 'Sydney_WPML_Elementor_Portfolio',
		];		

		$widgets[ 'athemes-posts' ] = [
			'conditions' => [ 'widgetType' => 'athemes-posts' ],
			'fields'     => [
				[
					'field'       => 'see_all_text',
					'type'        => __( '[aThemes Posts] See all button text', 'sydney' ),
					'editor_type' => 'LINE'
				],			 		  
			],
		];
					
		$this->load_integration_classes();

		return $widgets;
	}
	
	private function load_integration_classes() {
		require get_template_directory() . '/inc/integrations/wpml/class-sydney-wpml-testimonials.php';
		require get_template_directory() . '/inc/integrations/wpml/class-sydney-wpml-employee-carousel.php';
		require get_template_directory() . '/inc/integrations/wpml/class-sydney-wpml-portfolio.php';
	}
}

$sydney_wpml = new Sydney_WPML();