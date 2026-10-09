<?php
/**
 * The admin menu, grouped by side of the site
 *
 * Instead of a loose menu item for each content type (Speaking Resources, Counsel
 * Resources, Speaking Blog, Counsel Blog, Enquiries, Toolkit sign-ups), each side gets one
 * menu holding everything of its own, and the forms' entries share one "Leads" menu:
 *
 *   Speaking         Blog posts, Add blog post, Blog categories,
 *                    Resources, Add resource, Resource categories
 *   Private Counsel  the same, for its side
 *   Leads (n)        All enquiries, one list per side, Toolkit sign-ups
 *
 * The sides come from the blogs' and libraries' own lists (donphin_blog_sides(),
 * donphin_resource_sides()), so a side added there gets its menu here without any
 * change to this file. Each side's menu and screens are in its own colours (section 5,
 * assets/css/admin-menu.css). Posts is hidden while it holds nothing but WordPress's
 * sample, and comments are switched off: the site doesn't use them.
 *
 * Only WordPress's own menu APIs are used (show_in_menu, add_menu_page,
 * add_submenu_page, the parent_file, submenu_file and menu_order filters); the screens and
 * their addresses are WordPress's own and stay as they were. To put the default menu
 * back, add define( 'DONPHIN_DEFAULT_ADMIN_MENU', true ); to wp-config.php (or return
 * false from the donphin_group_admin_menu filter). Comments come back the same way with
 * the donphin_comments_off filter.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the menu is grouped by side (it is, unless switched off)
 *
 * @return bool
 */
function donphin_admin_menu_grouped() {
	return (bool) apply_filters( 'donphin_group_admin_menu', ! ( defined( 'DONPHIN_DEFAULT_ADMIN_MENU' ) && DONPHIN_DEFAULT_ADMIN_MENU ) );
}

/**
 * Each side's menu: its name, icon and place, and its blog and library (either may be
 * missing), by section key, in the blogs' order (Speaking first)
 *
 * A menu's own address is its first list (the blog's, or else the library's), as
 * WordPress expects of a menu made of other screens: it opens there, and there's no extra
 * item leading back to the menu itself.
 *
 * @return array
 */
function donphin_admin_menu_sides() {
	$icons     = array(
		'speaking' => 'dashicons-megaphone',
		'counsel'  => 'dashicons-businessperson',
	);
	// A short name, where the side's full one is too long (Leads' lists)
	$short     = array(
		'counsel' => 'Counsel',
	);
	// Each side's colours in the menu (assets/css/admin-menu.css), from its own palette:
	// accent (the stripe and icon), fill and fill-end (the open menu's bar), on-fill (type
	// on it), deep (the open menu's list) and current (the item you're on).
	// Speaking: speaking.css. Private Counsel: private-counsel.css.
	$colors    = array(
		'speaking' => array(
			'accent'   => '#FF6B35',
			'fill'     => '#FF6B35',
			'fill-end' => '#D9531E',
			'on-fill'  => '#FFFFFF',
			'deep'     => '#00303E',
			'current'  => '#25CED1',
		),
		'counsel'  => array(
			'accent'   => '#C4A27A',
			'fill'     => '#A67C4E',
			'fill-end' => '#8A5A2B',
			'on-fill'  => '#FCFAF6',
			'deep'     => '#0F1E38',
			'current'  => '#D2B48C',
		),
	);
	$sections  = donphin_sections();
	$blogs     = donphin_blog_sides();
	$libraries = donphin_resource_sides();
	$sides     = array();
	$position  = 1;
	foreach ( array_keys( array_merge( $blogs, $libraries ) ) as $key ) {
		$blog    = isset( $blogs[ $key ] ) ? $blogs[ $key ] : null;
		$library = isset( $libraries[ $key ] ) ? $libraries[ $key ] : null;
		$first   = $blog ? $blog : $library;

		$sides[ $key ] = array(
			'slug'     => 'edit.php?post_type=' . $first['post_type'],
			'label'    => isset( $sections[ $key ] ) ? ucwords( $sections[ $key ]['label'] ) : ucwords( $key ), // "Private counsel" reads "Private Counsel" in the menu
			'short'    => isset( $short[ $key ] ) ? $short[ $key ] : ( isset( $sections[ $key ] ) ? ucwords( $sections[ $key ]['label'] ) : ucwords( $key ) ),
			'icon'     => isset( $icons[ $key ] ) ? $icons[ $key ] : 'dashicons-category',
			'colors'   => isset( $colors[ $key ] ) ? $colors[ $key ] : array(),
			'position' => '4.' . $position++, // After the Dashboard and its separator
			'blog'     => $blog,
			'library'  => $library,
		);
	}
	return $sides;
}

