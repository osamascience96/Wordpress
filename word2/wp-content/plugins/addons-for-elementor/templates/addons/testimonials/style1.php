<?php
/**
 * Testimonials Template 1
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/testimonials/style1.php
 *
 */

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$class_attr = $data_attr = '';

if ($settings['layout'] == 'grid')
    list($class_attr, $data_attr) = lae_get_animation_atts($testimonial['widget_animation']);
?>

<div class="lae-testimonial  lae-<?php echo $testimonial['testimonial_rating']; ?> <?php echo $class_attr; ?>" <?php echo $data_attr; ?>>

    <div class="lae-testimonial-text">

        <?php if ($testimonial['testimonial_rating'] !== 'rating-none') : ?>

            <?php lae_get_template_part("addons/testimonials/star-rating", $args); ?>

        <?php endif; ?>

        <?php echo $widget_instance->parse_text_editor($testimonial['testimonial_text']); ?>

    </div>

    <div class="lae-testimonial-user">

        <div class="lae-image-wrapper">

            <?php $client_image = $testimonial['client_image']; ?>

            <?php if (!empty($client_image)): ?>

                <?php echo wp_get_attachment_image($client_image['id'], 'thumbnail', false, array('class' => 'lae-image full')); ?>

            <?php endif; ?>

        </div><!-- .lae-image-wrapper -->

        <div class="lae-user-text">

            <<?php echo lae_validate_html_tag($settings['title_tag']); ?>
            class="lae-author-name"><?php echo esc_html($testimonial['client_name']); ?></<?php echo lae_validate_html_tag($settings['title_tag']); ?>
        >

            <div class="lae-author-credentials"><?php echo wp_kses_post($testimonial['credentials']); ?></div>

        </div><!-- .lae-user-text -->

    </div><!-- .lae-testimonial-user -->

</div><!-- .lae-testimonial -->