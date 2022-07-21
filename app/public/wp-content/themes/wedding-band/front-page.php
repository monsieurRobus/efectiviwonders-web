<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wedding Band 
 */

$page_sections = array( 'banner', 'about', 'services', 'feature', 'story', 'blog', 'map', 'contactform' );
$ed_section    = wedding_band_home_section();
            
if ( 'posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
}elseif( $ed_section ){ 
    get_header(); 
    foreach( $page_sections as $section ){ 
        if( get_theme_mod( 'wedding_band_ed_' . $section . '_section' ) == 1 ){
            get_template_part( 'sections/' . esc_attr( $section ) );
        } 
    }
    get_footer();
}else {    
    include( get_page_template() );
}