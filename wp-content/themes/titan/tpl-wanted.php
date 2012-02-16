<?php
/*
Template Name: Most wanted
*/
?>
<?php get_header(); ?>
<div class="content-background">
	<div class="wrapper">
		<div class="notice"></div>
		<div id="content">
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<h1 class="pagetitle"><?php the_title(); ?></h1>
		<div class="entry page clear">
			<?php the_content(); ?>
			<ul id="most-wanted">
			<?php 
			$hot = get_bookmarks(array(
				'category_name' => 'Wishlist',
				'orderby' => 'Name'
			));
			foreach($hot as $item) {
			    echo "<li class='vcard'><a class='fn org url' href='{$item->link_url}'>{$item->link_name}</a>";
			    if ($item->link_description !== "") {
			        echo "<p>{$item->link_description}</p>";
			    } 
			    echo "</li>";
			}
			?>
			</ul>
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
