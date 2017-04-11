<?php 

$url = explode("?", $_SERVER['REQUEST_URI']);
if ( count($url) > 1 ) {
	$param = "?".$url[1];
} else {
	$param = "?";
}
$url = $url[0];

if ( $url == "/search" || $url == "/search/" ){
	if ( strpos($param, '?s=') !== false || strpos($param, '&s=') !== false ) {
		$location = get_site_url()."/".$param;
	} else {
		$location = get_site_url()."/?s=";
	}
	wp_redirect( $location, 301 );
}

get_header(); ?>

    <div class="container">
        <?php
		    global $sf_options;
		    $error_content = __( $sf_options['404_page_content'], 'swiftframework' );
		?>

		<div class="help-text">
		    <h2><?php echo $error_content; ?></h2>
		</div>
    </div>

<?php get_footer(); ?>