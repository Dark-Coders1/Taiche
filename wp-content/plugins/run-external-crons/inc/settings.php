<?php

/**
 * Run External Crons Settings Functions
 *
 * @package Run External Crons
 * @subpackage Settings
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display settings page
 *
 * @since 1.0
 *
 * @uses current_user_can() To check if the current user can edit settings
 * @uses rec_save_settings() To save new settings
 * @uses wp_print_scripts() To load jQuery UI files
 * @uses wp_nonce_field() To add nonce to the form
 * @uses get_option() To get REC settings
 * @uses rec_image_url() To get URL of the image
 * @uses submit_button() To get form submit button
 */
function rec_settings_page() {
	/* Don't show anything if user doesn't have capatibilities */
	if ( ! current_user_can( 'manage_options' ) )
		return;

	/* If new settings were submitted, save them */
	if ( isset( $_POST['url'] ) || isset( $_POST['newMetaFields'] ) )
		rec_save_settings();

	/* Enqueue scripts */
	wp_print_scripts( 'jquery-ui-sortable' );
	?>
	<style type="text/css">
	div.inside ul {
		margin-left: 20px;
	}
	div.inside ul li {
		list-style: square;
		line-height: 16px;
	}
	div.inside ul li.twitter {
		list-style-image: url(<?php rec_image_url( 'twitter-icon.png' ); ?>);
	}
	div.inside ul li.rss {
		list-style-image: url(<?php rec_image_url( 'rss-icon.png' ); ?>);
	}
	</style>
	<div class="wrap">
		<h2><?php _e( 'Run External Cron Settings', 'rec' ); ?></h2>
		<div class="postbox-container" style="width: 70%"><div class="metabox-holder"><div class="ui-sortable meta-box-sortables"><div class="postbox"><div class="inside">
			<ul>
				<li><?php _e( 'To add a new URL to the list, you need to press &#8220;Add new URL&#8221; button. That will show a new row with fields for URL and interval in which cron for that URL should be run. You can add unlimited number or URLs.', 'rec' ); ?></li>
				<li><?php _e( 'You don&#8217;t need to fill interval for each URL, if left blank, lowest interval will be used, or 3600 seconds by default.', 'rec' ); ?></li>
				<li><?php _e( 'If you want to remove URL from the list, just press button &#8220;-&#8221; for that URL.', 'rec' ); ?></li>
				<li><?php _e( 'Check <a href="http://blog.milandinic.com/wordpress/plugins/run-external-crons/">documentation</a> for more information.', 'rec' ); ?></li>
				<li><strong><?php _e( 'Don&#8217;t forget to press &#8220;Save settings&#8221; when you finish!', 'rec' ); ?></strong></li>
			</ul>
			<form enctype="multipart/form-data" method="post">
				<?php wp_nonce_field( 'rec_save_settings' ); ?>
				<table id="meta_fields" style="padding-left: 0px; width: 90%;">
					<tbody class="fields">
						<tr>
							<td>
							<span style="margin-right: 180px; padding-left: 150px;"><?php _e( 'URL', 'rec' ); ?></span>&nbsp;<?php _e( 'Interval (in seconds)', 'rec' ); ?>
							</td>
						</tr>
						<?php
						$rec_options = get_option( 'run_external_cron_settings' );
						if ( ! is_array( $rec_options ) )
							$rec_options = array();

						if ( isset( $rec_options['rec_url_list'] ) && $rec_url_list = $rec_options['rec_url_list'] ) {
							foreach ( $rec_url_list as $item_index => $item ) {
								?>
								<tr>
									<td>
									<table>
										<tr class="label" class="sortHandle">
											<td>
												<input type="text" name="url[<?php echo $item_index; ?>]" value="<?php echo esc_attr( $item['url'] ); ?>" size="60" />&nbsp;<input type="text" name="interval[<?php echo $item_index; ?>]" value="<?php echo esc_attr( $item['interval'] ); ?>" /><img src="<?php rec_image_url( 'minus-circle.png' ); ?>" alt="<?php esc_attr_e( 'Remove URL', 'rec' ); ?>" title="<?php esc_attr_e( 'Remove URL', 'rec' ); ?>" class="removeOldButton" style="cursor: pointer;">
											</td>
										</tr>
									</table>
									</td>
								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
				<img src="<?php rec_image_url( 'plus-circle.png' ); ?>" alt="<?php esc_attr_e( 'Add new URL', 'rec' ) ?>" title="<?php esc_attr_e( 'Add new URL', 'rec' ) ?>" id="addField" style="cursor: pointer;" />&nbsp;<?php _e( 'Add new URL', 'rec' ) ?>
				<?php submit_button( __( 'Save settings', 'rec' ), 'primary', 'update_settings' ); ?>
			</form>
		</div></div></div></div></div>
		<div class="postbox-container" style="width: 20%"><div class="metabox-holder"><div class="ui-sortable meta-box-sortables"><div class="postbox">
			<h3 class="hndle"><span><?php _e( 'Like this plugin?', 'rec' ); ?></span></h3>
			<div class="inside">
				<p><?php _e( 'Why not do any or all of the following:', 'rec' ); ?></p>
				<ul>
					<li><a href="http://blog.milandinic.com/wordpress/plugins/run-external-crons/"><?php _e( 'Link to it so other can find out about it', 'rec' ); ?></a></li>
					<li><a href="http://wordpress.org/extend/plugins/run-external-crons/"><?php _e( 'Give it a good rating on WordPress.org', 'rec' ); ?></a></li>
					<li><a href="http://wordpress.org/support/plugin/run-external-crons"><?php _e( 'Help out other users in the forums', 'rec' ); ?></a></li>
					<li class="rss"><a href="http://blog.milandinic.com/"><?php _e( 'Follow Milan&#8217;s blog', 'rec' ); ?></a></li>
					<li class="twitter"><a href="https://twitter.com/dinicmilan"><?php _e( 'Follow Milan on Twitter', 'rec' ); ?></a></li>
					<li><a href="http://blog.milandinic.com/donate/"><?php _ex( 'Donate', 'settings sidebar link', 'rec' ); ?></a></li>
				</ul>
				<a href="http://blog.milandinic.com/donate/"><img src="<?php rec_image_url( 'donate.png' ); ?>" width="92" height="26" alt="<?php echo esc_attr( _x( 'Donate', 'settings sidebar link', 'rec' ) ); ?>" /></a>
			</div>
		</div></div></div></div>
	</div>
	<script type="text/javascript">
	function addField() {
		var n = jQuery(".removeNewButton").length;
		jQuery("#meta_fields").find("tbody.fields")
			.append(jQuery("<tr>")
				.append(jQuery("<td>")
					.append(jQuery("<img>")
						.attr("src", "<?php rec_image_url( 'asterisk-yellow.png' ); ?>")
						.attr("alt", "<?php esc_attr_e( 'New URL', 'rec' ); ?>")
						.attr("title", "<?php esc_attr_e( 'New URL', 'rec' ); ?>")
					)
					.append("&nbsp;")
					.append(jQuery("<input>")
						.attr("type", "text")
						.attr("size", "57")
						.attr("name", "newMetaFields[" + n + "]")
					)
					.append("&nbsp;")
					.append(jQuery("<input>")
						.attr("type", "text")
						.attr("name", "newMetaFieldsInterval[" + n + "]")
					)
					.append("&nbsp;")
					.append(jQuery("<img>")
						.attr("src", "<?php rec_image_url( 'minus-circle.png' ); ?>")
						.attr("alt", "<?php esc_attr_e( 'Remove URL', 'rec' ); ?>")
						.attr("title", "<?php esc_attr_e( 'Remove URL', 'rec' ); ?>")
						.attr("class", "removeNewButton")
						.attr("style", "cursor: pointer;")
					)
				)
			);
	}

	jQuery(document).ready(function($) {
		$("#meta_fields tbody.fields").sortable({handle:'.sortHandle'});

		$("#addField").bind("click", function() {
			addField();
		});

		$(".removeNewButton").live("click", function() {
			$(this).parent().parent().remove();
		});

		$(".removeOldButton").live("click", function() {
			$(this).parent().parent().remove();
		});
	});
	</script>
	<?php
}

/**
 * Save settings
 *
 * Handle submission from settings page
 *
 * @since 1.0
 *
 * @uses check_admin_referer() To check nonce
 * @uses current_user_can() To check if the current user can edit settings
 * @uses get_option() To get REC settings
 * @uses esc_url_raw() To escape submitted URL
 * @uses apply_filters() Calls 'rec_add_interval' with the time
 *                        of the interval
 * @uses update_option() To save new REC settings
 * @uses wp_next_scheduled() To get time of next event
 * @uses wp_unschedule_event() To unschedule event
 * @uses wp_schedule_event() To schedule event
 */
function rec_save_settings() {
	check_admin_referer( 'rec_save_settings' );

	if ( ( ! isset( $_POST['url'] ) || ! isset( $_POST['newMetaFields'] ) ) && ! current_user_can( 'manage_options' ) )
		return;

	$rec_options = get_option( 'run_external_cron_settings' );
	$intervals = array();
	$rec_url_list = array();
	$list_key = 0;
	if ( isset( $_POST['url'] ) ) {
		foreach ( $_POST['url'] as $index => $v ) {
			$meta_field = array();
			if ( ! empty( $_POST['url'][$index] ) ) {
				$meta_field['url'] = esc_url_raw( trim( $_POST['url'][$index] ) );
				$meta_field['interval'] = $_POST['interval'][$index] ? absint( $_POST['interval'][$index] ) : '';
				if ( $meta_field['interval'] )
					$intervals[] = $meta_field['interval'];
			}
			$rec_url_list[$list_key++] = $meta_field;
		}
	}

	if ( isset( $_POST['newMetaFields'] ) ) {
		foreach ( $_POST['newMetaFields'] as $index => $url ) {
			$meta_field = array();
			$meta_field['url'] = esc_url_raw( trim( $url ) );
			$meta_field['interval'] = $_POST['newMetaFieldsInterval'][$index] ? absint( $_POST['newMetaFieldsInterval'][$index] ) : '';
			if ( $meta_field['interval'] )
					$intervals[] = $meta_field['interval'];
			$rec_url_list[$list_key++] = $meta_field;
		}
	}

	if ( ! empty( $rec_url_list ) ) {
		sort( $intervals );
		if ( ! $intervals )
			$intervals[] = apply_filters( 'rec_add_interval', 3600 );

		$lowest_interval = $intervals[0];
		// Is there new lowest interval?
		if ( $lowest_interval != $rec_options['interval'] ) {
			$new_rec_options['interval'] = $lowest_interval;
			$rec_reschedule_event = true;
		} else {
			$new_rec_options['interval'] = $rec_options['interval'];
			$rec_reschedule_event = false;
		}

		$new_rec_options['rec_url_list'] = $rec_url_list;

		update_option( 'run_external_cron_settings', $new_rec_options );
		if ( $rec_reschedule_event ) {
			$timestamp = wp_next_scheduled( 'rec_event' );
			wp_unschedule_event( $timestamp, 'rec_event' );
			wp_schedule_event( time(), 'rec', 'rec_event' );
		}
		echo '<div id="message" class="updated"><p>' . __( 'Settings updated', 'rec' ) . '</p></div>';
	}
}

/**
 * Get URL of image
 *
 * @since 1.0
 *
 * @uses plugins_url() To get URL path of the image
 */
function rec_image_url( $image ) {
	echo plugins_url( 'images/' . $image, __FILE__ );
}