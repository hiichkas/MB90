<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilitiesClass
 *
 * @author Rob O'Hea
 */

require_once(plugin_dir_path(dirname(__FILE__)) . "/Classes/DataGridClass.php"); 
require_once(plugin_dir_path(dirname(__FILE__)) . "/constants/constants.php"); 

class UtilitiesClass {
    
    public static function getRootURL()
    {
        $path = get_site_url();
        return $path;
    }
    
    public static function getRootPath()
    {
        $path = realpath(dirname(__FILE__));
        $rootURLArr = split("wp-content", $path);
        $urlPath = $_SERVER['REQUEST_URI'];
        $sep = "/";
        $userIncPath = $rootURLArr[0] . $sep . "wp-content" . $sep . "plugins" . $sep . "mb90-user-data" . $sep;
        
        return $userIncPath;
    }
    
    public static function redirectTo($path){
        ob_start();
        header('Location: '.$path);
        ob_end_flush();
        die();        
    }

    
    public static function wrapInHTML($tag, $contents)
    {
        return "<" . $tag . ">" . $contents . "</" . $tag . ">";
    }
    
    public static function GetVersionString()
    {
        if( MB90_DEBUG && $_SESSION["LoggedUserID"] == MB90_ADMIN_USERID ){
            return  "?v=" . microtime(true);
        }else{
            return "";
        }
       
    }
    
    // echo a chart container div with loader spinner image 
    public static function AddChartContainer()
    {
        echo '<div id="chart-container-lower"></div>';
    }
    
    public static function AddAjaxLoader()
    {
        echo '<div style="width:100%; text-align: center;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>';
    }
    
    function GetTimerJs()
    {
        global $post;
        $page_slug = $post->post_name;
        
        //$incPath = self::getRootURL() . MB90_90_EX_MENU_INC_FOLDER_PATH;
        $incPath = get_site_url() . MB90_90_EX_MENU_INC_FOLDER_PATH;
        $mb90ScriptVersion = self::GetVersionString();
        //echo '<script src="'.$incPath.'js/rangeslider/rangeslider.js?v=1.003"></script>'."\r\n";        
        
        //echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>';
        
        //echo '<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>';
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>'."\r\n";
        //echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js?v=1.0" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>'."\r\n";
        echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>'."\r\n";

        echo '<script src="'.$incPath.'js/jquery.actual.min.js'.$mb90ScriptVersion.'" type="text/javascript"></script>'."\r\n"; // used to get dimensions of hidden vars
        echo '<script src="'.$incPath.'js/timer/tabata-timer.js'.$mb90ScriptVersion.'" type="text/javascript"></script>'."\r\n";
        echo '<script src="'.$incPath.'js/timer/init.js'.$mb90ScriptVersion.'" type="text/javascript"></script>'."\r\n";
        
        echo '<script src="'.$incPath.'js/progressTimer/js/jquery.progressTimer.js'.$mb90ScriptVersion.'"></script>'."\r\n";
        
        echo '<script src="//cdn.rawgit.com/noelboss/featherlight/1.3.5/release/featherlight.min.js'.$mb90ScriptVersion.'" type="text/javascript" charset="utf-8"></script>'."\r\n";
        
        if( strtolower($page_slug) == MB90_WORKOUT_DAY_PAGE_SLUG) {
            echo '<script type="text/javascript">' . "\r\n";
            echo '        jQuery( document ).ready(function() {' . "\r\n";
            //echo '        timing_html = jQuery("#exTimings").clone().wrap("<p>").parent().html();' . "\r\n";
            //echo '        jQuery("#exTimings").remove();' . "\r\n";
            //echo '        jQuery("#exercies-inputform-wrapper").html(timing_html);' . "\r\n";
            /*echo '        jQuery("#exTimings").on("click", function(){' . "\r\n";
            echo '            if( jQuery("#exercise-summaryinfo-wrapper").css("display") == "none"){' . "\r\n";
            echo '                jQuery("#exTimgingsCaption").html("' . MB90_EXERCISE_HIDE_TIMINGS_CAPTION . '");' . "\r\n";
            echo '                jQuery("#exercise-summaryinfo-wrapper").slideDown(1000);' . "\r\n";
            echo '            }else{'."\r\n";
            echo '                jQuery("#exTimgingsCaption").html("' . MB90_EXERCISE_VIEW_TIMINGS_CAPTION . '");' . "\r\n";
            echo '                jQuery("#exercise-summaryinfo-wrapper").slideUp(1000);            '."\r\n";
            echo '            }' . "\r\n";
            echo '        });' . "\r\n";*/
            echo '        jQuery("#exercise-summaryinfo-wrapper").show();' . "\r\n";
            echo '        jQuery(".outer-timer-wrapper").show();' . "\r\n";
            echo '    });' . "\r\n";
            echo '</script>' . "\r\n";
        }

        //echo '<script src="'.$incPath.'js/asProgress/src/rainbow.min.js"></script>'."\r\n";
        //echo '<script src="'.$incPath.'js/asProgress/src/jquery-asProgress.js"></script>'."\r\n";
        //echo '<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>'."\r\n";
        

        //echo '<script src="'.$incPath.'js/bootstrap-progressbar/bootstrap.progressbar.js"></script>';
    }
    
