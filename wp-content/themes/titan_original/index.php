<?php get_header(); ?>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="post-header">
					<div class="date"><?php the_time(__( 'M j', 'titan' )); ?> <span><?php the_time( 'y' ); ?></span></div>
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr( sprintf( __( 'Permanent Link to %s', 'titan' ), the_title_attribute( 'echo=false' ) ) ); ?>"><?php the_title(); ?></a></h2>
					<div class="author"><?php printf( __( 'by %s', 'titan' ), get_the_author() ); ?></div>
				</div><!--end post header-->
				<div class="entry clear">
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail( array(250,9999), array( 'class' => ' alignleft border' ) );
					} ?>
					<?php the_content( __( 'read more...', 'titan' ) ); ?>
					<?php edit_post_link( __( 'Edit this', 'titan' ), '<p>', '</p>' ); ?>
					<?php wp_link_pages(); ?>
				</div><!--end entry-->
				<div class="post-footer">
					<div class="comments"><?php comments_popup_link( __( 'Leave a Comment', 'titan' ), __( '1 Comment', 'titan' ), __( '% Comments', 'titan' ) ); ?></div>
				</div><!--end post footer-->
			</div><!--end post-->
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		<div class="navigation index">
			<div class="alignleft"><?php next_posts_link( __( '&laquo; Older Entries', 'titan' ) ); ?></div>
			<div class="alignright"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'titan' ) ); ?></div>
		</div><!--end navigation-->
	<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>