<?php
/**
 * Don Phin, Esq. Child Theme Functions
 * Parent Theme: Kadence
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Free toolkit sign-ups (home page form)
require_once get_stylesheet_directory() . '/inc/toolkit-signup.php';

// Contact form (contact page)
require_once get_stylesheet_directory() . '/inc/contact-form.php';

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

	// Font tokens (the only place font families are defined)
	wp_enqueue_style(
		'donphin-fonts',
		get_stylesheet_directory_uri() . '/assets/css/fonts.css',
		array( 'donphin-google-fonts' ),
		donphin_asset_version( '/assets/css/fonts.css' )
	);

	// Child Theme Stylesheet
	wp_enqueue_style(
		'donphin-child-style',
		get_stylesheet_uri(),
		array( 'kadence-parent-style', 'donphin-fonts' ),
		donphin_asset_version( '/style.css' )
	);

	// Child Theme Header JS
	wp_enqueue_script(
		'donphin-header-script',
		get_stylesheet_directory_uri() . '/assets/js/header.js',
		array(),
		donphin_asset_version( '/assets/js/header.js' ),
		true
	);

	// Fades content in as it scrolls into view
	wp_enqueue_script(
		'donphin-reveal-script',
		get_stylesheet_directory_uri() . '/assets/js/reveal.js',
		array(),
		donphin_asset_version( '/assets/js/reveal.js' ),
		true
	);

	// Dedicated Stylesheet for Private Counsel Page (Zero clutter in style.css)
	if ( is_page_template( 'page-private-counsel.php' ) || is_page( array( 'private-counsel', 'counsel' ) ) || ( isset( $_GET['header'] ) && 'counsel' === $_GET['header'] ) ) {
		wp_enqueue_style(
			'donphin-private-counsel',
			get_stylesheet_directory_uri() . '/assets/css/private-counsel.css',
			array( 'donphin-child-style' ),
			donphin_asset_version( '/assets/css/private-counsel.css' )
		);
	}

	// Dedicated Stylesheet for the Contact and Thank You pages
	if ( is_page_template( array( 'page-contact.php', 'page-thank-you.php' ) ) || is_page( array( 'contact', 'thank-you' ) ) ) {
		wp_enqueue_style(
			'donphin-contact',
			get_stylesheet_directory_uri() . '/assets/css/contact.css',
			array( 'donphin-child-style' ),
			donphin_asset_version( '/assets/css/contact.css' )
		);
	}

	// Dedicated Stylesheet and behaviour for the book page
	if ( is_page_template( 'page-purchase-the-40-40-solution.php' ) || is_page( 'purchase-the-40-40-solution' ) ) {
		wp_enqueue_style(
			'donphin-book',
			get_stylesheet_directory_uri() . '/assets/css/book.css',
			array( 'donphin-child-style' ),
			donphin_asset_version( '/assets/css/book.css' )
		);

		// Testimonial slider
		wp_enqueue_script(
			'donphin-book-script',
			get_stylesheet_directory_uri() . '/assets/js/book.js',
			array(),
			donphin_asset_version( '/assets/js/book.js' ),
			true
		);
	}

	// Dedicated Stylesheet for the About page
	if ( is_page_template( 'page-about.php' ) || is_page( 'about' ) ) {
		wp_enqueue_style(
			'donphin-about',
			get_stylesheet_directory_uri() . '/assets/css/about.css',
			array( 'donphin-child-style' ),
			donphin_asset_version( '/assets/css/about.css' )
		);
	}

	// Dedicated Stylesheet for the Speaking page
	if ( is_page_template( 'page-speaking.php' ) || is_page( 'speaking' ) ) {
		wp_enqueue_style(
			'donphin-speaking',
			get_stylesheet_directory_uri() . '/assets/css/speaking.css',
			array( 'donphin-child-style' ),
			donphin_asset_version( '/assets/css/speaking.css' )
		);
	}

	// Shared video facade: loads the YouTube player only when someone presses play
	if ( is_page_template( array( 'page-purchase-the-40-40-solution.php', 'page-speaking.php' ) ) || is_page( array( 'purchase-the-40-40-solution', 'speaking' ) ) ) {
		wp_enqueue_script(
			'donphin-video',
			get_stylesheet_directory_uri() . '/assets/js/video.js',
			array(),
			donphin_asset_version( '/assets/js/video.js' ),
			true
		);
	}

	// Dedicated Stylesheet for the 404 page
	if ( is_404() ) {
		wp_enqueue_style(
			'donphin-404',
			get_stylesheet_directory_uri() . '/assets/css/404.css',
			array( 'donphin-child-style' ),
			donphin_asset_version( '/assets/css/404.css' )
		);
	}

	// Dedicated Stylesheet for the Home Page
	if ( is_front_page() ) {
		wp_enqueue_style(
			'donphin-home',
			get_stylesheet_directory_uri() . '/assets/css/home.css',
			array( 'donphin-child-style' ),
			donphin_asset_version( '/assets/css/home.css' )
		);

		// Home page behaviour (testimonial tabs)
		wp_enqueue_script(
			'donphin-home-script',
			get_stylesheet_directory_uri() . '/assets/js/home.js',
			array(),
			donphin_asset_version( '/assets/js/home.js' ),
			true
		);
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
 * file's own width and height (so the row doesn't shift as the logos load).
 * Shown in the logo marquee (template-parts/logo-marquee.php).
 */
