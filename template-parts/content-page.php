<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Palm Beach
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php palm_beach_post_image_single(); ?>

	<header class="entry-header">

		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content clearfix">

		<?php the_content(); ?>

		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'palm-beach' ),
			'after'  => '</div>',
		) ); ?>

	</div><!-- .entry-content -->

</article>
