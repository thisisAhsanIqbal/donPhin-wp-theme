<?php
/**
 * Front Page: the gateway
 *
 * donphin.com is a door into one of two sides of Don's work, and nothing else: no site
 * header, no footer. Don's name over two full-height cards, each a photograph with its
 * name, one line and a way in: Private Counsel and Keynote Speaking.
 *
 * It is a whole page of its own rather than going through header.php and footer.php,
 * which carry the site header and footer; wp_head() and wp_footer() still run, so
 * WordPress, its toolbar and the theme's styles work as everywhere else. The styles
 * are in assets/css/gateway.css (inc/enqueue.php).
 *
 * The earlier home page sections (template-parts/hero/hero-home.php and
 * template-parts/sections/) are no longer shown here, and are kept for reuse.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$images   = get_stylesheet_directory_uri() . '/assets/images/gateway/';
$sections = donphin_sections();

// The two doors, left to right
$doors = array(
	array(
		'section' => 'counsel',
		'title'   => 'Private Counsel',
		'line'    => 'For successful men ready for what comes next.',
		'image'   => 'counsel',
		'full'    => 1024,
		'alt'     => 'Don Phin, Esq., smiling, on a grey background',
		'focus'   => '50% 20%',
	),
	array(
		'section' => 'speaking',
		'title'   => 'Keynote Speaking',
		'line'    => 'Mastering the Emotional Edge',
		'image'   => 'speaking',
		'full'    => 1400,
		'alt'     => 'Don Phin on stage at a podium, hand raised to the audience',
		'focus'   => '50% 18%',
	),
);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'dp-gateway-page' ); ?>>
<?php wp_body_open(); ?>

<main class="dp-gateway">

	<header class="dp-gateway-head">
		<h1 class="dp-gateway-name">Don Phin, <span class="dp-gateway-name-accent">Esq.</span></h1>
		<p class="dp-gateway-intro">Two ways to work with me.</p>
	</header>

	<nav class="dp-gateway-doors" aria-label="<?php esc_attr_e( 'Two ways to work with Don', 'don-phin-esq' ); ?>">
		<?php foreach ( $doors as $index => $door ) : ?>
			<a class="dp-gateway-door dp-gateway-door--<?php echo esc_attr( $door['section'] ); ?>" href="<?php echo esc_url( home_url( $sections[ $door['section'] ]['home'] ) ); ?>">
				<img
					class="dp-gateway-photo"
					src="<?php echo esc_url( $images . $door['image'] . '-' . $door['full'] . '.webp' ); ?>"
					srcset="<?php echo esc_attr( $images . $door['image'] . '-800.webp 800w, ' . $images . $door['image'] . '-' . $door['full'] . '.webp ' . $door['full'] . 'w' ); ?>"
					sizes="(max-width: 767px) 100vw, 50vw"
					alt="<?php echo esc_attr( $door['alt'] ); ?>"
					style="object-position: <?php echo esc_attr( $door['focus'] ); ?>;"
					<?php echo 0 === $index ? 'fetchpriority="high"' : ''; ?>
					decoding="async"
				/>
				<span class="dp-gateway-door-body">
					<span class="dp-gateway-rule" aria-hidden="true"></span>
					<span class="dp-gateway-title"><?php echo esc_html( $door['title'] ); ?></span>
					<span class="dp-gateway-line"><?php echo esc_html( $door['line'] ); ?></span>
					<span class="dp-gateway-button">Explore</span>
				</span>
			</a>
		<?php endforeach; ?>
	</nav>

</main>

<?php wp_footer(); ?>
</body>
</html>
