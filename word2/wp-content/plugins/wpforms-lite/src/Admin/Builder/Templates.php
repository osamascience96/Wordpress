<?php

namespace WPForms\Admin\Builder;

/**
 * Templates class.
 *
 * @since 1.6.8
 */
class Templates {

	/**
	 * All templates data.
	 *
	 * @since 1.6.8
	 *
	 * @var array
	 */
	private $templates;

	/**
	 * Template categories data.
	 *
	 * @since 1.6.8
	 *
	 * @var array
	 */
	private $categories;

	/**
	 * License data.
	 *
	 * @since 1.6.8
	 *
	 * @var array
	 */
	private $license;

	/**
	 * All licenses list.
	 *
	 * @since 1.6.8
	 *
	 * @var array
	 */
	private $all_licenses;

	/**
	 * Determine if the class is allowed to load.
	 *
	 * @since 1.6.8
	 *
	 * @return bool
	 */
	private function allow_load() {

		// Load only in the Form Builder.
		$allow = wp_doing_ajax() || wpforms_is_admin_page( 'builder' );

		/**
		 * Whether to allow the form templates functionality to load.
		 *
		 * @since 1.7.2
		 *
		 * @param bool $allow True or false.
		 */
		return (bool) apply_filters( 'wpforms_admin_builder_templates_allow_load', $allow );
	}

	/**
	 * Initialize class.
	 *
	 * @since 1.6.8
	 */
	public function init() {

		if ( ! $this->allow_load() ) {
			return;
		}

		$this->init_license_data();
		$this->init_templates_data();
		$this->hooks();
	}

	/**
	 * Hooks.
	 *
	 * @since 1.6.8
	 */
	protected function hooks() {

		add_action( 'admin_init', [ $this, 'create_form_on_request' ], 100 );
		add_filter( 'wpforms_form_templates_core', [ $this, 'add_templates_to_setup_panel' ], 20 );
		add_filter( 'wpforms_create_form_args', [ $this, 'apply_to_new_form' ], 10, 2 );
		add_filter( 'wpforms_save_form_args', [ $this, 'apply_to_existing_form' ], 10, 3 );
	}

	/**
	 * Init license data.
	 *
	 * @since 1.6.8
	 */
	private function init_license_data() {

		$this->all_licenses = [ 'lite', 'basic', 'plus', 'pro', 'elite', 'agency', 'ultimate' ];

		// User license data.
		$this->license['key']   = wpforms_get_license_key();
		$this->license['type']  = wpforms_get_license_type();
		$this->license['type']  = in_array( $this->license['type'], [ 'agency', 'ultimate' ], true ) ? 'elite' : $this->license['type'];
		$this->license['type']  = empty( $this->license['type'] ) ? 'lite' : $this->license['type'];
		$this->license['index'] = array_search( $this->license['type'], $this->all_licenses, true );
	}

	/**
	 * Init templates and categories data.
	 *
	 * @since 1.6.8
	 */
	private function init_templates_data() {

		// Get cached templates data.
		$cache_data       = wpforms()->get( 'builder_templates_cache' )->get_cached();
		$templates_all    = ! empty( $cache_data['templates'] ) ? $cache_data['templates'] : [];
		$this->categories = ! empty( $cache_data['categories'] ) ? $cache_data['categories'] : [];

		// Higher priority templates slugs.
		// These remote templates are the replication of the default templates,
		// which were previously included with the WPForms plugin.
		$higher_templates_slugs = [
			'simple-contact-form-template',
			'request-a-quote-form-template',
			'donation-form-template',
			'billing-order-form-template',
			'newsletter-signup-form-template',
			'suggestion-form-template',
		];

		$templates_higher = [];
		$templates_access = [];
		$templates_denied = [];

		foreach ( $templates_all as $i => $template ) {
			$template['has_access'] = $this->has_access( $template );
			$template['license']    = $this->get_license_level( $template );
			$template['source']     = 'wpforms-api';
			$template['categories'] = ! empty( $template['categories'] ) ? array_keys( $template['categories'] ) : [];

			$is_higher = in_array( $i, $higher_templates_slugs, true );

			if ( $template['has_access'] ) {

				if ( $is_higher ) {
					$templates_higher[ $i ] = $template;
				} else {
					$templates_access[ $i ] = $template;
				}
			} else {

				if ( $is_higher ) {
					array_unshift( $templates_denied, $template );
				} else {
					$templates_denied[ $i ] = $template;
				}
			}
		}

		// Sort higher priority templates according to the slugs order.
		$templates_higher = array_replace( array_flip( $higher_templates_slugs ), $templates_higher );
		$templates_higher = array_filter( $templates_higher, 'is_array' );

		// Finally, merge everything together.
		$this->templates = array_merge( $templates_higher, $templates_access, $templates_denied );
	}

	/**
	 * Determine if user's license level has access to the template.
	 *
	 * @since 1.6.8
	 *
	 * @param array $template Template data.
	 *
	 * @return bool
	 */
	private function has_access( $template ) {

		$template_licenses = empty( $template['license'] ) ? [] : array_map( 'strtolower', (array) $template['license'] );
		$has_access        = true;

		foreach ( $template_licenses as $template_license ) {

			$has_access = $this->license['index'] >= array_search( $template_license, $this->all_licenses, true );

			if ( $has_access ) {
				break;
			}
		}

		return $has_access;
	}

