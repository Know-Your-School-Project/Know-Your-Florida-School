<?php

	/*
	*
	*	Footer Social Channels
	*	------------------------------------------------
	* 	Copyright Social Driver 2015 - http://socialdriver.com
	*
	*	Output for footer social channels
	*
	*/

	global $sf_options;

    $enable_copyright         = $sf_options['enable_copyright'];
    $show_backlink            = $sf_options['show_backlink'];
    $copyright_text           = __( do_shortcode($sf_options['footer_copyright_text']), 'swiftframework' );

    if ( $show_backlink ) {
        $socialdriver_backlink = apply_filters( "socialdriver_link", " | Built by <a href='http://collaborativecommunications.com/' rel='nofollow' target='_blank'>Collaborative Communications</a>, <a href='http://socialdriver.com' rel='nofollow' target='_blank'>Social Driver</a>, and <a href='http://www.jaxpef.org/' rel='nofollow' target='_blank'>The Jacksonville Public Education Fund</a>" );
    }

    if ( $enable_copyright ) {
        ?>

        <!--// OPEN #copyright //-->
        <footer id="copyright" class="<?php echo esc_attr($copyright_class); ?>">
            <div class="container">
                <div class="text-left"><?php echo $copyright_text; ?><?php echo $socialdriver_backlink; ?></div>
            </div>
            <!--// CLOSE #copyright //-->
        </footer>

        <?php
    }

?>