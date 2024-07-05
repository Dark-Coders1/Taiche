<?php

/*
 *  Added from version 1.8
 *
 */
add_action('admin_init', 'upme_upgrade_routine');

function upme_upgrade_routine() {


    $stored_version = get_option('upme_version');
    $current_version = upme_get_plugin_version();

    if (!$stored_version && $current_version) {
        update_option('upme_version', $current_version);
    }

    if (version_compare($current_version, $stored_version) == 0) {
        return;
    }


    // @TO DO Change Version No. on each upgrade
    if (version_compare('1.9.3', $stored_version) >= 0) {

        upme_upgrade_1_8();
    }

    if (version_compare('2.0.0', $stored_version) >= 0) {
        upme_upgrade_2_0();
    }

    if (version_compare('2.0.1', $stored_version) >= 0) {
        upme_upgrade_2_0_1();
    }
	
    if (version_compare('2.0.2', $stored_version) >= 0) {
        upme_upgrade_2_0_2();
    }

    if (version_compare('2.0.3', $stored_version) >= 0) {
        upme_upgrade_2_0_3();
    }

    update_option('upme_version', $current_version);
}

function upme_upgrade_1_8() {

    if (empty($GLOBALS['wp_rewrite'])) {
        $GLOBALS['wp_rewrite'] = new WP_Rewrite();
    }

    // Getting current UPME Options
    $current_option = get_option('upme_options');



    if (!isset($current_option['profile_page_id']) || $current_option['profile_page_id'] == 0) {
        // Get default page created by UPME of earlier version
        $id = get_option('upme_profile_page');

        if (isset($id) && $id > 0) {
            // Page is still exists
            $current_option['profile_page_id'] = $id;
        } else {
            // Inserting Profile page
            $profile_data = array(
                'post_title' => __('View Profile', 'upme'),
                'post_type' => 'page',
                'post_name' => 'profile',
                'post_content' => '[upme]',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => 1
            );
            $profile_page = wp_insert_post($profile_data, FALSE);

            if (isset($profile_page))
                $current_option['profile_page_id'] = $reg_page;
        }
    }

    if (!isset($current_option['registration_page_id']) || $current_option['registration_page_id'] == 0) {
        // Inserting Registration page
        $reg_data = array(
            'post_title' => __('Register', 'upme'),
            'post_type' => 'page',
            'post_name' => 'register',
            'post_content' => '[upme_registration]',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => 1
        );

        $reg_page = wp_insert_post($reg_data, FALSE);

        if (isset($reg_page))
            $current_option['registration_page_id'] = $reg_page;
    }

    if (!isset($current_option['login_page_id']) || $current_option['login_page_id'] == 0) {
        // Inserting Login Page
        $login_data = array(
            'post_title' => __('Login', 'upme'),
            'post_type' => 'page',
            'post_name' => 'login',
            'post_content' => '[upme_login]',
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => 1
        );

        $login_page = wp_insert_post($login_data, FALSE);

        if (isset($login_page))
            $current_option['login_page_id'] = $login_page;
    }

    // Adding registration closed message
    if (!isset($current_option['html_registration_disabled']) || (isset($current_option['html_registration_disabled']) && $current_option['html_registration_disabled'] == ''))
        $current_option['html_registration_disabled'] = __('User registration is currently not allowed.', 'upme');

    if (!isset($current_option['captcha_label']) || (isset($current_option['captcha_label']) && $current_option['captcha_label'] == ''))
        $current_option['captcha_label'] = __('Human Check', 'upme');

    // Adding date format to upgrade routine
    if (!isset($current_option['date_format']) || (isset($current_option['date_format']) && $current_option['date_format'] == ''))
        $current_option['date_format'] = 'mm/dd/yy';

    // Updating UPME Option
    update_option('upme_options', $current_option);
}

