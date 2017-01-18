<?php

    global $wpdb;

    /*
    $ProgrammeID = $_REQUEST['ProgrammeID'];
    $ExerciseID = $_REQUEST['ExerciseID'];
    $ExerciseDay = $_REQUEST['ExerciseDay'];
    $Reps = $_REQUEST['Reps'];

    $NumMinsForReps = $_REQUEST['NumMinsForReps'];
    $Message = $_REQUEST['Message'];
    $SelfAssessment = $_REQUEST['SelfAssessment'];
    $TenDayChallenge = $_REQUEST['10DayChallenge'];
    $TenDayChallengePhase = $_REQUEST['10DayChallengePhase'];
     * 
     */

    //$sql = "insert into mb90_prog_exercises values('$ProgrammeID','$ExerciseID','$ExerciseDay','$Reps','$NumMinsForReps','$Message','$SelfAssessment','$TenDayChallenge','$TenDayChallengePhase')";
    
    
    $wpdb->insert( 
            'mb90_prog_exercises', 
            array( 
                'ProgrammeID' => $_REQUEST['ProgrammeID'],
                'ExerciseID' => $_REQUEST['ExerciseID'],
                'ExerciseDay' => $_REQUEST['ExerciseDay'],
                'Reps' => $_REQUEST['Reps'],
                'NumMinsForReps' => $_REQUEST['NumMinsForReps'],
                'Message' => $_REQUEST['Message'],
                'SelfAssessment' => $_REQUEST['SelfAssessment'],
                'TenDayChallenge' => $_REQUEST['10DayChallenge'],
                'TenDayChallengePhase' => $_REQUEST['10DayChallengePhase']
            )
    );


?>
