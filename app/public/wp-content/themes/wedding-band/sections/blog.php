<?php 
/**
 * Blog Section
 * 
 * @package Wedding Band
 */ 
    $btitle      = get_theme_mod('wedding_band_blog_section_title');
    $description = get_theme_mod( 'wedding_band_blog_section_description' );
  
    ?>
    <section class="blog-section">
       <?php 
		    $qry = new WP_Query ( array( 
		        'post_type'     => 'post', 
		        'post_status'   => 'publish',
		        'posts_per_page'=> 3,                    

		    ) );
	        
		    if( $qry->have_posts() ){ ?>

			    <div class="container">
					<?php 
					wedding_band_get_section_header( $btitle, $description );
					?>

					<div class="row">
						<?php
						while( $qry->have_posts()): $qry->the_post(); ?>
							<div class="col">
								<article class="post">									
								    <a href="<?php the_permalink(); ?>"class="post-thumbnail">
										<?php
										if( has_post_thumbnail() ){ 
										    the_post_thumbnail( 'wedding-band-home-blog-thumb' ); 
							            }else{
							            	wedding_band_get_fallback_svg( 'wedding-band-home-blog-thumb' );
							            } ?>
								    </a>
									<header class="entry-header">
										<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<div class="entry-meta">
											<span class="byline"><i class="fa fa-pencil"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
										    <span class="posted-on"><i class="fa fa-calendar-o"></i><a href="<?php echo  esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_date() ); ?></a></span>
										</div>
									</header>

									<div class="entry-content">
										<?php the_excerpt(); ?>
									</div>

									<div class="entry-footer">
										<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More','wedding-band');?></a>
									</div>

								</article>
							</div>
						<?php 
						endwhile; 
						wp_reset_postdata();?>
					</div>
				</div>
			<?php 
		    }
			  ?>
	</section>