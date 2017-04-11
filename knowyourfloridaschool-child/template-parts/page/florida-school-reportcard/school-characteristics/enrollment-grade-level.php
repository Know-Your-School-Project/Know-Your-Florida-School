<?php

    require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

    $gradeLevelYear = get_field("about_year");


    $enrollmentData = ""; // This is a string with Enrollment Data for Highcharts
    $enrollmentDataEmpty = array(); // These are the races that doe not contain any data

    $gradeLevelParams = [
                          "PK"  => "Pre K",
                          "K"   => "K",
                          "1"   => "1st",
                          "2"   => "2nd",
                          "3"   => "3rd",
                          "4"   => "4th",
                          "5"   => "5th",
                          "6"   => "6th",
                          "7"   => "7th",
                          "8"   => "8th",
                          "9"   => "9th",
                          "10"  => "10th",
                          "11"  => "11th",
                          "12"  => "12th"
                        ];

    $schoolCharacterOutput .= '<div class="row">';
        $schoolCharacterOutput .= '<div class="col-md-12">';
            $schoolCharacterOutput .= '<h3>Grade Level</h3><p>' .   inject_data(get_field("enrollment_grade_level_description"), $schoolData, $schoolTypes) . '</p>';
        $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '<div class="row">';
        $schoolCharacterOutput .= '<div class="col-md-12">';

            // START GRADE LEVEL

            $schoolCharacterOutput .= '<div id="exhibit-enrollment-grade-level" class="exhibit-group">';
                $schoolCharacterOutput .= '<div id="school-enrollment-grade-level" class="highchart full-width-chart"></div>';
            $schoolCharacterOutput .= '</div>';
            $schoolCharacterOutput .= '<script>
                  (function($){
                  
                    $(document).ready(function () {
                    
                    $("#school-enrollment-grade-level").highcharts({
                    chart: {
                        type: "column",
                        width: $("#exhibit-grade-level").width()
                    },
                    title: {
                        text: "Enrollment Data",
                    },
                    subtitle: {
                        text: "Total Students: ' . $SPARData['school'][$endYear][ "SPAR_ENROLL_ALL" ] . '",
                    },
                    xAxis: {
                        categories: [ ';

                            $hasData = false;
                            if ( count($gradeLevelParams) > 0 && isset($SPARData['school'][$endYear]) && !empty($SPARData['school'][$endYear]) ) {

                              foreach ($gradeLevelParams as $enrollmentParamKey => $enrollmentParamName) {
                                // Find if gender has data
                                if ( isset($SPARData['school'][$endYear][ "SPAR_ENROLL_" . $enrollmentParamKey ]) && 
                                     !empty($SPARData['school'][$endYear][ "SPAR_ENROLL_" . $enrollmentParamKey ]) && 
                                     $SPARData['school'][$endYear][ "SPAR_ENROLL_" . $enrollmentParamKey ] != "" ) {
                                    $schoolCharacterOutput .= '"'.$enrollmentParamName . '", ';
                                    $hasData = true;
                                }
                              }
                              if ( $hasData ) {
                                  $schoolCharacterOutput = substr($schoolCharacterOutput, 0, -2) . " ";
                              }

                            }

                        $schoolCharacterOutput .= '],
                        title: {
                            text: "Grades"
                        },
                        allowDecimals: false,
                        gridLineWidth: 0,
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: "Student Enrollment Count"
                        },
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        },
                        startOnTick: true,
                        tickmarkPlacement: "on",
                        gridLineColor: "#e6e6e5",
                        lineWidth: 1,
                        gridLineWidth: 1,
                        plotLines: [{
                            color: "#e6e6e5",
                            width: 1,
                            value: 0
                        }]
                    },
                    tooltip: {
                        enabled: true,
                        formatter: function() {
                          return "<span class=\'chart-tooltip\' style=\'color:" + this.color + ";\'>" + this.x + " Grade = " + this.y + " Students</span>";
                        },
                        backgroundColor: "rgba(255,255,255,1)",
                        borderColor: "rgba(255,255,255,1)",
                        borderWidth: 0,
                        useHTML: true
                    },
                    legend: {
                        enabled: false,
                    },
                    credits: {
                        enabled: false
                    },
                    exporting: {
                        enabled: false
                    },
                    series: [';
                        
                        $colorCount = 0;
                        $enrollmentData = "";

                        $hasData = false;
                        if ( count($gradeLevelParams) > 0 && isset($SPARData['school'][$endYear]) && !empty($SPARData['school'][$endYear]) ) {

                          $enrollmentData .= '{ "color": "#917DB4", "data": [ ';
                          foreach ($gradeLevelParams as $enrollmentParamKey => $enrollmentParamName) {
                            // Find if gender has data
                            if ( isset($SPARData['school'][$endYear][ "SPAR_ENROLL_" . $enrollmentParamKey ]) && 
                                 !empty($SPARData['school'][$endYear][ "SPAR_ENROLL_" . $enrollmentParamKey ]) && 
                                 $SPARData['school'][$endYear][ "SPAR_ENROLL_" . $enrollmentParamKey ] != "" ) {
                                $enrollmentData .= '' . $SPARData['school'][$endYear][ "SPAR_ENROLL_" . $enrollmentParamKey ] . ', ';
                                $hasData = true;
                            }
                          }
                          if ( $hasData ) {
                              $enrollmentData = substr($enrollmentData, 0, -2) . " ";
                          }
                          $enrollmentData .= '] }';

                        }

                        $schoolCharacterOutput .= $enrollmentData;

                    $schoolCharacterOutput .= ']
                    });
                  });
                })(jQuery);
            </script>';

        // END GRADE LEVEL
        $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '</div>';

?>