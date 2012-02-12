<?php
//Set language folder and load textdomain
if (file_exists(STYLESHEETPATH . '/languages'))
	$language_folder = (STYLESHEETPATH . '/languages');
else
	$language_folder = (TEMPLATEPATH . '/languages');
load_theme_textdomain( 'titan', $language_folder);

//Add support for post thumbnails
if ( function_exists( 'add_theme_support' ) )
	add_theme_support( 'post-thumbnails' );

//Redirect to theme options page on activation
if ( is_admin() && isset($_GET['activated'] ) && $pagenow ==	"themes.php" )
	wp_redirect( 'themes.php?page=titan-admin.php');

// Required functions
if (is_file(STYLESHEETPATH . '/functions/comments.php'))
	require_once(STYLESHEETPATH . '/functions/comments.php');
else
	require_once(TEMPLATEPATH . '/functions/comments.php');

if (is_file(STYLESHEETPATH . '/functions/titan-extend.php'))
	require_once(STYLESHEETPATH . '/functions/titan-extend.php');
else
	require_once(TEMPLATEPATH . '/functions/titan-extend.php');
	
if (is_file(STYLESHEETPATH . '/functions/custom-tweet.php'))
	require_once(STYLESHEETPATH . '/functions/custom-tweet.php');
else
	require_once(TEMPLATEPATH . '/functions/custom-tweet.php');	
	
/**
* Retrieves the attachment data such as Title, Caption, Alt Text, Description
* @param int $post_id the ID of the Post, Page, or Custom Post Type
* @param String $size The desired image size, e.g. thumbnail, medium, large, full, or a custom size
* @return stdClass If there is only one result, this method returns a generic
* stdClass object representing each of the image's properties, and an array if otherwise.
*/
function getImageAttachmentData( $post_id, $size = 'thumbnail', $count = 1 )
{
$objMeta = array();
$meta;// (stdClass)
$args = array(
'numberposts' => $count,
'post_parent' => $post_id,
'post_type' => 'attachment',
'nopaging' => false,
'post_mime_type' => 'image',
'order' => 'ASC', // change this to reverse the order
'orderby' => 'menu_order ID', // select which type of sorting
'post_status' => 'any'
);

$attachments = & get_children($args);

if( $attachments )
{
foreach( $attachments as $attachment )
{
$meta = new stdClass();
$meta->ID = $attachment->ID;
$meta->title = $attachment->post_title;
$meta->caption = $attachment->post_excerpt;
$meta->description = $attachment->post_content;
$meta->alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);

// Image properties
$props = wp_get_attachment_image_src( $attachment->ID, $size, false );

$meta->properties['url'] = $props[0];
$meta->properties['width'] = $props[1];
$meta->properties['height'] = $props[2];

$objMeta[] = $meta;
}

return ( count( $attachments ) == 1 ) ? $meta : $objMeta;
}
}

// Sidebars
if ( function_exists( 'register_sidebar_widget' ))
		register_sidebar(array(
				'name'=> __( 'Sidebar', 'titan'),
				'id' => 'normal_sidebar',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h2 class="widgettitle">',
				'after_title' => '</h2>',
		));

if ( function_exists( 'register_sidebar_widget' ))
		register_sidebar(array(
				'name'=> __( 'Footer', 'vigilance'),
				'id' => 'footer_sidebar',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h2 class="widgettitle">',
				'after_title' => '</h2>',
		));
?>