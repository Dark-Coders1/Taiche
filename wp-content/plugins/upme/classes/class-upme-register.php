<?php

class UPME_Register {

    function __construct() {

        /*  Handling the register on standalone sites and multi sites */
        if (is_multisite ()) {
            add_action('init', array($this, 'handle_init'));
        } else {
            $this->handle_init();
        }

        add_action('init', array($this, 'upme_password_nag_handler'));
    }

    /* Prepare user meta */

    function prepare($array) {
        foreach ($array as $k => $v) {
            if ($k == 'upme-register')
                continue;
            $this->usermeta[$k] = $v;
        }
        return $this->usermeta;
    }

    /* Handle/return any errors */

    function handle() {
        global $upme_captcha_loader;
        require_once(ABSPATH . 'wp-includes/pluggable.php');

        if (get_option('users_can_register') == '1') {
            foreach ($this->usermeta as $key => $value) {

                /* Validate username */
                if ($key == 'user_login') {
                    if (esc_attr($value) == '') {
                        $this->errors[] = __('Please enter a username.', 'upme');
                    } elseif (username_exists($value)) {
                        $this->errors[] = __('This username is already registered. Please choose another one.', 'upme');
                    }
                }

                /* Validate email */
                if ($key == 'user_email') {
                    if (esc_attr($value) == '') {
                        $this->errors[] = __('Please type your e-mail address.', 'upme');
                    } elseif (!is_email($value)) {
                        $this->errors[] = __('The email address isn\'t correct.', 'upme');
                    } elseif (email_exists($value)) {
                        $this->errors[] = __('This email is already registered, please choose another one.', 'upme');
                    }
                }
            }

            if (!is_in_post('no_captcha', 'yes')) {
                if (!$upme_captcha_loader->validate_captcha(post_value('captcha_plugin'))) {
                    $this->errors[] = __('Please complete Captcha Test first.', 'upme');
                }
            }
        } else {
            $this->errors[] = __('Registration is disabled for this site.', 'upme');
        }
    }

    /* Create user */

    function create() {
        require_once(ABSPATH . 'wp-includes/pluggable.php');


        /* Create profile when there is no error */
        if (!isset($this->errors)) {

            // Set date format from admin settings
            $upme_settings = get_option('upme_options');
            $upme_date_format = (string) isset($upme_settings['date_format']) ? $upme_settings['date_format'] : 'mm/dd/yy';

            /* Create account, update user meta */
            $sanitized_user_login = sanitize_user($_POST['user_login']);

            /* Get password */
            if (isset($_POST['user_pass']) && $_POST['user_pass'] != '') {
                $user_pass = $_POST['user_pass'];
            } else {
                $user_pass = wp_generate_password(12, false);
            }

            /* New user */
            $user_id = wp_create_user($sanitized_user_login, $user_pass, $_POST['user_email']);
            if (!$user_id) {
                
            } else {

                // Get profile fields
                $profile_fields = get_option('upme_profile_fields');

                // Get list of dattime fields
                $date_time_fields = array();

                foreach ($profile_fields as $key => $field) {
                    extract($field);

                    // Filter date/time custom fields
                    if (isset($profile_fields[$key]['field']) && $profile_fields[$key]['field'] == 'datetime') {
                        array_push($date_time_fields, $profile_fields[$key]['meta']);
                    }
                }

                /* Now update all user meta */
                foreach ($this->usermeta as $key => $value) {

                    // save checkboxes
                    if (is_array($value)) { // checkboxes
                        $value = implode(', ', $value);
                    }

                    if (in_array($key, $date_time_fields)) {
                        $formatted_date = upme_date_format_to_standerd($value, $upme_date_format);
                        $value = $formatted_date;
                    }


                    update_user_meta($user_id, $key, esc_attr($value));

                    /* update core fields - email, url, pass */
                    if (in_array($key, array('user_email', 'user_url', 'display_name'))) {
                        wp_update_user(array('ID' => $user_id, $key => esc_attr($value)));
                    }
                }
            }

            // Set the password nag when user selected password setting is disabled
            $upme_settings = get_option('upme_options');
            $set_pass = (boolean) $upme_settings['set_password'];
            if (!$set_pass) {
                update_user_option($user_id, 'default_password_nag', true, true); //Set up the Password change nag.
            }

            // Set automatic login based on the setting value in admin
            if ($this->validate_automatic_login()) {
                wp_set_auth_cookie($user_id, false, is_ssl());
            }

            /* action after Account Creation */
            do_action('upme_user_register', $user_id);

            wp_new_user_notification($user_id, $user_pass);
        }
    }

