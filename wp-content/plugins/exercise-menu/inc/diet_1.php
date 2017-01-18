<?php
    global $wpdb;
    $incPath = "../wp-content/plugins/exercise-menu/inc/";
    //include('..\wp-content\plugins\exercise-menu\inc\exercise-table.php');

    //include('../wp-content/plugins/exercise-menu/inc/css/myBody90_cmsforms.css');
    
            
    $mode = $_POST["mode"];
//if( $mode == "add")
//{
    //require_once('..\wp-content\plugins\exercise-menu\inc\FormGenClass.php');
    
    echo "<h2>" . __( 'Diet', 'exercise-menu' ) . "</h2>";
    
?>

<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-color.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-icons.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-black.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/data-grid.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/mb90-buttons.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/myBody90_cmsforms.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="<?=$incPath?>/js/jquery.easyui.min.js"></script>
<!--<script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script>-->

<?php

    //$formGen = new mb90_formGen();
    //$formHTML = $formGen->getFormMarkup("exercises", $mode);
        
    //echo $formHTML;
    global $recordType;
    $recordType = "Diet";
    include($incPath . 'data-grid.php');



/*}
else if($mode == "edit")
{
    
}
else if($mode == "list")
{
    
}*/
    
?>
    
