<?php
/**
 * Palm Beach functions and definitions
 *
 * @package Palm Beach
 */

/**
 * Palm Beach only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


if ( ! function_exists( 'palm_beach_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function palm_beach_setup() {

		// Make theme available for translation. Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'palm-beach', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set detfault Post Thumbnail size.
		set_post_thumbnail_size( 520, 325, true );

		// Add Header Image Size.
		add_image_size( 'palm-beach-header-image', 1920, 720, true );

		// Add different thumbnail sizes for Magazine Post widgets.
		add_image_size( 'palm-beach-thumbnail-small', 280, 175, true );
		add_image_size( 'palm-beach-thumbnail-large', 600, 375, true );

		// Register Navigation Menu.
		register_nav_menu( 'primary', esc_html__( 'Main Navigation', 'palm-beach' ) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'palm_beach_custom_background_args', array( 'default-color' => 'ffffff' ) ) );

		// Set up the WordPress core custom logo feature.
		add_theme_support( 'custom-logo', apply_filters( 'palm_beach_custom_logo_args', array(
			'height'      => 40,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		) ) );

		// Set up the WordPress core custom header feature.
		add_theme_support( 'custom-header', apply_filters( 'palm_beach_custom_header_args', array(
			'header-text' => false,
			'width'       => 1920,
			'height'      => 360,
			'flex-height' => true,
		) ) );

		// Add Theme Support for wooCommerce.
		add_theme_support( 'woocommerce' );

		// Add extra theme styling to the visual editor.
		add_editor_style( array( 'assets/css/editor-style.css' ) );

		// Add Theme Support for Selective Refresh in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for responsive embed blocks.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'palm_beach_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function palm_beach_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'palm_beach_content_width', 800 );
}
add_action( 'after_setup_theme', 'palm_beach_content_width', 0 );


/**
 * Register widget areas and custom widgets.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function palm_beach_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'palm-beach' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Appears on posts and pages except the full width template.', 'palm-beach' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Magazine Homepage', 'palm-beach' ),
		'id'            => 'magazine-homepage',
		'description'   => esc_html__( 'Appears on blog index and Magazine Homepage template. You can use the Magazine widgets here.', 'palm-beach' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );
}
add_action( 'widgets_init', 'palm_beach_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function palm_beach_scripts() {

	// Get theme options from database.
	$theme_options = palm_beach_theme_options();

	// Get Theme Version.
	$theme_version = wp_get_theme()->get( 'Version' );

	// Register and Enqueue Stylesheet.
	wp_enqueue_style( 'palm-beach-stylesheet', get_stylesheet_uri(), array(), $theme_version );

	// Register and Enqueue Safari Flexbox CSS fixes.
	wp_enqueue_style( 'palm-beach-safari-flexbox-fixes', get_template_directory_uri() . '/assets/css/safari-flexbox-fixes.css', array(), '20210116' );

	// Register and Enqueue HTML5shiv to support HTML5 elements in older IE versions.
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/assets/js/html5shiv.min.js', array(), '3.7.3' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	// Register and enqueue navigation.min.js.
	if ( ( has_nav_menu( 'primary' ) || has_nav_menu( 'secondary' ) ) && ! palm_beach_is_amp() ) {
		wp_enqueue_script( 'palm-beach-navigation', get_theme_file_uri( '/assets/js/navigation.min.js' ), array(), '20220224', true );
		$palm_beach_l10n = array(
			'expand'   => esc_html__( 'Expand child menu', 'palm-beach' ),
			'collapse' => esc_html__( 'Collapse child menu', 'palm-beach' ),
			'icon'     => palm_beach_get_svg( 'expand' ),
		);
		wp_localize_script( 'palm-beach-navigation', 'palmBeachScreenReaderText', $palm_beach_l10n );
	}

	// Register and enqueue sticky-header.js.
	if ( true == $theme_options['sticky_header'] && ! palm_beach_is_amp() ) {
		wp_enqueue_script( 'palm-beach-jquery-sticky-header', get_template_directory_uri() . '/assets/js/sticky-header.js', array( 'jquery' ), '20170127' );
	}

	// Enqueue svgxuse to support external SVG Sprites in Internet Explorer.
	if ( ! palm_beach_is_amp() ) {
		wp_enqueue_script( 'svgxuse', get_theme_file_uri( '/assets/js/svgxuse.min.js' ), array(), '1.2.6' );
	}

	// Register Comment Reply Script for Threaded Comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'palm_beach_scripts' );


/**
* Enqueue theme fonts.
*/
function palm_beach_theme_fonts() {
	$fonts_url = palm_beach_get_fonts_url();

	// Load Fonts if necessary.
	if ( $fonts_url ) {
		require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );
		wp_enqueue_style( 'palm-beach-theme-fonts', wptt_get_webfont_url( $fonts_url ), array(), '20201110' );
	}
}
add_action( 'wp_enqueue_scripts', 'palm_beach_theme_fonts', 1 );
add_action( 'enqueue_block_editor_assets', 'palm_beach_theme_fonts', 1 );


/**
 * Retrieve webfont URL to load fonts locally.
 */
function palm_beach_get_fonts_url() {
	$font_families = array(
		'Hind:400,400italic,700,700italic',
		'Montserrat:400,400italic,700,700italic',
	);

	$query_args = array(
		'family'  => urlencode( implode( '|', $font_families ) ),
		'subset'  => urlencode( 'latin,latin-ext' ),
		'display' => urlencode( 'swap' ),
	);

	return apply_filters( 'palm_beach_get_fonts_url', add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
}


/**
 * Make custom image sizes available in Gutenberg.
 */
function palm_beach_add_image_size_names( $sizes ) {
	return array_merge( $sizes, array(
		'post-thumbnail'             => esc_html__( 'Palm Beach Single Post', 'palm-beach' ),
		'palm-beach-thumbnail-large' => esc_html__( 'Palm Beach Magazine Post', 'palm-beach' ),
	) );
}
add_filter( 'image_size_names_choose', 'palm_beach_add_image_size_names' );


/**
 * Include Files
 */

// Include Theme Info page.
require get_template_directory() . '/inc/theme-info.php';

// Include Theme Customizer Options.
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/default-options.php';

// Include SVG Icon Functions.
require get_template_directory() . '/inc/icons.php';

// Include Extra Functions.
require get_template_directory() . '/inc/extras.php';

// Include Template Functions.
require get_template_directory() . '/inc/template-tags.php';

// Include Gutenberg Features.
require get_template_directory() . '/inc/gutenberg.php';

// Include support functions for Theme Addons.
require get_template_directory() . '/inc/addons.php';

// Include Post Slider Setup.
require get_template_directory() . '/inc/slider.php';

// Include Magazine Functions.
require get_template_directory() . '/inc/magazine.php';

// Include Widget Files.
require get_template_directory() . '/inc/widgets/widget-magazine-posts-grid.php';
