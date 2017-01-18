<?php
    /*global $wpdb;
    $pluginURL = plugins_url("mb90-user-data/");
    $pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';
    
    require_once($pluginPath . 'inc/scripts/dbase_include.php');
    require_once($pluginPath . 'inc/Classes/DataGridClass.php');
    
    $incPath = $pluginPath . "inc/";
    $incURL = $pluginURL . "inc/";
    
    //echo $incURL;
    //echo $_SESSION["LoggedUserID"];
    
    $mode = $_POST["mode"];
    
    global $wpLoggedInUserID;
    $wpLoggedInUserID = get_current_user_id();
    $_SESSION["LoggedUserID"] = $wpLoggedInUserID;
    
    $userDetailsObj = new userDetails();
    $userDetailsArr = $userDetailsObj->getUserDetails($wpLoggedInUserID);
    
    //print_r($userDetailsArr);
    
    $_SESSION["UserName"] = $userDetailsArr['username'];
    //$_SESSION["UserProgrammeID"] = $userDetailsArr['userprogrammeid'];
    $_SESSION["UserProgrammeID"] = 1;
    $_SESSION["UserStartDate"] = $userDetailsArr['userstartdate'];
    //$_SESSION["UserWeight"] = $userDetailsArr['userweight'];
    
    //echo "user = [".$wpLoggedInUserID."]";
    //echo "programmeID = [".$_SESSION["UserProgrammeID"]."]";

     */
    
    
?>

<!--<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/easyui-color.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/easyui-icons.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/easyui-black.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/data-grid.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/mb90-buttons.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/myBody90_cmsforms.css">



<script type="text/javascript" src="<?=$incURL?>js/chart.min.js"></script>



<script type="text/javascript" src="<?=$incURL?>js/mb90-functions-memberpress.js"></script>-->

<!--<script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script>-->

<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/myBody90-user-input.css?v=1.0">
<script type="text/javascript" src="<?=$incURL?>js/chart.min.js"></script>
<!--<script type="text/javascript" src="<?=$incURL?>js/jquery.easyui.min.js"></script>-->

