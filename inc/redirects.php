<?php
/**
 * Redirects from old or shorthand addresses
 *
 * Pages that moved keep working from their old address, with a permanent (301)
 * redirect so search engines follow them too. To move a page, add its old path here.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Old path => new path, both relative to the site's home (no slashes at the ends of the key)
 *
 * @return array
 */
function donphin_redirects() {
	return array(
		// About and Contact moved into the Speaking section
		'about'          => '/speaking/about/',
		'about-don-phin' => '/speaking/about/',
		'contact'        => '/speaking/contact/',

		// The 40|40 Solution moved into the Speaking section
		'purchase-the-40-40-solution' => '/speaking/purchase-the-40-40-solution/',

		// The Journey moved into the Private Counsel section
		'the-journey'    => '/private-counsel/the-journey/',
		'journey'        => '/private-counsel/the-journey/',
	);
}

/**
 * Old or shorthand path prefixes => the real one, for whole sections
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
 * Send the visitor on if they asked for an old address
 */
function donphin_redirect_old_pages() {
	// The requested path, without the site's own folder (e.g. /donphin/ on this machine)
	$path = donphin_site_path( add_query_arg( array() ) );

	$target    = '';
	$redirects = donphin_redirects();

	if ( isset( $redirects[ $path ] ) ) {
		$target = $redirects[ $path ];

		// Links written as /contact/?topic=counsel meant Private Counsel's contact page
		$topic = isset( $_GET['topic'] ) ? sanitize_key( wp_unslash( $_GET['topic'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( 'contact' === $path && 'counsel' === $topic ) {
			$target = '/private-counsel/contact/';
		}
	} else {
		foreach ( donphin_redirect_prefixes() as $from => $to ) {
			if ( $path === $from || 0 === strpos( $path, $from . '/' ) ) {
				$target = '/' . $to . substr( $path, strlen( $from ) ) . '/';
				break;
			}
		}
	}

	if ( '' === $target ) {
		return;
	}

	// Anything else in the link (a status message, say) travels with it; the topic has done its job
	$args = wp_unslash( $_GET ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	unset( $args['topic'] );

	wp_safe_redirect( add_query_arg( urlencode_deep( $args ), home_url( $target ) ), 301 );
	exit;
}
add_action( 'template_redirect', 'donphin_redirect_old_pages', 1 );
