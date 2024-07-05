<?php

class UPME_Save {

    public $allowed_extensions;
    public $usermeta;

    function __construct() {

        /*  Handling the profile save on standalone sites and multi sites */
        if (is_multisite ()) {
            add_action('init', array($this, 'handle_init'));
        } else {
            $this->handle_init();
        }
    }

    /* Prepare user meta */

    function prepare($array) {
        foreach ($array as $k => $v) {
            $k = str_replace('-' . $this->userid, '', $k);
            if ($k == 'upme-submit')
                continue;
            $this->usermeta[$k] = $v;
        }
        return $this->usermeta;
    }

    /* Process uploads */

    function process_upload($array) {

        /* File upload conditions */
        $this->allowed_extensions = array("image/gif", "image/jpeg", "image/png");

        $settings = get_option('upme_options');

        // Set default to 500KB
        $this->max_size = 512000;

        // Setting Max File Size set from admin
        if (isset($settings['avatar_max_size']) && $settings['avatar_max_size'] > 0)
            $this->max_size = $settings['avatar_max_size'] * 1024 * 1024;

        if (isset($_FILES)) {
            foreach ($_FILES as $key => $array) {
                extract($array);
                if ($name) {

                    // Security Check Start
                    // Checking for Image size. If this is the real image (not tempered) then this function will return width and height and other values in return.
                    $image_data = getimagesize($tmp_name);

                    $clean_file = true;
                    if (!isset($image_data[0]) || !isset($image_data[1]))
                        $clean_file = false;
                    // Security Check End



                    $clean_key = str_replace('-' . $this->userid, '', $key);
                    if (!in_array($type, $this->allowed_extensions)) {
                        $this->errors[$clean_key] = __('The image file extention is not allowed!', 'upme');
                    } elseif ($size > $this->max_size) {
                        $this->errors[$clean_key] = __('The file you have selected exceeds the maximun allowed image size.', 'upme');
                    } elseif ($clean_file == false) {
                        $this->errors[$clean_key] = __('The file you selected appears to be corrupt or not a real image file.', 'upme');
                    } else {

                        /* Upload image */
                        // Checking for valid uploads folder
                        if($upload_dir = upme_get_uploads_folder_details()){
                                $target_path = $upload_dir['basedir']."/upme/";

                        // Checking for upload directory, if not exists then new created.
                        if (!is_dir($target_path))
                            mkdir($target_path, 0777);

                        $target_path = $target_path . time() . '_' . basename($name);

                        $nice_url = $upload_dir['baseurl'] ."/upme/";
                        $nice_url = $nice_url . time() . '_' . basename($name);
                        move_uploaded_file($tmp_name, $target_path);

                        /* Now we have the nice url */
                        /* Store in usermeta */
                        update_user_meta($this->userid, $clean_key, $nice_url);
                        }
                        
                        
                        
                    }
                }
            }
        }
    }

    /* Handle/return any errors */

    function handle() {
        if(is_array($this->usermeta)){
        foreach ($this->usermeta as $key => $value) {

            /* Validate email */
            if ($key == 'user_email') {
                if (!is_email($value)) {
                    $this->errors[$key] = __('E-mail address was not updated. Please enter a valid e-mail.', 'upme');
                }
            }

            /* Validate password */
            if ($key == 'user_pass') {
                if (esc_attr($value) != '') {
                    if ($this->usermeta['user_pass'] != $this->usermeta['user_pass_confirm']) {
                        $this->errors[$key] = __('Your passwords do not match.', 'upme');
                    }
                }
            }
        }
    }
    }

    /* Update user meta */

    function update() {
        require_once(ABSPATH . 'wp-includes/pluggable.php');

        // empty checkboxes
        $array = get_option('upme_profile_fields');

        // Get list of dattime fields
        $date_time_fields = array();

        foreach ($array as $key => $field) {
            extract($field);

            if (isset($array[$key]['field']) && $array[$key]['field'] == 'checkbox') {
                update_user_meta($this->userid, $meta, null);
            }

            // Filter date/time custom fields
            if (isset($array[$key]['field']) && $array[$key]['field'] == 'datetime') {
                array_push($date_time_fields, $array[$key]['meta']);
            }
        }


        if(is_array($this->usermeta)){
        foreach ($this->usermeta as $key => $value) {

            /* Update profile when there is no error */
            if (!isset($this->errors[$key])) {

                // save checkboxes
                if (is_array($value)) { // checkboxes
                    $value = implode(', ', $value);
                }

                //
                // Set date format from admin settings
                $upme_settings = get_option('upme_options');
                $upme_date_format = (string) isset($upme_settings['date_format']) ? $upme_settings['date_format'] : 'mm/dd/yy';

                if (in_array($key, $date_time_fields)) {
                    $formatted_date = upme_date_format_to_standerd($value, $upme_date_format);
                    $value = $formatted_date;
                }

                update_user_meta($this->userid, $key, esc_attr($value));

                /* update core fields - email, url, pass */
                if ((in_array($key, array('user_email', 'user_url', 'display_name')) ) || ($key == 'user_pass' && esc_attr($value) != '')) {
                    wp_update_user(array('ID' => $this->userid, $key => esc_attr($value)));
                }
            }
        }
    }
    }

    /* Get errors display */

    function get_errors($id) {
        global $upme;
        $display = null;
        if (isset($this->errors) && count($this->errors) > 0) {
            $display .= '<div class="upme-errors">';
            foreach ($this->errors as $newError) {
                $display .= '<span class="upme-error"><i class="upme-icon-remove"></i>' . $newError . '</span>';
            }
            $display .= '</div>';
        } else {
            /* Success message */
            if ($id == $upme->logged_in_user) {
                $display .= '<div class="upme-success"><span><i class="upme-icon-ok"></i>' . __('Your profile was updated.', 'upme') . '</span></div>';
            } else {
                $display .= '<div class="upme-success"><span><i class="upme-icon-ok"></i>' . __('Profile was updated.', 'upme') . '</span></div>';
            }

            
        }
        return $display;
    }

    /* Initializing login class on init action  */

    function handle_init() {
        /* Form is fired */
        foreach ($_POST as $k => $v) {
            if (strstr($k, 'upme-submit-')) {

                // User ID
                $this->userid = str_replace('upme-submit-', '', $k);

                // Prepare fields prior to update
                $this->prepare($_POST);

                // upload files
                $this->process_upload($_FILES);

                // Error handler
                $this->handle();

                // Update fields
                $this->update();

                /* action after save profile */
                do_action('upme_profile_update',$this->userid);
                
                
            } else if(strstr($k, 'upme-upload-submit-')){

                // User ID
                $this->userid = str_replace('upme-upload-submit-', '', $k);

                // upload files
                $this->process_upload($_FILES);

            } else if(strstr($k, 'upme-crop-submit-')){

                // User ID
                $this->userid = str_replace('upme-crop-submit-', '', $k);

            }


        }
    }

}

$upme_save = new UPME_Save();