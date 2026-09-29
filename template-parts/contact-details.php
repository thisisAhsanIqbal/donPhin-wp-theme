<?php
/**
 * Template Part: Direct contact details
 *
 * For people who would rather book or call than write: Don's Zoom scheduler, his
 * phone and email, and his social profiles. Shown beside both contact forms.
 * Styles live in assets/css/contact.css.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$socials = donphin_social_links();
?>

<p class="dp-contact-book">
	<a href="https://scheduler.zoom.us/don-phin/30-mins-w-don" class="dp-arrow-link" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Book a Zoom with Don (opens in a new tab)', 'don-phin-esq' ); ?>">
		Book a Zoom
		<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
	</a>
</p>

<address class="dp-contact-details">
	<a href="tel:+16198524580">(619) 852-4580</a>
	<span class="dp-contact-sep" aria-hidden="true">·</span>
	<a href="mailto:don@donphin.com">don@donphin.com</a>
</address>

<ul class="dp-contact-social">
	<?php foreach ( $socials as $key => $social ) : ?>
		<li>
			<a href="<?php echo esc_url( $social['url'] ); ?>" class="dp-contact-social-link dp-contact-social-link--<?php echo esc_attr( $key ); ?>" target="_blank" rel="me noopener" aria-label="<?php echo esc_attr( sprintf( 'Don Phin on %s (opens in a new tab)', $social['label'] ) ); ?>">
				<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="<?php echo esc_attr( $social['path'] ); ?>"/></svg>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
