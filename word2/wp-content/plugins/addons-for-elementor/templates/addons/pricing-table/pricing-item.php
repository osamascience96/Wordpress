<?php

/**
 * Loop - Pricing Item Shortcode Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/pricing-table/pricing-item.php
 *
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-pricing-item">

    <div class="lae-title"><?php echo htmlspecialchars_decode(wp_kses_post($title)); ?></div>

    <div class="lae-value-wrap">

        <div class="lae-value">

            <?php echo htmlspecialchars_decode(wp_kses_post($value)); ?>

        </div>

    </div>

</div>
