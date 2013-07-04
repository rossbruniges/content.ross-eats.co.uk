<?php $details = get_post_custom($post->ID); ?>
<div class="post-header">
	<h1 class="summary"><?php the_title(); ?></h1>
	<p class="author">by <strong class="reviewer vcard"><span class="fn"><?php printf(__ ( '%s', 'titan'), get_the_author()); ?></span></strong> on <abbr class="dtreviewed" title="<?php the_time(__ ( 'Y-m-d', 'titan')); ?>"><?php the_time(__ ( 'F jS, Y', 'titan')); ?></abbr></p>
</div><!--end post header-->
<div class="vcard">
    <h2>At a glance</h2>
    <div class="deets">
    <p class="fn org">
    <?php
        if (count($details['Restaurant URL'])) {
     	    echo '<a href="' . $details['Restaurant URL'][0] . '" class="url">' . get_the_title()  . '</a>';
     	} else {
     		echo get_the_title();
     	}
     ?>
     </p>
     <p><strong>Chef:</strong> <?php echo $details['Restaurant chef'][0] ?></p>
     <p><strong>Reservations: </strong> <span class="tel"><?php echo $details['Restaurant telephone'][0] ?></span></p>
     <p><strong>Rating: </strong> <span class="rating"><span class="value"><?php echo $details['Restaurant rating'][0] ?></span> out of <span class="best">10</span></span></p>
     <p><strong>Cost :</strong> <?php echo $details['Restaurant cost'][0] ?></p>
     </div>
     <div class="find">
     <h3>Location</h3>
     <div class="adr">
     	<?php echo $details['Restaurant address'][0] ?>
     </div>
     <p><strong>Map</strong></p>
     <img src="http://maps.google.com/maps/api/staticmap?zoom=14&size=236x236&maptype=roadmap&markers=color:blue|<?php echo $details['Restaurant Geo lat'][0] ?>,<?php echo $details['Restaurant Geo long'][0] ?>&sensor=false" width="238" height="238" alt="Location map" />
     <?php
     if (array_key_exists('squaremeal', $details) || array_key_exists('urbanspoon', $details)) {
         print "<h3>Don't just take my word for it</h3>";
    }
     ?>
     <?php if (array_key_exists('urbanspoon', $details)) : ?>
    	<?php echo $details['urbanspoon'][0]; ?>
    	<?php endif; ?>
    	<?php if (array_key_exists('squaremeal', $details)) : ?>
    	<?php echo $details['squaremeal'][0]; ?>
    	<?php endif; ?>
    </div>
</div>
<div id="post-<?php the_ID(); ?>" class="post">    
 	<div class="entry clear">
 	    <?php if (count($details['post_alert'])) : ?>
            <div class="alert">
                <?php echo $details['post_alert'][0]; ?>
            </div>
        <?php endif; ?>
 		<div id="images">
 		    <h2>In photos</h2>
 		    <?php 
 		        the_post_thumbnail(array(240,240)); 
 			    $attachment = getImageAttachmentData(get_the_ID());
		        echo '<p>' . $attachment->description . '</p>';
		    ?>
 			<a href="http://www.flickr.com/photos/thecssdiv/sets/<?php echo $details['Restaurant flickr group'][0] ?>/">More pictures</a>
 		</div>
 		<div class="description">
            
 			<?php the_content(__( 'read more...', 'titan')); ?>
 			<a href="https://twitter.com/share" class="twitter-share-button" data-text="Thought this was good enough to share" data-via="ross_eats">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
 		</div>
        <div class="related_posts">
            <?php
            $areas = array('london', 'america', 'uk');
            $active_areas = array();
            foreach (get_the_tags() as $tag) {
                if (in_array($tag->name, $areas)) {
                    array_push($active_areas, $tag->name);
                }
            }
            if (count($active_areas) > 0) {
                echo "<h2>Anything else 'near-by'?</h2>";
                echo "<p>Looking for something a bit differet? See if I've got any other reviews from near-by (obviously the accuacy of 'near-by' could vary...)</p>";
                echo "<ol>";
                foreach ($active_areas as $value) {
                    echo "<li><a href=/in/" . $value . ">" . $value . "</a></li>";
                };
                echo "</ol>";
            }
        ?>
            </div>
        <div class="tags"><?php the_tags( '<span>Tags</span> <p>', ', ', '</p>'); ?></div>
 		<?php wp_link_pages(); ?>
 	</div><!--end entry-->
 	<div class="meta clear">
 	    <p><?php _e( 'From', 'titan' ); ?> &rarr; <?php the_category( ', '); ?></p>
 	</div><!--end meta-->
</div><!--end post-->