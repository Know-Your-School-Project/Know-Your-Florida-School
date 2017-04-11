<?php

// This gets the most recent year's grade
if ( !function_exists("get_school_grade") ) {
    function get_school_grade($data) {
    	$grade = [];
    	$grade["SchoolGrade"] = preg_replace('/\s+/', '', $data[count($data)-1]["SchoolGrade"]);
        $grade["YEAR"] = preg_replace('/\s+/', '', $data[count($data)-1]["YEAR"]);
        $grade["SGCS_PercentofTotalPossiblePoints"] = preg_replace('/\s+/', '', $data[count($data)-1]["SGCS_PercentofTotalPossiblePoints"]);
        return $grade;
    }
}

// This displays the data that is not available in a string
if ( !function_exists("get_nodata_string") ) {
    function get_nodata_string($nodataArray) {
        $stringArray = array();
    	$string = "";
        foreach ($nodataArray as $key => $nameArray) {
            foreach ($nameArray as $nameKey => $name) {
                $stringArray[] = $name . ' (' . $key . ')';
            }
        }
        $string = " " . join(', or ', array_filter(array_merge(array(join(', ', array_slice($stringArray, 0, -1))), array_slice($stringArray, -1)), 'strlen'));
        return $string;
    }
}

// Swap data into CMS content
if ( !function_exists("inject_data") ) {
    function inject_data($content, $schoolData, $schoolTypes) {
        foreach ($schoolData[count($schoolData)-1] as $key => $value) {
            if ($key == "SGCS_PercentofTotalPossiblePoints_Percentile" ) {
              $content = str_replace("{{" . $key . "}}", round($value, 0), $content);
            }
            if ( $key == "TYPE" ) {
                if ( is_object($schoolTypes) && count($schoolTypes->SchoolType) > 0 ) {
                    foreach ($schoolTypes->SchoolType as $schoolType) {
                        if ( $schoolType->SCHOOLTYPE == $value ) {
                            $value = $schoolType->TYPENAME;
                        }
                    }
                }
                $content = str_replace("{{" . $key . "}}", strtolower($value), $content);
            } else {
                $content = str_replace("{{" . $key . "}}", ucwords(strtolower($value)), $content);
                $valuePos = ucwords(strtolower($value));
                if ( substr($valuePos, -1) == "s" ) {
                    $valuePos = $valuePos . "'";
                } else {
                    $valuePos = $valuePos . "'s";
                }
                $content = str_replace("{{" . $key . ":possessive}}", $valuePos, $content);
            }
        }
        return $content;
    }
}

// Swap data into CMS content
if ( !function_exists("inject_component") ) {
    function inject_component($content, $componentKey, $componentValue, $color, $post) {
        $content = str_replace("{{component}}", $componentValue, $content );
        $post->ID = 42;
        if ( $color != null && $color != "" ) {
            $content = str_replace("{{color:start}}", '<span class="color-span color-' . $color . '">', $content );
        } else {
            $content = str_replace("{{color:start}}", '<span>', $content );
        }
        $content = str_replace("{{color:end}}", '</span>', $content );
        if ( $componentKey == "SGCS_EnglishLanguageArts_Achievement" || 
             $componentKey == "SGCS_Mathematics_Achievement" || 
             $componentKey == "SGCS_Science_Achievement" || 
             $componentKey == "SGCS_SocialStudies_Achievement" ) {
           $content = str_replace("{{component:action}}", get_field("component_action_achievement", $post->ID), $content );
        } else if (
            $componentKey == "SGCS_EnglishLanguageArts_LearningGains" || 
            $componentKey == "SGCS_Mathematics_LearningGains" || 
            $componentKey == "SGCS_EnglishLanguageArts_LearningGainsLow25" || 
            $componentKey == "SGCS_Mathematics_LearningGainsLow25") {
           $content = str_replace("{{component:action}}", get_field("component_action_learning_gains", $post->ID), $content );
        } else if ( $componentKey == "SGCS_CollegeandCareerAccelerationLagged" ) {
           $content = str_replace("{{component:action}}", get_field("component_action_high_school_acceleration", $post->ID), $content );
        } else if ( $componentKey == "SGCS_MiddleSchoolAcceleration" ) {
           $content = str_replace("{{component:action}}", get_field("component_action_middle_school_acceleration", $post->ID), $content );
        } else {
           $content = str_replace("{{component:action}}", "", $content );
        }
        return $content;
    }
}

