<?php
require_once($incPath . 'scripts/dbase_include.php');

class datagrid
{
    function getFormInputs($gridType)
    {
        
        $formInputHTML = "";
        if( $gridType == "Exercise")
        {
            $exerciseDropDown = $this->get_dropdown("exercise_types", "", "required='true'", "editable='false'");
            $workoutDayDropDown = $this->get_dropdown("workout_day", "", "required='true'", "editable='false'");
            //$programmeDropDownReadOnly = $this->get_dropdown("programme_exercises", "readonly", "required='true'");
            $selfAssessmentDropDown = $this->get_yesno_dropdown("SelfAssessment", "editable='false'");
            $TenDayChallengeDropDown = $this->get_yesno_dropdown("10DayChallenge", "editable='false'");
            //$formInputHTML .= '<div class="fitem"><label>Programme:</label>'.$programmeDropDownReadOnly.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Exercise:</label>'.$exerciseDropDown.'</div>';
            //$formInputHTML .= '<div class="fitem"><label>Exercise Day:</label><input name="ExerciseDay" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Workout Day:</label>' . $workoutDayDropDown . '</div>';
            //$formInputHTML .= '<div class="fitem"><label>Reps:</label><input name="Reps" class="easyui-textbox" required="true"></div>';
            //$formInputHTML .= '<div class="fitem"><label>Minutes for Reps:</label><input name="NumMinsForReps" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Self Assessment:</label>'.$selfAssessmentDropDown.'</div>';
            //$formInputHTML .= '<div class="fitem"><label>Self Assessment Phase:</label><input name="SelfAssessmentPhase" class="easyui-textbox"></div>';
            $formInputHTML .= '<div class="fitem"><label>10 Day Challenge:</label>'.$TenDayChallengeDropDown.'</div>';
            //$formInputHTML .= '<div class="fitem"><label>10 Day Challenge Phase:</label><input name="10DayChallengePhase" class="easyui-textbox"></div>';
            $formInputHTML .= '<div class="fitem"><label>Message:</label><textarea name="Message" class="easyui-textarea" required="true"></textarea></div>';
        }
        else if( $gridType == "Goal")
        {
            $exerciseDropDown = $this->get_dropdown("exercise_types", "", "required='true'");
            $programmeDropDownReadOnly = $this->get_dropdown("programme_exercises", "readonly", "required='true'");
            $formInputHTML .= '<div class="fitem"><label>Programme:</label>'.$programmeDropDownReadOnly.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Exercise:</label>'.$exerciseDropDown.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Reps:</label><input name="Reps" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Minutes for Reps:</label><input name="NumMins" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Message:</label><textarea name="Message" class="easyui-textarea" required="true"></textarea></div>';
        }
        else if( $gridType == "Diet")
        {
            $mealTypeDropDown = $this->get_dropdown("meal_type", "readonly", "required='true'", "editable='false'");
            $formInputHTML .= '<div class="fitem"><label>Meal Type:</label>'.$mealTypeDropDown.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Meal Name:</label><input name="MealName" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Ingredients:</label><textarea name="Ingredients" class="easyui-textarea" required="true"></textarea></div>';
            $formInputHTML .= '<div class="fitem"><label>Preparation:</label><textarea name="CookingInstructions" class="easyui-textarea"></textarea></div>';
            $formInputHTML .= '<div class="fitem"><label>Calorie Count:</label><input name="CalorieCount" class="easyui-textbox" required="true"></div>';
        }
        else if( $gridType == "ExerciseMultimedia")
        {
            $exerciseDropDown = $this->get_dropdown("exercise_types", "", "required='true'", "editable='false'");
            $mmTypeDropDown = $this->get_multimedia_type_dropdown("ExerciseMMType");
            $formInputHTML .= '<div class="fitem"><label>Exercise:</label>'.$exerciseDropDown.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Media Type:</label>'. $mmTypeDropDown .'</div>';
            $formInputHTML .= '<div class="fitem" id="videorow"><label>Video URL:</label><input id="ExerciseMMPathVideo" name="ExerciseMMPath" class="easyui-textbox" required="true"></div>';
//            $formInputHTML .= '<div class="fitem" id="imagerow"><label>Image Upload:</label><input class="easyui-filebox" id="ExerciseMMPathImage" name="ExerciseMMPath" data-options="prompt:\'Choose a file...\'" style="width:100%">';
            //$formInputHTML .= '<div class="fitem" id="imagerow"><label>Image Upload:</label><input type="file" id="ExerciseMMPathImage" name="ExerciseMMPathImage" data-options="prompt:\'Choose a file...\'" style="width:100%">';
            $formInputHTML .= '<div class="fitem" id="imagerow"><label>Image Upload:</label><input type="file" id="ExerciseMMPathImage" name="ExerciseMMPathImage" style="width:100%">';
            
            $formInputHTML .= '<div class="fitem" id="imagerow2"><label>Current Image:</label><input type="text" id="ExerciseMMPathCurrImage" /></div>';
            //<input name="ExerciseMMPath" class="easyui-textbox" required="true"></div>';
            //$formInputHTML .= '<label for="file">Filename:</label><input type="file" name="myfile" id="myfile">
            $formInputHTML .= '<div class="fitem"><label>Media Description:</label><input name="MediaDescription" class="easyui-textbox"></div>';
        }
        else if( $gridType == "ExerciseVideos")
        {
            $exerciseDropDown = $this->get_dropdown("exercise_types", "", "required='true'", "editable='false'");
            $formInputHTML .= '<div class="fitem" style="display:none"><label>Media Type:</label>'. $mmTypeDropDown .'</div>';
            $formInputHTML .= '<div class="fitem"><label>Exercise:</label>'.$exerciseDropDown.'</div>';
            $formInputHTML .= '<div class="fitem" id="videorow"><label>Video URL:</label><input id="ExerciseMMPath" name="ExerciseMMPath" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Video Description:</label><input name="MediaDescription" class="easyui-textbox"></div>';
            
        }
        else if( $gridType == "ExerciseImages")
        {
            $exerciseDropDown = $this->get_dropdown("exercise_types", "", "required='true'", "editable='false'");
            $formInputHTML .= '<div class="fitem"><label>Exercise:</label>'.$exerciseDropDown.'</div>';
            //$formInputHTML .= '<div class="fitem" id="imagerow"><label>Video URL:</label><input id="ExerciseMMPath" name="ExerciseMMPath" class="easyui-textbox" required="true"></div>';
            //$formInputHTML .= '<div class="fitem" id="imagerow"><label>Image Upload:</label><input class="easyui-filebox" id="ExerciseMMPathImage" name="ExerciseMMPath" data-options="prompt:\'Choose a file...\'" style="width:100%">';
            $formInputHTML .= '<div class="fitem" id="imagerow"><label>Image Upload:</label><input type="file" name="ExerciseMMPath" style="width:100%" value=""/>';
            $formInputHTML .= '<div class="fitem"><label>Image Description:</label><input name="MediaDescription" class="easyui-textbox"></div>';
            //$formInputHTML .= '<div class="fitem"><button id="upload-image">Upload/Change Image</button></div>';
        }
        
        return $formInputHTML;
    }
    
