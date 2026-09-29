<?php
/**
 * Template Name: The Journey Page
 *
 * Used automatically by the page with the slug "the-journey". Part of Private Counsel:
 * it loads that page's stylesheet for the palette, the header colours and the book,
 * then its own (assets/css/journey.css) for the layout.
 *
 * What the year looks like after the Whole Life Assessment: the year built around
 * you, its three parts, the conversations, what happens between them, Don's gift
 * of The Inner Climb, and one line of his to close.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$images = get_stylesheet_directory_uri() . '/assets/images/Journey/';

// The book request goes to Private Counsel's own contact page
$request_url = home_url( '/private-counsel/contact/' );

// The three parts of the year
$parts = array(
	array( 'Private Counsel', 'Regular, candid conversations with the time and depth necessary to go where we need to go.' ),
	array( 'Three Immersive Experiences', 'Private retreats and experiences created around where you are in your journey — not a predetermined curriculum.' ),
	array( 'When Life Happens', 'Access to me when the decision is live, not simply when our next meeting happens to be scheduled.' ),
);

// What the conversations are for
$topics = array(
	'Where you are and where you’re headed',
	'The opportunities and challenges in front of you',
	'Relationships, purpose, and personal growth',
	'When you need to make a decision quickly',
);
?>

<section class="dp-jr-hero" aria-labelledby="dp-jr-title">
	<div class="dp-jr-hero-container">

		<div class="dp-jr-hero-content">
			<p class="dp-jr-eyebrow">The journey</p>
			<h1 id="dp-jr-title" class="dp-jr-title">A Year, Built <em class="dp-jr-accent">Around You.</em></h1>
			<p class="dp-jr-lead">This is what the year looks like once we’ve done the Whole Life Assessment together — a personally curated year, not a program.</p>
			<p class="dp-jr-text">I don’t have a program to put you through. I have a year to design around you.</p>
		</div>

		<figure class="dp-jr-hero-photo">
			<img
				src="<?php echo esc_url( $images . 'journey-m-1376.webp' ); ?>"
				srcset="<?php echo esc_attr( $images . 'journey-m-800.webp 800w, ' . $images . 'journey-m-1376.webp 1376w' ); ?>"
				sizes="(max-width: 991px) 100vw, 52vw"
				alt="Don Phin in conversation with a client across a table in a book-lined office"
				width="1376"
				height="768"
				loading="eager"
				decoding="async"
				fetchpriority="high"
			/>
		</figure>

	</div>
</section>

<section class="dp-jr-year" aria-labelledby="dp-jr-year-title">
	<div class="dp-jr-year-container">

		<h2 id="dp-jr-year-title" class="dp-jr-eyebrow dp-jr-eyebrow--center">A year designed around you</h2>

		<ol class="dp-jr-parts">
			<?php foreach ( $parts as $index => $part ) : ?>
				<li class="dp-jr-part">
					<span class="dp-jr-part-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
					<h3 class="dp-jr-part-title"><?php echo esc_html( $part[0] ); ?></h3>
					<p class="dp-jr-part-text"><?php echo esc_html( $part[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>

	</div>
</section>

<section class="dp-jr-talks" aria-labelledby="dp-jr-talks-title">

	<figure class="dp-jr-talks-photo">
		<img
			src="<?php echo esc_url( $images . 'journey-f-1376.webp' ); ?>"
			srcset="<?php echo esc_attr( $images . 'journey-f-800.webp 800w, ' . $images . 'journey-f-1376.webp 1376w' ); ?>"
			sizes="(max-width: 991px) 100vw, 50vw"
			alt="Don Phin listening closely to a client in his office"
			width="1376"
			height="768"
			loading="lazy"
			decoding="async"
		/>
	</figure>

	<div class="dp-jr-talks-content">
		<h2 id="dp-jr-talks-title" class="dp-jr-talks-title">The Conversations</h2>
		<p class="dp-jr-talks-when">As often as the moment requires — in person, by phone, or by Zoom.</p>
		<p class="dp-jr-talks-lead">These are deep-dive conversations and decision sessions for:</p>
		<ul class="dp-jr-talks-list">
			<?php foreach ( $topics as $topic ) : ?>
				<li><?php echo esc_html( $topic ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>

</section>

<section class="dp-jr-between" aria-labelledby="dp-jr-between-title">
	<div class="dp-jr-between-container">
		<p class="dp-jr-eyebrow dp-jr-eyebrow--center">Between conversations</p>
		<h2 id="dp-jr-between-title" class="dp-jr-between-title">Conversation. Experience. Reflection. <em class="dp-jr-accent">Integration.</em></h2>
		<p class="dp-jr-between-text">Between conversations, I may curate an experience specifically for you — something designed to provoke reflection, discovery or change. Purpose, relationships, health and spirit aren’t four retreat topics. They weave through everything we do together.</p>
	</div>

	<!-- Two of the experiences: out on the trail, and in stillness -->
	<div class="dp-jr-between-photos">
		<?php
		$experiences = array(
			array( 'phin-hiking', 'Don Phin hiking a mountain trail with a small group, smiling' ),
			array( 'phin-meditating', 'Don Phin meditating cross-legged on a wooden deck above a misty valley' ),
		);
		foreach ( $experiences as $experience ) :
			?>
			<figure class="dp-jr-between-photo">
				<img
					src="<?php echo esc_url( $images . $experience[0] . '-800.webp' ); ?>"
					srcset="<?php echo esc_attr( $images . $experience[0] . '-800.webp 800w, ' . $images . $experience[0] . '.webp 1376w' ); ?>"
					sizes="(max-width: 640px) 100vw, 480px"
					alt="<?php echo esc_attr( $experience[1] ); ?>"
					width="1376"
					height="768"
					loading="lazy"
					decoding="async"
				/>
			</figure>
		<?php endforeach; ?>
	</div>
</section>

<section class="dp-jr-gift" aria-labelledby="dp-jr-gift-title">
	<div class="dp-jr-gift-container">
		<div class="dp-jr-gift-card">

			<!-- The cover, drawn as on the Private Counsel page: a path climbing to a summit -->
			<div class="dp-pc-book" aria-hidden="true">
				<div class="dp-pc-book-cover">
					<svg class="dp-pc-book-art" viewBox="0 0 120 90" focusable="false">
						<path class="dp-pc-book-range" d="M4 84 32 48l12 12 24-38 22 30 10-10 16 42" fill="none"/>
						<path class="dp-pc-book-path" d="M34 84c10-4 18-9 14-15s-12-6-4-12 14-5 12-13 2-12 12-20" fill="none" pathLength="1"/>
						<circle class="dp-pc-book-summit" cx="68" cy="22" r="3"/>
					</svg>
					<span class="dp-pc-book-title">The Inner Climb</span>
				</div>
			</div>

			<div class="dp-jr-gift-body">
				<p class="dp-jr-eyebrow">A gift from Don</p>
				<h2 id="dp-jr-gift-title" class="dp-jr-gift-title">The Inner Climb</h2>
				<p class="dp-jr-gift-text">This short guide was written for men on the journey to a more meaningful, connected, and fulfilled life.</p>
			</div>

			<div class="dp-jr-gift-offer">
				<p class="dp-jr-gift-note">I’d be happy to send you a complimentary copy and mail it to you personally.</p>
				<a href="<?php echo esc_url( $request_url ); ?>" class="dp-jr-button">
					Request your copy
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</div>

		</div>
	</div>
</section>

<section class="dp-jr-close" aria-label="<?php esc_attr_e( 'A word from Don', 'don-phin-esq' ); ?>">
	<figure class="dp-jr-close-figure">
		<blockquote class="dp-jr-close-quote">
			<p>“The best leaders I know keep climbing — not for more, but for meaning.”</p>
		</blockquote>
		<figcaption class="dp-jr-close-by">— Don Phin, Esq.</figcaption>
	</figure>
</section>

<?php
// Anything added to the page in the WordPress editor follows the designed sections
while ( have_posts() ) :
	the_post();
	if ( '' !== trim( get_the_content() ) ) :
		?>
		<div class="dp-page-content-wrap">
			<div class="dp-page-container">
				<?php the_content(); ?>
			</div>
		</div>
		<?php
	endif;
endwhile;

get_footer();
