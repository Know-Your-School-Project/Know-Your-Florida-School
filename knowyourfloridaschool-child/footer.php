<?php

    global $sf_options;
    
    $header_layout = $sf_options['header_layout'];
    if ( isset( $_GET['header'] ) ) {
        $header_layout = $_GET['header'];
    }

    global $remove_promo_bar;

    if ( $remove_promo_bar ) {
        remove_action( 'sf_main_container_end', 'sf_footer_promo', 20 );
    }

    /* SET VARIABLES */
    $enable_footer            = $sf_options['enable_footer'];

    /* COPYRIGHT VARIABLES */
    $enable_copyright         = $sf_options['enable_copyright'];
    $show_backlink            = $sf_options['show_backlink'];
    $swiftideas_backlink      = $copyright_class = "";
    $socialdriver_backlink    = "";
    $copyright_text           = __( do_shortcode($sf_options['footer_copyright_text']), 'swiftframework' );

?>

<?php
    /**
     * @hooked - sf_footer_promo - 20
     * @hooked - sf_one_page_nav - 30
     **/
    do_action( 'sf_main_container_end' );
?>

<!--// CLOSE #main-container //-->
</div>
<div id="footer-wrap" class="row fw-row clearfix">

    <?php

    /* FOOTER WIDGETS */

    if ( $enable_footer ) {

        ?>

        <section id="FDE-link" class="row fw-row clearfix"> 
            <div class="spb_content_element spb_text_column container clearfix">
                <div class="col-sm-12">
                    <?php if ( function_exists( 'dynamic_sidebar' ) ) { ?>
                        <?php dynamic_sidebar( 'footer-data' ); ?>
                    <?php } ?>  
                </div>
            </div>
        </section>

        <section id="signup" class="row fw-row clearfix"> 
            <div class="spb_content_element spb_text_column container clearfix">
                <?php if ( function_exists( 'dynamic_sidebar' ) ) { ?>
                    <?php dynamic_sidebar( 'footer-signup' ); ?>
                <?php } ?> 
            </div>
        </section>

        <!--// OPEN #footer //-->
        <section id="footer">
            <div class="container">
                <div id="footer-widgets" class="clearfix">

                    <section class="footer-logo">
                        <a href="<?php echo get_home_url(); ?>"><img class="inject-me" data-src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-white.svg" data-fallback="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-white@2x.png" /></a>
                    </section>

                    <?php if ( function_exists( 'dynamic_sidebar' ) ) { ?>
                        <?php dynamic_sidebar( 'footer-content' ); ?>
                    <?php } ?>

                </div>
            </div>

            <?php do_action( 'sf_footer_wrap_after' ); ?>

            <!--// CLOSE #footer //-->
        </section>
    <?php
    }

    ?>

    <?php 

        /* COPYRIGHT OUTPUT */

        sd_get_template_part( 'footer/copyright' );

    ?>
</div>

<?php do_action( 'sf_container_end' ); ?>

<!--// CLOSE #container //-->
</div>

<?php
    /**
     * @hooked - sf_back_to_top - 20
     * @hooked - sf_fw_video_area - 30
     **/
    do_action( 'sf_after_page_container' );
?>

<?php wp_footer(); ?>

<!--// CLOSE BODY //-->
</body>


<!--// CLOSE HTML //-->
</html>