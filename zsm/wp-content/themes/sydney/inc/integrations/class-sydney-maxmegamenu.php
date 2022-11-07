<?php
/**
 * Class to handle Max Mega Menu compatibility
 *
 * @package Sydney
 */


if ( !class_exists( 'Sydney_MaxMegaMenu' ) ) :

	/**
	 * Sydney_MaxMegaMenu 
	 */
	Class Sydney_MaxMegaMenu {

		/**
		 * Instance
		 */		
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}


		/**
		 * Constructor
		 */
		public function __construct() {	
			add_filter( 'default_option_megamenu_settings', array( $this, 'default_theme' ) );
			add_filter( 'megamenu_themes', array( $this, 'custom_theme' ) );
		}

		/**
		 * Register the default theme
		 */
		public function default_theme( $input ) {
			if ( !isset($value['primary']['theme']) ) {
				$value['primary']['theme'] = 'sydney_theme';
			}
			 
			return $value;
		}

		/**
		 * Sydney's custom theme for MMM
		 */
		function custom_theme( $themes ) {
			$themes["sydney_theme"] = array(
				'title' => 'Sydney',
				'container_background_from' => 'rgba(0, 0, 0, 0)',
				'container_background_to' => 'rgba(0, 0, 0, 0)',
				'menu_item_align' => 'right',
				'menu_item_background_hover_from' => 'rgba(0, 0, 0, 0)',
				'menu_item_background_hover_to' => 'rgba(0, 0, 0, 0)',
				'menu_item_highlight_current' => 'off',
				'panel_font_size' => '14px',
				'panel_font_color' => '#666',
				'panel_font_family' => 'inherit',
				'panel_second_level_font_color' => '#555',
				'panel_second_level_font_color_hover' => '#555',
				'panel_second_level_text_transform' => 'uppercase',
				'panel_second_level_font' => 'inherit',
				'panel_second_level_font_size' => '16px',
				'panel_second_level_font_weight' => 'bold',
				'panel_second_level_font_weight_hover' => 'bold',
				'panel_second_level_text_decoration' => 'none',
				'panel_second_level_text_decoration_hover' => 'none',
				'panel_second_level_padding_left' => '10px',
				'panel_second_level_padding_right' => '10px',
				'panel_second_level_padding_top' => '10px',
				'panel_second_level_padding_bottom' => '10px',
				'panel_third_level_font_color' => '#666',
				'panel_third_level_font_color_hover' => '#666',
				'panel_third_level_font' => 'inherit',
				'panel_third_level_font_size' => '14px',
				'flyout_padding_top' => '0',
				'flyout_padding_right' => '0',
				'flyout_padding_bottom' => '0',
				'flyout_padding_left' => '0',
				'flyout_link_padding_top' => '0',
				'flyout_link_padding_bottom' => '0',
				'flyout_link_size' => '14px',
				'flyout_link_color' => '#666',
				'flyout_link_color_hover' => '#666',
				'flyout_link_family' => 'inherit',
				'toggle_background_from' => 'rgba(0, 0, 0, 0)',
				'toggle_background_to' => 'rgba(0, 0, 0, 0)',
				'toggle_bar_height' => '60px',
				'mobile_menu_padding_left' => '10px',
				'mobile_menu_padding_right' => '10px',
				'mobile_menu_padding_top' => '20px',
				'mobile_menu_padding_bottom' => '20px',
				'mobile_menu_overlay' => 'on',
				'mobile_menu_force_width' => 'on',
				'mobile_background_from' => 'rgb(0, 16, 46)',
				'mobile_background_to' => 'rgb(0, 16, 46)',
				'mobile_menu_item_link_font_size' => '14px',
				'mobile_menu_item_link_color' => '#ffffff',
				'mobile_menu_item_link_text_align' => 'left',
				'mobile_menu_item_link_color_hover' => '#ffffff',
				'mobile_menu_item_background_hover_from' => 'rgba(0, 0, 0, 0)',
				'mobile_menu_item_background_hover_to' => 'rgba(0, 0, 0, 0)',
				'custom_css' => '/** Push menu onto new line **/ 
				#{$wrap} { 
					clear: both; 
				}',
			);
			return $themes;
		}

	}

	/**
	 * Initialize class
	 */
	Sydney_MaxMegaMenu::get_instance();

endif;