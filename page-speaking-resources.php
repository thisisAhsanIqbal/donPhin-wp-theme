<?php
/**
 * Template Name: Speaking — Resources
 *
 * The Resources page for the Speaking section (/speaking/resources/): the ideas to take
 * away. The intro, Don's line on why sales are lost, the downloads (the book behind the
 * keynote and the meeting planner's one-sheet), press photos, and the tools and programs.
 * Assign it to the "Resources" page filed under Speaking. It sits on the Speaking
 * palette (speaking.css), with its layout in speaking-resources.css.
 *
 * Downloads are PDFs in assets/docs/. Until a file is there, its button asks for a copy
 * through the Speaking contact page instead, and switches to a download by itself once
 * the file is added.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$images      = get_stylesheet_directory_uri() . '/assets/images/';
$contact_url = home_url( '/speaking/contact/' );

/**
 * A file in the theme, as a URL, or '' if it isn't there yet
 */
$theme_file = function ( $path ) {
	return file_exists( get_stylesheet_directory() . $path ) ? get_stylesheet_directory_uri() . $path : '';
};

// The two downloads
$downloads = array(
	array(
		'eyebrow' => 'Free download',
		'title'   => 'The Emotional Edge',
		'sub'     => 'The Hidden Conversation That Determines Every Sale — by Don Phin, Esq.',
		'text'    => 'Most sales aren’t lost in the room. They’re lost in the story you’re carrying before you ever walk in. The full framework behind the keynote.',
		'button'  => 'Download the PDF',
		'file'    => $theme_file( '/assets/docs/the-emotional-edge.pdf' ),
	),
	array(
		'eyebrow' => 'For meeting planners',
		'title'   => 'The One-Sheet',
		'sub'     => 'Programs, stats, and booking info in one printable page.',
		'text'    => 'Everything a meeting planner or association executive needs to bring Don to a committee — programs, credibility numbers, and how to book him.',
		'button'  => 'Download the one-sheet (PDF)',
		'file'    => $theme_file( '/assets/docs/don-phin-speaking-one-sheet.pdf' ),
	),
);

// Press photos: shown small, downloaded full size
$photos = array(
	array( 'On stage', 'speaking/donSpeaking_169-960.webp', 'speaking/donSpeaking_169.webp', 'Don Phin on stage in front of a purple curtain, smiling and pointing to the audience', '42% 30%' ),
	array( 'Headshot', 'donPhin-graybg.webp', 'donPhin-graybg.webp', 'Don Phin, Esq., headshot on a grey background', '50% 22%' ),
	array( 'Audience engagement', 'speaking/stage-800.webp', 'speaking/stage-2200.webp', 'Don Phin at the podium as the audience raises their hands', '62% 40%' ),
);
?>

<section class="dp-res-intro" aria-labelledby="dp-res-title">
	<div class="dp-res-intro-container">
		<p class="dp-speak-label">Resources</p>
		<h1 id="dp-res-title" class="dp-res-title">Take the ideas <em class="dp-speak-accent">with you.</em></h1>
		<p class="dp-res-lead">The Emotional Edge is the book behind the keynote — the full framework, in Don’s own words.</p>
	</div>
</section>

<section class="dp-res-quote" aria-label="<?php esc_attr_e( 'A word from Don', 'don-phin-esq' ); ?>">
	<blockquote class="dp-res-quote-text">
		<p>“Have you ever lost a sale where all the logic was there for it to happen? The reality is, you didn’t lose it logically, you lost it emotionally. As I like to remind folks, <strong>if it doesn’t make sense, don’t try to make sense out of it!</strong>”</p>
	</blockquote>
</section>

<section class="dp-res-downloads" aria-labelledby="dp-res-downloads-title">
	<div class="dp-res-container">

		<header class="dp-res-head">
			<p class="dp-speak-label">Downloads</p>
			<h2 id="dp-res-downloads-title" class="dp-res-heading">Keep the framework close</h2>
		</header>

		<div class="dp-res-cards">
			<?php foreach ( $downloads as $item ) : ?>
				<article class="dp-res-card">
					<p class="dp-res-card-eyebrow"><?php echo esc_html( $item['eyebrow'] ); ?></p>
					<h3 class="dp-res-card-title"><?php echo esc_html( $item['title'] ); ?></h3>
					<p class="dp-res-card-sub"><?php echo esc_html( $item['sub'] ); ?></p>
					<p class="dp-res-card-text"><?php echo esc_html( $item['text'] ); ?></p>

					<?php if ( $item['file'] ) : ?>
						<a class="dp-res-button" href="<?php echo esc_url( $item['file'] ); ?>" download>
							<?php echo esc_html( $item['button'] ); ?>
							<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
						</a>
					<?php else : ?>
						<a class="dp-res-button" href="<?php echo esc_url( $contact_url ); ?>">
							Request a copy
							<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
						</a>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<section class="dp-res-media" aria-labelledby="dp-res-media-title">
	<div class="dp-res-container">

		<header class="dp-res-head">
			<p class="dp-speak-label dp-res-label-light">Media</p>
			<h2 id="dp-res-media-title" class="dp-res-heading dp-res-heading--light">Photos</h2>
		</header>

		<ul class="dp-res-photos">
			<?php foreach ( $photos as $photo ) : ?>
				<li>
					<figure class="dp-res-photo">
						<img
							src="<?php echo esc_url( $images . $photo[1] ); ?>"
							alt="<?php echo esc_attr( $photo[3] ); ?>"
							style="object-position: <?php echo esc_attr( $photo[4] ); ?>;"
							loading="lazy"
							decoding="async"
						/>
						<figcaption class="dp-res-photo-bar">
							<span class="dp-res-photo-name"><?php echo esc_html( $photo[0] ); ?></span>
							<a class="dp-res-photo-download" href="<?php echo esc_url( $images . $photo[2] ); ?>" download aria-label="<?php echo esc_attr( sprintf( 'Download the %s photo, full size', strtolower( $photo[0] ) ) ); ?>">Download</a>
						</figcaption>
					</figure>
				</li>
			<?php endforeach; ?>
		</ul>

	</div>
</section>

<section class="dp-res-tools" aria-labelledby="dp-res-tools-title">
	<div class="dp-res-container">

		<header class="dp-res-head">
			<p class="dp-speak-label">More from Don</p>
			<h2 id="dp-res-tools-title" class="dp-res-heading">Tools &amp; Programs</h2>
		</header>

		<div class="dp-res-cards">
			<article class="dp-res-card">
				<p class="dp-res-card-eyebrow">The book</p>
				<h3 class="dp-res-card-title">The 40//40 Solution</h3>
				<p class="dp-res-card-sub">Mastering the Emotional Energy of Leadership and Sales</p>
				<p class="dp-res-card-text">Logic didn’t create the drama in your boardroom, your sales calls, or your own head — so logic isn’t going to end it. This book is about what to do with the energy instead.</p>
				<a class="dp-res-button" href="<?php echo esc_url( home_url( '/speaking/purchase-the-40-40-solution/' ) ); ?>">
					Learn more
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</article>

			<article class="dp-res-card dp-res-card--soon">
				<p class="dp-res-card-eyebrow">Coming soon</p>
				<p class="dp-res-card-text">More tools and worksheets from Don’s programs are on the way.</p>
				<a class="dp-arrow-link" href="<?php echo esc_url( $contact_url ); ?>">
					Ask Don about a program
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</article>
		</div>

	</div>
</section>

<?php
get_footer();
