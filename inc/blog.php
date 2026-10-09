<?php
/**
 * Blogs: each section's own, managed in the admin (Speaking Blog, Counsel Blog)
 *
 * Every section keeps its own posts, in its own admin menu, with its own categories and
 * its own addresses: the list at /speaking/blog/, a post at /speaking/blog/{post}/, a
 * category at /speaking/blog/topic/{category}/. A post belongs to one side only, so the
 * Speaking blog never shows a Private Counsel post and the other way round. Sections
 * that have a blog are listed in donphin_blog_sides(); adding one there is all a new
 * blog needs.
 *
 * The list is archive-blog.php and a post is single-blog.php, for every side; their
 * colours, typefaces and layout come from the section (assets/css/blog.css).
 *
 * Posts written as ordinary WordPress Posts move to a side from the Posts screen ("Move
 * to Speaking Blog"); their old address keeps working (inc/redirects.php).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The sections that have a blog, by section key (see donphin_sections())
 *
 * post_type  The post type's name (20 characters at most).
 * taxonomy   Its categories.
 * base       Where its posts live: {base}/{post}/. The list sits at the base itself,
 *            and a category at {base}/topic/{category}/.
 * name       The admin menu's name; singular for one.
 * per_page   Posts on each page of the list.
 * label      The small label over the list's heading.
 * heading    The list's heading, and an italic accent after it ('' for none).
 * intro      The line under the heading.
 * cta        The invitation after each post and at the foot of the list: title, text,
 *            the button's label and where it leads.
 * author     The card about Don at the foot of each post: a line about him, and his
 *            About page on this side.
 *
 * @return array
 */
function donphin_blog_sides() {
	return array(
		'speaking' => array(
			'post_type' => 'dp_speaking_post',
			'taxonomy'  => 'dp_speaking_blog_cat',
			'base'      => 'speaking/blog',
			'name'      => 'Speaking Blog',
			'singular'  => 'Speaking Post',
			'per_page'  => 10, // The newest across the top, then three rows of three
			'label'     => 'The Blog',
			'heading'   => array( 'Ideas from', 'the stage.' ), // Placeholder until Don names it
			'intro'     => 'Leadership, sales and the workplace: the stories behind the keynotes, and what to do with them on Monday.',
			'cta'       => array(
				'title' => 'Want this to land with your whole team?',
				'text'  => 'Don brings these ideas to life on stage, for sales meetings, leadership retreats and conferences.',
				'label' => 'Book Don',
				'url'   => '/speaking/contact/',
			),
			'author'    => array(
				'bio' => 'Trial lawyer turned keynote speaker. Seventeen years arguing cases to juries taught Don that facts alone never win a room. Stories do. He’s the author of The 40//40 Solution.',
				'url' => '/speaking/about/',
			),
		),
		'counsel'  => array(
			'post_type' => 'dp_counsel_post',
			'taxonomy'  => 'dp_counsel_blog_cat',
			'base'      => 'private-counsel/blog',
			'name'      => 'Counsel Blog',
			'singular'  => 'Counsel Post',
			'per_page'  => 8,
			'label'     => 'Private Counsel',
			'heading'   => array( 'Reflections', '' ), // Placeholder until Don names it
			'intro'     => 'On judgment, legacy, and the journey that comes after the one you planned.',
			'cta'       => array(
				'title' => 'When you’re ready for what comes next',
				'text'  => 'Private counsel is by introduction, for one man at a time.',
				'label' => 'Request an introduction',
				'url'   => '/private-counsel/contact/',
			),
			'author'    => array(
				'bio' => 'For over forty years, Don has sat with CEOs, entrepreneurs, physicians and family business owners: first as an employment lawyer, then as a founder, and now as private counsel.',
				'url' => '/private-counsel/about/',
			),
		),
	);
}

/**
 * Every blog post type
 *
 * @return array
 */
function donphin_blog_post_types() {
	return array_values( wp_list_pluck( donphin_blog_sides(), 'post_type' ) );
}

/**
 * Which section a blog post type belongs to
 *
 * @param string $post_type A post type.
 * @return string A section key, or '' if it isn't a blog type.
 */
