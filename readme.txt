===  Simple Admin Language Change ===
Contributors: vyskoczilova
Tags: admin language, backend language, localization, backend, English
Requires at least: 4.7
Tested up to: 6.6
Stable tag: 2.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/vyskoczilova/Simple-Admin-Language-Change/

Change your dashboard language quickly and easily from the admin bar as often as you need.

== Description ==

The lightweight plugin extends the default WordPress functionality (user settings in Profile) and pulls out the language selection to the admin bar so you can easily switch between them.

Do you want help with the development? Join the [Github](https://github.com/vyskoczilova/Simple-Admin-Language-Change/)!

== Frequently Asked Questions ==

= I want to swith to different language =

You need to install the language first.

1. Go to `Settigngs -> General`.
1. Select the desired `site language` and hit `save changes`. The language gets installed.
1. Change the `site language` back to the old value.
1. Now you can switch in the dropdown.

= How can I report security bugs? =

You can report security bugs through the Patchstack Vulnerability Disclosure Program. The Patchstack team help validate, triage and handle any security vulnerabilities. [Report a security vulnerability.](https://patchstack.com/database/vdp/simple-admin-language-change)

== Installation ==
= EN =
1. Upload the plugin to your website or install via plugin management.
1. Check whether the WooCommerce plugin is installed and active.
1. Activate the plugin through the `Plugins` menu in WordPress administration
1. (If you wish, go to the  `Settings` and  `General` to select different installed language instead of English)
1. Done!

== Screenshots ==

1. Changing languages and installing another language (French)

== Changelog ==

= 2.0.4 (2021-07-27) =

* Lower the permissions check - anybody with "read" permissions (e.g., subscriber) can change their locale with the dropdown when logged into the admin.
* Hide the language switcher on the front end - the top admin bar is affected by site language, not the user's choice (opened [trac ticket](https://core.trac.wordpress.org/ticket/53794) for that)

= 2.0.3 (2021-05-08) =

* Replace textdomain `kbnt-salc` with `simple-admin-language-change` to make it work with GlotPress ([more info](https://wordpress.org/support/topic/text-domain-issue-30/))

= 2.0.2 (2021-05-03) =
* Fix security issues
    * Check for the empty nonce.
    * Escape translations.

= 2.0.1 (2021-05-03) =
* Fix security issues (thanks @ErwanLR from WPScan for reporting!)
    * Check for the empty nonce.
    * Check for user permission within ajax request.
    * Retrieve current user ID within the request.
* Make error messages translatable.

= 2.0.0 (2021-05-02) =
* Drop the old functionality replaced by an integrated solution since WordPress 4.7
* Add a simple select box into the admin bar instead.

= 1.0.2 (2018-02-25) =
* Fix: enable localization

= 1.0.1 (2018-02-18) =
* Fix: PHP 7 deprecated methods - compatibility ([#1](https://github.com/vyskoczilova/Simple-Admin-Language-Change/issues/1))

= 1.0.0 (2016-10-06) =
* Initial version
