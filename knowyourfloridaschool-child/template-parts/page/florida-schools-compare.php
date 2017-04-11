<?php

    include_once( get_stylesheet_directory() . "/template-parts/page/florida-school-reportcard/functions.php");

    if ( have_posts() ) : the_post(); ?>

    <?php do_action( 'sf_page_content_before' ); ?>

    <div <?php post_class( 'clearfix' ); ?> id="<?php the_ID(); ?>">

        <?php do_action( 'sf_page_content_start' ); ?>

        <?php 

            the_content();

            if ( isset($_GET["schools"]) && !empty($_GET["schools"]) && $_GET["schools"] != "" ) {

                require_once( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );

                $_COOKIE["compare-schools"] = stripslashes($_GET["schools"]);

                $endYear = get_field("year", 42);
                $startYear = $endYear;
                $schoolsToCompare = json_decode(stripslashes($_COOKIE["compare-schools"]));
                $schoolsToCompareData = [];

                if ( count($schoolsToCompare) > 0 ) {

                    echo '<section id="compare-feed" data-rowname="" class="row fw-row">';
                        echo '<div class="spb-row-container spb-row-content-width col-sm-12 col-natural" data-v-center="false" data-top-style="none" data-bottom-style="none" style="background-color:#ffffff;padding-left:0%;padding-right:0%;margin-top:0px;margin-bottom:0px;">';
                            echo '<div class="spb_content_element" style="padding-top:0px;padding-bottom:0px;">';
                                echo '<section class="container">';
                                    echo '<div class="row">';
                                        echo '<div class="spb_blog_widget blog-wrap excelined-feed spb_content_element col-sm-12">';
                                            echo '<div class="spb-asset-content">';
                                                echo '<div class="row">';
                                                    echo '<div class="container">';
                                                        echo '<div class="clearfix">';
                                                            echo '<div class="row">';
                                                                echo '<div class="blog-items-wrap blog-masonry ">';
                                                                    echo '<ul class="blog-items masonry-items clearfix" data-blog-type="masonry">';
                                                                        
                                                                        foreach ($schoolsToCompare as $key => $school) {

                                                                            $schoolId = $school->schoolid;
                                                                            $districtId = $school->districtid;

                                                                            // SCHOOL DATA
                                                                            $requestURL = "https://api.jaxpef.org/school/singleschool/" . $districtId . "/" . $schoolId . "/?APIKey=" . $apiKEY . "&yrstart=" . $startYear . "&yrend=" . $endYear;
                                                                            $schoolData = api_call($requestURL, get_stylesheet_directory() . "/cache/schoolchar-" . $districtId . "-" . $schoolId . "-" . $startYear . "-" . $endYear . ".json");

                                                                            $schoolData = $schoolData->SingleSchool;

                                                                            foreach ($schoolData as $key => $schoolDataYear) {
                                                                                $schoolData[$key] = get_object_vars($schoolDataYear);
                                                                            }

                                                                            $school->data = $schoolData;

                                                                            $schoolsToCompareData[] = $school;

                                                                            include( get_stylesheet_directory() . '/template-parts/page/florida-schools-compare/school-card.php' );
                                                                            
                                                                        }
                                                                    echo '</ul>';
                                                                echo '</div>';
                                                            echo '</div>';
                                                        echo '</div>';
                                                    echo '</div>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</section>';
                            echo '</div>';
                        echo '</div>';
                    echo '</section>';
            
                    global $sf_has_blog, $sf_include_imagesLoaded;
                    $sf_include_imagesLoaded = true;
                    $sf_has_blog             = true;

                }

            } else {

                wp_redirect( get_home_url() . "/?search=keyword&s=", 301 );

            }

            /**
             * @hooked - sf_page_comments - 10
             **/
            do_action( 'sf_page_content_end' );
        ?>

    </div>

    <?php do_action( 'sf_page_content_after' ); ?>

<?php endif; ?>
