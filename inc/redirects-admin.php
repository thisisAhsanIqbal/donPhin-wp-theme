<?php
/**
 * Seeing (and tidying) the old addresses that redirect, in the admin
 *
 * Tools > Old Addresses lists every redirect the site knows about: the old addresses
 * remembered on pages when they moved (inc/redirects.php), each with the page it leads
 * to now and a button to forget it; and the hints listed in the theme, each with where
 * it actually leads on this site, or a warning that it leads nowhere. Each page's own
 * edit screen also shows the old addresses that lead to it.
 *
 * Admin only: nothing here runs for visitors.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Tools > Old Addresses screen
 */
function donphin_redirects_admin_menu() {
	add_management_page(
		__( 'Old Addresses', 'don-phin-esq' ),
		__( 'Old Addresses', 'don-phin-esq' ),
		'edit_pages',
		'donphin-old-addresses',
		'donphin_redirects_admin_screen'
	);
}
add_action( 'admin_menu', 'donphin_redirects_admin_menu' );

/**
 * Forget one remembered old address (from the button on the screen)
 */
function donphin_forget_old_path() {
	$post_id = isset( $_POST['page_id'] ) ? absint( $_POST['page_id'] ) : 0;
	$path    = isset( $_POST['old_path'] ) ? sanitize_text_field( wp_unslash( $_POST['old_path'] ) ) : '';

	check_admin_referer( 'donphin_forget_' . $post_id . '_' . $path );
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		wp_die( esc_html__( 'You are not allowed to change this page.', 'don-phin-esq' ) );
	}

	delete_post_meta( $post_id, '_dp_old_path', $path );

	wp_safe_redirect( add_query_arg( 'forgotten', rawurlencode( $path ), admin_url( 'tools.php?page=donphin-old-addresses' ) ) );
	exit;
}
add_action( 'admin_post_donphin_forget_old_path', 'donphin_forget_old_path' );

/**
 * A site path as a full, clickable address
 */
function donphin_path_link( $path ) {
	$url = home_url( '/' . trim( $path, '/' ) . '/' );
	return sprintf( '<a href="%1$s" target="_blank" rel="noopener"><code>/%2$s/</code></a>', esc_url( $url ), esc_html( trim( $path, '/' ) ) );
}

/**
 * Print the screen
 */
