<?php
/**
 * Wedding Band Theme Info
 *
 * @package Wedding_Band
 */

function wedding_band_customizer_theme_info( $wp_customize ) {
	
    $wp_customize->add_section( 'theme_info', 
        array(
		'title'    => __( 'Information Links' , 'wedding-band' ),
		'priority' => 5,
	));

	$wp_customize->add_setting( 'theme_info_theme', 
        array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	));
    
    $wp_customize->add_setting( 'setup_instruction',
		array(
            'default'           => '',
			'sanitize_callback' => 'wp_kses_post'
		)
	);

	$wp_customize->add_control(
		new Wedding_Band_Theme_Info( $wp_customize, 'setup_instruction',
			array(
				'section'		=> 'theme_info',
				'description'	=> __( '<strong>Instruction for how to setup Home Page in Wedding Band Theme</strong><br/>1. Go to Pages and create a new page (Title can be anything. For example, Home )<br/>
					2. In right column and under Page Attributes, choose "Home Page" template<br/>
					3. Click on Publish<br/>
					4. Go to Appearance-> Customize -> Default Settings -> Static Front Page<br/>
					5. Select A static page<br/>
					6. Under Front Page, select the page that you created in the step 1<br/>
					7. Save changes', 'wedding-band'),
			)
		)
	);
    
   	$theme_info = '';
	$theme_info .= '<h3 class="sticky_title">' . __( 'Need help?', 'wedding-band' ) . '</h3>';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View demo', 'wedding-band' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/previews/?theme=wedding-band' ) . '" target="_blank">' . __( 'here', 'wedding-band' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View documentation', 'wedding-band' ) . ': </label><a href="' . esc_url( 'https://docs.rarathemes.com/docs/wedding-band' ) . '" target="_blank">' . __( 'here', 'wedding-band' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme info', 'wedding-band' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/wedding-band/' ) . '" target="_blank">' . __( 'here', 'wedding-band' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support ticket', 'wedding-band' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/support-ticket/' ) . '" target="_blank">' . __( 'here', 'wedding-band' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Rate this theme', 'wedding-band' ) . ': </label><a href="' . esc_url( 'https://wordpress.org/support/theme/wedding-band/reviews/' ) . '" target="_blank">' . __( 'here', 'wedding-band' ) . '</a></span><br />';
	$theme_info .= '<span class="sticky_info_row"><label class="more-detail row-element">' . __( 'More WordPress Themes' ,'wedding-band' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/' ) . '" target="_blank">' . __( 'here', 'wedding-band' ) . '</a></span><br />';
	

	$wp_customize->add_control( new Wedding_Band_Theme_Info( $wp_customize, 'theme_info_theme', 
        array(
		'label'       => __( 'About Wedding Band' , 'wedding-band' ),
		'section'     => 'theme_info',
		'description' => $theme_info
	)));

}
add_action( 'customize_register', 'wedding_band_customizer_theme_info' );

if( class_exists( 'WP_Customize_control' ) ){

	class Wedding_Band_Theme_Info extends WP_Customize_Control
	{
    	/**
       	* Render the content on the theme customizer page
       	*/
       	public function render_content()
       	{
       		?>
       		<label>
       			<strong class="customize-text_editor"><?php echo esc_html( $this->label ); ?></strong>
       			<br />
       			<span class="customize-text_editor_desc">
       				<?php echo wp_kses_post( $this->description ); ?>
       			</span>
       		</label>
       		<?php
       	}
    }//editor close
}//class close