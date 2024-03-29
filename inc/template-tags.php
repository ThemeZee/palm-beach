<?php
/**
 * Template Tags
 *
 * This file contains several template functions which are used to print out specific HTML markup
 * in the theme. You can override these template functions within your child theme.
 *
 * @package Palm Beach
 */

if ( ! function_exists( 'palm_beach_site_logo' ) ) :
	/**
	 * Displays the site logo in the header area
	 */
	function palm_beach_site_logo() {

		if ( function_exists( 'the_custom_logo' ) ) {

			the_custom_logo();

		}
	}
endif;


if ( ! function_exists( 'palm_beach_site_title' ) ) :
	/**
	 * Displays the site title in the header area
	 */
	function palm_beach_site_title() {

		if ( is_home() or is_page_template( 'template-magazine.php' )  ) : ?>

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

		<?php else : ?>

			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>

		<?php endif;
	}
endif;


if ( ! function_exists( 'palm_beach_site_description' ) ) :
	/**
	 * Displays the site description in the header area
	 */
	function palm_beach_site_description() {

		$description = get_bloginfo( 'description', 'display' ); /* WPCS: xss ok. */

		if ( $description || is_customize_preview() ) : ?>

			<p class="site-description"><?php echo $description; ?></p>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'palm_beach_header_image' ) ) :
	/**
	 * Displays the custom header image below the navigation menu.
	 */
	function palm_beach_header_image() {

		// Display default header image set on Appearance > Header.
		if ( get_header_image() ) : ?>

			<div id="headimg" class="header-image">

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id, 'full' ) ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				</a>

			</div>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'palm_beach_header_title' ) ) :
	/**
	 * Displays the header title.
	 */
	function palm_beach_header_title() {
		global $post;

		// Check if we find an image to display in the header.
		if ( is_singular() && has_post_thumbnail() ) :

			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'palm-beach-header-image' );
			?>

			<div class="header-title-image" style="background-image: url( '<?php echo esc_url( $image[0] ); ?>' )">

				<div class="header-title-image-container">

					<div class="header-title-wrap">

						<?php palm_beach_page_title(); ?>

					</div>

				</div>

			</div>

		<?php else : ?>

			<div class="header-title-background">

				<?php palm_beach_page_title(); ?>

			</div>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'palm_beach_page_title' ) ) :
	/**
	 * Displays title in header area.
	 */
	function palm_beach_page_title() {

		echo '<header class="page-header container clearfix">';

		if ( is_single() ) :

			// Display post title.
			the_title( '<h1 class="post-title header-title">', '</h1>' );
			palm_beach_entry_meta( true );

		elseif ( is_page() ) :

			// Display page title.
			the_title( '<h1 class="page-title header-title">', '</h1>' );

		elseif ( is_archive() ) :

			// Display archive title.
			the_archive_title( '<h1 class="archive-title header-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );

		elseif ( is_search() ) :

			echo '<h1 class="page-title header-title">' . esc_html__( 'Search', 'palm-beach' ) . '</h1>';
			echo get_search_form();

		elseif ( is_404() ) :

			echo '<h1 class="page-title header-title">' . esc_html__( '404: Page not found', 'palm-beach' ) . '</h1>';

		endif;

		echo '</header>';

	}
endif;


if ( ! function_exists( 'palm_beach_post_image' ) ) :
	/**
	 * Displays the featured image on archive posts.
	 *
	 * @param string $size Post thumbnail size.
	 * @param array  $attr Post thumbnail attributes.
	 */
	function palm_beach_post_image( $size = 'post-thumbnail', $attr = array() ) {

		// Display Post Thumbnail.
		if ( has_post_thumbnail() ) : ?>

			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_post_thumbnail( $size, $attr ); ?>
			</a>

		<?php endif;

	}
endif;


if ( ! function_exists( 'palm_beach_entry_meta' ) ) :
	/**
	 * Displays the date, author and categories of a post
	 */
	function palm_beach_entry_meta( $single_post = false ) {

		$postmeta = palm_beach_meta_date();
		$postmeta .= palm_beach_meta_author();

		// Display categories and comments only on single posts.
		if ( $single_post ) {

			$postmeta .= palm_beach_meta_category();
			$postmeta .= palm_beach_meta_comments();

		}

		echo '<div class="entry-meta clearfix">' . $postmeta . '</div>';
	}
endif;


if ( ! function_exists( 'palm_beach_meta_date' ) ) :
	/**
	 * Displays the post date
	 */
	function palm_beach_meta_date() {

		$time_string = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date published updated" datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$posted_on = palm_beach_get_svg( 'standard' ) . $time_string;

		return '<span class="meta-date">' . $posted_on . '</span>';
	}
endif;


if ( ! function_exists( 'palm_beach_meta_author' ) ) :
	/**
	 * Displays the post author
	 */
	function palm_beach_meta_author() {
		global $post;
		$author_id = (int) $post->post_author;

		$author_string = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( $author_id ) ),
			esc_attr( sprintf( esc_html__( 'View all posts by %s', 'palm-beach' ), get_the_author_meta( 'display_name', $author_id ) ) ),
			esc_html( get_the_author_meta( 'display_name', $author_id ) )
		);

		$posted_by = palm_beach_get_svg( 'user' ) . $author_string;

		return '<span class="meta-author"> ' . $posted_by . '</span>';
	}
