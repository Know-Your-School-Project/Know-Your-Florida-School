<?php

    /*
    *
    *	Swift Page Builder - Social Sharing Shortcode
    *	------------------------------------------------
    *	Swift Framework
    * 	Copyright Swift Ideas 2015 - http://www.swiftideas.com
    *
    */

    if ( class_exists('SwiftPageBuilderShortcode') ) {

        /* SOCIAL SHARING ASSET
        ================================================== */

        class SwiftPageBuilderShortcode_spb_socialsharing extends SwiftPageBuilderShortcode {

            protected function content( $atts, $content = null ) {
                $sharing = $type = $enable_email = $enable_print = $enable_facebook = $enable_twitter = $enable_linkedin = $width = $el_class = $text = '';
                extract( shortcode_atts( array(
                    'enable_email'      => 'yes',
                    'enable_facebook'   => 'yes',
                    'enable_twitter'    => 'yes',
                    'enable_linkedin'   => 'yes',
                    'width'             => '1/1',
                    'el_class'          => '',
                    'el_position'       => ''
                ), $atts ) );

                global $post;
                global $sf_options;

                $title = get_the_title( $post );
                if(isset($_SERVER['HTTPS'])) {
                    if ($_SERVER['HTTPS'] == "on") {
                        $link = "https://";
                    } else {
                        $link = "http://";
                    }
                } else {
                    $link = "http://";
                }
                $link .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
                $button_count = 0;
                $type = "standard";

                if ( isset($sf_options["twitter_username"]) && !empty($sf_options["twitter_username"]) && $sf_options["twitter_username"] != "" ) {
                    $twitter_handle = $sf_options["twitter_username"];
                } else {
                    $twitter_handle = "";
                }

                $width = spb_translateColumnWidthToSpan( $width );

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

                        $schoolData = format_data($schoolData->SingleSchool);

                        foreach ($schoolData as $key => $schoolDataYear) {
                            $schoolData[$key] = get_object_vars($schoolDataYear);
                        }

                        $schoolName = ucwords(strtolower($schoolData[count($schoolData)-1]["SCHOOL_NAME_LONG"]));
                        $schoolGrade = $schoolData[count($schoolData)-1]["SchoolGrade"];
                        $possiblepoints = $schoolData[count($schoolData)-1]["SGCS_PercentofTotalPossiblePoints"];

                        // END API CALL
                    }

                }

                if(is_front_page()){
                    if ( $enable_email == "yes" || $enable_email == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-email" href="' . $link . '" target="_self"><i class="fa fa-envelope"></i> <span>Email</span></a>';
                    }
                    if ( $enable_twitter == "yes" || $enable_twitter == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-twitter has-svg" href="https://twitter.com/share?text=%23KnowYourFLSchool%20makes%20it%20easy%20to%20find%20%26%20understand%20information%20about%20your%20school%20and%20see%20how%20it%20compares%20to%20others&url=http://bit.ly/knowyourschool" target="_blank"><i class="fa fa-twitter-square"></i></a>';
                    }
                    if ( $enable_facebook == "yes" || $enable_facebook == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-facebook has-svg" href="https://www.facebook.com/sharer/sharer.php?u=' . $link  . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
                    }
                    if ( $enable_linkedin == "yes" || $enable_linkedin == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-linkedin has-svg" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&title=' . urlencode($title) . '" target="_blank"><i class="fa fa-linkedin-square"></i></a>';
                    }
                    // if ( $button_count < 3 ) {
                    //     $type = "extended";
                    // }

                } else if(is_page('about')){

                    if ( $enable_email == "yes" || $enable_email == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-email" href="' . $link . '" target="_self"><i class="fa fa-envelope"></i> <span>Email</span></a>';
                    }
                    if ( $enable_twitter == "yes" || $enable_twitter == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-twitter has-svg" href="https://twitter.com/share?text=Learn%20more%20about%20%23KnowYourFLSchool,%20which%20unpacks%20%40EducationFL%20data%20for%203,300%20FL%20schools&url=http://bit.ly/kyfsabout" target="_blank"><i class="fa fa-twitter-square"></i></a>';
                    }
                    if ( $enable_facebook == "yes" || $enable_facebook == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-facebook has-svg" href="https://www.facebook.com/sharer/sharer.php?u=' . $link  . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
                    }
                    if ( $enable_linkedin == "yes" || $enable_linkedin == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-linkedin has-svg" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&title=' . urlencode($title) . '" target="_blank"><i class="fa fa-linkedin-square"></i></a>';
                    }
                    // if ( $button_count < 3 ) {
                    //     $type = "extended";
                    // }

                } else if(is_page(90)){
                /* School Grades page */

                    if ( $enable_email == "yes" || $enable_email == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-email" href="' . $link . '" target="_self"><i class="fa fa-envelope"></i> <span>Email</span></a>';
                    }
                    if ( $enable_twitter == "yes" || $enable_twitter == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-twitter has-svg" href="https://twitter.com/share?text=School%20grades%20provide%20a%20clear%20way%20for%20state%20of%20FL%20to%20measure%20school%20performance.%20Learn%20more%20at%20%23KnowYourFLSchool:&url=http://bit.ly/flschoolgrades" target="_blank"><i class="fa fa-twitter-square"></i></a>';
                    }
                    if ( $enable_facebook == "yes" || $enable_facebook == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-facebook has-svg" href="https://www.facebook.com/sharer/sharer.php?u=' . $link  . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
                    }
                    if ( $enable_linkedin == "yes" || $enable_linkedin == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-linkedin has-svg" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&title=' . urlencode($title) . '" target="_blank"><i class="fa fa-linkedin-square"></i></a>';
                    }
                    // if ( $button_count < 3 ) {
                    //     $type = "extended";
                    // }
                

                } else if(is_page(43)){
                /* State Summary page */

                    if ( $enable_email == "yes" || $enable_email == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-email" href="' . $link . '" target="_self"><i class="fa fa-envelope"></i> <span>Email</span></a>';
                    }
                    if ( $enable_twitter == "yes" || $enable_twitter == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-twitter has-svg" href="https://twitter.com/share?text=We%20can%20look%20at%20data%20from%20all%20of%20Florida%20to%20know%20whether%20schools%20are%20on%20the%20right%20track%20%23KnowYourFLSchool&url=http://bit.ly/flstatesummary" target="_blank"><i class="fa fa-twitter-square"></i></a>';
                    }
                    if ( $enable_facebook == "yes" || $enable_facebook == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-facebook has-svg" href="https://www.facebook.com/sharer/sharer.php?u=' . $link  . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
                    }
                    if ( $enable_linkedin == "yes" || $enable_linkedin == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-linkedin has-svg" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&title=' . urlencode($title) . '" target="_blank"><i class="fa fa-linkedin-square"></i></a>';
                    }
                    // if ( $button_count < 3 ) {
                    //     $type = "extended";
                    // }

                } else if(is_page(42)){
                /* Report Card page */

                    // if ( $enable_email == "yes" || $enable_email == 1 ) {
                    //     $button_count++;
                    //     $sharing .= '<a class="socialsharing-email" href="' . $link . '" target="_self"><i class="fa fa-envelope"></i> <span>Email</span></a>';
                    // }
                    if ( $enable_twitter == "yes" || $enable_twitter == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-twitter has-svg" href="https://twitter.com/share?text=' . $schoolName . '%20earned%20a%20' . $schoolGrade . '%20from%20%40FLEducation,%20scoring%20' . $possiblepoints . '%25%20of%20possible%20points.%20Learn%20more%20at%20%23KnowYourFLSchool:&url=' . $link . '" target="_blank"><i class="fa fa-twitter-square"></i></a>';
                    }
                    if ( $enable_facebook == "yes" || $enable_facebook == 1 ) {
                        $button_count++;
                        $sharing .= '<a class="socialsharing-facebook has-svg" href="https://www.facebook.com/sharer/sharer.php?u=' . $link  . '" target="_blank"><i class="fa fa-facebook-square"></i></a>';
                    }
                    // if ( $enable_linkedin == "yes" || $enable_linkedin == 1 ) {
                    //     $button_count++;
                    //     $sharing .= '<a class="socialsharing-linkedin has-svg" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&title=' . urlencode($title) . '" target="_blank"><i class="fa fa-linkedin-square"></i></a>';
                    // }
                    $sharing .= '<a class="socialsharing-linkedin has-svg" id="print-reportcard" href="#"><i class="fa fa-print"></i></a>';
                    // if ( $button_count < 3 ){
                    //     $type = "extended";
                    // }
                }

                $output = '';
                $output .= '<div class="socialsharing-wrap ' . $width . ' no-print">';
                $output .= '<div class="spb_socialsharing ' . $type . ' spb_content_element ' . $el_class . '">';
                $output .= '<div class="socialsharing-label">Share This Page</div>';
                $output .= '<div class="social socialsharing-button-wrap">';
                $output .= $sharing;
                $output .= '</div>';
                $output .= '</div>' . $this->endBlockComment( 'divider' ) . "\n";
                $output .= '</div>';

                $output = $this->startRow( $el_position ) . $output . $this->endRow( $el_position );
                
                return $output;
            }
        }

        SPBMap::map( 'spb_socialsharing', array(
            "name"        => __( "Social Sharing", 'swift-framework-plugin' ),
            "base"        => "spb_socialsharing",
            "class"       => "spb_socialsharing",
            'icon'        => 'spb-icon-socialsharing',
            "controls"    => '',
            "params"      => array(
                array(
                    "type"        => "buttonset",
                    "heading"     => __( "Email", 'swift-framework-plugin' ),
                    "param_name"  => "enable_email",
                    "value"       => array(
                        __( 'Yes', 'swift-framework-plugin' ) => "yes",
                        __( 'No', 'swift-framework-plugin' )  => "no"
                    ),
                    "description" => __( "Would you like email sharing to display on this page?", 'swift-framework-plugin' )
                ),
                array(
                    "type"       => "section",
                    "param_name" => "socialsharing_options",
                    "heading"    => __( "Social Sharing Options", 'swift-framework-plugin' ),
                ),
                array(
                    "type"        => "buttonset",
                    "heading"     => __( "Facebook", 'swift-framework-plugin' ),
                    "param_name"  => "enable_facebook",
                    "value"       => array(
                        __( 'Yes', 'swift-framework-plugin' ) => "yes",
                        __( 'No', 'swift-framework-plugin' )  => "no"
                    ),
                    "description" => __( "Would you like facebook sharing to display on this page?", 'swift-framework-plugin' )
                ),
                array(
                    "type"        => "buttonset",
                    "heading"     => __( "Linkedin", 'swift-framework-plugin' ),
                    "param_name"  => "enable_linkedin",
                    "value"       => array(
                        __( 'Yes', 'swift-framework-plugin' ) => "yes",
                        __( 'No', 'swift-framework-plugin' )  => "no"
                    ),
                    "description" => __( "Would you like linkedin sharing to display on this page?", 'swift-framework-plugin' )
                ),
                array(
                    "type"        => "buttonset",
                    "heading"     => __( "Twitter", 'swift-framework-plugin' ),
                    "param_name"  => "enable_twitter",
                    "value"       => array(
                        __( 'Yes', 'swift-framework-plugin' ) => "yes",
                        __( 'No', 'swift-framework-plugin' )  => "no"
                    ),
                    "description" => __( "Would you like tweeting to display on this page?", 'swift-framework-plugin' )
                ),
                array(
                    "type"       => "section",
                    "param_name" => "advanced_options",
                    "heading"    => __( "Advanced Options", 'swift-framework-plugin' ),
                ),
                array(
                    "type"        => "textfield",
                    "heading"     => __( "Extra class", 'swift-framework-plugin' ),
                    "param_name"  => "el_class",
                    "value"       => "",
                    "description" => __( "If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'swift-framework-plugin' )
                )
            ),
            "js_callback" => array( "init" => "spbTextSeparatorInitCallBack" )
        ) );

    }

?>