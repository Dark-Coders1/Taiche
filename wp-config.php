<?php
# Database Configuration
define( 'DB_NAME', 'wp_taichi' );
define( 'DB_USER', 'taichi' );
define( 'DB_PASSWORD', 'poF5P6nmZ5AbHhcUNVUd' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         ']*>gSiiISOSj{vEFkqWXTjlxY=~;uz1++LhHsk(<i|{s/%91-u0%t_SqFC.aww!W');
define('SECURE_AUTH_KEY',  'kq&1 Cg{>?Dzz}~>>97siA9Dk_tAaN$,1!|_sg`+=p~x4m8Ut{I5h9/8.<|hgyS9');
define('LOGGED_IN_KEY',    'AN|<*Ky|.$B*uoB/0![0.~e4nRStHb4B++>J?=fuU46>OpKCeNe1>W::bfK:W1MW');
define('NONCE_KEY',        ']>rM1=.G$7fNZ_1-{3Q-L%fBr<?e~WO6-OdJBhUm^wlB$xVSlTsk}mY6i`7%K2=w');
define('AUTH_SALT',        'MSZWeAB44aHwcsYAF,(DH]0$>7Kq7bIqx{bW3Z3N;/E]ElG.;s|{/WV=LMj~>?6l');
define('SECURE_AUTH_SALT', '}.9]pJ^_5 k0#/G9$--#ZWKMr6I9lQHcOny$@$NJr!FN*Gg6X<T5- VNE;dO8+^A');
define('LOGGED_IN_SALT',   '.]!oXNp)DW}PO1O{s&@[QS[utmOT>%8EkV!9)fCAd`yo`g.VWx$Pl=VJ-~|+5w3+');
define('NONCE_SALT',       'B/E+DI<=Q{?FhHFww:zP8imIn/i,b@0^brL,_h|;q{;7VD]BqDIs|?X7%034xbWG');


# Localized Language Stuff
//define('WP_DEBUG', true);

define('WP_HOME','http://taichi.wpengine.com');
define('WP_SITEURL','http://taichi.wpengine.com');
define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'taichi' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '26e2d3dc18f9a9b0051da823cf6ed6f264074909' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '2265' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'taichi.wpengine.com', 1 => 'taichiforhealthinstitute.org', 2 => 'www.taichiforhealthinstitute.org', );

$wpe_varnish_servers=array ( 0 => 'pod-2265', );

$wpe_special_ips=array ( 0 => '66.228.52.44', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );

define( 'WPE_CACHE_TYPE', 'generational' );

define( 'WPE_LBMASTER_IP', '66.228.52.44' );
define('WPLANG','');

# WP Engine ID


define('PWP_DOMAIN_CONFIG', 'www.taichiproductions.com' );

# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
