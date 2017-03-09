<?php
/**
 * The template for displaying large posts in Magazine Post widgets
 *
 * @package Palm Beach
 */

// Get widget settings.
$post_excerpt = get_query_var( 'palm_beach_post_excerpt', false );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'large-post clearfix' ); ?>>

	<?php palm_beach_post_image( 'palm-beach-thumbnail-large' ); ?>

	<div class="post-content">

		<header class="entry-header">

			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php palm_beach_entry_meta(); ?>

		</header><!-- .entry-header -->

		<?php // Display post excerpt if enabled.
		if ( $post_excerpt ) : ?>

			<div class="entry-content">

				<?php the_excerpt(); ?>
				<?php palm_beach_more_link(); ?>

			</div><!-- .entry-content -->

		<?php endif; ?>

	</div>

</article>
