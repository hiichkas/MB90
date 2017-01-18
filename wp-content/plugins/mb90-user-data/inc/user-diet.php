<?php
    global $wpdb;
    $pluginURL = plugins_url("mb90-user-data/");
    $pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';
    
    $incPath = $pluginPath . "inc/";
    $incURL = $pluginURL . "inc/";
    
    $mode = $_POST["mode"];
    
    //echo "<h2>" . __( 'Diet', 'exercise-menu' ) . "</h2>";
    
?>

<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/easyui-color.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/easyui-icons.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/easyui-black.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/data-grid.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/mb90-buttons.css">
<link rel="stylesheet" type="text/css" href="<?=$incURL?>css/myBody90_cmsforms.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="<?=$incURL?>js/jquery.easyui.min.js"></script>
<!--<script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script>-->

<?php

    global $recordType;
    $recordType = "Diet";
    include($pluginPath . 'inc/data-grid.php');

?>
    
