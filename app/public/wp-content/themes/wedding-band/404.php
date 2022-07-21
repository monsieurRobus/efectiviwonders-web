<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Wedding_Band
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            
            <div class="not-found">
				<h1><?php esc_html_e( '404', 'wedding-band' ); ?></h1>
				<h2><?php esc_html_e( 'Sorry!','wedding-band' ); ?></h2>
				<p><?php esc_html_e( 'The Page you are looking for does not exist.', 'wedding-band' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home page','wedding-band' ); ?></a>
                <a href="javascript:history.back(1);"><?php esc_html_e( 'Previous page','wedding-band' ); ?></a>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
