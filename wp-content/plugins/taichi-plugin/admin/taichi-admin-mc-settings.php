
<div tabindex="0" aria-label="Main content" id="wpbody-content">
    <div class="wrap">
         <h1>Tai Chi for Health Institute </h1>
<?php
//require_once('cnn-user-class.php'); 
require_once('mailchimp-settings/MC_OAuth2Client.php'); 
require_once('mailchimp-settings/MC_RestClient.php');
//require_once('mailchimp-settings/miniMCAPI.class.php');
//include('Mailchimp.php');
//require_once('miniMCAPI.class.php');
$client = new MC_OAuth2Client();?>
<?php 
// values
global $current_user;
$user = $current_user->ID ; 
if(empty($user)) { $user = get_current_user_id(); }
$con_stant  = 'taichi_user_meta_';
$meta_attributes = array(
            'api_key',
            'list_id',
            'template_id'
        );
// end of values
?>
<script type="text/javascript">
      jQuery(document).ready(function() {
        jQuery('#disconnect_form').click(function(){
            jQuery("#edit_newsletter").append(' <input type="hidden" value="DISCONNECT_USER_META" name="DISCONNECT_USER_META" id="DISCONNECT_USER_META">');
            jQuery('#edit_newsletter').submit();
        }); 

        jQuery('#submit_form').click(function(){
            jQuery("#edit_newsletter").append(' <input type="hidden" value="SUBMIT_USER_META" name="SUBMIT_USER_META" id="SUBMIT_USER_META">');
            jQuery('#edit_newsletter').submit();
        }); 
        
    });
</script>

<?php
// start of submit
if(isset($_POST['SUBMIT_USER_META'])) {
    foreach ($meta_attributes as $attribute) { update_user_meta($user, $con_stant.$attribute,$_POST[$attribute]); } 
    //echo 'sdfasdf';
} 
// end of submit values

// start of Disconnect mailchimp account
if(isset($_POST['DISCONNECT_USER_META'])){
  foreach ($meta_attributes as $attribute) { update_user_meta($user, $con_stant.$attribute,""); } 
}

//end of mailchimp disconnect
 
foreach ($meta_attributes as $attribute)  
    { 
     $user_meta_array[$attribute] = get_user_meta($user, $con_stant.$attribute, true); 
    } 
// end of get values
$user_api_key = get_user_meta($user, $con_stant.'api_key', true); 
   
   if(empty($user_api_key) && !$_GET['code']) { ?> 
          <p>  You have not connected your mailchimp account with us<br></p>
          <p> <a class="button" href="<?= $client->getLoginUri(); ?>">Connect to Mailchimp</a></p>

   <?php  } elseif($_GET['code'] && empty($user_api_key) )
                  { require_once('update_admin_api_key.php'); 
                  echo "update_api_key";
                 wp_redirect(admin_url('admin.php?page=taichi-admin-mc-settings')); exit;
                 ob_end_flush();
   } else {
?>
        <!-- <p>
            <a href="<?= $client->getLoginUri(); ?>">AUTHORIZE from MAIL CHIMP</a>
        </p> -->
        <!-- start of mc api and user metaz -->
<?php 
 if(isset($_GET['code']))
 {
    if (isset($_GET['error']) )
    {
            echo '<h2>Complete Failure!: '.$_GET['error']; ?>
            <a class="button" href="<?=$client->getLoginUri()?>">Try Again?</a>
     <?php
     } else 
     {
            $session = $client->getSession(); 
             // session retrieved
             if (!$session){  // now checking if session not exists      ?> 
                    <h4>We received an auth code: <?=$_GET['code']?>, but were unable to retrieve the access token</h4>
                    <br/>
                    <a class="button" href="<?=$client->getLoginUri()?>">Try Again?</a>
                      <?php }  
              else {  //echo "jawad";// if session exists then     // print_r($session,true) 
                          $rest = new MC_RestClient($session);  
                          $data = $rest->getMetadata();
                          $apikey_new = $session['access_token'].'-'.$data['dc'];  // apic key
                          //echo $apikey_new;
                    } // else of if not session
      } // else of get error if
  } // if code exists   //print_r($data,true)  $data['api_endpoint']   $session['access_token']    $data['dc']
   
     
     $user_api_key;
     $apikey = $user_api_key;
      $api = new MCAPI($apikey);              
              //$file_content =  file_get_contents( './templates/food_thearpy/index.html', true );
      $api->useSecure(true);
            
    ?>

    <form method="POST" name="edit_newsletter" id="edit_newsletter" action="<?php echo admin_url('admin.php?page=taichi-admin-mc-settings'); ?>">
        <table class="wp-list-table widefat  posts">
          <thead><th colspan="2" scope="col" class="manage-column column-title"><strong>Mailchimp Settings</strong></th></thead>
          <tbody>
            <?php $api_key_value = get_user_meta(get_current_user_id(),"taichi_user_meta_api_key");
                 if( isset($api_key_value) && !empty($api_key_value))
                 {
                  ?>
                  <script type="text/javascript">
                        jQuery(document).ready(function($){ 
                         $('#hide_apikey').hide();
                         $('#hide_template').hide();
                       });
                  </script>
                  <tr>
                    <td></td>
                    <td colspan="2"><input type="Submit" class="button" name="disconnect_form" id="disconnect_form" Value="Disconnect"></td>
                  </tr>
            <?php } ?>
            <tr id="hide_apikey">
                <th><label for="api_key'">Api Key</label></th>
                <td>
                    <input type="hidden" name="api_key" id="api_key" value="<?php echo $user_meta_array['api_key'];?>">
                    <a class="button" href="<?=$client->getLoginUri()?>">Connect to Mailchimp</a>
                </td>
            </tr>
         
            <tr>
                <th><label for="list_id">List Name</label></th>
                <td>
                    <select class="dropdown" id="list_id" name="list_id">
                        <?php $lists = $api->lists();
                        foreach($lists['data'] as $list){ ?>
                                <option value="<?php echo $list['id']; ?>" <?php if($list['id'] == $user_meta_array['list_id']){ echo 'selected';} ?> ><?php echo $list['name']; ?></option>
                        <?php } ?>
                        
                    </select>
                </td>

            </tr>
            <tr id='hide_template'>
                <th><label for="template_id">Template</label></th>
                <td>
                    <select class="dropdown" id="template_id" name="template_id">
                         <?php $template = $api->templates(); $count = count($template); 
                        foreach($template['user'] as $template ){ ?>
                                <option value="<?php echo $template['id']; ?>" <?php if($template['id'] == $user_meta_array['template_id']){ echo 'selected';} ?> ><?php echo $template['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr> 
                <td></td>
                <td><input type="Submit" class="button" name="submit_form" id="submit_form" Value="Save Settings"></td>
            </tr> 
         </tbody>
      </table>
    </form>

<?php } // end of if api key else ?>