<?php
/**
 * Contact form (page-contact.php)
 *
 * Each message is saved as a private entry under "Enquiries" in the admin and
 * emailed to the site admin address, with the sender set as the reply-to.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * What the enquiry can be about; also the choices in the form's dropdown
 */
function donphin_contact_topics() {
	return array(
		'speaking' => 'Speaking',
		'counsel'  => 'Private counsel',
		'other'    => 'Something else',
	);
}

/**
 * Admin-only list of enquiries; never shown on the site
 */
function donphin_register_enquiries() {
	register_post_type(
		'dp_enquiry',
		array(
			'labels'          => array(
				'name'          => __( 'Enquiries', 'don-phin-esq' ),
				'singular_name' => __( 'Enquiry', 'don-phin-esq' ),
				'menu_name'     => __( 'Enquiries', 'don-phin-esq' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-testimonial',
			'supports'        => array( 'title', 'editor' ),
			'capability_type' => 'post',
			// Entries only come from the form, so hide "Add New"
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
		)
	);
}
add_action( 'init', 'donphin_register_enquiries' );

/**
 * Show who sent an enquiry, and what about, in the admin list
 */
function donphin_enquiry_columns( $columns ) {
	$columns['dp_email'] = __( 'Email', 'don-phin-esq' );
	$columns['dp_topic'] = __( 'About', 'don-phin-esq' );
	return $columns;
}
add_filter( 'manage_dp_enquiry_posts_columns', 'donphin_enquiry_columns' );

/**
 * Fill those columns
 */
function donphin_enquiry_column_content( $column, $post_id ) {
	if ( 'dp_email' === $column ) {
		$email = get_post_meta( $post_id, '_dp_email', true );
		if ( $email ) {
			printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $email ) );
		}
	}

	if ( 'dp_topic' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_dp_topic', true ) );
	}
}
add_action( 'manage_dp_enquiry_posts_custom_column', 'donphin_enquiry_column_content', 10, 2 );

/**
 * Handle the form post, then send the visitor back to the form with ?contact=sent or ?contact=invalid
 *
 * No nonce: the form sits on a public page that may be cached, where a stale nonce would
 * turn away real visitors. The hidden "website" field catches bots instead.
 */
function donphin_handle_contact() {
	// phpcs:disable WordPress.Security.NonceVerification.Missing
	$is_bot  = ! empty( $_POST['website'] );
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$topic   = isset( $_POST['topic'] ) ? sanitize_key( wp_unslash( $_POST['topic'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	// phpcs:enable

	$topics = donphin_contact_topics();
	$topic  = isset( $topics[ $topic ] ) ? $topics[ $topic ] : $topics['other'];

	$status = 'sent';

	if ( $is_bot ) {
		// Pretend it worked, so bots learn nothing
		$status = 'sent';
	} elseif ( '' === $name || '' === $message || ! is_email( $email ) ) {
		$status = 'invalid';
	} else {
		$enquiry_id = wp_insert_post(
			array(
				'post_type'    => 'dp_enquiry',
				'post_title'   => sprintf( '%s — %s', $name, $topic ),
				'post_content' => $message,
				'post_status'  => 'private',
			)
		);

		if ( $enquiry_id ) {
			update_post_meta( $enquiry_id, '_dp_email', $email );
			update_post_meta( $enquiry_id, '_dp_topic', $topic );
		}

		wp_mail(
			get_option( 'admin_email' ),
			sprintf( 'Enquiry from %s (%s)', $name, $topic ),
			sprintf( "%s\n%s\nAbout: %s\n\n%s\n\nAll enquiries: %s", $name, $email, $topic, $message, admin_url( 'edit.php?post_type=dp_enquiry' ) ),
			array( 'Reply-To: ' . $name . ' <' . $email . '>' )
		);
	}

	// Sent, and there is a thank-you page: greet them there by name
	if ( 'sent' === $status && ! $is_bot ) {
		$thanks = get_page_by_path( 'thank-you' );

		if ( $thanks ) {
			// The name travels in a one-time note on the server, not in the address bar
			$token = wp_generate_password( 20, false );
			set_transient( 'dp_thanks_' . $token, $name, 10 * MINUTE_IN_SECONDS );

			wp_safe_redirect( add_query_arg( 'ref', $token, get_permalink( $thanks ) ) );
			exit;
		}
	}

	$back = wp_get_referer() ? wp_get_referer() : home_url( '/contact/' );
	$back = remove_query_arg( 'contact', strtok( $back, '#' ) );

	wp_safe_redirect( add_query_arg( 'contact', $status, $back ) . '#contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_donphin_contact', 'donphin_handle_contact' );
add_action( 'admin_post_donphin_contact', 'donphin_handle_contact' );
