<!DOCTYPE html>

<!--// OPEN HTML //-->
<html <?php language_attributes(); ?>>

<!--// OPEN HEAD //-->
<head>
    <?php
        $page_classes = sf_page_classes();
        $page_class   = $page_classes['page'];

        global $post, $sf_options;
        $extra_page_class = $page_header_type = "";
        $header_layout    = $sf_options['header_layout'];
        if ( $post ) {
            $extra_page_class = sf_get_post_meta( $post->ID, 'sf_extra_page_class', true );
        }
        if ( is_page() && $post ) {
            $page_header_type = sf_get_post_meta( $post->ID, 'sf_page_header_type', true );
        }
        add_action( 'sf_container_start', 'sf_pageslider', 30 );

        if ( $page_header_type == "naked-light" || $page_header_type == "naked-dark" ) {
            remove_action( 'sf_main_container_start', 'sf_breadcrumbs', 20 );
        }

        if ( isset($sf_options['enable_styles']) && ( $sf_options['enable_styles'] == false || $sf_options['enable_styles'] == 0 ) ) {
            $extra_page_class .= " remove-styles";
        }
        $header_right_config       = $sf_options['header_right_config'];
        $header_left_config       = $sf_options['header_left_config'];
        $mobile_header_layout    = $sf_options['mobile_header_layout'];
        $mobile_show_search      = $sf_options['mobile_show_search'];
        if ( ($mobile_header_layout == "left-logo" && $header_left_config != "slideout") || ($header_right_config == "slideout") ) {
            $extra_page_class .= " slideout-right";
        } else if ( ($mobile_header_layout == "right-logo" && $header_right_config != "slideout") || $header_left_config == "slideout" ) {
            $extra_page_class .= " slideout-left";
        }
    ?>

    <?php wp_head(); ?>

    <!--[if gte IE 9]>
      <style type="text/css">
        .gradient {
           filter: none;
        }
      </style>
    <![endif]-->

    <!--// CLOSE HEAD //-->
</head>

<!--// OPEN BODY //-->
<body <?php body_class( $page_class . ' ' . $extra_page_class ); ?>>

<?php
    /**
     * @hooked - sf_site_loading - 0
     * @hooked - sf_mobile_menu - 10
     * @hooked - sf_mobile_cart - 20
     * @hooked - sf_pageslider - 30 (if above header & boxed)
     **/
    do_action( 'sf_before_page_container' );
?>