	/**
	 * Determine license level of the template.
	 *
	 * @since 1.6.8
	 *
	 * @param array $template Template data.
	 *
	 * @return string
	 */
	private function get_license_level( $template ) {

		$licenses_pro      = [ 'basic', 'plus', 'pro' ];
		$licenses_template = (array) $template['license'];

		if (
			empty( $template['license'] ) ||
			in_array( 'lite', $licenses_template, true )
		) {
			return '';
		}

		foreach ( $licenses_pro as $license ) {
			if ( in_array( $license, $licenses_template, true ) ) {
				return 'pro';
			}
		}

		return 'elite';
	}

	/**
	 * Get categories data.
	 *
	 * @since 1.6.8
	 *
	 * @return array
	 */
	public function get_categories() {

		return $this->categories;
	}

	/**
	 * Get templates data.
	 *
	 * @since 1.6.8
	 *
	 * @return array
	 */
	public function get_templates() {

		return $this->templates;
	}

	/**
	 * Get single template data.
	 *
	 * @since 1.6.8
	 *
	 * @param string $slug Template slug OR Id.
	 *
	 * @return array
	 */
	private function get_template( $slug ) {

		$template = isset( $this->templates[ $slug ] ) ? $this->templates[ $slug ] : $this->get_template_by_id( $slug );

		if ( empty( $template ) ) {
			return [];
		}

		// Attempt to get template with form data (if available).
		$full_template = wpforms()
			->get( 'builder_template_single' )
			->instance( $template['id'], $this->license )
			->get_cached();

		if ( ! empty( $full_template['data'] ) ) {
			return $full_template;
		}

		return $template;
	}

	/**
	 * Get template data by Id.
	 *
	 * @since 1.6.8
	 *
	 * @param string $id Template id.
	 *
	 * @return array
	 */
	private function get_template_by_id( $id ) {

		$templates_by_id = [];

		foreach ( $this->templates as $template ) {
			if ( ! empty( $template['id'] ) ) {
				$templates_by_id[ $template['id'] ] = ! empty( $template['slug'] ) ? $template['slug'] : '';
			}
		}

		$slug = isset( $templates_by_id[ $id ] ) ? $templates_by_id[ $id ] : '';

		return isset( $this->templates[ $slug ] ) ? $this->templates[ $slug ] : [];
	}

	/**
	 * Add templates to the list on the Setup panel.
	 *
	 * @since 1.6.8
	 *
	 * @param array $templates Templates list.
	 *
	 * @return array
	 */
	public function add_templates_to_setup_panel( $templates ) {

		return array_merge( $templates, $this->templates );
	}

	/**
	 * Add template data when form is created.
	 *
	 * @since 1.6.8
	 *
	 * @param array $args Create form arguments.
	 * @param array $data Template data.
	 *
	 * @return array
	 */
	public function apply_to_new_form( $args, $data ) {

		if ( empty( $data ) || empty( $data['template'] ) ) {
			return $args;
		}

		$template = $this->get_template( $data['template'] );

		if (
			empty( $template['data'] ) ||
			! $this->has_access( $template )
		) {
			return $args;
		}

		$template['data']['meta']['template'] = $template['id'];

		// Enable Notifications by default.
		$template['data']['settings']['notification_enable'] = isset( $template['data']['settings']['notification_enable'] )
			? $template['data']['settings']['notification_enable']
			: 1;

		// Unset settings that should be defined locally.
		unset(
			$template['data']['settings']['form_title'],
			$template['data']['settings']['conversational_forms_title'],
			$template['data']['settings']['form_pages_title']
		);

		// Unset certain values for each Notification, since:
		// - Email Subject Line field (subject) depends on the form name that is generated from the template name and form_id.
		// - From Name field (sender_name) depends on the blog name and can be replaced by WP Mail SMTP plugin.
		// - From Email field (sender_address) depends on the internal logic and can be replaced by WP Mail SMTP plugin.
		if ( ! empty( $template['data']['settings']['notifications'] ) ) {
			foreach ( (array) $template['data']['settings']['notifications'] as $key => $notification ) {
				unset(
					$template['data']['settings']['notifications'][ $key ]['subject'],
					$template['data']['settings']['notifications'][ $key ]['sender_name'],
					$template['data']['settings']['notifications'][ $key ]['sender_address']
				);
			}
		}

		// Encode template data to post content.
		$args['post_content'] = wpforms_encode( $template['data'] );

		return $args;
	}

