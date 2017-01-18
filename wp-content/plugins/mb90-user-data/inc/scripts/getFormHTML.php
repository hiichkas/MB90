<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];
$serverName = $_SERVER['SERVER_NAME'];

if( strpos($serverName, "localhost") === false && strpos($serverName, "127.0.0.1") === false){
    require_once( $docRoot . '/wp-config.php' );  
}
else{
    $url = $_SERVER['REQUEST_URI']; //returns the current URL
    $parts = explode('/',$url);
    $rootDir = $parts[1];
    require_once( $docRoot . '/' . $rootDir . '/wp-config.php' );
}


$pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';
require_once($pluginPath . 'inc/Classes/DataGridClass.php');

$formType = $_REQUEST["formName"];
$formMode = $_REQUEST["mode"];

$formBuilderObj = new datagrid();
$formHTML = $formBuilderObj->getHtmlFormInputs($formType, $mode);

echo $formHTML;

?>
