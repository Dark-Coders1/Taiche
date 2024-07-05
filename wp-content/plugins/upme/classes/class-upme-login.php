<?php

class UPME_Login {

	function __construct() {

    /*  Handling the profile save on standalone sites and multi sites */
		if ( is_multisite() ) {
			add_action( 'init', array($this, 'handle_init' ) );
		}else{
			$this->handle_init();
		}
		

	}
	
	/*Prepare user meta*/
	function prepare ($array ) {
		foreach($array as $k => $v) {
			if ($k == 'upme-login') continue;
			$this->usermeta[$k] = $v;
		}
		return $this->usermeta;
	}
	
	/*Handle/return any errors*/
	function handle() {
	    global $upme_captcha_loader;
	    
		require_once(ABSPATH . 'wp-includes/pluggable.php');
		foreach($this->usermeta as $key => $value) {
		
			if ($key == 'user_login') {
				if (sanitize_user($value) == '') {
					$this->errors[] = __('The username field is empty.','upme');
				}
			}
			
			if ($key == 'user_pass') {
				if (esc_attr($value) == '') {
					$this->errors[] = __('The password field is empty.','upme');
				}
			}
		
		}
		
		// Check captcha first
		if(!is_in_post('no_captcha','yes'))
		{
		    if(!$upme_captcha_loader->validate_captcha(post_value('captcha_plugin')))
		    {
		        $this->errors[] = __('Please complete Captcha Test first.','upme');
		    }
		}
		
	
			/* attempt to signon */
			if (!is_array($this->errors)) {
				$creds = array();
				
				// Adding support for login by email
				if(is_email($_POST['user_login']))
				{
				    $user = get_user_by( 'email', $_POST['user_login'] );
				    
				    if(isset($user->data->user_login))
				        $creds['user_login'] = $user->data->user_login;
				    else
				        $creds['user_login'] = '';
				}
				// User is trying to login using username
				else
				    $creds['user_login'] = sanitize_user($_POST['user_login']);
				
				$creds['user_password'] = $_POST['login_user_pass'];
				$creds['remember'] = $_POST['rememberme'];
				
				$secure_cookie = false;
				if(is_ssl()){
					$secure_cookie = true;
				}

				$user = wp_signon( $creds, $secure_cookie );
				

				if ( is_wp_error($user) ) {
					if ($user->get_error_code() == 'invalid_username') {
						$this->errors[] = __('Invalid Username or Email','upme');
					}
					if ($user->get_error_code() == 'incorrect_password') {
						$this->errors[] = __('Incorrect Username or Password','upme');
					}
					
					if ($user->get_error_code() == 'empty_password') {
					    $this->errors[] = __('Please enter a password.','upme');
					}
					
					
				}
				 
				
			}
			
	}
	
	/*Get errors display*/
	function get_errors() {
		global $upme;
		$display = null;
		
		if (isset($this->errors) && is_array($this->errors))  
		{
		    $display .= '<div class="upme-errors">';
		
			foreach($this->errors as $newError) {
				
				$display .= '<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i>'.$newError.'</span>';
			
			}
		$display .= '</div>';
		} else {

                        // Get global login redirect settings
                        $upme_settings = get_option('upme_options');
                        $login_redirect_page_id = (int) isset($upme_settings['login_redirect_page_id']) ? $upme_settings['login_redirect_page_id'] : 0;
                        
			if (isset($_REQUEST['redirect_to']) && !empty($_REQUEST['redirect_to'])) {
				$url = $_REQUEST['redirect_to'];
			} elseif (isset($_POST['redirect_to']) && !empty($_POST['redirect_to']) ) {
				$url = $_POST['redirect_to'];
			} elseif ($login_redirect_page_id) {
                                $url = get_permalink($login_redirect_page_id);
                        } else {
				$url = $_SERVER['REQUEST_URI'];
			}
			wp_redirect( $url );
		}
		return $display;
	}

    /* Initializing login class on init action  */
	function handle_init(){
		/*Form is fired*/
		if ( isset( $_POST['upme-login'] ) ) {

			/* Prepare array of fields */
			$this->prepare( $_POST );

			// Setting default to false;
			$this->errors = false;

			/* Validate, get errors, etc before we login a user */
			$this->handle();

		}
	}

}

$upme_login = new UPME_Login();