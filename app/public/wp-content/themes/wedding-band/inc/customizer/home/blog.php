<?php 
/**
* news Section Theme Option.
*
* @package  wedding_band
*/

 function wedding_band_customize_register_blog( $wp_customize ) {
/** blog Section */
    $wp_customize->add_section(
        'wedding_band_blog_settings',
        array(
            'title' => __( 'Blog Section', 'wedding-band' ),
            'priority' => 60,
            'panel' => 'wedding_band_home_page_settings',
        )
    );
    
    /** Enable/Disable blog Section */
    $wp_customize->add_setting(
        'wedding_band_ed_blog_section',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_ed_blog_section',
        array(
            'label' => __( 'Enable Blog Section', 'wedding-band' ),
            'section' => 'wedding_band_blog_settings',
            'type' => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'wedding_band_blog_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_blog_section_title',
        array(
              'label' => __('Blog Section Title','wedding-band'),
              'section' => 'wedding_band_blog_settings', 
              'type' => 'text',
    ));

    $wp_customize->add_setting(
        'wedding_band_blog_section_description',
        array(
            'default'=> '',
            'sanitize_callback'=> 'wp_kses_post'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_blog_section_description',
        array(
              'label' => __('Section Description','wedding-band'),
              'section' => 'wedding_band_blog_settings', 
              'type' => 'text',
    ));


}
add_action( 'customize_register', 'wedding_band_customize_register_blog' );
