<?php

add_action('admin_menu', 'register_sbl_menu_page');
add_action( 'admin_init', 'register_sbl_settings' );
define( 'SBL_DOMAIN', 'sb-login' );

function register_sbl_menu_page() {

add_menu_page('SB Login', 'SB Login', 'add_users', __FILE__, 'sbl_plugin_menu', plugins_url('sb-login/img/icon.png'));

add_submenu_page(__FILE__, __('How to Use | SB Login', SBL_DOMAIN ), __('How to Use', SBL_DOMAIN ), 'add_users', __FILE__, 'sbl_plugin_menu');

add_submenu_page(__FILE__, 'Settings | SB Login', 'Settings', 'manage_options', 'sbl_settings', 'sbl_settings_page');

add_submenu_page(__FILE__, 'Server Information | SB Login', 'Server Information', 'add_users', 'sbl_server_info', 'sbl_server_info_menu');
}

function register_sbl_settings() {
register_setting( 'sbl-settings-group', 'sbl_option_dash' );
register_setting( 'sbl-settings-group', 'sbl_option_lost' );
register_setting( 'sbl-settings-group', 'sbl_option_pro' );
register_setting( 'sbl-settings-group', 'sbl_option_recent' );
register_setting( 'sbl-settings-group', 'sbl_option_xtra' );
}

include "admin/sidebar.php";

function sbl_plugin_menu() {
if ( !current_user_can( 'manage_options' ) )  {
wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
include "admin/usage.php";
}


function sbl_settings_page() {
if ( !current_user_can( 'manage_options' ) )  {
wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
include "admin/settings.php";
}

function sbl_server_info_menu() {
if ( !current_user_can( 'manage_options' ) )  {
wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
include "admin/server_info.php";
}

?>