<?php
     	
	
?>
<!-- <div tabindex="0" aria-label="Main content" id="wpbody-content">
    <div class="wrap"> -->

<style>

table tr td, table th {
padding: 2px;
background: none repeat scroll 0 0 #E4E4E4;
}
</style>

<?php
	global $wpdb;
	
	
	
	if(isset($_POST['post_title_6_bef'])&&isset($_POST['test_content_6_bef']))
	{ 
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => ''.$_POST['post_title_6_bef'],	// string
		), 
		array( 'meta_key' => '6_month_before_sub' ), 
		array( 
			'%s',	// value1	
		), 
		array( '%s' ) 
		);
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => $_POST['test_content_6_bef'],	// string	 
		), 
		array( 'meta_key' => '6_month_before_body' ), 
		array( 
			'%s',	// value1
		), 
		array( '%s' ) 
		);   	   		
		
   	}
	if(isset($_POST['post_title_3_bef'])&&isset($_POST['test_content_3_bef']))
	{ 
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => ''.$_POST['post_title_3_bef'],	// string
		), 
		array( 'meta_key' => '3_month_before_sub' ), 
		array( 
			'%s',	// value1	
		), 
		array( '%s' ) 
		);
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => $_POST['test_content_3_bef'],	// string	 
		), 
		array( 'meta_key' => '3_month_before_body' ), 
		array( 
			'%s',	// value1
		), 
		array( '%s' ) 
		);   	   		
   		
   	}
	if(isset($_POST['post_title_aftr'])&&isset($_POST['test_content_aftr']))
	{ 
  		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => ''.$_POST['post_title_aftr'],	// string
		), 
		array( 'meta_key' => 'after_expiry_sub' ), 
		array( 
			'%s',	// value1	
		), 
		array( '%s' ) 
		);
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => $_POST['test_content_aftr'],	// string	 
		), 
		array( 'meta_key' => 'after_expiry_body' ), 
		array( 
			'%s',	// value1
		), 
		array( '%s' ) 
		);   	   		 		
		
   	}	
	if(isset($_POST['post_title_6_aftr'])&&isset($_POST['test_content_6_aftr']))
	{ 
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => ''.$_POST['post_title_6_aftr'],	// string
		), 
		array( 'meta_key' => '6_month_after_expiry_sub' ), 
		array( 
			'%s',	// value1	
		), 
		array( '%s' ) 
		);
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => $_POST['test_content_6_aftr'],	// string	 
		), 
		array( 'meta_key' => '6_month_after_expiry_body' ), 
		array( 
			'%s',	// value1
		), 
		array( '%s' ) 
		);
   		
   	}
	if(isset($_POST['post_title_3_aftr'])&&isset($_POST['test_content_3_aftr']))
	{ 
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => ''.$_POST['post_title_3_aftr'],	// string
		), 
		array( 'meta_key' => '3_month_after_expiry_sub' ), 
		array( 
			'%s',	// value1	
		), 
		array( '%s' ) 
		);
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => $_POST['test_content_3_aftr'],	// string	 
		), 
		array( 'meta_key' => '3_month_after_expiry_body' ), 
		array( 
			'%s',	// value1
		), 
		array( '%s' ) 
		);   		
		
   	}
	if(isset($_POST['post_title_12_aftr'])&&isset($_POST['test_content_12_aftr']))
	{ 
   		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => ''.$_POST['post_title_12_aftr'],	// string
		), 
		array( 'meta_key' => '12_month_after_expiry_sub' ), 
		array( 
			'%s',	// value1	
		), 
		array( '%s' ) 
		);
		$wpdb->update( 
		'wp_expiry_email', 
		array( 
			'meta_value' => $_POST['test_content_12_aftr'],	// string	 
		), 
		array( 'meta_key' => '12_month_after_expiry_body' ), 
		array( 
			'%s',	// value1
		), 
		array( '%s' ) 
		);   			
		
   	}
$email_obj = $wpdb->get_results("SELECT * FROM `wp_expiry_email`");					
?>

	<form method="POST" name="taichi-email-editor-new" id="taichi-email-editor-new" action="">
    
<table>
    <!-- <thead><th colspan="2" scope="col" class="manage-column column-title"><strong>Email Editor</strong></th></thead> -->
    <tbody>
  <tr><td>
           <h1>6 months before certification expiry email</h1></td>
        </tr>
      <tr>
            <th><label for="post_title_6_bef">Email Subject</label></th>
            <td><input type="text" value = "<?php echo $email_obj[0]->meta_value ?>" size="100" name="post_title_6_bef" id="post_title"></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>
    
    <textarea rows="8" cols="50" type = "text"  name = "test_content_6_bef" ><?php echo $email_obj[3]->meta_value ?></textarea>
               

            </td>
        </tr>
  <tr><td>
           <h1>3 months before certification expiry email</h1></td>
        </tr>

       <tr>
            <th><label for="post_title_3_bef">Email Subject</label></th>
            <td><input type="text" value = "<?php echo $email_obj[1]->meta_value ?>" size="100" name="post_title_3_bef" id="post_title"></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>
               
    <textarea rows="8" cols="50" type = "text"  name = "test_content_3_bef" ><?php echo $email_obj[2]->meta_value ?></textarea>
            </td>
        </tr>
  <tr><td>
           <h1>After certification expiry email</h1></td>
        </tr>

  <tr>
            <th><label for="post_title_aftr">Email Subject</label></th>
            <td><input type="text" value = "<?php echo $email_obj[4]->meta_value ?>" size="100" name="post_title_aftr" id="post_title"></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>
               
    <textarea rows="8" cols="50" type = "text"  name = "test_content_aftr" ><?php echo $email_obj[5]->meta_value ?></textarea>
            </td>
        </tr>
  <tr><td>
           <h1>3 months after certification expiry email</h1></td>
        </tr>

  <tr>
            <th><label for="post_title_3_aftr">Email Subject</label></th>
            <td><input type="text" value = "<?php echo $email_obj[6]->meta_value ?>" size="100" name="post_title_3_aftr" id="post_title"></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>
               
    <textarea rows="8" cols="50" type = "text"  name = "test_content_3_aftr" ><?php echo $email_obj[7]->meta_value ?></textarea>
            </td>
        </tr>
  <tr><td>
           <h1>6 months after certification expiry email</h1></td>
        </tr>

  <tr>
            <th><label for="post_title_6_aftr">Email Subject</label></th>
            <td><input type="text" value = "<?php echo $email_obj[9]->meta_value ?>" size="100" name="post_title_6_aftr" id="post_title"></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>
               
    <textarea rows="8" cols="50" type = "text"  name = "test_content_6_aftr" ><?php echo $email_obj[8]->meta_value ?></textarea>
            </td>
        </tr>
  <tr><td>
           <h1>12 months after certification expiry email</h1></td>
        </tr>

  <tr>
            <th><label for="post_title_12_aftr">Email Subject</label></th>
            <td><input type="text" value = "<?php echo $email_obj[10]->meta_value ?>" size="100" name="post_title_12_aftr" id="post_title"></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>
               
    <textarea rows="8" cols="50" type = "text"  name = "test_content_12_aftr" ><?php echo $email_obj[11]->meta_value ?></textarea>
            </td>
        </tr>
        <tr> 
            <td>&nbsp;</td>
                <td><input type="Submit" class="button" name="submit_form" id="submit_form" Value="Send"></td>
        </tr>
    </tbody>
    </table>
</form>
