<?php
/**
 * Template Name: Article
 *
 * The blog page template displays the "blog-style" template on a sub-page. 
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options;
 
?>      
<?php woo_content_before();  ?>
    <div id="content" class="col-full">
    
    	<div id="main-sidebar-container">    
		
            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <section id="main" class="col-left">
            	
			<?php
                if ( is_home() && is_active_sidebar( 'homepage' ) ) {
                   // dynamic_sidebar( 'homepage' );
                } else {
                   // get_template_part( 'loop', 'index' );
                }
            ?>
<?php get_header(); ?>

<h3 style="font-family: Arial, Helvetica, sans-serif;
border-bottom: 1px dotted #939393;
color: #133e1c;
margin-bottom: 10px;
margin-top: 30px;
padding-bottom: 5px;
font-weight: bold;
font-size: 18px;
width:141%;">Articles</h3>

<div id="article_menu_links">

                                    <span class="categories_title">Categories:</span>

                                    
                                        <a href="#Tai Chi">Tai Chi</a> - 

                                    
                                        <a href="#Life Style">Life Style</a> - 

                                    
                                        <a href="#Health">Health</a> - 

                                    
                            </div>
<?php 




global $wpdb;


$queryy = "
    SELECT * FROM `wp_term_relationships`
INNER JOIN wp_posts
ON `wp_term_relationships`.object_id = wp_posts.ID
WHERE `wp_term_relationships`.term_taxonomy_id = 1
    		   ";

	$posts_array = $wpdb->get_results($queryy, OBJECT);

	 
	
sizeof($posts_array);
echo "<br>";
echo "<a name='Tai Chi'><div style='color: #133e1c;
font: bolder;
font-weight: bold;
text-decoration: underline;'>Tai Chi</div></a>";
echo "<br>";
echo '<ul style="list-style: inherit;line-height: 34px;">';
foreach ($posts_array as $taichi)
{

echo "<li><u><a style = 'font-size: 10pt;' href = {$taichi->guid} >".$taichi->post_title."</a></u></li>";	

}
echo "</ul>";

echo "<br>";

$queryy = "
    SELECT * FROM `wp_term_relationships`
INNER JOIN wp_posts
ON `wp_term_relationships`.object_id = wp_posts.ID
WHERE `wp_term_relationships`.term_taxonomy_id = 7
    		   ";

	$posts_array = $wpdb->get_results($queryy, OBJECT);

	 
	
sizeof($posts_array);
echo "<a name='Life Style'><div style='color: #133e1c;
font: bolder;
font-weight: bold;
text-decoration: underline;'>Life Style</div></a>";
echo "<br>";
echo '<ul style="list-style: inherit;line-height: 18px;">';
foreach ($posts_array as $taichi)
{

echo "<li><u><a style = 'font-size: 10pt;' href = {$taichi->guid} >".$taichi->post_title."</a></u></li>";	
echo "<br>";



}
echo "</ul>";


echo "<br>";
$queryy = "
    SELECT * FROM `wp_term_relationships`
INNER JOIN wp_posts
ON `wp_term_relationships`.object_id = wp_posts.ID
WHERE `wp_term_relationships`.term_taxonomy_id = 8
    		   ";

	$posts_array = $wpdb->get_results($queryy, OBJECT);

	 
	
sizeof($posts_array);
echo "<a name='Health'><div style='color: #133e1c;
font: bolder;
font-weight: bold;
text-decoration: underline;'>Health</div></a>";
echo "<br>";
echo '<ul style="list-style: inherit;line-height: 18px;">';
foreach ($posts_array as $taichi)
{

echo "<li><u><a style = 'font-size: 10pt;' href = {$taichi->guid} >".$taichi->post_title."</a></u></li>";	
echo "<br>";

}
echo "</ul>";

?>

</section><!-- /#main -->
            <?php //woo_main_after(); ?>
    
            <?php //get_sidebar(); ?>
    
		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
	<?php //woo_content_after(); ?>
		
<?php get_footer(); ?>

