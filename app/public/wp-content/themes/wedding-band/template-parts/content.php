<?php
/**
 * Template part for displaying posts.
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
     * @hooked wedding_band_post_content_image - 10
     * @hooked wedding_band_post_entry_header  - 20 
    */
    do_action( 'wedding_band_before_post_entry_content' );    
    ?>

	<div class="entry-content">
		<?php
			if( false === get_post_format() ){
                the_excerpt();
            }else{
                the_content( sprintf(
    				/* translators: %s: Name of current post. */
    				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'wedding-band' ), array( 'span' => array( 'class' => array() ) ) ),
    				the_title( '<span class="screen-reader-text">"', '"</span>', false )
    			) );
	        }

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wedding-band' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More','wedding-band'); ?></a>
		<?php wedding_band_entry_footer(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->


