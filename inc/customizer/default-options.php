<?php
/**
 * Returns theme options
 *
 * Uses sane defaults in case the user has not configured any theme options yet.
 *
 * @package Palm Beach
 */

/**
 * Get saved user settings from database or theme defaults
 *
 * @return array
 */
function palm_beach_theme_options() {

	// Merge theme options array from database with default options array.
	$theme_options = wp_parse_args( get_option( 'palm_beach_theme_options', array() ), palm_beach_default_options() );

	// Return theme options.
	return $theme_options;

}


/**
 * Returns the default settings of the theme
 *
 * @return array
 */
function palm_beach_default_options() {

	$default_options = array(
		'site_title'						=> true,
		'layout' 							=> 'right-sidebar',
		'sticky_header'						=> false,
		'excerpt_length' 					=> 20,
		'meta_date'							=> true,
		'meta_author'						=> true,
		'meta_category'						=> true,
		'featured_image'					=> true,
		'meta_tags'							=> true,
		'post_navigation'					=> true,
		'featured_magazine' 				=> false,
		'featured_blog' 					=> false,
		'featured_category' 				=> 0,
	);

	return $default_options;
}
