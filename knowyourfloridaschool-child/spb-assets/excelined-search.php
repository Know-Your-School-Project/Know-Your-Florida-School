<?php

    /*
    *
    *	Swift Page Builder - Search Shortcode
    *	------------------------------------------------
    *	Swift Framework
    * 	Copyright Swift Ideas 2015 - http://www.swiftideas.com
    *
    */

    class SwiftPageBuilderShortcode_spb_search extends SwiftPageBuilderShortcode {

        protected function content( $atts, $content = null ) {

            $width = $title = $input_class = $el_class = $output = $search_form = $el_position = '';

            extract( shortcode_atts( array(
                'title'       => '',
                'el_position'       => '',
                'input_size'        => 'large',
                'width'             => '1/1',
                'twitter_username'  => '',
                'el_class'          => ''
            ), $atts ) );

            $input_class = 'input-large';

            $el_class = $this->getExtraClass( $el_class );
            $width    = spb_translateColumnWidthToSpan( $width );
            
            require_once( get_stylesheet_directory() . '/template-parts/page/settings/variables.php' );

            $search_form .= '<div class="search-form-container"><div class="search-form-loading"><div id="infscr-loading" class="first-page-loading" style="position:absolute;top:0px;left:0px;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div></div>';
            $search_form .= '<form method="get" class="search-form search-widget clearfix" action="">';
            $search_form .= '<a class="search-icon-position" href="#"><img class="inject-me" data-src="' . get_stylesheet_directory_uri() . '/images/icon-search.svg" /></a>';
            $search_form .= '<div id="locationField" class="clearfix"><div class="input-select"><select name="search">';
            $search_form .= '<option value="keyword" ';
            if ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "keyword" ) {
                $search_form .= 'selected="selected"';
            }
            $search_form .= '>School Name</option>';
            $search_form .= '<option value="geo" ';
            if ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "geo" ) {
                $search_form .= 'selected="selected"';
            }
            $search_form .= '>Address</option>';
            $search_form .= '<option value="district" ';
            if ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "district" ) {
                $search_form .= 'selected="selected"';
            }
            $search_form .= '>District</option>';
            $search_form .= '</select><div class="icon-select"></div></div>';

            // SCHOOL NAME FIELD
            $search_form .= '<input autocomplete="off" type="text" placeholder="Search By School Name" name="s" class="' . $input_class . '"';
            if ( isset($_GET["s"]) && !empty($_GET["s"]) && $_GET["s"] != "" ) {
                $search_form .= ' value="' . str_replace('"', "", stripslashes(rawurldecode($_GET["s"]))) . '"';
            } else {
                $search_form .= ' value=""';
            }
            if ( !isset($_GET["search"]) || empty($_GET["search"]) || ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "keyword" ) ) { } else {
                $search_form .= ' style="display:none;"';
            }
            $search_form .= ' />';

            // ADDRESS FIELD
            $search_form .= '<input autocomplete="off" type="text" placeholder="Search By Address, City, Zip" name="address" class="' . $input_class . '"';
            if ( isset($_GET["address"]) && !empty($_GET["address"]) && $_GET["address"] != "" ) {
                $search_form .= ' value="' . $_GET["address"] . '"';
            } else {
                $search_form .= ' value=""';
            }
            if ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "geo" ) { } else {
                $search_form .= ' style="display:none;"';
            }
            $search_form .= ' />';
            $search_form .= '<input type="hidden" name="recommended_address" value="';
            if ( isset($_GET["address"]) && $_GET["address"] != "" ) {
                $search_form .= $_GET["address"];
            }
            $search_form .= '" />';

            $search_form .= '<input autocomplete="off" type="text" placeholder="Search By District" name="districtid" class="' . $input_class . '"';
            if ( isset($_GET["districtid"]) && !empty($_GET["districtid"]) && $_GET["districtid"] != "" ) {
                $search_form .= ' value="' . $_GET["districtid"] . '"';
            } else {
                $search_form .= ' value=""';
            }
            if ( isset($_GET["search"]) && !empty($_GET["search"]) && $_GET["search"] == "district" ) { } else {
                $search_form .= ' style="display:none;"';
            }
            $search_form .= ' />';
            $search_form .= '<input type="hidden" name="recommended_district" value="';
            if ( isset($_GET["districtid"]) && $_GET["districtid"] != "" ) {
                $search_form .= $_GET["districtid"];
            }
            $search_form .= '" />';

            // HIDDEN FIELDS
            $search_form .= '<input type="hidden" name="sradius" value="';
            if ( isset($_GET["sradius"]) && $_GET["sradius"] != "" ) {
                $search_form .= $_GET["sradius"];
            }
            $search_form .= '" />';
            $search_form .= '<input type="hidden" name="lat" value="';
            if ( isset($_GET["lat"]) && $_GET["lat"] != "" ) {
                $search_form .= $_GET["lat"];
            }
            $search_form .= '" />';
            $search_form .= '<input type="hidden" name="long" value="';
            if ( isset($_GET["long"]) && $_GET["long"] != "" ) {
                $search_form .= $_GET["long"];
            }
            $search_form .= '" />';

            $search_form .= '</div>';
            $search_form .= '</form></div>';

            $output .= "\n\t" . '<div class="spb_search_widget spb_content_element ' . $width . $el_class . '">';
            $output .= "\n\t\t" . '<div class="spb-asset-content"><div>';

            $output .= "\n\t\t" . '<div>';
            $output .= ( $title != '' ) ? "\n\t\t\t" . $this->spb_title( $title, 'spb-text-heading' ) : '';
            $output .= "\n\t\t" . '</div>';

            $output .= "\n\t\t" . $search_form;
            $output .= "\n\t\t" . '</div></div>';
            $output .= "\n\t" . '</div> ' . $this->endBlockComment( $width );

            $output = $this->startRow( $el_position ) . $output . $this->endRow( $el_position );

            return $output;

        }
    }

    SPBMap::map( 'spb_search', array(
        "name"   => __( "Search", 'swift-framework-plugin' ),
        "base"   => "spb_search",
        "class"  => "spb_search",
        "icon"   => "spb-icon-search",
        "params" => array(
            array(
                "type"        => "textfield",
                "heading"     => __( "Widget title", 'swift-framework-plugin' ),
                "param_name"  => "title",
                "value"       => "",
                "description" => __( "Heading text should be no more than 5 words. Leave it empty if not needed.", 'swift-framework-plugin' )
            ),
            array(
                "type"        => "textfield",
                "heading"     => __( "Extra class", 'swift-framework-plugin' ),
                "param_name"  => "el_class",
                "value"       => "",
                "description" => __( "If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'swift-framework-plugin' )
            )
        )
    ) );