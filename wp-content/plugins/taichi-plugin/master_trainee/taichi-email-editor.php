<!-- <div tabindex="0" aria-label="Main content" id="wpbody-content">
    <div class="wrap"> -->
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#schedule_date").datepicker({ dateFormat: 'yy-mm-dd' });

        jQuery('#submit_form').click(function()
        {
            var today_date = new Date();
            var scheduleDate = jQuery('#schedule_date').datepicker('getDate');
                if( (!scheduleDate) || (scheduleDate > today_date) )
                {
                    jQuery("#taichi-email-editor-new").append(' <input type="hidden" value="create_and_push" name="create_and_push" id="create_and_push">');
                    jQuery('#taichi-email-editor-new').submit();
                }
                else
                {
                    window.alert("Schedlue date can't be less than or equal to Today date!");
                }
        });
    });
</script>
<h1>Taichi Email Editor</h1>
<?php
	global $wpdb;
	$cons_tant = 'taichi_user_meta_';
	$user = 1;
	// Get api key
	$apikey = get_user_meta($user,$cons_tant.'api_key',true);
	$api = new Mailchimp($apikey);
	// Get list ID
	$list_id = get_user_meta($user,$cons_tant.'list_id',true);	
	$user_id = get_current_user_id();
	$user_segment_event = $wpdb->get_results("SELECT segment_ID,event_ID,event_Name FROM wp_segments  INNER JOIN wp_posts ON wp_segments.event_ID = wp_posts.ID where post_author='".$user_id."' ORDER BY wp_segments.event_Date DESC");
	if(isset($_POST['create_and_push']))
	{ 
   		$return_value = Taichi_Create_Campaign::user_custom_email($_POST);
   		if($return_value == 1)
   		{
            echo "<script type='text/javascript'>alert('Email Send/Schedule Sucessfully');</script>";
   		}
   	}	
?>
	<form method="POST" name="taichi-email-editor-new" id="taichi-email-editor-new" action="<?php echo admin_url('admin.php?page=taichi-email-editor'); ?>">
    <table>
    <!-- <thead><th colspan="2" scope="col" class="manage-column column-title"><strong>Email Editor</strong></th></thead> -->
    <tbody>
    	<tr>
            <th><label for="post_title">Email Subject</label></th>
            <td><input type="text" size="100" name="post_title" id="post_title"></td>
        </tr>
        <tr>
            <th><label for="list_id">Select Segment</label></th>
            <td >
                <select class="dropdown" id="select_segment" name="select_segment">
                	<option value="All">All</option>
                	<?php
                	for ($i=0; $i < count($user_segment_event); $i++) 
                		{ 
                		    echo '<option value="' . $user_segment_event[$i]->segment_ID. '">' . $user_segment_event[$i]->event_Name . '</option>';  
                		}
                	?>
            	</select>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
               <?php wp_editor( '', 'none', $settings = array('textarea_name'=>'test_content','textarea_rows'=>20) ); ?>

            </td>
        </tr>
        <tr>
            <th><label for="schedule_date">Schedule</label></th>
            <td><input type="text" name="schedule_date" id="schedule_date" /></td>
        </tr>
        <tr> 
        		<td>&nbsp;</td>
                <td><input type="Submit" class="button" name="submit_form" id="submit_form" Value="Send"></td>
       	</tr>
    </tbody>
    </table>
</form>

