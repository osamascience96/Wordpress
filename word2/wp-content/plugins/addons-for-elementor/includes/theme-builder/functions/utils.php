<?php

use Elementor\Plugin;

function lae_get_livemesh_item_templates() {
    global $wpdb;
    $templates = $wpdb->get_results(
        "SELECT $wpdb->term_relationships.object_id as ID, $wpdb->posts.post_title as post_title FROM $wpdb->term_relationships
						INNER JOIN $wpdb->term_taxonomy ON
							$wpdb->term_relationships.term_taxonomy_id=$wpdb->term_taxonomy.term_taxonomy_id
						INNER JOIN $wpdb->terms ON 
							$wpdb->term_taxonomy.term_id=$wpdb->terms.term_id AND ($wpdb->terms.slug='livemesh_item' OR $wpdb->terms.slug = 'loop')
						INNER JOIN $wpdb->posts ON
							$wpdb->term_relationships.object_id=$wpdb->posts.ID
          WHERE  $wpdb->posts.post_status='publish'"
    );

    return $templates;
}

function lae_get_livemesh_grid_templates() {
    global $wpdb;
    $templates = $wpdb->get_results(
        "SELECT $wpdb->term_relationships.object_id as ID, $wpdb->posts.post_title as post_title FROM $wpdb->term_relationships
						INNER JOIN $wpdb->term_taxonomy ON
							$wpdb->term_relationships.term_taxonomy_id=$wpdb->term_taxonomy.term_taxonomy_id
						INNER JOIN $wpdb->terms ON 
							$wpdb->term_taxonomy.term_id=$wpdb->terms.term_id AND $wpdb->terms.slug='livemesh_grid'
						INNER JOIN $wpdb->posts ON
							$wpdb->term_relationships.object_id=$wpdb->posts.ID
          WHERE  $wpdb->posts.post_status='publish'"
    );

    return $templates;
}

function lae_get_item_template_content($template_id, $settings) {

    Plugin::instance()->db->switch_to_query(array('p' => get_the_ID(), 'post_type' => get_post_type()));

    /* Fetch the custom item content from Elementor */
    $output = lae_get_template_content($template_id, $settings);

    Plugin::instance()->db->restore_current_query();

    return $output;
}

function lae_get_template_content($template_id, $settings) {

    $template_id = apply_filters('lae_theme_builder_template', $template_id, $settings);

    /*  WPML hook */
    $template_id = apply_filters('wpml_object_id', $template_id, 'elementor_library', true);

    if (!$template_id)
        return;

    /* Fetch the custom skin content from Elementor */
    $output = Plugin::instance()->frontend->get_builder_content_for_display($template_id, false);

    return $output;
}

function lae_get_document($post_id) {
    $document = null;

    try {
        $document = Plugin::instance()->documents->get($post_id);
    } catch (\Exception $e) {
    }

    if (!empty($document) && !$document instanceof Theme_Document) {
        $document = null;
    }

    return $document;
}
