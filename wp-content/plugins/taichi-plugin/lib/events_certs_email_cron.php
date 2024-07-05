<style>
table,th,td
{
border:1px solid black;
border-collapse:collapse;
}
</style>
<?php
include ("../../../../wp-load.php");
include ('../../../../wp-admin/admin-functions.php');
global $wpdb;
$queryy = "SELECT * FROM `wp_posts` where post_type = 'tribe_events' and post_status = 'publish' ";
$events = $wpdb->get_results($queryy, OBJECT);

echo count($events);
$msg = '';
foreach($events as $event)
{
	//echo $event->ID;
	
	$queryy = "SELECT user_id FROM `wp_event_attendees` where event_id = {$event->ID} ";
	$attendee_ids = $wpdb->get_results($queryy, OBJECT);
	if($attendee_ids == null)
		continue;
	$msg .= '<div class="CSSTableGenerator"><table style = "border:1px solid black;border-collapse:collapse;width:300px">';
	$msg .= '<tr><th style = "border:1px solid black;
border-collapse:collapse;" >'.$event->post_title.'</th></tr>';
	foreach($attendee_ids as $attendee_id )
	{
		$msg .=  "<tr><td style = 'border:1px solid black;border-collapse:collapse;'>".get_user_meta($attendee_id, 'first_name', true).",".get_user_meta($attendee_id, 'last_name', true)."</tr></td>";
		
	}
	$msg .= '</table></div><br>';

}
wp_reset_postdata();


echo $msg;




$to = "ittsel.ali@devsinc.com";
$subject = "Events Attendees Lists";
$txt = $msg;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers

$headers .= 'From: Events Attendees Lists <taichi@taichi.com>' . "\r\n";



//mail($to,$subject,$txt,$headers);


?>

