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
    
    /*if(isset($_POST['mealidlist'])) {
        $mealidlist = $_POST['mealidlist'];
        //var_dump(json_decode($json, true));
    } else {
        echo "no meals selected";
        exit;
    }*/
  
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

    // build the menu selection html and return with the list of IDs
    $selHTML = "";
    $idlist = "";
    global $wpdb;
    foreach( $wpdb->get_results("SELECT * FROM mb90_user_diet_translated WHERE UserID=" . $UserID . " AND DayNum = " . $daynum. " order by ID asc" ) as $key => $row)
    {
        $idlist .= $row->ID . ",";
        $selHTML .= '<p>' . "\r\n";
        $selHTML .= '<div id="' . $row->ID . '" class="diet-selected-item" calories="' . $row->CalorieCount. '">' . "\r\n";
        $selHTML .= '<div class="diet-selected-item-caption">' . $row->MealName. '</div>' . "\r\n";
        $selHTML .= '<div class="diet-selected-item-delete">DELETE</div>' . "\r\n";
        $selHTML .= '</div>' . "\r\n";
        $selHTML .= '</p>' . "\r\n";
    }
    $idlist = rtrim($idlist, ",");
    $dataArr = array( 'html' => $selHTML, 'idlist' => $idlist );
    header('Content-Type: application/json');
    echo json_encode($dataArr);

?>

