<?php

/**
 * File handling plugin upgrades
 *
 * @package    WordPress
 * @subpackage SALC
 * @since 2.0.0
 */

namespace SALC;

/**
 * Check version and run upgrade routine if needed.
 *
 * @return void
 */
function check_version()
{
	$plugin_version = get_option('SALC_VERSION', '1.0.2');
	if ($plugin_version !== SALC_VERSION) {
		// Store new version.
		update_option('SALC_VERSION', SALC_VERSION);

		// Run upgrade routine from the old version.
		if (version_compare($plugin_version, '2.0.0', '<')) {
			// Check if WPLANG_ADMIN used in versions 1.0.* is present.
			$admin_wplang = get_option('WPLANG_ADMIN', false);

			if ($admin_wplang) {
				// Update language for all admins.
				$administrators = get_users([ 'role__in' => [ 'administrator' ] ]);

				// Array of WP_User objects.
				foreach ($administrators as $a) {
					$a->__set('locale', $admin_wplang);
					wp_update_user($a);
				}
				delete_option('WPLANG_ADMIN');
			}
		}
	}
}
add_action('plugins_loaded', __NAMESPACE__ . '\check_version');
