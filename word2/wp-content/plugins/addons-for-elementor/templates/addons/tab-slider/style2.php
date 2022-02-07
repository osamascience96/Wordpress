<?php
/**
 * Tab Slider Template 2
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/tab-slider/style2.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


use Elementor\Icons_Manager;

?>

<div class="lae-tab-slide">

    <div class="lae-tab-slide-nav">

        <?php $icon_type = $tab['icon_type']; ?>

        <?php if ($icon_type == 'icon_image') : ?>

            <span class="lae-image-wrapper">

                <?php $icon_image = $tab['icon_image']; ?>

                <?php echo wp_get_attachment_image($icon_image['id'], 'thumbnail', false, array('class' => 'lae-image')); ?>

            </span>

        <?php elseif ($icon_type == 'icon' && (!empty($tab['selected_icon']['value']))) : ?>

            <span class="lae-icon-wrapper"><?php Icons_Manager::render_icon($tab['selected_icon'], ['aria-hidden' => 'true']); ?></span>

        <?php endif; ?>

        <span class="lae-tab-title"><?php echo esc_html($tab['tab_title']); ?></span>

    </div>

    <div class="lae-tab-slide-content">

        <?php echo $widget_instance->parse_text_editor($tab['tab_content']); ?>

    </div>

</div><!-- .lae-tab-slide -->
