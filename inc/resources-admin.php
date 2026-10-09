<?php
/**
 * Resources in the admin: the "Document or link" box on each resource, the short name,
 * icon and order on each category, the list's File column, and the one-time import of
 * the starter resources.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* --------------------------------------------------------------------------
 * The "Document or link" box
 * ------------------------------------------------------------------------ */

/**
 * Add the box to every resource type
 */
function donphin_resource_add_meta_box() {
	foreach ( donphin_resource_post_types() as $post_type ) {
		add_meta_box(
			'donphin_resource_meta',
			__( 'Document or link', 'don-phin-esq' ),
			'donphin_resource_meta_box',
			$post_type,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'donphin_resource_add_meta_box' );

/**
 * Print the box: the file (chosen from the Media Library), a link, and the small label
 */
function donphin_resource_meta_box( $post ) {
	wp_nonce_field( 'donphin_save_resource', 'donphin_resource_nonce' );
	$file_id = (int) get_post_meta( $post->ID, '_dp_res_file', true );
	$url     = (string) get_post_meta( $post->ID, '_dp_res_url', true );
	$tag     = (string) get_post_meta( $post->ID, '_dp_res_tag', true );
	$name    = $file_id ? basename( (string) get_attached_file( $file_id ) ) : '';
	?>
	<p>
		<strong><?php esc_html_e( 'Document', 'don-phin-esq' ); ?></strong><br>
		<span class="description"><?php esc_html_e( 'A PDF shows a preview on the resource’s page; images and audio show too. Visitors can download it.', 'don-phin-esq' ); ?></span>
	</p>
	<p class="dp-res-file">
		<input type="hidden" name="dp_res_file" value="<?php echo esc_attr( $file_id ? $file_id : '' ); ?>" data-dp-res-file>
		<span data-dp-res-file-name style="display:inline-block;min-width:200px;padding:6px 10px;margin-right:8px;background:#f6f7f7;border:1px solid #dcdcde;border-radius:3px;">
			<?php echo $name ? esc_html( $name ) : esc_html__( 'No file yet', 'don-phin-esq' ); ?>
		</span>
		<button type="button" class="button" data-dp-res-choose><?php esc_html_e( 'Choose or upload a file', 'don-phin-esq' ); ?></button>
		<button type="button" class="button-link button-link-delete" data-dp-res-remove style="margin-left:8px;<?php echo $file_id ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'don-phin-esq' ); ?></button>
	</p>

	<p>
		<label for="dp_res_url"><strong><?php esc_html_e( 'Or a link', 'don-phin-esq' ); ?></strong></label><br>
		<input type="text" id="dp_res_url" name="dp_res_url" value="<?php echo esc_attr( $url ); ?>" class="widefat" placeholder="https://www.youtube.com/watch?v=…">
		<span class="description"><?php esc_html_e( 'For a video (YouTube or Vimeo play on the resource’s page), a web tool, or a page on this site (e.g. /speaking/purchase-the-40-40-solution/). Used when there’s no document.', 'don-phin-esq' ); ?></span>
	</p>

	<p>
		<label for="dp_res_tag"><strong><?php esc_html_e( 'Small label', 'don-phin-esq' ); ?></strong> <span class="description"><?php esc_html_e( '(optional)', 'don-phin-esq' ); ?></span></label><br>
		<input type="text" id="dp_res_tag" name="dp_res_tag" value="<?php echo esc_attr( $tag ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Excerpt · Audio, or a book’s author', 'don-phin-esq' ); ?>">
		<span class="description"><?php esc_html_e( 'Shown under the title in the library and on its page.', 'don-phin-esq' ); ?></span>
	</p>

	<p class="description">
		<?php esc_html_e( 'With neither a document nor a link, the resource’s page offers to request a copy through the contact form, which names this resource for you.', 'don-phin-esq' ); ?>
	</p>
	<?php
}

/**
 * Save the box
 */
function donphin_resource_save_meta( $post_id ) {
	if ( ! isset( $_POST['donphin_resource_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['donphin_resource_nonce'] ) ), 'donphin_save_resource' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$file_id = isset( $_POST['dp_res_file'] ) ? absint( wp_unslash( $_POST['dp_res_file'] ) ) : 0;
	$url     = isset( $_POST['dp_res_url'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['dp_res_url'] ) ) ) : '';
	$tag     = isset( $_POST['dp_res_tag'] ) ? sanitize_text_field( wp_unslash( $_POST['dp_res_tag'] ) ) : '';

	// A path on this site becomes its full address
	if ( '' !== $url && 0 === strpos( $url, '/' ) ) {
		$url = home_url( $url );
	}

	$values = array(
		'_dp_res_file' => ( $file_id && 'attachment' === get_post_type( $file_id ) ) ? $file_id : '',
		'_dp_res_url'  => '' !== $url ? esc_url_raw( $url ) : '',
		'_dp_res_tag'  => $tag,
	);
	foreach ( $values as $key => $value ) {
		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
foreach ( donphin_resource_post_types() as $donphin_res_type ) {
	add_action( 'save_post_' . $donphin_res_type, 'donphin_resource_save_meta' );
}
unset( $donphin_res_type );

/**
 * The Media Library picker for the box
 */
function donphin_resource_admin_assets( $hook ) {
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->post_type, donphin_resource_post_types(), true ) || ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	wp_enqueue_media();
	donphin_enqueue_asset( 'js', 'admin-resource', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'donphin_resource_admin_assets' );

/* --------------------------------------------------------------------------
 * Categories: short name, icon and order
 * ------------------------------------------------------------------------ */

/**
 * The fields, as name => label
 */
function donphin_resource_term_fields( $term = null ) {
	$chip  = $term ? (string) get_term_meta( $term->term_id, 'dp_chip', true ) : '';
	$icon  = $term ? (string) get_term_meta( $term->term_id, 'dp_icon', true ) : '';
	$order = $term ? (string) get_term_meta( $term->term_id, 'dp_order', true ) : '';
	wp_nonce_field( 'donphin_save_resource_term', 'donphin_resource_term_nonce' );

	$rows = array(
		'dp_chip'  => array( __( 'Short name', 'don-phin-esq' ), '<input type="text" name="dp_chip" id="dp_chip" value="' . esc_attr( $chip ) . '">', __( 'On the category buttons above the library, e.g. “Checklists”. The name is used if this is empty.', 'don-phin-esq' ) ),
		'dp_icon'  => array( __( 'Icon', 'don-phin-esq' ), '', __( 'Beside the category’s name in the library.', 'don-phin-esq' ) ),
		'dp_order' => array( __( 'Order', 'don-phin-esq' ), '<input type="number" name="dp_order" id="dp_order" value="' . esc_attr( $order ) . '" style="width:6em">', __( 'Lower numbers come first in the library.', 'don-phin-esq' ) ),
	);
	$select = '<select name="dp_icon" id="dp_icon">';
	foreach ( array_keys( donphin_resource_icons() ) as $name ) {
		$select .= '<option value="' . esc_attr( $name ) . '"' . selected( $icon ? $icon : 'file', $name, false ) . '>' . esc_html( ucwords( str_replace( '-', ' ', $name ) ) ) . '</option>';
	}
	$rows['dp_icon'][1] = $select . '</select>';

	foreach ( $rows as $id => $row ) {
		if ( $term ) {
			printf( '<tr class="form-field"><th scope="row"><label for="%1$s">%2$s</label></th><td>%3$s<p class="description">%4$s</p></td></tr>', esc_attr( $id ), esc_html( $row[0] ), $row[1], esc_html( $row[2] ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- built and escaped above
		} else {
			printf( '<div class="form-field"><label for="%1$s">%2$s</label>%3$s<p>%4$s</p></div>', esc_attr( $id ), esc_html( $row[0] ), $row[1], esc_html( $row[2] ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- built and escaped above
		}
	}
}

/**
 * Save them
 */
function donphin_resource_save_term( $term_id ) {
	if ( ! isset( $_POST['donphin_resource_term_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['donphin_resource_term_nonce'] ) ), 'donphin_save_resource_term' ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_categories' ) ) {
		return;
	}
	$icons = donphin_resource_icons();
	$icon  = isset( $_POST['dp_icon'] ) ? sanitize_key( wp_unslash( $_POST['dp_icon'] ) ) : '';
	update_term_meta( $term_id, 'dp_chip', isset( $_POST['dp_chip'] ) ? sanitize_text_field( wp_unslash( $_POST['dp_chip'] ) ) : '' );
	update_term_meta( $term_id, 'dp_icon', isset( $icons[ $icon ] ) ? $icon : 'file' );
	update_term_meta( $term_id, 'dp_order', isset( $_POST['dp_order'] ) ? (int) wp_unslash( $_POST['dp_order'] ) : 0 );
}

foreach ( donphin_resource_sides() as $donphin_res_side ) {
	add_action( $donphin_res_side['taxonomy'] . '_add_form_fields', 'donphin_resource_term_fields' );
	add_action( $donphin_res_side['taxonomy'] . '_edit_form_fields', 'donphin_resource_term_fields' );
	add_action( 'created_' . $donphin_res_side['taxonomy'], 'donphin_resource_save_term' );
	add_action( 'edited_' . $donphin_res_side['taxonomy'], 'donphin_resource_save_term' );
}
unset( $donphin_res_side );

/* --------------------------------------------------------------------------
 * The list: which resources have their document yet
 * ------------------------------------------------------------------------ */

/**
 * Add the File column, after the title
 */
function donphin_resource_columns( $columns ) {
	$out = array();
	foreach ( $columns as $key => $label ) {
		$out[ $key ] = $label;
		if ( 'title' === $key ) {
			$out['dp_res_file'] = __( 'Document or link', 'don-phin-esq' );
		}
	}
	return $out;
}

/**
 * Fill it: the file's type, the link, or a reminder that there's neither yet
 */
function donphin_resource_column( $column, $post_id ) {
	if ( 'dp_res_file' !== $column ) {
		return;
	}
	$resource = donphin_resource( $post_id );
	if ( $resource['file'] ) {
		echo '<span class="dashicons dashicons-yes" style="color:#00a32a"></span> ' . esc_html( $resource['file']['ext'] . ( $resource['file']['size'] ? ' · ' . $resource['file']['size'] : '' ) );
	} elseif ( $resource['link'] ) {
		echo '<span class="dashicons dashicons-admin-links" style="color:#2271b1"></span> ' . esc_html__( 'Link', 'don-phin-esq' );
	} else {
		echo '<span style="color:#996800">' . esc_html__( 'Not yet: visitors can request it', 'don-phin-esq' ) . '</span>';
	}
}

foreach ( donphin_resource_post_types() as $donphin_res_type ) {
	add_filter( 'manage_' . $donphin_res_type . '_posts_columns', 'donphin_resource_columns' );
	add_action( 'manage_' . $donphin_res_type . '_posts_custom_column', 'donphin_resource_column', 10, 2 );
}
unset( $donphin_res_type );

/* --------------------------------------------------------------------------
 * The one-time import of the starter resources (inc/resources-seed.php)
 * ------------------------------------------------------------------------ */

/**
 * The starter list for a section, or an empty array if it has none
 *
 * @param string $side A key of donphin_resource_sides().
 * @return array
 */
function donphin_resources_seed( $side ) {
	require_once get_stylesheet_directory() . '/inc/resources-seed.php';
	$function = 'donphin_resources_seed_' . $side;
	return function_exists( $function ) ? call_user_func( $function ) : array();
}

/**
 * Offer the import on the resources list, while the library is still empty
 */
function donphin_resources_import_notice() {
	$screen = get_current_screen();
	if ( ! $screen || 'edit' !== $screen->base || ! current_user_can( 'publish_posts' ) ) {
		return;
	}
	$side = donphin_resource_side( $screen->post_type );
	if ( ! $side || ! donphin_resources_seed( $side ) ) {
		return;
	}
	// HR Tools fills from Speaking's library (Tools > Move HR Tools), not from the starter list
	if ( 'foryou' === $side && function_exists( 'donphin_hr_tools_move_pending' ) && donphin_hr_tools_move_pending() ) {
		return;
	}
	$sides = donphin_resource_sides();
	$count = wp_count_posts( $sides[ $side ]['post_type'] );
	if ( array_sum( (array) $count ) > 0 ) {
		return;
	}
	$total = array_sum( array_map( function ( $c ) { return count( $c['items'] ); }, donphin_resources_seed( $side ) ) );
	?>
	<div class="notice notice-info">
		<p><strong><?php esc_html_e( 'The library is empty.', 'don-phin-esq' ); ?></strong> <?php echo esc_html( sprintf( __( 'Import the %d starter resources and their categories? Each one can then be edited, given its document, or deleted.', 'don-phin-esq' ), $total ) ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="donphin_import_resources">
			<input type="hidden" name="side" value="<?php echo esc_attr( $side ); ?>">
			<?php wp_nonce_field( 'donphin_import_resources' ); ?>
			<p><button type="submit" class="button button-primary"><?php esc_html_e( 'Import the starter resources', 'don-phin-esq' ); ?></button></p>
		</form>
	</div>
	<?php
}
add_action( 'admin_notices', 'donphin_resources_import_notice' );

/**
 * The import, from the button: checks who's asking, imports, and returns to the list
 */
function donphin_resources_import() {
	check_admin_referer( 'donphin_import_resources' );
	if ( ! current_user_can( 'publish_posts' ) ) {
		wp_die( esc_html__( 'You can’t import resources.', 'don-phin-esq' ) );
	}

	$side  = isset( $_POST['side'] ) ? sanitize_key( wp_unslash( $_POST['side'] ) ) : '';
	$sides = donphin_resource_sides();
	if ( ! isset( $sides[ $side ] ) ) {
		wp_die( esc_html__( 'No such library.', 'don-phin-esq' ) );
	}

	donphin_resources_import_side( $side );
	wp_safe_redirect( admin_url( 'edit.php?post_type=' . $sides[ $side ]['post_type'] ) );
	exit;
}

/**
 * Import a section's starter resources: each category (with its short name, icon and
 * order), then each resource in it, in order, published. Only into an empty library,
 * so running it twice can't double everything.
 *
 * @param string $side A key of donphin_resource_sides().
 * @return int How many resources were added.
 */
function donphin_resources_import_side( $side ) {
	$sides    = donphin_resource_sides();
	$type     = $sides[ $side ]['post_type'];
	$taxonomy = $sides[ $side ]['taxonomy'];
	if ( array_sum( (array) wp_count_posts( $type ) ) > 0 ) {
		return 0;
	}

	$added = 0;
	$order = 0;
	foreach ( donphin_resources_seed( $side ) as $category ) {
		$order += 10;
		$term   = term_exists( $category['title'], $taxonomy );
		if ( ! $term ) {
			$term = wp_insert_term( $category['title'], $taxonomy, array( 'description' => $category['line'] ) );
		}
		if ( is_wp_error( $term ) ) {
			continue;
		}
		$term_id = (int) $term['term_id'];
		update_term_meta( $term_id, 'dp_chip', $category['chip'] );
		update_term_meta( $term_id, 'dp_icon', $category['icon'] );
		update_term_meta( $term_id, 'dp_order', $order );

		foreach ( $category['items'] as $position => $item ) {
			$item    = is_array( $item ) ? $item : array( 'name' => $item );
			$post_id = wp_insert_post(
				array(
					'post_type'   => $type,
					'post_status' => 'publish',
					'post_title'  => $item['name'],
					'menu_order'  => $position,
				)
			);
			if ( ! $post_id || is_wp_error( $post_id ) ) {
				continue;
			}
			$added++;
			wp_set_object_terms( $post_id, $term_id, $taxonomy );
			if ( ! empty( $item['tag'] ) ) {
				update_post_meta( $post_id, '_dp_res_tag', $item['tag'] );
			}
			if ( ! empty( $item['url'] ) ) {
				update_post_meta( $post_id, '_dp_res_url', 0 === strpos( $item['url'], '/' ) ? home_url( $item['url'] ) : $item['url'] );
			}
		}
	}

	return $added;
}
add_action( 'admin_post_donphin_import_resources', 'donphin_resources_import' );

/* --------------------------------------------------------------------------
 * The "Resource library" box on each side's Resources page: its heading and intro
 * ------------------------------------------------------------------------ */

/**
 * The Resources page templates, by section
 *
 * @return array
 */
function donphin_resource_page_templates() {
	return array(
		'page-speaking-resources.php' => 'speaking',
		'page-counsel-resources.php'  => 'counsel',
		'page-hr-tools.php'           => 'foryou',
	);
}

/**
 * Add the box to pages using one of those templates
 */
function donphin_resource_page_add_meta_box( $post_type, $post ) {
	$templates = donphin_resource_page_templates();
	if ( 'page' !== $post_type || ! isset( $templates[ get_page_template_slug( $post ) ] ) ) {
		return;
	}
	add_meta_box( 'donphin_resource_page', __( 'Resource library', 'don-phin-esq' ), 'donphin_resource_page_meta_box', 'page', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'donphin_resource_page_add_meta_box', 10, 2 );

/**
 * Print it: the heading and intro, each showing the section's own as its placeholder
 */
function donphin_resource_page_meta_box( $post ) {
	$templates = donphin_resource_page_templates();
	$sides     = donphin_resource_sides();
	$defaults  = $sides[ $templates[ get_page_template_slug( $post ) ] ]['library'];
	wp_nonce_field( 'donphin_save_resource_page', 'donphin_resource_page_nonce' );
	?>
	<p>
		<label for="dp_library_heading"><strong><?php esc_html_e( 'Heading', 'don-phin-esq' ); ?></strong></label><br>
		<input type="text" id="dp_library_heading" name="dp_library_heading" class="widefat" value="<?php echo esc_attr( get_post_meta( $post->ID, '_dp_library_heading', true ) ); ?>" placeholder="<?php echo esc_attr( $defaults['heading'] ); ?>">
	</p>
	<p>
		<label for="dp_library_intro"><strong><?php esc_html_e( 'Intro', 'don-phin-esq' ); ?></strong></label><br>
		<textarea id="dp_library_intro" name="dp_library_intro" class="widefat" rows="3" placeholder="<?php echo esc_attr( $defaults['intro'] ); ?>"><?php echo esc_textarea( get_post_meta( $post->ID, '_dp_library_intro', true ) ); ?></textarea>
	</p>
	<p class="description"><?php esc_html_e( 'Left empty, each shows what’s in grey. The library itself is managed under its Resources menu.', 'don-phin-esq' ); ?></p>
	<?php
}

/**
 * Save it
 */
function donphin_resource_page_save( $post_id ) {
	if ( ! isset( $_POST['donphin_resource_page_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['donphin_resource_page_nonce'] ) ), 'donphin_save_resource_page' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$values = array(
		'_dp_library_heading' => isset( $_POST['dp_library_heading'] ) ? sanitize_text_field( wp_unslash( $_POST['dp_library_heading'] ) ) : '',
		'_dp_library_intro'   => isset( $_POST['dp_library_intro'] ) ? sanitize_textarea_field( wp_unslash( $_POST['dp_library_intro'] ) ) : '',
	);
	foreach ( $values as $key => $value ) {
		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_page', 'donphin_resource_page_save' );
