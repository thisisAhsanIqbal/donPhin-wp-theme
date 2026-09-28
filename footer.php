<?php
/**
 * The Site Footer for the Don Phin, Esq. theme
 *
 * Closes the markup opened in header.php, then prints the footer:
 * the name, the four contact details (each with a small icon; two columns on
 * phones), and the copyright line.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

		<?php do_action( 'kadence_after_content' ); ?>
	</main><!-- #inner-wrap -->

	<footer class="dp-footer" role="contentinfo">
		<div class="dp-footer-simple">
			<div class="dp-footer-title">DON PHIN, ESQ.</div>
			<span class="dp-footer-rule" aria-hidden="true"></span>
			<div class="dp-footer-details">
				<span class="dp-footer-item"><?php echo donphin_footer_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>Juno Beach, FL</span>
				<span class="dp-footer-sep" aria-hidden="true">&middot;</span>
				<a href="tel:+16198524580" class="dp-footer-item"><?php echo donphin_footer_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>619-852-4580</a>
				<span class="dp-footer-sep" aria-hidden="true">&middot;</span>
				<a href="mailto:don@donphin.com" class="dp-footer-item"><?php echo donphin_footer_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>don@donphin.com</a>
				<span class="dp-footer-sep" aria-hidden="true">&middot;</span>
				<a href="https://www.linkedin.com/in/donphin" class="dp-footer-item" target="_blank" rel="noopener noreferrer" aria-label="Don Phin on LinkedIn (opens in a new tab)"><?php echo donphin_footer_icon( 'linkedin' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG ?>LinkedIn</a>
			</div>
			<p class="dp-footer-copyright">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Don Phin, Esq. All rights reserved.</p>
		</div>
	</footer>

</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
