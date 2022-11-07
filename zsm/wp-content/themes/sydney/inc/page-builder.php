<?php
/**
 * Page builder support
 *
 * @package Sydney
 */


/* Defaults */
add_theme_support( 'siteorigin-panels', array( 
	'margin-bottom' => 0,
) );

/* Theme widgets */
function sydney_theme_widgets($widgets) {
	$theme_widgets = array(
		'Sydney_Services_Type_A',
		'Sydney_Services_Type_B',
		'Sydney_List',
		'Sydney_Facts',
		'Sydney_Clients',
		'Sydney_Testimonials',
		'Sydney_Skills',
		'Sydney_Action',
		'Sydney_Video_Widget',
		'Sydney_Social_Profile',
		'Sydney_Employees',
		'Sydney_Latest_News',
		'Sydney_Portfolio'
	);
	foreach($theme_widgets as $theme_widget) {
		if( isset( $widgets[$theme_widget] ) ) {
			$widgets[$theme_widget]['groups'] = array('sydney-theme');
			$widgets[$theme_widget]['icon'] = 'dashicons dashicons-schedule';
		}
	}
	return $widgets;
}
add_filter('siteorigin_panels_widgets', 'sydney_theme_widgets');

/* Add a tab for the theme widgets in the page builder */
function sydney_theme_widgets_tab($tabs){
	$tabs[] = array(
		'title' => __('Sydney Theme Widgets', 'sydney'),
		'filter' => array(
			'groups' => array('sydney-theme')
		)
	);
	return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'sydney_theme_widgets_tab', 20);

/* Replace default row options */
function sydney_row_styles($fields) {

	$fields['bottom_border'] = array(
		'name' => __('Bottom Border Color', 'sydney'),
		'type' => 'color',
		'priority' => 3,
		'group'	   => 'design'		
	);
	$fields['padding'] = array(
		'name' => __('Top/bottom padding', 'sydney'),
		'type' => 'measurement',
		'description' => __('Add a value in the field to change the top/bottom row padding, otherwise 100px will be applied by default', 'sydney'),
		'priority' => 4,
		'group'	   => 'layout'
	);
	$fields['align'] = array(
		'name' => __('Center align the content?', 'sydney'),
		'type' => 'checkbox',
		'description' => __('This may or may not work. It depends on the widget styles.', 'sydney'),
		'priority' => 5,
		'group'	   => 'design'		
	);		

	$fields['color'] = array(
		'name' => __('Color', 'sydney'),
		'type' => 'color',
		'description' => __('Color of the row.', 'sydney'),
		'priority' => 7,
		'group'	   => 'design'	
	);	
	$fields['background_image'] = array(
		'name' => __('Background Image', 'sydney'),
		'type' => 'image',
		'description' => __('Background image of the row.', 'sydney'),
		'priority' => 8,
		'group'		=> 'design'
	);

	$fields['mobile_padding'] = array(
		'name' 		  => __('Mobile padding', 'sydney'),
		'type' 		  => 'select',
		'description' => __('Here you can select a top/bottom row padding for screen sizes < 1024px', 'sydney'),		
		'options' 	  => array(
			'' 				=> __('Default', 'sydney'),
			'mob-pad-0' 	=> __('0', 'sydney'),
			'mob-pad-15'    => __('15px', 'sydney'),
			'mob-pad-30'    => __('30px', 'sydney'),
			'mob-pad-45'    => __('45px', 'sydney'),
		),
		'priority'    => 21,
		'group'	   => 'layout'		
	);
	$fields['overlay'] = array(
	    'name'        => __('Disable row overlay?', 'sydney'),
	    'type'        => 'checkbox',
	    'group'       => 'design',
	    'priority'    => 14,
	);
	$fields['overlay_color'] = array(
	    'name'        => __('Overlay color', 'sydney'),
	    'type'        => 'color',
	    'default'	  => '#000000',
	    'group'       => 'design',
	    'priority'    => 15,
	);

	return $fields;
}
//remove_filter('siteorigin_panels_row_style_fields', array('SiteOrigin_Panels_Default_Styling', 'row_style_fields' ) );
add_filter('siteorigin_panels_row_style_fields', 'sydney_row_styles');

