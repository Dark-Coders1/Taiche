<?php
/**
 * Template Name: Ind_Newsletter
 *
 * The blog page template displays the "blog-style" template on a sub-page. 
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options, $wpdb;
 
?>      
<?php woo_content_before();  ?>
    <div id="content" class="col-full">
    
    	<div id="main-sidebar-container">    
		
            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <section id="main" class="col-left" style = "width: 100%">
            	
			<?php
                if ( is_home() && is_active_sidebar( 'homepage' ) ) {
                   // dynamic_sidebar( 'homepage' );
                } else {
                   // get_template_part( 'loop', 'index' );
                }
            ?>
<?php
 $id = $_GET['id'];
$content = $wpdb->get_results( "SELECT * FROM  wp_PageInstance WHERE PageID = $id ORDER BY PageInstanceID DESC limit 1" );
//print_r($content);
foreach($content as $data)
?><h3><?php echo $data->Title;?></h3>
<?php
echo $data->Content;
?>
                    
            </section><!-- /#main -->
            <?php //woo_main_after(); ?>
    
            <?php //get_sidebar(); ?>
    
		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
	<?php //woo_content_after(); ?>
		
<?php get_footer(); ?>
