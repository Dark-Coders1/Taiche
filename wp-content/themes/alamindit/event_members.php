<?php
require_once("../../../wp-load.php");

global $wpdb;

$queryy = "SELECT distinct(post_author) FROM `wp_posts` where post_type = 'tribe_events' and post_status = 'publish' ";
$authors = $wpdb->get_results($queryy, OBJECT);
foreach($authors as $author)
{
echo "id".$author->post_author;
$queryy = "SELECT * FROM `wp_posts` where post_type = 'tribe_events' and post_status = 'publish' and post_author = {$author->post_author}  ";
$events = $wpdb->get_results($queryy, OBJECT);

echo "count".count($events);echo "<br>";
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
		$msg .=  "<tr><td style = 'border:1px solid black;border-collapse:collapse;'>".gewt_user_meta($attendee_id, 'first_name', true).",".get_user_meta($attendee_id, 'last_name', true)."</tr></td>";
		
	}
	$msg .= '</table></div><br>';

}
wp_reset_postdata();


echo $msg;

$user_info = get_userdata($author->post_author);
      echo $user_info->user_email;


$to = $user_info->user_email;
$subject = "Events Attendees Lists Author";
$txt = $msg;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers

$headers .= 'From: Events Attendees Lists authors<taichi@taichi.com>' . "\r\n";


if($msg != null)
mail("riaz@chimpchamp.com",$subject,$txt,$headers);
//wp_mail("ittsel.ali@devsinc.com",$subject,$txt,$headers);
$msg = null;
}
 ?>
