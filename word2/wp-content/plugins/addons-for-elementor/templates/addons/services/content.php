<?php
/**
 * Content - Services Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/services/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Icons_Manager;
use Elementor\Utils;

$has_link = false;

$migration_allowed = Icons_Manager::is_migration_allowed();

if (!empty($service['service_link']['url'])) {

    $has_link = true;

    $link_key = 'link_' . $index;

    $url = $service['service_link'];

    $widget_instance->add_render_attribute($link_key, 'title', $service['service_title']);

    $widget_instance->add_render_attribute($link_key, 'href', $url['url']);

    if (!empty($url['is_external'])) {
        $widget_instance->add_render_attribute($link_key, 'target', '_blank');
    }

    if (!empty($url['nofollow'])) {
        $widget_instance->add_render_attribute($link_key, 'rel', 'nofollow');
    }
}

$class_attr = $data_attr = '';

if ($settings['layout'] == 'grid')
    list($class_attr, $data_attr) = lae_get_animation_atts($service['widget_animation']);

?>

<div class="lae-service <?php echo $class_attr; ?>" <?php echo $data_attr; ?>>

    <?php if ($service['icon_type'] == 'icon_image') : ?>

        <?php if (!empty($service['icon_image'])): ?>

            <div class="lae-image-wrapper">

                <?php

                $image_html = lae_get_image_html($service['icon_image'], 'thumbnail_size', $settings);

                if ($has_link)
                    $image_html = '<a class="lae-title-link" ' . $widget_instance->get_render_attribute_string($link_key) . '>' . $image_html . '</a>';

                echo $image_html;

                ?>

            </div>

        <?php endif; ?>

    <?php elseif ($service['icon_type'] == 'icon' && (!empty($service['icon']) || !empty($service['selected_icon']['value']))) : ?>

        <?php

        $migrated = isset($service['__fa4_migrated']['selected_icon']);
        $is_new = empty($service['icon']) && $migration_allowed;

        ?>

        <div class="lae-icon-wrapper">

            <?php

            if ($is_new || $migrated) :

                ob_start();

                Icons_Manager::render_icon($service['selected_icon'], ['aria-hidden' => 'true']);

                $icon_html = ob_get_contents();

                ob_end_clean();

            else :

                $icon_html = '<i class="' . esc_attr($service['icon']) . '" aria-hidden="true"></i>';

            endif;

            if ($has_link)
                $icon_html = '<a class="lae-icon-link" ' . $widget_instance->get_render_attribute_string($link_key) . '>' . $icon_html . '</a>';

            echo $icon_html;

            ?>

        </div>

    <?php endif; ?>

    <div class="lae-service-text">

        <?php

        $title_html = '<' . lae_validate_html_tag($settings['title_tag']) . ' class="lae-title">' . esc_html($service['service_title']) . '</' . lae_validate_html_tag($settings['title_tag']) . '>';

        if ($has_link)
            $title_html = '<a class="lae-title-link" ' . $widget_instance->get_render_attribute_string($link_key) . '>' . $title_html . '</a>';

        echo $title_html;

        ?>

        <div class="lae-service-details"><?php echo do_shortcode(wp_kses_post($service['service_excerpt'])); ?></div>

    </div><!-- .lae-service-text -->

</div><!-- .lae-service -->