function donphin_blog_side( $post_type ) {
	foreach ( donphin_blog_sides() as $key => $side ) {
		if ( $side['post_type'] === $post_type ) {
			return $key;
		}
	}
	return '';
}

/**
 * Which section's blog the current request is: a post, the list, or a category of it
 *
 * @return string A section key, or '' if the request isn't a blog's.
 */
function donphin_blog_side_for_request() {
	foreach ( donphin_blog_sides() as $key => $side ) {
		if ( is_singular( $side['post_type'] ) || is_post_type_archive( $side['post_type'] ) || is_tax( $side['taxonomy'] ) ) {
			return $key;
		}
	}
	return '';
}

/**
 * Register each section's blog and its categories
 */
function donphin_register_blogs() {
	foreach ( donphin_blog_sides() as $side ) {
		// Categories first: their addresses ({base}/topic/{category}/) must be matched before
		// the posts', or a category would be read as an attachment of a post called "topic"
		register_taxonomy(
			$side['taxonomy'],
			$side['post_type'],
			array(
				'labels'            => array(
					'name'          => __( 'Categories', 'don-phin-esq' ),
					'singular_name' => __( 'Category', 'don-phin-esq' ),
					'menu_name'     => __( 'Categories', 'don-phin-esq' ),
					'add_new_item'  => __( 'Add Category', 'don-phin-esq' ),
					'edit_item'     => __( 'Edit Category', 'don-phin-esq' ),
				),
				// Each category is a filtered list of its own: {base}/topic/{category}/
				'public'            => true,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'hierarchical'      => true,
				'rewrite'           => array(
					'slug'       => $side['base'] . '/topic',
					'with_front' => false,
				),
			)
		);

		register_post_type(
			$side['post_type'],
			array(
				'labels'        => array(
					'name'               => $side['name'],
					'singular_name'      => $side['singular'],
					'menu_name'          => $side['name'],
					'all_items'          => __( 'All Posts', 'don-phin-esq' ),
					'add_new'            => __( 'Add Post', 'don-phin-esq' ),
					'add_new_item'       => __( 'Add Post', 'don-phin-esq' ),
					'edit_item'          => __( 'Edit Post', 'don-phin-esq' ),
					'view_item'          => __( 'View Post', 'don-phin-esq' ),
					'view_items'         => __( 'View Blog', 'don-phin-esq' ),
					'search_items'       => __( 'Search Posts', 'don-phin-esq' ),
					'not_found'          => __( 'No posts yet.', 'don-phin-esq' ),
					'not_found_in_trash' => __( 'No posts in the Trash.', 'don-phin-esq' ),
				),
				'public'        => true,
				'show_in_rest'  => true,
				'has_archive'   => $side['base'], // The list
				'rewrite'       => array(
					'slug'       => $side['base'],
					'with_front' => false,
				),
				'menu_icon'     => 'dashicons-edit-large',
				'menu_position' => 22,
				'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions' ),
			)
		);
	}
}
// Before the libraries (priority 10), so each side's blog comes first in its admin menu
add_action( 'init', 'donphin_register_blogs', 9 );

/**
 * Refresh WordPress's addresses when the blogs change (a section added, a base moved),
 * so the new addresses work without visiting Settings > Permalinks
 */
function donphin_blogs_flush_rewrites() {
	$signature = md5( wp_json_encode( wp_list_pluck( donphin_blog_sides(), 'base' ) ) );
	if ( get_option( 'donphin_blogs_rewrites' ) !== $signature ) {
		flush_rewrite_rules( false );
		update_option( 'donphin_blogs_rewrites', $signature );
	}
}
add_action( 'init', 'donphin_blogs_flush_rewrites', 99 );

/**
 * Every side's list and categories use archive-blog.php, and its posts single-blog.php
 */
function donphin_blog_archive_template_hierarchy( $templates ) {
	if ( donphin_blog_side_for_request() ) {
		array_unshift( $templates, 'archive-blog.php' );
	}
	return $templates;
}
add_filter( 'archive_template_hierarchy', 'donphin_blog_archive_template_hierarchy' );
add_filter( 'taxonomy_template_hierarchy', 'donphin_blog_archive_template_hierarchy' );

