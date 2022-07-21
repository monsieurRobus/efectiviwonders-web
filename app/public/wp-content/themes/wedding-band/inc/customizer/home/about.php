<?php 
/**
* About Section Theme Option.
*
* @package  wedding_band
*/

 function wedding_band_customize_register_about( $wp_customize ) {

    global $wedding_band_options_pages;

     /** about Section */
    $wp_customize->add_section(
        'wedding_band_about_settings',
        array(
            'title' => __( 'About Section', 'wedding-band' ),
            'priority' => 20,
            'panel' => 'wedding_band_home_page_settings',
        )
    );
    
    /** Enable/Disable about Section */
    $wp_customize->add_setting(
        'wedding_band_ed_about_section',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_ed_about_section',
        array(
            'label' => __( 'Enable About Section', 'wedding-band' ),
            'section' => 'wedding_band_about_settings',
            'type' => 'checkbox',
        )
    );
    /** about Post One */
    $wp_customize->add_setting(
        'wedding_band_about_post',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_about_post',
        array(
            'label' => __( 'Select Page', 'wedding-band' ),
            'section' => 'wedding_band_about_settings',
            'type' => 'select',
            'choices' => $wedding_band_options_pages,
        )
    );

    /** About Section Readmore */
    $wp_customize->add_setting(
        'wedding_band_about_readmore',
        array(
            'default' => __( 'Read More', 'wedding-band' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_about_readmore',
        array(
            'label' => __( 'Read More Text', 'wedding-band' ),
            'section' => 'wedding_band_about_settings',
            'type' => 'text',
        )
    );

}
add_action( 'customize_register', 'wedding_band_customize_register_about' );