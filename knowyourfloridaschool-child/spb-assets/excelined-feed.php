<?php

    /*
    *
    *	Swift Page Builder - Blog Shortcode
    *	------------------------------------------------
    *	Swift Framework
    * 	Copyright Swift Ideas 2015 - http://www.swiftideas.com
    *
    */
    
    if ( file_exists( get_stylesheet_directory() . '/template-parts/page/search/excelined-filters.php' ) ) { 
        include_once( get_stylesheet_directory() . '/template-parts/page/search/excelined-filters.php' );
    }
    
    if ( file_exists( get_stylesheet_directory() . '/template-parts/page/search/excelined-feed.php' ) ) { 
        include_once( get_stylesheet_directory() . '/template-parts/page/search/excelined-feed.php' );
    }

    class SwiftPageBuilderShortcode_spb_florida_schools_feed extends SwiftPageBuilderShortcode {

        protected function content( $atts, $content = null ) {

            $width = $el_class = $output = $gutters = $fullwidth = $advanced_search = $columns = $hover_style = $show_read_more = $offset = $order = $content_output = $items = $item_figure = $el_position = '';

            extract( shortcode_atts( array(
                'pagination'            => 'no',
                'blog_filter'           => '',
                'el_position'           => '',
                'advanced_search'       => 'no',
                'columns'               => '1',
                'width'                 => '1/1',
                'el_class'              => ''
            ), $atts ) );

            $width = spb_translateColumnWidthToSpan( $width );

            /* SIDEBAR CONFIG
            ================================================== */
            $sidebar_config = sf_get_post_meta( get_the_ID(), 'sf_sidebar_config', true );

            $sidebars = '';
            if ( ( $sidebar_config == "left-sidebar" ) || ( $sidebar_config == "right-sidebar" ) ) {
                $sidebars = 'one-sidebar';
            } else if ( $sidebar_config == "both-sidebars" ) {
                $sidebars = 'both-sidebars';
            } else {
                $sidebars = 'no-sidebars';
            }

            $columns = $atts["columns"] = 1;

            /* BLOG ITEMS
            ================================================== */
            if ( isset($_GET["s"]) && $_GET["s"] != "" ) {
                $atts["keyword"] = str_replace('"', "", stripslashes(rawurldecode($_GET["s"])));
            }
            if ( isset($_GET["search"]) && $_GET["search"] != "" ) {
                $atts["search"] = $_GET["search"];
            } else {
                $atts["search"] = "keyword";
            }
            $currentYear = date("Y");
            if ( isset($_GET["districtid"]) ) {
                $atts["districtid"] = $_GET["districtid"];
            }
            if ( isset($_GET["zip"]) ) {
                $atts["zip"] = $_GET["zip"];
            }
            if ( isset($_GET["schoolgrade"]) ) {
                $atts["schoolgrade"] = $_GET["schoolgrade"];
            }
            if ( isset($_GET["type"]) ) {
                $atts["type"] = $_GET["type"];
            }
            if ( isset($_GET["magnetstatus"]) ) {
                $atts["magnetstatus"] = $_GET["magnetstatus"];
            }
            if ( isset($_GET["charterschool"]) ) {
                $atts["charterschool"] = $_GET["charterschool"];
            }
            if ( isset($_GET["address"]) ) {
                $atts["address"] = $_GET["address"];
            }
            if ( isset($_GET["lat"]) ) {
                $atts["lat"] = $_GET["lat"];
            }
            if ( isset($_GET["long"]) ) {
                $atts["long"] = $_GET["long"];
            }
            if ( isset($_GET["sradius"]) ) {
                $atts["sradius"] = $_GET["sradius"];
            }
            if ( isset($_GET["pageNum"]) ) {
                $atts["pageNum"] = $_GET["pageNum"];
            } else {
                $atts["pageNum"] = 1;
            }
            if ( isset($_GET["hitsperpage"]) ) {
                $atts["hitsperpage"] = $_GET["hitsperpage"];
            } else {
                $atts["hitsperpage"] = 10;
            }
            if ( isset($_GET["sortBy"]) ) {
                $atts["sortBy"] = $_GET["sortBy"];
            }
            if ( isset($_GET["arrange"]) ) {
                $atts["arrange"] = $_GET["arrange"];
            }

            $items = sf_florda_schools_feed_items( $atts );


            /* FINAL OUTPUT
            ================================================== */
            $title_wrap_class = "";
            if ( $blog_filter == "yes" ) {
                $title_wrap_class .= 'has-filter ';
            }
            if ( $fullwidth == "yes" && $sidebars == "no-sidebars" ) {
                $title_wrap_class .= 'container ';
            }
            $el_class = $this->getExtraClass( $el_class );

            $output .= "\n\t" . '<div class="spb_blog_widget blog-wrap excelined-feed spb_content_element ' . $width . $el_class . '">';
            $output .= "\n\t\t" . '<div class="spb-asset-content">';
                $output .= "\n\t\t" . '<div class="row">';
                    $output .= "\n\t\t" . '<div class="container">';
                        $output .= "\n\t\t" . '<div class="row">';
                            $output .= "\n\t\t" . '<div class="results-info-wrap col-md-7">';
                            if ( isset($_GET["search"]) && $_GET["search"] == "keyword" ) {
                                if ( isset($_GET["s"]) && $_GET["s"] != "" ) {
                                    $output .= "\n\t\t\t" . '<div class="results-keyword"><h5>SEARCH RESULTS FOR</h5><h2>' . str_replace('"', "", stripslashes(rawurldecode($_GET["s"]))) . '</h2></div>';
                                }
                            } else if ( isset($_GET["search"]) && $_GET["search"] == "geo" ) {
                                if ( isset($_GET["address"]) && $_GET["address"] != "" ) {
                                    $output .= "\n\t\t\t" . '<div class="results-keyword"><h5>SEARCH RESULTS FOR</h5><h2>' . $_GET["address"] . '</h2></div>';
                                }
                            }
                            $output .= "\n\t\t" . '</div>';
                            $output .= "\n\t\t" . '<div class="sortby-wrap ';
                            if ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "geo" ) {
                                $output .= "\n\t\t" . 'hidden ';
                            }
                            $output .= "\n\t\t" . 'col-md-5 clearfix">';
                                $output .= "\n\t\t" . '<div class="wrap-filter filter-sortby">' . "\n";

                                    $output .= '<label for="sortBy" class="filter-label">Sort By</label>';
                                    $output .= "\n\t\t" . '<div class="select-wrap"><select name="sortBy" class="school-feed-filter">';
                                        if ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "geo" ) {
                                            $output .= "\n\t\t" . '<option value="">Distance</option>';
                                        } else {
                                            $output .= "\n\t\t" . '<option value="SchoolName">School Name</option>';
                                        }
                                        $output .= "\n\t\t" . '<option value="SchoolGrade" ';
                                        if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SchoolGrade" ) {
                                            $output .= "\n\t\t" . 'SELECTED';
                                        }
                                        $output .= "\n\t\t" . '>School Grade</option>';
                                        if ( $advanced_search == "yes" ) {

                                            $output .= "\n\t\t" . '<option value="SGCS_PercentofTotalPossiblePoints" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_PercentofTotalPossiblePoints" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>Percent of Points Earned</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_EnglishLanguageArts_Achievement" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_EnglishLanguageArts_Achievement" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>ELA Achievement</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_Mathematics_Achievement" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_Mathematics_Achievement" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>Mathematics Achievement</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_Science_Achievement" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_Science_Achievement" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>Science Achievement</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_SocialStudies_Achievement" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_SocialStudies_Achievement" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>Social Studies Achievement</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_EnglishLanguageArts_LearningGains" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_EnglishLanguageArts_LearningGains" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>ELA Learning Gains</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_Mathematics_LearningGains" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_Mathematics_LearningGains" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>Mathematics Learning Gains</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_EnglishLanguageArts_LearningGainsLow25" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_EnglishLanguageArts_LearningGainsLow25" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>ELA Learning Gains Lowest 25%</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_Mathematics_LearningGainsLow25" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_Mathematics_LearningGainsLow25" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>Mathematics Learning Gains Lowest 25%</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_MiddleSchoolAcceleration" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_MiddleSchoolAcceleration" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>Middle School Acceleration</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_CollegeandCareerAccelerationLagged" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_CollegeandCareerAccelerationLagged" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>High School Acceleration</option>';

                                            $output .= "\n\t\t" . '<option value="SGCS_GraduationRateLagged" ';
                                            if ( isset($_GET["sortBy"]) &&  !empty($_GET["sortBy"]) && $_GET["sortBy"] == "SGCS_GraduationRateLagged" ) {
                                                $output .= "\n\t\t" . 'SELECTED';
                                            }
                                            $output .= "\n\t\t" . '>Graduation Rate</option>';

                                        }
                                    $output .= '</select></div>';
                        
                                $output .= '</div>' . "\n";
                                $output .= "\n\t\t" . '<div class="wrap-filter filter-arrange">' . "\n";

                                    $output .= '<label for="arrange" class="filter-label">Arrange</label>';
                                    $output .= "\n\t\t" . '<div class="select-wrap"><select name="arrange" class="school-feed-filter">';
                                        $output .= "\n\t\t" . '<option value="A" ';
                                        if ( isset($_GET["arrange"]) &&  !empty($_GET["arrange"]) && $_GET["arrange"] == "D" ) { } else {
                                            $output .= "\n\t\t" . 'SELECTED';
                                        }
                                        $output .= "\n\t\t" . '>Ascending</option>';
                                        $output .= "\n\t\t" . '<option value="D" ';
                                        if ( isset($_GET["arrange"]) &&  !empty($_GET["arrange"]) && $_GET["arrange"] == "D" ) {
                                            $output .= "\n\t\t" . 'SELECTED';
                                        }
                                        $output .= "\n\t\t" . '>Descending</option>';
                                    $output .= '</select></div>';
                        
                                $output .= '</div>' . "\n";
                        $output .= "\n\t\t" . '</div></div>';
                    $output .= "\n\t\t" . '</div>';
                $output .= "\n\t\t" . '</div>';
                $output .= "\n\t\t" . '<div class="row">';
                    $output .= "\n\t\t" . '<div class="container">';
                        if ( $blog_filter == "yes" ) {
                            $output .= "\n\t\t" . '<div class="title-wrap clearfix col-md-4 advanced-options-open ' . $title_wrap_class . '">';
                            if ( $blog_filter == "yes" ) {
                                $output .= sf_florda_schools_feed_filters();
                            }
                            $output .= '</div>';
                            $output .= "\n\t\t" . '<div class="col-md-8 clearfix">' . $items . '</div>';
                        } else {
                            $output .= "\n\t\t" . '<div class="col-md-12 clearfix">' . $items . '</div>';
                        }
                    $output .= "\n\t\t" . '</div>';
                $output .= "\n\t\t" . '</div>';
            $output .= "\n\t\t" . '</div>';
            $output .= "\n\t" . '</div> ' . $this->endBlockComment( $width );

            $output = $this->startRow( $el_position ) . $output . $this->endRow( $el_position );
            
            global $sf_has_blog, $sf_include_imagesLoaded;
            $sf_include_imagesLoaded = true;
            $sf_has_blog             = true;

            return $output;

        }
    }

    /* PARAMS
    ================================================== */
    $params = array(
        array(
            "type"        => "buttonset",
            "heading"     => __( "Filter", 'swift-framework-plugin' ),
            "param_name"  => "blog_filter",
            "std"         => "yes",
            "value"       => array(
                __( 'No', 'swift-framework-plugin' )  => "no",
                __( 'Yes', 'swift-framework-plugin' ) => "yes"
            ),
            "description" => __( "Show the blog category filter above the items.", 'swift-framework-plugin' )
        ),
        array(
            "type"        => "dropdown",
            "heading"     => __( "Pagination", 'swift-framework-plugin' ),
            "param_name"  => "pagination",
            "value"       => array(
                __( "Load more (AJAX)", 'swift-framework-plugin' ) => "load-more",
                __( "Infinite scroll", 'swift-framework-plugin' )  => "infinite-scroll",
                __( "Standard", 'swift-framework-plugin' )         => "standard",
                __( "None", 'swift-framework-plugin' )             => "none"
            ),
            "description" => __( "Select how you would like this feed to paginate.", 'swift-framework-plugin' )
        ),
    );

    $params[] = array(
        "type"       => "section",
        "param_name" => "advanced_options",
        "heading"    => __( "Advanced Options", 'swift-framework-plugin' ),
    );

    $params[] = array(
        "type"        => "buttonset",
        "heading"     => __( "Advanced Search", 'swift-framework-plugin' ),
        "param_name"  => "advanced_search",
        "std"         => "no",
        "value"       => array(
            __( 'No', 'swift-framework-plugin' )  => "no",
            __( 'Yes', 'swift-framework-plugin' ) => "yes"
        ),
        "description" => __( "Show advanced search options with more detail around statistics.", 'swift-framework-plugin' )
    );

    $params[] = array(
        "type"        => "textfield",
        "heading"     => __( "Extra class", 'swift-framework-plugin' ),
        "param_name"  => "el_class",
        "value"       => "",
        "description" => __( "If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'swift-framework-plugin' )
    );

    /* SHORTCODE MAP
    ================================================== */
    SPBMap::map( 'spb_florida_schools_feed', array(
        "name"   => __( "Florida Schools Feed", 'swift-framework-plugin' ),
        "base"   => "spb_florida_schools_feed",
        "class"  => "spb_florida_schools_feed",
        "icon"   => "spb-icon-blog",
        "params" => $params
    ) );
