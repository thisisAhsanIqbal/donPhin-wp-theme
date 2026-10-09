<?php
/**
 * Splitting the one library into each side's own (Counsel Resources > Set up from Speaking)
 *
 * The library began as one list under Speaking Resources. Don marked it up into two: the
 * resources for Private Counsel, and HR Tools (everything else) for Speaking. This page
 * shows exactly what will change, and changes nothing until "Apply" is pressed:
 * - the Private Counsel resources move to Counsel Resources, into its two categories
 *   (Books; Checklists, Reports, Tools and More), in Don's order
 * - the two on both lists are copied there too, keeping the same document
 * - a link that would lead to the Speaking side leads straight to where it means instead
 * - the resources on hold become drafts (kept, but not shown)
 * - From Chaos to Order is deleted (its document, if any, stays in the Media Library)
 * - HR Tools' books are put in Don's order
 * Running it again changes only what isn't done yet, so it's safe to press twice.
 *
 * Titles are matched ignoring case and punctuation ("40//40", "–", "…", curly quotes).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * What Don decided, by title (and by category, where a title alone is ambiguous)
 *
 * @return array
 */
function donphin_resources_split_brief() {
	return array(
		// Private Counsel, in two groups and in this order. 'both' stays on HR Tools too.
		'counsel' => array(
			array(
				'name'  => 'Books',
				'chip'  => 'Books',
				'icon'  => 'book',
				'items' => array(
					array( 'title' => 'Bathroom Book of Time' ),
					array( 'title' => 'Visionaries Workbook – Learn from the Masters' ), // Position pending client
					array(
						// Matched in its category: the video "The 40//40 Solution: Mastering…" has the same title
						'title'    => 'The 40//40 Solution — Mastering Emotional Energy in Leadership and Sales',
						'category' => 'Books & Excerpts',
						'both'     => true,
					),
					array( 'title' => 'The 40//40 Solution in Sales (Audio)' ), // The audio excerpt
					array( 'title' => 'The 40//40 Solution in Sales' ),         // The PDF excerpt
					array(
						// Straight to Amazon: its Speaking link (the 40//40 page) would cross sides
						'title' => 'The 40//40 Solution on Amazon',
						'url'   => 'https://amzn.to/2maEiy3',
					),
				),
			),
			array(
				'name'  => 'Checklists, Reports, Tools and More',
				'chip'  => 'Checklists & Tools',
				'icon'  => 'checklist',
				'items' => array(
					array( 'title' => '4 Phases of Emotional Development' ),
					array( 'title' => '32 Things You Can Do to Be a Better Person' ),
					array( 'title' => '50 Things You Can Do to Nurture and Balance Your Emotional Energy' ),
					array(
						'title' => '90-Day Strategic Plan',
						'both'  => true,
					),
					array( 'title' => 'A Few Lessons Learned…' ),
					array( 'title' => 'An Exercise for Great Listening' ),
					array( 'title' => 'Balanced Life Checkup' ),
					array( 'title' => 'Being Safe at Work, Home, and on the Road' ),
					array( 'title' => 'Checklist for Preventing Mistakes' ),
					array( 'title' => 'Coachable Moments Checklist' ),
					array( 'title' => 'Coaching Poster' ),
					array( 'title' => 'Inspiring Quotes' ),
					array( 'title' => 'Nepotism: The Pitfalls and Challenges' ),
					array( 'title' => 'Revisiting Maslow’s Hierarchy of Needs' ),
					array( 'title' => 'Spiritual Wisdom' ),
					array( 'title' => 'The Five-Minute Listening Exercise' ),
					array( 'title' => 'Visualization Techniques for Success' ),
					array( 'title' => 'Your Health is Wealth Shopping Checklist' ),
				),
			),
		),

		// On hold, confirm with client: crossed out with no instruction. Kept as drafts.
		'hold'    => array(
			'10 Things You Can Do to Have a Great Flying Experience',
			'How to Hire Your First Coach',
			'Coaching Questions',
			'Coaching Session Preparation',
			'Timeline of a Coaching Session',
		),

		// Removed everywhere (its document, if it has one, stays in the Media Library)
		'delete'  => array( 'From Chaos to Order' ),

		// HR Tools' books, in this order
		'books'   => array(
			array( 'title' => 'A to Z of Work Ideas and Questions' ),
			array( 'title' => 'The Great Job Opportunity' ),
			array( 'title' => 'The Truth About HR and You' ),
			array( 'title' => 'Mastering Time Management' ),
			array(
				'title'    => 'The 40//40 Solution — Mastering Emotional Energy in Leadership and Sales',
				'category' => 'Books & Excerpts',
			),
		),
	);
}

