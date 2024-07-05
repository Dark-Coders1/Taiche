<form action="<?php echo nd_login_current_url(); ?>/?wcz" method="post" class="nd_form" id="nd_login_form"><div class="nd_form_inner">
	
	<?php
		global $nd_login_errors;
		if (isset($nd_login_errors) && sizeof($nd_login_errors)>0 && $nd_login_errors->get_error_code()) :
			echo '<ul class="errors">';
			foreach ($nd_login_errors->errors as $error) {
				echo '<li>'.$error[0].'</li>';
				break;
			}
			echo '</ul>';
		endif; 
	?>
	
	<p><label for="nd_username"><?php _e('Username','ninety'); ?>:</label> <input type="text" class="text" name="log" id="nd_username" placeholder="<?php _e('Username', 'ninety'); ?>" /></p>
	<p><label for="nd_password"><?php _e('Password','ninety'); ?>:</label> <input type="password" class="text" name="pwd" id="nd_password" placeholder="<?php _e('Password','ninety'); ?>" /></p>
<p><?php if( function_exists( 'cptch_display_captcha_custom' ) ) { echo "<input type='hidden' name='cntctfrm_contact_action' value='true' />"; echo cptch_display_captcha_custom(); } ?></p>	
<p>
<?php if(get_option('sbl_option_lost')==Enabled) { echo '<a class="forgotten" href="#nd_lost_password_form">Lost your password?</a>'; } else { echo ''; } ?>
		 
<input type="submit" class="button" value="<?php _e('Login &rarr;','ninety'); ?>" />
		<input name="nd_login" type="hidden" value="true"  />
		<input name="rememberme" type="hidden" id="rememberme" value="forever"  />
		<input name="redirect_to" type="hidden" id="redirect_to" value="<?php echo nd_login_current_url(); ?>"  />
	</p>
</div></form>