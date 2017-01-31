<?php
/**
 * Plugin Name:       Simple Admin Language Change
 * Plugin URI:		  http://kybernaut.cz/pluginy/simple-admin-language-change
 * Description:       Change your admin language easily.
 * Version:           1.0.0
 * Author:            Karolína Vyskočilová
 * Author URI:        http://www.kybernaut.cz
 * Text Domain:       kbnt-scal
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// =============================================================================
// ACTIONS
// =============================================================================

function admin_language_loaded() {

	$new_general_setting = new admin_language_new_general_setting();	
	add_filter('locale', 'admin_language_setLocale');		
	
}
add_action( 'plugins_loaded', 'admin_language_loaded' );   


// =============================================================================
// FUNCTIONS
// =============================================================================

function admin_language_setLocale( $locale ) {
	
	global $pagenow;
	
	if ( is_admin() && $pagenow != 'options-general.php' && current_user_can('administrator') ) {
		$locale_admin = get_option( 'WPLANG_ADMIN', 'en_US' );	
		return $locale_admin;
	}

	return $locale;
}

// =============================================================================
// CLASSES
// =============================================================================

class admin_language_new_general_setting {

    function admin_language_new_general_setting( ) {
        add_filter( 'admin_init' , array( &$this , 'admin_language_register_fields' ) );
    }
    function admin_language_register_fields() {
        register_setting( 'general', 'WPLANG_ADMIN', 'esc_attr' );
        add_settings_field('admin_language', '<label for="WPLANG_ADMIN">'.__('Admin Language' , 'kbnt-scal' ).'</label>' , array(&$this, 'admin_language_fields_html') , 'general');
    }
    function admin_language_fields_html() {
        
		$locale = get_option( 'WPLANG_ADMIN', 'en_US' );	
		
		$languages = get_available_languages();
		$translations = wp_get_available_translations();
		if ( ! is_multisite() && defined( 'WPLANG_ADMIN' ) && '' !== WPLANG_ADMIN && 'en_US' !== WPLANG_ADMIN && ! in_array( WPLANG_ADMIN, $languages ) ) {
			$languages[] = WPLANG;
		}
		if ( ! empty( $languages ) || ! empty( $translations ) ) {
			
			wp_dropdown_languages( array(
				'name'         => 'WPLANG_ADMIN',
				'id'           => 'WPLANG_ADMIN',
				'selected'     => $locale,
				'languages'    => $languages,
				'translations' => $translations,
				'echo'         => 1,
				'show_available_translations' => ( ! is_multisite() || is_super_admin() ) && wp_can_install_language_pack(),
			) );

		}
		
    }
	
}