/**
 * Which side's menu a content type or category belongs to, and what its items are called
 *
 * @return array { types: post type => side key, taxonomies: taxonomy => post type }
 */
function donphin_admin_menu_map() {
	$map = array(
		'types'      => array(),
		'taxonomies' => array(),
	);
	foreach ( donphin_admin_menu_sides() as $key => $side ) {
		foreach ( array( 'blog', 'library' ) as $part ) {
			if ( $side[ $part ] ) {
				$map['types'][ $side[ $part ]['post_type'] ]     = $key;
				$map['taxonomies'][ $side[ $part ]['taxonomy'] ] = $side[ $part ]['post_type'];
			}
		}
	}
	return $map;
}

/**
 * The forms' entries, all under Leads, which opens on all the enquiries
 */
define( 'DONPHIN_LEADS_MENU', 'edit.php?post_type=dp_enquiry' );

function donphin_admin_menu_lead_types() {
	return array( 'dp_enquiry', 'dp_toolkit_signup' );
}

/* ==========================================================================
   1. EACH CONTENT TYPE INTO ITS MENU (as it's registered)
   ========================================================================== */

/**
 * File each side's blog and library under the side's menu, and the forms' entries under
 * Leads, naming each list for where it now sits
 */
function donphin_admin_menu_post_type_args( $args, $post_type ) {
	if ( ! donphin_admin_menu_grouped() ) {
		return $args;
	}

	$map = donphin_admin_menu_map();
	if ( isset( $map['types'][ $post_type ] ) ) {
		$sides   = donphin_admin_menu_sides();
		$side    = $sides[ $map['types'][ $post_type ] ];
		$is_blog = $side['blog'] && $side['blog']['post_type'] === $post_type;

		$args['show_in_menu']        = $side['slug'];
		$args['show_in_admin_bar']   = true; // Still in "+ New" on the toolbar
		$args['labels']              = isset( $args['labels'] ) ? (array) $args['labels'] : array();
		$args['labels']['all_items'] = $is_blog ? __( 'Blog posts', 'don-phin-esq' ) : __( 'Resources', 'don-phin-esq' );
		return $args;
	}

	if ( in_array( $post_type, donphin_admin_menu_lead_types(), true ) ) {
		$args['show_in_menu']        = DONPHIN_LEADS_MENU;
		$args['labels']              = isset( $args['labels'] ) ? (array) $args['labels'] : array();
		$args['labels']['all_items'] = 'dp_enquiry' === $post_type ? __( 'All enquiries', 'don-phin-esq' ) : __( 'Toolkit sign-ups', 'don-phin-esq' );
	}
	return $args;
}
add_filter( 'register_post_type_args', 'donphin_admin_menu_post_type_args', 10, 2 );

/* ==========================================================================
   2. THE MENUS
   ========================================================================== */

/**
 * The side menus and Leads. Each one opens on its first item (WordPress links a menu
 * with no page of its own to its first item).
 */
function donphin_admin_menu_add_menus() {
	if ( ! donphin_admin_menu_grouped() ) {
		return;
	}

	foreach ( donphin_admin_menu_sides() as $side ) {
		add_menu_page( $side['label'], $side['label'], 'edit_posts', $side['slug'], '', $side['icon'], $side['position'] );
	}

	$unread = donphin_admin_menu_unread_enquiries();
	add_menu_page(
		__( 'Leads', 'don-phin-esq' ),
		__( 'Leads', 'don-phin-esq' ) . donphin_admin_menu_badge( $unread ),
		'edit_posts',
		DONPHIN_LEADS_MENU,
		'',
		'dashicons-email-alt2',
		'4.9'
	);
}
add_action( 'admin_menu', 'donphin_admin_menu_add_menus', 9 ); // Before WordPress files the lists under them (10)

/**
 * The rest of each menu, around the lists WordPress has filed there: after each list, its
 * "Add" screen and its categories. Leads gets a list of enquiries per side.
 */
