<?php
    session_start();
    require_once('dbase_include.php');
    
    $formType = $_REQUEST["formType"];
    $formID = $_REQUEST["formNumber"];
    $date = $_REQUEST["date"];
    $numEntries = $_REQUEST["numEntries"]-1;
    $mode = $_REQUEST["mode"];
    
    $result = "";

    if( $mode == "add")
    {
        $result = "";
        if( $formType == "User10DayChallenge")
        {
            $inputRows = array();
            for($i = 0; $i <= $numEntries; $i ++)
            {
                $inputRows[] = array(
                    'UserID' => $_SESSION["LoggedUserID"],
                    'InputDate' => $date,
                    'ExerciseID' => $_REQUEST['ExerciseID_'.$formID.$i],
                    'Result' => $_REQUEST['Result_'.$formID.$i]
                );
            }
            //print_r($inputRows);
            foreach ( $inputRows as $inputRow ){
                $result .= $wpdb->insert( 'mb90_user_challenge_stats', $inputRow );
            }
                
        }
        else if( $formType == "UserSelfAssessment")
        {
            $inputRows = array();
            for($i = 0; $i <= $numEntries; $i ++)
            {
                $inputRows[] = array(
                    'UserID' => $_SESSION["LoggedUserID"],
                    'InputDate' => $date,
                    'ExerciseID' => $_REQUEST['ExerciseID_'.$formID.$i],
                    'Result' => $_REQUEST['Result_'.$formID.$i]
                );
            }
            //print_r($inputRows);
            foreach ( $inputRows as $inputRow ){
                $result .= $wpdb->insert( 'mb90_user_assessment_stats', $inputRow );
            }
        }
        else if( $formType == "UserBodyStats")
        {
            $inputRow = array(
                'UserID' => $_SESSION["LoggedUserID"],
                'InputDate' => $date
            );

            // now populate the input row with the key value pairs representing dbase column names and values
            for($i = 0; $i <= $numEntries; $i ++)
            {
                $fieldName = $_REQUEST['FieldName_'.$formID.$i];
                $value = $_REQUEST['Result_'.$formID.$i];
                $inputRow[$fieldName] = $value;
            }
            $result .= $wpdb->insert( 'mb90_user_bodystats', $inputRow );
        }
    }
    else // edit
    {
        if( $formType == "User10DayChallenge")
        {
            for($i = 0; $i <= $numEntries; $i ++){
                $result .= $wpdb->update( 
                    'mb90_user_challenge_stats', 
                    array( 
                        'UserID' => $_SESSION["LoggedUserID"],
                        'InputDate' => $date,
                        'ExerciseID' => $_REQUEST['ExerciseID_'.$formID.$i],
                        'Result' => $_REQUEST['Result_'.$formID.$i]
                    ),
                    array( 'ID' => $_REQUEST['ID_'.$formID.$i] )
                );
            }
        }
        else if( $formType == "UserSelfAssessment")
        {
            for($i = 0; $i <= $numEntries; $i ++){
                $result .= $wpdb->update( 
                    'mb90_user_assessment_stats', 
                    array( 
                        'UserID' => $_SESSION["LoggedUserID"],
                        'InputDate' => $date,
                        'ExerciseID' => $_REQUEST['ExerciseID_'.$formID.$i],
                        'Result' => $_REQUEST['Result_'.$formID.$i]
                    ),
                    array( 'ID' => $_REQUEST['ID_'.$formID.$i] )
                );
            }
        }
        else if( $formType == "UserBodyStats")
        {
            $idRow = array( 'ID' => $_REQUEST['ID_'.$formID.'0'] );
                    
            $inputRow = array(
                'UserID' => $_SESSION["LoggedUserID"],
                'InputDate' => $date
            );

            // now populate the input row with the key value pairs representing dbase column names and values
            for($i = 0; $i <= $numEntries; $i ++)
            {
                $fieldName = $_REQUEST['FieldName_'.$formID.$i];
                $value = $_REQUEST['Result_'.$formID.$i];
                $inputRow[$fieldName] = $value;
            }
            
            $result .= $wpdb->update( 
                'mb90_user_bodystats', 
                $inputRow,
                $idRow
            );
        }
    }
    
    echo $result;
    //echo "logged user = [" . $_SESSION["LoggedUserID"] . "]";
    //echo "numEntries = [".$numEntries."]";

?>
