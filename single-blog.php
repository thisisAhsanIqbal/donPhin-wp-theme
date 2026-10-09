<?php
/**
 * A blog post's own page (e.g. /speaking/blog/ai-is-not-big-brother/), for every
 * section's blog (inc/blog.php picks this template for them all).
 *
 * The way back, the title and who wrote it when on the hero; the featured picture laid
 * over its edge; the post; Don's note and the section's invitation; the posts either
 * side of it; then more from the same blog. Only this section's posts are ever linked.
 * Its colours, typefaces and layout come from the section (blog.css).
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

<article class="dp-blog dp-blog--<?php echo esc_attr( $key ); ?> dp-blog-single<?php echo $item['image'] ? ' dp-blog-single--image' : ''; ?>">

	<header class="dp-blog-post-hero">
		<div class="dp-blog-post-hero-container">
			<nav class="dp-blog-crumbs" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( $blog ); ?>"><?php echo esc_html( $side['label'] ); ?></a>
				<?php if ( $item['category'] ) : ?>
					<span aria-hidden="true">/</span>
					<a href="<?php echo esc_url( get_term_link( $item['category'] ) ); ?>"><?php echo esc_html( $item['category']->name ); ?></a>
				<?php endif; ?>
			</nav>

			<h1 class="dp-blog-post-title"><?php the_title(); ?></h1>

			<p class="dp-blog-post-meta">
				<span>By Don Phin, Esq.</span>
				<span class="dp-blog-meta-sep" aria-hidden="true">&middot;</span>
				<time datetime="<?php echo esc_attr( $item['datetime'] ); ?>"><?php echo esc_html( $item['date'] ); ?></time>
				<span class="dp-blog-meta-sep" aria-hidden="true">&middot;</span>
				<span><?php echo esc_html( sprintf( '%d min read', $item['minutes'] ) ); ?></span>
			</p>
		</div>
	</header>

	<?php if ( $item['image'] ) : ?>
		<figure class="dp-blog-post-figure">
			<?php echo wp_get_attachment_image( $item['image'], 'full', false, array( 'class' => 'dp-blog-post-image' ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- from wp_get_attachment_image() ?>
		</figure>
	<?php endif; ?>

	<div class="dp-blog-post-body">
		<div class="dp-blog-content">
			<?php the_content(); ?>
		</div>

		<aside class="dp-blog-note">
			<p class="dp-blog-note-by">Don Phin, Esq.</p>
			<p class="dp-blog-note-title"><?php echo esc_html( $side['cta']['title'] ); ?></p>
			<p class="dp-blog-note-text"><?php echo esc_html( $side['cta']['text'] ); ?></p>
			<a class="dp-blog-button" href="<?php echo esc_url( home_url( $side['cta']['url'] ) ); ?>">
				<?php echo esc_html( $side['cta']['label'] ); ?>
				<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
			</a>
		</aside>

		<?php if ( $newer || $older ) : ?>
			<nav class="dp-blog-adjacent" aria-label="<?php esc_attr_e( 'More posts', 'don-phin-esq' ); ?>">
				<?php if ( $older ) : ?>
					<a class="dp-blog-adjacent-link dp-blog-adjacent-link--older" href="<?php echo esc_url( get_permalink( $older ) ); ?>">
						<span class="dp-blog-adjacent-dir">Previous</span>
						<span class="dp-blog-adjacent-title"><?php echo esc_html( get_the_title( $older ) ); ?></span>
					</a>
				<?php endif; ?>
				<?php if ( $newer ) : ?>
					<a class="dp-blog-adjacent-link dp-blog-adjacent-link--newer" href="<?php echo esc_url( get_permalink( $newer ) ); ?>">
						<span class="dp-blog-adjacent-dir">Next</span>
						<span class="dp-blog-adjacent-title"><?php echo esc_html( get_the_title( $newer ) ); ?></span>
					</a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>
	</div>

	<?php if ( $related ) : ?>
		<section class="dp-blog-related" aria-labelledby="dp-blog-related-title">
			<div class="dp-blog-related-container">
				<header class="dp-blog-related-head">
					<h2 id="dp-blog-related-title" class="dp-blog-section-title">More from the blog</h2>
					<a class="dp-arrow-link" href="<?php echo esc_url( $blog ); ?>">
						See every post
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
					</a>
				</header>
				<ul class="dp-blog-related-posts">
					<?php foreach ( $related as $post_item ) : ?>
						<li>
							<a class="dp-blog-related-card" href="<?php echo esc_url( $post_item['url'] ); ?>">
								<span class="dp-blog-meta">
									<time datetime="<?php echo esc_attr( $post_item['datetime'] ); ?>"><?php echo esc_html( $post_item['date'] ); ?></time>
									<span class="dp-blog-meta-sep" aria-hidden="true">&middot;</span>
									<?php echo esc_html( sprintf( '%d min read', $post_item['minutes'] ) ); ?>
								</span>
								<span class="dp-blog-related-title"><?php echo esc_html( $post_item['title'] ); ?></span>
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
