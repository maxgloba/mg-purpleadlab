<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); ?>


		<?php
		while ( have_posts() ) :
			the_post();

			do_action( 'storefront_single_post_before' );

			get_template_part( 'content', 'single' );

			do_action( 'storefront_single_post_after' );

		endwhile; // End of the loop.
		?>


<?php
do_action( 'storefront_sidebar' );
get_footer();
