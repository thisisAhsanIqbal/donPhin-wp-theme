<?php
/**
 * Template Name: Speaking Page
 *
 * Used automatically by the page with the slug "speaking".
 *
 * Written for meeting planners and sales leaders: the reel, the client logos,
 * Don's Victim / Villain / Hero framework, what changes after he speaks, the three programs,
 * the numbers, the room, what clients say, and the invitation to book.
 *
 * The reel shows a still until it is clicked, so YouTube is only contacted for
 * people who actually watch (see assets/js/video.js). Without JavaScript the
 * still is a plain link to YouTube.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$images = get_stylesheet_directory_uri() . '/assets/images/';
$stage  = $images . 'speaking/';

// Speaker reel: "Don Phin Speaking Demo 2022" on the eSpeakers channel
$reel_id = 'cIrYglFKbg8';

// The one-sheet links only appear once the PDF is in the theme at this path
$one_sheet_path = '/assets/docs/don-phin-speaking-one-sheet.pdf';
$one_sheet_url  = file_exists( get_stylesheet_directory() . $one_sheet_path ) ? get_stylesheet_directory_uri() . $one_sheet_path : '';

// The story running underneath the conversation. 'hero' is the one that works.
$stories = array(
	array(
		'name'    => 'Victim',
		'line'    => 'Everyone defends.',
		'traits'  => array( 'Defensive', 'Suspicious', 'Reactive' ),
		'outcome' => 'Trust breaks down',
		'hero'    => false,
	),
	array(
		'name'    => 'Villain',
		'line'    => 'One side pressures. The other resists.',
		'traits'  => array( 'Manipulative', 'Urgent', 'Transactional' ),
		'outcome' => 'Trust breaks down',
		'hero'    => false,
	),
	array(
		'name'    => 'Hero',
		'line'    => 'Neither side plays the victim.',
		'traits'  => array( 'Curious', 'Collaborative', 'Transparent' ),
		'outcome' => 'Trust builds',
		'hero'    => true,
	),
);

$changes = array(
	'Build trust faster and listen in ways buyers recognize',
	'Replace pressure and defensiveness with curiosity',
	'Recognize the hidden Victim / Villain / Hero story shaping the sale',
	'Handle resistance calmly and compete on relationships, not price',
	'Use technology without surrendering the human advantage',
);

// Each program is a format, a title, the promise under the title, then the description
$programs = array(
	array(
		'format'   => 'Signature keynote',
		'title'    => 'The Emotional Edge',
		'subtitle' => 'Why Relationships Have Become the Last Competitive Advantage',
		'text'     => array(
			'A highly interactive keynote revealing the emotional conversation behind every sale — and how trust, curiosity and human connection create commitment.',
			'Don shows the room exactly which Victim, Villain, or Hero story is running underneath their own deals — and how to shift it.',
		),
	),
	array(
		'format'   => 'Interactive breakout',
		'title'    => 'Mastering the Emotional Energy of Partnerships',
		'subtitle' => 'Turn better conversations into stronger business relationships.',
		'text'     => array(
			'Goes deeper into the stories, assumptions and emotional dynamics that shape customers, teams, channel partners and other critical relationships.',
			'Creates win-win partnerships where there’s an emotional desire to support each other.',
		),
	),
	array(
		'format'   => 'Executive session',
		'title'    => 'Sales Commission Agreements That Keep You Out of Court',
		'subtitle' => 'The legal traps hiding in sales compensation plans.',
		'text'     => array(
			'This is where Don whips out his legal expertise.',
			'A practical executive briefing for leaders responsible for commission plans — covering clarity, disputes, changes, termination issues and costly drafting mistakes.',
		),
	),
);

// 'value' is set large, 'suffix' in blue beside it
$stats = array(
	array(
		'value'  => '700',
		'suffix' => '+',
		'label'  => 'Presentations delivered',
	),
	array(
		'value'  => '40',
		'suffix' => '+',
		'label'  => 'Years on the human side of business',
	),
	array(
		'value'  => '1',
		'suffix' => '',
		'label'  => 'Company built & sold',
	),
	array(
		'value'  => '1M',
		'suffix' => '+',
		'label'  => 'Professionals reached',
	),
);

// What clients say, each with a headshot in assets/images/speaking/ (240px copies
// of the originals beside them)
$testimonials = array(
	array(
		'quote' => 'Don presented his program The 40//40 Solution for Leadership and Engagement for our Fall Summit. Wonderful feedback and survey results. Our membership always thanks us when we bring Don to speak and consistently asks us to have him come back.',
		'name'  => 'Preston Diamond',
		'role'  => 'Managing Director, Institute of WorkComp Professionals',
		'photo' => 'preston-diamond-240.webp',
	),
	array(
		'quote' => 'Don has a way of breaking down the complex emotional energy in relationships to basic, common-sense, matter-of-fact thinking. The best takeaway from the 40//40 is the space for co-creation. When living in the 40//40, teamwork and sales are fostered.',
		'name'  => 'Don Mader',
		'role'  => 'CEO, Southeastern Printing',
		'photo' => 'don-mader-240.webp',
	),
	array(
		'quote' => 'It is rare when a speaker can have such a powerful effect simultaneously on doctors, assistants, and office managers. His presentation is talked about almost continually and has allowed all of us to be more successful in creating team cohesion and strength.',
		'name'  => 'Sanford M. Fisch',
		'role'  => 'CEO & Co-Founder, American Academy of Estate Planning Attorneys',
		'photo' => 'sanford-fisch-240.webp',
	),
);

?>

<section class="dp-speak-hero" aria-labelledby="dp-speak-title">
	<div class="dp-speak-hero-container">

		<p class="dp-speak-eyebrow">For meeting planners, sales leaders &amp; industry sales groups</p>

		<h1 id="dp-speak-title" class="dp-speak-title">
			Relationships are <em class="dp-speak-title-accent">the last competitive advantage.</em>
		</h1>

		<div class="dp-speak-hero-intro">
			<p class="dp-speak-hero-lead">AI can explain your product. It can’t create trust.</p>

			<p class="dp-speak-hero-body">
				Today’s buyers arrive informed, researched, compared and AI-briefed. They don’t need another presentation. They need confidence that your salesperson understands them, their business and what’s really at stake.
			</p>
		</div>

		<!-- Speaker reel: a still until it is played; it overlaps into the section below -->
		<div class="dp-video dp-speak-reel" data-video="<?php echo esc_attr( $reel_id ); ?>" data-title="<?php esc_attr_e( 'Don Phin speaker reel', 'don-phin-esq' ); ?>">
			<a
				class="dp-video-play"
				href="<?php echo esc_url( 'https://www.youtube.com/watch?v=' . $reel_id ); ?>"
				target="_blank"
				rel="noopener"
				aria-label="<?php esc_attr_e( 'Play Don Phin’s speaker reel (opens on YouTube if the player cannot load)', 'don-phin-esq' ); ?>"
			>
				<img
					src="<?php echo esc_url( $stage . 'reel-1600.webp' ); ?>"
					srcset="<?php echo esc_attr( $stage . 'reel-960.webp 960w, ' . $stage . 'reel-1600.webp 1600w, ' . $stage . 'reel-2400.webp 2400w' ); ?>"
					sizes="(max-width: 1600px) 86vw, 1360px"
					alt=""
					width="1600"
					height="900"
					loading="eager"
					decoding="async"
					fetchpriority="high"
				/>
				<span class="dp-video-icon" aria-hidden="true">
					<svg width="34" height="34" viewBox="0 0 24 24" fill="currentColor" focusable="false">
						<path d="M8 5.5v13l11-6.5z"></path>
					</svg>
				</span>
				<span class="dp-speak-reel-label" aria-hidden="true">Watch the speaker reel</span>
			</a>
		</div>

	</div>
</section>

<!-- The organisations that have booked Don, drifting right to left under the reel -->
<section class="dp-speak-trusted" aria-labelledby="dp-speak-trusted-label">
	<div class="dp-speak-trusted-container">
		<p id="dp-speak-trusted-label" class="dp-speak-trusted-label">Trusted by</p>
		<?php get_template_part( 'template-parts/logo-marquee', null, array( 'labelledby' => 'dp-speak-trusted-label' ) ); ?>
	</div>
</section>

<section class="dp-speak-framework" aria-labelledby="dp-speak-framework-title">
	<div class="dp-speak-framework-container">

		<!-- The premise the framework answers -->
		<p class="dp-speak-premise">
			AI can explain your product.<br class="dp-speak-premise-break"> <em class="dp-speak-premise-accent">It can’t make the buyer trust you.</em>
		</p>

		<header class="dp-speak-framework-head">
			<div class="dp-speak-framework-heading">
				<p class="dp-speak-label">Don’s framework</p>
				<h2 id="dp-speak-framework-title" class="dp-speak-framework-title">The Hidden Conversations</h2>
			</div>
			<p class="dp-speak-framework-intro">
				Every sales conversation has two conversations — the one spoken out loud, and <em class="dp-speak-accent">the one running underneath it.</em>
			</p>
		</header>

		<!-- Victim, then Villain, then Hero: an arrow leads from each to the next -->
		<ol class="dp-speak-stories">
			<?php foreach ( $stories as $index => $story ) : ?>
				<?php if ( $index > 0 ) : ?>
					<li class="dp-speak-story-step" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
					</li>
				<?php endif; ?>
				<li class="dp-speak-story dp-speak-story--<?php echo esc_attr( strtolower( $story['name'] ) ); ?>">
					<h3 class="dp-speak-story-name"><?php echo esc_html( $story['name'] ); ?></h3>
					<p class="dp-speak-story-line"><?php echo esc_html( $story['line'] ); ?></p>
					<p class="dp-speak-story-traits">
						<?php
						// Middots are decoration; the words are read as a plain list
						echo implode( '<span aria-hidden="true"> · </span>', array_map( 'esc_html', $story['traits'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- each trait is escaped
						?>
					</p>
					<p class="dp-speak-story-outcome">
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
						<?php echo esc_html( $story['outcome'] ); ?>
					</p>
				</li>
			<?php endforeach; ?>
		</ol>

	</div>
</section>

<!-- The shift: the one idea to take away from the framework, on cobalt -->
<section class="dp-speak-shift" aria-labelledby="dp-speak-shift-label">
	<div class="dp-speak-shift-container">
		<h2 id="dp-speak-shift-label" class="dp-speak-shift-label">The shift</h2>
		<p class="dp-speak-shift-text">
			It’s not about eliminating challenges. <em class="dp-speak-shift-accent">It’s about refusing to let victim thoughts run the conversation.</em>
		</p>
	</div>
</section>

<section class="dp-speak-changes" aria-labelledby="dp-speak-changes-title">
	<div class="dp-speak-changes-container">

		<header class="dp-speak-changes-head">
			<h2 id="dp-speak-changes-title" class="dp-speak-changes-title">What Changes After Don Speaks</h2>
			<p class="dp-speak-changes-intro">
				Today’s buyer has already done the research. What they haven’t done is <em class="dp-speak-accent">decide whether to trust you.</em>
			</p>
		</header>

		<ol class="dp-speak-changes-list">
			<?php foreach ( $changes as $change ) : ?>
				<li><?php echo esc_html( $change ); ?></li>
			<?php endforeach; ?>
		</ol>

	</div>
</section>

<section class="dp-speak-programs" aria-labelledby="dp-speak-programs-title">
	<div class="dp-speak-programs-container">

		<header class="dp-speak-programs-head">
			<p class="dp-speak-label dp-speak-programs-eyebrow">Build the experience your sales meeting needs</p>
			<h2 id="dp-speak-programs-title" class="dp-speak-programs-title">
				<span>Keynote.</span>
				<span>Breakout.</span>
				<em class="dp-speak-programs-accent">Executive Session.</em>
			</h2>
			<p class="dp-speak-programs-sub">He’s already in front of your sales team — put the day to full use.</p>
		</header>

		<ol class="dp-speak-programs-list">
			<?php foreach ( $programs as $program ) : ?>
				<li class="dp-speak-program">
					<div class="dp-speak-program-content">
						<p class="dp-speak-program-format"><?php echo esc_html( $program['format'] ); ?></p>
						<h3 class="dp-speak-program-title"><?php echo esc_html( $program['title'] ); ?></h3>
						<p class="dp-speak-program-subtitle"><?php echo esc_html( $program['subtitle'] ); ?></p>
						<?php foreach ( $program['text'] as $paragraph ) : ?>
							<p class="dp-speak-program-text"><?php echo esc_html( $paragraph ); ?></p>
						<?php endforeach; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>

		<?php if ( $one_sheet_url ) : ?>
			<p class="dp-speak-programs-more">
				<a href="<?php echo esc_url( $one_sheet_url ); ?>" class="dp-arrow-link" download aria-label="<?php esc_attr_e( 'See full program details in the one-sheet (PDF)', 'don-phin-esq' ); ?>">
					See full program details in the one-sheet
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</p>
		<?php endif; ?>

	</div>
</section>

<section class="dp-speak-stats" aria-label="<?php esc_attr_e( 'Don Phin by the numbers', 'don-phin-esq' ); ?>">
	<div class="dp-speak-stats-container">
		<ul class="dp-speak-stats-list">
			<?php foreach ( $stats as $stat ) : ?>
				<li class="dp-speak-stat">
					<span class="dp-speak-stat-number"><?php echo esc_html( $stat['value'] ); ?><?php if ( $stat['suffix'] ) : ?><span class="dp-speak-stat-suffix"><?php echo esc_html( $stat['suffix'] ); ?></span><?php endif; ?></span>
					<span class="dp-speak-stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<figure class="dp-speak-room">
	<img
		src="<?php echo esc_url( $stage . 'donSpeaking_169-1600.webp' ); ?>"
		srcset="<?php echo esc_attr( $stage . 'donSpeaking_169-960.webp 960w, ' . $stage . 'donSpeaking_169-1600.webp 1600w, ' . $stage . 'donSpeaking_169.webp 2752w' ); ?>"
		sizes="100vw"
		alt="Don Phin on stage in front of a purple curtain, smiling and pointing to the audience"
		width="2752"
		height="1536"
		loading="lazy"
		decoding="async"
	/>
	<figcaption class="dp-speak-room-caption">Don in the room</figcaption>
</figure>

<section class="dp-speak-praise" aria-labelledby="dp-speak-praise-title">
	<div class="dp-speak-praise-container">

		<h2 id="dp-speak-praise-title" class="dp-speak-praise-title">From the <em class="dp-speak-praise-accent">Room</em></h2>

		<div class="dp-speak-praise-list">
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<figure class="dp-speak-quote">
					<span class="dp-speak-quote-mark" aria-hidden="true">&ldquo;</span>

					<blockquote class="dp-speak-quote-text">
						<p><?php echo esc_html( $testimonial['quote'] ); ?></p>
					</blockquote>

					<figcaption class="dp-speak-quote-by">
						<img
							class="dp-speak-quote-photo"
							src="<?php echo esc_url( $stage . $testimonial['photo'] ); ?>"
							alt=""
							width="240"
							height="240"
							loading="lazy"
							decoding="async"
						/>
						<span class="dp-speak-quote-who">
							<span class="dp-speak-quote-name"><?php echo esc_html( $testimonial['name'] ); ?></span>
							<span class="dp-speak-quote-role"><?php echo esc_html( $testimonial['role'] ); ?></span>
						</span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<section class="dp-speak-cta" aria-labelledby="dp-speak-cta-title">
	<div class="dp-speak-cta-container">

		<span class="dp-speak-cta-rule" aria-hidden="true"></span>

		<h2 id="dp-speak-cta-title" class="dp-speak-cta-title">
			<span class="dp-speak-cta-line">Bring Don</span>
			<em class="dp-speak-cta-line dp-speak-accent">to Your Stage</em>
		</h2>

		<p class="dp-speak-cta-text">
			Tell me about your meeting, your audience, and what you want the room to walk away believing.
		</p>

		<div class="dp-speak-cta-actions">
			<a href="<?php echo esc_url( home_url( '/speaking/contact/' ) ); ?>" class="dp-dark-button dp-speak-cta-button">
				Start a conversation
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>

			<?php if ( $one_sheet_url ) : ?>
				<a href="<?php echo esc_url( $one_sheet_url ); ?>" class="dp-arrow-link" download aria-label="<?php esc_attr_e( 'Download the one-sheet (PDF)', 'don-phin-esq' ); ?>">
					Download one-sheet
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			<?php endif; ?>
		</div>

	</div>
</section>

<?php
get_footer();
