<?php
/*
Template Name: Reviews in

Takes a final part of the URL and searches for tags of the same,
then displays them in a lovely ordered list
*/
?>
<?php get_header(); ?>
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<?php
        	$page_slug = $post->post_name;
        	if ($page_slug == "in") {
				echo "<h1 class='pagetitle'>Ross eats in</h1>";
			} elseif ($page_slug == "everywhere") {
				echo "<h1 class='pagetitle'>Ross eats everywhere</h1>";
			} else {
				echo "<h1 class='pagetitle'>Ross eats in " . get_the_title() ."</h1>";
			}
		?>
		<div class="entry page clear">
			<?php the_content(); ?>
            <ol class="review_list">
            	<?php
            		for ($i=10; $i > 0; $i--) {
            			if ($page_slug == "in") {
            				$rated_list = new WP_Query(array(
				    			'category_name' => 'reviews',
				    			'posts_per_page' => -1,
				    			'orderby' => 'date',
				    			'order' => 'DESC',
				    			'meta_key' => 'Restaurant rating',
				    			'meta_value' => $i,
				    			'year' => date('Y')));

            			} elseif ($page_slug == "everywhere") {
            				$rated_list = new WP_Query(array(
				    			'category_name' => 'reviews',
				    			'posts_per_page' => -1,
				    			'orderby' => 'date',
				    			'order' => 'DESC',
				    			'meta_key' => 'Restaurant rating',
				    			'meta_value' => $i));
            			} else {
            				$rated_list = new WP_Query(array(
				    			'category_name' => 'reviews',
				    			'posts_per_page' => -1,
				    			'orderby' => 'date',
				    			'order' => 'DESC',
				    			'meta_key' => 'Restaurant rating',
				    			'meta_value' => $i,
				    			'tag' => $page_slug));
            			}
            			if ($rated_list->have_posts()) {
            				echo '<li><h2>Rated ' . $i . ' <span>(out of 10)</span></h2><ul>';
            				while ($rated_list->have_posts()) : $rated_list->the_post();
			        			$review_details = get_post_custom($post->ID);
			        	?>
			        		<li class="vcard">
			        <h3 class="fn"><?php echo str_replace('reviewed', '', get_the_title()); ?></h3>
			        <div class="summary">
			            
			            
			            <p><?php echo $review_details['Restaurant cost'][0]; ?></p>
			            <a href="<?php echo get_permalink(); ?>">Read my review <?php the_post_thumbnail(array(80,810)) ?></a>
			            </div>
			            <div class="adr">
                 		    <?php echo $review_details['Restaurant address'][0]; ?>
                 		</div>
                        <p class="date">Reviewed on <?php the_time(__ ( 'F jS, Y', 'titan')); ?></p>
                 		<?php if (count($review_details['post_alert'])) : ?>
                        <div class="alert">
                            <?php echo $review_details['post_alert'][0]; ?>
                        </div>
                        <?php endif; ?>
                        
			        </li>
			        	<?php endwhile; ?>
			        		</ul></lu>
			        	<?php
			        	}
            		}
            	?>
            </ol>
            <?php wp_reset_postdata(); ?>
			<?php edit_post_link(__( 'Edit', 'titan')); ?>
			<?php wp_link_pages(); ?>
		</div><!--end entry-->
	<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
	<?php comments_template( '', true); ?>
	<?php else : ?>
	<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