	/**
	 * Add template data when form is updated.
	 *
	 * @since 1.6.8
	 *
	 * @param array $form Form post data.
	 * @param array $data Form data.
	 * @param array $args Update form arguments.
	 *
	 * @return array
	 */
	public function apply_to_existing_form( $form, $data, $args ) {

		if ( empty( $args ) || empty( $args['template'] ) ) {
			return $form;
		}

		$template = $this->get_template( $args['template'] );

		if (
			empty( $template['data'] ) ||
			! $this->has_access( $template )
		) {
			return $form;
		}

		$form_data = wpforms_decode( wp_unslash( $form['post_content'] ) );

		// Something is wrong with the form data.
		if ( empty( $form_data ) ) {
			return $form;
		}

		// Compile the new form data preserving needed data from the existing form.
		$new                     = $template['data'];
		$new['id']               = isset( $form['ID'] ) ? $form['ID'] : 0;
		$new['field_id']         = isset( $form_data['field_id'] ) ? $form_data['field_id'] : 0;
		$new['settings']         = isset( $form_data['settings'] ) ? $form_data['settings'] : [];
		$new['payments']         = isset( $form_data['payments'] ) ? $form_data['payments'] : [];
		$new['meta']             = isset( $form_data['meta'] ) ? $form_data['meta'] : [];
		$new['meta']['template'] = $template['id'];

		// Update the form with new data.
		$form['post_content'] = wpforms_encode( $new );

		return $form;
	}

	/**
	 * Create a form on request.
	 *
	 * @since 1.6.8
	 */
	public function create_form_on_request() {

		$template = $this->get_template_on_request();

		// Just return if template not found OR user doesn't have access.
		if ( empty( $template['has_access'] ) ) {
			return;
		}

		// Check if the template requires some addons.
		if ( $this->check_template_required_addons( $template ) ) {
			return;
		}

		// Set form title equal to the template's name.
		$form_title = ! empty( $template['name'] ) ? $template['name'] : esc_html__( 'New form', 'wpforms-lite' );

		$title_exists = get_page_by_title( $form_title, 'OBJECT', 'wpforms' );
		$form_id      = wpforms()->form->add(
			$form_title,
			[],
			[
				'template' => $template['id'],
			]
		);

		// Return if something wrong.
		if ( ! $form_id ) {
			return;
		}

		// Update form title if duplicated.
		if ( ! empty( $title_exists ) ) {
			wpforms()->form->update(
				$form_id,
				[
					'settings' => [
						'form_title' => $form_title . ' (ID #' . $form_id . ')',
					],
				]
			);
		}

		$this->create_form_on_request_redirect( $form_id );
	}

	/**
	 * Get template data before creating a new form on request.
	 *
	 * @since 1.6.8
	 *
	 * @return array|bool Template OR false.
	 */
	private function get_template_on_request() {

		if ( ! wpforms_is_admin_page( 'builder' ) ) {
			return false;
		}

		if ( ! wpforms_current_user_can( 'create_forms' ) ) {
			return false;
		}

		$form_id = isset( $_GET['form_id'] ) ? (int) $_GET['form_id'] : false; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( ! empty( $form_id ) ) {
			return false;
		}

		$view = isset( $_GET['view'] ) ? sanitize_key( $_GET['view'] ) : 'setup'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( $view !== 'setup' ) {
			return false;
		}

		$template_id = isset( $_GET['template_id'] ) ? sanitize_key( $_GET['template_id'] ) : false; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		// Attempt to get the template.
		$template = $this->get_template( $template_id );

		// Just return if template is not found.
		if ( empty( $template ) ) {
			return false;
		}

		return $template;
	}

	/**
	 * Redirect after creating the form.
	 *
	 * @since 1.6.8
	 *
	 * @param integer $form_id Form ID.
	 */
	private function create_form_on_request_redirect( $form_id ) {

		// Redirect to the builder if possible.
		if ( wpforms_current_user_can( 'edit_form_single', $form_id ) ) {
			wp_safe_redirect(
				add_query_arg(
					[
						'view'    => 'fields',
						'form_id' => $form_id,
						'newform' => '1',
					],
					admin_url( 'admin.php?page=wpforms-builder' )
				)
			);
			exit;
		}

		// Redirect to the forms overview admin page if possible.
		if ( wpforms_current_user_can( 'view_forms' ) ) {
			wp_safe_redirect(
				admin_url( 'admin.php?page=wpforms-overview' )
			);
			exit;
		}

		// Finally, redirect to the admin dashboard.
		wp_safe_redirect( admin_url() );
		exit;
	}

	/**
	 * Check if the template requires some addons and then redirect to the builder for further interaction if needed.
	 *
	 * @since 1.6.8
	 *
	 * @param array $template Template data.
	 *
	 * @return bool True if template requires some addons that are not yet installed and/or activated.
	 */
	private function check_template_required_addons( $template ) {

		// Return false if none addons required.
		if ( empty( $template['addons'] ) ) {
			return false;
		}

		$required_addons = wpforms()->get( 'addons' )->get_by_slugs( $template['addons'] );

		foreach ( $required_addons as $i => $addon ) {
			if ( empty( $addon['action'] ) || ! in_array( $addon['action'], [ 'install', 'activate' ], true ) ) {
				unset( $required_addons[ $i ] );
			}
		}

		// Return false if not need to install or activate any addons.
		// We can proceed with creating the form directly in this process.
		if ( empty( $required_addons ) ) {
			return false;
		}

		// Otherwise return true.
		return true;
	}
}
