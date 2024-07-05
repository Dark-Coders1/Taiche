<?php
	global $before_title, $after_title, $current_user; 
	$current_user = wp_get_current_user();
?>
<div class="nd_logged_in" id="nd_user">
	
	<?php echo get_avatar( $current_user->ID, '58' ); ?>
	
	<?php echo $before_title; ?><?php _e('Welcome','ninety'); ?> <?php echo $current_user->display_name; ?><?php echo $after_title; ?>
	
	<?php
		if ($last_login = (int) get_user_meta($current_user->ID, 'nd_login_time', true)) echo '<p>'.__('You last logged in on ','ninety').date(__('l \t\h\e jS \of F, Y \a\t h:ia','ninety'), $last_login).'.</p>';
		
		$posts = wp_count_posts('post')->publish - (int) get_user_meta($current_user->ID, 'nd_num_posts', true);
		$comments = wp_count_comments()->approved - (int) get_user_meta($current_user->ID, 'nd_num_comments', true);
		
		echo '<p>';
		echo _n('Since last logging in there has been ', 'Since last logging in there have been ', $posts,'ninety');
		echo '<span class="count">'.$posts.'</span>';
		echo _n('new post and ', 'new posts and ', $posts,'ninety');
		echo '<span class="count">'.$comments.'</span>';
		echo _n('new comment', 'new comments', $comments, 'ninety');
	?>
	
	<ul class="links">
		<?php if(get_option('sbl_option_dash')==Enabled) { echo '<li><a href="/wp-admin">Dashboard</a></li>'; } else { echo ''; } ?>
		<?php if(get_option('sbl_option_pro')==Enabled) { echo '<li><a href="/wp-admin/profile.php">Profile</a></li>'; } else { echo ''; } ?>
<?php $sbl_option_xtra = get_option('sbl_option_xtra'); if(!empty($sbl_option_xtra)) {echo $sbl_option_xtra;} else {echo "";}?>		
		<li><a href="<?php echo wp_logout_url( nd_login_current_url() ); ?>"><?php _e('Log out','ninety'); ?></a></li>
	</ul>
</div>
<div class="nd_logged_in" id="nd_recently_viewed" style="display:none;">
	
	<?php echo $before_title; ?><?php _e('Recently Viewed Posts','ninety'); ?><?php echo $after_title; ?>
	<?php
		$viewed_posts = get_user_meta($current_user->ID, 'nd_viewed_posts', true);
		if (is_array($viewed_posts) && sizeof($viewed_posts)>0) :
			echo '<ul class="links">';
			$viewed_posts = array_reverse($viewed_posts);
			foreach ($viewed_posts as $viewed) :
				$viewed_post = get_post($viewed);
				if ($viewed_post) echo '<li><a href="'.get_permalink($viewed).'">'.$viewed_post->post_title.'</a></li>';
			endforeach;
			echo '</ul>';
		else :
			_e('You have not viewed any posts recently.', 'ninety');	
		endif;
	?>
	<hr/>
	<?php echo $before_title; ?><?php _e('My Recent Comments','ninety'); ?><?php echo $after_title; ?>
	<?php
		global $wpdb;
		$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
			comment_post_ID, user_id, comment_approved, comment_date_gmt,
			comment_type, SUBSTRING(comment_content,1,30) AS com_excerpt
			FROM $wpdb->comments
			LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
			$wpdb->posts.ID)
			WHERE comment_approved = '1' AND comment_type = '' AND
			post_password = '' AND user_id = '".$current_user->ID."'
			ORDER BY comment_date_gmt DESC LIMIT 5";
		$comments = $wpdb->get_results($sql);
		if ($comments) :
			echo '<ul class="links">';
			foreach ($comments as $comment) :
				echo '<li><a href="'.get_permalink($comment->ID).'#comment-'.$comment->comment_ID.'">&ldquo;'.strip_tags($comment->com_excerpt).'&hellip;&rdquo;</a></li>';
			endforeach;
			echo '</ul>';
		else :
			_e('You have not made any comments.', 'ninety');	
		endif;
	?>
</div>