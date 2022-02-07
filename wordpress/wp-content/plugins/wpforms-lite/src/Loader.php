<?php

namespace WPForms;

/**
 * WPForms Class Loader.
 *
 * @since 1.5.8
 */
class Loader {

	/**
	 * Classes to register.
	 *
	 * @since 1.5.8
	 *
	 * @var array
	 */
	private $classes = [];

	/**
	 * Loader init.
	 *
	 * @since 1.5.8
	 */
	public function init() {

		$this->populate_classes();

		wpforms()->register_bulk( $this->classes );
	}

	/**
	 * Populate the classes to register.
	 *
	 * @since 1.5.8
	 */
	protected function populate_classes() {

		$this->populate_admin();
		$this->populate_builder();
		$this->populate_migrations();
		$this->populate_capabilities();
		$this->populate_tasks();
		$this->populate_forms();
		$this->populate_smart_tags();
		$this->populate_logger();
		$this->populate_education();
		$this->populate_robots();
	}

	/**
	 * Populate the Forms related classes.
	 *
	 * @since 1.6.2
	 */
	private function populate_forms() {

		$this->classes[] = [
			'name' => 'Forms\Token',
			'id'   => 'token',
		];

		$this->classes[] = [
			'name' => 'Forms\Honeypot',
			'id'   => 'honeypot',
		];
	}

	/**
	 * Populate Admin related classes.
	 *
	 * @since 1.6.0
	 */
	private function populate_admin() {

		array_push(
			$this->classes,
			[
				'name' => 'Admin\Notice',
				'id'   => 'notice',
			],
			[
				'name' => 'Admin\Addons\AddonsCache',
				'id'   => 'addons_cache',
			],
			[
				'name' => 'Admin\Addons\Addons',
				'id'   => 'addons',
			],
			[
				'name' => 'Admin\AdminBarMenu',
				'hook' => 'init',
			],
			[
				'name' => 'Admin\Notifications',
				'id'   => 'notifications',
			],
			[
				'name' => 'Admin\Entries\Edit',
				'id'   => 'entries_edit',
				'hook' => 'admin_init',
			],
			[
				'name' => 'Admin\Entries\Export\Export',
			],
			[
				'name' => 'Admin\Challenge',
				'id'   => 'challenge',
			],
			[
				'name' => 'Admin\FormEmbedWizard',
				'hook' => 'admin_init',
			],
			[
				'name' => 'Admin\SiteHealth',
				'hook' => 'admin_init',
			],
			[
				'name' => 'Admin\Settings\Captcha',
				'hook' => 'admin_init',
			],
			[
				'name' => 'Admin\Tools\Tools',
				'hook' => 'admin_init',
			],
			[
				'name' => 'Admin\Pages\Addons',
				'id'   => 'addons_page',
			],
			[
				'name' => 'Forms\Fields\Richtext\EntryViewContent',
			],
			[
				'name' => 'Admin\Forms\Search',
				'id'   => 'forms_search',
			]
		);
	}

	/**
	 * Populate Form Builder related classes.
	 *
	 * @since 1.6.8
	 */
	private function populate_builder() {

		array_push(
			$this->classes,
			[
				'name' => 'Admin\Builder\Help',
				'id'   => 'builder_help',
			],
			[
				'name' => 'Admin\Builder\Shortcuts',
			],
			[
				'name' => 'Admin\Builder\TemplatesCache',
				'id'   => 'builder_templates_cache',
			],
			[
				'name' => 'Admin\Builder\TemplateSingleCache',
				'id'   => 'builder_template_single',
			],
			[
				'name' => 'Admin\Builder\Templates',
				'id'   => 'builder_templates',
			]
		);
	}

	/**
	 * Populate migration classes.
	 *
	 * @since 1.5.9
	 */
	private function populate_migrations() {

		$this->classes[] = [
			'name' => 'Migrations',
			'hook' => 'plugins_loaded',
		];
	}

	/**
	 * Populate access management (capabilities) classes.
	 *
	 * @since 1.5.8
	 */
	private function populate_capabilities() {

		array_push(
			$this->classes,
			[
				'name' => 'Access\Capabilities',
				'id'   => 'access',
				'hook' => 'plugins_loaded',
			],
			[
				'name' => 'Access\Integrations',
			],
			[
				'name'      => 'Admin\Settings\Access',
				'condition' => is_admin(),
			]
		);
	}

	/**
	 * Populate tasks related classes.
	 *
	 * @since 1.5.9
	 */
	private function populate_tasks() {

		array_push(
			$this->classes,
			[
				'name' => 'Tasks\Tasks',
				'id'   => 'tasks',
				'hook' => 'init',
			],
			[
				'name' => 'Tasks\Meta',
				'id'   => 'tasks_meta',
				'hook' => false,
				'run'  => false,
			]
		);
	}

	/**
	 * Populate smart tags loaded classes.
	 *
	 * @since 1.6.7
	 */
	private function populate_smart_tags() {

		array_push(
			$this->classes,
			[
				'name' => 'SmartTags\SmartTags',
				'id'   => 'smart_tags',
				'run'  => 'hooks',
			]
		);
	}

	/**
	 * Populate logger loaded classes.
	 *
	 * @since 1.6.3
	 */
	private function populate_logger() {

		array_push(
			$this->classes,
			[
				'name' => 'Logger\Log',
				'id'   => 'log',
				'hook' => false,
				'run'  => 'hooks',
			]
		);
	}

	/**
	 * Populate education related classes.
	 *
	 * @since 1.6.6
	 */
	private function populate_education() {

		// Kill switch.
		if ( ! (bool) apply_filters( 'wpforms_admin_education', true ) ) {
			return;
		}

		// Education core classes.
		array_push(
			$this->classes,
			[
				'name' => 'Admin\Education\Core',
				'id'   => 'education',
			],
			[
				'name' => 'Admin\Education\Fields',
				'id'   => 'education_fields',
			]
		);

		// Education features classes.
		$features = [
			'Builder\Captcha',
			'Builder\Fields',
			'Builder\Settings',
			'Builder\Providers',
			'Builder\Payments',
			'Builder\DidYouKnow',
			'Builder\Geolocation',
			'Builder\Confirmations',
			'Admin\DidYouKnow',
			'Admin\Settings\Integrations',
			'Admin\Settings\Geolocation',
			'Admin\NoticeBar',
			'Admin\Entries\Geolocation',
		];

		foreach ( $features as $feature ) {
			array_push(
				$this->classes,
				[
					'name' => 'Admin\Education\\' . $feature,
				]
			);
		}
	}

	/**
	 * Populate robots loaded class.
	 *
	 * @since 1.7.0
	 */
	private function populate_robots() {

		$this->classes[] = [
			'name' => 'Robots',
			'run'  => 'hooks',
		];
	}
}
