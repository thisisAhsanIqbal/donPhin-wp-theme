<?php
/**
 * Template Part: Photo Slider
 *
 * Full-width strip of session photos: three across on desktop, one on phones,
 * no gaps. It scrolls sideways on its own; assets/js/home.js adds the arrows,
 * the pause button and the auto-advance.
 *
 * Pictures come from assets/images/sliderImgs/web/ (WebP copies of the originals
 * in the folder above, cropped to 4:3).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slides = array(
	array( 'slide-01', 'A Vistage group wearing red clown noses during one of Don’s sessions' ),
	array( 'slide-02', 'Don Phin with two colleagues after a session' ),
	array( 'slide-03', 'Don Phin with a member in a Vistage Florida jacket' ),
	array( 'slide-04', 'Don Phin and the film crew holding a “that’s a wrap” clapperboard' ),
	array( 'slide-05', 'Don Phin and a production team on a green-screen set' ),
	array( 'slide-06', 'Don Phin and a colleague wearing red clown noses' ),
	array( 'slide-07', 'A monitor showing Don Phin filming on a green-screen set' ),
	array( 'slide-08', 'Don Phin with a colleague at LinkedIn Learning' ),
	array( 'slide-09', 'Don Phin and the crew at the end of a filming day' ),
	array( 'slide-10', 'Don Phin with a panel on a studio set' ),
);

$images = get_stylesheet_directory_uri() . '/assets/images/sliderImgs/web/';
?>

<section class="dp-slider" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Photos from Don’s sessions', 'don-phin-esq' ); ?>">

	<ul class="dp-slider-track" tabindex="0" role="group" aria-label="<?php esc_attr_e( 'Photos, scrolls sideways', 'don-phin-esq' ); ?>">
		<?php foreach ( $slides as $slide ) : ?>
			<li class="dp-slide">
				<img
					src="<?php echo esc_url( $images . $slide[0] . '-1200.webp' ); ?>"
					srcset="<?php echo esc_attr( $images . $slide[0] . '-700.webp 700w, ' . $images . $slide[0] . '-1200.webp 1200w' ); ?>"
					sizes="(max-width: 767px) 100vw, 34vw"
					width="1200"
					height="1200"
					loading="lazy"
					decoding="async"
					alt="<?php echo esc_attr( $slide[1] ); ?>"
				/>
			</li>
		<?php endforeach; ?>
	</ul>

	<!-- Shown by home.js; the strip scrolls without them too -->
	<div class="dp-slider-controls" hidden>
		<button type="button" class="dp-slider-button dp-slider-prev" aria-label="<?php esc_attr_e( 'Previous photo', 'don-phin-esq' ); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
				<line x1="19" y1="12" x2="5" y2="12"></line>
				<polyline points="12 19 5 12 12 5"></polyline>
			</svg>
		</button>

		<button type="button" class="dp-slider-button dp-slider-next" aria-label="<?php esc_attr_e( 'Next photo', 'don-phin-esq' ); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
				<line x1="5" y1="12" x2="19" y2="12"></line>
				<polyline points="12 5 19 12 12 19"></polyline>
			</svg>
		</button>

		<button type="button" class="dp-slider-button dp-slider-pause" aria-pressed="false" aria-label="<?php esc_attr_e( 'Pause the photos', 'don-phin-esq' ); ?>">
			<svg class="dp-slider-icon-pause" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
				<rect x="6" y="5" width="4" height="14" rx="1"></rect>
				<rect x="14" y="5" width="4" height="14" rx="1"></rect>
			</svg>
			<svg class="dp-slider-icon-play" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
				<path d="M8 5.5v13l11-6.5z"></path>
			</svg>
		</button>
	</div>

</section>
