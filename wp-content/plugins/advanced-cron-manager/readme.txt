=== Plugin Name ===
Contributors: Kubitomakita
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=contact%40jmikita%2ecom&lc=US&item_name=Advanced%20Cron%20Manager&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: cron, wp cron, manager, cron manager
Requires at least: 3.6
Tested up to: 3.9.1
Stable tag: 1.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Advanced manager for WordPress Cron tasks and schedules. Adding, removing and viewing with a few clicks. 

== Description ==

This plugin allow you to manage WP Cron tasks:

* viewing
* deleting tasks and schedules
* adding tasks and schedules

Plugin is using AJAX request so you'll need enabled Javascript in order to use it.

**Informations about WP Cron**

Please remember - after deactivation of this plugin added Schedules will be not available. Added Tasks will still work unless they use your custom schedule.

Important - WordPress Cron is depended on the User. WP Cron fires only on the page visit so it can be inaccurate.

**Additional informations**

Plugin supports i18n. If you would like to translate it grab a .po file, translate it and send it to me for plugin update. I'll be thankful :)

== Installation ==

1. Upload `acmanager.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

Plugin's page sits under Tools menu item.

== Frequently Asked Questions ==

= Tasks and schedules will be still working after plugin deactivation/removal? =

Tasks yes. Schedules no.

= What is the task hook? =

It's used for action. For example if your hook is hook_name you'll need to add in PHP:
'add_action('hook_name', 'function_name');'

== Screenshots ==

1. Plugin control panel

== Changelog ==

= 1.1 =
* Fixed Schedules list from other plugins

= 1.0 =
* Plugin relase

== Upgrade Notice ==

= 1.1 =
Fixed Schedules list from other plugins

= 1.0 =
Plugin relase