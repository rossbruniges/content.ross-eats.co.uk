<?php get_header(); ?>
<div class="content-background">
	<div class="wrapper hreview">
		<div class="notice"></div>
		<div id="content">
 	<?php if (have_posts()) : ?>
 	<?php while (have_posts()) : the_post(); ?>
 		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 			<div class="post-header">
 				<div class="tags"><?php the_tags( '<span>Tags</span> <p>', ', ', '</p>'); ?></div>
 				<h1 class="summary"><?php the_title(); ?></h1>
 				<p class="author">by <strong class="reviewer vcard"><span class="fn"><?php printf(__ ( '%s', 'titan'), get_the_author()); ?></span></strong> on <abbr class="dtreviewed" title="<?php the_time(__ ( 'Y-m-d', 'titan')); ?>"><?php the_time(__ ( 'F jS, Y', 'titan')); ?></abbr></p>
 			</div><!--end post header-->
 			<div class="entry clear burrito">
 			 <?php
   		    $details = get_post_custom($post->ID);
   		  ?>
 			  <div class="description">
 				<?php the_content(__( 'read more...', 'titan')); ?>
 				<?php include('burrito-announce.php'); ?>
 				<?php
        if (function_exists('tweet_button'))
           tweet_button(get_permalink());
        ?>
 				</div>
 			</div><!--end entry-->
 			<div class="meta clear">
 				<p><?php _e( 'From', 'titan' ); ?> &rarr; <?php the_category( ', '); ?></p>
 			</div><!--end meta-->
 		</div><!--end post-->
 		<div class="vcard item">
 		  <h2>At a glance</h2>
 		  <p class="fn"><?php
 		    if ($details['Restaurant URL'][0]) {
 		      echo '<a href="' . $details['URL'][0] . '" class="url">' . the_title()  . '</a>';
 		    } else {
 		      echo the_title();
 		    }
 		  ?></p>
 		  <p><strong>Cost :</strong> <?php echo $details['Price'][0] ?></p>
 		  <p><strong>Phone: </strong> <span class="tel"><?php echo $details['Phone'][0] ?></span></p>
 		  <h3>Location</h3>
 		  <div class="adr">
 		    <p class="street-address"><?php echo $details['Street'][0] ?></p>
 		    <p class="region">London</p>
 		    <p class="postal-code"><?php echo $details['Postcode'][0] ?></p>
 		  </div>
 		  <?php
 		  if ($details['urbanspoon'][0] != "") {
 		      echo "<h3>Don't just take my word for it</h3>";
      		  echo $details['urbanspoon'][0];
 		  }
 		  ?>
		</div>
 	<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
 		<?php comments_template( '', true); ?>
 	<?php else : ?>
 	<?php endif; ?>
 </div><!--end content-->
 <?php get_footer(); ?>