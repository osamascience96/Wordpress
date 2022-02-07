<?php

/**
 * Loop - Posts Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-slider/loop.php
 *
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

$args['thumbnail_items'] = '';
$slider_style = $settings['slider_style'];
// Use the processed post selector query to find posts.
$query_args = lae_build_query_args( $settings );
$loop = new \WP_Query( $query_args );
// Loop through the posts and do something with them.

if ( $loop->have_posts() ) {
    $args['target'] = ( $settings['post_link_new_window'] == 'yes' ? ' target="_blank"' : '' );
    lae_get_template_part( 'addons/posts-slider/loop-start', $args );
    while ( $loop->have_posts() ) {
        $loop->the_post();
        $args['post_id'] = get_the_ID();
        $free_styles = array( 'style-1', 'style-2' );
        
        if ( in_array( $slider_style, $free_styles ) ) {
            lae_get_template_part( "addons/posts-slider/{$slider_style}", $args );
        } else {
            lae_get_template_part( "premium/addons/posts-slider/{$slider_style}", $args );
        }
    
    }
    wp_reset_postdata();
    lae_get_template_part( 'addons/posts-slider/loop-end', $args );
}
