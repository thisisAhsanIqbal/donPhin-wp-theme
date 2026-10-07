<?php
/**
 * Template Name: Private Counsel — Resources
 *
 * The Resources page for the Private Counsel section (/private-counsel/resources/): the
 * heading and intro on navy, then the section's own library (Counsel Resources in the
 * admin), with its search and category buttons, in the Private Counsel colours.
 * Assign it to a "Resources" page filed under Private Counsel. The heading and intro are
 * in the page's "Resource library" box (the heading is "Resources" until it's changed).
 * It sits on the Private Counsel palette (private-counsel.css), with its layout in
 * counsel-resources.css and the library's in resource-library.css.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$heading = donphin_resource_page_text( get_the_ID(), 'heading', 'counsel' );
$intro   = donphin_resource_page_text( get_the_ID(), 'intro', 'counsel' );
?>

<section class="dp-cr-hero" aria-labelledby="dp-cr-title">
	<div class="dp-cr-hero-container">
		<p class="dp-pc-eyebrow">Private Counsel</p>
		<h1 id="dp-cr-title" class="dp-cr-title"><?php echo esc_html( $heading ); ?></h1>
		<?php if ( $intro ) : ?>
			<p class="dp-cr-intro"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
// The heading is the hero's, so the library goes straight to its search
get_template_part(
	'template-parts/resource-library',
	null,
	array(
		'side' => 'counsel',
	)
);

get_footer();