function donphin_client_logos() {
	return array(
		array( 'Vistage', 'vistage-logo.svg', 603, 116 ),
		array( 'SHRM', 'SHRM-logo.svg', 605, 346 ),
		array( 'ADP', 'adp-logo.svg', 2500, 1140 ),
		array( 'BASF', 'basf-logo.svg', 138, 29 ),
		array( 'EMC', 'emc-logo.svg', 219, 77 ),
		array( 'Avetta', 'avetta-logo.svg', 196, 30 ),
	);
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


/**
 * Which site section the current request belongs to: 'foryou', 'counsel' or 'speaking'.
 * Picks the active header tab, the header menu and the body class.
 */
function donphin_get_header_section() {
	$aliases = array(
		'foryou'          => 'foryou',
		'for-you'         => 'foryou',
		'counsel'         => 'counsel',
		'private-counsel' => 'counsel',
		'speaking'        => 'speaking',
	);

	// 1. URL override for previewing (e.g. ?header=counsel)
	if ( isset( $_GET['header'] ) ) {
		$requested = sanitize_key( wp_unslash( $_GET['header'] ) );
		if ( isset( $aliases[ $requested ] ) ) {
			return $aliases[ $requested ];
		}
	}

	// 2. Per-page choice from the "Header Section" meta box
	if ( is_singular() ) {
		$chosen = get_post_meta( get_the_ID(), '_donphin_header_section', true );
		if ( isset( $aliases[ $chosen ] ) ) {
			return $aliases[ $chosen ];
		}

		// The old two-header meta box saved 'speaking' as its default, so only 'counsel' was a real choice
		$legacy = get_post_meta( get_the_ID(), '_donphin_header_type', true );
		if ( empty( $legacy ) ) {
			$legacy = get_post_meta( get_the_ID(), 'header_type', true );
		}
		if ( in_array( $legacy, array( 'counsel', 'private-counsel' ), true ) ) {
			return 'counsel';
		}
	}

	// 3. Section pages by template or slug
	if ( is_page_template( 'page-private-counsel.php' ) || is_page( array( 'private-counsel', 'counsel', 'the-journey', 'journey', 'for-advisors', 'advisors' ) ) ) {
		return 'counsel';
	}
	if ( is_page_template( 'page-speaking.php' ) || is_page( 'speaking' ) ) {
		return 'speaking';
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
 * Add Header Section Meta Box to Pages & Posts
 */
function donphin_add_header_meta_box() {
	$screens = array( 'page', 'post' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'donphin_header_meta',
			__( 'Header Section', 'don-phin-esq' ),
			'donphin_header_meta_box_callback',
			$screen,
			'side',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'donphin_add_header_meta_box' );

/**
 * Render Header Section Meta Box
 */
function donphin_header_meta_box_callback( $post ) {
	wp_nonce_field( 'donphin_save_header_meta', 'donphin_header_nonce' );
	$current_section = get_post_meta( $post->ID, '_donphin_header_section', true );
	if ( empty( $current_section ) && 'counsel' === get_post_meta( $post->ID, '_donphin_header_type', true ) ) {
		$current_section = 'counsel';
	}
	?>
	<p>
		<label for="donphin_header_section"><strong><?php esc_html_e( 'Section for this Page:', 'don-phin-esq' ); ?></strong></label>
	</p>
	<select name="donphin_header_section" id="donphin_header_section" style="width: 100%; padding: 6px;">
		<option value="" <?php selected( $current_section, '' ); ?>>
			<?php esc_html_e( 'Automatic', 'don-phin-esq' ); ?>
		</option>
		<option value="foryou" <?php selected( $current_section, 'foryou' ); ?>>
			<?php esc_html_e( 'For You', 'don-phin-esq' ); ?>
		</option>
		<option value="counsel" <?php selected( $current_section, 'counsel' ); ?>>
			<?php esc_html_e( 'Private Counsel', 'don-phin-esq' ); ?>
		</option>
		<option value="speaking" <?php selected( $current_section, 'speaking' ); ?>>
			<?php esc_html_e( 'Speaking', 'don-phin-esq' ); ?>
		</option>
	</select>
	<p class="description" style="margin-top: 8px;">
		<?php esc_html_e( 'Sets the highlighted header tab and the header menu. Automatic uses Private Counsel on the Private Counsel pages, Speaking on /speaking/, and For You everywhere else.', 'don-phin-esq' ); ?>
	</p>
	<?php
}

/**
 * Save Header Meta Box Selection
 */
function donphin_save_header_meta( $post_id ) {
	if ( ! isset( $_POST['donphin_header_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['donphin_header_nonce'] ), 'donphin_save_header_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['donphin_header_section'] ) ) {
		$selected = sanitize_key( wp_unslash( $_POST['donphin_header_section'] ) );
		if ( in_array( $selected, array( 'foryou', 'counsel', 'speaking' ), true ) ) {
			update_post_meta( $post_id, '_donphin_header_section', $selected );
		} else {
			delete_post_meta( $post_id, '_donphin_header_section' );
		}
		// The new setting replaces the old two-header one
		delete_post_meta( $post_id, '_donphin_header_type' );
	}
}
add_action( 'save_post', 'donphin_save_header_meta' );
