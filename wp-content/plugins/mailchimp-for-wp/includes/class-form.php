<?php

class MC4WP_Lite_Form {
	private static $instance = null;
	private $form_instance_number = 1;
	private $error = null;
	private $success = false;
	private $submitted_form_instance = 0;

	public static function init() {
		if(self::$instance) {
			throw new Exception("Already initialized");
		} else {
			self::$instance = new self;
		}
	}

	public static function instance() {
		return self::$instance;
	}

	private function __construct() {
		$opts = mc4wp_get_options('form');

		if($opts['css']) {
			add_filter('mc4wp_stylesheets', array($this, 'add_stylesheets'));
		}

		add_shortcode( 'mc4wp_form', array( $this, 'output_form' ) );
		add_shortcode( 'mc4wp-form', array( $this, 'output_form' ) );

		// enable shortcodes in text widgets
		add_filter( 'widget_text', 'shortcode_unautop' );
		add_filter( 'widget_text', 'do_shortcode', 11 );

		if ( isset( $_POST['mc4wp_form_submit'] ) ) {
			$this->ensure_backwards_compatibility();
			add_action( 'init', array( $this, 'submit' ) );
			add_action( 'wp_footer', array( $this, 'print_scroll_js' ), 99);
		}

		add_action( 'wp_enqueue_scripts', array($this, 'register_scripts' ) );
	}

	public function register_scripts()
	{
		wp_register_script( 'mc4wp-placeholders', plugins_url('mailchimp-for-wp/assets/js/placeholders.min.js'), array(), MC4WP_LITE_VERSION, true );
	}

	public function add_stylesheets($stylesheets) {
		$opts = mc4wp_get_options('form');

		$stylesheets['form'] = 1;

		// theme?
		if($opts['css'] != 1 && $opts['css'] != 'default') {
			$stylesheets['form-theme'] = $opts['css'];
		}

		return $stylesheets;
	}

	public function output_form( $atts, $content = null ) {
		$opts = mc4wp_get_options('form');

		if ( !function_exists( 'mc4wp_replace_variables' ) ) {
			include_once MC4WP_LITE_PLUGIN_DIR . 'includes/template-functions.php';
		}

		// add some useful css classes
		$css_classes = ' ';
		if ( $this->error ) $css_classes .= 'mc4wp-form-error ';
		if ( $this->success ) $css_classes .= 'mc4wp-form-success ';

		$content = "\n<!-- Form by MailChimp for WordPress plugin v". MC4WP_LITE_VERSION ." - http://dannyvankooten.com/mailchimp-for-wordpress/ -->\n";
		$content .= '<form method="post" action="'. mc4wp_get_current_url() .'" id="mc4wp-form-'.$this->form_instance_number.'" class="mc4wp-form form'.$css_classes.'">';

		// maybe hide the form
		if ( !( $this->success && $opts['hide_after_success'] ) ) {
			$form_markup = __( $opts['markup'] );

			// replace special values
			$form_markup = str_replace( array( '%N%', '{n}' ), $this->form_instance_number, $form_markup );
			$form_markup = mc4wp_replace_variables( $form_markup, array_values( $opts['lists'] ) );
			$form_markup = apply_filters('mc4wp_form_content', $form_markup);
			$content .= $form_markup;

			// hidden fields
			$content .= '<textarea name="mc4wp_required_but_not_really" style="display: none;"></textarea>';
			$content .= '<input type="hidden" name="mc4wp_form_submit" value="1" />';
			$content .= '<input type="hidden" name="mc4wp_form_instance" value="'. $this->form_instance_number .'" />';
			$content .= '<input type="hidden" name="mc4wp_form_nonce" value="'. wp_create_nonce( '_mc4wp_form_nonce' ) .'" />';
		}

		if ( $this->form_instance_number == $this->submitted_form_instance ) {

			if ( $this->success ) {
				$content .= '<div class="mc4wp-alert mc4wp-success">' . __( $opts['text_success'] ) . '</div>';
			} elseif ( $this->error ) {

				$api = mc4wp_get_api();
				$e = $this->error;

				if ( $e == 'already_subscribed' ) {
					$text = ( empty( $opts['text_already_subscribed'] ) ) ? $api->get_error_message() : $opts['text_already_subscribed'];
					$content .= '<div class="mc4wp-alert mc4wp-notice">'. __( $text ) .'</div>';
				} elseif ( isset( $opts['text_' . $e] ) && !empty( $opts['text_'. $e] ) ) {
					$content .= '<div class="mc4wp-alert mc4wp-error">' . __( $opts['text_' . $e] ) . '</div>';
				}

				if ( current_user_can( 'manage_options' ) ) {

					if ( $api->has_error() ) {
						$content .= '<div class="mc4wp-alert mc4wp-error"><strong>Admin notice:</strong> '. $api->get_error_message() . '</div>';
					}
				}

			}
			// endif
		}

		if ( current_user_can( 'manage_options' ) && empty( $opts['lists'] ) ) {
			$content .= '<div class="mc4wp-alert mc4wp-error"><strong>Admin notice:</strong> you have not selected a MailChimp list for this sign-up form to subscribe to yet. <a href="'. admin_url( 'admin.php?page=mc4wp-lite-form-settings' ) .'">Edit your form settings</a> and select at least 1 list.</div>';
		}

		$content .= "</form>";
		$content .= "\n<!-- / MailChimp for WP Plugin -->\n";

		// increase form instance number in case there is more than one form on a page
		$this->form_instance_number++;

		// make sure scripts are enqueued later
		global $is_IE;
		if(isset($is_IE) && $is_IE) {
			wp_enqueue_script('mc4wp-placeholders');
		}

		return $content;
	}

