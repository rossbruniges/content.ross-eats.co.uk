<?php get_header(); ?>
<div class="content-background">
	<div class="wrapper">
		<div class="notice"></div>
		<div id="content">
	<h1 class="pagetitle"><?php _e( 'Opps, there is nothing here', 'titan' ); ?></h1>
	<div class="entry page">
		<div class="photo_frame">
	    <img src="<?php bloginfo( 'stylesheet_directory'); ?>/images/sad-cheerios.jpg" width="500" height="400" alt="sad looking cheerios" />
		Sad cheerios found at <a href="http://www.guttermagazine.com/blog/columns/honeys-pot/77-honeys-pot/1343-fuck-food-nostalgia">http://www.guttermagazine.com/</a>
		</div>
		<p>You came here expecting to read something food related but the link you've used to get here just didn't work.</p>
		<p>Please use the searchbox below to check the content you were expecting really does exist; failing that you might want to read one of my more popular articles found in the sidebar.</p>
		<?php if (is_file(STYLESHEETPATH . '/searchform.php')) include (STYLESHEETPATH . '/searchform.php'); else include(TEMPLATEPATH . '/searchform.php'); ?>
	</div><!--end entry-->
</div><!--end content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>