<?php

    $startDateStr = $userDetailsArr['userstartdate'];
    $numberDaysSinceStart = $userDetailsObj->getDaysBetweenDates($startDateStr, time());
    //echo $numberDaysSinceStart;

    if( $userDetailsExist === false){
        echo USER_PROFILE_INCOMPLETE;
    }
    elseif( $numberDaysSinceStart > 90){ // failsafe 
        echo COURSE_FINISHED;
    }
    else
    {

        if( isset($_REQUEST["challengeDate"]) ) // 10 day challenge date has been chosen
        {

        }
        else if($recordType == "User10DayChallenge" || $recordType == "UserSelfAssessment"){
            $challengeObj = new Assessments();
            switch($recordType){
                case "User10DayChallenge":
                    $challengeLinks = $challengeObj->get10DayChallengeLinks("All");
                    break;
                case "UserSelfAssessment":
                    $challengeLinks = $challengeObj->getSelfAssessmentLinks("All");
                    break;
            }
            echo $challengeLinks;

            $showGraphs = false;

            $chartObj = new chartFunctions();
            //$captionArray = $chartObj->getBarChartCaptions($recordType);
            $chartDataValArray = $chartObj->getBarChartValues($recordType);
            //echo "dataCount = [".count($chartDataValArray)."]";
            if( count($chartDataValArray) > 0)
            {
                //print_r($chartDataValArray);
                $count = 0;
                $phaseDate = $chartDataValArray[0]["exercisedate"];
                $numPhases = 0;
                for($i = 1; $i <= count($chartDataValArray); $i++){
                    //echo "phase = '".$phaseDate."]";
                    if($phaseDate != $chartDataValArray[$i]["exercisedate"]){
                        $numPhases = $numPhases + 1;
                        $phaseDate = $chartDataValArray[$i]["exercisedate"];
                    }
                }
                $startValue = "";
                $startLabel = "";
                if( $numPhases == 1){ // set the start value as 0 and start label as "Start"
                    $startValue = "0,";
                    $startLabel ='"Start",';
                }
                $numExercises = count($chartDataValArray) / $numPhases;
                //echo "numExercises = [".$numExercises."]";

                //echo '<div class="mb90-chart-outer-wrapper">';

                //foreach($captionArray as $caption )
                $labelsArr = array();
                $dataArr = array();
                $labelStr = "";
                $dataStr = "";

                $phaseCount = 0;
                //for($j = ($phaseCount*$numExercises); $j < ($numExercises*($phaseCount+1)); $j++) // loop through each exercisxe
                for($j = 0; $j < $numExercises; $j++) // loop through each exercisxe
                {
                    $exerciseIncrement = $numExercises; // use this to jump through $chartDataValArray array
                    for($i = 0; $i < $numPhases; $i++) // loop through each phase / chart
                    {
                        //echo "inc = [".($j+($i*$numExercises))."]<br>";
                        //$labelStr .= '"' . $chartDataValArray[(($j+($i*$numExercises)))]["exercisedate"] . '-'.$chartDataValArray[(($j+($i*$numExercises)))]["exercisetype"].'",';
                        $labelStr .= $startLabel . '"' . $chartDataValArray[(($j+($i*$numExercises)))]["exercisedate"] . '",';
                        $dataStr .= $startValue . $chartDataValArray[($j+($i*$numExercises))]["exerciseresult"] . ',';
                        //$exerciseIncrement = $exerciseIncrement + 1;
                    }
                    $phaseCount = $phaseCount + 1;

                    $labelStr = $chartObj->stripLeadComma($labelStr);
                    $dataStr = $chartObj->stripLeadComma($dataStr);

                    $labelsArr[] = $labelStr;
                    $dataArr[] = $dataStr;

                    $labelStr = "";
                    $dataStr = "";
                }

                $captionArray = array();
                echo '<div class="vc_row wpb_row vc_row-fluid">'; // row start
                for($i = 0; $i < $numExercises; $i++)
                {
                    $caption = $chartDataValArray[$i]["exercisename"];
                    $exerciseType = $chartDataValArray[$i]["exercisetype"];
                    if( $exerciseType == "Time"){
                        $exerciseType .= "-Seconds";
                    }
                    $captionArray[] = $caption;

                    //echo '<div class="mb90-chart-wrapper">';

                    if( $count > 0 && $count % 3 === 0){ // start a row after 3 charts
                        echo '</div><div class="vc_row wpb_row vc_row-fluid">'; // row start
                    }
                    // set up responsive divs for each chart
                    echo '<div class="vc_col-sm-3 wpb_column vc_column_container">';
                    echo '<div class="wpb_wrapper">';
                    echo '<div class="wpb_text_column wpb_content_element">';
                    echo '<div class="wpb_wrapper">';

                    echo '<div class="mb90-chart-caption"><h4>'.$caption.' ('.$exerciseType.')</h2></div>';
                    echo '<div class="mb90-chart-contents">';
                    echo '<canvas id="canvas_'.($i+1).'" height="200px" width="auto"></canvas>'."\r\n";
                    //echo '</div>';
                    echo '</div>';

                    // end responsive divs for chart
                    echo '</div></div></div></div>';

                    $count = $count + 1;
                }
                echo '<div id="chartjs-tooltip"></div>';
                echo '</div>';

                $count = 0;
                echo "\r\n" . '<script type="text/javascript">'."\r\n";
                for($i = 0; $i < $numExercises; $i++)
                {
                    $caption = $chartDataValArray[$i]["exercisename"];
                    echo 'var lineChartData_'.($i+1).' = {'."\r\n";
                    //echo 'tooltipFontSize: 10,'."\r\n";
                    //echo 'tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>hrs",'."\r\n";
                    //echo 'percentageInnerCutout : 70'."\r\n";
                    echo 'labels : ['.$labelsArr[$i].'],'."\r\n";
                    echo 'datasets : ['."\r\n";

                    echo '{'."\r\n";
                    echo 'label: "'.$caption.'",'."\r\n";
                    echo 'fillColor : "rgba(220,220,220,0.2)",'."\r\n";
                    echo 'strokeColor : "rgba(220,220,220,1)",'."\r\n";
                    echo 'pointColor : "rgba(220,220,220,1)",'."\r\n";
                    echo 'pointStrokeColor : "#fff",'."\r\n";
                    echo 'pointHighlightFill : "#fff",'."\r\n";
                    echo 'pointHighlightStroke : "rgba(220,220,220,1)",'."\r\n";
                    echo "data : [".$dataArr[$i]."]"."\r\n";
                    echo '}'."\r\n";
                    echo ']'."\r\n";
                    echo '}'."\r\n";
                }

                $count = 0;
                //echo 'window.onload = function(){'."\r\n";
                foreach($captionArray as $caption )
                {
                    echo 'var ctx_'.($count+1).' = document.getElementById("canvas_'.($count+1).'").getContext("2d");'."\r\n";
                    //echo 'window.myLine'.($count+1).' = new Chart(ctx_'.($count+1).').Line(lineChartData_'.($count+1).', {'."\r\n";
                    echo 'new Chart(ctx_'.($count+1).').Line(lineChartData_'.($count+1).', {'."\r\n";
                    echo 'responsive: true,'."\r\n";
                    echo 'showTooltips: true,'."\r\n";
                    echo 'scaleFontColor: "#777"'."\r\n";
                    echo '});'."\r\n";
                    $count = $count + 1;
                }

                //echo '}'."\r\n";
                echo '</script>'."\r\n";
            }
        }
        else if($recordType == "UserBodyData"){
            $showGraphs = true;
        }

        if( $showGraphs )
        {
            $chartObj = new chartFunctions();
            $captionArray = $chartObj->getBarChartCaptions($recordType);
            $chartDataValArray = $chartObj->getBarChartValues($recordType);

            $startValue = "";
            $startLabel = "";

            $count = 0;
            //echo '<div class="mb90-chart-outer-wrapper">';
            echo '<div class="vc_row wpb_row vc_row-fluid">'; // first row start
            foreach($captionArray as $caption )
            {
                //echo '<div class="mb90-chart-wrapper">';

                if( $count > 0 && $count % 3 === 0){ // start a row after 3 charts
                    echo '</div><div class="vc_row wpb_row vc_row-fluid">'; // row start
                }
                // set up responsive divs for each chart
                // WORKS for body stats
                echo '<div class="vc_col-sm-3 wpb_column vc_column_container">';
                echo '<div class="wpb_wrapper">';
                echo '<div class="wpb_text_column wpb_content_element">';
                echo '<div class="wpb_wrapper">';


                echo '<div class="mb90-chart-caption"><h3>'.$caption.'</h3></div>';
                echo '<div class="mb90-chart-contents">';
                echo '<canvas id="canvas_'.($count+1).'" height="200px" width="300px"></canvas>'."\r\n";
                echo '</div>';
                //echo '</div>';

                // end responsive divs for chart
                echo '</div></div></div></div>';
                //echo '<div id="chartjs-tooltip_'.($count+1).'"></div>';
                $count = $count + 1;
            }
            echo '<div id="chartjs-tooltip"></div>';
            echo '</div>';

            $count = 0;

            if( strpos($chartDataValArray[count($chartDataValArray)-1], ',' ) === false){ // set the start value as 0 and start label as "Start" if only 1 chart value exists
                $startValue = "0,";
                $startLabel ='"Start",';
            }


            echo "\r\n" . '<script type="text/javascript">'."\r\n";

            //echo 'alert(tooltip.toSource());'."\r\n";

            foreach($captionArray as $caption )
            {
                echo 'var lineChartData_'.($count+1).' = {'."\r\n";
                echo 'labels : ['.$startLabel.$chartDataValArray[count($chartDataValArray)-1].'],'."\r\n";
                echo 'datasets : ['."\r\n";

                echo '{'."\r\n";
                echo 'label: "'.$caption.'",'."\r\n";
                //echo 'label: "test",'."\r\n";
                echo 'fillColor : "rgba(220,220,220,0.2)",'."\r\n";
                echo 'strokeColor : "rgba(220,220,220,1)",'."\r\n";
                echo 'pointColor : "rgba(220,220,220,1)",'."\r\n";
                echo 'pointStrokeColor : "#fff",'."\r\n";
                echo 'pointHighlightFill : "#fff",'."\r\n";
                echo 'pointHighlightStroke : "rgba(220,220,220,1)",'."\r\n";
                //echo 'scaleFontColor : "#777",'."\r\n"; 
                echo "data : [".$startValue.$chartDataValArray[$count]."]"."\r\n";
                //if( $count < 11)
                  //  echo '},'."\r\n";
                //else
                echo '}'."\r\n";
                //$count = $count + 1;

                echo ']'."\r\n";
                echo '}'."\r\n";
                $count = $count + 1;
            }

            $count = 0;
            //echo 'window.onload = function(){'."\r\n";
            foreach($captionArray as $caption )
            {
                echo 'var ctx_'.($count+1).' = document.getElementById("canvas_'.($count+1).'").getContext("2d");'."\r\n";
                echo 'window.myLine'.($count+1).' = new Chart(ctx_'.($count+1).').Line(lineChartData_'.($count+1).', {'."\r\n";
                echo 'responsive: true,'."\r\n";
                echo 'showTooltips: true,'."\r\n";
                echo 'scaleFontColor: "#777"'."\r\n";
                echo '});'."\r\n";
                $count = $count + 1;
            }

            //echo '}'."\r\n";
            echo '</script>'."\r\n";
        }


        //include($pluginPath . 'inc/data-grid-memberpress.php');
    }



?>
    