/**
 * A title (or category name) with case, accents, punctuation and spaces taken out
 *
 * @param string $text A title.
 * @return string
 */
function donphin_resources_split_key( $text ) {
	$text = remove_accents( html_entity_decode( wp_strip_all_tags( (string) $text ), ENT_QUOTES, 'UTF-8' ) );
	return preg_replace( '/[^a-z0-9]/', '', strtolower( $text ) );
}

/**
 * Every resource of a side, with its matching key and category names
 *
 * @param string $side A key of donphin_resource_sides().
 * @return array
 */
function donphin_resources_split_posts( $side ) {
	$sides = donphin_resource_sides();
	$out   = array();
	foreach ( get_posts(
		array(
			'post_type'      => $sides[ $side ]['post_type'],
			'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
		)
	) as $post ) {
		$terms = get_the_terms( $post, $sides[ $side ]['taxonomy'] );
		$out[] = array(
			'post'       => $post,
			'key'        => donphin_resources_split_key( $post->post_title ),
			'categories' => ( $terms && ! is_wp_error( $terms ) ) ? wp_list_pluck( $terms, 'name' ) : array(),
		);
	}
	return $out;
}

/**
 * The resource an item of the brief means, among a side's
 *
 * @param array $item  'title', and 'category' where the title alone is ambiguous.
 * @param array $posts As donphin_resources_split_posts().
 * @return array|string The match, or why there isn't one.
 */
function donphin_resources_split_find( $item, $posts ) {
	$key     = donphin_resources_split_key( $item['title'] );
	$matches = array();
	foreach ( $posts as $entry ) {
		if ( $entry['key'] !== $key ) {
			continue;
		}
		if ( ! empty( $item['category'] ) && ! in_array( donphin_resources_split_key( $item['category'] ), array_map( 'donphin_resources_split_key', $entry['categories'] ), true ) ) {
			continue;
		}
		$matches[] = $entry;
	}
	if ( 1 === count( $matches ) ) {
		return $matches[0];
	}
	return $matches ? 'more than one match' : 'not found';
}

/**
 * Work out every change, without making any
 *
 * @return array steps (each: what, title, detail, done), problems, and the table of
 *               every resource afterwards (title, category, lists).
 */
