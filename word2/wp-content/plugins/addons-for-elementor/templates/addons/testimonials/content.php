<?php
/**
 * Content - Testimonials Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/testimonials/content.php
 *
 */

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

list($animate_class, $animation_attr) = lae_get_animation_atts($testimonial['widget_animation']); ?>

<div class="lae-grid-item lae-testimonial <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

    <div class="lae-testimonial-text">

        <?php echo $widget_instance->parse_text_editor($testimonial['testimonial_text']); ?>

    </div>

    <div class="lae-testimonial-user">

        <div class="lae-image-wrapper">

            <?php $client_image = $testimonial['client_image']; ?>

            <?php if (!empty($client_image)): ?>

                <?php echo wp_get_attachment_image($client_image['id'], 'thumbnail', false, array('class' => 'lae-image full')); ?>

            <?php endif; ?>

        </div>

        <div class="lae-text">

            <<?php echo Utils::validate_html_tag($settings['title_tag']); ?> class="lae-author-name"><?php echo esc_html($testimonial['client_name']); ?></<?php echo Utils::validate_html_tag($settings['title_tag']); ?>>

        <div class="lae-author-credentials"><?php echo wp_kses_post($testimonial['credentials']); ?></div>

    </div><!-- .lae-text -->

</div><!-- .lae-testimonial-user -->

</div><!-- .lae-testimonial -->