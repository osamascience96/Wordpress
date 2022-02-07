<?php

/**
 * Setup panel.
 *
 * @since 1.0.0
 * @since 1.6.8 Form Builder Refresh.
 */
class WPForms_Builder_Panel_Setup extends WPForms_Builder_Panel {

	/**
	 * Addons data handler class instance.
	 *
	 * @since 1.6.8
	 *
	 * @var \WPForms\Admin\Addons\Addons
	 */
	private $addons_obj;

	/**
	 * Is addon templates available?
	 *
	 * @since 1.6.9
	 *
	 * @var bool
	 */
	private $is_addon_templates_available = false;

	/**
	 * Is custom templates available?
	 *
	 * @since 1.6.9
	 *
	 * @var bool
	 */
	private $is_custom_templates_available = false;

	/**
	 * All systems go.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Define panel information.
		$this->name  = esc_html__( 'Setup', 'wpforms-lite' );
		$this->slug  = 'setup';
		$this->icon  = 'fa-cog';
		$this->order = 5;

		$this->addons_obj = wpforms()->get( 'addons' );
	}

	/**
	 * Enqueue assets for the Setup panel.
	 *
	 * @since 1.0.0
	 * @since 1.6.8 All the builder stylesheets enqueues moved to the `\WPForms_Builder::enqueues()`.
	 */
	public function enqueues() {

		$min = wpforms_get_min_suffix();

		wp_enqueue_script(
			'wpforms-builder-setup',
			WPFORMS_PLUGIN_URL . "assets/js/components/admin/builder/setup{$min}.js",
			[ 'wpforms-builder', 'listjs' ],
			WPFORMS_VERSION,
			true
		);
	}

	/**
	 * Get templates.
	 *
	 * @since 1.6.8
	 *
	 * @return array
	 */
	private function get_templates() {
		/*
		 * Form templates available in the WPForms core plugin.
		 *
		 * @since 1.4.0
		 *
		 * @param array $templates Core templates data.
		 */
		$core_templates = apply_filters( 'wpforms_form_templates_core', [] );

		/*
		 * Form templates available with the WPForms addons.
		 * Allows developers to provide additional templates with an addons.
		 *
		 * @since 1.4.0
		 *
		 * @param array $templates Addons templates data.
		 */
		$additional_templates = apply_filters( 'wpforms_form_templates', [] );

		return array_merge( (array) $core_templates, (array) $additional_templates );
	}

	/**
	 * Output the Settings panel primary content.
	 *
	 * @since 1.0.0
	 */
	public function panel_content() {

		?>
		<div id="wpforms-setup-form-name">
			<label for="wpforms-setup-name"><?php esc_html_e( 'Name Your Form', 'wpforms-lite' ); ?></label>
			<input type="text" id="wpforms-setup-name" placeholder="<?php esc_attr_e( 'Enter your form name here&hellip;', 'wpforms-lite' ); ?>">
		</div>

		<div class="wpforms-setup-title">
			<?php esc_html_e( 'Select a Template', 'wpforms-lite' ); ?>
			<span class="wpforms-setup-title-after"></span>
		</div>

		<p class="wpforms-setup-desc secondary-text">
			<?php
			printf(
				wp_kses( /* translators: %1$s - Create template doc link; %2$s - Contact us page link. */
					__( 'To speed up the process you can select from one of our pre-made templates, start with a <a href="#" class="wpforms-trigger-blank">blank form</a> or <a href="%1$s" target="_blank" rel="noopener noreferrer">create your own</a>. Have a suggestion for a new template? <a href="%2$s" target="_blank" rel="noopener noreferrer">We’d love to hear it</a>!', 'wpforms-lite' ),
					[
						'strong' => [],
						'a'      => [
							'href'   => [],
							'class'  => [],
							'target' => [],
							'rel'    => [],
						],
					]
				),
				'https://wpforms.com/docs/how-to-create-a-custom-form-template/',
				'https://wpforms.com/form-template-suggestion/'
			);
			?>
		</p>

		<?php
		ob_start();
		$this->template_select_options( $this->get_templates() );
		$templates = ob_get_clean();
		?>

		<div class="wpforms-setup-templates">
			<div class="wpforms-setup-templates-sidebar">

				<div class="wpforms-setup-templates-search-wrap">
					<i class="fa fa-search"></i>
					<input type="text" id="wpforms-setup-template-search" value="" placeholder="<?php esc_attr_e( 'Search Templates', 'wpforms-lite' ); ?>">
				</div>

				<ul class="wpforms-setup-templates-categories">
					<?php $this->template_categories(); ?>
				</ul>

			</div>

			<div id="wpforms-setup-templates-list">
				<div class="list">
					<?php echo $templates; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		</div>
		<?php

		do_action( 'wpforms_setup_panel_after' );
	}

