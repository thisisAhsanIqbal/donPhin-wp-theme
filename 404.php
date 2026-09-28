<?php
/**
 * The template for the 404 page
 *
 * Kept deliberately bare: Don on stage behind a big faint 404, his own line about
 * pointing you somewhere better, and one way back.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
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
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="dp-light-button">
				Back to the home page
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</div>

	</div>
</section>

<?php
get_footer();
