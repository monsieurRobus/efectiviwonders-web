<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wedding_band
 **
 *
     * Doctype Hook
     * 
     * @hooked wedding_band_doctype_cb
    */
    do_action( 'wedding_band_doctype' );
?>

<head>

<?php 
    /**
     * Before wp_head
     * 
     * @hooked wedding_band_head
    */
    do_action( 'wedding_band_before_wp_head' );

    wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
		
    <?php
    wp_body_open();
    
    /**
    * @hooked wedding_band_page_start 
    */
    do_action( 'wedding_band_before_page_start' ); 
    
    /**
    * wedding_band Header Top
    * 
    * @hooked wedding_band_header_start  - 10
    * @hooked wedding_band_main_header    - 20
    * @hooked wedding_band_header_end - 30    
    */
    do_action( 'wedding_band_header' ); 
    
    /**
    * After Header
    * 
    * @hooked wedding_band_page_header
    */
    do_action( 'wedding_band_after_header' );