    public static function GetTimingListing($exDay)
    {
        $exDay = $exDay % 10;
    }
    
    public static function GetTimerCss()
    {
        //$incPath = self::getRootURL() . MB90_90_EX_MENU_INC_FOLDER_PATH;
        $incPath = get_site_url() . MB90_90_EX_MENU_INC_FOLDER_PATH;

        $mb90ScriptVersion = self::GetVersionString();
        
        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">'."\r\n";
        //echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"'.$mb90ScriptVersion.'>';
        echo '<link rel="stylesheet" href="'.$incPath.'css/timer/tabata-timer.css'.$mb90ScriptVersion.'">'."\r\n";
        echo '<link href="//cdn.rawgit.com/noelboss/featherlight/1.3.5/release/featherlight.min.css" type="text/css" rel="stylesheet" />'."\r\n";
        echo '<link rel="stylesheet" href="'.$incPath.'js/rangeslider/nouislider.min.css'.$mb90ScriptVersion.'">'."\r\n";
        
        // include some js that needs to be loaded earlier
        echo '<script src="'.$incPath.'js/rangeslider/nouislider.min.js'.$mb90ScriptVersion.'"></script>'."\r\n"; 
        echo '<script src="//use.fontawesome.com/bcc1886acd.js"></script>'."\r\n"; 
        
        echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/prelude.css">'."\r\n";
        echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/rainbow.css">'."\r\n";
        echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/progress.css">'."\r\n";
        
        echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';

    }
    
    public static function GetDateLinks($page_slug)
    {
        switch (strtolower($page_slug)) {
            case MB90_SELF_ASSESSMENT_PAGE_SLUG:
                self::GetSelfAssessmentLinks();
                break;
            case MB90_10_DAY_CHALLENGE_PAGE_SLUG:
                self::GetUserChallengeLinks();
                break;
            case MB90_WORKOUT_DAY_PAGE_SLUG:
                break;
            default:
                break;
        }
    }
    
    public static function GetSelfAssessmentLinks()
    {
        $challengeObj = new Assessments();
        $challengeLinks = $challengeObj->getSelfAssessmentLinks("All");
        echo $challengeLinks;
    }
    
    public static function GetSelfAssessmentExList(){
        $challengObj = new Assessments();
        return $challengObj->GetSelfAssessmentExList();
    }
    
    public static function GetUserChallengeLinks()
    {
        $challengeObj = new Assessments();
        $challengeLinks = $challengeObj->get10DayChallengeLinks("All");
        echo $challengeLinks;
    }
    
    public static function GetUserChallengeExList(){
        $challengObj = new Assessments();
        return $challengObj->Get10DayChallengeExList();
    }    
    
    public static function GetBodyStatLinks()
    {
        $challengeObj = new Assessments();
        $challengeLinks = $challengeObj->getUserBodyStatLinks("All");
        echo $challengeLinks;
    }
    
