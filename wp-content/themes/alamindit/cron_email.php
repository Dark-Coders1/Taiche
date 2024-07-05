<?php
require_once("../../../wp-load.php");





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




$to = "riaz@chimpchamp.com";
$subject = "Events Attendees Lists";
$txt = $msg;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers

$headers .= 'From: Events Attendees Lists <taichi@taichi.com>' . "\r\n";
	if(mail('ittsel.ali@devsinc.com',$subject,$txt,$headers))
	echo "email sent";



//------------------------------------------Start NOtification of certifications-----------------------------
global $wpdb;
$email_obj = $wpdb->get_results("SELECT * FROM `wp_expiry_email`");	
// EXPIRED CERTIFICATIONS
	$subject = $email_obj[4]->meta_value;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: TCHI<taichi@taichi.com>' . "\r\n";
		
	$queryy = "SELECT * FROM `wp_Instructors_Certification` where certification_expiry_date < curdate() and email = 0";
	$expired_cert_owners = $wpdb->get_results($queryy, ARRAY_A);
	foreach($expired_cert_owners as $obj)
	{
				
		$queryy = "SELECT user_email FROM `wp_users` where ID = {$obj['instructor_id']}";	
		$owner_email = $wpdb->get_var($queryy);
		$to = $owner_email;	
		$txt = $obj['name']."<br>". $email_obj[5]->meta_value;
		if (stripos($to,'chimpchamp') !== false) {
    			mail($to,$subject,$txt,$headers);
		}
		//mail($to,$subject,$txt,$headers);
		$wpdb->update( 
		'wp_Instructors_Certification', 
		array( 
		'email' => '1'	// integer (number) 
		), 
		array( 'id' => $obj['id'] ), 
		array( 
		'%d'	// value2
		), 
		array( '%d' ) 
				);
	}

	// 6 MONTH GRACE PERIOD NOTIFICATION
	
	$subject = $email_obj[0]->meta_value;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: TCHI<taichi@taichi.com>' . "\r\n";
	global $wpdb;	
	$queryy = "SELECT * FROM `wp_Instructors_Certification` where certification_expiry_date between  DATE_ADD(curdate(),INTERVAL 170 DAY) and DATE_ADD(curdate(),INTERVAL 186 DAY) and 6_b_exp = 0";
	$expired_cert_owners = $wpdb->get_results($queryy, ARRAY_A);
	foreach($expired_cert_owners as $obj)
	{
				
		$queryy = "SELECT user_email FROM `wp_users` where ID = {$obj['instructor_id']}";	
		$owner_email = $wpdb->get_var($queryy);
		$to = $owner_email;	
		$txt = $obj['name']."<br>".$email_obj[3]->meta_value;
		if (stripos($to,'chimpchamp') !== false) {
    			mail($to,$subject,$txt,$headers);
		}		
		//mail($to,$subject,$txt,$headers);
		$wpdb->update( 
		'wp_Instructors_Certification', 
		array( 
		'6_b_exp' => '1'	// integer (number) 
		), 
		array( 'id' => $obj['id'] ), 
		array( 
		'%d'	// value2
		), 
		array( '%d' ) 
				);
	}


	// 3 MONTH GRACE PERIOD NOTIFICATION
	
	$subject = $email_obj[1]->meta_value;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: TCHI<taichi@taichi.com>' . "\r\n";
	global $wpdb;	
	$queryy = "SELECT * FROM `wp_Instructors_Certification` where certification_expiry_date between  DATE_ADD(curdate(),INTERVAL 83 DAY) and DATE_ADD(curdate(),INTERVAL 96 DAY) and 3_b_exp = 0";
	$expired_cert_owners = $wpdb->get_results($queryy, ARRAY_A);
	foreach($expired_cert_owners as $obj)
	{
				
		$queryy = "SELECT user_email FROM `wp_users` where ID = {$obj['instructor_id']}";	
		$owner_email = $wpdb->get_var($queryy);
		$to = $owner_email;	
		$txt = $obj['name']."<br>".$email_obj[2]->meta_value;
		
		if (stripos($to,'chimpchamp') !== false) {
			
    			mail($to,$subject,$txt,$headers);
		}			
		//mail($to,$subject,$txt,$headers);
		$wpdb->update( 
		'wp_Instructors_Certification', 
		array( 
		'3_b_exp' => '1'	// integer (number) 
		), 
		array( 'id' => $obj['id'] ), 
		array( 
		'%d'	// value2
		), 
		array( '%d' ) 
				);
	}

	// After 3 MONTH After EXPIRY
	
	$subject = $email_obj[6]->meta_value;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: TCHI<taichi@taichi.com>' . "\r\n";
	global $wpdb;	
	$queryy = "SELECT * FROM `wp_Instructors_Certification` where certification_expiry_date between  DATE_SUB(curdate(),INTERVAL 96 DAY) and DATE_SUB(curdate(),INTERVAL 80 DAY) and 3_a_exp = 0";
	$expired_cert_owners = $wpdb->get_results($queryy, ARRAY_A);
	foreach($expired_cert_owners as $obj)
	{
				
		$queryy = "SELECT user_email FROM `wp_users` where ID = {$obj['instructor_id']}";	
		$owner_email = $wpdb->get_var($queryy);
		$to = $owner_email;
		echo "email veri:";
echo $to = "ittsel.ali@ChimpChamp.com";
		print_r(stripos($to,'chimpchamp'));
		if (stripos($to,'chimpchamp') !== false) {echo "dont send email";}	
		$txt = $obj['name']."<br>".$email_obj[7]->meta_value;
		if (stripos($to,'chimpchamp') !== false) {
			echo $subject;
    			mail($to,$subject,$txt,$headers);
		}
		//mail($to,$subject,$txt,$headers);
		$wpdb->update( 
		'wp_Instructors_Certification', 
		array( 
		'3_a_exp' => '1'	// integer (number) 
		), 
		array( 'id' => $obj['id'] ), 
		array( 
		'%d'	// value2
		), 
		array( '%d' ) 
				);
	}

	// After 6 MONTH After EXPIRY
	
	$subject = $email_obj[9]->meta_value;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: TCHI<taichi@taichi.com>' . "\r\n";
	global $wpdb;	
	$queryy = "SELECT * FROM `wp_Instructors_Certification` where certification_expiry_date between  DATE_SUB(curdate(),INTERVAL 190 DAY) and DATE_SUB(curdate(),INTERVAL 170 DAY) and 6_a_exp = 0";
	$expired_cert_owners = $wpdb->get_results($queryy, ARRAY_A);
	foreach($expired_cert_owners as $obj)
	{
				
		$queryy = "SELECT user_email FROM `wp_users` where ID = {$obj['instructor_id']}";	
		$owner_email = $wpdb->get_var($queryy);
		$to = $owner_email;	
		$txt = $obj['name']."<br>".$email_obj[8]->meta_value;
		if (stripos($to,'chimpchamp') !== false) {
    			mail($to,$subject,$txt,$headers);
		}
		//mail($to,$subject,$txt,$headers);
		$wpdb->update( 
		'wp_Instructors_Certification', 
		array( 
		'6_a_exp' => '1'	// integer (number) 
		), 
		array( 'id' => $obj['id'] ), 
		array( 
		'%d'	// value2
		), 
		array( '%d' ) 
				);
	}
	

	// After 12 MONTH After EXPIRY
	
	$subject = $email_obj[4]->meta_value;;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: TCHI<taichi@taichi.com>' . "\r\n";
	global $wpdb;	
	$queryy = "SELECT * FROM `wp_Instructors_Certification` where certification_expiry_date between  DATE_SUB(curdate(),INTERVAL 360 DAY) and DATE_SUB(curdate(),INTERVAL 351 DAY) and 12_a_exp = 0";
	$expired_cert_owners = $wpdb->get_results($queryy, ARRAY_A);
	foreach($expired_cert_owners as $obj)
	{
				
		$queryy = "SELECT user_email FROM `wp_users` where ID = {$obj['instructor_id']}";	
		$owner_email = $wpdb->get_var($queryy);
		$to = $owner_email;	
		$txt = $obj['name']."<br>".$email_obj[11]->meta_value;
		if (stripos($to,'chimpchamp') !== false) {
    			mail($to,$subject,$txt,$headers);
		}
		//mail($to,$subject,$txt,$headers);
		$wpdb->update( 
		'wp_Instructors_Certification', 
		array( 
		'12_a_exp' => '1'	// integer (number) 
		), 
		array( 'id' => $obj['id'] ), 
		array( 
		'%d'	// value2
		), 
		array( '%d' ) 
				);
	}
//------------------------------------------End NOtification of certifications
	require_once '/nas/wp/www/cluster-2265/taichi/wp-content/plugins/taichi-plugin/lib/taichi-segment-corn.php';	
	//wp_mail($to,$subject,$txt,$headers);
	//wp_mail('ittsel.ali@devsinc.com', 'Automatic email', 'Hello, this is an automatically scheduled email from WordPress.');

?>