// This takes an array of keys and arranges them in descending order using the data
if ( !function_exists("data_arrange_keys") ) {
    function data_arrange_keys($data, $keys) {
        $arrangedKeys = array();
        foreach ($keys as $key => $name) {
            if ( $data[$key] == "" ) {
                $data[$key] = 0;
            }
            $arrangedKeys[$key] = "".round($data[$key]*100)."";
        }
        asort($arrangedKeys);
        $arrangedKeys = array_reverse($arrangedKeys);
        foreach ($arrangedKeys as $key => $value) {
            $arrangedKeys[$key] = $keys[$key];
        }
        return $arrangedKeys;
    }
}

// This removed duplicate data and arranges by YEAR
if ( !function_exists("format_data") ) {
    function format_data($data) {
        $newData = array();
        $years = array();
        if ( count($data) > 0 ) {
            foreach($data as $yearData) {
                if ( count($years) < 1 || !in_array($yearData->YEAR, $years)) {
                    $newData = array_merge($newData, [$yearData]);
                    $years[] = $yearData->YEAR;
                }
            }
        } else {
            $newData = $data;
        }
        return $newData;
    }
}

if ( !function_exists("get_SPAR_data") ) { 
    function get_SPAR_data($minYear, $maxYear, $districtId, $schoolId) {

        require( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );

        $year = $minYear;
        $SPARData = array("school" => array(), "district" => array(), "state" => array());

        while( $year <= $maxYear ) {
            try {
                $SPARData["school"][$year] = api_call("https://api.jaxpef.org/sparsearch/SparSchool/" . substr($year-1, -2) . substr($year, -2) . "/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY, get_stylesheet_directory() . "/cache/schoolspar-" . $districtId . "-" . $schoolId . "-" . ( $year - 1 ) . "-" . $year . ".json");
                if ( is_object ( $SPARData["school"][$year] ) && isset($SPARData["school"][$year]->SearchData[0]) && !empty($SPARData["school"][$year]->SearchData[0]) && $SPARData["school"][$year]->SearchData[0] != "" ) {
                    $SPARData["school"][$year] = $SPARData["school"][$year]->SearchData[0];
                    $SPARData["school"][$year] = get_object_vars($SPARData["school"][$year]);
                } else {
                    $SPARData["school"][$year] = array();
                }
                $SPARData["district"][$year] = api_call("https://api.jaxpef.org/sparsearch/SparDistrict/" . substr($year-1, -2) . substr($year, -2) . "/" . $districtId . "/?APIKey=" . $apiKEY, get_stylesheet_directory() . "/cache/schoolspar-" . $districtId . "-" . ( $year - 1 ) . "-" . $year . ".json");
                if ( is_object ( $SPARData["district"][$year] ) && isset($SPARData["district"][$year]->SearchData[0]) && !empty($SPARData["district"][$year]->SearchData[0]) && $SPARData["district"][$year]->SearchData[0] != "" ) {
                    $SPARData["district"][$year] = $SPARData["district"][$year]->SearchData[0];
                    $SPARData["district"][$year] = get_object_vars($SPARData["district"][$year]);
                } else {
                    $SPARData["district"][$year] = array();
                }
                $SPARData["state"][$year] = api_call("https://api.jaxpef.org/sparsearch/SparDistrict/" . substr($year-1, -2) . substr($year, -2) . "/99/?APIKey=" . $apiKEY, get_stylesheet_directory() . "/cache/schoolspar-99-" . ( $year - 1 ) . "-" . $year . ".json");
                if ( is_object ( $SPARData["state"][$year] ) && isset($SPARData["state"][$year]->SearchData[0]) && !empty($SPARData["state"][$year]->SearchData[0]) && $SPARData["state"][$year]->SearchData[0] != "" ) {
                    $SPARData["state"][$year] = $SPARData["state"][$year]->SearchData[0];
                    $SPARData["state"][$year] = get_object_vars($SPARData["state"][$year]);
                } else {
                    $SPARData["state"][$year] = array();
                }
            } catch (Exception $e) {
                $SPARData["school"][$year] = $e;
                $SPARData["district"][$year] = $e;
                $SPARData["state"][$year] = $e;
            }

            $year++;
        }

        return $SPARData;

    }
}

if ( !function_exists("api_call") ) {
    // This function is a caching mechanism for the api
    function api_call($url, $cache_file) {
        if(file_exists($cache_file)) {
            if(time() - filemtime($cache_file) > 86400) {
                // too old , re-fetch
                $cache = file_get_contents($url);
                file_put_contents($cache_file, $cache);
            } else {
                // cache is still fresh
                $cache = file_get_contents($cache_file);
            }
        } else {
            // no cache, create one
            $cache = file_get_contents($url);
            file_put_contents($cache_file, $cache);
        }
        return json_decode($cache);
    }
}

?>