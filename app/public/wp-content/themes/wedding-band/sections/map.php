<?php 
/**
 * Map Section
 * 
 * @package Wedding Band
*/ 
    if( is_active_sidebar( 'google-map' ) ):
	    echo '<div class="map-section">';
            echo '<div class="map">';
                dynamic_sidebar( 'google-map' );
            echo '</div>';
        echo '</div>';
    endif;