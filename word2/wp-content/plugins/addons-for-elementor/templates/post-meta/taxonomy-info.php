<?php

$output = '';

foreach ($taxonomies as $taxonomy) {

    $terms = get_the_terms(get_the_ID(), $taxonomy);

    if (!empty($terms) && !is_wp_error($terms)) {

        $output .= '<span class="lae-terms">';

        $term_count = 0;

        foreach ($terms as $term) {

            $term_link = get_term_link($term->slug, $taxonomy);

            if (!empty($term_link) && !is_wp_error($term_link)) {

                if ($term_count != 0)
                    $output .= ', ';

                $output .= '<a href="' . get_term_link($term->slug, $taxonomy) . '">' . $term->name . '</a>';

                $term_count = $term_count + 1;

            }
        }

        $output .= '</span>';
    }

}

echo $output;