	public function submit() {
		$opts = mc4wp_get_options('form');
		$this->submitted_form_instance = (int) $_POST['mc4wp_form_instance'];

		if ( !isset( $_POST['mc4wp_form_nonce'] ) || !wp_verify_nonce( $_POST['mc4wp_form_nonce'], '_mc4wp_form_nonce' ) ) {
			$this->error = 'invalid_nonce';
			return false;
		}

		if ( !isset( $_POST['EMAIL'] ) || !is_email( $_POST['EMAIL'] ) ) {
			// no (valid) e-mail address has been given
			$this->error = 'invalid_email';
			return false;
		}

		if ( isset( $_POST['mc4wp_required_but_not_really'] ) && !empty( $_POST['mc4wp_required_but_not_really'] ) ) {
			// spam bot filled the honeypot field
			return false;
		}

		$email = $_POST['EMAIL'];

		// setup merge vars
		$merge_vars = array();

		foreach ( $_POST as $name => $value ) {

			// only add uppercases fields to merge variables array
			if ( !empty( $name ) && $name == 'EMAIL' || $name !== strtoupper( $name ) ) { continue; }

			if ( $name === 'GROUPINGS' ) {

				$groupings = $value;

				// malformed
				if ( !is_array( $groupings ) ) { continue; }

				// setup groupings array
				$merge_vars['GROUPINGS'] = array();

				foreach ( $groupings as $grouping_id_or_name => $groups ) {

					$grouping = array();

					if ( is_numeric( $grouping_id_or_name ) ) {
						$grouping['id'] = $grouping_id_or_name;
					} else {
						$grouping['name'] = $grouping_id_or_name;
					}

					if ( !is_array( $groups ) ) {
						$grouping['groups'] = explode( ',', $groups );
					} else {
						$grouping['groups'] = $groups;
					}

					// add grouping to array
					$merge_vars['GROUPINGS'][] = $grouping;
				}

				if ( empty( $merge_vars['GROUPINGS'] ) ) { unset( $merge_vars['GROUPINGS'] ); }

			} else {
				$merge_vars[$name] = $value;
			}

		}

		$result = $this->subscribe( $email, $merge_vars );

		if ( $result === true ) {
			$this->success = true;

			// check if we want to redirect the visitor
			if ( !empty( $opts['redirect'] ) ) {
				wp_redirect( $opts['redirect'] );
				exit;
			}

			return true;
		} else {

			$this->success = false;
			$this->error = $result;

			return false;
		}
	}

