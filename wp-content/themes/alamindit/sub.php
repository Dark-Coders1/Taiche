
<?php
echo "asd";
require_once 'inc/MCAPI.class.php';
require_once 'inc/config.inc.php'; //contains apikey

echo $_POST['Country'];
if(isset($_POST['FirstName'])&&isset($_POST['LastName'])&&isset($_POST['Email'])&&isset($_POST['Country']))
{
    echo "set";
$api = new MCAPI('51d5c0335ee784197874654ac0bb4caf-us7');

/** 
Note that if you are not passing merge_vars, you will still need to
pass a "blank" array. That should be either:
	$merge_vars = array('');
	   - or -
	$merge_vars = '';

Specifically, this will fail:
	$merge_vars = array();

Or pass the proper data as below...
*/

$my_email = $_POST['Email'];

// By default this sends a confirmation email - you will not see new members
// until the link contained in it is clicked!
if(isset($_POST['NewsletterUnsubscribed'])&&isset($_POST['UpcomingWorkshops']))
{
$merge_vars = array('FNAME'=>$_POST['FirstName'], 'LNAME'=>$_POST['LastName'], 'CON'=> $_POST['Country'], 'NEWS'=>"NewsletterUnsubscribed", 'UWORKS'=>"UpcomingWorkshops"
                    );

$retval = $api->listSubscribe( "20a25a79bd", $my_email, $merge_vars, 'html', false, true, true );}

elseif(isset($_POST['NewsletterUnsubscribed']))
{
$merge_vars = array('FNAME'=>$_POST['FirstName'], 'LNAME'=>$_POST['LastName'], 'CON'=> $_POST['Country'], 'NEWS'=>"NewsletterUnsubscribed" 
                    );

$retval = $api->listSubscribe( "20a25a79bd", $my_email, $merge_vars, 'html', false, true, true );}

elseif(isset($_POST['UpcomingWorkshops']))
{
$merge_vars = array('FNAME'=>$_POST['FirstName'], 'LNAME'=>$_POST['LastName'], 'CON'=> $_POST['Country'], 'UWORKS'=>"UpcomingWorkshops" 
                    );

$retval = $api->listSubscribe( "20a25a79bd", $my_email, $merge_vars, 'html', false, true, true );}

if ($api->errorCode){
	echo "Unable to load listSubscribe()!\n";
	echo "\tCode=".$api->errorCode."\n";
	echo "\tMsg=".$api->errorMessage."\n";
} else {
    echo "Returned: ".$retval."\n";
}
}
?>
<script>

    window.location.assign("http://taichi.wpengine.com/subscribe/")

</script>
