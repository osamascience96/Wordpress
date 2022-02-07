<?php

namespace WPForms\Admin\Builder;

/**
 * Single template cache handler.
 *
 * @since 1.6.8
 */
class TemplateSingleCache extends \WPForms\Helpers\CacheBase {

	/**
	 * Template Id (hash).
	 *
	 * @since 1.6.8
	 *
	 * @var string
	 */
	private $id;

	/**
	 * License data (`key` and `type`).
	 *
	 * @since 1.6.8
	 *
	 * @var array
	 */
	private $license;

	/**
	 * Determine if the class is allowed to load.
	 *
	 * @since 1.6.8
	 *
	 * @return bool
	 */
	protected function allow_load() {

		// Load only in the Form Builder.
		$allow = wp_doing_ajax() || wpforms_is_admin_page( 'builder' );

		/**
		 * Whether to allow to load this class.
		 *
		 * @since 1.7.2
		 *
		 * @param bool $allow True or false.
		 */
		return apply_filters( 'wpforms_admin_builder_templatesinglecache_allow_load', $allow );
	}

	/**
	 * Re-initialize object with the particular template.
	 *
	 * @since 1.6.8
	 *
	 * @param string $template_id Template ID (hash).
	 * @param array  $license     License data.
	 *
	 * @return TemplateSingleCache
	 */
	public function instance( $template_id, $license ) {

		$this->id      = $template_id;
		$this->license = $license;

		$this->init();

		return $this;
	}

	/**
	 * Provide settings.
	 *
	 * @since 1.6.8
	 *
	 * @return array Settings array.
	 */
	protected function setup() {

		return [

			// Remote source URL.
			'remote_source' => $this->remote_source(),

			// Cache file.
			'cache_file'    => $this->get_cache_file_name(),

			// This filter is documented in wpforms/src/Admin/Builder/TemplatesCache.php.
			'cache_ttl'     => (int) apply_filters( 'wpforms_admin_builder_templates_cache_ttl', WEEK_IN_SECONDS ),
		];
	}

	/**
	 * Generate single template remote URL.
	 *
	 * @since 1.6.8
	 *
	 * @return string
	 */
	private function remote_source() {

		if ( ! isset( $this->license['key'] ) ) {
			return '';
		}

		return add_query_arg(
			[
				'license' => $this->license['key'],
				'site'    => site_url(),
			],
			'https://wpforms.com/templates/api/get/' . $this->id
		);
	}

	/**
	 * Get cache directory path.
	 *
	 * @since 1.6.8
	 */
	protected function get_cache_dir() {

		return parent::get_cache_dir() . 'templates/';
	}

	/**
	 * Generate single template cache file name.
	 *
	 * @since 1.6.8
	 *
	 * @return string.
	 */
	private function get_cache_file_name() {

		return sanitize_key( $this->id ) . '.json';
	}

	/**
	 * Prepare data to store in a local cache.
	 *
	 * @since 1.6.8
	 *
	 * @param array $data Raw data received by the remote request.
	 *
	 * @return array Prepared data for caching.
	 */
	protected function prepare_cache_data( $data ) {

		if (
			empty( $data ) ||
			! is_array( $data ) ||
			empty( $data['status'] ) ||
			$data['status'] !== 'success' ||
			empty( $data['data'] )
		) {
			return [];
		}

		$cache_data                                    = $data['data'];
		$cache_data['data']                            = empty( $cache_data['data'] ) ? [] : $cache_data['data'];
		$cache_data['data']['settings']                = empty( $cache_data['data']['settings'] ) ? [] : $cache_data['data']['settings'];
		$cache_data['data']['settings']['ajax_submit'] = '1';

		// Strip the word "Template" from the end of the template name and form title setting.
		$cache_data['name']                           = preg_replace( '/\sTemplate$/', '', $cache_data['name'] );
		$cache_data['data']['settings']['form_title'] = $cache_data['name'];

		// Unset `From Name` field of the notification settings.
		// By default, the builder will use the `blogname` option value.
		unset( $cache_data['data']['settings']['notifications'][1]['sender_name'] );

		return $cache_data;
	}
}
