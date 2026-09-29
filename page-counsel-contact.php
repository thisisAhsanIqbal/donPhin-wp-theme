<?php
/**
 * Template Name: Private Counsel — Contact
 *
 * The private "request a conversation" page for the Private Counsel section
 * (/private-counsel/contact/). Assign it to the "Contact" page filed under Private
 * Counsel. A shorter, more personal form than Speaking's: no event fields, just who
 * you are, how best to reach you, and what's on your mind.
 * Messages are handled in inc/contact-form.php.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Result of a submitted form, set by the redirect in inc/contact-form.php
$contact_status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$reach_options = array( 'Email', 'Phone', 'Either' );
?>

<section class="dp-contact dp-contact--counsel" aria-labelledby="dp-contact-title">
	<div class="dp-contact-container">

		<div class="dp-contact-intro">
			<p class="dp-contact-eyebrow">Request a conversation</p>

			<h1 id="dp-contact-title" class="dp-contact-title">
				<span class="dp-contact-line">One conversation is usually</span>
				<em class="dp-contact-line dp-contact-accent">enough to know.</em>
			</h1>

			<p class="dp-contact-text">
				If someone referred you here, I would be pleased to learn more about your situation and determine whether we are the right fit.
			</p>

			<ul class="dp-contact-terms" aria-label="<?php esc_attr_e( 'How private counsel works', 'don-phin-esq' ); ?>">
				<li>Personal</li>
				<li>Confidential</li>
				<li>Nothing leaves the room</li>
			</ul>

			<?php get_template_part( 'template-parts/contact-details' ); ?>
		</div>

		<div class="dp-contact-card" id="contact-form">
			<form class="dp-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="donphin_contact">
				<input type="hidden" name="form" value="counsel">

				<?php if ( 'sent' === $contact_status ) : ?>
					<p class="dp-contact-status is-sent" role="status">Thank you — your note is with Don, and only Don.</p>
				<?php elseif ( 'invalid' === $contact_status ) : ?>
					<p class="dp-contact-status is-invalid" role="alert">Something was missing. Please check your name, email and note, then try again.</p>
				<?php endif; ?>

				<p class="dp-contact-field">
					<label for="dp-contact-name">Your name</label>
					<input type="text" id="dp-contact-name" name="name" autocomplete="name" required>
				</p>

				<div class="dp-contact-row">
					<p class="dp-contact-field">
						<label for="dp-contact-email">Email address</label>
						<input type="email" id="dp-contact-email" name="email" autocomplete="email" required>
					</p>

					<p class="dp-contact-field">
						<label for="dp-contact-phone">Phone <span class="dp-contact-optional">(optional)</span></label>
						<input type="tel" id="dp-contact-phone" name="phone" autocomplete="tel">
					</p>
				</div>

				<p class="dp-contact-field">
					<label for="dp-contact-reach">Best way to reach you</label>
					<select id="dp-contact-reach" name="reach">
						<?php foreach ( $reach_options as $option ) : ?>
							<option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
						<?php endforeach; ?>
					</select>
				</p>

				<p class="dp-contact-field">
					<label for="dp-contact-message">What’s on your mind?</label>
					<textarea id="dp-contact-message" name="message" rows="6" required></textarea>
				</p>

				<!-- Hidden from people; bots that fill it in are ignored -->
				<div class="dp-contact-trap" aria-hidden="true">
					<label for="dp-contact-website">Website</label>
					<input type="text" id="dp-contact-website" name="website" tabindex="-1" autocomplete="off">
				</div>

				<button type="submit" class="dp-dark-button dp-contact-button">
					Request a conversation
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</button>
			</form>
		</div>

	</div>
</section>

<?php
get_footer();
