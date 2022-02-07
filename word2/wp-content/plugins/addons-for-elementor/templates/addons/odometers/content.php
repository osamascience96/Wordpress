<?php
/**
 * Content - Odometers Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/odometers/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Icons_Manager;

$migration_allowed = Icons_Manager::is_migration_allowed();

$prefix = (!empty ($odometer['prefix'])) ? '<span class="prefix">' . $odometer['prefix'] . '</span>' : '';
$suffix = (!empty ($odometer['suffix'])) ? '<span class="suffix">' . $odometer['suffix'] . '</span>' : '';

?>

<div class="lae-grid-item lae-odometer">

    <?php echo (!empty ($odometer['prefix'])) ? '<span class="lae-prefix">' . $odometer['prefix'] . '</span>' : ''; ?>

    <div class="lae-number odometer" data-stop="<?php echo intval($odometer['stop_value']); ?>">

        <?php echo intval($odometer['start_value']); ?>

    </div>

    <?php echo (!empty ($odometer['suffix'])) ? '<span class="lae-suffix">' . $odometer['suffix'] . '</span>' : ''; ?>

    <?php $icon_type = esc_html($odometer['icon_type']); ?>

    <?php $icon_html = ''; ?>

    <?php if ($icon_type == 'icon_image') : ?>

        <?php $icon_image = $odometer['icon_image']; ?>

        <?php if (!empty($icon_image)): ?>

            <?php $icon_html = '<span class="lae-image-wrapper">' . wp_get_attachment_image($icon_image['id'], 'full', false, array('class' => 'lae-image full')) . '</span>'; ?>

        <?php endif; ?>

    <?php elseif ((!empty($odometer['icon']) || !empty($odometer['selected_icon']['value']))) : ?>
        <?php

        $migrated = isset($odometer['__fa4_migrated']['selected_icon']);
        $is_new = empty($odometer['icon']) && $migration_allowed;

        $icon_html = '<span class="lae-icon-wrapper">';

        ?>

        <?php if ($is_new || $migrated) : ?>

            <?php

            ob_start();

            Icons_Manager::render_icon($odometer['selected_icon'], ['aria-hidden' => 'true']);

            $icon_html .= ob_get_contents();

            ob_end_clean();

            ?>

        <?php else : ?>

            <?php $icon_html .= '<i class="' . esc_attr($odometer['icon']) . '" aria-hidden="true"></i>'; ?>

        <?php endif; ?>

        <?php $icon_html .= '</span>'; ?>

    <?php endif; ?>

    <div class="lae-stats-title-wrap">

        <div class="lae-stats-title"><?php echo $icon_html . esc_html($odometer['stats_title']); ?></div>

    </div>

</div><!-- .lae-odometer -->