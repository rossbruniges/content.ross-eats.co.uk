<?php if ( post_password_required() ) : ?>
	<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'titan' ); ?></p>
	<?php 
	return; 
endif; ?>

<div id="comments">
<?php if ( have_comments() ) : ?>
	<div class="comment-number">
		<span><?php comments_number( __( 'Leave a comment', 'titan' ), __( 'One Comment', 'titan' ), __( '% Comments', 'titan' )); ?></span>
		<?php if ( comments_open() ) : ?>
			<a id="leavecomment" href="#respond" title="<?php esc_attr_e( 'Leave one &rarr;', 'titan' ); ?>"><?php _e( 'Leave one &rarr;', 'titan' ); ?></a>
		<?php endif; ?>
	</div><!--end comment-number-->

	<ol class="commentlist">
		<?php wp_list_comments( 'type=comment&callback=titan_custom_comment' ); ?>
	</ol>

	<div class="navigation clear">
		<div class="alignleft"><?php next_comments_link(__( '&laquo; Older Comments', 'titan' )); ?></div>
		<div class="alignright"><?php previous_comments_link(__( 'Newer Comments &raquo;', 'titan' )); ?></div>
	</div>
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
		<h3 class="pinghead"><?php _e( 'Trackbacks and Pingbacks', 'titan' ); ?></h3>
		<ol class="pinglist">
			<?php wp_list_comments( 'type=pings&callback=titan_list_pings' ); ?>
		</ol>

		<div class="navigation clear">
			<div class="alignleft"><?php next_comments_link(__( '&laquo; Older Pingbacks', 'titan' )); ?></div>
			<div class="alignright"><?php previous_comments_link(__( 'Newer Pingbacks &raquo;', 'titan' )); ?></div>
		</div>
	<?php endif; ?>
	<?php if ( ! comments_open() ) : ?>
		<p class="note"><?php _e( 'Comments are closed.', 'titan' ); ?></p>
	<?php endif; ?>
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->
		<div class="comment-number">
			<span><?php _e( 'No comments yet', 'titan' ); ?></span>
		</div>
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<?php if ( ! is_page() ) : ?>
			<p class="note"><?php _e( 'Comments are closed.', 'titan' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
</div><!--end comments-->

<?php

$req = get_option( 'require_name_email' );
$field = '<fieldset><label for="%1$s" class="comment-field"><small>%2$s</small></label><input class="text-input" type="text" name="%1$s" id="%1$s" value="%3$s" size="22" tabindex="%4$d" /></fieldset>';
comment_form( array(
	'comment_field' => '<p><label for="comment" class="comment-field"><small>' . _x( 'Comment', 'noun', 'titan' ) . '</small></label><textarea id="comment" name="comment" cols="50" rows="10" aria-required="true" tabindex="4"></textarea></p>',
	'comment_notes_before' => '',
	'comment_notes_after' => sprintf(
		'<p class="guidelines">%3$s</p>' . "\n" . '<p class="comments-rss"><a href="%1$s">%2$s</a></p>',
		esc_attr( get_post_comments_feed_link() ),
		__( 'Subscribe to this comment feed via RSS', 'titan' ),
		__( '<strong>Note:</strong> HTML is allowed. Your email address will not be published.', 'titan' )
	),
	'fields' => array(
		'author' => sprintf(
			$field,
			'author',
			(
				$req ?
				__( 'Name <span>(required)</span>', 'titan' ) :
				__( 'Name', 'titan' )
			),
			esc_attr( $comment_author ),
			1
		),
		'email' => sprintf(
			$field,
			'email',
			(
				$req ?
				__( 'Email <span>(required, will not be published)</span>', 'titan' ) :
				__( 'Email', 'titan' )
			),
			esc_attr( $comment_author_email ),
			2
		),
		'url' => sprintf(
			$field,
			'url',
			__( 'Website', 'titan' ),
			esc_attr( $comment_author_url ),
			3
		),
	),
	'label_submit' => __( 'Submit Comment', 'titan' ),
	'logged_in_as' => '<p>' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'titan' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
	'title_reply' => __( 'Leave a Reply', 'titan' ),
	'title_reply_to' => __( 'Leave a comment to %s', 'titan' ),
) );