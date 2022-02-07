<?php
/**
 * Styling Options for Astra Theme.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.0.15
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Body_Typo_Configs' ) ) {

	/**
	 * Customizer Sanitizes Initial setup
	 */
	class Astra_Body_Typo_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Body Typography Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$typo_section = astra_has_gcp_typo_preset_compatibility() ? 'section-typography' : 'section-body-typo';

			$_configs = array(

				/**
				 * Option: Font Family
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[body-font-family]',
					'type'        => 'control',
					'control'     => 'ast-font',
					'font-type'   => 'ast-font-family',
					'ast_inherit' => __( 'Default System Font', 'astra' ),
					'default'     => astra_get_option( 'body-font-family' ),
					'section'     => $typo_section,
					'priority'    => 6,
					'title'       => __( 'Body Font Family', 'astra' ),
					'connect'     => ASTRA_THEME_SETTINGS . '[body-font-weight]',
					'variant'     => ASTRA_THEME_SETTINGS . '[body-font-variant]',
				),

				/**
				 * Option: Font Variant
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[body-font-variant]',
					'type'              => 'control',
					'control'           => 'ast-font-variant',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_variant' ),
					'default'           => astra_get_option( 'body-font-variant' ),
					'ast_inherit'       => __( 'Default', 'astra' ),
					'section'           => $typo_section,
					'priority'          => 6,
					'title'             => __( 'Variants', 'astra' ),
					'variant'           => ASTRA_THEME_SETTINGS . '[body-font-family]',
				),

				/**
				 * Option: Font Weight
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[body-font-weight]',
					'type'              => 'control',
					'control'           => 'ast-font',
					'font-type'         => 'ast-font-weight',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'default'           => astra_get_option( 'body-font-weight' ),
					'ast_inherit'       => __( 'Default', 'astra' ),
					'section'           => $typo_section,
					'priority'          => 15,
					'title'             => __( 'Weight', 'astra' ),
					'connect'           => ASTRA_THEME_SETTINGS . '[body-font-family]',
				),

				/**
				 * Option: Body Text Transform
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[body-text-transform]',
					'type'     => 'control',
					'control'  => 'ast-select',
					'section'  => $typo_section,
					'default'  => astra_get_option( 'body-text-transform' ),
					'priority' => 20,
					'lazy'     => true,
					'title'    => __( 'Text Transform', 'astra' ),
					'choices'  => array(
						''           => __( 'Default', 'astra' ),
						'none'       => __( 'None', 'astra' ),
						'capitalize' => __( 'Capitalize', 'astra' ),
						'uppercase'  => __( 'Uppercase', 'astra' ),
						'lowercase'  => __( 'Lowercase', 'astra' ),
					),
				),

				/**
				 * Option: Body Font Size
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[font-size-body]',
					'type'        => 'control',
					'control'     => 'ast-responsive-slider',
					'section'     => $typo_section,
					'default'     => astra_get_option( 'font-size-body' ),
					'priority'    => 10,
					'lazy'        => true,
					'title'       => __( 'Size', 'astra' ),
					'suffix'      => 'px',
					'input_attrs' => array(
						'min' => 0,
					),
					'units'       => array(
						'px' => 'px',
					),
				),

				/**
				 * Option: Body Line Height
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[body-line-height]',
					'type'              => 'control',
					'control'           => 'ast-slider',
					'section'           => $typo_section,
					'lazy'              => true,
					'default'           => astra_get_option( 'body-line-height' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_number_n_blank' ),
					'priority'          => 25,
					'title'             => __( 'Line Height', 'astra' ),
					'suffix'            => 'em',
					'input_attrs'       => array(
						'min'  => 1,
						'step' => 0.01,
						'max'  => 5,
					),
				),

				/**
				 * Option: Paragraph Margin Bottom
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[para-margin-bottom]',
					'type'              => 'control',
					'control'           => 'ast-slider',
					'default'           => astra_get_option( 'para-margin-bottom' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_number_n_blank' ),
					'transport'         => 'postMessage',
					'section'           => $typo_section,
					'priority'          => 25,
					'title'             => __( 'Paragraph Margin Bottom', 'astra' ),
					'suffix'            => 'em',
					'lazy'              => true,
					'input_attrs'       => array(
						'min'  => 0.5,
						'step' => 0.01,
						'max'  => 5,
					),
					'divider'           => array( 'ast_class' => 'ast-bottom-divider' ),
				),

				/**
				 * Option: Underline links in entry-content.
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[underline-content-links]',
					'default'   => astra_get_option( 'underline-content-links' ),
					'type'      => 'control',
					'control'   => 'ast-toggle-control',
					'section'   => $typo_section,
					'priority'  => 32,
					'title'     => __( 'Underline Content Links', 'astra' ),
					'transport' => 'postMessage',
				),

				/**
				 * Option: Headings Font Family
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[headings-font-family]',
					'type'      => 'control',
					'control'   => 'ast-font',
					'font-type' => 'ast-font-family',
					'default'   => astra_get_option( 'headings-font-family' ),
					'title'     => __( 'Heading Font Family', 'astra' ),
					'section'   => $typo_section,
					'priority'  => 26,
					'connect'   => ASTRA_THEME_SETTINGS . '[headings-font-weight]',
					'variant'   => ASTRA_THEME_SETTINGS . '[headings-font-variant]',
				),

				/**
				 * Option: Font Variant
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[headings-font-variant]',
					'type'              => 'control',
					'control'           => 'ast-font-variant',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_variant' ),
					'default'           => astra_get_option( 'headings-font-variant' ),
					'ast_inherit'       => __( 'Default', 'astra' ),
					'section'           => $typo_section,
					'priority'          => 26,
					'title'             => __( 'Variants', 'astra' ),
					'variant'           => ASTRA_THEME_SETTINGS . '[headings-font-family]',
				),

				/**
				 * Option: Headings Font Weight
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[headings-font-weight]',
					'type'              => 'control',
					'control'           => 'ast-font',
					'font-type'         => 'ast-font-weight',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'default'           => astra_get_option( 'headings-font-weight' ),
					'title'             => __( 'Weight', 'astra' ),
					'section'           => $typo_section,
					'priority'          => 26,
					'connect'           => ASTRA_THEME_SETTINGS . '[headings-font-family]',
				),

				/**
				 * Option: Headings Text Transform
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[headings-text-transform]',
					'type'     => 'control',
					'control'  => 'ast-select',
					'section'  => $typo_section,
					'title'    => __( 'Text Transform', 'astra' ),
					'lazy'     => true,
					'default'  => astra_get_option( 'headings-text-transform' ),
					'priority' => 26,
					'choices'  => array(
						''           => __( 'Inherit', 'astra' ),
						'none'       => __( 'None', 'astra' ),
						'capitalize' => __( 'Capitalize', 'astra' ),
						'uppercase'  => __( 'Uppercase', 'astra' ),
						'lowercase'  => __( 'Lowercase', 'astra' ),
					),
				),

				/**
				 * Option: Heading <H1> Line Height
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[headings-line-height]',
					'section'           => $typo_section,
					'default'           => astra_get_option( 'headings-line-height' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_number_n_blank' ),
					'type'              => 'control',
					'lazy'              => true,
					'control'           => 'ast-slider',
					'title'             => __( 'Line Height', 'astra' ),
					'transport'         => 'postMessage',
					'priority'          => 26,
					'suffix'            => 'em',
					'input_attrs'       => array(
						'min'  => 1,
						'step' => 0.01,
						'max'  => 5,
					),
					'divider'           => array( 'ast_class' => 'ast-bottom-divider' ),
				),
			);


			if ( astra_has_gcp_typo_preset_compatibility() ) {

				$_configs[] = array(
					'name'       => ASTRA_THEME_SETTINGS . '[heading-typo-selector]',
					'default'    => astra_get_option( 'heading-typo-selector', 'h1' ),
					'type'       => 'control',
					'section'    => $typo_section,
					'priority'   => 27,
					'transport'  => 'postMessage',
					'control'    => 'ast-selector',
					'choices'    => array(
						'h1' => __( 'H1', 'astra' ),
						'h2' => __( 'H2', 'astra' ),
						'h3' => __( 'H3', 'astra' ),
						'h4' => __( 'H4', 'astra' ),
						'h5' => __( 'H5', 'astra' ),
						'h6' => __( 'H6', 'astra' ),
					),
					'responsive' => false,
					'renderAs'   => 'text',
				);
			}

			return array_merge( $configurations, $_configs );
		}
	}
}

new Astra_Body_Typo_Configs();
