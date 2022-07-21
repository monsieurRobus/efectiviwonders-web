<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wedding_band
*/

if( ! function_exists( 'wedding_band_doctype_cb' ) ) :
/**
 * Doctype Declaration
 * 
 * @since 1.0.1
*/
function wedding_band_doctype_cb(){
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'wedding_band_doctype', 'wedding_band_doctype_cb');

if( ! function_exists( 'wedding_band_head' ) ) :
/**
 * Before wp_head
 * 
 * @since 1.0.1
*/
function wedding_band_head(){
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
}
endif;
add_action( 'wedding_band_before_wp_head', 'wedding_band_head');

if( ! function_exists( 'wedding_band_page_start' ) ) :
/**
 * Page Start
 * 
 * @since 1.0.1
*/
function wedding_band_page_start(){
    ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#acc-content"><?php esc_html_e( 'Skip to content (Press Enter)', 'wedding-band' ); ?></a>
    <?php
}
endif;
add_action( 'wedding_band_before_page_start','wedding_band_page_start');

if( ! function_exists( 'wedding_band_header_start' ) ) :
/**
 * Header Start
 * 
 * @since 1.0.1
*/
function wedding_band_header_start(){ ?>
    <header id="masthead" class="site-header" role="banner">       
    <?php 
}
endif;
add_action( 'wedding_band_header', 'wedding_band_header_start', 10 );

if( !function_exists( 'wedding_band_main_header' )):
/**
 * Header
 * 
 * @since 1.0.1
*/
function wedding_band_main_header(){ ?>
    <div class="container"> 
            
        <div class="site-branding">       
            <?php 
                if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    the_custom_logo();
                } 
            ?>
            <div class="text-logo">
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </h1>

                <?php

                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                    <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                <?php 

                endif; ?>
            </div>
        </div><!-- .site-branding -->
                
        <div class="mobile-menu-wrapper">

            <button id="mobile-header" class="mobile-menu-close-btn" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="mobile-menu">
                <nav id="mobile-site-navigation" class="main-navigation mobile-navigation">        
                    <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                        <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal">X</button>
                        <div class="mobile-menu-title" aria-label="<?php esc_attr_e( 'Mobile', 'wedding-band' ); ?>">
                            <?php
                                wp_nav_menu( array(
                                    'theme_location' => 'primary',
                                    'menu_id'        => 'mobile-primary-menu',
                                    'menu_class'     => 'nav-menu main-menu-modal',
                                ) );
                            ?>
                        </div>
                    </div>
                </nav><!-- #mobile-site-navigation -->
            </div>
        </div>

        <nav id="site-navigation" class="main-navigation" role="navigation">                    
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
        </nav><!-- #site-navigation -->
    
    </div>
    <?php 
} 
endif;
add_action( 'wedding_band_header', 'wedding_band_main_header', 20 );

if( ! function_exists( 'wedding_band_header_end' ) ) :
/**
 * Header End
 * 
 * @since 1.0.1
*/
    function wedding_band_header_end(){
        ?>
        </header>
        <?php
    }
endif;
add_action( 'wedding_band_header', 'wedding_band_header_end', 30 );

if( ! function_exists( 'wedding_band_page_header' ) ):
/**
 * Page Header 
*/
function wedding_band_page_header(){
    echo '<div id="acc-content">';
    $ed_section = wedding_band_home_section();
    if( is_home() || ! $ed_section || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){ ?>
        
        <div id="content" class="site-content">
            <div class="container">
                <div class="row">
    <?php   
    }
}
endif;
add_action( 'wedding_band_after_header', 'wedding_band_page_header', 10 );

if( ! function_exists( 'wedding_band_page_content_image' ) ) :
/**
 * Page Featured Image
*/
function wedding_band_page_content_image(){
    $sidebar_layout = wedding_band_sidebar_layout();
    
    if( has_post_thumbnail() ){
        echo '<div class="post-thumbnail">';
        ( is_active_sidebar( 'right-sidebar' ) && ( $sidebar_layout == 'right-sidebar' ) ) ? the_post_thumbnail( 'wedding-band-blog-thumb' ) : the_post_thumbnail( 'wedding-band-blog-full-width-thumb' );    
        echo '</div>';
    }
}
endif;
add_action( 'wedding_band_before_page_entry_content', 'wedding_band_page_content_image', 10 );

if( ! function_exists( 'wedding_band_post_content_image' ) ) :
/**
 * Post Featured Image
*/
function wedding_band_post_content_image(){
    if( has_post_thumbnail() ){ 
        echo is_single() ? '<div class="post-thumbnail">' : '<a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';    
        
        is_active_sidebar( 'right-sidebar' ) ? the_post_thumbnail( 'wedding-band-blog-thumb' ) : the_post_thumbnail( 'wedding-band-blog-full-width-thumb' );    
        
        echo is_single() ? '</div>' : '</a>';
    }        
}
endif;
add_action( 'wedding_band_before_post_entry_content', 'wedding_band_post_content_image', 10 );

if( ! function_exists( 'wedding_band_post_entry_header' ) ) :
/**
 * Post Entry Header
*/
function wedding_band_post_entry_header(){
    ?>
    <header class="entry-header">
        <?php
            if( is_single() ){
                the_title( '<h1 class="entry-title">', '</h1>' );
            }else{
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            }
        ?>
        <div class="entry-meta">
            <?php 
            if ( 'post' === get_post_type() ){ 
                wedding_band_posted_on(); 
            } 
            ?>
        </div>
    </header><!-- .entry-header -->
    <?php
}
endif;
add_action( 'wedding_band_before_post_entry_content', 'wedding_band_post_entry_header', 20 );

