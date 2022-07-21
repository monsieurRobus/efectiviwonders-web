<?php 
	add_action( 'wp_enqueue_scripts', 'musicify_enqueue_styles' );
	function musicify_enqueue_styles() {
		wp_enqueue_style( 'musicify-parent-style', get_template_directory_uri() . '/style.css' ); 
	} 

// Load new fonts
	function musicify_google_fonts(){
		wp_enqueue_style('musicify-google-fonts', '//fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap', false);
	}
	add_action('wp_enqueue_scripts', 'musicify_google_fonts');



// Load new header
	require get_stylesheet_directory() . '/inc/custom-header.php';


	function musicify_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		$wp_customize->get_section('header_image')->title = __( 'Header Settings', 'musicify' );
		$wp_customize->get_section('colors')->title = __( 'Other Colors', 'musicify' );


		$wp_customize->selective_refresh->add_partial(
			'custom_logo',
			array(
				'selector'        => '.header-titles [class*=site-]:not(.logo-container .logofont)',
				'render_callback' => 'musicify_customize_partial_site_logo',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'retina_logo',
			array(
				'selector'        => '.header-titles [class*=site-]:not(.logo-container .logofont)',
				'render_callback' => 'musicify_customize_partial_site_logo',
			)
		);

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector'        => '.logo-container .logofont',
				'render_callback' => 'musicify_customize_partial_blogname',
			) );
			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector'        => '.logo-container .logofont',
				'render_callback' => 'musicify_customize_partial_blogdescription',
			) );
		}


		$wp_customize->add_section( 'musicify_section', array(
			'title'      => __('Other Features','musicify'),
			'priority'   => 1,
			'capability' => 'edit_theme_options',
		) );


		$wp_customize->add_setting('musicify_hide_sidebar', array(
			'default' => 0,
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('musicify_hide_sidebar', array(
			'label'    => __('Hide sidebar', 'musicify'),
			'section'  => 'musicify_section',
			'priority' => 0,
			'settings' => 'musicify_hide_sidebar',
			'type'     => 'checkbox',
		));

		$wp_customize->add_setting('musicify_fullwidth', array(
			'default' => 0,
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control('musicify_fullwidth', array(
			'label'    => __('Full Width (No max width)', 'musicify'),
			'section'  => 'musicify_section',
			'priority' => 0,
			'settings' => 'musicify_fullwidth',
			'type'     => 'checkbox',
		));


		/* New Section */

		$wp_customize->add_setting( 'only_show_header_frontpage', array(
			'default' => 0,
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'only_show_header_frontpage', array(
			'label'    => __( 'Only show header image on front page', 'musicify' ),
			'section'  => 'header_image',
			'priority' => 1,
			'settings' => 'only_show_header_frontpage',
			'type'     => 'checkbox',
		) );

		$wp_customize->add_setting( 'header_img_text', array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'header_img_text', array(
			'label'    => __( "Title", 'musicify' ),
			'section'  => 'header_image',
			'type'     => 'text',
			'priority' => 1,
		) );
		$wp_customize->add_setting( 'header_img_text_tagline', array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'header_img_text_tagline', array(
			'label'    => __( "Tagline", 'musicify' ),
			'section'  => 'header_image',
			'type'     => 'text',
			'priority' => 1,
		) );

		$wp_customize->add_setting( 'header_img_textcolor', array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_img_textcolor', array(
			'label'       => __( 'Text Color', 'musicify' ),
			'section'     => 'header_image',
			'priority'   => 1,
			'settings'    => 'header_img_textcolor',
		) ) );

		function musicify_sanitize_checkbox( $input ) {
			return ( ( isset( $input ) && true == $input ) ? true : false );
		}
	}
	add_action( 'customize_register', 'musicify_customize_register', 99999 );




	if(! function_exists('musicify_customizer_css_final_output' ) ):
		function musicify_customizer_css_final_output(){
			?>
			<style type="text/css">
			<?php if (get_theme_mod('musicify_hide_sidebar') == '1') : ?>   
				.featured-content {
					width: 100%;
					max-width: 100%;
					margin-right: 0px;
				}
				.featured-sidebar {
					display: none;
				}
			<?php endif; ?>
			<?php if (get_theme_mod('musicify_fullwidth') == '1') : ?> 
				.content-wrap {
					width: 100%;
					max-width: 98%;
				}
			<?php endif; ?>
			.page-numbers li a, .page-numbers.current, span.page-numbers.dots, .main-navigation ul li a:hover { color: <?php echo esc_attr(get_theme_mod( 'musicify_main_color')); ?>; }
			.comments-area p.form-submit input, a.continuereading, .blogpost-button, .blogposts-list .entry-header h2:after { background: <?php echo esc_attr(get_theme_mod( 'musicify_main_color')); ?>; }
		</style>
	<?php }
	add_action( 'wp_head', 'musicify_customizer_css_final_output' );
endif;



if ( ! function_exists( 'musicify_customize_partial_site_logo' ) ) {
	/**
	 * Render the site logo for the selective refresh partial.
	 *
	 * Doing it this way so we don't have issues with `render_callback`'s arguments.
	 */
	function musicify_customize_partial_site_logo() {
		the_custom_logo();
	}
}



/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function musicify_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function musicify_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */

function musicify_customize_preview_js() {
	wp_enqueue_script( 'musicify-customizer', get_stylesheet_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1', true );
	wp_dequeue_style( 'marketingly-customizer' );
}
add_action( 'customize_preview_init', 'musicify_customize_preview_js', 99999 );