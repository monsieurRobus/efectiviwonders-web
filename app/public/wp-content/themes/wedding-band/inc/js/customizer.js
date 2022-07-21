jQuery(document).ready(function($) {
	
	/* Move widgets to their respective sections */
	wp.customize.section( 'sidebar-widgets-google-map' ).panel( 'wedding_band_home_page_settings' );
	wp.customize.section( 'sidebar-widgets-google-map' ).priority( '70' );
    
});