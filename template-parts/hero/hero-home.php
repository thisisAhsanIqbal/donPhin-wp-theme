<?php
/**
 * Template Part: Home Page Hero Component
 *
 * An editorial split. On paper: the headline, Don's one-line idea, the two calls to
 * action and the organisations that have booked him. On a brand-blue panel that runs to
 * the edge of the screen: Don's portrait. The ways to work with Don follow in the
 * Speak / Counsel cards (section-pillars.php).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$youtube = donphin_social_links()['youtube'];
?>

<section class="dp-home-hero" aria-labelledby="dp-home-hero-title">

	<!-- Headline, idea and calls to action -->
	<div class="dp-home-hero-content">
		<p class="dp-home-hero-eyebrow">
			Speaker<span aria-hidden="true">&middot;</span>Author<span aria-hidden="true">&middot;</span>Counsel
		</p>

		<h1 id="dp-home-hero-title" class="dp-home-hero-title">
			<span class="dp-home-hero-line">Forty years on the human side of business.</span>
			<span class="dp-home-hero-line dp-home-hero-accent">Now, the AI side of change.</span>
		</h1>

		<p class="dp-home-hero-description">
			The problem is almost never the problem. It’s the story someone is telling themselves about the problem.
		</p>

		<div class="dp-home-hero-actions">
			<a href="<?php echo esc_url( home_url( '/speaking/contact/' ) ); ?>" class="dp-dark-button">
				Talk to Don
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
			<a href="<?php echo esc_url( $youtube['url'] ); ?>" class="dp-arrow-link" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Watch Don speak on YouTube (opens in a new tab)', 'don-phin-esq' ); ?>">
				Watch Don speak
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</div>
	</div>

	<!-- Organisations that have booked Don -->
	<div class="dp-home-hero-proof">
		<p id="dp-home-hero-proof-label" class="dp-home-hero-proof-label">Trusted by</p>
		<?php get_template_part( 'template-parts/logo-marquee', null, array( 'labelledby' => 'dp-home-hero-proof-label' ) ); ?>
	</div>

	<!-- Portrait, filling the right-hand panel -->
	<div class="dp-home-hero-media">
		<img
			src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/donphin-greenbg.webp' ); ?>"
			alt="Don Phin, Esq., smiling on a tree-lined street"
			class="dp-home-hero-portrait"
			width="1024"
			height="1024"
			fetchpriority="high"
		/>
	</div>

</section>
