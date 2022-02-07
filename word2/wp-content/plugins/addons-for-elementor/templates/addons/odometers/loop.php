<?php
/**
 * Loop - Odometers Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/odometers/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-odometers lae-uber-grid-container <?php echo lae_get_grid_classes($settings); ?>">

    <?php foreach ($settings['odometers'] as $odometer): ?>

        <?php $args['odometer'] = $odometer; ?>

        <?php lae_get_template_part("addons/odometers/content", $args); ?>

    <?php endforeach; ?>

</div><!-- .lae-odometers -->

<div class="lae-clear"></div>