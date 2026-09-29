<?php
/**
 * The template for the 404 page
 *
 * Kept deliberately bare: Don on stage behind a big faint 404, his own line about
 * pointing you somewhere better, and one way back.
 *
 * It belongs to whichever section the visitor was in (worked out from the broken
 * address, or from the page they came from; see donphin_get_header_section()), so
 * the header, the colours and the way back all keep them there.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// The way back: this section's home page
$sections = donphin_sections();
$section  = $sections[ donphin_get_header_section() ];
$back_url = home_url( $section['home'] );
$back     = '/' === $section['home'] ? 'Back to the home page' : sprintf( 'Back to %s', ucwords( $section['label'] ) );
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

		<div class="dp-404-actions">
			<a href="<?php echo esc_url( $back_url ); ?>" class="dp-light-button">
				<?php echo esc_html( $back ); ?>
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</div>

	</div>
</section>

<?php
get_footer();
