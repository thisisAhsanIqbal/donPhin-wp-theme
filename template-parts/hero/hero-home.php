<?php
/**
 * Template Part: Home Page Hero Component
 *
 * An editorial split. On paper: the headline, the two ways to work with Don (the stage
 * and the journey) straight under it as the only calls to action, and Don's one-line
 * idea. Beside it, running to the edge of the screen: Don's portrait. The ways to work with Don follow in the
 * Speak / Counsel cards (section-pillars.php).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The two ways to work with Don, straight under the headline: each section's home,
// with one short line about who it is for. They are the hero's only calls to action:
// the gateway's job is to send each visitor to the right side first.
$sections = donphin_sections();
$doors    = array(
	'speaking' => array( 'Keynote Speaker', 'For sales leaders and conferences.' ),
	'counsel'  => array( 'Private Counsel', 'For successful men ready for what comes next.' ),
);
?>

<section class="dp-home-hero" aria-labelledby="dp-home-hero-title">

	<!-- Headline, the two doors and Don's idea -->
	<div class="dp-home-hero-content">
		<p class="dp-home-hero-eyebrow">
			Speaker<span aria-hidden="true">&middot;</span>Author<span aria-hidden="true">&middot;</span>Counsel
		</p>

		<h1 id="dp-home-hero-title" class="dp-home-hero-title">
			<span class="dp-home-hero-line">Forty years on the human side of business.</span>
			<span class="dp-home-hero-line dp-home-hero-accent">Take the stage, or take the journey.</span>
		</h1>

		<!-- The two doors: the stage (Speaking) and the journey (Private Counsel) -->
		<ul class="dp-home-hero-doors" aria-label="<?php esc_attr_e( 'Two ways to work with Don', 'don-phin-esq' ); ?>">
			<?php foreach ( $doors as $key => $door ) : ?>
				<li>
					<a href="<?php echo esc_url( home_url( $sections[ $key ]['home'] ) ); ?>" class="dp-home-hero-door dp-home-hero-door--<?php echo esc_attr( $key ); ?>">
						<span class="dp-home-hero-door-name">
							<?php echo esc_html( $door[0] ); ?>
							<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
						</span>
						<span class="dp-home-hero-door-line"><?php echo esc_html( $door[1] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<p class="dp-home-hero-description">
			The problem is almost never the problem. It’s the story someone is telling themselves about the problem.
		</p>
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
