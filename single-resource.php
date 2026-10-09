<?php
/**
 * A resource's own page (e.g. /speaking/resources/hiring-checklist/), for any section's
 * library (inc/resources.php picks this template for every resource type).
 *
 * The title, its label and summary, and the download (or the link, or a request for a
 * copy) on the hero; then the preview beside what it's about; then more from the same
 * category. The preview follows what the resource is:
 * - a PDF shows in the browser's own viewer on larger screens, and on phones (whose
 *   browsers don't show PDFs in a page) as its first page, with a button to open it all
 * - an image shows itself, audio and video play in place, and a YouTube or Vimeo link
 *   plays in place too
 * - anything else, or nothing yet, is a drawn page with its title
 * Its colours come from the section (resource.css).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$resource = donphin_resource( get_post() );
	$file     = $resource['file'];
	$sides    = donphin_resource_sides();
	$side     = $sides[ $resource['side'] ];
	$library  = home_url( '/' . $side['base'] . '/' );

	// Its category (the first, if it has several)
	$terms    = get_the_terms( get_the_ID(), $side['taxonomy'] );
	$category = ( $terms && ! is_wp_error( $terms ) ) ? donphin_resource_category( $terms[0] ) : null;

	// A video link that plays in place
	$embed = 'link' === $resource['kind'] ? wp_oembed_get( $resource['link'], array( 'width' => 960 ) ) : false;

	// A PDF's first page, as WordPress made it on upload (if the server can)
	$first_page = 'pdf' === $resource['kind'] ? wp_get_attachment_image( $file['id'], 'large', false, array( 'class' => 'dp-rd-page-image', 'alt' => '' ) ) : '';

	// What it is, in a word, for the facts and the drawn page
	$formats = array(
		'pdf'   => 'PDF',
		'image' => 'Image',
		'audio' => 'Audio',
		'video' => 'Video',
		'file'  => $file ? $file['ext'] : '',
		'link'  => $embed ? 'Video' : 'Link',
		'none'  => 'On request',
	);
	$format = $formats[ $resource['kind'] ];

	// The main button
	$is_external = 'link' === $resource['kind'] && ! wp_validate_redirect( $resource['link'], false );
	if ( $file ) {
		$button = array( 'Download ' . ( 'audio' === $resource['kind'] ? 'the audio' : $file['ext'] ), $file['url'], true );
	} elseif ( 'link' === $resource['kind'] ) {
		$button = array( $embed ? 'Open the video' : 'Open', $resource['link'], false );
	} else {
		$button = array( 'Request a copy', $resource['request'], false );
	}

	// More from the same category
	$related = array();
	if ( $category ) {
		$related = array_map(
			'donphin_resource',
			get_posts(
				array(
					'post_type'      => get_post_type(),
					'posts_per_page' => 3,
					'post__not_in'   => array( get_the_ID() ),
					'orderby'        => array(
						'menu_order' => 'ASC',
						'title'      => 'ASC',
					),
					'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- one small query
						array(
							'taxonomy' => $side['taxonomy'],
							'terms'    => $category['term']->term_id,
						),
					),
				)
			)
		);
	}
	?>

<article class="dp-rd">

	<header class="dp-rd-hero">
		<div class="dp-rd-hero-container">
			<nav class="dp-rd-crumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( $library . '#dp-res-library' ); ?>"><?php echo esc_html( isset( $side['crumb'] ) ? $side['crumb'] : 'Resources' ); ?></a>
				<?php if ( $category ) : ?>
					<span aria-hidden="true">/</span>
					<a href="<?php echo esc_url( $library . '#dp-lib-' . $category['term']->slug ); ?>"><?php echo esc_html( $category['title'] ); ?></a>
				<?php endif; ?>
			</nav>

			<h1 class="dp-rd-title"><?php the_title(); ?></h1>

			<?php if ( $resource['tag'] ) : ?>
				<p class="dp-rd-tag"><?php echo esc_html( $resource['tag'] ); ?></p>
			<?php endif; ?>

			<?php if ( $resource['summary'] ) : ?>
				<p class="dp-rd-summary"><?php echo esc_html( $resource['summary'] ); ?></p>
			<?php endif; ?>

			<div class="dp-rd-actions">
				<a class="dp-rd-button" href="<?php echo esc_url( $button[1] ); ?>"<?php echo $button[2] ? ' download' : ''; ?><?php echo $is_external ? ' target="_blank" rel="noopener"' : ''; ?>>
					<?php if ( $file ) : ?>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M12 3v12"/><polyline points="7 10 12 15 17 10"/><path d="M5 21h14"/></svg>
					<?php endif; ?>
					<?php echo esc_html( $button[0] ); ?>
					<?php if ( ! $file ) : ?>
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
					<?php endif; ?>
				</a>
				<?php if ( $file && $file['size'] ) : ?>
					<span class="dp-rd-size"><?php echo esc_html( $file['ext'] . ' · ' . $file['size'] ); ?></span>
				<?php elseif ( 'none' === $resource['kind'] ) : ?>
					<span class="dp-rd-size">Not online yet. Ask, and Don’s office will send it.</span>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<div class="dp-rd-body">
		<div class="dp-rd-body-container">

			<div class="dp-rd-preview dp-rd-preview--<?php echo esc_attr( $embed ? 'embed' : $resource['kind'] ); ?>">
				<?php if ( 'pdf' === $resource['kind'] ) : ?>
					<object class="dp-rd-pdf" data="<?php echo esc_url( $file['url'] . '#view=FitH' ); ?>" type="application/pdf" aria-label="<?php echo esc_attr( 'Preview of ' . $resource['name'] ); ?>"></object>
					<!-- Phones: the first page, and the whole PDF a tap away -->
					<div class="dp-rd-pdf-small">
						<?php if ( $first_page ) : ?>
							<?php echo $first_page; // phpcs:ignore WordPress.Security.EscapeOutput -- from wp_get_attachment_image() ?>
						<?php else : ?>
							<div class="dp-rd-paper" aria-hidden="true">
								<span class="dp-rd-paper-kind"><?php echo esc_html( $format ); ?></span>
								<span class="dp-rd-paper-title"><?php the_title(); ?></span>
								<span class="dp-rd-paper-lines"></span>
								<span class="dp-rd-paper-by">Don Phin, Esq.</span>
							</div>
						<?php endif; ?>
						<a class="dp-rd-open" href="<?php echo esc_url( $file['url'] ); ?>" target="_blank" rel="noopener">Open the full PDF</a>
					</div>

				<?php elseif ( 'image' === $resource['kind'] ) : ?>
					<?php echo wp_get_attachment_image( $file['id'], 'large', false, array( 'class' => 'dp-rd-image' ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- from wp_get_attachment_image() ?>

				<?php elseif ( 'video' === $resource['kind'] ) : ?>
					<video class="dp-rd-video" src="<?php echo esc_url( $file['url'] ); ?>" controls preload="metadata"></video>

				<?php elseif ( $embed ) : ?>
					<div class="dp-rd-embed"><?php echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput -- from wp_oembed_get() ?></div>

				<?php else : ?>
					<!-- A drawn page: for audio (with its player), other files, links, and resources not online yet -->
					<div class="dp-rd-paper" aria-hidden="true">
						<span class="dp-rd-paper-kind"><?php echo esc_html( $format ); ?></span>
						<span class="dp-rd-paper-title"><?php the_title(); ?></span>
						<span class="dp-rd-paper-lines"></span>
						<span class="dp-rd-paper-by">Don Phin, Esq.</span>
					</div>
					<?php if ( 'audio' === $resource['kind'] ) : ?>
						<audio class="dp-rd-audio" src="<?php echo esc_url( $file['url'] ); ?>" controls preload="metadata"></audio>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<aside class="dp-rd-side">
				<?php if ( '' !== trim( get_the_content() ) ) : ?>
					<div class="dp-rd-about">
						<h2 class="dp-rd-side-title">About this resource</h2>
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

				<dl class="dp-rd-facts">
					<?php if ( $category ) : ?>
						<div><dt>Category</dt><dd><?php echo esc_html( $category['title'] ); ?></dd></div>
					<?php endif; ?>
					<div><dt>Format</dt><dd><?php echo esc_html( $format ); ?></dd></div>
					<?php if ( $file && $file['size'] ) : ?>
						<div><dt>Size</dt><dd><?php echo esc_html( $file['size'] ); ?></dd></div>
					<?php endif; ?>
					<div><dt>By</dt><dd>Don Phin, Esq.</dd></div>
				</dl>

				<div class="dp-rd-cta">
					<p class="dp-rd-cta-title"><?php echo esc_html( $side['cta']['title'] ); ?></p>
					<p class="dp-rd-cta-text"><?php echo esc_html( $side['cta']['text'] ); ?></p>
					<a class="dp-arrow-link" href="<?php echo esc_url( home_url( isset( $side['cta']['url'] ) ? $side['cta']['url'] : $side['contact'] ) ); ?>">
						<?php echo esc_html( $side['cta']['label'] ); ?>
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
					</a>
				</div>
			</aside>

		</div>
	</div>

	<?php if ( $related ) : ?>
		<section class="dp-rd-related" aria-labelledby="dp-rd-related-title">
			<div class="dp-rd-related-container">
				<header class="dp-rd-related-head">
					<h2 id="dp-rd-related-title" class="dp-rd-related-title">More <?php echo esc_html( $category['title'] ); ?></h2>
					<a class="dp-arrow-link" href="<?php echo esc_url( $library . '#dp-lib-' . $category['term']->slug ); ?>">
						See them all
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
					</a>
				</header>
				<ul class="dp-rd-cards">
					<?php foreach ( $related as $item ) : ?>
						<li>
							<a class="dp-rd-card" href="<?php echo esc_url( $item['url'] ); ?>">
								<span class="dp-rd-card-icon" aria-hidden="true"><?php echo donphin_resource_icon( $category['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?></span>
								<span class="dp-rd-card-name"><?php echo esc_html( $item['name'] ); ?></span>
								<?php if ( $item['tag'] ) : ?>
									<span class="dp-rd-card-tag"><?php echo esc_html( $item['tag'] ); ?></span>
								<?php endif; ?>
								<span class="dp-rd-card-format"><?php echo esc_html( $item['file'] ? $item['file']['ext'] : ( 'link' === $item['kind'] ? 'Link' : 'On request' ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endif; ?>

</article>

	<?php
endwhile;

get_footer();