	/*
		Ensure backwards compatibility so sign-up forms that contain old form mark-up rules don't break
		- Uppercase $_POST variables that should be sent to MailChimp
		- Format GROUPINGS in one of the following formats.
			$_POST[GROUPINGS][$group_id] = "Group 1, Group 2"
			$_POST[GROUPINGS][$group_name] = array("Group 1", "Group 2")
	*/
	public function ensure_backwards_compatibility() {

		// upercase $_POST variables
		foreach ( $_POST as $name => $value ) {

			// skip mc4wp internal vars
			if ($name == strtoupper($name) || in_array( $name, array( 'mc4wp_form_instance', 'mc4wp_form_nonce', 'mc4wp_required_but_not_really', 'mc4wp_form_submit' ) ) ) {
				continue;
			}

			$ucname = strtoupper( $name );
			$_POST[$ucname] = $value;
			unset( $_POST[$name] );
		}

		// detect old style GROUPINGS, then fix it.
		if ( isset( $_POST['GROUPINGS'] ) && is_array( $_POST['GROUPINGS'] ) && isset( $_POST['GROUPINGS'][0] ) ) {

			$old_groupings = $_POST['GROUPINGS'];
			unset( $_POST['GROUPINGS'] );
			$new_groupings = array();

			foreach ( $old_groupings as $grouping ) {

				if(!isset($grouping['groups'])) { continue; }

				if ( isset( $grouping['id'] ) ) {
					$key = $grouping['id'];
				} else if(isset( $grouping['name'] ) ) { 
					$key = $grouping['name'];
				} else { 
					continue; 
				}

				$new_groupings[$key] = $grouping['groups'];

			}

			// re-fill $_POST array with new groupings
			if ( !empty( $new_groupings ) ) { $_POST['GROUPINGS'] = $new_groupings; }

		}

		return;
	}

	public function subscribe( $email, array $merge_vars = array() ) {
		$api = mc4wp_get_api();
		$opts = mc4wp_get_options('form');

		$lists = $opts['lists'];

		if ( empty( $lists ) ) {
			return 'no_lists_selected';
		}

		// guess FNAME and LNAME
		if ( isset( $merge_vars['NAME'] ) && !isset( $merge_vars['FNAME'] ) && !isset( $merge_vars['LNAME'] ) ) {

			$strpos = strpos( $merge_vars['NAME'], ' ' );

			if ( $strpos ) {
				$merge_vars['FNAME'] = trim( substr( $merge_vars['NAME'], 0, $strpos ) );
				$merge_vars['LNAME'] = trim( substr( $merge_vars['NAME'], $strpos ) );
			} else {
				$merge_vars['FNAME'] = $merge_vars['NAME'];
			}
		}

		do_action('mc4wp_before_subscribe', $email, $merge_vars, 0);

		$result = false;
		$email_type = apply_filters('mc4wp_email_type', 'html');
		$lists = apply_filters('mc4wp_lists', $lists, $merge_vars);

		foreach ( $lists as $list_id ) {

			$list_merge_vars = apply_filters('mc4wp_merge_vars', $merge_vars, 0, $list_id);
			$result = $api->subscribe( $list_id, $email, $list_merge_vars, $email_type, $opts['double_optin'] );

			if($result === true) {
				$from_url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
				do_action('mc4wp_subscribe_form', $email, $list_id, 0, $merge_vars, $from_url); 
			}
		}

		do_action('mc4wp_after_subscribe', $email, $merge_vars, 0, $result);

		if ( $result === true ) {
			$this->success = true;
		} else {
			$this->success = false;
			$this->error = $result;
		}

		// flawed
		// this will only return the result of the last list a subscribe attempt has been sent to
		return $result;
	}

	public function print_scroll_js() {
		$form_id = $_POST['mc4wp_form_instance'];
		?><script type="text/javascript">(function(){var e=document.getElementById("mc4wp-form-<?php echo esc_js($form_id); ?>");if(!e){return}var t=0;var n=e;var r=window.innerHeight;if(n.offsetParent){do{t+=n.offsetTop}while(n=n.offsetParent)}else{t=e.offsetTop}if(r>e.clientHeight){t=t-(r-e.clientHeight)/2}if(window.jQuery!==undefined){var i=500+t;jQuery("html, body").animate({scrollTop:t},i)}else{window.scrollTo(0,t)}})()</script><?php
		/*?><script>
		(function() {
			var element = document.getElementById('mc4wp-form-<?php echo esc_js($form_id); ?>');

			if(!element) { 
				return; 
			}

			var scrollToHeight = 0;
			var obj = element;
			var windowHeight = window.innerHeight;

		    if (obj.offsetParent) {
		        do {
		            scrollToHeight += obj.offsetTop;
		       } while (obj = obj.offsetParent);
		    } else {
		    	scrollToHeight = element.offsetTop;
		    }

			if(windowHeight > element.clientHeight) {
				scrollToHeight = scrollToHeight - ((windowHeight - element.clientHeight) / 2);
			}
			
			if(window.jQuery !== undefined) {
				var animationTime = (500 + scrollToHeight);
				jQuery('html, body').animate({ scrollTop: scrollToHeight }, animationTime);
			} else {
				window.scrollTo(0, scrollToHeight);
			}
		})();
		</script>		
		<?php*/
	}

}
