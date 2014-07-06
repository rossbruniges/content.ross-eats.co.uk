<?php
/*
Template Name: London burritos
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
		<h1 class="pagetitle"><?php the_title(); ?></h1>
		<div class="entry page clear">
			<?php the_content(); ?>
			<h2>Results</h2>
			<ol class="quest_list">
			<?php
			    // create a wordpress loop that will be used to hold the burrito posts
			    $burrito_list = new WP_Query('category_name=london-burritos&posts_per_page=-1&meta_key=burrito_rank&orderby=meta_value_num&order=ASC');
			    $burrito_count = 0;
			    while ($burrito_list->have_posts()) : $burrito_list->the_post();
			        $burrito_count++;
			        $burrito_details = get_post_custom($post->ID);
			        $burrito_url = $burrito_details['burrito_url'][0] ? $burrito_details['burrito_url'][0] : $burrito_details['URL'][0];
				    $burrito_price = $burrito_details['burrito_price'][0] ? $burrito_details['burrito_price'][0] : $burrito_details['Price'][0];
				    $burrito_phone = $burrito_details['burrito_phone'][0] ? $burrito_details['burrito_phone'][0] : $burrito_details['Phone'][0];
				    $burrito_street = $burrito_details['burrito_street'][0] ? $burrito_details['burrito_street'][0] : $burrito_details['Street'][0];
				    $burrito_postcode = $burrito_details['burrito_postcode'][0] ? $burrito_details['burrito_postcode'][0] : $burrito_details['Postcode'][0];
				    $burrito_urbanspoon = $burrito_details['burrito_urbanspoon'][0] ? $burrito_details['burrito_urbanspoon'][0] : $burrito_details['urbanspoon'][0];
				    $burrito_squaremeal = $burrito_details['burrito_squaremeal'][0] ? $burrito_details['burrito_squaremeal'][0] : $burrito_details['squaremeal'][0];
			?>
			    <li class="vcard">
			        <strong class="rank"><span>#</span><?php echo $burrito_count; ?></strong>
			        <h3 class="fn org"><?php echo get_the_title(); ?></h3>
			        <p class="adr">
			        	<span class="street-address"><?php echo $burrito_street; ?></span>, 
			        	<span class="region">London</span> 
			        	<span class="postal-code"><?php echo $burrito_postcode; ?></span>
			        </p>
			        <p>
			        <?php
			            if ($burrito_phone != "") {
			                echo "<span class='tel'>" . $burrito_phone . "</span>";
			            }
			            if ($burrito_phone != "" && $burrito_url != "") {
			                echo " and  ";
			            }
 			            if ($burrito_url != "") {
 			                echo "<a class='url' href='http://" . $burrito_url . "'>" . $burrito_url . "</a>";
 			            }
 			        ?>
			        </p>
                    <p><strong>Cost</strong>: <?php echo $burrito_price; ?></p>
                    <?php the_content(); ?>
			    </li>
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