// Version 2.0.0 upgrade routine
function upme_upgrade_2_0() {
    // Uploader folder upgrade routine 
    $upme_current_upload_path = upme_path . "uploads";
    if (is_dir($upme_current_upload_path)) {

        global $wpdb;

        $available_files = 0;
        $delete_files = 0;

        // Checking for valid uploads folder
        if (!( $upload_dir = wp_upload_dir() ))
            return false;

        $upload_base_dir = $upload_dir['basedir'];
        $upme_upgraded_upload_path = $upload_base_dir . "/upme/";
        $upme_upgraded_upload_url = $upload_dir['baseurl'] . "/upme/";

        $upme_current_upload_path = upme_path . "uploads/";
        $upme_current_upload_url = upme_url . "uploads/";

        // Check the existence of upme folder within uploads folder of the site
        if (wp_mkdir_p($upme_upgraded_upload_path)) {


            $source = $upme_current_upload_path;
            $destination = $upme_upgraded_upload_path;

            // Get array of  uploaded files
            $files = scandir($upme_current_upload_path);
            $files_delete = array();

            // Copy all the files into destination folder
            $available_files = array();
            foreach ($files as $file) {
                if (in_array($file, array(".", "..")))
                    continue;

                array_push($available_files, $source . $file);
                if (copy($source . $file, $destination . $file)) {
                    array_push($files_delete, $source . $file);
                }
            }

            $delete_files = count($files_delete);
            $available_files = count($available_files);
            // Delete all successfully-copied files
            foreach ($files_delete as $file) {
                unlink($file);
            }


            // Check whther all the files are moved to deffault uploads folder
            if (($available_files == $delete_files) && (0 != $available_files)) {

                // Filter the file fields used as profile fields
                $fields = get_option('upme_profile_fields');
                foreach ($fields as $field) {

                    if (isset($field['field']) && isset($field['meta']) && 'fileupload' == $field['field']) {

                        // Update the link location of images to new upload path
                        $sql = 'update ' . $wpdb->usermeta . ' set meta_value= REPLACE(meta_value, %s , %s) where meta_key=%s';

                        $result = $wpdb->query(
                                        $wpdb->prepare($sql, $upme_current_upload_url, $upme_upgraded_upload_url, $field['meta'])
                        );
                    }
                }
                // Remove upload directory once all the files have been transfered
                rmdir($upme_current_upload_path);
            }
        } else {
            echo '<p class="error">' . __('Upload folder creation failed.', 'upme') . '</p>';
        }
    }
}

function upme_upgrade_2_0_1() {
    // Option Update for Separator for Profile Viewing
    $current_option = get_option('upme_options');
    $current_option['show_separator_on_profile'] = '0';
    $current_option['show_empty_field_on_profile'] = '0';

    //Adding UPME Setting for Cron Usage
    $current_option['use_cron'] = '1';

    // Adding Cron Scheduled Task Start
    if (!wp_next_scheduled('upme_process_cache_cron')) {
        wp_schedule_event(time(), 'hourly', 'upme_process_cache_cron');
    }
    // Adding Cron Scheduled Task Ends
    // Updating UPME Option
    update_option('upme_options', $current_option);

    // Updating Meta Value for Separator
    $profile_fields = get_option('upme_profile_fields');

    foreach ($profile_fields as $key => $value) {
        if ($value['type'] == 'seperator') {
            $profile_fields[$key]['type'] = 'separator';
        }

        if ($profile_fields[$key]['type'] == 'separator') {
            $profile_fields[$key]['meta'] = upme_manage_string_for_meta($value['name']) . '_separator';
            $current_user = wp_get_current_user();

            // Updating User Meta for Admin User
            add_user_meta($current_user->ID, $profile_fields[$key]['meta'], '', false);
        }
    }

    update_option('upme_profile_fields', $profile_fields);

    /* Upgrade Routine to Create Cache for Meta Values for All Users */
    $users = get_users(array('fields' => 'ID'));

    foreach ($users as $key => $value) {
        upme_update_user_cache($value);
    }
}

function upme_upgrade_2_0_2() {
    // Adding UPME Setting for Hide Admin Bar on Frontend
    $current_option = get_option('upme_options');
    $current_option['hide_frontend_admin_bar'] = 'enabled';
    $current_option['profile_url_type'] = 1;
    update_option('upme_options', $current_option);

    flush_rewrite_rules();    
}

function upme_upgrade_2_0_3() {
    $current_option = get_option('upme_options');
    $current_option['profile_url_type'] = 1;
    update_option('upme_options', $current_option);

    flush_rewrite_rules();    
}