    function getGridHeader($gridType)
    {
        $headerHTML = "";
        if( $gridType == "Exercise")
        {
            $headerHTML .= '<th field="ProgrammeID" width="50" hidden="true">Programme ID</th>';
            //$headerHTML .= '<th field="ProgrammeType" width="30">Programme</th>';
            $headerHTML .= '<th field="ExerciseID" width="50" hidden="true">Exercise ID</th>';
            $headerHTML .= '<th field="ExerciseName" width="30">Exercise</th>';
            $headerHTML .= '<th field="ExerciseDay" width="50">Workout Day</th>';
            //$headerHTML .= '<th field="Reps" width="50">Reps</th>';
            //$headerHTML .= '<th field="NumMinsForReps" width="50">Minutes for Reps</th>';

            $headerHTML .= '<th field="SelfAssessment" width="25" >Self Assessment</th>';
            //$headerHTML .= '<th field="SelfAssessmentPhase" width="25">Assessment Phase</th>';
            $headerHTML .= '<th field="10DayChallenge" width="25" >10 Day Challenge</th>';
            //$headerHTML .= '<th field="10DayChallengePhase" width="25">Challenge Phase</th>';
            $headerHTML .= '<th field="Message" width="110">Message</th>';
        }
        else if( $gridType == "Goal")
        {
            $headerHTML .= '<th field="ProgrammeID" width="50" hidden="true">Programme ID</th>';
            $headerHTML .= '<th field="ProgrammeType" width="50">Programme</th>';
            $headerHTML .= '<th field="ExerciseID" width="50" hidden="true">Exercise ID</th>';
            $headerHTML .= '<th field="ExerciseName" width="50">Exercise</th>';
            $headerHTML .= '<th field="Reps" width="50">Reps</th>';
            $headerHTML .= '<th field="NumMins" width="50">Minutes for Reps</th>';
            $headerHTML .= '<th field="Message" width="50">Message</th>';
        }
        else if( $gridType == "Diet")
        {
            $headerHTML .= '<th field="DietMealTypeID" width="50" hidden="true">Meal Type ID</th>';
            $headerHTML .= '<th field="MealTypeName" width="50">Meal Type</th>';
            $headerHTML .= '<th field="ID" width="50" hidden="true">Diet ID</th>';
            $headerHTML .= '<th field="MealName" width="50">Meal Name</th>';
            $headerHTML .= '<th field="Ingredients" width="50">Ingredients</th>';
            $headerHTML .= '<th field="CookingInstructions" width="50">Preparation</th>';
            $headerHTML .= '<th field="CalorieCount" width="50">Calorie Count</th>';
        }     
        else if( $gridType == "ExerciseMultimedia")
        {
            $headerHTML .= '<th field="ID" width="50" hidden="true">Multimedia ID</th>';
            $headerHTML .= '<th field="ExerciseName" width="50">Exercise</th>';
            $headerHTML .= '<th field="ExerciseMMType" width="50">Media Type</th>';
            $headerHTML .= '<th field="ExerciseMMPath" width="50">Upload</th>';
            $headerHTML .= '<th field="MediaDescription" width="50">Media Description</th>';
        }
        else if( $gridType == "ExerciseVideos")
        {
            $headerHTML .= '<th field="ID" width="50" hidden="true">Video ID</th>';
            $headerHTML .= '<th field="ExerciseName" width="50">Exercise</th>';
            $headerHTML .= '<th field="ExerciseMMType" width="50" hidden="true">Media Type</th>';
            $headerHTML .= '<th field="ExerciseMMPath" width="50">Video URL</th>';
            $headerHTML .= '<th field="MediaDescription" width="50">Video Description</th>';
        }
        else if( $gridType == "ExerciseImages")
        {
            $headerHTML .= '<th field="ID" width="50" hidden="true">Image ID</th>';
            $headerHTML .= '<th field="ExerciseName" width="50">Exercise</th>';
            $headerHTML .= '<th field="ExerciseMMType" width="50" hidden="true">Media Type</th>';
            $headerHTML .= '<th field="ExerciseMMPath" width="50" height="50" data-options="formatter:formatcellImage">Image Upload</th>';
            $headerHTML .= '<th field="MediaDescription" width="50">Image Description</th>';
        }
        
        return $headerHTML;
    }
    
