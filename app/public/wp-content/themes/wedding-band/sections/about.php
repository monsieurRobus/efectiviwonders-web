<?php 
/**
 * About Section
 * 
 * @package Wedding Band
*/  
    $about_post  = get_theme_mod( 'wedding_band_about_post' );
    $read_more   = get_theme_mod( 'wedding_band_about_readmore' , __( 'Read More', 'wedding-band' ) );

?>
    <section class="section-1">
        <?php 
        if( $about_post ){
            $about_query = new WP_Query( array( 'post_type' => 'page', 'p' => $about_post ));
	        if( $about_query->have_posts() ){ 
				while( $about_query->have_posts() ){ 
					$about_query->the_post(); ?>
					
					<div class="container">
						<div class="row">
							<div class="column-1">
								<?php 
								if( has_post_thumbnail() ){  
									the_post_thumbnail( 'wedding-band-about-thumb' ); 
								}else{
									wedding_band_get_fallback_svg( 'wedding-band-about-thumb' );
								} ?>
							</div>

							<div class="column-2">
								<div class="text">
									<h2><?php the_title(); ?></h2>
									<?php  the_excerpt();
									?>
									<a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html( $read_more ); ?></a>
								</div>
							</div>

						</div>
					</div>
					<?php 
				}
				wp_reset_postdata(); 
			}
	    } ?>
    </section>
