<?php

	if ( isset($schoolData[count($schoolData)-1]["SchoolGrade"]) && $schoolData[count($schoolData)-1]["SchoolGrade"] != "" && $schoolData[count($schoolData)-1]["SchoolGrade"] != "I" ) {

		$schoolGradeOutput .= "<h4>" . ( $recentYear - 1 ) . "-" . substr( $recentYear, 2) . " School Grade</h4>";
		$schoolGradeOutput .= '<div class="school-grade">' . $schoolData[count($schoolData)-1]["SchoolGrade"] . "</div>";
		$schoolGradeOutput .= '<div class="grade-scale grade-' . $schoolData[count($schoolData)-1]["SchoolGrade"] . '"><span class="a-grade">A</span><span class="b-grade">B</span><span class="c-grade">C</span><span class="d-grade">D</span><span class="f-grade">F</span></div>';

	} else if (  isset($schoolData[count($schoolData)-1]["SchoolGrade"]) && $schoolData[count($schoolData)-1]["SchoolGrade"] == "I" ) {

		$schoolGradeOutput .= '<h4 class="no-grade">Insufficient Data</h4>';
		$schoolGradeOutput .= '<div class="school-grade no-grade">I</div>';
		$schoolGradeOutput .= '<div class="grade-scale no-grade"><span class="a-grade">A</span><span class="b-grade">B</span><span class="c-grade">C</span><span class="d-grade">D</span><span class="f-grade">F</span></div>';

	} else {

		$schoolGradeOutput .= '<h4 class="no-grade">No School Grade Data</h4>';
		$schoolGradeOutput .= '<div class="school-grade no-grade">--</div>';
		$schoolGradeOutput .= '<div class="grade-scale no-grade"><span class="a-grade">A</span><span class="b-grade">B</span><span class="c-grade">C</span><span class="d-grade">D</span><span class="f-grade">F</span></div>';

	}

?>