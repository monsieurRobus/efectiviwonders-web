<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wedding_band
 */

 /**
     * After Content
     * 
     * @hooked wedding_band_content_end - 20
    */
    do_action( 'wedding_band_after_content' );
    
    /**
     * wedding_band Footer
     * 
     * @hooked wedding_band_footer_start  - 10
     * @hooked wedding_band_footer_top    - 20
     * @hooked wedding_band_footer_bottom - 30
     * @hooked wedding_band_footer_end    - 40
    */
    do_action( 'wedding_band_footer' );
    
    /**
     * After Footer
     * 
     * @hooked wedding_band_page_end - 20
    */
    do_action( 'wedding_band_after_footer' );
   
    wp_footer(); ?>

</body>
</html>