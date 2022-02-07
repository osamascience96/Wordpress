<?php
/**
 * Loop - Carousel Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/carousel/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$elements = $settings['elements'];

$dir = is_rtl() ? ' dir="rtl"' : '';

$carousel_settings = [
    'arrows' => ('yes' === $settings['arrows']),
    'dots' => ('yes' === $settings['dots']),
    'autoplay' => ('yes' === $settings['autoplay']),
    'autoplay_speed' => absint($settings['autoplay_speed']),
    'animation_speed' => absint($settings['animation_speed']),
    'pause_on_hover' => ('yes' === $settings['pause_on_hover']),
];

$responsive_settings = [
    'display_columns' => $settings['display_columns'],
    'scroll_columns' => $settings['scroll_columns'],
    'gutter' => $settings['gutter'],
    'tablet_width' => $settings['tablet_width'],
    'tablet_display_columns' => $settings['tablet_display_columns'],
    'tablet_scroll_columns' => $settings['tablet_scroll_columns'],
    'mobile_width' => $settings['mobile_width'],
    'mobile_display_columns' => $settings['mobile_display_columns'],
    'mobile_scroll_columns' => $settings['mobile_scroll_columns'],

];

$carousel_settings = array_merge($carousel_settings, $responsive_settings);

?>

<?php if (!empty($elements)) : ?>

    <div<?php echo $dir; ?> id="lae-carousel-<?php echo $widget_instance->get_id(); ?>"
                            class="lae-carousel lae-container"
                            data-settings='<?php echo wp_json_encode($carousel_settings); ?>'>

        <?php foreach ($elements as $element) : ?>

            <?php $args['element'] = $element; ?>

            <?php lae_get_template_part("addons/carousel/content", $args); ?>

        <?php endforeach; ?>

    </div><!-- .lae-carousel -->

<?php endif; ?>