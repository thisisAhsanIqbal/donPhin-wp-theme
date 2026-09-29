<?php
/**
 * The template for the 404 page
 *
 * Kept deliberately bare: Don on stage behind a big faint 404, his own line about
 * pointing you somewhere better, and one way back.
 *
 * It belongs to whichever section the visitor was in (worked out from the broken
 * address, or from the page they came from; see donphin_get_header_section()), so
 * the header, the colours and the way back all keep them there. Someone who arrived
 * from nowhere in particular is offered each section (from their taglines in
 * donphin_sections()) to pick from.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// The way back: this section's home page
$sections    = donphin_sections();
$section_key = donphin_get_header_section();
$section     = $sections[ $section_key ];
$back_url    = home_url( $section['home'] );
$back        = '/' === $section['home'] ? 'Back to the home page' : sprintf( 'Back to %s', ucwords( $section['label'] ) );

// Someone who arrived from nowhere in particular (For You) is offered each section
// instead, so they can pick the side of the site they came for
$paths = array();
if ( 'foryou' === $section_key ) {
	foreach ( $sections as $key => $candidate ) {
		if ( 'foryou' !== $key && '' !== $candidate['tagline'] ) {
			$paths[ $key ] = $candidate;
		}
	}
}
?>

<section class="dp-404" aria-labelledby="dp-404-title">
	<div class="dp-404-container">

		<p class="dp-404-eyebrow">Page not found</p>

		<h1 id="dp-404-title" class="dp-404-title">
			<span class="dp-404-line">I can’t help you with this page.</span>
			<em class="dp-404-line dp-404-accent">But I can point you somewhere better.</em>
		</h1>

		<p class="dp-404-text">
			That’s roughly what I tell half the people who call me. This link is broken or the page moved on. The good stuff is still here.
		</p>

		<?php if ( $paths ) : ?>

			<!-- Two ways in: pick the side of the site you came for -->
			<ul class="dp-404-paths" aria-label="<?php esc_attr_e( 'Where would you like to go?', 'don-phin-esq' ); ?>">
				<?php foreach ( $paths as $key => $path ) : ?>
					<li>
						<a href="<?php echo esc_url( home_url( $path['home'] ) ); ?>" class="dp-404-path dp-404-path--<?php echo esc_attr( $key ); ?>">
							<span class="dp-404-path-name">
								<?php echo esc_html( ucwords( $path['label'] ) ); ?>
								<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
							</span>
							<span class="dp-404-path-line"><?php echo esc_html( $path['tagline'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<a href="<?php echo esc_url( $back_url ); ?>" class="dp-arrow-link dp-404-home">
				<?php echo esc_html( $back ); ?>
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>

		<?php else : ?>

			<div class="dp-404-actions">
				<a href="<?php echo esc_url( $back_url ); ?>" class="dp-light-button">
					<?php echo esc_html( $back ); ?>
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</div>

		<?php endif; ?>

	</div>
</section>

<?php
get_footer();
