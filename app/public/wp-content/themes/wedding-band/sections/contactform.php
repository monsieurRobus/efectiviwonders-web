<?php  
/**
 * Contact Section
 * 
 * @package Wedding Band
 */ 
    $contact_title   = get_theme_mod( 'wedding_band_contactform_section_title' );
    $description     = get_theme_mod( 'wedding_band_contactform_section_description' );
    $contact_address = get_theme_mod( 'wedding_band_contactform_section_address' );
    $contact_email   = get_theme_mod( 'wedding_band_contactform_section_email' );
    $contact_phone   = get_theme_mod( 'wedding_band_contactform_section_phone_number' );
    $contact_form    = get_theme_mod( 'wedding_band_contact_form' );
	?>  
    <section class="contact-section">
		<div class="container">
			<?php 
			wedding_band_get_section_header( $contact_title, $description );
			 
			if( $contact_address || $contact_email || $contact_phone ){ ?>
				<div class="row">
					
					<?php 
					if( $contact_address ){ ?>
						<div class="col">
							<div class="text">
								<div class="table">
									<div class="table-row">
										<span class="address">
										   <i class="fa fa-map-marker" aria-hidden="true"></i>
                                           <?php echo esc_html( $contact_address ); ?>
                                        </span>
									</div>
								</div>
							</div>
						</div>
					<?php 
				    } 

					if( $contact_email ){ ?>
						<div class="col">
							<div class="text">
								<div class="table">
									<div class="table-row">
										<span class="mail">
											<i class="fa fa-envelope" aria-hidden="true"></i>
	                                        <a href="<?php echo esc_url( 'mailto:' . sanitize_email( $contact_email ) ); ?>"><?php echo esc_html( $contact_email ); ?></a>
                                        </span>
									</div>
								</div>
							</div>
						</div>
					<?php 
					} 

					if( $contact_phone ){ ?>
						<div class="col">
							<div class="text">
								<div class="table">
									<div class="table-row">
										<span class="phone">
										    <i class="fa fa-phone" aria-hidden="true"></i>
                                            <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $contact_phone ) ); ?>"><?php echo esc_html( $contact_phone ); ?></a>
                                        </span>
									</div>
								</div>
							</div>
						</div>
					<?php 
					} ?>

				</div>
			<?php 
		    } 
			
			if ( class_exists( 'wpcf7' ) ) {
				if( $contact_form ){ ?>
					<div class="form-section">
						<?php 
							if( has_shortcode( $contact_form , 'contact-form-7' ) ){
								echo do_shortcode( $contact_form );
							} 
						?>
					</div>
				<?php 
				} 
			} ?>
	    </div>
	</section>
	