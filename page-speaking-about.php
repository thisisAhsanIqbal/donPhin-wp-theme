<?php
/**
 * Template Name: About Page
 *
 * Used automatically by the page with the slug "about".
 *
 * Don's portrait beside the headline and his credentials, the arc of his career
 * as an editorial spread (a pulled line, then Don on stage beside today's work),
 * the highlights as a fact sheet on navy, a word from the room,
 * and the invitation to bring him to your stage.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$portrait = get_stylesheet_directory_uri() . '/assets/images/counsel/';
$stage    = get_stylesheet_directory_uri() . '/assets/images/speaking/';

// The contact form opens with "Speaking" already chosen
$book_url = add_query_arg( 'topic', 'speaking', home_url( '/contact/' ) );

// Credentials under the headline
$credentials = array(
	'Trial litigator',
	'Founder, HRThatWorks',
	'700+ presentations',
	'Author, The Emotional Edge',
	'Author, The 40//40 Solution',
);

// The career at a glance: the figure, the title, and the detail after the dash
$highlights = array(
	array( '17 yrs', 'Trial Litigator', 'Whistleblower & glass-ceiling employment cases, arguing to juries statewide.' ),
	array( 'Founder', 'HRThatWorks', 'Built and sold to ThinkHR; served 3,500+ companies.' ),
	array( '700+', 'Presentations', 'Including 500+ to Vistage CEO groups nationwide.' ),
	array( '15+', 'LinkedIn Learning Courses', 'Reaching over one million professionals.' ),
	array( 'Today', 'The Emotional Edge', 'Program and manuscript built around the Victim / Villain / Hero framework.' ),
	array( 'Author', 'The 40//40 Solution', 'Managing the Emotional Energy of Leadership and Sales.' ),
);
?>

<section class="dp-about-hero" aria-labelledby="dp-about-title">
	<div class="dp-about-hero-container">

		<figure class="dp-about-portrait">
			<img
				src="<?php echo esc_url( $portrait . 'portrait-1000.webp' ); ?>"
				srcset="<?php echo esc_attr( $portrait . 'portrait-640.webp 640w, ' . $portrait . 'portrait-1000.webp 1000w' ); ?>"
				sizes="(max-width: 991px) 100vw, 45vw"
				alt="Don Phin, Esq."
				width="1000"
				height="1210"
				loading="eager"
				decoding="async"
				fetchpriority="high"
			/>
		</figure>

		<div class="dp-about-hero-content">
			<p class="dp-about-eyebrow">About Don</p>

			<h1 id="dp-about-title" class="dp-about-title">Don has been selling his entire career.</h1>

			<p class="dp-about-intro">
				First, he sold ideas to juries as a trial lawyer. Then he sold his own vision while building a company from the ground up. For decades since, he’s been studying and speaking about what actually causes people to trust, decide, change and act.
			</p>

			<ul class="dp-about-tags" aria-label="<?php esc_attr_e( 'Credentials', 'don-phin-esq' ); ?>">
				<?php foreach ( $credentials as $credential ) : ?>
					<li><?php echo esc_html( $credential ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>

	</div>
</section>

<section class="dp-about-arc" aria-labelledby="dp-about-arc-title">
	<div class="dp-about-arc-container">

		<!-- The heading runs into a gold hairline, like a chapter opening -->
		<header class="dp-about-section-head">
			<h2 id="dp-about-arc-title" class="dp-about-section-title">The Arc</h2>
			<span class="dp-about-section-rule" aria-hidden="true"></span>
		</header>

		<div class="dp-about-arc-opening">
			<p class="dp-about-arc-lead">Don Phin, Esq. spent seventeen years as a trial litigator, arguing whistleblower and glass-ceiling cases to juries — learning, case by case, that facts alone never win a room. <em>Stories do.</em></p>
			<p class="dp-about-arc-text">He left the courtroom to build HRThatWorks from the ground up, growing it to serve 3,500 companies before selling it. That exit taught him something litigation had only pointed at: no matter what work you do, you’re in sales.</p>
		</div>

		<blockquote class="dp-about-arc-pull">
			<p>Most sales aren’t lost because of what happens in the room. They’re lost because of what happened before you ever walked in.</p>
		</blockquote>

		<div class="dp-about-arc-today">
			<figure class="dp-about-arc-photo">
				<img
					src="<?php echo esc_url( $stage . 'stage-1400.webp' ); ?>"
					srcset="<?php echo esc_attr( $stage . 'stage-800.webp 800w, ' . $stage . 'stage-1400.webp 1400w, ' . $stage . 'stage-2200.webp 2200w' ); ?>"
					sizes="(max-width: 991px) 100vw, 52vw"
					alt="Don Phin on stage at a podium, waving to an audience with hands raised"
					width="1400"
					height="933"
					loading="lazy"
					decoding="async"
				/>
			</figure>

			<div class="dp-about-arc-today-body">
				<p class="dp-about-arc-text">Today Don delivers his signature program, <em>The Emotional Edge</em>, to industry groups and company sales teams across the country — still doing what he’s always done: helping people see what’s really driving the room, so they can sell, lead and decide better.</p>

				<blockquote class="dp-about-arc-aside">
					<p>“Have you ever lost a sale where all the logic was there for it to happen? The reality is, you didn’t lose it logically, you lost it emotionally. As I like to remind folks, <strong>if it doesn’t make sense, don’t try to make sense out of it!</strong>”</p>
				</blockquote>
			</div>
		</div>

	</div>
</section>

<section class="dp-about-highlights" aria-labelledby="dp-about-highlights-title">
	<div class="dp-about-highlights-container">

		<header class="dp-about-section-head">
			<h2 id="dp-about-highlights-title" class="dp-about-section-title">Highlights</h2>
			<span class="dp-about-section-rule" aria-hidden="true"></span>
		</header>

		<!-- A fact sheet: the figure large, then what it stands for -->
		<dl class="dp-about-facts">
			<?php foreach ( $highlights as $highlight ) : ?>
				<?php $is_number = (bool) preg_match( '/^\d/', $highlight[0] ); ?>
				<div class="dp-about-fact">
					<dt class="dp-about-fact-figure<?php echo $is_number ? '' : ' dp-about-fact-figure--word'; ?>"><?php echo esc_html( $highlight[0] ); ?></dt>
					<dd class="dp-about-fact-body">
						<span class="dp-about-fact-title"><?php echo esc_html( $highlight[1] ); ?></span>
						<span class="dp-about-fact-text"><?php echo esc_html( $highlight[2] ); ?></span>
					</dd>
				</div>
			<?php endforeach; ?>
		</dl>

	</div>
</section>

<section class="dp-about-words" aria-labelledby="dp-about-words-title">
	<div class="dp-about-words-container">

		<h2 id="dp-about-words-title" class="dp-about-eyebrow dp-about-words-eyebrow">In his own words — from the room</h2>

		<figure class="dp-about-words-figure">
			<blockquote class="dp-about-words-quote">
				<p>“Don Phin presented The 40//40 Solution for Leadership in Sales. He’s been wowing our members in-person and via webinars for 17 years. Catch his in-person performance. And, it’s not just for salespeople. It’s for life.”</p>
			</blockquote>
			<figcaption class="dp-about-words-by">Preston Diamond, President, Institute of WorkComp Advisors</figcaption>
		</figure>

	</div>
</section>

<section class="dp-about-cta" aria-labelledby="dp-about-cta-title">
	<div class="dp-about-cta-container">

		<h2 id="dp-about-cta-title" class="dp-about-cta-title">Now you know where the ideas came from.</h2>

		<a class="dp-about-cta-button" href="<?php echo esc_url( $book_url ); ?>">
			Bring Don to your stage
			<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
		</a>

	</div>
</section>

<?php
get_footer();
