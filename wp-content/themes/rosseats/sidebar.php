<?php global $titan; ?>
<div id="sidebar">
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
	<ul>
	<?php if ( ! dynamic_sidebar( 'normal_sidebar' ) ) : ?>
		<li class="widget widget_recent_entries">
			<h2 class="widgettitle"><?php _e( 'Recent Articles', 'titan' ); ?></h2>
			<ul>
				<?php foreach( (array) get_posts( 'numberposts=10' ) as $post ) : ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>
		<li class="widget widget_categories">
			<h2 class="widgettitle"><?php _e( 'Categories', 'titan' ); ?></h2>
			<ul>
				<?php wp_list_categories( 'sort_column=name&hierarchical=0&title_li=' ); ?>
			</ul>
		</li>
		<li class="widget widget_archive">
			<h2 class="widgettitle"><?php _e( 'Archives', 'titan' ); ?></h2>
			<ul>
				<?php wp_get_archives( 'type=monthly' ); ?>
			</ul>
		</li>
	<?php endif; ?>
	</ul>
</div><!--end sidebar-->