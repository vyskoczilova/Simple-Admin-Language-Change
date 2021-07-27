<?php

/**
 * File handling scripts and styles
 *
 * @package    WordPress
 * @subpackage SALC
 * @since 2.0.0
 */

namespace SALC;

/**
 * Add custom icon to the admin bar
 * https://wordpress.stackexchange.com/questions/172939/how-do-i-add-an-icon-to-a-new-admin-bar-item
 *
 * @return void
 */
function admin_css()
{
	echo '<style>
    #wpadminbar #wp-admin-bar-salc-current-language .ab-icon:before {
		content: "\f326";
		top: 3px;
	}
	</style>';
}
add_action('admin_head', __NAMESPACE__ . '\admin_css');

/**
 * Load script
 *
 * @param string $hook_suffix The current admin page.
 * @return void
 */
function load_script($hook_suffix)
{

	// Check for permissions and if it is admin.
	if (! current_user_can('read') || ! is_admin() ) {
		return;
	}
	wp_enqueue_script('salc', plugin_dir_url(dirname(__FILE__)) . '/script.js', [], \SALC_VERSION, true);
	wp_localize_script('salc', 'props', [
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce("salc_change_user_locale")
	]);
}
add_action('admin_enqueue_scripts', __NAMESPACE__ . '\load_script');
