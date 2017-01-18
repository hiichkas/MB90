<?php

require_once('dbase_include.php');

//global $progSelected;
$progSelected = $_REQUEST["progSelected"];
//$progSelected = 1;

$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$pageRows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 10;
$offset = ($page-1)*$pageRows;

//$progExercises = $wpdb->get_results("SELECT * FROM mb90_prog_exercises_translated WHERE ProgrammeID = " .$progSelected. " ORDER BY ProgrammeID, ExerciseDay limit $offset,$pageRows", OBJECT);
$exerciseMM = $wpdb->get_results("SELECT * FROM mb90_exercise_multimedia_translated WHERE ExerciseMMType='Image' ORDER BY ExerciseName", OBJECT);
//echo $_SERVER['DOCUMENT_ROOT'].'myBody90.com/wp-includes/wp-db.php';
if( $wpdb->num_rows > 0 )
{
    $rows = array();
    foreach( $exerciseMM as $key => $row)
    {
        $rows[] = $row;
    }

    header("Content-type: application/json");

    //$arr = mysql_fetch_array($recCount);

    $response = array("total" => $wpdb->num_rows, "rows" => $rows);

    echo json_encode($response);
    //echo json_encode($rows);
    //echo "SELECT * FROM mb90_prog_exercises_translated WHERE ProgrammeID = " .$progSelected. " ORDER BY ProgrammeID, ExerciseDay limit $offset,$pageRows";

}



?>
