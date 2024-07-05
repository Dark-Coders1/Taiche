<?php

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




$result = mysqli_query($con,"SELECT post_content FROM `wp_posts` WHERE post_type = 'tribe_events' and post_status = 'publish' ");





while($row = mysqli_fetch_array($result))
  {

//echo $row['post_content'];
echo "<br>";
       

$arr = array("blue","red","green","yellow");
//print_r(str_replace("www.taichiforhealthinstitute.org/workshops/calendar/individual_workshop.php?id=","#",$row['post_content']));
//echo "Replacements: $i";

//$str = preg_replace('taichiforhealthinstitute.org/workshops/calendar/individual_workshop.php?id=', '#', $row['post_content']);
$a = "Foo moo boo tool foo";
    $b = preg_replace("/http:\/\/www.taichiforhealthinstitute.org\/workshops\/calendar\/individual_workshop.php\?id=?([0-9][0-9][0-9][0-9][0-9])[#]/", "#", $row['post_content']);
    print $b;
// This will be 'foo o' now
//echo $str;
  }

mysqli_close($con);//

?>
