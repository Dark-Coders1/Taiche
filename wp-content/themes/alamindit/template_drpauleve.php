<?php
/**
 * Template Name: Paul events
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
            <section id="main" class="col-left" style = "width: 660px">
            	
			<?php
                if ( is_home() && is_active_sidebar( 'homepage' ) ) {
                   // dynamic_sidebar( 'homepage' );
                } else {
                   // get_template_part( 'loop', 'index' );
                }
            ?>


<?php get_header(); ?>


<script type="text/javascript" charset="utf-8"  src="http://clients.chimpchamp.com/taichi/wp-includes/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8"  src="http://clients.chimpchamp.com/taichi/wp-includes/DataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" charset="utf-8"  src="http://clients.chimpchamp.com/taichi/wp-includes/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>

<style type="text/css" title="currentStyle">
    @import "http://clients.chimpchamp.com/taichi/wp-includes/DataTables-1.9.4/media/css/jquery.dataTables.css";
</style>
<h1 style="font-size:20px;">Dr Paul Lam's Workshop Calendar</h1>
<p>To find a workshop, choose your country.</p>
<p><a href="http://taichi.wpengine.com/dr-lams-workshop-calendar/">Click here</a> to authorised master trainers' workshop calendar.</p>
Search by country:

<select id = "msds-select">
  <option value="allcountries">All countries</option>
  <option value="Pakistan">Pakistan</option>
  <option value="Australia">Australia</option>
  <option value="Korea">Korea</option>
<option value="Italy">Italy</option>
<option value="New Zealand">New Zealand</option>
<option value="Singapore">Singapore</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sweden">Sweden</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States">United States</option>

</select>
<br><br>



<?php

global $post;

$all_events = tribe_get_events(array(

'author' => 1,
'eventDisplay'=>'all',

'posts_per_page'=>-1

));




foreach($all_events as $post) {

setup_postdata($post);

if (tribe_get_start_date( $post->ID, false, 'Ymd' ) < date("Ymd") || 'yes' == get_post_meta( $post->ID , '_EventHideFromUpcoming', true ))
continue;
?>



<?php
if(isset($_GET['country']) && $_GET['country'] != 'allcountries') {
if(tribe_get_country($post->ID) == $_GET['country'] ){

	if($month != tribe_get_start_date( $post->ID, false, 'M , Y' )){
?>
		<h3 style="font-size:15px;">
		<?php
		
		echo $month =  tribe_get_start_date( $post->ID, false, 'M , Y' );
		?>
		</h3>
	<?php
	}
	?>

<a href="<?php the_permalink(); ?>"><u><?php echo tribe_get_start_date( $post->ID, true, 'D. M j, Y' );
 ?>.</u> </a><?php the_title(); ?>,<?php echo tribe_get_city($post->ID); ?>,<?php tribe_get_venue($post->ID, false) ?> <?php echo tribe_get_country($post->ID); ?>
<br>
<?php
}
}
else{

if($month != tribe_get_start_date( $post->ID, false, 'M , Y' )){
?>
<br>
		<h3 style="font-size:15px;">
		<?php
		echo $month =  tribe_get_start_date( $post->ID, false, 'M , Y' );
		?>
		</h3>
		<br>
	<?php
	}
	?>

<a href="<?php the_permalink(); ?>">
  <u><?php echo tribe_get_start_date( $post->ID, false, 'M j-' ); echo tribe_get_end_date( $post->ID, false, 'M j' );?>.</u> 
</a>
<?php the_title(); ?>,<?php echo tribe_get_city($post->ID); ?>,<?php echo tribe_get_stateprovince($post->ID) ?>, <?php echo tribe_get_country($post->ID); ?>

<?php
}
?>
<br>


<?php if ( has_post_thumbnail() ) { ?>



<div class="event-thumb">

<a href="<?php the_permalink(); ?>"><?php //the_post_thumbnail('thumbnail'); ?></a>

</div>



<div class="event-excerpt">

<?php the_excerpt(); ?>

</div>



<?php } else { ?>



<div class="event-content" style="margin-bottom:10px;">

<?php //the_content(); ?>

</div>



<?php } ?>

<?php } //endforeach ?>

<?php wp_reset_query(); ?>


<script type="text/javascript">
                        jQuery(document).ready(function($){

 $("#table_id").dataTable({
        "sPaginationType": "full_numbers",
        "bFilter": true,
        "sDom":"lrtip" // default is lfrtip, where the f is the filter
       });
      var oTable;
      oTable = $('#table_id').dataTable();

$("#search").keyup( function () {
            /* Filter on the column (the index) of this element */
            oTable.fnFilter( this.value, $("#search").index(this) );
        });
if(getParam("country"))
$("#msds-select").val(getParam("country"));


$('#msds-select').change( function() {
            window.location.assign("http://taichi.wpengine.com/master-trainers-workshop-calendar/?country="+$(this).val())
       });




                       });

function getParam(key) {
        var paramsStr = window.location.search.substr(1, window.location.search.length),
            paramsArr = paramsStr.split("&"),
            items     = [];

        for (var i = 0; i < paramsArr.length; i++) {
            items[paramsArr[i].split("=")[0]] = paramsArr[i].split("=")[1];
        }

        if (key != "" && key != undefined) {
            // return single
            if (items[key] != undefined) {
                return items[key];
            } else {
                return null;
            }
        } else {
            // return all (array)
            return items;
        }
    };


                  </script>


   </section><!-- /#main -->
            <?php //woo_main_after(); ?>
    
            <?php //get_sidebar(); ?>
    
		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>       

    </div><!-- /#content -->
	<?php //woo_content_after(); ?>
		
<?php get_footer(); ?>

