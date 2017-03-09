<?php
/**
 * The template for displaying small posts in Magazine Post widgets
 *
 * @package Palm Beach
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'small-post clearfix' ); ?>>

	<?php palm_beach_post_image( 'palm-beach-thumbnail-small' ); ?>

	<div class="small-post-content">

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php palm_beach_entry_meta(); ?>

	</div>

</article>
