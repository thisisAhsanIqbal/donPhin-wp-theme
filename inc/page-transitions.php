<?php
/**
 * Page transitions: a soft fade on arrival
 *
 * Links work as normal, so the old page stays up until the new one is ready and the
 * screen is never blank. The new page's content arrives slightly faded and settles to
 * full strength; the header stays solid throughout. The behaviour is in
 * assets/js/page-transitions.js (enqueued in inc/enqueue.php), the fade in style.css
 * (section 11).
 *
 * This file adds the one piece that has to come first: a line in the head that marks
 * the page before it is drawn, so its content starts faded. If the script never
 * arrives, the content comes to full strength after a moment anyway.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Start the page content faded, to settle in (skipped for visitors who prefer less motion)
 */
function donphin_page_transition_head() {
	?>
	<script>
	(function () {
		if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
		var root = document.documentElement;
		root.classList.add('dp-fade');
		// Safety net: never leave the page faded if the transition script doesn't run
		window.setTimeout(function () { root.classList.add('dp-fade-in'); }, 1500);
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'donphin_page_transition_head', 1 );
