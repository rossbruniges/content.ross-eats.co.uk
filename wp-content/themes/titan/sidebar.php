<?php global $titan; ?>
<div id="sidebar">
	<?php if ($titan->sideboxState() != 'true' ){ ?>
		<div id="sidebox">
			<?php if (is_home() == 'true' ): ?>
			  <?php
				$last_post = get_posts($numberposts=1&$orderby=date&$order=ASC);
		    echo get_the_post_thumbnail($last_post[0]->ID, array(236,236));
		    $attachment = getImageAttachmentData($last_post[0]->ID);
		    echo '<p>' . $attachment->description . ' from ' . $attachment->title . '</p>';
		    ?>
			<?php else : ?>
				<?php the_post_thumbnail(array(236,236)) ?>
				<?php
     			  $attachment = getImageAttachmentData(get_the_ID());
    		      echo '<p>' . $attachment->description . '</p>';
    		     ?>
			<?php endif; ?>
			
		</div><!--end sidebox-->
	<?php } ?>
	<?php if ($titan->adboxState() == 'true' ){ ?>
		<div id="adbox" class="clear">
			<a href="<?php if ($titan->adboxUrl1() != '' )echo $titan->adboxUrl1(); else echo "#"; ?>"><img class="alignleft" src="<?php bloginfo( 'stylesheet_directory'); ?>/images/sidebar/<?php if ($titan->adboxImage1() != '' )echo $titan->adboxImage1(); else echo "125_ad_1.gif"; ?>" width="125" height="125" alt="<?php if ($titan->adboxAlt1() != '' )echo $titan->adboxAlt1(); else echo bloginfo( 'name'); ?>" /></a>
			<a href="<?php if ($titan->adboxUrl2() != '' )echo $titan->adboxUrl2(); else echo "#"; ?>"><img class="alignright" src="<?php bloginfo( 'stylesheet_directory'); ?>/images/sidebar/<?php if ($titan->adboxImage2() != '' )echo $titan->adboxImage2(); else echo "125_ad_1.gif"; ?>" width="125" height="125" alt="<?php if ($titan->adboxAlt2() != '' )echo $titan->adboxAlt2(); else echo bloginfo( 'name'); ?>" /></a>
		</div><!--end adbox-->
	<?php } ?>
	<?php if ( is_active_sidebar( 'normal_sidebar' )) echo "<ul>" ?>
<?php
	 echo '<li class="widget widget_categories" id="categories-3"><h2 class="widgettitle">Categories</h2><ul>';
	    wp_list_cats( 'sort_column=name&hierarchical=0&exclude=64');
         echo "</ul></li>";
	?>
	<?php if ( !function_exists( 'dynamic_sidebar')|| !dynamic_sidebar( 'normal_sidebar' )) : ?>
		<ul>
			<li class="widget widget_recent_entries">
				<h2 class="widgettitle"><?php _e( 'Recent Articles', 'titan'); ?></h2>
				<ul>
					<?php $side_posts = get_posts( 'numberposts=10'); foreach($side_posts as $post) : ?>
					<li><a href= "<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="widget widget_categories">
				<h2 class="widgettitle"><?php _e( 'Categories', 'titan'); ?></h2>
				<ul>
					<?php wp_list_cats( 'sort_column=name&exclude=64'); ?>
				</ul>
			</li>
			<li class="widget widget_archive">
				<h2 class="widgettitle"><?php _e( 'Archives', 'titan'); ?></h2>
				<ul>
					<?php wp_get_archives( 'type=monthly'); ?>
				</ul>
			</li>
		</ul>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'normal_sidebar' )) echo "</ul>" ?>
</div><!--end sidebar-->