function donphin_resources_split_plan() {
	$brief    = donphin_resources_split_brief();
	$speaking = donphin_resources_split_posts( 'speaking' );
	$counsel  = donphin_resources_split_posts( 'counsel' );
	$steps    = array();
	$problems = array();
	$lists    = array(); // Post ID => what it'll be on, for the table

	// Private Counsel: move, or copy when it's on both
	foreach ( $brief['counsel'] as $group ) {
		foreach ( $group['items'] as $position => $item ) {
			// In Counsel Resources it's under its group, not its Speaking category
			$copied = donphin_resources_split_find( array( 'title' => $item['title'] ), $counsel );
			$found  = donphin_resources_split_find( $item, $speaking );

			if ( is_array( $copied ) ) {
				$steps[] = array( 'what' => empty( $item['both'] ) ? 'move' : 'copy', 'title' => $item['title'], 'detail' => 'Already in Counsel Resources', 'done' => true );
				if ( ! empty( $item['url'] ) && get_post_meta( $copied['post']->ID, '_dp_res_url', true ) !== $item['url'] ) {
					$steps[] = array( 'what' => 'link', 'title' => $copied['post']->post_title, 'detail' => 'Its link becomes ' . $item['url'], 'done' => false, 'post_id' => $copied['post']->ID, 'url' => $item['url'] );
				}
				if ( is_array( $found ) && ! empty( $item['both'] ) ) {
					$lists[ $found['post']->ID ] = 'HR Tools, Private Counsel';
				}
				continue;
			}
			if ( ! is_array( $found ) ) {
				$problems[] = sprintf( '%s: %s in Speaking Resources', $item['title'], $found );
				continue;
			}

			$steps[] = array(
				'what'     => empty( $item['both'] ) ? 'move' : 'copy',
				'title'    => $found['post']->post_title,
				'detail'   => ( empty( $item['both'] ) ? 'Moves to Counsel Resources' : 'Copied to Counsel Resources, and stays in HR Tools' ) . ' → ' . $group['name'] . ' (#' . ( $position + 1 ) . ')',
				'done'     => false,
				'post_id'  => $found['post']->ID,
				'group'    => $group,
				'position' => $position,
				'url'      => isset( $item['url'] ) ? $item['url'] : '',
			);
			$lists[ $found['post']->ID ] = empty( $item['both'] ) ? 'Private Counsel' : 'HR Tools, Private Counsel';
		}
	}

	// On hold: drafts
	foreach ( $brief['hold'] as $title ) {
		$found = donphin_resources_split_find( array( 'title' => $title ), $speaking );
		if ( ! is_array( $found ) ) {
			$problems[] = sprintf( '%s: %s in Speaking Resources', $title, $found );
			continue;
		}
		$done    = 'draft' === $found['post']->post_status;
		$steps[] = array( 'what' => 'hold', 'title' => $found['post']->post_title, 'detail' => $done ? 'Already a draft' : 'Becomes a draft (on hold, kept)', 'done' => $done, 'post_id' => $found['post']->ID );
		$lists[ $found['post']->ID ] = 'On hold';
	}

	// Removed everywhere
	foreach ( $brief['delete'] as $title ) {
		$found = donphin_resources_split_find( array( 'title' => $title ), $speaking );
		if ( ! is_array( $found ) ) {
			$steps[] = array( 'what' => 'delete', 'title' => $title, 'detail' => 'Already gone', 'done' => true );
			continue;
		}
		$file    = (int) get_post_meta( $found['post']->ID, '_dp_res_file', true );
		$steps[] = array(
			'what'    => 'delete',
			'title'   => $found['post']->post_title,
			'detail'  => 'Deleted' . ( $file ? sprintf( '. Its document stays in the Media Library: attachment %d, %s', $file, wp_get_attachment_url( $file ) ) : ' (it has no document)' ),
			'done'    => false,
			'post_id' => $found['post']->ID,
		);
		$lists[ $found['post']->ID ] = 'Deleted';
	}

	// HR Tools' books, in order
	foreach ( $brief['books'] as $position => $item ) {
		$found = donphin_resources_split_find( $item, $speaking );
		if ( ! is_array( $found ) ) {
			$problems[] = sprintf( '%s: %s in Speaking Resources', $item['title'], $found );
			continue;
		}
		$done    = (int) $found['post']->menu_order === $position;
		$steps[] = array( 'what' => 'order', 'title' => $found['post']->post_title, 'detail' => $done ? 'Already in place' : sprintf( 'Book #%d on HR Tools', $position + 1 ), 'done' => $done, 'post_id' => $found['post']->ID, 'position' => $position );
	}

	// Every resource afterwards
	$table = array();
	foreach ( $speaking as $entry ) {
		$table[] = array(
			'title'    => $entry['post']->post_title,
			'category' => implode( ', ', $entry['categories'] ),
			'lists'    => isset( $lists[ $entry['post']->ID ] ) ? $lists[ $entry['post']->ID ] : ( 'draft' === $entry['post']->post_status ? 'On hold' : 'HR Tools' ),
		);
	}
	// Counsel's own (a copy of one on both lists is already counted, on its Speaking row)
	$on_both = array();
	foreach ( $speaking as $entry ) {
		if ( isset( $lists[ $entry['post']->ID ] ) && 'HR Tools, Private Counsel' === $lists[ $entry['post']->ID ] ) {
			$on_both[] = $entry['key'];
		}
	}
	foreach ( $counsel as $entry ) {
		if ( in_array( $entry['key'], $on_both, true ) ) {
			continue;
		}
		$table[] = array(
			'title'    => $entry['post']->post_title,
			'category' => implode( ', ', $entry['categories'] ) . ' (Counsel Resources)',
			'lists'    => 'Private Counsel',
		);
	}

	return array(
		'steps'    => $steps,
		'problems' => $problems,
		'table'    => $table,
	);
}

