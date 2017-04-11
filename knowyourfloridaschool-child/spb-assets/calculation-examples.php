<?php

    /*
    *
    *	Swift Page Builder - Calculation Example Shortcode
    *	------------------------------------------------
    *	Swift Framework
    * 	Copyright Swift Ideas 2015 - http://www.swiftideas.com
    *
    */

    class SwiftPageBuilderShortcode_spb_calc_examples extends SwiftPageBuilderShortcode {

        protected function content( $atts, $content = null ) {

            $width = $input_class = $el_class = $output = $el_position = '';

            extract( shortcode_atts( array(
                'el_position'       => '',
                'width'             => '1/1',
                'el_class'          => ''
            ), $atts ) );

            require( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );
            require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

            $el_class = $this->getExtraClass( $el_class );
            $width    = spb_translateColumnWidthToSpan( $width );

            $output .= "\n\t" . '<div class="spb_calc_examples spb_content_element ' . $width . $el_class . '">';
            $output .= "\n\t\t" . '<div class="spb-asset-content">';

            $output .= "\n\t\t" . '<div class="simple-calulation"><span class="color-blue">Points Earned</span> ÷ <span class="color-blue">Points Possible</span> = <span class="color-blue">Percentage</span> = <span class="color-blue">Letter Grade</span></div>';
            $output .= "\n\t\t" . '<div class="toogle-school-type"><div class="dropdown-container"><select name="calc-example-schools"><option value="elementary" SELECTED>Sunshine Elementary School</option><option value="middle">Sunshine Middle School</option><option value="high">Sunshine High School</option></select><div class="icon-select"></div></div></div>';

            /* START ELEMENTARY SCHOOL CALCULATION */

            $schoolId = 1441;
            $districtId = 16;
            $endYear = get_field("year", 42);
            $startYear = 1999;

            // START API CALL

            // SCHOOL DATA

            $requestURL = "https://api.jaxpef.org/school/singleschool/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY . "&yrstart=" . $startYear . "&yrend=" . $endYear;
            $schoolData = json_decode(file_get_contents($requestURL));

            $schoolData = format_data($schoolData->SingleSchool);

            foreach ($schoolData as $key => $schoolDataYear) {
                $schoolData[$key] = get_object_vars($schoolDataYear);
            }

            $schoolName = "Sunshine Elementary School";

            $output .= "\n\t\t" . '<div class="school-calc-type school-type-elementary">';
            
                /* START DATA BREAKDOWN */

                $output .= "\n\t\t" . '<div class="school-grade-component-reportcard">';

                    $schoolGradeOutput = "";
                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/report-card.php' );
                    $output .= $schoolGradeOutput;
                    $schoolGradeOutput = "";

                $output .= "\n\t\t" . '</div>';

                /* END DATA BREAKDOWN */

                /* START GRADING SCALE */

                $schoolGradeOutput = "";
                include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/scale.php' );
                $output .= $schoolGradeOutput;
                $schoolGradeOutput = "";

                /* END GRADING SCALE */

            $output .= "\n\t\t" . '</div>';

            unset($schoolData);

            /* END ELEMENTARY SCHOOL CALCULATION */

            /* START MIDDLE SCHOOL CALCULATION */

            $schoolId = 3029;
            $districtId = 13;
            $endYear = get_field("year", 42);
            $startYear = 1999;

            // START API CALL

            // SCHOOL DATA

            $requestURL = "https://api.jaxpef.org/school/singleschool/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY . "&yrstart=" . $startYear . "&yrend=" . $endYear;
            $schoolData = json_decode(file_get_contents($requestURL));

            $schoolData = format_data($schoolData->SingleSchool);

            foreach ($schoolData as $key => $schoolDataYear) {
                $schoolData[$key] = get_object_vars($schoolDataYear);
            }

            $schoolName = "Sunshine Middle School";

            $output .= "\n\t\t" . '<div class="school-calc-type school-type-middle" style="display:none;">';
            
                /* START DATA BREAKDOWN */

                $output .= "\n\t\t" . '<div class="school-grade-component-reportcard">';

                    $schoolGradeOutput = "";
                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/report-card.php' );
                    $output .= $schoolGradeOutput;
                    $schoolGradeOutput = "";

                $output .= "\n\t\t" . '</div>';

                /* END DATA BREAKDOWN */

                /* START GRADING SCALE */

                $schoolGradeOutput = "";
                include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/scale.php' );
                $output .= $schoolGradeOutput;
                $schoolGradeOutput = "";

                /* END GRADING SCALE */

            $output .= "\n\t\t" . '</div>';

            /* END MIDDLE SCHOOL CALCULATION */

            /* START HIGH SCHOOL CALCULATION */

            $schoolId = 7009;
            $districtId = 13;
            $endYear = get_field("year", 42);
            $startYear = 1999;

            // START API CALL

            // SCHOOL DATA

            $requestURL = "https://api.jaxpef.org/school/singleschool/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY . "&yrstart=" . $startYear . "&yrend=" . $endYear;
            $schoolData = json_decode(file_get_contents($requestURL));

            $schoolData = format_data($schoolData->SingleSchool);

            foreach ($schoolData as $key => $schoolDataYear) {
                $schoolData[$key] = get_object_vars($schoolDataYear);
            }

            $schoolName = "Sunshine High School";

            $output .= "\n\t\t" . '<div class="school-calc-type school-type-high" style="display:none;">';
            
                /* START DATA BREAKDOWN */

                $output .= "\n\t\t" . '<div class="school-grade-component-reportcard">';

                    $schoolGradeOutput = "";
                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/report-card.php' );
                    $output .= $schoolGradeOutput;
                    $schoolGradeOutput = "";

                $output .= "\n\t\t" . '</div>';

                /* END DATA BREAKDOWN */

                /* START GRADING SCALE */

                $schoolGradeOutput = "";
                include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/scale.php' );
                $output .= $schoolGradeOutput;
                $schoolGradeOutput = "";

                /* END GRADING SCALE */

            $output .= "\n\t\t" . '</div>';

            /* END HIGH SCHOOL CALCULATION */

            $output .= "\n\t\t" . '</div>';
            $output .= "\n\t" . '</div> ' . $this->endBlockComment( $width );

            $output = $this->startRow( $el_position ) . $output . $this->endRow( $el_position );

            return $output;

        }
    }

    SPBMap::map( 'spb_calc_examples', array(
        "name"   => __( "Grade Calculation Examples", 'swift-framework-plugin' ),
        "base"   => "spb_calc_examples",
        "class"  => "spb_calc_examples",
        "icon"   => "spb-icon-calc-examples",
        "params" => array(
            array(
                "type"        => "textfield",
                "heading"     => __( "Extra class", 'swift-framework-plugin' ),
                "param_name"  => "el_class",
                "value"       => "",
                "description" => __( "If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'swift-framework-plugin' )
            )
        )
    ) );