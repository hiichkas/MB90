<?php
/**
* @package   Katana
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// check compatibility
if (version_compare(PHP_VERSION, '5.3', '>=')) {

    // bootstrap warp
    require(__DIR__.'/warp.php');
}

remove_filter('template_redirect','redirect_canonical');

function wpb_add_google_fonts() {

	wp_enqueue_style( 'wpb-google-fonts', 'http://fonts.googleapis.com/css?family=Raleway:400,700', false ); 
	
}

add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );
