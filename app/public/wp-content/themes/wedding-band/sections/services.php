<?php 
/**
 * Services Section
 * 
 * @package Wedding Band
*/  
    $service_title = get_theme_mod( 'wedding_band_service_section_title' );
    $description   = get_theme_mod( 'wedding_band_service_section_description' );
    $post_one      = get_theme_mod( 'wedding_band_service_post_one' );
    $post_two      = get_theme_mod( 'wedding_band_service_post_two' );
    $post_three    = get_theme_mod( 'wedding_band_service_post_three' );
    $post_four     = get_theme_mod( 'wedding_band_service_post_four' );

    $service_post = array( $post_one, $post_two, $post_three, $post_four );
    $service_post = array_diff( array_unique( $service_post ), array('') );

    ?>
    <section class="section-2">
	    <div class="container">
			<?php 
			wedding_band_get_section_header( $service_title, $description );

            $service_qry = new WP_Query(array(
                'post__in' => $service_post,
                'orderby'  => 'post__in',
                'ignore_sticky_posts' => true,
            ));

			if( $service_post && $service_qry->have_posts() ){ ?>
				<div class="row">
					<?php 
					while( $service_qry->have_posts() ): 
					    $service_qry->the_post();
					    
					    $image = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
						
						<div class="col">
	                        <?php 
	                        if ( has_post_thumbnail() ) {
	                        	the_post_thumbnail( 'thumbnail' );
	                        }else{
	                        	wedding_band_get_fallback_svg( 'thumbnail' );
	                        }
	                        ?>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	   					    <?php the_excerpt(); ?>
						</div>
					
					<?php 
					endwhile; 
					wp_reset_postdata();?>	
				</div>
			<?php 
		    } 
			 ?>
		</div>
	</section>
