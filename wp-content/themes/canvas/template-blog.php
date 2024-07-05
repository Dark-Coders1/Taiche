<?php
/**
 * Template Name: Blog
 *
 * The blog page template displays the "blog-style" template on a sub-page. 
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options;
 
?>      
<?php
   
/* 


$con=mysqli_connect("localhost","clients_test","ittselali91","clients_wrdp8");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();


}

*/
//$result = mysqli_query($con,"SELECT * FROM wp_Workshops");


//echo $num = mysqli_num_rows($result);
//for ($i = 0 ; $i< $num ; $i++)
//{
  
//while($row = mysqli_fetch_array($result))
//{
/*$row = mysqli_fetch_array($result);
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


echo "Start date : ". $row['start_of_workshop']."| end date : ". $row['end_of_workshop']."| venue : ".strip_tags($row['location']). "| Country :" . $row['country']. "| City :" . $row['city']."| contactphone : ".strip_tags($row['contact'])."| email : ". $row['email']."| Cost : ".strip_tags($row['cost']);
//	echo "<br>";
	mysqli_query($con,"INSERT INTO wp_ai1ec_events (post_id , start , end, venue, country,city ,contact_phone,contact_email ,cost ) VALUES ($new_post_id ,$s_date , $e_date, $venue, $country, $city, $contact_phone ,$contact_email, $cost)") or die(mysql_error());

	mysqli_query($con,"INSERT INTO wp_ai1ec_event_instances (post_id , start , end) VALUES ($new_post_id ,$s_date , $e_date)") or die(mysql_error());

*/

//}
//}

//mysqli_close($con);
 ?>

<!-- #content Starts -->
  <?php woo_content_before(); ?>

    <div id="content" class="col-full">
    
      <div id="main-sidebar-container">    
    
            <!-- #main Starts -->
            <?php woo_main_before(); ?>

            <section id="main" class="col-left">
              
      <?php get_template_part( 'loop', 'blog' ); ?>
                    
            </section><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>
    
    </div><!-- /#main-sidebar-container -->         

    <?php get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
  <?php woo_content_after(); ?>
    

<?php get_footer(); ?>