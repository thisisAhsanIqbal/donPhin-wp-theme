<?php
/**
 * Template Part: "A Gift From Don" Book Gift Section
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="dp-giftbook-section" aria-label="A Gift From Don - Complimentary Book">
	<div class="dp-giftbook-container">
		<div class="dp-giftbook-card">
			
			<!-- Left: Book Visual with Grounding Depth -->
			<div class="dp-giftbook-visual">
				<div class="dp-giftbook-visual-inner">
					<img 
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/40-40book.png' ); ?>" 
						alt="The 40|40 Solution by Don Phin, Esq." 
						class="dp-giftbook-img"
						loading="lazy"
					/>
					<div class="dp-giftbook-ground-shadow" aria-hidden="true"></div>
				</div>
			</div>

			<!-- Right: Intimate Executive Invitation Content -->
			<div class="dp-giftbook-content">
				<div class="dp-giftbook-badge-row">
					<span class="dp-giftbook-eyebrow">A COMPLIMENTARY GIFT</span>
					<span class="dp-giftbook-diamond">◇</span>
					<span class="dp-giftbook-sub-eyebrow">FROM DON PHIN, ESQ.</span>
				</div>

				<h3 class="dp-giftbook-title">
					The 40 <span class="dp-giftbook-divider">|</span> 40 Solution
				</h3>

				<p class="dp-giftbook-subtitle">
					Mastering emotional energy in leadership, relationships, and life.
				</p>

				<p class="dp-giftbook-note">
					“If you are exploring whether private counsel is the right fit, I would be pleased to send you a complimentary copy and mail it to you personally.”
				</p>

				<div class="dp-giftbook-action-wrap">
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="dp-giftbook-cta-btn">
						REQUEST YOUR COPY
					</a>
					<span class="dp-giftbook-delivery-tag">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<rect x="1" y="3" width="15" height="13"></rect>
							<polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
							<circle cx="5.5" cy="18.5" r="2.5"></circle>
							<circle cx="18.5" cy="18.5" r="2.5"></circle>
						</svg>
						Complimentary &bull; Mailed directly to you
					</span>
				</div>
			</div>

		</div>
	</div>
</section>