function donphin_blog_single_template_hierarchy( $templates ) {
	if ( is_singular( donphin_blog_post_types() ) ) {
		array_unshift( $templates, 'single-blog.php' );
	}
	return $templates;
}
add_filter( 'single_template_hierarchy', 'donphin_blog_single_template_hierarchy' );

/**
 * Each side's own number of posts on a page of its list
 */
function donphin_blog_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	foreach ( donphin_blog_sides() as $side ) {
		if ( $query->is_post_type_archive( $side['post_type'] ) || $query->is_tax( $side['taxonomy'] ) ) {
			$query->set( 'posts_per_page', $side['per_page'] );
		}
	}
}
add_action( 'pre_get_posts', 'donphin_blog_posts_per_page' );

/**
 * Everything about one post that the list and the post page need
 *
 * @param WP_Post|int $post The post.
 * @return array Empty if there's no such post; otherwise id, title, url, date (as
 *               written), datetime (for <time>), excerpt, image (attachment id or 0),
 *               category (WP_Term or null), minutes (to read), side.
 */
function donphin_blog_post( $post ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return array();
	}

	$side  = donphin_blog_side( $post->post_type );
	$sides = donphin_blog_sides();

	$terms = $side ? get_the_terms( $post, $sides[ $side ]['taxonomy'] ) : false;
	$text  = wp_strip_all_tags( strip_shortcodes( $post->post_content ) );

	return array(
		'id'       => $post->ID,
		'title'    => get_the_title( $post ),
		'url'      => get_permalink( $post ),
		'date'     => get_the_date( '', $post ),
		'datetime' => get_the_date( 'c', $post ),
		'excerpt'  => has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( $text, 28, '…' ),
		'image'    => (int) get_post_thumbnail_id( $post ),
		'category' => ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null,
		'minutes'  => max( 1, (int) round( str_word_count( $text ) / 230 ) ),
		'side'     => $side,
	);
}

/**
 * A side's categories that have posts, in name order, for the buttons over its list
 *
 * @param string $side A key of donphin_blog_sides().
 * @return WP_Term[]
 */
function donphin_blog_categories( $side ) {
	$sides = donphin_blog_sides();
	$terms = get_terms(
		array(
			'taxonomy'   => $sides[ $side ]['taxonomy'],
			'hide_empty' => true,
		)
	);
	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * A post's words, ready for its page, and its headings for "In this post"
 *
 * Each main heading (h2) gets an id to link to. Empty paragraphs (only spaces or
 * &nbsp;, common in posts pasted from the old site) are left out, as is the old site's
 * empty sharing footer; the words themselves are untouched.
 *
 * @param string $html The post's content, after the_content filters.
 * @return array { html: string, toc: array of array( id, text ) }
 */
function donphin_blog_prepare_content( $html ) {
	$html = preg_replace( '#<p>(?:\s|&nbsp;|&\#160;|\xC2\xA0)*</p>#u', '', $html );
	$html = preg_replace( '#<footer class="entry-footer">.*?</footer>#s', '', $html );

	$toc  = array();
	$used = array();
	$html = preg_replace_callback(
		'#<h2(\s[^>]*)?>(.*?)</h2>#is',
		function ( $match ) use ( &$toc, &$used ) {
			$attrs = isset( $match[1] ) ? $match[1] : '';
			$text  = trim( wp_strip_all_tags( $match[2] ) );
			if ( '' === $text ) {
				return $match[0];
			}
			if ( preg_match( '#\sid=["\']([^"\']+)["\']#', $attrs, $id ) ) {
				$id = $id[1];
			} else {
				$base = sanitize_title( $text );
				$id   = $base;
				for ( $n = 2; isset( $used[ $id ] ); $n++ ) {
					$id = $base . '-' . $n;
				}
				$attrs .= ' id="' . esc_attr( $id ) . '"';
			}
			$used[ $id ] = true;
			$toc[]       = array( $id, $text );
			return '<h2' . $attrs . '>' . $match[2] . '</h2>';
		},
		$html
	);

	return array(
		'html' => $html,
		'toc'  => $toc,
	);
}

/* ==========================================================================
   Moving an ordinary WordPress Post into a side's blog (Posts > "Move to …")
   ========================================================================== */

/**
 * A "Move to Speaking Blog" link (and one per side) under each post on the Posts screen
 */
function donphin_blog_move_row_actions( $actions, $post ) {
	if ( 'post' !== $post->post_type || ! current_user_can( 'edit_post', $post->ID ) ) {
		return $actions;
	}
	foreach ( donphin_blog_sides() as $key => $side ) {
		$url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'donphin_blog_move',
					'post'   => $post->ID,
					'side'   => $key,
				),
				admin_url( 'admin-post.php' )
			),
			'donphin_blog_move_' . $post->ID
		);
		/* translators: %s: the blog's name, e.g. Speaking Blog */
		$actions[ 'donphin_move_' . $key ] = '<a href="' . esc_url( $url ) . '">' . esc_html( sprintf( __( 'Move to %s', 'don-phin-esq' ), $side['name'] ) ) . '</a>';
	}
	return $actions;
}
add_filter( 'post_row_actions', 'donphin_blog_move_row_actions', 10, 2 );

