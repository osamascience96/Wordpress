<?php
/**
 * Content - Clients Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/clients/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-client <?php echo $animate_class; ?>" <?php echo $animation_attr; ?>>

    <?php if (!empty($client['client_image'])): ?>

        <?php echo wp_get_attachment_image($client['client_image']['id'], 'full', false, array('class' => 'lae-image full', 'alt' => $client['client_name'])); ?>

    <?php endif; ?>

    <?php if (!empty($client['client_link']) && !empty($client['client_link']['url'])): ?>

        <?php $target = $client['client_link']['is_external'] ? 'target="_blank"' : ''; ?>

        <div class="lae-client-name">

            <a href="<?php echo esc_url($client['client_link']['url']); ?> "
               title="<?php echo esc_html($client['client_name']); ?>" <?php echo $target; ?>><?php echo
                wp_kses_post($client['client_name']); ?></a>

        </div>

    <?php else: ?>

        <div class="lae-client-name"><?php echo wp_kses_post($client['client_name']); ?></div>

    <?php endif; ?>

    <div class="lae-image-overlay"></div>

</div><!-- .lae-client -->