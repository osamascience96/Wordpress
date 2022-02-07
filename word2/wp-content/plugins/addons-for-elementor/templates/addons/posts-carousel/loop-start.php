<?php
/**
 * Loop Start - Posts Carousel Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-carousel/loop-start.php
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$carousel_settings = [
    'arrows' => ('yes' === $settings['arrows']),
    'dots' => ('yes' === $settings['dots']),
    'autoplay' => ('yes' === $settings['autoplay']),
    'autoplay_speed' => absint($settings['autoplay_speed']),
    'animation_speed' => absint($settings['animation_speed']),
    'pause_on_hover' => ('yes' === $settings['pause_on_hover']),
    'adaptive_height' => ('yes' === $settings['adaptive_height']),
];

$responsive_settings = [
    'display_columns' => $settings['display_columns'],
    'scroll_columns' => $settings['scroll_columns'],
    'gutter' => $settings['gutter'],
    'tablet_width' => $settings['tablet_width'],
    'tablet_display_columns' => $settings['tablet_display_columns'],
    'tablet_scroll_columns' => $settings['tablet_scroll_columns'],
    'tablet_gutter' => $settings['tablet_gutter'],
    'mobile_width' => $settings['mobile_width'],
    'mobile_display_columns' => $settings['mobile_display_columns'],
    'mobile_scroll_columns' => $settings['mobile_scroll_columns'],
    'mobile_gutter' => $settings['mobile_gutter'],

];

$carousel_settings = array_merge($carousel_settings, $responsive_settings);

?>

<div<?php echo is_rtl() ? ' dir="rtl"' : ''; ?>
        id="lae-posts-carousel-<?php echo uniqid(); ?>"
        class="lae-posts-carousel lae-container <?php echo 'lae-' . str_replace('_', '-', $settings['carousel_skin']); ?>"
        data-settings='<?php echo wp_json_encode($carousel_settings); ?>'>