    function get_yesno_dropdown($name)
    {
        $ddHTML = '<select class="easyui-combobox" name="' . $name .'" style="width:200px;" required=true editable=false">';
        $ddHTML .= '<option value="">-- Please Select --</option>';
        $ddHTML .= '<option value="Y">Yes</option>';
        $ddHTML .= '<option value="N">No</option>';
        $ddHTML .= '</select>';
        return $ddHTML;
    }
    
    function get_multimedia_type_dropdown($name)
    {
        $ddHTML = '<select id="ExerciseMMType" class="easyui-combobox" name="' . $name .'" style="width:200px;" required=true editable=false >';
            //data-options="onSelect:function(record){
              //  processMMType(record.value)
            //}">';
            //url:'combobox_data.json',
            //valueField:'id',
            //textField:'text',
            //panelHeight:'auto',
            //onSelect:function(record){
              //  alert(record.text)
            //}"">';
        $ddHTML .= '<option value="">-- Please Select --</option>';
        $ddHTML .= '<option value="Image">Image</option>';
        $ddHTML .= '<option value="Video">Video</option>';
        $ddHTML .= '</select>';
        return $ddHTML;        
    }
    
    function get_dropdown($type, $readmode, $required, $editable)
    {
        global $wpdb;
        $orderByField = "";
        if( $type == "exercise_types")
        {
            $dropdownID = "ExerciseID";
            $tableID = "ID";
            $dropdownCaption = "ExerciseName";
            $tableName = "mb90_exercise_types";
            $orderByField = "ExerciseName";
        }
        else if($type == "programme_exercises")
        {
            $dropdownID = "ProgrammeID";
            $tableID = "ID";
            $dropdownCaption = "ProgrammeType";
            $tableName = "mb90_programmes";            
        }
        else if($type == "self_assessment")
        {
            $dropdownID = "SelfAssessment";
            $tableID = "ID";
            $dropdownCaption = "SelfAssessment";
            $tableName = "mb90_programmes";            
        }
        else if($type == "programme_exercises")
        {
            $dropdownID = "ProgrammeID";
            $tableID = "ID";
            $dropdownCaption = "ProgrammeType";
            $tableName = "mb90_programmes";            
        }
        else if($type == "meal_type")
        {
            $dropdownID = "MealTypeID";
            $tableID = "ID";
            $dropdownCaption = "MealType";
            $tableName = "mb90_diet_meal_types";            
        }
        else if($type == "workout_day")
        {
            $dropdownID = "WorkoutDay";
            //$tableID = "ID";
            $dropdownCaption = "Workout Day";
            $ddHTML = '<select class="easyui-combobox" name="' . $dropdownID .'" style="width:200px;" '.$required.' '.$editable.'>';

            $ddHTML .= '<option value="2">2</option>';
            $ddHTML .= '<option value="3">3</option>';
            $ddHTML .= '<option value="5">5</option>';
            $ddHTML .= '<option value="6">6</option>';
            $ddHTML .= '<option value="9">9</option>';

            $ddHTML .= '</select>';    
            return $ddHTML;
        }
        
        if( $orderByField == ""){
            $orderByField = $tableID;
        }
        //$ddHTML = '<select class="easyui-combobox" name="' . $dropdownID .'" style="width:200px;" ' . $readmode . '>';
        $ddHTML = '<select class="easyui-combobox" name="' . $dropdownID .'" style="width:200px;" '.$required.' '.$editable.'>';
        
        foreach( $wpdb->get_results("SELECT * FROM " . $tableName . " ORDER BY " . $orderByField) as $key => $row)
        { 
            $ddHTML .= '<option value="'.$row->$tableID.'">'.$row->$dropdownCaption.'</option>';
        }
        
        $ddHTML .= '</select>';

        return $ddHTML;

    }
    
    function uploadImageFile($fileName, $folderName)
    {
        $url = $_SERVER['REQUEST_URI']; //returns the current URL
        $parts = explode('/',$url);
        $rootDir = $parts[1];
        $docRootPath = $_SERVER['DOCUMENT_ROOT'];
        $target_dir = $docRootPath . $rootDir . "/wp-content/uploads/ExerciseImages/" . $folderName . "/";
        
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
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
