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
		<h1 class="pagetitle"><?php the_title(); ?></h1>
		<div class="entry page clear">
			<?php the_content(); ?>
			<?php
                $page_slug = $post->post_name;
            ?>
			<ol class="review_list">
			<?php
			    // create a wordpress loop that will be used to hold reviews
			    $review_list = new WP_Query('category_name=reviews&posts_per_page=-1&meta_key=Restaurant rating&orderby=meta_value_num&order=DESC&tag=' . $page_slug);
			    $current_rating = 0;
			    while ($review_list->have_posts()) : $review_list->the_post();
			        $review_details = get_post_custom($post->ID);
			?>
			    <?php
			        if ($current_rating != $review_details['Restaurant rating'][0]) {
			            if ($current_rating != 0) {
			                echo "</ul></li>";
			            }
			            echo "<li>";
			            echo "<h2>Rated " . $review_details['Restaurant rating'][0] . " <span>(out of 10)</span></h2><ul>";
			        } 
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
			    <?php
			        
			        $current_rating = $review_details['Restaurant rating'][0];
			    ?>
            <?php endwhile; ?>
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
