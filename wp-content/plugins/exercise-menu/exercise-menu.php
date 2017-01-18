<?php
/*
Plugin Name: Exercise CMS
Plugin URI: http://www.pagemasters.ie
Description: Exercise CMS Plugin
Author: Page Masters
Author URI: http://www.pagemasters.ie
*/

require_once(plugin_dir_path(dirname(__FILE__)) . "/exercise-menu/inc/Classes/ExerciseUtilitiesClass.php"); 
$docRoot = ExerciseUtilitiesClass::getSiteRootPath();

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new submenu under Settings:
    add_options_page(__('Exercise Settings','exercise-menu'), __('Test Settings','exercise-menu'), 'manage_options', 'testsettings', 'mt_settings_page');

    // Add a new submenu under Tools:
    add_management_page( __('Exercise Tools','exercise-menu'), __('Test Tools','exercise-menu'), 'manage_options', 'testtools', 'mt_tools_page');

    // Add a new top-level menu:
    //add_menu_page(__('Exercise CMS','exercise-menu'), __('Exercise CMS','exercise-menu'), 10, 'mt-top-level-handle', 'my_magic_function' );
    // call add_sub_menu to prevent the top level menu appearing in the sub menu
    //add_submenu_page('mt-top-level-handle', __('Exercise CMS','exercise-menu'), __('Exercises CMS','exercise-menu'), 10, 'mt-top-level-handle', 'my_magic_function');
    
    add_menu_page( __('Exercise CMS','exercise-menu'), __('Exercise CMS','exercise-menu'), 'manage_options', 'mt-top-level-handle', array( &$this, 'admin' ) );
    
//add_menu_page('Page title', 'Top-level menu title', 'manage_options', 'my-top-level-handle', 'my_magic_function');
//add_submenu_page( 'my-top-level-handle', 'Page title', 'Sub-menu title', 'manage_options', 'my-submenu-handle', 'my_magic_function');
    
    // Add a submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', __('Workouts','exercise-menu'), __('Workouts','exercise-menu'), 'manage_options', 'mt-top-level-handle', 'mt_toplevel_page');
    
    //add_submenu_page('mt-top-level-handle', __('Exercise Listing','exercise-menu'), __('Exercise Listing','exercise-menu'), 'manage_options', 'sub-exercise-listing', 'mt_sublevel_exercise_listing');
    
    //add_submenu_page('mt-top-level-handle', __('Exercise Multimedia','exercise-menu'), __('Exercise Multimedia','exercise-menu'), 'manage_options', 'sub-exercise-multimedia', 'mt_sublevel_exercise_multimedia');
    
    add_submenu_page('mt-top-level-handle', __('Exercise Images','exercise-menu'), __('Exercise Images','exercise-menu'), 'manage_options', 'sub-exercise-images', 'mt_sublevel_exercise_images');
    
    add_submenu_page('mt-top-level-handle', __('Exercise Videos','exercise-menu'), __('Exercise Videos','exercise-menu'), 'manage_options', 'sub-exercise-videos', 'mt_sublevel_exercise_videos');

    // Add a second submenu to the custom top-level menu:
    //add_submenu_page('mt-top-level-handle', __('Goals','exercise-menu'), __('Goals','exercise-menu'), 'manage_options', 'sub-goals', 'mt_sublevel_goals');
    
    //add_submenu_page('mt-top-level-handle', __('Motivation','exercise-menu'), __('Motivation','exercise-menu'), 'manage_options', 'sub-motivation', 'mt_sublevel_motivation');
    
    add_submenu_page('mt-top-level-handle', __('Diet','exercise-menu'), __('Diet','exercise-menu'), 'manage_options', 'sub-diet', 'mt_sublevel_diet');
    
    //add_submenu_page('mt-top-level-handle', __('Documents','exercise-menu'), __('Documents','exercise-menu'), 'manage_options', 'sub-documents', 'mt_sublevel_documents');
    
    //add_submenu_page('mt-top-level-handle', __('Videos','exercise-menu'), __('Videos','exercise-menu'), 'manage_options', 'sub-videos', 'mt_sublevel_videos');
    
    remove_submenu_page( 'mt-top-level-handle', 'my_subpage_1');
}

// mt_settings_page() displays the page content for the Test settings submenu
function mt_settings_page() {
    echo "<h2>" . __( 'Exercise Settings', 'exercise-menu' ) . "</h2>";
}

// mt_tools_page() displays the page content for the Test Tools submenu
function mt_tools_page() {
    echo "<h2>" . __( 'Exercise Tools', 'exercise-menu' ) . "</h2>";
}

// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function mt_toplevel_page() {
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/exercises.php');
    //include($docRoot.'\wp-content\plugins\exercise-menu\inc\exercises.php');
}

// mt_sublevel_page() displays the page content for the first submenu
// of the custom Test Toplevel menu
function mt_sublevel_page() {
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/exercises.php');
}

function mt_sublevel_exercise_listing() {
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/exercise_listing.php');
}

function mt_sublevel_exercise_multimedia() {
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/exercise_multimedia.php');
}

function mt_sublevel_exercise_videos() {
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/exercise_videos.php');
}

function mt_sublevel_exercise_images() {
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/exercise_images.php');
}

// mt_sublevel_page2() displays the page content for the second submenu
// of the custom Test Toplevel menu
function mt_sublevel_goals() {
//    include('..\wp-content\plugins\exercise-menu\inc\goals.php');
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/goals.php');

}

function mt_sublevel_motivation() {
//    include('..\wp-content\plugins\exercise-menu\inc\motivation.php');
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/motivation.php');

}

function mt_sublevel_diet() {
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/diet.php');
    //include('..\wp-content\plugins\exercise-menu\inc\diet.php');
}

function mt_sublevel_documents() {
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/documents.php');
    //include('..\wp-content\plugins\exercise-menu\inc\documents.php');
}

function mt_sublevel_videos() {
    //include('..\wp-content\plugins\exercise-menu\inc\videos.php');
    global $docRoot;
    include($docRoot.'/wp-content/plugins/exercise-menu/inc/videos.php');
}

?>