<?php
error_reporting(true);
/**
This Example shows how to test a List Segment for use with a new campaign 
via the MCAPI class.
**/
require_once 'inc/MCAPI.class.php';
$user      = "taichi";
	$password   = "poF5P6nmZ5AbHhcUNVUd";
	$db         = "wp_taichi";
	$server     = "127.0.0.1";

$apikey = "51d5c0335ee784197874654ac0bb4caf-us7";
$api = new MCAPI($apikey);

$result = mysqli_query($con,"SELECT distinct(meta_value) as country FROM `wp_usermeta` where meta_key = 'country'");

while($row = mysqli_fetch_array($result)) {
  echo $row['country'];
  echo "<br>";
}
echo "hello";


//$retval = $api->listAddStaticSegment("5da4bab97a", "ameraszica");

$con=mysqli_connect($server,$user,$password,$db);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con,"INSERT INTO wp_subscribe_segments(seg_id, seg_name) VALUES (12,'asd')");



mysqli_close($con);

if ($api->errorCode){
	echo "Unable to Segment Campaign!";
	echo "\n\tCode=".$api->errorCode;
	echo "\n\tMsg=".$api->errorMessage."\n";
} else {
	echo "Your Segement matched [".$retval."] members.\n";
}

?>
