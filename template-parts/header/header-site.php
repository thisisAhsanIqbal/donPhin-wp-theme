<?php
/**
 * Template part: Site Header
 *
 * A dark top bar (section tabs + social links) over a white main bar (logo, menu, CTA).
 * $args['section'] ('foryou', 'counsel' or 'speaking') picks the active tab, the menu and the CTA.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = isset( $args['section'] ) ? $args['section'] : 'foryou';

$tabs = array(
	'foryou'   => array( 'For You', '/' ),
	'counsel'  => array( 'Private counsel', '/private-counsel/' ),
	'speaking' => array( 'Speaking', '/speaking/' ),
);

// Menu links are array( label, path, optional screen reader label )
$menus = array(
	'foryou'   => array(
		'links' => array(
			array( 'About', '/about/' ),
			array( "40| |40", '/purchase-the-40-40-solution/', 'The 40|40 Solution' ),
			array( 'Tools', '/free-tools/' ),
			array( 'Contact', '/contact/' ),
		),
		'cta'   => array( 'Book Don', '/contact/' ),
	),
	'counsel'  => array(
		'links' => array(
			array( 'The Journey', '/the-journey/' ),
			array( 'About', '/about/' ),
			array( 'Resources', '/resources/' ),
			array( 'Contact', '/contact/?topic=counsel' ),
		),
		'cta'   => array( 'Request A Conversation', '/contact/?topic=counsel' ),
	),
	'speaking' => array(
		'links' => array(
			array( 'Speaking', '/speaking/' ),
			array( 'About', '/about/' ),
			array( 'Resources', '/resources/' ),
			array( 'Contact', '/contact/' ),
		),
		'cta'   => array( 'Book Don', '/contact/' ),
	),
);

$socials = donphin_social_links();

$menu = isset( $menus[ $section ] ) ? $menus[ $section ] : $menus['foryou'];
?>
<header id="dp-site-header" class="dp-header dp-header--<?php echo esc_attr( $section ); ?>" role="banner">

	<!-- Top bar: section tabs + social links -->
	<div class="dp-topbar">
		<div class="dp-header-inner">
			<nav class="dp-topbar-tabs" aria-label="<?php esc_attr_e( 'Site sections', 'don-phin-esq' ); ?>">
				<ul class="dp-tab-list">
					<?php foreach ( $tabs as $key => $tab ) : ?>
						<li>
							<a href="<?php echo esc_url( home_url( $tab[1] ) ); ?>" class="dp-tab<?php echo $key === $section ? ' is-active' : ''; ?>"<?php echo $key === $section ? ' aria-current="true"' : ''; ?>><?php echo esc_html( $tab[0] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<ul class="dp-social-list">
				<?php foreach ( $socials as $key => $social ) : ?>
					<li>
						<a href="<?php echo esc_url( $social['url'] ); ?>" class="dp-social-link dp-social-link--<?php echo esc_attr( $key ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( sprintf( 'Don Phin on %s (opens in a new tab)', $social['label'] ) ); ?>">
							<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="<?php echo esc_attr( $social['path'] ); ?>"/></svg>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<!-- Main bar: logo, menu + CTA (the menu becomes the mobile drawer) -->
	<div class="dp-mainbar">
		<div class="dp-header-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="dp-logo">
				<span class="dp-logo-accent">Don Phin,</span> Esq.
			</a>

			<nav class="dp-nav" id="dp-site-nav" aria-label="<?php esc_attr_e( 'Main', 'don-phin-esq' ); ?>">
				<ul class="dp-nav-list">
					<?php foreach ( $menu['links'] as $link ) : ?>
						<li>
							<a href="<?php echo esc_url( home_url( $link[1] ) ); ?>" class="dp-nav-link"<?php echo isset( $link[2] ) ? ' aria-label="' . esc_attr( $link[2] ) . '"' : ''; ?>><?php echo esc_html( $link[0] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<a href="<?php echo esc_url( home_url( $menu['cta'][1] ) ); ?>" class="dp-cta-btn"><?php echo esc_html( $menu['cta'][0] ); ?></a>
			</nav>

			<button class="dp-mobile-toggle" type="button" aria-label="<?php esc_attr_e( 'Toggle navigation', 'don-phin-esq' ); ?>" aria-controls="dp-site-nav" aria-expanded="false">
				<svg class="dp-icon-hamburger" width="30" height="30" viewBox="0 0 64 64" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<rect x="1" y="12" width="41" height="6" rx="0.5"/>
					<rect x="1" y="29" width="62" height="6" rx="0.5"/>
					<rect x="22" y="46" width="41" height="6" rx="0.5"/>
				</svg>
				<svg class="dp-icon-close" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		</div>
	</div>

</header>