function donphin_admin_menu_add_items() {
	if ( ! donphin_admin_menu_grouped() ) {
		return;
	}

	foreach ( donphin_admin_menu_sides() as $side ) {
		// WordPress has filed the blog's list, then the library's (in the order they're
		// registered: inc/blog.php registers first). Each one's extras go just after it.
		$index = 0;
		$parts = array(
			'blog'    => array( __( 'Add blog post', 'don-phin-esq' ), __( 'Blog categories', 'don-phin-esq' ) ),
			'library' => array( __( 'Add resource', 'don-phin-esq' ), __( 'Resource categories', 'don-phin-esq' ) ),
		);
		foreach ( $parts as $part => $labels ) {
			if ( ! $side[ $part ] ) {
				continue;
			}
			$type     = get_post_type_object( $side[ $part ]['post_type'] );
			$taxonomy = get_taxonomy( $side[ $part ]['taxonomy'] );
			if ( ! $type ) {
				continue;
			}
			++$index; // Past the list itself

			add_submenu_page( $side['slug'], $labels[0], $labels[0], $type->cap->create_posts, 'post-new.php?post_type=' . $type->name, '', $index++ );
			if ( $taxonomy ) {
				add_submenu_page( $side['slug'], $labels[1], $labels[1], $taxonomy->cap->manage_terms, 'edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=' . $type->name, '', $index++ );
			}
		}
	}

	// Leads: after "All enquiries", one list per form
	$enquiries = get_post_type_object( 'dp_enquiry' );
	if ( $enquiries && function_exists( 'donphin_contact_forms' ) ) {
		$index = 1;
		$sides = donphin_admin_menu_sides();
		foreach ( donphin_contact_forms() as $key => $form ) {
			$label = isset( $sides[ $key ] ) ? $sides[ $key ]['short'] : $form['topic'];
			$count = donphin_admin_menu_unread_enquiries( $key );
			/* translators: %s: a side of the site, short, e.g. Speaking or Counsel */
			$title = sprintf( __( '%s enquiries', 'don-phin-esq' ), $label );
			add_submenu_page( DONPHIN_LEADS_MENU, $title, $title . donphin_admin_menu_badge( $count ), $enquiries->cap->edit_posts, 'edit.php?post_type=dp_enquiry&dp_side=' . $key, '', $index++ );
		}
	}
}
add_action( 'admin_menu', 'donphin_admin_menu_add_items', 11 );

/**
 * Light up the right menu and item on each screen: WordPress would look for the old
 * top-level items
 */
function donphin_admin_menu_parent_file( $parent_file ) {
	global $typenow;
	if ( ! donphin_admin_menu_grouped() ) {
		return $parent_file;
	}

	$map  = donphin_admin_menu_map();
	$type = donphin_admin_menu_current_type();
	if ( isset( $map['types'][ $type ] ) ) {
		$sides = donphin_admin_menu_sides();
		return $sides[ $map['types'][ $type ] ]['slug'];
	}
	if ( in_array( $typenow, donphin_admin_menu_lead_types(), true ) ) {
		return DONPHIN_LEADS_MENU;
	}
	return $parent_file;
}
add_filter( 'parent_file', 'donphin_admin_menu_parent_file' );

function donphin_admin_menu_submenu_file( $submenu_file ) {
	global $pagenow, $taxnow, $typenow;
	if ( ! donphin_admin_menu_grouped() ) {
		return $submenu_file;
	}

	$map  = donphin_admin_menu_map();
	$type = donphin_admin_menu_current_type();
	if ( isset( $map['types'][ $type ] ) ) {
		if ( in_array( $pagenow, array( 'edit-tags.php', 'term.php' ), true ) && isset( $map['taxonomies'][ $taxnow ] ) ) {
			return 'edit-tags.php?taxonomy=' . $taxnow . '&post_type=' . $type;
		}
		if ( 'post-new.php' === $pagenow ) {
			return 'post-new.php?post_type=' . $type;
		}
		return 'edit.php?post_type=' . $type;
	}

	if ( 'dp_enquiry' === $typenow && 'edit.php' === $pagenow ) {
		$side = donphin_admin_menu_enquiry_side();
		return $side ? 'edit.php?post_type=dp_enquiry&dp_side=' . $side : 'edit.php?post_type=dp_enquiry';
	}
	return $submenu_file;
}
add_filter( 'submenu_file', 'donphin_admin_menu_submenu_file' );

