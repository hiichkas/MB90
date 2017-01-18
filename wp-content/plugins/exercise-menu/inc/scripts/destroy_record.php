<?php

    require_once('dbase_include.php');
    
    $recordType = $_REQUEST["recordType"];
    
    $recordID = $_REQUEST["id"];
    $ProgrammeID = $_REQUEST["ProgrammeID"];
    
    if( $recordType == "Exercise")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_prog_exercises', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_prog_exercises WHERE ProgrammeID = " . $ProgrammeID);
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
    else if( $recordType == "Goal")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_goals', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_goals WHERE ProgrammeID = " . $ProgrammeID);
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
    else if( $recordType == "Diet")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_diet', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_diet");
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
    else if( $recordType == "ExerciseMultimedia")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_exercise_multimedia', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_exercise_multimedia");
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
    else if( $recordType == "ExerciseVideos" || $recordType == "ExerciseImages")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_exercise_multimedia', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_exercise_multimedia");
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
    
?>
