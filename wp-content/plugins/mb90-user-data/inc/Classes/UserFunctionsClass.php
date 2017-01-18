<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilitiesClass
 *
 * @author Rob O'Hea
 */
//$pluginDirPath = plugin_dir_path(dirname(__FILE__));
require_once(plugin_dir_path(dirname(__FILE__)) . "/Classes/UtilitiesClass.php"); 

class UserFunctionsClass extends UtilitiesClass{

    // check if user has filled profile yet
    public static function CheckUserAccountStatus()
    {
        session_start();
        if(!isset($_SESSION["LoggedUserID"]) || empty($_SESSION["LoggedUserID"])) {
            $wpLoggedInUserID = get_current_user_id();
            $_SESSION["LoggedUserID"] = $wpLoggedInUserID;
        }
        
        if(current_user_can('memberpress_product_authorized_' . MB90_90_DAY_COURSE_ID)) { // if user authorised for 90 day course

            $redirPath = UtilitiesClass::getRootURL();
            $userDetailsObj = new userDetails();

	    //echo "loggedUserID = [" . $_SESSION["LoggedUserID"] . "]";

            $userDetailsArr = $userDetailsObj->getUserDetails($_SESSION["LoggedUserID"]);

            if( count($userDetailsArr) === 0){ // if user details blank then redirect to account page
                redirectTo($redirPath . "account?filluserdetails=Y");
            }else{
                $_SESSION["UserStartDate"] = $userDetailsArr['userstartdate'];
            }
        }
    }
}
