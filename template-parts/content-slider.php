<?php
/**
 * The template for displaying articles in the slideshow loop
 *
 * @package Palm Beach
 */

?>

<li id="slide-<?php the_ID(); ?>" class="zeeslide clearfix">

	<?php // Check if we find an image to display in the header.
	if( has_post_thumbnail() ) :

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'palm-beach-header-image' );
		$image_url = $image[0];

	else :

		$image_url = get_template_directory_uri() . '/images/default-slider-image.png';

	endif;
	?>

	<div class="slide-post clearfix">

		<div class="header-title-image" style="background-image: url( '<?php echo esc_url( $image_url ); ?>' )">

			<div class="header-title-image-container">

				<div class="header-title-wrap">

					<header class="page-header container clearfix">

						<?php the_title( sprintf( '<h2 class="header-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

						<?php palm_beach_entry_meta( true ); ?>

					</header>

				</div>

			</div>

		</div>

	</div>

</li>
