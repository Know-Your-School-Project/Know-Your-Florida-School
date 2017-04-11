<?php

    /*
    *
    *   Swift Page Builder - State Summart Shortcode
    *   ------------------------------------------------
    *   Swift Framework
    *   Copyright Swift Ideas 2015 - http://www.swiftideas.com
    *
    */

    class SwiftPageBuilderShortcode_spb_state_summary extends SwiftPageBuilderShortcode {

        protected function content( $atts, $content = null ) {

            $width = $title = $input_class = $el_class = $output = $el_position = '';

            extract( shortcode_atts( array(
                'title'             => '',
                'el_position'       => '',
                'width'             => '1/1',
                'el_class'          => ''
            ), $atts ) );


            $el_class = $this->getExtraClass( $el_class );
            $width    = spb_translateColumnWidthToSpan( $width );

            $output .= "\n\t" . '<div class="spb_state_summary spb_content_element ' . $width . $el_class . '">';
            $output .= "\n\t\t" . '<div class="spb-asset-content">';

            $output .= ( $title != '' ) ? "\n\t\t\t" . $this->spb_title( $title, 'spb-text-heading' ) : '';

            $output .= "\n\t\t" . '<div class="card"><h3>All Schools</h3><div id="state-summary-all-schools" class="highchart state-summary-chart"></div>';

            /* ALL SCHOOLS */
            $AllSchoolsA = get_field("all_schools_grade_a", 43);
            $AllSchoolsB = get_field("all_schools_grade_b", 43);
            $AllSchoolsC = get_field("all_schools_grade_c", 43);
            $AllSchoolsD = get_field("all_schools_grade_d", 43);
            $AllSchoolsF = get_field("all_schools_grade_f", 43);
            $AllTotalSchools = get_field("all_schools_total_count", 43);
            $output .= "\n\t\t" . '<script>

                                            (function($){

                                                $(document).ready(function () {

                                                    var windowWidth = $(window).width();

                                                    if ( windowWidth > 767 ) {

                                                        $("#state-summary-all-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-all-schools").width(),
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $AllTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
                                                                    }
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
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100  * ' . $AllTotalSchools . ' ) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $AllSchoolsA / $AllTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $AllSchoolsB / $AllTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $AllSchoolsC / $AllTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $AllSchoolsD / $AllTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $AllSchoolsF / $AllTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-all-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($AllTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-all-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-all-schools #state-summary-all-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-all-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($AllTotalSchools) . '</div>";
                                                            $("#state-summary-all-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    } else {

                                                        $("#state-summary-all-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-all-schools").width(),
                                                                height: ' . ( 400 + ( 55 * 6 ) ) . ',
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $AllTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
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
                                                            },
                                                            legend: {
                                                                enabled: true,
                                                                layout: "vertical",
                                                                useHTML: true,
                                                                itemMarginBottom: 30,
                                                                symbolHeight: 25,
                                                                symbolWidth: 25,
                                                                y: 40,
                                                                labelFormatter: function() {
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100  * ' . $AllTotalSchools . ' ) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $AllSchoolsA / $AllTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $AllSchoolsB / $AllTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $AllSchoolsC / $AllTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $AllSchoolsD / $AllTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $AllSchoolsF / $AllTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-all-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($AllTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-all-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-all-schools #state-summary-all-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-all-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($AllTotalSchools) . '</div>";
                                                            $("#state-summary-all-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    }

                                                });

                                            })(jQuery);


                                            </script></div>';

            $output .= "\n\t\t" . '<div class="card"><h3>Elementary Schools</h3><div id="state-summary-elementary-schools" class="highchart state-summary-chart"></div>';

          /* ELEMENTARY SCHOOLS */
          $ElemSchoolsA = get_field("elementary_schools_grade_a", 43);
          $ElemSchoolsB = get_field("elementary_schools_grade_b", 43);
          $ElemSchoolsC = get_field("elementary_schools_grade_c", 43);
          $ElemSchoolsD = get_field("elementary_schools_grade_d", 43);
          $ElemSchoolsF = get_field("elementary_schools_grade_f", 43);
          $ElemTotalSchools = get_field("elementary_schools_total_count", 43);
          $output .= "\n\t\t" . '<script>

                                            (function($){

                                                $(document).ready(function () {

                                                    var windowWidth = $(window).width();

                                                    if ( windowWidth > 767 ) {

                                                        $("#state-summary-elementary-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-elementary-schools").width(),
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $ElemTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
                                                                    }
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
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100 ) * ' . $ElemTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $ElemSchoolsA / $ElemTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $ElemSchoolsB / $ElemTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $ElemSchoolsC / $ElemTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $ElemSchoolsD / $ElemTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $ElemSchoolsF / $ElemTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-elementary-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($ElemTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-elementary-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-elementary-schools .highcharts-container #state-summary-elementary-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-elementary-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($ElemTotalSchools) . '</div>";
                                                            $("#state-summary-elementary-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    } else {

                                                        $("#state-summary-elementary-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-all-schools").width(),
                                                                height: ' . ( 400 + ( 55 * 6 ) ) . ',
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $ElemTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
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
                                                            },
                                                            legend: {
                                                                enabled: true,
                                                                layout: "vertical",
                                                                useHTML: true,
                                                                itemMarginBottom: 30,
                                                                symbolHeight: 25,
                                                                symbolWidth: 25,
                                                                y: 40,
                                                                labelFormatter: function() {
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100  * ' . $ElemTotalSchools . ' ) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $ElemSchoolsA / $ElemTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $ElemSchoolsB / $ElemTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $ElemSchoolsC / $ElemTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $ElemSchoolsD / $ElemTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $ElemSchoolsF / $ElemTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-elementary-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($ElemTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-elementary-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-elementary-schools .highcharts-container #state-summary-elementary-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-elementary-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($ElemTotalSchools) . '</div>";
                                                            $("#state-summary-elementary-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    }

                                                });

                                            })(jQuery);


                                            </script></div>';

            $output .= "\n\t\t" . '<div class="card"><h3>Middle Schools</h3><div id="state-summary-middle-schools" class="highchart state-summary-chart"></div>';

            /* MIDDLE SCHOOLS */
            $MidSchoolsA = get_field("middle_schools_grade_a", 43);
            $MidSchoolsB = get_field("middle_schools_grade_b", 43);
            $MidSchoolsC = get_field("middle_schools_grade_c", 43);
            $MidSchoolsD = get_field("middle_schools_grade_d", 43);
            $MidSchoolsF = get_field("middle_schools_grade_f", 43);
            $MidTotalSchools = get_field("middle_schools_total_count", 43);
            $output .= "\n\t\t" . '<script>

                                            (function($){

                                                $(document).ready(function () {

                                                    var windowWidth = $(window).width();

                                                    if ( windowWidth > 767 ) {

                                                        $("#state-summary-middle-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-middle-schools").width(),
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $MidTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
                                                                    }
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
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100 ) * ' . $MidTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $MidSchoolsA / $MidTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $MidSchoolsB / $MidTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $MidSchoolsC / $MidTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $MidSchoolsD / $MidTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $MidSchoolsF / $MidTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-middle-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($MidTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-middle-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-middle-schools .highcharts-container #state-summary-middle-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-middle-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($MidTotalSchools) . '</div>";
                                                            $("#state-summary-middle-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    } else {

                                                        $("#state-summary-middle-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-all-schools").width(),
                                                                height: ' . ( 400 + ( 55 * 6 ) ) . ',
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $MidTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
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
                                                            },
                                                            legend: {
                                                                enabled: true,
                                                                layout: "vertical",
                                                                useHTML: true,
                                                                itemMarginBottom: 30,
                                                                symbolHeight: 25,
                                                                symbolWidth: 25,
                                                                y: 40,
                                                                labelFormatter: function() {
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100  * ' . $MidTotalSchools . ' ) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $MidSchoolsA / $MidTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $MidSchoolsB / $MidTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $MidSchoolsC / $MidTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $MidSchoolsD / $MidTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $MidSchoolsF / $MidTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-middle-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($MidTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-middle-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-middle-schools .highcharts-container #state-summary-middle-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-middle-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($MidTotalSchools) . '</div>";
                                                            $("#state-summary-middle-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    }

                                                });

                                            })(jQuery);


                                            </script></div>';

            $output .= "\n\t\t" . '<div class="card"><h3>High Schools</h3><div id="state-summary-high-schools" class="highchart state-summary-chart"></div>';

            /* HIGH SCHOOLS */
            $HighSchoolsA = get_field("high_schools_grade_a", 43);
            $HighSchoolsB = get_field("high_schools_grade_b", 43);
            $HighSchoolsC = get_field("high_schools_grade_c", 43);
            $HighSchoolsD = get_field("high_schools_grade_d", 43);
            $HighSchoolsF = get_field("high_schools_grade_f", 43);
            $HighTotalSchools = get_field("high_schools_total_count", 43);
            $output .= "\n\t\t" . '<script>

                                            (function($){

                                                $(document).ready(function () {

                                                    var windowWidth = $(window).width();

                                                    if ( windowWidth > 767 ) {

                                                        $("#state-summary-high-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-high-schools").width(),
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $HighTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
                                                                    }
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
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100 ) * ' . $HighTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $HighSchoolsA / $HighTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $HighSchoolsB / $HighTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $HighSchoolsC / $HighTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $HighSchoolsD / $HighTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $HighSchoolsF / $HighTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-high-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($HighTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-high-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-high-schools .highcharts-container #state-summary-high-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-high-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($HighTotalSchools) . '</div>";
                                                            $("#state-summary-high-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    } else {

                                                        $("#state-summary-high-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-all-schools").width(),
                                                                height: ' . ( 400 + ( 55 * 6 ) ) . ',
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $HighTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
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
                                                            },
                                                            legend: {
                                                                enabled: true,
                                                                layout: "vertical",
                                                                useHTML: true,
                                                                itemMarginBottom: 30,
                                                                symbolHeight: 25,
                                                                symbolWidth: 25,
                                                                y: 40,
                                                                labelFormatter: function() {
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100  * ' . $HighTotalSchools . ' ) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $HighSchoolsA / $HighTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $HighSchoolsB / $HighTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $HighSchoolsC / $HighTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $HighSchoolsD / $HighTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $HighSchoolsF / $HighTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-high-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($HighTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-high-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-high-schools .highcharts-container #state-summary-high-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-high-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($HighTotalSchools) . '</div>";
                                                            $("#state-summary-high-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    }

                                                });

                                            })(jQuery);


                                            </script></div>';

            $output .= "\n\t\t" . '<div class="card"><h3>Combination Schools</h3><div id="state-summary-combination-schools" class="highchart state-summary-chart"></div>';

            /* COMBINATION SCHOOLS */
            $CombSchoolsA = get_field("combination_schools_grade_a", 43);
            $CombSchoolsB = get_field("combination_schools_grade_b", 43);
            $CombSchoolsC = get_field("combination_schools_grade_c", 43);
            $CombSchoolsD = get_field("combination_schools_grade_d", 43);
            $CombSchoolsF = get_field("combination_schools_grade_f", 43);
            $CombTotalSchools = get_field("combination_schools_total_count", 43);
            $output .= "\n\t\t" . '<script>

                                            (function($){

                                                $(document).ready(function () {

                                                    var windowWidth = $(window).width();

                                                    if ( windowWidth > 767 ) {

                                                        $("#state-summary-combination-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-combination-schools").width(),
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $CombTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
                                                                    }
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
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100 ) * ' . $CombTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $CombSchoolsA / $CombTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $CombSchoolsB / $CombTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $CombSchoolsC / $CombTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $CombSchoolsD / $CombTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $CombSchoolsF / $CombTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-combination-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($CombTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-combination-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-combination-schools .highcharts-container #state-summary-combination-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-combination-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($CombTotalSchools) . '</div>";
                                                            $("#state-summary-combination-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    } else {

                                                        $("#state-summary-combination-schools").highcharts({
                                                            chart: {
                                                                type: "pie",
                                                                width: $("#state-summary-all-schools").width(),
                                                                height: ' . ( 400 + ( 55 * 6 ) ) . ',
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
                                                                useHTML: true,
                                                                borderWidth: 0,
                                                                backgroundColor: "rgba(255,255,255,1)",
                                                                formatter: function() {
                                                                    return \'<div class="tooltip-label" style="text-align:center;">\' + this.point.name + \'</div><div class="tooltip-label-desc" style="text-align:center;">\' + Math.round( ( this.y / 100 ) * ' . $CombTotalSchools . ' ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools<br />\' + Math.round( this.y ) + \'%</div>\';
                                                                }
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
                                                                    states: {
                                                                        hover: {
                                                                            enabled: false
                                                                        }
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
                                                            },
                                                            legend: {
                                                                enabled: true,
                                                                layout: "vertical",
                                                                useHTML: true,
                                                                itemMarginBottom: 30,
                                                                symbolHeight: 25,
                                                                symbolWidth: 25,
                                                                y: 40,
                                                                labelFormatter: function() {
                                                                    return \'<div class="legend-label">\' + this.name + \'</div><div class="legend-label-desc">\' + Math.round( ( this.y / 100  * ' . $CombTotalSchools . ' ) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + \' Schools (\' + Math.round( this.y ) + \'%)</div>\';
                                                                }
                                                            },
                                                            credits: {
                                                                enabled: false
                                                            },
                                                            exporting: {
                                                                enabled: false
                                                            },
                                                            series: [{ "data" : [{ "name" : "A", "color": "#f5ae27", "y" : ' . ( ( $CombSchoolsA / $CombTotalSchools ) * 100 ) . ' }, { "name" : "B", "color": "#937eb5", "y" : ' . ( ( $CombSchoolsB / $CombTotalSchools ) * 100 ) . ' }, { "name" : "C", "color": "#6183b3", "y" : ' . ( ( $CombSchoolsC / $CombTotalSchools ) * 100 ) . ' }, { "name" : "D", "color": "#1ab689", "y" : ' . ( ( $CombSchoolsD / $CombTotalSchools ) * 100 ) . ' }, { "name" : "F", "color": "#aeadae", "y" : ' . ( ( $CombSchoolsF / $CombTotalSchools ) * 100 ) . ' } ] }]
                                                        },
                                                        function(chart) { 

                                                            var textX = chart.plotLeft + (chart.plotWidth  * 0.5);
                                                            var textY = chart.plotTop  + (chart.plotHeight * 1);                                       
                                                            
                                                            var title = "<span id=\"state-summary-combination-pie-title\" style=\"position:absolute;height:50px;width:300px;text-align:center;\">' . number_format($CombTotalSchools) . ' Schools</span>";

                                                            $("#state-summary-combination-schools .highcharts-container").append(title);
                                                            var span = $("#state-summary-combination-schools .highcharts-container #state-summary-combination-pie-title");
                                                            span.css("left", textX + ( span.width() * -0.5 ));
                                                            span.css("top", textY);
                                                            
                                                            var title = "<div id=\"state-summary-combination-legend-title\" style=\"position:absolute;top:60px;width:200px;text-align:left;\">Total Schools: ' . number_format($CombTotalSchools) . '</div>";
                                                            $("#state-summary-combination-schools .highcharts-legend-item:last-child").append(title);

                                                        });

                                                    }

                                                });

                                            })(jQuery);


                                            </script></div>';

            $output .= "\n\t\t" . '</div>';
            $output .= "\n\t" . '</div> ' . $this->endBlockComment( $width );

            $output = $this->startRow( $el_position ) . $output . $this->endRow( $el_position );

            return $output;

        }
    }

    SPBMap::map( 'spb_state_summary', array(
        "name"   => __( "State Summary", 'swift-framework-plugin' ),
        "base"   => "spb_state_summary",
        "class"  => "spb_state_summary",
        "icon"   => "spb-icon-state-summary",
        "params" => array(
            array(
                "type"        => "textfield",
                "holder"      => "div",
                "heading"     => __( "Widget title", 'swift-framework-plugin' ),
                "param_name"  => "title",
                "value"       => "",
                "description" => __( "Heading text should be no more than 5 words. Leave it empty if not needed.", 'swift-framework-plugin' )
            ),
            array(
                "type"        => "textfield",
                "heading"     => __( "Extra class", 'swift-framework-plugin' ),
                "param_name"  => "el_class",
                "value"       => "",
                "description" => __( "If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'swift-framework-plugin' )
            )
        )
    ) );