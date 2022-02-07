<?php
/**
 * Content - Message Box Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/message-box/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Icons_Manager;

?>

<div class="lae-message-box">
    <span class="lae-message-icon">
        <?php if ($settings['icon_type'] == 'icon_image' && !empty($settings['icon_image'])) : ?>
            <div class="lae-image-wrapper">
                <?php echo wp_get_attachment_image($settings['icon_image']['id'], 'large', false, array('class' => 'lae-image lae-thumbnail')); ?>
            </div>
        <?php elseif ($settings['icon_type'] == 'icon' && (!empty($settings['icon']) || !empty($settings['selected_icon']['value']))) : ?>
            <div class="lae-icon-wrapper">
                <?php Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); ?>
            </div>
        <?php endif; ?>
    </span>
    <div class="lae-message-wrap">

        <<?php echo lae_validate_html_tag($settings['message_title_tag']); ?> class="lae-message-title"><?php echo wp_kses_post($settings['message_title']); ?></<?php echo lae_validate_html_tag($settings['message_title_tag']); ?>>

        <p class="lae-message-text"><?php echo do_shortcode(wp_kses_post($settings['message_text'])); ?></p>

    </div>
    <span class="lae-close-icon">
        <?php $icon_value = 'fas fa-times'; ?>

        <?php
        Icons_Manager::render_icon([
            'library' => 'fa-solid',
            'value' => $icon_value,
        ], ['aria-hidden' => 'true']);
        ?>
    </span>
</div>


