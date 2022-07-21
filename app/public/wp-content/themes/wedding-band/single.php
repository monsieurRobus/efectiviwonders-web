<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Wedding_Band
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single' );
			
			    /**
            * After post content
            * 
            * @hooked wedding_band_post_author  - 20 
            */

            do_action( 'wedding_band_after_post_content' );		

			wedding_band_pagination();

			/**
               * Comments
               * 
               * @hooked wedding_band_get_comment_section 
            */
            do_action( 'wedding_band_comment' ); 

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
