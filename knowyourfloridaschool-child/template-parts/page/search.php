
<?php do_action( 'sf_page_content_before' ); ?>

<div <?php post_class( 'clearfix' ); ?> id="<?php the_ID(); ?>">

    <?php do_action( 'sf_page_content_start' ); ?>

    <?php 

        $banner_image_id = get_field( "banner_image", 42 );

        $search_filter = '[spb_row wrap_type="content-width" row_bg_type="image" row_bg_color="#00a7b9" color_row_height="content-height" bg_image="' . $banner_image_id . '" bg_type="cover" parallax_image_height="content-height" parallax_image_movement="fixed" parallax_image_speed="0.5" parallax_video_height="window-height" row_top_style="none" row_bottom_style="none" parallax_video_overlay="none" row_overlay_opacity="0" row_padding_vertical="0" row_padding_horizontal="0" row_margin_vertical="0" remove_element_spacing="no" inner_column_height="col-natural" row_animation="none" row_animation_delay="0" row_id="search-filters" width="1/1" el_position="first last"] ';
            
            $search_filter .= '[spb_blank_spacer height="100" width="1/1" el_position="first last"]';
            $search_filter .= '[spb_search title="Find Your School" search_input_text="Search..." width="1/1" el_position="first last"] ';
        
        $search_filter .= '[/spb_row]'; 

        $search_filter .= '[spb_row wrap_type="content-width" row_bg_type="color" row_bg_color="#ffffff" color_row_height="content-height" bg_type="cover" parallax_image_height="content-height" parallax_image_movement="fixed" parallax_image_speed="0.5" parallax_video_height="window-height" row_top_style="none" row_bottom_style="none" parallax_video_overlay="none" row_overlay_opacity="0" row_padding_vertical="0" row_padding_horizontal="0" row_margin_vertical="0" remove_element_spacing="no" inner_column_height="col-natural" row_animation="none" row_animation_delay="0" row_id="search-feed" width="1/1" el_position="first last"] ';
            
            $search_filter .= '[spb_blank_spacer height="60" width="1/1" el_position="first last"] [spb_florida_schools_feed blog_filter="yes" pagination="standard" advanced_search="no" width="1/1" el_position="first last"] [spb_blank_spacer height="80" width="1/1" el_position="first last"]';

        $search_filter .= '[/spb_row]';

        echo do_shortcode($search_filter);

    ?>

    <?php
        /**
         * @hooked - sf_page_comments - 10
         **/
        do_action( 'sf_page_content_end' );
    ?>

</div>

<?php do_action( 'sf_page_content_after' ); ?>
