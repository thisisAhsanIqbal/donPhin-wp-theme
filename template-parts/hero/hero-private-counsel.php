<?php
/**
 * Template Part: Private Counsel Hero Component
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="dp-counsel-hero" aria-label="Private Counsel Overview">
	<div class="dp-counsel-hero-container">
		
		<!-- Left Content Column -->
		<div class="dp-counsel-hero-content">
			<div class="dp-hero-eyebrow">PRIVATE COUNSEL</div>
			
			<h1 class="dp-hero-headline">
				You've built the wealth, <span class="dp-hero-gold-italic">now is the opportunity</span> to build the life it was supposed to make possible.
			</h1>

			<p class="dp-hero-description">
				I work privately with three good men at a time for one year to help them become as intentional about the rest of their lives as they were about building their wealth.
			</p>

			<!-- Trust Badges with SVG Diamond Separators -->
			<div class="dp-hero-badges" aria-label="Core Principles">
				<span class="dp-badge-item">PERSONAL</span>
				<span class="dp-badge-separator" aria-hidden="true">
					<svg width="6" height="6" viewBox="0 0 24 24" fill="currentColor">
						<path d="M12 2L22 12L12 22L2 12L12 2Z"/>
					</svg>
				</span>
				<span class="dp-badge-item">CONFIDENTIAL</span>
				<span class="dp-badge-separator" aria-hidden="true">
					<svg width="6" height="6" viewBox="0 0 24 24" fill="currentColor">
						<path d="M12 2L22 12L12 22L2 12L12 2Z"/>
					</svg>
				</span>
				<span class="dp-badge-item">FULLY PRESENT</span>
			</div>

			<!-- Core Philosophy Mantra -->
			<div class="dp-hero-mantra">
				<p>&ldquo;This isn't about having more &mdash;<br>it's counsel for what matters most.&rdquo;</p>
			</div>
		</div>

		<!-- Right Image Column (Flush to top, right, bottom with overlay text) -->
		<div class="dp-counsel-hero-media">
			<div class="dp-hero-media-wrapper">
				<img 
					src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/DOnPhil.webp' ); ?>" 
					alt="Don Phin, Esq. - Private Counsel, Confidant, Guide" 
					class="dp-hero-portrait-full"
				/>
				<!-- Caption Overlay Directly on the Image -->
				<div class="dp-hero-image-overlay">
					<div class="dp-caption-title">Don Phin, Esq.</div>
					<div class="dp-caption-role">COUNSEL &middot; CONFIDANT &middot; GUIDE</div>
				</div>
			</div>
		</div>

	</div>
</section>
