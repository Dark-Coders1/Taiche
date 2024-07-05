<div class="wrap">
	<h2><img src="<?php echo WP_PLUGIN_URL; ?>/sb-login/img/icon1.png" alt="SB Login Settings"> SB Login Settings</h2>
	<?php if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) { 
		echo '<div id="message" class="updated"><p>'. __('Settings saved.') .'</p></div>'.PHP_EOL;
	} ?>

	<div style="width: 68%; float: left;">
		<form method="post" action="options.php">
		<?php
			settings_fields( 'sbl-settings-group' );
			$sbl_option_dash = get_option('sbl_option_dash');
			$sbl_option_lost = get_option('sbl_option_lost');
			$sbl_option_lost = get_option('sbl_option_pro');
			$sbl_option_lost = get_option('sbl_option_xtra');
			$sbl_option_lost = get_option('sbl_option_recent');				
		?>
		<div class="postbox" style="display: block;float:left;margin:5px;clear:left; width: 99%;">
			<h3 class="hndle" style="padding:5px; color:#007193;">Show/Add Links</h3>
			<div class="inside">
				<div>
					<table class="form-table">
<tr valign="top">
   							<p><b>If you want to show Captcha form please install <a href="http://wordpress.org/plugins/captcha/" target="_blank">Captcha Plugin</a>. Than it will automatically show Captcha form.</b></p>
   							
   						</tr>
   						<tr valign="top">
   							<th scope="row">Show Dashboard Link:</th>
   							<td><input type="checkbox" name="sbl_option_dash" value="Enabled" <?php if(get_option('sbl_option_dash')==Enabled) echo('checked="checked"'); ?>/></td>
   						</tr>
<tr valign="top">
   							<th scope="row">Show  Lost your password:</th>
   							<td><input type="checkbox" name="sbl_option_lost" value="Enabled" <?php if(get_option('sbl_option_lost')==Enabled) echo('checked="checked"'); ?>/></td>
   						</tr>
<tr valign="top">
   							<th scope="row">Show Profile Link:</th>
   							<td><input type="checkbox" name="sbl_option_pro" value="Enabled" <?php if(get_option('sbl_option_pro')==Enabled) echo('checked="checked"'); ?>/></td>
   						</tr>
<tr valign="top">
   							<th scope="row">Show Recent Activity Tab:</th>
   							<td><input type="checkbox" name="sbl_option_recent" value="Enabled" <?php if(get_option('sbl_option_recent')==Enabled) echo('checked="checked"'); ?>/></td>
   						</tr>
<tr valign="top">
   							<th scope="row">Add Extra Link:</th>
   							<td><input type="text" name="sbl_option_xtra" value="<?php $sbl_option_xtra = get_option('sbl_option_xtra'); if(!empty($sbl_option_xtra)) {echo $sbl_option_xtra;} else {echo "";}?>"><br><br>Example: < li>< a href="">Link< /a>< /li></td>
   						</tr>

					</table>
					

					<?php submit_button(); ?>	    
				</div>

			</div>
		</div>
		</form>
</div>
<?php echo sbl_sidebar(); ?>