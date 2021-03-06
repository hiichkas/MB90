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
    else if( $recordType == "UserDiet")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_user_diet', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_user_diet");
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
    else if( $recordType == "UserBodyData")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_user_bodystats', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_user_bodystats");
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
    else if( $recordType == "User10DayChallenge")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_user_challenge_stats', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_user_challenge_translated");
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
    else if( $recordType == "UserSelfAssessment")
    {
        $rowsDeletedCount = $wpdb->delete( 
                'mb90_user_assessment_stats', 
                array( 'ID' => $recordID )
        );
        if( $rowsDeletedCount > 0)
        {
            // hack - if no rows left then clear the data grid - this is not auto happening so forcing it by passing num rows back to ajax call
            $wpdb->get_results("SELECT * FROM mb90_user_assessment_translateds");
            $rowCount = $wpdb->num_rows;
            echo $rowCount;
        }
        else
            echo false;
    }
      
    
?>
