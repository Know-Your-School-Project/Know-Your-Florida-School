<?php
    
    require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

    $enrollmentData = ""; // This is a string with Enrollment Data for Highcharts
    $enrollmentDataEmpty = array(); // These are the disabilitys that doe not contain any data

    $schoolCharacterOutput .= '<div class="row">';
        $schoolCharacterOutput .= '<div class="col-md-12">';
            $schoolCharacterOutput .= '<h3>Students with Disabilities</h3><p>' .   inject_data(get_field("enrollment_disabilities_description"), $schoolData, $schoolTypes) . '</p>';
        $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '<div class="row">';
        $schoolCharacterOutput .= '<div class="col-md-12">';
        
            // START DISABILITIES

            $enrollmentParams = [ 
                                    "SPAR_ENROLL_DIS"           => "Disabled", 
                                    "SPAR_ENROLL_NONDIS"        => "Not Disabled"
                                ];

            $schoolCharacterOutput .= '<div id="exhibit-enrollment-disability" class="exhibit-group">';
                $schoolCharacterOutput .= '<div id="school-enrollment-disability" class="highchart pie-chart full-width-chart"></div>';
                $schoolCharacterOutput .= '<script>

                                            (function($){

                                                $(document).ready(function () {

                                                    var windowWidth = $(window).width();

                                                    if ( windowWidth > 767 ) {

                                                        $("#school-enrollment-disability").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#exhibit-enrollment-disability").width(),
                                                            },
                                                            title: {
                                                                text: ""
                                                            },
                                                            xAxis: {
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
                                                                    text: "Number of Students Enrolled"
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
                                                                    return "<span class=\'chart-tooltip\' style=\'color:" + this.color + ";\'>" + this.key + " = " + Math.round(this.percentage) + "% of Students</span>";
                                                                },
                                                                backgroundColor: "#ffffff",
                                                                borderColor: "#ffffff",
                                                                borderWidth: 0,
                                                                useHTML: true
                                                            },
                                                            plotOptions: {
                                                                pie: {
                                                                    dataLabels: {
                                                                        enabled: false,                        
                                                                        formatter: function() {
                                                                            return this.percentage.toFixed(2) + "%";
                                                                        }
                                                                    },
                                                                    showInLegend: true,
                                                                    shadow: false,
                                                                    borderWidth: 0,
                                                                    point: {
                                                                        events: {
                                                                            legendItemClick: function () {
                                                                                return false;
                                                                            }
                                                                        }
                                                                    },
                                                                    allowPointSelect: false
                                                                }
                                                            },
                                                            legend: {
                                                                enabled: true,
                                                                layout: "vertical",
                                                                align: "left",
                                                                width: 200,
                                                                verticalAlign: "top",
                                                                useHTML: true,
                                                                itemMarginBottom: 30,
                                                                symbolHeight: 25,
                                                                symbolWidth: 25,
                                                                x: 0,
                                                                y: 30,
                                                                useHTML: true,
                                                                labelFormatter: function() {
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">Students (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [';

                                                                $enrollmentParams = data_arrange_keys($SPARData["school"][$endYear], $enrollmentParams);
                                                                $colorCount = 0;
                                                                $enrollmentData = "";
                                                                
                                                                if ( count($enrollmentParams) > 0 && $SPARData > 0 ) {

                                                                    $enrollmentData .= '{ "data" : [';
                                                                    foreach ($enrollmentParams as $enrollmentParamKey => $enrollmentParamName) {
                                                                        // Find if gender has data
                                                                        if ( isset($SPARData['school'][$endYear][ $enrollmentParamKey ]) && 
                                                                             !empty($SPARData['school'][$endYear][ $enrollmentParamKey ]) && 
                                                                             $SPARData['school'][$endYear][ $enrollmentParamKey ] != "" ) {
                                                                            $enrollmentData .= '{ "name" : "' . $enrollmentParamName . '", "color": "' . $colors[$colorCount] . '", "y" : ' . ( ( $SPARData['school'][$endYear][ $enrollmentParamKey ] / $schoolData[count($schoolData)-1]["TotalEnrollmentCount"] ) * 100 ) . ' }, ';
                                                                            $hasData = true;
                                                                            $colorCount++;
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

                                                    } else {

                                                        $("#school-enrollment-disability").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#exhibit-enrollment-disability").width(),
                                                                height: ' . ( 400 + ( 55 * count($enrollmentParams) ) ) . ',
                                                            },
                                                            title: {
                                                                text: ""
                                                            },
                                                            xAxis: {
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
                                                                    text: "Number of Students Enrolled"
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
                                                                    return "<span class=\'chart-tooltip\' style=\'color:" + this.color + ";\'>" + this.key + " = " + Math.round(this.percentage) + "% of Students</span>";
                                                                },
                                                                backgroundColor: "#ffffff",
                                                                borderColor: "#ffffff",
                                                                borderWidth: 0,
                                                                useHTML: true
                                                            },
                                                            plotOptions: {
                                                                pie: {
                                                                    dataLabels: {
                                                                        enabled: false,                        
                                                                        formatter: function() {
                                                                            return this.percentage.toFixed(2) + "%";
                                                                        }
                                                                    },
                                                                    showInLegend: true,
                                                                    shadow: false,
                                                                    borderWidth: 0,
                                                                    point: {
                                                                        events: {
                                                                            legendItemClick: function () {
                                                                                return false;
                                                                            }
                                                                        }
                                                                    },
                                                                    allowPointSelect: false
                                                                }
                                                            },
                                                            legend: {
                                                                enabled: true,
                                                                layout: "vertical",
                                                                useHTML: true,
                                                                itemMarginTop: 30,
                                                                symbolHeight: 25,
                                                                symbolWidth: 25,
                                                                useHTML: true,
                                                                labelFormatter: function() {
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">Students (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [';

                                                                $enrollmentParams = data_arrange_keys($SPARData["school"][$endYear], $enrollmentParams);
                                                                $colorCount = 0;
                                                                $enrollmentData = "";

                                                                if ( count($enrollmentParams) > 0 && $SPARData > 0 ) {

                                                                    $enrollmentData .= '{ "data" : [';
                                                                    foreach ($enrollmentParams as $enrollmentParamKey => $enrollmentParamName) {
                                                                        // Find if gender has data
                                                                        if ( isset($SPARData['school'][$endYear][ $enrollmentParamKey ]) && 
                                                                             !empty($SPARData['school'][$endYear][ $enrollmentParamKey ]) && 
                                                                             $SPARData['school'][$endYear][ $enrollmentParamKey ] != "" ) {
                                                                            $enrollmentData .= '{ "name" : "' . $enrollmentParamName . '", "color": "' . $colors[$colorCount] . '", "y" : ' . ( ( $SPARData['school'][$endYear][ $enrollmentParamKey ] / $schoolData[count($schoolData)-1]["TotalEnrollmentCount"] ) * 100 ) . ' }, ';
                                                                            $hasData = true;
                                                                            $colorCount++;
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

                                                    }

                                                });

                                            })(jQuery);


                                            </script>';

            $schoolCharacterOutput .= '</div>';

            // END DISABILITIES

        $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '</div>';

?>