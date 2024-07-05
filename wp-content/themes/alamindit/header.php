<?php

/**

 * Header Template

 *

 * Here we setup all logic and XHTML that is required for the header section of all screens.

 *

 * @package WooFramework

 * @subpackage Template

 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>



<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" /><meta name="designer" content="alamindit is skype">

<title><?php woo_title(); ?></title>

<?php woo_meta(); ?>

<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />









<?php wp_head(); ?>

<?php woo_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php woo_top(); ?>

<div id="wrapper">



	<div id="inner-wrapper">



	<?php woo_header_before(); ?>



	<header id="header" class="col-full">



		<?php woo_header_inside(); ?>



	</header>


	<div style="position: relative;margin-top: -23px;margin-left: 30%;display:block;">

			 <!--<form method="get" id="searchform" action="<?php // bloginfo('home'); ?>/" style="margin-top: 4px;

				position: absolute;

				display: block;">

				<input type="text" size="18" value="<?php //echo wp_specialchars($s, 1); ?>" name="s" id="s" style="width:157px; margin-left: 93px;

				margin-top: 0px;"/>



			 </form>-->

			 <!-- <input type="submit" id="searchsubmit" value="Search" class="btn" /> -->

<div style = "float: left; margin-top: 22px">
<form style="clear:both;"name="search"  method="get" action="<?php echo $_SERVER['PHP_SELF']; ?> "> 

                   
                    <input id="s" name="s" type="text" size="30" />
<input type="hidden" class = "putin" id = "putin" name="cat" value="" />
                    <!-- The following 2 lines were added for the forum search  -->

                    <input id="query" name="query" type="hidden" size="30" />

                    <input type="hidden" id="searchaction" value="simplesearch" />   

                    <select name="type" class="banner_select" onchange="searchChange();">

                        <option value="Site" selected="selected" class="banner_option">Site</option>

                        <option value="Articles" class="banner_option">Articles</option>

                        

                    </select>

                    <input style = "align-items: flex-start;
text-align: center;
cursor: default;
color: buttontext;
padding: 2px 6px 3px;
border: 2px outset buttonface;
border-image-source: initial;
border-image-slice: initial;
border-image-width: initial;
border-image-outset: initial;
border-image-repeat: initial;
background-color: #EEEEEE;
box-sizing: border-box;
height: 23px;" type="submit" id="searchsubmit" value="Search" />
</form>

</div>
	


				



			<?php $args = array( 'numberposts' => -1); ?>



			<div id="pages" style="float:right; margin-top: 27px; position:relative; margin-right:25px;">

				

					

<select id="quick-links" class = "quick-links" style="width: 144px;" onchange = "hello()">                                          <option> Quick Links </option>                      <option value="http://www.taichiforarthritis.com">Tai Chi for Arthritis </option>                      <option value="http://www.taichifordiabetes.com">Tai Chi for Diabetes </option>                                           <option value="http://taichi.wpengine.com/tai-chi-for-beginners/">Tai Chi for Beginners </option>                      <option value="http://taichi.wpengine.com/tai-chi-for-osteoporosis/">Tai Chi for Osteoporosis </option>                                          <option value="http://taichi.wpengine.com/tai-chi-for-back-pain/">Tai Chi for Back Pain </option>                                          <option>......................... </option>                                          <option value="http://taichi.wpengine.com/dr-lams-workshop-calendar/">Dr Lam's workshop calendar </option>                      <option value="http://taichi.wpengine.com/master-trainers-workshop-calendar/">Master trainers workshop calendar </option>                                           <option>........................ </option>                      <option value="http://taichi.wpengine.com/certified-instructor/">Certified instructors </option>                                          <option value="http://taichi.wpengine.com/master-trainers/">Master trainers </option>                                          <option value="http://taichi.wpengine.com/senior-instructors/">Senior trainers </option>                                          <option>........................ </option>                                          <option value="http://taichi.wpengine.com/find_instructors/">Tai Chi classes  </option>                                           <option>........................ </option>                                          <option value="http://taichi.wpengine.com/newsletters/">Monthly newsletter  </option>                                          <option value="http://taichi.wpengine.com/article/#TaiChi">Tai chi articles  </option>                                          <option>Ask Dr Lam   </option>                                           <option>........................ </option>                                          <option value="http://www.taichiproductions.com/categories/">Resource material</option>                                          <option value="http://www.taichiproductions.com/categories/Instructional-DVDs/">Instructional DVDs</option>                                          <option value="http://www.taichiproductions.com/categories/Tai-Chi-Books/">Tai chi books</option>                      </select>

<script>
function hello()
{  
window.location.assign(jQuery("#quick-links option:selected").val())
}
function saf()
{  
//window.location.assign(jQuery("#quick-links option:selected").val())
}


                    function searchChange()

                    {

                        var field = document.search.type;

                        var value = field[field.selectedIndex].value;

                        var vq = document.getElementById('putin');

                        var vquery = document.getElementById('query');

                        var form = document.search;

                        if (value == 'Site')

                        {form.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
				vq.value = "";
                            
                        }

                        else if (value == 'Articles')

                        {
				form.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
                           vq.value = '1,7,8';
                            

                        }

                        else if (value == 'Forum')

                        {

                            form.action = 'taichi/feedback';
				vq.value = "";
                            

                        }

                    }

                

</script>


<?php
$args = array(
    
    'exclude'             => '2927'); 

//wp_dropdown_pages($args); 

?>

		
			</div>

		</div>

	<?php woo_header_after(); ?>
	<div id="aditbd1" style="position: relative;top: -46px;margin-bottom:-50px;"> 

			<?php echo do_shortcode('[metaslider id=3227]'); ?>

			</div> 
				<br><br>

<!--  <div id="aditbd1" style="position: relative;top: -46px;margin-bottom:-50px;"> <?php //echo do_shortcode("[slider id='2290' name='alamin']");?></div>  --> 
