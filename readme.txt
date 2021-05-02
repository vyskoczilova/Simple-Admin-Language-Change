===  Simple Admin Language Change ===
Contributors: vyskoczilova
Tags: admin language, backend language, localization, backend, English
Requires at least: 4.7
Tested up to: 5.7
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/vyskoczilova/Simple-Admin-Language-Change/

Change your dashboard language quickly and easily from the admin bar as often as you need.

== Description ==

The lightweight plugin extends the default functionality and pulls out the language selection to the admin bar so you can easily switch between them.

[youtube https://studio.youtube.com/video/i5Mz5ZefDmA]

Note: Plugin in versions 1.0.* allowed setting up administration language for different users for quite a long time. **Since WordPress 4.7 version, this feature is now provided natively by WordPress.**

Do you want help with the development? Join the [Github](https://github.com/vyskoczilova/Simple-Admin-Language-Change/)!

=== Compatibility ===
* Has conflict with [SiteOrigin Widgets Bundle](https://cs.wordpress.org/plugins/so-widgets-bundle/) - prevents javascript popup on Widgets page.

== Frequently Asked Questions ==

= I want to swith to different language =

You need to install the language first.

1. Go to `Settigngs -> General`.
1. Select the desired `site language` and hit `save changes`. The language gets installed.
1. Change the `site language` back to the old value.
1. Now you can swith in the dropdown.

== Installation ==
= EN =
1. Upload the plugin to your website or install via plugin management.
1. Check whether the WooCommerce plugin is installed and active.
1. Activate the plugin through the `Plugins` menu in WordPress administration
1. (If you wish, go to the  `Settings` and  `General` to select different installed language instead of English)
1. Done!

== Screenshots ==

1. Settings of Admin language in General Settings.

== Changelog ==

= 2.0.0 =
* Drop the old functionality replaced by an integrated solution since WordPress 4.7
* Add a simple select box into the admin bar instead.

= 1.0.2 (2018-02-25) =
* Fix: enable localization

= 1.0.1 (2018-02-18) =
* Fix: PHP 7 deprecated methods - compatibility ([#1](https://github.com/vyskoczilova/Simple-Admin-Language-Change/issues/1))

= 1.0.0 (2016-10-06) =
* Initial version
