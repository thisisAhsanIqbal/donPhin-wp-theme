<?php
/**
 * Template Part: Credibility
 *
 * Four figures across the pale yellow band, each a large blue number over a short caption.
 * assets/js/home.js counts each number up once as the band comes into view; the markup
 * already holds the final figures, so without JavaScript they simply show.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 'count' is what the number counts up to; 'suffix' follows it ('+', 'M+')
$figures = array(
	array(
		'count'   => 700,
		'suffix'  => '+',
		'caption' => 'Presentations delivered',
	),
	array(
		'count'   => 600,
		'suffix'  => '',
		'caption' => 'Of them to Vistage CEO groups',
	),
	array(
		'count'   => 1,
		'suffix'  => 'M+',
		'caption' => 'Professionals reached through 15+ LinkedIn Learning courses',
	),
	array(
		'count'   => 27,
		'suffix'  => '',
		'caption' => 'Consecutive years as editor of IRMI’s EPLiC Journal',
	),
);
?>

<section class="dp-cred" aria-labelledby="dp-cred-label">
	<div class="dp-cred-container">

		<h2 id="dp-cred-label" class="dp-cred-label">By the numbers</h2>

		<ul class="dp-cred-list">
			<?php foreach ( $figures as $figure ) : ?>
				<li class="dp-cred-item">
					<span class="dp-cred-number" data-count="<?php echo esc_attr( $figure['count'] ); ?>" data-suffix="<?php echo esc_attr( $figure['suffix'] ); ?>"><?php echo esc_html( $figure['count'] . $figure['suffix'] ); ?></span>
					<span class="dp-cred-caption"><?php echo esc_html( $figure['caption'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>

	</div>
</section>
