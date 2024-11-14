<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sanas
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
<div id="comments" class="comments-area blog-comments comments">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h3 class="blog-main-hedaing">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'weddlist' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h3>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'weddlist' ); ?></h2>
			<div class="nav-links">
				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'weddlist' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'weddlist' ) ); ?></div>
			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>
		<div class="comment-list listnone pb30">
			<?php
				wp_list_comments( array(
					'style'      	=> 'div',
					'callback' 		=> 'weddlist_shape_comment',
					'avatar_size' 	=> 100
				) );
			?>
		</div><!-- .comment-list -->        
		<?php 
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'weddlist' ); ?></p>
		<?php
		endif;
	endif; // Check for have_comments().
?>
    <div class="leave-reply-block">
    <?php
    /**    Comment form.*/
    $comment_form = array(
        'title_reply' => esc_html__('Leave Comment', 'weddlist'),
        'title_reply_to' => esc_html__('Leave Reply to %s', 'weddlist'),
        'comment_notes_before' => '',
        'fields' => array(
            'author' => '<div class="row"><div class="col-sm-6 col-12"><div class="form-group"><input type="text" name="name" class="form-control" placeholder="'.esc_attr__('Name', 'sanas').'"></div></div>',
            'email' => '' .
            '<div class="col-sm-6 col-12"><div class="form-group"><input type="email" name="email" placeholder="'.esc_attr__('Email', 'sanas').'" class="form-control"></div></div></div>',
        ),
        'label_submit' => esc_html__('Comment', 'weddlist'),
        'class_submit' => 'btn btn-secondary',
        'logged_in_as' => '',
        'comment_field' => '',
        'comment_notes_after' => '',
        'class_form'=>'reply-form',
        'label_submit' => esc_attr__('Post Comment', 'weddlist'),
            )
    ;
    $comment_form['comment_field'].='<div class="form-group">
        <textarea name="comment" rows="3" class="comments-area form-control" placeholder="'.esc_attr__('Your Comment', 'sanas').'"></textarea></div>';	
        comment_form($comment_form);
        ?>
    </div>
</div><!-- #comments -->