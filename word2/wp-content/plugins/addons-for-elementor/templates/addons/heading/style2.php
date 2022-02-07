<?php
/**
 * Heading Template 2
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/heading/style2.php
 *
 */


use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

list($animate_class, $animation_attr) = lae_get_animation_atts($settings['widget_animation']);

?>

<div class="lae-heading lae-<?php echo $settings['style']; ?> lae-align<?php echo $settings['align']; ?> <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

    <?php if (!empty($settings['subtitle'])): ?>

        <div class="lae-subtitle"><?php echo esc_html($settings['subtitle']); ?></div>

    <?php endif; ?>

    <<?php echo lae_validate_html_tag($settings['title_tag']); ?> class="lae-title"><?php echo wp_kses_post($settings['heading']); ?></<?php echo lae_validate_html_tag($settings['title_tag']); ?>>

    <?php if (!empty($settings['short_text'])): ?>

        <p class="lae-text"><?php echo wp_kses_post($settings['short_text']); ?></p>

    <?php endif; ?>

</div><!-- .lae-heading -->