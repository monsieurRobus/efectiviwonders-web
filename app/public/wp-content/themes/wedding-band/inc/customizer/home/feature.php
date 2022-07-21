<?php 
/**
* Reason Section Theme Option.
*
* @package  wedding_band
*/

 function wedding_band_customize_register_reason( $wp_customize ) {
    
    global $wedding_band_option_categories;
    
    /** feature Section */
    $wp_customize->add_section(
        'wedding_band_feature_settings',
        array(
            'title' => __( 'Featured Post Section', 'wedding-band' ),
            'priority' => 40,
            'panel' => 'wedding_band_home_page_settings',
        )
    );
    
    /** Enable/Disable feature Section */
    $wp_customize->add_setting(
        'wedding_band_ed_feature_section',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_ed_feature_section',
        array(
            'label' => __( 'Enable Featured Post Section', 'wedding-band' ),
            'section' => 'wedding_band_feature_settings',
            'type' => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'wedding_band_feature_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_feature_section_title',
        array(
              'label' => __('Section Title','wedding-band'),
              'section' => 'wedding_band_feature_settings', 
              'type' => 'text',
    ));


    $wp_customize->add_setting(
        'wedding_band_feature_section_description',
        array(
            'default'=> '',
            'sanitize_callback'=> 'wp_kses_post'
            )
        );
    $wp_customize-> add_control(
        'wedding_band_feature_section_description',
        array(
              'label' => __('Section Description','wedding-band'),
              'section' => 'wedding_band_feature_settings', 
              'type' => 'text',
    ));

     $wp_customize->add_setting(
        'wedding_band_feature_cat',
        array(
            'default' => '',
            'sanitize_callback' => 'wedding_band_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'wedding_band_feature_cat',
        array(
            'label' => __( 'Choose Post Category', 'wedding-band' ),
            'section' => 'wedding_band_feature_settings',
            'type' => 'select',
            'choices' => $wedding_band_option_categories,
        )
    );
}
add_action( 'customize_register', 'wedding_band_customize_register_reason' );
