<?php
    
$path = realpath(dirname(__FILE__));
$rootPathArr = split("wp-content", $path);
$userIncPath = $rootPathArr[0] . "/wp-content/plugins/mb90-user-data/";


    //$pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';

  /*
    on page load ... run ajax call to get data from mb90_user_diet_translated view
    
    call with {"DayNum":DayNum, "UserID":UserID}
    Use UserID as a Session Var in the web service if possible
    
    return json with {"idlist": "<comma delim list of meal IDs>", "mealhtml":""}
    populate the #selectedIDs hidden var with the returned IDs and populate the html liks
    jQuery( "#diet-selection-table").append(outer_html);

    when user clicks save

    run ajax call to save/update and send json with
    {"idlist":"#selectedIDs","UserID":"","DayNum",""}

    Run "if exists the update else insert" where UserID=UserID etc


   */

   
    require_once($userIncPath . 'inc/scripts/dbase_include.php');
    require_once($userIncPath . 'inc/Classes/UtilitiesClass.php');
    
// ==============================
// must check if logged in here
// ==============================

    session_start();
    if(!isset($_SESSION["LoggedUserID"]) || empty($_SESSION["LoggedUserID"])) {
        $wpLoggedInUserID = get_current_user_id();
        $_SESSION["LoggedUserID"] = $wpLoggedInUserID;
    }
    
    $UserID = $_SESSION["LoggedUserID"];
    
    if(isset($_POST['selectedIDList']) && !empty($_POST['selectedIDList'])) {
        $selectedIDList = $_POST['selectedIDList'];
    } else {
        echo "no meals selected";
        exit;
    }
  
    if(isset($_POST['daynum'])) {
        $daynum = $_POST['daynum'];
    } else {
        echo "no day of week specified";
        exit;
    }
    
    if(isset($_SESSION["LoggedUserID"]) && !empty($_SESSION["LoggedUserID"])) {
        //echo "userid = [" . $_SESSION["LoggedUserID"] . "]";
    }
    else{
        echo "You may not be logged in";
      exit;
    }

    //$deleteSQL = "DELETE from mb90_user_diet WHERE UserID = " . $UserID . " AND DayNum = " . $daynum . " AND MealID = " . $mealid;
    
    global $wpdb;
    // first clear down the data
    $wpdb->query($wpdb->prepare("DELETE FROM mb90_user_diet WHERE UserID = %d AND DayNum = %d",$UserID, $daynum));

    // now insert for each meal
    $insertErrorCount = 0;
    $idArr = split(",", $selectedIDList);
    foreach( $idArr as $mealid){
        $wpdb->insert("mb90_user_diet", array(
           "UserID" => $UserID,
           "DayNum" => $daynum,
           "MealID" => $mealid
        ));
        if( $wpdb->insert_id === false){
            $insertErrorCount++;
        }
    }
    if( $insertErrorCount > 0){
        $result = "Some meals were not saved properly. Please try again";
    }else{
        $result = "You daily diet was saved successfully.";
    }

    echo $result;

?>

