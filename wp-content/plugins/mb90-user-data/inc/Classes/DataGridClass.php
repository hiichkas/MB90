<?php
session_start();
$pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';

require_once($pluginPath . '/inc/scripts/dbase_include.php');

global $wpdb;

class userDetails
{
    function getUserDetails($userID)
    {
        //echo "SELECT * from mb90_user_details_translated WHERE UserID = ".$userID;
        global $wpdb;
        $userDetsArr = array();
        //echo "SELECT * from mb90_user_details_translated WHERE UserID = ".$userID;
        foreach( $wpdb->get_results("SELECT * from mb90_user_details_translated WHERE UserID = ".$userID) as $key => $row)
        { 
            //echo "...".$row.DisplayName."...";
            $userDetsArr[0]['userrecordid'] = $row->UserRecordID;
            $userDetsArr[0]['username'] = $row->DisplayName;
            $userDetsArr[0]['useremail'] = $row->Email;
            $userDetsArr[0]['userprogrammeid'] = $row->ProgrammeID;
            $userDetsArr[0]['userprogrammetype'] = $row->ProgrammeType;
            $userDetsArr[0]['userstartdate'] = $row->StartDate;
            $userDetsArr[0]['userweight'] = $weight = $row->Weight;
            $userDetsArr[0]['userage'] = $age = $row->Age;
            $userDetsArr[0]['userdob'] = $row->DOB;
            $userDetsArr[0]['userfeepaid'] = $row->FeePaid;
            $userDetsArr[0]['usersex'] = $sex = $row->UserSex;
            $userDetsArr[0]['userheight'] = $height = $row->Height;
            $userDetsArr[0]['useractivitylevel'] = $activityFactor = $row->ActivityLevelMultiplier;
            
            $userDetsArr[0]['userBMI'] = $bmi = $this->getBMI($weight, $height);
            $userDetsArr[0]['userBMR'] = $bmr = $this->getBMR($weight, $height, $age, $sex);
            $userDetsArr[0]['userTDEE'] = $tdee = $this->getTDEE($bmr, $activityFactor);
            
        }        
        return $userDetsArr[0];
    }

    function getWeightInputHTML($startDate, $userID)
    {
        global $wpdb;
        $userDetsArr = array();
        
        $chartObj = new chartFunctions();
    
        $html .= $chartObj->getWeightGraph();
        
        $html .= '<table class="weight-fields"><tbody>';
        $html .= '<tr><td colspan="2"><div id="mp-errormessage-weights"></div></td></tr>';
        
        //echo "SELECT * from mb90_user_details_translated WHERE UserID = ".$userID;
        $bodyStatsRecords = $wpdb->get_results("SELECT * from mb90_user_bodystats WHERE UserID = ".$userID." ORDER BY InputDate ASC");
        //return "bs = [" . $bodyStatsRecords . "]";
        if( count($bodyStatsRecords) > 0){
            $count = 1;
            foreach( $bodyStatsRecords as $key => $row)
            { 
                //$row->Weight;
                if( $count == 1){
                    $html .= '<tr><td class="label"><div class="mp_tablesubcaption bold-subcaption">Start Weight : ' . date("d/m/Y", strtotime($row->InputDate)) . '</div></td>';                    
                    $html .= '<td class="data"><div class="mp_tablecontent bold-subcaption leftpad-subcaption">' . $row->Weight . '<input type="hidden" id="weight_'. $count .'" value="' . $row->Weight . '" /></div></td></tr>';
                }else{
                    $html .= '<tr><td class="label"><div class="mp_tablesubcaption">End of Phase ' . ($count-1) . ' : ' . date("d/m/Y", strtotime($row->InputDate)) . '</div></td>';
                    $html .= '<td class="data"><div class="mp_tablecontent"><input type="text" id="weight_'. $count .'" value="' . $row->Weight . '" /></div></td></tr>';
                }
                $count ++;
            }
            // now add on extra row for next phase date
            if(count($bodyStatsRecords) < MB90_NUM_PHASES){ // only add next phase weight input if we haven't already displayed all phases including the start weight
                $nextPhaseEndDate = date("d/m/Y", strtotime($row->InputDate. ' + 10 days'));
                $html .= '<tr><td class="label"><div class="mp_tablesubcaption">End of Phase ' . ($count-1) . ' : ' . $nextPhaseEndDate . '</div></td>';
                $html .= '<td class="data"><div class="mp_tablecontent"><input type="text" id="weight_'. $count .'" value="" /></div></td></tr>';
            }

        }else{
            
        }
        $html .= '<tr><td colspan=2><input type="button" id="saveweights" value="Save Weights" /></td></tr>';
        $html .= '</tbody></table>';
        
        return $html;
    }
    
    function getDaysBetweenDates($startDate, $endDate)
    {
        //$now = time(); // or your date as well
        $start_date = strtotime($startDate);
        //$end_date = strtotime($endDate);
        $end_date = $endDate;
        $datediff = $end_date - $start_date;
        return ceil($datediff/(60*60*24));
    }
    
    function getActivityLevelDropDownHTML($selectedValue)
    {
        //$activityCaptionArr = array("little or no exercise, desk job", "light exercise or sports 1-3 days/wk", "moderate exercise or sports 3-5 days/wk", "hard exercise or sports 6-7 days/wk", "hard daily exercise or sports & physical labor job");
        $activityCaptionArr = array("little or no exercise, desk job", "light exercise or sports 1-3 days/wk");
        //$activityValueArr = array("1.200", "1.375", "1.550", "1.725", "1.900");
        $activityValueArr = array("1.200", "1.375");

        $html = "<select id='useractivitylevel'><option value='-1'>--Please Select--</option>";
        $count = 0;
        foreach($activityCaptionArr as $caption){
            if( $activityValueArr[$count] === $selectedValue ){
                $html .= "<option value='" . $activityValueArr[$count] . "' SELECTED>" . $caption . "</option>";
            }else{
                $html .= "<option value='" . $activityValueArr[$count] . "'>" . $caption . "</option>";
            }
            $count ++;
        }

        $html .= "</select>";
        return $html;
    }
    
    function getSexDropDownHTML($selectedValue)
    {
        $maleSelected = "";
        $femmaleSelected = "";
        $html = "<select id='usersex'>";
        
        if( $selectedValue !== false){
            if( strtolower($selectedValue) === "male"){
                $maleSelected = "SELECTED";
            }
            else{
                $femmaleSelected = "SELECTED";
            }
        }
        $html .= "<option value='-1'>--Please Select--</option><option value='Male' $maleSelected>Male</option><option value='Female' $femmaleSelected>Female</option>";
        $html .= "</select>";
        return $html;
    }
    
    function getBMI($weight, $height)
    {
        $height = $height / 100;
        // weight in kg / (height in meters * height in meters)
        return round($weight / ($height * $height), 1);
    }
    
    function getBMR($weight, $height, $age, $sex)
    {
        //For men: BMR = 10 x weight (kg) + 6.25 x height (cm) – 5 x age (years) + 5
        //For women: BMR = 10 x weight (kg) + 6.25 x height (cm) – 5 x age (years) – 161
        if( $sex == "Male"){
            return (10*$weight) + (6.25 * $height) - (5*$age) + 5;
        }else{
            return (10*$weight) + (6.25 * $height) - (5*$age) - 161;
        }
        //return 0;
    }
    
    function getTDEE($bmr, $activityFactor)
    {
        return( $bmr * $activityFactor);
    }
    
}