    public static function GetExListingArrayForDay($day)
    {
        global $wpdb;
        
        $listingArr = array();
        foreach( $wpdb->get_results("SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=" . $day . " AND ProgrammeID = 1 GROUP BY ExerciseID ORDER BY OrderNumber, ExerciseName, ExerciseMMType ASC" ) as $key => $row)
        {
            array_push($listingArr, $row->ExerciseName);
        }
        return $listingArr;
    }
    
    public static function GetBlockDetails($page_slug)
    {
        global $wpdb;
        $exDay = $_REQUEST["exDay"];
        $mode = $_REQUEST["exDayType"];
        if( strlen($exDay) == 0 )
        {
            $redirPath = get_site_url() . MB90_90_EX_SCHEDULE_FOLDER_PATH;
            self::redirectTo($redirPath);
        }
        else
        {
            switch ($exDay) {
                case -1:
                    $blockNum = -1; // gets the set of test timings for Self Assessment
                    $exDay = 1;
                    break;
                case -2:
                    $blockNum = -2; // gets the set of test timings for Normal Workout Day
                    $exDay = 2;
                    break;
                case -8:
                    $blockNum = -8; // gets the set of test timings for 10 Day Challenge
                    $exDay = 8;
                    break;
                default:
                    $blockNum = ceil($exDay / 10);
                    $exDay = $exDay % 10;
                    break;
            }
            $exCount = 0;
            $roundGroupings = 1;

            //$exDayOri = $exDay;


            foreach( $wpdb->get_results("SELECT * FROM mb90_workout_timings WHERE BlockNum=" . $blockNum ) as $key => $row)
            {
                $numRounds = $row->NumberOfRounds;
                if( $exDay == 9 ){ // the 9th day is set to be the double round exercise setup
                    $roundGroupings = 2; // used to group rounds together with no round rests inbetween
                }
                //$roundGroupings = $row->RoundGroupings; // used to group rounds together with no round rests inbetween
                $restBetweenRounds = $row->RestAfterRound;
                $timePerExercise = $row->SecondsPerExercise;
                $restAfterExercise = $row->RestAfterExercise;
            }

            $countSQL = "SELECT count(*) FROM mb90_prog_exercises WHERE ExerciseDay=" . $exDay . " AND ProgrammeID = 1";
            $numExercises = $wpdb->get_var( $countSQL );

            if( $roundGroupings > 1 )
            {
                $numExercises = $numExercises * $roundGroupings;
            }

            $totalExSeconds = $numExercises * $timePerExercise;
    //        $totalExRestSeconds = ($numExercises-1) * $restAfterExercise;
            $totalExRestSeconds = ($numExercises) * $restAfterExercise;

            if( $roundGroupings > 1 ) // need to decrement the total time as there are less end of round rests when rounds are grouped together
            {
                //$totalRoundRestSeconds = ($numRounds-(1+$roundGroupings)) * $restBetweenRounds;
                //$totalRoundRestSeconds = ($roundGroupings-1) * $restBetweenRounds;
                //$totalWorkoutTime = ((($totalExSeconds + $totalExRestSeconds)) * $numRounds) + ($restBetweenRounds * $numRounds-1);
                $totalWorkoutTime = ((($totalExSeconds + $totalExRestSeconds)) * $numRounds) + ($restBetweenRounds * ($numRounds-1));
            }
            else
            {
                //$totalRoundRestSeconds = ($numRounds-1) * $restBetweenRounds;
                $totalWorkoutTime = (($totalExSeconds + $totalExRestSeconds) * $numRounds) + ($restBetweenRounds * ($numRounds-1));
            }

            $totalWorkoutTimeSecs = $totalWorkoutTime % 60;
            $totalWorkoutTimeMins = floor($totalWorkoutTime / 60);

            //$html = '<h1 style="text-align: left;">Block ' . $blockNum . ': </h1>' . "\r\n";

            //$html = '<h1 style="text-align: left;">Num Exercises ' . $numExercises . ': </h1>' . "\r\n";

            //$html .= '<p class="p1" style="text-align: left;">' . $numExercises. ' exercises x ' . $numRounds . ' rounds with ' . $restBetweenRounds . ' seconds rest between rounds. ' . $timePerExercise . ' seconds per exercise with ' . $restAfterExercise . ' seconds rest per exercise</p>' . "\r\n";

            //$html .= '<h4>When you\'re ready, hit that timer and follow the list on the right. The timer will beep when you need to rest or get into the next exercise. Have fun!</h4>' . "\r\n";

            $html .= '<input type="hidden" id="exDayLocal" value="' . $exDay . '" />' . "\r\n";
            $html .= '<input type="hidden" id="totalworkouttimestring" value="' . $totalWorkoutTimeMins . ' minutes ' . $totalWorkoutTimeSecs . ' seconds" />' . "\r\n";
            $html .= '<input type="hidden" id="numexercises" value="' . $numExercises . '" />' . "\r\n";
            $html .= '<input type="hidden" id="roundsdisplay" value="' . $numRounds . '" />' . "\r\n";
            $html .= '<input type="hidden" id="roundgroupings" value="' . $roundGroupings . '" />' . "\r\n";
            $html .= '<input type="hidden" id="roundrest" value="' . $restBetweenRounds . '" />' . "\r\n";
            $html .= '<input type="hidden" id="exrest" value="' . $restAfterExercise . '" />' . "\r\n";
            $html .= '<input type="hidden" id="work" value="' . $timePerExercise . '" />' . "\r\n";
            $html .= '<input type="hidden" id="rounds" value="' . $numRounds * $numExercises . '" />' . "\r\n";
            $html .= '<input type="hidden" id="totalworkouttime" value="' . (($totalWorkoutTimeMins * 60) + $totalWorkoutTimeSecs)*1000 . '" />' . "\r\n";

            // set a hidden var with times
            //$html .= '<input type="hidden" id="totalTime" value="' . $totalWorkoutTime . '" />' . "\r\n";
            //$html .= '<div class="example" data-timer="' . $totalWorkoutTime . '"></div>' . "\r\n";
            echo "<div class='outer-timer-wrapper'>";
            echo $html;        
            echo "</div>";
            /*if( mode == "show")
                echo $html;
            if( mode == "show")
                return $html;*/
        }
    }
    
