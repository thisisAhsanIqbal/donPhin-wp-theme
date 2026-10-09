<?php
/**
 * Moving HR Tools out of Speaking into a library of its own (Tools > Move HR Tools)
 *
 * HR Tools began as the Speaking library (Speaking Resources). It belongs to neither side,
 * so it now has its own library (HR Tools in the admin, /hr-tools/ on the site). This
 * page shows what will change, and changes nothing until "Move" is pressed:
 * - every Speaking resource becomes an HR tool, keeping its words, document or link,
 *   label, order, status and author; its old address (/speaking/resources/{tool}/) is
 *   remembered, so links to it keep working (inc/redirects.php)
 * - the Speaking library's categories become HR Tools' categories, keeping their short
 *   names, icons and order (they are moved as they are, not copied)
 * - the HR Tools page is created at /hr-tools/ (page-hr-tools.php), taking the heading and
 *   intro set in Speaking Resources' "Resource library" box, if any
 * Speaking keeps its Resources page (the downloads, press photos and programs) and an empty
 * library of its own. Running it again changes only what isn't done yet; once it's all
 * done, the page leaves the Tools menu.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * What's still to move: the Speaking resources (any status but the bin's and unsaved
 * drafts), whether its categories are still Speaking's, and the HR Tools page
 *
 * @return array { resources: WP_Post[], categories: WP_Term[], page: WP_Post|null }
 */
function donphin_hr_tools_move_state() {
	$sides = donphin_resource_sides();

	$categories = get_terms(
		array(
			'taxonomy'   => $sides['speaking']['taxonomy'],
			'hide_empty' => false,
		)
	);

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'private', 'pending' ),
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- admin only, once
			'meta_value'     => 'page-hr-tools.php', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);

	return array(
		'resources'  => get_posts(
			array(
				'post_type'      => $sides['speaking']['post_type'],
				'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
			)
		),
		'categories' => is_wp_error( $categories ) ? array() : $categories,
		'page'       => $pages ? $pages[0] : null,
	);
}

/**
 * Whether the move is still to do. It happens once: after it, anything added to Speaking's
 * own library is Speaking's and stays there.
 *
 * @return bool
 */
function donphin_hr_tools_move_pending() {
	return ! get_option( 'donphin_hr_tools_moved' );
}

/**
 * Whether the move can run: Counsel Resources has to be set up from Speaking first
 * (inc/resources-split.php), as it copies its resources out of the same library
 *
 * @return bool
 */
function donphin_hr_tools_move_ready() {
	$sides = donphin_resource_sides();
	return array_sum( (array) wp_count_posts( $sides['counsel']['post_type'] ) ) > 0;
}

/**
 * Move it all. Each step is skipped once done.
 *
 * @return array What was done, as lines for the page.
 */
