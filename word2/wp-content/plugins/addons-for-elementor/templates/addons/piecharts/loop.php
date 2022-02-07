<?php
/**
 * Loop - Piecharts Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/piecharts/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-piecharts lae-uber-grid-container <?php echo lae_get_grid_classes($settings); ?> ">

    <?php foreach ($settings['piecharts'] as $piechart): ?>

        <?php $args['piechart'] = $piechart; ?>

        <?php lae_get_template_part("addons/piecharts/content", $args); ?>

    <?php endforeach; ?>

</div><!-- .lae-piecharts -->

<div class="lae-clear"></div>