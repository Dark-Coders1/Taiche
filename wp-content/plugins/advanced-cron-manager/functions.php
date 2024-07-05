<?php
/**
 * Common ACM functions
 */

/**
 * Prints array in readable way
 * @param  array $a
 * @param  string $name
 * @return void
 */
function acm_pr($a, $name = '') {
	echo '<pre>'.$name.' ';
	print_r($a);
	echo '</pre>';
}

function acm_get_cron_hash($name, $timestamp, $args, $itv) {
	return substr(md5($name.$timestamp.implode(':', $args).$itv), 0, 8);
}

function acm_get_cron_arguments($args) {

	$ret = '';

	foreach ($args as $arg) {
		
		$ret .= $arg.'<br />';

	}

	return $ret;
}

function acm_get_next_cron_execution($timestamp) {

	if ($timestamp - time() <= 0)
		return __('At next page refresh', 'acm');

	return __('In', 'acm').' '.human_time_diff( current_time('timestamp'), $timestamp ).'<br>'.date("d.m.Y H:i:s", $timestamp);

}

?>