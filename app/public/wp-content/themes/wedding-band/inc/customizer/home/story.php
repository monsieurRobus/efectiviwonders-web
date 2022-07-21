<?php 
/**
* promotional Section Theme Option.
*
* @package  wedding_band
*/

 function wedding_band_customize_register_promotional( $wp_customize ) {
    
    global $wedding_band_options_posts;

    /** story Section */
    $wp_customize->add_section(
        'wedding_band_story_settings',
        array(
            'title' => __( 'Story Section', 'wedding-band' ),
            'priority' => 50,
            'panel' => 'wedding_band_home_page_settings',
        )
    );
    
    /** Enable/Disable story Section */
    $wp_customize->add_setting(
        'wedding_band_ed_story_section',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_ed_story_section',
        array(
            'label' => __( 'Enable story Section', 'wedding-band' ),
            'section' => 'wedding_band_story_settings',
            'type' => 'checkbox',
        )
    );

    /** story Post One */
    $wp_customize->add_setting(
        'wedding_band_story_post',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_story_post',
        array(
            'label' => __( 'Select Story Post', 'wedding-band' ),
            'section' => 'wedding_band_story_settings',
            'type' => 'select',
            'choices' => $wedding_band_options_posts,
        )
    );
}
add_action( 'customize_register', 'wedding_band_customize_register_promotional' );
