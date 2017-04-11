<?php

	// THIS WILL BE THE GENERAL PARENT EMPOWERMENT STATEMENT

	$totalPointsEarned 	= $schoolData[count($schoolData)-1]["SGCS_PercentofTotalPossiblePoints_Percentile"];
	$schoolType 		= $schoolData[count($schoolData)-1]["TYPE"];

	if ( isset($totalPointsEarned) && !empty($totalPointsEarned) && $totalPointsEarned != "" ) {
		if ( $schoolType == 1 ) {
			// ELEMENTARY
			$breakpoint25 = get_field("SGCS_TotalPointsEarned_elementary_25th");
			$breakpoint50 = get_field("SGCS_TotalPointsEarned_elementary_50th");
			$breakpoint75 = get_field("SGCS_TotalPointsEarned_elementary_75th");

		} else if ( $schoolType == 2 ) {
			// MIDDLE
			$breakpoint25 = get_field("SGCS_TotalPointsEarned_middle_25th");
			$breakpoint50 = get_field("SGCS_TotalPointsEarned_middle_50th");
			$breakpoint75 = get_field("SGCS_TotalPointsEarned_middle_75th");

		} else if ( $schoolType == 4 ) {
			// COMBINATION
			$breakpoint25 = get_field("SGCS_TotalPointsEarned_combination_25th");
			$breakpoint50 = get_field("SGCS_TotalPointsEarned_combination_50th");
			$breakpoint75 = get_field("SGCS_TotalPointsEarned_combination_75th");

		} else if ( $schoolType == 3 ) {
			// HIGH
			$breakpoint25 = get_field("SGCS_TotalPointsEarned_high_25th");
			$breakpoint50 = get_field("SGCS_TotalPointsEarned_high_50th");
			$breakpoint75 = get_field("SGCS_TotalPointsEarned_high_75th");

		}

		$schoolGradeOutput .= "<p>" . inject_data(get_field("general_statement"), $schoolData, $schoolTypes) . "</p>";

		if ( isset($breakpoint25) && !empty($breakpoint25) && $breakpoint25 != 0 && 
			 isset($breakpoint50) && !empty($breakpoint50) && $breakpoint50 != 0 && 
			 isset($breakpoint75) && !empty($breakpoint75) && $breakpoint75 != 0 ) {
			if ( $totalPointsEarned < $breakpoint25 ) {
				// QUARTILE 1
				$statement = get_field("general_statement_quartile_1", 42);
				$statementIndex = rand(0, count($statement)-1);
				$schoolGradeOutput .= "<p>" . inject_data( $statement[$statementIndex]["statement"], $schoolData, $schoolTypes) . "</p>";
			} else if ( $totalPointsEarned >= $breakpoint25 && $totalPointsEarned < $breakpoint50 ) {
				// QUARTILE 2
				$statement = get_field("general_statement_quartile_2", 42);
				$statementIndex = rand(0, count($statement)-1);
				$schoolGradeOutput .= "<p>" . inject_data( $statement[$statementIndex]["statement"], $schoolData, $schoolTypes) . "</p>";
			} else if ( $totalPointsEarned >= $breakpoint50 && $totalPointsEarned < $breakpoint75 ) {
				// QUARTILE 3
				$statement = get_field("general_statement_quartile_3", 42);
				$statementIndex = rand(0, count($statement)-1);
				$schoolGradeOutput .= "<p>" . inject_data( $statement[$statementIndex]["statement"], $schoolData, $schoolTypes) . "</p>";
			} else if ( $totalPointsEarned >= $breakpoint75 ) {
				// QUARTILE 4
				$statement = get_field("general_statement_quartile_4", 42);
				$statementIndex = rand(0, count($statement)-1);
				$schoolGradeOutput .= "<p>" . inject_data( $statement[$statementIndex]["statement"], $schoolData, $schoolTypes) . "</p>";
			}
		}
		
	}

?>