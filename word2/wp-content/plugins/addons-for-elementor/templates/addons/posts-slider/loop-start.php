<?php
/**
 * Loop Start - Posts Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-slider/loop-start.php
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$dir = is_rtl() ? ' dir="rtl"' : '';

$slider_style = $settings['slider_style'];

$slider_settings = [
    'slider_id' => $settings['slider_id'],
    'arrows' => ('yes' === $settings['arrows']),
    'dots' => ('yes' === $settings['dots']),
    'autoplay' => ('yes' === $settings['autoplay']),
    'autoplay_speed' => absint($settings['autoplay_speed']),
    'animation_speed' => absint($settings['animation_speed']),
    'pause_on_hover' => ('yes' === $settings['pause_on_hover']),
    'center_mode' => (array_key_exists('center_mode', $settings) && 'yes' === $settings['center_mode']),
    'center_padding' => (array_key_exists('center_padding', $settings) ? $settings['center_padding'] : 15),
    'adaptive_height' => ('yes' === $settings['adaptive_height']),
    'thumbnail_nav' => (array_key_exists('thumbnail_nav', $settings) && 'yes' === $settings['thumbnail_nav']),
];

?>

<div class="lae-posts-slider-wrap">
    <div<?php echo is_rtl() ? ' dir="rtl"' : ''; ?>
            id="lae-posts-slider-<?php echo $settings['slider_id']; ?>"
            class="lae-posts-slider lae-container <?php echo 'lae-posts-slider-' . $slider_style; ?>"
            data-settings='<?php echo wp_json_encode($slider_settings); ?>'>