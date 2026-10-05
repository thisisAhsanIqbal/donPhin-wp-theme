<?php
/**
 * Template Name: Speaking — Resources
 *
 * The Resources page for the Speaking section (/speaking/resources/): the ideas to take
 * away. The intro, Don's line on why sales are lost, the downloads (the guides, each with
 * a drawn cover, and the meeting planner's one-sheet), press photos, and the tools and
 * programs (The 40//40 Solution and the two interactive web tools), and the library:
 * everything Don has made, by category, with a search and a button for each category.
 * Assign it to the "Resources" page filed under Speaking. It sits on the Speaking
 * palette (speaking.css), with its layout in speaking-resources.css.
 *
 * Downloads are PDFs in assets/docs/. Until a file is there, its button asks for a copy
 * through the Speaking contact page instead, and switches to a download by itself once
 * the file is added. The library's items work the same way from assets/docs/library/;
 * its contents, and the web tools', are in inc/resource-library.php.
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
		'title'   => 'Hiring and Retaining Employees in this Crazy Economy',
		'sub'     => 'Finding good people, and keeping the ones worth keeping.',
		'text'    => 'Where hiring goes wrong, what turnover really costs, and the practical moves that keep good people from walking out the door.',
		'button'  => 'Download the guide',
		'file'    => $theme_file( '/assets/docs/hiring-and-retaining-employees.pdf' ),
		'cover'   => 'blue',
		'kind'    => 'E-book',
	),
	array(
		'eyebrow' => 'Free guide',
		'title'   => 'The Power of the Stories We Tell Ourselves',
		'sub'     => 'Same reality. Different stories.',
		'text'    => 'The Victim, Villain and Hero stories running underneath every decision, and how changing the story changes what happens next.',
		'button'  => 'Download the guide',
		'file'    => $theme_file( '/assets/docs/the-power-of-the-stories-we-tell-ourselves.pdf' ),
		'cover'   => 'gold',
		'kind'    => 'Manifesto',
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

// The web tools and the library (inc/resource-library.php)
$tools         = donphin_resource_tools();
$library       = donphin_resource_library();
$library_total = array_sum(
	array_map(
		function ( $category ) {
			return count( $category['items'] );
		},
		$library
	)
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

		<!-- The two interactive tools, each one open once it's live (until then, a request) -->
		<div class="dp-res-webtools">
			<?php foreach ( $tools as $tool ) : ?>
				<?php $tool_url = $tool['url'] ? $tool['url'] : add_query_arg( 'resource', rawurlencode( $tool['name'] ), $contact_url ); ?>
				<a class="dp-res-webtool" href="<?php echo esc_url( $tool_url ); ?>">
					<span class="dp-res-webtool-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"><?php echo $tool['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?></svg>
					</span>
					<span class="dp-res-webtool-body">
						<span class="dp-res-webtool-kind">Interactive tool</span>
						<span class="dp-res-webtool-name"><?php echo esc_html( $tool['name'] ); ?></span>
						<span class="dp-res-webtool-line"><?php echo esc_html( $tool['line'] ); ?></span>
						<span class="dp-res-webtool-action">
							<?php echo $tool['url'] ? 'Open the tool' : 'Request access'; ?>
							<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
						</span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<section class="dp-res-library" id="dp-res-library" aria-labelledby="dp-res-library-title">
	<div class="dp-res-container">

		<header class="dp-res-head">
			<p class="dp-speak-label">The library</p>
			<h2 id="dp-res-library-title" class="dp-res-heading">Every tool Don has made, in one place</h2>
			<p class="dp-res-head-text"><?php echo esc_html( $library_total ); ?> checklists, forms, worksheets, books and videos, built over forty years of helping companies keep good people.</p>
		</header>

		<div class="dp-lib" data-dp-lib>

			<!-- Search and the category buttons; shown by resource-library.js, since they need it -->
			<div class="dp-lib-controls" data-dp-lib-controls hidden>
				<label class="dp-lib-search">
					<span class="screen-reader-text">Search the library</span>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
					<input type="search" placeholder="<?php echo esc_attr( sprintf( 'Search %d resources…', $library_total ) ); ?>" autocomplete="off" data-dp-lib-search>
				</label>

				<div class="dp-lib-chips" role="group" aria-label="Show one category">
					<button type="button" class="dp-lib-chip" data-cat="all" aria-pressed="true">
						All <span class="dp-lib-chip-count"><?php echo esc_html( $library_total ); ?></span>
					</button>
					<?php foreach ( $library as $key => $category ) : ?>
						<button type="button" class="dp-lib-chip" data-cat="<?php echo esc_attr( $key ); ?>" aria-pressed="false">
							<?php echo esc_html( $category['chip'] ); ?> <span class="dp-lib-chip-count"><?php echo esc_html( count( $category['items'] ) ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</div>

			<p class="dp-lib-status screen-reader-text" aria-live="polite" data-dp-lib-status></p>

			<div class="dp-lib-groups">
				<?php foreach ( $library as $key => $category ) : ?>
					<section class="dp-lib-group" id="dp-lib-<?php echo esc_attr( $key ); ?>" data-cat="<?php echo esc_attr( $key ); ?>" aria-labelledby="dp-lib-<?php echo esc_attr( $key ); ?>-title">
						<header class="dp-lib-group-head">
							<span class="dp-lib-group-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"><?php echo $category['icon']; // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?></svg>
							</span>
							<div class="dp-lib-group-words">
								<h3 id="dp-lib-<?php echo esc_attr( $key ); ?>-title" class="dp-lib-group-title"><?php echo esc_html( $category['title'] ); ?></h3>
								<p class="dp-lib-group-line"><?php echo esc_html( $category['line'] ); ?></p>
							</div>
							<span class="dp-lib-group-count" data-dp-lib-count><?php echo esc_html( count( $category['items'] ) ); ?></span>
						</header>

						<ul class="dp-lib-list">
							<?php foreach ( $category['items'] as $item ) : ?>
								<?php $resource = donphin_resource_item( $item, $category, $contact_url ); ?>
								<li class="dp-lib-item" data-search="<?php echo esc_attr( strtolower( $resource['name'] . ' ' . $resource['tag'] ) ); ?>">
									<a class="dp-lib-link" href="<?php echo esc_url( $resource['href'] ); ?>"<?php echo $resource['download'] ? ' download' : ''; ?>>
										<span class="dp-lib-name">
											<?php echo esc_html( $resource['name'] ); ?>
											<?php if ( $resource['tag'] ) : ?>
												<span class="dp-lib-tag"><?php echo esc_html( $resource['tag'] ); ?></span>
											<?php endif; ?>
										</span>
										<span class="dp-lib-action dp-lib-action--<?php echo esc_attr( strtolower( $resource['action'] ) ); ?>"><?php echo esc_html( $resource['action'] ); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>

						<button type="button" class="dp-lib-more" aria-expanded="false" data-dp-lib-more hidden>
							<?php echo esc_html( sprintf( 'Show all %d', count( $category['items'] ) ) ); ?>
						</button>
					</section>
				<?php endforeach; ?>
			</div>

			<p class="dp-lib-empty" data-dp-lib-empty hidden>
				Nothing in the library matches that yet.
				<a href="<?php echo esc_url( $contact_url ); ?>">Ask Don</a> — he may have just the thing.
			</p>

		</div>
	</div>
</section>

<?php
get_footer();
