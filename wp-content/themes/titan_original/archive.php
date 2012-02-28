<?php get_header(); ?>
	<?php if ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
			<h1 class="pagetitle"><?php printf(__( 'Posts from the  &#8216;%s&#8217; Category', 'titan' ), single_cat_title('', false)); ?></h1>
		<?php /* If this is a tag archive */ } elseif ( is_tag() ) { ?>
			<h1 class="pagetitle"><?php printf(__( 'Posts tagged &#8216;%s&#8217;', 'titan' ), single_tag_title('', false)); ?></h1>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h1 class="pagetitle"><?php printf( __( 'Archive for %s', 'titan' ), get_the_time(  'F jS, Y', 'titan' ) ); ?></h1>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h1 class="pagetitle"><?php printf( __( 'Archive for %s', 'titan' ), get_the_time(  'F, Y', 'titan' ) ); ?></h1>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h1 class="pagetitle"><?php printf( __( 'Archive for %s', 'titan' ), get_the_time(  'Y', 'titan' ) ); ?></h1>
		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h1 class="pagetitle"><?php printf(__( 'Posts by %s', 'titan' ), get_the_author() ); ?></h1>
		<?php /* If this is a paged archive */ } elseif ( is_paged() ) { ?>
			<h1 class="pagetitle"><?php _e( 'Blog Archives', 'titan' ); ?></h1>
		<?php } ?>
		<?php rewind_posts(); ?>
		<div class="entries">
			<ul>
				<?php while (have_posts()) : the_post(); ?>
					<li><span><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( __('Permanent Link to %s', 'titan' ), the_title_attribute('echo=0') ); ?>"><?php printf( __( '%s on', 'titan' ), get_the_title() ); ?></a> <?php the_time( get_option( 'date_format' ) ); ?></span></li>
				<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
			</ul>
		</div><!--end entries-->
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link( __( '&laquo; Older Entries', 'titan' ) ); ?></div>
			<div class="alignright"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'titan' ) ); ?></div>
		</div><!--end navigation-->
	<?php endif; ?>
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>