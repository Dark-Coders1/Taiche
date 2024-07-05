<?php
/**
 * Index Template
 *
 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage
 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options;
?>      
    
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">
    
    	<div id="main-sidebar-container">    
		
            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <section id="main" class="col-left">
            	
			<?php
                if ( is_home() && is_active_sidebar( 'homepage' ) ) {
                    dynamic_sidebar( 'homepage' );
                } else {
//get_template_part( 'loop', 'index' );
                    $id=3543; 
$post = get_post($id); 
$content = apply_filters('the_content', $post->post_content); 
echo $content;  
                }
            ?>
                    
            </section><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>
    
		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
	<?php woo_content_after(); ?>
	<script>
//document.getElementsByClassName('widget widget_clw')[0].style.visibility='hidden';
document.getElementById("clw-6").remove();
</script>	
<?php get_footer(); ?>
