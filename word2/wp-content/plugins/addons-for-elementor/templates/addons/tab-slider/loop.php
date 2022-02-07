<?php
/**
 * Loop - Tab Slider Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/tab-slider/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$dir = is_rtl() ? ' dir="rtl"' : '';

$rtl_style = is_rtl() ? ' style="direction:rtl"' : '';

$plain_styles = array('style1');

$slider_settings = [
    'autoplay' => ('yes' === $settings['autoplay']),
    'autoplay_speed' => absint($settings['autoplay_speed']),
    'animation_speed' => absint($settings['animation_speed']),
    'pause_on_hover' => ('yes' === $settings['pause_on_hover']),
    'pause_on_focus' => ('yes' === $settings['pause_on_focus']),
    'infinite_looping' => ('yes' === $settings['infinite_looping']),
    'adaptive_height' => ('yes' === $settings['adaptive_height']),
];

?>

<div<?php echo $dir . $rtl_style; ?> class="lae-tab-slider lae-<?php echo esc_attr($settings['style']); ?>"
                                     data-settings='<?php echo wp_json_encode($slider_settings); ?>'>

    <?php foreach ($settings['tabs'] as $tab) : ?>

        <?php $args['tab'] = $tab; ?>

        <?php lae_get_template_part("addons/tab-slider/{$settings['style']}", $args); ?>

    <?php endforeach; ?>

</div><!-- .lae-tab-slider -->
