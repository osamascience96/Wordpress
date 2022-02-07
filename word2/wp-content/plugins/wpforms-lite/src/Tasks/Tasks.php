<?php

namespace WPForms\Tasks;

use WPForms\Helpers\Transient;
use WPForms\Tasks\Actions\EntryEmailsTask;

/**
 * Class Tasks manages the tasks queue and provides API to work with it.
 *
 * @since 1.5.9
 */
class Tasks {

	/**
	 * Group that will be assigned to all actions.
	 *
	 * @since 1.5.9
	 */
	const GROUP = 'wpforms';

	/**
	 * Perform certain things on class init.
	 *
	 * @since 1.5.9
	 */
	public function init() {

		// Register WPForms tasks.
		foreach ( $this->get_tasks() as $task ) {

			if ( ! is_subclass_of( $task, Task::class ) ) {
				continue;
			}

			new $task();
		}

		add_action( 'delete_expired_transients', [ Transient::class, 'delete_all_expired' ], 11 );

		add_action( 'admin_menu', [ $this, 'admin_hide_as_menu' ], PHP_INT_MAX );

		/*
		 * By default we send emails in the same process as the form submission is done.
		 * That means that when many emails are set in form Notifications -
		 * the form submission can take a while because of all those emails that are sending in the background.
		 * Since WPForms 1.6.0 users can enable a new option in Settings > Emails,
		 * called "Optimize Email Sending", to send email in async way.
		 * This feature was enabled for WPForms 1.5.9, but some users were not happy.
		 */
		if ( ! (bool) wpforms_setting( 'email-async', false ) ) {
			add_filter( 'wpforms_tasks_entry_emails_trigger_send_same_process', '__return_true' );
		}

		add_action( EntryEmailsTask::ACTION, [ EntryEmailsTask::class, 'process' ] );
	}

	/**
	 * Get the list of WPForms default scheduled tasks.
	 * Tasks, that are fired under certain specific circumstances
	 * (like sending form submission email notifications)
	 * are not listed here.
	 *
	 * @since 1.5.9
	 *
	 * @return Task[] List of tasks classes.
	 */
	public function get_tasks() {

		if ( ! $this->is_usable() ) {
			return [];
		}

		$tasks = [
			Actions\EntryEmailsMetaCleanupTask::class,
		];

		return apply_filters( 'wpforms_tasks_get_tasks', $tasks );
	}

	/**
	 * Hide Action Scheduler admin area when not in debug mode.
	 *
	 * @since 1.5.9
	 */
	public function admin_hide_as_menu() {

		// Filter to redefine that WPForms hides Tools > Action Scheduler menu item.
		if ( apply_filters( 'wpforms_tasks_admin_hide_as_menu', ! wpforms_debug() ) ) {
			remove_submenu_page( 'tools.php', 'action-scheduler' );
		}
	}

	/**
	 * Create a new task.
	 * Used for "inline" tasks, that require additional information
	 * from the plugin runtime before they can be scheduled.
	 *
	 * Example:
	 *     wpforms()->get( 'tasks' )
	 *              ->create( 'i_am_the_dude' )
	 *              ->async()
	 *              ->params( 'The Big Lebowski', 1998 )
	 *              ->register();
	 *
	 * This `i_am_the_dude` action will be later processed as:
	 *     add_action( 'i_am_the_dude', 'thats_what_you_call_me' );
	 *
	 * Function `thats_what_you_call_me()` will receive `$meta_id` param,
	 * and you will be able to receive all params from the action like this:
	 *     $params = ( new Meta() )->get( (int) $meta_id );
	 *     list( $name, $year ) = $meta->data;
	 *
	 * @since 1.5.9
	 *
	 * @param string $action Action that will be used as a hook.
	 *
	 * @return \WPForms\Tasks\Task
	 */
	public function create( $action ) {

		return new Task( $action );
	}

	/**
	 * Cancel all the AS actions for a group.
	 *
	 * @since 1.5.9
	 *
	 * @param string $group Group to cancel all actions for.
	 */
	public function cancel_all( $group = '' ) {

		if ( empty( $group ) ) {
			$group = self::GROUP;
		} else {
			$group = sanitize_key( $group );
		}

		if ( class_exists( 'ActionScheduler_DBStore' ) ) {
			\ActionScheduler_DBStore::instance()->cancel_actions_by_group( $group );
		}
	}

	/**
	 * Whether ActionScheduler thinks that it has migrated or not.
	 *
	 * @since 1.5.9.3
	 *
	 * @return bool
	 */
	public function is_usable() {

		// No tasks if ActionScheduler wasn't loaded.
		if ( ! class_exists( 'ActionScheduler_DataController' ) ) {
			return false;
		}

		return \ActionScheduler_DataController::is_migration_complete();
	}

	/**
	 * Whether task has been scheduled and is pending.
	 *
	 * @since 1.6.0
	 *
	 * @param string $hook Hook to check for.
	 *
	 * @return bool
	 */
	public function is_scheduled( $hook ) {

		if ( ! function_exists( 'as_next_scheduled_action' ) ) {
			return false;
		}

		return as_next_scheduled_action( $hook );
	}
}
