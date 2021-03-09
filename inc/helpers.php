<?php

/**
 * Helper functions
 *
 * @package    WordPress
 * @subpackage SALC
 * @since 2.0.0
 */

namespace SALC;

/**
 * Parse HTML of wp_dropdown_languages into array
 *
 * @return array
 */
function parse_wp_dropdown_languages()
{

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

	$dom = new \DOMDocument();
	$dom->loadHTML(mb_convert_encoding($wp_dropdown_languages, 'HTML-ENTITIES', 'UTF-8'));
	$options = $dom->getElementsByTagName('option');
	for ($i = 0; $i < $options->length; $i++) {
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
