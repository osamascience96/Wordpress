<?php

namespace WPForms\Admin\Education\Builder;

use \WPForms\Admin\Education;

/**
 * Builder/Providers Education feature.
 *
 * @since 1.6.6
 */
class Providers extends Education\Builder\Panel {

	/**
	 * Panel slug.
	 *
	 * @since 1.6.6
	 *
	 * @return string
	 **/
	protected function get_name() {

		return 'providers';
	}

	/**
	 * Hooks.
	 *
	 * @since 1.6.6
	 */
	public function hooks() {

		add_action( 'wpforms_providers_panel_sidebar', [ $this, 'filter_addons' ], 1 );
		add_action( 'wpforms_providers_panel_sidebar', [ $this, 'display_addons' ], 500 );
	}

	/**
	 * Ensure that we do not display activated addon items if those addons are not allowed according to the current license.
	 *
	 * @since 1.6.6
	 */
	public function filter_addons() {

		$this->filter_not_allowed_addons( 'wpforms_providers_panel_sidebar' );
	}
}
