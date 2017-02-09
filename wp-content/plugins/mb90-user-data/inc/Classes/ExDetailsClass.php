<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExDetailsClass
 *
 * @author Rob O'Hea
 */
class ExDetailsClass extends UserFunctionsClass{

    // return the welcome header
    public static function getWelcomeHeader($page_slug)
    {
        global $current_user;
        //global $post;
        //$page_slug = $post->post_name;
        $headerHTML = "";
        // first check if the user has filled in profile info ... an auto redirect to the profile page will happen if not
        UserFunctionsClass::CheckUserAccountStatus();
        
        switch (strtolower($page_slug)) {
            case MB90_SELF_ASSESSMENT_PAGE_SLUG:
                $headerHTML .= UtilitiesClass::wrapInHTML(MB90_SELF_ASSESSMENT_PAGE_WELCOME_HTML, MB90_SELF_ASSESSMENT_PAGE_WELCOME . $current_user->first_name . "!");
                break;
            case MB90_10_DAY_CHALLENGE_PAGE_SLUG:
                $headerHTML .= UtilitiesClass::wrapInHTML(MB90_10_DAY_CHALLENGE_PAGE_WELCOME_HTML, MB90_10_DAY_CHALLENGE_PAGE_WELCOME . $current_user->first_name . "!");
                break;
            case MB90_WORKOUT_DAY_PAGE_SLUG:
                $headerHTML .= UtilitiesClass::wrapInHTML(MB90_WORKOUT_DAY_PAGE_WELCOME_HTML, MB90_WORKOUT_DAY_PAGE_WELCOME . $current_user->first_name . "!");
                break;
            default:
                $headerHTML .= UtilitiesClass::wrapInHTML(MB90_WORKOUT_DAY_PAGE_WELCOME_HTML, MB90_WORKOUT_DAY_PAGE_WELCOME . $current_user->first_name . "!");
        }
        
        echo strtoupper($headerHTML . "</br></br>");
    }
}
