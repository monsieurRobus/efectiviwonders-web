<?php 
/**
 * Footer Option.
 *
 * @package Wedding Band
 */
 
function wedding_band_customize_footer_settings( $wp_customize ) {

 /** Footer Section */
    $wp_customize->add_section(
        'wedding_band_footer_section',
        array(
            'title' => __( 'Footer Settings', 'wedding-band' ),
            'priority' => 70,
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'wedding_band_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'wedding-band' ),
            'section' => 'wedding_band_footer_section',
            'type' => 'textarea',
        )
    );

}

add_action( 'customize_register', 'wedding_band_customize_footer_settings' );
 