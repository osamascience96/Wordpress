<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
use  Elementor\Group_Control_Image_Size ;
function lae_get_terms( $taxonomy )
{
    global  $wpdb ;
    $term_coll = array();
    
    if ( taxonomy_exists( $taxonomy ) ) {
        $terms = get_terms( $taxonomy );
        // Get all terms of a taxonomy
        if ( $terms && !is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $term_coll[$term->term_id] = $term->name;
            }
        }
    } else {
        $qt = 'SELECT * FROM ' . $wpdb->terms . ' AS t INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy =  "' . $taxonomy . '" AND tt.count > 0 ORDER BY  t.term_id DESC LIMIT 0 , 30';
        $terms = $wpdb->get_results( $qt, ARRAY_A );
        if ( $terms && !is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $term_coll[$term['term_id']] = $term['name'];
            }
        }
    }
    
    return $term_coll;
}

function lae_entry_terms_list(
    $taxonomy = 'category',
    $separator = ', ',
    $before = ' ',
    $after = ' '
)
{
    global  $post ;
    $output = '<span class="lae-' . $taxonomy . '-list">';
    $output .= get_the_term_list(
        $post->ID,
        $taxonomy,
        $before,
        $separator,
        $after
    );
    $output .= '</span>';
    return $output;
}

function lae_get_chosen_terms( $query_args )
{
    $chosen_terms = array();
    $taxonomies = array();
    
    if ( !empty($query_args) && !empty($query_args['tax_query']) ) {
        $term_queries = $query_args['tax_query'];
        foreach ( $term_queries as $terms_query ) {
            if ( !is_array( $terms_query ) ) {
                continue;
            }
            $field = $terms_query['field'];
            $taxonomy = $terms_query['taxonomy'];
            $terms = $terms_query['terms'];
            if ( empty($taxonomy) || empty($terms) ) {
                continue;
            }
            if ( !in_array( $taxonomy, $taxonomies ) ) {
                $taxonomies[] = $taxonomy;
            }
            
            if ( is_array( $terms ) ) {
                foreach ( $terms as $term ) {
                    $chosen_terms[] = get_term_by( $field, $term, $taxonomy );
                }
            } else {
                $chosen_terms[] = get_term_by( $field, $terms, $taxonomy );
            }
        
        }
    }
    
    // Remove duplicates
    $taxonomies = array_unique( $taxonomies );
    $return = array( $chosen_terms, $taxonomies );
    return apply_filters( 'lae_chosen_taxonomy_terms', $return, $query_args );
}

function lae_get_taxonomy_info( $taxonomy )
{
    $output = '';
    $terms = get_the_terms( get_the_ID(), $taxonomy );
    
    if ( !empty($terms) && !is_wp_error( $terms ) ) {
        $output .= '<span class="lae-terms">';
        $term_count = 0;
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term->slug, $taxonomy );
            
            if ( !empty($term_link) && !is_wp_error( $term_link ) ) {
                if ( $term_count != 0 ) {
                    $output .= ', ';
                }
                $output .= '<a href="' . get_term_link( $term->slug, $taxonomy ) . '">' . $term->name . '</a>';
                $term_count = $term_count + 1;
            }
        
        }
        $output .= '</span>';
    }
    
    return apply_filters( 'lae_taxonomy_info', $output, $taxonomy );
}

function lae_get_info_for_taxonomies( $taxonomies )
{
    $output = '';
    foreach ( $taxonomies as $taxonomy ) {
        $output .= lae_get_taxonomy_info( $taxonomy );
    }
    return apply_filters( 'lae_taxonomies_info', $output, $taxonomies );
}

// get all registered taxonomies
function lae_get_taxonomies_map()
{
    $map = array();
    $taxonomies = lae_get_all_taxonomies();
    foreach ( $taxonomies as $taxonomy ) {
        $map[$taxonomy] = $taxonomy;
    }
    return apply_filters( 'lae_taxonomies_map', $map );
}

function lae_get_all_taxonomies()
{
    $taxonomies = get_taxonomies( array(
        'public'   => true,
        '_builtin' => false,
    ) );
    $taxonomies = array_merge( array(
        'category' => 'category',
        'post_tag' => 'post_tag',
    ), $taxonomies );
    return $taxonomies;
}

