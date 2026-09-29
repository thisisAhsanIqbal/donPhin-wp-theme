<?php
/**
 * Template Name: Private Counsel Page
 *
 * Used automatically by the page with the slug "private-counsel".
 *
 * Built around one idea, a life well-built: the headline in an arched portrait,
 * the five dimensions of a life as five simple cards,
 * the one room where nothing is performed, the first step (the Whole Life
 * Assessment) in the same ivory, and the invitation to enquire
 * beside Don's gift, The Inner Climb.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$images = get_stylesheet_directory_uri() . '/assets/images/counsel/';

// The contact form opens with "Private counsel" already chosen
$enquire_url = add_query_arg( 'topic', 'counsel', home_url( '/contact/' ) );

// The five chapters of a life, each a card with its name and a line icon (24x24 SVG insides)
$chapters = array(
	'Wealth'        => '<circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18"/><path d="M7 6h1v4"/><path d="m16.71 13.88.7.71-2.82 2.82"/>',
	'Purpose'       => '<circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>',
	'Health'        => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/><path d="M3.22 12H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27"/>',
	'Relationships' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
	'Spirit'        => '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>',
);
?>

<section class="dp-pc-hero" aria-labelledby="dp-pc-title">

	<!-- Depth only: the light behind the portrait, the echo of the arch, and grain -->
	<div class="dp-pc-hero-scene" aria-hidden="true"></div>

	<div class="dp-pc-hero-container">

		<div class="dp-pc-hero-content">
			<p class="dp-pc-eyebrow">Private counsel</p>

			<h1 id="dp-pc-title" class="dp-pc-title">
				You’ve built the wealth, now is the opportunity to <em class="dp-pc-gold-accent">build the life</em> it was supposed to make possible.
			</h1>

			<p class="dp-pc-hero-lead">
				I work with a few good men at a time <br class="dp-pc-break">for one year to help them transform their lives.
			</p>

			<blockquote class="dp-pc-hero-creed">
				<span class="dp-pc-creed-not">This is not about having more</span>
				<span class="dp-pc-creed-is">It’s counsel for <em class="dp-pc-gold-accent">what matters most.</em></span>
			</blockquote>

			<div class="dp-pc-hero-actions">
				<a href="<?php echo esc_url( $enquire_url ); ?>" class="dp-pc-button">
					Request a conversation
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
				<span class="dp-pc-hero-note">A few seats &middot; By enquiry</span>
			</div>
		</div>

		<figure class="dp-pc-portrait">
			<div class="dp-pc-arch">
				<img
					src="<?php echo esc_url( $images . 'portrait-1000.webp' ); ?>"
					srcset="<?php echo esc_attr( $images . 'portrait-640.webp 640w, ' . $images . 'portrait-1000.webp 1000w' ); ?>"
					sizes="(max-width: 991px) 80vw, 34vw"
					alt="Don Phin, Esq."
					width="1000"
					height="1210"
					loading="eager"
					decoding="async"
					fetchpriority="high"
				/>
			</div>
			<figcaption class="dp-pc-portrait-caption">
				<span class="dp-pc-portrait-name">Don Phin, Esq.</span>
				<span class="dp-pc-portrait-roles">
					Counsel<span class="dp-pc-diamond" aria-hidden="true"></span>Confidant<span class="dp-pc-diamond" aria-hidden="true"></span>Guide
				</span>
			</figcaption>
		</figure>

		<!-- The three terms of the work, carrying the foot of the hero -->
		<ul class="dp-pc-hero-terms">
			<li>
				<span class="dp-pc-term-name">Personal</span>
				<span class="dp-pc-term-note">A few men at a time. Never more.</span>
			</li>
			<li>
				<span class="dp-pc-term-name">Confidential</span>
				<span class="dp-pc-term-note">Nothing leaves the room.</span>
			</li>
			<li>
				<span class="dp-pc-term-name">Fully present</span>
				<span class="dp-pc-term-note">No script. No agenda.</span>
			</li>
		</ul>

	</div>
</section>

<section class="dp-pc-chapters" aria-labelledby="dp-pc-chapters-title">
	<div class="dp-pc-chapters-container">

		<header class="dp-pc-chapters-head">
			<!-- Not shown; names the section for screen readers -->
			<h2 id="dp-pc-chapters-title" class="dp-pc-sr">The five dimensions of a life</h2>
			<p class="dp-pc-chapters-lead">
				You’ve been extraordinarily intentional about building one dimension of your life.
			</p>
			<p class="dp-pc-chapters-question">What might happen if you brought that same intention to the others?</p>
		</header>

		<!-- One gold ring per dimension, joined by a single line: an icon and its name -->
		<ul class="dp-pc-chapter-list">
			<?php foreach ( $chapters as $name => $icon ) : ?>
				<li class="dp-pc-chapter">
					<span class="dp-pc-chapter-mark"><svg class="dp-pc-chapter-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?></svg></span>
					<h3 class="dp-pc-chapter-name"><?php echo esc_html( $name ); ?></h3>
				</li>
			<?php endforeach; ?>
		</ul>

	</div>
</section>

<section class="dp-pc-setting" aria-labelledby="dp-pc-setting-title">
	<div class="dp-pc-setting-container">

		<figure class="dp-pc-room">
			<img
					src="<?php echo esc_url( $images . 'room-1400.webp' ); ?>"
					srcset="<?php echo esc_attr( $images . 'room-900.webp 900w, ' . $images . 'room-1400.webp 1400w, ' . $images . 'room-2000.webp 2000w' ); ?>"
					sizes="(max-width: 991px) 92vw, 54vw"
					alt="Don Phin in a private conversation with a client in a book-lined study"
					width="1400"
					height="985"
					loading="lazy"
					decoding="async"
				/>
		</figure>

		<div class="dp-pc-setting-content">
			<h2 id="dp-pc-setting-title" class="dp-pc-setting-title">
				You need one room where <em class="dp-pc-gold-accent">nothing is performed.</em>
			</h2>
			<p class="dp-pc-setting-text">
				A confidential environment where you do not have to protect an image, appear certain, or already know the answer. A place where you can slow down, examine the whole situation, and tell yourself the truth.
			</p>
			<p class="dp-pc-setting-note">Not everybody wants to have their private conversations with a group.</p>
		</div>

	</div>
</section>

<!-- Continues the setting on the same ivory and grid: the heading under the photograph, the detail under the text -->
<section class="dp-pc-firststep" aria-labelledby="dp-pc-firststep-title">
	<div class="dp-pc-firststep-container">

		<div class="dp-pc-firststep-head">
			<p class="dp-pc-eyebrow">The first step</p>
			<h2 id="dp-pc-firststep-title" class="dp-pc-firststep-title">
				Before I agree to spend a year with someone, I want to understand him &mdash; <em class="dp-pc-gold-accent">and I want him to understand me.</em>
			</h2>
		</div>

		<div class="dp-pc-firststep-body">
			<p>The Whole Life Assessment is a separate, in-depth engagement exploring where you are today across Purpose, Relationships, Health and Spirit.</p>
			<p>At its conclusion, I’ll tell you what I see and, if we both believe a year together makes sense, I’ll design that year specifically around you.</p>
		</div>

	</div>
</section>

<section class="dp-pc-enquire" id="enquiries" aria-labelledby="dp-pc-enquire-title">
	<div class="dp-pc-enquire-container">

		<div class="dp-pc-enquire-main">
			<p class="dp-pc-eyebrow">Enquiries</p>
			<h2 id="dp-pc-enquire-title" class="dp-pc-enquire-title">
				One conversation is usually <em class="dp-pc-gold-accent">enough to know.</em>
			</h2>
			<p class="dp-pc-enquire-text">
				If someone referred you here, I would be pleased to learn more about your situation and determine whether we are the right fit.
			</p>
			<a href="<?php echo esc_url( $enquire_url ); ?>" class="dp-pc-button">
				Request a conversation
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</div>

		<aside class="dp-pc-gift" aria-labelledby="dp-pc-gift-title">

			<!-- The cover: a path climbing to a summit -->
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

			<div class="dp-pc-gift-content">
				<p class="dp-pc-gift-eyebrow">A gift from Don</p>
				<h3 id="dp-pc-gift-title" class="dp-pc-gift-title">The Inner Climb</h3>
				<p class="dp-pc-gift-text">Insights for the journey toward purpose, connection, and inner wholeness.</p>
			</div>

		</aside>

	</div>
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