endif;


if ( ! function_exists( 'palm_beach_meta_category' ) ) :
	/**
	 * Displays the category of posts
	 */
	function palm_beach_meta_category() {

		// Return early if post has no category.
		if ( ! has_category() ) {
			return;
		}

		$posted_in = palm_beach_get_svg( 'category' ) . get_the_category_list( ', ' );

		return '<span class="meta-category"> ' . $posted_in . '</span>';
	}
endif;


if ( ! function_exists( 'palm_beach_meta_comments' ) ) :
	/**
	 * Displays the post comments
	 */
	function palm_beach_meta_comments() {

		// Check if comments are open or we have at least one comment.
		if ( ! ( comments_open() || get_comments_number() ) ) {
			return;
		}

		ob_start();
		comments_popup_link( esc_html__( 'No comments', 'palm-beach' ), esc_html__( 'One comment', 'palm-beach' ), esc_html__( '% comments', 'palm-beach' ) );
		$comments_string = ob_get_contents();
		ob_end_clean();

		return '<span class="meta-comments"> ' . palm_beach_get_svg( 'comment' ) . $comments_string . '</span>';
	}
endif;


if ( ! function_exists( 'palm_beach_entry_tags' ) ) :
	/**
	 * Displays the post tags on single post view
	 */
	function palm_beach_entry_tags() {

		// Get tags.
		$tag_list = get_the_tag_list( '<span class="tags-title">' . esc_html__( 'Tags', 'palm-beach' ) . '</span>', '' );

		// Display tags.
		if ( $tag_list ) : ?>

			<div class="entry-tags clearfix">
				<span class="meta-tags">
					<?php echo $tag_list; ?>
				</span>
			</div><!-- .entry-tags -->

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'palm_beach_more_link' ) ) :
	/**
	 * Displays the more link on posts
	 */
	function palm_beach_more_link() {

		// Get theme options from database.
		$theme_options = palm_beach_theme_options();

		// Display read more button if there is excerpt.
		if ( $theme_options['excerpt_length'] > 0 ) : ?>

			<a href="<?php echo esc_url( get_permalink() ) ?>" class="more-link"><?php esc_html_e( 'Read more', 'palm-beach' ); ?></a>

		<?php
		endif;
	}
endif;


if ( ! function_exists( 'palm_beach_post_navigation' ) ) :
	/**
	 * Displays Single Post Navigation
	 */
	function palm_beach_post_navigation() {

		// Get theme options from database.
		$theme_options = palm_beach_theme_options();

		if ( true === $theme_options['post_navigation'] || is_customize_preview() ) {

			the_post_navigation( array(
				'prev_text' => esc_html_x( 'Previous Post', 'post navigation', 'palm-beach' ),
				'next_text' => esc_html_x( 'Next Post', 'post navigation', 'palm-beach' ),
			) );

		}
	}
endif;


if ( ! function_exists( 'palm_beach_breadcrumbs' ) ) :
	/**
	 * Displays ThemeZee Breadcrumbs plugin
	 */
	function palm_beach_breadcrumbs() {

		if ( function_exists( 'themezee_breadcrumbs' ) ) {

			themezee_breadcrumbs( array(
				'before' => '<div class="breadcrumbs-container container clearfix">',
				'after' => '</div>',
			) );

		}
	}
endif;


if ( ! function_exists( 'palm_beach_related_posts' ) ) :
	/**
	 * Displays ThemeZee Related Posts plugin
	 */
	function palm_beach_related_posts() {

		if ( function_exists( 'themezee_related_posts' ) ) {

			themezee_related_posts( array(
				'class' => 'related-posts clearfix',
				'before_title' => '<header class="related-posts-header"><h2 class="related-posts-title">',
				'after_title' => '</h2></header>',
			) );

		}
	}
endif;


if ( ! function_exists( 'palm_beach_pagination' ) ) :
	/**
	 * Displays pagination on archive pages
	 */
	function palm_beach_pagination() {

		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => '&laquo;<span class="screen-reader-text">' . esc_html_x( 'Previous Posts', 'pagination', 'palm-beach' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next Posts', 'pagination', 'palm-beach' ) . '</span>&raquo;',
		) );
	}
endif;


/**
 * Displays credit link on footer line
 */
function palm_beach_footer_text() {
	?>

	<span class="credit-link">
		<?php
		// translators: Theme Name and Link to ThemeZee.
		printf( esc_html__( 'WordPress Theme: %1$s by %2$s.', 'palm-beach' ),
			esc_html__( 'Palm Beach', 'palm-beach' ),
			'ThemeZee'
		);
		?>
	</span>

	<?php
}
add_action( 'palm_beach_footer_text', 'palm_beach_footer_text' );
