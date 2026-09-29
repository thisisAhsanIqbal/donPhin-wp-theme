<?php
/**
 * The "Header Section" box on the page and post screens
 *
 * Lets an editor put any page in a section by hand. Most pages never need it: pages
 * filed under a section's home page, or using one of its templates, are placed
 * automatically (see donphin_get_header_section() in inc/sections.php).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the box to pages and posts
 */
function donphin_add_header_meta_box() {
	foreach ( array( 'page', 'post' ) as $screen ) {
		add_meta_box(
			'donphin_header_meta',
			__( 'Header Section', 'don-phin-esq' ),
			'donphin_header_meta_box_callback',
			$screen,
			'side',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'donphin_add_header_meta_box' );

/**
 * Print the box: "Automatic", then one choice per section
 */
function donphin_header_meta_box_callback( $post ) {
	wp_nonce_field( 'donphin_save_header_meta', 'donphin_header_nonce' );
	$current = get_post_meta( $post->ID, '_donphin_header_section', true );
	if ( empty( $current ) && 'counsel' === get_post_meta( $post->ID, '_donphin_header_type', true ) ) {
		$current = 'counsel';
	}
	?>
	<p>
		<label for="donphin_header_section"><strong><?php esc_html_e( 'Section for this Page:', 'don-phin-esq' ); ?></strong></label>
	</p>
	<select name="donphin_header_section" id="donphin_header_section" style="width: 100%; padding: 6px;">
		<option value="" <?php selected( $current, '' ); ?>><?php esc_html_e( 'Automatic', 'don-phin-esq' ); ?></option>
		<?php foreach ( donphin_sections() as $key => $section ) : ?>
			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $current, $key ); ?>><?php echo esc_html( $section['label'] ); ?></option>
		<?php endforeach; ?>
	</select>
	<p class="description" style="margin-top: 8px;">
		<?php esc_html_e( 'Sets the highlighted header tab, the header menu and the colours. Automatic follows where the page is filed: pages under Speaking or Private Counsel take that section, and everything else is For You.', 'don-phin-esq' ); ?>
	</p>
	<?php
}

/**
 * Save the choice
 */
function donphin_save_header_meta( $post_id ) {
	if ( ! isset( $_POST['donphin_header_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['donphin_header_nonce'] ), 'donphin_save_header_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['donphin_header_section'] ) ) {
		$selected = sanitize_key( wp_unslash( $_POST['donphin_header_section'] ) );
		if ( array_key_exists( $selected, donphin_sections() ) ) {
			update_post_meta( $post_id, '_donphin_header_section', $selected );
		} else {
			delete_post_meta( $post_id, '_donphin_header_section' );
		}
		// The new setting replaces the old two-header one
		delete_post_meta( $post_id, '_donphin_header_type' );
	}
}
add_action( 'save_post', 'donphin_save_header_meta' );
