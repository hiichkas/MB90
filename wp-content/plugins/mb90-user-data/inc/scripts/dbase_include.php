<?php

define( 'SHORTINIT', true );
$docRoot = $_SERVER['DOCUMENT_ROOT'];
$serverName = $_SERVER['SERVER_NAME'];

if( strpos($serverName, "localhost") === false && strpos($serverName, "127.0.0.1") === false){
    require_once( $docRoot . '/wp-load.php' );  
}
else{
    $url = $_SERVER['REQUEST_URI']; //returns the current URL
    $parts = explode('/',$url);
    $rootDir = $parts[1];
    require_once( $docRoot . '/' . $rootDir . '/wp-load.php' );
}


global $wpdb;
$wpIncludesPath = ABSPATH . 'wp-includes/'; // wordpress includes folder
require_once($wpIncludesPath . 'user.php');

function convertDateForDbase($date)
{
    $dateArr = split("/", $date);
    return $dateArr[2] . "-" . $dateArr[1] . "-" . $dateArr[0];
}


$pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';
require_once($pluginPath . 'inc/constants/constants.php');
    
?>
