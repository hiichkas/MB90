<?php

    global $wpdb;
    $pluginURL = plugins_url("mb90-user-data/");
    $pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';
    
    require_once($pluginPath . 'inc/scripts/dbase_include.php');
    require_once($pluginPath . 'inc/Classes/DataGridClass.php');

    //$exListing = "";

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
    function GetRowTemplate()
    {
        $rowStart = '<div class="vc_row wpb_row vc_row-fluid">' . "\r\n";
        $rowEnd = '</div>' . "\r\n";    

        $columnStart = '<div class="vc_col-sm-4 wpb_column vc_column_container">' . "\r\n";
        $columnStart .= '<div class="wpb_wrapper">' . "\r\n";
        
        $imageColumnStart = '<div class="vc_col-sm-2 wpb_column vc_column_container">' . "\r\n";
        $imageColumnStart .= '<div class="wpb_wrapper">' . "\r\n";
        
        $descColumnStart = '<div class="vc_col-sm-6 wpb_column vc_column_container">' . "\r\n";
        $descColumnStart .= '<div class="wpb_wrapper">' . "\r\n";

        $columnEnd = '</div></div>' . "\r\n";

        $columnHeaderStart = '<div class="wpb_text_column wpb_content_element">' . "\r\n";
        $columnHeaderStart .= '<div class="wpb_wrapper">' . "\r\n";

        $columnHeaderEnd .= '</div></div>' . "\r\n";

        $imagesRowStart = '<div class="vc_row wpb_row vc_inner vc_row-fluid">' . "\r\n";
        $imagesRowEnd = '</div>' . "\r\n";

        $imageCellStart = '<div class="vc_col-sm-12 wpb_column vc_column_container">' . "\r\n";
        $imageCellStart .= '<div class="wpb_wrapper">' . "\r\n";
        $imageCellStart .= '<div class="wpb_single_image wpb_content_element vc_align_">' . "\r\n";
        $imageCellStart .= '<div class="wpb_wrapper">' . "\r\n";
        $imageCellStart .= '<div class="vc_single_image-wrapper-custom vc_box_border_grey">' . "\r\n";

        
        $imageCellEnd = '</div></div></div></div></div>' . "\r\n";

        $videoCellStart = '<div class="wpb_video_widget wpb_content_element">' . "\r\n";
        $videoCellStart .= '<div class="wpb_wrapper">' . "\r\n";
        $videoCellStart .= '<div class="wpb_video_wrapper">' . "\r\n";

        $videoCellEnd = '</div></div></div>' . "\r\n";

        $videoLink = "";
        $imageLink = "";
        $descriptionText = "";
        $columnCaption .= '<h2>Anatomy</h2>' . "\r\n";
        $descriptionCaption = '<h2>##EXERCISENAME##</h2>' . "\r\n";

        $descriptionEnd = $columnEnd;
    
        $rowTemplate = $rowStart;
        $rowTemplate .= $imageColumnStart;
        $rowTemplate .= $columnHeaderStart;
        $rowTemplate .= "<h2>Anatomy</h2>";
        $rowTemplate .= $columnHeaderEnd;

        // need to loop through images here ... load them into an array

        $rowTemplate .= $imagesRowStart;
        $rowTemplate .= $imageCellStart;
        $rowTemplate .= "##IMAGE1##";
        $rowTemplate .= $imageCellEnd;
        $rowTemplate .= $imageCellStart;
        $rowTemplate .= "##IMAGE2##";
        $rowTemplate .= $imageCellEnd;
        $rowTemplate .= $imagesRowEnd;
        $rowTemplate .= $imagesRowStart;
        $rowTemplate .= $imageCellStart;
        $rowTemplate .= "##IMAGE3##";
        $rowTemplate .= $imageCellEnd;
        $rowTemplate .= $imageCellStart;
        $rowTemplate .= "##IMAGE4##";
        $rowTemplate .= $imageCellEnd;
        $rowTemplate .= $imagesRowEnd;
        $rowTemplate .= $columnEnd;

        $rowTemplate .= $columnStart;
        $rowTemplate .= $columnHeaderStart;
        $rowTemplate .= "<h2>Video</h2>";
        $rowTemplate .= $columnHeaderEnd;
        $rowTemplate .= $videoCellStart;
        //echo '<iframe width="500" height="281" frameborder="0" src="' . $row->ExerciseMMPath . '" allowfullscreen=""></iframe>';
        //echo '[embed width="500" height="281"]' . $row->ExerciseMMPath . '[/embed]';
        $rowTemplate .= '##EXERCISEVIDEOPATH##';
        $rowTemplate .= $videoCellEnd;        
        $rowTemplate .= $columnEnd;

        $rowTemplate .= $descColumnStart;
        //echo $columnHeaderStart;
        $rowTemplate .= "<h2>##EXERCISENAME##</h2>";
        //echo $columnHeaderEnd;
        //echo $videoCellStart;
        $rowTemplate .= '<p>##MESSAGE##</p>' . "\r\n";
        //echo $videoCellEnd;
        $rowTemplate .= $columnEnd;        
        $rowTemplate .= $rowEnd;
        
        $sep = GetRowSep();
        
        $rowTemplate .= $sep;
        
        return $rowTemplate;
    }
    
    function GetTimerJs()
    {
        if( strpos("localhost", $_SERVER["SERVER_NAME"]) !== false){
        $incPath = "http://localhost:8080/MB90/wp-content/plugins/exercise-menu/inc/";
        }else{
        $incPath = "http://mybody90.com/wp-content/plugins/exercise-menu/inc/";
        }
        
        echo '<script src="'.$incPath.'js/timer/tabata-timer.js" type="text/javascript"></script>';
        echo '<script src="'.$incPath.'js/timer/init.js" type="text/javascript"></script>';

        echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>';
        echo '<script src="'.$incPath.'js/progressTimer/js/jquery.progressTimer.js"></script>';
        
        echo '<script src="//cdn.rawgit.com/noelboss/featherlight/1.3.5/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>';
        
        //echo '<script src="'.$incPath.'js/asProgress/src/rainbow.min.js"></script>';        
        //echo '<script src="'.$incPath.'js/asProgress/src/jquery-asProgress.js"></script>';
        //echo '<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>';
        

        //echo '<script src="'.$incPath.'js/bootstrap-progressbar/bootstrap.progressbar.js"></script>';
    }
    
    function GetTimerCss()
    {
        if( strpos("localhost", $_SERVER["SERVER_NAME"]) !== false){
        $incPath = "http://localhost:8080/MB90/wp-content/plugins/exercise-menu/inc/";
        }else{
        $incPath = "http://mybody90.com/wp-content/plugins/exercise-menu/inc/";
        }
        
        //echo '<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">';
        echo '<link rel="stylesheet" href="'.$incPath.'css/timer/bootstrap.css">';
        //echo '<link rel="stylesheet" href="'.$incPath.'css/timer/timer-styling.css">';
        //echo '<link rel="stylesheet" href="'.$incPath.'css/timer/TimeCircles.css">';
        echo '<link rel="stylesheet" href="'.$incPath.'css/timer/tabata-timer.css">';
        
        echo '<link href="//cdn.rawgit.com/noelboss/featherlight/1.3.5/release/featherlight.min.css" type="text/css" rel="stylesheet" />';
        
        //echo '<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">';
        
/*echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/prelude.css">';
echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/rainbow.css">';
echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/progress.css">';*/
        
        //echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';

    }
    
    function redirectTo($path){
        ob_start();
        header('Location: '.$path);
        ob_end_flush();
        die();        
    }
    
    // check if user has filled profile yet
    function CheckUserAccountStatus()
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
    }
    
    function GetUserChallengeLinks()
    {
        $challengeObj = new Assessments();
        $challengeLinks = $challengeObj->get10DayChallengeLinks("All");
        echo $challengeLinks;
    }
    
    function GetSelfAssessmentLinks()
    {
        $challengeObj = new Assessments();
        $challengeLinks = $challengeObj->getSelfAssessmentLinks("All");
        echo $challengeLinks;
    }
    
    function GetBodyStatLinks()
    {
        $challengeObj = new Assessments();
        $challengeLinks = $challengeObj->getUserBodyStatLinks("All");
        echo $challengeLinks;
    }
    
    function GetStartButton()
    {
        if( strpos("localhost", $_SERVER["SERVER_NAME"]) !== false){
        $incPath = "http://localhost:8080/MB90/wp-content/plugins/mb90-user-data/inc/";
        }else{
        $incPath = "http://mybody90.com/wp-content/plugins/mb90-user-data/inc/";
        }
        $buttonLink = '<div class="start-button-caption" id="start-button">Click to Start <img class="timer-start start-button" src="' . $incPath . 'images/play-button.png" alt="Click to Start" name="Click to Start"/></div>';
        $buttonLink .= '<div id="start-button-html">Click to Start <img class="timer-start start-button" src="' . $incPath . 'images/play-button.png" alt="Click to Start" name="Click to Start"/></div>';
        $buttonLink .= '<div id="stop-button-html">Click to Stop <img class="timer-start start-button" src="' . $incPath . 'images/stop-button.png" alt="Click to Stop" name="Click to Stop"/></div>';
        echo $buttonLink;
    }
    
    function GetBlockDetails($exDay, $mode)
    {
        global $wpdb;
        $blockNum = ceil($exDay / 10);
        //echo "SELECT * FROM mb90_workout_timings WHERE BlockNum=" . $blockNum;
        $exCount = 0;
        if($exDay == "UserChallenge"){
            $countSQL = "SELECT count(*) FROM mb90_exercise_types WHERE Is10DayChallenge='Y'";
            $numRounds = MB90_USER_CHALLENGE_NUMROUNDS;
            $restBetweenRounds = MB90_USER_CHALLENGE_ROUNDREST;
            $timePerExercise = MB90_USER_CHALLENGE_EXTIME;
            $restAfterExercise = MB90_USER_CHALLENGE_REST;
        }else if($exDay == "SelfAssessment"){
            $countSQL = "SELECT count(*) FROM mb90_exercise_types WHERE IsSelfAssessment='Y'";
            $numRounds = MB90_SELF_ASSESSMENT_NUMROUNDS;
            $restBetweenRounds = MB90_SELF_ASSESSMENT_ROUNDREST;
            $timePerExercise = MB90_SELF_ASSESSMENT_EXTIME;
            $restAfterExercise = MB90_SELF_ASSESSMENT_REST;
        }else{
            $countSQL = "SELECT count(*) FROM mb90_prog_exercises WHERE ExerciseDay=" . $exDay . " AND ProgrammeID = 1";

            foreach( $wpdb->get_results("SELECT * FROM mb90_workout_timings WHERE BlockNum=" . $blockNum ) as $key => $row)
            {
                $numRounds = $row->NumberOfRounds;
                $restBetweenRounds = $row->RestAfterRound;
                $timePerExercise = $row->SecondsPerExercise;
                $restAfterExercise = $row->RestAfterExercise;
            }
        }

        $numExercises = $wpdb->get_var( $countSQL );
        
        //$numExercises = 10;
        $totalExSeconds = $numExercises * $timePerExercise;
        $totalExRestSeconds = ($numExercises-1) * $restAfterExercise;
        $totalRoundRestSeconds = ($numRounds-1) * $restBetweenRounds;

        $totalWorkoutTime = (($totalExSeconds + $totalExRestSeconds) * $numRounds) + $totalRoundRestSeconds;
        //echo "totqal = [".$totalWorkoutTime."]";
        $totalWorkoutTimeSecs = $totalWorkoutTime % 60;
        $totalWorkoutTimeMins = floor($totalWorkoutTime / 60);
        
        //$html = '<h1 style="text-align: left;">Block ' . $blockNum . ': </h1>' . "\r\n";
        
        //$html = '<h1 style="text-align: left;">Num Exercises ' . $numExercises . ': </h1>' . "\r\n";
        
        //$html .= '<p class="p1" style="text-align: left;">' . $numExercises. ' exercises x ' . $numRounds . ' rounds with ' . $restBetweenRounds . ' seconds rest between rounds. ' . $timePerExercise . ' seconds per exercise with ' . $restAfterExercise . ' seconds rest per exercise</p>' . "\r\n";

        //$html .= '<h4>When you\'re ready, hit that timer and follow the list on the right. The timer will beep when you need to rest or get into the next exercise. Have fun!</h4>' . "\r\n";
        $html .= '<input type="hidden" id="totalworkouttimestring" value="' . $totalWorkoutTimeMins . ' minutes ' . $totalWorkoutTimeSecs . ' seconds" />' . "\r\n";
        $html .= '<input type="hidden" id="numexercises" value="' . $numExercises . '" />' . "\r\n";
        $html .= '<input type="hidden" id="roundsdisplay" value="' . $numRounds . '" />' . "\r\n";
        $html .= '<input type="hidden" id="roundrest" value="' . $restBetweenRounds . '" />' . "\r\n";
        $html .= '<input type="hidden" id="exrest" value="' . $restAfterExercise . '" />' . "\r\n";
        $html .= '<input type="hidden" id="work" value="' . $timePerExercise . '" />' . "\r\n";
        $html .= '<input type="hidden" id="rounds" value="' . $numRounds * $numExercises . '" />' . "\r\n";
        $html .= '<input type="hidden" id="totalworkouttime" value="' . (($totalWorkoutTimeMins * 60) + $totalWorkoutTimeSecs)*1000 . '" />' . "\r\n";
        
        // set a hidden var with times
        //$html .= '<input type="hidden" id="totalTime" value="' . $totalWorkoutTime . '" />' . "\r\n";
        //$html .= '<div class="example" data-timer="' . $totalWorkoutTime . '"></div>' . "\r\n";
        echo $html;        
        /*if( mode == "show")
            echo $html;
        if( mode == "show")
            return $html;*/
    }
    
    function GetExerciseListing($exDay)
    {
        
        
    }
    
    function GetTimingListing($exDay)
    {

    }

    function GetSelfAssessmentExList(){
        $challengObj = new Assessments();
        return $challengObj->GetSelfAssessmentExList();
    }

    function Get10DayChallengeExList(){
        $challengObj = new Assessments();
        return $challengObj->Get10DayChallengeExList();
        //return "test";
    }
    
    function GetMediaRows($exDay)
    {
        //echo "exday111 = [" . $exDay . "]";
        global $wpdb;
        $exListing = "";
        //$exListing = "";
        
        $currentExName = "";
        $rowHTML   = $rowStart;
        $imageHTML = $columnHeaderStart . "<h2>Anatomy</h2>" . $columnHeaderEnd;
        $videoHTML = $columnHeaderStart . "<h2>Video</h2>" . $columnHeaderEnd;
        $descHTML  = "";
        $imageCount = 0;
        $videoCount = 0;
        $descriptionCount = 0;
        $rowCount   = 0;
        $rowCountTotal = 0;
        $rowHTMLArr = array();

        $sep = GetRowSep();

        //echo "SQL = [" . "SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=" . $exDay . " AND ProgrammeID = 1 order by ExerciseName, ExerciseMMType asc" . "]";
        foreach( $wpdb->get_results("SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=" . $exDay . " AND ProgrammeID = 1 order by ExerciseName, ExerciseMMType asc" ) as $key => $row)
        {
            $rowCountTotal ++;
            $exName = $row->ExerciseName;
            if( $currentExName !== $exName ){ // start a new row
                //echo "new row";
                $imageCount = 0;
                $videoCount = 0;
                if( $currentExName !== "" ){ // if not the start of the 1st row
                    // now clean up placeholders that were not used
                    $rowHTML = str_replace("##EXERCISEVIDEOPATH##","",$rowHTML);
                    $rowHTML = str_replace("##IMAGE1##","",$rowHTML);
                    $rowHTML = str_replace("##IMAGE2##","",$rowHTML);
                    $rowHTML = str_replace("##IMAGE3##","",$rowHTML);
                    $rowHTML = str_replace("##IMAGE4##","",$rowHTML);
                    //echo "adding to array";
                    array_push($rowHTMLArr, $rowHTML);
                    $exListing .= $currentExName . '##,##';
                }

                $rowHTML = GetRowTemplate();
                $rowHTML = str_replace("##EXERCISENAME##",$row->ExerciseName,$rowHTML); // swap in ex name
                $rowHTML = str_replace("##MESSAGE##", $row->Message, $rowHTML); // swap in description
            }

            // now process if an image
            if( $row->ExerciseMMType == "Image" && $imageCount == 0){ // restrict to 1 image only
                $imageCount ++;
                $imageHTMLStr = '<a href="#" data-featherlight="#exImageName_' . $rowCountTotal . '"><img width="100" height="100" class="vc_single_image-img-custom" src="' . $row->ExerciseMMPath . '" id="exImageName_' . $rowCountTotal . '" alt="' . $row->ExerciseName . '" title="' . $row->ExerciseName . '"></a>';
                //echo "11##IMAGE' . $imageCount. '##11";
                $rowHTML = str_replace("##IMAGE" . $imageCount. "##", $imageHTMLStr, $rowHTML); // swap in image html
            }

            // now process if a video
            if( $row->ExerciseMMType == "Video" && $videoCount == 0){ // only allow 1 video
                $videoCount ++;
                $embedCode = wp_oembed_get($row->ExerciseMMPath);
                $rowHTML = str_replace("##EXERCISEVIDEOPATH##", $embedCode, $rowHTML); // swap in image path
            }

            $currentExName = $row->ExerciseName;

        }

        $rowHTML = str_replace("##EXERCISEVIDEOPATH##","",$rowHTML);
        $rowHTML = str_replace("##IMAGE1##","",$rowHTML);
        $rowHTML = str_replace("##IMAGE2##","",$rowHTML);
        $rowHTML = str_replace("##IMAGE3##","",$rowHTML);
        $rowHTML = str_replace("##IMAGE4##","",$rowHTML);             

        array_push($rowHTMLArr, $rowHTML);
        $exListing .= $currentExName;

        //echo $rowStart . $imageHTML . $videoHTML . $descHTML . $rowEnd;
        //array_push($rowHTMLArr, $rowStart . $colummStart . $imageHTML . $columnEnd . $colummStart . $videoHTML . $columnEnd . $colummStart . $descHTML . $columnEnd . $rowEnd);
        $rowCount = 1;
        foreach( $rowHTMLArr as $rowHTMLstr){
            //echo "row [".$rowCount."] start";
            echo $rowHTMLstr;
            //echo $sep;
            //echo "row [".$rowCount."] end";
            $rowCount ++;
        }
        
        echo '<input type="hidden" id="exlistinghidden" value="' . $exListing . '" />';
    }
    
    //echo "PHASE1 = [" . $_REQUEST["exday"] . "]";
    $exDay = $_REQUEST["localexday"];
    $action = $_REQUEST["exaction"];
    
/*    if( $action == "localexdayblockdetails" ){
        
    }else if( $action == "localexdayexlist" ){
        
    }else if( $action == "localexdayextiminglist" ){
        
    } else if ($action == "localexdaymediarows") {
        GetMediaRows();
    }*/
    

    //global $current_user;
    //get_currentuserinfo();
    //$current_user = wp_get_current_user();
    //$user = $current_user->display_name;

?>