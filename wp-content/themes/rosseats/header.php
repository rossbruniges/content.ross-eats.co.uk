<?php global $titan; ?>
<!DOCTYPE html>
<html <?php language_attributes( 'html' ) ?>>
<head>
    <meta name="google-site-verification" content="G4gCHqqeSJKF8_GzrYR5oRg1HmmVTj7-6t6Pg5CMpac" />	
	<?php if ( is_front_page() ) : ?>
		<title><?php bloginfo('name'); ?></title>
	<?php elseif ( is_404() ) : ?>
		<title><?php _e('Page Not Found |', 'titan'); ?> | <?php bloginfo('name'); ?></title>
	<?php elseif ( is_search() ) : ?>
		<title><?php printf(__ ("Search results for '%s'", "titan"), get_search_query()); ?> | <?php bloginfo('name'); ?></title>
	<?php else : ?>
		<title><?php wp_title($sep = ''); ?> | <?php bloginfo('name');?></title>
	<?php endif; ?>

	<!-- Basic Meta Data -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="copyright" content="<?php
		esc_attr( sprintf(
			__( 'Design is copyright %1$s The Theme Foundry', 'titan' ),
			date( 'Y' )
		) );
	?>" />

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" />

	<!-- WordPress -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="skip-content"><a href="#content"><?php _e( 'Skip to content', 'titan' ); ?></a></div>
	<div id="header" class="clear">
        <div id="follow">
			<div class="wrapper clear">
				<dl>
					<dt><?php _e( 'Follow:', 'titan' ); ?></dt>
					<dd><a class="rss" href="<?php bloginfo( 'rss2_url'); ?>"><?php _e( 'RSS', 'titan' ); ?></a></dd>
					 <dd><a class="twitter" href="http://www.iwtter.com/ross_eats/"><?php _e( 'Twitter', 'titan' ); ?></a></dd>
				</dl>
			</div><!--end wrapper-->
		</div><!--end follow-->
		<div class="wrapper">
				<?php
				$logo_markup = is_home() ? '<h1 id="title"><a href="%1$s"><img id="frame" alt="" width="107" height="84" src="%2$s/images/header_ross.jpg" />%3$s</a></h1>' : '<div id="title"><a href="%1$s"><img id="frame" alt="" width="107" height="84" src="%2$s/images/header_ross.jpg" />%3$s</a></div>';
				printf(
					$logo_markup,
					home_url( '/' ),
                    get_bloginfo( 'stylesheet_directory' ),
					get_bloginfo( 'name' )
				);
				?>
				<div id="description">
					<?php bloginfo('description'); ?>
				</div><!--end description-->
			<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'nav-1',
						'container_id'    => 'navigation',
						'menu_id'         => 'nav',
						'fallback_cb'     => array( &$titan, 'main_menu_fallback' )
					)
				);
			?>
		</div><!--end wrapper-->
	</div><!--end header-->
<div class="content-background">
<div class="wrapper clear">
<?php
    if (is_single()) {
        $content_class = "";
        if (in_category('Reviews') || in_category('London Burritos')) {
            $content_class = "hreview";
        }
    }
?>
<div id="content" class="<?php echo $content_class ?>">