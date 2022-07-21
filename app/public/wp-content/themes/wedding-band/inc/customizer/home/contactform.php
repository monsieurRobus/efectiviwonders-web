<?php 
/**
* Trainer Section Theme Option.
*
* @package  wedding_band
*/

 function wedding_band_customize_register_trainer( $wp_customize ) {
    
    /** contactform Section */
    $wp_customize->add_section(
        'wedding_band_contactform_settings',
        array(
            'title' => __( 'Contact Form Section', 'wedding-band' ),
            'priority' => 80,
            'panel' => 'wedding_band_home_page_settings',
        )
    );
    
    /** Enable/Disable contactform Section */
    $wp_customize->add_setting(
        'wedding_band_ed_contactform_section',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_ed_contactform_section',
        array(
            'label' => __( 'Enable Contact Form Section', 'wedding-band' ),
            'section' => 'wedding_band_contactform_settings',
            'type' => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'wedding_band_contactform_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_contactform_section_title',
        array(
              'label' => __('Section Title','wedding-band'),
              'section' => 'wedding_band_contactform_settings', 
              'type' => 'text',
    ));


    $wp_customize->add_setting(
        'wedding_band_contactform_section_description',
        array(
            'default'=> '',
            'sanitize_callback'=> 'wp_kses_post'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_contactform_section_description',
        array(
              'label' => __('Section Description','wedding-band'),
              'section' => 'wedding_band_contactform_settings', 
              'type' => 'text',
    ));

    $wp_customize->add_setting(
        'wedding_band_contactform_section_address',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_contactform_section_address',
        array(
              'label' => __('Address','wedding-band'),
              'section' => 'wedding_band_contactform_settings', 
              'type' => 'text',
    ));

    $wp_customize->add_setting(
        'wedding_band_contactform_section_email',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_email'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_contactform_section_email',
        array(
              'label' => __('Email','wedding-band'),
              'section' => 'wedding_band_contactform_settings', 
              'type' => 'text',
    ));

    $wp_customize->add_setting(
        'wedding_band_contactform_section_phone_number',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_contactform_section_phone_number',
        array(
              'label' => __('Phone Number','wedding-band'),
              'section' => 'wedding_band_contactform_settings', 
              'type' => 'text',
    ));

    if ( class_exists( 'wpcf7' ) ) {
    $wp_customize->add_setting(
        'wedding_band_contact_form',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
            )
    );
    
    $wp_customize->add_control( 
        'wedding_band_contact_form',
        array(
            'label' => __( 'Contact Form', 'wedding-band' ),
            'section' => 'wedding_band_contactform_settings',
            'description' => __( 'Enter the Contact Form Shortcode. Ex. [contact-form-7 id="186" title="Google contact"]', 'wedding-band' ),
            'type' => 'text',
        )
     );
    
    }

}
add_action( 'customize_register', 'wedding_band_customize_register_trainer' );