/**
 * The post type the current screen is about: its own, or its category's
 */
function donphin_admin_menu_current_type() {
	global $typenow, $taxnow;
	if ( $typenow ) {
		return $typenow;
	}
	$map = donphin_admin_menu_map();
	return ( $taxnow && isset( $map['taxonomies'][ $taxnow ] ) ) ? $map['taxonomies'][ $taxnow ] : '';
}

/**
 * The order of the menu's top: the Dashboard, then each side and Leads, then Posts (if
 * shown), Pages and Media. Everything else, plugins' menus included, keeps its place after.
 */
function donphin_admin_menu_order( $order ) {
	if ( ! donphin_admin_menu_grouped() || ! is_array( $order ) ) {
		return $order;
	}
	$top = array( 'index.php', 'separator1' );
	foreach ( donphin_admin_menu_sides() as $side ) {
		$top[] = $side['slug'];
	}
	$top = array_merge( $top, array( DONPHIN_LEADS_MENU, 'edit.php', 'edit.php?post_type=page', 'upload.php' ) );

	$rest = array_diff( $order, $top );
	return array_merge( array_values( array_intersect( $top, $order ) ), array_values( $rest ) );
}
add_filter( 'custom_menu_order', 'donphin_admin_menu_grouped' );
add_filter( 'menu_order', 'donphin_admin_menu_order' );

/* ==========================================================================
   3. LEADS: ENQUIRIES BY SIDE, AND HOW MANY ARE UNREAD
   ========================================================================== */

/**
 * The side asked for on the enquiries list (?dp_side=speaking), if it's a real one
 *
 * @return string A key of donphin_contact_forms(), or ''.
 */
function donphin_admin_menu_enquiry_side() {
	$side = isset( $_GET['dp_side'] ) ? sanitize_key( wp_unslash( $_GET['dp_side'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- only filters a list
	$forms = function_exists( 'donphin_contact_forms' ) ? donphin_contact_forms() : array();
	return isset( $forms[ $side ] ) ? $side : '';
}

/**
 * Show only that side's enquiries (each records the form it came from, as its topic)
 */
function donphin_admin_menu_filter_enquiries( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() || 'dp_enquiry' !== $query->get( 'post_type' ) ) {
		return;
	}
	$side = donphin_admin_menu_enquiry_side();
	if ( ! $side ) {
		return;
	}
	$forms = donphin_contact_forms();
	$query->set(
		'meta_query',
		array(
			array(
				'key'   => '_dp_topic',
				'value' => $forms[ $side ]['topic'],
			),
		)
	);
}
add_action( 'pre_get_posts', 'donphin_admin_menu_filter_enquiries' );

/**
 * Enquiries nobody has opened yet, all of them or one side's
 *
 * @param string $side A key of donphin_contact_forms(), or '' for all.
 * @return int
 */
function donphin_admin_menu_unread_enquiries( $side = '' ) {
	static $counts = array();
	if ( isset( $counts[ $side ] ) ) {
		return $counts[ $side ];
	}

	$meta = array(
		array(
			'key'     => '_dp_seen',
			'compare' => 'NOT EXISTS',
		),
	);
	if ( '' !== $side ) {
		$forms  = donphin_contact_forms();
		$meta[] = array(
			'key'   => '_dp_topic',
			'value' => isset( $forms[ $side ] ) ? $forms[ $side ]['topic'] : '',
		);
	}

	$found = new WP_Query(
		array(
			'post_type'              => 'dp_enquiry',
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'meta_query'             => $meta, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- a handful of entries, admin only
			'no_found_rows'          => false,
			'update_post_term_cache' => false,
		)
	);

	$counts[ $side ] = (int) $found->found_posts;
	return $counts[ $side ];
}

/**
 * The red count WordPress shows beside "Comments" and "Plugins", for a menu item
 *
 * @param int $count How many.
 * @return string '' for none.
 */
function donphin_admin_menu_badge( $count ) {
	if ( $count < 1 ) {
		return '';
	}
	return sprintf( ' <span class="awaiting-mod count-%1$d"><span class="pending-count">%1$s</span></span>', $count, esc_html( number_format_i18n( $count ) ) );
}

/**
 * Opening an enquiry marks it read
 */
function donphin_admin_menu_mark_enquiry_seen() {
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- only notes that it was opened
	if ( $post_id && 'dp_enquiry' === get_post_type( $post_id ) && current_user_can( 'edit_post', $post_id ) && ! get_post_meta( $post_id, '_dp_seen', true ) ) {
		update_post_meta( $post_id, '_dp_seen', time() );
	}
}
add_action( 'load-post.php', 'donphin_admin_menu_mark_enquiry_seen' );

/**
 * "New" beside each unopened enquiry in the list
 */
function donphin_admin_menu_enquiry_state( $states, $post ) {
	if ( 'dp_enquiry' === $post->post_type && ! get_post_meta( $post->ID, '_dp_seen', true ) ) {
		$states['dp_new'] = __( 'New', 'don-phin-esq' );
	}
	return $states;
}
add_filter( 'display_post_states', 'donphin_admin_menu_enquiry_state', 10, 2 );

/* ==========================================================================
   4. WHAT THE SITE DOESN'T USE: POSTS (WHILE EMPTY) AND COMMENTS
   ========================================================================== */

/**
 * Whether Posts holds anything but WordPress's sample ("Hello world!"). New writing goes
 * straight into a side's blog, so Posts is hidden until something lands there; it comes
 * back by itself with its "Move to …" links (inc/blog.php) when it does.
 *
 * @return bool
 */
function donphin_admin_menu_posts_in_use() {
	static $in_use = null;
	if ( null === $in_use ) {
		$sample = get_post( 1 );
		$found  = get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => array( 'publish', 'draft', 'pending', 'future', 'private' ),
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'post__not_in'   => ( $sample && 'post' === $sample->post_type && 'hello-world' === $sample->post_name ) ? array( 1 ) : array(),
			)
		);
		$in_use = ! empty( $found );
	}
	return $in_use;
}

