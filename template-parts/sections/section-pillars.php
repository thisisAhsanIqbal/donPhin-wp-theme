<?php
/**
 * Template Part: Speak / Counsel
 *
 * Two photo cards on ink, one per way Don works.
 * The large italic verb sits on the photo; the title, text and link sit below.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 'focus' is the object-position that keeps Don in frame when a photo is cropped.
// 'external' links open in a new tab.
$pillars = array(
	array(
		'label' => 'Speak',
		'title' => 'Keynotes that make the meeting.',
		'text'  => 'More than 700 presentations, including 600 to Vistage CEO groups, on the emotions of leadership, hiring and retaining good people, and the stories that run our lives. No warmed-over slides. Stories, psychology, and forty years in the trenches.',
		'link'  => 'See the keynotes',
		'url'   => home_url( '/speaking/' ),
		'image' => 'asASpeak.webp',
		'alt'   => 'Don Phin speaking from a podium to a full conference hall',
		'focus' => '75% 50%',
	),
	array(
		'label' => 'Counsel',
		'title' => 'Counsel for what matters most.',
		'text'  => 'Private counsel for men who have built the wealth and want to build the life it was supposed to make possible. A few men at a time, for one year. Personal, confidential, and fully present: no script, no agenda, and nothing leaves the room.',
		'link'  => 'Explore private counsel',
		'url'   => home_url( '/private-counsel/' ),
		'image' => 'asACoach.webp',
		'alt'   => 'Don Phin in a one-on-one private conversation',
		'focus' => '62% 35%',
	),
);
?>

<section class="dp-pillars" aria-label="<?php esc_attr_e( 'Speak, counsel', 'don-phin-esq' ); ?>">
	<div class="dp-pillars-container">

		<?php
		foreach ( $pillars as $pillar ) :
			$external = ! empty( $pillar['external'] );
			?>
			<article class="dp-pillar">
				<div class="dp-pillar-media">
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $pillar['image'] ); ?>"
						alt="<?php echo esc_attr( $pillar['alt'] ); ?>"
						width="1878"
						height="2272"
						loading="lazy"
						decoding="async"
						style="object-position: <?php echo esc_attr( $pillar['focus'] ); ?>;"
					/>
					<p class="dp-pillar-verb"><?php echo esc_html( $pillar['label'] ); ?></p>
				</div>

				<div class="dp-pillar-body">
					<h2 class="dp-pillar-title"><?php echo esc_html( $pillar['title'] ); ?></h2>
					<p class="dp-pillar-text"><?php echo esc_html( $pillar['text'] ); ?></p>
					<a
						href="<?php echo esc_url( $pillar['url'] ); ?>"
						class="dp-arrow-link"
						<?php if ( $external ) : ?>
							target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $pillar['link'] . ' (opens in a new tab)' ); ?>"
						<?php endif; ?>
					>
						<?php echo esc_html( $pillar['link'] ); ?>
						<?php echo donphin_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>
					</a>
				</div>
			</article>
		<?php endforeach; ?>

	</div>
</section>
