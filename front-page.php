<?php
/**
 * Front Page Template (Home)
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// 1. Load the Home Hero Component
get_template_part( 'template-parts/hero/hero', 'home' );

// 2. Load the Speak / Counsel Component
get_template_part( 'template-parts/sections/section', 'pillars' );

// 3. Load the Credibility Component
get_template_part( 'template-parts/sections/section', 'credibility' );

// 4. Load the Photo Slider Component
get_template_part( 'template-parts/sections/section', 'slider' );

// 5. Load the Free Tools (lead capture) Component
get_template_part( 'template-parts/sections/section', 'tools' );

// 6. Load the Testimonials Component
get_template_part( 'template-parts/sections/section', 'testimonials' );

// 7. Load the Closing Call to Action Component
get_template_part( 'template-parts/sections/section', 'home-cta' );

// Output any additional content added in WordPress editor (static front page only)
if ( 'page' === get_option( 'show_on_front' ) ) :
	while ( have_posts() ) :
		the_post();
		$content = get_the_content();
		if ( ! empty( trim( $content ) ) ) :
			?>
			<div class="dp-page-content-wrap">
				<div class="dp-page-container">
					<?php the_content(); ?>
				</div>
			</div>
			<?php
		endif;
	endwhile;
endif;

get_footer();
