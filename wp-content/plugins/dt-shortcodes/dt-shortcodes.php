<?php
/**
 * Plugin Name: DT Shortcodes
 * Plugin URI: http://diablothemes.com
 * Description: The DT Shortcodes plugin for Wordpress.
 * Version: 1.0
 * Author: DiabloThemes
 * Author URI: http://diablothemes.com
 * License: GPL2
 */
 
 // Constants
 
define('DTSC_TINYMCE_DIR', plugins_url('dt-shortcodes/tinymce/'));
 
// Get styles & scripts
function dt_shortcode_scripts() {
	if (!is_admin() && is_page('members/paulcotter/profile/')){
		wp_register_style('dt_shortcodes_css', plugins_url('assets/css/dt-shortcodes.css',__FILE__ ));
		wp_register_style('font-awesome', plugins_url('font-awesome/css/font-awesome.min.css',__FILE__ ));
		wp_register_style('qtip', plugins_url('assets/css/jquery.qtip.min.css',__FILE__ ));
		wp_enqueue_style('dt_shortcodes_css');
		wp_enqueue_style('font-awesome');
		wp_enqueue_style('qtip');
		
		wp_register_script( 'equalheightcolumns', plugins_url( 'assets/js/jquery.equalheightcolumns.js',__FILE__ ), array( 'jquery' ));
		wp_register_script( 'waypoints', plugins_url( 'assets/js/waypoints.min.js',__FILE__ ), array( 'jquery' ));
		wp_register_script( 'qtip', plugins_url( 'assets/js/jquery.qtip.min.js',__FILE__ ), array( 'jquery' ));
		wp_register_script( 'dt_shortcodes_js', plugins_url( 'assets/js/dt-shortcodes.js',__FILE__ ), array( 'jquery' ));
		wp_enqueue_script( 'equalheightcolumns' );
		wp_enqueue_script( 'waypoints' );
		wp_enqueue_script( 'qtip' );
		wp_enqueue_script( 'dt_shortcodes_js' );
		 	
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-tooltip' );
		wp_enqueue_script( 'jquery-effects-fade' ); 
		
	}
}
add_action( 'wp_enqueue_scripts', 'dt_shortcode_scripts' );

function dt_shortcodes_tinymce_css() {
	wp_register_style( 'dt-shortcodes-tinymce-btn', plugins_url('assets/css/tinymce-btn.css',__FILE__ ) );
	wp_enqueue_style( 'dt-shortcodes-tinymce-btn' );
}
add_action('admin_enqueue_scripts', 'dt_shortcodes_tinymce_css');

// Get shortcodes
require_once('shortcodes.php');

// TinyMCE

function register_dtsc_button($buttons) {
	array_push($buttons, 'dtsc_tinymce_button');
	return $buttons;
}

function add_dtsc_button_tinymce_plugin($plugin_array) {
	$plugin_array['dtsc_tinymce_button'] = DTSC_TINYMCE_DIR . 'dtsc_tinymce_button.js';
	return $plugin_array;
}
 
function dtsc_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;
 
	if ( get_user_option('rich_editing') == 'true') {
		
		wp_enqueue_script( 'jquery-core' );	
		wp_localize_script( 'jquery-core', 'DiabloShortcodes', array('tinymce_folder' => DTSC_TINYMCE_DIR) );	

		add_filter("mce_external_plugins", "add_dtsc_button_tinymce_plugin");
		add_filter('mce_buttons', 'register_dtsc_button');		
	}
}

add_action('init', 'dtsc_button');
 
