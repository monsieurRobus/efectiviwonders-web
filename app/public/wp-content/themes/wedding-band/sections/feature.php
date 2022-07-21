<?php 
/**
 * Feature Post Section
 * 
 * @package Wedding Band
 */   
    $feature_title = get_theme_mod('wedding_band_feature_section_title');
    $description   = get_theme_mod('wedding_band_feature_section_description');
    $feature_cat   = get_theme_mod('wedding_band_feature_cat');
  	?> 
    <section class="section-3">
		<div class="container">
			<?php 
			wedding_band_get_section_header( $feature_title, $description );

            if( $feature_cat ){
		        $qry = new WP_Query ( array( 
		            'post_type'     => 'post', 
		            'posts_per_page'=> -1,                    
		            'cat'           => $feature_cat,
		            'order'         => 'ASC'
		        ) );
        
                if( $qry->have_posts() ){ ?>
				    <ul id="lightSlider">
						<?php 
						while( $qry->have_posts() ): $qry->the_post(); 
							if( has_post_thumbnail() ){ ?>
						        <li>
							        <div class="image-holder">
										<?php the_post_thumbnail('wedding-band-feature-thumb'); ?>
										<div class="text">
											<h3><?php the_title(); ?></h3>
										</div>
										<div class="caption-image">												
											<?php the_post_thumbnail('wedding-band-feature-caption-thumb'); ?>
										</div>
										<div class="description">
											<div class="image">
												<?php the_post_thumbnail('wedding-band-feature-small-thumb'); ?>
												<div class="text">
													<h3><?php the_title(); ?></h3>
												</div>
											</div>
											<div class="content">
												<?php the_excerpt(); ?>
												<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More','wedding-band');?></a>
											</div>
										</div>
									</div>
						        </li>
					    	<?php }
						endwhile; 
						wp_reset_postdata();?>
				    </ul>
			    <?php 
			    } 
			     
			}  ?>
		</div>
	</section>
		