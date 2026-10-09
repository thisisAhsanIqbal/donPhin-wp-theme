<?php
/**
 * Resources: each section's library of checklists, forms, books and videos, managed in
 * the admin (Speaking Resources), each with a page of its own showing a preview of the
 * document and a download.
 *
 * Every section keeps its own resources, in its own admin menu, with its own categories
 * and its own addresses (/speaking/resources/{resource}/). Sections that have a library
 * are listed in donphin_resource_sides(); adding one there is all a new library needs.
 *
 * A resource: its title, a short summary (the excerpt), a description (the editor), its
 * category, and either a file from the Media Library (a PDF, an image, audio) or a link
 * (a video, a web tool, a page). With neither, its page asks for a copy instead.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The sections that have a library, by section key (see donphin_sections())
 *
 * post_type  The post type's name (20 characters at most).
 * taxonomy   Its categories.
 * base       Where its resources live: {base}/{resource}/. The section's Resources
 *            page sits at the base itself.
 * name       The admin menu's name; singular for one.
 * icon       The admin menu's dashicon.
 * contact    Where requests for a copy go.
 * cta        The invitation beside each resource: title, text, and the button's label
 *            (the button leads to contact, or to its own 'url' if it has one).
 * library    The library's heading and intro on the section's Resources page, until
 *            they're changed in the page's "Resource library" box.
 * crumb      Optional: the way back from a resource to its library ("Resources").
 * menu       Optional: the library's items in the admin menu (inc/admin-menu.php): the
 *            list, "Add" and categories ("Resources", "Add resource", "Resource categories").
 *
 * Speaking and Private Counsel each have their own; HR Tools belongs to neither side: it
 * is the For You section's, common to everyone, with its own page at /hr-tools/
 * (page-hr-tools.php).
 *
 * @return array
 */
function donphin_resource_sides() {
	return array(
		'speaking' => array(
			'post_type' => 'dp_speaking_resource',
			'taxonomy'  => 'dp_speaking_res_cat',
			'base'      => 'speaking/resources',
			'name'      => 'Speaking Resources',
			'singular'  => 'Speaking Resource',
			'icon'      => 'dashicons-portfolio',
			'contact'   => '/speaking/contact/',
			'cta'       => array(
				'title' => 'Want this to land with your whole team?',
				'text'  => 'Don brings these ideas to life on stage, for sales meetings, leadership retreats and conferences.',
				'label' => 'Book Don',
			),
			// Speaking's own library, empty since HR Tools became a library of its own
			// (below): it shows on the Resources page once something is added to it
			'library'   => array(
				'heading' => 'More from Don',
				'intro'   => '',
			),
		),
		'counsel'  => array(
			'post_type' => 'dp_counsel_resource',
			'taxonomy'  => 'dp_counsel_res_cat',
			'base'      => 'private-counsel/resources',
			'name'      => 'Counsel Resources',
			'singular'  => 'Counsel Resource',
			'icon'      => 'dashicons-portfolio',
			'contact'   => '/private-counsel/contact/',
			'cta'       => array(
				'title' => 'When you’re ready for what comes next',
				'text'  => 'Private counsel is by introduction, for one man at a time.',
				'label' => 'Request an introduction',
			),
			'library'   => array(
				'heading' => 'Resources', // A placeholder until Don names it
				'intro'   => '',
			),
		),
		// HR Tools: common to everyone, part of neither side
		'foryou'   => array(
			'post_type' => 'dp_hr_tool',
			'taxonomy'  => 'dp_hr_tool_cat',
			'base'      => 'hr-tools',
			'name'      => 'HR Tools',
			'singular'  => 'HR Tool',
			'icon'      => 'dashicons-portfolio',
			// Requests for a copy reach Don's office through its main form (Speaking's)
			'contact'   => '/speaking/contact/',
			'crumb'     => 'HR Tools',
			'menu'      => array( 'All HR tools', 'Add HR tool', 'Tool categories' ),
			'cta'       => array(
				'title' => 'Want help putting these to work?',
				'text'  => 'Don speaks to teams about the people side of business, and works one to one with leaders.',
				'label' => 'See how Don can help',
				'url'   => '/', // The gateway: the reader chooses the side
			),
			'library'   => array(
				'heading' => 'HR Tools',
				'intro'   => 'I have created a great deal of content related to the workplace. Some of it may benefit you!',
			),
		),
	);
}

/**
 * Every resource post type
 *
 * @return array
 */
function donphin_resource_post_types() {
	return wp_list_pluck( donphin_resource_sides(), 'post_type' );
}

/**
 * Which section a resource post type belongs to
 *
 * @param string $post_type A post type.
 * @return string A section key, or '' if it isn't a resource type.
 */
function donphin_resource_side( $post_type ) {
	foreach ( donphin_resource_sides() as $key => $side ) {
		if ( $side['post_type'] === $post_type ) {
			return $key;
		}
	}
	return '';
}

/**
 * Register each section's resources and their categories
 */
