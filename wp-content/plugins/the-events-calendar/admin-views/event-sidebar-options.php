
<?php
/**
* UI for option to hide from upcoming events list
*/

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

?>

<div class="scroll" style = "overflow: auto;height: 500px;">

<?php
$args = array(
	'post_type' => 'certificate_template','post_status' => 'private', 'posts_per_page' => -1
	
);

$id = 0;
$the_query = get_posts( $args );
global $post;
$certs_string = tribe_get_event_meta($post->ID, '_EventHideFromUpcoming');
echo '<input type="text" id= "certs_hidden_field" hidden = "hidden" value="'.$certs_string.'">';
// The Loop


        
	foreach ( $the_query as $postt ) {
		
		
		if (strpos($certs_string, $postt->post_title) !== false && $certs_string != null ) {
    		$checked = 'checked="checked"';
}

?>

<label class="selectit"><input value="<?php echo $postt->post_title ?>" id = "<?php echo 'cert_'.$id ?>" class="abc" type="checkbox" disabled <?php echo $checked ?> name="EventHideFromUpcoming"> <?php _e($postt->post_title, 'tribe-events-calendar'); ?></label><br /><br />
		
<?php
$checked = null;
$id++;
	}
        

/* Restore original Post Data */
?>



<?php //checked(tribe_get_event_meta($post->ID, '_EventHideFromUpcoming') == "yes") ?>

<label class="selectit" hidden = "hidden" ><input  type="checkbox" id = "certs_string" checked = "checked" hidden = "hidden" name="EventHideFromUpcoming"> <?php _e("Hide From Event Listings", 'tribe-events-calendar'); ?></label><br /><br />
<label class="selectit" hidden = "hidden" ><input value="yes" type="checkbox"  hidden = "hidden" name="EventShowInCalendar"> <?php _e("Sticky in Calendar View", 'tribe-events-calendar'); ?></label>

</div>
<script>

jQuery(document).ready(function(){

var certifications_string = jQuery('#certs_hidden_field').val();
jQuery('#certs_string').val(certifications_string);
	jQuery('.abc').removeAttr("disabled");	
	jQuery('.abc').change(function(){
		id = jQuery(this).attr('id');
				
		//$(this).attr('id');
		if (jQuery(this).is(':checked')){
			certifications_string += jQuery('#'+id).val()+",";		
			jQuery('#certs_string').val(certifications_string);
		}
		else{
			replace_the_value = jQuery('#'+id).val()+",";			
			certifications_string = certifications_string.replace(replace_the_value,'');
			jQuery('#certs_string').val(certifications_string);
		}

	});

});

</script>










