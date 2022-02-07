<?php
/**
 * Loop - Posts Carousel Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-carousel/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Use the processed post selector query to find posts.
$query_args = lae_build_query_args($settings);

$query_args = apply_filters('lae_posts_carousel_' . $widget_instance->get_id() . '_query_args', $query_args, $settings);

$loop = new \WP_Query($query_args);

// Loop through the posts and do something with them.
if ($loop->have_posts()) :

    lae_get_template_part('addons/posts-carousel/loop-start', $args);

    while ($loop->have_posts()) : $loop->the_post();

        $args['post_id'] = get_the_ID();

        lae_get_template_part("addons/posts-carousel/content", $args);

    endwhile;

    wp_reset_postdata();

    lae_get_template_part('addons/posts-carousel/loop-end', $args);

endif;