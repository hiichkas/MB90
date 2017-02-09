<?php

    $pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';
    
    require_once($pluginPath . 'inc/scripts/dbase_include.php');
    require_once($pluginPath . 'inc/Classes/DataGridClass.php');
    
    function redirectTo($path){
        ob_start();
        header('Location: '.$path);
        ob_end_flush();
        die();        
    }
    
    // check if logged in and/or if course has been completed
    function CheckUserAccountOld()
    {
        if( strpos("localhost", $_SERVER["SERVER_NAME"]) !== false){
            $redirPath = "http://localhost:8080/MB90/";
        }else{
            $redirPath = "http://mybody90.com/";
        }
        if ( !is_user_logged_in() ) {
            redirectTo($redirPath . "login");
        }else{
            $userDetailsObj = new userDetails();
            $userDetailsArr = $userDetailsObj->getUserDetails($_SESSION["LoggedUserID"]);
            
            //print_r($userDetailsArr);
            //echo "count = [" . count($userDetailsArr) . "]";
            //die();
            
            if( count($userDetailsArr) === 0){ // if user details blank then redirect to account page
                //redirectTo($redirPath . "account?filluserdetails=Y");
            }else{
                $startDateStr = $_SESSION["UserStartDate"];
                $startDate = strtotime($startDateStr);
                $today = strtotime("now");
                $numberDaysSinceStart = floor(($today - $startDate)  / (60 * 60 * 24));
                
                //echo "startDateStr, startDate, numberDaysSinceStart = [" . $startDateStr . "][" . $startDate. "][" .$numberDaysSinceStart . "]";
                //die();

                if( $numberDaysSinceStart > MB90_NUM_DAYS){ // failsafe 
                    redirectTo($redirPath . "course-completed");   
                }
            }
        }
    }
    
    // check if user has filled profile yet
    /*function CheckUserAccountStatus()
    {
        if(current_user_can('memberpress_product_authorized_' . MB90_90_DAY_COURSE_ID)) { // if user authorised for 90 day course
            if( strpos("localhost", $_SERVER["SERVER_NAME"]) !== false){ // check if user has filled in profile
                $redirPath = "http://localhost:8080/MB90/";
            }else{
                $redirPath = "http://mybody90.com/";
            }
            $userDetailsObj = new userDetails();
            $userDetailsArr = $userDetailsObj->getUserDetails($_SESSION["LoggedUserID"]);

            if( count($userDetailsArr) === 0){ // if user details blank then redirect to account page
                redirectTo($redirPath . "account?filluserdetails=Y");
            }
        }
    }*/

    function CheckUserAccountStatus()
    {
        session_start();
        if(!isset($_SESSION["LoggedUserID"]) || empty($_SESSION["LoggedUserID"])) {
            $wpLoggedInUserID = get_current_user_id();
            $_SESSION["LoggedUserID"] = $wpLoggedInUserID;
        }

        if(current_user_can('memberpress_product_authorized_' . MB90_90_DAY_COURSE_ID)) { // if user authorised for 90 day course
            if( strpos("localhost", $_SERVER["SERVER_NAME"]) !== false){ // check if user has filled in profile
                $redirPath = "http://localhost:8080/MB90/";
            }else{
                $redirPath = "http://mybody90.com/";
            }
            $userDetailsObj = new userDetails();

	    //echo "loggedUserID = [" . $_SESSION["LoggedUserID"] . "]";

            $userDetailsArr = $userDetailsObj->getUserDetails($_SESSION["LoggedUserID"]);

            if( count($userDetailsArr) === 0){ // if user details blank then redirect to account page
                redirectTo($redirPath . "account?filluserdetails=Y");
		//echo "redirecting to profile page";
            }
        }
    }
    
    function GetUserDetails()
    {
        global $wpLoggedInUserID;
        
        session_start();
        if(!isset($_SESSION["LoggedUserID"]) || empty($_SESSION["LoggedUserID"])) {
            $wpLoggedInUserID = get_current_user_id();
            $_SESSION["LoggedUserID"] = $wpLoggedInUserID;
        }

        $userDetailsObj = new userDetails();
        $userDetailsArr = $userDetailsObj->getUserDetails($_SESSION["LoggedUserID"]);

        $bmi = $userDetailsArr['userBMI'];
        $bmr = $userDetailsArr['userBMR'];
        $tdee = $userDetailsArr['userTDEE'];
        
        echo '<input type="hidden" name="tdee" id="tdee" value=' . $tdee . ' />';
        echo '<input type="hidden" name="dietDailyCalories" id="dietDailyCalories" value=' . floor($tdee * 0.8) . ' />';
        echo '<input type="hidden" name="dietSelectedCalories" id="dietSelectedCalories" value="0" />';
        
    
    }
    
    function GetWeightGraph()
    {
        
        $chartObj = new chartFunctions();
        $weightGraphHTML = $chartObj->getWeightGraph();

        echo $weightGraphHTML;
    }
    
    function GetBMIGraph()
    {
        $graphObj = new chartFunctions();
        $bmiGraphHTML =  $graphObj->GetBMIGraph();
        
        echo $bmiGraphHTML;
    }

    function GetBMRGraph()
    {
        $graphObj = new chartFunctions();
        $bmrGraphHTML =  $graphObj->GetBMRGraph();
        
        echo $bmrGraphHTML;
    }

    function GetTDEEGraph()
    {
        $graphObj = new chartFunctions();
        $tdeeGraphHTML =  $graphObj->GetTDEEGraph();
        
        echo $tdeeGraphHTML;
    }

    function GetRowTemplate()
    {
        $rowStart = '<div class="vc_row wpb_row vc_row-fluid">' . "\r\n";
        $rowEnd = '</div>' . "\r\n";    

        $columnStart = '<div class="vc_col-sm-4 wpb_column vc_column_container">' . "\r\n";
        $columnStart .= '<div class="wpb_wrapper">' . "\r\n";

        $columnEnd = '</div></div>' . "\r\n";

        $columnHeaderStart = '<div class="wpb_text_column wpb_content_element">' . "\r\n";
        $columnHeaderStart .= '<div class="wpb_wrapper">' . "\r\n";

        $columnHeaderEnd .= '</div></div>' . "\r\n";

        $imageCellEnd = '</div></div></div></div></div>' . "\r\n";

        $videoCellStart = '<div class="wpb_video_widget wpb_content_element">' . "\r\n";
        $videoCellStart .= '<div class="wpb_wrapper">' . "\r\n";
        $videoCellStart .= '<div class="">' . "\r\n";

        $videoCellEnd = '</div></div></div>' . "\r\n";

   
        $rowTemplate = $rowStart;
        
        // day of week column
        $rowTemplate .= $columnStart;
        $rowTemplate .= $columnHeaderStart;
        $rowTemplate .= "<h2>DAY OF WEEK</h2>";
        $rowTemplate .= $columnHeaderEnd;
        
        $rowTemplate .= $videoCellStart;
        $rowTemplate .= '##DAYOFWEEK##';
        $rowTemplate .= $videoCellEnd;        
        $rowTemplate .= $columnEnd;
        
        // meal selection column
        $rowTemplate .= $columnStart;
        $rowTemplate .= $columnHeaderStart;
        $rowTemplate .= "<h2>MEALS FOR TODAY</h2>";
        $rowTemplate .= $columnHeaderEnd;
        
        $rowTemplate .= $videoCellStart;
        $rowTemplate .= '##SELECTEDMEALS##';
        $rowTemplate .= $videoCellEnd;        
        $rowTemplate .= $columnEnd;

        // Edit buttons column
        $rowTemplate .= $columnStart;
        $rowTemplate .= $columnHeaderStart;
        $rowTemplate .= "<h2>EDIT YOUR MENU</h2>";
        $rowTemplate .= $columnHeaderEnd;
        
        $rowTemplate .= $videoCellStart;
        $rowTemplate .= '##EDITBUTTON##';
        $rowTemplate .= $videoCellEnd;        
        $rowTemplate .= $columnEnd;
        
        $rowTemplate .= $rowEnd;
        
        $sep = GetRowSep();
        
        $rowTemplate .= $sep;
        
        return $rowTemplate;
    }
    
    function daysBetweenDates($startDate, $endDate)
    {
        //$datediff = $endDate - $startDate;
        $timeDiff = abs($endDate - $startDate);
        $numberDays = $timeDiff/86400; 
        
        return ceil($numberDays);
    }
    
    function BuildExScheduleInputForm()
    {
         $formHTML = "<form name='exScheduleForm' id='exScheduleForm' action='' method='POST'>";
         $formHTML .= "<input type='hidden' id='exDay' name='exDay' />";
         $formHTML .= "<input type='hidden' id='exDayType' name='exDayType' />";
         $formHTML .= "</form>";
         return $formHTML;
    }
    
    function GetExerciseNumberGrid($incPath)
    {
        $testmode = true;
        
        $userDetailsObj = new userDetails();
        $userDetailsArr = $userDetailsObj->getUserDetails($_SESSION["LoggedUserID"]);
        $userStartDate = strtotime($userDetailsArr['userstartdate']);
        
        $dayOfCourse = daysBetweenDates($userStartDate, time());
                
        // days that are not workouts 1,4,7,10
        //$nonWorkoutDaysArr = array(1,4,7,0);
        $nonWorkoutDaysArr = array(4,7,0);
        $fullDayCount = 0;
        $gridHTML = BuildExScheduleInputForm();

        if( (string)MB90_DEBUG == "true" && $_SESSION["LoggedUserID"] == MB90_ADMIN_USERID ){ // add 3 test days for debugging/testing
            
            //$test = '"' . MB90_DEBUG . '" ... [' . $_SESSION["LoggedUserID"] . '] ... [' . MB90_ADMIN_USERID . ']';
            $gridHTML .= '<div id="schedule-day-grid-wrapper">' . "\r\n";
            
            $gridHTML .= '<h2>Exercise Days</h2>' . "\r\n";
            $gridHTML .= '<div class="image-grid-wrapper image-grid-col-test">' . "\r\n";
               
            $gridHTML .= '<div class="image-grid-col image-grid-col-test">';
            $gridHTML .= '<a class="exDayScheduleLink" data-exday="-1" data-exdaytype="self-assessment" href="javascript:void(0);" title="Self Assessment">';
            $gridHTML .= '<div class="mb90-schedule-day-number mb90-schedule-day-number-circle mb90-test-day">Self Assessment Test</div>' . "\r\n";
            $gridHTML .= '</a></div>'; 

            $gridHTML .= '<div class="image-grid-col image-grid-col-test">';
            $gridHTML .= '<a class="exDayScheduleLink" data-exday="-2" data-exdaytype="normal-exday" href="javascript:void(0);" title="Workout">';
            $gridHTML .= '<div class="mb90-schedule-day-number mb90-schedule-day-number-circle mb90-test-day">Workout Test</div>' . "\r\n";
            $gridHTML .= '</a></div>'; 

            $gridHTML .= '<div class="image-grid-col image-grid-col-test">';
            $gridHTML .= '<a class="exDayScheduleLink" data-exday="-8" data-exdaytype="10-day-challenge" href="javascript:void(0);" title="10 Day Challenge">';
            $gridHTML .= '<div class="mb90-schedule-day-number mb90-schedule-day-number-circle mb90-test-day">10 Day Test</div>' . "\r\n";
            $gridHTML .= '</a></div>'; 

            $gridHTML .= '</div>';
                
        }
        
        $gridHTML .= '<div class="image-grid-wrapper">' . "\r\n";
        for($dayCount = 1; $dayCount <= MB90_NUM_DAYS; $dayCount ++ )
        {
            $opacityClass = "";
            if( $dayCount < $dayOfCourse){
                $opacityClass = MB90_HALF_OPACITY_CSS;
            }
            
            $gridHTML .= '<div class="image-grid-col">' . "\r\n";
            //$gridHTML .= '<h2 style="padding-right: 10px;    padding-top: 15px; float:left">PHASE [' . $rowCount. ']</h2>' . "\r\n";
            //for($dayCount = 1; $dayCount <= 10; $dayCount ++ )
            //{
                $fullDayCount ++;
                $fullDayCountPadded = ($fullDayCount < 10 ? "0" . $fullDayCount : $fullDayCount);
                
                // make only today a clickable day
                //if( $dayOfCourse == $fullDayCount){
                    $imageActiveClass = "active-exercise-dayicon";                
                    if( in_array($fullDayCount%10, $nonWorkoutDaysArr, true)) // just show static wordpress posts for these days
                    {
                        $link = '<a class="exDayScheduleLink" href="../your-exercise-details-post-' . ($fullDayCount%10 > 0 ? $fullDayCount%10 : 10) . '" title="Day ' . $fullDayCount. ' (Active Rest Day)">';
                    }
                    else
                    {
                        if( $fullDayCount%10 === 1){ // self assessment
                            $link = '<a class="exDayScheduleLink" data-exday="' . $fullDayCount . '" data-exdaytype="self-assessment" href="javascript:void(0);" title="Day ' . $fullDayCount. ' (Self Assessment)">';
                        }else if( $fullDayCount%10 === 8){ // 10 day challenge
                            $link = '<a class="exDayScheduleLink" data-exday="' . $fullDayCount . '" data-exdaytype="10-day-challenge" href="javascript:void(0);" title="Day ' . $fullDayCount. ' (10 Day Challenge)">';
                        }
                        else{ // all other exercise days
                            $link = '<a class="exDayScheduleLink" data-exday="' . $fullDayCount . '" data-exdaytype="normal-exday" href="javascript:void(0);" title="Day ' . $fullDayCount. ' (Workout)">';
                        }
                    }
                //}else{
                //    $imageActiveClass = "inactive-exercise-dayicon";
                //}
                
                $gridHTML .= '<div class="image-grid-image-div">' . "\r\n";
                $gridHTML .= $link;
                if( $fullDayCountPadded > 63) $fullDayCountPaddedBlue = $fullDayCountPadded + 1; else $fullDayCountPaddedBlue = $fullDayCountPadded;
                if( $fullDayCountPadded > 20 && $fullDayCountPadded < 64) 
                    $fullDayCountPaddedRed = $fullDayCountPadded + 6; 
                else if( $fullDayCountPadded >= 64) 
                    $fullDayCountPaddedRed = $fullDayCountPadded + 7;
                else 
                    $fullDayCountPaddedRed = $fullDayCountPadded;
                
                //$gridHTML .= '<img data-alt-src="'.$incPath.'images/numbers/mybodynumbers1-90Red-' . $fullDayCountPaddedRed . '.png" src="'.$incPath.'images/numbers/mybodynumbers1-90-' . $fullDayCountPaddedBlue . '.png" class="image-grid-image ' . $imageActiveClass . '" />' . "\r\n";
                $gridHTML .= '<div class="mb90-schedule-day-number mb90-schedule-day-number-circle ' . $opacityClass . '">' . $fullDayCountPadded . '</div>' . "\r\n";
                
                $gridHTML .= '</a>';
                $gridHTML .= '</div>' . "\r\n";
            //}            
            $gridHTML .= '</div>' . "\r\n";
            if( $fullDayCount % 10 == 0){
                $gridHTML .= '</div><div class="image-grid-wrapper">' . "\r\n";
            }
        }
        $gridHTML .= '</div>' . "\r\n";
        
        $gridHTML .= '</div>' . "\r\n"; // end of the schedule-day-grid-wrapper div
        
        echo $gridHTML;
    }
    
    function GetDietListingRows($UserID)
    {
        global $wpdb;
        $exListing = "";
        
        $currentDayNum = "";
        $rowHTML   = $rowStart;
        $DayOfWeekHTML = $columnHeaderStart . "<h2>Day Of Week</h2>" . $columnHeaderEnd;
        $oHTML = $columnHeaderStart . "<h2>Video</h2>" . $columnHeaderEnd;
        $descHTML  = "";
        $imageCount = 0;
        $videoCount = 0;
        $descriptionCount = 0;
        $rowCount   = 0;
        $rowHTMLArr = array();
        
        $selectedMeals = "";

        $sep = GetRowSep();

        //CREATE VIEW `mb90_user_diet_translated` AS 
        //SELECT `dt`.`ID`, `dt`.`MealTypeID`, `dt`.`MealTypeName`, `dt`.`MealName`, `ud`.`UserID`, `ud`.`DayNum` FROM `mb90_user_diet` `ud` JOIN `mb90_diet_translated` `dt`  on `ud`.`MealID` = `dt`.`ID`
        
        //echo "SELECT * FROM mb90_user_diet_translated WHERE UserID=" . $UserID . " order by DayNum, ID asc";
        foreach( $wpdb->get_results("SELECT * FROM mb90_user_diet_translated WHERE UserID=" . $UserID . " order by DayNum, ID asc" ) as $key => $row)
        {
            $dayNum = $row->DayNum;
            if( $currentDayNum !== $dayNum ){ // start a new row
                $imageCount = 0;
                $videoCount = 0;
                if( $currentDayNum !== "" ){ // if not the start of the 1st row
                    $rowHTML = str_replace("##SELECTEDMEALS##", $selectedMeals, $rowHTML); // swap in meal listing
                    $selectedMeals = "";
                    // now clean up placeholders that were not used
                    /*$rowHTML = str_replace("##SELECTEDMEALS##","",$rowHTML);
                    $rowHTML = str_replace("##IMAGE1##","",$rowHTML);
                    $rowHTML = str_replace("##IMAGE2##","",$rowHTML);
                    $rowHTML = str_replace("##IMAGE3##","",$rowHTML);
                    $rowHTML = str_replace("##IMAGE4##","",$rowHTML);
                     */
                    //echo "adding to array";
                    //array_push($rowHTMLArr, $rowHTML);
                    $rowHTMLArr[$currentDayNum] = $rowHTML;
                    $exListing .= $currentMealID . '##,##';
                }

                $rowHTML = GetRowTemplate();
                $dayOfWeek = GetDayOfWeek($row->DayNum);
                $rowHTML = str_replace("##DAYOFWEEK##",$dayOfWeek,$rowHTML); // swap in ex name
                //$rowHTML = str_replace("##EDITBUTTON##", '<input type="button" value="edit" />', $rowHTML); // swap in description
                //$rowHTML = str_replace("##EDITBUTTON##", '<input class="diet-edit-button" value="Edit Menu" type="button" onclick="window.open(\'../your-diet-builder?dow=' .$row->DayNum . '\',\'_self\')" />', $rowHTML); // swap in description
                $rowHTML = str_replace("##EDITBUTTON##", '<input class="diet-edit-button" value="Edit Menu" type="button" dow="' .$row->DayNum . '" />', $rowHTML); // swap in description
            }
            
            $selectedMeals .= '<p><strong>' . $row->MealTypeName . ':</strong> ' . $row->MealName . '&nbsp;(' . $row->CalorieCount. ' Cals)</p>';
            
            //echo "selmeals = ]" . $selectedMeals . "]";
            $currentDayNum = $row->DayNum;

        }
        $rowHTML = str_replace("##SELECTEDMEALS##", $selectedMeals, $rowHTML); // swap in meal listing
        //array_push($rowHTMLArr, $rowHTML);
        $rowHTMLArr[$row->DayNum] = $rowHTML;
        $exListing .= $currentMealID;

        //echo $rowStart . $imageHTML . $videoHTML . $descHTML . $rowEnd;
        //array_push($rowHTMLArr, $rowStart . $colummStart . $imageHTML . $columnEnd . $colummStart . $videoHTML . $columnEnd . $colummStart . $descHTML . $columnEnd . $rowEnd);
        
        //populate and blank days 
        for($i = 0; $i <= 7; $i++)
        {
            $blankDayNum = $i;
            if( $rowHTMLArr[$i] == null)
            {
                //$rowHTMLArr[$i] = "<p>TEST[" . $i . "]</p>";
                $blankRowHTML = GetRowTemplate();
                $blankDayOfWeek = GetDayOfWeek($blankDayNum);
                $blankRowHTML = str_replace("##DAYOFWEEK##",$blankDayOfWeek,$blankRowHTML);
                $blankRowHTML = str_replace("##SELECTEDMEALS##","NONE SELECTED",$blankRowHTML);
                $blankRowHTML = str_replace("##EDITBUTTON##", '<input class="diet-edit-button" value="Edit Menu" type="button" dow="' . $blankDayNum . '" />', $blankRowHTML);
                
                $rowHTMLArr[$i] = $blankRowHTML;
            }
        }

        
        $rowCount = 1;
/*        foreach( $rowHTMLArr as $rowHTMLstr){
            //echo "row [".$rowCount."] start";
            echo "[" . $rowCount . "] " . $rowHTMLstr;
            //echo $sep;
            //echo "row [".$rowCount."] end";
            $rowCount ++;
        }*/
        
        for($i = 1; $i <= 7; $i++)
        {
            echo $rowHTMLArr[$i];
        }
        
        echo '<input type="hidden" id="exlistinghidden" value="' . $exListing . '" />';
    }
    
    function GetDayOfWeek($dayNum)
    {
        $dates = array("", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        return strtoupper($dates[$dayNum]);
    }

    function GetDayOfWeekBlock($dayNum)
    {
        $dow = GetDayOfWeek($dayNum);
        echo $dow . '<input id="daynum" type="hidden" value="' . $_REQUEST["dow"] . '" />';
    }
    
    
    function GetRowSep()
    {
        $sepHTML = '<div class="vc_row wpb_row vc_row-fluid">' . "\r\n";
        $sepHTML .= '<div class="vc_col-sm-12 wpb_column vc_column_container">' . "\r\n";
        $sepHTML .= '<div class="wpb_wrapper">' . "\r\n";
        $sepHTML .= '<div class="vc_separator wpb_content_element vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_grey">' . "\r\n";
        $sepHTML .= '<span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span>' . "\r\n";
        $sepHTML .= '<span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>' . "\r\n";
        $sepHTML .= '</div></div></div></div>' . "\r\n";
        return $sepHTML;
    }


    function GetWeekDays()
    {
        $ddHTML = '<select id="dietDayDD">' . "\r\n";
        $ddHTML .= '<option value="">-- Please Select --</option>' . "\r\n";
        $ddHTML .= '<option value="1">Monday</option>' . "\r\n";
        $ddHTML .= '<option value="2">Tuesday</option>' . "\r\n";
        $ddHTML .= '<option value="3">Wednesday</option>' . "\r\n";
        $ddHTML .= '<option value="4">Thursday</option>' . "\r\n";
        $ddHTML .= '<option value="5">Friday</option>' . "\r\n";
        $ddHTML .= '<option value="6">Saturday</option>' . "\r\n";
        $ddHTML .= '<option value="7">Sunday</option>' . "\r\n";
        $ddHTML .= '</select>' . "\r\n";
        echo $ddHTML;
    }
    function GetDietJs()
    {
        //echo '<script src="'.$incPath.'js/timer/tabata-timer.js" type="text/javascript"></script>';
        echo '<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>';
        echo '<script src="' . MB90_90_EX_MENU_PLUGIN_URL . 'inc/js/diet/init.js" type="text/javascript"></script>';
    }

    function GetExerciseScheduleJs()
    {
        //echo '<script src="'.$incPath.'js/timer/tabata-timer.js" type="text/javascript"></script>';
        //echo '<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>';
        echo '<script src="' . MB90_90_EX_MENU_PLUGIN_URL . 'inc/js/exercise-schedule/exercise-schedule.js?v=1.100" type="text/javascript"></script>';
    }
    
    function GetExerciseScheduleCss()
    {
        echo '<link rel="stylesheet" href="' . MB90_90_EX_MENU_PLUGIN_URL . 'inc/css/exercise-schedule/exercise-schedule.css?v=1.000">';
        //echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';
        //echo '<link rel="stylesheet" href="'.$incPath.'css/jquery-ui-1.11.4-smoothness.css">';
    }
    
    function GetDietOptions($mode)
    {
        global $wpdb;
        $dietMealCount = 0;
        //$countSQL = "SELECT count(*) FROM mb90_prog_exercises WHERE ExerciseDay=" . $exDay . " AND ProgrammeID = 1";
        //$numExercises = $wpdb->get_var( $countSQL );
        $dietHTML = '<div id="accordion">' . "\r\n";
        
        //$dietHTML = '<h3>Section 1</h3>' . "\r\n";
        //$dietHTML = '<div>' . "\r\n";
        

        $currMealType = "";
        $prevMealType = "";
        foreach( $wpdb->get_results("SELECT * FROM mb90_diet_translated order by MealTypeID asc" ) as $key => $row)
        {
            $currMealType = $row->MealTypeName;
            if( $prevMealType !== $currMealType ){
                
                if( $prevMealType !== "" )
                    $dietHTML .= '</div>' . "\r\n"; // end section if not first section
                
                $dietHTML .= '<h3>' . $currMealType . '</h3><div class="accordion-section">'. "\r\n"; // start section
            }
            $dietHTML .= '<div id="' . $row->ID . '" class="diet-selector-item" calories="' . $row->CalorieCount . '"><p>' . $row->MealName . '</p></div>';
            
            $prevMealType = $row->MealTypeName;
        }

        $dietHTML .= '</div></div>' . "\r\n"; // end accordion
        
        echo $dietHTML;
    }
    
?>