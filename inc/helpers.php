<?php
/**
 * Small helpers used across the templates: asset versioning, Don's social profiles,
 * the client logos, and the theme's icons
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Version an asset by when it last changed.
 *
 * The theme version does not move between edits, so a browser that already has
 * a stylesheet cached goes on using it and the edit never shows up. A file's own
 * timestamp changes whenever the file does, which is what busts the cache.
 *
 * @param string $path Theme-relative path, for example '/assets/css/about.css'.
 * @return string
 */
function donphin_asset_version( $path ) {
	$file = get_stylesheet_directory() . $path;

	return file_exists( $file ) ? (string) filemtime( $file ) : wp_get_theme()->get( 'Version' );
}

/**
 * Don's social profiles: the header icons and the home hero's "Watch Don speak" link.
 * 'path' is the 24x24 SVG icon.
 */
function donphin_social_links() {
	return array(
		'linkedin' => array(
			'label' => 'LinkedIn',
			'url'   => 'https://www.linkedin.com/in/donphin',
			'path'  => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
		),
		'youtube'  => array(
			'label' => 'YouTube',
			'url'   => 'https://www.youtube.com/channel/UCY4rQB3Z-62FVcLW264tANQ',
			'path'  => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z',
		),
	);
}

/**
 * The organisations that have booked Don: name, file in assets/images/icons/, and the
 * file's own width and height (so the row doesn't shift as the logos load), and the
 * key its size in the marquee is balanced by (style.css, .dp-logo-mark--{key}).
 * The twelve from Don's Sales on Stage one-sheet, in its order.
 * Shown in the logo marquee (template-parts/logo-marquee.php).
 */
function donphin_client_logos() {
	return array(
		array( 'American Academy of Estate Planning Attorneys', 'client-american-academy.png', 189, 60, 'american-academy' ),
		array( 'ADP', 'client-adp.png', 190, 67, 'adp' ),
		array( 'Avetta', 'client-avetta.png', 198, 105, 'avetta' ),
		array( 'PIHRA, Professionals in Human Resources Association', 'client-pihra.png', 147, 101, 'pihra' ),
		array( 'Vistage', 'client-vistage.png', 190, 37, 'vistage' ),
		array( 'Association of Workplace Investigators', 'client-awi.png', 184, 51, 'awi' ),
		array( 'HHRABC', 'client-hhrabc.png', 128, 105, 'hhrabc' ),
		array( 'Embassy Suites by Hilton', 'client-embassy-suites.png', 128, 101, 'embassy-suites' ),
		array( 'ARCSI, a division of ISSA', 'client-arcsi.png', 192, 90, 'arcsi' ),
		array( 'AAMGA, American Association of Managing General Agents', 'client-aamga.png', 144, 58, 'aamga' ),
		array( 'ReSource Pro', 'client-resourcepro.png', 198, 40, 'resourcepro' ),
		array( 'SHRM', 'client-shrm.png', 166, 96, 'shrm' ),
	);
}

/**
 * One of the theme's icons (assets/images/icons/{name}.svg), printed inline so it takes
 * the colour of the text around it. The files draw in currentColor for that reason.
 *
 * @param string $name  File name without .svg, e.g. 'calendar'.
 * @param string $class Class for the svg element.
 * @return string The svg, or '' if there is no such icon.
 */
function donphin_icon( $name, $class = 'dp-icon' ) {
	static $cache = array();

	$name = sanitize_file_name( $name );
	if ( ! isset( $cache[ $name ] ) ) {
		$file           = get_stylesheet_directory() . '/assets/images/icons/' . $name . '.svg';
		$cache[ $name ] = ( '' !== $name && is_readable( $file ) ) ? (string) file_get_contents( $file ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- a theme file
	}
	if ( '' === $cache[ $name ] ) {
		return '';
	}

	// Decorative: the button's own words say what it does
	return preg_replace( '/<svg\b/', '<svg class="' . esc_attr( $class ) . '" aria-hidden="true" focusable="false"', $cache[ $name ], 1 );
}

/**
 * Right arrow used after link text on the home page (hero links, Speak / Counsel)
 */
function donphin_arrow_icon() {
	return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
}

/**
 * A small line icon for the footer (24x24 SVG insides)
 */
function donphin_footer_icon( $name ) {
	$icons = array(
		'pin'      => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
		'phone'    => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>',
		'mail'     => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
		'linkedin' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
	);

	return '<svg class="dp-footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $name ] . '</svg>';
}
