<!--<div id="mb90-load-cover"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>-->
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    global $post;
    $page_slug = $post->post_name; // used to process the appropriate page
        
    $pluginDirPath = plugin_dir_path(dirname(__FILE__));
    
    include($pluginDirPath . "../plugins/mb90-user-data/inc/Classes/UserFunctionsClass.php"); 
    include($pluginDirPath . "../plugins/mb90-user-data/inc/Classes/ExDetailsClass.php"); 
    
    $utilObj = UtilitiesClass::getRootPath();
    
    UserFunctionsClass::CheckUserAccountStatus(); // check if user has filled out profile details, redirect to profile page if not
    
    ExDetailsClass::getWelcomeHeader($page_slug); // print html for welcome header
    
    UtilitiesClass::GetTimerCss($page_slug);
    
    UtilitiesClass::GetDateLinks($page_slug); // print the date buttons for user to choose from
    
    //UtilitiesClass::AddAjaxLoader(); 
    
    UtilitiesClass::GetBlockDetails($page_slug); // get timings and exercises from dbase
    
    if( strtolower($page_slug) == MB90_WORKOUT_DAY_PAGE_SLUG) {
        //include($pluginDirPath . "../plugins/mb90-user-data/inc/scripts/workout-include.php"); 
        //echo "\r\n" . "<style>" . "\r\n" . ".outer-timer-wrapper{display:block !important}" . "\r\n" . "#exercise-summaryinfo-wrapper{display:block !important}" . "\r\n". "</style>" . "\r\n";
        echo "\r\n" . "<style>" . "\r\n" . ".outer-timer-wrapper{display:block !important}" . "\r\n". "</style>" . "\r\n";
    }
    
?>