/**
 * Make the changes
 *
 * @return array What was done, one line each.
 */
function donphin_resources_split_apply() {
	$sides = donphin_resource_sides();
	$plan  = donphin_resources_split_plan();
	$log   = array();
	$terms = array();

	foreach ( $plan['steps'] as $step ) {
		if ( $step['done'] ) {
			continue;
		}
		$post_id = $step['post_id'];

		switch ( $step['what'] ) {
			case 'move':
			case 'copy':
				// The group's category first: without it, nothing moves
				$group = $step['group'];
				if ( ! isset( $terms[ $group['name'] ] ) ) {
					$terms[ $group['name'] ] = donphin_resources_split_category( $group, count( $terms ) );
				}
				if ( is_wp_error( $terms[ $group['name'] ] ) ) {
					$log[] = sprintf( 'Not done: %s (couldn’t make the category “%s”: %s)', $step['title'], $group['name'], $terms[ $group['name'] ]->get_error_message() );
					unset( $terms[ $group['name'] ] );
					break;
				}

				if ( 'move' === $step['what'] ) {
					if ( ! set_post_type( $post_id, $sides['counsel']['post_type'] ) ) {
						$log[] = 'Not done: couldn’t move ' . $step['title'];
						break;
					}
					wp_set_object_terms( $post_id, array(), $sides['speaking']['taxonomy'] );
					wp_update_post(
						array(
							'ID'         => $post_id,
							'menu_order' => $step['position'],
						)
					);
					$target = $post_id;
				} else {
					$source = get_post( $post_id );
					$target = $source ? wp_insert_post(
						array(
							'post_type'    => $sides['counsel']['post_type'],
							'post_status'  => 'publish',
							'post_title'   => $source->post_title,
							'post_content' => $source->post_content,
							'post_excerpt' => $source->post_excerpt,
							'menu_order'   => $step['position'],
						),
						true
					) : 0;
					if ( ! $target || is_wp_error( $target ) ) {
						$log[] = 'Not done: couldn’t copy ' . $step['title'] . ( is_wp_error( $target ) ? ' (' . $target->get_error_message() . ')' : '' );
						break;
					}
					foreach ( array( '_dp_res_file', '_dp_res_url', '_dp_res_tag' ) as $key ) {
						$value = get_post_meta( $post_id, $key, true );
						if ( '' !== $value ) {
							update_post_meta( $target, $key, $value );
						}
					}
				}

				$filed = wp_set_object_terms( $target, $terms[ $group['name'] ], $sides['counsel']['taxonomy'] );
				if ( ! empty( $step['url'] ) ) {
					update_post_meta( $target, '_dp_res_url', esc_url_raw( $step['url'] ) );
				}
				$log[] = ( 'move' === $step['what'] ? 'Moved ' : 'Copied ' ) . $step['title']
					. ( is_wp_error( $filed ) ? ' (but couldn’t file it under ' . $group['name'] . ': set its category by hand)' : '' );
				break;

			case 'link':
				$log[] = update_post_meta( $post_id, '_dp_res_url', esc_url_raw( $step['url'] ) )
					? 'Link: ' . $step['title'] . ' → ' . $step['url']
					: 'Not done: couldn’t change the link of ' . $step['title'];
				break;

			case 'hold':
				$result = wp_update_post(
					array(
						'ID'          => $post_id,
						'post_status' => 'draft',
					),
					true
				);
				$log[]  = is_wp_error( $result ) ? 'Not done: ' . $step['title'] . ' (' . $result->get_error_message() . ')' : 'On hold (draft): ' . $step['title'];
				break;

			case 'delete':
				$log[] = wp_delete_post( $post_id, true )
					? 'Deleted: ' . $step['title'] . '. ' . $step['detail']
					: 'Not done: couldn’t delete ' . $step['title'];
				break;

			case 'order':
				$result = wp_update_post(
					array(
						'ID'         => $post_id,
						'menu_order' => $step['position'],
					),
					true
				);
				$log[]  = is_wp_error( $result ) ? 'Not done: ' . $step['title'] . ' (' . $result->get_error_message() . ')' : sprintf( 'HR Tools book #%d: %s', $step['position'] + 1, $step['title'] );
				break;
		}
	}

	return $log;
}

