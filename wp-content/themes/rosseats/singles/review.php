<?php 
    $details = get_post_custom($post->ID); 
    $details_url = $details['restaurant_url'][0] ? $details['restaurant_url'][0] : $details['Restaurant URL'][0];
    $details_chef = $details['restaurant_chef'][0] ? $details['restaurant_chef'][0] : $details['Restaurant chef'][0];
    $details_telephone = $details['restaurant_telephone'][0] ? $details['restaurant_telephone'][0] : $details['Restaurant telephone'][0];
    $details_rating = $details['restaurant_rating'][0] ? $details['restaurant_rating'][0] : $details['Restaurant rating'][0];
    $details_cost = $details['restaurant_cost'][0] ? $details['restaurant_cost'][0] : $details['Restaurant cost'][0];
    $details_address = $details['restaurant_address'][0] ? $details['restaurant_address'][0] : $details['Restaurant address'][0];
    if ($details['restaurant_geo_lat'][0] && $details['restaurant_geo_long'][0]) {
        $details_point = $details['restaurant_geo_lat'][0] . ',' . $details['restaurant_geo_long'][0];
    } else {
        $details_point = $details['Restaurant Geo lat'][0] . ',' . $details['Restaurant Geo long'][0];
    }
    $details_urbanspoon = $details['restaurant_urbanspoon'][0] ? $details['restaurant_urbanspoon'][0] : $details['urbanspoon'][0];
    $details_squaremeal = $details['restaurant_squaremeal'][0] ? $details['restaurant_squaremeal'][0] : $details['squaremeal'][0];
    $details_flickr = $details['restaurant_flickr'][0] ? $details['restaurant_flickr'][0] : $details['Restaurant flickr group'][0];
    $details_amend = $details['restaurant_amend'][0] ? $details['restaurant_amend'][0] : $details['post_alert'][0];
?>
<div class="post-header">
	<h1 class="summary"><?php the_title(); ?></h1>
	<p class="author">by <strong class="reviewer vcard"><span class="fn"><?php printf(__ ( '%s', 'titan'), get_the_author()); ?></span></strong> on <abbr class="dtreviewed" title="<?php the_time(__ ( 'Y-m-d', 'titan')); ?>"><?php the_time(__ ( 'F jS, Y', 'titan')); ?></abbr></p>
</div><!--end post header-->
<div class="vcard">
    <h2>At a glance</h2>
    <div class="deets">
    <p class="fn org">
    <?php
        if (count($details_url)) {
     	    echo '<a href="' . $details_url . '" class="url">' . get_the_title()  . '</a>';
     	} else {
     		echo get_the_title();
     	}
     ?>
     </p>
     <p><strong>Chef:</strong> <?php echo $details_chef ?></p>
     <p><strong>Reservations: </strong> <span class="tel"><?php echo $details_telephone ?></span></p>
     <p><strong>Rating: </strong> <span class="rating"><span class="value"><?php echo $details_rating ?></span> out of <span class="best">10</span></span></p>
     <p><strong>Cost :</strong> <?php echo $details_cost ?></p>
     </div>
     <div class="find">
     <h3>Location</h3>
     <div class="adr">
     	<?php echo $details_address ?>
     </div>
     <p><strong>Map</strong></p>
     <img src="http://maps.google.com/maps/api/staticmap?zoom=14&size=236x236&maptype=roadmap&markers=color:blue|<?php echo $details_point ?>&sensor=false" width="238" height="238" alt="Location map" />
     <?php
     if ($details_urbanspoon || $details_squaremeal) {
         print "<h3>Don't just take my word for it</h3>";
    }
     ?>
     <?php if ($details_urbanspoon) : ?>
    	<?php echo $details_urbanspoon ?>
    	<?php endif; ?>
    	<?php if ($details_squaremeal) : ?>
    	<?php echo $details_squaremeal ?>
    	<?php endif; ?>
    </div>
</div>
<div id="post-<?php the_ID(); ?>" class="post">    
 	<div class="entry clear">
 	    <?php if ($details_amend) : ?>
            <div class="alert">
                <?php echo $details_amend; ?>
            </div>
        <?php endif; ?>
 		<div id="images">
            <?php if ($details_flickr) : ?>
 		     <h2>In photos</h2>
 		     <?php 
 		        the_post_thumbnail(array(240,240)); 
 			    $attachment = getImageAttachmentData(get_the_ID());
		        echo '<p>' . $attachment->description . '</p>';
		      ?>
 			    <a href="http://www.flickr.com/photos/thecssdiv/sets/<?php echo $details_flickr ?>/">More pictures</a>
            <?php else : ?>
                <?php 
                the_post_thumbnail(array(240,240)); 
                $attachment = getImageAttachmentData(get_the_ID());
                echo '<p>' . $attachment->description . '</p>';
              ?>
            <?php endif; ?>
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