<?php 
/**
* Banner Section Theme Option.
*
* @package  wedding_band
*/

function wedding_band_customize_register_banner( $wp_customize ) {
    
    global $wedding_band_option_categories;

      /** banner Section */
    $wp_customize->add_section(
        'wedding_band_banner_settings',
        array(
            'title' => __( 'Slider Section', 'wedding-band' ),
            'priority' => 10,
            'panel' => 'wedding_band_home_page_settings',
        )
    );
    
    /** Enable/Disable banner Section */
    $wp_customize->add_setting(
        'wedding_band_ed_banner_section',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_ed_banner_section',
        array(
            'label' => __( 'Enable Slider Section', 'wedding-band' ),
            'section' => 'wedding_band_banner_settings',
            'type' => 'checkbox',
        )
    );

    /** Enable/Disable Slider Auto Transition */
    $wp_customize->add_setting(
        'wedding_band_slider_auto',
        array(
            'default' => '1',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_slider_auto',
        array(
            'label' => __( 'Enable Slider Auto Transition', 'wedding-band' ),
            'section' => 'wedding_band_banner_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Loop */
    $wp_customize->add_setting(
        'wedding_band_slider_loop',
        array(
            'default' => '1',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_slider_loop',
        array(
            'label' => __( 'Enable Slider Loop', 'wedding-band' ),
            'section' => 'wedding_band_banner_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Caption */
    $wp_customize->add_setting(
        'wedding_band_slider_caption',
        array(
            'default' => '1',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_slider_caption',
        array(
            'label' => __( 'Enable Slider Caption', 'wedding-band' ),
            'section' => 'wedding_band_banner_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Slider Animation */
    $wp_customize->add_setting(
        'wedding_band_slider_animation',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_slider_animation',
        array(
            'label' => __( 'Choose Slider Animation', 'wedding-band' ),
            'section' => 'wedding_band_banner_settings',
            'type' => 'select',
            'choices' => array(
                'fade' => __( 'Fade', 'wedding-band' ),
                '' => __( 'Slide', 'wedding-band' ),
            )
        )
    );
    
    /** Slider Readmore */
    $wp_customize->add_setting(
        'wedding_band_slider_readmore',
        array(
            'default' => __( 'View More', 'wedding-band' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_slider_readmore',
        array(
            'label' => __( 'Readmore Text', 'wedding-band' ),
            'section' => 'wedding_band_banner_settings',
            'type' => 'text',
        )
    );
    
    /** Select Category */
    $wp_customize->add_setting(
        'wedding_band_slider_cat',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_slider_cat',
        array(
            'label' => __( 'Choose Slider Category', 'wedding-band' ),
            'section' => 'wedding_band_banner_settings',
            'type' => 'select',
            'choices' => $wedding_band_option_categories,
        )
    );
    /** Slider Settings Ends */
}
add_action( 'customize_register', 'wedding_band_customize_register_banner' );
