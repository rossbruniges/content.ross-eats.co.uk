<?php global $titan; ?>
</div><!--end wrapper-->
</div><!--end content-background-->
<div id="footer">
	<div class="wrapper clear">
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
<?php wp_footer(); ?>
</body>
</html>