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
    
    function GetTimerJs()
    {
        //$incPath = self::getRootURL() . MB90_90_EX_MENU_INC_FOLDER_PATH;
        $incPath = get_site_url() . MB90_90_EX_MENU_INC_FOLDER_PATH;
        
        //echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>';
        
        //echo '<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>';
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>'."\r\n";
        echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js?v=1.0" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>'."\r\n";

        echo '<script src="'.$incPath.'js/timer/tabata-timer.js?v=1.3" type="text/javascript"></script>'."\r\n";
        echo '<script src="'.$incPath.'js/timer/init.js?v=1.964" type="text/javascript"></script>'."\r\n";
        
        echo '<script src="'.$incPath.'js/progressTimer/js/jquery.progressTimer.js"></script>'."\r\n";
        
        echo '<script src="//cdn.rawgit.com/noelboss/featherlight/1.3.5/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>'."\r\n";
        
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

        
        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">'."\r\n";
        //echo '<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">';
        //echo '<link rel="stylesheet" href="'.$incPath.'css/timer/bootstrap.css">';
        //echo '<link rel="stylesheet" href="'.$incPath.'css/timer/timer-styling.css">';
        //echo '<link rel="stylesheet" href="'.$incPath.'css/timer/TimeCircles.css">';
        echo '<link rel="stylesheet" href="'.$incPath.'css/timer/tabata-timer.css?v=1.511">'."\r\n";
        
        echo '<link href="//cdn.rawgit.com/noelboss/featherlight/1.3.5/release/featherlight.min.css" type="text/css" rel="stylesheet" />'."\r\n";
        
        //echo '<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">'."\r\n";
        
        /*echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/prelude.css">'."\r\n";
        echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/rainbow.css">'."\r\n";
        echo '<link rel="stylesheet" href="'.$incPath.'js/asProgress/css/progress.css">'."\r\n";*/
        
        //echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';

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
    
    public static function GetUserChallengeLinks()
    {
        $challengeObj = new Assessments();
        $challengeLinks = $challengeObj->get10DayChallengeLinks("All");
        echo $challengeLinks;
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
    
    public static function GetBodyStatLinks()
    {
        $challengeObj = new Assessments();
        $challengeLinks = $challengeObj->getUserBodyStatLinks("All");
        echo $challengeLinks;
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
            $blockNum = ceil($exDay / 10);
            $exCount = 0;
            $roundGroupings = 1;

            //$exDayOri = $exDay;
            $exDay = $exDay % 10;

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
            $html .= '<strong>Exercise Timings: </strong><br /><span id="exercise-summaryinfo"></span>';
            $html .= '<br /><strong>Total Time: </strong><br /><span id="totalworkouttimespan"></span>';

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
        $incPath = get_site_url() . MB90_90_USER_DATA_INC_FOLDER_PATH;
        $buttonLink = '<div class="start-button-caption" id="start-button">Click to Start <img class="timer-start start-button" src="' . $incPath . 'images/play-button.png" alt="Click to Start" name="Click to Start"/></div>';
        $buttonLink .= '<div id="start-button-html">Click to Start <img class="timer-start start-button" src="' . $incPath . 'images/play-button.png" alt="Click to Start" name="Click to Start"/></div>';
        $buttonLink .= '<div id="stop-button-html">Click to Stop <img class="timer-start start-button" src="' . $incPath . 'images/stop-button.png?v=1.0" alt="Click to Stop" name="Click to Stop"/></div>';
        echo $buttonLink;
    }
    
    public static function GetCurrentNextExercises()
    {
        $finalHTML = "";
        $currNextHTML .= '<div class="outer-timer-wrapper">' . "\r\n";
        $currNextHTML .= '<div class="timer-display">00:00.00</div>' . "\r\n";
        $currNextHTML .= '<div class="progressbar-caption">Current Exercise</div>' . "\r\n";
        $currNextHTML .= '</div>' . "\r\n";

        $finalHTML .= self::WrapColumn($currNextHTML, 3);
        // new col
        $currNextHTML = '<div class="outer-timer-wrapper">' . "\r\n";
        $currNextHTML .= '<div id="currentExercise" class="timer-exercise-label">...</div>' . "\r\n";
        $currNextHTML .= '</div>' . "\r\n";

        $finalHTML .= self::WrapColumn($currNextHTML, 3);
        
        // new col
        $currNextHTML = '<div class="outer-timer-wrapper">' . "\r\n";
        $currNextHTML .= '<div class="progressbar-caption">Next Exercise</div>' . "\r\n";
        $currNextHTML .= '</div>' . "\r\n";
        
        $finalHTML .= self::WrapColumn($currNextHTML, 3);

        // new col
        $currNextHTML = '<div class="outer-timer-wrapper">' . "\r\n";
        $currNextHTML .= '<div id="nextExercise" class="timer-exercise-label">...</div>' . "\r\n";
        $currNextHTML .= '</div>' . "\r\n";
        
        $finalHTML .= self::WrapColumn($currNextHTML, 3);
        
        $finalHTML = self::WrapRow($finalHTML);
        
        echo $finalHTML;

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
    
}
