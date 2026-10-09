<?php
/**
 * Template Name: HR Tools
 *
 * The HR Tools page (/hr-tools/): Don's library of checklists, forms, posters, videos and
 * books for the workplace, common to everyone and part of neither side. The heading and
 * intro on paper, with how much is there; then the library itself (HR Tools in the admin),
 * with its search and a button for each category. It wears the For You header and the
 * site's own ink and blue (hr-tools.css; the library's layout is resource-library.css).
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

// How much is there, for the line under the intro
$library = donphin_resource_library( 'foryou' );
$tools   = array_sum(
	array_map(
		function ( $category ) {
			return count( $category['items'] );
		},
		$library
	)
);
?>

<section class="dp-hr-hero" aria-labelledby="dp-hr-title">
	<div class="dp-hr-hero-container">
		<p class="dp-hr-label">From Don Phin, Esq.</p>
		<h1 id="dp-hr-title" class="dp-hr-title"><?php echo esc_html( $heading ); ?></h1>
		<?php if ( $intro ) : ?>
			<p class="dp-hr-intro"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>
		<?php if ( $tools ) : ?>
			<ul class="dp-hr-facts">
				<li><strong><?php echo esc_html( number_format_i18n( $tools ) ); ?></strong> tools</li>
				<li><strong><?php echo esc_html( number_format_i18n( count( $library ) ) ); ?></strong> categories</li>
				<li>Free to use</li>
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
