<?php
/*
Plugin Name: User Body Data
Plugin URI: http://www.pagemasters.ie
Description: Exercise CMS Plugin
Author: Page Masters
Author URI: http://www.pagemasters.ie
*/

// Example 1 : WP Shortcode to display form on any page or post.

function show_user_bodydata_grid(){
    
    $incPath = "inc/";
    global $recordType;
    $recordType = "UserBodyData";
    include($incPath . 'user-data.php');
}

add_shortcode('user-bodydata', 'show_user_bodydata_grid');

function show_user_diet_grid(){
    
    $incPath = "inc/";
    global $recordType;

    $recordType = "UserDiet";
    include($incPath . 'user-data.php');
}

add_shortcode('user-dietdata', 'show_user_diet_grid');

function show_user_10daychallenge_grid(){
    
    $incPath = "inc/";
    global $recordType;
    global $showGraphs;

    $showGraphs = false; //set to true once dev is completed
    $recordType = "User10DayChallenge";
    //echo $incPath;
    include($incPath . 'user-data.php');
}

add_shortcode('user-10daychallenge-data', 'show_user_10daychallenge_grid');

function show_user_sa_grid(){ // self assessment
    
    $incPath = "inc/";
    global $recordType;

    $recordType = "UserSelfAssessment";
    include($incPath . 'user-data.php');
}

add_shortcode('user-sa-data', 'show_user_sa_grid');

?>