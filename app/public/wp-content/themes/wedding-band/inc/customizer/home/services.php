<?php 
/**
* Information Section Theme Option.
*
* @package  wedding_band
*/

 function wedding_band_customize_register_information( $wp_customize ) {
    
    global $wedding_band_options_posts;
    
     /** service Section */
    $wp_customize->add_section(
        'wedding_band_service_settings',
        array(
            'title' => __( 'Service Section', 'wedding-band' ),
            'priority' => 30,
            'panel' => 'wedding_band_home_page_settings',
        )
    );
    
    /** Enable/Disable service Section */
    $wp_customize->add_setting(
        'wedding_band_ed_services_section',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_ed_services_section',
        array(
            'label' => __( 'Enable Service Section', 'wedding-band' ),
            'section' => 'wedding_band_service_settings',
            'type' => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'wedding_band_service_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_service_section_title',
        array(
              'label' => __('Section Title','wedding-band'),
              'section' => 'wedding_band_service_settings', 
              'type' => 'text',
    ));


    $wp_customize->add_setting(
        'wedding_band_service_section_description',
        array(
            'default'=> '',
            'sanitize_callback'=> 'wp_kses_post'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_service_section_description',
        array(
              'label' => __('Section Description','wedding-band'),
              'section' => 'wedding_band_service_settings', 
              'type' => 'text',
    ));

    /** Services Post */
    $wp_customize->add_setting(
        'wedding_band_service_post_one',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_service_post_one',
        array(
            'label' => __( 'Post One', 'wedding-band' ),
            'section' => 'wedding_band_service_settings',
            'type' => 'select',
            'choices' => $wedding_band_options_posts,
        )
    );

    $wp_customize->add_setting(
        'wedding_band_service_post_two',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_service_post_two',
        array(
            'label' => __( 'Post Two', 'wedding-band' ),
            'section' => 'wedding_band_service_settings',
            'type' => 'select',
            'choices' => $wedding_band_options_posts,
        )
    );

    $wp_customize->add_setting(
        'wedding_band_service_post_three',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_service_post_three',
        array(
            'label' => __( 'Post Three', 'wedding-band' ),
            'section' => 'wedding_band_service_settings',
            'type' => 'select',
            'choices' => $wedding_band_options_posts,
        )
    );

    $wp_customize->add_setting(
        'wedding_band_service_post_four',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_service_post_four',
        array(
            'label' => __( 'Post Four', 'wedding-band' ),
            'section' => 'wedding_band_service_settings',
            'type' => 'select',
            'choices' => $wedding_band_options_posts,
        )
    );
}
add_action( 'customize_register', 'wedding_band_customize_register_information');