<?php

    require_once('dbase_include.php');
    
    $recordType = $_REQUEST["recordType"];
    $recordID = $_REQUEST['id'];
    
    if( $recordType == "Exercise")
    {
        $result = $wpdb->update( 
            'mb90_prog_exercises', 
            array( 
                'ProgrammeID' => $_REQUEST['ProgrammeID'],
                'ExerciseID' => $_REQUEST['ExerciseID'],
                'ExerciseDay' => $_REQUEST['ExerciseDay'],
                'Reps' => $_REQUEST['Reps'],
                'NumMinsForReps' => $_REQUEST['NumMinsForReps'],
                'Message' => $_REQUEST['Message'],
                'SelfAssessment' => $_REQUEST['SelfAssessment'],
                '10DayChallenge' => $_REQUEST['10DayChallenge'],
                '10DayChallengePhase' => $_REQUEST['10DayChallengePhase']
            ),
            array( 'ID' => $recordID )
    );
    }
    else if( $recordType == "Goal")
    {
        $result = $wpdb->update( 
            'mb90_goals', 
            array( 
                'ProgrammeID' => $_REQUEST['ProgrammeID'],
                'ExerciseID' => $_REQUEST['ExerciseID'],
                //'GoalName' => $_REQUEST['GoalName'],
                'Reps' => $_REQUEST['Reps'],
                'NumMins' => $_REQUEST['NumMins'],
                'Message' => $_REQUEST['Message']
            ),
            array( 'ID' => $recordID )
        );
    }
    else if( $recordType == "UserDiet")
    {
        $result = $wpdb->update( 
            'mb90_user_diet', 
            array( 
                'UserID' =>  $_REQUEST['UserID'],
                'MealType' => $_REQUEST['MealTypeID'],
                'MealName' => $_REQUEST['MealName'],
                'Ingredients' => $_REQUEST['Ingredients'],
                'CookingInstructions' => $_REQUEST['CookingInstructions'],
                'CalorieCount' => $_REQUEST['CalorieCount']
            ),
            array( 'ID' => $recordID )
        );
    }
    else if( $recordType == "UserBodyData")
    {
        $result = $wpdb->update( 
            'mb90_user_bodystats', 
            array( 
                'UserID' =>  $_REQUEST['UserID'],
                'InputDate' => convertDateForDbase($_REQUEST['InputDate']),
                //'InputDate' => "2015/01/01",
                'Weight' => $_REQUEST['Weight'],
                'ActivityLevel' => "",
                'RightArm' => $_REQUEST['RightArm'],
                'LeftArm' => $_REQUEST['LeftArm'],
                'Chest' => $_REQUEST['Chest'],
                'Navel' => $_REQUEST['Navel'],
                'Hips' => $_REQUEST['Hips'],
                'RightLegUpper' => $_REQUEST['RightLegUpper'],
                'RightLegThigh' => $_REQUEST['RightLegThigh'],
                'RightLegCalf' => $_REQUEST['RightLegCalf'],
                'LeftLegUpper' => $_REQUEST['LeftLegUpper'],
                'LeftLegThigh' => $_REQUEST['LeftLegThigh'],
                'LeftLegCalf' => $_REQUEST['LeftLegCalf']
            ),
            array( 'ID' => $recordID )
        );
    }
    else if( $recordType == "User10DayChallenge")
    {
        $result = $wpdb->update( 
            'mb90_user_challenge_stats', 
            array( 
                'UserID' => $_REQUEST['UserID'],
                'InputDate' => convertDateForDbase($_REQUEST['InputDate']),
                'ExerciseID' => $_REQUEST['ExerciseID'],
                'Result' => $_REQUEST['Result']
            ),
            array( 'ID' => $recordID )
        );
    }
    else if( $recordType == "SelfAssessment")
    {
        $result = $wpdb->update( 
            'mb90_user_assessment_stats', 
            array( 
                'UserID' => $_REQUEST['UserID'],
                'InputDate' => convertDateForDbase($_REQUEST['InputDate']),
                'ExerciseID' => $_REQUEST['ExerciseID'],
                'Result' => $_REQUEST['Result']
            ),
            array( 'ID' => $recordID )
        );
    }

    echo $result;
    
?>
