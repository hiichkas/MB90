<?php
    
$path = realpath(dirname(__FILE__));
$rootPathArr = split("wp-content", $path);
$userIncPath = $rootPathArr[0] . "/wp-content/plugins/mb90-user-data/";

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
    
    //$paramArr = array("userstartdate", "userweight", "userheight", "userage", "userdob", "usersex", "useractivitylevel", "userrecordid");
    $numWeightsTotal = 10; // this includes the 1st day and then the 9 end of phase measurements
    
    $weightinputcount = $_REQUEST["weightinputcount"];
    $formError = false;
    $weightArray = array();
    for( $i = 1; $i <= $weightinputcount; $i++){
        $qStringParam = "weight_" . $i;
        //$weightVal = $_REQUEST[$qStringParam];
        if(!isset($_REQUEST[$qStringParam]) || empty($_REQUEST[$qStringParam])){
            $formError = true;
            $errorStr .= $qStringParam . " = [" . $_REQUEST[$qStringParam] . "], ";
        }else{
            $weightArray[] = $_REQUEST[$qStringParam];
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
    
    $sqlErrorCount = 0;
    $coursStartDate = $_REQUEST["userstartdate"];
    $coursStartDateStr = str_replace('/', '-', $_REQUEST["userstartdate"]);
    $coursStartDate = date('Y-m-d', strtotime($coursStartDateStr));
    $coursEndDate = date('Y-m-d', strtotime($coursStartDateStr. ' + 90 days'));
    
    $userID = $_REQUEST["userid"];
    
    $dob = $coursStartDateStr = str_replace('/', '-', $_REQUEST["userdob"]);
    $dob = date('Y-m-d', strtotime($dob));
    
    // now populate the database with weights
    
    global $wpdb;
    $inputDate = $coursStartDate;
    $insertErrorCount = 0;
    for( $i = 1; $i < count($weightArray); $i++){ // ignore the startup weight as this is editable in the profile section
        $inputDate = date('Y-m-d', strtotime($inputDate . "+ 10 days" ));
        //$result .= $inputDate . ", ";
        $weight = $weightArray[$i];
        
        /*$result .= sprintf("\nINSERT INTO `mb90_user_bodystats` " . 
                    "(UserId, InputDate, Weight) " . 
                    "values(%d, '$inputDate', %d) ON DUPLICATE KEY UPDATE Weight = %d;\n",
                    $UserID, $weight, $weight);*/
        
        
        $rows_affected = $wpdb->query(
            $wpdb->prepare(
                    "INSERT INTO `mb90_user_bodystats` " . 
                    "(UserId, InputDate, Weight) " . 
                    "values(%d, '$inputDate', %d) ON DUPLICATE KEY UPDATE Weight = %d;",
                    $UserID, $weight, $weight
            ) // $wpdb->prepare
        ); // $wpdb->query
        
        //$result .= "\naffected = [" . $rows_affected . "]";
        
        /*if( $rows_affected == 0 ){
            $insertErrorCount ++;
        }*/
    }
    
    if( $insertErrorCount > 0){
        $result .= "Some weight data was not saved properly. Please try again";
    }else{
        $result .= "Your weight details were saved successfully.\nPlease click ok to update this page.";
    }
    //header('Content-Type: application/json');
    //echo json_encode($result);
    echo $result;

?>
