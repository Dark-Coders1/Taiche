<?php
// Create connection

	$user      = "taichi";
	$password   = "poF5P6nmZ5AbHhcUNVUd";
	$db         = "wp_taichi";
	$server     = "127.0.0.1";

$con=mysqli_connect($server,$user,$password,$db);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();


  }


$result = mysqli_query($con,"SELECT wp_Instructors.* ,  GROUP_CONCAT( DISTINCT wp_Workshop_Types.title, ', ') as certid FROM wp_Instructors_Certification
				right JOIN wp_Instructors
				ON wp_Instructors_Certification.instructor_id = wp_Instructors.id
				left JOIN wp_Workshop_Types
                                ON  wp_Instructors_Certification.certification_id = wp_Workshop_Types.id and wp_Instructors_Certification.certification_expiry_date > NOW() 
                                
				group by wp_Instructors.id");





while($row = mysqli_fetch_array($result))
  {


        echo "<br><br><br><br>";
	//$certs_string;
	echo $id = $row['id'];
	mysqli_query($con,"DELETE FROM wp_Instructors WHERE  id = $id ");
	echo $certs_string ="'".$row['certid']."'";
	$f_name  = "'".$row['first_name']."'";
	$l_name  = "'".$row['last_name']."'";
	$email  = "'".$row['email']."'";
	$password = '123456';
	$description  = "'".$row['instructor_profile']."'";
	$school  = "'".$row['school']."'";
	$postcode  = "'".$row['postcode']."'";
	$phone  = "'".$row['phone']."'";
	$class_information  = "'".$row['class_information']."'";
	$other  = "'".$row['other']."'";
	$other_location  = "'".$row['other_location']."'";
	$cost  = "'".$row['cost']."'";
	$messages  = "'".$row['messages']."'";
	$recent_news  = "'".$row['recent_news']."'";
	$cap = 'a:1:{s:21:"ai1ec_event_assistant";b:1;}';
	$cap1 = "'".$cap."'" ;
	$picture = $row['picture'];
	$base64 = base64_encode($picture);
	echo $state = "'".$row['state']."'";
	echo $country = "'".$row['country']."'";
	echo $suburb = "'".$row['suburb']."'";
      // echo $pic_src = '<img src="data:image/jpeg;base64,'.$base64.'" />';


$url = 'http://taichi.wpengine.com/wp-content/uploads/upme/cropped-'.$id.'_d.jpg';
echo $url = "'".$url."'";
file_put_contents('wp-content/uploads/upme/cropped-'.$id.'_d.jpg', $picture);?>
	 

<?php
//////////////////////////////////////////////////////////////////////////////////////echo "First name : ". $row['first_name']."| Last name : ". $row['last_name']. "| email :" . $row['email']. "| Description :" . $row['instructor_profile'];

//mysqli_query($con,"INSERT INTO wp_users (id ,user_login, user_pass, user_nicename, user_email, user_registered, user_status, display_name) VALUES ($id, $f_name, MD5($password), $f_name, $email, '2011-06-07 00:00:00','0', $f_name)") or die(mysql_error());




	//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'first_name', $f_name)") or die(mysql_error());

	//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'last_name', $l_name)") or die(mysql_error());

	$description = preg_replace("/[']/", "", $description);
 	$certs_string = preg_replace("/[']/", "", $certs_string);

	//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'description',  '$description')") or die(mysql_error());

	//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'state', $state)") or die(mysql_error());


	//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'country', $country)") or die(mysql_error());

	//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'suburb', $suburb)") or die(mysql_error());

//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'postcode', $postcode)") or die(mysql_error());

//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'phone', $phone)") or die(mysql_error());

//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'class_information', $class_information)") or die(mysql_error());

//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'other', $other)") or die(mysql_error());

//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'other_location', $other_location)") or die(mysql_error());

//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'cost', $cost)") or die(mysql_error());

//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'messages', $messages)") or die(mysql_error());

//mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'recent_news', $recent_news)") or die(mysql_error());


mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'certification', '$certs_string')") or die(mysql_error());

if ($picture != null)	
mysqli_query($con,"INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ($id, 'user_pic', $url)") or die(mysql_error());	

	

	echo "row inserted";

	echo "<br>";


  }

mysqli_close($con);//





/*$string = "9:30am to 2:70am";
preg_match_all('/([0-9:.]+|[a-zA-Z]+)/',$string,$matches);
print_r($matches);
for($i=0  ;$i<4 ; $i++)
{
$s = $matches[0][$i];

if (preg_match('/[0-9:.]/', substr($s,strlen(3)), $l, PREG_OFFSET_CAPTURE))
{echo $matches[0][$i]; }
}
*/


/*


$con=mysqli_connect("localhost","clients_test","ittselali91","clients_wrdp8");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();


}


$result = mysqli_query($con,"SELECT * FROM wp_Workshops");
//echo "below suff";





while($row = mysqli_fetch_array($result))
  {

	$new_post = array(
	'post_title'	=> $row['title'],
	'post_content'	=> '',//$post_title,
	'post_status'	=> 'publish', // Choose: publish, preview, future, etc.
	'post_type'		=> 'ai1ec_event', // Set the post type based on the IF is post_type X
	'post_author' => 1
					);
	$new_post_id = wp_insert_post($new_post); // http://codex.wordpress.org/Function_Reference/wp_insert_post


	$s_date  = "'".$row['start_of_workshop']." 5:30:00'";
	$e_date  = "'".$row['end_of_workshop']." 5:30:00'";
	$venue   = "'".strip_tags($row['location'])."'";
	$country  = "'".$row['country']."'";
	$city  = "'".$row['city']."'";
	$contact_phone   = "'".strip_tags($row['contact'])."'";
	$contact_email  = "'".$row['email']."'";
	$cost  = "'".strip_tags($row['cost'])."'";


//echo "Start date : ". $row['start_of_workshop']."| end date : ". $row['end_of_workshop']."| venue : ".strip_tags($row['location']). "| Country :" . $row['country']. "| City :" . $row['city']."| contactphone : ".strip_tags($row['contact'])."| email : ". $row['email']."| Cost : ".strip_tags($row['cost']);
//	echo "<br>";
	mysqli_query($con,"INSERT INTO wp_ai1ec_events (post_id , start , end, venue, country,city ,contact_phone,contact_email ,cost ) VALUES ($new_post_id ,$s_date , $e_date, $venue, $country, $city, $contact_phone ,$contact_email, $cost)") or die(mysql_error());

	mysqli_query($con,"INSERT INTO wp_ai1ec_event_instances (post_id , start , end) VALUES ($new_post_id ,$s_date , $e_date)") or die(mysql_error());



    }

mysqli_close($con);

*/
?>
