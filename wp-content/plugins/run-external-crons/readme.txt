=== Run External Crons ===
Contributors: dimadin
Donate link: http://blog.milandinic.com/donate/
Tags: cron, cronjob, cron job 
Requires at least: 3.3
Tested up to: 3.4.1
Stable tag: 1.0

Use WordPress internal cron system to hit external URLs on a scheduled basis.

== Description ==

[Plugin homepage](http://blog.milandinic.com/wordpress/plugins/run-external-crons/) | [Plugin author](http://blog.milandinic.com/) | [Donate](http://blog.milandinic.com/donate/)

This plugin enables using WordPress as a cron system that would hit external URLs (ie. any URL) on a scheduled basis. User can submit URL and interval in which that URL should be opened by WordPress.

This can be used, for example, for other WordPress sites that are on hosts that don't have native cron system or where it's complicated to set it up. For that cases, URL should be in format `http://example.com/wp-cron.php` and there should be constant `DISABLE_WP_CRON` in `wp-config.php` file to avoid running WordPress own pseudo cron:
`define('DISABLE_WP_CRON', true);`

It's recommended to setup a real cron for the site where this plugin is installed, with interval that is the lowest one from settings. Follow WordPress specific advises from above, and check links from [plugin's page](http://blog.milandinic.com/wordpress/plugins/run-external-crons/) on how to set up this.

If you are translator, you can translate this plugin to your language and send translations to plugin's author.

== Installation ==

1. Upload `run-external-crons` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You can change default options on 'Settings > Run External Crons' page

== Screenshots ==

1. Example of settings screen