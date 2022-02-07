<?php
/**
 * Content - Pricing Table Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/pricing-table/content.php
 *
 */


use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$pricing_title = esc_html($pricing_plan['pricing_title']);
$tagline = esc_html($pricing_plan['tagline']);
$price_tag = htmlspecialchars_decode(wp_kses_post($pricing_plan['price_tag']));
$pricing_img = $pricing_plan['pricing_image'];
$pricing_url = (empty($pricing_plan['button_url']['url'])) ? '#' : esc_url($pricing_plan['button_url']['url']);
$pricing_button_text = esc_html($pricing_plan['button_text']);
$button_new_window = esc_html($pricing_plan['button_url']['is_external']);
$highlight = ($pricing_plan['highlight'] == 'yes');

$price_tag = (empty($price_tag)) ? '' : $price_tag;

list($animate_class, $animation_attr) = lae_get_animation_atts($pricing_plan['widget_animation']);

?>

<div class="lae-grid-item lae-pricing-plan <?php echo($highlight ? ' lae-highlight' : ''); ?> <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

    <div class="lae-top-header">

        <?php if (!empty($tagline)): ?>
        
            <p class="lae-tagline center"><?php echo $tagline; ?></p>
        
        <?php endif; ?>

        <<?php echo lae_validate_html_tag($settings['plan_name_tag']); ?> class="lae-plan-name lae-center"><?php echo $pricing_title; ?></<?php echo lae_validate_html_tag($settings['plan_name_tag']); ?>>

        <?php if (!empty($pricing_img)) : ?>

            <?php echo wp_get_attachment_image($pricing_img['id'], 'full', false, array('class' => 'lae-image full', 'alt' => $pricing_title)); ?>

        <?php endif; ?>

    </div>

    <<?php echo lae_validate_html_tag($settings['plan_price_tag']); ?> class="lae-plan-price lae-plan-header lae-center">

        <span class="lae-text"><?php echo wp_kses_post($price_tag); ?></span>

    </<?php echo lae_validate_html_tag($settings['plan_price_tag']); ?>>

    <div class="lae-plan-details">

        <?php echo $widget_instance->parse_text_editor($pricing_plan['pricing_content']); ?>

    </div><!-- .lae-plan-details -->

    <div class="lae-purchase">

        <a class="lae-button default"
           href="<?php echo esc_url($pricing_url); ?>"<?php echo(!empty($button_new_window) ? ' target="_blank"' : ''); ?>><?php echo esc_html($pricing_button_text); ?></a>

    </div>

</div><!-- .lae-pricing-plan -->