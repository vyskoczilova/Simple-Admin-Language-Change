<?php

/**
 * Main plugin file
 *
 * @package    WordPress
 * @subpackage SALC
 * @since 1.0.0
 */

namespace SALC;

use WP_Admin_Bar;

/**
 * Plugin Name:       Simple Admin Language Change
 * Plugin URI:        http://kybernaut.cz/pluginy/simple-admin-language-change
 * Description:       Change your dashboard language quickly and easily in the admin bar.
 * Version:           2.0.4
 * Author:            Karolína Vyskočilová
 * Author URI:        https://www.kybernaut.cz
 * Text Domain:       simple-admin-language-change
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

define('SALC_VERSION', '2.0.4');

/**
 * Localize the plugin
 *
 * @return void
 */
function localize_plugin()
{
	load_plugin_textdomain('simple-admin-language-change', false, plugin_dir_path(__FILE__) . 'languages/');
}
add_action('init', __NAMESPACE__ . '\localize_plugin');

require_once 'inc/upgrade.php';
require_once 'inc/helpers.php';
require_once 'inc/scripts-and-styles.php';

/**
 * Add menu to admin bar
 *
 * @param WP_Admin_Bar $admin_bar Admin bar instance.
 * @return void
 */
function admin_menu($admin_bar)
{

	// Check for permissions and if it is admin.
	if (! current_user_can('read') || ! is_admin() ) {
		return;
	}

	$languages = parse_wp_dropdown_languages();

	$admin_bar->add_menu([
		'id'    => 'salc-current-language',
		'parent' => 'top-secondary',
		'group'  => null,
		'title' => '<span class="ab-icon"></span>' . $languages['active']['title'],
		'href'  => '#',
		'meta' => [
			'title' => __('Current dashboard language', 'simple-admin-language-change'),
			'onclick'  => "return false;"
		]
	]);

	foreach ($languages['available'] as $la) {
		$admin_bar->add_menu([
			'id'    => 'salc-current-' . sanitize_title($la['title']),
			'parent' => 'salc-current-language',
			'group'  => null,
			'title' => $la['title'],
			'href' => '#' . ($la['value'] ? $la['value'] : 'en_US'),
		]);
	}
}
add_action('admin_bar_menu', __NAMESPACE__ . '\admin_menu', 500);


/**
 * Change user locale
 *
 * @return void
 */
function change_user_locale_ajax()
{

	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], "salc_change_user_locale")) {
		wp_die(esc_html(__('Something went wrong, try again.', 'simple-admin-language-change')));
	}


// Check for permissions and if it is admin.
	if (! current_user_can('read') || ! is_admin()) {

		wp_die(esc_html(__('You don\'t have the correct permissions for language change.', 'simple-admin-language-change')));
	}

	$user_id = \get_current_user_id();

	$lang = isset($_REQUEST['lang']) ? \sanitize_text_field(wp_unslash($_REQUEST['lang'])) : false;

	if (! $user_id || ! $lang) {
		\wp_send_json_error('updated', 403);
		wp_die();
	}

	if ($lang === 'site-default') {
		$lang = null;
	}

	wp_update_user(['ID' => $user_id, 'locale' => $lang]);

	\wp_send_json_success('updated', 200);
	wp_die();
}
add_action("wp_ajax_change_user_locale", __NAMESPACE__ . "\change_user_locale_ajax");
