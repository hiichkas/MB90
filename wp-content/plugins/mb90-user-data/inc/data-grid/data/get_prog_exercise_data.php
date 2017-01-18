<?php

define( 'SHORTINIT', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . 'myBody90.com/wp-load.php' );

global $wpdb;

//$progExercises = $wpdb->get_results("SELECT * FROM mb90_prog_exercises WHERE ProgrammeID = " .$progSelected. " ORDER BY ProgrammeID, ExerciseDay", OBJECT);
$progExercises = $wpdb->get_results("SELECT * FROM mb90_prog_exercises WHERE ProgrammeID = 1 ORDER BY ProgrammeID, ExerciseDay", OBJECT);

//echo $_SERVER['DOCUMENT_ROOT'].'myBody90.com/wp-includes/wp-db.php';
if( $wpdb->num_rows > 0 )
{
    $rows = array();
    foreach( $progExercises as $key => $row)
    {
        $rows[] = $row;
    }

    header("Content-type: application/json");

    //$arr = mysql_fetch_array($recCount);

    $response = array("totalCount" => $wpdb->num_rows, "records" => $rows);

    //echo json_encode($response);
    echo json_encode($rows);
}



?>
