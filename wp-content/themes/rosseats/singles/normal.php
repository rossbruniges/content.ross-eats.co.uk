<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-header">
 	    <div class="tags"><?php the_tags( '<span>Tags</span> <p>', ', ', '</p>'); ?></div>
 		<h1><?php the_title(); ?></h1>
 		<div class="author">
 		    <?php printf(__ ( 'by %s on', 'titan'), get_the_author()); ?> <?php the_time(__ ( 'F jS, Y', 'titan')); ?></div>
 	</div><!--end post header-->
 	<div class="entry clear">
 		<?php the_content(__( 'read more...', 'titan')); ?>
 		<a href="https://twitter.com/share" class="twitter-share-button" data-text="Thought this was good enough to share" data-via="ross_eats">Tweet</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
 		<?php wp_link_pages(); ?>
 	</div><!--end entry-->
 	<div class="meta clear">
 		<p><?php _e( 'From', 'titan' ); ?> &rarr; <?php the_category( ', '); ?></p>
    </div><!--end meta-->
</div><!--end post-->