<?php 

if ( ! function_exists( 'wedding_band_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wedding_band_posted_on() {
  
  printf( '<span class="byline"><i class="fa fa-pencil"></i><span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ) );
  printf( '<span class="posted-on"><i class="fa fa-calendar-o"></i><a href="%1$s" rel="bookmark"><time class="entry-date published updated" datetime="%2$s">%3$s</time></a></span>', esc_url( get_permalink() ), esc_attr( get_the_date() ), esc_html( get_the_date() ) );
  
  if ( 'post' === get_post_type() ) {
    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( esc_html__( ', ', 'wedding-band' ) );
    if ( $categories_list && wedding_band_categorized_blog() ) {
      printf( '<span class="cat-links"><i class="fa fa-bookmark"></i>%1$s</span>', $categories_list ); // WPCS: XSS OK.
    }
  }

  if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
      echo '<span class="comments-link"><i class="fa fa-comments"></i>';
        /* translators: %s: post title */
         comments_popup_link( esc_html__( 'Leave a comment', 'wedding-band' ), esc_html__( '1 Comment', 'wedding-band' ), esc_html__( '% Comments', 'wedding-band' ) );
      echo '</span>';
  }

}
endif;

if ( ! function_exists( 'wedding_band_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function wedding_band_entry_footer() {
  // Hide category and tag text for pages.
  if ( 'post' === get_post_type() ) {
   
    /* translators: used between list items, there is a space after the comma */
    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'wedding-band' ) );
    if ( $tags_list ) {
      printf( '<span class="tags-links">' . esc_html__( 'Tags:  %1$s', 'wedding-band' ) . '</span>', $tags_list ); // WPCS: XSS OK.
    }
  }

  edit_post_link(
    sprintf(
      /* translators: %s: Name of current post */
      esc_html__( 'Edit %s', 'wedding-band' ),
      the_title( '<span class="screen-reader-text">"', '"</span>', false )
    ),
    '<span class="edit-link">',
    '</span>'
  );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function wedding_band_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'wedding_band_categories' ) ) ) {
    // Create an array of all the categories that are attached to posts.
    $all_the_cool_cats = get_categories( array(
      'fields'     => 'ids',
      'hide_empty' => 1,
      // We only need to know if there is more than one category.
      'number'     => 2,
    ) );

    // Count the number of categories that are attached to the posts.
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'wedding_band_categories', $all_the_cool_cats );
  }

  if ( $all_the_cool_cats > 1 ) {
    // This blog has more than 1 category so wedding_band_categorized_blog should return true.
    return true;
  } else {
    // This blog has only 1 category so wedding_band_categorized_blog should return false.
    return false;
  }
}

/**
 * Return sidebar layouts for pages
*/
function wedding_band_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'wedding_band_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'wedding_band_sidebar_layout', true );    
    }else{
        return 'right-sidebar';
    }
}

if( ! function_exists( 'wedding_band_pagination' ) ):

  function wedding_band_pagination(){
        
    if( is_single() ){
        the_post_navigation();
    }else{
          the_posts_pagination( array(
            'prev_text'   => __( '<<', 'wedding-band' ),
            'next_text'   => __( '>>', 'wedding-band' ),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'wedding-band' ) . ' </span>',
          ) );
    }
  }

endif;

/**
 * Returns Section header
*/
function wedding_band_get_section_header( $title, $description ){
    if( $title || $description ){ ?>
        <div class="header-part">
            <?php 
                if( $title ) echo '<h2>' . esc_html( $title ) . '</h2>';
                if( $description ) echo wpautop( wp_kses_post( $description ) ); 
            ?>
        </div>
    <?php
    }
}

/**
 * Escape iframe
*/
function wedding_band_sanitize_iframe( $iframe ){
        
        $allow_tag = array(
            'iframe'=>array(
            'src'   => array()
            ) );
        
    return wp_kses( $iframe, $allow_tag );
}

 if( ! function_exists( 'wedding_band_home_section') ):
/**
 * Check if home page section are enable or not.
*/
    function wedding_band_home_section(){

        $wedding_band_sections = array( 'banner', 'about', 'services', 'feature', 'story', 'blog', 'map', 'contactform' );       
        $enable_section = false;
        foreach( $wedding_band_sections as $section ){ 
            if( get_theme_mod( 'wedding_band_ed_' . $section . '_section' ) == 1 ){
                $enable_section = true;
            }
        }
        return $enable_section;
    }
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
	/**
	 * Triggered after the opening <body> tag.
    */
	do_action( 'wp_body_open' );
}
endif;

if( ! function_exists( 'wedding_band_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function wedding_band_get_image_sizes( $size = '' ) {
 
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'wedding_band_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function wedding_band_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size = wedding_band_get_image_sizes( $post_thumbnail );
     
    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#f2f2f2;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

if( ! function_exists( 'wedding_band_fonts_url' ) ) :
/**
 * Register custom fonts.
 */
function wedding_band_fonts_url() {
    $fonts_url = '';

    /*
    * translators: If there are characters in your language that are not supported
    * by Lato, translate this to 'off'. Do not translate into your own language.
    */
    $lato = _x( 'on', 'Lato font: on or off', 'wedding-band' );

    if ( 'off' !== $lato ) {
        $font_families = array();

        $font_families[] = 'Lato:400,700,900';

        $query_args = array(
            'family'  => urlencode( implode( '|', $font_families ) ),
            'display' => urlencode( 'fallback' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url( $fonts_url );
}
endif;