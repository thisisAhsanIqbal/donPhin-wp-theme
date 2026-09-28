<?php
/**
 * The Main Header controller for Don Phin, Esq. theme
 * Parent Theme: Kadence
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php do_action( 'kadence_before_wrapper' ); ?>

<div id="wrapper" class="site wp-site-blocks">

	<?php do_action( 'kadence_before_header' ); ?>

	<?php
	// One header for the whole site; the section picks the active tab, menu and CTA
	get_template_part( 'template-parts/header/header', 'site', array( 'section' => donphin_get_header_section() ) );
	?>

	<?php do_action( 'kadence_after_header' ); ?>

	<main id="inner-wrap" class="wrap kt-clear" role="main">
		<?php do_action( 'kadence_before_content' ); ?>
