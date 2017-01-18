<?php
    
$path = realpath(dirname(__FILE__));
$rootURLArr = split("wp-content", $path);
$userIncPath = $rootURLArr[0] . "\\wp-content\\plugins\\mb90-user-data\\";


    //$pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';

  
    require_once($userIncPath . 'inc/scripts/dbase_include.php');
    //require_once($userIncPath . 'inc/Classes/DataGridClass.php');
    
// ==============================
// must check if logged in here
// ==============================

    session_start();
    if(!isset($_SESSION["LoggedUserID"]) || empty($_SESSION["LoggedUserID"])) {
        $wpLoggedInUserID = get_current_user_id();
        $_SESSION["LoggedUserID"] = $wpLoggedInUserID;
    }
    
    $UserID = $_SESSION["LoggedUserID"];
    
    $paramArr = array("userstartdate", "userweight", "userheight", "userage", "userdob", "usersex", "useractivitylevel");
    $formError = false;
    foreach($paramArr as $qStringParam){
        if(!isset($_REQUEST[$qStringParam]) || empty($_REQUEST[$qStringParam])){
            $formError = true;
            $errorStr .= $qStringParam . " = [" . $_REQUEST[$qStringParam] . "], ";
        }
    }
    if( $formError === true){
        echo "Please fill out all fields: " . $errorStr;
        exit;
    }
    
    if((!isset($_SESSION["LoggedUserID"]) || empty($_SESSION["LoggedUserID"]))){ 
        echo "You are not logged in. Please log in and try again.";
        exit;
    }

    //$deleteSQL = "DELETE from mb90_user_diet WHERE UserID = " . $UserID . " AND DayNum = " . $daynum . " AND MealID = " . $mealid;
    
    global $wpdb;
    // first clear down the data
    //$wpdb->query($wpdb->prepare("DELETE FROM mb90_user_diet WHERE UserID = %d AND DayNum = %d",$UserID, $daynum));
    
    $insertRecord = false;
//    if(!isset($_POST["userrecordid"]) || empty($_POST["userrecordid"] || $_POST["userrecordid"])){
        if( $_POST["userrecordid"] == 0){         // user has not saved profile details yet
            $insertRecord = true; 
        }
    //}

    $sqlErrorCount = 0;
    $coursStartDate = $_REQUEST["userstartdate"];
    $coursStartDateStr = str_replace('/', '-', $_REQUEST["userstartdate"]);
    $coursStartDate = date('Y-m-d', strtotime($coursStartDateStr));
    
    $coursEndDate = date('Y-m-d', strtotime($coursStartDateStr. ' + 90 days'));
    //$coursStartDate = date("Y-m-d", $coursStartDate);
    //$coursEndDate = date("Y-m-d", $coursEndDate);
    $dob = $coursStartDateStr = str_replace('/', '-', $_REQUEST["userdob"]);
    $dob = date('Y-m-d', strtotime($dob));
    //$dob = strtotime($_REQUEST["userdob"], "d/m/Y");
    //$dob = date("Y-m-d", $dob);
    if( $insertRecord )
    {
        $wpdb->insert("mb90_user_details", array(
            "UserID" => $_REQUEST["userid"],
            "ProgrammeID" => 1,
            "StartDate" => $coursStartDate,
            "EndDate" => $coursEndDate,
            "Weight" => $_REQUEST["userweight"],
            "Age" => $_REQUEST["userage"],
            "DOB" => $dob,
            "FeePaid" => "Y",
            "Sex" => $_REQUEST["usersex"],
            "Height" => $_REQUEST["userheight"],
            "ActivityLevelMultiplier" => $_REQUEST["useractivitylevel"],
            "CourseStarted" => "N"
        ));
        if( $wpdb->insert_id === false){
            $sqlErrorCount++;
        }
        
        // now insert the 1st weight into the bodystats table
        /*
        $wpdb->insert( 
            'mb90_user_bodystats', 
            array( 
                'UserID' => $_REQUEST["userid"],
                'InputDate' => $coursStartDate,
                'Weight' => $_REQUEST["userweight"],
                'ActivityLevel' => "",
                'RightArm' => 0,
                'LeftArm' => 0,
                'Chest' => 0,
                'Navel' => 0,
                'Hips' => 0,
                'RightLegUpper' => 0,
                'RightLegThigh' => 0,
                'RightLegCalf' => 0,
                'LeftLegUpper' => 0,
                'LeftLegThigh' => 0,
                'LeftLegCalf' => 0
            )
        );
         * */
        
        $rows_affected = $wpdb->query(
            $wpdb->prepare(
                    "INSERT INTO `mb90_user_bodystats` " . 
                    "(UserId, InputDate, Weight) " . 
                    "values(%d, '$coursStartDate', %d) ON DUPLICATE KEY UPDATE Weight = %d;",
                    $_REQUEST["userid"], $_REQUEST["userweight"], $_REQUEST["userweight"]
            ) // $wpdb->prepare
        ); // $wpdb->query
        
        /*if( $wpdb->insert_id === false){
            $sqlErrorCount++;
        }*/
    }
    else // run an update
    {
        $result = $wpdb->update( 
            'mb90_user_details', 
            array( 
            "UserID" => $_REQUEST["userid"],
            "ProgrammeID" => 1,
            "StartDate" => $coursStartDate,
            "EndDate" => $coursEndDate,
            "Weight" => $_REQUEST["userweight"],
            "Age" => $_REQUEST["userage"],
            "DOB" => $dob,
            "FeePaid" => "Y",
            "Sex" => $_REQUEST["usersex"],
            "Height" => $_REQUEST["userheight"],
            "ActivityLevelMultiplier" => $_REQUEST["useractivitylevel"],
            "CourseStarted" => "N"
            ),
            array( 'ID' => $_REQUEST["userrecordid"] )
        );
        
        /*$result = $wpdb->update( 
            'mb90_user_bodystats', 
            array( 
                'UserID' => $_REQUEST["userid"],
                'InputDate' => $coursStartDate,
                'Weight' => $_REQUEST["userweight"]
         * 
         */
                /*'ActivityLevel' => "",
                'RightArm' => 0,
                'LeftArm' => 0,
                'Chest' => 0,
                'Navel' => 0,
                'Hips' => 0,
                'RightLegUpper' => 0,
                'RightLegThigh' => 0,
                'RightLegCalf' => 0,
                'LeftLegUpper' => 0,
                'LeftLegThigh' => 0,
                'LeftLegCalf' => 0*/
            /*),
            array( 'ID' => $_REQUEST["userrecordid"] )
        );*/
        
        
        
        $rows_affected = $wpdb->query(
            $wpdb->prepare(
                    "INSERT INTO `mb90_user_bodystats` " . 
                    "(UserId, InputDate, Weight) " . 
                    "values(%d, '$coursStartDate', %d) ON DUPLICATE KEY UPDATE Weight = %d;",
                    $_REQUEST["userid"], $_REQUEST["userweight"], $_REQUEST["userweight"]
            ) // $wpdb->prepare
        ); // $wpdb->query
        
    }
    
    if( $sqlErrorCount > 0){
        $result = "There was a problem saving your details. Please try again";
    }else{
        $result = "Your profile details were saved successfully.\nPlease click ok to update this page.";
    }
    //header('Content-Type: application/json');
    //echo json_encode($result);
    echo $result;

?>