/**
 * A Counsel Resources category for one of the groups, made if it isn't there yet
 *
 * @param array $group The group, as in donphin_resources_split_brief().
 * @param int   $index Its place among the groups.
 * @return int|WP_Error The category's ID, or why it couldn't be made.
 */
function donphin_resources_split_category( $group, $index ) {
	$sides    = donphin_resource_sides();
	$taxonomy = $sides['counsel']['taxonomy'];
	$term     = term_exists( $group['name'], $taxonomy );
	if ( ! $term ) {
		$term = wp_insert_term( $group['name'], $taxonomy );
	}
	if ( is_wp_error( $term ) ) {
		return $term;
	}
	$term_id = (int) $term['term_id'];
	update_term_meta( $term_id, 'dp_chip', $group['chip'] );
	update_term_meta( $term_id, 'dp_icon', $group['icon'] );
	update_term_meta( $term_id, 'dp_order', ( $index + 1 ) * 10 );
	return $term_id;
}

/**
 * The page under Counsel Resources, or under Tools once the admin menu is grouped by side
 * (inc/admin-menu.php): it is a one-time step, so it stays out of the side's own menu
 */
function donphin_resources_split_menu() {
	$sides = donphin_resource_sides();
	add_submenu_page(
		donphin_admin_menu_grouped() ? 'tools.php' : 'edit.php?post_type=' . $sides['counsel']['post_type'],
		__( 'Set up from Speaking', 'don-phin-esq' ),
		__( 'Set up from Speaking', 'don-phin-esq' ),
		'manage_options',
		'donphin-resources-split',
		'donphin_resources_split_page'
	);
}
add_action( 'admin_menu', 'donphin_resources_split_menu' );

/**
 * Print the page: what was just done (after Apply), what will change, any problems, and
 * every resource with the list(s) it'll be on
 */
