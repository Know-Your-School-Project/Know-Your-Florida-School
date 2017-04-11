<?php

    // START ELA STUDENT PERFORMANCE

    // DATASET

    if ( isset($subject) && !empty($subject) && $subject != "" ) {

        $schoolPerformanceOutput .= "<h3 class='reportcard-title'>Subgroup</h3>";

        $schoolPerformanceOutput .= "<div class='data-toggle-container'><select class='data-toggle-subgroup'>";
        foreach( $datasets as $datasetKey => $datasetName ) {
            $schoolPerformanceOutput .= "<option value='" . $subject . '-subgroup-' . $datasetKey . "'>" . $datasetName . "</option>";
        }  
        $schoolPerformanceOutput .= "</select><div class='icon-select'></div></div>";

        $first = true;
        foreach( $datasets as $datasetKey => $datasetName ) {
            if ( $first == true ) {
                $schoolPerformanceOutput .= '<div id="exhibit-performance-' . $subject . '-subgroup-' . $datasetKey . '" class="exhibit-group">';
            } else {
                $schoolPerformanceOutput .= '<div id="exhibit-performance-' . $subject . '-subgroup-' . $datasetKey . '" class="exhibit-group" style="display:none;"">';
            }
                $schoolPerformanceOutput .= '<div id="school-performance-' . $subject . '-subgroup-' . $datasetKey . '" class="highchart"></div>';
                $schoolPerformanceOutput .= '<script>

                                            (function($){

                                                $(document).ready(function () {

                                                    $("#school-performance-' . $subject . '-subgroup-' . $datasetKey . '").highcharts({
                                                        chart: {
                                                            width: $("#exhibit-performance-' . $subject . '-subgroup-' . $datasetKey . '").width(),
                                                            height: 400
                                                        },
                                                        title: {
                                                            text: ""
                                                        },
                                                        xAxis: {
                                                            categories: [';
          
                                                                $year = $minYear;
                                                                while( $year <= $maxYear ) {
                                                                    if ( $year != $minYear ) {
                                                                        $schoolPerformanceOutput .= ', "' . ( $year - 1 ) . '-' . substr($year, -2) . '"';
                                                                    } else {
                                                                        $schoolPerformanceOutput .= '"' . ( $year - 1 ) . '-' . substr($year, -2) . '"';
                                                                    }
                                                                    $year++;
                                                                }

                                $schoolPerformanceOutput .= '],
                                                            allowDecimals: false,
                                                            gridLineWidth: 0,
                                                            labels: {
                                                                formatter: function () {
                                                                    return this.value;
                                                                }
                                                            },
                                                            crosshair: true
                                                        },
                                                        yAxis: {
                                                            title: {
                                                                text: ""
                                                            },
                                                            labels: {
                                                                formatter: function () {
                                                                    return this.value + "%";
                                                                }
                                                            },
                                                            min: 0,
                                                            max: 100,
                                                            startOnTick: true,
                                                            tickmarkPlacement: "on",
                                                            gridLineColor: "#e6e6e5",
                                                            lineWidth: 1,
                                                            gridLineWidth: 1,
                                                            plotLines: [{
                                                                color: "#e6e6e5",
                                                                width: 1,
                                                                value: 0
                                                            }],
                                                            opposite: true
                                                        },
                                                        tooltip: {
                                                            enabled: true,
                                                            shared: true,
                                                            formatter: function () {
                                                                var s = "";
                                                                var points = this.points;

                                                                $.each(points, function (index, value) {
                                                                    s += "<span class=\'chart-tooltip\' style=\'color:" + this.color + ";\'>" + this.series.name + ": " +
                                                                        this.y + "%</span>";
                                                                    if ( index < points.length - 1 ) {
                                                                        s += "<br />";
                                                                    }
                                                                });

                                                                return s;
                                                            },
                                                            backgroundColor: "rgba(255,255,255,1)",
                                                            borderColor: "rgba(255,255,255,1)",
                                                            borderWidth: 0,
                                                            useHTML: true
                                                        },
                                                        credits: {
                                                            enabled: false
                                                        },
                                                        exporting: {
                                                            enabled: false
                                                        },
                                                        series: [';

                                $colorIndex = 0;

                                $chartSubgroups = array();

                                foreach( $subgroups as $subgroupKey => $subgroupName) {
                                    $hasData = false;
                                    foreach( $SPARData[$datasetKey] as $year => $SPARDataYear ) {
                                        if ( isset($SPARDataYear["SPAR_" . strtoupper($subject) . "_PASS_" . $subgroupKey]) && !empty($SPARDataYear["SPAR_" . strtoupper($subject) . "_PASS_" . $subgroupKey]) && $SPARDataYear["SPAR_" . strtoupper($subject) . "_PASS_" . $subgroupKey] != "" ) {
                                            $hasData = true;
                                        }
                                    }
                                    if ( $hasData == true ) {
                                        $chartSubgroups[$subgroupKey] = $subgroupName;
                                    }
                                }
                                
								foreach( $chartSubgroups as $subgroupKey => $subgroupName) {

                                    $schoolPerformanceOutput .= '{
                                                                name: "' . $subgroupName . ' Students",
                                                                type: "line",
                                                                color: "' . $colors[$colorIndex] . '",
                                                                data: [';
          
                                                                    foreach( $SPARData[$datasetKey] as $year => $SPARDataYear ) {
                                                                        if ( isset($SPARDataYear["SPAR_" . strtoupper($subject) . "_PASS_" . $subgroupKey]) && !empty($SPARDataYear["SPAR_" . strtoupper($subject) . "_PASS_" . $subgroupKey]) && $SPARDataYear["SPAR_" . strtoupper($subject) . "_PASS_" . $subgroupKey] != "" ) {
                                                                            if ( $year != $minYear ) {
                                                                                $schoolPerformanceOutput .= ', ' . $SPARDataYear["SPAR_" . strtoupper($subject) . "_PASS_" . $subgroupKey] . '';
                                                                            } else {
                                                                                $schoolPerformanceOutput .= '' . $SPARDataYear["SPAR_" . strtoupper($subject) . "_PASS_" . $subgroupKey] . '';
                                                                            }
                                                                        } else {
                                                                            if ( $year != $minYear ) {
                                                                                $schoolPerformanceOutput .= ', 0';
                                                                            } else {
                                                                                $schoolPerformanceOutput .= '0';
                                                                            }
                                                                        }
                                                                    }
                                    
                                    $schoolPerformanceOutput .= '], }, ';

                                    if ( $colorIndex <= count($colors) ) {
                                        $colorIndex++;
                                    } else {
                                        $colorIndex = 0;
                                    }

                                 }
                                    
                                    $schoolPerformanceOutput .= ']
                                                    });

                                                });

                                            })(jQuery);


                                            </script>';
            $schoolPerformanceOutput .= '</div>';
            $first = false;
        }

    }

    // END ELA STUDENT PERFORMANCE

?>