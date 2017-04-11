<?php get_header(); ?>

<?php

    global $sf_options;
    $sidebar_config = $sf_options['archive_sidebar_config'];
    $left_sidebar   = $sf_options['archive_sidebar_left'];
    $right_sidebar  = $sf_options['archive_sidebar_right'];
    $blog_type      = $sf_options['archive_display_type'];

    if ( $blog_type == "masonry" || $blog_type == "masonry-fw" ) {
        global $sf_include_imagesLoaded;
        $sf_include_imagesLoaded = true;
    }

    global $sf_has_blog;
    $sf_has_blog = true;

    sf_set_sidebar_global( $sidebar_config );
?>

<?php 
    
    sd_get_template_part("page/search");

?>

<?php get_footer(); ?>