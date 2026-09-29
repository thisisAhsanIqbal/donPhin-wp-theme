<?php
/**
 * Template part: Site Header
 *
 * One white bar: logo, menu and button. Each side of the site keeps to itself: there
 * are no tabs to the other side, and the logo leads to this section's own home.
 * $args['section'] (a key of donphin_sections(): 'foryou', 'counsel' or 'speaking') picks
 * the menu, the button and the logo's link; the menu and button come from the menu
 * assigned to the section in Appearance > Menus, or the registry (inc/sections.php).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sections = donphin_sections();
$section  = isset( $args['section'], $sections[ $args['section'] ] ) ? $args['section'] : 'foryou';
$menu     = donphin_section_menu( $section );
?>
<header id="dp-site-header" class="dp-header dp-header--<?php echo esc_attr( $section ); ?>" role="banner">

	<!-- Main bar: logo, menu + CTA (the menu becomes the mobile drawer) -->
	<div class="dp-mainbar">
		<div class="dp-header-inner">
			<a href="<?php echo esc_url( home_url( $sections[ $section ]['home'] ) ); ?>" class="dp-logo">
				<span class="dp-logo-accent">Don Phin,</span> Esq.
			</a>

			<nav class="dp-nav" id="dp-site-nav" aria-label="<?php esc_attr_e( 'Main', 'don-phin-esq' ); ?>">
				<ul class="dp-nav-list">
					<?php foreach ( $menu['links'] as $link ) : ?>
						<li>
							<a href="<?php echo esc_url( $link[1] ); ?>" class="dp-nav-link"<?php echo '' !== $link[2] ? ' aria-label="' . esc_attr( $link[2] ) . '"' : ''; ?>><?php echo esc_html( $link[0] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<a href="<?php echo esc_url( $menu['cta'][1] ); ?>" class="dp-cta-btn">
					<?php echo donphin_icon( $menu['cta'][2], 'dp-cta-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput -- the theme's own SVG file ?>
					<span><?php echo esc_html( $menu['cta'][0] ); ?></span>
				</a>
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
