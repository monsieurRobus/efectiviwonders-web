<?php
/**
 * Template Name: Home Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wedding Band
 */

get_header();
      
    $wedding_band_page_sections = array( 'banner', 'about', 'services', 'feature', 'story', 'blog', 'map', 'contactform' );

    foreach( $wedding_band_page_sections as $section ){ 
        if( get_theme_mod( 'wedding_band_ed_' . $section . '_section' ) == 1 ){
            get_template_part( 'sections/' . esc_attr( $section ) );
        } 
    }
    
get_footer();