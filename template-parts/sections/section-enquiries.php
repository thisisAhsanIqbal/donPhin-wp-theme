<?php
/**
 * Template Part: "Enquiries" CTA Section
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="dp-enquiries-section" aria-label="Enquiries and Consultation">
	<div class="dp-enquiries-container">
		
		<!-- Eyebrow Badge -->
		<div class="dp-enquiries-eyebrow">ENQUIRIES</div>

		<!-- Main Headline Statement -->
		<h2 class="dp-enquiries-headline">
			One conversation is usually enough to know.
		</h2>

		<!-- Body Paragraph -->
		<p class="dp-enquiries-desc">
			If someone referred you here, I would be pleased to learn more about your situation and determine whether we are the right fit.
		</p>

		<!-- Call To Action Button -->
		<div class="dp-enquiries-btn-wrap">
			<a href="<?php echo esc_url( home_url( '/private-counsel/contact/' ) ); ?>" class="dp-enquiries-cta-btn">
				REQUEST A CONVERSATION
			</a>
		</div>

	</div>
</section>
