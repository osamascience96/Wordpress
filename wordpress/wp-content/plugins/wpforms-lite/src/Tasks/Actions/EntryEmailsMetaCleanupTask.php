<?php

namespace WPForms\Tasks\Actions;

use WPForms\Tasks\Task;
use WPForms\Tasks\Meta;

/**
 * Class EntryEmailsMetaCleanupTask.
 *
 * @since 1.5.9
 */
class EntryEmailsMetaCleanupTask extends Task {

	/**
	 * Action name for this task.
	 *
	 * @since 1.5.9
	 */
	const ACTION = 'wpforms_process_entry_emails_meta_cleanup';

	/**
	 * Class constructor.
	 *
	 * @since 1.5.9
	 */
	public function __construct() {

		parent::__construct( self::ACTION );

		$this->init();
	}

	/**
	 * Initialize the task with all the proper checks.
	 *
	 * @since 1.5.9
	 */
	public function init() {

		// Register the action handler.
		add_action( self::ACTION, [ $this, 'process' ] );

		if ( ! function_exists( 'as_next_scheduled_action' ) ) {
			return;
		}

		// Add new if none exists.
		if ( as_next_scheduled_action( self::ACTION ) !== false ) {
			return;
		}

		$interval = (int) apply_filters( 'wpforms_tasks_entry_emails_meta_cleanup_interval', DAY_IN_SECONDS );

		$this->recurring( strtotime( 'tomorrow' ), $interval )
		     ->params( $interval )
		     ->register();
	}

	/**
	 * Perform the cleanup action: remove outdated meta for entry emails task.
	 *
	 * @since 1.5.9
	 *
	 * @param int $meta_id ID for meta information for a task.
	 */
	public function process( $meta_id ) {

		$task_meta = new Meta();
		$meta      = $task_meta->get( (int) $meta_id );

		// We should actually receive something.
		if ( empty( $meta ) || empty( $meta->data ) ) {
			return;
		}

		list( $interval ) = $meta->data;

		$task_meta->clean_by( EntryEmailsTask::ACTION, (int) $interval );
	}
}
