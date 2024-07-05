<?php
/*
  Plugin Name: WP Engine System
  Plugin URI: http://wpengine.com/plugins
  Description: WP Engine-specific services and options
  Author: WP Engine
  Version: 2.2.2
  Changelog: (see changelog.txt)
 */

// Our plugin
define( 'WPE_PLUGIN_BASE', __FILE__ );

// Allow changing the version number in only one place (the header above)
$plugin_data = get_file_data( WPE_PLUGIN_BASE, array( 'Version' => 'Version' ) );
define( 'WPE_PLUGIN_VERSION', $plugin_data['Version'] );

//setup wpe plugin url
if(is_multisite()) {
	define('WPE_PLUGIN_URL', network_site_url('/wp-content/mu-plugins/wpengine-common'));
} else {
	define( 'WPE_PLUGIN_URL', content_url('/mu-plugins/wpengine-common') );
}

require_once(dirname(__FILE__)."/wpengine-common/plugin.php");

// Login-Lockout plugin, indirect here so that it works with mu-plugin rules
if ( getenv( 'WPENGINE_LIMIT_LOGIN_ATTEMPTS' ) !== 'off' ) {
    $lla_path = dirname(__FILE__)."/limit-login-attempts/limit-login-attempts.php";
    if ( file_exists($lla_path) ) { require_once($lla_path); }
}

// Prevent weird problems with logging in due to Object Caching
// example: password has been changed, but Object Cache still holds old password, and therefore prevents login
if ( defined( 'WP_CACHE' ) && WP_CACHE ) {
    add_filter( 'wp_authenticate_user', 'wpe_refresh_user' );
    function wpe_refresh_user( $user ) {
        wp_cache_delete( $user->user_login, 'userlogins' );
        return get_user_by( 'login', $user->user_login );
    }
}

if ( getenv( 'WPE_HEARTBEAT_AUTOSAVE_ONLY' ) == 'on' ) {
	require_once __DIR__ . '/wpengine-common/class.heartbeatthrottle.php';
	$heartbeat_throttle = new WPE_Heartbeat_Throttle();
	$heartbeat_throttle->register();
}

// Force destroy login cookies if invalid, expired, etc. This prevents stale cookies (which never expire
// in the browser) from cache busting. 
// This feature is controlled by an environment variable, but defaulted to on.
if ( getenv( 'WPENGINE_CLEAR_EXPIRED_COOKIES' ) !== 'off' ) {
	require_once __DIR__ . '/wpengine-common/class.cookies.php';
	\wpe\plugin\Cookies::register_hooks();
}

// Enforce sanity checking on wp_sessions. This became a problem when EDD had a bug that had sessions
// expiring in the year 2058.
require_once __DIR__ . '/wpengine-common/class.sessionsanity.php';
$wpe_session_sanity = new \wpe\plugin\SessionSanity();
$wpe_session_sanity->register_hooks();

// Custom site preview
require_once( __DIR__ . '/wpengine-common/class.site-preview.php' );
\WPE\Site_Preview::get_instance()->register_hooks();

// Useful for multisite: Add a Site ID column to the Network Admin > Sites page
if ( is_multisite() ) {
    add_filter( 'wpmu_blogs_columns', 'wpe_site_id' );
    function wpe_site_id( $columns ) {
        $columns['site_id'] = __( 'ID', 'site_id' );
        return $columns;
    }

    add_action( 'manage_sites_custom_column', 'wpe_site_id_columns', 10, 3 );
    add_action( 'manage_blogs_custom_column', 'wpe_site_id_columns', 10, 3 );
    function wpe_site_id_columns( $column, $blog_id ) {
        if ( $column == 'site_id' ) {
            echo $blog_id;
        }
    }
}

//temporary location for login-protection script
//@TODO should be it's own plugin probably

add_filter( 'site_url', 'wpe_filter_site_url', 0, 4 );
/**
 * Filter the value returned for 'site_url'
 *
 * This function will only filter the url if it is the 'login_post' scheme. If
 * not, then the value is unchanged
 *
 * @since 1.0
 *
 * @param string $url The unfiltered URL to return
 * @param string $path The relative path
 * @param string $scheme The scheme to use, such as http vs. https
 * @param int $blog_id The blog ID for the URL
 * @return string The new URL
 */
function wpe_filter_site_url( $url, $path, $scheme, $blog_id ) {
    // We only want to filter the login_post scheme
    if ( $scheme == 'login_post' ) {
	$url = add_query_arg( array( 'wpe-login'=> PWP_NAME ) , $url );
    }
    return $url;
}

/**
 * Kills the email button in Jetpack's Sharing module due to spam.
 * Remove this once devs ship a fix. Currently slated for Jetpack 3.2.
 *
 * Legs:    Johnny Tightlips where'd they hit ya?
 * Johnny:  I ain't sayin' nothin'.
 *
 * @param array $services The array of supported Jetpack services.
 * @return array The filtered array of supported Jetpack services.
 */
function wpe_kill_sharedaddy_email ( $services ) {
	if ( class_exists( 'Jetpack' ) ) {
		unset( $services['email'] );
	}

	return $services;
}
add_filter( 'sharing_services', 'wpe_kill_sharedaddy_email' );

if ( ! function_exists( 'current_action' ) ) :
/**
 * Retrieve the name of the current action.
 *
 * This function was added in WordPress 3.9, but some sites
 * are still running old versions of WordPress and therefore need
 * us to define this function.
 *
 * The current_filter() function has been around for a long
 * time (2.5) and so there shouldn't be any issue with calling
 * that function.
 *
 * @uses  current_filter()
 *
 * @return string Hook name of the current action.
 */
function current_action() {
	return current_filter();
}
endif;

// Disable core updates and emails.
add_filter( 'auto_update_core', '__return_false' );
add_filter( 'auto_update_translation', '__return_false' );
add_filter( 'auto_core_update_send_email', '__return_false' );
