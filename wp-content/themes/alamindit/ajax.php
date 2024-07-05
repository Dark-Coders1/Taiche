<?php
     	require_once("../../../wp-load.php");

	
?>
<?php
$con=mysqli_connect("66.228.52.44","taichi","poF5P6nmZ5AbHhcUNVUd","wp_taichi");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();


}


$result = mysqli_query($con,"SELECT * FROM `Workshops` where start_of_workshop > '2010-00-00' and start_of_workshop < '2014-00-00'");
//echo "below suff";



$count = 0;

while($row = mysqli_fetch_array($result))
  {
$count++;
echo $count;
	
	$venue   = "'".strip_tags($row['location'])."'";
	$country  = "'".$row['country']."'";
	$city  = "'".$row['city']."'";
	$contact_phone   = "'".strip_tags($row['contact'])."'";
	$contact_email  = "'".$row['email']."'";
	$cost  = "'".strip_tags($row['cost'])."'";

	$new_post = array(
	'post_title'	=> $row['title'],
	'post_content'	=> $contact_phone.'<br>'.$contact_email.'<br>'.$cost.'<br>'.$country,//$post_title,
	'post_status'	=> 'publish', // Choose: publish, preview, future, etc.
	'post_type'		=> 'tribe_events', // Set the post type based on the IF is post_type X
	'post_author' => $row['master_trainer']
					);
	$new_post_id = wp_insert_post($new_post); // http://codex.wordpress.org/Function_Reference/wp_insert_post

	
	
	mysqli_query($con,"DELETE FROM Workshops WHERE  id = {$row['id']} ");
	$s_date  = "'".$row['start_of_workshop']." 5:30:00'";
	$e_date  = "'".$row['end_of_workshop']." 5:30:00'";
	

$new_post = array(
	'post_title'	=> $venue,
	'post_content'	=> '',//$post_title,
	'post_status'	=> 'publish', // Choose: publish, preview, future, etc.
	'post_type'		=> 'tribe_venue', // Set the post type based on the IF is post_type X
	'post_author' => $row['master_trainer']
					);
	$venu_post_id = wp_insert_post($new_post);



//echo "Start date : ". $row['start_of_workshop']."| end date : ". $row['end_of_workshop']."| venue : ".strip_tags($row['location']). "| Country :" . $row['country']. "| City :" . $row['city']."| contactphone : ".strip_tags($row['contact'])."| email : ". $row['email']."| Cost : ".strip_tags($row['cost']);
//	echo "<br>";
	mysqli_query($con,"INSERT INTO wp_postmeta (post_id , meta_key , meta_value) VALUES ($new_post_id ,'_EventEndDate' , $e_date)") or die(mysql_error());

mysqli_query($con,"INSERT INTO wp_postmeta (post_id , meta_key , meta_value) VALUES ($new_post_id ,'_EventVenueID' , $venu_post_id)") or die(mysql_error());

	mysqli_query($con,"INSERT INTO wp_postmeta (post_id , meta_key , meta_value) VALUES ($new_post_id ,'_EventStartDate' , $s_date)") or die(mysql_error());



    }

mysqli_close($con);

?>
