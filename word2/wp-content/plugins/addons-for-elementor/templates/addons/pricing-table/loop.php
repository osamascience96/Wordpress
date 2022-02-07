<?php
/**
 * Loop - Pricing Table Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/pricing-table/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-pricing-table lae-uber-grid-container <?php echo lae_get_grid_classes($settings); ?>">

    <?php foreach ($settings['pricing_plans'] as $pricing_plan) : ?>

        <?php $args['pricing_plan'] = $pricing_plan; ?>

        <?php lae_get_template_part("addons/pricing-table/content", $args); ?>

    <?php endforeach; ?>

</div><!-- .lae-pricing-table -->

<div class="lae-clear"></div>