	/**
	 * Generate and display categories menu.
	 *
	 * @since 1.6.8
	 */
	private function template_categories() {

		$common_categories = [
			'all' => esc_html__( 'All Templates', 'wpforms-lite' ),
		];

		if ( $this->is_custom_templates_available ) {
			$common_categories['custom'] = esc_html__( 'Custom Templates', 'wpforms-lite' );
		}

		if ( $this->is_addon_templates_available ) {
			$common_categories['addons'] = esc_html__( 'Addon Templates', 'wpforms-lite' );
		}

		$categories = array_merge(
			$common_categories,
			wpforms()->get( 'builder_templates' )->get_categories()
		);

		foreach ( $categories as $slug => $name ) {
			printf(
				'<li data-category="%1$s"%2$s>%3$s</li>',
				esc_attr( $slug ),
				$slug === 'all' ? ' class="active"' : '',
				esc_html( $name )
			);
		}
	}

	/**
	 * Generate a block of templates to choose from.
	 *
	 * @since 1.4.0
	 * @since 1.6.8 Refactor during the Form Builder Refresh. Deprecate second parameter `$slug`.
	 *
	 * @param array  $templates Templates array.
	 * @param string $slug      Deprecated.
	 */
	public function template_select_options( $templates, $slug = '' ) {

		if ( empty( $templates ) ) {
			return;
		}

		// Loop through each available template.
		foreach ( $templates as $template ) {

			echo wpforms_render( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				'builder/templates-item',
				$this->prepare_template_render_arguments( $template ),
				true
			);
		}
	}

	/**
	 * Prepare arguments for rendering template item.
	 *
	 * @since 1.6.8
	 *
	 * @param array $template Template data.
	 *
	 * @return array Arguments.
	 */
	private function prepare_template_render_arguments( $template ) {

		$template['plugin_dir'] = isset( $template['plugin_dir'] ) ? $template['plugin_dir'] : '';
		$template['source']     = $this->get_template_source( $template );
		$template['url']        = ! empty( $template['url'] ) ? $template['url'] : '';
		$template['has_access'] = ! empty( $template['license'] ) ? $template['has_access'] : true;

		$args = [];

		$args['template_id'] = ! empty( $template['id'] ) ? $template['id'] : $template['slug'];
		$args['categories']  = $this->get_template_categories( $template );
		$args['demo_url']    = '';

		if ( ! empty( $template['url'] ) ) {
			$utm_campaign     = wpforms()->pro ? 'plugin' : 'liteplugin';
			$args['demo_url'] = add_query_arg(
				[
					'utm_content' => $template['name'],
				],
				$template['url'] . "?utm_source=WordPress&utm_campaign={$utm_campaign}&utm_medium=builder-templates"
			);
		}

		$template_license = ! empty( $template['license'] ) ? $template['license'] : '';
		$template_name    = sprintf( /* translators: %s - Form template name. */
			esc_html__( '%s template', 'wpforms-lite' ),
			esc_html( $template['name'] )
		);

		$args['badge_text']           = '';
		$args['license_class']        = '';
		$args['education_class']      = '';
		$args['education_attributes'] = '';

		if ( $template['source'] === 'wpforms-addon' ) {
			$args['badge_text'] = esc_html__( 'Addon', 'wpforms-lite' );

			// At least one addon template available.
			$this->is_addon_templates_available = true;
		}

		if ( empty( $template['has_access'] ) ) {
			$args['license_class']        = ' pro';
			$args['badge_text']           = $template_license;
			$args['education_class']      = ' education-modal';
			$args['education_attributes'] = sprintf(
				' data-name="%1$s" data-license="%2$s" data-action="upgrade"',
				esc_attr( $template_name ),
				esc_attr( $template_license )
			);
		}

		$args['addons_attributes'] = $this->prepare_addons_attributes( $template );

		$args['selected']       = ! empty( $this->form_data['meta']['template'] ) && $this->form_data['meta']['template'] === $args['template_id'];
		$args['selected_class'] = $args['selected'] ? ' selected' : '';
		$args['badge_text']     = $args['selected'] ? esc_html__( 'Selected', 'wpforms-lite' ) : $args['badge_text'];
		$args['template']       = $template;

		return $args;
	}

