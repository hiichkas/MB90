<?php
    global $wpdb;
    $incPath = "../wp-content/plugins/exercise-menu/inc/";
?>

<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-color.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-icons.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-black.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/data-grid.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/mb90-buttons.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/myBody90_cmsforms.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="<?=$incPath?>/js/jquery.easyui.min.js"></script>

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
    
