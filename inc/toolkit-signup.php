<?php
/**
 * Free toolkit sign-ups (the "Take the tools" form on the home page)
 *
 * Each sign-up is saved as a private entry under "Toolkit sign-ups" in the admin
 * and emailed to the site admin address.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin-only list of sign-ups; never shown on the site
 */
function donphin_register_toolkit_signups() {
	register_post_type(
		'dp_toolkit_signup',
		array(
			'labels'          => array(
				'name'          => __( 'Toolkit sign-ups', 'don-phin-esq' ),
				'singular_name' => __( 'Toolkit sign-up', 'don-phin-esq' ),
				'menu_name'     => __( 'Toolkit sign-ups', 'don-phin-esq' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-email-alt',
			'supports'        => array( 'title' ),
			'capability_type' => 'post',
			// Entries only come from the form, so hide "Add New"
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
		)
	);
}
add_action( 'init', 'donphin_register_toolkit_signups' );

/**
 * Handle the form post, then send the visitor back to the form with ?toolkit=sent or ?toolkit=invalid
 *
 * No nonce: the form sits on public pages that may be cached, where a stale nonce would
 * turn away real visitors. The hidden "website" field catches bots instead.
 */
function donphin_handle_toolkit_signup() {
	// phpcs:disable WordPress.Security.NonceVerification.Missing
	$is_bot = ! empty( $_POST['website'] );
	$email  = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	// phpcs:enable

	$status = 'sent';

	if ( $is_bot ) {
		// Pretend it worked, so bots learn nothing
		$status = 'sent';
	} elseif ( ! is_email( $email ) ) {
		$status = 'invalid';
	} else {
		$existing = get_posts(
			array(
				'post_type'   => 'dp_toolkit_signup',
				'title'       => $email,
				'post_status' => 'any',
				'fields'      => 'ids',
				'numberposts' => 1,
			)
		);

		if ( empty( $existing ) ) {
			wp_insert_post(
				array(
					'post_type'   => 'dp_toolkit_signup',
					'post_title'  => $email,
					'post_status' => 'private',
				)
			);

			wp_mail(
				get_option( 'admin_email' ),
				sprintf( 'New toolkit sign-up: %s', $email ),
				sprintf( "%s asked for the free toolkit on %s.\n\nAll sign-ups: %s", $email, home_url( '/' ), admin_url( 'edit.php?post_type=dp_toolkit_signup' ) )
			);
		}
	}

	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'toolkit', strtok( $back, '#' ) );

	wp_safe_redirect( add_query_arg( 'toolkit', $status, $back ) . '#free-tools' );
	exit;
}
add_action( 'admin_post_nopriv_donphin_toolkit_signup', 'donphin_handle_toolkit_signup' );
add_action( 'admin_post_donphin_toolkit_signup', 'donphin_handle_toolkit_signup' );