class datagrid
{
    function getHtmlFormInputs($formType, $mode)
    {
        global $wpdb;
        if( $formType == "User10DayChallenge" || $formType == "SelfAssessment" || $formType == "UserBodyData")
        {
            $formArray = array();
            $programmeID = $_SESSION["UserProgrammeID"];
            
            if( $formType == "User10DayChallenge" ){
                $challengePhase = $this->getChallengePhase("10Day");
                $dataViewName = "mb90_user_challenge_translated";
                //$exerciseViewName = "mb90_prog_exercises_translated_frontend";
                $exerciseViewName = "mb90_prog_exercises_days";
                $phaseFilterField = "10DayChallengePhase";
            }
            else if($formType == "SelfAssessment"){
                $challengePhase = $this->getChallengePhase("Assessment");
                $dataViewName = "mb90_user_assessment_translated";
                //$exerciseViewName = "mb90_prog_exercises_translated_frontend";
                $exerciseViewName = "mb90_prog_exercises_days";
                $phaseFilterField = "SelfAssessmentPhase";
            }
            else if($formType == "UserBodyData"){
                $challengePhase = $this->getChallengePhase("UserBodyData");
                //return "cp = [" . $challengePhase . "]";
                $dataViewName = "mb90_user_bodystats";
                $exerciseViewName = "mb90_prog_exercises_translated_frontend";
                $phaseFilterField = "UserBodyStatsPhase";
            }
            
            //echo "challenge phase = [" . $challengePhase . "]";
            
            // get those challenges/assessments where the user has entered data

            $completedChallenges = $wpdb->get_results("SELECT * FROM ".$dataViewName." WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID", OBJECT);
            if( $wpdb->num_rows > 0 )
            {
                $rows = array();
                foreach( $completedChallenges as $key => $row)
                {
                    $challengeCompletionDates[] = $row->InputDate;
                }
            }
            
            // setup arrays for populating hidden vars and captions for blank forms when adding the 1st data
            $labelArr = array();
            $exerciseIdArr = array();
            $measurementTypeArr = array();
            $todayProcessed = false;
            $addFormForToday = false;
            //echo "<br />cp = [".$challengePhase."]<br />";
            // now to get each challenge/assessment phase form inputs loop using this count
            $populatedFormNumber = 0;
            $isPopulatedForm = false;
            // for each phase ... check if data exists ... if so then generate form markup with data, else generate blank form
            for($phaseCount = 0; $phaseCount < $challengePhase; $phaseCount ++)
            {
                $formInputHTML = "";
                $isPopulatedForm = false;
                $whereClause = " WHERE ProgrammeID = " . $programmeID ." AND ".$phaseFilterField." = " . ($phaseCount+1);
                $exerciseCount = 0;
                $divWrapperStart = '<div class="mb90-formRowWrapper">';
                $divWrapperEnd = '</div>';
                $inputDate = "";
                $formCount = 0;
                $bodyStatCount = 0;

                $challengeCompletionDate = $challengeCompletionDates[$phaseCount];
                $dataFoundForPhase = false;

                $todayChallengeDate = date("Y-m-d", strtotime("now"));
                $challengeObj = new Assessments();
                $allChallengeDates = $challengeObj->getAllChallengeDates($_SESSION["UserStartDate"], $formType);

                /*if( in_array($todayChallengeDate, $allChallengeDates) && !in_array($todayChallengeDate, $challengeCompletionDates) && $todayProcessed === false)
                {
                    $addFormForToday = true;
                }*/
                if( count($challengeCompletionDates) > 0 && strlen($challengeCompletionDate) > 0) // if a challenge/assessment has already been inputted
                {
                    $formInputHTML = '<div class="vc_row wpb_row vc_row-fluid mb90-form-input-vc-row">';
                    $exerciseCount = 0;
                    // get the previously inputted data and generate form with data displayed

                    foreach( $wpdb->get_results("SELECT * FROM ".$dataViewName." where InputDate='".$challengeCompletionDate."' and UserId=" . $_SESSION["LoggedUserID"] ) as $key => $row)
                    { 
                        $isPopulatedForm = true;
                        $populatedFormNumber ++;
                        //echo "<br />form" . $phaseCount;
                        $dataFoundForPhase = true;

                        if($phaseCount == 0){ // only populate these arrays once in this loop
                            if($formType == "UserBodyData"){
                                $labelArr = array("Weight", "Right Arm", "Left Arm", "Chest", "Navel", "Hips", "Right Leg Upper", "Right Leg Thigh", "Right Leg Calf", "Left Leg Upper", "Left Leg Thigh", "Left Leg Calf"); // captions to use for forms with no data i.e. adding data
                                $fieldNameArr = array("Weight", "RightArm", "LeftArm", "Chest", "Navel", "Hips", "RightLegUpper", "RightLegThigh", "RightLegCalf", "LeftLegUpper", "LeftLegThigh", "LeftLegCalf"); // dbase field names
                            }else{
                                //$labelArr[] = $row->ExerciseName.'&nbsp;('.$row->MeasurementType.'):'; // captions to use for forms with no data i.e. adding data
                                $labelArr[] = $row->ExerciseName.':'; // captions to use for forms with no data i.e. adding data
                                $exerciseIdArr[] = $row->ExerciseTypeID;
                                $measurementTypeArr[] = $row->MeasurementType;
                            }
                        }

                        $exerciseCount ++;

                        if($exerciseCount % 2 == 1 && $exerciseCount > 1){ // close off each row after 2 exercises
                            //$formInputHTML .= '</div><div class="vc_row wpb_row vc_row-fluid mb90-form-input-vc-row">';
                        }
                        $resultValue = "";
                        if(strlen($row->Result) > 0 && $row->Result !== null){ // for edit mode
                            $resultValue = $row->Result;
                        }
                        
                        $suffix = $phaseCount . $formCount;
                        
                        if($formType == "UserBodyData"){
                            for($bsCount = 0; $bsCount < count($labelArr); $bsCount ++){
                                $suffix = $phaseCount . $formCount;
                                $formInputHTML .= '<div class="vc_col-sm-12 wpb_column vc_column_container"><div class="mb90-input-form-label"><label>'.$labelArr[$bsCount].'</label></div><div class="mb90-input-form-input"><input type="text" id="Result_'.($suffix).'" value="' . $row->$fieldNameArr[$bsCount] . '" name="Result_'.($suffix).'" required="true" /></div>';
                                //$formInputHTML .= '<input type="hidden" id="ExerciseID_'.($suffix).'" name="ExerciseID_'.($suffix).'" value="'.$row->ExerciseTypeID.'" />';
                                $formInputHTML .= '<input type="hidden" id="FieldName_'.($suffix).'" name="FieldName_'.($suffix).'" value="'.$fieldNameArr[$bsCount].'" />';
                                $formInputHTML .= '<input type="hidden" id="ID_'.($suffix).'" name="ID_'.($suffix).'" value="'.$row->ID.'" /></div>';
                                $formCount ++;
                            }
                            //$formInputHTML .= '<input type="hidden" id="MeasurementType_'.($suffix).'" name="MeasurementType_'.($suffix).'" value="'.$row->MeasurementType.'" /></div>';
                        }else{
                            $formInputHTML .= '<div class="vc_col-sm-12 wpb_column vc_column_container"><div class="mb90-input-form-label"><label>'.$row->ExerciseName.'</label></div><div class="mb90-input-form-input"><input type="text" id="Result_'.($suffix).'" value="' . $row->Result . '" name="Result_'.($suffix).'" required="true" /></div>';
                            $formInputHTML .= '<input type="hidden" id="ExerciseID_'.($suffix).'" name="ExerciseID_'.($suffix).'" value="'.$row->ExerciseTypeID.'" />';
                            $formInputHTML .= '<input type="hidden" id="ID_'.($suffix).'" name="ID_'.($suffix).'" value="'.$row->ID.'" />';
                            $formInputHTML .= '<input type="hidden" id="MeasurementType_'.($suffix).'" name="MeasurementType_'.($suffix).'" value="'.$row->MeasurementType.'" /></div>';
                            $formCount ++;
                        }
                    }
                    //$formInputHTML .= '</div>';
                    if(strlen($formInputHTML) > 0) // if data was found for this challenge/assessment/bodystats
                    {
                        $formInputHTML = '<div style="display:none"><label>User ID:</label><input type="hidden" name="UserID"></div>' . $formInputHTML;
                        $formInputHTML .= '<input type="hidden" name="numEntries" id="numEntries" value="'.count($labelArr).'" />';
                        $formInputHTML .= '<input type="hidden" name="formNumber" id="formNumber" value="'.$phaseCount.'" />';
                        $formInputHTML .= '';
                        $formArray[] = $formInputHTML;
                        $formInputHTML = "";
                    }
                    /*
                    if today's date is in_array("all challenge date") and today's date is not in the completiondates array
                            return blank form in addmode
                     */
                    //$todayChallengeDate = strtotime("now");
                }
                //now create the blank forms
                //if( $isPopulatedForm === false)
                else
                { // add blank forms for any phase that has not already been populated and falls within the current phase or previous phases
                    $formInputHTML = "";
                    unset($labelArr);
                    $labelArr = array();
                    if( $formType == "User10DayChallenge" ){
                        //$exerciseWhereClause = "WHERE ProgrammeID=".$programmeID." and 10DayChallenge='Y'";
                        $exerciseWhereClause = "WHERE ProgrammeID=".$programmeID." and ExerciseDay=8 GROUP BY ExerciseID ORDER BY OrderNumber, ExerciseName, ExerciseMMType ASC";
                    }
                    else if($formType == "SelfAssessment"){
                        //$exerciseWhereClause = "WHERE ProgrammeID=".$programmeID." and SelfAssessment='Y'";
                        $exerciseWhereClause = "WHERE ProgrammeID=".$programmeID." and ExerciseDay=1 GROUP BY ExerciseID ORDER BY OrderNumber, ExerciseName, ExerciseMMType ASC";
                        //SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=1 AND ProgrammeID = 1 GROUP BY ExerciseID ORDER BY OrderNumber, ExerciseName, ExerciseMMType ASC
                    }
                    
                    if($formType == "UserBodyData"){
                        $labelArr = array("Weight", "Right Arm", "Left Arm", "Chest", "Navel", "Hips", "Right Leg Upper", "Right Leg Thigh", "Right Leg Calf", "Left Leg Upper", "Left Leg Thigh", "Left Leg Calf"); // captions to use for forms with no data i.e. adding data
                        $fieldNameArr = array("Weight", "RightArm", "LeftArm", "Chest", "Navel", "Hips", "RightLegUpper", "RightLegThigh", "RightLegCalf", "LeftLegUpper", "LeftLegThigh", "LeftLegCalf"); // dbase field names
                    }else{
                        //echo "SELECT * FROM ".$exerciseViewName." " . $exerciseWhereClause;
                        foreach( $wpdb->get_results("SELECT * FROM ".$exerciseViewName." " . $exerciseWhereClause ) as $key => $row)
                        {
                            //$labelArr[] = $row->ExerciseName.'&nbsp;('.$row->ExerciseMeasurementType.'):'; // captions to use for forms with no data i.e. adding data
                            $labelArr[] = $row->ExerciseName.':'; // captions to use for forms with no data i.e. adding data
                            $exerciseIdArr[] = $row->ExerciseID;
                            $measurementTypeArr[] = $row->ExerciseMeasurementType;
                        }
                    }
                    
                    $labelCount = 0;
                    $formInputHTML .= '<div class="vc_row wpb_row vc_row-fluid mb90-form-input-vc-row">';
                    foreach($labelArr as $label)
                    {
                        $labelCount ++;

                        if($labelCount % 2 > 1){ // if an odd numbered element then set right hand style
                            if($labelCount == count($labelArr)){
                                $formInputHTML .= '</div>'; // close final row
                            }else{
                                $formInputHTML .= '</div><div class="vc_row wpb_row vc_row-fluid mb90-form-input-vc-row">';                                
                            }
                        }
                        
                        $suffix = $phaseCount . $formCount;
                        
                        //echo "here1";
                        //print_r($labelArr);
                        //echo "here2";
                        
                        if($formType == "UserBodyData"){
                            //for($bsCount = 0; $bsCount < count($labelArr); $bsCount ++){
                                $formInputHTML .= '<div class="vc_col-sm-12 wpb_column vc_column_container"><div class="mb90-input-form-label"><label>'.$label.'</label></div><div class="mb90-input-form-input"><input type="text" id="Result_'.($suffix).'" name="Result_'.($suffix).'" required="true" /></div>';
                                //$formInputHTML .= '<input type="hidden" id="ExerciseID_'.($suffix).'" name="ExerciseID_'.($suffix).'" value="'.$row->ExerciseTypeID.'" />';
                                $formInputHTML .= '<input type="hidden" id="FieldName_'.($suffix).'" name="FieldName_'.($suffix).'" value="'.$fieldNameArr[$formCount].'" />';
                                $formInputHTML .= '<input type="hidden" id="ID_'.($suffix).'" name="ID_'.($suffix).'" value="" /></div>';
                            //}
                            $formCount = $formCount + 1;
                            //$formInputHTML .= '<input type="hidden" id="MeasurementType_'.($suffix).'" name="MeasurementType_'.($suffix).'" value="'.$row->MeasurementType.'" /></div>';
                        }else{
                            //$formInputHTML .= '<div class="fitem ' . $formCellStyle . '"><label>'.$label.'</label><input id="Result_'.($suffix).'" value="" name="Result_'.($suffix).'" class="easyui-textbox" required="true">';
                            $formInputHTML .= '<div class="vc_col-sm-12 wpb_column vc_column_container"><div class="mb90-input-form-label"><label>'.$label.'</label></div><div class="mb90-input-form-input"><input type="text" id="Result_'.($suffix).'" value="" name="Result_'.($suffix).'" required="true" /></div>';
                            $formInputHTML .= '<input type="hidden" id="ExerciseID_'.($suffix).'" name="ExerciseID_'.($suffix).'" value="'.$exerciseIdArr[$formCount].'" />';
                            $formInputHTML .= '<input type="hidden" id="ID_'.($suffix).'" name="ID_'.($suffix).'" value="" />';
                            $formInputHTML .= '<input type="hidden" id="MeasurementType_'.($suffix).'" name="MeasurementType_'.($suffix).'" value="'.$measurementTypeArr[$formCount].'" /></div>';
                            $formCount = $formCount + 1;
                        }
                    }
                    
                       
                    $formInputHTML .= '<input type="hidden" name="numEntries" id="numEntries" value="'.count($labelArr).'" />';
                    $formInputHTML .= '<input type="hidden" name="formNumber" id="formNumber" value="'.$phaseCount.'" />';
                    //$formInputHTML .= '</div>';
                    $formArray[] = $formInputHTML;
                    $formInputHTML = "";
                }
                
                $formCount = 0;
            }
        }  
        return $formArray;
    }
    
