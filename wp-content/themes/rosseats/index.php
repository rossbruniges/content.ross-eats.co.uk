<?php get_header(); ?>
    <?php if ( is_home() ) {
        query_posts($query_string . '&posts_per_page=3');
        }
    ?>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="post-header">
					<div class="date">
					    <?php the_time(__( 'M j', 'titan' )); ?>
					    <span><?php the_time( 'y' ); ?></span>
					    <span class="category">in <?php the_category(',') ?></span>
					</div>
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr( sprintf( __( 'Permanent Link to %s', 'titan' ), the_title_attribute( 'echo=false' ) ) ); ?>"><?php the_title(); ?></a></h2>
					<div class="author"><?php printf( __( 'by %s', 'titan' ), get_the_author() ); ?></div>
				</div><!--end post header-->
				<div class="entry clear">
					<?php the_content( __( 'read more...', 'titan' ) ); ?>
					<?php
        			    if (in_category("London Burritos")) {
        			        echo "<p class='cta alert'>But how does it rank in my list of <a href='http://www.ross-eats.co.uk/londons-best-burrito/'>London's best burrito</a>?</p>";
        			    }
        			?>
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