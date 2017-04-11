<?php

    /* START ELEMENTARY SCHOOL CALCULATION */

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

    $schoolType = $schoolData[count($schoolData)-1]["TYPE"];

    $components = array(
                    "SGCS_EnglishLanguageArts_Achievement", 
                    "SGCS_Mathematics_Achievement",
                    "SGCS_Science_Achievement",
                    "SGCS_SocialStudies_Achievement", 
                    "SGCS_EnglishLanguageArts_LearningGains", 
                    "SGCS_Mathematics_LearningGains", 
                    "SGCS_EnglishLanguageArts_LearningGainsLow25", 
                    "SGCS_Mathematics_LearningGainsLow25", 
                    "SGCS_CollegeandCareerAccelerationLagged", 
                    "SGCS_MiddleSchoolAcceleration", 
        );

    $highestComponent   = "";
    $highestScore       = 0;

    $lowestComponent    = "";
    $lowestScore        = 100;

    foreach($components as $component) {
        if ( $schoolData[count($schoolData)-1][$component] != "" ) {
            if ( $schoolData[count($schoolData)-1][$component] > $highestScore ) {
                $highestComponent   = $component;
                $highestScore       = $schoolData[count($schoolData)-1][$component];
            } 
            if ( $schoolData[count($schoolData)-1][$component] < $lowestScore ) {
                $lowestComponent    = $component;
                $lowestScore        = $schoolData[count($schoolData)-1][$component];
            }
        }
    }

    $reportCardOutput = "\n\t\t" . '<div class="school-calc">';

        /* START DATA BREAKDOWN */
        $reportCardOutput .= "\n\t\t\t" . '<div class="row points-calc">';
            $reportCardOutput .= "\n\t\t\t" . '<div class="row points-header">';
                $reportCardOutput .= "\n\t\t\t" . '<div class="col-sm-12">';
                    $reportCardOutput .= "\n\t\t\t" . '<h2>' . ucwords(strtolower($schoolName)) . '</h2>';
                    $reportCardOutput .= "\n\t\t\t" . '<h4>' . ( $recentYear - 1 ) . "-" . $recentYear . ' Student Performance by School Grade Component</h4>';
                    $reportCardOutput .= "\n\t\t\t" . inject_data(get_field("report_card_description", 42), $schoolData, $schoolTypes);
                $reportCardOutput .= "\n\t\t\t" . '</div>';
            $reportCardOutput .= "\n\t\t\t" . '</div>';
            
            if ( ( isset($elaAchievement) && !empty($elaAchievement) && $elaAchievement != "" ) || 
                 ( isset($mathAchievement) && !empty($mathAchievement) && $mathAchievement != "" ) || 
                 ( isset($scienceAchievement) && !empty($scienceAchievement) && $scienceAchievement != "" ) || 
                 ( isset($socialStudiesAchievement) && !empty($socialStudiesAchievement) && $socialStudiesAchievement != "" ) ) {
                $reportCardOutput .= "\n\t\t\t" . '<div class="row dot-border-bottom">';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="icon-component icon-component-acievement" aria-hidden="true"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-component-achievement.svg" data-fallback"' . get_stylesheet_directory_uri() . '/images/icon-component-achievement.png" /></div>';
                    $reportCardOutput .= "\n\t\t\t" . '<p class="component-title">Achievement</p>';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="achievement-components">';
                        if ( isset($elaAchievement) && !empty($elaAchievement) && $elaAchievement != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_Achievement_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_Achievement_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_Achievement_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_Achievement_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_Achievement_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_Achievement_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_Achievement_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_Achievement_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_Achievement_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_Achievement_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_Achievement_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_Achievement_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> English Language Arts</a>';
                            if ( $highestComponent == "SGCS_EnglishLanguageArts_Achievement" ) {
                                if ( $elaAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, "green", $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint25 && $elaAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, "green", $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint50 && $elaAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, "green", $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_EnglishLanguageArts_Achievement" ) {
                                if ( $elaAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, "red", $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint25 && $elaAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, "red", $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint50 && $elaAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, "red", $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $elaAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, null, $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint25 && $elaAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, null, $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint50 && $elaAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, null, $post ) . '</p></div>';
                                } else if ( $elaAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_Achievement", $elaAchievement, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($elaAchievement) && !empty($elaAchievement) && $elaAchievement != "" ) {
                                if ( $highestComponent == "SGCS_EnglishLanguageArts_Achievement" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_EnglishLanguageArts_Achievement" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $elaAchievement . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                        if ( isset($mathAchievement) && !empty($mathAchievement) && $mathAchievement != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_Mathematics_Achievement_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_Achievement_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_Achievement_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_Mathematics_Achievement_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_Achievement_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_Achievement_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_Mathematics_Achievement_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_Achievement_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_Achievement_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_Mathematics_Achievement_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_Achievement_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_Achievement_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> Mathematics</a>';
                            if ( $highestComponent == "SGCS_Mathematics_Achievement" ) {
                                if ( $mathAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, "green", $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint25 && $mathAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement highest"><p>' .inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, "green", $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint50 && $mathAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, "green", $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_Mathematics_Achievement" ) {
                                if ( $mathAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, "red", $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint25 && $mathAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, "red", $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint50 && $mathAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, "red", $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $mathAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, null, $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint25 && $mathAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, null, $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint50 && $mathAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, null, $post ) . '</p></div>';
                                } else if ( $mathAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_Achievement", $mathAchievement, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($mathAchievement) && !empty($mathAchievement) && $mathAchievement != "" ) {
                                if ( $highestComponent == "SGCS_Mathematics_Achievement" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_Mathematics_Achievement" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $mathAchievement . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                        if ( isset($scienceAchievement) && !empty($scienceAchievement) && $scienceAchievement != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_Science_Achievement_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_Science_Achievement_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_Science_Achievement_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_Science_Achievement_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_Science_Achievement_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_Science_Achievement_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_Science_Achievement_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_Science_Achievement_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_Science_Achievement_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_Science_Achievement_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_Science_Achievement_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_Science_Achievement_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> Science</a>';
                            if ( $highestComponent == "SGCS_Science_Achievement" ) {
                                if ( $scienceAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, "green", $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint25 && $scienceAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, "green", $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint50 && $scienceAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, "green", $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_Science_Achievement" ) {
                                if ( $scienceAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, "red", $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint25 && $scienceAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, "red", $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint50 && $scienceAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, "red", $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $scienceAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, null, $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint25 && $scienceAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, null, $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint50 && $scienceAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, null, $post ) . '</p></div>';
                                } else if ( $scienceAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Science_Achievement", $scienceAchievement, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($scienceAchievement) && !empty($scienceAchievement) && $scienceAchievement != "" ) {
                                if ( $highestComponent == "SGCS_Science_Achievement" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_Science_Achievement" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $scienceAchievement . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                        if ( isset($socialStudiesAchievement) && !empty($socialStudiesAchievement) && $socialStudiesAchievement != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_SocialStudies_Achievement_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_SocialStudies_Achievement_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_SocialStudies_Achievement_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_SocialStudies_Achievement_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_SocialStudies_Achievement_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_SocialStudies_Achievement_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_SocialStudies_Achievement_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_SocialStudies_Achievement_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_SocialStudies_Achievement_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_SocialStudies_Achievement_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_SocialStudies_Achievement_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_SocialStudies_Achievement_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> Social Studies</a>';
                            if ( $highestComponent == "SGCS_SocialStudies_Achievement" ) {
                                if ( $socialStudiesAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, "green", $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint25 && $socialStudiesAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, "green", $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint50 && $socialStudiesAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, "green", $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_SocialStudies_Achievement" ) {
                                if ( $socialStudiesAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, "red", $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint25 && $socialStudiesAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, "red", $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint50 && $socialStudiesAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, "red", $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="socialstudies-achievement-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $socialStudiesAchievement < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, null, $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint25 && $socialStudiesAchievement < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, null, $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint50 && $socialStudiesAchievement < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, null, $post ) . '</p></div>';
                                } else if ( $socialStudiesAchievement >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="science-achievement-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_SocialStudies_Achievement", $socialStudiesAchievement, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($socialStudiesAchievement) && !empty($socialStudiesAchievement) && $socialStudiesAchievement != "" ) {
                                if ( $highestComponent == "SGCS_SocialStudies_Achievement" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_SocialStudies_Achievement" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $socialStudiesAchievement . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                    $reportCardOutput .= "\n\t\t\t" . '</div>';
                $reportCardOutput .= "\n\t\t\t" . '</div>';
            }
            if ( ( isset($elaLearningGains) && !empty($elaLearningGains) && $elaLearningGains != "" ) || 
                 ( isset($mathLearningGains) && !empty($mathLearningGains) && $mathLearningGains != "" ) ) {
                $reportCardOutput .= "\n\t\t\t" . '<div class="row dot-border-bottom">';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="icon-component icon-component-learning-gains" aria-hidden="true"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-component-learning-gains.svg" data-fallback"' . get_stylesheet_directory_uri() . '/images/icon-component-learning-gains.png" /></div>';
                    $reportCardOutput .= "\n\t\t\t" . '<p class="component-title">Learning Gains</p>';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="learning-gains-components">';
                        if ( isset($elaLearningGains) && !empty($elaLearningGains) && $elaLearningGains != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_LearningGains_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_LearningGains_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_LearningGains_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_LearningGains_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_LearningGains_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_LearningGains_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_LearningGains_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_LearningGains_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_LearningGains_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_LearningGains_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_LearningGains_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_LearningGains_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> English Language Arts</a>';
                            if ( $highestComponent == "SGCS_EnglishLanguageArts_LearningGains" ) {
                                if ( $elaLearningGains < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, "green", $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint25 && $elaLearningGains < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, "green", $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint50 && $elaLearningGains < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, "green", $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_EnglishLanguageArts_LearningGains" ) {
                                if ( $elaLearningGains < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, "red", $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint25 && $elaLearningGains < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, "red", $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint50 && $elaLearningGains < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, "red", $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $elaLearningGains < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, null, $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint25 && $elaLearningGains < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, null, $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint50 && $elaLearningGains < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, null, $post ) . '</p></div>';
                                } else if ( $elaLearningGains >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGains", $elaLearningGains, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($elaLearningGains) && !empty($elaLearningGains) && $elaLearningGains != "" ) {
                                if ( $highestComponent == "SGCS_EnglishLanguageArts_LearningGains" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_EnglishLanguageArts_LearningGains" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $elaLearningGains . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                        if ( isset($mathLearningGains) && !empty($mathLearningGains) && $mathLearningGains != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_Mathematics_LearningGains_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_LearningGains_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_LearningGains_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_Mathematics_LearningGains_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_LearningGains_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_LearningGains_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_Mathematics_LearningGains_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_LearningGains_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_LearningGains_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_Mathematics_LearningGains_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_LearningGains_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_LearningGains_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> Mathematics</a>';
                            if ( $highestComponent == "SGCS_Mathematics_LearningGains" ) {
                                if ( $mathLearningGains < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, "green", $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint25 && $mathLearningGains < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, "green", $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint50 && $mathLearningGains < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, "green", $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_Mathematics_LearningGains" ) {
                                if ( $mathLearningGains < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, "red", $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint25 && $mathLearningGains < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, "red", $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint50 && $mathLearningGains < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, "red", $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $mathLearningGains < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, null, $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint25 && $mathLearningGains < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, null, $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint50 && $mathLearningGains < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, null, $post ) . '</p></div>';
                                } else if ( $mathLearningGains >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGains", $mathLearningGains, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($mathLearningGains) && !empty($mathLearningGains) && $mathLearningGains != "" ) {
                                if ( $highestComponent == "SGCS_Mathematics_LearningGains" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_Mathematics_LearningGains" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $mathLearningGains . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                    $reportCardOutput .= "\n\t\t\t" . '</div>';
                $reportCardOutput .= "\n\t\t\t" . '</div>';
            }
            if ( ( isset($elaLearningGainsLow25) && !empty($elaLearningGainsLow25) && $elaLearningGainsLow25 != "" ) || 
                 ( isset($mathLearningGainsLow25) && !empty($mathLearningGainsLow25) && $mathLearningGainsLow25 != "" ) ) {
                $reportCardOutput .= "\n\t\t\t" . '<div class="row dot-border-bottom">';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="icon-component icon-component-learning-gains-low-25" aria-hidden="true"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-component-learning-gains-low-25.svg" data-fallback"' . get_stylesheet_directory_uri() . '/images/icon-component-learning-gains-low-25.png" /></div>';
                    $reportCardOutput .= "\n\t\t\t" . '<p class="component-title">Learning Gains of Lowest Performing Students</p>';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="learning-gains-low25-components">';
                        if ( isset($elaLearningGainsLow25) && !empty($elaLearningGainsLow25) && $elaLearningGainsLow25 != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_EnglishLanguageArts_LearningGainsLow25_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> English Language Arts</a>';
                            if ( $highestComponent == "SGCS_EnglishLanguageArts_LearningGainsLow25" ) {
                                if ( $elaLearningGainsLow25 < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, "green", $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint25 && $elaLearningGainsLow25 < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, "green", $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint50 && $elaLearningGainsLow25 < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, "green", $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_EnglishLanguageArts_LearningGainsLow25" ) {
                                if ( $elaLearningGainsLow25 < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, "red", $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint25 && $elaLearningGainsLow25 < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, "red", $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint50 && $elaLearningGainsLow25 < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, "red", $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $elaLearningGainsLow25 < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, null, $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint25 && $elaLearningGainsLow25 < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, null, $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint50 && $elaLearningGainsLow25 < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, null, $post ) . '</p></div>';
                                } else if ( $elaLearningGainsLow25 >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-low25-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_EnglishLanguageArts_LearningGainsLow25", $elaLearningGainsLow25, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($elaLearningGainsLow25) && !empty($elaLearningGainsLow25) && $elaLearningGainsLow25 != "" ) {
                                if ( $highestComponent == "SGCS_EnglishLanguageArts_LearningGainsLow25" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_EnglishLanguageArts_LearningGainsLow25" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $elaLearningGainsLow25 . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                        if ( isset($mathLearningGainsLow25) && !empty($mathLearningGainsLow25) && $mathLearningGainsLow25 != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_Mathematics_LearningGainsLow25_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_LearningGainsLow25_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_LearningGainsLow25_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_Mathematics_LearningGainsLow25_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_LearningGainsLow25_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_LearningGainsLow25_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_Mathematics_LearningGainsLow25_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_LearningGainsLow25_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_LearningGainsLow25_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_Mathematics_LearningGainsLow25_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_Mathematics_LearningGainsLow25_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_Mathematics_LearningGainsLow25_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> Mathematics</a>';
                            if ( $highestComponent == "SGCS_Mathematics_LearningGainsLow25" ) {
                                if ( $mathLearningGainsLow25 < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, "green", $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint25 && $mathLearningGainsLow25 < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, "green", $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint50 && $mathLearningGainsLow25 < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, "green", $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_Mathematics_LearningGainsLow25" ) {
                                if ( $mathLearningGainsLow25 < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, "red", $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint25 && $mathLearningGainsLow25 < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, "red", $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint50 && $mathLearningGainsLow25 < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, "red", $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $mathLearningGainsLow25 < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, null, $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint25 && $mathLearningGainsLow25 < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, null, $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint50 && $mathLearningGainsLow25 < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, null, $post ) . '</p></div>';
                                } else if ( $mathLearningGainsLow25 >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="math-learning-gains-low25-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_Mathematics_LearningGainsLow25", $mathLearningGainsLow25, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($mathLearningGainsLow25) && !empty($mathLearningGainsLow25) && $mathLearningGainsLow25 != "" ) {
                                if ( $highestComponent == "SGCS_Mathematics_LearningGainsLow25" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_Mathematics_LearningGainsLow25" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $mathLearningGainsLow25 . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                    $reportCardOutput .= "\n\t\t\t" . '</div>';
                $reportCardOutput .= "\n\t\t\t" . '</div>';
            }
            if ( ( isset($middleAcceleration) && !empty($middleAcceleration) && $middleAcceleration != "" ) || 
                 ( isset($highAcceleration) && !empty($highAcceleration) && $highAcceleration != "" ) ) {
                $reportCardOutput .= "\n\t\t\t" . '<div class="row dot-border-bottom">';
                    if ( isset($middleAcceleration) && !empty($middleAcceleration) && $middleAcceleration != "" ) {
                        $reportCardOutput .= "\n\t\t\t" . '<div class="icon-component icon-component-middle-acceleration" aria-hidden="true"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-component-middle-acceleration.svg" data-fallback"' . get_stylesheet_directory_uri() . '/images/icon-component-middle-acceleration.png" /></div>';
                    }
                    if ( isset($highAcceleration) && !empty($highAcceleration) && $highAcceleration != "" ) {
                        $reportCardOutput .= "\n\t\t\t" . '<div class="icon-component icon-component-high-acceleration" aria-hidden="true"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-component-high-acceleration.svg" data-fallback"' . get_stylesheet_directory_uri() . '/images/icon-component-high-acceleration.png" /></div>';
                    }
                    $reportCardOutput .= "\n\t\t\t" . '<p class="component-title">Acceleration</p>';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="acceleration-components">';
                        if ( isset($middleAcceleration) && !empty($middleAcceleration) && $middleAcceleration != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_MiddleSchoolAcceleration_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_MiddleSchoolAcceleration_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_MiddleSchoolAcceleration_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_MiddleSchoolAcceleration_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_MiddleSchoolAcceleration_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_MiddleSchoolAcceleration_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_MiddleSchoolAcceleration_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_MiddleSchoolAcceleration_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_MiddleSchoolAcceleration_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_MiddleSchoolAcceleration_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_MiddleSchoolAcceleration_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_MiddleSchoolAcceleration_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> Middle School</a>';
                            if ( $highestComponent == "SGCS_MiddleSchoolAcceleration" ) {
                                if ( $middleAcceleration < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, "green", $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint25 && $middleAcceleration < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, "green", $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint50 && $middleAcceleration < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, "green", $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_MiddleSchoolAcceleration" ) {
                                if ( $middleAcceleration < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, "red", $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint25 && $middleAcceleration < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, "red", $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint50 && $middleAcceleration < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, "red", $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $middleAcceleration < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, null, $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint25 && $middleAcceleration < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, null, $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint50 && $middleAcceleration < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, null, $post ) . '</p></div>';
                                } else if ( $middleAcceleration >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="middle-acceleration-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_MiddleSchoolAcceleration", $middleAcceleration, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($middleAcceleration) && !empty($middleAcceleration) && $middleAcceleration != "" ) {
                                if ( $highestComponent == "SGCS_MiddleSchoolAcceleration" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_MiddleSchoolAcceleration" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $middleAcceleration . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                        if ( isset($highAcceleration) && !empty($highAcceleration) && $highAcceleration != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("SGCS_CollegeandCareerAcceleration201314_elementary_25th", 42);
                                $breakpoint50 = get_field("SGCS_CollegeandCareerAcceleration201314_elementary_50th", 42);
                                $breakpoint75 = get_field("SGCS_CollegeandCareerAcceleration201314_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("SGCS_CollegeandCareerAcceleration201314_middle_25th", 42);
                                $breakpoint50 = get_field("SGCS_CollegeandCareerAcceleration201314_middle_50th", 42);
                                $breakpoint75 = get_field("SGCS_CollegeandCareerAcceleration201314_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("SGCS_CollegeandCareerAcceleration201314_combination_25th", 42);
                                $breakpoint50 = get_field("SGCS_CollegeandCareerAcceleration201314_combination_50th", 42);
                                $breakpoint75 = get_field("SGCS_CollegeandCareerAcceleration201314_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("SGCS_CollegeandCareerAcceleration201314_high_25th", 42);
                                $breakpoint50 = get_field("SGCS_CollegeandCareerAcceleration201314_high_50th", 42);
                                $breakpoint75 = get_field("SGCS_CollegeandCareerAcceleration201314_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="ela-learning-gains-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> High School</a>';
                            if ( $highestComponent == ": 4px;" ) {
                                if ( $highAcceleration < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("highest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, "green", $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint25 && $highAcceleration < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("highest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, "green", $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint50 && $highAcceleration < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("highest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, "green", $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("highest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement highest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, "green", $post ) . '</p></div>';
                                }
                            } else if ( $lowestComponent == "SGCS_CollegeandCareerAccelerationLagged" ) {
                                if ( $highAcceleration < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("lowest_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, "red", $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint25 && $highAcceleration < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("lowest_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, "red", $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint50 && $highAcceleration < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("lowest_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, "red", $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("lowest_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement lowest"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, "red", $post ) . '</p></div>';
                                }
                            } else {
                                if ( $highAcceleration < $breakpoint25 ) {
                                    // QUARTILE 1
                                    $statement = get_field("neither_component_quartile_1", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, null, $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint25 && $highAcceleration < $breakpoint50 ) {
                                    // QUARTILE 2
                                    $statement = get_field("neither_component_quartile_2", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, null, $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint50 && $highAcceleration < $breakpoint75 ) {
                                    // QUARTILE 3
                                    $statement = get_field("neither_component_quartile_3", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, null, $post ) . '</p></div>';
                                } else if ( $highAcceleration >= $breakpoint75 ) {
                                    // QUARTILE 4
                                    $statement = get_field("neither_component_quartile_4", 42);
                                    $statementIndex = rand(0, count($statement)-1);
                                    $reportCardOutput .= "\n\t\t\t" . '<div id="high-acceleration-pe-statement" class="pe-statement" style="display:none;"><p>' . inject_component( $statement[$statementIndex]["statement"], "SGCS_CollegeandCareerAccelerationLagged", $highAcceleration, null, $post ) . '</p></div>';
                                }
                            }
                            if ( isset($highAcceleration) && !empty($highAcceleration) && $highAcceleration != "" ) {
                                if ( $highestComponent == "SGCS_CollegeandCareerAccelerationLagged" ) {
                                    $color = "green";
                                } else if ( $lowestComponent == "SGCS_CollegeandCareerAccelerationLagged" ) {
                                    $color = "red";
                                } else {
                                    $color = "blue";
                                }
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-' . $color . '">' . $highAcceleration . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                    $reportCardOutput .= "\n\t\t\t" . '</div>';
                $reportCardOutput .= "\n\t\t\t" . '</div>';
            }
            if ( ( isset($graduationRate) && !empty($graduationRate) && $graduationRate != "" ) ) {
                $reportCardOutput .= "\n\t\t\t" . '<div class="row solid-border-bottom">';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="icon-component icon-component-grad-rate" aria-hidden="true"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-component-grad-rate.svg" data-fallback"' . get_stylesheet_directory_uri() . '/images/icon-component-grad-rate.png" /></div>';
                    $reportCardOutput .= "\n\t\t\t" . '<p class="component-title">Graduation Rate</p>';
                    $reportCardOutput .= "\n\t\t\t" . '<div class="graduation-rate-components">';
                        if ( isset($graduationRate) && !empty($graduationRate) && $graduationRate != "" ) {
                            if ( $schoolType == 1 ) {
                                // ELEMENTARY
                                $breakpoint25 = get_field("GradRate_elementary_25th", 42);
                                $breakpoint50 = get_field("GradRate_elementary_50th", 42);
                                $breakpoint75 = get_field("GradRate_elementary_75th", 42);
                            } else if ( $schoolType == 2 ) {
                                // MIDDLE
                                $breakpoint25 = get_field("GradRate_middle_25th", 42);
                                $breakpoint50 = get_field("GradRate_middle_50th", 42);
                                $breakpoint75 = get_field("GradRate_middle_75th", 42);
                            } else if ( $schoolType == 4 ) {
                                // COMBINATION
                                $breakpoint25 = get_field("GradRate_combination_25th", 42);
                                $breakpoint50 = get_field("GradRate_combination_50th", 42);
                                $breakpoint75 = get_field("GradRate_combination_75th", 42);
                            } else if ( $schoolType == 3 ) {
                                // HIGH
                                $breakpoint25 = get_field("GradRate_high_25th", 42);
                                $breakpoint50 = get_field("GradRate_high_50th", 42);
                                $breakpoint75 = get_field("GradRate_high_75th", 42);
                            }
                            $reportCardOutput .= "\n\t\t\t" . '<div id="graduation-rate-wrapper" class="component"><a href="#" class="pe-component"><img class="inject-me" aria-hidden="true" data-src="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.svg" data-fallback="' . get_stylesheet_directory_uri() . '/images/icon-accordion-caret.png" /> Graduation Rate</a>';
                            if ( $graduationRate < $breakpoint25 ) {
                                // QUARTILE 1
                                $statement = get_field("graduation_rate_quartile_1", 42);
                                $statementIndex = rand(0, count($statement)-1);
                                $reportCardOutput .= "\n\t\t\t" . '<div id="graduation-rate-pe-statement" class="pe-statement grad-rate"><p>' . inject_data( inject_component( $statement[$statementIndex]["statement"], "SGCS_GraduationRateLagged", $graduationRate, null, $post ), $schoolData, $schoolTypes) . '</p></div>';
                            } else if ( $graduationRate >= $breakpoint25 && $graduationRate < $breakpoint50 ) {
                                // QUARTILE 2
                                $statement = get_field("graduation_rate_quartile_2", 42);
                                $statementIndex = rand(0, count($statement)-1);
                                $reportCardOutput .= "\n\t\t\t" . '<div id="graduation-rate-pe-statement" class="pe-statement grad-rate"><p>' . inject_data( inject_component( $statement[$statementIndex]["statement"], "SGCS_GraduationRateLagged", $graduationRate, null, $post ), $schoolData, $schoolTypes) . '</p></div>';
                            } else if ( $graduationRate >= $breakpoint50 && $graduationRate < $breakpoint75 ) {
                                // QUARTILE 3
                                $statement = get_field("graduation_rate_quartile_3", 42);
                                $statementIndex = rand(0, count($statement)-1);
                                $reportCardOutput .= "\n\t\t\t" . '<div id="graduation-rate-pe-statement" class="pe-statement grad-rate"><p>' . inject_data( inject_component( $statement[$statementIndex]["statement"], "SGCS_GraduationRateLagged", $graduationRate, null, $post ), $schoolData, $schoolTypes) . '</p></div>';
                            } else if ( $graduationRate >= $breakpoint75 ) {
                                // QUARTILE 4
                                $statement = get_field("graduation_rate_quartile_4", 42);
                                $statementIndex = rand(0, count($statement)-1);
                                $reportCardOutput .= "\n\t\t\t" . '<div id="graduation-rate-pe-statement" class="pe-statement grad-rate"><p>' . inject_data( inject_component( $statement[$statementIndex]["statement"], "SGCS_GraduationRateLagged", $graduationRate, null, $post ), $schoolData, $schoolTypes) . '</p></div>';
                            }
                            if ( isset($graduationRate) && !empty($graduationRate) && $graduationRate != "" ) {
                                $reportCardOutput .= "\n\t\t\t" . '<div class="component-value"><span class="color-blue">' . $graduationRate . '%</span></div>';
                            }
                            $reportCardOutput .= "\n\t\t\t" . '</div>';
                        }
                    $reportCardOutput .= "\n\t\t\t" . '</div>';
                $reportCardOutput .= "\n\t\t\t" . '</div>';
            }
        $reportCardOutput .= "\n\t\t\t" . '</div>';
        $reportCardOutput .= "\n\t\t\t" . '<div class="row points-equation">';
            $reportCardOutput .= "\n\t\t\t" . '<div class="col-md-12">';
                $reportCardOutput .= "\n\t\t\t" . $gradePercent . '% = ' . $gradeLetter;
            $reportCardOutput .= "\n\t\t\t" . '</div>';
        $reportCardOutput .= "\n\t\t\t" . '</div>';

        $reportCardOutput .= "\n\t\t\t" . '<div id="understanding-grade-overlay">';
            $reportCardOutput .= "\n\t\t\t" . '<a href="#" class="understanding-grade-close"><i class="fa fa-times" aria-hidden="true"></i></a>';
            $reportCardOutput .= "\n\t\t\t" . '<div class="understanding-grade-content"></div>';
        $reportCardOutput .= "\n\t\t\t" . '</div>';

        /* END DATA BREAKDOWN */

    $reportCardOutput .= "\n\t\t" . '</div>';

    $schoolGradeOutput .= $reportCardOutput;
    /* END HIGH SCHOOL CALCULATION */

?>