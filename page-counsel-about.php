<?php
/**
 * Template Name: Private Counsel — About
 *
 * The About page for the Private Counsel section (/private-counsel/about/), written
 * for the men considering counsel: Don's life story and why he's the right person to
 * walk alongside them. Assign it to the "About" page filed under Private Counsel. It sits on the Private Counsel palette (private-counsel.css), with
 * its layout in counsel-about.css.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$images      = get_stylesheet_directory_uri() . '/assets/images/';
$enquire_url = home_url( '/private-counsel/contact/' );

// The story, told in the first person, with the pull-quote between its two halves
$story_before = array(
	'I grew up in the Bronx and went to Bronx Science. Came west for San Diego State, stayed for the ocean, and spent a stretch working on a tuna boat — which taught me more about hard work than law school did. McGeorge gave me the JD in 1983, and I spent the next seventeen years as a plaintiff’s-side employment lawyer.',
	'I thought I was representing victims against villainous bosses. That was my story about my own work, and I believed it completely.',
	'What eventually broke it was something I saw in every single trial. Twelve jurors would hear one identical set of facts and walk out with twelve different accounts of what happened. Same reality. Different stories. And the stories — not the facts — decided the outcome.',
);

$story_after = array(
	'That observation has run my career ever since. I stopped suing employers and started helping them. In 2002 I built HR That Works, ran its hotline for 3,500 client companies largely on my own, and sold it to ThinkHR in 2014. I stayed two years as a VP, helped build their handbook builder, and left on schedule.',
	'I’d love to tell you I arrived at the story insight as a clean piece of professional analysis. I didn’t. I was divorced, burned out and broke when I started applying it to my own life. It worked on me before it ever worked on a client.',
);

// Why he's the right person to walk alongside you, in his words
$why = array(
	'I have worked with over 6000 CEOs, and many of their teams, to develop better stories so they produce better results. These stories affect our culture, engagement, brand, ability to sell, and career opportunities. When people have the right stories, like the ones that work with reality, life is good. When they have the wrong stories, they fight reality and get frustrated, anxious, and angry.',
	'What makes me unique is the ability to move past the apparent logic of a situation, and listen to discover deeper and often simpler causes. One of the most damaging stories is the need to assert control over a situation. That story limits our opportunity and causes people to reject us. The good news is, as with most wrong stories, there is a way out, and you can replace it with the right story. The goal is for you to be the hero in a story of your own design.',
);

// DC Cordova's foreword
$foreword = array(
	'I met Don Phin as a student in the Money and You program presented by Excellerated Business Schools. I was immediately struck by his focus, pragmatism, love, and compassion.',
	'Don is the prototype of the new professional for the twenty-first century. He understands that his professional success, as well as the success of those around him, has as much to do with people’s feelings as with his technical skills or anything else.',
);
?>

<section class="dp-ca-hero" aria-labelledby="dp-ca-title">
	<div class="dp-ca-hero-container">

		<div class="dp-ca-hero-content">
			<p class="dp-pc-eyebrow">About Don</p>
			<h1 id="dp-ca-title" class="dp-ca-title">It worked on me before it ever worked <em class="dp-pc-gold-accent">on a client.</em></h1>
			<p class="dp-ca-lead">For over forty years, I’ve had the privilege of sitting with CEOs, entrepreneurs, physicians, attorneys, family business owners, and men who’ve built extraordinary lives.</p>
			<!-- Stays on the page: scrolls down to the invitation at the foot, whose button
			     leads on to the contact page -->
			<a href="#dp-ca-request" class="dp-pc-button dp-ca-jump">
				Request an introduction
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</div>

		<figure class="dp-ca-portrait">
			<img
				src="<?php echo esc_url( $images . 'donPhin-graybg.webp' ); ?>"
				alt="Don Phin, Esq."
				width="1024"
				height="1024"
				loading="eager"
				decoding="async"
				fetchpriority="high"
			/>
		</figure>

	</div>
</section>

<section class="dp-ca-story" aria-labelledby="dp-ca-story-title">
	<div class="dp-ca-story-container">

		<header class="dp-ca-head">
			<p class="dp-ca-eyebrow">My story</p>
			<h2 id="dp-ca-story-title" class="dp-ca-heading">Same reality. <em class="dp-ca-accent">Different stories.</em></h2>
		</header>

		<div class="dp-ca-story-body">
			<?php foreach ( $story_before as $paragraph ) : ?>
				<p><?php echo esc_html( $paragraph ); ?></p>
			<?php endforeach; ?>

			<blockquote class="dp-ca-pull">
				<p>Twelve people. One set of facts. Twelve different stories. The stories won.</p>
			</blockquote>

			<?php foreach ( $story_after as $paragraph ) : ?>
				<p><?php echo esc_html( $paragraph ); ?></p>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<section class="dp-ca-why" aria-labelledby="dp-ca-why-title">
	<div class="dp-ca-why-container">

		<header class="dp-ca-head">
			<p class="dp-pc-eyebrow">Why me</p>
			<h2 id="dp-ca-why-title" class="dp-ca-heading dp-ca-heading--light">To be the hero in a story <em class="dp-pc-gold-accent">of your own design.</em></h2>
		</header>

		<div class="dp-ca-why-body">
			<?php foreach ( $why as $paragraph ) : ?>
				<p><?php echo esc_html( $paragraph ); ?></p>
			<?php endforeach; ?>
		</div>

		<figure class="dp-ca-foreword">
			<blockquote class="dp-ca-foreword-text">
				<?php foreach ( $foreword as $paragraph ) : ?>
					<p><?php echo esc_html( $paragraph ); ?></p>
				<?php endforeach; ?>
			</blockquote>
			<figcaption class="dp-ca-foreword-by">
				<span class="dp-ca-foreword-name">DC Cordova</span>
				<span class="dp-ca-foreword-role">CEO of Excellerated Business Schools</span>
			</figcaption>
		</figure>

	</div>
</section>

<section class="dp-ca-close" id="dp-ca-request" aria-labelledby="dp-ca-close-title">
	<div class="dp-ca-close-container">
		<h2 id="dp-ca-close-title" class="dp-ca-close-title">The bottom line is I love my work, and so do my clients, because we produce results.</h2>
		<p class="dp-ca-close-text">How would you like to get together and learn how I can help you?</p>
		<a href="<?php echo esc_url( $enquire_url ); ?>" class="dp-ca-button">
			Request an introduction
			<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
		</a>
	</div>
</section>

<?php
get_footer();