if( ! function_exists( 'wedding_band_page_entry_header' ) ) :
/**
 * Post Entry Header
*/
function wedding_band_page_entry_header(){
    ?>
    <header class="entry-header">
        <?php
            the_title( '<h1 class="entry-title">', '</h1>' ); 
        ?>  
    </header><!-- .entry-header -->
    <?php
}
endif;
add_action( 'wedding_band_before_page_entry_content', 'wedding_band_page_entry_header', 20 );

if( ! function_exists( 'wedding_band_post_author' ) ) :
/**
 * Author Bio
 * 
*/
function wedding_band_post_author(){
    if( get_the_author_meta( 'description' ) ){
    ?>
        <section class="author-section">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 110 ); ?>
            <div class="text">
                <span class="name"><?php printf( esc_html__( 'About %s', 'wedding-band' ), get_the_author_meta( 'display_name' ) ); ?></span>              
                <?php echo wpautop( esc_html( get_the_author_meta( 'description' ) ) ); ?>
            </div>
        </section>
    <?php  
    }  
}
endif;
add_action( 'wedding_band_after_post_content', 'wedding_band_post_author', 20 );

if( ! function_exists( 'wedding_band_get_comment_section' ) ) :
/**
 * Comment template
*/
function wedding_band_get_comment_section(){
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
}
endif;
add_action( 'wedding_band_comment', 'wedding_band_get_comment_section' );

if( ! function_exists( 'wedding_band_content_end' ) ) :
/**
 * Content End
*/
function wedding_band_content_end(){
    $ed_section    = wedding_band_home_section();
    if( is_home() || ! $ed_section || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){ 
    ?>
                </div><!-- row -->
            </div><!-- .content -->
        </div><!-- #container -->        
    <?php
    }
}
endif;
add_action( 'wedding_band_after_content', 'wedding_band_content_end', 20 );

if( ! function_exists( 'wedding_band_footer_start' ) ) :
/**
 * Footer Start
*/
function wedding_band_footer_start(){ ?>
    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">
    <?php
}
endif;
add_action( 'wedding_band_footer', 'wedding_band_footer_start', 10 );

if( ! function_exists( 'wedding_band_footer_top' ) ) :
/**
 * Footer Top
*/
function wedding_band_footer_top(){    
    if( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) || is_active_sidebar( 'footer-four' ) ){
    ?>
        <div class="footer-t">
            <div class="row">
                
                <?php if( is_active_sidebar( 'footer-one' ) ){ ?>
                    <div class="column">
                        <?php dynamic_sidebar( 'footer-one' ); ?>    
                    </div>
                <?php } ?>
                
                <?php if( is_active_sidebar( 'footer-two' ) ){ ?>
                    <div class="column">
                        <?php dynamic_sidebar( 'footer-two' ); ?>    
                    </div>
                <?php } ?>
                
                <?php if( is_active_sidebar( 'footer-three' ) ){ ?>
                    <div class="column">
                        <?php dynamic_sidebar( 'footer-three' ); ?>  
                    </div>
                <?php } ?>

                <?php if( is_active_sidebar( 'footer-four' ) ){ ?>
                    <div class="column">
                        <?php dynamic_sidebar( 'footer-four' ); ?>   
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php 
    }   
}
endif;
add_action( 'wedding_band_footer', 'wedding_band_footer_top', 20 );

if( ! function_exists( 'wedding_band_footer_bottom' ) ) :
/**
 * Footer Bottom
 * 
 * @since 1.0.1 
*/
function wedding_band_footer_bottom(){
    $copyright_text = get_theme_mod( 'wedding_band_footer_copyright_text' ); ?>  
    <div class="footer-b">            
        <div class="site-info">
            <?php 
            if( $copyright_text ){
                echo wp_kses_post( $copyright_text );
            }else{
                echo esc_html__( '&copy; Copyright ', 'wedding-band' ) . date_i18n( esc_html__( 'Y', 'wedding-band' ) ); ?> 
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>.
            <?php } ?>
                <?php echo esc_html__( 'Wedding Band | Developed By', 'wedding-band' ); ?>
            <a href="<?php echo esc_url( 'https://rarathemes.com/' ); ?>" rel="nofollow" target="_blank"><?php echo esc_html__( 'Rara Theme', 'wedding-band' ); ?></a>
            <?php printf( esc_html__( 'Powered by %s', 'wedding-band' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'wedding-band' ) ) .'" target="_blank">WordPress.</a>' ); ?>

            <?php 
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
            ?>
        </div>
    </div>
    <?php 
}
endif;
add_action( 'wedding_band_footer', 'wedding_band_footer_bottom', 30 );

if( ! function_exists( 'wedding_band_footer_end' ) ) :
/**
 * Footer End
*/
function wedding_band_footer_end(){
    ?>
    </div>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'wedding_band_footer', 'wedding_band_footer_end', 40 );

if( ! function_exists( 'wedding_band_page_end' ) ) :
/**
 * Page End
*/
function wedding_band_page_end(){
    ?>
    </div><!-- #acc-content -->
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'wedding_band_after_footer', 'wedding_band_page_end', 20 );