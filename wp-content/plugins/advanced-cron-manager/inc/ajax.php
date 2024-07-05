<?php

/**
* ACM Ajax class
*/
class ACMajax {

	public function __construct() {

		add_action('wp_ajax_add_schedule', array($this, 'add_schedule'));
		add_action('wp_ajax_remove_schedule', array($this, 'remove_schedule'));

		add_action('wp_ajax_add_task', array($this, 'add_task'));
		add_action('wp_ajax_remove_task', array($this, 'remove_task'));

	}

	public function add_schedule() {

		$params = $_REQUEST;

		// Return error when noonce doesn't match
		if ( !wp_verify_nonce($params['noonce'], 'add_schedule') )
			die( json_encode( array('status' => 'error', 'details' => __('Sorry, wrong noonce.', 'acm')) ) );

		if ( $params['interval'] <= 0 )
			die( json_encode( array('status' => 'error', 'details' => __('Sorry, interval can\'t be less than 1 second.', 'acm')) ) );

		if ( is_numeric($params['name']) )
			die( json_encode( array('status' => 'error', 'details' => __('Sorry, Schedule name can\'t be numeric.', 'acm')) ) );

		// Get schedules from option and from WP
		$schedules_opt = get_option('acm_schedules', array());
		$schedules_arr = wp_get_schedules();
		$schedules = array_merge($schedules_opt, $schedules_arr);

		$params['name'] = strtolower(trim( str_replace(' ', '_', $params['name']) ));
		
		foreach ($schedules as $name => $schedule) {

			// Return error when there is that schedule already
			if ( $params['name'] == $name )
				die( json_encode( array('status' => 'error', 'details' => sprintf(__('Sorry, there already is %s schedule.', 'acm' ), $name )) ) );

			// Return error when there is schedule with the same interval
			if ( $params['interval'] == $schedule['interval'] )
				die( json_encode( array('status' => 'error', 'details' => sprintf(__('Sorry, there already is schedule with %1$s seconds interval (%2$s).', 'acm' ), $params['interval'], $name )) ) );
		}

		// Add new schedule
		$schedules_opt[$params['name']] = array(
			'interval' => $params['interval'],
			'display' => $params['display']
		);

		// Update option with new schedule
		update_option('acm_schedules', $schedules_opt);

		$li = '<li id="single-schedule-'.$params['name'].'">'.$params['name'].' - '.$params['display'].' <a data-confirm="'.sprintf(__('Are you sure you want to delete %s schedule?', 'acm' ), $params['name'] ).'" data-schedule="'.$params['name'].'" data-noonce="'.wp_create_nonce( 'remove_schedule_'.$params['name'] ).'" class="remove remove-schedule">Remove</a></li>';

		$select = '<option value="'.$params['name'].'">'.$params['display'].'</option>';

		die( json_encode( array('status' => 'success', 'li' => $li, 'select' => $select) ) );


	}	

	public function remove_schedule() {

		$params = $_REQUEST;

		// Return error when noonce doesn't match
		if ( !wp_verify_nonce($params['noonce'], 'remove_schedule_'.$params['name']) )
			die( json_encode( array('status' => 'error', 'details' => __('Sorry, wrong noonce.', 'acm')) ) );

		$schedules = get_option('acm_schedules', array());

		if ( !array_key_exists($params['name'], $schedules) )
			die( json_encode( array('status' => 'error', 'details' => __('Sorry, there is no schedule to remove.', 'acm')) ) );

		// Remove schedule
		unset( $schedules[$params['name']] );

		// Update option with removed schedule
		update_option('acm_schedules', $schedules);

		die( json_encode( array('status' => 'success', 'details' => $params['name'] ) ) );

	}

	public function add_task() {

		$params = $_REQUEST;

		// Return error when noonce doesn't match
		if ( !wp_verify_nonce($params['noonce'], 'add_task') )
			die( json_encode( array('status' => 'error', 'details' => __('Sorry, wrong noonce.', 'acm')) ) );

		// Hook empty
		if ( empty($params['hook']) )
			die( json_encode( array('status' => 'error', 'details' => __('Task hook can\'t be empty.', 'acm')) ) );

		// Schedule name empty
		if ( empty($params['schedule']) )
			die( json_encode( array('status' => 'error', 'details' => __('Schedule name can\'t be empty.', 'acm')) ) );


		// Prepare vars
		$hook = strtolower(trim( str_replace(' ', '_', $params['hook']) ));
		$timestamp = time() + $params['offset'];
		$args = (empty($params['args'])) ? array() : explode(',', $params['args']);

		if ( $params['schedule'] == 'single' ) { // schedule single event

			$status = wp_schedule_single_event( $timestamp, $hook, $args );

			if ( $status === false )
				die( json_encode( array('status' => 'error', 'details' => __('Sorry, something goes wrong.', 'acm')) ) );

		} else { // schedule regular event

			$status = wp_schedule_event( $timestamp, $params['schedule'], $hook, $args );

			if ( $status === false )
				die( json_encode( array('status' => 'error', 'details' => __('Sorry, something goes wrong.', 'acm')) ) );

		}

		// Render new table row

		$wptime_offset = get_option('gmt_offset') * 3600;

		$table = '<tr class="single-cron cron-added-new">';
			$table .= '<td class="column-hook">';
				$table .= $hook;
			$table .= '</td>';
			$table .= '<td class="column-schedule">';
				$table .= $params['schedule'];
			$table .= '</td>';
			$table .= '<td class="column-args">'.acm_get_cron_arguments($args).'</td>';
			$table .= '<td class="column-next">'.acm_get_next_cron_execution($timestamp+$wptime_offset).'</td>';
		$table .= '</tr>';

		die( json_encode( array('status' => 'success', 'table' => $table, 'timestamp' => $timestamp ) ) );

	}

	public function remove_task() {

		$params = $_REQUEST;

		// Return error when noonce doesn't match
		if ( !wp_verify_nonce($params['noonce'], 'remove_task_'.$params['task']) )
			die( json_encode( array('status' => 'error', 'details' => __('Sorry, wrong noonce.', 'acm')) ) );

		$args = (empty($params['args'])) ? array() : explode(',', $params['args']);
		$timestamp = wp_next_scheduled($params['task'], $args);

		$hash = acm_get_cron_hash($params['task'], $timestamp, $args, (!isset($params['interval'])) ? 0 : $params['interval']);

		if ( empty($timestamp) )
			die( json_encode( array('status' => 'error', 'details' => __('Sorry, it\'s wrong data to remove', 'acm')) ) );

		wp_unschedule_event( $timestamp, $params['task'], $args );

		die( json_encode( array('status' => 'success', 'task' => $params['task'], 'info' => '<td colspan="4">'.__('Removed.', 'acm').'</td>', 'hash' => $hash ) ) );

	}

}

?>