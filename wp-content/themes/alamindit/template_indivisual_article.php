<?php
/**
 * Template Name: Ind_Article
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

$con=mysqli_connect("localhost","clients_test","ittselali91","clients_wrdp8");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();


  }

$result = mysqli_query($con,"SELECT * FROM wp_articles WHERE articleid=".$_GET['id']);



echo "<b>Tai Chi</b>";

while($row = mysqli_fetch_array($result))
  {
		echo "<br>";
		echo $row['title'];
		echo "<br>";
    echo $row['realauthor'];
    echo "<br>";
    echo $row['summary'];
    echo "<br>";
    echo $row['article'];
	
	
  }

mysqli_close($con);//


?>

<?php get_footer(); 
?>