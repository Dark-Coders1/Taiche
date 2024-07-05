<?php
class taichi_segment 
{
	public static function create_segment()
	{
		echo " in create segment";
		global $wpdb;
		//include_once('cnn-plugin.php');
		$cons_tant = 'taichi_user_meta_';
		$user = 1;
		// Get api key
		$apikey = get_user_meta($user,$cons_tant.'api_key',true);
		//$apikey = "c35549c8398443bf6213dbdf54091dd9-us4";
		$api = new Mailchimp($apikey);
		
		// Get list ID
		$list_id = get_user_meta($user,$cons_tant.'list_id',true);
		//$list_id = "a3137276a2";
		//echo " get api and list id";
		
		 $curr_date_time = $wpdb->get_results('SELECT ID,post_title as post_name,post_date FROM wp_posts WHERE post_type="tribe_events" and  (post_date BETWEEN NOW() - INTERVAL 1 DAY and NOW() ) and post_status = "publish"');
		 //$curr_date_time = $wpdb->get_results('SELECT ID, Post_title as post_name,post_date FROM wp_posts WHERE post_type="tribe_events" and( post_date BETWEEN "2014-05-20" and "2014-05-21")');
		for ($i=0; $i < count($curr_date_time); $i++) {
			echo $hello = $curr_date_time[$i]->post_name.$curr_date_time[$i]->post_date;
			echo "<br>";
		}
		echo "=============================================";
		$length = count($curr_date_time);
	
		for ($i=0; $i < $length; $i++)
		{
			$segment_name = $curr_date_time[$i]->post_name;
			$vari = $curr_date_time[$i]->ID;
			$cons_tant = "_EventStartDate";
			echo "=================================<br>";
			echo $event_schedule_date = get_post_meta($vari,$cons_tant,true);
			echo "<br>";
			// adding segments to mail chimp
			$segment_id = $api->call('lists/static-segment-add',array(
																	'apikey' => $apikey ,
																	'id' => $list_id,
																	'name' => $event_schedule_date."-".$segment_name
																	)
									);
			// adding segment in to database
			
			$wpdb->insert('wp_segments',array(
											'segment_id' => $segment_id['id'],
											'event_ID' => $curr_date_time[$i]->ID,
											'event_Name' => $event_schedule_date."-".$curr_date_time[$i]->post_name,
											'event_Date' => $event_schedule_date
											)
						);

			$email = array();
			$first_name = array();

			$event_key = '_tribe_wooticket_for_event';
			echo $post_id = $curr_date_time[$i]->ID;	
			echo "<br>";
			$attendees = new  TribeWooTickets();
			$attendees = $attendees->get_att($post_id);
			$length_array = count($attendees);
			for ($j=0; $j < $length_array ; $j++) 
			{ 
				$email[] = $attendees[$j]['purchaser_email'];
				echo $attendees[$j]['purchaser_email'];
				$first_name[] = $attendees[$j]['purchaser_name'];
			}
			
			$length_array = count($email);
			// list subscribtion of users			
			for ($j=0; $j < $length_array; $j++) 
			{ 
				$api->call('lists/subscribe', array(
														'id' => $list_id ,
														'email' => array('email' => $email[$j] ) ,
														'merge_vars' => array('FNAME' => $first_name[$j]),
														'email_type' => 'html',
														'double_optin' => false,
														'update_existing' => true,
														'replace_interests' => true,
														'send_welcome' => false
													)
							);
				
			}
			// adding users to segments
			$api_1_3 = new MCAPI($apikey);
			if(!empty($email))
			{
				$return = $api_1_3->listStaticSegmentMembersAdd($list_id, $segment_id['id'], $email);
				echo $api_1_3->errorMessage;
			}
			
			
		}// for loop end
		
	}// Function end
	public static function update_segment()
	{
		echo " in update segment";
		// constants
		global $wpdb;
		$cons_tant = 'taichi_user_meta_';
		$user = 1;
		//get apikey
		$apikey = get_user_meta($user,$cons_tant.'api_key',true);
		//get list ID
		$list_id = get_user_meta($user,$cons_tant.'list_id',true);
		$api = new Mailchimp($apikey);
		///////////////////////////////////////////
		$event_pick = $wpdb->get_results('SELECT * FROM wp_segments WHERE event_Date > NOW()');
		if(!empty($event_pick))
		{
			$length_of_array = count($event_pick);
			for ($i=0; $i < $length_of_array; $i++)
			{ 				
				$event_ID_update = $event_pick[$i]->event_ID;
				$segment_id_update = $event_pick[$i]->segment_ID;

				$email = array();
				$first_name = array();
				$event_key = '_tribe_wooticket_for_event';
				$post_id = $event_ID_update;
				$attendees = new  TribeWooTickets();
				$attendees = $attendees->get_att($post_id);
				$length_array = count($attendees);
				for ($j=0; $j < $length_array ; $j++) 
				{ 
					$email[] = $attendees[$j]['purchaser_email'];
					$first_name[] = $attendees[$j]['purchaser_name'];
				}

				// list subscribe
				$length_array = count($email);
				// list subscribtion of users			
				for ($j=0; $j < $length_array; $j++) 
				{ 
					$api->call('lists/subscribe', array(
															'id' => $list_id ,
															'email' => array('email' => $email[$j] ) ,
															'merge_vars' => array('FNAME' => $first_name[$j]),
															'email_type' => 'html',
															'double_optin' => false,
															'update_existing' => true,
															'replace_interests' => true,
															'send_welcome' => false
														)
								);
					
				}
				// adding users to segments
				$api_1_3 = new MCAPI($apikey);
				if(!empty($email))
				{
					$return = $api_1_3->listStaticSegmentMembersAdd($list_id, $segment_id_update, $email);
					echo $api_1_3->errorMessage;
				}
			}// for loop end

		}// if end
	}// function end
}// class end
?>
