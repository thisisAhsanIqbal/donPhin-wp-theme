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
 * home       The section's home page.
 * slug       The home page's slug. Pages filed under it belong to the section.
 * aliases    Other names the section answers to (?header=..., older settings).
 * pages      Other page slugs that belong to it without being filed under it.
 * templates  Page templates that always belong to it, wherever the page is filed.
 * stylesheet The section's palette, assets/css/{stylesheet}.css, loaded on all its pages.
 * menu       The header menu, used until a menu is assigned to the section in
 *            Appearance > Menus: array( label, path, optional screen reader label ).
 * cta        The header button: array( label, path ).
 *
 * @return array
 */
function donphin_sections() {
	return array(
		'foryou'   => array(
			'label'      => 'For You',
			'home'       => '/',
			'slug'       => '',
			'aliases'    => array( 'for-you' ),
			'pages'      => array(),
			'templates'  => array(),
			'stylesheet' => '',
			'menu'       => array(
				array( 'About', '/speaking/about/' ),
				array( "40|\u{2009}|40", '/purchase-the-40-40-solution/', 'The 40|40 Solution' ), // a thin space between the bars
				array( 'Tools', '/free-tools/' ),
				array( 'Contact', '/speaking/contact/' ),
			),
			'cta'        => array( 'Book Don', '/speaking/contact/' ),
		),
		'counsel'  => array(
			'label'      => 'Private counsel',
			'home'       => '/private-counsel/',
			'slug'       => 'private-counsel',
			'aliases'    => array( 'private', 'counsel' ),
			'pages'      => array( 'for-advisors', 'advisors' ),
			'templates'  => array( 'page-private-counsel.php', 'page-the-journey.php', 'page-counsel-about.php', 'page-counsel-contact.php' ),
			'stylesheet' => 'private-counsel',
			'menu'       => array(
				array( 'Home', '/private-counsel/', 'Private Counsel home' ),
				array( 'The Journey', '/private-counsel/the-journey/' ),
				array( 'About', '/private-counsel/about/' ),
				array( 'Resources', '/private-counsel/resources/' ),
				array( 'Contact', '/private-counsel/contact/' ),
			),
			'cta'        => array( 'Request A Conversation', '/private-counsel/contact/' ),
		),
		'speaking' => array(
			'label'      => 'Speaking',
			'home'       => '/speaking/',
			'slug'       => 'speaking',
			'aliases'    => array(),
			'pages'      => array(),
			'templates'  => array( 'page-speaking.php', 'page-speaking-about.php', 'page-speaking-contact.php' ),
			'stylesheet' => 'speaking',
			'menu'       => array(
				array( 'Home', '/speaking/', 'Speaking home' ),
				array( 'About', '/speaking/about/' ),
				array( 'Resources', '/speaking/resources/' ),
				array( 'The 40//40 Solution', '/purchase-the-40-40-solution/' ),
				array( 'Contact', '/speaking/contact/' ),
			),
			'cta'        => array( 'Book Don', '/speaking/contact/' ),
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
 * Which section the current request belongs to. Picks the active header tab, the
 * header menu and button, the body class and the section stylesheet.
 *
 * @return string A key of donphin_sections().
 */
function donphin_get_header_section() {
	$sections = donphin_sections();

	// 1. URL override, for previewing and for the thank-you page (e.g. ?header=counsel)
	if ( isset( $_GET['header'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$key = donphin_section_key( sanitize_key( wp_unslash( $_GET['header'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( $key ) {
			return $key;
		}
	}

	if ( is_singular() ) {
		// 2. Per-page choice from the "Header Section" box
		$key = donphin_section_key( (string) get_post_meta( get_the_ID(), '_donphin_header_section', true ) );
		if ( $key ) {
			return $key;
		}

		// The old two-header box: only 'counsel' was a real choice
		$legacy = get_post_meta( get_the_ID(), '_donphin_header_type', true );
		if ( empty( $legacy ) ) {
			$legacy = get_post_meta( get_the_ID(), 'header_type', true );
		}
		if ( in_array( $legacy, array( 'counsel', 'private-counsel' ), true ) ) {
			return 'counsel';
		}
	}

	if ( is_page() ) {
		// 3. The section's own templates, home page and extra pages
		foreach ( $sections as $key => $section ) {
			$slugs = array_filter( array_merge( array( $section['slug'] ), $section['pages'] ) );
			if ( ( $section['templates'] && is_page_template( $section['templates'] ) ) || ( $slugs && is_page( $slugs ) ) ) {
				return $key;
			}
		}

		// 4. Pages filed under a section's home page, e.g. /speaking/about/
		foreach ( get_post_ancestors( get_queried_object_id() ) as $ancestor ) {
			$key = donphin_section_key( get_post_field( 'post_name', $ancestor ) );
			if ( $key ) {
				return $key;
			}
		}
	}

	return 'foryou';
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
 * class "cta" there becomes the button), otherwise from donphin_sections().
 *
 * @param string $key A key of donphin_sections().
 * @return array { links: array of array( label, url, aria label ), cta: array( label, url ) }
 */
function donphin_section_menu( $key ) {
	$sections = donphin_sections();
	$section  = isset( $sections[ $key ] ) ? $sections[ $key ] : $sections['foryou'];

	$links = array();
	foreach ( $section['menu'] as $link ) {
		$links[] = array( $link[0], home_url( $link[1] ), isset( $link[2] ) ? $link[2] : '' );
	}
	$cta = array( $section['cta'][0], home_url( $section['cta'][1] ) );

	$locations = get_nav_menu_locations();
	$location  = 'section-' . $key;
	if ( ! empty( $locations[ $location ] ) ) {
		$items = wp_get_nav_menu_items( $locations[ $location ] );
		if ( $items ) {
			$links = array();
			foreach ( $items as $item ) {
				if ( in_array( 'cta', (array) $item->classes, true ) ) {
					$cta = array( $item->title, $item->url );
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
