<?php
/**
 * Content - Stats Bars Template
 *
 * This template can be overridden by copying it to mytheme/addons-for-elementor/addons/stats-bars/content.php
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$color_style = '';
$color = $stats_bar['bar_color'];
if ($color)
    $color_style = ' style="background:' . esc_attr($color) . ';"';

?>

<div class="lae-stats-bar">

    <div class="lae-stats-title">

        <?php echo esc_html($stats_bar['stats_title']) ?>

        <span><?php echo esc_attr($stats_bar['percentage_value']); ?>%</span>

    </div>

    <div class="lae-stats-bar-wrap">

        <div <?php echo $color_style; ?> class="lae-stats-bar-content"
                                         data-perc="<?php echo esc_attr($stats_bar['percentage_value']); ?>"></div>

        <div class="lae-stats-bar-bg"></div>

    </div>

</div><!-- .lae-stats-bar -->