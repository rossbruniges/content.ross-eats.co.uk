<?php global $titan; ?>
</div><!--end wrapper-->
</div><!--end content-background-->
<div id="footer">
	<div class="wrapper clear">
	    <div id="footer-about" class="footer-column">
		    <h2><?php _e('About', 'titan'); ?></h2>
			<p>This website contains thoughts on food and restaurants from me, <span class="vcard"><a href="mailto:ross@ross-eats.co.uk" class="fn email">Ross Bruniges</a></span>.</p>
            <p>I've been going out to restaurants in London and further afield (I generally like to holiday in places where I know I can get a good meal) for about 5 years and reckon I've had a few decent ones in that time so thought I'd start writing about them a bit more.</p> 
            <p>I go to places with a good rep or an interesting menu about once a month and take <a href="http://www.flickr.com/photos/thecssdiv/sets/">photos</a> where allowed.</p>
            <p>I hope you leave here feeling hungry!</p>
            <p><a href="http://www.urbanspoon.com/br/52/4207/London/Ross-eats.html"><img alt="Ross eats London restaurants" src="http://a2.urbns.pn/images/1/badge/featured_blog.gif" style="border:none;width:134px;height:48px" /></a></p>
	    </div>
	    <div id="footer-flickr" class="footer-column">
	        <h2><?php _e('Flickr', 'titan'); ?></h2>
		    <div class="flickr-footer">
		        <?php
		            $url = "http://www.flickr.com/badge_code_v2.gne?count=9&display=latest&size=s&layout=x&source=user_tag&user=92146798%40N00&tag=ross-eats";
		            $html = file_get_contents($url);
			        preg_match_all("/<div.*div>/", $html, $matches);
			        foreach($matches[0] as $div) {
				        echo str_replace("></a>", "/></a>", $div);
			        }
		        ?>
	        </div>
			<p>As mentioned I will always try and take pictures wherever I go; to see what else I've got check out <a href="http://www.flickr.com/photos/thecssdiv/sets/">all my other foody pictures</a>.</p>
	</div>
	<div id="footer-search" class="footer-column">
	    <div class="tweets twitter-section">
	        <h2><?php _e('Twitter', 'titan'); ?></h2>
	        <a class="twitter-timeline" href="https://twitter.com/ross_eats" data-widget-id="279687137186693120">Tweets by @ross_eats</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            
		</div>
	</div>
		<div id="copyright">
			<p class="copyright-notice">
				<?php printf(
					__( 'Copyright &copy; %1$s %2$s.', 'titan' ),
					date( 'Y' ),
					$titan->copyrightName()
				); ?>
				<?php
					printf(
						__( '<a href="%1$s">Titan Theme</a> by <a href="%2$s">The Theme Foundry</a>', 'titan' ),
						'http://thethemefoundry.com/titan/',
						'http://thethemefoundry.com/'
					);
				?>
			</p>
		</div><!--end copyright-->
	</div><!--end wrapper-->
</div><!--end footer-->
<?php if (!is_front_page() && in_category('Reviews')) : ?>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/flickr_gallery.js"></script>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>