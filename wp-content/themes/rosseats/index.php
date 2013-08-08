<?php get_header(); ?>
    <?php if ( is_home() ) {
        query_posts($query_string . "&posts_per_page=3&tag__not_in=" . MINI_TAG_ID);
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
	<?php if ( is_home() ) {
        query_posts($query_string . '&posts_per_page=3&tag=mini');
        }
    ?>
    <?php if ( have_posts() ) : ?>
    	<div id="minis">
    		<h2>Mini reviews</h2>
    		<p>Bite sized reviews - for either when the experience was too short to fully judge or for when I don't have the most time to get words down in internet.</p>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php $details = get_post_custom($post->ID); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="post-header">
					<h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr( sprintf( __( 'Permanent Link to %s', 'titan' ), the_title_attribute( 'echo=false' ) ) ); ?>"><?php the_title(); ?></a></h3>
					<?php if (count($details['Restaurant URL'])) {
     	    			echo '<a href="' . $details['Restaurant URL'][0] . '" class="url">' . $details['Restaurant URL'][0]  . '</a>';
     				} ?>
					<div><?php the_time(__( 'F jS, Y', 'titan' )); ?></div>
					<div class="author"><?php printf( __( 'by %s', 'titan' ), get_the_author() ); ?></div>
				</div><!--end post header-->
				<div class="entry clear">
					<figure><div class="frame">
					<?php 
 		        		the_post_thumbnail(array(240,240)); 
 			    		$attachment = getImageAttachmentData(get_the_ID());
		        		echo '</div><figcaption>' . $attachment->description . '</figcaption>';
		    		?>
		    		</figure>
					<?php the_content( __( '', 'titan' ) ); ?>        			 
					<?php wp_link_pages(); ?>
				</div><!--end entry-->
				<div class="post-footer">
					<div class="comments"><?php comments_popup_link( __( 'Leave a Comment', 'titan' ), __( '1 Comment', 'titan' ), __( '% Comments', 'titan' ) ); ?></div>
				</div><!--end post footer-->
			</div><!--end post-->
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
		</div>
	<?php endif; ?>
	<?php wp_reset_query(); /* #9 on github - screwy homepage title */ ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>