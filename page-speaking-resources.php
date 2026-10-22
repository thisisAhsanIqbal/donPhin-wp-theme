<?php
/**
 * Template Name: Speaking — Resources
 *
 * The Resources page for the Speaking section (/speaking/resources/): Sales on Stage™ only,
 * there to support paid speaking. The hero (the title, the promise and the speaker reel),
 * the story and what a sales team walks away with, For Meeting Planners (one-sheet, bio,
 * photos, video) with the speaker photos, the Sales on Stage™ book, the downloads (the
 * worksheets and field guide, and The 40//40 Solution's PDFs), about Don, and a place for
 * articles and interviews, with "Discuss Your Sales Conference" near the top and at the
 * foot. HR material lives on HR Tools (/hr-tools/). It sits on the Speaking palette
 * (speaking.css), with its layout in speaking-resources.css.
 *
 * Nothing here is made up: a resource Don hasn't approved yet shows as "Coming soon",
 * and becomes a download by itself once its file is added. The files it looks for:
 * - assets/docs/sales-on-stage-one-sheet.pdf          the speaker one-sheet
 * - assets/docs/don-phin-speaker-bio.pdf              the short and extended bios
 * - assets/docs/sales-on-stage-field-guide.pdf        the Field Guide & Workbook
 * - assets/docs/the-six-stories-of-selling.pdf        The Six Stories of Selling
 * - assets/docs/victim-villain-hero-exercises.pdf     the Victim, Villain & Hero exercises
 * - assets/images/sales-on-stage/book-cover.webp      the book's cover (drawn until then)
 * The 40//40 Solution's PDFs and audio are the Private Counsel resources of the same name
 * (their document is set there, in the admin). The book's "Learn more" and the articles
 * are set below.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$images      = get_stylesheet_directory_uri() . '/assets/images/';
$contact_url = home_url( '/speaking/contact/' );

// The speaker reel (the same as on the Speaking page)
$reel_id = 'fTTt8cN4qWA';

// The book's full title
$book_title    = 'Sales on Stage™';
$book_subtitle = 'Six Stories That Make or Break the Sale';

// Where the book's page is, once it is ('' until then)
$book_url = '';

/**
 * A file in the theme, as a URL, or '' if it isn't there yet
 */
$theme_file = function ( $path ) {
	return file_exists( get_stylesheet_directory() . $path ) ? get_stylesheet_directory_uri() . $path : '';
};

/**
 * A Private Counsel resource, by its address, as a card: its document to download if it
 * has one, its own page if not, or "Coming soon" if it isn't published
 */
$counsel_resource = function ( $slug, $card ) {
	$sides = donphin_resource_sides();
	$post  = get_page_by_path( $slug, OBJECT, $sides['counsel']['post_type'] );
	if ( ! $post || 'publish' !== $post->post_status ) {
		return $card + array( 'url' => '' );
	}

	$resource = donphin_resource( $post );
	if ( $resource['file'] ) {
		return $card + array(
			'url'      => $resource['file']['url'],
			'download' => true,
		);
	}
	return $card + array( 'url' => $resource['url'] );
};

// What a sales team walks away with: the point, then what it means
$takeaways = array(
	array( 'Recognize the Six Stories', 'Understand the stories influencing every sales conversation, including the ones nobody says out loud.' ),
	array( 'Master the Roles We Play', 'Recognize when you or your buyer slips into Victim, Villain, or Hero mode—and learn how to shift the dynamic.' ),
	array( 'Connect Beyond Logic', 'Understand how feelings and emotions influence buying decisions, even when the facts make perfect sense.' ),
	array( 'Change the Story. Change the Sale.', 'Walk away with practical tools to challenge assumptions, change perspectives, and create better sales conversations.' ),
);

// For meeting planners, each drawn as a small cover in its own colour ('cover': navy, blue, gold or paper)
$planner_items = array(
	array(
		'title'    => 'Speaker One-Sheet',
		'text'     => 'Program description, audience takeaways, and speaker information.',
		'button'   => 'Download the one-sheet',
		'url'      => $theme_file( '/assets/docs/sales-on-stage-one-sheet.pdf' ),
		'download' => true,
		'cover'    => 'paper',
		'kind'     => 'One-sheet',
	),
	array(
		'title'    => 'Speaker Bio',
		'text'     => 'Short and extended biographies for conference programs and promotional materials.',
		'button'   => 'Download the bio',
		'url'      => $theme_file( '/assets/docs/don-phin-speaker-bio.pdf' ),
		'download' => true,
		'cover'    => 'blue',
		'kind'     => 'Bio',
	),
	array(
		'title'  => 'Speaker Photos',
		'text'   => 'Downloadable headshots and onstage photographs.',
		'button' => 'See the photos',
		'url'    => '#dp-res-photos',
		'cover'  => 'gold',
		'kind'   => 'Photos',
	),
	array(
		'title'  => 'Speaking Video',
		'text'   => 'Don’s speaker reel.',
		'button' => 'Watch the video',
		'url'    => '#dp-res-title',
		'cover'  => 'navy',
		'kind'   => 'Video',
	),
);

