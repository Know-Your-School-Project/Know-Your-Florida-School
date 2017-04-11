<?php

define('WP_USE_THEMES', false);

/** Loads the WordPress Environment and Template */
require ('../../../../wp-load.php');

$post_id = $_GET["id"];

if ( FALSE === get_post_status( $post_id ) ) {

	header("HTTP/1.0 404 Not Found - Archive Empty");
    $wp_query->set_404();
    require TEMPLATEPATH.'/404.php';
    exit;
    exit();

} else {

	$content = do_shortcode( get_post_field('post_content', $post_id) );
	
	echo json_encode( $content );

}

?>