function donphin_hr_tools_move_apply() {
	global $wpdb;

	$sides = donphin_resource_sides();
	$from  = $sides['speaking'];
	$to    = $sides['foryou'];
	$state = donphin_hr_tools_move_state();
	$log   = array();

	// 1. The categories: moved as they are (same terms, same ids, same short names, icons
	//    and order), so every resource keeps its category without being touched
	if ( $state['categories'] ) {
		$moved = $wpdb->update( $wpdb->term_taxonomy, array( 'taxonomy' => $to['taxonomy'] ), array( 'taxonomy' => $from['taxonomy'] ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery -- one-time move of a taxonomy's terms; caches cleared below
		foreach ( $state['categories'] as $term ) {
			clean_term_cache( $term->term_id, $from['taxonomy'] );
			clean_term_cache( $term->term_id, $to['taxonomy'] );
		}
		delete_option( $from['taxonomy'] . '_children' );
		delete_option( $to['taxonomy'] . '_children' );
		/* translators: %d: how many categories */
		$log[] = sprintf( _n( '%d category moved to HR Tools.', '%d categories moved to HR Tools.', (int) $moved, 'don-phin-esq' ), (int) $moved );
	}

	// 2. The resources, each remembering its old address
	$count = 0;
	foreach ( $state['resources'] as $post ) {
		if ( 'publish' === $post->post_status ) {
			$old = donphin_site_path( get_permalink( $post ) );
			if ( '' !== $old && ! in_array( $old, get_post_meta( $post->ID, '_dp_old_path' ), true ) ) {
				add_post_meta( $post->ID, '_dp_old_path', $old );
			}
		}
		if ( set_post_type( $post->ID, $to['post_type'] ) ) {
			clean_post_cache( $post->ID );
			++$count;
		}
	}
	if ( $count ) {
		/* translators: %d: how many resources */
		$log[] = sprintf( _n( '%d resource moved to HR Tools.', '%d resources moved to HR Tools.', $count, 'don-phin-esq' ), $count );
	}

	// 3. The page, with Speaking Resources' heading and intro if they were set
	if ( ! $state['page'] ) {
		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'HR Tools',
				'post_name'    => 'hr-tools',
				'post_content' => '',
			),
			true
		);
		if ( ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-hr-tools.php' );

			$speaking_pages = get_posts(
				array(
					'post_type'      => 'page',
					'posts_per_page' => 1,
					'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- admin only, once
					'meta_value'     => 'page-speaking-resources.php', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				)
			);
			foreach ( array( '_dp_library_heading', '_dp_library_intro' ) as $key ) {
				$value = $speaking_pages ? (string) get_post_meta( $speaking_pages[0]->ID, $key, true ) : '';
				if ( '' !== $value ) {
					update_post_meta( $page_id, $key, $value );
					delete_post_meta( $speaking_pages[0]->ID, $key );
				}
			}
			/* translators: %s: the page's address */
			$log[] = sprintf( __( 'The HR Tools page is up at %s.', 'don-phin-esq' ), get_permalink( $page_id ) );
		}
	}

	// Done once every step is: from now on Speaking's library is Speaking's own
	$after = donphin_hr_tools_move_state();
	if ( ! $after['resources'] && ! $after['categories'] && $after['page'] ) {
		update_option( 'donphin_hr_tools_moved', time(), false );
	}

	return $log;
}

/**
 * The page under Tools, while there's something to move (and just after)
 */
