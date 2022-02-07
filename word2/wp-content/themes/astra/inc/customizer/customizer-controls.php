<?php
/**
 * Astra Theme Customizer Controls.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$astra_control_dir = ASTRA_THEME_DIR . 'inc/customizer/custom-controls';

// @codingStandardsIgnoreStart WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require $astra_control_dir . '/class-astra-customizer-control-base.php';
require $astra_control_dir . '/typography/class-astra-control-typography.php';
require $astra_control_dir . '/description/class-astra-control-description.php';
require $astra_control_dir . '/customizer-link/class-astra-control-customizer-link.php';
require $astra_control_dir . '/font-variant/class-astra-control-font-variant.php';
// @codingStandardsIgnoreEnd WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