/**
 * Hide Posts (while unused) and Comments from the menu
 */
function donphin_admin_menu_hide() {
	if ( ! donphin_admin_menu_grouped() ) {
		return;
	}
	if ( ! donphin_admin_menu_posts_in_use() ) {
		remove_menu_page( 'edit.php' );
	}
	if ( donphin_comments_off() ) {
		remove_menu_page( 'edit-comments.php' );
	}
}
add_action( 'admin_menu', 'donphin_admin_menu_hide', 99 );

/**
 * And from the toolbar: "+ New > Post" while Posts is hidden, and the comments bubble
 */
function donphin_admin_menu_toolbar( $bar ) {
	if ( ! donphin_admin_menu_grouped() ) {
		return;
	}
	if ( ! donphin_admin_menu_posts_in_use() ) {
		$bar->remove_node( 'new-post' );
	}
	if ( donphin_comments_off() ) {
		$bar->remove_node( 'comments' );
	}
}
add_action( 'admin_bar_menu', 'donphin_admin_menu_toolbar', 999 );

/**
 * The Dashboard's Quick Draft writes into Posts, so it goes while Posts is hidden
 */
function donphin_admin_menu_dashboard() {
	if ( donphin_admin_menu_grouped() && ! donphin_admin_menu_posts_in_use() ) {
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	}
}
add_action( 'wp_dashboard_setup', 'donphin_admin_menu_dashboard' );

/**
 * Whether comments are off (they are, unless switched back on)
 *
 * @return bool
 */
function donphin_comments_off() {
	return (bool) apply_filters( 'donphin_comments_off', true );
}

/**
 * Comments off for real, not just out of the menu: closed everywhere, no pingbacks, the
 * old ones not shown, and the comment boxes gone from the editor
 */
