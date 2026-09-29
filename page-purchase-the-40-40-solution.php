<?php
/**
 * Template Name: The 40|40 Solution Page
 *
 * Used automatically by the page with the slug "purchase-the-40-40-solution", filed
 * under Speaking (/speaking/purchase-the-40-40-solution/). Part of the Speaking section.
 *
 * The video shows a still image until it is clicked, so YouTube is only contacted
 * for people who actually watch (see assets/js/book.js). Without JavaScript the
 * still is a plain link to YouTube.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$images = get_stylesheet_directory_uri() . '/assets/images/';
$book   = $images . '40-40/';

// Don's own Amazon link, the one the current site uses (it carries his tracking tag)
$buy_url = 'https://amzn.to/2maEiy3';

$reasons = array(
	'You ever engage in self-limiting nonsense. (Of course, you do.)',
	'You ever fantasize about going to work… and having nobody to deal with that day?',
	'You are exhausting yourself trying to control everything and everybody.',
	'You would like the people around you to “step up to the plate”.',
	'You’re having challenges making sales, even if all the logic is there for it to happen.',
	'You feel stuck in your career…and things need to change.',
	'You feel stuck in a relationship…and things need to change.',
	'You know what you need to do…but you are still not doing it.',
	'You want to be better at leading and serving people.',
	'You would like an emotional roadmap for being a great leader.',
);

$testimonials = array(
	array(
		'quote' => array( 'Thank you so much for presenting to our San Diego SHRM members. Your presentation was very insightful and you were hilariously engaging! We truly appreciate you taking time to share your wisdom and knowledge with our Members.' ),
		'name'  => 'Emily Mullin',
		'role'  => 'Executive Director San Diego SHRM',
	),
	array(
		'quote' => array( 'It was such a pleasure to listen to your presentation on Monday. I have shared about your 40:40 concept with several people. I have your book beside my bed and my husband is reading it too. I can’t wait to have you on my podcast!' ),
		'name'  => 'Sylvia Becker-Hill',
		'role'  => 'PCC, MA',
	),
	array(
		'quote' => array( 'Don, I really enjoyed your talk given to Sales and Leadership Marketing Alliance… I REALLY enjoyed your talk! I’m excited to read your book this weekend. I am a fan of you and will have you come in to train our team! Thank you for inspiring me and so many others!' ),
		'name'  => 'Melissa Wadley',
		'role'  => 'Director of Sales, Paylocity',
	),
	array(
		'quote' => array( 'I have been a voracious reader most of my life, particularly in the areas of leadership, management, and organizational transformation. Not much surprises me anymore. But reading The 40||40 Solution by Don Phin was an exception for me. The book provided new and powerful insights into the emotional dynamics of good leadership. In the end, leadership is about connecting and aligning with people. We can make the case that life itself is about this connection. This little book delivers the goods. Buy it. Read it. And we’ll meet you on the 40-yard lines.' ),
		'name'  => 'David Dibble',
		'role'  => 'The New Agreements For Leaders',
	),
	array(
		'quote' => array(
			'Don Phin has worked with our company for over a decade. The reason we keep coming back is his work continues to evolve, as he never stops learning. The 40||40 Solution is a perfect example. Don has a way of breaking down the complex emotional energy in relationships to basic, common sense, matter of fact thinking. It’s like reading a guidebook on how to takes the noise out of how we communicate.',
			'The best takeaway from the 40/ /40 is the space it allows for co-creation. My team has heard me say a thousand times that no one of us is smarter than any two of us. When living in the 40||40 teamwork is fostered.',
		),
		'name'  => 'Don Mader',
		'role'  => 'CEO, Southeastern Printing',
	),
	array(
		'quote' => array( 'The 40/ /40 Solution refocuses leaders from working in your business to working on relationships in your business and encouraging others to become their own hero. It also reframes our job to make people feel good about themselves every day. As a leader and 80%er, I did not realize the effect I can have on people who feel judged. Thank you for pointing this out Don. I know there are many others like me who could benefit from The 40||40 Solution.' ),
		'name'  => 'Alan Sorkin',
		'role'  => 'Master Chair Vistage International, Inc.',
	),
	array(
		'quote' => array(
			'In The 40 || 40 Solution Don Phin shows you how to apply emotional energy (yours and others) to work for you instead of against you.',
			'To be candid, I was hesitant to read this book when I received an advance review copy. As an INTJ (Myers–Briggs), the focus on emotions seemed too “touchy feely” for me.',
			'Yet the practicality of The 40 || 40 Solution and the common-sense psychology behind it surprised me.',
			'I highly recommend this book!',
		),
		'name'  => 'Mike Young',
		'role'  => 'Esq., Mike Young Law',
	),
	array(
		'quote' => array( 'Don Phin presented The 40||40 Solution to our broker clients. He’s been wowing our clients in-person and via Webinars for 17 years. Grab his new book. Catch his in-person performance. And, it’s not just for salespeople. It’s for life.' ),
		'name'  => 'Preston Diamond',
		'role'  => 'Managing Director Institute of WorkComp Professionals',
	),
	array(
		'quote' => array( 'As an engineer, I am obsessed with efficiency. Unfortunately, I’ve learned that you can’t be efficient with humans, because of these things called ’emotions.’ The 40//40 Solution takes a practical (and engaging) approach towards understanding how to manage emotional energy for better relationships with yourself and others. Using an easy-to-understand metaphor of roles (Victim, Villain, and Hero) and percentages (the 40 || 40), the authors frame the managing of emotions in a way that even an engineer like me can understand and use.' ),
		'name'  => 'Andrew Tarvin',
		'role'  => 'Founder',
	),
	array(
		'quote' => array( 'Mr. Phin’s 40| |40 Solution harnesses the power of emotional energy to inspire and motivate. I highly recommend his book and associated workshops to business leaders looking for new and creative ways to engage their professional team.' ),
		'name'  => 'Sharon R. Bock',
		'role'  => 'Esq., Clerk & Comptroller, Palm Beach County',
	),
);
?>

<section class="dp-book-hero" aria-labelledby="dp-book-title">
	<div class="dp-book-hero-container">

		<div class="dp-book-hero-content">
			<h1 id="dp-book-title" class="dp-book-title">
				You can’t think your way out of an emotional problem.
			</h1>

			<p class="dp-book-subtitle">
				Logic didn’t create the drama in your boardroom, your sales calls, or your own head — so logic isn’t going to end it. This book is about what to do with the energy instead.
			</p>

			<p class="dp-book-credit">
				<span class="dp-book-credit-title">The 40||40 Solution — Mastering the Emotional Energy of Leadership and Sales</span>
				<span class="dp-book-credit-authors">Don Phin, Esq. and Loy Young</span>
			</p>

			<div class="dp-book-actions">
				<a class="dp-dark-button" href="<?php echo esc_url( $buy_url ); ?>" target="_blank" rel="noopener">
					Get it on Amazon
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>

				<a class="dp-arrow-link" href="<?php echo esc_url( home_url( '/speaking/contact/' ) ); ?>">
					Order copies for your team
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</div>

			<p class="dp-book-trust">The book behind 700+ keynotes and 600 Vistage CEO groups.</p>
		</div>

		<div class="dp-book-cover">
			<img
				src="<?php echo esc_url( $book . 'book-3d 1.webp' ); ?>"
				alt="The 40|40 Solution: Mastering Emotional Energy in Leadership and Sales, by Don Phin, Esq. and Loy Young"
				width="1066"
				height="1606"
				loading="eager"
				decoding="async"
				fetchpriority="high"
			/>
		</div>

	</div>
</section>

<section class="dp-book-video-section" aria-label="<?php esc_attr_e( 'Video about the book', 'don-phin-esq' ); ?>">
	<div class="dp-book-video-container">
		<div class="dp-video" data-video="q-FdUTykDuA" data-title="The 40|40 Solution">
			<a
				class="dp-video-play"
				href="https://youtu.be/q-FdUTykDuA?si=g_ptfIu7l4NNoAzx"
				target="_blank"
				rel="noopener"
				aria-label="<?php esc_attr_e( 'Play the video about The 40|40 Solution (opens on YouTube if the player cannot load)', 'don-phin-esq' ); ?>"
			>
				<img
					src="<?php echo esc_url( $images . '40-40-video-cover.webp' ); ?>"
					alt=""
					width="1280"
					height="720"
					loading="lazy"
					decoding="async"
				/>
				<span class="dp-video-icon" aria-hidden="true">
					<svg width="34" height="34" viewBox="0 0 24 24" fill="currentColor" focusable="false">
						<path d="M8 5.5v13l11-6.5z"></path>
					</svg>
				</span>
			</a>
		</div>
	</div>
</section>

<section class="dp-book-letter" aria-labelledby="dp-book-letter-title">
	<div class="dp-book-letter-container">

		<h2 id="dp-book-letter-title" class="dp-book-letter-title">From the Desk of Don Phin</h2>

		<p class="dp-book-lead">
			Today’s books on “emotional intelligence” fail to address half of the problem…how we feel about people and things. If you or somebody else is engaging in nonsense, no logic or intelligence is going to solve it. Because that’s not what created it!
		</p>

		<p>
			The 40||40 Solution is your unique guide to Mastering Emotional Energy! It is the solution to ending painful and destructive dramas, whether in the boardroom, sales meeting, at home, or in conversations with yourself. Unlike most emotional intelligence books that focus on thinking your way through emotional problems, this book helps you learn how to feel your way through them. So that you can feel good about yourself afterward.
		</p>

		<p>
			When you learn The 40||40 Solution, you will be able to slay dragons, conquer fears, be a leader, sell more, share success and be happy, all without having to self-sacrifice, exhaust yourself or be out of balance. It’s your guide and path to becoming a true hero!
		</p>

	</div>
</section>

<section class="dp-book-fit" aria-labelledby="dp-book-fit-title">
	<div class="dp-book-fit-container">

		<h2 id="dp-book-fit-title" class="dp-book-fit-title">
			The 40||40 Solution is the right book for you if…
		</h2>

		<ul class="dp-book-fit-list">
			<?php foreach ( $reasons as $reason ) : ?>
				<li><?php echo esc_html( $reason ); ?></li>
			<?php endforeach; ?>
		</ul>

	</div>
</section>

<?php
/*
 * Testimonials.
 *
 * Without JavaScript this is the plain wall of quotes it has always been.
 * book.js turns it into the spotlight slider: one quote at a time, with the
 * names along the bottom as the way through them (see assets/js/book.js).
 */
