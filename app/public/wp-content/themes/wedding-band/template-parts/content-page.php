<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wedding_Band
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php 
    /**
     * Before Page entry content
     * 
     * @hooked wedding_band_page_content_image - 10
     * @hooked wedding_band_page_entry_header  - 20
    */
    do_action( 'wedding_band_before_page_entry_content' );    
    ?>
    
	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wedding-band' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		wedding_band_entry_footer();
		?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