function donphin_comments_switch_off() {
	if ( ! donphin_comments_off() ) {
		return;
	}
	foreach ( get_post_types() as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
add_action( 'init', 'donphin_comments_switch_off', 100 );

function donphin_comments_closed( $open ) {
	return donphin_comments_off() ? false : $open;
}
add_filter( 'comments_open', 'donphin_comments_closed', 20 );
add_filter( 'pings_open', 'donphin_comments_closed', 20 );

function donphin_comments_hidden( $comments ) {
	return donphin_comments_off() ? array() : $comments;
}
add_filter( 'comments_array', 'donphin_comments_hidden', 20 );

/**
 * No "X-Pingback" header or pingback endpoint either
 */
function donphin_comments_no_pingback_header( $headers ) {
	if ( donphin_comments_off() ) {
		unset( $headers['X-Pingback'] );
	}
	return $headers;
}
add_filter( 'wp_headers', 'donphin_comments_no_pingback_header' );

function donphin_comments_no_pingback_method( $methods ) {
	if ( donphin_comments_off() ) {
		unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );
	}
	return $methods;
}
add_filter( 'xmlrpc_methods', 'donphin_comments_no_pingback_method' );

/* ==========================================================================
   5. EACH SIDE IN ITS OWN COLOURS
   ========================================================================== */

/**
 * Every menu in its own colours: each side, and Leads in the site's own blue and ink (the
 * header's, style.css). By key: its menu's address, its name, its colours (see
 * donphin_admin_menu_sides()) and the post types whose screens are its.
 *
 * @return array
 */
function donphin_admin_menu_colored() {
	$colored = array();
	$map     = donphin_admin_menu_map();
	foreach ( donphin_admin_menu_sides() as $key => $side ) {
		if ( $side['colors'] ) {
			$colored[ $key ] = array(
				'slug'   => $side['slug'],
				'label'  => $side['label'],
				'colors' => $side['colors'],
				'types'  => array_keys( $map['types'], $key, true ),
			);
		}
	}
	$colored['leads'] = array(
		'slug'   => DONPHIN_LEADS_MENU,
		'label'  => __( 'Leads', 'don-phin-esq' ),
		'colors' => array(
			'accent'   => '#8DB6F5',
			'fill'     => '#1F6BE0',
			'fill-end' => '#1857B8',
			'on-fill'  => '#FFFFFF',
			'deep'     => '#2A2029',
			'current'  => '#8DB6F5',
		),
		'types'  => donphin_admin_menu_lead_types(),
	);
	return $colored;
}

/**
 * The menu's colours (assets/css/admin-menu.css), each menu's own set on its item and on
 * its screens: a stripe and a tinted icon always, its colour across its bar and its dark
 * ground under its list while it's open, and its name beside the title on its screens
 */
function donphin_admin_menu_colors() {
	if ( ! donphin_admin_menu_grouped() ) {
		return;
	}
	donphin_enqueue_asset( 'css', 'admin-menu' );

	$css = '';
	foreach ( donphin_admin_menu_colored() as $key => $item ) {
		$vars = '';
		foreach ( $item['colors'] as $name => $value ) {
			$vars .= '--dp-am-' . $name . ':' . sanitize_hex_color( $value ) . ';';
		}
		// On its menu item (classed by donphin_admin_menu_side_classes()), and on its screens
		$css .= '#adminmenu li.dp-am-side-' . sanitize_key( $key ) . '{' . $vars . '}';
		$css .= 'body.dp-admin-side-' . sanitize_key( $key ) . '{' . $vars . '--dp-am-label:"' . esc_attr( $item['label'] ) . '";}';
	}
	wp_add_inline_style( 'donphin-admin-menu', $css );
}
add_action( 'admin_enqueue_scripts', 'donphin_admin_menu_colors' );

/**
 * Note on each screen's body which menu it belongs to (dp-admin-side-speaking)
 */
function donphin_admin_menu_body_class( $classes ) {
	if ( ! donphin_admin_menu_grouped() ) {
		return $classes;
	}
	$type = donphin_admin_menu_current_type();
	foreach ( donphin_admin_menu_colored() as $key => $item ) {
		if ( $type && in_array( $type, $item['types'], true ) ) {
			return $classes . ' dp-admin-side dp-admin-side-' . sanitize_html_class( $key );
		}
	}
	return $classes;
}
add_filter( 'admin_body_class', 'donphin_admin_menu_body_class' );

/**
 * Mark each coloured menu's item (dp-am-side, and dp-am-side-{key} for its colours), so
 * admin-menu.css can colour it (WordPress's filter for the classes on top-level items)
 */
function donphin_admin_menu_side_classes( $menu ) {
	if ( ! donphin_admin_menu_grouped() ) {
		return $menu;
	}
	$slugs = array_flip( wp_list_pluck( donphin_admin_menu_colored(), 'slug' ) ); // slug => key
	foreach ( $menu as $index => $item ) {
		if ( isset( $item[2], $item[4], $slugs[ $item[2] ] ) ) {
			$menu[ $index ][4] .= ' dp-am-side dp-am-side-' . sanitize_html_class( $slugs[ $item[2] ] );
		}
	}
	return $menu;
}
add_filter( 'add_menu_classes', 'donphin_admin_menu_side_classes' );
