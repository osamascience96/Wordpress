<?php
/**
 * Content - Carousel Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/carousel/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<div class="lae-carousel-item">

    <?php echo $widget_instance->parse_text_editor($element['element_content']); ?>

</div><!-- .lae-carousel-item -->