function donphin_redirects_admin_screen() {
	// Every page carrying at least one remembered old address
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'meta_key'       => '_dp_old_path', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- admin screen
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Old Addresses', 'don-phin-esq' ); ?></h1>
		<p><?php esc_html_e( 'Addresses that no longer hold a page, and where they send visitors now. Redirects always go to wherever the page lives at the moment, and only if it is published; an address that leads nowhere simply shows the page not found screen.', 'don-phin-esq' ); ?></p>

		<?php if ( isset( $_GET['forgotten'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div class="notice notice-success is-dismissible"><p>
				<?php
				/* translators: %s: an old address */
				printf( esc_html__( 'Forgotten: /%s/ no longer redirects.', 'don-phin-esq' ), esc_html( sanitize_text_field( wp_unslash( $_GET['forgotten'] ) ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				?>
			</p></div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Remembered automatically', 'don-phin-esq' ); ?></h2>
		<p class="description"><?php esc_html_e( 'Kept whenever a page\'s parent or slug changes, so links to its old address keep working.', 'don-phin-esq' ); ?></p>
		<table class="widefat striped" style="margin-top: 12px;">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Old address', 'don-phin-esq' ); ?></th>
					<th><?php esc_html_e( 'Leads to', 'don-phin-esq' ); ?></th>
					<th><?php esc_html_e( 'Page', 'don-phin-esq' ); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$rows = 0;
				foreach ( $pages as $page ) :
					foreach ( get_post_meta( $page->ID, '_dp_old_path' ) as $old ) :
						++$rows;
						$live = 'publish' === $page->post_status;
						?>
						<tr>
							<td><?php echo donphin_path_link( $old ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside ?></td>
							<td>
								<?php if ( $live ) : ?>
									<?php echo donphin_path_link( donphin_site_path( get_permalink( $page ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside ?>
								<?php else : ?>
									<em><?php esc_html_e( 'Nowhere while the page is not published', 'don-phin-esq' ); ?></em>
								<?php endif; ?>
							</td>
							<td><a href="<?php echo esc_url( get_edit_post_link( $page->ID ) ); ?>"><?php echo esc_html( get_the_title( $page ) ); ?></a></td>
							<td style="text-align: right;">
								<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" onsubmit="return confirm('<?php echo esc_js( __( 'Stop redirecting this old address?', 'don-phin-esq' ) ); ?>');">
									<input type="hidden" name="action" value="donphin_forget_old_path">
									<input type="hidden" name="page_id" value="<?php echo esc_attr( $page->ID ); ?>">
									<input type="hidden" name="old_path" value="<?php echo esc_attr( $old ); ?>">
									<?php wp_nonce_field( 'donphin_forget_' . $page->ID . '_' . $old ); ?>
									<button type="submit" class="button button-small"><?php esc_html_e( 'Forget', 'don-phin-esq' ); ?></button>
								</form>
							</td>
						</tr>
						<?php
					endforeach;
				endforeach;

				if ( ! $rows ) :
					?>
					<tr><td colspan="4"><?php esc_html_e( 'None yet. Moving a page to a new parent or slug adds its old address here.', 'don-phin-esq' ); ?></td></tr>
				<?php endif; ?>
			</tbody>
		</table>

		<h2 style="margin-top: 32px;"><?php esc_html_e( 'Listed in the theme', 'don-phin-esq' ); ?></h2>
		<p class="description">
			<?php
			/* translators: %s: a file name */
			printf( esc_html__( 'Hints kept in %s, checked live against this site.', 'don-phin-esq' ), '<code>inc/redirects.php</code>' );
			?>
		</p>
		<table class="widefat striped" style="margin-top: 12px;">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Old address', 'don-phin-esq' ); ?></th>
					<th><?php esc_html_e( 'Meant for', 'don-phin-esq' ); ?></th>
					<th><?php esc_html_e( 'On this site', 'don-phin-esq' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( donphin_redirects() as $old => $hint ) :
					$page   = donphin_find_page( $hint );
					$target = $page ? donphin_site_path( get_permalink( $page ) ) : '';
					?>
					<tr>
						<td><?php echo donphin_path_link( $old ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside ?></td>
						<td><code><?php echo esc_html( $hint ); ?></code></td>
						<td>
							<?php if ( ! $page ) : ?>
								<span style="color: #b32d2e;">&#10007; <?php esc_html_e( 'Not found, so no redirect', 'don-phin-esq' ); ?></span>
							<?php elseif ( trim( $target, '/' ) === trim( $old, '/' ) ) : ?>
								<span style="color: #996800;">&ndash; <?php esc_html_e( 'The page is still at this address, so no redirect', 'don-phin-esq' ); ?></span>
							<?php else : ?>
								<span style="color: #008a20;">&#10003;</span> <?php echo donphin_path_link( $target ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2 style="margin-top: 32px;"><?php esc_html_e( 'Section shorthand', 'don-phin-esq' ); ?></h2>
		<table class="widefat striped" style="margin-top: 12px; max-width: 640px;">
			<tbody>
				<?php foreach ( donphin_redirect_prefixes() as $from => $to ) : ?>
					<tr>
						<td><code>/<?php echo esc_html( $from ); ?>/&hellip;</code></td>
						<td><code>/<?php echo esc_html( $to ); ?>/&hellip;</code></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * On each page's edit screen: the old addresses that lead to it
 */
function donphin_old_addresses_meta_box() {
	add_meta_box(
		'donphin_old_addresses',
		__( 'Old Addresses', 'don-phin-esq' ),
		'donphin_old_addresses_meta_box_callback',
		'page',
		'side',
		'low'
	);
}
add_action( 'add_meta_boxes', 'donphin_old_addresses_meta_box' );

/**
 * Print the box
 */
function donphin_old_addresses_meta_box_callback( $post ) {
	$old = get_post_meta( $post->ID, '_dp_old_path' );
	if ( ! $old ) {
		echo '<p class="description">' . esc_html__( 'None. If this page moves, its old address will be kept here and keep working.', 'don-phin-esq' ) . '</p>';
		return;
	}

	echo '<p class="description">' . esc_html__( 'These addresses redirect to this page:', 'don-phin-esq' ) . '</p><ul style="margin: 0;">';
	foreach ( $old as $path ) {
		echo '<li>' . donphin_path_link( $path ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside
	}
	echo '</ul><p><a href="' . esc_url( admin_url( 'tools.php?page=donphin-old-addresses' ) ) . '">' . esc_html__( 'Manage in Tools > Old Addresses', 'don-phin-esq' ) . '</a></p>';
}
