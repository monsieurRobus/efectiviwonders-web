<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wedding_Band
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>



	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
	<div id="comments" class="comments-area">
		<h2 class="comments-title">
			<?php printf( // WPCS: XSS OK.
		          esc_html( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'wedding-band' ) ),
		          number_format_i18n( get_comments_number() )
		        );
			?>
		</h2>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
          			'avatar_size'=> 80,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'wedding-band' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'wedding-band' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'wedding-band' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.
		?>
		</div><!-- #comments -->
		<?php 
	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<div id="comments" class="comments-area">
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wedding-band' ); ?></p>
	</div><!-- #comments -->
	<?php
	endif;
	?>



<div class="comment-form">
	<div class="comments-area form">
	    <?php
	    /**
	     * @link https://codex.wordpress.org/Function_Reference/comment_form
	    */        
	    comment_form(); 
	    ?>
	</div>
</div>
