<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExerciseUtilitiesClass
 *
 * @author Rob O'Hea
 */
class ExerciseUtilitiesClass {
    //put your code here
    
    public static function getRootURL()
    {
        $path = get_site_url();
        return $path;
    }

    public static function getSiteRootPath()
    {
        $path = realpath(dirname(__FILE__));
        $rootURLArr = split("wp-content", $path);
        $urlPath = $_SERVER['REQUEST_URI'];
        $sep = "/";
        //$userIncPath = $rootURLArr[0] . $sep . "wp-content" . $sep . "plugins" . $sep . "mb90-user-data" . $sep;
        $userIncPath = $rootURLArr[0];
        
        return $userIncPath;
    }
    
    public static function getRootPath()
    {
        $path = realpath(dirname(__FILE__));
        $rootURLArr = split("wp-content", $path);
        $urlPath = $_SERVER['REQUEST_URI'];
        $sep = "/";
        $userIncPath = $rootURLArr[0] . $sep . "wp-content" . $sep . "plugins" . $sep . "mb90-user-data" . $sep;
        
        return $userIncPath;
    }
    
}
