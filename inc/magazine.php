<?php
/**
 * Magazine Functions
 *
 * Custom Functions and Template tags used in the Magazine widgets and Magazine templates
 *
 * @package Palm Beach
 */


/**
* Function to change excerpt length for posts in category posts widgets
*
* @param int $length Length of excerpt in number of words.
* @return int
*/
function palm_beach_magazine_posts_excerpt_length( $length ) {
	return 25; // Number of words.
}


/**
* Get Magazine Post IDs
*
* @param String $cache_id        Magazine Widget Instance.
* @param int    $category        Category ID.
* @param int    $number_of_posts Number of posts.
* @return array Post IDs
*/
function palm_beach_get_magazine_post_ids( $cache_id, $category, $number_of_posts ) {

	$cache_id = sanitize_key( $cache_id );
	$post_ids = get_transient( 'palm_beach_magazine_post_ids' );

	if ( ! isset( $post_ids[ $cache_id ] ) ) {

		// Get Posts from Database.
		$query_arguments = array(
			'fields'              => 'ids',
			'cat'                 => (int) $category,
			'posts_per_page'      => (int) $number_of_posts,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);
		$query = new WP_Query( $query_arguments );

		// Create an array of all post ids.
		$post_ids[ $cache_id ] = $query->posts;

		// Set Transient.
		set_transient( 'palm_beach_magazine_post_ids', $post_ids );
	}

	return apply_filters( 'palm_beach_magazine_post_ids', $post_ids[ $cache_id ], $cache_id );
}


/**
* Delete Cached Post IDs
*
* @return void
*/
function palm_beach_flush_magazine_post_ids() {
	delete_transient( 'palm_beach_magazine_post_ids' );
}
add_action( 'save_post', 'palm_beach_flush_magazine_post_ids' );
add_action( 'deleted_post', 'palm_beach_flush_magazine_post_ids' );
add_action( 'switch_theme', 'palm_beach_flush_magazine_post_ids' );
