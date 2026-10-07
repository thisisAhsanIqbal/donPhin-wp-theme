<?php
/**
 * Site sections
 *
 * donphin.com is a gateway to separate sections, each with its own home page, menu,
 * header button and palette. Everything about a section is described once, in
 * donphin_sections(); the header tabs, the menus, working out which section a page
 * belongs to, the body class, the section stylesheet (inc/enqueue.php) and the
 * "Header Section" box on the page screen (inc/header-meta-box.php) all read from it.
 *
 * To add a section: add an entry below, give it a stylesheet in assets/css/ if it has
 * its own palette, and file its pages under its home page in WordPress.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Every section, in the order of the header tabs.
 *
 * label      The tab's name.
 * tagline    One short line about the section, for places that offer a choice of
 *            sections (the For You 404 page).
 * home       The section's home page.
 * slug       The home page's slug. Pages filed under it belong to the section.
 * aliases    Other names the section answers to (?header=..., older settings).
 * pages      Other page slugs that belong to it without being filed under it.
 * templates  Page templates that always belong to it, wherever the page is filed.
 * stylesheet The section's palette, assets/css/{stylesheet}.css, loaded on all its pages.
 * menu       The header menu, used until a menu is assigned to the section in
 *            Appearance > Menus: array( label, path, optional screen reader label ).
 * cta        The header button: array( label, path, icon ), the icon being a file in
 *            assets/images/icons/ without its .svg.
 *
 * @return array
 */
function donphin_sections() {
	return array(
		'foryou'   => array(
			'label'      => 'For You',
			'tagline'    => '',
			'home'       => '/',
			'slug'       => '',
			'aliases'    => array( 'for-you' ),
			'pages'      => array(),
			'templates'  => array(),
			'stylesheet' => '',
			'menu'       => array(
				array( 'About', '/speaking/about/' ),
				array( 'Tools', '/free-tools/' ),
				array( 'Contact', '/speaking/contact/' ),
			),
			'cta'        => array( 'Book Don', '/speaking/contact/', 'calendar' ),
		),
		'counsel'  => array(
			'label'      => 'Private counsel',
			'tagline'    => 'The Next Journey: three men at a time, by introduction.',
			'home'       => '/private-counsel/',
			'slug'       => 'private-counsel',
			'aliases'    => array( 'private', 'counsel' ),
			'pages'      => array( 'for-advisors', 'advisors' ),
			'templates'  => array( 'page-private-counsel.php', 'page-the-journey.php', 'page-counsel-about.php', 'page-counsel-contact.php', 'page-counsel-resources.php' ),
			'stylesheet' => 'private-counsel',
			'menu'       => array(
				array( 'Home', '/private-counsel/', 'Private Counsel home' ),
				array( 'The Next Journey', '/private-counsel/the-journey/' ),
				array( 'About', '/private-counsel/about/' ),
				array( 'Resources', '/private-counsel/resources/' ),
				array( 'Contact', '/private-counsel/contact/' ),
			),
			'cta'        => array( 'Enquire', '/private-counsel/contact/', 'send' ),
		),
		'speaking' => array(
			'label'      => 'Speaking',
			'tagline'    => 'Keynotes and workshops for your sales team or event.',
			'home'       => '/speaking/',
			'slug'       => 'speaking',
			'aliases'    => array(),
			'pages'      => array(),
			'templates'  => array( 'page-speaking.php', 'page-speaking-about.php', 'page-speaking-contact.php', 'page-speaking-resources.php', 'page-purchase-the-40-40-solution.php' ),
			'stylesheet' => 'speaking',
			'menu'       => array(
				array( 'Home', '/speaking/', 'Speaking home' ),
				array( 'About', '/speaking/about/' ),
				array( 'Resources', '/speaking/resources/' ),
				array( 'The 40//40 Solution', '/speaking/purchase-the-40-40-solution/' ),
				array( 'Contact', '/speaking/contact/' ),
			),
			'cta'        => array( 'Book Don', '/speaking/contact/', 'calendar' ),
		),
	);
}

/**
 * Which section a name refers to: its key, or any of its aliases
 *
 * @param string $name A section key or alias.
 * @return string The section key, or '' if none.
 */
function donphin_section_key( $name ) {
	foreach ( donphin_sections() as $key => $section ) {
		if ( $name === $key || in_array( $name, $section['aliases'], true ) || ( '' !== $section['slug'] && $name === $section['slug'] ) ) {
			return $key;
		}
	}
	return '';
}

/**
 * A site path without the site's own folder (e.g. /donphin/ on this machine) and
 * without slashes at either end: 'speaking/contact' for /donphin/speaking/contact/
 *
 * @param string $url A full URL or a path.
 * @return string
 */
function donphin_site_path( $url ) {
	$path = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
	$base = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	if ( '' !== $base && ( $path === $base || 0 === strpos( $path, $base . '/' ) ) ) {
		$path = trim( substr( $path, strlen( $base ) ), '/' );
	}
	return $path;
}

/**
 * Which section an address belongs to, by its first part: /speaking/... is Speaking,
 * /private-counsel/... and /private/... are Private Counsel
 *
 * @param string $url A full URL or a path.
 * @return string A section key, or '' if the address doesn't start with one.
 */
function donphin_section_from_url( $url ) {
	$first = strtok( donphin_site_path( $url ), '/' );
	return ( false === $first ) ? '' : donphin_section_key( sanitize_title( $first ) );
}

/**
 * Which section a post or page belongs to
 *
 * @param int $post_id The post or page.
 * @return string A section key, or '' if it belongs to none in particular.
 */
