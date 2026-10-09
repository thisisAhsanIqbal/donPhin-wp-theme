<?php
/**
 * A section's blog (e.g. /speaking/blog/), and each of its categories
 * (/speaking/blog/topic/{category}/), for every section's blog (inc/blog.php picks this
 * template for them all).
 *
 * The heading and intro, with a button for each category; then the posts: on the first
 * page of the whole blog, the newest across the top and the rest below; then the pages,
 * and the section's invitation. Only this section's posts are ever shown. Its colours,
 * typefaces and layout come from the section (blog.css): Speaking sets the posts as
 * cards, Private Counsel as an editorial list.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$key   = donphin_blog_side_for_request();
$sides = donphin_blog_sides();
$side  = $sides[ $key ];
$blog  = get_post_type_archive_link( $side['post_type'] );
$term  = is_tax( $side['taxonomy'] ) ? get_queried_object() : null;
$paged = max( 1, (int) get_query_var( 'paged' ) );

$categories = donphin_blog_categories( $key );

$items = array();
while ( have_posts() ) {
	the_post();
	$items[] = donphin_blog_post( get_post() );
}

// The newest leads the first page of the whole blog
$feature = ( ! $term && 1 === $paged && $items ) ? array_shift( $items ) : null;

/**
 * One post's picture: its featured image, or a drawn panel in the section's colours
 */
$picture = function ( $post, $size ) use ( $side ) {
	if ( $post['image'] ) {
		return wp_get_attachment_image( $post['image'], $size, false, array( 'class' => 'dp-blog-image', 'alt' => '' ) );
	}
	return '<span class="dp-blog-art" aria-hidden="true"><span class="dp-blog-art-mark">&ldquo;</span><span class="dp-blog-art-by">' . esc_html( $side['label'] ) . '</span></span>';
};

/**
 * The line over a post's title: its category, the date, and how long it takes to read
 */
$meta = function ( $post ) {
	$parts = array();
	if ( $post['category'] ) {
		$parts[] = '<span class="dp-blog-meta-cat">' . esc_html( $post['category']->name ) . '</span>';
	}
	$parts[] = '<time datetime="' . esc_attr( $post['datetime'] ) . '">' . esc_html( $post['date'] ) . '</time>';
	$parts[] = '<span>' . esc_html( sprintf( '%d min read', $post['minutes'] ) ) . '</span>';
	return '<p class="dp-blog-meta">' . implode( '<span class="dp-blog-meta-sep" aria-hidden="true">&middot;</span>', $parts ) . '</p>';
};
?>

