<?php
/**
 * Loop Start - Posts Grid Box Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/posts-gridbox-slider/loop-start.php
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
];

?>

<div class="lae-posts-gridbox-slider-wrap">
    <div<?php echo is_rtl() ? ' dir="rtl"' : ''; ?>
            id="lae-posts-gridbox-slider-<?php echo $settings['slider_id']; ?>"
            class="lae-posts-gridbox-slider lae-container <?php echo 'lae-posts-gridbox-slider-' . $slider_style; ?>"
            data-settings='<?php echo wp_json_encode($slider_settings); ?>'>