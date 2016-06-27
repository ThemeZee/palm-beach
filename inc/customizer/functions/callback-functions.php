<?php
/**
 * Callback Functions
 *
 * Used to determine whether an option setting is displayed or not.
 * Called via the active_callback parameter of the add_control() function
 *
 * @package Palm Beach
 */

/**
 * Adds a callback function to retrieve wether slider is activated or not
 *
 * @param object $control / Instance of the Customizer Control.
 * @return bool
 */
function palm_beach_slider_activated_callback( $control ) {

	// Check if Slider is turned on.
	if ( $control->manager->get_setting( 'palm_beach_theme_options[slider_blog]' )->value() == 1 ) :
		return true;
	elseif ( $control->manager->get_setting( 'palm_beach_theme_options[slider_magazine]' )->value() == 1 ) :
		return true;
	else :
		return false;
	endif;

}