function lae_entry_published( $format = null )
{
    if ( empty($format) ) {
        $format = get_option( 'date_format' );
    }
    $published = '<span class="published"><abbr title="' . sprintf( get_the_time( esc_html__( 'l, F, Y, g:i a', 'livemesh-el-addons' ) ) ) . '">' . sprintf( get_the_time( $format ) ) . '</abbr></span>';
    return apply_filters( 'lae_entry_published', $published, $format );
    $link = '<span class="published">' . '<a href="' . get_day_link( get_the_time( esc_html__( 'Y', 'livemesh-el-addons' ) ), get_the_time( esc_html__( 'm', 'livemesh-el-addons' ) ), get_the_time( esc_html__( 'd', 'livemesh-el-addons' ) ) ) . '" title="' . sprintf( get_the_time( esc_html__( 'l, F, Y, g:i a', 'livemesh-el-addons' ) ) ) . '">' . '<span class="updated">' . get_the_time( $format ) . '</span>' . '</a></span>';
    return apply_filters( 'lae_entry_published_link', $link, $format );
}

function lae_entry_author()
{
    $author = '<span class="author vcard">' . esc_html__( 'By ', 'livemesh-el-addons' ) . '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></span>';
    return apply_filters( 'lae_entry_author', $author );
}

/* Return the css class name to help achieve the number of columns specified for mobile resolution */
function lae_get_grid_classes( $settings, $columns_field = 'per_line' )
{
    
    if ( isset( $settings['column_layout'] ) && $settings['column_layout'] == 'auto' ) {
        $grid_classes = ' lae-grid-auto-column-layout';
    } else {
        $grid_classes = ' lae-grid-desktop-';
        $grid_classes .= $settings[$columns_field];
        $grid_classes .= ' lae-grid-tablet-';
        $grid_classes .= $settings[$columns_field . '_tablet'];
        $grid_classes .= ' lae-grid-mobile-';
        $grid_classes .= $settings[$columns_field . '_mobile'];
    }
    
    return apply_filters(
        'lae_grid_classes',
        $grid_classes,
        $settings,
        $columns_field
    );
}

/*
* Converting string to boolean is a big one in PHP
*/
function lae_to_boolean( $value )
{
    if ( !isset( $value ) ) {
        return false;
    }
    
    if ( $value == 'true' || $value == '1' ) {
        $value = true;
    } elseif ( $value == 'false' || $value == '0' ) {
        $value = false;
    }
    
    return (bool) $value;
    // Make sure you do not touch the value if the value is not a string
}

/**
 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
 * @param str $hex Colour as hexadecimal (with or without hash);
 * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
 * @return str Lightened/Darkend colour as hexadecimal (with hash);
 */
function lae_color_luminance( $hex, $percent )
{
    // validate hex string
    $hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
    $new_hex = '#';
    if ( strlen( $hex ) < 6 ) {
        $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
    }
    // convert to decimal and change luminosity
    for ( $i = 0 ;  $i < 3 ;  $i++ ) {
        $dec = hexdec( substr( $hex, $i * 2, 2 ) );
        $dec = min( max( 0, $dec + $dec * $percent ), 255 );
        $new_hex .= str_pad(
            dechex( $dec ),
            2,
            0,
            STR_PAD_LEFT
        );
    }
    return $new_hex;
}

function lae_get_option( $option_name, $default = null )
{
    $settings = get_option( 'lae_settings' );
    
    if ( !empty($settings) && isset( $settings[$option_name] ) ) {
        $option_value = $settings[$option_name];
    } else {
        $option_value = $default;
    }
    
    return apply_filters(
        'lae_get_option',
        $option_value,
        $option_name,
        $default
    );
}

function lae_update_option( $option_name, $option_value )
{
    $settings = get_option( 'lae_settings' );
    if ( empty($settings) ) {
        $settings = array();
    }
    $settings[$option_name] = $option_value;
    update_option( 'lae_settings', $settings );
}

/**
 * Update multiple options in one go
 * @param array $setting_data An collection of settings key value pairs;
 */
