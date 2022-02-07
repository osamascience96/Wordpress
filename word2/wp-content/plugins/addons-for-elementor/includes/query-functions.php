<?php

function lae_get_all_post_type_options() {

    $post_types = get_post_types(array('public' => true), 'objects');

    $options = ['' => ''];

    foreach ($post_types as $post_type) {
        $options[$post_type->name] = $post_type->label;
    }

    return apply_filters('lae_post_type_options', $options);
}

/**
 * Action to handle searching taxonomy terms.
 */
function lae_get_all_taxonomy_options() {

    $taxonomies = lae_get_all_taxonomies();

    $results = array();
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(array('taxonomy' => $taxonomy));
        foreach ($terms as $term)
            $results[$term->taxonomy . ':' . $term->slug] = $term->taxonomy . ':' . $term->name;
    }

    return apply_filters('lae_taxonomy_options', $results);
}

function lae_build_query_args($settings) {

    if ($settings['query_type'] == 'current_query') {

        global $wp_query;

        $query_args = $wp_query->query_vars;

        $query_args = apply_filters('lae_current_query_args', $query_args, $settings);
    }
    elseif ($settings['query_type'] == 'related') {

        $query_args = lae_default_query_args($settings);

        $post_id = get_queried_object_id();
        $related_post_id = is_singular() && ($post_id !== 0) ? $post_id : null;
        $query_args['post_type'] = get_post_type($related_post_id);

        $exclude_posts = $settings['exclude_posts'];
        if (!empty($exclude_posts)) {
            $query_args['post__not_in'] = explode(',', $exclude_posts);
            $query_args['post__not_in'] = array_map('intval', $query_args['post__not_in']);
        }

        if ($related_post_id) {
            $post_not_in = isset($query_args['post__not_in']) ? $query_args['post__not_in'] : [];
            $post_not_in[] = $related_post_id;
            $query_args['post__not_in'] = $post_not_in;
        }

        $taxonomies = $settings['taxonomies'];
        $terms = array();
        if (is_array($taxonomies)) {
            foreach ($taxonomies as $taxonomy) {
                $terms[$taxonomy] = wp_get_post_terms($related_post_id, $taxonomy, ['fields' => 'tt_ids']);
            }
        }
        else {
            $taxonomy = $taxonomies; // it is a string representing single taxonomy
            $terms[$taxonomy] = wp_get_post_terms($related_post_id, $taxonomy, ['fields' => 'tt_ids']);
        }

        foreach ($terms as $taxonomy => $ids) {

            if (empty($ids))
                continue;

            $query = array(
                'taxonomy' => $taxonomy,
                'field' => 'term_taxonomy_id',
                'terms' => $ids,
            );

            if (empty($query_args['tax_query']))
                $query_args['tax_query'] = array();
            else
                $query_args['tax_query']['relation'] = 'OR';

            $query_args['tax_query'][] = $query;
        }

        $query_args = apply_filters('lae_related_query_args', $query_args, $settings);
    }
    else {

        $query_args = lae_default_query_args($settings);

        if (!empty($settings['post_in'])) {
            $query_args['post_type'] = 'any';
            $query_args['post__in'] = explode(',', $settings['post_in']);
            $query_args['post__in'] = array_map('intval', $query_args['post__in']);
        }
        else {
            if (!empty($settings['post_types'])) {
                $query_args['post_type'] = $settings['post_types'];
            }

            $exclude_posts = $settings['exclude_posts'];
            if (!empty($exclude_posts)) {
                $query_args['post__not_in'] = explode(',', $exclude_posts);
                $query_args['post__not_in'] = array_map('intval', $query_args['post__not_in']);
            }

            if (!empty($settings['tax_query'])) {
                $tax_queries = $settings['tax_query'];

                $query_args['tax_query'] = array();
                $query_args['tax_query']['relation'] = 'OR';
                foreach ($tax_queries as $tq) {
                    list($tax, $term) = explode(':', $tq);

                    if (empty($tax) || empty($term))
                        continue;
                    $query_args['tax_query'][] = array(
                        'taxonomy' => $tax,
                        'field' => 'slug',
                        'terms' => $term
                    );
                }
            }
        }

        $query_args = apply_filters('lae_custom_query_args', $query_args, $settings);
    }

    $query_args['paged'] = max(1, get_query_var('paged'), get_query_var('page'));

    return apply_filters('lae_posts_query_args', $query_args, $settings);
}

function lae_default_query_args($settings) {

    $query_args = [
        'orderby' => $settings['orderby'],
        'order' => $settings['order'],
        'ignore_sticky_posts' => 1,
        'post_status' => 'publish',
    ];

    $query_args['posts_per_page'] = $settings['posts_per_page'];

    $query_args['offset'] = isset($settings['offset']) ? intval($settings['offset']) : 0;

    return apply_filters('lae_default_query_args', $query_args, $settings);
}