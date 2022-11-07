<?php
/**
 * Sanitize functions
 *
 * @package Sydney
 */


/**
 * Selects
 */
function sydney_sanitize_select( $input, $setting ){
          
    $input = sanitize_key($input);

    $choices = $setting->manager->get_control( $setting->id )->choices;
                      
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
      
}

/**
 * Sanitize blog elements
 */
function sydney_sanitize_blog_meta_elements( $input ) {
    $input     = (array) $input;
    $sanitized = array();

    foreach ( $input as $sub_value ) {
        if ( in_array( $sub_value, array( 'post_date', 'post_categories', 'post_author', 'post_comments' ), true ) ) {
            $sanitized[] = $sub_value;
        }
    }
    return $sanitized;
}

function sydney_sanitize_single_meta_elements( $input ) {
    $input     = (array) $input;
    $sanitized = array();

    foreach ( $input as $sub_value ) {
        if ( in_array( $sub_value, array( 'sydney_posted_on', 'sydney_posted_by', 'sydney_post_categories', 'sydney_entry_comments' ), true ) ) {
            $sanitized[] = $sub_value;
        }
    }
    return $sanitized;
}

/**
 * Sanitize header components
 */
function sydney_sanitize_header_components( $input ) {
    $input      = (array) $input;
    $sanitized  = array();
    $elements   = array_keys( sydney_header_elements() );

    foreach ( $input as $sub_value ) {
        if ( in_array( $sub_value, $elements, true ) ) {
            $sanitized[] = $sub_value;
        }
    }
    return $sanitized;    
}

/**
 * Sanitize loop product components
 */
function sydney_sanitize_product_loop_components( $input ) {
    $input      = (array) $input;
    $sanitized  = array();
    $elements   = array( 'woocommerce_template_loop_product_title', 'woocommerce_template_loop_rating', 'woocommerce_template_loop_price', 'sydney_loop_product_category', 'sydney_loop_product_description' );

    foreach ( $input as $sub_value ) {
        if ( in_array( $sub_value, $elements, true ) ) {
            $sanitized[] = $sub_value;
        }
    }
    return $sanitized;    
}


/**
 * Sanitize top bar components
 */
function sydney_sanitize_topbar_components( $input ) {
    $input      = (array) $input;
    $sanitized  = array();
    $elements   = array_keys( sydney_topbar_elements() );

    foreach ( $input as $sub_value ) {
        if ( in_array( $sub_value, $elements, true ) ) {
            $sanitized[] = $sub_value;
        }
    }
    return $sanitized;    
}

/**
 * Sanitize text
 */
function sydney_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize URLs
 */
function sydney_sanitize_urls( $input ) {
    if ( strpos( $input, ',' ) !== false) {
        $input = explode( ',', $input );
    }
    if ( is_array( $input ) ) {
        foreach ($input as $key => $value) {
            $input[$key] = esc_url_raw( $value );
        }
        $input = implode( ',', $input );
    }
    else {
        $input = esc_url_raw( $input );
    }
    return $input;
}

/**
 * Sanitize hex and rgba
 */
function sydney_sanitize_hex_rgba( $input, $setting ) {
    if ( empty( $input ) || is_array( $input ) ) {
        return $setting->default;
    }

    if ( false === strpos( $input, 'rgb' ) ) {
        $input = sanitize_hex_color( $input );
    } else {
        if ( false === strpos( $input, 'rgba' ) ) {
            // Sanitize as RGB color
            $input = str_replace( ' ', '', $input );
            sscanf( $input, 'rgb(%d,%d,%d)', $red, $green, $blue );
            $input = 'rgb(' . sydney_in_range( $red, 0, 255 ) . ',' . sydney_in_range( $green, 0, 255 ) . ',' . sydney_in_range( $blue, 0, 255 ) . ')';
        }
        else {
            // Sanitize as RGBa color
            $input = str_replace( ' ', '', $input );
            sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
            $input = 'rgba(' . sydney_in_range( $red, 0, 255 ) . ',' . sydney_in_range( $green, 0, 255 ) . ',' . sydney_in_range( $blue, 0, 255 ) . ',' . sydney_in_range( $alpha, 0, 1 ) . ')';
        }
    }
    return $input;
}

/**
 * Helper function to check if value is in range
 */
function sydney_in_range( $input, $min, $max ){
    if ( $input < $min ) {
        $input = $min;
    }
    if ( $input > $max ) {
        $input = $max;
    }
    return $input;
}

/**
 * Sanitize fonts
 */
function sydney_google_fonts_sanitize( $input ) {
    $val =  json_decode( $input, true );
    if( is_array( $val ) ) {
        foreach ( $val as $key => $value ) {
            $val[$key] = sanitize_text_field( $value );
        }
        $input = json_encode( $val );
    }
    else {
        $input = json_encode( sanitize_text_field( $val ) );
    }
    return $input;
}