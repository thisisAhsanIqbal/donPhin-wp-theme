<?php
/**
 * Template Name: Thank You Page
 *
 * Used automatically by the page with the slug "thank-you". People land here after
 * sending the contact form, and are greeted by name.
 *
 * The name comes from a one-time note the server left for this visitor
 * (see inc/contact-form.php), so it cannot be faked through the address bar.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Nothing to index here, and nothing worth sharing
add_filter( 'wp_robots', 'wp_robots_no_robots' );

$name = '';

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- reading a one-time token, not acting on it
$token = isset( $_GET['ref'] ) ? sanitize_text_field( wp_unslash( $_GET['ref'] ) ) : '';

if ( $token ) {
	$stored = get_transient( 'dp_thanks_' . $token );

	if ( is_string( $stored ) && '' !== $stored ) {
		$name = $stored;
		// One greeting per message; a refresh shows the plain version
		delete_transient( 'dp_thanks_' . $token );
	}
}

get_header();
?>

<section class="dp-thanks" aria-labelledby="dp-thanks-title">
	<div class="dp-thanks-container">

		<p class="dp-thanks-eyebrow">Message received</p>

		<h1 id="dp-thanks-title" class="dp-thanks-title">
			<span class="dp-thanks-line">
				<?php
				if ( $name ) {
					printf( 'Thank you, %s.', esc_html( $name ) );
				} else {
					echo 'Thank you.';
				}
				?>
			</span>
			<em class="dp-thanks-line dp-thanks-accent">I’ll be in touch.</em>
		</h1>

		<p class="dp-thanks-text">
			Your message is with me now. If I’m the right person, you’ll know fast. If I’m not, I’ll point you somewhere better.
		</p>

		<div class="dp-thanks-actions">
			<?php
			// Back to the side they wrote from (the form sends them here with ?header=...), never the gateway
			$section = donphin_sections()[ donphin_get_header_section() ];
			?>
			<a href="<?php echo esc_url( home_url( $section['home'] ) ); ?>" class="dp-dark-button">
				<?php echo esc_html( '/' === $section['home'] ? 'Back to the home page' : sprintf( 'Back to %s', ucwords( $section['label'] ) ) ); ?>
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>

			<a href="https://scheduler.zoom.us/don-phin/30-mins-w-don" class="dp-arrow-link" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Book a Zoom with Don (opens in a new tab)', 'don-phin-esq' ); ?>">
				Book a Zoom
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</div>

	</div>
</section>

<?php
get_footer();
