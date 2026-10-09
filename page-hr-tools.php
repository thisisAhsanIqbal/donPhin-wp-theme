<?php
/**
 * Template Name: HR Tools
 *
 * The HR Tools page (/hr-tools/): Don's library of checklists, forms, posters, videos and
 * books for the workplace, common to everyone and part of neither side. The hero, on the
 * header's frame: the heading, Don's line signed by him, a way down to the tools and how
 * much is there, beside a small stack of pages for the biggest categories (each a way
 * into its list); then the library itself (HR Tools in the admin), with its search and a
 * button for each category. It wears the For You header and the site's own ink and blue
 * (hr-tools.css; the library's layout is resource-library.css).
 * Assign it to a top-level "HR Tools" page (Tools > Move HR Tools creates one). The
 * heading and intro are in the page's "Resource library" box.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$heading = donphin_resource_page_text( get_the_ID(), 'heading', 'foryou' );
$intro   = donphin_resource_page_text( get_the_ID(), 'intro', 'foryou' );

// How much is there, and the biggest categories for the stack of pages beside the words
$library = donphin_resource_library( 'foryou' );
$tools   = array_sum(
	array_map(
		function ( $category ) {
			return count( $category['items'] );
		},
		$library
	)
);
$deck = $library;
usort(
	$deck,
	function ( $a, $b ) {
		return count( $b['items'] ) - count( $a['items'] );
	}
);
$deck = array_slice( $deck, 0, 3 );

// Don's portrait, signing his note
$portrait = get_stylesheet_directory_uri() . '/assets/images/counsel/portrait-640.webp';
?>

<section class="dp-hr-hero" aria-labelledby="dp-hr-title">
	<div class="dp-hr-hero-container">

		<div class="dp-hr-hero-text">
			<p class="dp-hr-label"><span class="dp-hr-label-dot" aria-hidden="true"></span>Free for everyone</p>
			<h1 id="dp-hr-title" class="dp-hr-title"><?php echo esc_html( $heading ); ?></h1>

			<?php if ( $intro ) : ?>
				<figure class="dp-hr-note">
					<blockquote class="dp-hr-intro"><p><?php echo esc_html( $intro ); ?></p></blockquote>
					<figcaption class="dp-hr-signed">
						<img src="<?php echo esc_url( $portrait ); ?>" alt="" width="40" height="40">
						<span>Don Phin, Esq.</span>
					</figcaption>
				</figure>
			<?php endif; ?>

			<?php if ( $tools ) : ?>
				<div class="dp-hr-actions">
					<a class="dp-hr-button" href="#dp-res-library">
						Browse the tools
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
					</a>
					<?php
					// Each figure counts up from zero, slowly, as the page opens (count-up.js); its
					// width is held to the final figure's digits, so nothing shifts as it counts
					$facts = array(
						array( $tools, '', __( 'tools', 'don-phin-esq' ) ),
						array( count( $library ), '', __( 'categories', 'don-phin-esq' ) ),
						array( 100, '%', __( 'free', 'don-phin-esq' ) ),
					);
					?>
					<ul class="dp-hr-facts">
						<?php foreach ( $facts as $fact ) : ?>
							<li>
								<strong><span class="dp-count" data-count="<?php echo esc_attr( $fact[0] ); ?>" data-count-duration="2600" style="--dp-digits: <?php echo esc_attr( strlen( (string) $fact[0] ) ); ?>"><?php echo esc_html( $fact[0] ); ?></span><?php echo esc_html( $fact[1] ); ?></strong>
								<span><?php echo esc_html( $fact[2] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $deck ) : ?>
			<!-- A small stack of pages: the biggest categories, the biggest in front -->
			<ul class="dp-hr-deck" aria-label="<?php esc_attr_e( 'The biggest categories', 'don-phin-esq' ); ?>">
				<?php foreach ( array_reverse( $deck ) as $index => $category ) : ?>
					<li class="dp-hr-card dp-hr-card--<?php echo esc_attr( count( $deck ) - $index ); ?>">
						<a href="<?php echo esc_url( '#dp-lib-' . $category['key'] ); ?>">
							<span class="dp-hr-card-top">
								<span class="dp-hr-card-icon" aria-hidden="true"><?php echo donphin_resource_icon( $category['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?></span>
								<span class="dp-hr-card-tally">
									<span class="dp-hr-card-count"><?php echo esc_html( number_format_i18n( count( $category['items'] ) ) ); ?></span>
									<span class="dp-hr-card-chip"><?php echo esc_html( $category['chip'] ); ?></span>
								</span>
							</span>
							<span class="dp-hr-card-title"><?php echo esc_html( $category['title'] ); ?></span>
							<span class="dp-hr-card-lines" aria-hidden="true"></span>
							<span class="dp-hr-card-more">See them <span aria-hidden="true">&rarr;</span></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>

<?php
// The heading is the hero's, so the library goes straight to its search
get_template_part(
	'template-parts/resource-library',
	null,
	array(
		'side' => 'foryou',
	)
);

get_footer();
