<?php
/**
 * Beaver Builder Compatibility File.
 *
 * @package Astra
 */

// If plugin - 'Builder Builder' not exist then return.
if ( ! class_exists( 'FLBuilderModel' ) ) {
	return;
}

/**
 * Astra Beaver Builder Compatibility
 */
if ( ! class_exists( 'Astra_Beaver_Builder' ) ) :

	/**
	 * Astra Beaver Builder Compatibility
	 *
	 * @since 1.0.0
	 */
	class Astra_Beaver_Builder {

		/**
		 * Member Variable
		 *
		 * @var object instance
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'wp', array( $this, 'beaver_builder_default_setting' ), 20 );
			add_action( 'do_meta_boxes', array( $this, 'beaver_builder_default_setting' ), 20 );
			add_filter( 'astra_theme_assets', array( $this, 'add_styles' ) );
		}

		/**
		 * Builder Template Content layout set as Full Width / Stretched
		 *
		 * @since  1.0.13
		 * @return void
		 */
		public function beaver_builder_default_setting() {

			if ( false === astra_enable_page_builder_compatibility() || 'post' == get_post_type() ) {
				return;
			}

			global $post;
			$id = astra_get_post_id();

			$do_render = apply_filters( 'fl_builder_do_render_content', true, FLBuilderModel::get_post_id() ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

			$page_builder_flag = get_post_meta( $id, '_astra_content_layout_flag', true );
			if ( isset( $post ) && empty( $page_builder_flag ) && ( is_admin() || is_singular() ) ) {

				if ( empty( $post->post_content ) && $do_render && FLBuilderModel::is_builder_enabled() ) {

					update_post_meta( $id, '_astra_content_layout_flag', 'disabled' );
					update_post_meta( $id, 'site-post-title', 'disabled' );
					update_post_meta( $id, 'ast-title-bar-display', 'disabled' );
					update_post_meta( $id, 'ast-featured-img', 'disabled' );

					$content_layout = get_post_meta( $id, 'site-content-layout', true );
					if ( empty( $content_layout ) || 'default' == $content_layout ) {
						update_post_meta( $id, 'site-content-layout', 'page-builder' );
					}

					$sidebar_layout = get_post_meta( $id, 'site-sidebar-layout', true );
					if ( empty( $sidebar_layout ) || 'default' == $sidebar_layout ) {
						update_post_meta( $id, 'site-sidebar-layout', 'no-sidebar' );
					}
				}
			}
		}

		/**
		 * Add assets in theme
		 *
		 * @param array $assets list of theme assets (JS & CSS).
		 * @return array List of updated assets.
		 * @since 3.5.0
		 */
		public function add_styles( $assets ) {

			if ( ! empty( $assets['css'] ) ) {
				$assets['css'] = array( 'astra-bb-builder' => 'compatibility/page-builder/bb-plugin' ) + $assets['css'];
			}
			return $assets;
		}

	}

endif;

/**
 * Kicking this off by calling 'get_instance()' method
 */
Astra_Beaver_Builder::get_instance();
