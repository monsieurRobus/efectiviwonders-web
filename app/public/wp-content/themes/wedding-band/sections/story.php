<?php
/**
 * Story Section
 * 
 * @package Wedding Band
*/  

$story_post = get_theme_mod('wedding_band_story_post');

if( $story_post ){       
	$story_query = new WP_Query( array( 'p' => $story_post) );
	if( $story_query->have_posts() ){ 
		while( $story_query->have_posts() ){
			$story_query->the_post();?>		
			<div class="section-4">
				<div class="container">
					<div class="content">
						<div class="text-holder">
							<div class="text">
								<h3><?php the_title(); ?></h3>
								<?php the_content();
								?>
							</div>
						</div>
						<div class="image">
							<?php 
							if( has_post_thumbnail() ){
								the_post_thumbnail( 'wedding-band-story-thumb' );
							}else{
								wedding_band_get_fallback_svg( 'wedding-band-story-thumb' );
							} ?>
						</div>
					</div>
				</div>
			</div>
			
		<?php
		}
		wp_reset_postdata();
	}	     
}