    public static function GetStartButton()
    {
        global $post;
        $page_slug = $post->post_name; // used to process the appropriate page
        $incPath = get_site_url() . MB90_90_USER_DATA_INC_FOLDER_PATH;

        $buttonLink = '<div class="outer-timer-wrapper">' . "\r\n";
        $buttonLink .= '<div class="progressbar-wrapper-outer">' . "\r\n";
        
        //$buttonLink .= '<div class="progressbar-caption">TOTAL TIME: <span id="totalworkouttimespan"></span></div>' . "\r\n";
        $buttonLink .= '<div id="total-progress-timer" class="progressbar-wrapper"></div><div class="progress-bar-caption-overlay">TOTAL TIME</div>' . "\r\n";
        //$buttonLink .= '<div class="progressbar-caption">EXERCISE TIME</div>' . "\r\n";
        $buttonLink .= '<div id="exercise-progress-timer" class="progressbar-wrapper"></div><div class="progress-bar-caption-overlay">EXERCISE TIME</div>' . "\r\n";
        //$buttonLink .= '<div class="progressbar-caption">REST TIME</div>' . "\r\n";
        $buttonLink .= '<div id="rest-progress-timer" class="progressbar-wrapper"></div><div class="progress-bar-caption-overlay">REST TIME</div>' . "\r\n";
        
        $buttonLink .= '</div>' . "\r\n";
            
        /*$buttonLink .= '<div class="start-button-caption" id="start-button">Click to Start <img class="timer-start start-button" src="' . $incPath . 'images/play-button.png" alt="Click to Start" name="Click to Start"/></div>' . "\r\n";
        $buttonLink .= '<div id="start-button-html">Click to Start <img class="timer-start start-button" src="' . $incPath . 'images/play-button.png" alt="Click to Start" name="Click to Start"/></div>' . "\r\n";
        $buttonLink .= '<div id="stop-button-html">Click to Stop <img class="timer-start start-button" src="' . $incPath . 'images/stop-button.png?v=1.0" alt="Click to Stop" name="Click to Stop"/></div>' . "\r\n";
         */
        
        $buttonLink .= '<div class="start-button-caption" id="start-button">Click to Start <i class="timer-start start-button fa fa-play-circle" aria-hidden="true" alt="Click to Start"></i></div>' . "\r\n";
        $buttonLink .= '<div id="start-button-html">Click to Start <i class="timer-start start-button fa fa-play-circle" aria-hidden="true" alt="Click to Start"></i></div>' . "\r\n";
        $buttonLink .= '<div id="stop-button-html">Click to Stop <i class="timer-start start-button fa fa-stop-circle" aria-hidden="true" alt="Click to Stop"></i></div>' . "\r\n";
        
        //if( MB90_90_DEBUG ){
        switch (strtolower($page_slug)) {
            case MB90_SELF_ASSESSMENT_PAGE_SLUG:
                $buttonLink .= self::GetExerciseTimings();
                break;
            case MB90_10_DAY_CHALLENGE_PAGE_SLUG:
                $buttonLink .= self::GetExerciseTimings();
                break;
            case MB90_WORKOUT_DAY_PAGE_SLUG:
                break;
            default:
                break;
        }

        $buttonLink .= '</div>' . "\r\n";
        
        echo $buttonLink;
    }
    
