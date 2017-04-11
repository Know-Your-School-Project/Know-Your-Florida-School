<?php

    /* CURRENT YEAR'S DATA */
    $totalPointsEarned = $schoolData[count($schoolData)-1]["SGCS_TotalPointsEarned"];
    $totalPossiblePoints = $schoolData[count($schoolData)-1]["SGCS_TotalComponents"] * 100;
    $gradePercent = $schoolData[count($schoolData)-1]["SGCS_PercentofTotalPossiblePoints"];
    $gradeLetter = $schoolData[count($schoolData)-1]["SchoolGrade"];
    $elaAchievement = $schoolData[count($schoolData)-1]["SGCS_EnglishLanguageArts_Achievement"];
    $mathAchievement = $schoolData[count($schoolData)-1]["SGCS_Mathematics_Achievement"];
    $elaLearningGains = $schoolData[count($schoolData)-1]["SGCS_EnglishLanguageArts_LearningGains"];
    $mathLearningGains = $schoolData[count($schoolData)-1]["SGCS_Mathematics_LearningGains"];
    $elaLearningGainsLow25 = $schoolData[count($schoolData)-1]["SGCS_EnglishLanguageArts_LearningGainsLow25"];
    $mathLearningGainsLow25 = $schoolData[count($schoolData)-1]["SGCS_Mathematics_LearningGainsLow25"];
    $scienceAchievement = $schoolData[count($schoolData)-1]["SGCS_Science_Achievement"];
    $socialStudiesAchievement = $schoolData[count($schoolData)-1]["SGCS_SocialStudies_Achievement"];
    $graduationRate = $schoolData[count($schoolData)-1]["SGCS_GraduationRateLagged"];
    $highAcceleration = $schoolData[count($schoolData)-1]["SGCS_CollegeandCareerAccelerationLagged"];
    $middleAcceleration = $schoolData[count($schoolData)-1]["SGCS_MiddleSchoolAcceleration"];

	$schoolGradeOutput .= '<div class="row">';
		$schoolGradeOutput .= '<div class="col-md-12"><div class="card">';
			$schoolGradeOutput .= '<div id="exhibit-grading-scale" class="exhibit-group">';

			    require_once( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );

			    if ( $schoolData > 0 ) {

			        /* START GRADING SCALE */
			        $schoolGradeOutput .= "\n\t\t\t" . '<h3 class="grading-scale-title">How is This Grade Calculated? <a href="/about/school-grades/#school-grade-components" title="How is this grade calculated?" target="_blank"><i class="eeflrc-icon-info" aria-hidden="true"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-info.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-info-purple.png" /></i></a></h3>';
			        $schoolGradeOutput .= inject_data(get_field("grading_scale_description", 42), $schoolData, $schoolTypes);
			        $schoolGradeOutput .= "\n\t\t\t" . '<div class="row">';
			            $schoolGradeOutput .= "\n\t\t\t" . '<div class="col-xs-6">';
				            $schoolGradeOutput .= "\n\t\t\t" . '<div class="grading-scale-components-wrap clearfix">';
							    if ( isset($gradeLetter) && !empty($gradeLetter) && $gradeLetter != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p><strong>School Grade</strong></p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $gradeLetter . '</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p><strong>School Grade</strong></p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($gradePercent) && !empty($gradePercent) && $gradePercent != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p><strong>Percent of Points Earned</strong></p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $gradePercent . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p><strong>Percent of Points Earned</strong></p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($elaAchievement) && !empty($elaAchievement) && $elaAchievement != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>ELA Achievement</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $elaAchievement . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>ELA Achievement</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($mathAchievement) && !empty($mathAchievement) && $mathAchievement != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>Math Achievement</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $mathAchievement . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>Math Achievement</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($elaLearningGains) && !empty($elaLearningGains) && $elaLearningGains != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>ELA Learning Gains</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $elaLearningGains . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>ELA Learning Gains</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($mathLearningGains) && !empty($mathLearningGains) && $mathLearningGains != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>Math Learning Gains</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $mathLearningGains . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>Math Learning Gains</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($elaLearningGainsLow25) && !empty($elaLearningGainsLow25) && $elaLearningGainsLow25 != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>ELA Learning Gains Lowest 25%</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $elaLearningGainsLow25 . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>ELA Learning Gains Lowest 25%</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($mathLearningGainsLow25) && !empty($mathLearningGainsLow25) && $mathLearningGainsLow25 != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>Math Learning Gains Lowest 25%</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $mathLearningGainsLow25 . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>Math Learning Gains Lowest 25%</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($scienceAchievement) && !empty($scienceAchievement) && $scienceAchievement != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>Science Achievement</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $scienceAchievement . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>Science Achievement</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($socialStudiesAchievement) && !empty($socialStudiesAchievement) && $socialStudiesAchievement != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>Social Studies Achievement</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $socialStudiesAchievement . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>Social Studies Achievement</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($graduationRate) && !empty($graduationRate) && $graduationRate != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>Graduation Rate</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $graduationRate . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>Graduation Rate</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($highAcceleration) && !empty($highAcceleration) && $highAcceleration != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>High School Acceleration</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $highAcceleration . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>High School Acceleration</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
							    if ( isset($middleAcceleration) && !empty($middleAcceleration) && $middleAcceleration != "" ) {
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-achievement"><p>Middle School Acceleration</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-achievement"><p>' . $middleAcceleration . '/100</p></div>';
				                } else {
				                	$schoolGradeOutput .= "\n\t\t\t" . '<div class="float-left label-not-available"><p>Middle School Acceleration</p></div>';
				                    $schoolGradeOutput .= "\n\t\t\t" . '<div class="float-right data-not-available"><p>N/A</p></div>';
				                }
			        		$schoolGradeOutput .= "\n\t\t\t" . '</div>';
			        	$schoolGradeOutput .= "\n\t\t\t" . '</div>';
			            $schoolGradeOutput .= "\n\t\t\t" . '<div class="col-xs-6">';
				            $schoolGradeOutput .= "\n\t\t\t" . '<div class="grading-scale-wrapper">';
					            $schoolGradeOutput .= "\n\t\t\t" . '<div class="grading-scale-bar"></div>';
					            $schoolGradeOutput .= "\n\t\t\t" . '<span class="scale-background">';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-A"></span>';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-B"></span>';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-C"></span>';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-D"></span>';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-F"></span>';
					            $schoolGradeOutput .= "\n\t\t\t" . '</span>';
					            $schoolGradeOutput .= "\n\t\t\t" . '<span class="letter-grades">';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-A">A</span>';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-B">B</span>';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-C">C</span>';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-D">D</span>';
					                $schoolGradeOutput .= "\n\t\t\t" . '<span class="grade-F">F</span>';
					            $schoolGradeOutput .= "\n\t\t\t" . '</span>';
					            $schoolGradeOutput .= "\n\t\t\t" . '<div class="grading-scale-fill" style="height:' . $schoolData[count($schoolData)-1]["SGCS_PercentofTotalPossiblePoints"] . '%;top:-' . $schoolData[count($schoolData)-1]["SGCS_PercentofTotalPossiblePoints"] . '%;" data-fill="' . $schoolData[count($schoolData)-1]["SGCS_PercentofTotalPossiblePoints"] . '%">';
					                $schoolGradeOutput .= "\n\t\t\t" . '<div class="total-points"><strong>' . $schoolData[count($schoolData)-1]["SGCS_TotalPointsEarned"] . '</strong> of ' . $schoolData[count($schoolData)-1]["SGCS_TotalComponents"] * 100 . ' points <strong>(' . $schoolData[count($schoolData)-1]["SGCS_PercentofTotalPossiblePoints"] . '%)</strong></div>';
					            $schoolGradeOutput .= "\n\t\t\t" . '</div>';
				        	$schoolGradeOutput .= "\n\t\t\t" . '</div>';
			        	$schoolGradeOutput .= "\n\t\t\t" . '</div>';
			        $schoolGradeOutput .= "\n\t\t\t" . '</div>';
			        /* END GRADING SCALE */
			        
			    }
			    
		    $schoolGradeOutput .= '</div>';
	        $schoolGradeOutput .= "\n\t\t\t" . '<div class="points-equation">';
	            $schoolGradeOutput .= "\n\t\t\t" . '<div class="col-md-12">';
	                $schoolGradeOutput .= "\n\t\t\t" . $schoolData[count($schoolData)-1]["SGCS_TotalPointsEarned"] . " ÷ " . $schoolData[count($schoolData)-1]["SGCS_TotalComponents"] * 100 . " = " . $gradePercent . '% = ' . $gradeLetter;
	            $schoolGradeOutput .= "\n\t\t\t" . '</div>';
	        $schoolGradeOutput .= "\n\t\t\t" . '</div>';
		$schoolGradeOutput .= '</div></div>';
	$schoolGradeOutput .= '</div>';

?>