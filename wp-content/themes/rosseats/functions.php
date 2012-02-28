<?php
	locate_template( array( 'functions' . DIRECTORY_SEPARATOR . 'titan-extend.php' ), true );
	
/**
* Retrieves the attachment data such as Title, Caption, Alt Text, Description
* @param int $post_id the ID of the Post, Page, or Custom Post Type
* @param String $size The desired image size, e.g. thumbnail, medium, large, full, or a custom size
* @return stdClass If there is only one result, this method returns a generic
* stdClass object representing each of the image's properties, and an array if otherwise.
*/
function getImageAttachmentData( $post_id, $size = 'thumbnail', $count = 1 ) {
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

    if( $attachments ) {
        foreach( $attachments as $attachment ) {
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