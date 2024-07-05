<?php
/**
 * Template Name: event_temmplate
 *
 * The blog page template displays the "blog-style" template on a sub-page. 
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options, $wpdb;
 
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
                    
                }
            ?>
                    
            </section><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar('alt'); ?>
    
		</div><!-- /#main-sidebar-container -->         

		<?php //get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
	<?php woo_content_after(); ?>
		
<?php get_footer(); ?>
