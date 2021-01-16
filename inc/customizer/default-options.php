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
* Get a single theme option
*
* @return mixed
*/
function palm_beach_get_option( $option_name = '' ) {

	// Get all Theme Options from Database.
	$theme_options = palm_beach_theme_options();

	// Return single option.
	if ( isset( $theme_options[ $option_name ] ) ) {
		return $theme_options[ $option_name ];
	}

	return false;
}


/**
 * Returns the default settings of the theme
 *
 * @return array
 */
function palm_beach_default_options() {
	$default_options = array(
		'retina_logo'      => false,
		'site_title'       => true,
		'site_description' => false,
		'layout'           => 'right-sidebar',
		'sticky_header'    => false,
		'blog_title'       => '',
		'excerpt_length'   => 20,
		'meta_date'        => true,
		'meta_author'      => true,
		'meta_category'    => true,
		'meta_comments'    => true,
		'meta_tags'        => true,
		'post_navigation'  => true,
		'slider_magazine'  => false,
		'slider_blog'      => false,
		'slider_category'  => 0,
		'slider_limit'     => 8,
		'slider_animation' => 'slide',
		'slider_speed'     => 7000,
	);

	return $default_options;
}
