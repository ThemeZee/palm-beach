<?php
/**
 * Add Support for Theme Addons
 *
 * @package Palm Beach
 */

/**
 * Register support for Jetpack and theme addons
 */
function palm_beach_theme_addons_setup() {

	// Add theme support for Palm Beach Pro plugin.
	add_theme_support( 'palm-beach-pro' );

	// Add theme support for ThemeZee Plugins.
	add_theme_support( 'themezee-widget-bundle' );
	add_theme_support( 'themezee-breadcrumbs' );
	add_theme_support( 'themezee-related-posts' );
	add_theme_support( 'themezee-mega-menu', array( 'primary', 'secondary' ) );

	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'post-wrapper',
		'footer_widgets' => 'footer',
		'wrapper'        => false,
		'render'         => 'palm_beach_infinite_scroll_render',
		'posts_per_page' => 6,
	) );

}
add_action( 'after_setup_theme', 'palm_beach_theme_addons_setup' );


/**
 * Load custom stylesheets for theme addons
 */
function palm_beach_theme_addons_scripts() {

	// Load widget bundle styles if widgets are active.
	if ( is_active_widget( 'TZWB_Facebook_Likebox_Widget', false, 'tzwb-facebook-likebox' )
		or is_active_widget( 'TZWB_Recent_Comments_Widget', false, 'tzwb-recent-comments' )
		or is_active_widget( 'TZWB_Recent_Posts_Widget', false, 'tzwb-recent-posts' )
		or is_active_widget( 'TZWB_Social_Icons_Widget', false, 'tzwb-social-icons' )
		or is_active_widget( 'TZWB_Tabbed_Content_Widget', false, 'tzwb-tabbed-content' )
	) {

		// Enqueue Widget Bundle stylesheet.
		wp_enqueue_style( 'themezee-widget-bundle', get_template_directory_uri() . '/css/themezee-widget-bundle.css', array(), '20160421' );

	}

	// Load Related Posts stylesheet only on single posts.
	if ( is_singular( 'post' ) ) {

		// Enqueue Related Post stylesheet.
		wp_enqueue_style( 'themezee-related-posts', get_template_directory_uri() . '/css/themezee-related-posts.css', array(), '20160421' );

	}

}
add_action( 'wp_enqueue_scripts', 'palm_beach_theme_addons_scripts' );


/**
 * Add custom image sizes for theme addons
 */
function palm_beach_theme_addons_image_sizes() {

	// Add Widget Bundle thumbnail.
	add_image_size( 'tzwb-thumbnail', 80, 60, true );

	// Add Related Posts thumbnail.
	add_image_size( 'themezee-related-posts', 480, 300, true );

}
add_action( 'after_setup_theme', 'palm_beach_theme_addons_image_sizes' );


/**
 * Custom render function for Infinite Scroll.
 */
function palm_beach_infinite_scroll_render() {

	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content' );
	}

}
