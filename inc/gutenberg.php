<?php
/**
 * Add theme support for the Gutenberg Editor
 *
 * @package Palm Beach
 */


/**
 * Registers support for various Gutenberg features.
 *
 * @return void
 */
function palm_beach_gutenberg_support() {

	// Add theme support for dimension controls.
	add_theme_support( 'custom-spacing' );

	// Add theme support for custom line heights.
	add_theme_support( 'custom-line-height' );

	// Define block color palette.
	$color_palette = apply_filters( 'palm_beach_color_palette', array(
		'primary_color'    => '#57b7d7',
		'secondary_color'  => '#3e9ebe',
		'tertiary_color'   => '#2484a4',
		'accent_color'     => '#57d777',
		'highlight_color'  => '#d75f57',
		'light_gray_color' => '#e4e4e4',
		'gray_color'       => '#646464',
		'dark_gray_color'  => '#242424',
	) );

	// Add theme support for block color palette.
	add_theme_support( 'editor-color-palette', apply_filters( 'palm_beach_editor_color_palette_args', array(
		array(
			'name'  => esc_html_x( 'Primary', 'block color', 'palm-beach' ),
			'slug'  => 'primary',
			'color' => esc_html( $color_palette['primary_color'] ),
		),
		array(
			'name'  => esc_html_x( 'Secondary', 'block color', 'palm-beach' ),
			'slug'  => 'secondary',
			'color' => esc_html( $color_palette['secondary_color'] ),
		),
		array(
			'name'  => esc_html_x( 'Tertiary', 'block color', 'palm-beach' ),
			'slug'  => 'tertiary',
			'color' => esc_html( $color_palette['tertiary_color'] ),
		),
		array(
			'name'  => esc_html_x( 'Accent', 'block color', 'palm-beach' ),
			'slug'  => 'accent',
			'color' => esc_html( $color_palette['accent_color'] ),
		),
		array(
			'name'  => esc_html_x( 'Highlight', 'block color', 'palm-beach' ),
			'slug'  => 'highlight',
			'color' => esc_html( $color_palette['highlight_color'] ),
		),
		array(
			'name'  => esc_html_x( 'White', 'block color', 'palm-beach' ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
		array(
			'name'  => esc_html_x( 'Light Gray', 'block color', 'palm-beach' ),
			'slug'  => 'light-gray',
			'color' => esc_html( $color_palette['light_gray_color'] ),
		),
		array(
			'name'  => esc_html_x( 'Gray', 'block color', 'palm-beach' ),
			'slug'  => 'gray',
			'color' => esc_html( $color_palette['gray_color'] ),
		),
		array(
			'name'  => esc_html_x( 'Dark Gray', 'block color', 'palm-beach' ),
			'slug'  => 'dark-gray',
			'color' => esc_html( $color_palette['dark_gray_color'] ),
		),
		array(
			'name'  => esc_html_x( 'Black', 'block color', 'palm-beach' ),
			'slug'  => 'black',
			'color' => '#000000',
		),
	) ) );

	// Check if block style functions are available.
	if ( function_exists( 'register_block_style' ) ) {

		// Register Widget Title Block style.
		register_block_style( 'core/heading', array(
			'name'         => 'widget-title',
			'label'        => esc_html__( 'Widget Title', 'palm-beach' ),
			'style_handle' => 'palm-beach-stylesheet',
		) );
	}
}
add_action( 'after_setup_theme', 'palm_beach_gutenberg_support' );


/**
 * Enqueue block styles and scripts for Gutenberg Editor.
 */
function palm_beach_block_editor_assets() {

	// Enqueue Editor Styling.
	wp_enqueue_style( 'palm-beach-editor-styles', get_theme_file_uri( '/assets/css/editor-styles.css' ), array(), '20210306', 'all' );

	// Enqueue Page Template Switcher Editor plugin.
	#wp_enqueue_script( 'palm-beach-page-template-switcher', get_theme_file_uri( '/assets/js/page-template-switcher.js' ), array( 'wp-blocks', 'wp-element', 'wp-edit-post' ), '20210306' );
}
add_action( 'enqueue_block_editor_assets', 'palm_beach_block_editor_assets' );


/**
 * Remove inline styling in Gutenberg.
 *
 * @return array $editor_settings
 */
function palm_beach_block_editor_settings( $editor_settings ) {
	// Remove editor styling.
	if ( ! current_theme_supports( 'editor-styles' ) ) {
		$editor_settings['styles'] = '';
	}

	return $editor_settings;
}
#add_filter( 'block_editor_settings', 'palm_beach_block_editor_settings', 11 );


/**
 * Add body classes in Gutenberg Editor.
 */
function palm_beach_block_editor_body_classes( $classes ) {
	global $post;
	$current_screen = get_current_screen();

	// Return early if we are not in the Gutenberg Editor.
	if ( ! ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) ) {
		return $classes;
	}

	// Fullwidth Page Template?
	if ( 'templates/template-fullwidth.php' === get_page_template_slug( $post->ID ) ) {
		$classes .= ' palm-beach-fullwidth-page-layout ';
	}

	// No Title Page Template?
	if ( 'templates/template-no-title.php' === get_page_template_slug( $post->ID ) or
		'templates/template-sidebar-left-no-title.php' === get_page_template_slug( $post->ID ) or
		'templates/template-sidebar-right-no-title.php' === get_page_template_slug( $post->ID ) ) {
		$classes .= ' palm-beach-page-title-hidden ';
	}

	// Full-width / No Title Page Template?
	if ( 'templates/template-fullwidth-no-title.php' === get_page_template_slug( $post->ID ) ) {
		$classes .= ' palm-beach-fullwidth-page-layout palm-beach-page-title-hidden ';
	}

	return $classes;
}
#add_filter( 'admin_body_class', 'palm_beach_block_editor_body_classes' );
