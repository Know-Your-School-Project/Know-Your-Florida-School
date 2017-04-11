<?php 

    /* API CALL
    ================================================== */
    if ( ! function_exists( 'excelined_atts_to_url' ) ) {

        function excelined_atts_to_url( $atts ) {

            $blog_type = $pagination = $blog_filter = $pageNum = $hitsperpage = $districtid = $zip = $schoolgrade = $type = $magnetstatus = $charterschool = $lat = $long = $keyword = $offset = "";

            extract( shortcode_atts( array(
                'blog_type'          => 'mini',
                'pagination'         => 'no',
                'blog_filter'        => '',
                'pageNum'            => '1',
                'hitsperpage'        => '10',
                'districtid'         => '',
                'zip'                => '',
                'schoolgrade'        => '',
                'type'               => '',
                'magnetstatus'       => '',
                'charterschool'      => '',
                'address'            => '',
                'lat'                => '',
                'long'               => '',
                'sradius'            => '',
                'keyword'            => '',
                'search'             => '',
                'advanced_search'    => '',
                'sortBy'             => '',
                'arrange'            => '',
            ), $atts ) );

            require( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );

            /* QUERY SETUP
            ================================================== */

            if ( $pageNum == "" ) {
                if ( get_query_var( 'paged' ) ) {
                    $pageNum  = get_query_var( 'paged' );
                    $offset = $offset + ( $atts["hitsperpage"] * ( $pageNum - 1 ) );
                } elseif ( get_query_var( 'pageNum' ) ) {
                    $pageNum  = get_query_var( 'pageNum' );
                    $offset = $offset + ( $atts["hitsperpage"] * ( $pageNum - 1 ) );
                } else {
                    $pageNum = 1;
                    $offset = $offset + ( $atts["hitsperpage"] * ( $pageNum - 1 ) );
                }
            } else {
                $offset = $offset + ( $atts["hitsperpage"] * ( $pageNum - 1 ) );
            }

            // ROOT AND PAGINATION FOR API CALL
            $requestURL = "https://api.jaxpef.org/schoolsearch/search/" . $pageNum . "/" . $atts["hitsperpage"] . "/?APIKey=" . $apiKEY;
            
            // FILTER BY DISTRICT
            if ( isset($atts["districtid"]) && !empty($atts["districtid"]) && $atts["districtid"] != "" ) {
                $requestURL .= "&districtid=" . $atts["districtid"];
            } else {
                $requestURL .= "&districtid=";
            }

            // FILTER BY ZIPCODE
            if ( isset($atts["zip"]) && !empty($atts["zip"]) && $atts["zip"] != "" ) {
                $requestURL .= "&physical_zip=" . $atts["zip"];
            } else {
                $requestURL .= "&physical_zip=";
            }

            // FILTER BY SCHOOL GRADE
            if ( isset($atts["schoolgrade"]) && !empty($atts["schoolgrade"]) && $atts["schoolgrade"] != "" ) {
                $requestURL .= "&SchoolGrade=" . $atts["schoolgrade"];
            } else {
                $requestURL .= "&SchoolGrade=";
            }

            // FILTER BY SCHOOL TYPE
            if ( isset($atts["type"]) && !empty($atts["type"]) && $atts["type"] != "" ) {
                $requestURL .= "&TYPE=" . $atts["type"];
            } else {
                $requestURL .= "&TYPE=";
            }

            // FILTER BY MAGNET STATUS
            if ( isset($atts["magnetstatus"]) && !empty($atts["magnetstatus"]) && $atts["magnetstatus"] != "" ) {
                $requestURL .= "&MAGNET_STATUS=" . $atts["magnetstatus"];
            } else {
                $requestURL .= "&MAGNET_STATUS=";
            }

            // FILTER BY CHARTER SCHOOL STATUS
            if ( isset($atts["charterschool"]) && !empty($atts["charterschool"]) && $atts["charterschool"] != "" ) {
                $requestURL .= "&CharterSchool=" . $atts["charterschool"];
            } else {
                $requestURL .= "&CharterSchool=";
            }

            // FILTER BY GEOLOCATION
            if ( isset($atts["lat"]) && !empty($atts["lat"]) && $atts["lat"] != "" && 
                 isset($atts["long"]) && !empty($atts["long"]) && $atts["long"] != "" && 
                 isset($atts["sradius"]) && !empty($atts["sradius"]) && $atts["sradius"] != "" ) {
                $requestURL .= "&lat=" . $atts["lat"] . "&long=" . $atts["long"] . "&sradius=" . $atts["sradius"];
            } else {
                $requestURL .= "&lat=&long=&sradius=";
            }

            // FILTER BY KEYWORD
            if ( isset($atts["keyword"]) && !empty($atts["keyword"]) && $atts["keyword"] != "" ) {
                $requestURL .= "&kWord=" . urlencode($atts["keyword"]);
            } else {
                $requestURL .= "&kWord=";
            }

            // FILTER BY KEYWORD
            if ( isset($atts["sortBy"]) && !empty($atts["sortBy"]) && $atts["sortBy"] != "" ) {
                $requestURL .= "&sortBy=" . urlencode($atts["sortBy"]);
            } else {
                $requestURL .= "&sortBy=";
            }

            // FILTER BY KEYWORD
            if ( isset($atts["arrange"]) && !empty($atts["arrange"]) && $atts["arrange"] != "" ) {
                $requestURL .= "&sortDirection=" . urlencode($atts["arrange"]);
            } else {
                $requestURL .= "&sortDirection=";
            }

            return $requestURL;

        }

    };

    /* NEXT PAGE PARAMETERS
    ================================================== */
    if ( ! function_exists( 'excelined_change_page' ) ) {

        function excelined_change_page( $atts, $new_page ) {

            global $post;

            $blog_type = $pagination = $blog_filter = $pageNum = $hitsperpage = $districtid = $zip = $schoolgrade = $type = $magnetstatus = $charterschool = $lat = $long = $keyword = $offset = "";

            extract( shortcode_atts( array(
                'blog_type'          => 'mini',
                'pagination'         => 'no',
                'blog_filter'        => '',
                'pageNum'            => '1',
                'hitsperpage'        => '10',
                'districtid'         => '',
                'zip'                => '',
                'schoolgrade'        => '',
                'type'               => '',
                'magnetstatus'       => '',
                'charterschool'      => '',
                'address'            => '',
                'lat'                => '',
                'long'               => '',
                'sradius'            => '',
                'keyword'            => '',
                'search'             => '',
                'advanced_search'    => '',
                'sortBy'             => '',
                'arrange'            => '',
            ), $atts ) );

            require( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );

            /* QUERY SETUP
            ================================================== */

            if ( $pageNum == "" ) {
                if ( get_query_var( 'paged' ) ) {
                    $pageNum  = get_query_var( 'paged' );
                    $offset = $offset + ( $atts["hitsperpage"] * ( $pageNum - 1 ) );
                } elseif ( get_query_var( 'pageNum' ) ) {
                    $pageNum  = get_query_var( 'pageNum' );
                    $offset = $offset + ( $atts["hitsperpage"] * ( $pageNum - 1 ) );
                } else {
                    $pageNum = 1;
                    $offset = $offset + ( $atts["hitsperpage"] * ( $pageNum - 1 ) );
                }
            } else {
                $offset = $offset + ( $atts["hitsperpage"] * ( $pageNum - 1 ) );
            }

            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $baseURL = $protocol . $_SERVER['SERVER_NAME'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            // ROOT AND PAGINATION FOR API CALL
            if ( isset($atts["search"]) && !empty($atts["search"]) && $atts["search"] != "" ) {
                $requestURL = $baseURL . "?search=" . $atts["search"];
            } else {
                $requestURL = $baseURL . "?search=keyword";
            }

            if ( isset($atts["keyword"]) && !empty($atts["keyword"]) && $atts["keyword"] != "" ) {
                $requestURL .= "&s=" . urlencode($atts["keyword"]);
            } else {
                $requestURL .= "&s=";
            }

            // FILTER BY DISTRICT
            if ( isset($atts["districtid"]) && !empty($atts["districtid"]) && $atts["districtid"] != "" ) {
                $requestURL .= "&districtid=" . rawurlencode($atts["districtid"]);
            }

            // FILTER BY ZIPCODE
            if ( isset($atts["zip"]) && !empty($atts["zip"]) && $atts["zip"] != "" ) {
                $requestURL .= "&zip=" . rawurlencode($atts["zip"]);
            }

            // FILTER BY SCHOOL GRADE
            if ( isset($atts["schoolgrade"]) && !empty($atts["schoolgrade"]) && $atts["schoolgrade"] != "" ) {
                $requestURL .= "&schoolgrade=" . rawurlencode($atts["schoolgrade"]);
            }

            // FILTER BY SCHOOL TYPE
            if ( isset($atts["type"]) && !empty($atts["type"]) && $atts["type"] != "" ) {
                $requestURL .= "&type=" . rawurlencode($atts["type"]);
            }

            // FILTER BY MAGNET STATUS
            if ( isset($atts["magnetstatus"]) && !empty($atts["magnetstatus"]) && $atts["magnetstatus"] != "" ) {
                $requestURL .= "&magnetstatus=" . rawurlencode($atts["magnetstatus"]);
            }

            // FILTER BY CHARTER SCHOOL STATUS
            if ( isset($atts["charterschool"]) && !empty($atts["charterschool"]) && $atts["charterschool"] != "" ) {
                $requestURL .= "&charterschool=" . rawurlencode($atts["charterschool"]);
            }

            // FILTER BY GEOLOCATION
            if ( isset($atts["address"]) && !empty($atts["address"]) && $atts["address"] != "" && 
                 isset($atts["lat"]) && !empty($atts["lat"]) && $atts["lat"] != "" && 
                 isset($atts["long"]) && !empty($atts["long"]) && $atts["long"] != "" && 
                 isset($atts["sradius"]) && !empty($atts["sradius"]) && $atts["sradius"] != "" ) {
                $requestURL .= "&address=" . rawurlencode($atts["address"]) . "&lat=" . rawurlencode($atts["lat"]) . "&long=" . rawurlencode($atts["long"]) . "&sradius=" . rawurlencode($atts["sradius"]);
            }

            // PAGE
            $requestURL .= "&pageNum=" . rawurlencode($new_page);

            // HITS PER PAGE
            if ( isset($atts["hitsperpage"]) && !empty($atts["hitsperpage"]) && $atts["hitsperpage"] != "" ) {
                $requestURL .= "&hitsperpage=" . rawurlencode($atts["hitsperpage"]);
            }

            // SORTING
            if ( isset($atts["sortBy"]) && !empty($atts["sortBy"]) && $atts["sortBy"] != "" ) {
                $requestURL .= "&sortBy=" . rawurlencode($atts["sortBy"]);
            }

            // SORTING
            if ( isset($atts["arrange"]) && !empty($atts["arrange"]) && $atts["arrange"] != "" ) {
                $requestURL .= "&arrange=" . rawurlencode($atts["arrange"]);
            }

            return $requestURL;

        }

    };

    /* FLORDA SCHOOLS FEED ITEMS
    ================================================== */
    if ( ! function_exists( 'sf_florda_schools_feed_items' ) ) {

        function sf_florda_schools_feed_items( $atts ) {

            $blog_type = $pagination = $blog_filter = $pageNum = $hitsperpage = $districtid = $zip = $schoolgrade = $type = $magnetstatus = $charterschool = $lat = $long = $keyword = $offset = "";

            extract( shortcode_atts( array(
                'blog_type'          => 'masonry',
                'columns'            => '3',
                'pagination'         => 'no',
                'blog_filter'        => '',
                'pageNum'            => '1',
                'hitsperpage'        => '10',
                'districtid'         => '',
                'zip'                => '',
                'schoolgrade'        => '',
                'type'               => '',
                'magnetstatus'       => '',
                'charterschool'      => '',
                'address'            => '',
                'lat'                => '',
                'long'               => '',
                'sradius'            => '',
                'keyword'            => '',
                'search'             => '',
                'advanced_search'    => '',
                'sortBy'             => '',
                'arrange'            => '',
            ), $atts ) );

            $blog_items_output = "";

            global $sf_sidebar_config;

            require( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );
            require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

            // SCHOOL TYPES
            $schoolTypes = api_call("https://api.jaxpef.org/schooltypes/schooltype/?APIKey=" . $apiKEY, get_stylesheet_directory() . "/cache/type.json");
    
            $requestURL = excelined_atts_to_url( $atts );

            /* LIST CLASS CONFIG
            ================================================== */
            $list_class = $wrap_class = '';
            $list_class = 'masonry-items';
            if ( $columns > 1 ) {
                $list_class .= ' gutters';
            }

            if ( $pagination == "infinite-scroll" ) {
                $list_class .= ' blog-inf-scroll';
            } else if ( $pagination == "load-more" ) {
                $list_class .= ' blog-load-more';
            }

            /* BLOG ITEMS OUTPUT
            ================================================== */
            try {

                $blog_items_output .= '<div class="row"><div class="blog-items-wrap blog-' . $blog_type . ' ' . $wrap_class . '">';
      
                if ( $columns == "5" ) {
                    $item_class = "col-sm-sf-5";
                } else if ( $columns == "4" ) {
                    $item_class = "col-sm-3";
                } else if ( $columns == "3" ) {
                    $item_class = "col-sm-4";
                } else if ( $columns == "2" ) {
                    $item_class = "col-sm-6";
                } else if ( $columns == "1" ) {
                    $item_class = "col-sm-12";
                }

                if ( ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "geo" && isset($_GET["address"]) && !empty($_GET["address"]) && $_GET["address"] != "" ) && ( $_GET["lat"] == "" || $_GET["long"] == "" ) ) {

                    // IF GOOGLE WAS NOT ABLE TO FIND AN ADDRESS

                    $blog_items_output .= '<div class="col-md-12 no-results"><h2>We could not find this address. Try again.</h2></div>';

                } else if ( ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "district" ) && ( !isset($_GET["districtid"]) || empty($_GET["districtid"]) || $_GET["districtid"] == "" || !is_int(intval($_GET["districtid"])) ) ) {

                    // IF THE DISTRICT WAS NOT FOUND

                    $blog_items_output .= '<div class="col-md-12 no-results"><h2>We could not locate this district. Try again.</h2></div>';

                } else {

                    $schoolData = file_get_contents( $requestURL );

                    $schoolData = json_decode( $schoolData );

                    if ( count( $schoolData->SearchData ) > 0 ) {

                        $blog_items_output .= '<ul class="blog-items ' . $list_class . ' clearfix" data-blog-type="' . $blog_type . '" data-atts="' . rawurlencode(json_encode($atts)) . '" data-paged="' . $pageNum . '" data-template="florida_schools_feed">';

                        foreach ($schoolData->SearchData as $school) {

                            $school = get_object_vars($school);

                            /* BLOG ITEM OUTPUT
                            ================================================== */
                            $blog_items_output .= '<li class="blog-item ' . $item_class . ' school-' . $school["SCHOOLID"] . ' grade-' . $school["SchoolGrade"] . ' ';
                            if ( isset($_COOKIE["compare-schools"]) && !empty($_COOKIE["compare-schools"]) && $_COOKIE["compare-schools"] != "" && in_array( json_decode(json_encode(["districtid" => $school["DISTRICTID"],"schoolid" => $school["SCHOOLID"],"schoolname" => $school["SCHOOL_NAME_LONG"]])), json_decode(stripslashes($_COOKIE["compare-schools"])) ) ) {
                                $blog_items_output .= 'selected-to-compare ';
                            }
                            $blog_items_output .= 'page type-page status-publish hentry" data-schoolid="' . $school["SCHOOLID"] . '">';
                                $blog_items_output .= '<div class="school-card">';
                                    $blog_items_output .= '<div class="school-compare-input">';
                                    $blog_items_output .= '<i class="icon-school"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/masonry-item-school.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/masonry-item-school-grey.png" /></i>';
                                    $blog_items_output .= '<label>Add To My Schools <input type="checkbox" name="compare-school" id="compare-school-' . $school["SCHOOLID"] . '" value="' . $school["SCHOOLID"] . '" data-schoolid="' . $school["SCHOOLID"] . '" data-districtid="' . $school["DISTRICTID"] . '" data-schoolname="' . $school["SCHOOL_NAME_LONG"] . '"';
                            
                                    if ( isset($_COOKIE["compare-schools"]) && !empty($_COOKIE["compare-schools"]) && $_COOKIE["compare-schools"] != "" && in_array( json_decode(json_encode(["districtid" => $school["DISTRICTID"],"schoolid" => $school["SCHOOLID"],"schoolname" => $school["SCHOOL_NAME_LONG"]])), json_decode(stripslashes($_COOKIE["compare-schools"])) ) ) {
                                        $blog_items_output .= ' CHECKED';
                                    }
                                    
                                    $blog_items_output .= ' /></label></div>';
                                    if ( $school["SchoolGrade"] != "" && $school["SchoolGrade"] != "I" ) {
                                        $blog_items_output .= '<div class="school-grade"><div class="school-grade-letter">' . $school["SchoolGrade"] . '</div></div>';
                                    } else if ( $school["SchoolGrade"] == "I" ) {
                                        $blog_items_output .= '<div class="school-grade"><div class="school-grade-letter">' . $school["SchoolGrade"] . '</div></div>';
                                    } else {
                                        $blog_items_output .= '<div class="school-grade"><div class="school-grade-letter">--</div></div>';
                                    }
                                    $blog_items_output .= '<div class="school-stats-wrap">';
                                        $blog_items_output .= '<a href="' . get_home_url() . '/school-report-card/?schoolid=' . $school["SCHOOLID"] . '&districtid=' . $school["DISTRICTID"] . '"><div class="school-name">' . ucwords(strtolower($school["SCHOOL_NAME_LONG"])) . '</div></a>';
                                        if ( count($schoolTypes->SchoolType) > 0 ) {
                                            $blog_items_output .= '<div class="school-type">';
                                            if ( $school["TYPE"] != "" ) {
                                                foreach ($schoolTypes->SchoolType as $schoolType) {
                                                    if ( $schoolType->SCHOOLTYPE == $school["TYPE"] ) {
                                                        $blog_items_output .= $schoolType->TYPENAME;
                                                    }
                                                }
                                            }
                                            $blog_items_output .= '</div>';
                                        }
                                        if ( $school["PHYSICAL_ADDRESS"] != "" ||
                                             $school["PHYSICAL_CITY"] != "" ||
                                             $school["PHYSICAL_STATE"] != "" ||
                                             $school["PHYSICAL_ZIP"] != "" ) {
                                            $blog_items_output .= '<div class="school-address">';
                                            if ( $school["PHYSICAL_ADDRESS"] != "" ) {
                                                $blog_items_output .= $school["PHYSICAL_ADDRESS"] . '<br />';
                                            }
                                            $blog_items_output .= $school["PHYSICAL_CITY"] . ', ' . $school["PHYSICAL_STATE"] . ' ' . $school["PHYSICAL_ZIP"] . '</div>';
                                        }
                                        $blog_items_output .= '<a class="view-full-reportcard-link" href="' . get_home_url() . '/school-report-card/?schoolid=' . $school["SCHOOLID"] . '&districtid=' . $school["DISTRICTID"] . '"><i class="icon-view-full-reportcard"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-view-full-reportcard.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-view-full-reportcard.png" /></i> View Full Reportcard</a>';
                                    $blog_items_output .= '</div>';

                                    if ( $advanced_search == "yes" ) {

                                        $blog_items_output .= '<div class="school-stats clearfix">';

                                            $blog_items_output .= '<div class="row"><div class="col-md-6">';

                                                /* Percent of Points Earned */
                                                $blog_items_output .= '<div class="school-stat school-stat-pointedearned clearfix';
                                                if ( !isset($school["SGCS_PercentofTotalPossiblePoints"]) || empty ($school["SGCS_PercentofTotalPossiblePoints"]) || $school["SGCS_PercentofTotalPossiblePoints"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_PercentofTotalPossiblePoints" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>Percent of Total Points Earned</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">Percent of Total Points Earned</div>';
                                                    }
                                                    if ( !isset($school["SGCS_PercentofTotalPossiblePoints"]) || empty ($school["SGCS_PercentofTotalPossiblePoints"]) || $school["SGCS_PercentofTotalPossiblePoints"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_PercentofTotalPossiblePoints"] . '%</div>';
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* ELA Achievement */
                                                $blog_items_output .= '<div class="school-stat school-stat-ela-achievement clearfix';
                                                if ( !isset($school["SGCS_EnglishLanguageArts_Achievement"]) || empty ($school["SGCS_EnglishLanguageArts_Achievement"]) || $school["SGCS_EnglishLanguageArts_Achievement"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_EnglishLanguageArts_Achievement" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>ELA Achievement</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">ELA Achievement</div>';
                                                    }
                                                    if ( !isset($school["SGCS_EnglishLanguageArts_Achievement"]) || empty ($school["SGCS_EnglishLanguageArts_Achievement"]) || $school["SGCS_EnglishLanguageArts_Achievement"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_EnglishLanguageArts_Achievement"] . '%</div>';
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* Math Achievement */
                                                $blog_items_output .= '<div class="school-stat school-stat-math-achievement clearfix';
                                                if ( !isset($school["SGCS_Mathematics_Achievement"]) || empty ($school["SGCS_Mathematics_Achievement"]) || $school["SGCS_Mathematics_Achievement"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_Mathematics_Achievement" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>Math Achievement</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">Math Achievement</div>';
                                                    }
                                                    if ( !isset($school["SGCS_Mathematics_Achievement"]) || empty ($school["SGCS_Mathematics_Achievement"]) || $school["SGCS_Mathematics_Achievement"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_Mathematics_Achievement"] . '%</div>';
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* Science Achievement */
                                                $blog_items_output .= '<div class="school-stat school-stat-science-achievement clearfix';
                                                if ( !isset($school["SGCS_Science_Achievement"]) || empty ($school["SGCS_Science_Achievement"]) || $school["SGCS_Science_Achievement"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_Science_Achievement" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>Science Achievement</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">Science Achievement</div>';
                                                    }
                                                    if ( !isset($school["SGCS_Science_Achievement"]) || empty ($school["SGCS_Science_Achievement"]) || $school["SGCS_Science_Achievement"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_Science_Achievement"] . '%</div>';
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* Social Studies Achievement */
                                                $blog_items_output .= '<div class="school-stat school-stat-socialstudies-achievement clearfix';
                                                if ( !isset($school["SGCS_SocialStudies_Achievement"]) || empty ($school["SGCS_SocialStudies_Achievement"]) || $school["SGCS_SocialStudies_Achievement"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_SocialStudies_Achievement" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>Social Studies Achievement</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">Social Studies Achievement</div>';
                                                    }
                                                    if ( !isset($school["SGCS_SocialStudies_Achievement"]) || empty ($school["SGCS_SocialStudies_Achievement"]) || $school["SGCS_SocialStudies_Achievement"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_SocialStudies_Achievement"] . '%</div>';
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* ELA Learning Gains */
                                                $blog_items_output .= '<div class="school-stat school-stat-ela-learning-gains clearfix';
                                                if ( !isset($school["SGCS_EnglishLanguageArts_LearningGains"]) || empty ($school["SGCS_EnglishLanguageArts_LearningGains"]) || $school["SGCS_EnglishLanguageArts_LearningGains"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_EnglishLanguageArts_LearningGains" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>ELA Learning Gains</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">ELA Learning Gains</div>';
                                                    }
                                                    if ( !isset($school["SGCS_EnglishLanguageArts_LearningGains"]) || empty ($school["SGCS_EnglishLanguageArts_LearningGains"]) || $school["SGCS_EnglishLanguageArts_LearningGains"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_EnglishLanguageArts_LearningGains"] . '%</div>';
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* Math Learning Gains */
                                                $blog_items_output .= '<div class="school-stat school-stat-math-learning-gains clearfix';
                                                if ( !isset($school["SGCS_Mathematics_LearningGains"]) || empty ($school["SGCS_Mathematics_LearningGains"]) || $school["SGCS_Mathematics_LearningGains"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_Mathematics_LearningGains" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>Math Learning Gains</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">Math Learning Gains</div>';
                                                    }
                                                    if ( !isset($school["SGCS_Mathematics_LearningGains"]) || empty ($school["SGCS_Mathematics_LearningGains"]) || $school["SGCS_Mathematics_LearningGains"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_Mathematics_LearningGains"] . '%</div>';
                                                    }
                                                $blog_items_output .= '</div>';

                                            $blog_items_output .= '</div><div class="col-md-6">';

                                                /* ELA Learning Gains Low 25% */
                                                $blog_items_output .= '<div class="school-stat school-stat-ela-learning-gains-low25 clearfix';
                                                if ( !isset($school["SGCS_EnglishLanguageArts_LearningGainsLow25"]) || empty ($school["SGCS_EnglishLanguageArts_LearningGainsLow25"]) || $school["SGCS_EnglishLanguageArts_LearningGainsLow25"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_EnglishLanguageArts_LearningGainsLow25" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>ELA Learning Gains Lowest 25%</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">ELA Learning Gains Lowest 25%</div>';
                                                    }
                                                    if ( !isset($school["SGCS_EnglishLanguageArts_LearningGainsLow25"]) || empty ($school["SGCS_EnglishLanguageArts_LearningGainsLow25"]) || $school["SGCS_EnglishLanguageArts_LearningGainsLow25"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_EnglishLanguageArts_LearningGainsLow25"] . '%</div>';
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* Math Learning Gains Lowest 25% */
                                                $blog_items_output .= '<div class="school-stat school-stat-math-learning-gains-low25 clearfix';
                                                if ( !isset($school["SGCS_Mathematics_LearningGainsLow25"]) || empty ($school["SGCS_Mathematics_LearningGainsLow25"]) || $school["SGCS_Mathematics_LearningGainsLow25"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_Mathematics_LearningGainsLow25" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>Math Learning Gains Lowest 25%</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">Math Learning Gains Lowest 25%</div>';
                                                    }
                                                    if ( !isset($school["SGCS_Mathematics_LearningGainsLow25"]) || empty ($school["SGCS_Mathematics_LearningGainsLow25"]) || $school["SGCS_Mathematics_LearningGainsLow25"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_Mathematics_LearningGainsLow25"] . '%</div>';                        
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* Middle School Acceleration */
                                                $blog_items_output .= '<div class="school-stat school-stat-middle-acceleration clearfix';
                                                if ( !isset($school["SGCS_MiddleSchoolAcceleration"]) || empty ($school["SGCS_MiddleSchoolAcceleration"]) || $school["SGCS_MiddleSchoolAcceleration"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_MiddleSchoolAcceleration" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>Middle School Acceleration</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">Middle School Acceleration</div>';
                                                    }
                                                    if ( !isset($school["SGCS_MiddleSchoolAcceleration"]) || empty ($school["SGCS_MiddleSchoolAcceleration"]) || $school["SGCS_MiddleSchoolAcceleration"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_MiddleSchoolAcceleration"] . '%</div>';                        
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* High School Acceleration */
                                                $blog_items_output .= '<div class="school-stat school-stat-high-acceleration clearfix';
                                                if ( !isset($school["SGCS_CollegeandCareerAccelerationLagged"]) || empty ($school["SGCS_CollegeandCareerAccelerationLagged"]) || $school["SGCS_CollegeandCareerAccelerationLagged"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_CollegeandCareerAccelerationLagged" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>High School Acceleration</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">High School Acceleration</div>';
                                                    }
                                                    if ( !isset($school["SGCS_CollegeandCareerAccelerationLagged"]) || empty ($school["SGCS_CollegeandCareerAccelerationLagged"]) || $school["SGCS_CollegeandCareerAccelerationLagged"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_CollegeandCareerAccelerationLagged"] . '%</div>';                      
                                                    }
                                                $blog_items_output .= '</div>';

                                                /* Graduation Rate */
                                                $blog_items_output .= '<div class="school-stat school-stat-gradrate clearfix';
                                                if ( !isset($school["SGCS_GraduationRateLagged"]) || empty ($school["SGCS_GraduationRateLagged"]) || $school["SGCS_GraduationRateLagged"] == "" ) {
                                                    $blog_items_output .= " disable-stat";
                                                }
                                                $blog_items_output .= '">';
                                                    if ( $sortBy == "SGCS_GraduationRateLagged" ) {
                                                        $blog_items_output .= '<div class="school-stat-label"><strong>Graduation Rate</strong></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-label">Graduation Rate</div>';
                                                    }
                                                    if ( !isset($school["SGCS_GraduationRateLagged"]) || empty ($school["SGCS_GraduationRateLagged"]) || $school["SGCS_GraduationRateLagged"] == "" ) {
                                                        $blog_items_output .= '<div class="school-stat-value"></div>';
                                                    } else {
                                                        $blog_items_output .= '<div class="school-stat-value">' . $school["SGCS_GraduationRateLagged"] . '%</div>';                      
                                                    } 
                                                $blog_items_output .= '</div>';

                                                $blog_items_output .= '<div class="school-stat school-stat-description clearfix">';
                                                    $blog_items_output .= 'School grade and student performance by component is for the ' . ( $school["YEAR"] - 1 ) . "-" . substr( $school["YEAR"], 2) . ' school year.';
                                                $blog_items_output .= '</div>';

                                            $blog_items_output .= '</div></div>';

                                        $blog_items_output .= '</div>';

                                    }

                                $blog_items_output .= '</div>';
                            $blog_items_output .= '</li>';

                        }

                        $blog_items_output .= '</ul>';

                        /* PAGINATION OUTPUT
                        ================================================== */
                        if ( $pagination == "infinite-scroll" ) {

                            global $sf_include_infscroll;
                            $sf_include_infscroll = true;

                            $blog_items_output .= '<div class="pagination-wrap hidden">';
                            $blog_items_output .= excelined_pagenavi( $schoolData, $atts );
                            $blog_items_output .= '</div>';

                        } else if ( $pagination == "load-more" ) {

                            global $sf_include_infscroll;
                            $sf_include_infscroll = true;

                            $blog_items_output .= '<a href="#" class="load-more-btn">' . __( 'Load More', 'swiftframework' ) . '</a>';

                            $blog_items_output .= '<div class="pagination-wrap load-more hidden">';
                            $blog_items_output .= excelined_pagenavi( $schoolData, $atts );
                            $blog_items_output .= '</div>';

                        } else if ( $pagination == "standard" ) {
                            $blog_items_output .= '<div class="pagination-wrap standard-pagination masonry-pagination">';
                            $blog_items_output .= excelined_pagenavi( $schoolData, $atts );
                            $blog_items_output .= '</div>';
                        }

                    } else {

                        $blog_items_output .= '<ul class="blog-items ' . $list_class . ' clearfix" data-blog-type="' . $blog_type . '" data-atts="' . rawurlencode(json_encode($atts)) . '" data-paged="' . $pageNum . '" data-template="florida_schools_feed">';

                        if ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "district" ) {
                            
                            // IF THE DISTRICT WAS NOT FOUND

                            $blog_items_output .= '<li class="blog-item col-md-12 no-results"><h2>We could not locate this district. Try again.</h2></li>';

                        } else {

                            // NEED SOME KIND OF NO RESULT MESSAGE

                            $blog_items_output .= '<li class="blog-item col-md-12 no-results"><h2>No Results</h2></li>';

                        }

                        $blog_items_output .= '</ul>';

                    }

                }

                $blog_items_output .= '</div></div>';

            } catch (Exception $e) {

                $blog_items_output .= '<div class="row"><div class="blog-items-wrap blog-' . $blog_type . ' ' . $wrap_class . '">';
      
                $blog_items_output .= '<ul class="blog-items ' . $list_class . ' clearfix" data-blog-type="' . $blog_type . '" data-atts="' . rawurlencode(json_encode($atts)) . '" data-paged="' . $pageNum . '" data-template="florida_schools_feed">';

                // NEED SOME KIND OF ERROR OUTPUT HERE

                $blog_items_output .= '<li class="blog-item col-md-12 no-results"><h2>No Results</h2></li>';

                $blog_items_output .= '</ul>';

                $blog_items_output .= '</div></div>';

            }

            /* FUNCTION OUTPUT
            ================================================== */

            return $blog_items_output;

        }
    }

    /* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
       Function is largely based on Version 2.4 of the WP-PageNavi plugin */
    if ( ! function_exists( 'excelined_pagenavi' ) ) {
        function excelined_pagenavi( $schoolData, $atts, $before = '', $after = '' ) {

            $paged = $atts["pageNum"];

            $posts_per_page = intval( $atts["hitsperpage"] );
            $status = explode(":", $schoolData->status);
            if ( $status[0] == "OK-TotalPages" ) {
                $max_page = $status[1];
            }

            $pagenavi_options = array();
            //$pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%:');
            $pagenavi_options['pages_text']                   = ( '' );
            $pagenavi_options['current_text']                 = '%PAGE_NUMBER%';
            $pagenavi_options['page_text']                    = '%PAGE_NUMBER%';
            $pagenavi_options['first_text']                   = __( 'First Page', 'swiftframework' );
            $pagenavi_options['last_text']                    = __( 'Last Page', 'swiftframework' );
            $pagenavi_options['next_text']                    = __( "Next <i class='ss-navigateright'></i>", "swiftframework" );
            $pagenavi_options['prev_text']                    = __( "<i class='ss-navigateleft'></i> Previous", "swiftframework" );
            $pagenavi_options['dotright_text']                = '...';
            $pagenavi_options['dotleft_text']                 = '...';
            $pagenavi_options['num_pages']                    = 5; //continuous block of page numbers
            $pagenavi_options['always_show']                  = 0;
            $pagenavi_options['num_larger_page_numbers']      = 0;
            $pagenavi_options['larger_page_numbers_multiple'] = 5;

            $output = "";

            //If NOT a single Post is being displayed
            /*http://codex.wordpress.org/Function_Reference/is_single)*/
            if ( ! is_single() ) {
                $numposts = $max_page * $posts_per_page;

                $pages_to_show         = intval( $pagenavi_options['num_pages'] );
                $larger_page_to_show   = intval( $pagenavi_options['num_larger_page_numbers'] );
                $larger_page_multiple  = intval( $pagenavi_options['larger_page_numbers_multiple'] );
                $pages_to_show_minus_1 = $pages_to_show - 1;
                $half_page_start       = floor( $pages_to_show_minus_1 / 2 );
                //ceil - Round fractions up (http://us2.php.net/manual/en/function.ceil.php)
                $half_page_end = ceil( $pages_to_show_minus_1 / 2 );
                $start_page    = $paged - $half_page_start;

                if ( $start_page <= 0 ) {
                    $start_page = 1;
                }

                $end_page = $paged + $half_page_end;
                if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 ) {
                    $end_page = $start_page + $pages_to_show_minus_1;
                }
                if ( $end_page > $max_page ) {
                    $start_page = $max_page - $pages_to_show_minus_1;
                    $end_page   = $max_page;
                }
                if ( $start_page <= 0 ) {
                    $start_page = 1;
                }

                $larger_per_page = $larger_page_to_show * $larger_page_multiple;
                //round_num() custom function - Rounds To The Nearest Value.
                $larger_start_page_start = ( round_num( $start_page, 10 ) + $larger_page_multiple ) - $larger_per_page;
                $larger_start_page_end   = round_num( $start_page, 10 ) + $larger_page_multiple;
                $larger_end_page_start   = round_num( $end_page, 10 ) + $larger_page_multiple;
                $larger_end_page_end     = round_num( $end_page, 10 ) + ( $larger_per_page );

                if ( $larger_start_page_end - $larger_page_multiple == $start_page ) {
                    $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
                    $larger_start_page_end   = $larger_start_page_end - $larger_page_multiple;
                }
                if ( $larger_start_page_start <= 0 ) {
                    $larger_start_page_start = $larger_page_multiple;
                }
                if ( $larger_start_page_end > $max_page ) {
                    $larger_start_page_end = $max_page;
                }
                if ( $larger_end_page_end > $max_page ) {
                    $larger_end_page_end = $max_page;
                }
                if ( $max_page > 1 || intval( $pagenavi_options['always_show'] ) == 1 ) {
                    /*http://php.net/manual/en/function.str-replace.php */
                    /*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
                    $pages_text = str_replace( "%CURRENT_PAGE%", number_format_i18n( $paged ), $pagenavi_options['pages_text'] );
                    $pages_text = str_replace( "%TOTAL_PAGES%", number_format_i18n( $max_page ), $pages_text );
                    $output .= $before . '<ul class="pagenavi bar-styling">' . "\n";

                    if ( ! empty( $pages_text ) ) {
                        $output .= '<li><span class="pages">' . $pages_text . '</span></li>';
                    }
                    //Displays a link to the previous post which exists in chronological order from the current post.
                    /*http://codex.wordpress.org/Function_Reference/previous_post_link*/
                    if ( $paged > 1 ) {
                        $output .= '<li class="prev"><a href="' . excelined_change_page( $atts, $paged - 1 ) . '">' . $pagenavi_options['prev_text'] . '</a>' . get_previous_posts_link( $pagenavi_options['prev_text'] ) . '</li>';
                    }

                    if ( $start_page >= 2 && $pages_to_show < $max_page ) {
                        $first_page_text = str_replace( "%TOTAL_PAGES%", number_format_i18n( $max_page ), $pagenavi_options['first_text'] );
                        //esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote).
                        /*http://codex.wordpress.org/Data_Validation*/
                        //get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
                        $output .= '<li><a href="' . esc_url( excelined_change_page( $atts, 1 ) ) . '" class="first" title="' . $first_page_text . '">1</a></li>';
                        if ( ! empty( $pagenavi_options['dotleft_text'] ) ) {
                            $output .= '<li><span class="expand">' . $pagenavi_options['dotleft_text'] . '</span></li>';
                        }
                    }

                    if ( $larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page ) {
                        for ( $i = $larger_start_page_start; $i < $larger_start_page_end; $i += $larger_page_multiple ) {
                            $page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options['page_text'] );
                            $output .= '<li><a href="' . esc_url( excelined_change_page( $atts, $i ) ) . '" class="single_page" title="' . $page_text . '" data-pagenumber="' . number_format_i18n( $i ) . '">' . $page_text . '</a></li>';
                        }
                    }

                    for ( $i = $start_page; $i <= $end_page; $i ++ ) {
                        if ( $i == $paged ) {
                            $current_page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options['current_text'] );
                            $output .= '<li><span class="current">' . $current_page_text . '</span></li>';
                        } else {
                            $page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options['page_text'] );
                            $output .= '<li><a href="' . esc_url( excelined_change_page( $atts, $i ) ) . '" class="single_page" title="' . $page_text . '" data-pagenumber="' . number_format_i18n( $i ) . '">' . $page_text . '</a></li>';
                        }
                    }

                    if ( $end_page < $max_page ) {
                        if ( ! empty( $pagenavi_options['dotright_text'] ) ) {
                            $output .= '<li><span class="expand">' . $pagenavi_options['dotright_text'] . '</span></li>';
                        }
                        $last_page_text = str_replace( "%TOTAL_PAGES%", number_format_i18n( $max_page ), $pagenavi_options['last_text'] );
                        $output .= '<li><a href="' . esc_url( excelined_change_page( $atts, $max_page ) ) . '" class="last" title="' . $last_page_text . '" data-pagenumber="' . number_format_i18n( $max_page ) . '">' . $max_page . '</a></li>';
                    }
                    if ( $paged < $max_page ) {
                        $output .= '<li class="next"><a href="' . esc_url( excelined_change_page( $atts, $paged + 1 ) ) . '">' . $pagenavi_options['next_text'] . '</a></li>';
                    }

                    if ( $larger_page_to_show > 0 && $larger_end_page_start < $max_page ) {
                        for ( $i = $larger_end_page_start; $i <= $larger_end_page_end; $i += $larger_page_multiple ) {
                            $page_text = str_replace( "%PAGE_NUMBER%", number_format_i18n( $i ), $pagenavi_options['page_text'] );
                            $output .= '<li><a href="' . esc_url( excelined_change_page( $atts, $i ) ) . '" class="single_page" title="' . $page_text . '" data-pagenumber="' . number_format_i18n( $i ) . '">' . $page_text . '</a></li>';
                        }
                    }
                    $output .= '</ul>' . $after . "\n";
                }
            }

            return $output;
        }
    }

?>