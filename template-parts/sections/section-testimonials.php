<?php
/**
 * Template Part: Testimonials
 *
 * A row of quote cards on the brand blue: two per view on desktop, one on phones.
 * The row scrolls sideways on its own; assets/js/home.js adds the arrows and dots.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$testimonials = array(
	array(
		'paragraphs' => array(
			'Dear Don, Thank you for your support and guidance. It’s always ‘right on the mark’. Since your session at our annual staff retreat, we have come a long way. Victims, Villains and Heroes makes so much sense, drama in the workplace is greatly diminished.',
			'Our staff loved your presentation and were totally engaged. You kept their attention and really drove points home. It had an impact. Conversations among staff are on a deeper, more meaningful level. We made tremendous growth in a very short period of time. Victims, Villains and Heroes is a powerful frame. Thank you again for your guidance.”',
		),
		'name'       => 'Bobbi DePorter',
		'role'       => 'President, Learning Forum',
	),
	array(
		'paragraphs' => array(
			'If you’ve wished that you had the expertise of a labor law attorney, an organizational leadership expert … all wrapped in a bow of dynamic storytelling available in one person, look no further than Don Phin. … I’ve grown even more confident in leading Bayberry toward achieving strategic outcomes by setting clear goals, getting buy-in from our management team, delegating responsibilities, and instilling accountability in our organizational culture. Don is invaluable to me and to my agency.”',
		),
		'name'       => 'Linda Plourde',
		'role'       => 'Executive Director, Bayberry, Inc.',
	),
	array(
		'paragraphs' => array(
			'I have known Don for 20+ years. He is someone I go to with complex human dynamic issues. He listens, questions, listens, questions and then helps you find the best course of action. He is one of Vistage’s top speakers. I have been blessed to hear him speak twice in the past and am super excited to have him speaking to my CEO group in 2023. He sets the standard for giving CEOs practical and actionable take homes. He is a straight shooter with a gigantic heart. He is the best.',
		),
		'name'       => 'Mark Fackler',
		'role'       => 'CEO Vistage',
	),
	array(
		'paragraphs' => array(
			'Don is a rare HR resource. He is both incredibly smart and most importantly practical. I have referred him to numerous CEOs in my group and he always gets glowing reports.',
		),
		'name'       => 'Alan Sorkin',
		'role'       => 'Executive Vice Chairman The Conrad Prebys Foundation',
	),
	array(
		'paragraphs' => array(
			'Don delivered a standout session at our People Development Days. @Don, your unique blend of insight and energy captivated us all. Your ability to simplify complex concepts made the session both engaging and relatable. Attendees walked away inspired and with a fresh perspective. Thank you!',
		),
		'name'       => 'Astrid Breuer',
		'role'       => 'L&D Professional',
	),
);
?>

<section class="dp-testimonials" aria-labelledby="dp-testimonials-label">
	<div class="dp-testimonials-container">

		<div class="dp-testimonials-head">
			<h2 id="dp-testimonials-label" class="dp-testimonials-label">Testimonials</h2>

			<!-- Shown by home.js; the row scrolls sideways without them too -->
			<div class="dp-testimonials-controls" hidden>
				<div class="dp-testimonials-dots" role="tablist" aria-label="<?php esc_attr_e( 'Testimonial pages', 'don-phin-esq' ); ?>"></div>

				<button type="button" class="dp-testimonials-arrow dp-testimonials-prev" aria-label="<?php esc_attr_e( 'Previous testimonials', 'don-phin-esq' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<line x1="19" y1="12" x2="5" y2="12"></line>
						<polyline points="12 19 5 12 12 5"></polyline>
					</svg>
				</button>

				<button type="button" class="dp-testimonials-arrow dp-testimonials-next" aria-label="<?php esc_attr_e( 'More testimonials', 'don-phin-esq' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<line x1="5" y1="12" x2="19" y2="12"></line>
						<polyline points="12 5 19 12 12 19"></polyline>
					</svg>
				</button>
			</div>
		</div>

		<div class="dp-testimonials-track" tabindex="0" role="group" aria-label="<?php esc_attr_e( 'Testimonials, scrolls sideways', 'don-phin-esq' ); ?>">
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<figure class="dp-testimonial">
					<span class="dp-testimonial-mark" aria-hidden="true">&ldquo;</span>

					<blockquote class="dp-testimonial-quote">
						<?php foreach ( $testimonial['paragraphs'] as $paragraph ) : ?>
							<p><?php echo esc_html( $paragraph ); ?></p>
						<?php endforeach; ?>
					</blockquote>

					<figcaption class="dp-testimonial-cite">
						<span class="dp-testimonial-name"><?php echo esc_html( $testimonial['name'] ); ?></span>
						<span class="dp-testimonial-role"><?php echo esc_html( $testimonial['role'] ); ?></span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>

	</div>
</section>
