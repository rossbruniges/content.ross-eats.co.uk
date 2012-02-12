<?php get_header(); ?>
<div class="content-background">
	<div class="wrapper">
		<div class="notice"></div>
		<div id="content">
 	<?php if (have_posts()) : ?>
 	<?php while (have_posts()) : the_post(); ?>
 		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 			<div class="post-header">
 				<div class="tags"><?php the_tags( '<span>Tags</span> <p>', ', ', '</p>'); ?></div>
 				<h1><?php the_title(); ?></h1>
 				<div class="author"><?php printf(__ ( 'by %s on', 'titan'), get_the_author()); ?> <?php the_time(__ ( 'F jS, Y', 'titan')); ?></div>
 			</div><!--end post header-->
 			<div class="entry clear">
 				<?php the_content(__( 'read more...', 'titan')); ?>
 				<?php
        if (function_exists('tweet_button'))
           tweet_button(get_permalink());
        ?>
 				<?php edit_post_link(__( 'Edit', 'titan')); ?>
 				<?php wp_link_pages(); ?>
 			</div><!--end entry-->
 			<div class="meta clear">
 				<p><?php _e( 'From', 'titan' ); ?> &rarr; <?php the_category( ', '); ?></p>
 			</div><!--end meta-->
 		</div><!--end post-->
 	<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
 		<?php comments_template( '', true); ?>
 	<?php else : ?>
 	<?php endif; ?>
 </div><!--end content-->
 <?php get_sidebar(); ?>
 <?php get_footer(); ?>