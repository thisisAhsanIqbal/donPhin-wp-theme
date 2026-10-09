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
	'redirects-admin',  // Tools > Old Addresses: every redirect, where it leads, and forgetting old ones
	'robots',           // robots.txt: AI assistants may read the site even while search engines are kept out
	'page-transitions', // A soft fade as each page arrives (the fade is in style.css)
	'header-meta-box',  // The "Header Section" box on the page screen
	'contact-form',     // The Speaking and Private Counsel contact forms
	'toolkit-signup',   // Free toolkit sign-ups (home page form)
	'resources',        // Each section's resources (Speaking Resources in the admin), with a page each
	'resources-admin',  // Their admin: the document or link, category settings, the starter import
	'resources-split',  // Counsel Resources > Set up from Speaking: the one library split into each side's
	'blog',             // Each section's own blog (Speaking Blog in the admin): its list, posts and categories
);

foreach ( $donphin_modules as $donphin_module ) {
	require_once get_stylesheet_directory() . '/inc/' . $donphin_module . '.php';
}
unset( $donphin_modules, $donphin_module );
