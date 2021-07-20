<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Palm Beach
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

	<?php do_action( 'palm_beach_before_site' ); ?>

	<div id="page" class="hfeed site">

		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'palm-beach' ); ?></a>

		<?php do_action( 'palm_beach_before_header' ); ?>

		<?php do_action( 'palm_beach_header_bar' ); ?>

		<header id="masthead" class="site-header clearfix" role="banner">

			<div class="header-main container clearfix">

				<div id="logo" class="site-branding clearfix">

					<?php palm_beach_site_logo(); ?>
					<?php palm_beach_site_title(); ?>
					<?php palm_beach_site_description(); ?>

				</div><!-- .site-branding -->

				<?php get_template_part( 'template-parts/header/site', 'navigation' ); ?>

			</div><!-- .header-main -->

		</header><!-- #masthead -->

		<?php do_action( 'palm_beach_after_header' ); ?>

		<?php
		// Display slider or header image on homepage.
		if ( is_home() or is_page_template( 'template-magazine.php' ) or is_page_template( 'template-slider.php' ) ) :

			palm_beach_slider();
			palm_beach_header_image();

		else :

			palm_beach_header_title();

		endif;
		?>

		<?php palm_beach_breadcrumbs(); ?>

		<div id="content" class="site-content container clearfix">
