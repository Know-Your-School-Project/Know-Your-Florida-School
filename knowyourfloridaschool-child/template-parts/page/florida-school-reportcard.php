<?php

require( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );
require_once( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/functions.php' );

if ( ( isset($_GET["schoolid"]) && !empty($_GET["schoolid"]) && $_GET["schoolid"] != "" ) && ( isset($_GET["districtid"]) && !empty($_GET["districtid"]) && $_GET["districtid"] != "" ) ) {

    $schoolId = $_GET["schoolid"];
    $districtId = $_GET["districtid"];
    $endYear = get_field("year", 42);
    $startYear = 1999;

    // START API CALL

    // SCHOOL DATA

    $requestURL = "https://api.jaxpef.org/school/singleschool/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY . "&yrstart=" . $startYear . "&yrend=" . $endYear;
    $schoolData = api_call($requestURL, get_stylesheet_directory() . "/cache/schooldata-" . $districtId . "-" . $schoolId . "-" . $startYear . "-" . $endYear . ".json");
    $schoolData = format_data($schoolData->SingleSchool);

    foreach ($schoolData as $key => $schoolDataYear) {
        $schoolData[$key] = get_object_vars($schoolDataYear);
    }

    $schoolName = ucwords(strtolower($schoolData[count($schoolData)-1]["SCHOOL_NAME_LONG"]));
    
    $SPARminYear = $SPARyear = get_field("performance_min_year", 42);
    $SPARmaxYear = get_field("performance_max_year", 42);

    if ( $SPARmaxYear < $SPARminYear ) {
        $SPARmaxYear = $SPARminYear;
    }

    // THOMAS: CREATED GLOBAL VAR IN VARIBALES.PHP, MOVED API CALL HERE FROM INJECT FUNCTION IN FUNCTIONS.PHP IN ORDER TO PREVENT MULTIPLE API CALLS FOR THE SAME DATA. 
    $schoolTypes = api_call("https://api.jaxpef.org/schooltypes/schooltype/?APIKey=" . $apiKEY, get_stylesheet_directory() . "/cache/type.json");
    
    // END API CALL

        ?>

        <?php if ( have_posts() ) : the_post(); ?>

            <?php do_action( 'sf_page_content_before' ); ?>

            <div <?php post_class( 'clearfix' ); ?> id="<?php the_ID(); ?>" data-districtid="<?php echo $districtId; ?>" data-schoolid="<?php echo $schoolId; ?>" data-apicall="<?php echo $requestURL; ?>">

                <?php do_action( 'sf_page_content_start' ); ?>

                <?php 

                        // START OVERVIEW

                        $colors = ["#f5ae27", "#6183b3", "#1ab689", "#937eb5", "#aeadae", "#64c9d3", "#00a7b9", "#f15940", "#58c3cd", "#201d1d", "#159db1", "#5b5053", "#724000", "#e1765a", "#8673ad"];

                        $schoolGrade = get_school_grade($schoolData);

                        $banner_image_url = wp_get_attachment_image_src( get_field( "banner_image", $post->ID ), 'banner-image' )[0];

                        if ( $banner_image_url != "" ) {
                            $banner_image = 'style="background-image: url(' . $banner_image_url .');"';
                        } else {
                            $banner_image = 'style="background-image: url(' . get_stylesheet_directory_uri() . '/images/heading-banner-reportcards.png);"';
                        }

                        ?>

                        <section id="school-reportcard-overview" class="row fw-row">
                            <div class="spb-row-container spb-row-content-width col-sm-12  col-natural" data-v-center="false" data-top-style="none" data-bottom-style="none" <?php echo $banner_image; ?>>
                                <div class="spb_content_element">
                                    <section class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php

                                                    echo '<h1 class="school-name">' . ucwords(strtolower($schoolName)) . "</h1>";
                                                    echo '<a href="#" class="add-school-compare-link" data-schoolid="' . $schoolData[count($schoolData)-1]["SCHOOLID"] . '" data-districtid="' . $schoolData[count($schoolData)-1]["DISTRICTID"] . '" data-schoolname="' . $schoolName . '">ADD TO MY SCHOOLS LIST</a>';

                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <?php

                                                        include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/overview/stats.php' );

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div> 
                            </div>
                        </section>
                        
                        <?php

                        // END OVERVIEW

                        ?>

                        <div class="container">

                            <?php

                            // START TOGGLE

                            $toggleOutput = '[spb_row wrap_type="content-width" row_bg_type="color" color_row_height="content-height" bg_type="cover" parallax_image_height="content-height" parallax_image_movement="fixed" parallax_image_speed="0.5" parallax_video_height="window-height" row_top_style="none" row_bottom_style="none" parallax_video_overlay="none" row_overlay_opacity="0" row_padding_vertical="0" row_padding_horizontal="0" row_margin_vertical="0" remove_element_spacing="no" inner_column_height="col-natural" row_animation="none" row_animation_delay="0" row_id="school-reportcard-toggle" width="1/1" el_position="first last"]';
                            $toggleOutput .= '[spb_blank_spacer height="30" width="1/1" el_position="first last"] ';
                            $toggleOutput .= '[spb_socialsharing enable_email="yes" enable_facebook="yes" enable_linkedin="yes" enable_twitter="yes" width="1/1" el_position="first last"] [spb_blank_spacer height="60" width="1/1" el_position="first last"] '; 
                            $toggleOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="" el_position="first"]<div class="toggle-content"><a href="#" data-hash="school-reportcard-school-grade" class="toggle-content-link toggle-content-school-grades">School Grades</a><a href="#" data-hash="school-reportcard-performance-details" class="toggle-content-link toggle-content-performance-details">Student Performance Details</a><a href="#" data-hash="school-reportcard-student-characteristics" class="toggle-content-link toggle-content-student-characteristics">Student Characteristics</a></div>[/spb_text_block]';
                            $toggleOutput .= '[/spb_row]';
                            echo do_shortcode($toggleOutput);

                            // END TOGGLE

                            ?>
                        
                            <?php

                            // START SCHOOL GRADE

                            $schoolGradeOutput = '[spb_row wrap_type="content-width" row_bg_type="color" color_row_height="content-height" bg_type="cover" parallax_image_height="content-height" parallax_image_movement="fixed" parallax_image_speed="0.5" parallax_video_height="window-height" row_top_style="none" row_bottom_style="none" parallax_video_overlay="none" row_overlay_opacity="0" row_padding_vertical="0" row_padding_horizontal="0" row_margin_vertical="0" remove_element_spacing="no" inner_column_height="col-natural" row_animation="none" row_animation_delay="0" row_id="school-reportcard-school-grade-data" width="1/1" el_position="first last"]';
                            $schoolGradeOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/3" el_class="school-grade-column" el_position="first"]';

                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/grade.php' );
                            
                            $schoolGradeOutput .= '[/spb_text_block] ';
                            $schoolGradeOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="2/3" el_class="parent-empowerment-column" el_position="last"]';

                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/grade-description.php' );

                            $schoolGradeOutput .= '[/spb_text_block] ';   
                            $schoolGradeOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="school-grade-component-reportcard" el_position="first last"]';

                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/report-card.php' );
                            
                            $schoolGradeOutput .= '[/spb_text_block] ';
                            $schoolGradeOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="school-grade-component-grading-scale" el_position="first last"]';

                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/grade-components/scale.php' );
                            
                            $schoolGradeOutput .= '[/spb_text_block] ';
                            $schoolGradeOutput .= '[spb_button button_size="standard" button_colour="purple" button_align="align-center" button_text="View Historical Data" button_target="_self" animation="none" animation_delay="0" width="1/1" el_class="view-grade-history" el_position="first last"] ';
                            $schoolGradeOutput .= '[/spb_row]';

                            echo do_shortcode($schoolGradeOutput);

                            // END SCHOOL GRADE

                            // START PERFORMANCE

                            $schoolPerformanceOutput = '[spb_row wrap_type="content-width" row_bg_type="color" color_row_height="content-height" bg_type="cover" parallax_image_height="content-height" parallax_image_movement="fixed" parallax_image_speed="0.5" parallax_video_height="window-height" row_top_style="none" row_bottom_style="none" parallax_video_overlay="none" row_overlay_opacity="0" row_padding_vertical="0" row_padding_horizontal="0" row_margin_vertical="0" remove_element_spacing="no" inner_column_height="col-natural" row_animation="none" row_animation_delay="0" row_id="school-reportcard-performance-details-description" width="1/1" el_position="first last"]';
                            $schoolPerformanceOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_position="first last"]';
                            
                            $schoolPerformanceOutput .= "<h2 class='reportcard-title'>Student Performance Details</h2>";

                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/description.php' );

                            $schoolPerformanceOutput .= '[/spb_text_block] ';
                            
                            $schoolPerformanceOutput .= '[/spb_row]';
                            $schoolPerformanceOutput .= '[spb_row wrap_type="full-width" row_bg_type="color" color_row_height="content-height" bg_type="cover" parallax_image_height="content-height" parallax_image_movement="fixed" parallax_image_speed="0.5" parallax_video_height="window-height" row_top_style="none" row_bottom_style="none" parallax_video_overlay="none" row_overlay_opacity="0" row_padding_vertical="0" row_padding_horizontal="0" row_margin_vertical="0" remove_element_spacing="no" inner_column_height="col-natural" row_animation="none" row_animation_delay="0" row_id="school-reportcard-performance-details-data" width="1/1" el_position="first last"]';
                             
                            $minYear = $year = get_field("performance_min_year");
                            $maxYear = get_field("performance_max_year");

                            if ( $maxYear < $minYear ) {
                                $maxYear = $minYear;
                            }

                            $subgroups = array(
                                    "W"     => "White",
                                    "B"     => "Black/African American",
                                    "H"     => "Hispanic/Latino",
                                    "A"     => "Asian",
                                    "NHPI"  => "Native Hawaiian/Pacific Islander",
                                    "AIAN"  => "American Indian/Alaska Native",
                                    "MULT"  => "Multiracial",
                                    "DIS"   => "Disabled",
                                    "ED"    => "Economically Disadvantaged",
                                    "ELL"   => "English Language Learners",
                                    "MIG"   => "Migrant",
                                    "F"     => "Female",
                                    "M"     => "Male"
                                );

                            $datasets = array(
                                    "school"    => "School",
                                    "district"  => "District",
                                    "state"     => "State"
                                );

                            if ( $minYear != "" && $minYear > 0 && $maxYear != "" && $maxYear > 0 && $maxYear >= $minYear ) {
                                
                                //$SPARData = get_SPAR_data($minYear, $maxYear, $districtId, $schoolId);

                                if ( count($SPARData["school"]) > 0 && count($SPARData["district"]) > 0 && count($SPARData["state"]) > 0 ) {

                                    $schoolPerformanceOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_position="first last"]';
                                    
                                    $schoolPerformanceOutput .= "<h2 class='reportcard-title english-language-reportcard-title'>English Language Arts</h2>";
                                    
                                    $schoolPerformanceOutput .= '[/spb_text_block] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/2" el_class="student-performance-spar-ela-aggregate" el_position="first"]';
                                    
                                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-ela-aggregate.php' );
                                    
                                    $schoolPerformanceOutput .= '[/spb_text_block] ';
                                    $schoolPerformanceOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/2" el_class="student-performance-spar-ela-subgroup" el_position="last"]';
                                    
                                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-ela-subgroup.php' );

                                    $schoolPerformanceOutput .= '[/spb_text_block] ';

                                    $schoolPerformanceOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="view-table-wrap" el_position="first last"]<p style="text-align:center;">View a table of full English Language Arts data.</p>[/spb_text_block] ';
                                    $schoolPerformanceOutput .= '[spb_button button_size="standard" button_colour="purple" button_align="align-center" button_text="View Table" button_target="_self" animation="none" animation_delay="0" width="1/1" el_class="view-ela-performance-data" el_position="first last"] ';
                            
                                    $schoolPerformanceOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_position="first last"]';
                                    
                                    $schoolPerformanceOutput .= "<h2 class='reportcard-title mathematics-reportcard-title'>Mathematics</h2>";
                                    
                                    $schoolPerformanceOutput .= '[/spb_text_block] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/2" el_class="student-performance-spar-math-aggregate" el_position="first"]';
                                    
                                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-math-aggregate.php' );
                                    
                                    $schoolPerformanceOutput .= '[/spb_text_block] ';
                                    $schoolPerformanceOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/2" el_class="student-performance-spar-math-subgroup" el_position="last"]';
                                    
                                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-math-subgroup.php' );

                                    $schoolPerformanceOutput .= '[/spb_text_block] ';

                                    $schoolPerformanceOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="view-table-wrap mathematics-wrap" el_position="first last"]<p style="text-align:center;">View a table of full Mathematics data.</p>[/spb_text_block] ';
                                    $schoolPerformanceOutput .= '[spb_button button_size="standard" button_colour="purple" button_align="align-center" button_text="View Table" button_target="_self" animation="none" animation_delay="0" width="1/1" el_class="view-math-performance-data" el_position="first last"] ';
                            
                                    $schoolPerformanceOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_position="first last"]';
                                    
                                    $schoolPerformanceOutput .= "<h2 class='reportcard-title'>Science</h2>";
                                    
                                    $schoolPerformanceOutput .= '[/spb_text_block] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/2" el_class="student-performance-spar-science-aggregate" el_position="first"]';
                                    
                                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-science-aggregate.php' );
                                    
                                    $schoolPerformanceOutput .= '[/spb_text_block] ';
                                    $schoolPerformanceOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/2" el_class="student-performance-spar-science-subgroup" el_position="last"]';
                                    
                                    include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/performance-details/spar-science-subgroup.php' );

                                    $schoolPerformanceOutput .= '[/spb_text_block] ';

                                    $schoolPerformanceOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="view-table-wrap" el_position="first last"]<p style="text-align:center;">View a table of full Science data.</p>[/spb_text_block] ';
                                    $schoolPerformanceOutput .= '[spb_button button_size="standard" button_colour="purple" button_align="align-center" button_text="View Table" button_target="_self" animation="none" animation_delay="0" width="1/1" el_class="view-science-performance-data" el_position="first last"] ';
                                    $schoolPerformanceOutput .= "[spb_accordion active_section='2' el_class='assessment-details-accordion' width='1/1' el_position=''] [spb_accordion_tab title='Assessment Details' accordion_id='' icon=''] [spb_text_block animation='none' animation_delay='0' padding_vertical='0' padding_horizontal='0' width='1/1' el_position='first last']<div class='assessment-details'><p>The Florida Standards Assessments (FSA) measure students’ mastery of the new Florida Standards and are administered to students in grades 3-10 in English language arts (ELA) and grades 3-8 in mathematics as well as in Algebra 1, Geometry, and Algebra 2 (2014-15). For ELA and mathematics assessments, the FSA replaced the Florida Comprehensive Assessment Test (FCAT) 2.0 and Algebra 1 and Geometry End-of-Course (EOC) assessments aligned to the Next Generation Sunshine State Standards (NGSSS). In science, Florida continues to administer the Statewide Science Assessment in grades 5 and 8 and the Biology 1 EOC assessment, aligned to the NGSSS (2013-14 and 2014-15).</p>
 
                                        <p>The FAA is designed for students whose participation in the general statewide assessment (FSA and EOC) is not appropriate, even with accommodations. The FAA measures student academic performance on the Next Generation Sunshine State Standards Access Points (NGSSS-AP) in language arts (reading, writing), mathematics and science.</p>
                                         
                                        <p>Assessment results in the following tables reflect scores on FSA (2014-15) or NGSSS assessment data, as applicable, combined with FAA data for ELA results (2014-15) and for reading and writing results (2013-14). Beginning in 2014-15, Florida's state assessment in ELA included sections for both reading comprehension and writing. As of 2014-15, writing is no longer a stand-alone subject for state assessments, having been combined with reading for the state's ELA measure. For mathematics and science, results include FSA or NGSSS, FAA and EOC assessment results, as applicable. Results show satisfactory attainment for students who were in attendance during both semesters of the school year.</p>
                                         
                                        <p>On EOC assessments and the FSA ELA and mathematics and NGSSS science tests, students can attain one of five possible achievement levels, ranging from Level 1 (lowest) to Level 5 (highest), with scores at Level 3 or higher designated as satisfactory. The FAA is scored on nine performance levels, with FAA Level 4 establishing the minimum level for satisfactory attainment.</p></div>[/spb_text_block] [/spb_accordion_tab][/spb_accordion]";
                                }
                            }

                            $schoolPerformanceOutput .= '[/spb_row]';

                            echo do_shortcode($schoolPerformanceOutput);

                            if ( WP_DEBUG === true && count($SPARData["school"]) > 0 && count($SPARData["district"]) > 0 && count($SPARData["state"]) > 0 ) {

                                echo "<h2>Below is the full set of raw SPAR data from the API (" . $minYear . " - " . $maxYear . "):</h2>";

                                echo "<pre>";
                                print_r($SPARData["school"]);
                                echo "</pre>";
                                echo "<pre>";
                                print_r($SPARData["district"]);
                                echo "</pre>";
                                echo "<pre>";
                                print_r($SPARData["state"]);
                                echo "</pre>";

                            }

                            // END SCHOOL PERFORMANCE

                            // START CHARACTERISTICS
                            
                            $endYear = get_field("about_year");
                            $startYear = 1999;
                            
                            $requestURL = "https://api.jaxpef.org/school/singleschool/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY . "&yrstart=" . $startYear . "&yrend=" . $endYear;
                            $schoolData = api_call($requestURL, get_stylesheet_directory() . "/cache/schoolchar-" . $districtId . "-" . $schoolId . "-" . $startYear . "-" . $endYear . ".json");

                            $schoolData = format_data($schoolData->SingleSchool);

                            foreach ($schoolData as $key => $schoolDataYear) {
                                $schoolData[$key] = get_object_vars($schoolDataYear);
                            }

                            $schoolCharacterOutput = '[spb_row wrap_type="content-width" row_bg_type="color" color_row_height="content-height" bg_type="cover" parallax_image_height="content-height" parallax_image_movement="fixed" parallax_image_speed="0.5" parallax_video_height="window-height" row_top_style="none" row_bottom_style="none" parallax_video_overlay="none" row_overlay_opacity="0" row_padding_vertical="0" row_padding_horizontal="0" row_margin_vertical="0" remove_element_spacing="no" inner_column_height="col-natural" row_animation="none" row_animation_delay="0" row_id="school-reportcard-student-characteristics-data" width="1/1" el_position="first last"]';
                            $schoolCharacterOutput .= '[spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_position="first last"]';
                            
                            $schoolCharacterOutput .= "<h2 class='reportcard-title'>Student Characteristics</h2>";

                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/description.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] '; 
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-grade-level" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-grade-level.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-gender" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-gender.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-race" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-race.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-disabilities" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-disabilities.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-english-learners" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-english-learners.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-economic-status" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-economic-status.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-homeless" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-homeless.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-foster-care" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-foster-care.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_blank_spacer height="20" width="1/1" el_position="first last"] [spb_text_block animation="none" animation_delay="0" padding_vertical="0" padding_horizontal="0" width="1/1" el_class="about-school-enrollment-military" el_position="first last"]';
                            
                            include( get_stylesheet_directory() . '/template-parts/page/florida-school-reportcard/school-characteristics/enrollment-military.php' );

                            $schoolCharacterOutput .= '[/spb_text_block] ';
                            $schoolCharacterOutput .= '[spb_button button_size="standard" button_colour="purple" button_align="align-center" button_text="View Historical Data" button_target="_self" animation="none" animation_delay="0" width="1/1" el_class="view-grade-history" el_position="first last"] ';
                            $schoolCharacterOutput .= '[/spb_row]';

                            echo do_shortcode($schoolCharacterOutput);

                            ?>

                        </div>

                        <?php

                        // END ACHIEVEMENT

                        if ( WP_DEBUG === true ) {

                            echo "<h2>Below is the full set of raw data from the API (" . $startYear . " - " . $endYear . "):</h2>";

                            echo "<pre>";
                            print_r($schoolData);
                            echo "</pre>";

                        }

                        /**
                         * @hooked - sf_page_comments - 10
                         **/
                        do_action( 'sf_page_content_end' );
                    ?>

            </div>

            <?php do_action( 'sf_page_content_after' ); ?>

        <?php endif;
    
} else {

    wp_redirect( get_home_url(), 301 );

}

?>