// The worksheets and field guide (only Don's approved materials; more as they're ready)
$worksheets = array(
	array(
		'title'    => 'Sales on Stage™ Field Guide & Workbook',
		'url'      => $theme_file( '/assets/docs/sales-on-stage-field-guide.pdf' ),
		'download' => true,
		'cover'    => 'navy',
		'kind'     => 'Field guide',
	),
	array(
		'title'    => 'The Six Stories of Selling',
		'url'      => $theme_file( '/assets/docs/the-six-stories-of-selling.pdf' ),
		'download' => true,
		'cover'    => 'gold',
		'kind'     => 'Worksheet',
	),
	array(
		'title'    => 'Victim, Villain & Hero Exercises',
		'url'      => $theme_file( '/assets/docs/victim-villain-hero-exercises.pdf' ),
		'download' => true,
		'cover'    => 'blue',
		'kind'     => 'Exercises',
	),
);

// The 40//40 Solution: the book in PDF, and its sales excerpt in PDF and audio
$forty_forty = array(
	$counsel_resource(
		'the-40-40-solution-mastering-emotional-energy-in-leadership-and-sales',
		array(
			'title'  => 'The 40//40 Solution – Mastering Emotional Energy in Leadership and Sales',
			'button' => 'Download the PDF',
			'cover'  => 'navy',
			'kind'   => 'PDF',
		)
	),
	$counsel_resource(
		'the-40-40-solution-in-sales',
		array(
			'title'  => 'The 40//40 Solution in Sales – Book Excerpt',
			'button' => 'Download the PDF',
			'cover'  => 'paper',
			'kind'   => 'PDF excerpt',
		)
	),
	$counsel_resource(
		'the-40-40-solution-in-sales-audio',
		array(
			'title'  => 'The 40//40 Solution in Sales – Book Excerpt',
			'button' => 'Listen to the excerpt',
			'cover'  => 'gold',
			'kind'   => 'Audio excerpt',
		)
	),
);

// Articles, interviews and podcasts, once approved: each array( 'kind', 'title', 'url' )
$articles = array();

$book_cover = $theme_file( '/assets/images/sales-on-stage/book-cover.webp' );

// Press photos: shown small, downloaded full size
$photos = array(
	array( 'On stage', 'speaking/donSpeaking_169-960.webp', 'speaking/donSpeaking_169.webp', 'Don Phin on stage in front of a purple curtain, smiling and pointing to the audience', '42% 30%' ),
	array( 'Headshot', 'donPhin-graybg.webp', 'donPhin-graybg.webp', 'Don Phin, Esq., headshot on a grey background', '50% 22%' ),
	array( 'Audience engagement', 'speaking/stage-800.webp', 'speaking/stage-2200.webp', 'Don Phin at the podium as the audience raises their hands', '62% 40%' ),
);

/**
 * The orange call to action to the Speaking contact page
 */
$cta = function ( $label = 'Discuss Your Sales Conference' ) use ( $contact_url ) {
	?>
	<a class="dp-res-button dp-res-button--cta" href="<?php echo esc_url( $contact_url ); ?>">
		<?php echo esc_html( $label ); ?>
		<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
	</a>
	<?php
};

/**
 * A resource card: its drawn cover beside its words, and its button (or "Coming soon").
 * 'download' => true makes the button a download rather than a link.
 */
