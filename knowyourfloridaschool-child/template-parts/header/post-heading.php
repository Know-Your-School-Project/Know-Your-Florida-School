<?php

	/*
	*
	*	POST AUTHOR
	*	------------------------------------------------
	* 	Copyright Social Driver 2015 - http://socialdriver.com
	*
	*	This is the way that the author displays on posts
	*
	*/

    global $wp_query, $post, $sf_options;
    
    $shop_page  = false;
    $page_title = $page_subtitle = $page_title_style = $page_title_overlay_effect = $fancy_title_image_url = $article_heading_bg = $article_heading_text = $page_heading_el_class = $page_design_style = $extra_styles = $page_title_text_align = "";

    $show_page_title    = apply_filters( 'sf_page_heading_ns_pagetitle', 1 );
    $remove_breadcrumbs = apply_filters( 'sf_page_heading_ns_removebreadcrumbs', 0 );
    $breadcrumb_in_heading = 0;
    if ( isset( $sf_options['breadcrumb_in_heading'] ) ) {
    	$breadcrumb_in_heading = $sf_options['breadcrumb_in_heading'];
    }
    $page_title_height  = 300;
    $page_title_style   = "standard";

    $next_icon = apply_filters( 'sf_next_icon', '<i class="ss-navigateright"></i>' );
    $prev_icon = apply_filters( 'sf_prev_icon', '<i class="ss-navigateleft"></i>' );

	// Shop page check
    if ( ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_category' ) && is_product_category() ) ) {
        $shop_page = true;
    }

    // Defaults
    $default_show_page_heading = $sf_options['default_show_page_heading'];
    $pagination_style          = "standard";
    if ( isset( $sf_options['pagination_style'] ) ) {
        $pagination_style = $sf_options['pagination_style'];
    }

    // Post meta
    if ( $post && is_singular() ) {
        $show_page_title       = sf_get_post_meta( $post->ID, 'sf_page_title', true );
        $remove_breadcrumbs    = sf_get_post_meta( $post->ID, 'sf_no_breadcrumbs', true );
        $page_title_style      = sf_get_post_meta( $post->ID, 'sf_page_title_style', true );
        $page_title            = sf_get_post_meta( $post->ID, 'sf_page_title_one', true );
        $page_subtitle         = sf_get_post_meta( $post->ID, 'sf_page_subtitle', true );
        $fancy_title_image     = rwmb_meta( 'sf_page_title_image', 'type=image&size=full' );
        $page_title_text_style = sf_get_post_meta( $post->ID, 'sf_page_title_text_style', true );
        $page_title_overlay_effect = sf_get_post_meta( $post->ID, 'sf_page_title_overlay_effect', true );
        $page_title_text_align = sf_get_post_meta( $post->ID, 'sf_page_title_text_align', true );
        $page_title_height     = sf_get_post_meta( $post->ID, 'sf_page_title_height', true );
        $page_heading_bg       = sf_get_post_meta( $post->ID, 'sf_page_title_bg_color', true );
        $page_heading_text     = sf_get_post_meta( $post->ID, 'sf_page_title_text_color', true );

        if ( $page_heading_bg != "" ) {
            $article_heading_bg = 'style="background-color:' . $page_heading_bg . ';border-color:' . $page_heading_bg . ';"';
        }
        if ( $page_heading_text != "" ) {
            $article_heading_text = 'style="color:' . $page_heading_text . ';"';
        }
        if ( get_field("banner_image") != "" && wp_get_attachment_image_src(get_field("banner_image")) ) {
            $page_heading_el_class .= " has-banner-image";
            $article_heading_bg = 'style="background-image:url(' . wp_get_attachment_image_src(get_field("banner_image"), "full")[0] . ');"';
        } else {
            $article_heading_bg = 'style="background-image:url(' . get_stylesheet_directory_uri() . '/images/heading-banner.png);"';
        }
    }

    if ( is_singular( 'post' ) ) {
        $fw_media_display = sf_get_post_meta( $post->ID, 'sf_fw_media_display', true );
        $page_design_style 	  = sf_get_post_meta( $post->ID, 'sf_page_design_style', true );
        if ( $fw_media_display == "fw-media-title" ) {
            return;
        }
    }

    // Woo setup
    if ( $shop_page ) {
        $show_page_title       = $sf_options['woo_show_page_heading'];
        $page_title_style      = $sf_options['woo_page_heading_style'];
        $fancy_title_image     = $sf_options['woo_page_heading_image'];
        $page_title_text_style = $sf_options['woo_page_heading_text_style'];
        if ( isset( $sf_options['woo_page_heading_text_align'] ) ) {
        	$page_title_text_align = $sf_options['woo_page_heading_text_align'];
        }

        if ( isset( $fancy_title_image ) && isset( $fancy_title_image['url'] ) ) {
            $fancy_title_image_url = $fancy_title_image['url'];
        }

        if ( is_product_category() ) {
        	$category = $wp_query->get_queried_object();
        	$hero_id = get_woocommerce_term_meta( $category->term_id, 'hero_id', true  );
        	if ( $hero_id != "" && $hero_id != 0 ) {
        		$fancy_title_image_url = wp_get_attachment_url($hero_id, 'full');
        	}
        }
    }
    if ( function_exists( 'is_product' ) && is_product() ) {
        $product_layout = sf_get_post_meta( $post->ID, 'sf_product_layout', true );
        if ( $product_layout == "fw-split" ) {
            return;
        }
    }

    // Page Title
    if ( $show_page_title == "" ) {
        $show_page_title = $default_show_page_heading;
    }
    if ( $page_title == "" ) {
        $page_title = get_the_title();
    }
    if ( $page_title_height == "" ) {
        $page_title_height = apply_filters( 'sf_shop_fancy_page_height', 300 );
    }

    // Fancy heading image
    if ( ( $page_title_style == "fancy" || $page_title_style == "fancy-tabbed" ) && $fancy_title_image_url == "" ) {
        foreach ( $fancy_title_image as $detail_image ) {
            if ( isset( $detail_image['url'] ) ) {
                $fancy_title_image_url = $detail_image['url'];
                break;
            }
        }
        if ( ! $fancy_title_image ) {
            $fancy_title_image     = get_post_thumbnail_id();
            $fancy_title_image_url = wp_get_attachment_url( $fancy_title_image, 'full' );
        }
    }

    // Page Title Hidden
    if ( ! $show_page_title ) {
        $page_heading_el_class .= " page-heading-hidden";
    }

    // Breadcrumb in heading
    if ( $breadcrumb_in_heading ) {
    	$page_heading_el_class .= " page-heading-breadcrumbs";
    }

    if ( $page_title_style == "fancy-tabbed" ) {
    	$page_title_text_align = "left";
    }

    // Return if product & inner heading
    if ( function_exists( 'is_product' ) && is_product() && sf_theme_supports( 'product-inner-heading' ) && ( $page_title_style == "standard" || $page_title_style == "" ) ) {
    	return;
    }

    // Dont' allow fancy-tabbed on product pages
    if ( function_exists( 'is_product' ) && is_product() && sf_theme_supports( 'product-inner-heading' ) && $page_title_style == "fancy-tabbed" ) {
    	$page_title_style = "fancy";
    }

    if ( $page_title_style == "fancy" && sf_theme_opts_name() == "sf_atelier_options" && !(function_exists( 'is_product' ) && is_product()) ) {
        $extra_styles = 'height: ' . $page_title_height . 'px;';
    }

    if ( isset($sf_options['minimal_checkout']) ) {
		if ( function_exists('is_checkout') && is_checkout() ) {
			global $woocommerce;
        	if ( $sf_options['minimal_checkout'] ) { ?>

            	<div class="minimal-checkout-return container"><a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>"><?php _e("Return to cart", "swiftframework"); ?></a></div>

        	<?php }
    	}
	}

    if ( !is_search() ) {
        if ( ! is_home() ) {
            ?>
            <?php if ( $page_title_style == "fancy" || $page_title_style == "fancy-tabbed" ) { ?>

                <div class="fancy-heading-wrap <?php echo esc_attr($page_title_style); ?>-style">

                <?php if ( $fancy_title_image_url != ""  ) {
    				
    				$bg_color_title = $bg_opacity_title = "";
    				if ($post) {
                    	$bg_color_title = sf_get_post_meta( $post->ID, 'sf_bg_color_title', true );
        	            $bg_opacity_title = sf_get_post_meta( $post->ID, 'sf_bg_opacity_title', true );
    	            }
    	            
    	            if ( !$bg_color_title ) {
    	                $bg_color_title = "transparent";
    	                $bg_opacity_title = "0";
    	            }

                ?>
                    <div class="page-heading fancy-heading clearfix <?php echo esc_attr($page_title_text_style); ?>-style fancy-image <?php echo esc_attr($page_heading_el_class); ?>" style="background-image: url(<?php echo esc_url($fancy_title_image_url); ?>);<?php echo $extra_styles; ?>" data-height="<?php echo esc_attr($page_title_height); ?>">
                    	<span class="media-overlay" style="background-color:<?php echo $bg_color_title; ?>;opacity:<?php echo ( $bg_opacity_title/100); ?>;"></span>

                <?php } else { ?>
                    <div class="page-heading fancy-heading <?php echo esc_attr($page_heading_el_class); ?> clearfix" data-height="<?php echo esc_attr($page_title_height); ?>" <?php echo $article_heading_bg; ?>>
                <?php } ?>

                <?php if ( $page_title_style == "fancy" && $page_design_style == "hero-content-split" ) {
                	sf_post_split_heading_buttons();
                } ?>

                <?php if ( $page_title_style == "fancy-tabbed" ) { ?>
                <div class="tabbed-heading-wrap">
                <?php } ?>

                <div class="heading-text container" data-textalign="<?php echo esc_attr($page_title_text_align); ?>">
                    
                    <h1 class="entry-title"><?php echo $page_title; ?></h1>

                    <?php if ( $page_subtitle ) { ?>
                        <h3><?php echo $page_subtitle; ?></h3>
                    <?php } ?>

    				<?php if ( !$remove_breadcrumbs && $breadcrumb_in_heading ) {
    					echo sf_breadcrumbs( true );
    				} ?>

                    <?php if ( is_singular( 'gallery' ) && ! ( sf_theme_opts_name() == "sf_joyn_options" && $pagination_style == "fs-arrow" ) ) { ?>
                        <div
                            class="prev-item" <?php echo $article_heading_text; ?>><?php next_post_link( '%link', $prev_icon, false, '', 'gallery-category' ); ?></div>
                        <div
                            class="next-item" <?php echo $article_heading_text; ?>><?php previous_post_link( '%link', $next_icon, false, '', 'gallery-category' ); ?></div>
                    <?php } ?>

                </div>

                <?php if ( $page_title_style == "fancy-tabbed" ) { ?>
                </div>
                <?php } ?>

    			<?php if ($page_title_overlay_effect != "" && $page_title_overlay_effect != "none") { ?>

    				<div class="sf-canvas-effect" data-type="<?php echo esc_attr($page_title_overlay_effect); ?>">
    					<canvas id="page-heading-canvas" data-canvas_id="page-heading-canvas"></canvas>
    				</div>

    			<?php } ?>

                </div>

                </div>

            <?php } else { ?>

                <?php if ( $show_page_title == 2 ) { ?>
                    <div class="page-heading ph-sort clearfix" <?php echo $article_heading_bg; ?>>
                <?php } else { ?>
                    <div class="page-heading <?php echo esc_attr($page_heading_el_class); ?> clearfix" <?php echo $article_heading_bg; ?>>
                <?php } ?>
                <div class="container">
                    <div class="heading-text">

                        <?php if ( sf_woocommerce_activated() && is_woocommerce() ) { ?>

                            <?php if ( is_product() ) { ?>

                                <h1 class="entry-title" <?php echo $article_heading_text; ?>><?php echo esc_attr($page_title); ?></h1>

                            <?php } else { ?>

                                <h1 class="entry-title" <?php echo $article_heading_text; ?>><?php woocommerce_page_title(); ?></h1>

                            <?php } ?>

                        <?php } else if ( is_category() ) { ?>

                            <h1 <?php echo $article_heading_text; ?>><?php single_cat_title(); ?></h1>

                        <?php } else if ( is_archive() ) { ?>

                            <?php /* If this is a tag archive */
                            if ( is_tag() ) { ?>
                                <h1 <?php echo $article_heading_text; ?>><?php _e( "Posts tagged with", "swiftframework" ); ?>
                                    &#8216;<?php single_tag_title(); ?>&#8217;</h1>
                                <?php /* If this is a daily archive */
                            } elseif ( is_day() ) { ?>
                                <h1 <?php echo $article_heading_text; ?>><?php _e( "Archive for", "swiftframework" ); ?> <?php the_time( 'F jS, Y' ); ?></h1>
                                <?php /* If this is a monthly archive */
                            } elseif ( is_month() ) { ?>
                                <h1 <?php echo $article_heading_text; ?>><?php _e( "Archive for", "swiftframework" ); ?> <?php the_time( 'F, Y' ); ?></h1>
                                <?php /* If this is a yearly archive */
                            } elseif ( is_year() ) { ?>
                                <h1 <?php echo $article_heading_text; ?>><?php _e( "Archive for", "swiftframework" ); ?> <?php the_time( 'Y' ); ?></h1>
                                <?php /* If this is an author archive */
                            } elseif ( is_author() ) { ?>
                                <?php $author = get_userdata( get_query_var( 'author' ) ); ?>
                                <?php if ( class_exists( 'ATCF_Campaigns' ) ) { ?>
                                    <h1 <?php echo $article_heading_text; ?>><?php _e( "Projects by", "swiftframework" ); ?> <?php echo esc_attr($author->display_name); ?></h1>
                                <?php } else { ?>
                                    <h1 <?php echo $article_heading_text; ?>><?php _e( "Author archive for", "swiftframework" ); ?> <?php echo esc_attr($author->display_name); ?></h1>
                                <?php } ?>
                                <?php /* If this is a paged archive */
                            } elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) { ?>
                                <h1 <?php echo $article_heading_text; ?>><?php _e( "Blog Archives", "swiftframework" ); ?></h1>
                            <?php } else { ?>
                                <?php 
                                    $taxonomy_title = "";
                                    $taxonomy = $wp_query->get_queried_object();
                                    if ( $taxonomy && isset($taxonomy) && !empty($taxonomy) ) {
                                        $taxonomy_title = $taxonomy->name;
                                    }

                                ?>
                                <?php if ( $taxonomy_title != "" ) { ?>
                                    <h1 <?php echo $article_heading_text; ?>><?php echo $taxonomy_title; ?></h1>
                                <?php } else { ?>
                                    <h1 <?php echo $article_heading_text; ?>><?php post_type_archive_title(); ?></h1>
                                <?php } ?>
                            <?php } ?>

                        <?php } else if ( is_404() ) { ?>

                            <h1 class="entry-title" <?php echo $article_heading_text; ?>><?php _e( "404", "swiftframework" ); ?></h1>
    					
    					<?php } else if ( is_home() && get_option('page_for_posts') ) { ?>
    					
    					     <h1 class="entry-title" <?php echo $article_heading_text; ?>><?php echo apply_filters('the_title',get_page( get_option('page_for_posts') )->post_title); ?></h1>
    		
                        <?php } else { ?>

                            <h1 class="entry-title" <?php echo $article_heading_text; ?>><?php echo $page_title; ?></h1>

                        <?php } ?>

                    </div>

                    <?php if ( is_singular( 'gallery' ) && ! ( sf_theme_opts_name() == "sf_joyn_options" && $pagination_style == "fs-arrow" ) ) { ?>
                        <div class="next-item" <?php echo $article_heading_text; ?>><?php previous_post_link( '%link', $next_icon, false, '', 'gallery-category' ); ?></div>
                        <div class="prev-item" <?php echo $article_heading_text; ?>><?php next_post_link( '%link', $prev_icon, false, '', 'gallery-category' ); ?></div>
                    <?php } ?>

    				<?php if ( !$remove_breadcrumbs && $breadcrumb_in_heading ) {
    					echo sf_breadcrumbs( true );
    				} ?>

                    <?php if ( $shop_page && sf_theme_supports( 'page-heading-woocommerce' ) ) {
                        woocommerce_catalog_ordering();
                        woocommerce_result_count();
                    } ?>

                </div>
            </div>

            <?php 

                if ( function_exists('bcn_display') ) {
                    echo '<div class="row"><div class="container breadcrumbs-container"><div id="breadcrumbs">';
                    bcn_display();
                    echo '</div></div></div>';
                }

            }
        }
    }

?>