function donphin_register_resources() {
	foreach ( donphin_resource_sides() as $side ) {
		register_post_type(
			$side['post_type'],
			array(
				'labels'        => array(
					'name'               => $side['name'],
					'singular_name'      => $side['singular'],
					'menu_name'          => $side['name'],
					'all_items'          => __( 'All Resources', 'don-phin-esq' ),
					'add_new'            => __( 'Add Resource', 'don-phin-esq' ),
					'add_new_item'       => __( 'Add Resource', 'don-phin-esq' ),
					'edit_item'          => __( 'Edit Resource', 'don-phin-esq' ),
					'view_item'          => __( 'View Resource', 'don-phin-esq' ),
					'search_items'       => __( 'Search Resources', 'don-phin-esq' ),
					'not_found'          => __( 'No resources yet.', 'don-phin-esq' ),
					'not_found_in_trash' => __( 'No resources in the Trash.', 'don-phin-esq' ),
				),
				'public'        => true,
				'show_in_rest'  => true,
				'has_archive'   => false, // The section's Resources page is the list
				'rewrite'       => array(
					'slug'       => $side['base'],
					'with_front' => false,
				),
				'menu_icon'     => $side['icon'],
				'menu_position' => 21,
				'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			)
		);

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
				// Categories are shown on the Resources page, not as pages of their own
				'public'            => false,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'hierarchical'      => true,
				'rewrite'           => false,
			)
		);
	}
}
add_action( 'init', 'donphin_register_resources' );

/**
 * Refresh WordPress's addresses when the libraries change (a section added, a base
 * moved), so the new addresses work without visiting Settings > Permalinks
 */
function donphin_resources_flush_rewrites() {
	$signature = md5( wp_json_encode( donphin_resource_sides() ) );
	if ( get_option( 'donphin_resources_rewrites' ) !== $signature ) {
		flush_rewrite_rules( false );
		update_option( 'donphin_resources_rewrites', $signature );
	}
}
add_action( 'init', 'donphin_resources_flush_rewrites', 99 );

/**
 * Resource pages use single-resource.php, whichever section they belong to
 */
function donphin_resource_template_hierarchy( $templates ) {
	if ( is_singular( donphin_resource_post_types() ) ) {
		array_unshift( $templates, 'single-resource.php' );
	}
	return $templates;
}
add_filter( 'single_template_hierarchy', 'donphin_resource_template_hierarchy' );

/**
 * The category icons to choose from (24x24 SVG insides), by name
 *
 * @return array
 */
function donphin_resource_icons() {
	return array(
		'book'      => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>',
		'open-book' => '<path d="M2 4h6a4 4 0 0 1 4 4v13a3 3 0 0 0-3-3H2z"/><path d="M22 4h-6a4 4 0 0 0-4 4v13a3 3 0 0 1 3-3h7z"/>',
		'form'      => '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/>',
		'checklist' => '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/>',
		'idea'      => '<path d="M12 2a7 7 0 0 0-4 12.7V17h8v-2.3A7 7 0 0 0 12 2z"/><line x1="9" y1="21" x2="15" y2="21"/>',
		'chat'      => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
		'image'     => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21"/>',
		'play'      => '<circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/>',
		'file'      => '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/>',
	);
}

/**
 * A category icon as a whole SVG
 *
 * @param string $name A key of donphin_resource_icons().
 * @return string
 */
function donphin_resource_icon( $name ) {
	$icons = donphin_resource_icons();
	$insides = isset( $icons[ $name ] ) ? $icons[ $name ] : $icons['file'];
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $insides . '</svg>';
}

/**
 * A category's settings: its short name (on the filter buttons), icon and order
 *
 * @param WP_Term $term The category.
 * @return array
 */
function donphin_resource_category( $term ) {
	$chip = (string) get_term_meta( $term->term_id, 'dp_chip', true );
	$icon = (string) get_term_meta( $term->term_id, 'dp_icon', true );
	return array(
		'term'  => $term,
		'title' => $term->name,
		'chip'  => '' !== $chip ? $chip : $term->name,
		'line'  => $term->description,
		'icon'  => '' !== $icon ? $icon : 'file',
		'order' => (int) get_term_meta( $term->term_id, 'dp_order', true ),
	);
}

/**
 * Everything about one resource that the pages need
 *
 * @param WP_Post|int $post The resource.
 * @return array Empty if there's no such resource; otherwise name, tag, summary,
 *               url (its page), file (url, mime, ext, size, id),
 *               link (a video, tool or page), kind ('pdf', 'image', 'audio', 'video',
 *               'link', 'file' or 'none'), request (the contact form, asking for it).
 */
