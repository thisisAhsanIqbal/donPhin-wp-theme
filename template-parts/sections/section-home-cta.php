<?php
/**
 * Template Part: Home Closing Call to Action
 *
 * Centred close on paper: a small quarter-hour ring, the headline, the invitation,
 * the "Book a conversation" button, and Don's direct contact line.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="dp-home-cta" aria-labelledby="dp-home-cta-title">
	<div class="dp-home-cta-container">

		<!-- Decorative: a clock ring with a quarter hour marked -->
		<svg class="dp-home-cta-ring" viewBox="0 0 100 100" aria-hidden="true" focusable="false">
			<circle cx="50" cy="50" r="44" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.18"/>
			<path d="M50 6 A44 44 0 0 1 94 50" fill="none" class="dp-home-cta-ring-accent" stroke="#1F6BE0" stroke-width="3" stroke-linecap="round"/>
			<line x1="50" y1="50" x2="50" y2="22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
			<line x1="50" y1="50" x2="72" y2="50" class="dp-home-cta-ring-accent" stroke="#1F6BE0" stroke-width="2" stroke-linecap="round"/>
			<circle cx="50" cy="50" r="3" fill="currentColor"/>
		</svg>

		<h2 id="dp-home-cta-title" class="dp-home-cta-title">
			<span class="dp-home-cta-line">Fifteen minutes will tell you</span>
			<em class="dp-home-cta-line dp-home-cta-accent">everything.</em>
		</h2>

		<p class="dp-home-cta-text">
			Booking a speaker or considering private counsel — it all starts the same way. Tell me what’s going on. If I’m the right person, you’ll know fast. If I’m not, I probably know who is.
		</p>

		<a href="<?php echo esc_url( home_url( '/speaking/contact/' ) ); ?>" class="dp-dark-button dp-home-cta-button">
			Book a conversation
			<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
		</a>

		<p class="dp-home-cta-contact">
			<span class="dp-home-cta-pair">
				<a href="tel:+16198524580">(619) 852-4580</a>
				<span class="dp-home-cta-sep" aria-hidden="true">·</span>
				<a href="mailto:don@donphin.com">don@donphin.com</a>
			</span>
			<span class="dp-home-cta-sep dp-home-cta-sep--place" aria-hidden="true">·</span>
			<span>Based in Florida, works everywhere</span>
		</p>

	</div>
</section>
