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

function simple_admin_language_admin_menu ( WP_Admin_Bar $admin_bar ) {
	// Check for permissions matching the user_locale
	if ( ! current_user_can( 'edit_posts' ) || ! current_user_can( 'edit_pages' ) ) {
		return;
    }

	$languages = simple_admin_language_parse_wp_dropdown_languages();

    $admin_bar->add_menu( array(
		'id'    => 'salc-current-language',
        'parent' => 'top-secondary',
        'group'  => null,
        'title' => '<span class="ab-icon"></span>' . $languages['active']['title'],
        'href'  => '#',
        'meta' => [
			'title' => __( 'Current dashboard language', 'kbnt-kbnt-scal' ),
		]
	) );

	foreach( $languages['available'] as $la ) {

		$admin_bar->add_menu([
			'id'    => 'salc-current-' . sanitize_title($la['title']),
			'parent' =>'salc-current-language',
			'group'  => null,
			'title' => $la['title'],
			'href'  => '#',
		]);

	}
}
add_action( 'admin_bar_menu', 'simple_admin_language_admin_menu', 500 );

/**
 * Parse HTML of wp_dropdown_languages into array
 * @return array
 */
function simple_admin_language_parse_wp_dropdown_languages() {

	$user_locale = get_user_locale();
	$available_languages = get_available_languages();
	ob_start();
	wp_dropdown_languages(
		[
			'name'                        => 'locale',
			'id'                          => 'locale',
			'selected'                    => $user_locale,
			'languages'                   => $available_languages,
			'show_available_translations' => false,
			'show_option_site_default'    => true,
		]
	);
	$wp_dropdown_languages = ob_get_contents();
	ob_end_clean();
	$languages = [
		'active' => [],
		'available' => []
	];

	$dom = new DOMDocument();
	$dom->loadHTML(mb_convert_encoding($wp_dropdown_languages, 'HTML-ENTITIES', 'UTF-8'));
	$options = $dom->getElementsByTagName('option');
	for ($i = 0; $i < $options->length; $i++ ) {
		$language = [
			'value' => $options->item($i)->getAttribute('value'),
			'title' => $options->item($i)->nodeValue,
		];
		if ($options->item($i)->hasAttribute('selected')) {
			$languages['active'] = $language;
		} else {
			$languages['available'][] = $language;
		}
	}

	return $languages;

}


function simple_admin_language_admin_css() {
	echo '<style>
    #wpadminbar #wp-admin-bar-salc-current-language .ab-icon:before {
		content: "\f326";
		top: 3px;
	}
	</style>';
}
add_action('admin_head', 'simple_admin_language_admin_css');