$card = function ( $item ) {
	?>
	<article class="dp-res-card dp-res-card--doc">
		<div class="dp-res-cover dp-res-cover--<?php echo esc_attr( $item['cover'] ); ?>" aria-hidden="true">
			<span class="dp-res-cover-kind"><?php echo esc_html( $item['kind'] ); ?></span>
			<span class="dp-res-cover-title"><?php echo esc_html( $item['title'] ); ?></span>
			<span class="dp-res-cover-by">Don Phin, Esq.</span>
		</div>

		<div class="dp-res-card-body">
			<h3 class="dp-res-card-title"><?php echo donphin_tm( $item['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped by donphin_tm() ?></h3>
			<?php if ( ! empty( $item['text'] ) ) : ?>
				<p class="dp-res-card-text"><?php echo esc_html( $item['text'] ); ?></p>
			<?php endif; ?>

			<?php if ( $item['url'] ) : ?>
				<a class="dp-res-button" href="<?php echo esc_url( $item['url'] ); ?>"<?php echo empty( $item['download'] ) ? '' : ' download'; ?>>
					<?php echo esc_html( isset( $item['button'] ) ? $item['button'] : 'Download the PDF' ); ?>
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			<?php else : ?>
				<span class="dp-res-soon">Coming soon</span>
			<?php endif; ?>
		</div>
	</article>
	<?php
};
?>

<!-- The stage: the title, the promise and the button on the left under a spotlight, the
     speaker reel on the right with the resources fanned over its corner, then an index -->
<section class="dp-res-intro" aria-labelledby="dp-res-title">
	<div class="dp-res-intro-container">

		<div class="dp-res-intro-words">
			<p class="dp-speak-label">Resources</p>
			<h1 id="dp-res-title" class="dp-res-title"><?php echo donphin_tm( $book_title ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped by donphin_tm() ?> <em class="dp-res-title-accent"><?php echo esc_html( $book_subtitle ); ?></em></h1>
			<p class="dp-res-tagline">Every sale is a story. Every buyer and seller plays a role. Discover how changing the story can change the sale.</p>

			<div class="dp-res-intro-actions">
				<?php $cta(); ?>
				<a class="dp-res-intro-link" href="#dp-res-planners">
					Browse the resources
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</div>
		</div>

		<div class="dp-res-intro-stage">
			<!-- Speaker reel: a still until it is played -->
			<div class="dp-video dp-speak-reel dp-res-reel" data-video="<?php echo esc_attr( $reel_id ); ?>" data-title="<?php esc_attr_e( 'Don Phin speaker reel', 'don-phin-esq' ); ?>">
				<a
					class="dp-video-play"
					href="<?php echo esc_url( 'https://www.youtube.com/watch?v=' . $reel_id ); ?>"
					target="_blank"
					rel="noopener"
					aria-label="<?php esc_attr_e( 'Play Don Phin’s speaker reel (opens on YouTube if the player cannot load)', 'don-phin-esq' ); ?>"
				>
					<img
						src="<?php echo esc_url( $images . 'speaking/reel2-1280.webp' ); ?>"
						srcset="<?php echo esc_attr( $images . 'speaking/reel2-960.webp 960w, ' . $images . 'speaking/reel2-1280.webp 1280w' ); ?>"
						sizes="(max-width: 991px) 92vw, 46vw"
						alt=""
						width="1280"
						height="720"
						loading="eager"
						decoding="async"
						fetchpriority="high"
					/>
					<span class="dp-video-icon" aria-hidden="true">
						<svg width="34" height="34" viewBox="0 0 24 24" fill="currentColor" focusable="false">
							<path d="M8 5.5v13l11-6.5z"></path>
						</svg>
					</span>
				</a>
			</div>

			<!-- The resources, fanned over the corner -->
			<div class="dp-res-intro-fan" aria-hidden="true">
				<span class="dp-res-cover dp-res-cover--paper"><span class="dp-res-cover-kind">One-sheet</span><span class="dp-res-cover-title">Sales on Stage<sup class="dp-tm">™</sup></span><span class="dp-res-cover-by">Don Phin, Esq.</span></span>
				<span class="dp-res-cover dp-res-cover--gold"><span class="dp-res-cover-kind">Field guide</span><span class="dp-res-cover-title">Sales on Stage<sup class="dp-tm">™</sup></span><span class="dp-res-cover-by">Don Phin, Esq.</span></span>
				<span class="dp-res-cover dp-res-cover--navy"><span class="dp-res-cover-kind">Book</span><span class="dp-res-cover-title">Sales on Stage<sup class="dp-tm">™</sup></span><span class="dp-res-cover-by">Don Phin, Esq.</span></span>
			</div>
		</div>

	</div>

	<nav class="dp-res-index" aria-label="<?php esc_attr_e( 'On this page', 'don-phin-esq' ); ?>">
		<ol class="dp-res-index-list">
			<li><a href="#dp-res-planners"><span class="dp-res-index-num">01</span> For Meeting Planners</a></li>
			<li><a href="#dp-res-book"><span class="dp-res-index-num">02</span> The Book</a></li>
			<li><a href="#dp-res-worksheets"><span class="dp-res-index-num">03</span> Downloads</a></li>
			<li><a href="#dp-res-about"><span class="dp-res-index-num">04</span> About Don</a></li>
		</ol>
	</nav>
</section>

<!-- The story, then what a sales team walks away with -->
<section class="dp-res-story" aria-labelledby="dp-res-takeaways-title">
	<div class="dp-res-container">

		<div class="dp-res-story-lead">
			<p class="dp-res-story-tagline">The sale doesn’t happen just because the logic makes sense.</p>
			<p>Ever lose a sale you were sure you’d win? All the facts lined up. The buyer seemed interested. Everything made sense.</p>
			<p class="dp-res-story-turn">Except the outcome.</p>
			<p class="dp-res-story-welcome">Welcome to the emotional side of selling.</p>
			<p>Explore the stories we tell ourselves, the stories our buyers tell themselves, and the roles we play in every sales conversation.</p>
		</div>

		<header class="dp-res-head">
			<p class="dp-speak-label">The keynote</p>
			<h2 id="dp-res-takeaways-title" class="dp-res-heading">What Your Sales Team Will Walk Away With</h2>
		</header>

		<ol class="dp-res-takeaways">
			<?php foreach ( $takeaways as $i => $takeaway ) : ?>
				<li class="dp-res-takeaway">
					<span class="dp-res-takeaway-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<h3 class="dp-res-takeaway-title"><?php echo esc_html( $takeaway[0] ); ?></h3>
					<p class="dp-res-takeaway-text"><?php echo esc_html( $takeaway[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>

		<div class="dp-res-cta">
			<?php $cta( 'Book Don for Your Next Sales Conference' ); ?>
		</div>

	</div>
</section>

<section class="dp-res-downloads" id="dp-res-planners" aria-labelledby="dp-res-planners-title">
	<div class="dp-res-container">

		<header class="dp-res-head">
			<p class="dp-speak-label">Meeting planners</p>
			<h2 id="dp-res-planners-title" class="dp-res-heading">For Meeting Planners</h2>
			<p class="dp-res-head-line">Everything needed to evaluate and promote Don’s Sales on Stage™ keynote.</p>
		</header>

		<div class="dp-res-cards dp-res-cards--docs">
			<?php array_map( $card, $planner_items ); ?>
		</div>

		<div class="dp-res-cta">
			<?php $cta(); ?>
		</div>

	</div>
</section>

<section class="dp-res-media" id="dp-res-photos" aria-labelledby="dp-res-media-title">
	<div class="dp-res-container">

		<header class="dp-res-head">
			<p class="dp-speak-label dp-res-label-light">Media</p>
			<h2 id="dp-res-media-title" class="dp-res-heading dp-res-heading--light">Speaker Photos</h2>
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

<section class="dp-res-tools" id="dp-res-book" aria-labelledby="dp-res-book-title">
	<div class="dp-res-container">

		<!-- The book, featured across the width: its cover once it's added, drawn until then -->
		<article class="dp-res-feature">
			<?php if ( $book_cover ) : ?>
				<img
					class="dp-res-feature-book"
					src="<?php echo esc_url( $book_cover ); ?>"
					alt="<?php echo esc_attr( $book_title . ': ' . $book_subtitle . ', by Don Phin, Esq.' ); ?>"
					loading="lazy"
					decoding="async"
				/>
			<?php else : ?>
				<div class="dp-res-cover dp-res-cover--navy dp-res-cover--feature" aria-hidden="true">
					<span class="dp-res-cover-kind">Book</span>
					<span class="dp-res-cover-title"><?php echo donphin_tm( $book_title ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped by donphin_tm() ?></span>
					<span class="dp-res-cover-sub"><?php echo esc_html( $book_subtitle ); ?></span>
					<span class="dp-res-cover-by">Don Phin, Esq.</span>
				</div>
			<?php endif; ?>
			<div class="dp-res-feature-body">
				<p class="dp-res-card-eyebrow">The book</p>
				<h2 id="dp-res-book-title" class="dp-res-card-title"><?php echo donphin_tm( $book_title ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped by donphin_tm() ?></h2>
				<p class="dp-res-card-sub"><?php echo esc_html( $book_subtitle ); ?></p>
				<p class="dp-res-card-text">Sales on Stage™ explores how the stories we tell ourselves and the roles we play influence our relationships, conversations, and sales outcomes.</p>
				<p class="dp-res-card-text">The book expands on the ideas behind the keynote and provides additional opportunities for reflection and application.</p>
				<?php if ( $book_url ) : ?>
					<a class="dp-res-button" href="<?php echo esc_url( $book_url ); ?>">
						Learn more about the book
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
					</a>
				<?php else : ?>
					<span class="dp-res-soon dp-res-soon--light">Learn more · Coming soon</span>
				<?php endif; ?>
			</div>
		</article>

	</div>
</section>

<section class="dp-res-downloads dp-res-worksheets" id="dp-res-worksheets" aria-labelledby="dp-res-worksheets-title">
	<div class="dp-res-container">

		<header class="dp-res-head">
			<p class="dp-speak-label">Downloads</p>
			<h2 id="dp-res-worksheets-title" class="dp-res-heading">Worksheets &amp; Field Guide</h2>
			<p class="dp-res-head-line">Take the ideas off the stage and into your next sales conversation.</p>
		</header>

		<div class="dp-res-cards dp-res-cards--docs dp-res-cards--three">
			<?php array_map( $card, $worksheets ); ?>
		</div>

		<h3 class="dp-res-subhead">From The 40//40 Solution</h3>

		<div class="dp-res-cards dp-res-cards--docs dp-res-cards--three">
			<?php array_map( $card, $forty_forty ); ?>
		</div>

	</div>
</section>

<!-- About Don: the portrait, his story, and his books -->
<section class="dp-res-about" id="dp-res-about" aria-labelledby="dp-res-about-title">
	<div class="dp-res-container">
		<div class="dp-res-about-grid">

			<figure class="dp-res-about-portrait">
				<img
					src="<?php echo esc_url( $images . 'counsel/portrait-1000.webp' ); ?>"
					srcset="<?php echo esc_attr( $images . 'counsel/portrait-640.webp 640w, ' . $images . 'counsel/portrait-1000.webp 1000w' ); ?>"
					sizes="(max-width: 767px) 80vw, 34vw"
					alt="Don Phin, Esq."
					width="1000"
					height="1210"
					loading="lazy"
					decoding="async"
				/>
			</figure>

			<div class="dp-res-about-words">
				<p class="dp-speak-label">About Don</p>
				<h2 id="dp-res-about-title" class="dp-res-heading">Facts alone never win a room. <em>Stories do.</em></h2>
				<p class="dp-res-about-text">Don Phin, Esq. spent seventeen years as a trial litigator, arguing employment and business cases to juries — learning, case by case, that facts alone never win a room. Stories do.</p>
				<p class="dp-res-about-text">Today Don delivers his signature keynote, <em>Sales on Stage</em>, to industry sales groups and company sales teams across the country.</p>

				<ul class="dp-res-about-books" aria-label="<?php esc_attr_e( 'Books by Don', 'don-phin-esq' ); ?>">
					<li>
						<span class="dp-res-about-book-kind">Author</span>
						<span class="dp-res-about-book-title"><?php echo donphin_tm( $book_title ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped by donphin_tm() ?></span>
						<span class="dp-res-about-book-sub"><?php echo esc_html( $book_subtitle ); ?></span>
					</li>
					<li>
						<span class="dp-res-about-book-kind">Author</span>
						<span class="dp-res-about-book-title">The 40//40 Solution</span>
						<span class="dp-res-about-book-sub">Managing the Emotional Energy of Leadership and Sales</span>
					</li>
				</ul>
			</div>

		</div>
	</div>
</section>

<section class="dp-res-tools dp-res-articles" id="dp-res-articles" aria-labelledby="dp-res-articles-title">
	<div class="dp-res-container">

		<header class="dp-res-head">
			<p class="dp-speak-label">Further reading</p>
			<h2 id="dp-res-articles-title" class="dp-res-heading">Articles, Interviews &amp; Additional Resources</h2>
		</header>

		<?php if ( $articles ) : ?>
			<ul class="dp-res-articles-list">
				<?php foreach ( $articles as $article ) : ?>
					<li>
						<a class="dp-res-article" href="<?php echo esc_url( $article['url'] ); ?>">
							<span class="dp-res-article-kind"><?php echo esc_html( $article['kind'] ); ?></span>
							<span class="dp-res-article-title"><?php echo esc_html( $article['title'] ); ?></span>
							<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="dp-res-placeholder">Coming soon</p>
		<?php endif; ?>

	</div>
</section>

<section class="dp-res-quote dp-res-closing" aria-labelledby="dp-res-closing-title">
	<div class="dp-res-quote-text">
		<p class="dp-res-closing-lead">Now you know where the ideas came from.</p>
		<h2 id="dp-res-closing-title" class="dp-res-closing-title">“And that’s my story. <strong>Now, let’s talk about yours.</strong>”</h2>
		<?php $cta(); ?>
	</div>
</section>

<?php
get_footer();
