<?php

    /*
    *
    *	Swift Page Builder - Client Custom Shortcode
    *	------------------------------------------------
    *	Swift Framework
    * 	Copyright Swift Ideas 2015 - http://www.swiftideas.com
    *
    */

    if ( class_exists('SwiftPageBuilderShortcode') ) {

        /* DIVIDER ASSET
        ================================================== */

        class SwiftPageBuilderShortcode_excelined_divider extends SwiftPageBuilderShortcode {

            protected function content( $atts, $content = null ) {
                $with_line = $fullwidth = $type = $width = $el_class = $text = '';
                extract( shortcode_atts( array(
                    'with_line'     => '',
                    'type'          => 'standard',
                    'heading_text'  => '',
                    'top_margin'    => '0px',
                    'bottom_margin' => '30px',
                    'fullwidth'     => '',
                    'text'          => '',
                    'width'         => '1/1',
                    'el_class'      => '',
                    'el_position'   => ''
                ), $atts ) );

                $width = spb_translateColumnWidthToSpan( $width );

                $up_icon = apply_filters( 'sf_up_icon' , '<i class="ss-up"></i>' );

                $style = "margin-top: " . $top_margin . "; margin-bottom: " . $bottom_margin . ";";

                $output = '';
                $output .= '<div class="divider-wrap ' . $width . '">';
                if ( $type == "heading" ) {
                    $output .= '<div class="spb_divider ' . $el_class . '" style="' . $style . '">';
                    $output .= '<h3 class="divider-heading">' . $heading_text . '</h3>';
                    $output .= '</div>' . $this->endBlockComment( 'divider' ) . "\n";
                } else {
                    $output .= '<div class="spb_divider ' . $type . ' spb_content_element ' . $el_class . '" style="' . $style . '">';
                    if ( $type == "go_to_top" ) {
                        $output .= '<a class="animate-top" href="#">' . $text . '</a>';
                    } else if ( $type == "go_to_top_icon1" ) {
                        $output .= '<a class="animate-top" href="#">' . $up_icon . '</a>';
                    } else if ( $type == "go_to_top_icon2" ) {
                        $output .= '<a class="animate-top" href="#">' . $text . $up_icon . '</a>';
                    }
                    $output .= '</div>' . $this->endBlockComment( 'divider' ) . "\n";
                }

                $output .= '</div>';


                if ( $fullwidth == "yes" && $width == "col-sm-12" ) {
                    $output = $this->startRow( $el_position, '', true ) . $output . $this->endRow( $el_position, '', true );
                } else {
                    $output = $this->startRow( $el_position ) . $output . $this->endRow( $el_position );
                }

                return $output;
            }
        }

        SPBMap::map( 'excelined_divider', array(
            "name"        => __( "Divider", 'swift-framework-plugin' ),
            "base"        => "spb_divider",
            "class"       => "spb_divider",
            'icon'        => 'spb-icon-divider',
            "controls"    => '',
            "params"      => array(
                array(
                    "type"        => "dropdown",
                    "heading"     => __( "Divider type", 'swift-framework-plugin' ),
                    "param_name"  => "type",
                    "value"       => array(
                        __( 'Standard', 'swift-framework-plugin' )           => "standard"
                    ),
                    "description" => __( "Select divider type.", 'swift-framework-plugin' )
                ),
                array(
                    "type"        => "textfield",
                    "heading"     => __( "Top Margin", 'swift-framework-plugin' ),
                    "param_name"  => "top_margin",
                    "value"       => __( "0px", 'swift-framework-plugin' ),
                    "description" => __( "Set the margin above the divider (include px).", 'swift-framework-plugin' )
                ),
                array(
                    "type"        => "textfield",
                    "heading"     => __( "Bottom Margin", 'swift-framework-plugin' ),
                    "param_name"  => "bottom_margin",
                    "value"       => __( "30px", 'swift-framework-plugin' ),
                    "description" => __( "Set the margin below the divider (include px).", 'swift-framework-plugin' )
                ),
                array(
                    "type"        => "buttonset",
                    "heading"     => __( "Full width", 'swift-framework-plugin' ),
                    "param_name"  => "fullwidth",
                    "value"       => array(
                        __( 'No', 'swift-framework-plugin' )  => "no",
                        __( 'Yes', 'swift-framework-plugin' ) => "yes"
                    ),
                    "description" => __( "Select yes if you'd like the divider to be full width (only to be used with no sidebars, and with Standard/Thin/Dotted divider types).", 'swift-framework-plugin' )
                ),
                array(
                    "type"        => "textfield",
                    "heading"     => __( "Extra class", 'swift-framework-plugin' ),
                    "param_name"  => "el_class",
                    "value"       => "",
                    "description" => __( "If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'swift-framework-plugin' )
                )
            ),
            "js_callback" => array( "init" => "spbTextSeparatorInitCallBack" )
        ) );

        /* BUTTON ASSET
        ================================================== */

        class SwiftPageBuilderShortcode_excelined_button extends SwiftPageBuilderShortcode {

            public function content( $atts, $content = null ) {

                $title = $el_class = $width = $el_position = $inline_style = '';

                extract( shortcode_atts( array(
                    'button_size'       => 'standard',
                    'button_colour'     => 'grey',
                    'button_align'      => 'align-center',
                    'button_text'       => '',
                    'button_icon'       => '',
                    'button_link'       => '#',
                    'button_target'     => '_self',
                    'button_dropshadow' => 'no',
                    'animation'         => '',
                    'animation_delay'   => '',
                    'el_class'          => '',
                    'el_position'       => '',
                    'width'             => '1/2'
                ), $atts ) );

                $output = '';

                $el_class = $this->getExtraClass( $el_class );
                $width    = spb_translateColumnWidthToSpan( $width );

                $output .= "\n\t" . '<div class="spb_button_element sf-animation ' . $button_align . ' ' . $width . $el_class . '" data-animation="' . $animation . '" data-delay="' . $animation_delay . '">';
                $output .= "\n\t\t\t" . do_shortcode( '[sf_button colour="' . $button_colour . '" type="standard" size="' . $button_size . '" link="' . $button_link . '" target="' . $button_target . '" icon="' . $button_icon . '" dropshadow="' . $button_dropshadow . '"]' . $button_text . '[/sf_button]' );
                $output .= "\n\t" . '</div> ' . $this->endBlockComment( $width );

                $output = $this->startRow( $el_position ) . $output . $this->endRow( $el_position );

                return $output;
            }
        }

        $target_arr = array(
            __( "Same window", 'swift-framework-plugin' ) => "_self",
            __( "New window", 'swift-framework-plugin' )  => "_blank"
        );


        SPBMap::map( 'excelined_button', array(
                "name"          => __( "Button", 'swift-framework-plugin' ),
                "base"          => "spb_button",
                "class"         => "",
                "icon"          => "spb-icon-button",
                "wrapper_class" => "clearfix",
                "controls"      => "full",
                "params"        => array(
                    array(
                        "type"       => "dropdown",
                        "heading"    => __( "Button Size", 'swift-framework-plugin' ),
                        "param_name" => "button_size",
                        "value"      => array(
                            __( "Standard", 'swift-framework-plugin' ) => "standard",
                        )
                    ),
                    array(
                        "type"       => "dropdown",
                        "heading"    => __( "Button Colour", 'swift-framework-plugin' ),
                        "param_name" => "button_colour",
                        "value"      => array(
                            __( "Purple", 'swift-framework-plugin' )        => "purple",
                            __( "Aqua", 'swift-framework-plugin' )          => "aqua",
                            __( "Green", 'swift-framework-plugin' )         => "green",
                            __( "White Green", 'swift-framework-plugin' )   => "white-green",
                            __( "White Purple", 'swift-framework-plugin' )  => "white-purple",
                        )
                    ),
                    array(
                        "type"       => "dropdown",
                        "heading"    => __( "Button Alignment", 'swift-framework-plugin' ),
                        "param_name" => "button_align",
                        "value"      => array(
                            __( "Center", 'swift-framework-plugin' )                => "align-center",
                            __( "Left", 'swift-framework-plugin' )                => "align-left",
                            __( "Right", 'swift-framework-plugin' )                => "align-right",
                        )
                    ),
                    array(
                        "type"        => "textfield",
                        "heading"     => __( "Button Text", 'swift-framework-plugin' ),
                        "param_name"  => "button_text",
                        "holder"      => "div",
                        "value"       => "Button Text",
                        "description" => __( "Icon to the left of the title text. You can get the code from <a href='http://fortawesome.github.com/Font-Awesome/' target='_blank'>here</a>. E.g. fa-cloud", 'swift-framework-plugin' )
                    ),
                    array(
                        "type"       => "textfield",
                        "heading"    => __( "Button Link", 'swift-framework-plugin' ),
                        "param_name" => "button_link",
                        "value"      => "",
                    ),
                    array(
                        "type"       => "dropdown",
                        "heading"    => __( "Button Target", 'swift-framework-plugin' ),
                        "param_name" => "button_target",
                        "value"      => $target_arr
                    ),
                    array(
                        "type"       => "section",
                        "param_name" => "tb_animation_options",
                        "heading"    => __( "Animation Options", 'swift-framework-plugin' ),
                    ),
                    array(
                        "type"        => "dropdown",
                        "heading"     => __( "Intro Animation", 'swift-framework-plugin' ),
                        "param_name"  => "animation",
                        "value"       => spb_animations_list(),
                        "description" => __( "Select an intro animation for the text block that will show it when it appears within the viewport.", 'swift-framework-plugin' )
                    ),
                    array(
                        "type"        => "textfield",
                        "heading"     => __( "Animation Delay", 'swift-framework-plugin' ),
                        "param_name"  => "animation_delay",
                        "value"       => "0",
                        "description" => __( "If you wish to add a delay to the animation, then you can set it here (ms).", 'swift-framework-plugin' )
                    ),
                    array(
                        "type"       => "section",
                        "param_name" => "btn_misc_options",
                        "heading"    => __( "Misc Options", 'swift-framework-plugin' ),
                    ),
                    array(
                        "type"        => "textfield",
                        "heading"     => __( "Extra class", 'swift-framework-plugin' ),
                        "param_name"  => "el_class",
                        "value"       => "",
                        "description" => __( "If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'swift-framework-plugin' )
                    )
                )
            )
        );

    }

?>