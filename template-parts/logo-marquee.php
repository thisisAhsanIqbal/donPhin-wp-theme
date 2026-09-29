<?php
/**
 * Template Part: Client Logo Marquee
 *
 * The organisations that have booked Don, in one row that drifts from right to left
 * forever. The list is printed twice, back to back, and the pair slides one list's
 * width before starting over, so the loop never shows a seam. The second copy is
 * decoration only. Styles live in style.css (shared: logo marquee).
 *
 * $args['labelledby'] is the id of the visible label that names the list.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$labelledby = isset( $args['labelledby'] ) ? $args['labelledby'] : '';
$icons      = get_stylesheet_directory_uri() . '/assets/images/icons/';
?>

<div class="dp-logo-marquee">
	<div class="dp-logo-marquee-track">
		<?php foreach ( array( false, true ) as $is_copy ) : ?>
			<ul class="dp-logo-list"<?php echo $is_copy ? ' aria-hidden="true"' : ( $labelledby ? ' aria-labelledby="' . esc_attr( $labelledby ) . '"' : '' ); ?>>
				<?php foreach ( donphin_client_logos() as $client ) : ?>
					<li>
						<img
							src="<?php echo esc_url( $icons . $client[1] ); ?>"
							alt="<?php echo $is_copy ? '' : esc_attr( $client[0] ); ?>"
							class="dp-logo-mark dp-logo-mark--<?php echo esc_attr( isset( $client[4] ) ? $client[4] : sanitize_title( $client[0] ) ); ?>"
							width="<?php echo esc_attr( $client[2] ); ?>"
							height="<?php echo esc_attr( $client[3] ); ?>"
							decoding="async"
						/>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endforeach; ?>
	</div>
</div>
