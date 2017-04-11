<?php

define('WP_USE_THEMES', false);

/** Loads the WordPress Environment and Template */
require ('../../../../wp-load.php');
    
if ( file_exists( get_stylesheet_directory() . '/template-parts/page/search/excelined-feed.php' ) ) { 
    include_once( get_stylesheet_directory() . '/template-parts/page/search/excelined-feed.php' );
}

if ( isset( $_COOKIE["pixel_ratio"] ) ) {
    $pixel_ratio = $_COOKIE["pixel_ratio"];
    if ( $pixel_ratio >= 2 ) {
        require( get_template_directory() . '/includes/plugins/aq_resizer-2x.php' );
    } else {
        require( get_template_directory() . '/includes/plugins/aq_resizer-1x.php' );
    }
} else {
    require( get_template_directory() . '/includes/plugins/aq_resizer-1x.php' );
}

$atts = json_decode(stripcslashes($_GET["atts"]));

if ( is_object($atts) ) {
    $atts = get_object_vars($atts);
}

if ( !isset($_GET["atts"]) || $_GET["atts"] == "" || empty($_GET["atts"]) || !is_array($atts) || count($atts) <= 0 ) {

	header("HTTP/1.0 404 Not Found - Archive Empty");
    $wp_query->set_404();
    require TEMPLATEPATH.'/404.php';
    exit;
    exit();

} else {

    if ( count($atts) > 0 ) {
        foreach ($atts as $key => $value) {
            if ( isset($_GET[$key]) && $_GET[$key] != "" && !empty($_GET[$key]) ) {
                $atts[$key] = $_GET[$key];
            }
        }
    }

	echo str_replace( "//page", "/page", str_replace( get_site_url() . "/wp-content/themes/florida-child/api/florida_schools_feed.php", $_GET["permalinkURL"], sf_florda_schools_feed_items( $atts ) ) );

}

?>