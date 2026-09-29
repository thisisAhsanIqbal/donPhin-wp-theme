<?php
/**
 * Template Name: Contact Page
 *
 * Used automatically by the page with the slug "contact".
 * Details on the left, the form on the right. Messages are handled in inc/contact-form.php.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$socials = donphin_social_links();
$topics  = donphin_contact_topics();

// Result of a submitted message, set by the redirect in inc/contact-form.php
$contact_status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Links can open the form on a topic, e.g. /contact/?topic=counsel from the Private Counsel page
$chosen_topic = isset( $_GET['topic'] ) ? sanitize_key( wp_unslash( $_GET['topic'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<section class="dp-contact" aria-labelledby="dp-contact-title">
	<div class="dp-contact-container">

		<div class="dp-contact-intro">
			<h1 id="dp-contact-title" class="dp-contact-title">
				<span class="dp-contact-line">Tell me what’s going on.</span>
				<em class="dp-contact-line dp-contact-accent">You’ll know fast if I can help.</em>
			</h1>

			<p class="dp-contact-text">
				Booking a keynote or considering private counsel — it all starts the same way. If I’m not the right person, I probably know who is.
			</p>

			<p class="dp-contact-book">
				<a href="https://scheduler.zoom.us/don-phin/30-mins-w-don" class="dp-arrow-link" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Book a Zoom with Don (opens in a new tab)', 'don-phin-esq' ); ?>">
					Book a Zoom
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</a>
			</p>

			<address class="dp-contact-details">
				<a href="tel:+16198524580">(619) 852-4580</a>
				<span class="dp-contact-sep" aria-hidden="true">·</span>
				<a href="mailto:don@donphin.com">don@donphin.com</a>
			</address>

			<ul class="dp-contact-social">
				<?php foreach ( $socials as $key => $social ) : ?>
					<li>
						<a href="<?php echo esc_url( $social['url'] ); ?>" class="dp-contact-social-link dp-contact-social-link--<?php echo esc_attr( $key ); ?>" target="_blank" rel="me noopener" aria-label="<?php echo esc_attr( sprintf( 'Don Phin on %s (opens in a new tab)', $social['label'] ) ); ?>">
							<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="<?php echo esc_attr( $social['path'] ); ?>"/></svg>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="dp-contact-card" id="contact-form">
			<form class="dp-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="donphin_contact">

				<?php if ( 'sent' === $contact_status ) : ?>
					<p class="dp-contact-status is-sent" role="status">Thanks — your message is on its way to Don.</p>
				<?php elseif ( 'invalid' === $contact_status ) : ?>
					<p class="dp-contact-status is-invalid" role="alert">Something was missing. Please check your name, email and message, then try again.</p>
				<?php endif; ?>

				<p class="dp-contact-field">
					<label for="dp-contact-name">Your name</label>
					<input type="text" id="dp-contact-name" name="name" autocomplete="name" required>
				</p>

				<p class="dp-contact-field">
					<label for="dp-contact-email">Email address</label>
					<input type="email" id="dp-contact-email" name="email" autocomplete="email" required>
				</p>

				<p class="dp-contact-field">
					<label for="dp-contact-topic">What is this about?</label>
					<select id="dp-contact-topic" name="topic">
						<?php foreach ( $topics as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $chosen_topic, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</p>

				<p class="dp-contact-field">
					<label for="dp-contact-message">What’s going on?</label>
					<textarea id="dp-contact-message" name="message" rows="6" required></textarea>
				</p>

				<!-- Hidden from people; bots that fill it in are ignored -->
				<div class="dp-contact-trap" aria-hidden="true">
					<label for="dp-contact-website">Website</label>
					<input type="text" id="dp-contact-website" name="website" tabindex="-1" autocomplete="off">
				</div>

				<button type="submit" class="dp-dark-button dp-contact-button">
					Send it to Don
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</button>
			</form>
		</div>

	</div>
</section>

<?php
get_footer();
