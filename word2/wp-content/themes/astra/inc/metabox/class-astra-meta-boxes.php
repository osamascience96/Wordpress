<?php
/**
 * Post Meta Box
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

/**
 * Meta Boxes setup
 */
if ( ! class_exists( 'Astra_Meta_Boxes' ) ) {

	/**
	 * Meta Boxes setup
	 */
	class Astra_Meta_Boxes {

		/**
		 * Instance
		 *
		 * @var $instance
		 */
		private static $instance;

		/**
		 * Meta Option
		 *
		 * @var $meta_option
		 */
		private static $meta_option;

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
			/** @psalm-suppress InvalidGlobal */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
			global $pagenow;
			/** @psalm-suppress InvalidGlobal */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort

			/**
			 * Set metabox options
			 *
			 * @see https://php.net/manual/en/filter.filters.sanitize.php
			 */
			self::$meta_option = apply_filters(
				'astra_meta_box_options',
				array(
					'ast-hfb-above-header-display'  => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
					'ast-main-header-display'       => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
					'ast-hfb-below-header-display'  => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
					'ast-hfb-mobile-header-display' => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
					'footer-sml-layout'             => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
					'footer-adv-display'            => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
					'site-post-title'               => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
					'site-sidebar-layout'           => array(
						'default'  => 'default',
						'sanitize' => 'FILTER_DEFAULT',
					),
					'site-content-layout'           => array(
						'default'  => 'default',
						'sanitize' => 'FILTER_DEFAULT',
					),
					'ast-featured-img'              => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
					'ast-breadcrumbs-content'       => array(
						'sanitize' => 'FILTER_DEFAULT',
					),
				)
			);

			add_action( 'load-post.php', array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
			add_action( 'do_meta_boxes', array( $this, 'remove_metabox' ) );
			add_filter( 'register_post_type_args', array( $this, 'custom_fields_support' ), 10, 2 );

			add_action( 'init', array( $this, 'register_script' ) );
			add_action( 'init', array( $this, 'register_meta_settings' ) );

			if ( 'widgets.php' !== $pagenow && ! is_customize_preview() ) {
				add_action( 'enqueue_block_editor_assets', array( $this, 'load_scripts' ) );
			}
		}

		/**
		 * Register Post Meta options support.
		 *
		 * @since 3.7.6
		 * @param array|mixed $args the post type args.
		 * @param string      $post_type the post type.
		 */
		public function custom_fields_support( $args, $post_type ) {
			if ( is_array( $args ) && isset( $args['public'] ) && $args['public'] && isset( $args['supports'] ) && is_array( $args['supports'] ) && ! in_array( 'custom-fields', $args['supports'], true ) ) {
				$args['supports'][] = 'custom-fields';
			}

			return $args;
		}

		/**
		 * Check if layout is bb themer's layout
		 */
		public static function is_bb_themer_layout() {

			$is_layout = false;

			$post_type = get_post_type();
			$post_id   = get_the_ID();

			if ( 'fl-theme-layout' === $post_type && $post_id ) {

				$is_layout = true;
			}

			return $is_layout;
		}

		/**
		 *  Remove Metabox for beaver themer specific layouts
		 */
		public function remove_metabox() {

			$post_type = get_post_type();
			$post_id   = get_the_ID();

			if ( 'fl-theme-layout' === $post_type && $post_id ) {

				$template_type = get_post_meta( $post_id, '_fl_theme_layout_type', true );

				if ( ! ( 'archive' === $template_type || 'singular' === $template_type || '404' === $template_type ) ) {

					remove_meta_box( 'astra_settings_meta_box', 'fl-theme-layout', 'side' );
				}
			}
		}

		/**
		 *  Init Metabox
		 */
		public function init_metabox() {

			add_action( 'add_meta_boxes', array( $this, 'setup_meta_box' ) );
			add_action( 'save_post', array( $this, 'save_meta_box' ) );
		}

		/**
		 *  Setup Metabox
		 */
		public function setup_meta_box() {

			// Get all public posts.
			$post_types = get_post_types(
				array(
					'public' => true,
				)
			);

			$post_types['fl-theme-layout'] = 'fl-theme-layout';

			$metabox_name = sprintf(
				// Translators: %s is the theme name.
				__( '%s Settings', 'astra' ),
				astra_get_theme_name()
			);

			// Enable for all posts.
			foreach ( $post_types as $type ) {

				if ( 'attachment' !== $type ) {
					add_meta_box(
						'astra_settings_meta_box',              // Id.
						$metabox_name,                          // Title.
						array( $this, 'markup_meta_box' ),      // Callback.
						$type,                                  // Post_type.
						'side',                                 // Context.
						'default',                               // Priority.
						array(
							'__back_compat_meta_box' => true,
						)
					);
				}
			}
		}

		/**
		 * Get metabox options
		 */
		public static function get_meta_option() {
			return self::$meta_option;
		}

		/**
		 * Metabox Markup
		 *
		 * @param  object $post Post object.
		 * @return void
		 */
		public function markup_meta_box( $post ) {

			wp_nonce_field( basename( __FILE__ ), 'astra_settings_meta_box' );
			$stored = get_post_meta( $post->ID );

			if ( is_array( $stored ) ) {

				// Set stored and override defaults.
				foreach ( $stored as $key => $value ) {
					self::$meta_option[ $key ]['default'] = ( isset( $stored[ $key ][0] ) ) ? $stored[ $key ][0] : '';
				}
			}

			// Get defaults.
			$meta = self::get_meta_option();

			/**
			 * Get options
			 */
			$site_sidebar        = ( isset( $meta['site-sidebar-layout']['default'] ) ) ? $meta['site-sidebar-layout']['default'] : 'default';
			$site_content_layout = ( isset( $meta['site-content-layout']['default'] ) ) ? $meta['site-content-layout']['default'] : 'default';
			$site_post_title     = ( isset( $meta['site-post-title']['default'] ) ) ? $meta['site-post-title']['default'] : '';
			$footer_bar          = ( isset( $meta['footer-sml-layout']['default'] ) ) ? $meta['footer-sml-layout']['default'] : '';
			$footer_widgets      = ( isset( $meta['footer-adv-display']['default'] ) ) ? $meta['footer-adv-display']['default'] : '';
			$above_header        = ( isset( $meta['ast-hfb-above-header-display']['default'] ) ) ? $meta['ast-hfb-above-header-display']['default'] : 'default';
			$primary_header      = ( isset( $meta['ast-main-header-display']['default'] ) ) ? $meta['ast-main-header-display']['default'] : '';
			$below_header        = ( isset( $meta['ast-hfb-below-header-display']['default'] ) ) ? $meta['ast-hfb-below-header-display']['default'] : 'default';
			$mobile_header       = ( isset( $meta['ast-hfb-mobile-header-display']['default'] ) ) ? $meta['ast-hfb-mobile-header-display']['default'] : 'default';
			$ast_featured_img    = ( isset( $meta['ast-featured-img']['default'] ) ) ? $meta['ast-featured-img']['default'] : '';
			$breadcrumbs_content = ( isset( $meta['ast-breadcrumbs-content']['default'] ) ) ? $meta['ast-breadcrumbs-content']['default'] : '';

			$show_meta_field = ! self::is_bb_themer_layout();
			do_action( 'astra_meta_box_markup_before', $meta );

			/**
			 * Option: Sidebar
			 */
			?>
			<div class="site-sidebar-layout-meta-wrap components-base-control__field">
				<p class="post-attributes-label-wrapper" >
					<strong> <?php esc_html_e( 'Sidebar', 'astra' ); ?> </strong>
				</p>
				<select name="site-sidebar-layout" id="site-sidebar-layout">
					<option value="default" <?php selected( $site_sidebar, 'default' ); ?> > <?php esc_html_e( 'Customizer Setting', 'astra' ); ?></option>
					<option value="left-sidebar" <?php selected( $site_sidebar, 'left-sidebar' ); ?> > <?php esc_html_e( 'Left Sidebar', 'astra' ); ?></option>
					<option value="right-sidebar" <?php selected( $site_sidebar, 'right-sidebar' ); ?> > <?php esc_html_e( 'Right Sidebar', 'astra' ); ?></option>
					<option value="no-sidebar" <?php selected( $site_sidebar, 'no-sidebar' ); ?> > <?php esc_html_e( 'No Sidebar', 'astra' ); ?></option>
				</select>
			</div>
			<?php
			/**
			 * Option: Sidebar
			 */
			?>
			<div class="site-content-layout-meta-wrap components-base-control__field">
				<p class="post-attributes-label-wrapper" >
					<strong> <?php esc_html_e( 'Content Layout', 'astra' ); ?> </strong>
				</p>
				<select name="site-content-layout" id="site-content-layout">
					<option value="default" <?php selected( $site_content_layout, 'default' ); ?> > <?php esc_html_e( 'Customizer Setting', 'astra' ); ?></option>
					<option value="boxed-container" <?php selected( $site_content_layout, 'boxed-container' ); ?> > <?php esc_html_e( 'Boxed', 'astra' ); ?></option>
					<option value="content-boxed-container" <?php selected( $site_content_layout, 'content-boxed-container' ); ?> > <?php esc_html_e( 'Content Boxed', 'astra' ); ?></option>
					<option value="plain-container" <?php selected( $site_content_layout, 'plain-container' ); ?> > <?php esc_html_e( 'Full Width / Contained', 'astra' ); ?></option>
					<option value="page-builder" <?php selected( $site_content_layout, 'page-builder' ); ?> > <?php esc_html_e( 'Full Width / Stretched', 'astra' ); ?></option>
				</select>
			</div>
			<?php
			/**
			 * Option: Disable Sections - Primary Header, Title, Footer Widgets, Footer Bar
			 */
			?>
			<div class="disable-section-meta-wrap components-base-control__field">
				<p class="post-attributes-label-wrapper">
					<strong> <?php esc_html_e( 'Disable Sections', 'astra' ); ?> </strong>
				</p>
				<div class="disable-section-meta">
					<?php do_action( 'astra_meta_box_markup_disable_sections_before', $meta ); ?>

					<?php if ( $show_meta_field && Astra_Builder_Helper::is_row_empty( 'above', 'header', 'desktop' ) ) : ?>
					<div class="ast-hfb-above-header-display-option-wrap">
						<input type="checkbox" id="ast-hfb-above-header-display" name="ast-hfb-above-header-display" value="disabled" <?php checked( $above_header, 'disabled' ); ?> />
						<label for="ast-hfb-above-header-display"><?php esc_html_e( 'Disable Above Header', 'astra' ); ?></label> <br />
					</div>
					<?php endif; ?>

					<?php if ( $show_meta_field && Astra_Builder_Helper::is_row_empty( 'primary', 'header', 'desktop' ) ) : ?>
					<div class="ast-main-header-display-option-wrap">
						<label for="ast-main-header-display">
							<input type="checkbox" id="ast-main-header-display" name="ast-main-header-display" value="disabled" <?php checked( $primary_header, 'disabled' ); ?> />
							<?php esc_html_e( 'Disable Primary Header', 'astra' ); ?>
						</label>
					</div>
					<?php endif; ?>

					<?php if ( $show_meta_field && Astra_Builder_Helper::is_row_empty( 'below', 'header', 'desktop' ) ) : ?>
					<div class="ast-hfb-below-header-display-option-wrap">
						<input type="checkbox" id="ast-hfb-below-header-display" name="ast-hfb-below-header-display" value="disabled" <?php checked( $below_header, 'disabled' ); ?> />
						<label for="ast-hfb-below-header-display"><?php esc_html_e( 'Disable Below Header', 'astra' ); ?></label> <br />
					</div>
					<?php endif; ?>

					<?php if ( $show_meta_field && Astra_Builder_Helper::is_row_empty( 'primary', 'header', 'mobile' ) || Astra_Builder_Helper::is_row_empty( 'above', 'header', 'mobile' ) || Astra_Builder_Helper::is_row_empty( 'below', 'header', 'mobile' ) ) : ?>

					<div class="ast-hfb-mobile-header-display-option-wrap">
						<input type="checkbox" id="ast-hfb-mobile-header-display" name="ast-hfb-mobile-header-display" value="disabled" <?php checked( $mobile_header, 'disabled' ); ?> />
						<label for="ast-hfb-mobile-header-display"><?php esc_html_e( 'Disable Mobile Header', 'astra' ); ?></label> <br />
					</div>
					<?php endif; ?>

					<?php do_action( 'astra_meta_box_markup_disable_sections_after_primary_header', $meta ); ?>
					<?php if ( $show_meta_field ) { ?>
						<div class="site-post-title-option-wrap">
							<label for="site-post-title">
								<input type="checkbox" id="site-post-title" name="site-post-title" value="disabled" <?php checked( $site_post_title, 'disabled' ); ?> />
								<?php esc_html_e( 'Disable Title', 'astra' ); ?>
							</label>
						</div>
						<?php
						$ast_breadcrumbs_content = astra_get_option( 'ast-breadcrumbs-content' );
						if ( 'disabled' != $ast_breadcrumbs_content && 'none' !== astra_get_option( 'breadcrumb-position' ) ) {
							?>
					<div class="ast-breadcrumbs-content-option-wrap">
						<label for="ast-breadcrumbs-content">
							<input type="checkbox" id="ast-breadcrumbs-content" name="ast-breadcrumbs-content" value="disabled" <?php checked( $breadcrumbs_content, 'disabled' ); ?> />
							<?php esc_html_e( 'Disable Breadcrumb', 'astra' ); ?>
						</label>
					</div>
						<?php } ?>

						<div class="ast-featured-img-option-wrap">
							<label for="ast-featured-img">
								<input type="checkbox" id="ast-featured-img" name="ast-featured-img" value="disabled" <?php checked( $ast_featured_img, 'disabled' ); ?> />
								<?php esc_html_e( 'Disable Featured Image', 'astra' ); ?>
							</label>
						</div>
					<?php } ?>

					<?php
					$footer_adv_layout = astra_get_option( 'footer-adv' );

					if ( $show_meta_field && ( 'disabled' != $footer_adv_layout && ! Astra_Builder_Helper::$is_header_footer_builder_active ) ) {
						?>
					<div class="footer-adv-display-option-wrap">
						<label for="footer-adv-display">
							<input type="checkbox" id="footer-adv-display" name="footer-adv-display" value="disabled" <?php checked( $footer_widgets, 'disabled' ); ?> />
							<?php esc_html_e( 'Disable Footer Widgets', 'astra' ); ?>
						</label>
					</div>

						<?php
					}
					$footer_sml_layout = astra_get_option( 'footer-sml-layout' );
					if ( 'disabled' != $footer_sml_layout || Astra_Builder_Helper::$is_header_footer_builder_active ) {
						?>
					<div class="footer-sml-layout-option-wrap">
						<label for="footer-sml-layout">
							<input type="checkbox" id="footer-sml-layout" name="footer-sml-layout" value="disabled" <?php checked( $footer_bar, 'disabled' ); ?> />
							<?php esc_html_e( 'Disable Footer', 'astra' ); ?>
						</label>
					</div>
						<?php
					}
					?>
					<?php do_action( 'astra_meta_box_markup_disable_sections_after', $meta ); ?>
				</div>
			</div>
			<?php

			do_action( 'astra_meta_box_markup_after', $meta );
		}

		/**
		 * Metabox Save
		 *
		 * @param  number $post_id Post ID.
		 * @return void
		 */
		public function save_meta_box( $post_id ) {

			// Checks save status.
			$is_autosave = wp_is_post_autosave( $post_id );
			$is_revision = wp_is_post_revision( $post_id );

			$is_valid_nonce = ( isset( $_POST['astra_settings_meta_box'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['astra_settings_meta_box'] ) ), basename( __FILE__ ) ) ) ? true : false;

			// Exits script depending on save status.
			if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
				return;
			}

			/**
			 * Get meta options
			 */
			$post_meta = self::get_meta_option();

			foreach ( $post_meta as $key => $data ) {

				// Sanitize values.
				$sanitize_filter = ( isset( $data['sanitize'] ) ) ? $data['sanitize'] : 'FILTER_DEFAULT';

				switch ( $sanitize_filter ) {

					case 'FILTER_SANITIZE_STRING':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
						break;

					case 'FILTER_SANITIZE_URL':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_URL );
						break;

					case 'FILTER_SANITIZE_NUMBER_INT':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );
						break;

					default:
							$meta_value = filter_input( INPUT_POST, $key, FILTER_DEFAULT );
						break;
				}

				// Store values.
				if ( $meta_value ) {
					update_post_meta( $post_id, $key, $meta_value );
				} else {
					delete_post_meta( $post_id, $key );
				}
			}

		}

		/**
		 * Register Script for Meta options
		 */
		public function register_script() {
			$path = get_template_directory_uri() . '/inc/metabox/extend-metabox/build/index.js';
			wp_register_script(
				'astra-meta-settings',
				$path,
				array( 'wp-plugins', 'wp-edit-post', 'wp-i18n', 'wp-element' ),
				ASTRA_THEME_VERSION,
				true
			);
		}

		/**
		 * Enqueue Script for Meta settings.
		 *
		 * @return void
		 */
		public function load_scripts() {
			$post_type = get_post_type();

			if ( defined( 'ASTRA_ADVANCED_HOOKS_POST_TYPE' ) && ASTRA_ADVANCED_HOOKS_POST_TYPE === $post_type ) {
				return;
			}

			$metabox_name = sprintf(
				// Translators: %s is the theme name.
				__( '%s Settings', 'astra' ),
				astra_get_theme_name()
			);

			$settings_title = $metabox_name;

			/* Directory and Extension */
			$file_prefix = ( true === SCRIPT_DEBUG ) ? '' : '.min';
			$dir_name    = ( true === SCRIPT_DEBUG ) ? 'unminified' : 'minified';
			$css_uri     = ASTRA_THEME_URI . '/inc/metabox/extend-metabox/css/' . $dir_name;

			wp_enqueue_style( 'astra-meta-box', $css_uri . '/metabox' . $file_prefix . '.css', array(), ASTRA_THEME_VERSION );
			wp_enqueue_script( 'astra-meta-settings' );
			wp_localize_script(
				'astra-meta-settings',
				'astMetaParams',
				array(
					'post_type'                => $post_type,
					'title'                    => $settings_title,
					'sidebar_options'          => $this->get_sidebar_options(),
					'sidebar_title'            => __( 'Sidebar', 'astra' ),
					'content_layout'           => $this->get_content_layout_options(),
					'content_layout_title'     => __( 'Content Layout', 'astra' ),
					'disable_sections_title'   => __( 'Disable Sections', 'astra' ),
					'disable_sections'         => $this->get_disable_section_fields(),
					'sticky_header_title'      => __( 'Sticky Header', 'astra' ),
					'sticky_header_options'    => $this->get_sticky_header_options(),
					'transparent_header_title' => __( 'Transparent Header', 'astra' ),
					'page_header_title'        => __( 'Page Header', 'astra' ),
					'header_options'           => $this->get_header_enabled_options(),
					'page_header_options'      => $this->get_page_header_options(),
					'is_bb_themer_layout'      => ! astra_check_is_bb_themer_layout(), // Show page header option only when bb is not activated.
					'is_addon_activated'       => defined( 'ASTRA_EXT_VER' ) ? true : false,
				)
			);
		}

		/**
		 * Get all Sidebar Options.
		 */
		public function get_sidebar_options() {
			return array(
				'default'       => __( 'Customizer Setting', 'astra' ),
				'left-sidebar'  => __( 'Left Sidebar', 'astra' ),
				'right-sidebar' => __( 'Right Sidebar', 'astra' ),
				'no-sidebar'    => __( 'No Sidebar', 'astra' ),
			);
		}

		/**
		 * Get Contenr Layout Options.
		 */
		public function get_content_layout_options() {
			return array(
				'default'                 => __( 'Customizer Setting', 'astra' ),
				'boxed-container'         => __( 'Boxed', 'astra' ),
				'content-boxed-container' => __( 'Content Boxed', 'astra' ),
				'plain-container'         => __( 'Full Width / Contained', 'astra' ),
				'page-builder'            => __( 'Full Width / Stretched', 'astra' ),
			);
		}

		/**
		 * Get disable section fields.
		 */
		public function get_disable_section_fields() {
			return array(
				array(
					'key'   => 'ast-hfb-above-header-display',
					'label' => __( 'Disable Above Header', 'astra' ),
				),
				array(
					'key'   => 'ast-main-header-display',
					'label' => __( 'Disable Primary Header', 'astra' ),
				),
				array(
					'key'   => 'ast-hfb-below-header-display',
					'label' => __( 'Disable Below Header', 'astra' ),
				),
				array(
					'key'   => 'ast-hfb-mobile-header-display',
					'label' => __( 'Disable Mobile Header', 'astra' ),
				),
				array(
					'key'   => 'site-post-title',
					'label' => __( 'Disable Title', 'astra' ),
				),
				array(
					'key'   => 'ast-breadcrumbs-content',
					'label' => __( 'Disable Breadcrumb', 'astra' ),
				),
				array(
					'key'   => 'ast-featured-img',
					'label' => __( 'Disable Featured Image', 'astra' ),
				),
				array(
					'key'   => 'footer-sml-layout',
					'label' => __( 'Disable Footer', 'astra' ),
				),
			);
		}

		/**
		 * Get sticky header options.
		 */
		public function get_sticky_header_options() {
			return array(
				array(
					'key'   => 'header-above-stick-meta',
					'label' => __( 'Stick Above Header', 'astra' ),
				),
				array(
					'key'   => 'header-main-stick-meta',
					'label' => __( 'Disable Primary Header', 'astra' ),
				),
				array(
					'key'   => 'header-below-stick-meta',
					'label' => __( 'Stick Below Header', 'astra' ),
				),
			);
		}

		/**
		 * Get all transparet and sticky header options.
		 */
		public function get_header_enabled_options() {
			return array(
				'default'  => __( 'Customizer Setting', 'astra' ),
				'enabled'  => __( 'Enabled', 'astra' ),
				'disabled' => __( 'Disabled', 'astra' ),
			);
		}

		/**
		 * Get page header Options.
		 */
		public function get_page_header_options() {
			if ( ! defined( 'ASTRA_EXT_VER' ) ) {
				return array();
			}

			/** @psalm-suppress UndefinedClass */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
			$header_options = Astra_Target_Rules_Fields::get_post_selection( 'astra_adv_header' );
			/** @psalm-suppress UndefinedClass */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
			if ( empty( $header_options ) ) {
				$header_options = array(
					'' => __( 'No Page Headers Found', 'astra' ),
				);
			}

			return $header_options;
		}

		/**
		 * Register Post Meta options for react based fields.
		 *
		 * @since 3.7.4
		 */
		public function register_meta_settings() {
			$meta = self::get_meta_option();

			register_post_meta(
				'', // Pass an empty string to register the meta key across all existing post types.
				'site-sidebar-layout',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['site-sidebar-layout']['default'] ) ? $meta['site-sidebar-layout']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'site-content-layout',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['site-content-layout']['default'] ) ? $meta['site-content-layout']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'ast-main-header-display',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['ast-main-header-display']['default'] ) ? $meta['ast-main-header-display']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'ast-hfb-above-header-display',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['ast-hfb-above-header-display']['default'] ) ? $meta['ast-hfb-above-header-display']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'ast-hfb-below-header-display',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['ast-hfb-below-header-display']['default'] ) ? $meta['ast-hfb-below-header-display']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'ast-hfb-mobile-header-display',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['ast-hfb-mobile-header-display']['default'] ) ? $meta['ast-hfb-mobile-header-display']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'site-post-title',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['site-post-title']['default'] ) ? $meta['site-post-title']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'ast-breadcrumbs-content',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['ast-breadcrumbs-content']['default'] ) ? $meta['ast-breadcrumbs-content']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'ast-featured-img',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['ast-featured-img']['default'] ) ? $meta['ast-featured-img']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'footer-sml-layout',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['footer-sml-layout']['default'] ) ? $meta['footer-sml-layout']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'theme-transparent-header-meta',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'adv-header-id-meta',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
			register_post_meta(
				'',
				'stick-header-meta',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);

			register_post_meta(
				'',
				'header-above-stick-meta',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['header-above-stick-meta']['default'] ) ? $meta['header-above-stick-meta']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);

			register_post_meta(
				'',
				'header-main-stick-meta',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['header-main-stick-meta']['default'] ) ? $meta['header-main-stick-meta']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);

			register_post_meta(
				'',
				'header-below-stick-meta',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'default'       => isset( $meta['header-below-stick-meta']['default'] ) ? $meta['header-below-stick-meta']['default'] : '',
					'type'          => 'string',
					'auth_callback' => '__return_true',
				)
			);
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Astra_Meta_Boxes::get_instance();