<?php

    $containerClasses = "";
    
    require_once( SF_TEMPLATE_PATH . "/php/simple_html_dom.php");

    $top_bar = str_get_html(sf_top_bar_menu());
    $main_menu = str_get_html(sf_main_menu('main-navigation', 'full'));
    $overlay_menu = str_get_html(sf_overlay_menu());
    $class = "sf-menu-item-modal";
    $modal_posts = array();
    $modal_content = "";
    $modalClasses = "";

    if ( isset($post) && !empty($post) ) {

        foreach ($top_bar->find('li.'.$class) as $element) {

            $post_url = $element->children[0]->attr["href"];
            if ( $post_url != "" ) {
                $post_id = url_to_postid("".$post_url."");

                if ( !isset($post_id) || FALSE === get_post_status( $post_id ) || $post_id <= 0 || in_array($post_id, $modal_posts) ) { 
                    
                    if ( strpos($post_url, '#') !== false && !in_array($post_id, $modal_posts) ) {

                        $modal_posts[] = $post_id;

                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.str_replace("#", "", $post_url).' " data-postid="'.$post_url.'"></div>';
                        
                    }

                } else {

                    $modal_posts[] = $post_id;

                    if ( $post_id == $post->ID ) {
                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.$post_id.' force-open" data-postid="'.$post_id.'" style="display:block;">' . do_shortcode( get_post_field('post_content', $post_id) ) . "</div>";
                        $containerClasses .= "force-close";
                        $modalClasses .= "force-open ";
                    } else {
                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.$post_id.'" data-postid="'.$post_id.'">' . do_shortcode( get_post_field('post_content', $post_id) ) . "</div>";
                    }
                    
                }
            }
        }

        foreach ($main_menu->find('li.'.$class) as $element) {

            $post_url = $element->children[0]->attr["href"];
            if ( $post_url != "" ) {
                $post_id = url_to_postid("".$post_url."");

                if ( !isset($post_id) || FALSE === get_post_status( $post_id ) || $post_id <= 0 || in_array($post_id, $modal_posts) ) { 
                    
                    if ( strpos($post_url, '#') !== false && !in_array($post_id, $modal_posts) ) {

                        $modal_posts[] = $post_id;

                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.str_replace("#", "", $post_url).' " data-postid="'.$post_url.'"></div>';

                    }

                } else {

                    $modal_posts[] = $post_id;

                    if ( $post_id == $post->ID ) {
                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.$post_id.' force-open" data-postid="'.$post_id.'" style="display:block;">' . do_shortcode( get_post_field('post_content', $post_id) ) . "</div>";
                        $containerClasses .= "force-close";
                        $modalClasses .= "force-open ";
                    } else {
                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.$post_id.'" data-postid="'.$post_id.'">' . do_shortcode( get_post_field('post_content', $post_id) ) . "</div>";
                    }
                    
                }
            }
        }

        foreach ($overlay_menu->find('li.'.$class) as $element) {

            $post_url = $element->children[0]->attr["href"];
            if ( $post_url != "" ) {
                $post_id = url_to_postid("".$post_url."");

                if ( !isset($post_id) || FALSE === get_post_status( $post_id ) || $post_id <= 0 || in_array($post_id, $modal_posts) ) { 
                    
                    if ( strpos($post_url, '#') !== false && !in_array($post_id, $modal_posts) ) {

                        $modal_posts[] = $post_id;

                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.str_replace("#", "", $post_url).' " data-postid="'.$post_url.'"></div>';

                    }

                } else {

                    $modal_posts[] = $post_id;

                    if ( $post_id == $post->ID ) {
                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.$post_id.' force-open" data-postid="'.$post_id.'" style="display:block;">' . do_shortcode( get_post_field('post_content', $post_id) ) . "</div>";
                        $containerClasses .= "force-close";
                        $modalClasses .= "force-open ";
                    } else {
                        $modal_content .= '<div class="sd-modal-content sd-modal-content-'.$post_id.'" data-postid="'.$post_id.'">' . do_shortcode( get_post_field('post_content', $post_id) ) . "</div>";
                    }
                    
                }
            }
        }

    }

    if ( isset($post) && !empty($post) && $post->ID == 42 ) {

        if ( ( isset($_GET["schoolid"]) && !empty($_GET["schoolid"]) && $_GET["schoolid"] != "" ) && ( isset($_GET["districtid"]) && !empty($_GET["districtid"]) && $_GET["districtid"] != "" ) ) {

            require( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );
            require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

            $schoolId = $_GET["schoolid"];
            $districtId = $_GET["districtid"];
            $endYear = $recentYear;
            $startYear = 1999;

            // START API CALL

            // SCHOOL DATA
            $requestURL = "https://api.jaxpef.org/school/singleschool/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY . "&yrstart=" . $startYear . "&yrend=" . $endYear;
            $schoolData = json_decode(file_get_contents($requestURL));

            // THOMAS: CREATED GLOBAL VAR IN VARIBALES.PHP, MOVED API CALL HERE FROM TABLE.PHP  IN ORDER TO PREVENT MULTIPLE API CALLS FOR THE SAME DATA. 
            $schoolData = format_data($schoolData->SingleSchool);
            $minYear; 
            $maxYear;
            $minYear = $year = get_field("performance_min_year");
            $maxYear = get_field("performance_max_year");
            $SPARData = get_SPAR_data($minYear, $maxYear, $districtId, $schoolId);

            foreach ($schoolData as $key => $schoolDataYear) {
                $schoolData[$key] = get_object_vars($schoolDataYear);
            } 

            $schoolName = ucwords(strtolower($schoolData[count($schoolData)-1]["SCHOOL_NAME_LONG"]));

            // END API CALL

            require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

            $modal_content = '<div class="sd-modal-content sd-modal-content-' . $post->ID . ' sd-modal-content-grade-history" data-postid="' . $post->ID . '">';
            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/grade-history.php' );
            $modal_content .= '</div>';

            $modal_content .= '<div class="sd-modal-content sd-modal-content-' . $post->ID . ' sd-modal-content-spar-ela-table" data-postid="' . $post->ID . '">';
            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-ela-table.php' );
            $modal_content .= '</div>';

            $modal_content .= '<div class="sd-modal-content sd-modal-content-' . $post->ID . ' sd-modal-content-spar-reading-table" data-postid="' . $post->ID . '">';
            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-read-table.php' );
            $modal_content .= '</div>';

            $modal_content .= '<div class="sd-modal-content sd-modal-content-' . $post->ID . ' sd-modal-content-spar-math-table" data-postid="' . $post->ID . '">';
            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-math-table.php' );
            $modal_content .= '</div>';

            $modal_content .= '<div class="sd-modal-content sd-modal-content-' . $post->ID . ' sd-modal-content-spar-science-table" data-postid="' . $post->ID . '">';
            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-science-table.php' );
            $modal_content .= '</div>';

        }

    }

    if ( $modal_content != "" ) { 

        ?>
        <div id="modal-container" class="<?php echo $modalClasses; ?>clearfix">
            <div class="container">
                <div class="sd-modal-header">
                    <div class="container">
                        <a href="#" id="logo-modal" class="logo-modal-link"></a>
                        <a href="#" id="close-modal" class="close-modal-link">
                            <div class="close-container">
                                <img class="inject-me" data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-close.svg" />
                            </div>
                        </a>
                    </div>
                </div>
                <?php echo $modal_content; ?>
            </div>
        </div>
        <?php 

    } else {

        ?>
        <div id="modal-container" class="<?php echo $modalClasses; ?>clearfix">
            <div class="container">
                <div class="sd-modal-header">
                    <div class="container">
                        <a href="#" id="logo-modal" class="logo-modal-link"></a>
                        <a href="#" id="close-modal" class="close-modal-link">
                            <div class="close-container">
                                <img class="inject-me" data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-close.svg" />
                            </div>
                        </a>
                    </div>
                </div>
                <?php echo $modal_content; ?>
            </div>
        </div>
        <?php 
    
    }

?>

<!--// OPEN #container //-->
<div id="container" class="<?php echo $containerClasses; ?> clearfix">

    <?php
        /**
         * @hooked - sf_mobile_header - 10
         * @hooked - sf_header_wrap - 20
         **/
        do_action( 'sf_container_start' );
    ?>

    <!--// OPEN #main-container //-->
    <div id="main-container" class="clearfix">

<?php
    /**
     * @hooked - sf_pageslider - 10 (if standard)
     * @hooked - sf_breadcrumbs - 20
     * @hooked - sf_page_heading - 30
     **/
    do_action( 'sf_main_container_start' );
?>