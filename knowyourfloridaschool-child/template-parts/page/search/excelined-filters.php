<?php 

    /* FLORIDA SCHOOLS FEED FILTERS
    ================================================== */
    if ( ! function_exists( 'sf_florda_schools_feed_filters' ) ) {
        function sf_florda_schools_feed_filters( ) {

            global $post;

            require( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );

            $filterURL = array(
                    "districtid"    => "https://api.jaxpef.org/districts/districtdistinct/?APIKey=" . $apiKEY,
                    "zip"           => "https://api.jaxpef.org/zips/physicalzip/?APIKey=" . $apiKEY,
                    "type"          => "https://api.jaxpef.org/schooltypes/schooltype/?APIKey=" . $apiKEY,
                    "schoolgrade"   => "https://api.jaxpef.org/schoolgrades/distinctschoolgrades/?APIKey=" . $apiKEY,
                    "charterschool" => "https://api.jaxpef.org/charterschool/charterschool/?APIKey=" . $apiKEY,
                    "magnetstatus"  => "https://api.jaxpef.org/magnetstatus/magnetstatus/?APIKey=" . $apiKEY,
                );

            $filter_output = "";

            $filter_output .= '<a href="#" class="toggle-advanced-options">Filter Your Results <i class="fa fa-angle-up" aria-hidden="true"></i></a>';

            $filter_output .= '<div class="wrap-filters clearfix">';
            $filter_output .= '<form action="' . get_home_url() . '" method="GET">' . "\n";
            $filter_output .= '<input type="hidden" name="search" value="';
            if ( isset($_GET["search"]) && $_GET["search"] != "" ) {
                $filter_output .= $_GET["search"];
            }
            $filter_output .= '" />';
            $filter_output .= '<input type="hidden" name="hitsPerPage" value="10" />';

                /* START SCHOOL GRADE FILTER */

                $filterKey = "schoolgrade";
                $filterData = api_call($filterURL[$filterKey], get_stylesheet_directory() . "/cache/" . $filterKey . ".json");
                $filterData = $filterData->SchoolGrades;

                if ( count($filterData) > 0 ) {

                    if ( isset($_GET[$filterKey]) && !empty($_GET[$filterKey]) && $_GET[$filterKey] != "" ) {
                        $filterValue = explode(",", $_GET[$filterKey]);
                    }

                    $filter_output .= '<div class="wrap-filter filter-' . $filterKey . '">' . "\n";

                        $filter_output .= '<label class="filter-label">Performance</label>';
                        $filter_output .= '<div class="checkbox-wrap">';
                            foreach ($filterData as $filterOption) {
                                if ( $filterOption->SchoolGrade != "" ) {
                                    $filter_output .= '<label><input type="checkbox" name="' . $filterKey . '" value="' . $filterOption->SchoolGrade . '"';
                                    if ( isset($filterValue) && !empty($filterValue) && count($filterValue) > 0 && in_array($filterOption->SchoolGrade, $filterValue) ) {
                                        $filter_output .= " CHECKED";
                                    }
                                    $filter_output .= '> ' . $filterOption->SchoolGrade . '</label>';
                                }
                            }
                        $filter_output .= '</div>';
                
                    $filter_output .= '</div>' . "\n";

                }

                /* END SCHOOL GRADE FILTER */

                /* START TYPE FILTER */

                $filterKey = "type";
                $filterData = file_get_contents( $filterURL[$filterKey] );
                $filterData = json_decode( $filterData )->SchoolType;

                if ( count($filterData) > 0) {

                    $filter_output .= '<div class="wrap-filter filter-' . $filterKey . '">' . "\n";

                        $filter_output .= '<label for="' . $filterKey . '" class="filter-label">School Level</label>';
                        $filter_output .= '<div class="checkbox-wrap">';
                            foreach ($filterData as $filterOption) {
                                if ( $filterOption->SCHOOLTYPE != "" ) {
                                    $filter_output .= '<label><input type="checkbox" name="' . $filterKey . '" value="' . $filterOption->SCHOOLTYPE . '"';
                                    if ( isset($filterValue) && !empty($filterValue) && count($filterValue) > 0 && in_array($filterOption->SCHOOLTYPE, $filterValue) ) {
                                        $filter_output .= " CHECKED";
                                    }
                                    $filter_output .= '> ' . $filterOption->TYPENAME . '</label>';
                                }
                            }
                        $filter_output .= '</div>';
                
                    $filter_output .= '</div>' . "\n";

                }

                /* END TYPE FILTER */

                /* START DISTRICT FILTER */

                $filterKey = "districtid";
                $filterData = file_get_contents( $filterURL[$filterKey] );
                $filterData = json_decode( $filterData )->DistrictDistinct;

                if ( count($filterData) > 0) {

                    $filter_output .= '<div class="wrap-filter filter-' . $filterKey . '">' . "\n";

                        $filter_output .= '<label for="' . $filterKey . '" class="filter-label">District</label>';
                        $filter_output .= '<div class="select-wrap"><select name="' . $filterKey . '" class="school-feed-filter">';
                            $filter_output .= '<option value="">Select a District</option>';
                            foreach ($filterData as $filterOption) {
                                if ( $filterOption->DISTRICTID != 99 ) {
                                    $filter_output .= '<option value="' . $filterOption->DISTRICTID . '"';
                                    if ( isset($_GET[$filterKey]) && !empty($_GET[$filterKey]) && $_GET[$filterKey] == $filterOption->DISTRICTID ) {
                                        $filter_output .= " SELECTED";
                                    }
                                    $filter_output .= '>' .$filterOption->DISTRICT_NAME . '</option>';
                                }
                            }
                        $filter_output .= '</select></div>';
                
                    $filter_output .= '</div>' . "\n";

                }

                /* END DISTRICT FILTER */

                /* START ZIPCODE FILTER */

                $filterKey = "zip";
                $filterData = file_get_contents( $filterURL[$filterKey] );
                $filterData = json_decode( $filterData )->PhysicalZip;

                if ( count($filterData) > 0) {

                    $filter_output .= '<div class="wrap-filter filter-' . $filterKey . '">' . "\n";

                        $filter_output .= '<label for="' . $filterKey . '" class="filter-label">Zip Code</label>';
                        $filter_output .= '<div><select name="' . $filterKey . '" class="school-feed-filter" multiple data-placeholder=" ">';
                            $filter_output .= '<option value=""></option>';
                            foreach ($filterData as $filterOption) {
                                if ( $filterOption->PHYSICAL_ZIP != "" ) {
                                    $filter_output .= '<option value="' . $filterOption->PHYSICAL_ZIP . '"';
                                    if ( isset($_GET[$filterKey]) && !empty($_GET[$filterKey]) && count(explode(",", $_GET[$filterKey])) > 0 && in_array($filterOption->PHYSICAL_ZIP, explode(",", $_GET[$filterKey])) ) {
                                        $filter_output .= " SELECTED";
                                    }
                                    $filter_output .= '>' . $filterOption->PHYSICAL_ZIP . '</option>';
                                }
                            }
                        $filter_output .= '</select></div>';
                
                    $filter_output .= '</div>' . "\n";

                }

                /* END ZIPCODE FILTER */

                /* START CHARTER SCHOOL FILTER 

                $filterKey = "charterschool";
                $filterData = file_get_contents( $filterURL[$filterKey] );
                $filterData = json_decode( $filterData )->CharterSchool;

                if ( count($filterData) > 0) {

                    $filter_output .= '<div class="wrap-filter filter-' . $filterKey . '">' . "\n";

                        $filter_output .= '<label for="' . $filterKey . '">School Type</label>';
                        $filter_output .= '<div class="select-wrap"><select name="' . $filterKey . '" class="school-feed-filter">';
                            $filter_output .= '<option value="">Type of Charter School</option>';
                            foreach ($filterData as $filterOption) {
                                if ( $filterOption->CharterSchool != "" ) {
                                    $filter_output .= '<option value="' . $filterOption->CharterSchool . '"';
                                    if ( isset($_GET[$filterKey]) && !empty($_GET[$filterKey]) && $_GET[$filterKey] == $filterOption->CharterSchool ) {
                                        $filter_output .= " SELECTED";
                                    }
                                    $filter_output .= '>' . $filterOption->CharterSchool_NAME . '</option>';
                                }
                            }
                        $filter_output .= '</select></div>';
                
                    $filter_output .= '</div>' . "\n";

                } */

                /* END CHARTER SCHOOL FILTER */

                /* START MAGNET STATUS FILTER 

                $filterKey = "magnetstatus";
                $filterData = file_get_contents( $filterURL[$filterKey] );
                $filterData = json_decode( $filterData )->MagnetStatus;

                if ( count($filterData) > 0) {

                    $filter_output .= '<div class="wrap-filter filter-' . $filterKey . '">' . "\n";

                        $filter_output .= '<div class="select-wrap"><select name="' . $filterKey . '" class="school-feed-filter">';
                            $filter_output .= '<option value="">Magnet Status</option>';
                            foreach ($filterData as $filterOption) {
                                if ( $filterOption->MAGNET_STATUS != "" ) {
                                    $filter_output .= '<option value="' . $filterOption->MAGNET_STATUS . '"';
                                    if ( isset($_GET[$filterKey]) && !empty($_GET[$filterKey]) && $_GET[$filterKey] == $filterOption->MAGNET_STATUS ) {
                                        $filter_output .= " SELECTED";
                                    }
                                    $filter_output .= '>' . $filterOption->MAGNET_STATUS_NAME . '</option>';
                                }
                            }
                        $filter_output .= '</select></div>';
                
                    $filter_output .= '</div>' . "\n";

                } */

                /* END MAGNET STATUS FILTER */

                /* START GEOSEARCH FILTERS */

                $filterKey = "sradius";
                $filterData = array( 
                                        (object) array("sradius" => 5, "sradiusName" => "5 miles"), 
                                        (object) array("sradius" => 10, "sradiusName" => "10 miles"), 
                                        (object) array("sradius" => 15, "sradiusName" => "15 miles"), 
                                        (object) array("sradius" => 20, "sradiusName" => "20 miles"), 
                                        (object) array("sradius" => 25, "sradiusName" => "25 miles"), 
                                        (object) array("sradius" => 30, "sradiusName" => "30 miles"), 
                                        (object) array("sradius" => 35, "sradiusName" => "35 miles"), 
                                        (object) array("sradius" => 40, "sradiusName" => "40 miles"), 
                                        (object) array("sradius" => 45, "sradiusName" => "45 miles"), 
                                        (object) array("sradius" => 50, "sradiusName" => "50 miles")
                                    );

                if ( count($filterData) > 0 && isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "geo" ) {

                    $filter_output .= '<div class="wrap-filter filter-' . $filterKey . '">' . "\n";

                        $filter_output .= '<label for="' . $filterKey . '" class="filter-label">Distance</label>';
                        $filter_output .= '<div class="select-wrap"><select name="' . $filterKey . '" class="school-feed-filter">';
                            foreach ($filterData as $filterOption) {
                                if ( $filterOption->sradius != "" ) {
                                    $filter_output .= '<option value="' . $filterOption->sradius . '"';
                                    if ( isset($_GET[$filterKey]) && !empty($_GET[$filterKey]) && $_GET[$filterKey] == $filterOption->sradius ) {
                                        $filter_output .= " SELECTED";
                                    }
                                    $filter_output .= '>' . $filterOption->sradiusName . '</option>';
                                }
                            }
                        $filter_output .= '</select></div>';
                
                    $filter_output .= '</div>' . "\n";
                    $filter_output .= '<input type="hidden" name="lat" value="';
                    if ( isset($_GET["lat"]) && $_GET["lat"] != "" ) {
                        $filter_output .= $_GET["lat"];
                    }
                    $filter_output .= '" />';
                    $filter_output .= '<input type="hidden" name="long" value="';
                    if ( isset($_GET["long"]) && $_GET["long"] != "" ) {
                        $filter_output .= $_GET["long"];
                    }
                    $filter_output .= '" />';
                    $filter_output .= '<input type="hidden" name="address" value="';
                    if ( isset($_GET["address"]) && $_GET["address"] != "" ) {
                        $filter_output .= $_GET["address"];
                    }
                    $filter_output .= '" />';

                } else {

                    $filter_output .= '<input type="hidden" name="sradius" value="';
                    if ( isset($_GET["sradius"]) && $_GET["sradius"] != "" ) {
                        $filter_output .= $_GET["sradius"];
                    }
                    $filter_output .= '" />';
                    $filter_output .= '<input type="hidden" name="lat" value="';
                    if ( isset($_GET["lat"]) && $_GET["lat"] != "" ) {
                        $filter_output .= $_GET["lat"];
                    }
                    $filter_output .= '" />';
                    $filter_output .= '<input type="hidden" name="long" value="';
                    if ( isset($_GET["long"]) && $_GET["long"] != "" ) {
                        $filter_output .= $_GET["long"];
                    }
                    $filter_output .= '" />';
                    $filter_output .= '<input type="hidden" name="address" value="';
                    if ( isset($_GET["address"]) && $_GET["address"] != "" ) {
                        $filter_output .= $_GET["address"];
                    }
                    $filter_output .= '" />';

                }

                /* END GEOSEARCH FILTERS */
            
            $filter_output .= '</form>';
            $filter_output .= '</div>' . "\n";

            return $filter_output;
        }
    }

?>