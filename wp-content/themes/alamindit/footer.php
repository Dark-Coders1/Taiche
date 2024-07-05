<?php
/**
 * Footer Template
 *
 * Here we setup all logic and XHTML that is required for the footer section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;

 woo_footer_top();

 	woo_footer_before();
?>

	<footer id="footer" class="col-full" style="background-color: #133E1C;">
		<a href="http://taichi.wpengine.com/contact-us/" style="color:white;">Contact us   :</a>
		<a href="http://taichi.wpengine.com/your_security/" style="color:white;">   Security   :</a>
		<a href="http://taichi.wpengine.com/privacy_policy/" style="color:white;">   Privacy    :</a>
		<a href="http://taichi.wpengine.com/disclaimer/" style="color:white;">   Disclaimer    :</a>
		<a href="http://taichi.wpengine.com/links/" style="color:white;">   Links    :</a>
		<a href="http://taichi.wpengine.com/faqs/" style="color:white;">   FAQs    :</a>
		<a href="http://taichi.wpengine.com/sitemap/" style="color:white;">   Sitemap    </a>
		<br>
		<?php woo_footer_inside(); ?>

		<div id="copyright" class="col-left" style="color:white;">
			<?php woo_footer_left(); ?>
		</div>

		<div id="credit" class="col-right">
			<?php woo_footer_right(); ?>
		</div>

	</footer>
	<?php woo_footer_after(); ?>

	</div><!-- /#inner-wrapper -->

</div><!-- /#wrapper -->

<div class="fix"></div><!--/.fix-->

<?php wp_footer(); ?>
<?php woo_foot(); ?>

<script>
//document.getElementsByClassName('widget widget_clw')[0].style.visibility='hidden';
document.getElementById("clw-6").remove();
</script>
</body>
</html>
