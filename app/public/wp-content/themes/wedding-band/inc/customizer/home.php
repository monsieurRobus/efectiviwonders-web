<?php
/**
 * Home Page Theme Option.
 *
 * @package wedding_band
 */

function wedding_band_customize_register_home( $wp_customize ) {
    
    
     /** Home Page Settings */
    $wp_customize->add_panel( 
        'wedding_band_home_page_settings',
         array(
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'title' => __( 'Home Page Settings', 'wedding-band' ),
            'description' => __( 'Customize Home Page Settings', 'wedding-band' ),
        ) 
    );

}
add_action( 'customize_register', 'wedding_band_customize_register_home' );