    public static function GetExerciseTimings()
    {
        global $post;
        $page_slug = $post->post_name;
        /*if( strtolower($page_slug) == MB90_WORKOUT_DAY_PAGE_SLUG) {
            $exTimingsCaption = MB90_EXERCISE_VIEW_TIMINGS_STATIC_CAPTION;
        }else{
            $exTimingsCaption = MB90_EXERCISE_VIEW_TIMINGS_CAPTION;
        }*/
        $exTimingsCaption = MB90_EXERCISE_VIEW_TIMINGS_STATIC_CAPTION;
        $exTimingHTML = '<div id="exTimings"><strong><div id="exTimgingsCaption">' . $exTimingsCaption . ': </div></strong><div id="exercise-summaryinfo-wrapper"><div id="exercise-summaryinfo"></div>';
        $exTimingHTML .= '<br /><strong>Total Time: </strong><br /><span id="totalworkouttimespandisplay"></span></div></div>';
        return $exTimingHTML;
    }
    
    public static function GetCurrentNextExercises()
    {
        $exScrollerHTML = '<div class="outer-timer-wrapper">' . "\r\n";
        
        $exScrollerHTML .= '<div class="mb90-scroller-buttons horizon horizon-prev"><<</div><div class="mb90-scroller-buttons horizon horizon-next">>></div>' . "\r\n";
        
        $exScrollerHTML .= '<div class="timer-display">00:00.00</div>' . "\r\n";
        
        $exScrollerHTML .= '<div id="mb90-exercise-scroller"><div class="ex-scroller-center" id="ex-scroller-content">' . "\r\n";
        
        $exListing = self::GetExListingArrayForDay(MB90_SELF_ASSESSMENT_DAY_NUMBER);
        foreach($exListing as $key=>$exerciseCaption)
        {
            if( $key == 0){
                $exScrollerHTML .= '<div class="exerciseListItem ex-scroller-internal"><button class="btn mb90-nopointer current-exercise animated">' . $exerciseCaption . '</button></div>' . "\r\n";
            }else{
                $exScrollerHTML .= '<div class="exerciseListItem ex-scroller-internal"><button class="btn mb90-nopointer unselected-exercise">' . $exerciseCaption . '</button></div>' . "\r\n";
            }
        }

        $exScrollerHTML .= '</div>' . "\r\n"; // close off the #ex-scroller-content div
        
        $exScrollerHTML .= '</div>' . "\r\n"; // close off the mb90-exercise-scroller div
        
        $exScrollerHTML .= '</div>' . "\r\n"; // close off the outer-timer-wrapper div
        
        echo $exScrollerHTML;
        
        /*
        $finalHTML = "";
        
        // new col
        $currNextHTML = '<div class="outer-timer-wrapper">' . "\r\n";
        $currNextHTML .= '<div class="timer-display">00:00.00</div>' . "\r\n";
        $currNextHTML .= '<div id="current-exercise" class="timer-exercise-label"><button class="btn mb90-nopointer">...</button></div>' . "\r\n";
        $currNextHTML .= '</div>' . "\r\n";

        $finalHTML .= self::WrapColumn($currNextHTML, 4);
        
        // new col
        $currNextHTML = '<div class="outer-timer-wrapper">' . "\r\n";
        $currNextHTML .= '<div id="nextExercise" class="timer-exercise-label"><button class="btn mb90-nopointer">...</button></div>' . "\r\n";
        $currNextHTML .= '</div>' . "\r\n";
        
        $finalHTML .= self::WrapColumn($currNextHTML, 4);
        
        // new col
        $currNextHTML = '<div class="outer-timer-wrapper">' . "\r\n";
        $currNextHTML .= '<div id="thirdExercise" class="timer-exercise-label"><button class="btn mb90-nopointer">...</button></div>' . "\r\n";
        $currNextHTML .= '</div>' . "\r\n";
        
        $finalHTML .= self::WrapColumn($currNextHTML, 4);

        
        $finalHTML = self::WrapRow($finalHTML);
        
        echo "<div class='ex-scroller-center' id='ex-scroller-content'>";
        echo '<div class="outer-timer-wrapper"><div class="timer-display">00:00.00</div><div id="mb90-exercise-scroller"></div></div>';
         * 
         */

    }
    
