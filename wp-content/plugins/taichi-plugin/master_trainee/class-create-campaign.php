<?php
class Taichi_Create_Campaign
	{
		const POST_TYPE = 'taichi_email';
		
			public static function user_custom_email($_POST)
   			{
   				global $wpdb;
   				$current_user = get_current_user_id();
   				$post_id = wp_insert_post(array(
    	    	    							'post_title' => $_POST['post_title'],
    	    	    							'post_type' => self::POST_TYPE,
    	    	    							'post_status' => 'publish',
    	    	    							'author' => $current_user,            
    	    									)
   										);

   				$meta_attributes = array(
            							'select_segment',
            							'schedule_date',
            							'test_content'
        								);

   				foreach ($meta_attributes as $attribute) 
   				{
            		if (isset($post_id))
            		{
            		    add_post_meta($post_id, self::POST_TYPE . '_' . $attribute, $_POST[$attribute]);
            			$metaz_of_post[$attribute] =  get_post_meta($post_id, self::POST_TYPE . '_' . $attribute, true);		
            		}
        		}

        		/*if(!isset($_POST['schedule_date']))
        		{
        			$date = date('Y-m-d', strtotime(' +0 day'));
					$$metaz_of_post["schedule_date"] = date('Y-m-d 19:00:00', strtotime($date));
        			//$today = date("Y-m-d H:i:s");
        		    //echo "date null..........".$metaz_of_post["schedule_date"];
        		    //$metaz_of_post["schedule_date"] = $today;
        		    //echo "date after..........".$metaz_of_post["schedule_date"];
        		}*/


        		$metas_user = array(
                        			'api_key',
                        			'list_id',
                        			);          

        		foreach ($metas_user as $meta_user) 
            	{
            	    $metaz_of_user[$meta_user] =  get_user_meta(1, 'taichi_user_meta_'.$meta_user , true);
            	}

            	$mckey = $metaz_of_user['api_key'];
	    		$listid =  $metaz_of_user['list_id']; 
	    		$schedule_date = $metaz_of_post['schedule_date'];
	    		$content_of_email = $metaz_of_post['test_content'];
	    		$segment_id = $metaz_of_post['select_segment'];
	    		$MailChimp = new Mailchimp($mckey);
	    		$user_email = $user_segment_event = $wpdb->get_results("SELECT user_nicename,user_email FROM wp_users where ID='".$current_user."'" );
	    		// segment_op conditons
	    		
	    		if($_POST['select_segment'] == "All") // to send to all segments
	    		{
	    			//echo "in all";
	    			$user_segment_event = $wpdb->get_results("SELECT segment_ID,event_ID,event_Name FROM wp_segments INNER JOIN wp_posts ON wp_segments.event_ID = wp_posts.ID where post_author='".$current_user."'");// and event_Date > NOW()");
	    			//echo "pre";
	    			//print_r($user_segment_event);
					$counter_return = 0;
	    			for ($i=0; $i < count($user_segment_event); $i++) 
                	{ 
                		$conditions = array();
    					$conditions[] = array(
    											    'field' => 'static_segment',
    											    'op'    => 'eq',
    											    'value' => (string) $user_segment_event[$i]->segment_ID
    											);
    					$segment_options = array(	
        										'match'      => 'all',
        										'conditions' => $conditions
    											);
	
		    			echo "here i come for all";
		    			echo $_POST['schedule_date'];
	    				$campaign_id = $MailChimp->call('campaigns/create', array(
																					'apikey' =>$mckey ,
			 																		'type' =>"plaintext",
			 																		'options' => array('list_id' => $listid, 'subject' => $_POST['post_title'],'from_email' => 'jawad.firdous@gmail.com','from_name' => $user_email[0]->user_nicename),//$user_email[0]->user_email),
			 																		'content' => array('text' => $content_of_email),
			 																		'segment_opts' => $segment_options
																				)
															);
	    				if(empty($_POST['schedule_date']))
        				{
        					$campaign_send = $MailChimp->call('campaigns/send',array(
		    																		'apikey' => $mckey,
		    																		'cid' => $campaign_id['id']
		    																		)
        													);
        					if($campaign_send[complete] == 1)
        					{
        						$counter_return = $counter_return + 1;
        					}
        					// 			echo "campaign send";
        					// 			echo "<pre>";
		    				// print_r($campaign_send);
        				}
        				else // if date is set by user then schedule
        				{
		    				$campaign_schedule = $MailChimp->call('campaigns/schedule',array(
		    																				'apikey' => $mckey,
		    																				'cid' => $campaign_id['id'],
		    																				'schedule_time' => $schedule_date
		    																				)
		    													);
		    				if($campaign_schedule[complete] == 1)
        					{
        						$counter_return = $counter_return + 1;
        					}
		    				// echo "<pre>";
		    				// print_r($campaign_schedule);
		    			}
                		    
                	}

                	if(count($user_segment_event) == $counter_return)
                	{
                		return 1;
                	}
                	else
                	{
                		return 0;
                	}
	    		}
	    		else // send to only one segment
	    		{
	    			$conditions = array();
    				$conditions[] = array(
    										    'field' => 'static_segment',
    										    'op'    => 'eq',
    										    'value' => (string) $segment_id
    									);
    				$segment_options = array(
        									'match'      => 'all',
        									'conditions' => $conditions
    										);

	    			//echo "here i come";
	    			//echo $_POST['schedule_date'];
	    			$campaign_id = $MailChimp->call('campaigns/create', array(
																				'apikey' =>$mckey ,
			 																	'type' =>"plaintext",
			 																	'options' => array('list_id' => $listid, 'subject' => $_POST['post_title'],'from_email' => 'jawad.firdous@gmail.com','from_name' => $user_email[0]->user_nicename),//$user_email[0]->user_email),
			 																	'content' => array('text' => $content_of_email),
			 																	'segment_opts' => $segment_options
																				)
														);
	    			if(empty($_POST['schedule_date']))
        			{
        				$campaign_send = $MailChimp->call('campaigns/send',array(
		    																	'apikey' => $mckey,
		    																	'cid' => $campaign_id['id']
		    																	)
        												);
        				if($campaign_send[complete] == 1)
        				{
        					return 1;
        				}
        				else
        				{
        					return 0;
        				}
        				//echo "campaign send";
        				//echo "<pre>";
		    			// print_r($campaign_send);
        			}
        			else // if date is set by user then schedule
        			{
		    			$campaign_schedule = $MailChimp->call('campaigns/schedule',array(
		    																			'apikey' => $mckey,
		    																			'cid' => $campaign_id['id'],
		    																			'schedule_time' => $schedule_date
		    																			)
		    												);
		    			if($campaign_schedule[complete] == 1)
        				{
        					return 1;
        				}
        				else
        				{
        					return 0;
        				}
		    				// echo "<pre>";
		    				// print_r($campaign_schedule);
		    		}
	    		}//end else


   			}// function end
		
	}
?>