<?php
/**
 * Plugin Name: TAICHI Mailchimp Plugin
 * Version: 0.0.1
 * Author: Usman Asif
 * Author URI: http://www.devsinc.com
 * License: GPLv2 or later
 */
add_action('admin_enqueue_scripts', 'add_styles_and_scripts');
function add_styles_and_scripts() {
    wp_enqueue_style('champ-style', plugin_dir_url(__FILE__) . 'assets/css/champ-camp.css', false);
    wp_enqueue_style('jquery-ui', plugin_dir_url(__FILE__) . 'assets/jqueryui/jquery-ui.css', false);
    wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'assets/js/champ-camp.js', false);
    wp_enqueue_script('holder', plugin_dir_url(__FILE__) . 'assets/jqueryui/jquery-ui.js', array('jquery'));
}

add_action('admin_menu', 'taichi_admin_actions');

function taichi_admin_actions() {
    add_menu_page('Email Editor', 'Email Editor', 'master_me', 'taichi-email-editor', 'taichi_email_editor');
    add_menu_page('Expiry Email Editor', 'Expiry Email Editor', 'manage_options', 'expiry-email-editor', 'expiry_email_editor');	    
    add_submenu_page('taichi-email-editor', 'Settings', 'Settings', 'manage_options', 'taichi-admin-mc-settings', 'taichi_connect_mc');
	
	
    //add_submenu_page('taichi_admin','segment corn','segment corn','manage_options','taichi-segment-corn','taichi_segment_corn');
    //add_submenu_page('taichi_admin','','Email Editor','master_me','taichi-email-editor','taichi_email_editor');
}

// function taichi_admin_Mailchimp() {
//     include('master_trainee/taichi-email-editor.php');
    
// }

function taichi_connect_mc(){
	include('admin/taichi-admin-mc-settings.php');

}

// function taichi_segment_corn(){

// 	include('lib/taichi-segment-corn.php');
// }

function taichi_email_editor(){
    include('master_trainee/taichi-email-editor.php');
}
function expiry_email_editor(){
    include('admin/cert_expiry_email_editor.php');
}

include ('Mailchimp.php');
//include 'mailchimp/MCAPI.php';
require_once('admin/mailchimp-settings/miniMCAPI.class.php');
//include('lib/taichi-class-segment.php');
include('master_trainee/class-create-campaign.php');
?>
