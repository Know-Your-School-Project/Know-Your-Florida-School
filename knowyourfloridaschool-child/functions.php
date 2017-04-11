<?php
	
	/*
	*
	*	Social Driver Functions - Child Theme
	*	------------------------------------------------
	*	These functions will override the parent theme
	*	functions. We have provided some examples below.
	*
	*
	*/
	
	
	/* REMOVE PAGE BUILDER ASSETS
	================================================== */
	function spb_remove_assets_client( $pb_assets ) {

        unset($pb_assets['tweets-slider']);
        unset($pb_assets['latest-tweets']);
        unset($pb_assets['googlechart']);
        unset($pb_assets['blog-grid']);
        unset($pb_assets['gmaps']);
        unset($pb_assets['divider']);
        unset($pb_assets['blog']);
        unset($pb_assets['counter']);
        unset($pb_assets['icon-boxes']);
        unset($pb_assets['search']);
        unset($pb_assets['widget-area']);
        // unset($pb_assets['contact_forms']);

		return $pb_assets;

	}
	add_filter( 'spb_assets_filter', 'spb_remove_assets_client' );	
	
	
	/* ADD PAGE BUILDER ASSETS
	================================================== */
	function spb_add_assets_client( $pb_assets ) {

        $path      = get_stylesheet_directory() . '/spb-assets/';
        $folders   = scandir( $path, 1 );
        foreach ( $folders as $file ) {
            if ( $file == '.' || $file == '..' || $file == '.DS_Store' || strpos($file,'.php') != true ) {
                continue;
            }
            $file               = substr( $file, 0, - 4 );
            $new_pb_assets[ $file ] = $path . $file . '.php' ;
        }

        $pb_assets = apply_filters( 'spb_assets_filter', $new_pb_assets );

        // Load Each Asset
        foreach ( $pb_assets as $asset ) {
            require_once( $asset );
        }

		return $pb_assets;

	}
    if ( is_admin() ) {
        add_action( 'admin_init', 'spb_add_assets_client', 2 );
    }
    if ( ! is_admin() ) {
        add_action( 'wp', 'spb_add_assets_client', 2 );
    }


	/* OVERRIDE REDUX THEME OPTIONS
	================================================== */
	if ( ! function_exists( 'add_another_section_client' ) ) {
		function add_another_section_client($sections){

		    return $sections;
		}
		// In this example OPT_NAME is the returned opt_name.
		add_filter("redux/options/sf_socialdriver_options/sections", 'add_another_section_client');
	}

	if ( ! function_exists( 'page_init' ) ) {
		function page_init() {
		     add_post_type_support( 'page', 'excerpt' );
		}
	}
	add_action( 'init', 'page_init' );


	/* THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
	================================================== */
	function custom_stylesheets() {
	   echo '<link rel="stylesheet" id="page-builder-assets-css" href="'.get_stylesheet_directory_uri().'/css/page-builder-assets.min.css" type="text/css" media="all">';
	}

	add_action('admin_head', 'custom_stylesheets');


    /* HIDE DASHBOARD OPTIONS
    ================================================== */
    if ( ! function_exists( 'hide_dash_options' ) ) {
        function hide_dash_options() {

            if ( is_user_logged_in() ) {
                
                echo '<style>';
                echo ' label[for="sf_page_subtitle"], #sf_page_subtitle, #sf_page_subtitle_description { display: none !important; } ';
                echo ' label[for="sf_show_subtitle_first"], #sf_show_subtitle_first, #sf_show_subtitle_first_description { display: none !important; } ';
                echo '</style>';
                
            }

        }
        add_action( 'admin_head', 'hide_dash_options' );
        add_action( 'wp_before_admin_bar_render', 'hide_dash_options' );
    }


    /* ADD MORE STYLE SHEETS
    ================================================== */
    if ( ! function_exists( 'client_scripts' ) ) {
	    function client_scripts() {

	        global $sf_options;

	        $enable_min_scripts = $sf_options['enable_min_scripts'];

            if ( $enable_min_scripts == true || $enable_min_scripts == 1 ) {
                /* MINIFIED */
                wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/css/style.min.css', array(), null, 'all' );
                wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri() . '/js/scripts.min.js', 'jquery', null, true );
            } else {
                wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/css/style.css', array(), null, 'all' );
                wp_enqueue_script( 'chosen', get_stylesheet_directory_uri() . '/js/chosen.jquery.min.js', 'jquery', null, true );
                wp_enqueue_script( 'd3', get_stylesheet_directory_uri() . '/js/d3.min.js', 'jquery', null, true );
                wp_enqueue_script( 'nv-d3', get_stylesheet_directory_uri() . '/js/nv.d3.js', 'jquery', null, true );
                wp_enqueue_script( 'highcharts-script', get_stylesheet_directory_uri() . '/js/highcharts.js', 'jquery', null, true );
                wp_enqueue_script( 'exporting-script', get_stylesheet_directory_uri() . '/js/exporting.js', 'jquery', null, true );
                wp_enqueue_script( 'regression-script', get_stylesheet_directory_uri() . '/js/regression.js', 'jquery', null, true );
                wp_enqueue_script( 'rangeslider', get_stylesheet_directory_uri() . '/js/rangeslider.min.js', 'jquery', null, true );
                wp_enqueue_script( 'search-script', get_stylesheet_directory_uri() . '/js/search.js', 'jquery', null, true );
                wp_enqueue_script( 'school-reportcards-script', get_stylesheet_directory_uri() . '/js/school-reportcards.js', 'jquery', null, true );
                wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri() . '/js/scripts.js', 'jquery', null, true );
            }    

            wp_enqueue_script( 'google-map', '//maps.google.com/maps/api/js?libraries=geometry,places&amp;key=AIzaSyAh5Cr40G-hvqiLmVWOkSs2RbW5AU9Pok8', 'jquery', null, true );

	    }

	    add_action( 'wp_enqueue_scripts', 'client_scripts', 100 );
	}
    
    if ( file_exists( get_stylesheet_directory() . '/template-parts/content/post-preview.php' ) ) { 
    	include_once( get_stylesheet_directory() . '/template-parts/content/post-preview.php' );
	}

    /**
     * Hide the main editor on defined pages
     * 
     * You can choose between page titles or page templates. Just set them 
     * accordingly like this:
     * 
     * define('EDITOR_HIDE_PAGE_TITLES', json_encode(array('Home', 'Some post archive', 'Some Listing')));
     * define('EDITOR_HIDE_PAGE_TEMPLATES', json_encode(array('template-of-something.php', 'archive-customposttype.php')));
     * 
     * 
     * @global string $pagenow
     * @return void
     */
    function atz_hide_editor() {
        global $pagenow;
        if(!('post.php' == $pagenow)){
            return;
        }
        
        // Get the Post ID.
        $post_id = filter_input(INPUT_GET, 'post') ? filter_input(INPUT_GET, 'post') : filter_input(INPUT_POST, 'post_ID');
        if(!isset($post_id)) {
            return;
        }

        // Hide the editor n State Summary, School Report Card, and School Compare Pages
        if( $post_id == 42 ) {
            remove_post_type_support('page', 'editor');
        }
    }
    add_action('admin_init', 'atz_hide_editor');
		
?>