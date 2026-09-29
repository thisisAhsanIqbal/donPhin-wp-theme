<?php
/**
 * Redirects from old or shorthand addresses, worked out as the request comes in
 *
 * Pages that moved keep working from their old addresses, with a permanent (301)
 * redirect so search engines follow them too. Nothing here points at a fixed address
 * that could be wrong on a given site: every redirect goes to wherever the page lives
 * *now*, looked up at the time, and only if it exists and is published. It never sends
 * anyone to the address they are already on, so it can't loop, and if it can't find
 * the page it steps aside and WordPress shows the page or a normal 404.
 *
 * Three sources, in order:
 *  1. Old addresses remembered automatically: whenever a page's address changes (a new
 *     parent or slug), the old one is stored on the page (donphin_remember_old_path()).
 *  2. donphin_redirects(): addresses that should lead somewhere else, as hints. Each is
 *     followed only if its page is found, by its path or else by its slug.
 *  3. donphin_redirect_prefixes(): shorthand for whole sections (/private/... to
 *     /private-counsel/...), again only when the page is there.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hints: old path => where that page should now be, both relative to the site's home.
 * Pages that simply moved in WordPress don't need to be listed; they are remembered
 * automatically. List only addresses that never belonged to the page, or moves made
 * before the automatic memory existed.
 *
 * @return array
 */
function donphin_redirects() {
	return array(
		// About and Contact moved into the Speaking section
		'about'                       => '/speaking/about/',
		'about-don-phin'              => '/speaking/about/',
		'contact'                     => '/speaking/contact/',

		// The 40|40 Solution moved into the Speaking section
		'purchase-the-40-40-solution' => '/speaking/purchase-the-40-40-solution/',

		// The Journey moved into the Private Counsel section
		'the-journey'                 => '/private-counsel/the-journey/',
		'journey'                     => '/private-counsel/the-journey/',
	);
}

/**
 * Shorthand path prefixes => the real one, for whole sections
 * (so /private/about/ reaches /private-counsel/about/)
 *
 * @return array
 */
function donphin_redirect_prefixes() {
	return array(
		'private' => 'private-counsel',
	);
}

/**
 * The published page a path leads to, if any: by its full path first, then, for a
 * page that has moved on this site but not been listed yet, by its last part (slug)
 *
 * @param string $path A site path such as 'speaking/about'.
 * @return WP_Post|null
 */
function donphin_find_page( $path ) {
	$path = trim( $path, '/' );
	if ( '' === $path ) {
		return null;
	}

	$page = get_page_by_path( $path );
	if ( $page && 'publish' === $page->post_status ) {
		return $page;
	}

	// Not at that path on this site: look for the page by its slug, wherever it is
	$slug  = basename( $path );
	$found = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'name'           => $slug,
			'posts_per_page' => 2,
		)
	);

	// Only when the slug is unmistakable: two pages called "about" can't be told apart
	return 1 === count( $found ) ? $found[0] : null;
}

/**
 * The published page that used to live at a path, from the addresses remembered on pages
 *
 * @param string $path A site path such as 'the-journey'.
 * @return WP_Post|null
 */
function donphin_find_moved_page( $path ) {
	$found = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'meta_key'       => '_dp_old_path', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- only on requests for missing pages
			'meta_value'     => trim( $path, '/' ), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'posts_per_page' => 1,
		)
	);
	return $found ? $found[0] : null;
}

/**
 * Remember a page's old address whenever its address changes, so the old one keeps working
 */
function donphin_remember_old_path( $post_id, $after, $before ) {
	if ( 'page' !== $after->post_type || 'publish' !== $before->post_status || wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( $after->post_name === $before->post_name && $after->post_parent === $before->post_parent ) {
		return;
	}

	// The address the page had before this save
	$old = trim( get_page_uri( $before ), '/' );
	$new = trim( get_page_uri( $after ), '/' );
	if ( '' === $old || $old === $new ) {
		return;
	}

	if ( ! in_array( $old, get_post_meta( $post_id, '_dp_old_path' ), true ) ) {
		add_post_meta( $post_id, '_dp_old_path', $old );
	}

	// If this page has come back to an address it used to have, that isn't "old" any more
	delete_post_meta( $post_id, '_dp_old_path', $new );
}
add_action( 'post_updated', 'donphin_remember_old_path', 10, 3 );

/**
 * Send the visitor on if they asked for an old address, to wherever the page is now
 */
function donphin_redirect_old_pages() {
	// The requested path, without the site's own folder (e.g. /donphin/ on this machine)
	$path = donphin_site_path( add_query_arg( array() ) );
	if ( '' === $path ) {
		return;
	}

	$page      = null;
	$redirects = donphin_redirects();

	// 1. A remembered old address (only for addresses that no longer lead anywhere)
	if ( is_404() ) {
		$page = donphin_find_moved_page( $path );
	}

	// 2. A listed hint
	if ( ! $page && isset( $redirects[ $path ] ) ) {
		$hint = $redirects[ $path ];

		// Links written as /contact/?topic=counsel meant Private Counsel's contact page
		$topic = isset( $_GET['topic'] ) ? sanitize_key( wp_unslash( $_GET['topic'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( 'contact' === $path && 'counsel' === $topic ) {
			$hint = '/private-counsel/contact/';
		}

		$page = donphin_find_page( $hint );
	}

	// 3. Section shorthand, e.g. /private/about/
	if ( ! $page && is_404() ) {
		foreach ( donphin_redirect_prefixes() as $from => $to ) {
			if ( $path === $from || 0 === strpos( $path, $from . '/' ) ) {
				$page = donphin_find_page( $to . substr( $path, strlen( $from ) ) );
				break;
			}
		}
	}

	if ( ! $page ) {
		return;
	}

	// Never to the address they are already on: that is how redirect loops start
	$target = get_permalink( $page );
	if ( ! $target || trim( donphin_site_path( $target ), '/' ) === $path ) {
		return;
	}

	// Anything else in the link (a status message, say) travels with it; the topic has done its job
	$args = wp_unslash( $_GET ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	unset( $args['topic'] );

	wp_safe_redirect( add_query_arg( urlencode_deep( $args ), $target ), 301 );
	exit;
}
add_action( 'template_redirect', 'donphin_redirect_old_pages', 1 );
