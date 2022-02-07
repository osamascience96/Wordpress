<?php

namespace WPForms\Lite\Admin\Education;

/**
 * Education core for Lite.
 *
 * @since 1.6.6
 */
class Core extends \WPForms\Admin\Education\Core {

	/**
	 * Hooks.
	 *
	 * @since 1.6.6
	 */
	protected function hooks() {

		parent::hooks();

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueues' ] );
	}

	/**
	 * Load enqueues.
	 *
	 * @since 1.6.6
	 */
	public function enqueues() {

		parent::enqueues();

		$min = wpforms_get_min_suffix();

		wp_enqueue_script(
			'wpforms-lite-admin-education-core',
			WPFORMS_PLUGIN_URL . "lite/assets/js/admin/education/core{$min}.js",
			[ 'wpforms-admin-education-core' ],
			WPFORMS_VERSION,
			false
		);
	}
}
