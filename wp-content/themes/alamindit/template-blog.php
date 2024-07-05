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


$key = "taichi_user_meta_api_key";
$user = 1;
$apikey = get_user_meta($user,$key,true);
echo $apikey;

/*$new_post = array(
	'post_title'	=> 'ievent',
	'post_content'	=> 'ievent',//$post_title,
	'post_status'	=> 'publish', // Choose: publish, preview, future, etc.
	'post_type'		=> 'tribe_events', // Set the post type based on the IF is post_type X
	'post_author' => 1
					);
	echo $new_post_id = wp_insert_post($new_post); // http://codex.wordpress.org/Function_Reference/wp_insert_post

$new_post = array(
	'post_title'	=> 'iorder',
	'post_content'	=> 'iorder',//$post_title,
	'post_status'	=> 'publish', // Choose: publish, preview, future, etc.
	'post_type'		=> 'shop_order', // Set the post type based on the IF is post_type X
	'post_author' => 1
					);
	echo $new_post_id = wp_insert_post($new_post); // http://codex.wordpress.org/Function_Reference/wp_insert_post

$new_post = array(
	'post_title'	=> 'itikt',
	'post_content'	=> 'itikt',//$post_title,
	'post_status'	=> 'publish', // Choose: publish, preview, future, etc.
	'post_type'		=> 'tribe_wooticket', // Set the post type based on the IF is post_type X
	'post_author' => 1
					);
	echo $new_post_id = wp_insert_post($new_post); // http://codex.wordpress.org/Function_Reference/wp_insert_post
*/

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