function lae_update_options( $setting_data )
{
    $settings = get_option( 'lae_settings' );
    if ( empty($settings) ) {
        $settings = array();
    }
    foreach ( $setting_data as $setting => $value ) {
        // because of get_magic_quotes_gpc()
        $value = stripslashes( $value );
        $settings[$setting] = $value;
    }
    update_option( 'lae_settings', $settings );
}

/**
 * Get system info
 *
 */
function lae_get_sysinfo()
{
    global  $wpdb ;
    // Get theme info
    $theme_data = wp_get_theme();
    $theme = $theme_data->Name . ' ' . $theme_data->Version;
    $return = '### <strong>Begin System Info</strong> ###' . "\n\n";
    // Start with the basics...
    $return .= '-- Site Info' . "\n\n";
    $return .= 'Site URL:                 ' . site_url() . "\n";
    $return .= 'Home URL:                 ' . home_url() . "\n";
    $return .= 'Multisite:                ' . (( is_multisite() ? 'Yes' : 'No' )) . "\n";
    // Theme info
    $plugin = get_plugin_data( LAE_PLUGIN_FILE );
    // Plugin configuration
    $return .= "\n" . '-- Plugin Configuration' . "\n\n";
    $return .= 'Name:                     ' . $plugin['Name'] . "\n";
    $return .= 'Version:                  ' . $plugin['Version'] . "\n";
    // WordPress configuration
    $return .= "\n" . '-- WordPress Configuration' . "\n\n";
    $return .= 'Version:                  ' . get_bloginfo( 'version' ) . "\n";
    $return .= 'Language:                 ' . (( defined( 'WPLANG' ) && WPLANG ? WPLANG : 'en_US' )) . "\n";
    $return .= 'Permalink Structure:      ' . (( get_option( 'permalink_structure' ) ? get_option( 'permalink_structure' ) : 'Default' )) . "\n";
    $return .= 'Active Theme:             ' . $theme . "\n";
    $return .= 'Show On Front:            ' . get_option( 'show_on_front' ) . "\n";
    // Only show page specs if frontpage is set to 'page'
    
    if ( get_option( 'show_on_front' ) == 'page' ) {
        $front_page_id = get_option( 'page_on_front' );
        $blog_page_id = get_option( 'page_for_posts' );
        $return .= 'Page On Front:            ' . (( $front_page_id != 0 ? get_the_title( $front_page_id ) . ' (#' . $front_page_id . ')' : 'Unset' )) . "\n";
        $return .= 'Page For Posts:           ' . (( $blog_page_id != 0 ? get_the_title( $blog_page_id ) . ' (#' . $blog_page_id . ')' : 'Unset' )) . "\n";
    }
    
    $return .= 'ABSPATH:                  ' . ABSPATH . "\n";
    $return .= 'WP_DEBUG:                 ' . (( defined( 'WP_DEBUG' ) ? ( WP_DEBUG ? 'Enabled' : 'Disabled' ) : 'Not set' )) . "\n";
    $return .= 'Memory Limit:             ' . WP_MEMORY_LIMIT . "\n";
    $return .= 'Registered Post Stati:    ' . implode( ', ', get_post_stati() ) . "\n";
    // Get plugins that have an update
    $updates = get_plugin_updates();
    // WordPress active plugins
    $return .= "\n" . '-- WordPress Active Plugins' . "\n\n";
    $plugins = get_plugins();
    $active_plugins = get_option( 'active_plugins', array() );
    foreach ( $plugins as $plugin_path => $plugin ) {
        if ( !in_array( $plugin_path, $active_plugins ) ) {
            continue;
        }
        $update = ( array_key_exists( $plugin_path, $updates ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '' );
        $return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
    }
    // WordPress inactive plugins
    $return .= "\n" . '-- WordPress Inactive Plugins' . "\n\n";
    foreach ( $plugins as $plugin_path => $plugin ) {
        if ( in_array( $plugin_path, $active_plugins ) ) {
            continue;
        }
        $update = ( array_key_exists( $plugin_path, $updates ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '' );
        $return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
    }
    
    if ( is_multisite() ) {
        // WordPress Multisite active plugins
        $return .= "\n" . '-- Network Active Plugins' . "\n\n";
        $plugins = wp_get_active_network_plugins();
        $active_plugins = get_site_option( 'active_sitewide_plugins', array() );
        foreach ( $plugins as $plugin_path ) {
            $plugin_base = plugin_basename( $plugin_path );
            if ( !array_key_exists( $plugin_base, $active_plugins ) ) {
                continue;
            }
            $update = ( array_key_exists( $plugin_path, $updates ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '' );
            $plugin = get_plugin_data( $plugin_path );
            $return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
        }
    }
    
    // Server configuration (really just versioning)
    $return .= "\n" . '-- Webserver Configuration' . "\n\n";
    $return .= 'PHP Version:              ' . PHP_VERSION . "\n";
    $return .= 'MySQL Version:            ' . $wpdb->db_version() . "\n";
    $return .= 'Webserver Info:           ' . $_SERVER['SERVER_SOFTWARE'] . "\n";
    // PHP configs... now we're getting to the important stuff
    $return .= "\n" . '-- PHP Configuration' . "\n\n";
    $return .= 'Memory Limit:             ' . ini_get( 'memory_limit' ) . "\n";
    $return .= 'Upload Max Size:          ' . ini_get( 'upload_max_filesize' ) . "\n";
    $return .= 'Post Max Size:            ' . ini_get( 'post_max_size' ) . "\n";
    $return .= 'Upload Max Filesize:      ' . ini_get( 'upload_max_filesize' ) . "\n";
    $return .= 'Time Limit:               ' . ini_get( 'max_execution_time' ) . "\n";
    $return .= 'Max Input Vars:           ' . ini_get( 'max_input_vars' ) . "\n";
    $return .= 'Display Errors:           ' . (( ini_get( 'display_errors' ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A' )) . "\n";
    $return = apply_filters( 'edd_sysinfo_after_php_config', $return );
    // PHP extensions and such
    $return .= "\n" . '-- PHP Extensions' . "\n\n";
    $return .= 'cURL:                     ' . (( function_exists( 'curl_init' ) ? 'Supported' : 'Not Supported' )) . "\n";
    $return .= 'fsockopen:                ' . (( function_exists( 'fsockopen' ) ? 'Supported' : 'Not Supported' )) . "\n";
    $return .= 'SOAP Client:              ' . (( class_exists( 'SoapClient' ) ? 'Installed' : 'Not Installed' )) . "\n";
    $return .= 'Suhosin:                  ' . (( extension_loaded( 'suhosin' ) ? 'Installed' : 'Not Installed' )) . "\n";
    $return .= "\n" . '### End System Info ###';
    return $return;
}

function lae_get_image_html(
    $image_setting,
    $image_size_key,
    $settings,
    $disable_lazy_load = false
)
{
    $image_html = '';
    $attachment_id = $image_setting['id'];
    // Old version of image settings.
    if ( !isset( $settings[$image_size_key . '_size'] ) ) {
        $settings[$image_size_key . '_size'] = '';
    }
    $size = $settings[$image_size_key . '_size'];
    $image_class = 'lae-image';
    if ( $disable_lazy_load ) {
        $image_class .= ' ' . lae_disable_lazy_load_classes();
    }
    if ( isset( $image_setting['class'] ) ) {
        $image_class .= ' ' . $image_setting['class'];
    }
    // If is the new version - with image size.
    $image_sizes = get_intermediate_image_sizes();
    $image_sizes[] = 'full';
    
    if ( !empty($attachment_id) && in_array( $size, $image_sizes ) ) {
        $image_class .= " attachment-{$size} size-{$size}";
        $image_attrs = array(
            'class' => trim( $image_class ),
            'alt'   => get_the_title( $attachment_id ),
            'title' => lae_get_image_alt( $attachment_id ),
        );
        if ( $disable_lazy_load ) {
            $image_attrs = array_merge( $image_attrs, array(
                'data-no-lazy' => 1,
                'loading'      => 'eager',
            ) );
        }
        $image_html .= wp_get_attachment_image(
            $attachment_id,
            $size,
            false,
            $image_attrs
        );
    } else {
        $image_src = Group_Control_Image_Size::get_attachment_image_src( $attachment_id, $image_size_key, $settings );
        if ( !$image_src && isset( $image_setting['url'] ) ) {
            $image_src = $image_setting['url'];
        }
        $size = $settings[$image_size_key . '_size'];
        $custom_dimension = $settings[$image_size_key . '_custom_dimension'];
        
        if ( !empty($image_src) ) {
            $lazy_load_attr = '';
            if ( $disable_lazy_load ) {
                $lazy_load_attr = 'loading=eager data-no-lazy=1';
            }
            $image_class_html = ( !empty($image_class) ? ' class="' . $image_class . '"' : '' );
            
            if ( is_null( $custom_dimension ) ) {
                $image_html .= sprintf(
                    '<img %s src="%s" title="%s" alt="%s"%s />',
                    esc_attr( $lazy_load_attr ),
                    esc_attr( $image_src ),
                    get_the_title( $attachment_id ),
                    lae_get_image_alt( $attachment_id ),
                    $image_class_html
                );
            } else {
                $image_html .= sprintf(
                    '<img width="%s" height="%s" %s src="%s" title="%s" alt="%s"%s />',
                    esc_attr( $custom_dimension['width'] ),
                    esc_attr( $custom_dimension['height'] ),
                    esc_attr( $lazy_load_attr ),
                    esc_attr( $image_src ),
                    get_the_title( $attachment_id ),
                    lae_get_image_alt( $attachment_id ),
                    $image_class_html
                );
            }
        
        }
    
    }
    
    return apply_filters(
        'lae_attachment_image_html',
        $image_html,
        $image_setting,
        $image_size_key,
        $settings
    );
}

function lae_get_image_alt( $attachment_id )
{
    if ( empty($attachment_id) ) {
        return '';
    }
    if ( !$attachment_id ) {
        return '';
    }
    $attachment = get_post( $attachment_id );
    if ( !$attachment ) {
        return '';
    }
    $alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
    
    if ( !$alt ) {
        $alt = $attachment->post_excerpt;
        if ( !$alt ) {
            $alt = $attachment->post_title;
        }
    }
    
    $alt = trim( strip_tags( $alt ) );
    return apply_filters( 'lae_image_alt', $alt, $attachment_id );
}

/** Isotope filtering support for Portfolio pages **/
function lae_get_taxonomy_terms_filter( $taxonomies, $chosen_terms = array() )
{
    $output = '';
    $terms = array();
    
    if ( empty($chosen_terms) ) {
        foreach ( $taxonomies as $taxonomy ) {
            global  $wp_version ;
            
            if ( version_compare( $wp_version, '4.5', '>=' ) ) {
                $taxonomy_terms = get_terms( array(
                    'taxonomy' => $taxonomy,
                ) );
            } else {
                $taxonomy_terms = get_terms( $taxonomy );
            }
            
            if ( !empty($taxonomy_terms) && !is_wp_error( $taxonomy_terms ) ) {
                $terms = array_merge( $terms, $taxonomy_terms );
            }
        }
    } else {
        $terms = $chosen_terms;
    }
    
    
    if ( !empty($terms) ) {
        $output .= '<div class="lae-taxonomy-filter">';
        $output .= '<div class="lae-filter-item segment-0 lae-active"><a data-value="*" href="#">' . esc_html__( 'All', 'livemesh-el-addons' ) . '</a></div>';
        $segment_count = 1;
        foreach ( $terms as $term ) {
            $output .= '<div class="lae-filter-item segment-' . intval( $segment_count ) . '"><a href="#" data-value=".term-' . intval( $term->term_id ) . '" title="' . esc_html__( 'View all items filed under ', 'livemesh-el-addons' ) . esc_attr( $term->name ) . '">' . esc_html( $term->name ) . '</a></div>';
            $segment_count++;
        }
        $output .= '</div>';
    }
    
    return apply_filters(
        'lae_taxonomy_terms_filter',
        $output,
        $taxonomies,
        $chosen_terms
    );
}

function lae_get_animation_atts( $animation )
{
    $animate_class = "";
    $animation_attr = "";
    
    if ( $animation != "none" ) {
        $animate_class = ' lae-animate-on-scroll';
        if ( in_array( $animation, array(
            'bounceIn',
            'bounceInUp',
            'bounceInDown',
            'bounceInLeft',
            'bounceInRight',
            'fadeIn',
            'fadeInLeft',
            'fadeInRight',
            'fadeInUp',
            'fadeInDown',
            'fadeInLeftBig',
            'fadeInRightBig',
            'fadeInUpBig',
            'fadeInDownBig',
            'flipInX',
            'flipInY',
            'lightSpeedIn',
            'rotateIn',
            'rotateInDownLeft',
            'rotateInDownRight',
            'rotateInUpLeft',
            'rotateInUpRight',
            'slideInUp',
            'slideInDown',
            'slideInLeft',
            'slideInRight',
            'zoomIn',
            'zoomInUp',
            'zoomInDown',
            'zoomInLeft',
            'zoomInRight',
            'rollIn'
        ) ) ) {
            $animate_class .= ' lae-visible-on-scroll';
        }
        $animation_attr = ' data-animation="' . esc_attr( $animation ) . '"';
    }
    
    $return = array( $animate_class, $animation_attr );
    return apply_filters( 'lae_animation_attributes', $return, $animation );
}

function lae_get_animation_options()
{
    return apply_filters( 'lae_animation_options', array(
        'none'        => __( 'None', 'livemesh-el-addons' ),
        'fadeIn'      => __( 'Fade In', 'livemesh-el-addons' ),
        'fadeInLeft'  => __( 'Fade In Left', 'livemesh-el-addons' ),
        'fadeInRight' => __( 'Fade In Right', 'livemesh-el-addons' ),
    ) );
}

function lae_get_template_part( $template_name, $args = null, $return = false )
{
    $template_file = $template_name . '.php';
    $default_folder = LAE_PLUGIN_DIR . 'templates/';
    // Allow the user to place the templates in a different folder than the default addons-for-elementor/ folder
    $theme_folder = apply_filters( 'lae_templates_folder', LAE_PLUGIN_SLUG );
    /* Look for the file in the theme */
    $template = locate_template( $theme_folder . '/' . $template_file );
    if ( !$template ) {
        $template = $default_folder . $template_file;
    }
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }
    if ( $return ) {
        ob_start();
    }
    if ( file_exists( $template ) ) {
        include $template;
    }
    if ( $return ) {
        return ob_get_clean();
    }
    return null;
}

function lae_shorten_number_format( $n, $precision = 1 )
{
    
    if ( $n < 1000 ) {
        // Anything less than a thousand
        $n_format = number_format( $n );
    } else {
        
        if ( $n < 1000000 ) {
            // Anything less than a billion
            $n_format = number_format( $n / 1000, $precision ) . 'k';
        } else {
            
            if ( $n < 1000000000 ) {
                // Anything less than a billion
                $n_format = number_format( $n / 1000000, $precision ) . 'M';
            } else {
                // At least a billion
                $n_format = number_format( $n / 1000000000, $precision ) . 'B';
            }
        
        }
    
    }
    
    return $n_format;
}

function lae_disable_lazy_load_classes()
{
    // no-lazyload - wp-smushit
    // data-no-lazy="1" - wprocket, rocket-lazy-load
    // skip-lazy - jetpack, SG Optimizer using filter in functions.php
    // exclude-me - autoptimize
    // a3-notlazy - a3-lazy-load
    return apply_filters( 'lae_disable_lazy_load_classes', 'skip-lazy no-lazyload exclude-me a3-notlazy' );
}

function lae_template_error( $error_string )
{
    $output = '<div class="lae-template-error">';
    $output .= $error_string;
    $output .= '</div>';
    return $output;
}

function lae_validate_html_tag( $tag )
{
    $allowed_html_tags = [
        'article',
        'aside',
        'div',
        'footer',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'header',
        'main',
        'nav',
        'p',
        'section',
        'span'
    ];
    return ( in_array( strtolower( $tag ), $allowed_html_tags ) ? $tag : 'div' );
}
