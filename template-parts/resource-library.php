<?php
/**
 * A section's resource library: search, a button per category, and each category's
 * list, every number counted from what's there. Used by each side's Resources page;
 * its colours and shapes follow the side (assets/css/resource-library.css), and
 * assets/js/resource-library.js does the searching and filtering.
 *
 * Arguments (get_template_part( 'template-parts/resource-library', null, $args )):
 * side     A key of donphin_resource_sides(): whose library to show.
 * heading  The heading above it ('' for none, when the page's hero already says it).
 * label    The small line above the heading.
 * intro    A sentence or two under the heading.
 *
 * Shows nothing while the library is empty.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'side'    => 'speaking',
		'heading' => '',
		'label'   => '',
		'intro'   => '',
	)
);

$library = donphin_resource_library( $args['side'] );
if ( ! $library ) {
	return;
}

$sides         = donphin_resource_sides();
$contact_url   = home_url( $sides[ $args['side'] ]['contact'] );
$library_total = array_sum(
	array_map(
		function ( $category ) {
			return count( $category['items'] );
		},
		$library
	)
);
?>

<section class="dp-lib-section" id="dp-res-library"<?php echo $args['heading'] ? ' aria-labelledby="dp-res-library-title"' : ' aria-label="Resources"'; ?>>
	<div class="dp-lib-container">

		<?php if ( $args['heading'] ) : ?>
			<header class="dp-lib-head">
				<?php if ( $args['label'] ) : ?>
					<p class="dp-lib-label"><?php echo esc_html( $args['label'] ); ?></p>
				<?php endif; ?>
				<h2 id="dp-res-library-title" class="dp-lib-heading"><?php echo esc_html( $args['heading'] ); ?></h2>
				<?php if ( $args['intro'] ) : ?>
					<p class="dp-lib-intro"><?php echo esc_html( $args['intro'] ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<div class="dp-lib" data-dp-lib>

			<!-- Search and the category buttons; shown by resource-library.js, since they need it -->
			<div class="dp-lib-controls" data-dp-lib-controls hidden>
				<label class="dp-lib-search">
					<span class="screen-reader-text">Search the library</span>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
					<input type="search" placeholder="<?php echo esc_attr( sprintf( 'Search %d resources…', $library_total ) ); ?>" autocomplete="off" data-dp-lib-search>
				</label>

				<div class="dp-lib-chips" role="group" aria-label="Show one category">
					<button type="button" class="dp-lib-chip" data-cat="all" aria-pressed="true">
						All <span class="dp-lib-chip-count"><?php echo esc_html( $library_total ); ?></span>
					</button>
					<?php foreach ( $library as $category ) : ?>
						<button type="button" class="dp-lib-chip" data-cat="<?php echo esc_attr( $category['key'] ); ?>" aria-pressed="false">
							<?php echo esc_html( $category['chip'] ); ?> <span class="dp-lib-chip-count"><?php echo esc_html( count( $category['items'] ) ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</div>

			<p class="dp-lib-status screen-reader-text" aria-live="polite" data-dp-lib-status></p>

			<div class="dp-lib-groups">
				<?php foreach ( $library as $category ) : ?>
					<?php $key = $category['key']; ?>
					<section class="dp-lib-group" id="dp-lib-<?php echo esc_attr( $key ); ?>" data-cat="<?php echo esc_attr( $key ); ?>" aria-labelledby="dp-lib-<?php echo esc_attr( $key ); ?>-title">
						<header class="dp-lib-group-head">
							<span class="dp-lib-group-icon" aria-hidden="true">
								<?php echo donphin_resource_icon( $category['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
							</span>
							<div class="dp-lib-group-words">
								<h3 id="dp-lib-<?php echo esc_attr( $key ); ?>-title" class="dp-lib-group-title"><?php echo esc_html( $category['title'] ); ?></h3>
								<?php if ( $category['line'] ) : ?>
									<p class="dp-lib-group-line"><?php echo esc_html( $category['line'] ); ?></p>
								<?php endif; ?>
							</div>
							<span class="dp-lib-group-count" data-dp-lib-count><?php echo esc_html( count( $category['items'] ) ); ?></span>
						</header>

						<ul class="dp-lib-list">
							<?php foreach ( $category['items'] as $resource ) : ?>
								<li class="dp-lib-item" data-search="<?php echo esc_attr( strtolower( $resource['name'] . ' ' . $resource['tag'] ) ); ?>">
									<a class="dp-lib-link" href="<?php echo esc_url( $resource['url'] ); ?>">
										<span class="dp-lib-name">
											<?php echo esc_html( $resource['name'] ); ?>
											<?php if ( $resource['tag'] ) : ?>
												<span class="dp-lib-tag"><?php echo esc_html( $resource['tag'] ); ?></span>
											<?php endif; ?>
										</span>
										<svg class="dp-lib-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><polyline points="9 6 15 12 9 18"/></svg>
									</a>
									<?php if ( $resource['file'] ) : ?>
										<a class="dp-lib-get" href="<?php echo esc_url( $resource['file']['url'] ); ?>" download aria-label="<?php echo esc_attr( sprintf( 'Download %s (%s)', $resource['name'], $resource['file']['ext'] ) ); ?>">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 3v12"/><polyline points="7 10 12 15 17 10"/><path d="M5 21h14"/></svg>
											<?php echo esc_html( $resource['file']['ext'] ); ?>
										</a>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>

						<button type="button" class="dp-lib-more" aria-expanded="false" data-dp-lib-more hidden>
							<?php echo esc_html( sprintf( 'Show all %d', count( $category['items'] ) ) ); ?>
						</button>
					</section>
				<?php endforeach; ?>
			</div>

			<p class="dp-lib-empty" data-dp-lib-empty hidden>
				Nothing in the library matches that yet.
				<a href="<?php echo esc_url( $contact_url ); ?>">Ask Don</a> — he may have just the thing.
			</p>

		</div>

	</div>
</section>
