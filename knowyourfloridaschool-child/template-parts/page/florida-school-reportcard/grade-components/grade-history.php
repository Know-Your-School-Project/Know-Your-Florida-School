<?php

$requestURL = "https://api.jaxpef.org/historicgrades/historicgrades/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY;
$schoolHistoricData = api_call($requestURL, get_stylesheet_directory() . "/cache/schoolhist-" . $districtId . "-" . $schoolId . ".json");
$schoolTypes = api_call("https://api.jaxpef.org/schooltypes/schooltype/?APIKey=" . $apiKEY, get_stylesheet_directory() . "/cache/type.json");
    
$schoolHistoricData = format_data($schoolHistoricData->History);

foreach ($schoolHistoricData as $key => $schoolHistoricDataYear) {
    $schoolHistoricData[$key] = get_object_vars($schoolHistoricDataYear);
}

$modal_content .= '<div class="page-content">';
	$modal_content .= '<div class="row">';
		$modal_content .= '<div class="col-md-12">';
			$modal_content .= '<div id="exhibit-grade-history-' . $schoolId . '" data-schoolid="' . $schoolId . '" class="exhibit-group exhibit-grade-history">';
				if( have_rows('school_grade_history') ) {
					$modal_content .= '<a href="#" class="close-modal-link"><< Back to School Report Card</a>';
					$modal_content .= '<table id="grade-history-table">';
						$modal_content .= '<tbody class="row-hover">';

						$modal_content .= '<tr class="grade-history-description"> ';
							$modal_content .= '<td colspan=3>' . inject_data(get_field("grade_history_description"), $schoolData, $schoolTypes) . '</td>';
						$modal_content .= '</tr>';

					 	// loop through the rows of data
					 	$oddeven = "odd";
					 	$rowCount = 0;
					    while ( have_rows('school_grade_history') ) { the_row();

					        // display a sub field value
					        $year = get_sub_field('year');
					        $grade = '<span class="no-grade">--</span>';
					        if ( isset($schoolData) && !empty($schoolData) && count($schoolData) > 0 ) {
					        	foreach ($schoolData as $key => $data) {
					        		if ( $data["YEAR"] == $year ) {
					        			$grade = $data["SchoolGrade"];
					        		}
					        	}
					        }
					        if ( isset($schoolHistoricData) && !empty($schoolHistoricData) && count($schoolHistoricData) > 0 ) {
					        	foreach ($schoolHistoricData as $key => $data) {
					        		if ( $data["YEAR"] == $year ) {
					        			$grade = $data["SCHOOLGRADE"];
					        		}
					        	}
					        }
					        $description = get_sub_field('description');

							$modal_content .= '<tr class="row-' . $rowCount . ' ' . $oddeven . '"> ';
								$modal_content .= '<td class="column-1"><div class="hidden-sm hidden-xs">' . $year . '</div><div class="hidden-lg hidden-md">' . $year . ': <span class="school-grade">' . $grade . '</span></div></td>';
								$modal_content .= '<td class="column-2 hidden-sm hidden-xs">' . $grade . '</td>';
								$modal_content .= '<td class="column-3">' . $description . '</td>';
							$modal_content .= '</tr>';

							if ( get_sub_field('compatibility') ) {
								$modal_content .= '<tr class="not-compatible"> ';
									$modal_content .= '<td colspan=3></td>';
								$modal_content .= '</tr>';
							}

							if ( $oddeven == "odd" ) {
								$oddeven = "even";
							} else {
								$oddeven = "odd";
							}

							$rowCount++;

					    }
					    $modal_content .= '</tbody>';
					$modal_content .= '</table>';
					$modal_content .= '<a href="#" class="close-modal-link"><< Back to School Report Card</a>';
				}
		    $modal_content .= '</div>';
		$modal_content .= '</div>';
	$modal_content .= '</div>';
$modal_content .= '</div>';

?>