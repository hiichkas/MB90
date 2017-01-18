<?php

    require_once('dbase_include.php');
    
    function getExDayTranslated($day)
    {
        if( $day == 'SA' ){
            $day = 1;
        }else if($day == '10 Day'){
            $day = 8;
        }
        return $day;
    }
    
    function getImageRootPath($folderName)
    {
        $url = $_SERVER['REQUEST_URI']; //returns the current URL
        $parts = explode('/',$url);
        $rootDir = $parts[1];
        $docRootPath = $_SERVER['DOCUMENT_ROOT'];
        if( $_SERVER['SERVER_NAME'] === "localhost")
            $target_dir = $docRootPath . $rootDir . "/wp-content/uploads/ExerciseImages/" . $folderName . "/";  
        else
            $target_dir = $docRootPath . "/" . $rootDir . "/uploads/ExerciseImages/" . $folderName . "/";  
        return $target_dir;
    }
    
    function getImageRootURL($folderName)
    {
        $url = $_SERVER['REQUEST_URI']; //returns the current URL
        $port = ":" . $_SERVER['SERVER_PORT'];
        if( $port === ":80"){
            $port = "";
        }
        $parts = explode('/',$url);
        $rootDir = $parts[1];
        $docRootPath = "http://" . $_SERVER['SERVER_NAME'] . $port;
        if( $_SERVER['SERVER_NAME'] === "localhost")
            $target_dir = $docRootPath . "/" . $rootDir . "/wp-content/uploads/ExerciseImages/" . $folderName . "/";
        else
            $target_dir = $docRootPath . "/" . $rootDir . "/uploads/ExerciseImages/" . $folderName . "/";
        return $target_dir;
    }
    
    function uploadImageFile($fileName, $folderName)
    {
        $target_dir = getImageRootPath($folderName);
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        
        $target_file = $target_dir . basename($_FILES[$fileName]["name"]);
        //return $target_file . "-" . $target_dir;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES[$fileName]["tmp_name"]);
            if($check !== false) {
                //return "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                return "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            return "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            return "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$fileName]["tmp_name"], $target_file)) {
                //return "The file ". basename( $_FILES["ExerciseMMPath"]["name"]). " has been uploaded.";
                return 1;
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        }
    }
    
    $recordType = $_REQUEST["recordType"];

    if( $recordType == "Exercise")
    {
        $exDayTranslated = getExDayTranslated($_REQUEST['ExerciseDay']);
        $result = $wpdb->insert( 
        'mb90_prog_exercises', 
            array( 
                //'ProgrammeID' => $_REQUEST['ProgrammeID'],
                'ProgrammeID' => 1,
                'OrderNumber' => $_REQUEST['OrderNumber'],
                'ExerciseID' => $_REQUEST['ExerciseID'],
                'ExerciseDay' => $exDayTranslated,
                //'Reps' => $_REQUEST['Reps'],
                //'NumMinsForReps' => $_REQUEST['NumMinsForReps'],
                'Message' => $_REQUEST['Message'],
                'SelfAssessment' => $_REQUEST['SelfAssessment'],
                //'SelfAssessmentPhase' => $_REQUEST['SelfAssessmentPhase'],
                '10DayChallenge' => $_REQUEST['10DayChallenge'],
                //'10DayChallengePhase' => $_REQUEST['10DayChallengePhase'],
                'Message' => $_REQUEST['Message']
            )
        );
    }
    else if( $recordType == "Goal")
    {
        $result = $wpdb->insert( 
        'mb90_goals', 
            array( 
                'ProgrammeID' => $_REQUEST['ProgrammeID'],
                'ExerciseID' => $_REQUEST['ExerciseID'],
                //'GoalName' => $_REQUEST['GoalName'],
                'Reps' => $_REQUEST['Reps'],
                'NumMins' => $_REQUEST['NumMins'],
                'Message' => $_REQUEST['Message']
            )
        );
    }
    else if( $recordType == "Diet")
    {
        $result = $wpdb->insert( 
            'mb90_diet', 
            array( 
                'MealType' => $_REQUEST['MealTypeID'],
                'MealName' => $_REQUEST['MealName'],
                'Ingredients' => $_REQUEST['Ingredients'],
                'CookingInstructions' => $_REQUEST['CookingInstructions'],
                'CalorieCount' => $_REQUEST['CalorieCount']
            )
        );
    }
    else if( $recordType == "ExerciseMultimedia")
    {
        //$wpdb->show_errors();
        $result = $wpdb->insert( 
            'mb90_exercise_multimedia', 
            array( 
                'ExerciseID' => $_REQUEST['ExerciseID'],
                'Type' => $_REQUEST['ExerciseMMType'],
                'Path' => $_REQUEST['ExerciseMMPath'],
                'Description' => $_REQUEST['MediaDescription']
            )
        );
        //$result = "'".$wpdb->last_query."'";
        
        //$result = "'success save'";
    }    
    else if( $recordType == "ExerciseVideos")
    {
        //$wpdb->show_errors();
        $result = $wpdb->insert( 
            'mb90_exercise_multimedia', 
            array( 
                'ExerciseID' => $_REQUEST['ExerciseID'],
                //'Type' => $_REQUEST['ExerciseMMType'],
                'Type' => 'Video',
                //'Path' => $_REQUEST['ExerciseMMPath'],
                'Path' => $wp_upload_dir['url'] . '/' . basename( $filename ),
                
                'Description' => $_REQUEST['MediaDescription']
            )
        );
        //$result = "'".$wpdb->last_query."'";
        
    }    
    else if( $recordType == "ExerciseImages")
    {

        //include($docRoot . $rootDir . 'wp-load.php');
        $imageUploadStatus = uploadImageFile("ExerciseMMPath", $_REQUEST['ExerciseID']);
        if( $imageUploadStatus === 1)
        {
            //$wpdb->show_errors();
            $result = $wpdb->insert( 
                'mb90_exercise_multimedia', 
                array( 
                    'ExerciseID' => $_REQUEST['ExerciseID'],
                    //'Type' => $_REQUEST['ExerciseMMType'],
                    'Type' => 'Image',
                    //'Path' => $_REQUEST['ExerciseMMPath'],
                    //'Path' => $wp_upload_dir['url'] . '/' . basename( $filename ),
                    'Path' => getImageRootURL($_REQUEST['ExerciseID']) . basename($_FILES["ExerciseMMPath"]["name"]),
                    'Description' => $_REQUEST['MediaDescription']
                )
            );
        }else{
            $result = '{"errorMsg":"' . $imageUploadStatus . '"}';
        }
        //$result = "'".$wpdb->last_query."'";
        
        //$result = "'".$wp_upload_dir['url'] . '/' . basename( $filename )."'";
        //$result = $er;
    }    
    
    echo $result;
    //echo "recordType = [".$recordType."]";


?>
