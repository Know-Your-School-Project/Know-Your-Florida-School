<?php

    /* Variables */
        // $subject

    $minYear = $year = get_field("performance_min_year");
    $maxYear = get_field("performance_max_year");

    $yearCount = ( $maxYear - $minYear ) + 1;

    $table_header = '';

    if($subject === 'ELA'){

        $table_header = 'English Language Arts Assessment Results (FSA and FAA)';

    } else if($subject === 'MATH'){

        $table_header = 'Mathematics Assessment Results (FSA, EOCs and FAA)';

    } else if($subject === 'SCI'){

        $table_header = 'Science Assessment Results (Statewide Science Assessment or NGSSS, EOCs and FAA)';

    }

    //$SPARData = get_SPAR_data($minYear, $maxYear, $districtId, $schoolId);

    $races = array(
            "ALL"   => "All Students",
            "W"     => "White",
            "B"     => "Black",
            "H"     => "Hispanic",
            "A"     => "Asian",
            "NHPI"  => "Native Hawaiian or Other Pacific Islander",
            "AIAN"  => "American Indian or Alaska Native",
            "MULT"  => "Two or More Races",
            "DIS"   => "Disabled",
            "ED"    => "Economically Disadvantaged",
            "ELL"   => "English Learners",
            "MIG"   => "Migrant",
            "F"     => "Female",
            "M"     => "Male"
        );

    $modal_content .= '<table id="spar-' . $subject . '-table" class="desktop-table">';
        $modal_content .= '<thead>';
        $modal_content .= '<tr><th></th><th class="table-label" colspan="100%" rowspan="" headers="" scope="">' . $table_header .'</th></tr>';
        $modal_content .= '<tr><th></th><th class="table-label" colspan="100%" rowspan="" headers="" scope="">Percent of Students Scoring Satisfactory and Above</th></tr>';
        $modal_content .= '</thead>';
        $modal_content .= '<tbody class="row-hover">';
            $modal_content .= '<tr class="spar-' . $subject . '-description row-1">
                                
                                   <th class="spar-' . $subject . '-cell" width="25%"></th>';
                foreach($SPARData as $level => $levelData) {
                  $modal_content .= '<th class="spar-' . $subject . '-header" colspan="' . ( $yearCount * 2 ) . '" id="performance-table-'. $level . '"">' . $level . '</th>';                }
            $modal_content .= '</tr> ';
            $modal_content .= '</tr>';
            $modal_content .= '<tr class="spar-' . $subject . '-description row-2">
                                    <td class="spar-' . $subject . '-cell" width="25%"></td>';
                foreach($SPARData as $level => $levelData) {
                    for ($y=$minYear;$y<=$maxYear;$y++) {
                        $modal_content .=   '<td class="spar-' . $subject . '-cell">' . ( $y - 1 ) . '-' . substr($y, -2) . ' Results</td>
                                             <td class="spar-' . $subject . '-cell">' . ( $y - 1 ) . '-' . substr($y, -2) . ' Percent Tested</td>';
                    }
                }
            $modal_content .= '</tr>';
            $row = 3;

            $chartSubgroups = array();

            foreach( $races as $raceKey => $raceName) {
                $hasData = false;
                foreach( $SPARData as $level => $levelData ) {
                    for ($y=$minYear;$y<=$maxYear;$y++) {
                        if ( ( isset($SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey]) && $SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey] != "" && $SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey] != 0 ) ||
                             ( isset($SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey]) && $SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey] != "" && $SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey] != 0 ) ) {
                            $hasData = true;
                        }
                    }
                }
                if ( $hasData == true ) {
                    $chartSubgroups[$raceKey] = $raceName;
                }
            }
            
            foreach($chartSubgroups as $raceKey => $race) {
                $modal_content .= '<tr class="spar-' . $subject . '-' . $race . '-description row-' . $row . '">
                                    <td class="spar-' . $subject . '-' . $race . '-cell" width="25%">' . $race . '</td>';
                    foreach($SPARData as $level => $levelData) {
                        for ($y=$minYear;$y<=$maxYear;$y++) {
                            if ( isset($SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey]) && $SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey] != "" ) {
                                $modal_content .=   '<td class="spar-' . $subject . '-' . $race . '-cell">' . $SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey] . '</td>';
                            } else {
                                $modal_content .=   '<td class="spar-' . $subject . '-' . $race . '-cell null-value">N</td>';
                            }
                            if ( isset($SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey]) && $SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey] != "" ) {
                                $modal_content .=   '<td class="spar-' . $subject . '-' . $race . '-cell">' . $SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey] . '</td>';
                            } else {
                                $modal_content .=   '<td class="spar-' . $subject . '-' . $race . '-cell null-value">N</td>';
                            }

                        }
                    }
                $modal_content .= '</tr>';
                $row++;
            }
            $modal_content .= '<tr class="spar-' . $subject . '-description row-' . ( $row + 1 ) . '">
                                <td class="spar-' . $subject . '-cell" colspan="' . ( ( count( $SPARData ) * $yearCount * 2 ) + 1 ) . '">N = No test results reported</td>';
            $modal_content .= '</tr>';
        $modal_content .= '</tbody>';
    $modal_content .= '</table>';

    $modal_content .= '<table id="spar-' . $subject . '-table" class="mobile-table">';
    $modal_content .= '<tr><th class="table-label" colspan="100%" rowspan="" headers="" scope="">' . $table_header .'</th></tr>';
    $modal_content .= '<tr><th class="table-label" colspan="100%" rowspan="" headers="" scope="">Percent of Students Scoring Satisfactory and Above</th></tr>';
    $modal_content .= '</table>';
    foreach($SPARData as $level => $levelData) {
    $modal_content .= '<table id="spar-' . $subject . '-table" class="mobile-table">';
        $modal_content .= '<tr class="spar-' . $subject . '-description row-1">';
            $modal_content .= '<th class="spar-' . $subject . '-header" id="performance-table-'. $level . '"" colspan="100%">' . $level . '</th>';
        $modal_content .= '</tr> ';
        $modal_content .= '<tbody class="row-hover">';
            $modal_content .= '<tr class="spar-' . $subject . '-description row-2">
                                    <td class="spar-' . $subject . '-cell"></td>';
     
            for ($y=$minYear;$y<=$maxYear;$y++) {
                $modal_content .=   '<td class="spar-' . $subject . '-cell">' . ( $y - 1 ) . '-' . substr($y, -2) . ' Results</td>
                                     <td class="spar-' . $subject . '-cell">' . ( $y - 1 ) . '-' . substr($y, -2) . ' Percent Tested</td>';
            }
            $modal_content .= '</tr>';
            $row = 3;

            $chartSubgroups = array();

            foreach( $races as $raceKey => $raceName) {
                $hasData = false;
                    for ($y=$minYear;$y<=$maxYear;$y++) {
                        if ( ( isset($SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey]) && $SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey] != "" && $SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey] != 0 ) ||
                             ( isset($SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey]) && $SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey] != "" && $SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey] != 0 ) ) {
                            $hasData = true;
                        }
                    }
                if ( $hasData == true ) {
                    $chartSubgroups[$raceKey] = $raceName;
                }
            }
            
            foreach($chartSubgroups as $raceKey => $race) {
                $modal_content .= '<tr class="spar-' . $subject . '-' . $race . '-description row-' . $row . '">
                                    <td class="spar-' . $subject . '-' . $race . '-cell">' . $race . '</td>';
                for ($y=$minYear;$y<=$maxYear;$y++) {
                    if ( isset($SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey]) && $SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey] != "" ) {
                        $modal_content .=   '<td class="spar-' . $subject . '-' . $race . '-cell">' . $SPARData[$level][$y]["SPAR_" . $subject . "_PASS_" . $raceKey] . '</td>';
                    } else {
                        $modal_content .=   '<td class="spar-' . $subject . '-' . $race . '-cell null-value">N</td>';
                    }
                    if ( isset($SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey]) && $SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey] != "" ) {
                        $modal_content .=   '<td class="spar-' . $subject . '-' . $race . '-cell">' . $SPARData[$level][$y]["SPAR_" . $subject . "_PT_" . $raceKey] . '</td>';
                    } else {
                        $modal_content .=   '<td class="spar-' . $subject . '-' . $race . '-cell null-value">N</td>';
                    }

                }
                $modal_content .= '</tr>';
                $row++;
            }
            $modal_content .= '<tr class="spar-' . $subject . '-description row-' . ( $row + 1 ) . '">
                                <td class="spar-' . $subject . '-cell" colspan="' . ( ( count( $SPARData ) * $yearCount * 2 ) + 1 ) . '">N = No test results reported</td>';
            $modal_content .= '</tr>';
        $modal_content .= '</tbody>';
    $modal_content .= '</table>';

    }

?>