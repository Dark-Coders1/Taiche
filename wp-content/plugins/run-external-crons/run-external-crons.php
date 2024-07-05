<?php

/**
 * The Run External Crons Plugin
 *
 * Use WordPress internal cron system to hit external URLs on a scheduled basis.
 *
 * @package Run External Crons
 * @subpackage Main
 */

/**
 * Plugin Name: Run External Crons
 * Plugin URI:  http://blog.milandinic.com/wordpress/plugins/run-external-crons/
 * Description: Use WordPress internal cron system to hit external URLs on a scheduled basis.
 * Author:      Milan Dinić
 * Author URI:  http://blog.milandinic.com/
 * Version:     1.0
 * Text Domain: rec
 * Domain Path: /languages/
 * License:     GPL
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit;

/*
 Todo:
	- add help
 */

/**
 * Schedule REC event on activation
 *
 * Schedules plugin's event that
 * should run on a filterable period.
 *
 * @since 1.0
 *
 * @uses wp_schedule_event() To schedule event
 */
function rec_activation() {
	wp_schedule_event( time(), 'rec', 'rec_event' );
}
register_activation_hook( __FILE__, 'rec_activation' );

/**
 * Unschedule REC event on deactivation
 *
 * @since 1.0
 *
 * @uses wp_next_scheduled() To get time of next event
 * @uses wp_unschedule_event() To unschedule event
 */
function rec_deactivation() {
	$timestamp = wp_next_scheduled( 'rec_event' );
	wp_unschedule_event( $timestamp, 'rec_event' );
}
register_deactivation_hook( __FILE__, 'rec_deactivation' );

/**
 * Remove options on uninstallation of plugin
 *
 * @since 1.0
 *
 * @uses delete_option() To delete all site settings
*/
function rec_uninstall() {
	/* Remove site's settings */
	delete_option( 'run_external_cron_settings' );
	delete_option( 'run_external_cron_last_run' );
}
register_uninstall_hook( __FILE__, 'rec_uninstall' );

/**
 * Load textdomain for internationalization
 *
 * @since 1.0
 *
 * @uses load_plugin_textdomain() To load translation file
 * @uses plugin_basename() To get plugin's file name
 */
function rec_load_textdomain() {
	load_plugin_textdomain( 'rec', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'rec_load_textdomain' );

/**
 * Add action links to plugins page
 *
 * Thanks to Dion Hulse for guide
 * and Adminize plugin for implementation
 *
 * @link http://dd32.id.au/wordpress-plugins/?configure-link
 * @link http://bueltge.de/wordpress-admin-theme-adminimize/674/
 *
 * @since 1.0
 *
 * @uses bbp_digest_load_textdomain() To load translation
 * @uses plugin_basename() To get plugin's file name
 *
 * @param array $links Default links of plugin
 * @param string $file Name of plugin's file
 * @return array $links New & old links of plugin
 */
function rec_filter_plugin_actions( $links, $file ) {
	static $this_plugin;

	if ( ! $this_plugin )
		$this_plugin = plugin_basename( __FILE__ );

	if ( $file == $this_plugin ) {
		$settings_link = '<a href="' . add_query_arg( array( 'page' => 'rec' ), admin_url( 'options-general.php' ) ) . '">' . _x( 'Settings', 'plugin actions link', 'rec' ) . '</a>';
		$donate_link = '<a href="http://blog.milandinic.com/donate/">' . __( 'Donate', 'rec' ) . '</a>';
		$links = array_merge( array( $donate_link, $settings_link ), $links ); // Before other links
	}

	return $links;
}
add_filter( 'plugin_action_links', 'rec_filter_plugin_actions', 10, 2 );

/**
 * Add custom cron interval
 *
 * Add a 'rec' interval to the existing set
 * of intervals. This interval is filterable
 * and by default is lowest of all intervals
 * set by user.
 *
 * @since 1.0
 *
 * @uses apply_filters() Calls 'rec_add_interval' with the time
 *                        of the interval
 *
 * @param $schedules array Existing cron intervals
 * @return $schedules array New cron intervals
 */
function rec_add_interval( $schedules ) {
	$schedules['rec'] = array(
		'interval' => apply_filters( 'rec_add_interval', 3600 ),
		'display' => __( 'Run External Cron Interval', 'rec' )
	);

	return $schedules;
}
add_filter( 'cron_schedules', 'rec_add_interval' );

/**
 * Register settings page
 *
 * @since 1.0
 *
 * @uses add_options_page() To register settings page
 */
function rec_register_setting_page() {
	add_options_page( __( 'Run External Crons', 'rec' ), __( 'Run External Crons', 'rec' ), 'manage_options', 'rec', 'rec_get_settings_page' );
}
add_action( 'admin_menu', 'rec_register_setting_page' );

/**
 * Get settings page
 *
 * @since 1.0
 *
 * @uses rec_settings_page() To display page content
 */
function rec_get_settings_page() {
	/* Load file with settings functions */
	require_once( dirname( __FILE__ ) . '/inc/settings.php' );
	/* Display settings */
	rec_settings_page();
}

/**
 * Filter interval time
 *
 * If user set interval for any URL,
 * use lowest value as event interval.
 *
 * @since 1.0
 *
 * @uses get_option() To get REC settings
 *
 * @param $interval int Existing interval
 * @return $interval int New interval
 */
function rec_filter_interval( $interval ) {
	$rec_options = get_option( 'run_external_cron_settings' );
	if ( $rec_options && $rec_options['interval'] && ( $rec_options['interval'] > 0 ) )
		$interval = $rec_options['interval'];

	return $interval;
}
add_filter( 'rec_add_interval' , 'rec_filter_interval' );

/**
 * Cron event
 *
 * Run external crons
 * on scheduled time.
 *
 * @since 1.0
 *
 * @uses get_option() To get REC settings
 * @uses wp_remote_get() To open URL
 * @uses update_option() To save new REC settings
 */
function rec_event() {
	$rec_options  = get_option( 'run_external_cron_settings' );
	$rec_last_run = get_option( 'run_external_cron_last_run' );

	if ( ! $rec_options || ! $rec_options['rec_url_list'] )
		return;

	if ( ! $rec_last_run )
		$rec_last_run = array();

	foreach ( $rec_options['rec_url_list'] as $item_index => $item ) {
		$md5_url = md5( $item['url'] );
		if ( ! $rec_last_run[$md5_url] || ! $item['ínterval'] || ( ( $rec_last_run[$md5_url] + $item['ínterval'] ) <= time() ) ) {
			wp_remote_get( $item['url'], array( 'timeout' => 600 ) );
			$rec_last_run[$md5_url] = time();
		}
	}

	update_option( 'run_external_cron_last_run', $rec_last_run );
}
add_action( 'rec_event', 'rec_event' );