<?php
//include('mailchimp-settings/miniMCAPI.class.php');
if(isset($_GET['code'])){
        //ECHO $_GET['code'];
            if (isset($_GET['error']) ){
                    echo '<h2>Complete Failure!: '.$_GET['error']; ?>
                    <a href="<?=$client->getLoginUri()?>">Try Again?</a>
             <?php } else {
                    $session = $client->getSession();
    // session retrieved
    // now checking if session not exists                    
 if (!$session){?> 
        <h2>Hrm, we received an auth code: <?=$_GET['code']?>, but were unable to retrieve the access token</h2>
        <br/>
       <a href="<?=$client->getLoginUri()?>">Try Again?</a>
    <?php } else {  // if session exists then ?>
        <?php  //print_r($session,true)
            $rest = new MC_RestClient($session);
            $data = $rest->getMetadata();
        ?>
<?php //$data['api_endpoint'] $session['access_token'] $data['dc'] print_r($data,true) 
    $apikey = $session['access_token'].'-'.$data['dc'];  // api key
    echo $apikey;
    $api = new MCAPI($apikey);
    $api->useSecure(true);
    //$lists = $api->lists('', 0, 5);
?>
    <!-- <a href="<?=$client->getLoginUri()?>">Try Again?</a> -->
    <?php
             } // else of if not session

            } // else of get error if
    } // if code exists   

$user = get_current_user_id();
$con_stant = 'taichi_user_meta_';
if(isset($apikey)){  update_user_meta($user, $con_stant.'api_key',$apikey); 
update_user_meta($user, $con_stant.'api_key',$apikey);?>
<p><strong>Your Mailchimp Key is Retrieved</strong> </p>
<Br><a href="<?php echo admin_url('admin.php?page=taichi-newsletter') ?>"> Click Here to Go Your Page</a><?php

}

//$apikey = $user_api_key ; 

?> 