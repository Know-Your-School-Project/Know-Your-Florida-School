<?php
    
    require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

    $enrollmentData = ""; // This is a string with Enrollment Data for Highcharts
    $enrollmentDataEmpty = array(); // These are the races that doe not contain any data

    $schoolCharacterOutput .= '<div class="row">';
        $schoolCharacterOutput .= '<div class="col-md-12">';
            $schoolCharacterOutput .= '<h3>English Learners</h3><p>' .   inject_data(get_field("enrollment_english_learners_description"), $schoolData, $schoolTypes) . '</p>';
        $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '<div class="row">';
        $schoolCharacterOutput .= '<div class="col-md-12">';
        
            // START ENGLISH LANGUAGE LEARNERS

            $colorCount = 0;
            $enrollmentData = "";
            $totalPercentage = 0;
            $enrollmentParams = [ 
                                    "EnrollmentELL"             => "English Learner"
                                ];

            $schoolCharacterOutput .= '<div id="exhibit-enrollment-ell" class="exhibit-group">';
                $schoolCharacterOutput .= '<div id="school-enrollment-ell" class="highchart pie-chart full-width-chart"></div>';
                $schoolCharacterOutput .= '<script>

                                            (function($){

                                                $(document).ready(function () {

                                                    var windowWidth = $(window).width();

                                                    if ( windowWidth > 767 ) {

                                                        $("#school-enrollment-ell").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#exhibit-enrollment-ell").width(),
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

                                                                $enrollmentParams = data_arrange_keys($schoolData[count($schoolData)-1], $enrollmentParams);
                                                                $colorCount = 0;
                                                                $enrollmentData = "";

                                                                if ( count($enrollmentParams) > 0 && $schoolData > 0 ) {

                                                                    $enrollmentData .= '{ "data" : [';
                                                                    foreach ($enrollmentParams as $enrollmentParamKey => $enrollmentParamName) {
                                                                        // Find if race has data
                                                                        foreach ($schoolData as &$schoolDataYear) {
                                                                            if ( preg_replace('/\s+/', '', $schoolDataYear[$enrollmentParamKey]) == "" || round(($schoolDataYear[$enrollmentParamKey]/100)*$schoolDataYear["TotalEnrollmentCount"]) == 0 ) {
                                                                                $enrollmentDataEmpty[$schoolDataYear["YEAR"]][] = $enrollmentParamName;
                                                                            }
                                                                        }
                                                                        // If the data isn't empty, display it
                                                                        if ( ( isset($enrollmentDataEmpty[$schoolDataYear["YEAR"]]) && !in_array( $enrollmentParamName, $enrollmentDataEmpty[$schoolDataYear["YEAR"]] ) ) || !isset($enrollmentDataEmpty[$schoolDataYear["YEAR"]]) ) {
                                                                            $enrollmentData .= '{ "name" : "' . $enrollmentParamName . '", "color": "' . $colors[$colorCount] . '", "y" : ' . $schoolDataYear[$enrollmentParamKey] . ' }, ';
                                                                            $totalPercentage = $schoolData[count($schoolData)-1][$enrollmentParamKey] + $totalPercentage;
                                                                        }
                                                                        $colorCount++;
                                                                    }
                                                                    if ( $totalPercentage != 100 ) {
                                                                        $enrollmentData .= '{ "name" : "Non-English Learner", "color": "' . $colors[$colorCount] . '", "y" : ' . ( 100 - $totalPercentage ) . ' }, ';
                                                                    }
                                                                    $enrollmentData = substr($enrollmentData, 0, -2) . " ";
                                                                    $enrollmentData .= '] }';

                                                                }

                                                                $schoolCharacterOutput .= $enrollmentData;

                                                            $schoolCharacterOutput .= ']
                                                        });

                                                    } else {

                                                        $("#school-enrollment-ell").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#exhibit-enrollment-ell").width(),
                                                                height: ' . ( 400 + ( 55 * ( count($enrollmentParams) +1 ) ) ) . ',
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

                                                                $enrollmentParams = data_arrange_keys($schoolData[count($schoolData)-1], $enrollmentParams);
                                                                $colorCount = 0;
                                                                $enrollmentData = "";

                                                                if ( count($enrollmentParams) > 0 && $schoolData > 0 ) {

                                                                    $enrollmentData .= '{ "data" : [';
                                                                    foreach ($enrollmentParams as $enrollmentParamKey => $enrollmentParamName) {
                                                                        // Find if race has data
                                                                        foreach ($schoolData as &$schoolDataYear) {
                                                                            if ( preg_replace('/\s+/', '', $schoolDataYear[$enrollmentParamKey]) == "" || round(($schoolDataYear[$enrollmentParamKey]/100)*$schoolDataYear["TotalEnrollmentCount"]) == 0 ) {
                                                                                $enrollmentDataEmpty[$schoolDataYear["YEAR"]][] = $enrollmentParamName;
                                                                            }
                                                                        }
                                                                        // If the data isn't empty, display it
                                                                        if ( ( isset($enrollmentDataEmpty[$schoolDataYear["YEAR"]]) && !in_array( $enrollmentParamName, $enrollmentDataEmpty[$schoolDataYear["YEAR"]] ) ) || !isset($enrollmentDataEmpty[$schoolDataYear["YEAR"]]) ) {
                                                                            $enrollmentData .= '{ "name" : "' . $enrollmentParamName . '", "color": "' . $colors[$colorCount] . '", "y" : ' . $schoolDataYear[$enrollmentParamKey] . ' }, ';
                                                                            $totalPercentage = $schoolData[count($schoolData)-1][$enrollmentParamKey] + $totalPercentage;
                                                                        }
                                                                        $colorCount++;
                                                                    }
                                                                    if ( $totalPercentage != 100 ) {
                                                                        $enrollmentData .= '{ "name" : "Non-English Learner", "color": "' . $colors[$colorCount] . '", "y" : ' . ( 100 - $totalPercentage ) . ' }, ';
                                                                    }
                                                                    $enrollmentData = substr($enrollmentData, 0, -2) . " ";
                                                                    $enrollmentData .= '] }';

                                                                }

                                                                $schoolCharacterOutput .= $enrollmentData;

                                                            $schoolCharacterOutput .= ']
                                                        });

                                                    }

                                                });

                                            })(jQuery);


                                            </script>';

            // END ENGLISH LANGUAGE LEARNERS

            $schoolCharacterOutput .= '</div>';

        $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '</div>';

?>