function donphin_resources_split_page() {
	$log = array();
	if ( isset( $_POST['donphin_split_apply'] ) ) {
		check_admin_referer( 'donphin_resources_split' );
		if ( current_user_can( 'manage_options' ) ) {
			$log = donphin_resources_split_apply();
		}
	}

	$plan    = donphin_resources_split_plan();
	$pending = array_filter( $plan['steps'], function ( $step ) { return ! $step['done']; } );
	$counts  = array_count_values( array_column( $plan['table'], 'lists' ) );
	$hr      = 0;
	$pc      = 0;
	foreach ( $counts as $lists => $n ) {
		$hr += false !== strpos( $lists, 'HR Tools' ) ? $n : 0;
		$pc += false !== strpos( $lists, 'Private Counsel' ) ? $n : 0;
	}
	$labels = array(
		'move'   => 'Move',
		'copy'   => 'Copy',
		'hold'   => 'On hold',
		'delete' => 'Delete',
		'order'  => 'Order',
		'link'   => 'Link',
	);
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Set up Counsel Resources from Speaking', 'don-phin-esq' ); ?></h1>
		<p><?php esc_html_e( 'Splits the one library into Private Counsel’s and HR Tools (Speaking), as Don marked it up. Nothing changes until you press Apply; pressing it again only does what isn’t done yet.', 'don-phin-esq' ); ?></p>

		<?php if ( $log ) : ?>
			<?php
			// Anything that didn't work says so, and Apply again retries just that
			$failed = array_filter(
				$log,
				function ( $line ) {
					return 0 === strpos( $line, 'Not done' ) || false !== strpos( $line, 'by hand' );
				}
			);
			?>
			<div class="notice <?php echo $failed ? 'notice-warning' : 'notice-success'; ?>"><p><strong><?php echo esc_html( $failed ? sprintf( 'Done, but %d didn’t work (below). Press Apply again to retry them.', count( $failed ) ) : 'Done.' ); ?></strong></p><ul style="list-style:disc;padding-left:20px">
				<?php foreach ( $log as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
			</ul></div>
		<?php endif; ?>

		<?php if ( $plan['problems'] ) : ?>
			<div class="notice notice-error"><p><strong><?php esc_html_e( 'Couldn’t find these (they’ll be skipped):', 'don-phin-esq' ); ?></strong></p><ul style="list-style:disc;padding-left:20px">
				<?php foreach ( $plan['problems'] as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
			</ul></div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Afterwards', 'don-phin-esq' ); ?></h2>
		<p>
			<?php
			echo esc_html(
				sprintf(
					'Private Counsel: %d · HR Tools: %d · On hold: %d · Deleted: %d',
					$pc,
					$hr,
					isset( $counts['On hold'] ) ? $counts['On hold'] : 0,
					isset( $counts['Deleted'] ) ? $counts['Deleted'] : 0
				)
			);
			?>
		</p>

		<?php if ( $pending ) : ?>
			<h2><?php echo esc_html( sprintf( 'Changes to make (%d)', count( $pending ) ) ); ?></h2>
			<table class="widefat striped" style="max-width:1100px">
				<thead><tr><th style="width:90px">Change</th><th>Resource</th><th>What happens</th></tr></thead>
				<tbody>
					<?php foreach ( $pending as $step ) : ?>
						<tr><td><?php echo esc_html( $labels[ $step['what'] ] ); ?></td><td><?php echo esc_html( $step['title'] ); ?></td><td><?php echo esc_html( $step['detail'] ); ?></td></tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<form method="post" style="margin-top:16px">
				<?php wp_nonce_field( 'donphin_resources_split' ); ?>
				<p><button type="submit" name="donphin_split_apply" value="1" class="button button-primary button-large"><?php echo esc_html( sprintf( 'Apply these %d changes', count( $pending ) ) ); ?></button></p>
				<p class="description"><?php esc_html_e( 'Before you do: Tools > Export > Speaking Resources makes a copy you can import back if anything goes wrong.', 'don-phin-esq' ); ?></p>
			</form>
		<?php else : ?>
			<div class="notice notice-info inline"><p><?php esc_html_e( 'Everything is done: there’s nothing left to change.', 'don-phin-esq' ); ?></p></div>
		<?php endif; ?>

		<h2><?php echo esc_html( sprintf( 'Every resource (%d)', count( $plan['table'] ) ) ); ?></h2>
		<table class="widefat striped" style="max-width:1100px">
			<thead><tr><th>Title</th><th>Category</th><th>List(s)</th></tr></thead>
			<tbody>
				<?php foreach ( $plan['table'] as $row ) : ?>
					<tr><td><?php echo esc_html( $row['title'] ); ?></td><td><?php echo esc_html( html_entity_decode( $row['category'], ENT_QUOTES, 'UTF-8' ) ); ?></td><td><?php echo esc_html( $row['lists'] ); ?></td></tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * Point to the page from the Counsel Resources list while it's still empty
 */
function donphin_resources_split_notice() {
	$screen = get_current_screen();
	$sides  = donphin_resource_sides();
	if ( ! $screen || 'edit' !== $screen->base || $sides['counsel']['post_type'] !== $screen->post_type || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( array_sum( (array) wp_count_posts( $sides['counsel']['post_type'] ) ) > 0 ) {
		return;
	}
	printf(
		'<div class="notice notice-info"><p><strong>%s</strong> <a href="%s">%s</a></p></div>',
		esc_html__( 'Counsel Resources is empty.', 'don-phin-esq' ),
		esc_url( menu_page_url( 'donphin-resources-split', false ) ),
		esc_html__( 'Set it up from Speaking Resources (shows every change first) →', 'don-phin-esq' )
	);
}
add_action( 'admin_notices', 'donphin_resources_split_notice' );
