<?php
	echo "Cron Job run";
	include ("../../../../wp-load.php");
	include ('../../../../wp-admin/admin-functions.php');
	include('taichi-class-segment.php');
	// Create new segments in mailchimp
	taichi_segment::create_segment();		
	ob_end_flush();

	// update existing segments with new emails.
	taichi_segment::update_segment();
	ob_end_flush();
?>