<?php
session_start();

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

$wpIncludesPath = ABSPATH . 'wp-includes/'; // wordpress includes folder
require_once($wpIncludesPath . 'user.php');

$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$pageRows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 10;
$offset = ($page-1)*$pageRows;

$progExercises = $wpdb->get_results("SELECT * FROM mb90_user_assessment_translated WHERE UserID = ".$_SESSION["LoggedUserID"]." ORDER BY InputDate, ID", OBJECT);

if( $wpdb->num_rows > 0 )
{
    $rows = array();
    foreach( $progExercises as $key => $row)
    {
        $rows[] = $row;
    }

    header("Content-type: application/json");

    $response = array("total" => $wpdb->num_rows, "rows" => $rows);

    echo json_encode($response);
    //echo "startDate = [".$_startDate."]";
    
    //echo "SELECT * FROM mb90_user_challenge_translated WHERE UserID = ".$wpLoggedInUserID." ORDER BY ID";
    
}

?>
