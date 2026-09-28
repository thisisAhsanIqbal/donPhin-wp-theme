<?php
/**
 * Template Part: Free Tools (lead capture)
 *
 * The pitch on the left, the email form on a card on the right.
 * Sign-ups are handled in inc/toolkit-signup.php.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Result of a submitted sign-up, set by the redirect in inc/toolkit-signup.php
$toolkit_status = isset( $_GET['toolkit'] ) ? sanitize_key( wp_unslash( $_GET['toolkit'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<section class="dp-tools" id="free-tools" aria-labelledby="dp-tools-title">
	<div class="dp-tools-container">

		<div class="dp-tools-intro">
			<h2 id="dp-tools-title" class="dp-tools-title">
				Take the tools. <em class="dp-tools-accent">Seriously.</em>
			</h2>
			<p class="dp-tools-text">
				Four decades of worksheets, calculators, and frameworks I use with paying clients. The turnover cost calculator. The entrance interview. The emotional development ladder. The questions that unstick a stuck career.
			</p>
		</div>

		<div class="dp-tools-card">
			<form class="dp-tools-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="donphin_toolkit_signup">

				<label for="dp-tools-email" class="dp-tools-label">Email address</label>
				<input
					type="email"
					id="dp-tools-email"
					name="email"
					class="dp-tools-input"
					autocomplete="email"
					required
					aria-describedby="dp-tools-micro"
					<?php if ( 'invalid' === $toolkit_status ) : ?>
						aria-invalid="true"
					<?php endif; ?>
				>

				<!-- Hidden from people; bots that fill it in are ignored -->
				<div class="dp-tools-trap" aria-hidden="true">
					<label for="dp-tools-website">Website</label>
					<input type="text" id="dp-tools-website" name="website" tabindex="-1" autocomplete="off">
				</div>

				<button type="submit" class="dp-dark-button dp-tools-button">
					Send the toolkit
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</button>

				<?php if ( 'sent' === $toolkit_status ) : ?>
					<p class="dp-tools-status is-sent" role="status">Thanks — you’re on the list.</p>
				<?php elseif ( 'invalid' === $toolkit_status ) : ?>
					<p class="dp-tools-status is-invalid" role="alert">That email address doesn’t look right. Please check it and try again.</p>
				<?php endif; ?>

				<p id="dp-tools-micro" class="dp-tools-micro">
					One email with everything in it. Unsubscribe whenever, no hard feelings.
				</p>
			</form>
		</div>

	</div>
</section>