function donphin_section_for_post( $post_id ) {
	if ( ! $post_id ) {
		return '';
	}

	// 1. Chosen by hand in the "Header Section" box
	$key = donphin_section_key( (string) get_post_meta( $post_id, '_donphin_header_section', true ) );
	if ( $key ) {
		return $key;
	}

	// The old two-header box: only 'counsel' was a real choice
	$legacy = get_post_meta( $post_id, '_donphin_header_type', true );
	if ( empty( $legacy ) ) {
		$legacy = get_post_meta( $post_id, 'header_type', true );
	}
	if ( in_array( $legacy, array( 'counsel', 'private-counsel' ), true ) ) {
		return 'counsel';
	}

	// A resource belongs to the section whose library it's in
	$side = donphin_resource_side( get_post_type( $post_id ) );
	if ( $side ) {
		return $side;
	}

	if ( 'page' !== get_post_type( $post_id ) ) {
		return '';
	}

	// 2. The section's own templates, home page and extra pages
	$template = get_page_template_slug( $post_id );
	$slug     = get_post_field( 'post_name', $post_id );
	foreach ( donphin_sections() as $key => $section ) {
		if ( ( $template && in_array( $template, $section['templates'], true ) ) || ( '' !== $slug && ( $slug === $section['slug'] || in_array( $slug, $section['pages'], true ) ) ) ) {
			return $key;
		}
	}

	// 3. Filed under a section's home page, e.g. /speaking/about/
	foreach ( get_post_ancestors( $post_id ) as $ancestor ) {
		$key = donphin_section_key( get_post_field( 'post_name', $ancestor ) );
		if ( $key ) {
			return $key;
		}
	}

	return '';
}

/**
 * Which section the current request belongs to. Picks the active header tab, the
 * header menu and button, the body class, the section stylesheet and the 404 page's
 * way back.
 *
 * @return string A key of donphin_sections().
 */
function donphin_get_header_section() {
	// Worked out once per request, once WordPress knows what was asked for
	static $cached = null;
	if ( null !== $cached ) {
		return $cached;
	}

	$key = '';

	// 1. URL override, for previewing and for the thank-you page (e.g. ?header=counsel)
	if ( isset( $_GET['header'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$key = donphin_section_key( sanitize_key( wp_unslash( $_GET['header'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	// 2. A post or page: its own section
	if ( ! $key && is_singular() ) {
		$key = donphin_section_for_post( get_queried_object_id() );
	}

	// 3. A page that doesn't exist: the section of the address asked for, or else of
	//    the page on this site the visitor came from, so the 404 keeps them where they were
	if ( ! $key && is_404() ) {
		$key = donphin_section_from_url( add_query_arg( array() ) );

		$referer = wp_get_raw_referer();
		if ( ! $key && $referer && wp_validate_redirect( $referer, false ) ) {
			$key = donphin_section_from_url( $referer );
			if ( ! $key ) {
				$key = donphin_section_for_post( url_to_postid( $referer ) );
			}
		}
	}

	$key = $key ? $key : 'foryou';

	if ( did_action( 'wp' ) ) {
		$cached = $key;
	}
	return $key;
}

/**
 * Add the section as a body class: 'foryou-header', 'counsel-header' or 'speaking-header'
 */
function donphin_header_body_classes( $classes ) {
	$classes[] = donphin_get_header_section() . '-header';
	return $classes;
}
add_filter( 'body_class', 'donphin_header_body_classes' );

/**
 * One menu location per section, so each section's menu can be edited in
 * Appearance > Menus. Until one is assigned, the section's menu from
 * donphin_sections() is used.
 */
function donphin_register_section_menus() {
	$locations = array();
	foreach ( donphin_sections() as $key => $section ) {
		/* translators: %s: section name */
		$locations[ 'section-' . $key ] = sprintf( __( 'Header menu: %s', 'don-phin-esq' ), $section['label'] );
	}
	register_nav_menus( $locations );
}
add_action( 'after_setup_theme', 'donphin_register_section_menus' );

/**
 * A section's header menu and button, ready to print.
 *
 * From the menu assigned in Appearance > Menus if there is one (an item given the CSS
 * class "cta" there becomes the button, and a class "icon-calendar", say, picks its
 * icon), otherwise from donphin_sections().
 *
 * @param string $key A key of donphin_sections().
 * @return array { links: array of array( label, url, aria label ), cta: array( label, url, icon ) }
 */
function donphin_section_menu( $key ) {
	$sections = donphin_sections();
	$section  = isset( $sections[ $key ] ) ? $sections[ $key ] : $sections['foryou'];

	$links = array();
	foreach ( $section['menu'] as $link ) {
		$links[] = array( $link[0], home_url( $link[1] ), isset( $link[2] ) ? $link[2] : '' );
	}
	$cta = array( $section['cta'][0], home_url( $section['cta'][1] ), isset( $section['cta'][2] ) ? $section['cta'][2] : '' );

	$locations = get_nav_menu_locations();
	$location  = 'section-' . $key;
	if ( ! empty( $locations[ $location ] ) ) {
		$items = wp_get_nav_menu_items( $locations[ $location ] );
		if ( $items ) {
			$links = array();
			foreach ( $items as $item ) {
				if ( in_array( 'cta', (array) $item->classes, true ) ) {
					// Its icon: a class "icon-{name}" on the item, or the section's own
					$icon = $cta[2];
					foreach ( (array) $item->classes as $class ) {
						if ( 0 === strpos( $class, 'icon-' ) ) {
							$icon = substr( $class, 5 );
						}
					}
					$cta = array( $item->title, $item->url, $icon );
					continue;
				}
				$links[] = array( $item->title, $item->url, $item->attr_title );
			}
		}
	}

	return array(
		'links' => $links,
		'cta'   => $cta,
	);
}
