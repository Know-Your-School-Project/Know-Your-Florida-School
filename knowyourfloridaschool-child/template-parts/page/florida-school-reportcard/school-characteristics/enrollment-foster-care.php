<?php
    
    require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

    $enrollmentData = ""; // This is a string with Enrollment Data for Highcharts
    $enrollmentDataEmpty = array(); // These are the races that doe not contain any data

    $schoolCharacterOutput .= '<div class="row">';
        $schoolCharacterOutput .= '<div class="col-md-12">';
            $schoolCharacterOutput .= '<h3>Foster Care</h3><p>' .   inject_data(get_field("enrollment_foster_care_description"), $schoolData, $schoolTypes) . '</p>';
        $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '<div class="row">';
        $schoolCharacterOutput .= '<div class="col-md-12">';
        
        

        $schoolCharacterOutput .= '</div>';
    $schoolCharacterOutput .= '</div>';

?>