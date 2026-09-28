<?php
/**
 * Template Part: 5 Dimensions of Life (Open Gold Continuum)
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pillars = array(
	'WEALTH',
	'PURPOSE',
	'HEALTH',
	'RELATIONSHIPS',
	'SPIRIT',
);
?>

<section class="dp-continuum-section" aria-label="Whole-Life Intention Continuum">
	<div class="dp-continuum-container">
		
		<!-- Thought-Provoking Lead Question -->
		<div class="dp-continuum-header">
			<blockquote class="dp-continuum-quote">
				&ldquo;You've been extraordinarily intentional about building one dimension of your life. <br class="dp-quote-break">What might happen if you brought that same intention to the others?&rdquo;
			</blockquote>
		</div>

		<!-- Open Gold Continuum Line & Diamond Nodes -->
		<div class="dp-continuum-track">
			<div class="dp-continuum-line" aria-hidden="true"></div>
			
			<div class="dp-continuum-nodes">
				<?php foreach ( $pillars as $pillar ) : ?>
					<div class="dp-continuum-node">
						<div class="dp-node-diamond" aria-hidden="true">
							<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
								<path d="M12 2L22 12L12 22L2 12L12 2Z"/>
							</svg>
						</div>
						<span class="dp-node-label"><?php echo esc_html( $pillar ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

	</div>
</section>