    function getFormInputs($gridType)
    {
        global $wpdb;
        $formInputHTML = "";
        if( $gridType == "Exercise")
        {
            $exerciseDropDown = $this->get_dropdown("exercise_types", "", "required='true'");
            $programmeDropDownReadOnly = $this->get_dropdown("programme_exercises", "readonly", "required='true'");
            $selfAssessmentDropDown = $this->get_yesno_dropdown("SelfAssessment");
            $TenDayChallengeDropDown = $this->get_yesno_dropdown("10DayChallenge");
            $formInputHTML .= '<div class="fitem"><label>Programme:</label>'.$programmeDropDownReadOnly.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Exercise:</label>'.$exerciseDropDown.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Exercise Day:</label><input name="ExerciseDay" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Reps:</label><input name="Reps" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Minutes for Reps:</label><input name="NumMinsForReps" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Self Assessment:</label>'.$selfAssessmentDropDown.'</div>';
            $formInputHTML .= '<div class="fitem"><label>10 Day Challenge:</label>'.$TenDayChallengeDropDown.'</div>';
            $formInputHTML .= '<div class="fitem"><label>10 Day Challenge Phase:</label><input name="10DayChallengePhase" class="easyui-textbox" required="true"></div>';
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
        else if( $gridType == "UserDiet")
        {
            $mealTypeDropDown = $this->get_dropdown("meal_type", "readonly", "required='true'");
            $formInputHTML .= '<div class="fitem"><label>Meal Type:</label>'.$mealTypeDropDown.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Meal Name:</label><input name="MealName" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Ingredients:</label><input name="Ingredients" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Instructions Video Link:</label><input name="CookingInstructions" class="easyui-textbox"></div>';
            $formInputHTML .= '<div class="fitem"><label>Calorie Count:</label><input name="CalorieCount" class="easyui-textbox" required="true"></div>';
        }
        else if( $gridType == "UserBodyData")
        {
            //$formInputHTML .= '<div class="fitem"><label>Date:</label><input name="InputDate" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" required="true" panelWidth="300"></div>';
            $formInputHTML .= '<div class="fitem" style="display:none"><label>User ID:</label><input name="UserID" class="easyui-textbox"></div>';
            $formInputHTML .= '<div class="fitem"><label>Date:</label><input name="InputDate" class="easyui-datebox" data-options="field:\'fn\',formatter:formatDate,parser:parseDate" required="true" panelWidth="300"></div>';
            //$formInputHTML .= '<div class="fitem"><label>Date:</label><input name="InputDate" class="easyui-datebox" required="true" panelWidth="300"></div>';

            $formInputHTML .= '<div class="fitem"><label>Weight:</label><input name="Weight" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Right Arm:</label><input name="RightArm" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Left Arm:</label><input name="LeftArm" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Chest:</label><input name="Chest" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Navel:</label><input name="Navel" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Hips:</label><input name="Hips" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Right Leg Upper:</label><input name="RightLegUpper" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Right Leg Thigh:</label><input name="RightLegThigh" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Right Leg Calf:</label><input name="RightLegCalf" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Left Leg Upper:</label><input name="LeftLegUpper" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Left Leg Thigh:</label><input name="LeftLegThigh" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label>Left Leg Calf:</label><input name="LeftLegCalf" class="easyui-textbox" required="true"></div>';
        }
        else if( $gridType == "User10DayChallengeSingle")
        {
            $formInputHTML .= '<div class="fitem" style="display:none"><label>User ID:</label><input name="UserID" class="easyui-textbox"></div>';
            $exerciseDropDown = $this->get_dropdown("10day_challenge_exercises", "", "required='true'");
            $measurementTypeDropDown = $this->get_dropdown("10day_challenge_measurement_types", "", "required='true'"); // Reps or Time
            $formInputHTML .= '<div class="fitem"><label>Date:</label><input id="dd" name="InputDate" type="text" class="easyui-datebox" data-options="field:\'fn\',formatter:formatDate,parser:parseDate" required="true" panelWidth="300"></div>';
            $formInputHTML .= '<div class="fitem"><label>Exercise:</label>'.$exerciseDropDown.'</div>';
            $formInputHTML .= '<div class="fitem" style="display:none"><label>MeasurementType:</label>'.$measurementTypeDropDown.'</div>';
            $formInputHTML .= '<div class="fitem"><label>Type:</label><input id="MeasurementType" name="MeasurementType" class="easyui-textbox" required="true" readonly="true"></div>';
            $formInputHTML .= '<div class="fitem"><label id="Result">Result:</label><input name="Result" class="easyui-textbox" required="true"></div>';

            //dropdown : 10days_challenge_exercises
        }   
        else if( $gridType == "User10DayChallenge")
        {
            $programmeID = $_SESSION["UserProgrammeID"];
            $tenDayChallengePhase = $this->getChallengePhase("10Day");
            //$whereClause = " WHERE ProgrammeID = " . $programmeID ." AND TenDayChallengePhase = " . $tenDayChallengePhase;
            $whereClause = " WHERE UserID = " . $_SESSION["LoggedUserID"];
            //echo "SELECT * FROM mb90_user_challenge_exercises_translated " .$whereClause." ORDER BY ExerciseID ASC";
            
            $formInputHTML .= '<div class="fitem" style="display:none"><label>User ID:</label><input name="UserID" class="easyui-textbox"></div>';
            $exerciseCount = 1;
            foreach( $wpdb->get_results("SELECT * FROM mb90_user_challenge_exercises_translated " .$whereClause." ORDER BY ExerciseID ASC") as $key => $row)
            { 
                //$ddHTML .= '<option value="'.$row->$tableID.'">'.$row->$dropdownCaption.'</option>';
                //echo "<br />Exercise = [".$row->ExerciseName."]";
                $formInputHTML .= '<div class="fitem"><label>'.$row->ExerciseName.'&nbsp;('.$row->MeasurementType.'):</label><input id="Result_'.$exerciseCount.'" name="Result_'.$exerciseCount.'" class="easyui-textbox" required="true">';
                $formInputHTML .= '<input id="ExerciseID_'.$exerciseCount.'" name="ExerciseID_'.$exerciseCount.'" class="easyui-textbox" required="true" hidden="true">';
                $formInputHTML .= '<input id="MeasurementType_'.$exerciseCount.'" name="MeasurementType_'.$exerciseCount.'" class="easyui-textbox" required="true" readonly="true"></div>';
                $exerciseCount = $exerciseCount + 1;
            }
            $formInputHTML .= '</div>';
        }  
        else if( $gridType == "UserSelfAssessment")
        {
            $programmeID = $_SESSION["UserProgrammeID"];
            $assessmentPhase = $this->getChallengePhase("Assessment");
            //$whereClause = " WHERE ProgrammeID = " . $programmeID ." AND SelfAssessmentPhase = " . $assessmentPhase;
            $whereClause = " WHERE UserID = " . $_SESSION["LoggedUserID"];
            
            $formInputHTML .= '<div class="fitem" style="display:none"><label>User ID:</label><input name="UserID" class="easyui-textbox"></div>';
            $exerciseCount = 1;
            foreach( $wpdb->get_results("SELECT * FROM mb90_user_assessment_exercises_translated " .$whereClause." ORDER BY ExerciseID ASC") as $key => $row)
            { 
                //$ddHTML .= '<option value="'.$row->$tableID.'">'.$row->$dropdownCaption.'</option>';
                //echo "<br />Exercise = [".$row->ExerciseName."]";
                $formInputHTML .= '<div class="fitem"><label>'.$row->ExerciseName.'&nbsp;('.$row->MeasurementType.'):</label><input id="Result_'.$exerciseCount.'" name="Result_'.$exerciseCount.'" class="easyui-textbox" required="true">';
                $formInputHTML .= '<input id="ExerciseID_'.$exerciseCount.'" name="ExerciseID_'.$exerciseCount.'" class="easyui-textbox" required="true" hidden="true">';
                $formInputHTML .= '<input id="MeasurementType_'.$exerciseCount.'" name="MeasurementType_'.$exerciseCount.'" class="easyui-textbox" required="true" readonly="true"></div>';
                $exerciseCount = $exerciseCount + 1;
            }
            $formInputHTML .= '</div>';
        }   
        else if( $gridType == "UserSelfAssessmentSingle")
        {

            
            $formInputHTML .= '<div class="fitem" style="display:none"><label>User ID:</label><input name="UserID" class="easyui-textbox"></div>';
            $exerciseDropDown = $this->get_dropdown("10day_challenge_exercises", "", "required='true'");
            $measurementTypeDropDown = $this->get_dropdown("10day_challenge_measurement_types", "", "required='true'"); // Reps or Time
            $formInputHTML .= '<div class="fitem"><label>Date:</label><input id="dd" name="InputDate" type="text" class="easyui-datebox" data-options="field:\'fn\',formatter:formatDate,parser:parseDate" required="true" panelWidth="300"></div>';
            $formInputHTML .= '<div class="fitem"><label>Exercise:</label>'.$exerciseDropDown.'</div>';
            $formInputHTML .= '<div class="fitem" style="display:none"><label>MeasurementType:</label>'.$measurementTypeDropDown.'</div>';
            //$formInputHTML .= '<div class="fitem"><label>Type:</label><input name="MeasurementType" class="easyui-textbox" required="true"></div>';
            $formInputHTML .= '<div class="fitem"><label id="Result">Result:</label><input name="Result" class="easyui-textbox" required="true"></div>';
        }   
        
        return $formInputHTML;
    }
    
    function getChallengePhase($type)
    {
        if($type == "10Day" || $type == "UserBodyData" )
            $divider = 10;
        else if( $type == "Assessment")
            $divider = 30;   
        
        $startDateStr = $_SESSION["UserStartDate"];
        $startDate = strtotime($startDateStr);
        $today = strtotime("now");
        $numberDaysSinceStart = floor(($today - $startDate)  / (60 * 60 * 24));
        if( $numberDaysSinceStart > 90){ // failsafe 
            $numberDaysSinceStart = 90;
        }
        
        //echo "startDate = [".$startDate."], today = [".$today."] numdays start =[".$numberDaysSinceStart."]";
        
        $phase =  floor(($numberDaysSinceStart / $divider))+1;
        //echo "phase= [".$phase."]";
        return $phase;
        //return 1;
    }
    
    function getGridHeader($gridType)
    {
        $headerHTML = "";
        if( $gridType == "Exercise")
        {
            $headerHTML .= '<th field="ProgrammeID" width="50" hidden="true">Programme ID</th>';
            $headerHTML .= '<th field="ProgrammeType" width="50">Programme</th>';
            $headerHTML .= '<th field="ExerciseID" width="50" hidden="true">Exercise ID</th>';
            $headerHTML .= '<th field="ExerciseName" width="50">Exercise</th>';
            $headerHTML .= '<th field="ExerciseDay" width="50">Exercise Day</th>';
            $headerHTML .= '<th field="Reps" width="50">Reps</th>';
            $headerHTML .= '<th field="NumMinsForReps" width="50">Minutes for Reps</th>';

            $headerHTML .= '<th field="SelfAssessment" width="50" >Self Assessment</th>';
            $headerHTML .= '<th field="SelfAssessmentPhase" width="50" >Self Assessment Phase</th>';
            $headerHTML .= '<th field="10DayChallenge" width="50" >10 Day Challenge</th>';
            $headerHTML .= '<th field="10DayChallengePhase" width="50">10 Day Challenge Phase</th>';
            $headerHTML .= '<th field="Message" width="50">Message</th>';
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
        else if( $gridType == "UserDiet")
        {
            $headerHTML .= '<th field="DietMealTypeID" width="50" hidden="true">Meal Type ID</th>';
            $headerHTML .= '<th field="MealTypeName" width="50">Meal Type</th>';
            $headerHTML .= '<th field="ID" width="50" hidden="true">Diet ID</th>';
            $headerHTML .= '<th field="MealName" width="50">Meal Name</th>';
            $headerHTML .= '<th field="Ingredients" width="50">Ingredients</th>';
            $headerHTML .= '<th field="CookingInstructions" width="50">Instruction Video Link</th>';
            $headerHTML .= '<th field="CalorieCount" width="50">Calorie Count</th>';
        }        
        else if( $gridType == "UserBodyData")
        {
            // UserID will be taken from wordpress login session
            $headerHTML .= '<th field="UserID" hidden="true">User ID</th>';
            $headerHTML .= '<th field="InputDate" width="70" data-options="field:\'fn\',formatter:formatDate,parser:parseDate">Date</th>';
            $headerHTML .= '<th field="Weight" width="50">Weight</th>';
            //$headerHTML .= '<th field="ActivityLevel" width="50">Activity Levl</th>';
            $headerHTML .= '<th field="RightArm" width="60">Right Arm</th>';
            $headerHTML .= '<th field="LeftArm" width="60">Left Arm</th>';
            $headerHTML .= '<th field="Chest" width="50">Chest</th>';
            $headerHTML .= '<th field="Navel" width="50">Navel</th>';
            $headerHTML .= '<th field="Hips" width="50">Hips</th>';
            
            $headerHTML .= '<th field="RightLegUpper" width="50">RL Upper</th>';
            $headerHTML .= '<th field="RightLegThigh" width="50">RL Thigh</th>';
            $headerHTML .= '<th field="RightLegCalf" width="50">RL Calf</th>';
            
            $headerHTML .= '<th field="LeftLegUpper" width="50">LL Upper</th>';
            $headerHTML .= '<th field="LeftLegThigh" width="50">LL Thigh</th>';
            $headerHTML .= '<th field="LeftLegCalf" width="50">LL Calf</th>';
            
        }   
        else if( $gridType == "User10DayChallenge")
        {
            //$headerHTML .= '<th field="InputDate" width="100" data-options="field:\'fn\',formatter:formatDate">Date</th>';
            $headerHTML .= '<th field="UserID" hidden="true">User ID</th>';
            $headerHTML .= '<th field="InputDate" width="100" data-options="field:\'fn\',formatter:formatDate,parser:parseDate" >Date</th>';
            $headerHTML .= '<th field="ExerciseID" hidden="true">Exercise ID</th>';
            $headerHTML .= '<th field="ExerciseName" width="100">Exercise Name</th>';
            $headerHTML .= '<th field="MeasurementType" width="100">Measurement</th>';
            $headerHTML .= '<th field="Result" width="100">Result</th>';
            //dropdown : 10days_challenge_exercises
        }   
        else if( $gridType == "UserSelfAssessment")
        {
            $headerHTML .= '<th field="UserID" hidden="true">User ID</th>';
            $headerHTML .= '<th field="InputDate" width="100" data-options="field:\'fn\',formatter:formatDate,parser:parseDate" >Date</th>';
            $headerHTML .= '<th field="ExerciseID" hidden="true">Exercise ID</th>';
            $headerHTML .= '<th field="ExerciseName" width="100">Exercise Name</th>';
            $headerHTML .= '<th field="MeasurementType" width="100">Measurement</th>';
            $headerHTML .= '<th field="Result" width="100">Result</th>';
        }   
        
        return $headerHTML;
    }
    
    function get_yesno_dropdown($name)
    {
        $ddHTML = '<select class="easyui-combobox" name="' . $name .'" style="width:200px;" required=true">';
        $ddHTML .= '<option value="">-- Please Select --</option>';
        $ddHTML .= '<option value="Y">Yes</option>';
        $ddHTML .= '<option value="N">No</option>';
        $ddHTML .= '</select>';
        return $ddHTML;
    }
    
    function get_dropdown($type, $readmode, $required)
    {
        global $wpdb;
        $whereClause = "";
        $onChange = "";
        $dataOptions = "";
        
        if( $type == "exercise_types")
        {
            $dropdownID = "ExerciseID";
            $tableID = "ID";
            $dropdownCaption = "ExerciseName";
            $tableName = "mb90_exercise_types";
        }
        else if( $type == "10day_challenge_exercises")
        {
            $dropdownID = "ExerciseID";
            $tableID = "ExerciseID";
            $dropdownCaption = "ExerciseName";
            $tableName = "mb90_prog_exercises_translated";
            $whereClause = "WHERE 10DayChallenge = 'Y' ";
            $dataOptions = ' data-options="field:\'fn\',onSelect:updateMeasurementType" ';
            //$onChange = ' onchange="updateMeasurementType();" ';
        }
        else if( $type == "10day_challenge_measurement_types")
        {
            $dropdownID = "MeasurementTypeExerciseID";
            $tableID = "ID";
            $dropdownCaption = "MeasurementType";
            $tableName = "mb90_exercise_types";
            
            //$whereClause = "WHERE 10DayChallenge = 'Y' ";
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
        
        //$ddHTML = '<select class="easyui-combobox" name="' . $dropdownID .'" style="width:200px;" ' . $readmode . '>';
        $ddHTML = '<select '.$dataOptions.' class="easyui-combobox" name="' . $dropdownID .'" style="width:200px;" '.$required.' id="' . $dropdownID .'">';
        
        foreach( $wpdb->get_results("SELECT * FROM " . $tableName . " " .$whereClause." ORDER BY " . $tableID) as $key => $row)
        { 
            $ddHTML .= '<option value="'.$row->$tableID.'">'.$row->$dropdownCaption.'</option>';
        }
        
        $ddHTML .= '</select>';

        return $ddHTML;
        //return "SELECT * FROM " . $tableName . " " .$whereClause." ORDER BY " . $tableID;
    }
}

class chartFunctions
{
    function stripLeadComma($str)
    {
        return substr($str, 0, strlen($str)-1);
    }
    
    function getShortDate($dateStr)
    {
        $date = new DateTime($dateStr);
        return $date->format('d-M');
    }
    
    // get labels and data for a chart specific to 1 body stat type e.g. weight
    function getBarChartBodyStatValuesSpecific($statType, $userID, $height, $age, $sex, $activityFactor)
    {
        global $wpdb;
        $userDetailsObj = new userDetails();
        $rowArray = array();
        foreach( $wpdb->get_results("SELECT " . $statType . ", InputDate FROM mb90_user_bodystats WHERE UserID = ". $userID ." ORDER BY InputDate ASC") as $key => $row)
        { 
            $weight = $row->Weight;
            $dataStr .= "'".$row->$statType . "',";
            $captionStr .= "'".date("d-M", strtotime($row->InputDate)). "',";
            
            $bmr = $userDetailsObj->getBMR($weight, $height, $age, $sex);
            $bmiStr .= "'" . $userDetailsObj->getBMI($weight, $height) . "',";
            $bmrStr .= "'" . $bmr . "',";
            $tdeeStr .= "'".$userDetailsObj->getTDEE($bmr, $activityFactor) . "',";
            
        }
        array_push($rowArray, $this->stripLeadComma($captionStr));
        array_push($rowArray, $this->stripLeadComma($dataStr));
        
        array_push($rowArray, $this->stripLeadComma($bmiStr));
        array_push($rowArray, $this->stripLeadComma($bmrStr));
        array_push($rowArray, $this->stripLeadComma($tdeeStr));
        
        return $rowArray;
    }
    
    function getBarChartValues($screenName)
    {
        global $wpdb;
        $rowArray = array();
        
        if( $screenName == "UserBodyData"){
            $weightStr = "";
            $rightArmStr = "";
            $lefttArmStr = "";
            $chestStr = "";
            $navelStr = "";
            $hipsStr = "";
            $rightLegUpperStr = "";
            $rightLegThighStr = "";
            $rightLegCalfStr = "";
            $leftLegUpperStr = "";
            $leftLegThighStr = "";
            $leftLegCalfStr = "";
            $dateStr = "";
        
            foreach( $wpdb->get_results("SELECT * FROM mb90_user_bodystats WHERE UserID = ".$_SESSION["LoggedUserID"]." ORDER BY InputDate ASC") as $key => $row)
            { 
                $weightStr .= "'".$row->Weight . "',";
                $rightArmStr .= "'".$row->RightArm . "',";
                $lefttArmStr .= "'".$row->LeftArm . "',";
                $chestStr .= "'".$row->Chest . "',";
                $navelStr .= "'".$row->Navel . "',";
                $hipsStr .= "'".$row->Hips . "',";
                $rightLegUpperStr .= "'".$row->RightLegUpper . "',";
                $rightLegThighStr .= "'".$row->RightLegThigh . "',";
                $rightLegCalfStr .= "'".$row->RightLegCalf . "',";
                $leftLegUpperStr .= "'".$row->LeftLegUpper . "',";
                $leftLegThighStr .= "'".$row->LeftLegThigh . "',";
                $leftLegCalfStr .= "'".$row->LeftLegCalf . "',";
                //$dateStr .= "'" . $this->getShortDate($row->InputDate) . "'";
                $dateStr .= "'".$this->getShortDate($row->InputDate) . "',";
            }

            array_push($rowArray, $this->stripLeadComma($weightStr));
            array_push($rowArray, $this->stripLeadComma($rightArmStr));
            array_push($rowArray, $this->stripLeadComma($lefttArmStr));
            array_push($rowArray, $this->stripLeadComma($chestStr));
            array_push($rowArray, $this->stripLeadComma($navelStr));
            array_push($rowArray, $this->stripLeadComma($hipsStr));
            array_push($rowArray, $this->stripLeadComma($rightLegUpperStr));
            array_push($rowArray, $this->stripLeadComma($rightLegThighStr));
            array_push($rowArray, $this->stripLeadComma($rightLegCalfStr));
            array_push($rowArray, $this->stripLeadComma($leftLegUpperStr));
            array_push($rowArray, $this->stripLeadComma($leftLegThighStr));
            array_push($rowArray, $this->stripLeadComma($leftLegCalfStr));
            array_push($rowArray, $this->stripLeadComma($dateStr));
        }
        else if( $screenName == "User10DayChallenge"){
            $programmeID = $_SESSION["UserProgrammeID"];
            //$whereClause = " WHERE ProgrammeID = " . $programmeID ." AND UserID = " . $_SESSION["LoggedUserID"];
            $whereClause = " WHERE UserID = " . $_SESSION["LoggedUserID"];
            //echo "SELECT * FROM mb90_user_challenge_exercises_translated " .$whereClause." ORDER BY InputDate, ExerciseID ASC";
            $exerciseCount = 0;
            $varArray = array();
            foreach( $wpdb->get_results("SELECT * FROM mb90_user_challenge_exercises_translated " .$whereClause." ORDER BY InputDate, ExerciseID ASC") as $key => $row)
            { 
                $varArray[$exerciseCount]['exercisetype'] = $row->MeasurementType;
                $varArray[$exerciseCount]['exercisename'] = $row->ExerciseName;
                $varArray[$exerciseCount]['exerciseresult'] = $row->Result;
                $varArray[$exerciseCount]['exercisedate'] = $this->getShortDate($row->InputDate);
                $varArray[$exerciseCount]['exercisechallengephase'] = $row->TenDayChallengePhase;
                $exerciseCount = $exerciseCount + 1;
            }
            return $varArray;
        }
        else if( $screenName == "UserSelfAssessment"){
            $programmeID = $_SESSION["UserProgrammeID"];
            //$tenDayChallengePhase = $this->get10DayChallengePhase();
            //echo " WHERE ProgrammeID = " . $programmeID ." AND UserID = " . $_SESSION["LoggedUserID"];
            
            //$whereClause = " WHERE ProgrammeID = " . $programmeID ." AND UserID = " . $_SESSION["LoggedUserID"];
            $whereClause = " WHERE UserID = " . $_SESSION["LoggedUserID"];
            $exerciseCount = 0;
            $varArray = array();
            foreach( $wpdb->get_results("SELECT * FROM mb90_user_assessment_exercises_translated " .$whereClause." ORDER BY InputDate, ExerciseID ASC") as $key => $row)
            { 
                $varArray[$exerciseCount]['exercisetype'] = $row->MeasurementType;
                $varArray[$exerciseCount]['exercisename'] = $row->ExerciseName;
                $varArray[$exerciseCount]['exerciseresult'] = $row->Result;
                $varArray[$exerciseCount]['exercisedate'] = $this->getShortDate($row->InputDate);
                $varArray[$exerciseCount]['exercisechallengephase'] = $row->SelfAssessmentPhase;
                $exerciseCount = $exerciseCount + 1;
            }
            return $varArray;
        }
        return $rowArray;
    }
    function getBarChartCaptions($screenName)
    {
        switch($screenName){
            case "UserBodyData":
                $captionArray = array("Weight", "Right Arm", "Left Arm", "Chest", "Navel", "Hips", "Right Leg Upper", "Right Leg Thigh", "Right Leg Calf", "Left Leg Upper", "Left Leg Thigh", "Left Leg Calf" );                
                break;
            case "User10DayChallenge":
                $captionArray = array("Weight", "Right Arm", "Left Arm", "Chest", "Navel", "Hips", "Right Leg Upper", "Right Leg Thigh", "Right Leg Calf", "Left Leg Upper", "Left Leg Thigh", "Left Leg Calf" );                
                break;
            case "UserSelfAssessment":
                $captionArray = array("Weight", "Right Arm", "Left Arm", "Chest", "Navel", "Hips", "Right Leg Upper", "Right Leg Thigh", "Right Leg Calf", "Left Leg Upper", "Left Leg Thigh", "Left Leg Calf" );                
                break;
        }
        return $captionArray; 
    }
    
    function GetWeightGraph()
    {
        $chartDataArray = $this->getChartData();
        $html = $this->GetGraphHTML(WEIGHT_PROGRESS_CAPTION);
        $js = $this->GetGraphJavascript(WEIGHT_PROGRESS_CAPTION, $chartDataArray );
        return $html . $js;
    }
    
    function GetBMIGraph()
    {
        $chartDataArray = $this->getChartData();
        $html = $this->GetGraphHTML(BMI_PROGRESS_CAPTION);
        $js = $this->GetGraphJavascript(BMI_PROGRESS_CAPTION, $chartDataArray );
        return $html . $js;
    }
    
    function GetBMRGraph()
    {
        $chartDataArray = $this->getChartData();
        $html = $this->GetGraphHTML(BMR_PROGRESS_CAPTION);
        $js = $this->GetGraphJavascript(BMR_PROGRESS_CAPTION, $chartDataArray );
        return $html . $js;
    }
    
    function GetTDEEGraph()
    {
        $chartDataArray = $this->getChartData();
        $html = $this->GetGraphHTML(TDEE_PROGRESS_CAPTION);
        $js = $this->GetGraphJavascript(TDEE_PROGRESS_CAPTION, $chartDataArray );
        return $html . $js;
    }
    
    function GetGraphHTML($graphCaption)
    {
        $graphID = "";
        switch ($graphCaption) {
            case WEIGHT_PROGRESS_CAPTION:
                $graphID = "weights";
                break;
            case BMI_PROGRESS_CAPTION:
                $graphID = "bmiGraphCanvas";
                break;
            case BMR_PROGRESS_CAPTION:
                $graphID = "bmrGraphCanvas";
                break;
            case TDEE_PROGRESS_CAPTION:
                $graphID = "tdeeGraphCanvas";
                break;
            default:
                $graphID = "weights";
        }
        $html = '<table class="weight-fields"><tbody>';
        $html .= '<tr><td colspan="2"><div class="mp_tablecaption">' . $graphCaption . '</div></td></tr>';
        $html .= '<tr class="white-row"><td colspan="2" class="graph-cell"><canvas id="' . $graphID . '" ></canvas></td></tr>';
        $html .= '</tbody></table>';
        return $html;
    }
    
    function getChartData()
    {
        //echo "logged user = [" . $_SESSION["LoggedUserID"] . "]";
        
        $userDetailsObj = new userDetails();
        $userDetailsArr = $userDetailsObj->getUserDetails($_SESSION["LoggedUserID"]);
        $height = $userDetailsArr["userheight"];
        $age = $userDetailsArr["userage"];
        $sex = $userDetailsArr["usersex"];
        $activityFactor = $userDetailsArr["useractivitylevel"];

        $chartDataArray = $this->getBarChartBodyStatValuesSpecific("Weight", $_SESSION["LoggedUserID"], $height, $age, $sex, $activityFactor);
        return $chartDataArray;
    }
    
    function GetGraphJavascript($graphCaption, $chartDataArray)
    {
        // only the weight prgress chart is line chart ... the others are bar charts
        if( $graphCaption == WEIGHT_PROGRESS_CAPTION) {
            $graphCode = $this->getLineChart($chartDataArray);
        }else{
            $graphCode = $this->getBarChart($graphCaption, $chartDataArray);
        }

        return $graphCode;
    }
    
    function getBarChart($graphCaption, $chartArray)
    {
        switch ($graphCaption) {
            case BMI_PROGRESS_CAPTION:
                $fillColor = "#0fa2e6";
                $strokeColor = "#fff";
                $ttFillColor = "#e33a0c";
                $ttFontColor = "#000";
                $prefix = "bmi";
                $arrayIndex = 2;
                break;
            case BMR_PROGRESS_CAPTION:
                $fillColor = "#e33a0c";
                $strokeColor = "#fff";
                $ttFillColor = "#0fa2e6";
                $ttFontColor = "#000";
                $prefix = "bmr";
                $arrayIndex = 3;
                break;
            case TDEE_PROGRESS_CAPTION:
                $fillColor = "#48A497";
                $strokeColor = "#fff";
                $ttFillColor = "#000";
                $ttFontColor = "#fff";
                $prefix = "tdee";
                $arrayIndex = 4;
                break;
            default:
                $fillColor = "";
                $strokeColor = "";
                $ttFillColor = "";
                $prefix = "bmi";
                $arrayIndex = 2;
        }
        
        $barChartCode = '<script>';
        $barChartCode .= 'var ' . $prefix .'Graph = document.getElementById("' . $prefix .'GraphCanvas").getContext("2d");' . "\r\n";
        
        $barChartCode .= 'var ' . $prefix .'BarData = {' . "\r\n";
        $barChartCode .= '                labels : [' . $chartArray[0] .'],' . "\r\n";
        $barChartCode .= '                datasets : [' . "\r\n";
        $barChartCode .= '                        {' . "\r\n";
        $barChartCode .= '                                fillColor : "' . $fillColor .'",' . "\r\n";
        $barChartCode .= '                                strokeColor : "' . $strokeColor .'",' . "\r\n";
        $barChartCode .= '                                data : [' . $chartArray[$arrayIndex] . ']' . "\r\n";
        $barChartCode .= '                        }' . "\r\n";
        $barChartCode .= '                ]' . "\r\n";
        $barChartCode .= '        }' . "\r\n";
        
        $barChartCode .= '        var ' . $prefix .'ChartOptions = { ' . "\r\n";
        $barChartCode .= '                   scaleShowGridLines : true,     ' . "\r\n";
        $barChartCode .= '                   responsive : false, ' . "\r\n";
        $barChartCode .= '                   pointDotRadius : 6,' . "\r\n";
        $barChartCode .= '                   //scaleFontStyle: 10,' . "\r\n";
        $barChartCode .= '                   tooltipFontColor: "' . $ttFontColor .'",' . "\r\n";
        $barChartCode .= '                   tooltipFillColor: "' . $ttFillColor .'"' . "\r\n";
        $barChartCode .= '                   //scaleLabel: "<%= value%> Kg",' . "\r\n";
        $barChartCode .= '        } ' . "\r\n";
        
        $barChartCode .= '        new Chart(' . $prefix .'Graph).Bar(' . $prefix .'BarData, ' . $prefix .'ChartOptions);' . "\r\n";
        
        $barChartCode .= '</script>';
        
        return $barChartCode;
    }
    
    function getLineChart($chartArray)
    {        
        $lineChartCode = '<script>' . "\r\n";
        $lineChartCode .= 'var weights = document.getElementById("weights").getContext("2d");' . "\r\n";
        $lineChartCode .= '            var weightData = {' . "\r\n";
        $lineChartCode .= '                    labels : [' . $chartArray[0] . '],' . "\r\n";
        $lineChartCode .= '                    datasets : [' . "\r\n";
        $lineChartCode .= '                            {' . "\r\n";
        $lineChartCode .= '                                    fillColor : "rgba(227,58,12,0.4)",' . "\r\n";
        $lineChartCode .= '                                    strokeColor : "#e33a0c",' . "\r\n";
        $lineChartCode .= '                                    pointColor : "#fff",' . "\r\n";
        $lineChartCode .= '                                    pointStrokeColor : "e33a0c",' . "\r\n";
        $lineChartCode .= '                                    data : [' . $chartArray[1] . ']' . "\r\n";
        $lineChartCode .= '                            }' . "\r\n";
        $lineChartCode .= '                    ]' . "\r\n";
        $lineChartCode .= '            }' . "\r\n";
        $lineChartCode .= '            var chartOptions = { ' . "\r\n";
        $lineChartCode .= '                       scaleShowGridLines : true,     ' . "\r\n";
        $lineChartCode .= '                       responsive : false, ' . "\r\n";
        $lineChartCode .= '                       pointDotRadius : 6,' . "\r\n";
        $lineChartCode .= '                       //scaleFontStyle: 10,' . "\r\n";
        $lineChartCode .= '                       tooltipFillColor: "rgba(15,162,230,0.8)",' . "\r\n";
        $lineChartCode .= '                       //scaleLabel: "<%= value%> Kg",' . "\r\n";
        $lineChartCode .= '            } ' . "\r\n";

        
        $lineChartCode .= 'if( weightData.datasets[0].data.length == 1) // if only 1 data record then use a bar chart else a line graph' . "\r\n";
        $lineChartCode .= 'new Chart(weights).Bar(weightData, chartOptions);' . "\r\n";
        $lineChartCode .= 'else' . "\r\n";
        $lineChartCode .= 'new Chart(weights).Line(weightData, chartOptions);' . "\r\n";
    
        //$lineChartCode .= '            new Chart(weights).Line(weightData, chartOptions);' . "\r\n";
        $lineChartCode .= '</script>' . "\r\n";
        return $lineChartCode;
    }
}

class Assessments
{
    // return list challenge dates
    function get10DayChallengeLinks($mode)
    {
        global $wpdb;
        $allowEdit = false;
        $allowAdd = false;
        
        if($mode == "Previous")
        {
            $challenges = $wpdb->get_results("SELECT * FROM mb90_user_challenge_translated WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID", OBJECT);

            if( $wpdb->num_rows > 0 )
            {
                $rows = array();
                foreach( $challenges as $key => $row)
                {
                    $rows[] = $row;
                }

                header("Content-type: application/json");

                $response = array("total" => $wpdb->num_rows, "rows" => $rows);

                echo json_encode($response);
            }
        }
        else if($mode == "All")
        {
            // get completed challenges ... don't allow adding any new records to these
            $completedChallenges = $wpdb->get_results("SELECT * FROM mb90_user_challenge_translated WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID", OBJECT);
            
            //echo "SELECT * FROM mb90_user_challenge_translated WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID";
            if( $wpdb->num_rows > 0 )
            {
                $rows = array();
                foreach( $completedChallenges as $key => $row)
                {
                    $challengeCompletionDates[] = $row->InputDate;
                }
            }
            $startDateStr = $_SESSION["UserStartDate"];
            $allChallengeDates = $this->getAllChallengeDates($startDateStr, "User10DayChallenge");
            $challengeDateCount = 1;

            //$linkHTML = '<div class="mb90-challengeDatesWrapper">';
            $linkHTML .= '<div class="vc_row wpb_row vc_row-fluid">';
            for($cd =0; $cd < count($allChallengeDates); $cd++)
            {
                $challengeDate = $allChallengeDates[$cd];
                $onClickStr = $this->getOnClick($challengeDate, $challengeCompletionDates, $cd+1, "User 10 Day Challenge");         
                $dateDisplay = date("d/m/Y", strtotime($challengeDate));
                $linkHTML .= '<div class="vc_col-sm-3 wpb_column vc_column_container"><div class="wpb_wrapper"><div class="wpb_text_column wpb_content_element">';
                $linkHTML .= '<div class="wpb_wrapper challengelink-button-wrapper">';
                $linkHTML .= '<a '.$onClickStr.' href="javascript:void(0);" title="10 Day Challenge For ' . $dateDisplay . '" class="tm-blog-more uk-button uk-button-primary uk-button-large uk-text-truncate">' . $dateDisplay . '</a>';
                $linkHTML .= '</div></div></div></div>';
            }
            //$linkHTML .= '</div>';
            $linkHTML .= '</div>';
        }
        return $linkHTML;
    }
    
    // return list of body stat measurement dates
    function getUserBodyStatLinks($mode)
    {
        global $wpdb;
        $allowEdit = false;
        $allowAdd = false;
        
        if($mode == "Previous")
        {
            $challenges = $wpdb->get_results("SELECT * FROM mb90_user_bodystats WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID", OBJECT);

            if( $wpdb->num_rows > 0 )
            {
                $rows = array();
                foreach( $challenges as $key => $row)
                {
                    $rows[] = $row;
                }

                header("Content-type: application/json");

                $response = array("total" => $wpdb->num_rows, "rows" => $rows);

                echo json_encode($response);
            }
        }
        else if($mode == "All")
        {
            // get completed challenges ... don't allow adding any new records to these
            $completedChallenges = $wpdb->get_results("SELECT * FROM mb90_user_bodystats WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID", OBJECT);
            
            //echo "SELECT * FROM mb90_user_challenge_translated WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID";
            if( $wpdb->num_rows > 0 )
            {
                $rows = array();
                foreach( $completedChallenges as $key => $row)
                {
                    $challengeCompletionDates[] = $row->InputDate;
                }
            }
            $startDateStr = $_SESSION["UserStartDate"];
            $allChallengeDates = $this->getAllChallengeDates($startDateStr, "UserBodyData");
            
            //echo "challengeCompletionDates" . print_r($challengeCompletionDates) . "]";
            //echo "allChallengeDates" . print_r($allChallengeDates) . "]";
            $challengeDateCount = 1;

            //$linkHTML = '<div class="mb90-challengeDatesWrapper">';
            $linkHTML .= '<div class="vc_row wpb_row vc_row-fluid">';
            for($cd =0; $cd < count($allChallengeDates); $cd++)
            {
                $challengeDate = $allChallengeDates[$cd];
                $onClickStr = $this->getOnClick($challengeDate, $challengeCompletionDates, $cd+1, "User Body Stats");         
                $dateDisplay = date("d/m/Y", strtotime($challengeDate));
                $linkHTML .= '<div class="vc_col-sm-3 wpb_column vc_column_container"><div class="wpb_wrapper"><div class="wpb_text_column wpb_content_element">';
                $linkHTML .= '<div class="wpb_wrapper challengelink-button-wrapper">';
                $linkHTML .= '<a '.$onClickStr.' href="javascript:void(0);" title="User Body Stats For ' . $dateDisplay . '" class="tm-blog-more uk-button uk-button-primary uk-button-large uk-text-truncate">' . $dateDisplay . '</a>';
                $linkHTML .= '</div></div></div></div>';
            }
            //$linkHTML .= '</div>';
            $linkHTML .= '</div>';
        }
        return $linkHTML;
    }
    
    function getAllChallengeDates($startDate, $type)
    {
        $dateArray = array();
        $loopDate = "";
        
        if( $type == "User10DayChallenge")
        {
            for($dateCount = 1; $dateCount <=9; $dateCount ++){
                if( $dateCount == 1){
                    $loopDate = strtotime("+9 days", strtotime($startDate));
                }else{
                    $loopDate = strtotime("+10 days", strtotime($loopDate));
                }
                $loopDate = date("Y-m-d", $loopDate);
                //echo $loopDate . ",";
                $dateArray[] = $loopDate;
            }
        }
        else if( $type == "SelfAssessment")
        {
            for($dateCount = 1; $dateCount <=4; $dateCount ++){
                if( $dateCount == 1){
                    $loopDate = strtotime($startDate);                    
                }else{
                    $loopDate = strtotime("+30 days", strtotime($loopDate));
                }
                $loopDate = date("Y-m-d", $loopDate);
                $dateArray[] = $loopDate;
            }
        }
        else if( $type == "UserBodyData")
        {
            for($dateCount = 1; $dateCount <=10; $dateCount ++){
                if( $dateCount == 1){
                    $loopDate = strtotime($startDate);                    
                }else{
                    $loopDate = strtotime("+10 days", strtotime($loopDate));
                }
                $loopDate = date("Y-m-d", $loopDate);
                $dateArray[] = $loopDate;
            }
        }
        return $dateArray;
    }
    
    // return list challenge dates
    function getSelfAssessmentLinks($mode)
    {
        global $wpdb;
        $allowEdit = false;
        $allowAdd = false;
        
        if($mode == "Previous")
        {
            $challenges = $wpdb->get_results("SELECT * FROM mb90_user_assessment_translated WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID", OBJECT);

            if( $wpdb->num_rows > 0 )
            {
                $rows = array();
                foreach( $challenges as $key => $row)
                {
                    $rows[] = $row;
                }

                header("Content-type: application/json");

                $response = array("total" => $wpdb->num_rows, "rows" => $rows);

                echo json_encode($response);
            }
        }
        else if($mode == "All")
        {
            //$challengeDates = array();
            //$linkHTML = '<div class="mb90-challengeDatesWrapper">';
            $linkHTML .= '<div class="vc_row wpb_row vc_row-fluid">';
            //echo "SELECT * FROM mb90_user_assessment_translated WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID";
            // get completed challenges ... don't allow adding any new records to these
            $completedChallenges = $wpdb->get_results("SELECT * FROM mb90_user_assessment_translated WHERE UserID = ".$_SESSION["LoggedUserID"]." GROUP BY InputDate ORDER BY ID", OBJECT);
            
            if( $wpdb->num_rows > 0 )
            {
                $rows = array();
                foreach( $completedChallenges as $key => $row)
                {
                    $challengeCompletionDates[] = $row->InputDate;
                }
            }
            $startDateStr = $_SESSION["UserStartDate"];

            $allChallengeDates = $this->getAllChallengeDates($startDateStr, "SelfAssessment");
            $challengeDateCount = 1;

            //$linkHTML = '<div class="mb90-challengeDatesWrapper">';
            for($cd =0; $cd < count($allChallengeDates); $cd++)
            {
                $challengeDate = $allChallengeDates[$cd];
                $onClickStr = $this->getOnClick($challengeDate, $challengeCompletionDates, $cd+1, "User Self Assessment");         
                $dateDisplay = date("d/m/Y", strtotime($challengeDate));
                $linkHTML .= '<div class="vc_col-sm-3 wpb_column vc_column_container"><div class="wpb_wrapper"><div class="wpb_text_column wpb_content_element">';
                $linkHTML .= '<div class="wpb_wrapper challengelink-button-wrapper">';
                $linkHTML .= '<a '.$onClickStr.' href="javascript:void(0);" title="Self Assessment For ' . $dateDisplay . '" class="tm-blog-more uk-button uk-button-primary uk-button-large uk-text-truncate">' . $dateDisplay . '</a>';
                $linkHTML .= '</div></div></div></div>';
            }
            //$linkHTML .= '</div>';
            $linkHTML .= '</div>';
        }
        return $linkHTML;
    }
    
    function getOnClick($challengeDate, $challengeCompletionDates, $dateCount, $type)
    {
        $dates = array();
        $dates = $challengeCompletionDates;
        $tooSoonCaption = 'Too Soon ...';
        $tooSoonMsg = 'This '.$type.' date is in the future. You must wait until the specified date before completing this';
        $typeNoSpaces = str_replace(" ", "", $type);
        
        if($this->dateInFuture($challengeDate === true) && MB90_90_DEBUG){
        //if(false){
            $onClickStr = ' onclick="dialogHTML(\'Too soon ...\', \'This '.$type.' is in the future. You must wait until the specified date before completing this\')" ';
        }else{
            if(count($dates) > 0 && in_array($challengeDate, $dates)){ // already completed so only allow to edit
                $onClickStr = ' onclick="customFormHTML(\''.$typeNoSpaces.'\', \'edit\', \''.$challengeDate.'\', \''.$dateCount.'\', \''.$tooSoonMsg.'\', \''.$tooSoonCaption.'\')" ';
            }else{
                $onClickStr = ' onclick="customFormHTML(\''.$typeNoSpaces.'\', \'add\', \''.$challengeDate.'\', \''.$dateCount.'\', \''.$tooSoonMsg.'\', \''.$tooSoonCaption.'\')" ';
            }
        }
        return $onClickStr;
    }
    
    function dateInFuture($date)
    {
        $current_date = new DateTime();
        $current_date = $current_date->format('Y-m-d');
        //$this_date = new DateTime();
        //echo "currdate = [".$current_date."] ... date = [" .$date."]";
        if( $current_date < $date )
            return true;
        return false;
    }
    
    function GetSelfAssessmentExList(){
        global $wpdb;
        $exListing = "";
        $exCount = 0;
        //foreach( $wpdb->get_results("SELECT * FROM mb90_exercise_types WHERE IsSelfAssessment = 'Y'") as $key => $row){
        foreach( $wpdb->get_results("SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=1 AND ProgrammeID = 1 GROUP BY ExerciseID ORDER BY OrderNumber, ExerciseName, ExerciseMMType ASC" ) as $key => $row)
        {
           $exListing .= $row->ExerciseName . '##,##';
           $exCount ++;
        }
        return "<div id='exlisting'></div><input id='exlistinghidden' type='hidden' value='" . $exListing . "' /><input id='excount' type='hidden' value='" . $exCount . "' />";
    }
    
    function Get10DayChallengeExList(){
        global $wpdb;
        $exListing = "";
        $exCount = 0;
        //foreach( $wpdb->get_results("SELECT * FROM mb90_exercise_types WHERE Is10DayChallenge = 'Y'") as $key => $row){
        foreach( $wpdb->get_results("SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=8 AND ProgrammeID = 1 GROUP BY ExerciseID ORDER BY OrderNumber, ExerciseName, ExerciseMMType ASC" ) as $key => $row)
        {
           $exListing .= $row->ExerciseName . '##,##';
           $exCount ++;
        }
        return "<div id='exlisting'></div><input id='exlistinghidden' type='hidden' value='" . $exListing . "' /><input id='excount' type='hidden' value='" . $exCount . "' />";
    }
    
}


class graphDetails
{
    
}

?>