    /* Get errors display */

    function get_errors() {
        global $upme;
        $display = null;

        $error_result = array();

        if (isset($this->errors) && count($this->errors) > 0) {
            $display .= '<div class="upme-errors">';
            foreach ($this->errors as $newError) {

                $display .= '<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i>' . $newError . '</span>';
            }
            $display .= '</div>';

            $error_result['status'] = "error";
            $error_result['display'] = $display;
        } else {

            $this->registered = 1;

            $upme_settings = get_option('upme_options');

            // Display custom registraion message
            if (isset($upme_settings['msg_register_success']) && !empty($upme_settings['msg_register_success'])) {
                $display .= '<div class="upme-success"><span><i class="upme-icon-ok"></i>' . remove_script_tags($upme_settings['msg_register_success']) . '</span></div>';
            } else {
                $display .= '<div class="upme-success"><span><i class="upme-icon-ok"></i>' . __('Registration successful. Please check your email.', 'upme') . '</span></div>';
            }

            // Add text/HTML setting to be displayed after registration message
            if (isset($upme_settings['html_register_success_after']) && !empty($upme_settings['html_register_success_after'])) {
                $display .= '<div class="upme-success-html">' . remove_script_tags($upme_settings['html_register_success_after']) . '</div>';
            }


            if (isset($_POST['redirect_to'])) {
                wp_redirect($_POST['redirect_to']);
            } else {
                // Redirect to profile page after registration when automatic login is set to true
                if ($this->validate_automatic_login()) {
                    // Redirect to custom page based on the values provided in settings section

                    $register_redirect_page_id = (int) isset($upme_settings['register_redirect_page_id']) ? $upme_settings['register_redirect_page_id'] : 0;
                    if ($register_redirect_page_id) {
                        $url = get_permalink($register_redirect_page_id);
                        wp_redirect($url);
                    }
                }
            }

            $error_result['status'] = "success";
            $error_result['display'] = $display;
        }
        return $error_result;
    }

    /* Initializing login class on init action */

    function handle_init() {
        /* Form is fired */

        if (isset($_POST['upme-register-form'])) {

            /* Prepare array of fields */
            $this->prepare($_POST);

            /* Validate, get errors, etc before we create account */
            $this->handle();

            /* Create account */
            $this->create();
        }
    }

    // Valdate automatic login based on set password
    function validate_automatic_login() {

        $automatic_login_status = FALSE;

        $upme_settings = get_option('upme_options');

        $set_pass = (boolean) $upme_settings['set_password'];
        $automatic_login = (boolean) $upme_settings['automatic_login'];

        if ($set_pass && $automatic_login) {
            $automatic_login_status = TRUE;
        }
        return $automatic_login_status;
    }

    function disable_password_nag($current_status) {
        return 0;
    }

    // Disable password nag notice in the admin for user setup passwords
    function upme_password_nag_handler() {

        if (is_user_logged_in ()) {
            $current_user = wp_get_current_user();

            if (!get_user_option('default_password_nag', $current_user->ID)) {
                add_filter('get_user_option_default_password_nag', array($this, 'disable_password_nag'));
            }
        }
    }

}

$upme_register = new UPME_Register();

