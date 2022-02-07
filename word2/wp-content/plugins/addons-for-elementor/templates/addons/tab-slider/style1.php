<?php
/**
 * Tab Slider Template 1
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/tab-slider/style1.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-tab-slide">

    <div class="lae-tab-slide-nav">

        <span class="lae-tab-title"><?php echo esc_html($tab['tab_title']); ?></span>

    </div>

    <div class="lae-tab-slide-content">

        <?php echo $widget_instance->parse_text_editor($tab['tab_content']); ?>

    </div>

</div><!-- .lae-tab-slide -->
