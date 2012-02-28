<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
            if (in_category('Reviews')) {
                include 'singles/review.php';
            } elseif (in_category('London Burritos')) {
                include 'singles/burrito.php';
            } else {
                include 'singles/normal.php';
            }
        ?>
    <?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
	<?php comments_template( '', true); ?>
<?php endif; ?>
</div><!--end content-->
<?php
    if (!in_category('Reviews') && !in_category('London Burritos')) {
        get_sidebar(); 
    }
?>    
<?php get_footer(); ?>