/* Filter for the styles */
function sydney_row_styles_output($attr, $style) {
	//$attr['style'] = '';

	if(!empty($style['bottom_border'])) $attr['style'] .= 'border-bottom: 1px solid '. esc_attr($style['bottom_border']) . ';';
	
	if(!empty($style['color'])) {
		$attr['style'] .= 'color: ' . esc_attr($style['color']) . ';';
		$attr['data-hascolor'] = 'hascolor';
	}
	
	if(!empty($style['align'])) $attr['style'] .= 'text-align: center;';
	if(!empty( $style['background_image'] )) {
		$url = wp_get_attachment_image_src( $style['background_image'], 'full' );
		if( !empty($url) ) {
			$attr['style'] .= 'background-image: url(' . esc_url($url[0]) . ');';
			$attr['data-hasbg'] = 'hasbg';
		}
	}
	if(!empty($style['padding'])) {
		$attr['style'] .= 'padding: ' . esc_attr($style['padding']) . ' 0; ';
	} else {
		$attr['style'] .= 'padding: 100px 0; ';
	}

	if( !empty( $style['mobile_padding'] ) ) {
		$attr['class'][] = esc_attr($style['mobile_padding']);
	}
    if( !empty( $style['column_padding'] ) ) {
       $attr['class'][] = 'no-col-padding';
    }
    
	if ( empty($style['overlay']) ) {
    	$attr['data-overlay'] = 'true';
	}
	if ( !empty($style['overlay_color']) ) {
    	$attr['data-overlay-color'] = esc_attr($style['overlay_color']);		
	}

	if(empty($attr['style'])) unset($attr['style']);
	return $attr;
}
add_filter('siteorigin_panels_row_style_attributes', 'sydney_row_styles_output', 10, 2);

/**
 * Page builder widget options
 */
function sydney_custom_widget_style_fields($fields) {
	$fields['content_alignment'] = array(
	    'name'        => __('Content alignment', 'sydney'),
		'type' 		  => 'select',
	    'group'       => 'design',
		'options' => array(
			'left' => __('Left', 'sydney'),
			'center' => __('Center', 'sydney'),
			'right' => __('Right', 'sydney'),
		),
		'default'	  => 'left',
	    'description' => __('This setting depends on the content, it may or may not work', 'sydney'),
	    'priority'    => 10,
	);	
	$fields['title_color'] = array(
	    'name'        => __('Widget title color', 'sydney'),
	    'type'        => 'color',
	    'default'	  => '#443f3f',
	    'group'       => 'design',
	    'priority'    => 11,
	);	
	$fields['headings_color'] = array(
	    'name'        => __('Headings color', 'sydney'),
	    'type'        => 'color',
	    'default'	  => '#443f3f',
	    'group'       => 'design',
	    'description' => __('This applies to all headings in the widget, except the widget title', 'sydney'),
	    'priority'    => 12,
	);

  return $fields;
}
add_filter( 'siteorigin_panels_widget_style_fields', 'sydney_custom_widget_style_fields');

/**
 * Output page builder widget options
 */
function sydney_custom_widget_style_attributes( $attributes, $args ) {

	if ( !empty($args['title_color']) ) {
    	$attributes['data-title-color'] = esc_attr($args['title_color']);		
	}
	if ( !empty($args['headings_color']) ) {
    	$attributes['data-headings-color'] = esc_attr($args['headings_color']);		
	}
	if ( !empty($args['content_alignment']) ) {
		$attributes['style'] .= 'text-align: ' . esc_attr($args['content_alignment']) . ';';
	}	
    return $attributes;
}
add_filter('siteorigin_panels_widget_style_attributes', 'sydney_custom_widget_style_attributes', 10, 2);

/**
 * Remove defaults
 */
function sydney_remove_default_so_row_styles( $fields ) {
	unset( $fields['background_image_attachment'] );
	unset( $fields['background_display'] );
	unset( $fields['border_color'] );	
	return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'sydney_remove_default_so_row_styles' );
add_filter('siteorigin_premium_upgrade_teaser', '__return_false');