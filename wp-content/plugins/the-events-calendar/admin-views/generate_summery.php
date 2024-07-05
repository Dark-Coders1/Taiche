	<?php

	$display = "<h2>Summery Report</h2>";
	require_once("../../../../wp-load.php");
	$post_id = $_GET['post'];	
	$event = get_post($post_id);
		$event_start_date = get_post_meta($post_id,'_EventStartDate', true);
		$master_frstname = get_user_meta($event->post_author,'first_name',true);
		$master_lstname = get_user_meta($event->post_author,'last_name',true);
		$fullname_master = $master_frstname." ".$master_lstname;

	$attendees = new  TribeWooTickets();
   	$attendees = $attendees->get_att( $post_id );
	
	global $wpdb;
	
	$display .= '<div style = "background: #eee;">';
	$display .= '<h3>Event Title: '.$event->post_title.'<h3>';
	$display .= '<h4>Start Date: '.$event_start_date.'<h4>';
	$display .= '<h4>Organizer: '.$fullname_master.'<h4>';
	$display .= '<table style=" background: #C0C0C0; margin:0 auto;width:300px;border:1px solid black;border-collapse:collapse">
		<tr>
				  <th style="padding:15px;border:1px solid black;border-collapse:collapse">Attendee</th>
				  <th style="padding:15px;border:1px solid black;border-collapse:collapse">Certificate No.</th> 
		</tr>';	
	
	$total_attendees = 0;
	foreach($attendees as $attendee)
		{
		
		
		$email = trim($attendee['purchaser_email']);
		
		$user = get_user_by( 'email', $email );
		$attendee_frstname = get_user_meta($user->ID,'first_name',true);
		$attendee_lstname = get_user_meta($user->ID,'last_name',true);
		$fullname_attendee = $attendee_frstname." ".$attendee_lstname;
		
		if($fullname_attendee == null || $fullname_attendee == " " )
		continue; 
		$total_attendees++;
		$attendee_certificates = $wpdb->get_results("select GROUP_CONCAT(certificate_number ) as certs_number from wp_Instructors_Certification where Instructor_id = {$user->ID} and event_id = $post_id");	
		
		
			$display .= '<tr>
				  <td style="padding:15px;border:1px solid black;border-collapse:collapse">'.$fullname_attendee.'</td>
				  <td style="padding:15px;border:1px solid black;border-collapse:collapse">'.$attendee_certificates[0]->certs_number.'</td> 
				</tr>';
		
		
		}
		
		$display .= '</table>
		<br>
		<h4 style="text-align:center;"> Total number of Attendees </h4> 
		<div style="text-align:center;">'.$total_attendees.'</div>
		</div>';
		echo $display;
		
		$subject = $event->post_title."(".$event_start_date.")"." By ".$fullname_master;
		$txt = $display;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers

		$headers .= 'From: Taichi<taichi@taichi.com>' . "\r\n";


		if($display != null)
		mail("riaz@chimpchamp.com",$subject,$txt,$headers);
		?>
