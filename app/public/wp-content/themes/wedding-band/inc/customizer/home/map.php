<?php 
/**
* Subscription Section Theme Option.
*
* @package  wedding_band
*/

 function wedding_band_customize_register_subscription( $wp_customize ) {

     
    /** map Section */
    $wp_customize->add_section(
        'wedding_band_map_settings',
        array(
            'title' => __( 'Google Map Section', 'wedding-band' ),
            'priority' => 70,
            'panel' => 'wedding_band_home_page_settings',
        )
    );
    
    /** Enable/Disable map Section */
    $wp_customize->add_setting(
        'wedding_band_ed_map_section',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_ed_map_section',
        array(
            'label' => __( 'Enable Google map Section', 'wedding-band' ),
            'section' => 'wedding_band_map_settings',
            'type' => 'checkbox',
        )
    );

}
add_action( 'customize_register', 'wedding_band_customize_register_subscription' );
