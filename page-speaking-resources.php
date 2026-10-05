<?php
/**
 * Template Name: Speaking — Resources
 *
 * The Resources page for the Speaking section (/speaking/resources/): the ideas to take
 * away. The intro, Don's line on why sales are lost, the downloads (the guides, each with
 * a drawn cover, and the meeting planner's one-sheet), press photos, and the tools and
 * programs: The 40//40 Solution, then the toolkit in three shelves (calculators and
 * planners, HR checklists and guides, book summaries).
 * Assign it to the "Resources" page filed under Speaking. It sits on the Speaking
 * palette (speaking.css), with its layout in speaking-resources.css.
 *
 * Downloads are PDFs in assets/docs/, and the toolkit's in assets/docs/tools/, named
 * after each item (e.g. tools/turnover-cost-calculator.pdf). Until a file is there, its
 * button asks for a copy through the Speaking contact page instead, and switches to a
 * download by itself once the file is added.
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

// The downloads, each drawn as a small cover in its own colour ('cover': navy, blue or gold)
$downloads = array(
	array(
		'eyebrow' => 'Free download',
		'title'   => 'The Emotional Edge',
		'sub'     => 'The Hidden Conversation That Determines Every Sale — by Don Phin, Esq.',
		'text'    => 'Most sales aren’t lost in the room. They’re lost in the story you’re carrying before you ever walk in. The full framework behind the keynote.',
		'button'  => 'Download the PDF',
		'file'    => $theme_file( '/assets/docs/the-emotional-edge.pdf' ),
		'cover'   => 'navy',
		'kind'    => 'Book',
	),
	array(
		'eyebrow' => 'Free guide',
		'title'   => 'Hiring and Retaining Employees',
		'sub'     => 'Finding good people, and keeping the ones worth keeping.',
		'text'    => 'Where hiring goes wrong, what turnover really costs, and the practical moves that keep good people from walking out the door.',
		'button'  => 'Download the guide',
		'file'    => $theme_file( '/assets/docs/hiring-and-retaining-employees.pdf' ),
		'cover'   => 'blue',
		'kind'    => 'Guide',
	),
	array(
		'eyebrow' => 'Free guide',
		'title'   => 'The Power of the Stories We Tell Ourselves',
		'sub'     => 'Same reality. Different stories.',
		'text'    => 'The Victim, Villain and Hero stories running underneath every decision, and how changing the story changes what happens next.',
		'button'  => 'Download the guide',
		'file'    => $theme_file( '/assets/docs/the-power-of-the-stories-we-tell-ourselves.pdf' ),
		'cover'   => 'gold',
		'kind'    => 'Guide',
	),
	array(
		'eyebrow' => 'For meeting planners',
		'title'   => 'The One-Sheet',
		'sub'     => 'Programs, stats, and booking info in one printable page.',
		'text'    => 'Everything a meeting planner or association executive needs to bring Don to a committee — programs, credibility numbers, and how to book him.',
		'button'  => 'Download the one-sheet (PDF)',
		'file'    => $theme_file( '/assets/docs/don-phin-speaking-one-sheet.pdf' ),
		'cover'   => 'paper',
		'kind'    => 'One-sheet',
	),
);

// The toolkit, on three shelves. Each item's file is assets/docs/tools/{slug}.pdf.
$toolkit = array(
	array(
		'title' => 'Calculators & Planners',
		'line'  => 'Put numbers on what people decisions really cost.',
		'icon'  => '<rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="11" x2="8" y2="11.01"/><line x1="12" y1="11" x2="12" y2="11.01"/><line x1="16" y1="11" x2="16" y2="11.01"/><line x1="8" y1="15" x2="8" y2="15.01"/><line x1="12" y1="15" x2="12" y2="15.01"/><line x1="16" y1="15" x2="16" y2="18"/><line x1="8" y1="18" x2="12" y2="18"/>',
		'items' => array( 'Turnover Cost Calculator', 'Retention Planner' ),
	),
	array(
		'title' => 'HR Checklists & Guides',
		'line'  => 'The conversations that keep good people, step by step.',
		'icon'  => '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/>',
		'items' => array( 'OKRs', '60-Day Review', 'Stay Interviews' ),
	),
	array(
		'title' => 'Book Summaries',
		'line'  => 'The ideas Don returns to, distilled.',
		'icon'  => '<path d="M2 4h6a4 4 0 0 1 4 4v13a3 3 0 0 0-3-3H2z"/><path d="M22 4h-6a4 4 0 0 0-4 4v13a3 3 0 0 1 3-3h7z"/>',
		'items' => array( 'The Effective Executive', 'Mastery', 'Antifragile' ),
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

		<div class="dp-res-cards dp-res-cards--docs">
			<?php foreach ( $downloads as $item ) : ?>
				<article class="dp-res-card dp-res-card--doc">
					<!-- A small cover for the document, drawn in its own colour -->
					<div class="dp-res-cover dp-res-cover--<?php echo esc_attr( $item['cover'] ); ?>" aria-hidden="true">
						<span class="dp-res-cover-kind"><?php echo esc_html( $item['kind'] ); ?></span>
						<span class="dp-res-cover-title"><?php echo esc_html( $item['title'] ); ?></span>
						<span class="dp-res-cover-by">Don Phin, Esq.</span>
					</div>

					<div class="dp-res-card-body">
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
					</div>
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

		<!-- The book, featured across the width -->
		<article class="dp-res-feature">
			<img
				class="dp-res-feature-book"
				src="<?php echo esc_url( $images . '40-40/book-3d-clear.webp' ); ?>"
				alt="The 40//40 Solution by Don Phin, Esq. and Loy Young"
				loading="lazy"
				decoding="async"
			/>
			<div class="dp-res-feature-body">
				<p class="dp-res-card-eyebrow">The book</p>
				<h3 class="dp-res-card-title">The 40//40 Solution</h3>
				<p class="dp-res-card-sub">Mastering the Emotional Energy of Leadership and Sales</p>
				<p class="dp-res-card-text">Logic didn’t create the drama in your boardroom, your sales calls, or your own head — so logic isn’t going to end it. This book is about what to do with the energy instead.</p>
				<a class="dp-res-button" href="<?php echo esc_url( home_url( '/speaking/purchase-the-40-40-solution/' ) ); ?>">
					Learn more
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</div>
		</article>

		<!-- The toolkit: three shelves, each item a download once its PDF is in assets/docs/tools/ -->
		<div class="dp-res-shelves">
			<?php foreach ( $toolkit as $shelf ) : ?>
				<section class="dp-res-shelf" aria-label="<?php echo esc_attr( $shelf['title'] ); ?>">
					<header class="dp-res-shelf-head">
						<span class="dp-res-shelf-icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"><?php echo $shelf['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?></svg>
						</span>
						<h3 class="dp-res-shelf-title"><?php echo esc_html( $shelf['title'] ); ?></h3>
						<p class="dp-res-shelf-line"><?php echo esc_html( $shelf['line'] ); ?></p>
					</header>

					<ul class="dp-res-shelf-list">
						<?php foreach ( $shelf['items'] as $name ) : ?>
							<?php $file = $theme_file( '/assets/docs/tools/' . sanitize_title( $name ) . '.pdf' ); ?>
							<li>
								<?php if ( $file ) : ?>
									<a class="dp-res-tool" href="<?php echo esc_url( $file ); ?>" download>
										<span class="dp-res-tool-name"><?php echo esc_html( $name ); ?></span>
										<span class="dp-res-tool-action">Download</span>
									</a>
								<?php else : ?>
									<a class="dp-res-tool" href="<?php echo esc_url( $contact_url ); ?>" aria-label="<?php echo esc_attr( sprintf( 'Request %s', $name ) ); ?>">
										<span class="dp-res-tool-name"><?php echo esc_html( $name ); ?></span>
										<span class="dp-res-tool-action">Request</span>
									</a>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<?php
get_footer();
