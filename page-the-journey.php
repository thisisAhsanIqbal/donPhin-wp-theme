<?php
/**
 * Template Name: The Journey Page
 *
 * The Next Journey (/private-counsel/the-journey/): Don's private counsel offer, from
 * the offer architecture (reference/Part1_Offer_Architecture_The_Next_Journey.docx) and
 * the client experience (reference/A_Year_in_the_Life.pdf). Part of Private Counsel: it
 * loads that page's stylesheet for the palette, the header colours and the book, then its
 * own (assets/css/journey.css) for the layout.
 *
 * The journey in brief; the transformation it is for; how it unfolds (Day of Discovery,
 * Assessment, Personal Blueprint, the Journey); the three immersions; the counsel between
 * them; what is constant and what is shaped around him; access (three men, by
 * introduction); Don's gift of The Inner Climb, and one line of his to close.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$images      = get_stylesheet_directory_uri() . '/assets/images/';
$journey     = $images . 'Journey/';
$request_url = home_url( '/private-counsel/contact/' );

// How it unfolds, in order
$steps = array(
	array( 'Day of Discovery', 'A full day, one-on-one. We talk, we walk, we share a meal. I ask the questions you’ve probably never been asked.' ),
	array( 'The Assessment', 'The Everything But Your Money™ Whole-Life Assessment, over a month: health and personality assessments, and confidential conversations with the friends, family and colleagues you give me permission to speak with.' ),
	array( 'Your Personal Blueprint', 'What I see, laid out plainly: where you are across purpose, health, relationships and spirit, and what the year could be.' ),
	array( 'The Journey', 'One year. Three private immersions, and counsel on call — designed around you, not a curriculum.' ),
);

// The three immersions: numeral, name, the line from the offer, what it is, and its photo
$immersions = array(
	array(
		'num'   => 'I',
		'name'  => 'Ground',
		'line'  => 'The trail.',
		'text'  => 'Two men getting to know each other at walking pace. Mostly walking, mostly talking — shared effort rather than a conference table.',
		'image' => $journey . 'phin-hiking-800.webp',
		'alt'   => 'Don Phin hiking a mountain trail, smiling',
		'focus' => '52% 40%',
	),
	array(
		'num'   => 'II',
		'name'  => 'Deep Immersion',
		'line'  => 'The long evenings.',
		'text'  => 'Somewhere built for long, unhurried conversation, where fear, judgment and regret are finally spoken. Whatever is actually there.',
		'image' => $images . 'counsel/room-900.webp',
		'alt'   => 'Don Phin in a long, unhurried conversation in a book-lined study',
		'focus' => '62% 40%',
	),
	array(
		'num'   => 'III',
		'name'  => 'Integration',
		'line'  => 'Stillness.',
		'text'  => 'A quieter setting, built for stillness. We look back at the year and design the life you live next.',
		'image' => $journey . 'phin-meditating-800.webp',
		'alt'   => 'Don Phin meditating on a wooden deck above a misty valley',
		'focus' => '50% 45%',
	),
);

// Between the immersions
$between = array(
	array( 'Counsel Days', 'About once a month, a whole day together, in person or online. No rushing, no watching the clock.' ),
	array( 'The Counsel Line', 'For the decisions that can’t be answered on a spreadsheet. The phone rings: “Don, I need another perspective.”' ),
	array( 'Invitations', 'Never homework. A letter you’ll never send, a conversation you’ve postponed, an afternoon without your phone.' ),
);

// What is the same for every man, and what is shaped around him
$constant = array(
	'The four dimensions beyond wealth: purpose, health, relationships and spirit',
	'The sequence: Day of Discovery, Assessment, Blueprint, Journey',
	'Three immersions, and counsel between them',
	'No judgment, and expectations drafted into agreements',
);
$bespoke = array(
	'Where the immersions happen, and what we do there',
	'Which dimension leads',
	'Who from your world joins: a son on the trail, a partner at dinner',
	'The pace between',
);
?>

<section class="dp-jr-hero" aria-labelledby="dp-jr-title">
	<div class="dp-jr-hero-container">

		<div class="dp-jr-hero-content">
			<p class="dp-jr-eyebrow">The Next Journey</p>
			<h1 id="dp-jr-title" class="dp-jr-title">One man. One year. <em class="dp-jr-accent">Built around you.</em></h1>
			<p class="dp-jr-lead">A personal transformation journey: one year, three private immersions, and counsel on call.</p>
			<p class="dp-jr-text">This isn’t coaching, consulting or therapy. I don’t have a program to put you through. I have a year to design around you.</p>
		</div>

		<figure class="dp-jr-hero-photo">
			<img
				src="<?php echo esc_url( $journey . 'journey-m-1376.webp' ); ?>"
				srcset="<?php echo esc_attr( $journey . 'journey-m-800.webp 800w, ' . $journey . 'journey-m-1376.webp 1376w' ); ?>"
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

<section class="dp-jr-story" aria-labelledby="dp-jr-story-title">
	<div class="dp-jr-story-container">

		<header class="dp-jr-story-head">
			<p class="dp-pc-eyebrow">The transformation</p>
			<h2 id="dp-jr-story-title" class="dp-jr-story-title">Nobody has been assigned <em class="dp-pc-gold-accent">to the man.</em></h2>
		</header>

		<div class="dp-jr-story-body">
			<p>Around every man who has mastered wealth stands a team built to protect his fortune. On the Tuesday morning after the sale, the succession, or the last day in the corner office, he has the boat, the watch, and the question he has never said out loud: <em>what was it for?</em></p>
			<p class="dp-jr-story-after">Twelve months later he has set down the guilt of what the building cost. His son calls him first. His body carries him up the trail he once watched from the car. His calendar holds only what he chose. He is happy, visibly so, and fully inside the life he paid for.</p>
		</div>

		<blockquote class="dp-jr-story-pull">
			<p>The moment on the trail when he says the thing he has never said to anyone, and hears, perhaps for the first time in years, that he is a good man with permission to stop punishing himself.</p>
		</blockquote>

	</div>
</section>

<section class="dp-jr-year" aria-labelledby="dp-jr-year-title">
	<div class="dp-jr-year-container">

		<h2 id="dp-jr-year-title" class="dp-jr-eyebrow dp-jr-eyebrow--center">How it unfolds</h2>
		<p class="dp-jr-year-lead">Every engagement begins with the Assessment. I choose the man as carefully as the man chooses me.</p>

		<ol class="dp-jr-parts dp-jr-parts--four">
			<?php foreach ( $steps as $index => $step ) : ?>
				<li class="dp-jr-part">
					<span class="dp-jr-part-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
					<h3 class="dp-jr-part-title"><?php echo esc_html( $step[0] ); ?></h3>
					<p class="dp-jr-part-text"><?php echo esc_html( $step[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>

	</div>
</section>

<section class="dp-jr-immersions" aria-labelledby="dp-jr-immersions-title">
	<div class="dp-jr-immersions-container">

		<header class="dp-jr-immersions-head">
			<p class="dp-jr-eyebrow dp-jr-eyebrow--center">The year</p>
			<h2 id="dp-jr-immersions-title" class="dp-jr-immersions-title">Three private <em class="dp-jr-accent">immersions.</em></h2>
			<p class="dp-jr-immersions-lead">We leave normal life behind for a few days — not to escape it, but to see it more clearly.</p>
		</header>

		<ol class="dp-jr-immersion-list">
			<?php foreach ( $immersions as $item ) : ?>
				<li class="dp-jr-immersion">
					<figure class="dp-jr-immersion-photo">
						<img
							src="<?php echo esc_url( $item['image'] ); ?>"
							alt="<?php echo esc_attr( $item['alt'] ); ?>"
							style="object-position: <?php echo esc_attr( $item['focus'] ); ?>;"
							loading="lazy"
							decoding="async"
						/>
						<span class="dp-jr-immersion-num" aria-hidden="true"><?php echo esc_html( $item['num'] ); ?></span>
					</figure>
					<div class="dp-jr-immersion-body">
						<p class="dp-jr-immersion-kicker">Immersion <?php echo esc_html( $item['num'] ); ?></p>
						<h3 class="dp-jr-immersion-name"><?php echo esc_html( $item['name'] ); ?></h3>
						<p class="dp-jr-immersion-line"><?php echo esc_html( $item['line'] ); ?></p>
						<p class="dp-jr-immersion-text"><?php echo esc_html( $item['text'] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>

	</div>
</section>

<section class="dp-jr-talks" aria-labelledby="dp-jr-talks-title">

	<figure class="dp-jr-talks-photo">
		<img
			src="<?php echo esc_url( $journey . 'journey-f-1376.webp' ); ?>"
			srcset="<?php echo esc_attr( $journey . 'journey-f-800.webp 800w, ' . $journey . 'journey-f-1376.webp 1376w' ); ?>"
			sizes="(max-width: 991px) 100vw, 50vw"
			alt="Don Phin listening closely to a client in his office"
			width="1376"
			height="768"
			loading="lazy"
			decoding="async"
		/>
	</figure>

	<div class="dp-jr-talks-content">
		<h2 id="dp-jr-talks-title" class="dp-jr-talks-title">Between immersions</h2>
		<p class="dp-jr-talks-when">Counsel on call. No one should make life’s biggest decisions alone.</p>
		<ul class="dp-jr-talks-list dp-jr-talks-list--named">
			<?php foreach ( $between as $item ) : ?>
				<li>
					<span class="dp-jr-talks-name"><?php echo esc_html( $item[0] ); ?></span>
					<span class="dp-jr-talks-text"><?php echo esc_html( $item[1] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

</section>

<section class="dp-jr-shape" aria-labelledby="dp-jr-shape-title">
	<div class="dp-jr-shape-container">

		<header class="dp-jr-shape-head">
			<p class="dp-jr-eyebrow dp-jr-eyebrow--center">A framework, not a formula</p>
			<h2 id="dp-jr-shape-title" class="dp-jr-shape-title">The same care for every man. <em class="dp-jr-accent">A year that’s only yours.</em></h2>
		</header>

		<div class="dp-jr-shape-columns">
			<div class="dp-jr-shape-col">
				<h3 class="dp-jr-shape-col-title">Always</h3>
				<ul>
					<?php foreach ( $constant as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="dp-jr-shape-col dp-jr-shape-col--bespoke">
				<h3 class="dp-jr-shape-col-title">Shaped around you</h3>
				<ul>
					<?php foreach ( $bespoke as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

	</div>
</section>

<section class="dp-jr-access" aria-labelledby="dp-jr-access-title">
	<div class="dp-jr-access-container">
		<p class="dp-pc-eyebrow">Access</p>
		<h2 id="dp-jr-access-title" class="dp-jr-access-title">Three men at any one time. <em class="dp-pc-gold-accent">Mathematics, not marketing.</em></h2>
		<p class="dp-jr-access-text">By introduction only: from wealth advisors, estate attorneys, family offices, and men who have made the journey. When the three seats are filled, there is a quiet waitlist.</p>
		<a href="<?php echo esc_url( $request_url ); ?>" class="dp-pc-button">
			Request an introduction
			<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
		</a>
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
			<p>“If our year together helps you live that life more intentionally, then it will have been one of the best investments either of us ever made.”</p>
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