    // wrap html in responsive column
    public static function WrapColumn($content, $numColsOfTwelve)
    {
        $HTML = '<div class="wpb_column vc_column_container vc_col-sm-' . $numColsOfTwelve . '">' . "\r\n"; 
        $HTML .= '<div class="vc_column-inner "><div class="wpb_wrapper">' . "\r\n"; 
        $HTML .= '<div class="wpb_text_column wpb_content_element ">' . "\r\n"; 
        $HTML .= '<div class="wpb_wrapper">' . "\r\n"; 

        $HTML .= $content . "\r\n"; 
        
        $HTML .= '</div></div></div></div></div>' . "\r\n"; 
        
        return $HTML;
    }
    
    // wrap html column(s) in responsive row
    public static function WrapRow($content)
    {
        $HTML = '<div class="vc_row wpb_row vc_row-fluid mb90-row-center">' . "\r\n";
        $HTML .= $content . "\r\n";
        $HTML .= '</div>' . "\r\n";
        
        return $HTML;
    }
    
    public static function includeUserData()
    {
        //include(self::getRootPath() . 'inc/data-grid.php');
        //[user-sa-data]
    }
    
    public static function GetMediaRows()
    {
        $exDay = $_REQUEST["exDay"];
	$exDay = $exDay % 10;
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
        $exNameArr = array();

        $sep = self::GetRowSep();

        //echo "SQL = [" . "SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=" . $exDay . "  AND UPPER(ExerciseMMType) != 'IMAGE' AND ProgrammeID = 1 order by OrderNumber, ExerciseName, ExerciseMMType ASL" . "]";
        foreach( $wpdb->get_results("SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=" . $exDay . " AND UPPER(ExerciseMMType) != 'IMAGE' AND ProgrammeID = 1 order by OrderNumber, ExerciseName, ExerciseMMType asc" ) as $key => $row)
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
                    array_push($exNameArr, $currentExName);
                    
                    $exListing .= $currentExName . '##,##';
                }

                $rowHTML = self::GetRowTemplate();
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
        array_push($exNameArr, $currentExName);
        
        if( $exDay == 9 ){ // Quick Fix: rohea: double up the exercises per round ... need to tidy this up to get the roundGroupings from the mb90_workout_timings table
            $exListing .= $currentExName . '##,##' . $exListing . $currentExName;
        }else{
            $exListing .= $currentExName;            
        }

        //echo $rowStart . $imageHTML . $videoHTML . $descHTML . $rowEnd;
        //array_push($rowHTMLArr, $rowStart . $colummStart . $imageHTML . $columnEnd . $colummStart . $videoHTML . $columnEnd . $colummStart . $descHTML . $columnEnd . $rowEnd);
        $rowCount = 1;
        foreach( $rowHTMLArr as $rowHTMLstr){
            echo $rowHTMLstr;
            $rowCount ++;
        }
        
