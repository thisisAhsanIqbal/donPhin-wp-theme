<?php
/**
 * Template Name: Speaking — Contact
 *
 * The booking page for the Speaking section (/speaking/contact/), for event planners
 * and sales leaders. Assign it to the "Contact" page filed under Speaking.
 * The pitch and direct details on the left, the booking form on the right: the event,
 * its date, audience size and location. Messages are handled in inc/contact-form.php.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Result of a submitted form, set by the redirect in inc/contact-form.php
$contact_status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Arriving from a "Request" on the Resources page: the message names what was asked for
$requested = isset( $_GET['resource'] ) ? sanitize_text_field( wp_unslash( $_GET['resource'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$message   = '' !== $requested ? sprintf( 'I’d like a copy of: %s', $requested ) : '';

// Rough audience sizes, enough to plan the room, as value => label (the values stay
// plain text so they reach the inbox unchanged whatever the visitor's browser sends)
$audience_sizes = array(
	'Under 50'  => 'Under 50',
	'50-150'    => '50–150',
	'150-500'   => '150–500',
	'500-1,000' => '500–1,000',
	'1,000+'    => '1,000+',
);
?>

<section class="dp-contact dp-contact--speaking" aria-labelledby="dp-contact-title">
	<div class="dp-contact-container">

		<div class="dp-contact-intro">
			<p class="dp-contact-eyebrow">Book Don</p>

			<h1 id="dp-contact-title" class="dp-contact-title">
				<span class="dp-contact-line">Bring Don</span>
				<em class="dp-contact-line dp-contact-accent">to your stage.</em>
			</h1>

			<p class="dp-contact-text">
				Tell me about your meeting, your audience, and what you want the room to walk away believing.
			</p>

			<?php get_template_part( 'template-parts/contact-details' ); ?>
		</div>

		<div class="dp-contact-card" id="contact-form">
			<form class="dp-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="donphin_contact">
				<input type="hidden" name="form" value="speaking">

				<?php if ( 'sent' === $contact_status ) : ?>
					<p class="dp-contact-status is-sent" role="status">Thanks — the details are on their way to Don.</p>
				<?php elseif ( 'invalid' === $contact_status ) : ?>
					<p class="dp-contact-status is-invalid" role="alert">Something was missing. Please check your name, email and the event name, then try again.</p>
				<?php endif; ?>

				<div class="dp-contact-row">
					<p class="dp-contact-field">
						<label for="dp-contact-name">Your name</label>
						<input type="text" id="dp-contact-name" name="name" autocomplete="name" required>
					</p>

					<p class="dp-contact-field">
						<label for="dp-contact-email">Email address</label>
						<input type="email" id="dp-contact-email" name="email" autocomplete="email" required>
					</p>
				</div>

				<div class="dp-contact-row">
					<p class="dp-contact-field">
						<label for="dp-contact-organization">Organization <span class="dp-contact-optional">(optional)</span></label>
						<input type="text" id="dp-contact-organization" name="organization" autocomplete="organization">
					</p>

					<p class="dp-contact-field">
						<label for="dp-contact-event">Event name</label>
						<input type="text" id="dp-contact-event" name="event_name" required>
					</p>
				</div>

				<div class="dp-contact-row">
					<p class="dp-contact-field">
						<label for="dp-contact-date">Event date</label>
						<input type="text" id="dp-contact-date" name="event_date" placeholder="e.g. March 12, 2027, or spring 2027">
					</p>

					<p class="dp-contact-field">
						<label for="dp-contact-audience">Audience size</label>
						<select id="dp-contact-audience" name="audience_size">
							<option value="">Choose one</option>
							<?php foreach ( $audience_sizes as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
				</div>

				<p class="dp-contact-field">
					<label for="dp-contact-location">Location</label>
					<input type="text" id="dp-contact-location" name="location" placeholder="City, or virtual">
				</p>

				<p class="dp-contact-field">
					<label for="dp-contact-message">Anything else Don should know? <span class="dp-contact-optional">(optional)</span></label>
					<textarea id="dp-contact-message" name="message" rows="5"><?php echo esc_textarea( $message ); ?></textarea>
				</p>

				<!-- Hidden from people; bots that fill it in are ignored -->
				<div class="dp-contact-trap" aria-hidden="true">
					<label for="dp-contact-website">Website</label>
					<input type="text" id="dp-contact-website" name="website" tabindex="-1" autocomplete="off">
				</div>

				<button type="submit" class="dp-dark-button dp-contact-button">
					Send the details
					<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
				</button>
			</form>
		</div>

	</div>
</section>

<?php
get_footer();