/**
 * Move one post into a side's blog. Its words, picture, date and author stay as they
 * are; its WordPress categories are dropped (each side has its own), and its old
 * address is remembered so links to it keep working.
 *
 * @param int    $post_id The post.
 * @param string $side    A key of donphin_blog_sides().
 * @return bool Whether it moved.
 */
function donphin_blog_move_post( $post_id, $side ) {
	$sides = donphin_blog_sides();
	$post  = get_post( $post_id );
	if ( ! $post || 'post' !== $post->post_type || ! isset( $sides[ $side ] ) ) {
		return false;
	}

	if ( 'publish' === $post->post_status ) {
		$old = donphin_site_path( get_permalink( $post ) );
		if ( '' !== $old && ! in_array( $old, get_post_meta( $post_id, '_dp_old_path' ), true ) ) {
			add_post_meta( $post_id, '_dp_old_path', $old );
		}
	}

	wp_delete_object_term_relationships( $post_id, array( 'category', 'post_tag' ) );
	if ( ! set_post_type( $post_id, $sides[ $side ]['post_type'] ) ) {
		return false;
	}
	clean_post_cache( $post_id );
	return true;
}

function donphin_blog_move_handler() {
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- checked below
	$side    = isset( $_GET['side'] ) ? sanitize_key( wp_unslash( $_GET['side'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	check_admin_referer( 'donphin_blog_move_' . $post_id );
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( esc_html__( 'You can’t move this post.', 'don-phin-esq' ) );
	}

	$sides = donphin_blog_sides();
	if ( donphin_blog_move_post( $post_id, $side ) ) {
		wp_safe_redirect( add_query_arg( array( 'post_type' => $sides[ $side ]['post_type'], 'donphin_moved' => $post_id ), admin_url( 'edit.php' ) ) );
	} else {
		wp_safe_redirect( add_query_arg( 'donphin_move_failed', 1, admin_url( 'edit.php' ) ) );
	}
	exit;
}
add_action( 'admin_post_donphin_blog_move', 'donphin_blog_move_handler' );

/**
 * Say what happened, on the screen the move lands on
 */
function donphin_blog_move_notice() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- only reads which notice to show
	if ( isset( $_GET['donphin_moved'] ) ) {
		$post = get_post( absint( $_GET['donphin_moved'] ) );
		if ( $post ) {
			printf(
				'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
				esc_html(
					sprintf(
						/* translators: %s: the post's title */
						__( '“%s” is in this blog now. Its old address leads here, and you can give it one of this blog’s categories.', 'don-phin-esq' ),
						wp_specialchars_decode( get_the_title( $post ), ENT_QUOTES )
					)
				)
			);
		}
	}
	if ( isset( $_GET['donphin_move_failed'] ) ) {
		echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'That post couldn’t be moved.', 'don-phin-esq' ) . '</p></div>';
	}
	// phpcs:enable
}
add_action( 'admin_notices', 'donphin_blog_move_notice' );
