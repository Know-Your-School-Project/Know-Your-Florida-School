<?php

$subject = "SCI";

$modal_content .= '<div class="page-content">';
  $modal_content .= '<div class="row">';
    $modal_content .= '<div class="col-md-12">';
      $modal_content .= '<div id="exhibit-grade-history-' . $schoolId . '" data-schoolid="' . $schoolId . '" class="exhibit-group exhibit-grade-history">';
        if( have_rows('school_grade_history') ) {
          $modal_content .= '<a href="#" class="close-modal-link"><< Back to School Report Card</a>';
          
                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/charts/table.php' );

          $modal_content .= '<a href="#" class="close-modal-link"><< Back to School Report Card</a>';
        }
        $modal_content .= '</div>';
    $modal_content .= '</div>';
  $modal_content .= '</div>';
$modal_content .= '</div>';

?>