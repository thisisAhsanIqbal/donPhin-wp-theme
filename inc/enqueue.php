<?php
/**
 * Stylesheets and scripts
 *
 * Loaded in layers: the parent theme, the fonts and style.css on every page; then the
 * section's palette (from donphin_sections(), inc/sections.php) on every page of that
 * section; then whatever the page's own template needs (donphin_template_assets()).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * What each page template needs beyond the site and section styles, as
 * template => array( 'css' => files in assets/css/, 'js' => files in assets/js/ ).
 * A template's CSS loads after its section's palette, so it can use the palette's colours.
 *
 * @return array
 */
function donphin_template_assets() {
	return array(
		'page-speaking.php'                    => array( 'js' => array( 'video', 'count-up' ) ),
		'page-speaking-about.php'              => array( 'css' => array( 'about' ) ),
		'page-speaking-contact.php'            => array( 'css' => array( 'contact' ) ),
		'page-speaking-resources.php'          => array(
			'css' => array( 'resource-library', 'speaking-resources' ),
			'js'  => array( 'resource-library' ),
		),
		'page-counsel-resources.php'           => array(
			'css' => array( 'resource-library', 'counsel-resources' ),
			'js'  => array( 'resource-library' ),
		),
		'page-the-journey.php'                 => array( 'css' => array( 'journey' ) ),
		'page-counsel-about.php'               => array( 'css' => array( 'counsel-about' ) ),
		'page-counsel-contact.php'             => array( 'css' => array( 'contact' ) ),
		'page-thank-you.php'                   => array( 'css' => array( 'contact' ) ),
		'page-purchase-the-40-40-solution.php' => array(
			'css' => array( 'book' ),
			'js'  => array( 'book', 'video' ),
		),
	);
}

/**
 * Enqueue one of the theme's own files, versioned by when it last changed
 *
 * @param string $type 'css' or 'js'.
 * @param string $name File name without the extension, e.g. 'journey'.
 * @param array  $deps Handles it depends on.
 */
function donphin_enqueue_asset( $type, $name, $deps = array() ) {
	$path   = '/assets/' . $type . '/' . $name . '.' . $type;
	$handle = 'donphin-' . $name . ( 'js' === $type ? '-script' : '' );

	if ( 'css' === $type ) {
		wp_enqueue_style( $handle, get_stylesheet_directory_uri() . $path, $deps, donphin_asset_version( $path ) );
	} else {
		wp_enqueue_script( $handle, get_stylesheet_directory_uri() . $path, $deps, donphin_asset_version( $path ), true );
	}
}

/**
 * Enqueue Parent and Child Stylesheets & Scripts
 */
function donphin_enqueue_scripts() {
	// Parent Kadence stylesheet
	wp_enqueue_style(
		'kadence-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'kadence' )->get( 'Version' )
	);

	// Google Fonts: Fraunces (serif, with italics) + Zalando Sans, both variable over weights 400-700.
	// Version is null so WordPress doesn't append ?ver= to the Google Fonts URL.
	wp_enqueue_style(
		'donphin-google-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&family=Zalando+Sans:wght@400..700&display=swap',
		array(),
		null
	);

	// The section's own typefaces, where it has them (its palette stylesheet points the
	// font tokens at them)
	$sections = donphin_sections();
	$section  = $sections[ donphin_get_header_section() ];
	if ( ! empty( $section['fonts'] ) ) {
		wp_enqueue_style( 'donphin-section-fonts', $section['fonts'], array(), null );
	}

	// Font tokens (the only place font families are defined, bar a section's own)
	donphin_enqueue_asset( 'css', 'fonts', array( 'donphin-google-fonts' ) );

	// Child Theme Stylesheet
	wp_enqueue_style(
		'donphin-child-style',
		get_stylesheet_uri(),
		array( 'kadence-parent-style', 'donphin-fonts' ),
		donphin_asset_version( '/style.css' )
	);

	// The header (sticky shadow, mobile menu) and the scroll fade, on every page but the
	// gateway, which has no header and fits on one screen
	if ( ! is_front_page() ) {
		donphin_enqueue_asset( 'js', 'header' );
		donphin_enqueue_asset( 'js', 'reveal' );
	}

	// A soft fade as each page arrives (see inc/page-transitions.php)
	donphin_enqueue_asset( 'js', 'page-transitions' );

	// The section's palette and header colours, on every page of the section
	$stylesheet = $section['stylesheet'];
	$page_deps  = array( 'donphin-child-style' );
	if ( $stylesheet ) {
		donphin_enqueue_asset( 'css', $stylesheet, array( 'donphin-child-style' ) );
		$page_deps = array( 'donphin-' . $stylesheet );
	}

	// What the page's own template needs
	foreach ( donphin_template_assets() as $template => $assets ) {
		if ( ! is_page_template( $template ) ) {
			continue;
		}
		foreach ( isset( $assets['css'] ) ? $assets['css'] : array() as $name ) {
			donphin_enqueue_asset( 'css', $name, $page_deps );
		}
		foreach ( isset( $assets['js'] ) ? $assets['js'] : array() as $name ) {
			donphin_enqueue_asset( 'js', $name );
		}
	}

	// A resource's own page (single-resource.php), in any section's library
	if ( is_singular( donphin_resource_post_types() ) ) {
		donphin_enqueue_asset( 'css', 'resource', $page_deps );
	}

	// The home page and the 404 page aren't page templates
	if ( is_front_page() ) {
		donphin_enqueue_asset( 'css', 'gateway', array( 'donphin-child-style' ) );
	}
	if ( is_404() ) {
		donphin_enqueue_asset( 'css', '404', array( 'donphin-child-style' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'donphin_enqueue_scripts', 20 );

/**
 * Preconnect to Google Fonts so the font files start downloading sooner
 */
function donphin_font_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'donphin_font_resource_hints', 10, 2 );
