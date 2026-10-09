<?php
/**
 * A blog post's own page (e.g. /speaking/blog/ai-is-not-big-brother/), for every
 * section's blog (inc/blog.php picks this template for them all).
 *
 * The page keeps to the header's own frame, so its edges line up with the logo and the
 * header's button; the words sit in one centred reading column inside it:
 * - the hero: the way back, the category, the title, the summary (the excerpt, if it has
 *   one) and Don, with the date and the reading time
 * - the featured picture at its own shape (never cropped: pictures from the old site
 *   carry their title in the image). On Speaking it sits beside the words on wide
 *   screens, out to the button's edge; on Private Counsel it's framed below them
 * - the words, with the sharing links in a rail to the left and "In this post" (the
 *   post's headings) to the right on wide screens; on smaller ones the headings sit
 *   above the words and the sharing links below
 * - who wrote it, the section's invitation, the posts either side, and more from the
 *   same blog, as cards
 * A thin bar along the top shows how far through the post the reader is (blog.js).
 * Only this section's posts are ever linked. Its colours, typefaces and layout come
 * from the section (blog.css).
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$item  = donphin_blog_post( get_post() );
	$key   = $item['side'];
	$sides = donphin_blog_sides();
	$side  = $sides[ $key ];
	$blog  = get_post_type_archive_link( $side['post_type'] );

	// The words, with ids on the headings, and the headings for "In this post"
	$content = donphin_blog_prepare_content( apply_filters( 'the_content', get_the_content() ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WordPress's own filter
	$toc     = count( $content['toc'] ) > 1 ? $content['toc'] : array();

	// The featured picture, at its own shape
	$image = $item['image'] ? wp_get_attachment_image( $item['image'], 'full', false, array( 'class' => 'dp-blog-post-image', 'fetchpriority' => 'high' ) ) : '';

	// Don's portrait for the byline and the card about him
	$portrait = get_stylesheet_directory_uri() . '/assets/images/counsel/portrait-640.webp';

	// Sharing
	$share_url   = rawurlencode( $item['url'] );
	$share_title = rawurlencode( wp_specialchars_decode( $item['title'], ENT_QUOTES ) );
	$shares      = array(
		array( 'LinkedIn', 'https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url, '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>' ),
		array( 'X', 'https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_title, '<path d="M4 4l16 16M20 4L4 20"/>' ),
		array( 'Email', 'mailto:?subject=' . $share_title . '&body=' . $share_url, '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>' ),
	);
	$share_list = function ( $class ) use ( $shares, $item ) {
		$out = '<ul class="dp-blog-share ' . esc_attr( $class ) . '">';
		foreach ( $shares as $share ) {
			$out .= '<li><a class="dp-blog-share-link" href="' . esc_url( $share[1] ) . '"' . ( 'Email' === $share[0] ? '' : ' target="_blank" rel="noopener"' ) . ' aria-label="' . esc_attr( 'Share on ' . $share[0] . ( 'Email' === $share[0] ? '' : ' (opens in a new tab)' ) ) . '">'
				. '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $share[2] . '</svg></a></li>';
		}
		$out .= '<li><button type="button" class="dp-blog-share-link dp-blog-copy" data-url="' . esc_url( $item['url'] ) . '" aria-label="Copy the link">'
			. '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>'
			. '<span class="dp-blog-copy-done" role="status"></span></button></li>';
		return $out . '</ul>';
	};

	// The posts either side of it, in this blog only
	$newer = get_adjacent_post( false, '', false );
	$older = get_adjacent_post( false, '', true );

	// More from the same blog: the same category first, then the newest
	$related = array();
	if ( $item['category'] ) {
		$related = get_posts(
			array(
				'post_type'      => $side['post_type'],
				'posts_per_page' => 3,
				'post__not_in'   => array( $item['id'] ),
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- one small query
					array(
						'taxonomy' => $side['taxonomy'],
						'terms'    => $item['category']->term_id,
					),
				),
			)
		);
	}
	if ( count( $related ) < 3 ) {
		$related = array_merge(
			$related,
			get_posts(
				array(
					'post_type'      => $side['post_type'],
					'posts_per_page' => 3 - count( $related ),
					'post__not_in'   => array_merge( array( $item['id'] ), wp_list_pluck( $related, 'ID' ) ),
				)
			)
		);
	}
	$related = array_map( 'donphin_blog_post', $related );
	?>

<div class="dp-blog-progress" aria-hidden="true"><span class="dp-blog-progress-bar"></span></div>

<article class="dp-blog dp-blog--<?php echo esc_attr( $key ); ?> dp-blog-single<?php echo $image ? ' dp-blog-single--image' : ''; ?>">

	<header class="dp-blog-post-hero">
		<div class="dp-blog-post-hero-container">
			<div class="dp-blog-post-hero-text">
				<nav class="dp-blog-crumbs" aria-label="Breadcrumb">
					<a href="<?php echo esc_url( $blog ); ?>">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
						<?php echo esc_html( $side['label'] ); ?>
					</a>
					<?php if ( $item['category'] ) : ?>
						<span class="dp-blog-crumbs-sep" aria-hidden="true">/</span>
						<a class="dp-blog-crumbs-cat" href="<?php echo esc_url( get_term_link( $item['category'] ) ); ?>"><?php echo esc_html( $item['category']->name ); ?></a>
					<?php endif; ?>
				</nav>

				<h1 class="dp-blog-post-title"><?php the_title(); ?></h1>

				<?php if ( has_excerpt() ) : ?>
					<p class="dp-blog-post-dek"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>

				<div class="dp-blog-byline">
					<img class="dp-blog-byline-photo" src="<?php echo esc_url( $portrait ); ?>" alt="" width="48" height="48" loading="eager">
					<div class="dp-blog-byline-text">
						<span class="dp-blog-byline-name">Don Phin, Esq.</span>
						<span class="dp-blog-byline-meta">
							<time datetime="<?php echo esc_attr( $item['datetime'] ); ?>"><?php echo esc_html( $item['date'] ); ?></time>
							<span class="dp-blog-meta-sep" aria-hidden="true">&middot;</span>
							<?php echo esc_html( sprintf( '%d min read', $item['minutes'] ) ); ?>
						</span>
					</div>
				</div>
			</div>

			<?php if ( $image ) : ?>
				<figure class="dp-blog-post-figure">
					<?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput -- from wp_get_attachment_image() ?>
				</figure>
			<?php endif; ?>
		</div>
	</header>

	<div class="dp-blog-post-layout<?php echo $toc ? ' dp-blog-post-layout--toc' : ''; ?>">

		<aside class="dp-blog-rail dp-blog-rail--share" aria-label="<?php esc_attr_e( 'Share this post', 'don-phin-esq' ); ?>">
			<div class="dp-blog-rail-inner">
				<p class="dp-blog-rail-title">Share</p>
				<?php echo $share_list( 'dp-blog-share--rail' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?>
			</div>
		</aside>

		<?php if ( $toc ) : ?>
			<nav class="dp-blog-rail dp-blog-rail--toc" aria-labelledby="dp-blog-toc-title">
				<div class="dp-blog-rail-inner">
					<p id="dp-blog-toc-title" class="dp-blog-rail-title">In this post</p>
					<!-- Smaller screens: the heading becomes a button that folds the list away (blog.js) -->
					<button type="button" class="dp-blog-toc-toggle" aria-expanded="true" aria-controls="dp-blog-toc-list" hidden>
						<span class="dp-blog-toc-toggle-label">In this post</span>
						<span class="dp-blog-toc-count"><?php echo esc_html( sprintf( '%d sections', count( $toc ) ) ); ?></span>
						<svg class="dp-blog-toc-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><polyline points="6 9 12 15 18 9"/></svg>
					</button>
					<ol id="dp-blog-toc-list" class="dp-blog-toc">
						<?php foreach ( $toc as $heading ) : ?>
							<li><a href="#<?php echo esc_attr( $heading[0] ); ?>"><?php echo esc_html( $heading[1] ); ?></a></li>
						<?php endforeach; ?>
					</ol>
				</div>
			</nav>
		<?php endif; ?>

		<div class="dp-blog-post-main">
			<div class="dp-blog-content">
				<?php echo $content['html']; // phpcs:ignore WordPress.Security.EscapeOutput -- the post's content, through the_content ?>
			</div>

			<footer class="dp-blog-post-end">
				<?php if ( $item['category'] ) : ?>
					<p class="dp-blog-filed">
						<span>Filed under</span>
						<a class="dp-blog-topic" href="<?php echo esc_url( get_term_link( $item['category'] ) ); ?>"><?php echo esc_html( $item['category']->name ); ?></a>
					</p>
				<?php endif; ?>
				<div class="dp-blog-post-end-share">
					<span>Share this post</span>
					<?php echo $share_list( 'dp-blog-share--inline' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?>
				</div>
			</footer>

			<section class="dp-blog-author" aria-label="<?php esc_attr_e( 'About the author', 'don-phin-esq' ); ?>">
				<img class="dp-blog-author-photo" src="<?php echo esc_url( $portrait ); ?>" alt="Don Phin, Esq." width="112" height="112" loading="lazy">
				<div class="dp-blog-author-text">
					<p class="dp-blog-author-label">Written by</p>
					<p class="dp-blog-author-name">Don Phin, Esq.</p>
					<p class="dp-blog-author-bio"><?php echo esc_html( $side['author']['bio'] ); ?></p>
					<a class="dp-arrow-link" href="<?php echo esc_url( home_url( $side['author']['url'] ) ); ?>">
						More about Don
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
					</a>
				</div>
			</section>

			<?php if ( $newer || $older ) : ?>
				<nav class="dp-blog-adjacent" aria-label="<?php esc_attr_e( 'More posts', 'don-phin-esq' ); ?>">
					<?php if ( $older ) : ?>
						<a class="dp-blog-adjacent-link dp-blog-adjacent-link--older" href="<?php echo esc_url( get_permalink( $older ) ); ?>">
							<span class="dp-blog-adjacent-dir">&larr; Previous</span>
							<span class="dp-blog-adjacent-title"><?php echo esc_html( get_the_title( $older ) ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( $newer ) : ?>
						<a class="dp-blog-adjacent-link dp-blog-adjacent-link--newer" href="<?php echo esc_url( get_permalink( $newer ) ); ?>">
							<span class="dp-blog-adjacent-dir">Next &rarr;</span>
							<span class="dp-blog-adjacent-title"><?php echo esc_html( get_the_title( $newer ) ); ?></span>
						</a>
					<?php endif; ?>
				</nav>
			<?php endif; ?>
		</div>

	</div>

	<section class="dp-blog-cta" aria-labelledby="dp-blog-cta-title">
		<div class="dp-blog-cta-container">
			<h2 id="dp-blog-cta-title" class="dp-blog-section-title"><?php echo esc_html( $side['cta']['title'] ); ?></h2>
			<p class="dp-blog-cta-text"><?php echo esc_html( $side['cta']['text'] ); ?></p>
			<a class="dp-blog-button" href="<?php echo esc_url( home_url( $side['cta']['url'] ) ); ?>">
				<?php echo esc_html( $side['cta']['label'] ); ?>
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</div>
	</section>

	<?php if ( $related ) : ?>
		<section class="dp-blog-related" aria-labelledby="dp-blog-related-title">
			<div class="dp-blog-related-container">
				<header class="dp-blog-related-head">
					<h2 id="dp-blog-related-title" class="dp-blog-section-title">Keep reading</h2>
					<a class="dp-arrow-link" href="<?php echo esc_url( $blog ); ?>">
						See every post
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
					</a>
				</header>
				<ul class="dp-blog-posts dp-blog-posts--related">
					<?php foreach ( $related as $post_item ) : ?>
						<li>
							<article class="dp-blog-card">
								<a class="dp-blog-card-picture" href="<?php echo esc_url( $post_item['url'] ); ?>" tabindex="-1" aria-hidden="true">
									<?php if ( $post_item['image'] ) : ?>
										<?php echo wp_get_attachment_image( $post_item['image'], 'medium_large', false, array( 'class' => 'dp-blog-image', 'alt' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- from wp_get_attachment_image() ?>
									<?php else : ?>
										<span class="dp-blog-art" aria-hidden="true"><span class="dp-blog-art-mark">&ldquo;</span><span class="dp-blog-art-by"><?php echo esc_html( $side['label'] ); ?></span></span>
									<?php endif; ?>
								</a>
								<div class="dp-blog-card-text">
									<p class="dp-blog-meta">
										<time datetime="<?php echo esc_attr( $post_item['datetime'] ); ?>"><?php echo esc_html( $post_item['date'] ); ?></time>
										<span class="dp-blog-meta-sep" aria-hidden="true">&middot;</span>
										<span><?php echo esc_html( sprintf( '%d min read', $post_item['minutes'] ) ); ?></span>
									</p>
									<h3 class="dp-blog-card-title"><a href="<?php echo esc_url( $post_item['url'] ); ?>"><?php echo esc_html( $post_item['title'] ); ?></a></h3>
									<p class="dp-blog-excerpt"><?php echo esc_html( $post_item['excerpt'] ); ?></p>
								</div>
							</article>
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
