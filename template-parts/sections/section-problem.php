<?php
/**
 * Template Part: The Problem
 *
 * The section that earns the rest of the page: a portrait of Don that stays in view
 * beside the heading and his first-person account of the problem he solves.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="dp-problem" aria-labelledby="dp-problem-title">
	<div class="dp-problem-container">

		<header class="dp-problem-header">
			<h2 id="dp-problem-title" class="dp-problem-title">
				Every expensive failure I’ve ever been called into was a people failure <em class="dp-problem-accent">wearing a business costume.</em>
			</h2>
		</header>

		<div class="dp-problem-media">
			<img
				src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/phinBusinessPortrait.webp' ); ?>"
				alt="Don Phin, seated at a boardroom table"
				width="1878"
				height="2272"
				loading="lazy"
				decoding="async"
			/>
		</div>

		<div class="dp-problem-body">
			<p class="dp-problem-lead">
				The merger that didn’t integrate. The system nobody adopted. The star performer who bled three good people out of the department. The family business where nobody will say the quiet thing at the table.
			</p>

			<p>
				None of those were spreadsheet problems. They were fear, ego, resentment, and unexamined assumptions — dressed up in a business case so nobody had to name them.
			</p>

			<p>
				I’ve seen the end of that movie about as often as anyone alive. First from a courtroom, where I watched what unresolved workplace conflict costs when it finally gets a case number. Then from the front of the room, working with CEOs before the case number exists.
			</p>

			<p class="dp-problem-offer">
				<em class="dp-problem-accent">That’s the whole offer.</em> I help leaders see the human thing they’re avoiding, name it without drama, and act on it before it gets expensive.
			</p>
		</div>

	</div>
</section>
