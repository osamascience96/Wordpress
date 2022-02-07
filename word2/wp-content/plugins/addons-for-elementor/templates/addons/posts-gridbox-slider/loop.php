<?php
/**
 * Loop - Posts Grid Box Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-gridbox-slider/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$slider_style = $settings['slider_style'];

// Use the processed post selector query to find posts.
$query_args = lae_build_query_args($settings);

$loop = new \WP_Query($query_args);

$args['total_posts'] = $loop->post_count;

$args['counter'] = 0;

$args['slider_height'] = $settings['slider_height'];

$args['image_height'] = $settings['image_height'];

// Loop through the posts and do something with them.
if ($loop->have_posts()) :

    $args['target'] = $settings['post_link_new_window'] == 'yes' ? ' target="_blank"' : '';

    lae_get_template_part('addons/posts-gridbox-slider/loop-start', $args);

    while ($loop->have_posts()) : $loop->the_post();

        $args['counter'] = $args['counter'] + 1;

        $args['post_id'] = get_the_ID();

        $free_styles = array('style-1', 'style-2', 'style-3');

        if (in_array($slider_style, $free_styles))

            lae_get_template_part("addons/posts-gridbox-slider/{$slider_style}", $args);
        else
            lae_get_template_part("premium/addons/posts-gridbox-slider/{$slider_style}", $args);

    endwhile;

    wp_reset_postdata();

    lae_get_template_part('addons/posts-gridbox-slider/loop-end', $args);

endif;