<?php 
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function wedding_band_widgets_init() {
  
    $sidebars = array(
        'sidebar'   => array(
            'name'        => esc_html__( 'Right Sidebar', 'wedding-band' ),
            'id'          => 'right-sidebar', 
            'description' => esc_html__( 'Add widgets here.', 'wedding-band' ),
        ),        
        'footer-one'=> array(
            'name'        => esc_html__( 'Footer One', 'wedding-band' ),
            'id'          => 'footer-one', 
            'description' => esc_html__( 'Add footer one widgets.', 'wedding-band' ),
        ),
        'footer-two'=> array(
            'name'        => esc_html__( 'Footer Two', 'wedding-band' ),
            'id'          => 'footer-two', 
            'description' => esc_html__( 'Add footer two widgets.', 'wedding-band' ),
        ),
        'footer-three'=> array(
            'name'        => esc_html__( 'Footer Three', 'wedding-band' ),
            'id'          => 'footer-three', 
            'description' => esc_html__( 'Add footer three widgets.', 'wedding-band' ),
        ),
        'footer-four'=> array(
            'name'        => esc_html__( 'Footer Four', 'wedding-band' ),
            'id'          => 'footer-four', 
            'description' => esc_html__( 'Add footer four widgets.', 'wedding-band' ),
        ),
        'google-map' => array(
            'name' => esc_html__('Google Map Widget', 'wedding-band'),
            'id' => 'google-map',
            'description' => __( 'Widget for Google map section( Use Text widget for Google Map ).','wedding-band'),
        )
    );

    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
        'name'          => $sidebar['name'],
        'id'            => $sidebar['id'],
        'description'   => $sidebar['description'],
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
      ) );
    }
    
}
add_action( 'widgets_init', 'wedding_band_widgets_init' );

/**
 * Recent Post Widget
*/
require get_template_directory() . '/inc/widgets/widget-recent-post.php';

/**
 * Popular Post Widget
*/
require get_template_directory() . '/inc/widgets/widget-popular-post.php';

/**
 * Social Link Widget
*/
require get_template_directory() . '/inc/widgets/widget-social-links.php';