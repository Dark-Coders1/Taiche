<?php
 if (is_user_logged_in()) : 
	
	global $current_user;
	$current_user = wp_get_current_user();
	?>

	<ul class="nd_tabs">
		<li class="active"><a href="#nd_user"><?php echo $current_user->user_login; ?></a></li>
		<?php if(get_option('sbl_option_recent')==Enabled) { echo '<li><a href="#nd_recently_viewed">Recent Activity</a></li>'; } else { echo ''; } ?>
	</ul>
	
<?php else : ?>

	<ul class="nd_tabs">
		<li class="active"><a href="#nd_login_form"><?php _e('Login', 'ninety'); ?></a></li>
		<?php if (get_option('users_can_register')) : ?><li><a href="#nd_register_form"><?php _e('Register', 'ninety'); ?></a></li><?php endif; ?>
	</ul>

<?php endif; ?>