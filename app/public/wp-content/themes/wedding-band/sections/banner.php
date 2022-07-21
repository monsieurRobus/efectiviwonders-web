<?php 
/**
 * Slider Section
 * 
 * @package Wedding Band
*/ 
    $slider_caption  = get_theme_mod( 'wedding_band_slider_caption', '1' );
    $slider_readmore = get_theme_mod( 'wedding_band_slider_readmore', __( 'View More', 'wedding-band' ) );
    $slider_cat      = get_theme_mod( 'wedding_band_slider_cat' );
    
    if( $slider_cat ){
        $qry = new WP_Query ( array( 
            'post_type'     => 'post', 
            'post_status'   => 'publish',
            'posts_per_page'=> -1,                    
            'cat'           => $slider_cat,
            'order'         => 'ASC'
        ) );
        
        if( $qry->have_posts() ){?>
            <div class="slider">
                    <div class="owl-carousel owl-theme banner-slider">
                        <?php
                        while( $qry->have_posts() ){
                            $qry->the_post();
                            
                            if( has_post_thumbnail() ){ ?>
                                <div class="item"> 
                                    <?php 
                                    the_post_thumbnail('wedding-band-banner-thumb');
                                    if( $slider_caption ){ ?>
                                        <div class="banner-text">
                                            <div class="container">
                                                <div class="text">
                                                    <h2><?php the_title(); ?></h2>
                                                    <?php the_excerpt(); ?>
                                                    <a class="view-more" href="<?php the_permalink(); ?>"><?php echo esc_html( $slider_readmore );?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php 
                                    } ?>
                                </div>
                            <?php 
                            } 
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
            </div>
            <?php 
            } 
            
        }