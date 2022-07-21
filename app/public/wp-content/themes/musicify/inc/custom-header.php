<?php
/**
 * @package Musicify
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses musicify_header_style()
 */
function musicify_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'musicify_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'fff',
		'flex-height'            => true,
		'default-image'			=> get_theme_file_uri( '/images/bg-image.jpg' ),
		'wp-head-callback'       => 'musicify_header_style',
		) ) );
		register_default_headers( array(
		'header-bg' => array(
			'url'           => get_theme_file_uri( '/images/bg-image.jpg' ),
			'thumbnail_url' => get_theme_file_uri( '/images/bg-image.jpg' ),
			'description'   => _x( 'Default', 'Default header image', 'musicify' )
			),	
		) );

}
add_action( 'after_setup_theme', 'musicify_custom_header_setup' );

if ( ! function_exists( 'musicify_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see musicify_custom_header_setup().
	 */
function musicify_header_style() {
	$header_text_color = get_header_textcolor();
	$header_image = get_header_image();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( empty( $header_image ) && $header_text_color == get_theme_support( 'custom-header', 'default-text-color' ) ){
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
		<style type="text/css">


	.logo-container .logofont {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}

	<?php if ( ! display_header_text() ) : ?>
	a.logofont {
		position: absolute;
		clip: rect(1px, 1px, 1px, 1px);
		display:none;
	}
	<?php endif; ?>

		<?php header_image(); ?>"
		<?php
		if ( ! display_header_text() ) :
			?>
		a.logofont{
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
			display:none;
		}
		<?php
		else :
			?>
		.logo-container .logofont{
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
		<?php endif; ?>
		</style>
		<?php
	}
	endif;
