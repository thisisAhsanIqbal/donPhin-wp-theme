<?php
/**
 * Don Phin, Esq. Child Theme Functions
 * Parent Theme: Kadence
 *
 * This file only loads the theme's modules, each in inc/ and each about one thing.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$donphin_modules = array(
	'helpers',          // Asset versioning, social profiles, client logos, icons
	'sections',         // The site's sections (For You, Private Counsel, Speaking): menus, detection, body class
	'enqueue',          // Stylesheets and scripts, by section and by page template
	'redirects',        // Old and shorthand addresses, sent on to where the pages live now
	'page-transitions', // A soft fade as each page arrives (the fade is in style.css)
	'header-meta-box',  // The "Header Section" box on the page screen
	'contact-form',     // The Speaking and Private Counsel contact forms
	'toolkit-signup',   // Free toolkit sign-ups (home page form)
);

foreach ( $donphin_modules as $donphin_module ) {
	require_once get_stylesheet_directory() . '/inc/' . $donphin_module . '.php';
}
unset( $donphin_modules, $donphin_module );