        echo '<input type="hidden" id="exlistinghidden" value="' . $exListing . '" />';
    }

    
    public static function GetMediaRowsOri()
    {
        $exDay = $_REQUEST["exDay"];
	$exDay = $exDay % 10;
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
        $exNameArr = array();

        $sep = self::GetRowSep();

        //echo "SQL = [" . "SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=" . $exDay . " AND ProgrammeID = 1 order by OrderNumber, ExerciseName, ExerciseMMType asc" . "]";
        foreach( $wpdb->get_results("SELECT * FROM mb90_prog_exercises_days WHERE ExerciseDay=" . $exDay . " AND ProgrammeID = 1 order by OrderNumber, ExerciseName, ExerciseMMType asc" ) as $key => $row)
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
                    array_push($exNameArr, $currentExName);
                    
                    $exListing .= $currentExName . '##,##';
                }

                $rowHTML = self::GetRowTemplate();
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
        array_push($exNameArr, $currentExName);
        
        if( $exDay == 9 ){ // Quick Fix: rohea: double up the exercises per round ... need to tidy this up to get the roundGroupings from the mb90_workout_timings table
            $exListing .= $currentExName . '##,##' . $exListing . $currentExName;
        }else{
            $exListing .= $currentExName;            
        }

        //echo $rowStart . $imageHTML . $videoHTML . $descHTML . $rowEnd;
        //array_push($rowHTMLArr, $rowStart . $colummStart . $imageHTML . $columnEnd . $colummStart . $videoHTML . $columnEnd . $colummStart . $descHTML . $columnEnd . $rowEnd);
        $rowCount = 1;
        foreach( $rowHTMLArr as $rowHTMLstr){
            echo $rowHTMLstr;
            $rowCount ++;
        }
        
        echo '<input type="hidden" id="exlistinghidden" value="' . $exListing . '" />';
    }
    
    public static function GetRowSep()
    {
        $sepHTML = '<div class="vc_row wpb_row vc_row-fluid mb90-ex-separator">' . "\r\n";
        $sepHTML .= '<div class="vc_col-sm-12 wpb_column vc_column_container">' . "\r\n";
        $sepHTML .= '<div class="wpb_wrapper">' . "\r\n";
        $sepHTML .= '<div class="vc_separator wpb_content_element vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_grey">' . "\r\n";
        $sepHTML .= '<span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span>' . "\r\n";
        $sepHTML .= '<span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>' . "\r\n";
        $sepHTML .= '</div></div></div></div>' . "\r\n";
        return $sepHTML;
    }
    
    public static function GetRowTemplate()
    {
        $rowStart = '<div class="vc_row wpb_row vc_row-fluid mb90-ex-separator">' . "\r\n";
        $rowEnd = '</div>' . "\r\n";    

        $columnStart = '<div class="vc_col-sm-4 wpb_column vc_column_container">' . "\r\n";
        $columnStart .= '<div class="wpb_wrapper">' . "\r\n";
        
        $imageColumnStart = '<div class="vc_col-sm-2 wpb_column vc_column_container">' . "\r\n";
        $imageColumnStart .= '<div class="wpb_wrapper">' . "\r\n";
        
        $descColumnStart = '<div class="vc_col-sm-6 wpb_column vc_column_container">' . "\r\n";
        $descColumnStart .= '<div class="wpb_wrapper">' . "\r\n";
        $descColumnStart .= '<div class="mb90-exercise-description">' . "\r\n";

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
        $videoCellStart .= '<div class="wpb_video_wrapper mb90-video-wrapper">' . "\r\n";

        $videoCellEnd = '</div></div></div>' . "\r\n";

        $videoLink = "";
        $imageLink = "";
        $descriptionText = "";
        $columnCaption .= '<h2>Anatomy</h2>' . "\r\n";
        $descriptionCaption = '<h2>##EXERCISENAME##</h2>' . "\r\n";

        $descriptionEnd = $columnEnd;
    
        $rowTemplate = $rowStart;
/*        $rowTemplate .= $imageColumnStart;
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
*/

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
        $rowTemplate .= "</div>"  . "\r\n";
        $rowTemplate .= $columnEnd;        
        $rowTemplate .= $rowEnd;
        
        $sep = self::GetRowSep();
        
        $rowTemplate .= $sep;
        
        return $rowTemplate;
    }
    
}