function donphin_hr_tools_move_menu() {
	if ( ! donphin_hr_tools_move_pending() && ! isset( $_POST['donphin_hr_move'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- checked on the page
		return;
	}
	add_management_page(
		__( 'Move HR Tools', 'don-phin-esq' ),
		__( 'Move HR Tools', 'don-phin-esq' ),
		'manage_options',
		'donphin-hr-tools-move',
		'donphin_hr_tools_move_page'
	);
}
add_action( 'admin_menu', 'donphin_hr_tools_move_menu' );

/**
 * Print the page: what was just done, or what will change and the button
 */
function donphin_hr_tools_move_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$log = array();
	if ( isset( $_POST['donphin_hr_move'] ) && donphin_hr_tools_move_ready() ) {
		check_admin_referer( 'donphin_hr_tools_move' );
		$log = donphin_hr_tools_move_apply();
	}

	$sides = donphin_resource_sides();
	$state = donphin_hr_tools_move_state();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Move HR Tools', 'don-phin-esq' ); ?></h1>

		<?php if ( $log ) : ?>
			<div class="notice notice-success"><p><?php echo wp_kses_post( implode( '<br>', array_map( 'esc_html', $log ) ) ); ?></p></div>
		<?php endif; ?>

		<?php if ( ! donphin_hr_tools_move_pending() ) : ?>
			<p><?php esc_html_e( 'HR Tools is a library of its own. Nothing is left to move.', 'don-phin-esq' ); ?></p>
			<p>
				<a class="button button-primary" href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $sides['foryou']['post_type'] ) ); ?>"><?php esc_html_e( 'See HR Tools', 'don-phin-esq' ); ?></a>
				<?php if ( $state['page'] ) : ?>
					<a class="button" href="<?php echo esc_url( get_permalink( $state['page'] ) ); ?>"><?php esc_html_e( 'View the page', 'don-phin-esq' ); ?></a>
				<?php endif; ?>
			</p>
			<p class="description"><?php esc_html_e( 'This page goes from the Tools menu once you leave it.', 'don-phin-esq' ); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'HR Tools belongs to neither Speaking nor Private Counsel, so it becomes a library of its own, at /hr-tools/. Nothing changes until you press Move.', 'don-phin-esq' ); ?></p>

			<table class="widefat striped" style="max-width: 760px; margin: 16px 0;">
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Resources', 'don-phin-esq' ); ?></th>
						<td>
							<?php
							$by_status = array_count_values( wp_list_pluck( $state['resources'], 'post_status' ) );
							$parts     = array();
							foreach ( $by_status as $status => $n ) {
								$object  = get_post_status_object( $status );
								$parts[] = $n . ' ' . strtolower( $object ? $object->label : $status );
							}
							/* translators: 1: how many, 2: by status, e.g. "97 published, 5 draft" */
							echo esc_html( $state['resources'] ? sprintf( __( '%1$d move from Speaking Resources to HR Tools (%2$s). Their old addresses lead to the new ones.', 'don-phin-esq' ), count( $state['resources'] ), implode( ', ', $parts ) ) : __( 'Already moved.', 'don-phin-esq' ) );
							?>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Categories', 'don-phin-esq' ); ?></th>
						<td>
							<?php
							/* translators: %s: the categories' names */
							echo esc_html( $state['categories'] ? sprintf( __( 'Move as they are, with their short names, icons and order: %s.', 'don-phin-esq' ), implode( ', ', array_map( 'html_entity_decode', wp_list_pluck( $state['categories'], 'name' ) ) ) ) : __( 'Already moved.', 'don-phin-esq' ) );
							?>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'The page', 'don-phin-esq' ); ?></th>
						<td><?php echo esc_html( $state['page'] ? __( 'Already there.', 'don-phin-esq' ) : __( 'An "HR Tools" page is created at /hr-tools/.', 'don-phin-esq' ) ); ?></td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Speaking', 'don-phin-esq' ); ?></th>
						<td><?php esc_html_e( 'Keeps its Resources page (the downloads, press photos and programs) and an empty library of its own, for anything Speaking-only later.', 'don-phin-esq' ); ?></td>
					</tr>
				</tbody>
			</table>

			<?php if ( ! donphin_hr_tools_move_ready() ) : ?>
				<div class="notice notice-warning inline"><p>
					<?php esc_html_e( 'First, set up Counsel Resources from Speaking: it copies the Private Counsel resources out of this same library, so it has to run before the library moves.', 'don-phin-esq' ); ?>
					<a href="<?php echo esc_url( menu_page_url( 'donphin-resources-split', false ) ); ?>"><?php esc_html_e( 'Set up Counsel Resources →', 'don-phin-esq' ); ?></a>
				</p></div>
			<?php else : ?>
				<form method="post">
					<?php wp_nonce_field( 'donphin_hr_tools_move' ); ?>
					<p><button type="submit" name="donphin_hr_move" value="1" class="button button-primary"><?php esc_html_e( 'Move', 'don-phin-esq' ); ?></button></p>
				</form>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Point the way on Speaking Resources while the move is still to do
 */
function donphin_hr_tools_move_notice() {
	$screen = get_current_screen();
	$sides  = donphin_resource_sides();
	if ( ! $screen || 'edit' !== $screen->base || ! in_array( $screen->post_type, array( $sides['speaking']['post_type'], $sides['foryou']['post_type'] ), true ) || ! current_user_can( 'manage_options' ) || ! donphin_hr_tools_move_pending() ) {
		return;
	}
	printf(
		'<div class="notice notice-info"><p><strong>%s</strong> <a href="%s">%s</a></p></div>',
		esc_html__( 'HR Tools is becoming a library of its own.', 'don-phin-esq' ),
		esc_url( admin_url( 'tools.php?page=donphin-hr-tools-move' ) ),
		esc_html__( 'See what moves, and move it →', 'don-phin-esq' )
	);
}
add_action( 'admin_notices', 'donphin_hr_tools_move_notice' );
