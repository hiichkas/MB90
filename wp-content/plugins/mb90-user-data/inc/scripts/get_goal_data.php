<?php

require_once('dbase_include.php');

$progSelected = $_REQUEST["progSelected"];

$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$pageRows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 10;
$offset = ($page-1)*$pageRows;

//$progExercises = $wpdb->get_results("SELECT * FROM mb90_prog_exercises_translated WHERE ProgrammeID = " .$progSelected. " ORDER BY ProgrammeID, ExerciseDay limit $offset,$pageRows", OBJECT);
$progExercises = $wpdb->get_results("SELECT * FROM mb90_goals_translated WHERE ProgrammeID = " .$progSelected. " ORDER BY ID", OBJECT);

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
}



?>
