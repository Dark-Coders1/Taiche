<?php
/*
Plugin Name: SB Login 
Plugin URI: http://webcarezone.com/project/sb-login
Description: Sb login widget that allows a user to login, register, reset their password, see recent activity,time , post and comment count ALL without leaving their current location!
Version: 2.0
Author: Fida Al Hasan
Author URI: http://fida.webcarezone.com
*/

/*
Copyright (C) 2013  Fida Al Hasan

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

global $nd_login_vars, $wpdb;

$nd_login_vars['plugin_path'] = WP_PLUGIN_DIR.'/sb-login';
$nd_login_vars['plugin_url'] = WP_PLUGIN_URL.'/sb-login';

load_plugin_textdomain('ninety', $nd_login_vars['plugin_url'] . '/langs/', 'sb-login/langs/');

###[ Detect Ajax ]###############################################NINETY#DEGREES####

if (!function_exists('nd_is_ajax')) {
	function nd_is_ajax() {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return true;
		return false;
	}
}

###[ Get Current URL ]###########################################NINETY#DEGREES####

function nd_login_current_url() {
	$pageURL = 'http://';
	$pageURL .= $_SERVER['HTTP_HOST'];
	$pageURL .= $_SERVER['REQUEST_URI'];
	if ( force_ssl_login() || force_ssl_admin() ) $pageURL = str_replace( 'http://', 'https://', $pageURL );
	return $pageURL;
}

###[ Update user data upon logging in ]###########################################NINETY#DEGREES####

function nd_update_user_meta( $user_id ) {
	update_user_meta( $user_id, 'nd_login_time', current_time('timestamp') );
	update_user_meta( $user_id, 'nd_num_comments', wp_count_comments()->approved );
	update_user_meta( $user_id, 'nd_num_posts', wp_count_posts('post')->publish );
}

###[ Update user data upon viewing post ]###########################################NINETY#DEGREES####

function nd_update_user_view_meta() {
	if (is_user_logged_in() && is_single()) :
		
		global $post;
		$user_id = get_current_user_id();
		$posts = get_user_meta( $user_id, 'nd_viewed_posts', true );
		if (!is_array($posts)) $posts = array();
		if (sizeof($posts)>4) array_shift($posts);
		if (!in_array($post->ID, $posts)) $posts[] = $post->ID;
		update_user_meta( $user_id, 'nd_viewed_posts', $posts );
		
	endif;
}
add_action('wp_head', 'nd_update_user_view_meta');

###[ Init ]######################################################NINETY#DEGREES####

function nd_login_init_script() {
	global $nd_login_vars;
	if (!is_admin()) :
		wp_register_script( 'ajax_login_js', $nd_login_vars['plugin_url'] . '/js/login.js' , 'jquery', '1.0', true );
		wp_register_script( 'blockui', $nd_login_vars['plugin_url'] . '/js/blockui.js' , 'jquery', '1.0', true );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'ajax_login_js' );
		wp_enqueue_script( 'blockui' );
	endif;
}
add_action('init', 'nd_login_init_script');

function nd_login_init_style() {
	global $nd_login_vars;
	$logincss = $nd_login_vars['plugin_url'] . '/css/login.css';
	if (file_exists(TEMPLATEPATH . '/sb-login/login.css')) $logincss = get_bloginfo('template_url') . '/sb-login/login.css';
	if (is_ssl()) $logincss = str_replace('http://','https://', $logincss);
	wp_register_style('login_css', $logincss);
	wp_enqueue_style( 'login_css' );
}
add_action('wp_print_styles', 'nd_login_init_style');

function nd_login_init() {
	class NinetyAjaxLogin extends WP_Widget {
	    function NinetyAjaxLogin() {  
	        $widget_ops = array('description' => __( 'An Ajax powered Login &amp; Register widget. See the ReadMe for customisation instructions.','ninety') );
			$this->WP_Widget('nd_ajax_login', __('SB Login','ninety'), $widget_ops);  
	    }
	    function widget($args, $instance) {
	        nd_login_widget($args);
	    }
	} 
	register_widget('NinetyAjaxLogin');
}
add_action('init', 'nd_login_init', 1);

###[ Load Templates ]###############################################NINETY#DEGREES####

function nd_login_load_template( $name ) {
	global $nd_login_vars;
	if (file_exists(TEMPLATEPATH . '/sb-login/' . $name)) include( TEMPLATEPATH . '/sb-login/' . $name ); else include( $nd_login_vars['plugin_path'] . '/template/' . $name );
}

###[ Shortcode ]###############################################WebCareZone.com####

add_shortcode( 'sblogin', 'nd_login_widget' );

###[ Widget ]###################################################NINETY#DEGREES####

function nd_login_widget($args) {
	global $before_title, $after_title;
	
	// extract($args);	
	
	echo $before_widget;	
	
	if (is_user_logged_in()) :
		nd_login_load_template( 'tabs.php' );
		nd_login_load_template( 'logged-in.php' );
	else :
		
		nd_login_load_template( 'tabs.php' );
		nd_login_load_template( 'login-form.php' );
		if (get_option('users_can_register')) nd_login_load_template( 'register-form.php' );
		nd_login_load_template( 'lost-password-form.php' );

	endif;		
	echo $after_widget;
}

###[ Option Page ]###############################################WebCareZone.com####

if(is_admin())
include 'sbl_admin.php';

###[ Proces Login/Register ]###################################################NINETY#DEGREES####

function nd_login_process() {
	
	global $nd_login_errors, $nd_reg_errors, $nd_lost_pass_errors;
	
	if (isset($_POST['nd_login']) && $_POST['nd_login']) :
		$nd_login_errors = nd_handle_login();
	elseif ( get_option('users_can_register') && isset($_POST['nd_register']) && $_POST['nd_register'] ) :
		$nd_reg_errors = nd_handle_register();
	elseif (isset($_POST['nd_lostpass']) && $_POST['nd_lostpass']) :
		$nd_lost_pass_errors = nd_handle_lost_password();
	endif;
	
}
add_action('init', 'nd_login_process');

function nd_handle_login() {
	
	if ( isset( $_REQUEST['redirect_to'] ) ) $redirect_to = $_REQUEST['redirect_to'];
	else $redirect_to = admin_url();
		
	if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) ) $secure_cookie = false;
	else $secure_cookie = '';

	$user = wp_signon('', $secure_cookie);
	
	// Check the username
	if ( !$_POST['log'] ) :
		$user = new WP_Error();
		$user->add('empty_username', __('<strong>ERROR</strong>: Please enter a username.', 'ninety'));
	elseif ( !$_POST['pwd'] ) :
		$user = new WP_Error();
		$user->add('empty_username', __('<strong>ERROR</strong>: Please enter your password.', 'ninety'));
	endif;

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);
	
	$redirect_to = apply_filters('nd_login_redirect', $redirect_to );
	
	if ( !is_wp_error($user) ) nd_update_user_meta( $user->ID );
	
	if (nd_is_ajax()) :
		if ( !is_wp_error($user) ) :
			echo 'SUCCESS';
		else :
			foreach ($user->errors as $error) {
				echo $error[0];
				break;
			}
		endif;
		exit;
	else :
		if ( !is_wp_error($user) ) :
			wp_redirect($redirect_to);
			exit;
		endif;
	endif;
	return $user;
}

function nd_handle_register() {
	
	$posted = array();
	$errors = new WP_Error();
	$user_pass = wp_generate_password();
		
	require_once( ABSPATH . WPINC . '/registration.php');
		
	// Get (and clean) data
	$fields = array(
		'username',
		'email',
		'password',
		'password2'
	);
	foreach ($fields as $field) {
		if (isset($_POST[$field])) $posted[$field] = stripslashes(trim($_POST[$field])); else $posted[$field] = '';
	}
		
	$user_login = sanitize_user( $posted['username'] );
	$user_email = apply_filters( 'user_registration_email', $posted['email'] );
			
	// Check the username
	if ( $posted['username'] == '' )
		$errors->add('empty_username', __('<strong>ERROR</strong>: Please enter a username.', 'ninety'));
	elseif ( !validate_username( $posted['username'] ) )
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.', 'ninety'));
	elseif ( username_exists( $posted['username'] ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: This username is already registered, please choose another one.', 'ninety'));
		
	// Check the e-mail address
	if ($posted['email'] == '')
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.', 'ninety'));
	elseif ( !is_email( $posted['email'] ) )
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.', 'ninety'));
	elseif ( email_exists( $posted['email'] ) )
		$errors->add('email_exists', __('<strong>ERROR</strong>: This email is already registered, please choose another one.', 'ninety'));
			
	// Check Passwords match
	if ($posted['password'] == '')
		$errors->add('empty_password', __('<strong>ERROR</strong>: Please enter a password.', 'ninety'));
	elseif ($posted['password'] !== $posted['password2'])
		$errors->add('wrong_password', __('<strong>ERROR</strong>: Passwords do not match.', 'ninety'));
	else
		$user_pass = $posted['password'];
			
	do_action('register_post', $posted['username'], $posted['email'], $errors);
	$errors = apply_filters( 'registration_errors', $errors, $posted['username'], $posted['email'] );
	
	if ( !$errors->get_error_code() ) :
		$user_id = wp_create_user(  $posted['username'], $user_pass, $posted['email'] );
		if ( !$user_id ) :
			$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'ninety'), get_option('admin_email')));
		else :
			$secure_cookie = is_ssl() ? true : false;
		    wp_set_auth_cookie($user_id, true, $secure_cookie);
		    wp_new_user_notification( $user_id, $user_pass );
		    nd_update_user_meta( $user_id );
		endif;
	endif;
	
    if (nd_is_ajax()) :
		if ( !$errors->get_error_code() ) :
			echo 'SUCCESS';
		else :
			foreach ($errors->errors as $error) {
				echo $error[0];
				break;
			}
		endif;
		exit;
	else :
		if ( !is_wp_error($user) ) :
		    wp_redirect( nd_login_current_url() );
		    exit;
		endif;
	endif;
	return $errors;
}

function nd_handle_lost_password() {
	
	global $wpdb, $current_site;

	$errors = new WP_Error();

	if ( empty( $_POST['username_or_email'] ) ) $errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.', 'ninety'));

	if ( strpos($_POST['username_or_email'], '@') ) {
		$user_data = get_user_by_email(trim($_POST['username_or_email']));
		if ( empty($user_data) ) $errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.', 'ninety'));
	} else {
		$login = trim($_POST['username_or_email']);
		$user_data = get_userdatabylogin($login);
	}

	do_action('lostpassword_post');
	
	if ( !$user_data ) $errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.', 'ninety'));

	if (nd_is_ajax()) :
		if ( $errors->get_error_code() ) :
			foreach ($errors->errors as $error) {
				echo $error[0];
				break;
			}
			exit;
		endif;
	else :
		if ( $errors->get_error_code() ) return $errors;
	endif;

	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retrieve_password', $user_login);

	$allow = apply_filters('allow_password_reset', true, $user_data->ID);
	
	if ( !$allow ) $errors->add('no_password_reset', __('Password reset is not allowed for this user', 'ninety'));
	else if ( is_wp_error($allow) ) $errors = $allow;
	
	if (nd_is_ajax()) :
		if ( $errors->get_error_code() ) :
			foreach ($errors->errors as $error) {
				echo $error[0];
				break;
			}
			exit;
		endif;
	else :
		if ( $errors->get_error_code() ) return $errors;
	endif;

	$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
	if ( empty($key) ) {
		// Generate something random for a key...
		$key = wp_generate_password(20, false);
		do_action('retrieve_password_key', $user_login, $key);
		// Now insert the new md5 key into the db
		$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
	}
	$message = __('Someone has asked to reset the password for the following site and username.', 'ninety') . "\r\n\r\n";
	$message .= network_site_url() . "\r\n\r\n";
	$message .= sprintf(__('Username: %s', 'ninety'), $user_login) . "\r\n\r\n";
	$message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.', 'ninety') . "\r\n\r\n";
	$message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";

	if ( is_multisite() ) $blogname = $GLOBALS['current_site']->site_name;
	else $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$title = sprintf( __('[%s] Password Reset', 'ninety'), $blogname );

	$title = apply_filters('retrieve_password_title', $title);
	$message = apply_filters('retrieve_password_message', $message, $key);

	wp_mail($user_email, $title, $message);
	
	if (nd_is_ajax()) :
		echo 'SUCCESS:'.__('Check your e-mail for the confirmation link.', 'ninety');
		exit;
	endif;
	
	return true;
}