<?php get_header(); ?>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="post-header">
					<div class="tags"><?php the_tags( __( '<span>Tags</span> <p>', 'titan' ), ', ', '</p>' ); ?></div>
					<h1><?php the_title(); ?></h1>
					<div class="author"><?php printf( __( 'by %1$s on %2$s', 'titan' ), get_the_author(), get_the_time( get_option( 'date_format' ) ) ); ?></div>
				</div><!--end post header-->
				<div class="entry clear">
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail( array(250,9999), array( 'class' => ' alignleft border' ) );
					} ?>
					<?php the_content( __( 'read more...', 'titan' ) ); ?>
					<?php edit_post_link( __( 'Edit this', 'titan' ), '<p style="clear:both">', '</p>' ); ?>
					<?php wp_link_pages(); ?>
				</div><!--end entry-->
				<div class="meta clear">
					<p><?php printf( __( 'From &rarr; %s', 'titan' ), get_the_category_list( ', ' ) ); ?></p>
				</div><!--end meta-->
			</div><!--end post-->
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		<?php comments_template( '', true ); ?>
	<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>