	/**
	 * Generate addon attributes.
	 *
	 * @since 1.6.8
	 *
	 * @param array $template Template data.
	 *
	 * @return string Addon attributes.
	 */
	private function prepare_addons_attributes( $template ) {

		$addons_attributes = '';
		$required_addons   = false;

		if ( ! empty( $template['addons'] ) && is_array( $template['addons'] ) ) {
			$required_addons = $this->addons_obj->get_by_slugs( $template['addons'] );

			foreach ( $required_addons as $i => $addon ) {
				if (
					! isset( $addon['action'] ) ||
					! isset( $addon['title'] ) ||
					! isset( $addon['slug'] ) ||
					! in_array( $addon['action'], [ 'install', 'activate' ], true )
				) {
					unset( $required_addons[ $i ] );
				}
			}
		}

		if ( ! empty( $required_addons ) ) {
			$addons_names = implode( ', ', wp_list_pluck( $required_addons, 'title' ) );
			$addons_slugs = implode( ',', wp_list_pluck( $required_addons, 'slug' ) );

			$addons_attributes = sprintf(
				' data-addons-names="%1$s" data-addons="%2$s"',
				esc_attr( $addons_names ),
				esc_attr( $addons_slugs )
			);
		}

		return $addons_attributes;
	}

	/**
	 * Determine the template source.
	 *
	 * @since 1.6.9
	 *
	 * @param array $template Template data.
	 *
	 * @return string Template source.
	 */
	private function get_template_source( $template ) {

		if ( ! empty( $template['source'] ) ) {
			return $template['source'];
		}

		if ( $template['plugin_dir'] === 'wpforms' || $template['plugin_dir'] === 'wpforms-lite' ) {
			return 'wpforms-core';
		}

		return 'wpforms-addon';
	}

	/**
	 * Determine the template categories.
	 *
	 * @since 1.6.9
	 *
	 * @param array $template Template data.
	 *
	 * @return string Template categories coma separated.
	 */
	private function get_template_categories( $template ) {

		$categories = ! empty( $template['categories'] ) ? (array) $template['categories'] : [];

		if ( isset( $template['source'] ) && $template['source'] === 'wpforms-addon' ) {
			$categories[] = 'addons';
		}

		static $addons = null;

		if ( $addons === null ) {
			$addons = array_keys( $this->addons_obj->get_all() );
		}

		if (
			isset( $template['source'] ) &&
			$template['source'] !== 'wpforms-core' &&
			$template['source'] !== 'wpforms-api' &&
			! in_array( $template['plugin_dir'], $addons, true )
		) {
			$categories[] = 'custom';

			// At least one custom template available.
			$this->is_custom_templates_available = true;
		}

		return implode( ',', $categories );
	}
}

new WPForms_Builder_Panel_Setup();