<div class="dp-blog dp-blog--<?php echo esc_attr( $key ); ?>">

	<section class="dp-blog-hero" aria-labelledby="dp-blog-heading">
		<div class="dp-blog-hero-container">
			<?php if ( $term ) : ?>
				<p class="dp-blog-label"><a href="<?php echo esc_url( $blog ); ?>"><?php echo esc_html( $side['label'] ); ?></a></p>
				<h1 id="dp-blog-heading" class="dp-blog-heading"><?php echo esc_html( $term->name ); ?></h1>
				<?php if ( $term->description ) : ?>
					<p class="dp-blog-intro"><?php echo esc_html( $term->description ); ?></p>
				<?php endif; ?>
			<?php else : ?>
				<p class="dp-blog-label"><?php echo esc_html( $side['label'] ); ?></p>
				<h1 id="dp-blog-heading" class="dp-blog-heading">
					<?php echo esc_html( $side['heading'][0] ); ?>
					<?php if ( '' !== $side['heading'][1] ) : ?>
						<em class="dp-blog-accent"><?php echo esc_html( $side['heading'][1] ); ?></em>
					<?php endif; ?>
				</h1>
				<?php if ( $side['intro'] ) : ?>
					<p class="dp-blog-intro"><?php echo esc_html( $side['intro'] ); ?></p>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( count( $categories ) > 1 || $term ) : ?>
				<nav class="dp-blog-topics" aria-label="<?php esc_attr_e( 'Categories', 'don-phin-esq' ); ?>">
					<a class="dp-blog-topic" href="<?php echo esc_url( $blog ); ?>"<?php echo $term ? '' : ' aria-current="page"'; ?>>All</a>
					<?php foreach ( $categories as $category ) : ?>
						<a class="dp-blog-topic" href="<?php echo esc_url( get_term_link( $category ) ); ?>"<?php echo ( $term && $term->term_id === $category->term_id ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $category->name ); ?></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>
		</div>
	</section>

	<section class="dp-blog-list" aria-label="<?php esc_attr_e( 'Posts', 'don-phin-esq' ); ?>">
		<div class="dp-blog-list-container">

			<?php if ( $feature ) : ?>
				<article class="dp-blog-feature">
					<a class="dp-blog-feature-picture" href="<?php echo esc_url( $feature['url'] ); ?>" tabindex="-1" aria-hidden="true">
						<?php echo $picture( $feature, 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput -- from wp_get_attachment_image(), or escaped above ?>
					</a>
					<div class="dp-blog-feature-text">
						<p class="dp-blog-feature-label">Latest</p>
						<?php echo $meta( $feature ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?>
						<h2 class="dp-blog-feature-title"><a href="<?php echo esc_url( $feature['url'] ); ?>"><?php echo esc_html( $feature['title'] ); ?></a></h2>
						<p class="dp-blog-excerpt"><?php echo esc_html( $feature['excerpt'] ); ?></p>
						<a class="dp-blog-more" href="<?php echo esc_url( $feature['url'] ); ?>" aria-hidden="true" tabindex="-1">
							Read the post
							<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
						</a>
					</div>
				</article>
			<?php endif; ?>

			<?php if ( $items ) : ?>
				<ul class="dp-blog-posts">
					<?php foreach ( $items as $post_item ) : ?>
						<li>
							<article class="dp-blog-card">
								<a class="dp-blog-card-picture" href="<?php echo esc_url( $post_item['url'] ); ?>" tabindex="-1" aria-hidden="true">
									<?php echo $picture( $post_item, 'medium_large' ); // phpcs:ignore WordPress.Security.EscapeOutput -- from wp_get_attachment_image(), or escaped above ?>
								</a>
								<div class="dp-blog-card-text">
									<?php echo $meta( $post_item ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?>
									<h2 class="dp-blog-card-title"><a href="<?php echo esc_url( $post_item['url'] ); ?>"><?php echo esc_html( $post_item['title'] ); ?></a></h2>
									<p class="dp-blog-excerpt"><?php echo esc_html( $post_item['excerpt'] ); ?></p>
									<span class="dp-blog-more" aria-hidden="true">
										Read
										<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
									</span>
								</div>
							</article>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( ! $feature && ! $items ) : ?>
				<div class="dp-blog-empty">
					<p class="dp-blog-empty-title"><?php echo $term ? 'Nothing here yet.' : 'The first post is on its way.'; ?></p>
					<p class="dp-blog-empty-text">
						<?php if ( $term ) : ?>
							<a href="<?php echo esc_url( $blog ); ?>">See every post</a>
						<?php else : ?>
							Check back soon.
						<?php endif; ?>
					</p>
				</div>
			<?php endif; ?>

			<?php
			$pages = paginate_links(
				array(
					'type'      => 'array',
					'prev_text' => __( 'Newer', 'don-phin-esq' ),
					'next_text' => __( 'Older', 'don-phin-esq' ),
				)
			);
			if ( $pages ) :
				?>
				<nav class="dp-blog-pages" aria-label="<?php esc_attr_e( 'More posts', 'don-phin-esq' ); ?>">
					<?php echo implode( '', $pages ); // phpcs:ignore WordPress.Security.EscapeOutput -- from paginate_links() ?>
				</nav>
			<?php endif; ?>

		</div>
	</section>

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

</div>

<?php
get_footer();
