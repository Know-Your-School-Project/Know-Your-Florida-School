<?php

    if ( isset($school->data) && !empty($school->data) && count($school->data) > 0 ) {

        $schoolData = $school->data[0];

        echo '<li class="blog-item col-sm-4 school-' . $schoolData["SCHOOLID"] . ' grade-' . $schoolData["SchoolGrade"] . ' page type-page status-publish hentry selected-to-compare" data-schoolid="' . $schoolData["SCHOOLID"] . '">';
            echo '<div class="school-card">';
                echo '<div class="school-compare-input">';
                    echo '<i class="icon-school"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/masonry-item-school.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/masonry-item-school-grey.png"></i>';
                    echo '<a class="view-full-reportcard-link" href="' . get_home_url() . '/school-report-card/?schoolid=' . $schoolData["SCHOOLID"] . '&amp;districtid=' . $schoolData["DISTRICTID"] . '"><i class="icon-view-full-reportcard"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-view-full-reportcard.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-view-full-reportcard.png"></i> View Full Reportcard</a>';
                echo '</div>';
                echo '<div class="school-details clearfix">';

                    if ( count($schoolTypes->SchoolType) > 0 ) {
                        echo '<div class="school-type">';
                        foreach ($schoolTypes->SchoolType as $schoolType) {
                            if ( $schoolType->SCHOOLTYPE == $schoolData["TYPE"] ) {
                                echo $schoolType->TYPENAME;
                            }
                        }
                        echo '</div>';
                    }

                    echo '<div class="school-name">' . $schoolData["SCHOOL_NAME_LONG"] . '</div>';
                    
                echo '</div>';
                echo '<div class="school-stats clearfix">';

                    /* School Grade */
                    echo '<div class="school-stat school-stat-schoolgrade clearfix';
                    if ( !isset($schoolData["SchoolGrade"]) || empty ($schoolData["SchoolGrade"]) || $schoolData["SchoolGrade"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label"><strong>School Grade</strong></div>';
                        echo '<div class="school-stat-value">' . $schoolData["SchoolGrade"] . '</div>';
                    echo '</div>';

                    /* Percent of Points Earned */
                    echo '<div class="school-stat school-stat-pointedearned clearfix';
                    if ( !isset($schoolData["SGCS_PercentofTotalPossiblePoints"]) || empty ($schoolData["SGCS_PercentofTotalPossiblePoints"]) || $schoolData["SGCS_PercentofTotalPossiblePoints"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label"><strong>Percent of Points Earned</strong></div>';
                        if ( !isset($schoolData["SGCS_PercentofTotalPossiblePoints"]) || empty ($schoolData["SGCS_PercentofTotalPossiblePoints"]) || $schoolData["SGCS_PercentofTotalPossiblePoints"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_PercentofTotalPossiblePoints"] . '%</div>';
                        }
                    echo '</div>';

                    /* ELA Achievement */
                    echo '<div class="school-stat school-stat-ela-achievement clearfix';
                    if ( !isset($schoolData["SGCS_EnglishLanguageArts_Achievement"]) || empty ($schoolData["SGCS_EnglishLanguageArts_Achievement"]) || $schoolData["SGCS_EnglishLanguageArts_Achievement"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">ELA Achievement</div>';
                        if ( !isset($schoolData["SGCS_EnglishLanguageArts_Achievement"]) || empty ($schoolData["SGCS_EnglishLanguageArts_Achievement"]) || $schoolData["SGCS_EnglishLanguageArts_Achievement"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_EnglishLanguageArts_Achievement"] . '%</div>';
                        }
                    echo '</div>';

                    /* Math Achievement */
                    echo '<div class="school-stat school-stat-math-achievement clearfix';
                    if ( !isset($schoolData["SGCS_Mathematics_Achievement"]) || empty ($schoolData["SGCS_Mathematics_Achievement"]) || $schoolData["SGCS_Mathematics_Achievement"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">Math Achievement</div>';
                        if ( !isset($schoolData["SGCS_Mathematics_Achievement"]) || empty ($schoolData["SGCS_Mathematics_Achievement"]) || $schoolData["SGCS_Mathematics_Achievement"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_Mathematics_Achievement"] . '%</div>';
                        }
                    echo '</div>';

                    /* Science Achievement */
                    echo '<div class="school-stat school-stat-science-achievement clearfix';
                    if ( !isset($schoolData["SGCS_Science_Achievement"]) || empty ($schoolData["SGCS_Science_Achievement"]) || $schoolData["SGCS_Science_Achievement"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">Science Achievement</div>';
                        if ( !isset($schoolData["SGCS_Science_Achievement"]) || empty ($schoolData["SGCS_Science_Achievement"]) || $schoolData["SGCS_Science_Achievement"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_Science_Achievement"] . '%</div>';
                        }
                    echo '</div>';

                    /* Social Studies Achievement */
                    echo '<div class="school-stat school-stat-socialstudies-achievement clearfix';
                    if ( !isset($schoolData["SGCS_SocialStudies_Achievement"]) || empty ($schoolData["SGCS_SocialStudies_Achievement"]) || $schoolData["SGCS_SocialStudies_Achievement"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">Social Studies Achievement</div>';
                        if ( !isset($schoolData["SGCS_SocialStudies_Achievement"]) || empty ($schoolData["SGCS_SocialStudies_Achievement"]) || $schoolData["SGCS_SocialStudies_Achievement"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_SocialStudies_Achievement"] . '%</div>';
                        }
                    echo '</div>';

                    /* ELA Learning Gains */
                    echo '<div class="school-stat school-stat-ela-learning-gains clearfix';
                    if ( !isset($schoolData["SGCS_EnglishLanguageArts_LearningGains"]) || empty ($schoolData["SGCS_EnglishLanguageArts_LearningGains"]) || $schoolData["SGCS_EnglishLanguageArts_LearningGains"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">ELA Learning Gains</div>';
                        if ( !isset($schoolData["SGCS_EnglishLanguageArts_LearningGains"]) || empty ($schoolData["SGCS_EnglishLanguageArts_LearningGains"]) || $schoolData["SGCS_EnglishLanguageArts_LearningGains"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_EnglishLanguageArts_LearningGains"] . '%</div>';
                        }
                    echo '</div>';

                    /* Math Learning Gains */
                    echo '<div class="school-stat school-stat-math-learning-gains clearfix';
                    if ( !isset($schoolData["SGCS_Mathematics_LearningGains"]) || empty ($schoolData["SGCS_Mathematics_LearningGains"]) || $schoolData["SGCS_Mathematics_LearningGains"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">Math Learning Gains</div>';
                        if ( !isset($schoolData["SGCS_Mathematics_LearningGains"]) || empty ($schoolData["SGCS_Mathematics_LearningGains"]) || $schoolData["SGCS_Mathematics_LearningGains"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_Mathematics_LearningGains"] . '%</div>';
                        }
                    echo '</div>';

                    /* ELA Learning Gains Low 25% */
                    echo '<div class="school-stat school-stat-ela-learning-gains-low25 clearfix';
                    if ( !isset($schoolData["SGCS_EnglishLanguageArts_LearningGainsLow25"]) || empty ($schoolData["SGCS_EnglishLanguageArts_LearningGainsLow25"]) || $schoolData["SGCS_EnglishLanguageArts_LearningGainsLow25"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">ELA Learning Gains Lowest 25%</div>';
                        if ( !isset($schoolData["SGCS_EnglishLanguageArts_LearningGainsLow25"]) || empty ($schoolData["SGCS_EnglishLanguageArts_LearningGainsLow25"]) || $schoolData["SGCS_EnglishLanguageArts_LearningGainsLow25"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_EnglishLanguageArts_LearningGainsLow25"] . '%</div>';
                        }
                    echo '</div>';

                    /* Math Learning Gains Lowest 25% */
                    echo '<div class="school-stat school-stat-math-learning-gains-low25 clearfix';
                    if ( !isset($schoolData["SGCS_Mathematics_LearningGainsLow25"]) || empty ($schoolData["SGCS_Mathematics_LearningGainsLow25"]) || $schoolData["SGCS_Mathematics_LearningGainsLow25"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">Math Learning Gains Lowest 25%</div>';
                        if ( !isset($schoolData["SGCS_Mathematics_LearningGainsLow25"]) || empty ($schoolData["SGCS_Mathematics_LearningGainsLow25"]) || $schoolData["SGCS_Mathematics_LearningGainsLow25"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_Mathematics_LearningGainsLow25"] . '%</div>';                        
                        }
                    echo '</div>';

                    /* Middle School Acceleration */
                    echo '<div class="school-stat school-stat-middle-acceleration clearfix';
                    if ( !isset($schoolData["SGCS_MiddleSchoolAcceleration"]) || empty ($schoolData["SGCS_MiddleSchoolAcceleration"]) || $schoolData["SGCS_MiddleSchoolAcceleration"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">Middle School Acceleration</div>';
                        if ( !isset($schoolData["SGCS_MiddleSchoolAcceleration"]) || empty ($schoolData["SGCS_MiddleSchoolAcceleration"]) || $schoolData["SGCS_MiddleSchoolAcceleration"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_MiddleSchoolAcceleration"] . '%</div>';                        
                        }
                    echo '</div>';

                    /* High School Acceleration */
                    echo '<div class="school-stat school-stat-high-acceleration clearfix';
                    if ( !isset($schoolData["SGCS_CollegeandCareerAccelerationLagged"]) || empty ($schoolData["SGCS_CollegeandCareerAccelerationLagged"]) || $schoolData["SGCS_CollegeandCareerAccelerationLagged"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">High School Acceleration</div>';
                        if ( !isset($schoolData["SGCS_CollegeandCareerAccelerationLagged"]) || empty ($schoolData["SGCS_CollegeandCareerAccelerationLagged"]) || $schoolData["SGCS_CollegeandCareerAccelerationLagged"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_CollegeandCareerAccelerationLagged"] . '%</div>';                      
                        }
                    echo '</div>';

                    /* Graduation Rate */
                    echo '<div class="school-stat school-stat-gradrate clearfix';
                    if ( !isset($schoolData["SGCS_GraduationRateLagged"]) || empty ($schoolData["SGCS_GraduationRateLagged"]) || $schoolData["SGCS_GraduationRateLagged"] == "" ) {
                        echo " disable-stat";
                    }
                    echo '">';
                        echo '<div class="school-stat-label">Graduation Rate</div>';
                        if ( !isset($schoolData["SGCS_GraduationRateLagged"]) || empty ($schoolData["SGCS_GraduationRateLagged"]) || $schoolData["SGCS_GraduationRateLagged"] == "" ) {
                            echo '<div class="school-stat-value"></div>';
                        } else {
                            echo '<div class="school-stat-value">' . $schoolData["SGCS_GraduationRateLagged"] . '%</div>';                      
                        } 
                    echo '</div>';

                    echo '<div class="school-stat school-stat-description clearfix">';
                        echo 'School grade and student performance by component is for the ' . ( $schoolData["YEAR"] - 1 ) . "-" . substr( $schoolData["YEAR"], 2) . ' school year.';
                    echo '</div>';

                echo '</div>';
            echo '</div>';
        echo '</li>';
      
    }         

?>