function donphin_resource( $post ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return array();
	}

	$side    = donphin_resource_side( $post->post_type );
	$sides   = donphin_resource_sides();
	$file_id = (int) get_post_meta( $post->ID, '_dp_res_file', true );
	$tag     = (string) get_post_meta( $post->ID, '_dp_res_tag', true );
	$link    = (string) get_post_meta( $post->ID, '_dp_res_url', true );

	$file = null;
	if ( $file_id && get_post( $file_id ) ) {
		$path = get_attached_file( $file_id );
		$mime = (string) get_post_mime_type( $file_id );
		$file = array(
			'id'   => $file_id,
			'url'  => wp_get_attachment_url( $file_id ),
			'mime' => $mime,
			'ext'  => strtoupper( (string) pathinfo( (string) $path, PATHINFO_EXTENSION ) ),
			'size' => ( $path && file_exists( $path ) ) ? size_format( filesize( $path ), 0 ) : '',
		);
	}

	if ( $file ) {
		if ( 'application/pdf' === $file['mime'] ) {
			$kind = 'pdf';
		} elseif ( 0 === strpos( $file['mime'], 'image/' ) ) {
			$kind = 'image';
		} elseif ( 0 === strpos( $file['mime'], 'audio/' ) ) {
			$kind = 'audio';
		} elseif ( 0 === strpos( $file['mime'], 'video/' ) ) {
			$kind = 'video';
		} else {
			$kind = 'file';
		}
	} else {
		$kind = '' !== $link ? 'link' : 'none';
	}

	$label   = get_the_title( $post ) . ( '' !== $tag ? ' (' . $tag . ')' : '' );
	$contact = home_url( isset( $sides[ $side ]['contact'] ) ? $sides[ $side ]['contact'] : '/' );

	return array(
		'id'      => $post->ID,
		'name'    => get_the_title( $post ),
		'tag'     => $tag,
		'summary' => has_excerpt( $post ) ? get_the_excerpt( $post ) : '',
		'url'     => get_permalink( $post ),
		'file'    => $file,
		'link'    => $link,
		'kind'    => $kind,
		'side'    => $side,
		'request' => add_query_arg( 'resource', rawurlencode( wp_specialchars_decode( $label, ENT_QUOTES ) ), $contact ),
	);
}

/**
 * A section's library: its categories in order, each with its published resources
 *
 * @param string $side A key of donphin_resource_sides().
 * @return array Categories (as donphin_resource_category()), each with 'items'
 *               (as donphin_resource()). Empty categories are left out.
 */
function donphin_resource_library( $side ) {
	$sides = donphin_resource_sides();
	if ( ! isset( $sides[ $side ] ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => $sides[ $side ]['taxonomy'],
			'hide_empty' => true,
		)
	);
	if ( is_wp_error( $terms ) ) {
		return array();
	}

	$library = array_map( 'donphin_resource_category', $terms );
	usort(
		$library,
		function ( $a, $b ) {
			return $a['order'] === $b['order'] ? strcasecmp( $a['title'], $b['title'] ) : $a['order'] - $b['order'];
		}
	);

	foreach ( $library as $i => $category ) {
		$posts = get_posts(
			array(
				'post_type'      => $sides[ $side ]['post_type'],
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- one query per category, on a small library
					array(
						'taxonomy'         => $sides[ $side ]['taxonomy'],
						'terms'            => $category['term']->term_id,
						'include_children' => false,
					),
				),
			)
		);
		$library[ $i ]['key']   = $category['term']->slug;
		$library[ $i ]['items'] = array_map( 'donphin_resource', $posts );
		if ( ! $library[ $i ]['items'] ) {
			unset( $library[ $i ] );
		}
	}

	return array_values( $library );
}

/**
 * The two interactive web tools, shown as cards on the Speaking Resources page
 *
 * Each: name, line, icon (24x24 SVG insides), url ('' until the tool is live).
 *
 * @return array
 */
function donphin_resource_tools() {
	return array(
		array(
			'name' => 'Employee Turnover Cost Calculator',
			'line' => 'Put a number on what it costs every time someone walks out the door.',
			'icon' => '<rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="11" x2="8" y2="11.01"/><line x1="12" y1="11" x2="12" y2="11.01"/><line x1="16" y1="11" x2="16" y2="11.01"/><line x1="8" y1="15" x2="8" y2="15.01"/><line x1="12" y1="15" x2="12" y2="15.01"/><line x1="16" y1="15" x2="16" y2="18"/><line x1="8" y1="18" x2="12" y2="18"/>',
			'url'  => '',
		),
		array(
			'name' => 'Engagement & Retention Program Planner',
			'line' => 'Build the program that keeps your best people, one step at a time.',
			'icon' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="m9 16 2 2 4-4"/>',
			'url'  => '',
		),
	);
}

/**
 * The heading or intro of a Resources page's library: as set in the page's "Resource
 * library" box (inc/resources-admin.php), or the section's own
 *
 * @param int    $page_id The Resources page.
 * @param string $field   'heading' or 'intro'.
 * @param string $side    A key of donphin_resource_sides().
 * @return string
 */
function donphin_resource_page_text( $page_id, $field, $side ) {
	$sides = donphin_resource_sides();
	$value = (string) get_post_meta( $page_id, '_dp_library_' . $field, true );
	return '' !== $value ? $value : $sides[ $side ]['library'][ $field ];
}
