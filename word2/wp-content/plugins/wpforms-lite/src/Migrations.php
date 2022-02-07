<?php

namespace WPForms;

/**
 * Class Migrations handles both Lite and Pro plugin upgrade routines.
 *
 * @since 1.5.9
 */
class Migrations {

	/**
	 * WP option name to store the migration version.
	 *
	 * @since 1.5.9
	 */
	const OPTION_NAME = 'wpforms_version_lite';

	/**
	 * Have we migrated?
	 *
	 * @since 1.5.9
	 *
	 * @var bool
	 */
	private $is_migrated = false;

	/**
	 * Class init.
	 *
	 * @since 1.5.9
	 */
	public function init() {

		$this->hooks();
	}

	/**
	 * General hooks.
	 *
	 * @since 1.5.9
	 */
	private function hooks() {

		add_action( 'wpforms_loaded', [ $this, 'maybe_migrate' ], -9999 );
		add_action( 'wpforms_loaded', [ $this, 'update_version' ], -9998 );
	}

	/**
	 * Run the migration if needed.
	 *
	 * @since 1.5.9
	 */
	public function maybe_migrate() {

		if ( ! is_admin() ) {
			return;
		}

		// Retrieve the last known version.
		$version = get_option( self::OPTION_NAME );

		if ( empty( $version ) ) {
			$version = '0.0.1';
		}

		$this->migrate( $version );
	}

	/**
	 * Run the migrations for a specific version.
	 *
	 * @since 1.5.9
	 *
	 * @param string $version Version to run the migrations for.
	 */
	private function migrate( $version ) {

		if ( version_compare( $version, '1.5.9', '<' ) ) {
			$this->v159_upgrade();
		}

		if ( version_compare( $version, '1.6.7.2', '<' ) ) {
			$this->v1672_upgrade();
		}

		if ( version_compare( $version, '1.6.8', '<' ) ) {
			$this->v168_upgrade();
		}
	}

	/**
	 * If upgrade has occurred, update version options in database.
	 *
	 * @since 1.5.9
	 */
	public function update_version() {

		if ( ! is_admin() ) {
			return;
		}

		if ( ! $this->is_migrated ) {
			return;
		}

		update_option( self::OPTION_NAME, WPFORMS_VERSION );
	}

	/**
	 * Do all the required migrations for WPForms v1.5.9.
	 *
	 * @since 1.5.9
	 */
	private function v159_upgrade() {

		$meta = wpforms()->get( 'tasks_meta' );

		// Create the table if it doesn't exist.
		if ( $meta && ! $meta->table_exists() ) {
			$meta->create_table();
		}

		$this->is_migrated = true;
	}

	/**
	 * Do all the required migrations for WPForms v1.6.7.2.
	 *
	 * @since 1.6.7.2
	 */
	private function v1672_upgrade() {

		$review = get_option( 'wpforms_review' );

		if ( empty( $review ) ) {
			return;
		}

		$notices = get_option( 'wpforms_admin_notices', [] );

		if ( isset( $notices['review_request'] ) ) {
			return;
		}

		$notices['review_request'] = $review;

		update_option( 'wpforms_admin_notices', $notices, true );
		delete_option( 'wpforms_review' );
	}

	/**
	 * Do all the required migrations for WPForms v1.6.8.
	 *
	 * @since 1.6.8
	 */
	private function v168_upgrade() {

		$current_opened_date = get_option( 'wpforms_builder_opened_date', null );

		// Do not run migration twice as 0 is a default value for all old users.
		if ( $current_opened_date === '0' ) {
			return;
		}

		// We don't want users to report to us if they already previously used the builder by creating a form.
		$forms = wpforms()->form->get(
			'',
			[
				'posts_per_page'         => 1,
				'nopaging'               => false,
				'fields'                 => 'ids',
				'update_post_meta_cache' => false,
			]
		);

		// At least 1 form exists - set the default value.
		if ( ! empty( $forms ) ) {
			add_option( 'wpforms_builder_opened_date', 0, '', 'no' );
		}
	}
}
