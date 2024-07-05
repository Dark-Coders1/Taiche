<?php

class UPME {

    function __construct() {

        $this->logged_in_user = 0;
        $this->allow_search = false;
        $this->login_code_count = 0;

        $this->include_for_validation = array('text', 'textarea', 'select', 'radio', 'checkbox', 'password', 'datetime');
        $this->yes_true_array = array('yes', 'true');
        $this->method_mapping = array(
            'text' => 'text_box',
            'fileupload' => '',
            'textarea' => 'text_box',
            'select' => 'drop_down',
            'radio' => 'drop_down',
            'checkbox' => 'drop_down',
            'password' => '',
            'datetime' => 'text_box'
        );

        add_action('wp_enqueue_scripts', array(&$this, 'add_style_scripts_frontend'), 9);

        /* Allowed input types */
        $this->allowed_inputs = array(
            'text' => __('Text', 'upme'),
            'fileupload' => __('Image Upload', 'upme'),
            'textarea' => __('Textarea', 'upme'),
            'select' => __('Select Dropdown', 'upme'),
            'radio' => __('Radio', 'upme'),
            'checkbox' => __('Checkbox', 'upme'),
            'password' => __('Password', 'upme'),
            'datetime' => __('Date Picker', 'upme'),
            'video' => __('Video', 'upme')
        );

        /* Core registration fields */
        $set_pass = $this->get_option('set_password');
        if ($set_pass) {
            $this->registration_fields = array(
                50 => array(
                    'icon' => 'user',
                    'field' => 'text',
                    'type' => 'usermeta',
                    'meta' => 'user_login',
                    'name' => __('Username', 'upme'),
                    'required' => 1
                ),
                100 => array(
                    'icon' => 'envelope',
                    'field' => 'text',
                    'type' => 'usermeta',
                    'meta' => 'user_email',
                    'name' => __('E-mail', 'upme'),
                    'required' => 1,
                    'can_hide' => 1,
                ),
                150 => array(
                    'icon' => 'lock',
                    'field' => 'password',
                    'type' => 'usermeta',
                    'meta' => 'user_pass',
                    'name' => __('Password', 'upme'),
                    'required' => 1,
                    'can_hide' => 0,
                    'help' => __('Password must be at least 7 characters long. To make it stronger, use upper and lower case letters, numbers and symbols.', 'upme')
                ),
                200 => array(
                    'icon' => 0,
                    'field' => 'password',
                    'type' => 'usermeta',
                    'meta' => 'user_pass_confirm',
                    'name' => __('Confirm Password', 'upme'),
                    'required' => 1,
                    'can_hide' => 0,
                    'help' => __('Type your password again.', 'upme')
                ),
                250 => array(
                    'icon' => 0,
                    'field' => 'password_indicator',
                    'type' => 'usermeta'
                )
            );
        } else {
            $this->registration_fields = array(
                50 => array(
                    'icon' => 'user',
                    'field' => 'text',
                    'type' => 'usermeta',
                    'meta' => 'user_login',
                    'name' => __('Username', 'upme'),
                    'required' => 1
                ),
                100 => array(
                    'icon' => 'envelope',
                    'field' => 'text',
                    'type' => 'usermeta',
                    'meta' => 'user_email',
                    'name' => __('E-mail', 'upme'),
                    'required' => 1,
                    'can_hide' => 1,
                    'help' => __('A password will be e-mailed to you.', 'upme')
                )
            );
        }

        /* Core login fields */
        $this->login_fields = array(
            50 => array(
                'icon' => 'user',
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'user_login',
                'name' => __('Username or Email', 'upme'),
                'required' => 1
            ),
            100 => array(
                'icon' => 'lock',
                'field' => 'password',
                'type' => 'usermeta',
                'meta' => 'login_user_pass',
                'name' => __('Password', 'upme'),
                'required' => 1
            )
        );

        /* Setup profile fields */
        $this->fields = array(
            50 => array(
                'position' => '50',
                'type' => 'separator',
                'meta' => 'profile_info_separator',
                'name' => __('Profile Info', 'upme'),
                'private' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0
            ),
            60 => array(
                'position' => '60',
                'icon' => 'camera',
                'field' => 'fileupload',
                'type' => 'usermeta',
                'meta' => 'user_pic',
                'name' => __('Profile Picture', 'upme'),
                'can_hide' => 0,
                'can_edit' => 1,
                'private' => 0,
                'social' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            100 => array(
                'position' => '100',
                'icon' => 'user',
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'first_name',
                'name' => __('First Name', 'upme'),
                'can_hide' => 1,
                'can_edit' => 1,
                'private' => 0,
                'social' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            101 => array(
                'position' => '101',
                'icon' => 0,
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'last_name',
                'name' => __('Last Name', 'upme'),
                'can_hide' => 1,
                'can_edit' => 1,
                'private' => 0,
                'social' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            150 => array(
                'position' => '150',
                'icon' => 'user',
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'display_name',
                'name' => __('Display Name', 'upme'),
                'can_hide' => 0,
                'can_edit' => 1,
                'private' => 0,
                'social' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            200 => array(
                'position' => '200',
                'icon' => 'pencil',
                'field' => 'textarea',
                'type' => 'usermeta',
                'meta' => 'description',
                'name' => __('About / Bio', 'upme'),
                'can_hide' => 1,
                'can_edit' => 1,
                'private' => 0,
                'social' => 0,
                'deleted' => 0,
                'allow_html' => 1,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            210 => array(
                'position' => '210',
                'icon' => 'picture',
                'field' => 'fileupload',
                'type' => 'usermeta',
                'meta' => 'custom_pic',
                'name' => __('Custom Photo 1', 'upme'),
                'can_hide' => 0,
                'can_edit' => 1,
                'private' => 0,
                'social' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            250 => array(
                'position' => '250',
                'type' => 'separator',
                'meta' => 'contact_info_separator',
                'name' => __('Contact Info', 'upme'),
                'private' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0
            ),
            300 => array(
                'position' => '300',
                'icon' => 'envelope',
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'user_email',
                'name' => __('Email', 'upme'),
                'can_hide' => 1,
                'can_edit' => 1,
                'private' => 0,
                'social' => 1,
                'tooltip' => __('Send E-mail', 'upme'),
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            400 => array(
                'position' => '400',
                'icon' => 'link',
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'user_url',
                'name' => __('Website', 'upme'),
                'can_hide' => 1,
                'can_edit' => 1,
                'private' => 0,
                'social' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            450 => array(
                'position' => '450',
                'type' => 'separator',
                'meta' => 'social_profiles_separator',
                'name' => __('Social Profiles', 'upme'),
                'private' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0
            ),
            500 => array(
                'position' => '500',
                'icon' => 'facebook',
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'facebook',
                'name' => __('Facebook', 'upme'),
                'can_hide' => 1,
                'can_edit' => 1,
                'private' => 0,
                'social' => 1,
                'tooltip' => __('Connect via Facebook', 'upme'),
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            510 => array(
                'position' => '510',
                'icon' => 'twitter',
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'twitter',
                'name' => __('Twitter Username', 'upme'),
                'can_hide' => 1,
                'can_edit' => 1,
                'private' => 0,
                'social' => 1,
                'tooltip' => __('Connect via Twitter', 'upme'),
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            520 => array(
                'position' => '520',
                'icon' => 'google-plus',
                'field' => 'text',
                'type' => 'usermeta',
                'meta' => 'googleplus',
                'name' => __('Google+', 'upme'),
                'can_hide' => 1,
                'can_edit' => 1,
                'private' => 0,
                'social' => 1,
                'tooltip' => __('Connect via Google+', 'upme'),
                'deleted' => 0,
                'show_to_user_role' => 0,
                'edit_by_user_role' => 0
            ),
            550 => array(
                'position' => '550',
                'type' => 'separator',
                'meta' => 'account_info_separator',
                'name' => __('Account Info', 'upme'),
                'private' => 0,
                'deleted' => 0,
                'show_to_user_role' => 0
            ),
            600 => array(
                'position' => '600',
                'icon' => 'lock',
                'field' => 'password',
                'type' => 'usermeta',
                'meta' => 'user_pass',
                'name' => __('New Password', 'upme'),
                'can_hide' => 0,
                'can_edit' => 1,
                'private' => 1,
                'social' => 0,
                'deleted' => 0
            ),
            700 => array(
                'position' => '700',
                'icon' => 0,
                'field' => 'password',
                'type' => 'usermeta',
                'meta' => 'user_pass_confirm',
                'name' => 0,
                'can_hide' => 0,
                'can_edit' => 1,
                'private' => 1,
                'social' => 0,
                'deleted' => 0
            )
        );

        /* Store default profile fields */
        if (!get_option('upme_profile_fields')) {
            update_option('upme_profile_fields', $this->fields);
        }

        /* Create a generic profile page */
        add_action('wp_loaded', array(&$this, 'create_profile_page'), 9);

        /* Setup redirection */
        add_action('wp_loaded', array(&$this, 'upme_redirect'), 9);

        /* Setup global vars */
        add_action('wp_loaded', array(&$this, 'upme_globals'), 9);

        /* Should we override "default avatar" */
        add_filter('get_avatar', array(&$this, 'upme_replace_avatar'), 10, 5);

        /* Current page of users */
        if (!isset($_REQUEST['userspage']) || $_REQUEST['userspage'] == 0 || $_REQUEST['userspage'] == '') {
            $this->current_users_page = 1;
        } else {
            $this->current_users_page = $_REQUEST['userspage'];
        }

        add_action('init', array($this, 'upme_hide_admin_bar'));

        add_action('init', array($this, 'upme_profile_custom_routes'));

        add_filter('query_vars', array($this, 'upme_profile_custom_routes_query_vars'));
    }
    // get user orders
    function fused_get_all_user_orders($user_id,$status='completed'){
    if(!$user_id)
        return false;
    
    $orders=array();//order ids
     
    $args = array(
        'numberposts'     => -1,
        'meta_key'        => '_customer_user',
        'meta_value'      => $user_id,
        'post_type'       => 'shop_order',
        'post_status'     => 'publish',
        'tax_query'=>array(
                array(
                    'taxonomy'  =>'shop_order_status',
                    'field'     => 'slug',
                    'terms'     =>$status
                    )
        )  
    );
    
    $posts=get_posts($args);
    //get the post ids as order ids
    $orders=wp_list_pluck( $posts, 'ID' );
    
    return $orders;
 
}	
    /* Replace avatar */

    function upme_replace_avatar($avatar, $id_or_email, $size, $default, $alt) {
        // Optimized condition and added strict conditions
        if (is_numeric($id_or_email)) {
            $user_id = $id_or_email;
        } else if (is_object($id_or_email)) {
            $user_id = email_exists($id_or_email->comment_author_email);
        } else {
            $user_id = email_exists($id_or_email);
        }


        // Filter default gravatars to prvent the loading of custom profile image
        $default_gravatars = array("blank", "identicon", "wavatar", "monsterid", "retro");

        if ($user_id > 0 && !in_array($default, $default_gravatars)) {
            if (get_the_author_meta('user_pic', $user_id) != '') {
                $avatar = '<img src="' . get_the_author_meta('user_pic', $user_id) . '" alt="" width="' . $size . '" height="' . $size . '" class="avatar avatar-' . $size . ' photo">';
            }
        }
        return $avatar;
    }

    /* Globals */

    function upme_globals() {
        $this->current_page = $_SERVER['REQUEST_URI'];
    }

    /* Setup redirection */

    function upme_redirect() {
        global $pagenow;

        /* Not admin */
        if (!current_user_can('manage_options')) {

            $option_name = '';
            // Check if current page is profile page
            if ('profile.php' == $pagenow) {
                // If user have selected to redirect backend profile page
                if ($this->get_option('redirect_backend_profile') == '1') {
                    $option_name = 'profile_page_id';
                }
            }


            // Check if current page is login or not
            if ('wp-login.php' == $pagenow && !isset($_REQUEST['action'])) {
                if ($this->get_option('redirect_backend_login') == '1') {
                    $option_name = 'login_page_id';
                }
            }

            if ('wp-login.php' == $pagenow && isset($_REQUEST['action']) && $_REQUEST['action'] == 'register') {
                if ($this->get_option('redirect_backend_registration') == '1') {
                    $option_name = 'registration_page_id';
                }
            }

            if ($option_name != '') {
                if ($this->get_option($option_name) > 0) {
                    // Generating page url based on stored ID
                    $page_url = get_permalink($this->get_option($option_name));

                    // Redirect if page is not blank
                    if ($page_url != '') {
                        if ($option_name == 'login_page_id' && isset($_GET['redirect_to'])) {
                            $url_data = parse_url($page_url);
                            $join_code = '/?';
                            if (isset($url_data['query']) && $url_data['query'] != '') {
                                $join_code = '&';
                            }

                            $page_url = $page_url . $join_code . 'redirect_to=' . $_GET['redirect_to'];
                        }

                        wp_redirect($page_url);
                        exit;
                    }
                }
            }
        }
    }

    /* Create profile page */

    function create_profile_page() {
        if (!get_option('upme_profile_page')) {
            $new = array(
                'post_title' => __('View Profile', 'upme'),
                'post_type' => 'page',
                'post_name' => 'profile',
                'post_content' => '[upme]',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => 1
            );
            $new_page = wp_insert_post($new, FALSE);


            if (isset($new_page)) {

                $current_option = get_option('upme_options');
                $page_data = get_post($new_page);

                $current_option['edit_profile_redirect'] = '';
                if (isset($page_data->guid))
                    $current_option['edit_profile_redirect'] = $page_data->guid;

                update_option('upme_options', $current_option);
                update_option('upme_profile_page', $new_page);
            }
        }
    }

    /* Get profile link by ID */

    function profile_link($id) {
        global $wp_query;

        $current_option = get_option('upme_options');

        $username = get_the_author_meta('user_login', $id);

        if (isset($current_option['profile_page_id']))
            $link = get_permalink($current_option['profile_page_id']);
        else
            $link = '';

        if ($link != '') {
            // Get the current permalink structure
            $permalink_structure;
            if (isset($_REQUEST['page_id'])) {
                $permalink_structure = 'DEFAULT';
            } else {
                $permalink_structure = 'CUSTOM';
            }


            if (isset($current_option['profile_url_type']) && 2 == $current_option['profile_url_type']) {
                if ('DEFAULT' == $permalink_structure) {
                    return add_query_arg(array('username' => $username), $link);
                } else {
                    return $link . $username;
                }
            } else {
                if ('DEFAULT' == $permalink_structure) {
                    return add_query_arg(array('viewuser' => $id), $link);
                } else {
                    return $link . $id;
                }
            }
        } else {
            return '';
        }
    }

    /* get setting */

    function get_option($option) {
        $settings = get_option('upme_options');
        if (isset($settings[$option])) {
            return $settings[$option];
        } else {
            return '';
        }
    }

    /* register styles */

    function add_style_scripts_frontend() {

        /* Google fonts */
        wp_register_style('upme_google_fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&subset=latin,latin-ext');
        wp_enqueue_style('upme_google_fonts');

        /* Font Awesome */
        wp_register_style('upme_font_awesome', upme_url . 'css/font-awesome.min.css');
        wp_enqueue_style('upme_font_awesome');

        /* Main css file */
        wp_register_style('upme_css', upme_url . 'css/upme.css');
        wp_enqueue_style('upme_css');

        /* Add style */
        if ($this->get_option('style')) {
            wp_register_style('upme_style', upme_url . 'styles/' . $this->get_option('style') . '.css');
            wp_enqueue_style('upme_style');
        }

        /* Responsive */
        wp_register_style('upme_responsive', upme_url . 'css/upme-responsive.css');
        wp_enqueue_style('upme_responsive');


        /* date_picker */
        wp_register_style('upme_date_picker', upme_url . 'css/upme-datepicker.css');
        wp_enqueue_style('upme_date_picker');

        wp_register_script('upme_date_picker_js', upme_url . 'js/upme-datepicker.js', array('jquery'));
        wp_enqueue_script('upme_date_picker_js');

        wp_register_script('upme_fitvids_js', upme_url . 'js/upme-fitvids.js', array('jquery'));
        wp_enqueue_script('upme_fitvids_js');

        // Add lightbox using Thickbox
        wp_enqueue_script("thickbox");
        wp_enqueue_style("thickbox");

        // Set date format from admin settings
        $upme_settings = get_option('upme_options');
        $upme_date_format = (string) isset($upme_settings['date_format']) ? $upme_settings['date_format'] : 'mm/dd/yy';

        $date_picker_array = array(
            'closeText' => 'Done',
            'prevText' => 'Prev',
            'nextText' => 'Next',
            'currentText' => 'Today',
            'monthNames' => array(
                'Jan' => 'January',
                'Feb' => 'February',
                'Mar' => 'March',
                'Apr' => 'April',
                'May' => 'May',
                'Jun' => 'June',
                'Jul' => 'July',
                'Aug' => 'August',
                'Sep' => 'September',
                'Oct' => 'October',
                'Nov' => 'November',
                'Dec' => 'December'
            ),
            'monthNamesShort' => array(
                'Jan' => 'Jan',
                'Feb' => 'Feb',
                'Mar' => 'Mar',
                'Apr' => 'Apr',
                'May' => 'May',
                'Jun' => 'Jun',
                'Jul' => 'Jul',
                'Aug' => 'Aug',
                'Sep' => 'Sep',
                'Oct' => 'Oct',
                'Nov' => 'Nov',
                'Dec' => 'Dec'
            ),
            'dayNames' => array(
                'Sun' => 'Sunday',
                'Mon' => 'Monday',
                'Tue' => 'Tuesday',
                'Wed' => 'Wednesday',
                'Thu' => 'Thursday',
                'Fri' => 'Friday',
                'Sat' => 'Saturday'
            ),
            'dayNamesShort' => array(
                'Sun' => 'Sun',
                'Mon' => 'Mon',
                'Tue' => 'Tue',
                'Wed' => 'Wed',
                'Thu' => 'Thu',
                'Fri' => 'Fri',
                'Sat' => 'Fri'
            ),
            'dayNamesMin' => array(
                'Sun' => 'Su',
                'Mon' => 'Mo',
                'Tue' => 'Tu',
                'Wed' => 'We',
                'Thu' => 'Th',
                'Fri' => 'Fr',
                'Sat' => 'Sa'
            ),
            'weekHeader' => 'Wk',
            'dateFormat' => $upme_date_format
        );
        wp_localize_script('upme_date_picker_js', 'UPMEDatePicker', $date_picker_array);

        //wp_register_script('form-validate', upme_url . 'js/form-validate.js', array('jquery'));
        //wp_enqueue_script('form-validate');

        $validate_strings = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'ErrMsg' => array(
                'similartousername' => __('Your password is too similar to your username.', 'upme'),
                'mismatch' => __('Both passwords do not match.', 'upme'),
                'tooshort' => __('Your password is too short.', 'upme'),
                'veryweak' => __('Your password strength is too weak.', 'upme'),
                'weak' => __('Your password strength is weak.', 'upme'),
                'usernamerequired' => __('Please provide username.', 'upme'),
                'emailrequired' => __('Please provide email address.', 'upme'),
                'validemailrequired' => __('Please provide valid email address.', 'upme'),
                'usernameexists' => __('That username is already taken, please try a different one.', 'upme'),
                'emailexists' => __('The email you entered is already registered. Please try a new email or log in to your existing account.', 'upme')
            ),
            'MeterMsg' => array(
                'similartousername' => __('Your password is too similar to your username.', 'upme'),
                'mismatch' => __('Both passwords do not match.', 'upme'),
                'tooshort' => __('Your password is too short.', 'upme'),
                'veryweak' => __('Your password strength is too weak.', 'upme'),
                'weak' => __('Your password strength is weak.', 'upme'),
                'good' => __('Good', 'upme'),
                'strong' => __('Strong', 'upme')
            ),
            'Err' => __('ERROR', 'upme')
        );

        //wp_localize_script('form-validate', 'Validate', $validate_strings);
    }

    /* Display shortcode */

    function display($args=array()) {

        global $post, $wp_query;


        // Loading CSS and Script only when required
        /* Tipsy script */
        if (!wp_script_is('upme_tipsy')) {
            wp_register_script('upme_tipsy', upme_url . 'js/jquery.tipsy.js', array('jquery'));
            wp_enqueue_script('upme_tipsy');
        }

        /* Tipsy css */
        if (!wp_style_is('upme_tipsy')) {
            wp_register_style('upme_tipsy', upme_url . 'css/tipsy.css');
            wp_enqueue_style('upme_tipsy');
        }



        /* Capture logged in user ID */
        if (is_user_logged_in ()) {
            $current_user = wp_get_current_user();
            if (($current_user instanceof WP_User)) {
                $this->logged_in_user = $current_user->ID;
            }
        }

        /* Arguments */
        $defaults = array(
            'id' => null,
            'group' => null,
            'width' => 1,
            'view' => null,
            'show_stats' => null,
            'show_social_bar' => null,
            'use_in_sidebar' => null,
            'users_per_page' => '50',
            'hide_until_search' => null,
            'orderby' => 'registered',
            'order' => 'desc',
            'show_id' => false,
            'role' => null
        );
        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);

        $this->profile_show_id = $show_id;

        $this->profile_order_field = $orderby;

        $this->profile_order = 'asc';
        if (strtolower($order) == 'asc' || strtolower($order) == 'desc')
            $this->profile_order = $order;

        $this->profile_role = $role;
        $sidebar_class = null;
        if ($use_in_sidebar)
            $sidebar_class = 'upme-sidebar';

        $current_option = get_option('upme_options');

        /* Using group shuts down id */
        if (!$group) {
            if ($id == 'author' && isset($post->post_author)) {
                $id = $post->post_author;
            } elseif ($this->user_exists($id)) {
                $id = $id;
            } elseif (isset($_REQUEST['viewuser']) && $this->user_exists($_REQUEST['viewuser']) && ( $this->get_option('users_can_view') || (!$this->get_option('users_can_view') && current_user_can('manage_options') )) && !$use_in_sidebar) {
                $id = $_REQUEST['viewuser'];
            } elseif (isset($_REQUEST['username']) && ( $this->get_option('users_can_view') || (!$this->get_option('users_can_view') && current_user_can('manage_options') )) && !$use_in_sidebar) {
                // View profiles by username in default permalinks
                $userdata = get_user_by('login', $_REQUEST['username']);
                if ($userdata != false) {
                    $id = $userdata->data->ID;
                }
            } elseif (isset($wp_query->query_vars['upme_profile_filter']) && ( $this->get_option('users_can_view') || (!$this->get_option('users_can_view') && current_user_can('manage_options') )) && !$use_in_sidebar) {

                // View profiles by username/user id in custom permalinks
                $upme_profile_filter_value = $wp_query->query_vars['upme_profile_filter'];
                if (isset($current_option['profile_url_type']) && 2 == $current_option['profile_url_type']) {

                    $userdata = get_user_by('login', $upme_profile_filter_value);
                    if ($userdata != false) {
                        $id = $userdata->data->ID;
                    }
                } else {

                    $id = $upme_profile_filter_value;
                }
            } else {
                $id = $this->logged_in_user;
            }
        }

        /* If no ID is set, normally logged out */
        /* He must login to view his profile. */

        if (!$group) {
            if ($id == null && !is_user_logged_in()) {

                return $this->login_to_view_your_profile();
            } elseif ($id && !is_user_logged_in() && !$this->guests_can_view()) {
                return $this->login_to_view_profile();
            } elseif(!is_numeric($id)) {
                return $this->upme_invalid_user_profile();
            } elseif(is_numeric($id) && !(get_user_by('id', $id))){
                return $this->upme_invalid_user_profile();
            } else {
                return $this->view_profile($id, $width, $view, $group, $show_stats, $show_social_bar, $use_in_sidebar, $users_per_page, null, $role);
            }
        }

        /* If group of users is used */
        if ($group) {
            if (!is_user_logged_in() && !$this->guests_can_view()) {
                return $this->login_to_view_profile();
            } else {
                return $this->view_profile($id, $width, $view, $group, $show_stats, $show_social_bar, $use_in_sidebar, $users_per_page, $hide_until_search, $role);
            }
        }
    }

    function display_mini_profile($args=array()) {
        global $post;

        /* Capture logged in user ID */

        $current_user = wp_get_current_user();
        if (($current_user instanceof WP_User)) {
            $this->logged_in_user = $current_user->ID;
        }

        /* Arguments */
        $defaults = array(
            'id' => null,
            'group' => null,
            'width' => 1,
            'view' => null,
            'show_stats' => null,
            'show_social_bar' => null,
            'use_in_sidebar' => null,
            'users_per_page' => null,
            'hide_until_search' => null,
            'orderby' => 'registered',
            'order' => 'desc',
            'show_id' => false,
            'role' => null
        );
        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);

        $this->profile_show_id = $show_id;

        $this->profile_order_field = $orderby;

        $this->profile_order = 'asc';
        if (strtolower($order) == 'asc' || strtolower($order) == 'desc')
            $this->profile_order = $order;

        $sidebar_class = null;
        $name_holder_width = '50%';
        if ($use_in_sidebar) {
            $sidebar_class = 'upme-sidebar';
            $name_holder_width = '100%';
        }


        /* If no ID is set, normally logged out */
        /* User must login to view his profile. */

        $pic_class = 'upme-pic mini_profile';
        if (is_safari ())
            $pic_class = 'upme-pic safari mini_profile';

        $display = '';

        $display .= '<div class="upme-wrap upme-' . $id . ' upme-width-' . $width . ' ' . $sidebar_class . '">
        <div class="upme-inner upme-clearfix">

        <div class="upme-head">

        <div class="upme-left upme-profile-holder">
        <div class="' . $pic_class . '" style="width:' . $name_holder_width . ';">';

        $display.=$this->pic($this->logged_in_user, 50);

        $display.='<div class="upme-field-name">';
        if ($this->get_option('clickable_profile')) {
            if ($this->get_option('clickable_profile') == 1) {
                $display .= '<a href="' . $this->profile_link($this->logged_in_user) . '">';
            } else {
                $display .= '<a href="' . get_author_posts_url($this->logged_in_user) . '">';
            }

            $display .= get_the_author_meta('display_name', $this->logged_in_user);
            $display .= '</a>';
        } else {
            $display .= get_the_author_meta('display_name', $this->logged_in_user);
        }
        $display.='</div>';

        $display.='</div>';

        if (is_user_logged_in ()) {

            $display .= '<div class="upme-name upme-button-holder">';
            $link = get_permalink($this->get_option('profile_page_id'));
            $class = "upme-button-alt";
            $link_text = __('View Profile', 'upme');

            $display .= '<div class="upme-field-edit upme-mini-profile-button"><a href="' . $link . '" class="' . $class . '">' . $link_text . '</a>&nbsp;' . do_shortcode('[upme_logout wrap_div="false" user_id="' . $this->logged_in_user . '"]') . '</div>
            </div>';
        }

        $display .= '</div><div class="upme-clear"></div>';

        $display .= '</div>

        </div>
        </div>';

        return $display;
    }

    /* Return true if guests can view profiles */

    function guests_can_view() {
        if ($this->get_option('guests_can_view') == 1)
            return true;
        return false;
    }

    /* Login to view profile */

    function login_to_view_profile() {
        $display = null;
        $display .= '<div class="upme-wrap">';
        $display .= wpautop($this->get_option('html_login_to_view'));
        $display .= '<p class="upme-login-spacer">&nbsp;</p>';
        $display .= do_shortcode('[upme_login]');
        $display .= '</div>';
        return $display;
    }

    /* Login to view your profile */

    function login_to_view_your_profile() {
        $display = null;
        $display .= '<div class="upme-wrap">';
        $display .= wpautop($this->get_option('html_user_login_message'));
        $display .= '<p class="upme-login-spacer">&nbsp;</p>';
        $display .= do_shortcode('[upme_login]');
        $display .= '</div>';
        return $display;
    }

    /* Display pagination class */

    function pagination($users_per_page, $users, $role=null) {
        $display = null;

        /* Prepare loop */
        $args = array('orderby' => 'registered', 'order' => 'DESC');

        if ($users != 'all') {
            $list_of_users = explode(',', $users);
            $args['include'] = $list_of_users;
        }

        $args['per_page'] = $users_per_page;
        if (!isset($this->searched_users)) {
            $this->search_result($args);
        }

        /* Count of users returned */
        $count = $this->total_matching_user;
        if ($count > $users_per_page) { // activate page links
            $display .= '<div class="upme-navi">';

            /* How many links will we display ? */
            $this->num_of_links = ceil($count / $users_per_page);

            // This determined how many links to show
            $this->link_delta = 6;

            // Getting From where to start
            $first_link = $this->current_users_page - floor($this->link_delta / 2);
            if ($first_link <= 0)
                $first_link = 1;

            // Getting From where to end
            $last_link = $this->link_delta + $first_link - 1;

            if ($last_link > $this->num_of_links) {
                $k = $last_link - $this->num_of_links;
                $first_link = $first_link - $k;
                $last_link = $this->num_of_links;
            }

            if ($first_link <= 0)
                $first_link = 1;

            // First & Previous Links Start
            if ($this->current_users_page - 1 <= $this->num_of_links && $this->current_users_page != 1) {
                $previous_link = add_query_arg(array('userspage' => $this->current_users_page - 1));
            } else {
                $previous_link = null;
            }

            $link = add_query_arg(array('userspage' => 1));
            if ($this->current_users_page > 1 && $this->current_users_page <= $this->num_of_links) {
                $display .= '<a href="javascript:void(0);" onclick="javascript:change_page(1)" class="page gradient"><span>' . __('first', 'upme') . '</span></a>';
            }
            if ($previous_link)
                $display .= '<a href="javascript:void(0);" onclick="javascript:change_page(' . ($this->current_users_page - 1) . ')" class="page gradient"><span>' . __('previous', 'upme') . '</span></a>';
            // First & Previous Links Ends


            /* Show links for limited Pages rather than all pages Starts */
            for ($i = $first_link; $i <= $last_link; $i++) {

                if ($this->current_users_page > $this->num_of_links) {
                    $this->current_users_page = 1;
                }

                $link = add_query_arg(array('userspage' => $i));

                if ($i == $this->current_users_page) {
                    $display .= '<span class="page active">' . $i . '</span>';
                } else {
                    $display .= '<a href="javascript:void(0);" onclick="javascript:change_page(' . $i . ')" class="page gradient"><span>' . $i . '</span></a>';
                }
            }
            /* Show links for limited Pages rather than all pages Ends */


            // Last & Next Links Starts
            if ($this->current_users_page + 1 <= $this->num_of_links) {
                $next_link = add_query_arg(array('userspage' => $this->current_users_page + 1));
            } else {
                $next_link = null;
            }

            $link = add_query_arg(array('userspage' => $this->num_of_links));
            if ($this->current_users_page < $this->num_of_links) { // last
                if ($next_link)
                    $display .= '<a href="javascript:void(0);" onclick="javascript:change_page(' . ($this->current_users_page + 1) . ')"  class="page gradient"><span>' . __('next', 'upme') . '</span></a>';
                if ($this->current_users_page < $this->num_of_links) {
                    $display .= '<a href="javascript:void(0);" onclick="javascript:change_page(' . $this->num_of_links . ')" class="page gradient"><span>' . __('last', 'upme') . '</span></a>';
                }
            }
            // Last & Next Links Ends
            // Getting Dropdown to jump to page if Total Pages are greater than Page Link delta
            if ($this->num_of_links > $this->link_delta) {
                $display.='<select class="upme-go-to-page">';
                $display.='<option value="0">Jump</option>';
                for ($i = 1; $i <= $this->num_of_links; $i++) {
                    $link = add_query_arg(array('userspage' => $i));

                    $sel = '';
                    if ($i == $this->current_users_page)
                        $sel = ' selected="selected"';

                    $display.='<option value="' . $i . '" ' . $sel . '>' . $i . '</option>';
                }

                $display.='</select>';
            }

            $display .= '</div>';
        }

        return $display;
    }

    /* Setup which results appear on page */

    function setup_page($args, $users_per_page) {
        if (isset($this->num_of_links) && $this->current_users_page > $this->num_of_links) {
            $current_page = 0;
        } else {
            $current_page = $this->current_users_page - 1;
        }
        $offset = $users_per_page * ($current_page);
        $args['number'] = $users_per_page;
        $args['offset'] = $offset;
        return $args;
    }

    private function build_search_field_array() {


        $custom_fields = get_option('upme_profile_fields');
        $this->search_banned_field_type = array('fileupload', 'password', 'datetime');

        $this->show_combined_search_field = false;
        $this->show_nontext_search_fields = false;

        $this->all_text_search_field = array();
        $this->combined_search_field = array();
        $this->nontext_search_fields = array();
        $this->checkbox_search_fields = array();

        $included_fields = '';
        if ($this->search_args['fields'] != '')
            $included_fields = explode(',', $this->search_args['fields']);

        $excluded_fields = explode(',', $this->search_args['exclude_fields']);

        $search_filters = array();
        $search_filters = explode(',', $this->search_args['filters']);

        foreach ($custom_fields as $key => $value) {
            if (isset($value['type']) && $value['type'] == 'usermeta') {
                if (isset($value['field']) && !in_array($value['field'], $this->search_banned_field_type)) {
                    if (isset($value['meta']) && !in_array($value['meta'], $excluded_fields)) {
                        switch ($value['field']) {
                            case 'text':
                            case 'textarea':
                            case 'datetime':

                                if (is_array($search_filters) && in_array($value['meta'], $search_filters)) {
                                    if ($this->show_nontext_search_fields === false) {
                                        $this->show_nontext_search_fields = true;
                                    }

                                    $this->nontext_search_fields[] = $value;
                                } else {
                                    if ($this->show_combined_search_field === false)
                                        $this->show_combined_search_field = true;

                                    $this->all_text_search_field[] = $value['meta'];

                                    if (is_array($included_fields) && count($included_fields) > 0 && in_array($value['meta'], $included_fields))
                                        $this->combined_search_field[] = $value['meta'];
                                }



                                break;

                            case 'select':
                            case 'radio':

                                $is_in_field = false;
                                $is_in_filter = false;

                                if (is_array($search_filters) && in_array($value['meta'], $search_filters))
                                    $is_in_filter = true;

                                if (is_array($included_fields) && count($included_fields) > 0 && in_array($value['meta'], $included_fields))
                                    $is_in_field = true;

                                if ($is_in_field == true || $is_in_filter == true) {
                                    if ($this->show_nontext_search_fields === false) {
                                        $this->show_nontext_search_fields = true;
                                    }

                                    $this->nontext_search_fields[] = $value;
                                }
                                break;

                            case 'checkbox':

                                $is_in_field = false;
                                $is_in_filter = false;

                                if (is_array($search_filters) && in_array($value['meta'], $search_filters))
                                    $is_in_filter = true;

                                if (is_array($included_fields) && count($included_fields) > 0 && in_array($value['meta'], $included_fields))
                                    $is_in_field = true;

                                if ($is_in_filter == true || $is_in_field == true) {
                                    if ($this->show_nontext_search_fields === false) {
                                        $this->show_nontext_search_fields = true;
                                    }

                                    $this->checkbox_search_fields[] = $value;
                                }
                                break;

                            default:
                                break;
                        }
                    }
                }
            }
        }
    }

    /* Setup search form */

    function search($args=array()) {



        global $predefined;

        // Determine search form is loaded
        $this->upme_search = true;
        /* Default Arguments */
        $defaults = array(
            'fields' => null,
            'filters' => null,
            'exclude_fields' => null,
            'operator' => 'AND',
            'use_in_sidebar' => null
        );

        $this->search_args = wp_parse_args($args, $defaults);

        $this->search_operator = $this->search_args['operator'];

        if (strtolower($this->search_args['operator']) != 'and' && strtolower($this->search_args['operator']) != 'or') {
            $this->search_args['operator'] = 'AND';
        }

        // Prepare array of all fields to load
        $this->build_search_field_array();

        $sidebar_class = null;
        if ($this->search_args['use_in_sidebar'])
            $sidebar_class = 'upme-sidebar';

        $display = null;

        $display.='<div class="upme-wrap upme-wrap-form ' . $sidebar_class . '">';
        $display.='<div class="upme-inner upme-clearfix">';
        $display.='<div class="upme-head">' . __('Search Users', 'upme') . '</div>';
        $display.='<form action="" method="post" id="upme_search_form" class="upme-search-form">';

        // Check For default fields Start
        if ($this->show_combined_search_field === true) {
            $display.='<p class="upme-p upme-search-p">';
            $display.= UPME_Html::text_box(array(
                        'class' => 'upme-search-input upme-combined-search',
                        'value' => isset($_POST['upme_combined_search']) ? $_POST['upme_combined_search'] : '',
                        'name' => 'upme_combined_search',
                        'placeholder' => __('Combined Search', 'upme')
                    ));

            if (count($this->combined_search_field) > 0) {
                $display.='<input type="hidden" name="upme_combined_search_fields" value="' . implode(',', $this->combined_search_field) . '" />';
            } else {
                $display.='<input type="hidden" name="upme_combined_search_fields" value="' . implode(',', $this->all_text_search_field) . '" />';
            }


            $display.='</p>';
        }

        // Check For default fields End
        // Custom Search Fields Creation Starts

        if ($this->show_nontext_search_fields === true) {
            $counter = 0;
            $display.='<p class="upme-p upme-search-p">';
            foreach ($this->nontext_search_fields as $key => $value) {
                $method_name = '';
                $method_name = $this->method_mapping[$value['field']];
                if ($method_name != '') {
                    if ($counter > 0 && $counter % 2 == 0) {
                        $display.='</p>';
                        $display.='<p class="upme-p upme-search-p">';
                    }

                    $counter++;

                    $class = 'upme-search-input upme-search-input-left upme-search-meta-' . $value['meta'];
                    if ($counter > 0 && $counter % 2 == 0)
                        $class = 'upme-search-input upme-search-input-right upme-search-meta-' . $value['meta'];


                    if ($method_name == 'drop_down') {
                        $loop = array();

                        if (isset($value['predefined_loop']) && $value['predefined_loop'] != '' && $value['predefined_loop'] != '0') {
                            $defined_loop = $predefined->get_array($value['predefined_loop']);

                            foreach ($defined_loop as $option) {
                                if ($option == '' || $option == null) {
                                    $loop[$option] = $value['name'];
                                } else {
                                    $loop[$option] = $option;
                                }
                            }
                        } else if (isset($value['choices']) && $value['choices'] != '') {
                            $loop_default = explode(PHP_EOL, $value['choices']);
                            $loop[''] = $value['name'];

                            foreach ($loop_default as $option)
                                $loop[$option] = $option;
                        }

                        if (isset($_POST['upme_search'][$value['meta']]))
                            $_POST['upme_search'][$value['meta']] = stripslashes_deep($_POST['upme_search'][$value['meta']]);


                        $default = isset($_POST['upme_search'][$value['meta']]) ? $_POST['upme_search'][$value['meta']] : '0';
                        $name = 'upme_search[' . $value['meta'] . ']';

                        if ($value['field'] == 'checkbox') {
                            $default = isset($_POST['upme_search'][$value['meta']]) ? $_POST['upme_search'][$value['meta']] : array();
                            $name = 'upme_search[' . $value['meta'] . '][]';
                        }

                        if (count($loop) > 0) {
                            $display.= UPME_Html::drop_down(array(
                                        'class' => $class,
                                        'name' => $name,
                                        'placeholder' => $value['name']
                                            ), $loop, $default);
                        }
                    } else if ($method_name == 'text_box') {
                        if (isset($_POST['upme_search'][$value['meta']]))
                            $_POST['upme_search'][$value['meta']] = stripslashes_deep($_POST['upme_search'][$value['meta']]);


                        $default = isset($_POST['upme_search'][$value['meta']]) ? $_POST['upme_search'][$value['meta']] : '';
                        $name = 'upme_search[' . $value['meta'] . ']';

                        $display.= UPME_Html::text_box(array(
                                    'class' => $class,
                                    'name' => $name,
                                    'placeholder' => $value['name'],
                                    'value' => $default
                                ));
                    }
                }
            }
            $display.='</p>';


            if (isset($this->checkbox_search_fields) && count($this->checkbox_search_fields) > 0) {
                foreach ($this->checkbox_search_fields as $key => $value) {
                    $display.='<p class="upme-p upme-search-p upme-multiselect-p">';

                    $method_name = '';
                    $method_name = $this->method_mapping[$value['field']];
                    if ($method_name != '') {
                        $class = 'upme-search-input upme-search-multiselect upme-search-meta-' . $value['meta'];

                        $loop = array();

                        if (isset($value['predefined_loop']) && $value['predefined_loop'] != '' && $value['predefined_loop'] != '0') {
                            $defined_loop = $predefined->get_array($value['predefined_loop']);

                            foreach ($defined_loop as $option)
                                $loop[$option] = $option;
                        } else if (isset($value['choices']) && $value['choices'] != '') {
                            $loop_default = explode(PHP_EOL, $value['choices']);
                            $loop[''] = $value['name'];

                            foreach ($loop_default as $option)
                                $loop[$option] = $option;
                        }

                        if (isset($_POST['upme_search'][$value['meta']]))
                            $_POST['upme_search'][$value['meta']] = stripslashes_deep($_POST['upme_search'][$value['meta']]);

                        $default = isset($_POST['upme_search'][$value['meta']]) ? $_POST['upme_search'][$value['meta']] : '0';
                        $name = 'upme_search[' . $value['meta'] . ']';
                        if ($value['field'] == 'checkbox') {
                            $default = isset($_POST['upme_search'][$value['meta']]) ? $_POST['upme_search'][$value['meta']] : array();
                            $name = 'upme_search[' . $value['meta'] . '][]';
                        }

                        if (count($loop) > 0) {
                            $display.= UPME_Html::drop_down(array(
                                        'class' => $class,
                                        'name' => $name,
                                        'placeholder' => $value['name']
                                            ), $loop, $default);
                        }
                    }

                    $display.='</p>';
                }
            }
        }

        $display.='<input type="hidden" name="userspage" id="userspage" value="' . $this->current_users_page . '" />';

        $display.='<input type="hidden" name="upme-search-fired" id="upme-search-fired" value="1" />';

        // Custom Search Fields Creation Ends
        // Submit Button
        $display.='<p class="upme-search-submit-p">';
        $display.=UPME_Html::button('submit', array(
                    'class' => 'upme-button-alt upme-search-submit',
                    'name' => 'upme-search',
                    'value' => __('Filter', 'upme')
                ));
        $display.='</p><div class="upme-clear"></div>';

        $display.='</form>';

        $display.='</div>';
        $display.='</div>';

        return $display;
    }

    /* Apply search params and Generate Results */

    function search_result($args) {



        global $wpdb;

        $this->search_query = array();

        $this->search_user_argument = array();

        $this->search_query_string = "SELECT DISTINCT users.* FROM " . $wpdb->users . " as users";

        $this->count_search_query_string = "SELECT COUNT(DISTINCT(users.ID)) FROM " . $wpdb->users . " as users";

        $this->search_query_search_param = array();
        $this->combined_search_query_search_param = array();

        if (is_post ()) {
            if (is_in_post('upme_combined_search') && is_in_post('upme_combined_search_fields')) {
                if (post_value('upme_combined_search_fields') != '' && post_value('upme_combined_search') != '') {
                    $fields = explode(',', post_value('upme_combined_search_fields'));

                    $combined_search_text = esc_sql(like_escape(post_value('upme_combined_search')));

                    foreach ($fields as $key => $value) {

                        $this->combined_search_query_search_param[] = "(mt.meta_key = '_upme_search_cache' AND mt.meta_value LIKE '%" . $value . '::' . $combined_search_text . "%')";
                    }

                    $this->search_query_search_param[] = '( ' . implode(' OR ', $this->combined_search_query_search_param) . ' )';
                }
            }

            if (is_in_post('upme_search')) {
                foreach ($_POST['upme_search'] as $key => $value) {
                    $process = false;

                    if (is_array($value) && count($value) > 0)
                        $process = true;
                    else if ($value != '' && $value != '0')
                        $process = true;
                    else
                        $process = false;

                    if ($process === true) {
                        if (is_array($value)) {

                            foreach ($value as $k => $v) {
                                $this->search_query_search_param[] = "(mt.meta_key = '_upme_search_cache' AND mt.meta_value LIKE '%" . $key . '::' . esc_sql(trim($v)) . "%')";
                            }
                        } else {

                            $this->search_query_search_param[] = "(mt.meta_key = '_upme_search_cache' AND mt.meta_value LIKE '%" . $key . '::' . esc_sql($value) . "%')";
                        }
                    }
                }
            }
        }

        if ($this->profile_role) {
            $this->search_query_search_param[] = "(mt.meta_key = '_upme_search_cache' AND mt.meta_value LIKE '%role::" . $this->profile_role . "%')";
        }

        if (count($this->search_query_search_param) > 0) {
            $this->search_query_string.=' INNER JOIN ' . $wpdb->usermeta . ' as mt ON (users.ID = mt.user_id) WHERE 1=1 AND ' . implode(' ' . $this->search_args['operator'] . ' ', $this->search_query_search_param);

            $this->count_search_query_string.=' INNER JOIN ' . $wpdb->usermeta . ' as mt ON (users.ID = mt.user_id) WHERE 1=1 AND ' . implode(' ' . $this->search_args['operator'] . ' ', $this->search_query_search_param);
        }

        // Setting up order data
        if (in_array($this->profile_order_field, array('nicename', 'email', 'url', 'registered')))
            $orderby = 'users.user_' . $this->profile_order_field;
        elseif (in_array($this->profile_order_field, array('user_nicename', 'user_email', 'user_url', 'user_registered')))
            $orderby = 'users.' . $this->profile_order_field;
        elseif ('name' == $this->profile_order_field || 'display_name' == $this->profile_order_field)
            $orderby = 'users.display_name';
        elseif ('ID' == $this->profile_order_field || 'id' == $this->profile_order_field)
            $orderby = 'users.ID';
        else
            $orderby = 'users.user_login';

        $this->search_query_string.= ' ORDER BY ' . $orderby . ' ' . $this->profile_order;
        $this->count_search_query_string.= ' ORDER BY ' . $orderby . ' ' . $this->profile_order;

        // Setting Limit Data
        if (isset($this->current_users_page) && $this->current_users_page > 1) {
            $offset = ($this->current_users_page - 1) * $args['per_page'];
            $this->search_query_string.= ' LIMIT ' . $offset . ',' . $args['per_page'];
        } else {
            $this->search_query_string.= ' LIMIT ' . $args['per_page'];
        }

        $this->count_search_query_string.= ' LIMIT 1';

        $this->total_matching_user = $wpdb->get_var($this->count_search_query_string);

        $this->searched_users = $wpdb->get_results($this->search_query_string);
    }

    /* View profile area */

    function view_profile($id=null, $width=null, $view=null, $group=null, $show_stats=null, $show_social_bar=null, $use_in_sidebar=null, $users_per_page=null, $hide_until_search=null, $role=null) {

        global $upme_save;

        $display = null;

        /* Search running? */
        if (isset($_REQUEST['upme-search-fired'])) {
            $hide_until_search = false;
        }

        $sidebar_class = null;
        if ($use_in_sidebar)
            $sidebar_class = 'upme-sidebar';

        $users = array();
        /* Ignore id if group is used */
        if ($group) {

            /* allow search */
            $this->allow_search = true;

            /* pagination */
            if (!$hide_until_search) {

                if ($users_per_page)
                    $display .= $this->pagination($users_per_page, $group, $role);
            }

            /* Loop of users */
            $args = array('orderby' => $this->profile_order_field, 'order' => $this->profile_order);

            if ($group != 'all') {
                $users = explode(',', $group);
            }

            /* Setup offset/page and array of users */
            if ($users_per_page) {
                $args = $this->setup_page($args, $users_per_page);
            }

            /* Modify args */
            if (!$hide_until_search) {

                if(isset($_REQUEST['upme-search-fired']) || $group == 'all'){
                    if (!isset($this->searched_users)) {
                        $this->search_result($args);
                    }

                    foreach ($this->searched_users as $user) {
                        $users[] = $user->ID;
                    }
                }


            }
        } else {
            $users[] = $id;
        }

        $pic_class = 'upme-pic';
        if (is_safari ())
            $pic_class = 'upme-pic safari';


        /* Loop and display users */
        if (!$hide_until_search) {

            if ($users) {

                $display .= '<div class="upme-column-wrap">';

                foreach ($users as $id) {

                    $display .= '<div class="upme-wrap upme-' . $id . ' upme-width-' . $width . ' ' . $sidebar_class . '">
                    <div class="upme-inner upme-clearfix">

                    <div class="upme-head">

                    <div class="upme-left">
                    <div class="' . $pic_class . '">' . $this->pic($id, 50) . '</div>';

                    if ($this->can_edit_profile($this->logged_in_user, $id)) {

                        $display .= '<div class="upme-name">
                        <div class="upme-field-name">';


                        if ($this->get_option('clickable_profile')) {
                            if ($this->get_option('clickable_profile') == 1) {
                                $display .= '<a href="' . $this->profile_link($id) . '">';
                            } else {
                                $display .= '<a href="' . get_author_posts_url($id) . '">';
                            }

                            $display .= get_the_author_meta('first_name', $id)." ".get_the_author_meta('last_name', $id);
                            $display .= '</a>';
                        } else {
                            $display .= get_the_author_meta('first_name', $id)." ".get_the_author_meta('last_name', $id);
                        }

                        $display .= '</div>';

                        if ($use_in_sidebar == 'yes' || $use_in_sidebar) {
                            $link = get_permalink($this->get_option('profile_page_id'));
                            $class = "upme-button-alt";
                            $link_text = __('View Profile', 'upme');
                        } else {
                            $link = '#edit';
                            $class = "upme-button-alt upme-fire-editor";
                            $link_text = __('Edit Profile', 'upme');
                        }

                        $display .= '<div class="upme-field-edit"><a href="' . $link . '" class="' . $class . '">' . $link_text . '</a>&nbsp;' . do_shortcode('[upme_logout wrap_div="false" user_id="' . $id . '"]') . '</div>
                        </div>';
                    } else {

                        $display .= '<div class="upme-name">
                        <div class="upme-field-name upme-field-name-wide">';

                        if ($this->get_option('clickable_profile')) {
                            if ($this->get_option('clickable_profile') == 1) {
                                $display .= '<a href="' . $this->profile_link($id) . '">';
                            } else {
                                $display .= '<a href="' . get_author_posts_url($id) . '">';
                            }

                            $display .= get_the_author_meta('first_name', $id)." ".get_the_author_meta('last_name', $id);
                            $display .= '</a>';
                        } else {
                            $display .= get_the_author_meta('first_name', $id)." ".get_the_author_meta('last_name', $id);
                        }

                        $display .= '</div>
                        </div>';
                    }

                    $display .= '</div>';



                    if (($width == '2' || $width == '3') && ($view != 'compact')) {
                        $display .= '<div class="upme-clear"></div>';
                    }

                    $display .= '<div class="upme-right">';

                    if ($show_social_bar != 'no') {
                        $display .= $this->show_user_social_profiles($id);
                    }

                    if ($show_stats != 'no') {
                        $display .= $this->show_user_stats($id);
                    }

                    $display .= '</div><div class="upme-clear"></div>

                    </div>

                    <div class="upme-main upme-main-' . $view . '">';

                    /* Display errors */
                    if (isset($_POST['upme-submit-' . $id])) {
                        $display .= $upme_save->get_errors($id);
                    }

                    $display .= $this->show_profile_fields($id, $view);
                    $display .= $this->edit_profile_fields($id, $width, $sidebar_class);

                    $display .= '</div>

                    </div>
                    </div>';
                }

                $display .= '</div>';
            } else {
                $display .= '<p>' . __('No users found matching the selected criteria.', 'upme') . '</p>';
            }
        } /* hide_until_search argument */

        /* pagination */
        if (!$hide_until_search) {
            if ($group) {
                if ($users_per_page) {
                    $display .= '<div class="upme-clear"></div>';
                    $display .= $this->pagination($users_per_page, $group, $role);

                    if (!isset($this->upme_search) || (isset($this->upme_search) && $this->upme_search == false)) {
                        // Show Hidden Form in case there is no search form
                        $display.='<form action="" method="post" id="upme-pagination-form">';
                        $display.='<input type="hidden" name="userspage" id="upme-pagination-form-per-page" />';
                        $display.='</form>';
                    }
                }
            }
        }

        return $display;
    }

    /* Show user stats */

    function show_user_stats($id) {

        $author_posts_text = '';
        // Include the link to author posts page based on the setting in admin
        if ($this->get_option('link_author_posts_page') == '1') {
            $author_posts_url = get_author_posts_url($id);

            // Remove link for author who has no post entries
            if (0 == $this->get_entries_num($id)) {
                $author_posts_text = $this->get_entries_num($id);
            } else {
                $author_posts_text = '<a href="' . $author_posts_url . '">' . $this->get_entries_num($id) . '</a>';
            }
        } else {
            $author_posts_text = $this->get_entries_num($id);
        }

        return '<div class="upme-stats">
        <div class="upme-stats-i upme-stats-posts"><i class="upme-icon-rss"></i><span class="upme-posts-link">' . $author_posts_text . '</span></div>
        <div class="upme-stats-i upme-stats-comments"><i class="upme-icon-comments-alt"></i><span class="upme-comments-link">' . $this->get_comments_num($id) . '</span></div>
        </div>';
    }

    /* Can edit user profile */

    function can_edit_profile($logged_in, $profile_id) {
        if ($logged_in == $profile_id || ( current_user_can('edit_user', $profile_id) ))
            return true;
    }

    /* Bool user exists by ID */

    function user_exists($id) {
        $userdata = get_userdata($id);
        if ($userdata == false)
            return false;
        return true;
    }

    /* Get picture by ID */

    function pic($id, $size) {
        // Check the existance of image path in upload folder and remove the data
        // in case its not available
        $user_pic = get_the_author_meta('user_pic', $id);

        if ($upload_dir = upme_get_uploads_folder_details()) {
            $upme_upload_path = $upload_dir['basedir'] . "/upme/";
            $upme_upload_url = $upload_dir['baseurl'] . "/upme/";

            $user_pic_path = str_replace($upme_upload_url, $upme_upload_path, $user_pic);
            if (!file_exists($user_pic_path)) {
                delete_user_meta($id, 'user_pic');
                $user_pic = '';
            }
        }

        if ($user_pic != '') {
            return '<img id="upme-avatar-user_pic" src="' . $user_pic . '" class="avatar avatar-50" />';
        } else {
            return get_avatar($id, $size);
        }
    }

    /* Edit profile fields */

    function edit_profile_fields($id, $width=null, $sidebar_class=null) {

        global $predefined, $upme_roles;

        $this->upme_load_edit_form_scripts();

        if ($this->can_edit_profile($this->logged_in_user, $id)) {
            $display = null;

            // Set date format from admin settings
            $upme_settings = get_option('upme_options');
            $upme_date_format = (string) isset($upme_settings['date_format']) ? $upme_settings['date_format'] : 'mm/dd/yy';

            $display .= '<div id="upme-edit-form-err-holder" style="display: none;" class="upme-errors"></div>';
            $display .= '<form id="upme-edit-profile-form" class="upme-edit-profile-form" action="" method="post" enctype="multipart/form-data">';

            $array = get_option('upme_profile_fields');

            foreach (get_option('upme_profile_fields') as $key => $field) {
                //echo "<pre>";print_r(get_option('upme_profile_fields'));
                extract($field);

                // WP 3.6 Fix
                if (!isset($deleted))
                    $deleted = 0;

                if (!isset($private))
                    $private = 0;

                // Set the default value for required attribute
                if (!isset($required))
                    $required = 0;
                // Assign the required class for required fields
                $required_class = '';
                if ($required == 1 && in_array($field, $this->include_for_validation)) {
                    $required_class = ' required';
                }


                $display_field = 0;

                $edit_by_user_role = isset($edit_by_user_role) ? $edit_by_user_role : '0';
                $edit_by_user_role_list = isset($edit_by_user_role_list) ? $edit_by_user_role_list : '';

                $upme_roles->upme_get_user_roles_by_id($this->logged_in_user);
                $edit_field_status = $upme_roles->upme_fields_by_user_role($edit_by_user_role, $edit_by_user_role_list);

                //if ($edit_field_status) {
                // Checking wether to show field or not.
                if (current_user_can('manage_options')) {
                    // For admin Always allow
                    $display_field = 1;
                } else {
                    if ($field == 'password')
                        $display_field = 1;
                    else if ($field == 'fileupload' && $can_edit == 1) //
                        $display_field = 1;
                    else if ($private == 0 && $field != 'fileupload')
                        $display_field = 1;
                    else
                        $display_field = 0;
                }

                /* Separator */
                if ($type == 'separator' && $deleted == 0) {
                    $display .= '<div class="upme-field upme-separator upme-edit upme-clearfix">' . $name . '</div>';
                }

                /* user meta - editing fields */
                if ($type == 'usermeta' && $deleted == 0 && $display_field == 1) {

                    $display .= '<div class="upme-field upme-edit">';

                    /* Show the label */
                    if (isset($array[$key]['name']) && $name) {
                        $display .= '<label class="upme-field-type" for="' . $meta . '-' . $id . '">';
                        if (isset($array[$key]['icon']) && $icon) {
                            $display .= '<i class="upme-icon-' . $icon . '"></i>';
                        } else {
                            $display .= '<i class="upme-icon-none"></i>';
                        }
                        $display .= '<span>' . $name . '</span></label>';
                    } else {
                        if (isset($array[$key]['icon']) && $icon) {
                            $display .= '<label class="upme-field-type upme-field-type-width-' . $width . '" for="' . $meta . '-' . $id . '"><i class="upme-icon-' . $icon . '"></i></label>';
                        } else {
                            $display .= '<label class="upme-field-type upme-field-type-width-' . $width . ' upme-field-type-' . $sidebar_class . '">&nbsp;</label>';
                        }
                    }

                    $display .= '<div class="upme-field-value">';


                    // Checking if field should be editable or not
                    // For admin always allow
                    if (current_user_can('manage_options') && $edit_field_status) {
                        $disabled = null;
                    } else if (!$edit_field_status) {
                        $disabled = 'disabled="disabled"';
                    } else {
                        if ($can_edit == 0)
                            $disabled = 'disabled="disabled"';
                        else
                            $disabled = null;
                    }

if($id != get_current_user_id())
$disabled = 'disabled="disabled"';

$admin = new WP_User(get_current_user_id());
   				$user = new WP_User($user_object->ID);
   				if ($admin->wp_capabilities['administrator']==1)
   				{$disabled = null;
}
                    switch ($field) {
                        case 'textarea':
                            $display .= '<textarea title="' . $name . '" ' . $disabled . ' class="upme-input ' . $required_class . '" name="' . $meta . '-' . $id . '" id="' . $meta . '-' . $id . '">' . get_the_author_meta($meta, $id) . '</textarea>';
                            break;

                        case 'text':
                            $display .= '<input title="' . $name . '" ' . $disabled . ' type="text" class="upme-input ' . $required_class . ' upme-edit-' . $meta . '" name="' . $meta . '-' . $id . '" id="' . $meta . '-' . $id . '" value="' . get_the_author_meta($meta, $id) . '" />';
                            break;

                        case 'datetime':

                            $formatted_date_value = upme_date_format_to_custom(get_the_author_meta($meta, $id), $upme_date_format);
                            $display .= '<input readonly="readonly" title="' . $name . '" ' . $disabled . ' type="text" class="upme-input upme-datepicker ' . $required_class . '" name="' . $meta . '-' . $id . '" id="' . $meta . '-' . $id . '" value="' . $formatted_date_value . '" />';
                            break;

                        case 'select':

                            if (isset($array[$key]['predefined_loop']) && $array[$key]['predefined_loop'] != '' && $array[$key]['predefined_loop'] != '0') {
                                $loop = $predefined->get_array($array[$key]['predefined_loop']);
                            } else if (isset($array[$key]['choices']) && $array[$key]['choices'] != '') {
                                $loop = explode(PHP_EOL, $choices);
                            }


                            if (isset($loop)) {

                                $profile_user_meta = '';
                                $profile_user_meta = get_the_author_meta($meta, $id);

                                $display .= '<select title="' . $name . '" ' . $disabled . ' class="upme-input ' . $required_class . '" name="' . $meta . '-' . $id . '" id="' . $meta . '-' . $id . '">';
                                $display .= '<option value="" ' . selected($profile_user_meta, "", 0) . '>' . __('Please Select', 'upme') . '</option>';
                                foreach ($loop as $option) {
                                    // Added as per http://codecanyon.net/item/user-profiles-made-easy-wordpress-plugin/discussion/4109874?filter=All+Discussion&page=27#comment_4352415
                                    $option = trim($option);
                                    $display .= '<option value="' . $option . '" ' . selected($profile_user_meta, $option, 0) . '>' . $option . '</option>';
                                }
                                $display .= '</select>';
                            }
                            $display .= '<div class="upme-clear"></div>';
                            break;

                        case 'radio':
                            if (isset($array[$key]['choices'])) {
                                $loop = explode(PHP_EOL, $choices);
                            }
                            if (isset($loop) && $loop[0] != '') {
                                foreach ($loop as $option) {
                                    // Added as per http://codecanyon.net/item/user-profiles-made-easy-wordpress-plugin/discussion/4109874?filter=All+Discussion&page=27#comment_4352415
                                    $option = trim($option);
                                    $display .= '<label class="upme-radio"><input title="' . $name . '" ' . $disabled . ' class="' . $required_class . '" type="radio" name="' . $meta . '-' . $id . '" value="' . $option . '" ' . checked(get_the_author_meta($meta, $id), $option, 0);
                                    $display .= '/> ' . $option . '</label>';
                                }
                            }
                            $display .= '<div class="upme-clear"></div>';
                            break;

                        case 'checkbox':
                            if (isset($array[$key]['choices'])) {
                                $loop = explode(PHP_EOL, $choices);
                            }
                            if (isset($loop) && $loop[0] != '') {
                                foreach ($loop as $option) {
                                    // Added as per http://codecanyon.net/item/user-profiles-made-easy-wordpress-plugin/discussion/4109874?filter=All+Discussion&page=27#comment_4352415
                                    $option = trim($option);
                                    $display .= '<label class="upme-checkbox"><input title="' . $name . '" ' . $disabled . ' class="' . $required_class . '" type="checkbox" name="' . $meta . '-' . $id . '[]" value="' . $option . '" ';
                                    $values = explode(', ', get_the_author_meta($meta, $id));
                                    if (in_array($option, $values)) {
                                        $display .= 'checked="checked"';
                                    }
                                    $display .= '/> ' . $option . '</label>';
                                }
                            }
                            $display .= '<div class="upme-clear"></div>';
                            break;

                        case 'password':
                            $display .= '<input title="' . $name . '" ' . $disabled . ' type="password" class="upme-input ' . $required_class . ' upme-edit-' . $meta . '" name="' . $meta . '-' . $id . '" id="' . $meta . '-' . $id . '" value="" autocomplete="off"  />';

                            if ($meta == 'user_pass') {
                                $display .= '<div class="upme-help">' . __('If you would like to change the password type a new one. Otherwise leave this blank.', 'upme') . '</div>';
                            } elseif ($meta == 'user_pass_confirm') {
                                $display .= '<div class="upme-help">' . __('Type your new password again.', 'upme') . '</div>';
                                $display .='<div class="password-meter"><div id="password-meter-message" class="password-meter-message">&nbsp;</div></div>';
                            }

                            break;

                        case 'fileupload':

                            if ($meta == 'user_pic') {

                                // Include removal link for profile images
                                $display_delete_link = '<div class="upme-delete-userpic-wrapper" upme-data-field-name="' . $meta . '" upme-data-user-id="' . $id . '"><i class="upme-icon-remove" original-title="remove"></i> <label class="upme-delete-image"  >' . __('Delete Image', 'upme') . '</label></div>';
                                $display_delete_link .= '<div id="upme-spinner-' . $meta . '" class="upme-delete-spinner"><i original-title="spinner" class="upme-icon-spinner upme-tooltip3"></i><label>' . __('Loading', 'upme') . '</label></div>';


                                $display .= '<div id="upme-current-picture" class="upme-note"><strong>' . __('Current Picture', 'upme') . ':</strong></div>';
                                if (get_the_author_meta('user_pic', $id) != '') {
                                    $display .= '<div class="upme-note upme-current-pic-note"><img id="upme-preview-user_pic" src="' . get_the_author_meta('user_pic', $id) . '" alt="" />' . $display_delete_link . '</div>';
                                } else {
                                    $display .= '<div class="upme-note upme-current-pic-note">' . get_avatar($id, 50) . '</div>';
                                    $display .= '<div class="upme-note upme-current-pic-note">' . __('You can sign up at <a href="http://en.gravatar.com/">Gravatar</a> to have a globally recognized avatar or upload a custom profile picture below.', 'upme') . '</div><div class="upme-clear"></div>';
                                }
                            } else {

                                // Include removal link for profile images
                                $display_delete_link = '<div class="upme-delete-image-wrapper" upme-data-field-name="' . $meta . '" upme-data-user-id="' . $id . '"><i class="upme-icon-remove" original-title="remove"></i> <label class="upme-delete-image"  >' . __('Delete Image', 'upme') . '</label></div>';
                                $display_delete_link .= '<div id="upme-spinner-' . $meta . '" class="upme-delete-spinner"><i original-title="spinner" class="upme-icon-spinner upme-tooltip3"></i><label>' . __('Loading', 'upme') . '</label></div>';


                                if (get_the_author_meta($meta, $id) != '') {
                                    $display .= '<div class="upme-note"><img src="' . get_the_author_meta($meta, $id) . '" alt="" />' . $display_delete_link . '</div>';
                                }
                            }

                            // Showing default file upload control for Opera and Safari
                            $uploader_box_url = admin_url('admin-ajax.php') . '?action=upme_initialize_upload_box&upme_disabled=' . $disabled . '&upme_meta=' . $meta . '&upme_id=' . $id . '&TB_iframe=true&width=720&height=530&scrolling=no';

                            $display_upload_btn = '<div class="clear"></div>';
                            $display_upload_btn .= ' <a id="user-avatar-link" class="thickbox" href="' . $uploader_box_url . '"  >';
                            $display_upload_btn .= '<input type="button" name="' . $meta . '-' . $id . '" id="file_' . $meta . '-' . $id . '" class="upme-init-uploadbox upme-button-alt-wide upme-fire-editor" value="' . __('Update Image', 'upme') . '"></a>';

                            if (is_safari() || is_opera()) {

                                if ($meta == 'user_pic') {
                                    $display .= $display_upload_btn;
                                } else {
                                    $display .= '<input title="' . $name . '" ' . $disabled . ' type="file" name="' . $meta . '-' . $id . '" id="file_' . $meta . '-' . $id . '" style="display:block;" />';
                                }
                            } else {

                                if ($meta == 'user_pic') {
                                    $display .= $display_upload_btn;
                                } else {
                                    $display .= '<input title="' . $name . '" class="upme-fileupload-field ' . $required_class . '" ' . $disabled . ' type="file" name="' . $meta . '-' . $id . '" id="file_' . $meta . '-' . $id . '" style="display:block;" />';
                                }
                            }


                            break;

                        case 'video':
                            $display .= '<input title="' . $name . '" ' . $disabled . ' type="text" class="upme-input ' . $required_class . ' upme-edit-' . $meta . '" name="' . $meta . '-' . $id . '" id="' . $meta . '-' . $id . '" value="' . get_the_author_meta($meta, $id) . '" />';
                            break;
                    }

                    /* User can hide this from public */
                    if (isset($array[$key]['can_hide']) && $can_hide == 1) {

                        /* user hide from public */
                        if (get_the_author_meta('hide_' . $meta, $id) == 1) {
                            $class = 'upme-icon-check';
                        } else {
                            $class = 'upme-icon-check-empty';
                        }

                        $display .= '<div class="upme-hide-from-public">
                        <i class="' . $class . '"></i>' . __('Hide from Public', 'upme') . '
                        <input type="hidden" name="hide_' . $meta . '-' . $id . '" id="hide_' . $meta . '-' . $id . '" value="' . get_the_author_meta('hide_' . $meta, $id) . '" />
                        </div>';
                    } elseif ($can_hide == 0 && $private == 0) {
                        //$display .= '<div class="upme-hide-from-public upme-disable">
                        //				'.sprintf(__('%s must be publicly visible.','upme'), $name).'
                        //			</div>';
                    }

                    $display .= '</div>';

                    $display .= '</div><div class="upme-clear"></div>';
                }
                //}
            }

            $display .= '<div class="upme-field upme-edit">
            <label class="upme-field-type upme-field-type-width-' . $width . ' upme-field-type-' . $sidebar_class . '">&nbsp;</label>
            <div class="upme-field-value">
            <input type="hidden" id="upme-edit-usr-id" value="' . $id . '" />
            <input type="hidden" name="upme-submit-' . $id . '" value="' . $id . '" />
            <input type="submit" name="upme-submit-' . $id . '" class="upme-button" value="' . __('Update Profile', 'upme') . '" />
            </div>
            </div><div class="upme-clear"></div>';

            $display .= '</form>';

            return $display;
        }
    }

    /* user flag */

    function user_flag($meta, $id) {
        global $predefined;
        $user_country = get_the_author_meta($meta, $id);
        $countries = $predefined->get_array('countries');

        if ($user_country == '0' || $user_country == '' || $user_country == 'Select Country') {
            return 'No Country Selected';
        } else {
            foreach ($countries as $code => $country) {
                if ($country == $user_country) {
                    return '<img src="' . upme_url . 'img/assets/flags/' . strtolower($code) . '.png" class="upme-img-normal" />';
                }
            }
        }
    }

    /* Display profile fields */

    function show_profile_fields($id, $view) {
        global $upme_roles;

        $display = null;

        $fullname = null;

        // Set date format from admin settings
        $upme_settings = get_option('upme_options');
        $upme_date_format = (string) isset($upme_settings['date_format']) ? $upme_settings['date_format'] : 'mm/dd/yy';


        $profile_fields = get_option('upme_profile_fields');

        /* If user specified view (specific fields)
          It should be included (filter profile fields
          to show only these fields */
        if ($view) {
            $view_fields = explode(',', $view);

            foreach ($profile_fields as $key => $array) {
                if (!in_array($key, $view_fields) && (isset($array['meta']) && !in_array($array['meta'], $view_fields))) {
                    unset($profile_fields[$key]);
                }
            }
        }

        /* Done filtering */

        // Showing ID

        if ($this->profile_show_id == 'true') {
            $display.='<div class="upme-field upme-view">';
            $display.='<div class="upme-field-type"><i class="upme-icon-user"></i><span>' . __('User ID', 'upme') . '</span></div>';
            $display.='<div class="upme-field-value"><span>' . $id . '</span></div>';
            $display.='</div>';
            $display.='<div class="upme-clear"></div>';
        }

        /* echo "<pre>";
          print_r($profile_fields); die; */
        foreach ($profile_fields as $key => $field) {
            //echo "<pre>";
            //print_r($profile_fields);exit;
            extract($field);

            // WP 3.6 Fix
            if (!isset($deleted))
                $deleted = 0;

            if (!isset($private))
                $private = 0;

            if ($type == 'separator' || ($type == 'usermeta' && $field != 'password' && get_the_author_meta($meta, $id) == '')) {
                if ($type == 'separator') {
                    if ($this->get_option('show_separator_on_profile') == '1') {
                        $display .='<div class="upme-field upme-separator upme-view upme-clearfix">' . $field['name'] . '</div>';
                    }
                } else {
                    if ($this->get_option('show_empty_field_on_profile') == '1') {

                        $profile_fields_icon = isset($profile_fields[$key]['icon']) ? $profile_fields[$key]['icon'] : '';
                        $icon = isset($icon) ? $icon : '';
                        $name = isset($name) ? $name : '';

                        $show_to_user_role = isset($show_to_user_role) ? $show_to_user_role : '0';
                        $show_to_user_role_list = isset($show_to_user_role_list) ? $show_to_user_role_list : '';

                        $upme_roles->upme_get_user_roles_by_id($id);
                        $show_field_status = $upme_roles->upme_empty_fields_by_user_role($show_to_user_role, $show_to_user_role_list);

                        if ($show_field_status) {
                            $display .= '<div class="upme-field upme-view">';
                            $display.= '<div class="upme-field-type">';

                            if (isset($profile_fields_icon) && $icon) {
                                $display .= '<i class="upme-icon-' . $icon . '"></i>';
                            } else {
                                $display .= '<i class="upme-icon-none"></i>';
                            }

			    $display.= '<span>' . $name . '</span>';
                            $display .= '</div>';

                            $display.= '<div class="upme-field-value">';
                            $display.= '<span>-</span>';
                            $display.= '</div>';

                            $display .= '</div><div class="upme-clear"></div>';
                        }
                    }
                }
            }




            if ($type == 'usermeta' && get_the_author_meta($meta, $id) != '' && $deleted == 0) {
                if ($social == 0 || ( $social == 1 && $meta == 'user_email' ) || !isset($profile_fields[$key]['social'])) {

                    /* Do not show private fields */
                    if ($private == 0 || ($private == 1 && current_user_can('manage_options') )) {

                        $show_to_user_role = isset($show_to_user_role) ? $show_to_user_role : '0';
                        $show_to_user_role_list = isset($show_to_user_role_list) ? $show_to_user_role_list : '';

                        $upme_roles->upme_get_user_roles_by_id($id);
                        $show_field_status = $upme_roles->upme_fields_by_user_role($show_to_user_role, $show_to_user_role_list);

                        if ($show_field_status) {
                            if (2 != $can_hide || ( 2 == $can_hide && $this->can_edit_profile($this->logged_in_user, $id) )) {
                                if (get_the_author_meta('hide_' . $meta, $id) == 0 || ( get_the_author_meta('hide_' . $meta, $id) == 1 && $this->can_edit_profile($this->logged_in_user, $id) )) {



                                    if ($meta == 'first_name') {
                                        $display .= '<div class="upme-field upme-view">
                                    <div class="upme-field-type">';

                                        if (isset($profile_fields[$key]['icon']) && $icon) {
                                            $display .= '<i class="upme-icon-' . $icon . '"></i>';
                                        } else {
                                            $display .= '<i class="upme-icon-none"></i>';
                                        }

                                        $display .= '<span>' . __('Name', 'upme') . '</span></div>
                                    <div class="upme-field-value"><span>' . $this->get_user_name($id) . '</span></div>
                                    </div><div class="upme-clear"></div>';
                                    } elseif ($meta == 'last_name') {

                                    } else {

                                        /* Do not show these fields */
                                        if ($meta == 'display_name')
                                            continue;
                                        if ($meta == 'user_pass')
                                            continue;
                                        if ($meta == 'user_pass_confirm')
                                            continue;
                                        if ($meta == 'user_pic')
                                            continue;

                                        /* Show these fields */
                                        $display .= '<div class="upme-field upme-view">
                                    <div class="upme-field-type">';

                                        if (isset($profile_fields[$key]['icon']) && $icon) {
                                            $display .= '<i class="upme-icon-' . $icon . '"></i>';
                                        } else {
                                            $display .= '<i class="upme-icon-none"></i>';
                                        }

                                        $display .= '<span>' .$name . '</span></div>
                                    <div class="upme-field-value">';




                                        if ($field == 'fileupload') {

                                            $display .= '<img src="' . get_the_author_meta($meta, $id) . '" alt="" />';
                                        } else if ($field == 'datetime') {
                                            $display .= '<span>';

                                            $date_time_value = get_the_author_meta($meta, $id);
                                            $display .= upme_date_format_to_custom($date_time_value, $upme_date_format);


                                            $display .= '</span>';

                                        } else if($field == 'video'){

                                            $video_url = get_the_author_meta($meta, $id);
                                            $player_details = upme_video_type_css($video_url);
                                            $player_url = upme_video_url_customizer($video_url);

                                            $display .= '<div class="upme-video-container">';
                                            $display .= '<iframe  width="'.$player_details['width'].'" height="'.$player_details['height'].'" src="'.$player_url.'" frameborder="0" allowfullscreen ></iframe>';
                                            $display .= '</div>';
                                        } else {

                                            if (isset($profile_fields[$key]['allow_html']) && $allow_html == 1) {
                                                $display .= str_replace("\r\n", "<br />", html_entity_decode(get_the_author_meta($meta, $id)));
                                            } else {
                                                $display .= '<span>';

                                                /* Append country with flag */
                                                if (isset($profile_fields[$key]['predefined_loop']) && $predefined_loop == 'countries') {
                                                    $display .= $this->user_flag($meta, $id);
                                                }

if($name == 'Events Attended')
                                                {
////////////////



////////////////
$user_id=$id;					
$orders=array();//order ids
     
    $args = array(
        'numberposts'     => -1,
        'meta_key'        => '_customer_user',
        'meta_value'      => $user_id,
        'post_type'       => 'shop_order',
        'post_status'     => 'publish',
        'tax_query'=>array(
                array(
                    'taxonomy'  =>'shop_order_status',
                    'field'     => 'slug',
                    'terms'     =>'completed'
                    )
        )  
    );
    global $wpdb;
    $posts=get_posts($args);
    //get the post ids as order ids
    $orders=wp_list_pluck( $posts, 'ID' );
//print_r($orders);
foreach($orders as $order)
{
 $eve_id = $wpdb->get_var( "SELECT max(meta_value) AS meta_value FROM `wp_postmeta` where post_id IN (SELECT post_id FROM `wp_postmeta` where meta_value = $order and meta_key =  '_tribe_wooticket_order' ) and meta_key = '_tribe_wooticket_event'");


if(get_permalink( $eve_id ) != "" and get_the_title($eve_id) != "")
$display .= '<a href = '.get_permalink( $eve_id ).'>'.get_the_title($eve_id).'</a><br>';

//print_r($order);
}	}					
						if($name == 'Certification')
                                                {
					global $wpdb;

						

$queryy = "SELECT  id, instructor_id, certification_id, Date_Sub(certification_expiry_date, interval 3 month) as certification_expiry_date ,name,email  FROM `wp_Instructors_Certification` where instructor_id = $id and Date_Sub(certification_expiry_date, interval 3 month) > curdate() ";


	$user_certs_obj = $wpdb->get_results($queryy, ARRAY_A);
	
	foreach ($user_certs_obj as $cert_obj)
{		if($cert_obj['name'] == '')
		continue;						
	$cert_id = $wpdb->get_var( "SELECT ID FROM wp_posts where post_title ='{$cert_obj['name']}' and post_type = 'certificate_template' ");
					
  $cert_aid = $wpdb->get_var( "SELECT meta_value FROM `wp_postmeta` where post_id = $cert_id and meta_key = '_thumbnail_id'");							 $val = $wpdb->get_var( "SELECT guid  FROM wp_posts where ID =$guid_id ");
							$val = $wpdb->get_var( "SELECT guid FROM wp_posts where ID =$cert_aid ");							$display .= '<img src="'.$val.'" alt="Smiley face" style= " float: left" >';
							if(is_super_admin(get_current_user_id()))
							$expiry_string = "(".$cert_obj['certification_expiry_date'].")";
							$display .= '<div class = "upme-field-value" style="float: right">'.$cert_obj['name'].''.$expiry_string.'</div>';
							$display .= '<br><br>';}


///////// for admin expired certicates
						
//echo $id;

if(is_super_admin(get_current_user_id()))
{
$display .= '<br><br><br><b>-----Expired Certificates-----</b><br>';
$queryy = "SELECT  id, instructor_id, certification_id, Date_Sub(certification_expiry_date, interval 3 month) as certification_expiry_date ,name,email  FROM `wp_Instructors_Certification` where instructor_id = $id and Date_Sub(certification_expiry_date, interval 3 month) < curdate() ";


	$user_certs_obj = $wpdb->get_results($queryy, ARRAY_A);
	
	foreach ($user_certs_obj as $cert_obj)
{				if($cert_obj['name'] == '')
					continue;			
	$cert_id = $wpdb->get_var( "SELECT ID FROM wp_posts where post_title ='{$cert_obj['name']}' and post_type = 'certificate_template' and post_status = 'private'");
					
  $cert_aid = $wpdb->get_var( "SELECT meta_value FROM `wp_postmeta` where post_id = $cert_id and meta_key = '_thumbnail_id'");							 $val = $wpdb->get_var( "SELECT guid  FROM wp_posts where ID =$guid_id ");
							$val = $wpdb->get_var( "SELECT guid FROM wp_posts where ID =$cert_aid ");							$display .= '<img src="'.$val.'" alt="Smiley face" style= " float: left">';
							$expiry_string = "(".$cert_obj['certification_expiry_date'].")";
							$display .= '<div class = "upme-field-value" style="float: right">'.$cert_obj['name'].''.$expiry_string.'</div>';
							$display .= '<br><br>';}}



						}
								
							
						
						//print_r($certif);
						
						else
						{$display .= get_the_author_meta($meta, $id);}

                                                $display .= '</span>';
                                            }
                                        }

                                        $display .= '</div>
                                    </div><div class="upme-clear"></div>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $display;
    }

    /* Get social profiles of user */

    function show_user_social_profiles($id) {
        $display = null;
        $array = get_option('upme_profile_fields');
        $display .= '<div class="upme-social">';
        $profile_fields = get_option('upme_profile_fields');
        foreach ($profile_fields as $key => $field) {
            extract($field);
            if ($type == 'usermeta' && isset($profile_fields[$key]['social']) && $social == 1 && get_the_author_meta($meta, $id) != '' && ( get_the_author_meta('hide_' . $meta, $id) == 0 || ( get_the_author_meta('hide_' . $meta, $id) == 1 && $this->can_edit_profile($this->logged_in_user, $id) ) )) {

                $display .= '<div class="upme-' . $icon . '"><a target="_blank" rel="external nofollow" href="';

                if ($meta == 'user_email') {
                    $display .= 'mailto:';
                }

                if ($meta == 'twitter') {
                    $meta_value = 'http://twitter.com/' . get_the_author_meta($meta, $id);
                } else {
                    $meta_value = get_the_author_meta($meta, $id);
                }
                $display .= $meta_value;

                $display .= '"';
                if (isset($array[$key]['tooltip']) && $tooltip) {
                    $display .= ' class="upme-tooltip" title="' . $tooltip . '"';
                }
                $display .= '><i class="upme-icon-' . $icon . '"></i></a></div>';
            }
        }
        $display .= '</div><div class="upme-clear"></div>';
        return $display;
    }

    /* Get full name of user */

    function get_user_name($id) {
        $name = null;
        if (get_the_author_meta('first_name', $id) || get_the_author_meta('last_name', $id)) {
            if (get_the_author_meta('first_name', $id) != '') {
                $name .= get_the_author_meta('first_name', $id) . ' ';
            }
            if (get_the_author_meta('last_name', $id) != '') {
                $name .= get_the_author_meta('last_name', $id);
            }
        }
        return $name;
    }

    /* Get number of entries */

    function get_entries_num($id) {
        $count = count_user_posts($id);
        if ($count == 1) {
            return sprintf(__('%s entry', 'upme'), $count);
        } else {
            return sprintf(__('%s entries', 'upme'), $count);
        }
    }

    /* Get number of comments */

    function get_comments_num($id) {
        $args = array('user_id' => $id);
        $comments = get_comments($args);
        $count = count($comments);
        if ($count == 1) {
            return sprintf(__('%s comment', 'upme'), $count);
        } else {
            return sprintf(__('%s comments', 'upme'), $count);
        }
    }

    /* Post value */

    function post_value($meta) {
        global $upme_register;

        if (isset($_POST['upme-register-form'])) {
            if (isset($_POST[$meta])) {
                return $_POST[$meta];
            }
        } else {
            if (strstr($meta, 'country')) {
                return 'United States';
            }
        }
    }

    /* Show registration form */

    function show_registration($args=array()) {

        global $post, $upme_register;


        // Loading scripts and styles only when required
        /* Password Stregth Checker Script */
        if (!wp_script_is('form-validate')) {
            wp_register_script('form-validate', upme_url . 'js/form-validate.js', array('jquery'));
            wp_enqueue_script('form-validate');

            $validate_strings = array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'ErrMsg' => array(
                    'similartousername' => __('Your password is too similar to your username.', 'upme'),
                    'mismatch' => __('Both passwords do not match.', 'upme'),
                    'tooshort' => __('Your password is too short.', 'upme'),
                    'veryweak' => __('Your password strength is too weak.', 'upme'),
                    'weak' => __('Your password strength is weak.', 'upme'),
                    'usernamerequired' => __('Please provide username.', 'upme'),
                    'emailrequired' => __('Please provide email address.', 'upme'),
                    'validemailrequired' => __('Please provide valid email address.', 'upme'),
                    'usernameexists' => __('That username is already taken, please try a different one.', 'upme'),
                    'emailexists' => __('The email you entered is already registered. Please try a new email or log in to your existing account.', 'upme')
                ),
                'MeterMsg' => array(
                    'similartousername' => __('Your password is too similar to your username.', 'upme'),
                    'mismatch' => __('Both passwords do not match.', 'upme'),
                    'tooshort' => __('Your password is too short.', 'upme'),
                    'veryweak' => __('Your password strength is too weak.', 'upme'),
                    'weak' => __('Your password strength is weak.', 'upme'),
                    'good' => __('Good', 'upme'),
                    'strong' => __('Strong', 'upme')
                ),
                'Err' => __('ERROR', 'upme')
            );

            wp_localize_script('form-validate', 'Validate', $validate_strings);
        }

        if (!wp_style_is('upme_password_meter')) {
            wp_register_style('upme_password_meter', upme_url . 'css/password-meter.css');
            wp_enqueue_style('upme_password_meter');
        }


        /* Arguments */
        $defaults = array(
            'use_in_sidebar' => null,
            //'redirect_to' => $this->current_page
            'redirect_to' => null
        );
        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);

        $pic_class = 'upme-pic';
        if (is_safari ())
            $pic_class = 'upme-pic safari';

        // Default set to blank
        $this->captcha = '';
        if (isset($captcha))
            $this->captcha = $captcha;

        $sidebar_class = null;
        if ($use_in_sidebar)
            $sidebar_class = 'upme-sidebar';

        $display = null;


        if (get_option('users_can_register') == '1') {

            /* Get errors */
            if (isset($_POST['upme-register-form'])) {
                $display_errors = $upme_register->get_errors();
            }

            $display .= '<div id="upme-registration" class="upme-wrap upme-registration ' . $sidebar_class . '">
            <div class="upme-inner upme-clearfix">';


            // Display the head section for default screen and error messages
            if (!isset($display_errors['status']) || (isset($display_errors['status']) && ("error" == $display_errors['status']))) {

                $display .= '               <div class="upme-head">

                <div class="upme-left">
                <div class="' . $pic_class . '">';

                if (isset($_POST['upme-register']) && $_POST['user_email'] != '') {
                    $display .= $this->pic($_POST['user_email'], 50);
                } else {
                    $display .= $this->pic('john@doe.com', 50);
                }

                $display .= '</div>';

                $display .= '<div class="upme-name">

                <div class="upme-field-name upme-field-name-wide">';

                if (isset($_POST['upme-register']) && $_POST['display_name'] != '') {
                    $display .= $_POST['display_name'];
                } else {
                    $display .= __('Your display name will appear here.', 'upme');
                }

                $display .= '</div>

                </div>';

                $display .= '</div>';


                $display .= '<div class="upme-right">';

                $display .= '</div><div class="upme-clear"></div>

                </div>';
            }

            $display .= '               <div class="upme-main">

            <div class="upme-errors" style="display:none;" id="pass_err_holder">
            <span class="upme-error upme-error-block" id="pass_err_block">
            <i class="upme-icon-remove"></i>Please enter a username.
            </span>
            </div>
            ';

            /* Display errors */
            if (isset($_POST['upme-register-form'])) {
                $display .= $display_errors['display'];
            }

            $display .= $this->show_register_form($sidebar_class, $redirect_to);

            $display .= '</div>

            </div>
            </div>';
        } else {
            $display .= '<div id="upme-registration" class="upme-wrap upme-registration ' . $sidebar_class . '"><div class="upme-inner upme-clearfix"><div class="upme-head">';
            if ($this->get_option('html_registration_disabled') != '')
                $display.=$this->get_option('html_registration_disabled');
            else
                $display.=__('User registration is currently not allowed.', 'upme');

            $display .= '</div></div></div>';
        }

        return $display;
    }

    /* Display registration form */

    function show_register_form($sidebar_class=null, $redirect_to=null) {
        global $upme_register, $predefined, $upme_captcha_loader;
        $display = null;

        /* Get end of array */
        $array = get_option('upme_profile_fields');

        // Optimized condition and added strict conditions
        if (!isset($upme_register->registered) || $upme_register->registered != 1) {

            $display .= '<form action="" method="post" id="upme-registration-form">';

            $display .= '<div class="upme-field upme-separator upme-edit upme-edit-show upme-clearfix">' . __('Account Info', 'upme') . '</div>';

            /* Add Account Information Fields to top of Registration fields */

            foreach ($this->registration_fields as $key => $field) {

                extract($field);

                if ($type == 'usermeta') {

                    $display .= '<div class="upme-field upme-edit upme-edit-show">';

                    /* Show the label */
                    if (isset($this->registration_fields[$key]['name']) && $name) {
                        $display .= '<label class="upme-field-type" for="' . $meta . '">';
                        if (isset($this->registration_fields[$key]['icon']) && $icon) {
                            $display .= '<i class="upme-icon-' . $icon . '"></i>';
                        } else {
                            $display .= '<i class="upme-icon-none"></i>';
                        }
                        $display .= '<span>' . $name . '</span></label>';
                    } else {
                        $display .= '<label class="upme-field-type">&nbsp;</label>';
                    }

                    if (!isset($required))
                        $required = 0;

                    $required_class = '';
                    if ($required == 1 && in_array($field, $this->include_for_validation)) {
                        $required_class = ' required';
                    }

                    $display .= '<div class="upme-field-value">';

                    switch ($field) {


                        case 'textarea':
                            $display .= '<textarea class="upme-input' . $required_class . '" name="' . $meta . '" id="reg_' . $meta . '" title="' . $name . '">' . $this->post_value($meta) . '</textarea>';
                            break;

                        case 'text':
                            $display .= '<input type="text" class="upme-input' . $required_class . '" name="' . $meta . '" id="reg_' . $meta . '" value="' . $this->post_value($meta) . '" title="' . $name . '" />';

                            if (isset($this->registration_fields[$key]['help']) && $help != '') {
                                $display .= '<div class="upme-help">' . $help . '</div><div class="upme-clear"></div>';
                            }

                            break;

                        case 'datetime':

                            $display .= '<input type="text" readonly="readonly" class="upme-input' . $required_class . ' upme-datepicker" name="' . $meta . '" id="reg_' . $meta . '" value="' . $this->post_value($meta) . '" title="' . $name . '" />';

                            if (isset($this->registration_fields[$key]['help']) && $help != '') {
                                $display .= '<div class="upme-help">' . $help . '</div><div class="upme-clear"></div>';
                            }
                            break;

                        case 'password':

                            $display .= '<input type="password" class="upme-input password' . $required_class . '" name="' . $meta . '" id="reg_' . $meta . '" value="" autocomplete="off" title="' . $name . '" />';

                            if (isset($this->registration_fields[$key]['help']) && $help != '') {
                                $display .= '<div class="upme-help">' . $help . '</div><div class="upme-clear"></div>';
                            }

                            break;

                        case 'password_indicator':
                            $display .= '<div class="password-meter"><div class="password-meter-message" id="password-meter-message">&nbsp;</div></div>';
                            break;

                        case 'video':
                            $display .= '<input type="text" class="upme-input' . $required_class . '" name="' . $meta . '" id="reg_' . $meta . '" value="' . $this->post_value($meta) . '" title="' . $name . '" />';

                            if (isset($this->registration_fields[$key]['help']) && $help != '') {
                                $display .= '<div class="upme-help">' . $help . '</div><div class="upme-clear"></div>';
                            }

                            break;
                    }

                    /* User can hide this from public */
                    if (isset($this->registration_fields[$key]['can_hide']) && $can_hide == 1) {

                        foreach ($array as $key => $meta_field) {
                            if ('user_email' == $meta_field['meta'] && 1 == $meta_field['can_hide']) {
                                $display .= '<div class="upme-hide-from-public">
                        <i class="upme-icon-check-empty"></i>' . __('Hide from Public', 'upme') . '
                        <input type="hidden" name="hide_' . $meta . '" id="hide_' . $meta . '" value="" />
                        </div>';
                            }
                        }
                    }

                    $display .= '</div>';

                    $display .= '</div><div class="upme-clear"></div>';
                }
            }




            foreach ($array as $key => $field) {
                // Optimized condition and added strict conditions
                $exclude_array = array('user_pass', 'user_pass_confirm', 'user_email');
                if (isset($field['meta']) && in_array($field['meta'], $exclude_array)) {
                    unset($array[$key]);
                }
            }

            $i_array_end = end($array);

            if (isset($i_array_end['position'])) {
                $array_end = $i_array_end['position'];
                if ($array[$array_end]['type'] == 'separator') {
                    unset($array[$array_end]);
                }
            }


            /* Show the fields that user added to customizer */

            foreach ($array as $key => $field) {

                extract($field);

                // WP 3.6 Fix
                if (!isset($deleted))
                    $deleted = 0;

                if (!isset($private))
                    $private = 0;

                if (!isset($required))
                    $required = 0;

                $required_class = '';
                if ($required == 1 && in_array($field, $this->include_for_validation)) {
                    $required_class = ' required';
                }


                /* separator */
                if ($type == 'separator' && $deleted == 0 && $private == 0 && isset($array[$key]['show_in_register']) && $array[$key]['show_in_register'] == 1) {
                    $display .= '<div class="upme-field upme-separator upme-edit upme-edit-show upme-clearfix">' . $name . '</div>';
                }

                /* user meta - registration fields */
                if ($type == 'usermeta' && $deleted == 0 && $private == 0 && isset($array[$key]['show_in_register']) && $array[$key]['show_in_register'] == 1) {

                    $display .= '<div class="upme-field upme-edit upme-edit-show">';

                    /* Show the label */
                    if (isset($array[$key]['name']) && $name) {
                        $display .= '<label class="upme-field-type" for="' . $meta . '">';
                        if (isset($array[$key]['icon']) && $icon) {
                            $display .= '<i class="upme-icon-' . $icon . '"></i>';
                        } else {
                            $display .= '<i class="upme-icon-none"></i>';
                        }
                        $display .= '<span>' . $name . '</span></label>';
                    } else {
                        $display .= '<label class="upme-field-type">&nbsp;</label>';
                    }

                    $display .= '<div class="upme-field-value">';

                    switch ($field) {

                        case 'textarea':
                            $display .= '<textarea class="upme-input' . $required_class . '" name="' . $meta . '" id="' . $meta . '" title="' . $name . '">' . $this->post_value($meta) . '</textarea>';
                            break;

                        case 'text':
                            $display .= '<input type="text" class="upme-input' . $required_class . '" name="' . $meta . '" id="' . $meta . '" value="' . $this->post_value($meta) . '"  title="' . $name . '" />';
                            break;


                        case 'datetime':
                            $display .= '<input type="text" readonly="readonly" class="upme-input' . $required_class . ' upme-datepicker" name="' . $meta . '" id="' . $meta . '" value="' . $this->post_value($meta) . '"  title="' . $name . '" />';
                            break;

                        case 'select':
                            if (isset($array[$key]['predefined_loop']) && $array[$key]['predefined_loop'] != '' && $array[$key]['predefined_loop'] != '0') {
                                $loop = $predefined->get_array($array[$key]['predefined_loop']);
                            } else if (isset($array[$key]['choices']) && $array[$key]['choices'] != '') {
                                $loop = explode(PHP_EOL, $choices);
                            }

                            if (isset($loop)) {
                                $display .= '<select class="upme-input' . $required_class . '" name="' . $meta . '" id="' . $meta . '" title="' . $name . '">';
                                foreach ($loop as $option) {

                                    // Added as per http://codecanyon.net/item/user-profiles-made-easy-wordpress-plugin/discussion/4109874?filter=All+Discussion&page=27#comment_4352415

                                    $option = trim($option);

                                    $display .= '<option value="' . $option . '" ' . selected($this->post_value($meta), $option, 0) . '>' . $option . '</option>';
                                }
                                $display .= '</select>';
                            }
                            $display .= '<div class="upme-clear"></div>';
                            break;

                        case 'radio':
                            if (isset($array[$key]['choices'])) {
                                $loop = explode(PHP_EOL, $choices);
                            }
                            if (isset($loop) && $loop[0] != '') {
                                $counter = 0;
                                foreach ($loop as $option) {
                                    if ($counter > 0)
                                        $required_class = '';
                                    // Added as per http://codecanyon.net/item/user-profiles-made-easy-wordpress-plugin/discussion/4109874?filter=All+Discussion&page=27#comment_4352415
                                    $option = trim($option);
                                    $display .= '<label class="upme-radio"><input type="radio" class="' . $required_class . '" title="' . $name . '" name="' . $meta . '" value="' . $option . '" ' . checked($this->post_value($meta), $option, 0);
                                    $display .= '/> ' . $option . '</label>';

                                    $counter++;
                                }
                            }
                            $display .= '<div class="upme-clear"></div>';
                            break;

                        case 'checkbox':
                            if (isset($array[$key]['choices'])) {
                                $loop = explode(PHP_EOL, $choices);
                            }
                            if (isset($loop) && $loop[0] != '') {
                                $counter = 0;
                                foreach ($loop as $option) {

                                    if ($counter > 0)
                                        $required_class = '';

                                    // Added as per http://codecanyon.net/item/user-profiles-made-easy-wordpress-plugin/discussion/4109874?filter=All+Discussion&page=27#comment_4352415
                                    $option = trim($option);
                                    $display .= '<label class="upme-checkbox"><input type="checkbox" class="' . $required_class . '" title="' . $name . '" name="' . $meta . '[]" value="' . $option . '" ';
                                    if (is_array($this->post_value($meta)) && in_array($option, $this->post_value($meta))) {
                                        $display .= 'checked="checked"';
                                    }
                                    $display .= '/> ' . $option . '</label>';

                                    $counter++;
                                }
                            }
                            $display .= '<div class="upme-clear"></div>';
                            break;

                        case 'password':
                            $display .= '<input type="password" class="upme-input' . $required_class . '" title="' . $name . '" name="' . $meta . '" id="' . $meta . '" value="' . $this->post_value($meta) . '" />';

                            if ($meta == 'user_pass') {
                                $display .= '<div class="upme-help">' . __('If you would like to change the password type a new one. Otherwise leave this blank.', 'upme') . '</div>';
                            } elseif ($meta == 'user_pass_confirm') {
                                $display .= '<div class="upme-help">' . __('Type your new password again.', 'upme') . '</div>';
                            }
                            break;


                        case 'video':
                            $display .= '<input type="text" class="upme-input' . $required_class . '" name="' . $meta . '" id="reg_' . $meta . '" value="' . $this->post_value($meta) . '" title="' . $name . '" />';

                            if (isset($this->registration_fields[$key]['help']) && $help != '') {
                                $display .= '<div class="upme-help">' . $help . '</div><div class="upme-clear"></div>';
                            }

                            break;
                    }

                    /* User can hide this from public */
                    if (isset($array[$key]['can_hide']) && $can_hide == 1) {

                        $display .= '<div class="upme-hide-from-public">
                        <i class="upme-icon-check-empty"></i>' . __('Hide from Public', 'upme') . '
                        <input type="hidden" name="hide_' . $meta . '" id="hide_' . $meta . '" value="" />
                        </div>';
                    } elseif ($can_hide == 0 && $private == 0) {
                        // Commented Out text Field Must be Publicly Visible
                        //$display .= '<div class="upme-hide-from-public upme-disable">
                        //				'.sprintf(__('%s must be publicly visible.','upme'), $name).'
                        //			</div>';
                    }

                    $display .= '</div>';

                    $display .= '</div><div class="upme-clear"></div>';
                }
            }

            $display.=$upme_captcha_loader->load_captcha($this->captcha);

            //if($this->use_captcha == 'yes')
            //else
            //  $display.='<input type="hidden" name="no_captcha" value="yes" />';


            $display .= '<div class="upme-field upme-edit upme-edit-show">
            <label class="upme-field-type upme-field-type-' . $sidebar_class . '">&nbsp;</label>
            <div class="upme-field-value">
            <input type="hidden" name="upme-register-form" value="upme-register-form" />
            <input type="submit" name="upme-register" id="upme-register" class="upme-button" value="' . __('Register', 'upme') . '" />
            </div>
            </div><div class="upme-clear"></div>';

            if ($redirect_to != '') {
                $display .= '<input type="hidden" name="redirect_to" value="' . $redirect_to . '" />';
            }

            $display .= '</form>';
        } // Registration complete

        return $display;
    }

    /* Login Form on Front end */

    function login($args=array()) {

        global $upme_login;

        // Increasing Counter for Shortcode number
        $this->login_code_count++;

        // Check if redirect to is not set and redirect to is availble in URL
        $default_redirect = "";
        if (isset($_GET['redirect_to']) && $_GET['redirect_to'] != '')
            $default_redirect = $_GET['redirect_to'];

        /* Arguments */
        $defaults = array(
            'use_in_sidebar' => null,
            'redirect_to' => $default_redirect
        );

        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);

        // Default set to no captcha
        $this->captcha = 'no';
        if (isset($captcha))
            $this->captcha = $captcha;


        $sidebar_class = null;
        if ($use_in_sidebar)
            $sidebar_class = 'upme-sidebar';

        $display = null;
        $display .= '<div class="upme-wrap upme-login ' . $sidebar_class . '">
        <div class="upme-inner upme-clearfix upme-login-wrapper">';

        $display .= '<div class="upme-head">';
        $display .='<div class="upme-left">';
        $display .='<div class="upme-field-name upme-field-name-wide login-heading" id="login-heading-' . $this->login_code_count . '">' . __('Login', '') . '</div>';
        $display .='</div>';
        $display .='<div class="upme-right"></div><div class="upme-clear"></div>';
        $display .= '</div>';

        $display .='<div class="upme-main">';

        /* Display errors */
        if (isset($_POST['upme-login'])) {
            $display .= $upme_login->get_errors();
        }

        $display .= $this->show_login_form($sidebar_class, $redirect_to);

        $display .= '</div>

        </div>
        </div>';

        return $display;
    }

    /* Show login forms */

    function show_login_form($sidebar_class=null, $redirect_to=null) {
        global $upme_login, $upme_captcha_loader;



        $display = null;
        $display .= '<form action="" method="post" id="upme-login-form-' . $this->login_code_count . '">';


        foreach ($this->login_fields as $key => $field) {
            extract($field);

            if ($type == 'usermeta') {

                $display .= '<div class="upme-field upme-edit upme-edit-show">';

                /* Show the label */
                $placeholder = '';
                $icon_name = '';
                $input_ele_class = '';
                if ($sidebar_class == null) {
                    if (isset($this->login_fields[$key]['name']) && $name) {
                        $display .= '<label class="upme-field-type" for="' . $meta . '">';
                        if (isset($this->login_fields[$key]['icon']) && $icon) {
                            $display .= '<i class="upme-icon-' . $icon . '"></i>';
                        } else {
                            $display .= '<i class="upme-icon-none"></i>';
                        }
                        $display .= '<span>' . $name . '</span></label>';
                    } else {
                        $display .= '<label class="upme-field-type">&nbsp;</label>';
                    }
                } else {
                    $icon_name.='<label class="upme-field-type-sidebar">';
                    if (isset($this->login_fields[$key]['icon']) && $icon) {
                        $icon_name .= '<i class="upme-icon-' . $icon . '"></i>';
                    } else {
                        $icon_name .= '<i class="upme-icon-none"></i>';
                    }
                    $icon_name.='</label>';
                    $placeholder = ' placeholder="' . $name . '"';
                    $input_ele_class = ' in_sidebar_value';
                }



                $display .= '<div class="upme-field-value">';

                $display .=$icon_name;

                switch ($field) {
                    case 'textarea':
                        $display .= '<textarea class="upme-input' . $input_ele_class . '" name="' . $meta . '" id="' . $meta . '" ' . $placeholder . '>' . $this->post_value($meta) . '</textarea>';
                        break;
                    case 'text':
                        $display .= '<input type="text" class="upme-input' . $input_ele_class . '" name="' . $meta . '" id="' . $meta . '" value="' . $this->post_value($meta) . '" ' . $placeholder . ' />';

                        if (isset($this->login_fields[$key]['help']) && $help != '') {
                            $display .= '<div class="upme-help">' . $help . '</div><div class="upme-clear"></div>';
                        }

                        break;
                    case 'password':
                        $display .= '<input type="password" class="upme-input' . $input_ele_class . '" name="' . $meta . '" id="' . $meta . '" value="" ' . $placeholder . ' />';
                        break;
                }

                if ($field == 'password') {

                }



                $display .= '</div>';

                $display .= '</div><div class="upme-clear"></div>';
            }
        }


        $display.=$upme_captcha_loader->load_captcha($this->captcha);

        $display .= '<div class="upme-field upme-edit upme-edit-show">
        <label class="upme-field-type upme-field-type-' . $sidebar_class . '">&nbsp;</label>
        <div class="upme-field-value">';

        if (isset($_POST['rememberme']) && $_POST['rememberme'] == 1) {
            $class = 'upme-icon-check';
        } else {
            $class = 'upme-icon-check-empty';
        }


        // Forgot Pass Link
        $forgot_pass = '<a href="javascript:void(0);" id="upme-forgot-pass-' . $this->login_code_count . '" class="upme-login-forgot-link ' . $sidebar_class . '" title="' . __('Forget?', 'upme') . '">' . __('Forget?', 'upme') . '</a>';

        // Register Link
        $register_link = site_url('/wp-login.php?action=register');

        $page_url = '';
        $page_url = get_permalink($this->get_option('registration_page_id'));
        if ($page_url != '')
            $register_link = $page_url;


        $register_link = '<a href="' . $register_link . '" class="upme-login-register-link ' . $sidebar_class . '">' . __('Register', 'upme') . '</a>';

        $remember_me_class = '';
        $login_btn_class = '';
        if ($sidebar_class != null) {
            $login_btn_class = ' in_sidebar';
            $remember_me_class = ' in_sidebar_remember';
        }


        $display .= '<div class="upme-rememberme' . $remember_me_class . '">
        <i class="' . $class . '"></i>' . __('Remember me', 'upme') . '
        <input type="hidden" name="rememberme" id="rememberme-' . $this->login_code_count . '" value="0" />
        </div><input type="submit" name="upme-login" class="upme-button upme-login' . $login_btn_class . '" value="' . __('Log In', 'upme') . '" /><br />' . $forgot_pass . ' | ' . $register_link;


        $display .= ' </div>
        </div><div class="upme-clear"></div>';

        $display .= '<input type="hidden" name="redirect_to" value="' . $redirect_to . '" />';

        $display .= '</form>';




        // Generating Forgot Password Form
        $forgot_pass = '';

        $forgot_pass .= '<div class="upme-forgot-pass" id="upme-forgot-pass-holder-' . $this->login_code_count . '">';

        $forgot_pass .= '<div class="upme-field upme-edit upme-edit-show">';
        $forgot_pass .= '<label class="upme-field-type" for="user_name_email-' . $this->login_code_count . '"><i class="upme-icon-user"></i><span>' . __('Username or Email', 'upme') . '</span></label>';
        $forgot_pass .= '<div class="upme-field-value"><input type="text" class="upme-input" name="user_name_email" id="user_name_email-' . $this->login_code_count . '" value=""></div>';
        $forgot_pass .= '</div>';

        $forgot_pass.='<div class="upme-field upme-edit upme-edit-show">';
        $forgot_pass.='<label class="upme-field-type upme-blank-lable">&nbsp;</label>';
        $forgot_pass.='<div class="upme-field-value">';
        $forgot_pass.='<div class="upme-back-to-login">';
        $forgot_pass.='<a href="javascript:void(0);" title="' . __('Back to Login', 'upme') . '" id="upme-back-to-login-' . $this->login_code_count . '">' . __('Back to Login', 'upme') . '</a> | ' . $register_link;
        $forgot_pass.='</div>';

        $forgot_pass.='<input type="button" name="upme-forgot-pass" id="upme-forgot-pass-btn-' . $this->login_code_count . '" class="upme-button upme-login" value="' . __('Forgot Password', 'upme') . '">';

        $forgot_pass.='</div>';
        $forgot_pass.='</div>';



        $forgot_pass .= '</div>';


        $display.=$forgot_pass;


        return $display;
    }

    /* TRUE or false user can view content */

    function user_can_view_content() {
        if (!is_user_logged_in())
            return false;
        return true;
    }

    /* Private content plugin */

    function hidden_content($args=array(), $content) {

        $display = null;

        /* Arguments */
        $defaults = array(
            'message' => 'on'
        );
        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);

        /* Require login */
        if (!$this->user_can_view_content()) {

            if ($message !== 'off') {

                /* filter wildcards */
                $html = $this->get_option('html_private_content');
                $html = str_replace("{upme_current_uri}", $this->current_page, $html);
                $display .= wpautop($html);
                $display .= do_shortcode('[upme_login]');
            }
        } else { /* Show hidden content */
            /* Adding do_shortcode again to allow shortcode inside shortcode, now private content can have shortcode too */
            $display .= do_shortcode($content);
        }

        return $display;
    }

    /* Logout button */

    function logout($args=array()) {
        $display = null;

        $defaults = array(
            'redirect_to' => $this->current_page
        );
        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);

        // WP 3.6 Fix
        if (is_user_logged_in ()) {
            if (isset($warp_div) && $warp_div == true)
                $display .= '<div class="upme-wrap">';

            $user_id = isset($user_id) ? trim($user_id) : 0;
            $current_user = wp_get_current_user();
            $current_user_id = trim($current_user->ID);
            // Display the Log out link only for the logged in users
            if ($user_id == 0 || ($user_id == $current_user_id)) {
                $display .= '<a href="' . wp_logout_url($redirect_to) . '" class="upme-button-alt">' . __('Log Out', 'upme') . '</a>';
            }

            if (isset($warp_div) && $warp_div == true)
                $display .= '</div>';
        }

        return $display;
    }

    function upme_load_edit_form_scripts() {
        // Loading scripts and styles only when required
        /* Password Stregth Checker Script */
        if (!wp_script_is('form-validate')) {
            wp_register_script('form-validate', upme_url . 'js/form-validate.js', array('jquery'));
            wp_enqueue_script('form-validate');

            $validate_strings = array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'ErrMsg' => array(
                    'similartousername' => __('Your password is too similar to your username.', 'upme'),
                    'mismatch' => __('Both passwords do not match.', 'upme'),
                    'tooshort' => __('Your password is too short.', 'upme'),
                    'veryweak' => __('Your password strength is too weak.', 'upme'),
                    'weak' => __('Your password strength weak.', 'upme'),
                    'usernamerequired' => __('Please provide username.', 'upme'),
                    'emailrequired' => __('Please provide email address.', 'upme'),
                    'validemailrequired' => __('Please provide valid email address.', 'upme'),
                    'usernameexists' => __('That username is already taken, please try a different one.', 'upme'),
                    'emailexists' => __('The email you entered is already registered. Please try a new email or log in to your existing account.', 'upme'),
                    'emailempty' => __('Email is empty.', 'upme'),
                    'emailinvalid' => __('Invalid email.', 'upme'),
                    'emailvalid' => __('Email is available.', 'upme')
                ),
                'MeterMsg' => array(
                    'similartousername' => __('Your password is too similar to your username.', 'upme'),
                    'mismatch' => __('Both passwords do not match.', 'upme'),
                    'tooshort' => __('Your password is too short.', 'upme'),
                    'veryweak' => __('Your password strength is too weak.', 'upme'),
                    'weak' => __('Your password strength weak.', 'upme'),
                    'good' => __('Good', 'upme'),
                    'strong' => __('Strong', 'upme')
                ),
                'Err' => __('ERROR', 'upme')
            );

            wp_localize_script('form-validate', 'Validate', $validate_strings);
        }

        if (!wp_style_is('upme_password_meter')) {
            wp_register_style('upme_password_meter', upme_url . 'css/password-meter.css');
            wp_enqueue_style('upme_password_meter');
        }
    }

    function upme_hide_admin_bar() {

        $current_option = get_option('upme_options');
        if ('hide_from_non_admin' == $current_option['hide_frontend_admin_bar']) {
            if (!current_user_can('manage_options')) {
                show_admin_bar(false);
            }
        } else if ('hide_from_all' == $current_option['hide_frontend_admin_bar']) {
            show_admin_bar(false);
        } else {
            show_admin_bar(true);
        }
    }

    /* Add new rewriting rule to manage userId/username as pretty permalinks */

    function upme_profile_custom_routes() {
        $current_option = get_option('upme_options');

        // Add custom rewrite rules when not in default permalinks
        if (isset($current_option['profile_page_id']) && !isset($_REQUEST['page_id'])) {
            $link = get_permalink($current_option['profile_page_id']);
            $filter_link = substr(str_replace(site_url(), '', $link), 1);
            $filter_link = '^' . $filter_link . '([^/]+)/?';

            $profile_page_id = url_to_postid($link);

            add_rewrite_rule($filter_link, 'index.php?page_id=' . $profile_page_id . '&upme_profile_filter=$matches[1]', 'top');
        }
    }

    /* Add new query variable to handle userID/username in custom permalinks */

    function upme_profile_custom_routes_query_vars($query_vars) {
        $query_vars[] = 'upme_profile_filter';
        return $query_vars;
    }

    function upme_invalid_user_profile() {
        $display = null;
        $display .= '<div class="upme-wrap">';
        $display .= '<p class="upme-login-spacer">&nbsp;</p>';
        $display .= __('User not found.', 'upme');
        $display .= '</div>';
        return $display;
    }

}

$upme = new UPME();
