<?php
/**
 * Loop - Stats Bars Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/stats-bars/loop.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-stats-bars">

    <?php foreach ($settings['stats_bars'] as $stats_bar) : ?>

        <?php $args['stats_bar'] = $stats_bar; ?>

        <?php lae_get_template_part("addons/stats-bars/content", $args); ?>

    <?php endforeach; ?>

</div><!-- .lae-stats-bars -->