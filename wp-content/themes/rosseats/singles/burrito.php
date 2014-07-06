<?php 
    $details = get_post_custom($post->ID);
    $burrito_url = $details['burrito_url'][0] ? $details['burrito_url'][0] : $details['URL'][0];
    $burrito_price = $details['burrito_price'][0] ? $details['burrito_price'][0] : $details['Price'][0];
    $burrito_phone = $details['burrito_phone'][0] ? $details['burrito_phone'][0] : $details['Phone'][0];
    $burrito_street = $details['burrito_street'][0] ? $details['burrito_street'][0] : $details['Street'][0];
    $burrito_postcode = $details['burrito_postcode'][0] ? $details['burrito_postcode'][0] : $details['Postcode'][0];
    $burrito_urbanspoon = $details['burrito_urbanspoon'][0] ? $details['burrito_urbanspoon'][0] : $details['urbanspoon'][0];
    $burrito_squaremeal = $details['burrito_squaremeal'][0] ? $details['burrito_squaremeal'][0] : $details['squaremeal'][0];
?>
<div class="post-header">
	<h1 class="summary"><?php the_title(); ?></h1>
		<p class="author">by <strong class="reviewer vcard"><span class="fn"><?php printf(__ ( '%s', 'titan'), get_the_author()); ?></span></strong> on <abbr class="dtreviewed" title="<?php the_time(__ ( 'Y-m-d', 'titan')); ?>"><?php the_time(__ ( 'F jS, Y', 'titan')); ?></abbr></p>
</div><!--end post header-->
    <div class="vcard item">
        <h2>At a glance</h2>
     	<p class="fn">
     	    <?php
     	        if ($burrito_url) {
     		        echo '<a href="' . $burrito_url . '" class="url">' . the_title()  . '</a>';
     		    } else {
     		        echo the_title();
     		    }
            ?>
     	</p>
     	<p><strong>Cost :</strong> <?php echo $burrito_price ?></p>
     	<p><strong>Phone: </strong> <span class="tel"><?php echo $burrito_phone ?></span></p>
     	<h3>Location</h3>
     	<div class="adr">
     	    <p class="street-address"><?php echo $burrito_street ?></p>
     		<p class="region">London</p>
     		<p class="postal-code"><?php echo $burrito_postcode ?></p>
     	</div>
     	<?php
     	    if ($burrito_urbanspoon || $burrito_squaremeal) {
                 echo "<h3>Don't just take my word for it</h3>";
            }
     	    if ($burrito_urbanspoon != "") {
          		echo $burrito_urbanspoon;
     		}
     		if ($burrito_squaremeal != "") {
          		echo $burrito_squaremeal;
     		}
     	?>
    </div>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 	<div class="entry clear burrito">
 		<div class="description">
 		    <?php the_content(__( 'read more...', 'titan')); ?>
 			<div class="announce">
                <h2>Part of Londons best burrito</h2>
                <p>Back in October 2010 I decided to try and find what I felt was London's best burrito after noticing that there was quite a lot of choice. To make it a fair test I set the following rules:</p>
                <ul>
                    <li>steak burrito</li>
                    <li>no guacamole</li>
                    <li>hot sauce</li>
                    <li>to go (no knife and fork allowed)</li>
                </ul>
                <p>How does this burrito ran in my quest? See my full list of what I feel are <a href="http://www.ross-eats.co.uk/londons-best-burrito/">London's best burritos</a>.</p>
            </div>
 			<a href="https://twitter.com/share" class="twitter-share-button" data-text="Thought this was good enough to share" data-via="ross_eats">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
 		</div>
 		
 	</div><!--end entry-->
 	<div class="tags">
        <?php the_tags( '<span>Tags</span> <p>', ', ', '</p>'); ?>
    </div>
 	<div class="meta clear">
 	    <p><?php _e( 'From', 'titan' ); ?> &rarr; <?php the_category( ', '); ?></p>
 	</div><!--end meta-->
</div><!--end post-->