$praise_total = count( $testimonials );
?>
<section class="dp-book-praise" aria-labelledby="dp-book-praise-label">
	<div class="dp-book-praise-container">

		<div class="dp-book-praise-head">
			<h2 id="dp-book-praise-label" class="dp-book-praise-label">Testimonials</h2>

			<div class="dp-book-praise-nav" hidden>
				<p class="dp-book-praise-count">
					<span class="dp-book-praise-now">01</span>
					<span class="dp-book-praise-total">/ <?php echo esc_html( sprintf( '%02d', $praise_total ) ); ?></span>
				</p>

				<button class="dp-book-praise-button dp-book-praise-prev" type="button" aria-label="Previous testimonial">
					<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" focusable="false">
						<path d="M15 4 7 12l8 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</button>

				<button class="dp-book-praise-button dp-book-praise-next" type="button" aria-label="Next testimonial">
					<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" focusable="false">
						<path d="M9 4l8 8-8 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</button>
			</div>
		</div>

		<div class="dp-book-praise-stage">
			<span class="dp-book-praise-mark" aria-hidden="true">&ldquo;</span>

			<div class="dp-book-praise-wall">
				<?php foreach ( $testimonials as $testimonial ) : ?>
					<figure class="dp-book-quote">
						<blockquote class="dp-book-quote-text">
							<?php foreach ( $testimonial['quote'] as $paragraph ) : ?>
								<p><?php echo esc_html( $paragraph ); ?></p>
							<?php endforeach; ?>
						</blockquote>

						<figcaption class="dp-book-quote-by">
							<span class="dp-book-quote-name"><?php echo esc_html( $testimonial['name'] ); ?></span>
							<span class="dp-book-quote-role"><?php echo esc_html( $testimonial['role'] ); ?></span>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="dp-book-praise-rail" hidden>
			<div class="dp-book-praise-progress" aria-hidden="true"><span></span></div>

			<div class="dp-book-praise-names" role="tablist" aria-label="Choose a testimonial">
				<?php foreach ( $testimonials as $index => $testimonial ) : ?>
					<button
						class="dp-book-praise-name"
						type="button"
						role="tab"
						data-index="<?php echo esc_attr( $index ); ?>"
						aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
						tabindex="<?php echo 0 === $index ? '0' : '-1'; ?>"
					>
						<?php echo esc_html( $testimonial['name'] ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		</div>

	</div>
</section>

<section class="dp-book-order" aria-labelledby="dp-book-order-title">
	<div class="dp-book-order-container">

		<div class="dp-book-order-cover">
			<img
				src="<?php echo esc_url( $book . 'book-3d 1.webp' ); ?>"
				alt=""
				width="1066"
				height="1606"
				loading="lazy"
				decoding="async"
			/>
		</div>

		<div class="dp-book-order-action">
			<h2 id="dp-book-order-title" class="dp-book-order-title">Get Your Copy of Don’s Book</h2>

			<a class="dp-book-buy" href="<?php echo esc_url( $buy_url ); ?>" target="_blank" rel="noopener">
				<img
					src="<?php echo esc_url( $book . 'buy-amazon.webp' ); ?>"
					alt="Buy The 40|40 Solution now on Amazon"
					width="600"
					height="414"
					loading="lazy"
					decoding="async"
				/>
			</a>
		</div>

	</div>
</section>

<?php
get_footer();
