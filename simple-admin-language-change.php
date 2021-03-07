<?php
/**
 * Plugin Name:       Simple Admin Language Change
 * Plugin URI:		  http://kybernaut.cz/pluginy/simple-admin-language-change
 * Description:       Change your dashboard language quickly and easily in the admin bar.
 * Version:           2.0.0
 * Author:            Karolína Vyskočilová
 * Author URI:        https://www.kybernaut.cz
 * Text Domain:       kbnt-scal
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('SIMPLE_ADMIN_LANGUAGE_VERSION', '2.0.0');


/**
 * Localize the plugin
 *
 * @return void
 */
function admin_language_localize_plugin()
{
	load_plugin_textdomain('kbnt-scal', false, plugin_dir_path(__FILE__) . 'languages/');
}
add_action('init', 'admin_language_localize_plugin');

/**
 * Check version and run upgrade routine if needed.
 * @return void
 */
function simple_admin_language_check_version()
{
	$plugin_version = get_option('simple_admin_language_version', '1.0.2');
	if ( $plugin_version !== SIMPLE_ADMIN_LANGUAGE_VERSION) {

		// Store new version.
		update_option('simple_admin_language_version',SIMPLE_ADMIN_LANGUAGE_VERSION);

		// Run upgrade routine from the old version.
		if ( version_compare($plugin_version, '2.0.0', '<')) {

			// Check if WPLANG_ADMIN used in versions 1.0.* is present.
			$admin_wplang = get_option('WPLANG_ADMIN', false);

			if ($admin_wplang) {
				// Update language for all admins.
				$administrators = get_users( array( 'role__in' => array( 'administrator' ) ) );

				// Array of WP_User objects.
				foreach ($administrators as $a) {
					$a->__set('locale',$admin_wplang);
					wp_update_user($a);
				}
				delete_option('WPLANG_ADMIN');
			}
		}
	}
}
add_action('plugins_loaded', 'simple_admin_language_check_version');
