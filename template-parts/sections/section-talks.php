<?php
/**
 * Template Part: Keynotes
 *
 * The talks Don is asked to deliver as a numbered list, beside the heading and a
 * box inviting a custom talk (that box stays in view on desktop).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$talks = array(
	array(
		'title'    => 'Mastering the Emotional Energy of Leadership and Sales',
		'text'     => 'The one with the red noses. Why teams manufacture drama, what it costs, and how a leader can stop being the source of it. Ends with an exercise people are still talking about a year later. Every attendee leaves with the book.',
		'best_for' => 'CEO groups, leadership summits, sales kickoffs.',
	),
	array(
		'title'    => 'What AI Is Actually Doing to Your People',
		'text'     => 'Not a tools demo. A candid look at what happens to judgment, initiative, and trust when a company hands its thinking to a machine — and what leaders should be protecting on purpose. Current, specific, and free of both hype and doom.',
		'best_for' => 'boards, executive offsites, industry conferences.',
	),
	array(
		'title'    => 'Hiring and Keeping People Worth Keeping',
		'text'     => 'Where recruiting actually breaks, what turnover really costs you in dollars, and the handful of retention moves that outperform another pizza party. Comes with the calculators and templates.',
		'best_for' => 'HR associations, ownership groups, growth-stage teams.',
	),
);
?>

<section class="dp-talks" aria-labelledby="dp-talks-title">
	<div class="dp-talks-container">

		<h2 id="dp-talks-title" class="dp-talks-title">
			What I’m <em class="dp-talks-accent">asked to deliver</em>
		</h2>

		<ol class="dp-talks-list">
			<?php foreach ( $talks as $talk ) : ?>
				<li class="dp-talk">
					<div class="dp-talk-content">
						<h3 class="dp-talk-title"><?php echo esc_html( $talk['title'] ); ?></h3>
						<p class="dp-talk-text"><?php echo esc_html( $talk['text'] ); ?></p>
						<p class="dp-talk-best">
							<span class="dp-talk-best-label">Best for:</span><?php echo esc_html( $talk['best_for'] ); ?>
						</p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>

		<div class="dp-talks-custom">
			<h3 class="dp-talks-custom-title">Built for your room</h3>
			<p class="dp-talks-custom-text">
				Give me your agenda and your pain and I’ll build the talk around it. Most of my repeat bookings started as a custom request.
			</p>
			<a href="<?php echo esc_url( home_url( '/speaking/contact/' ) ); ?>" class="dp-light-button">
				Check available dates
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</div>

	</div>
</section>
