<?php
/**
 * Alternate Sidebar Template
 *
 * If a `secondary` widget area is active and has widgets,
 * and the selected layout has a third column, display the sidebar.
 *
 * @package WooFramework
 * @subpackage Template
 */
	global $woo_options;
	
	$selected_layout = 'one-col';
	$layouts = array( 'three-col-left', 'three-col-middle', 'three-col-right' );
	if ( is_array( $woo_options ) && array_key_exists( 'woo_layout', $woo_options ) ) { $selected_layout = $woo_options['woo_layout']; }
	
	if ( in_array( $selected_layout, $layouts ) ) {

		if ( woo_active_sidebar( 'secondary' ) ) {
	
			woo_sidebar_before();
?>
<aside id="sidebar-alt">
	<?php
		woo_sidebar_inside_before();
		woo_sidebar( 'secondary' );
	
		woo_sidebar_inside_after();
	?>
</aside><!-- /#sidebar-alt -->
<?php
			woo_sidebar_after();
echo '<div id="sidebar_tar" style = "background-color: #133E1C;
width: 5px;
height: 101.38%;
position: absolute;
margin-left: 23%;
margin-top: -38px;
"></div>';
		} // End IF Statement
	} // End IF Statement
?>

<script>
//document.getElementsByClassName('widget widget_clw')[0].style.visibility='hidden';
document.getElementById("clw-6").remove();
</script>