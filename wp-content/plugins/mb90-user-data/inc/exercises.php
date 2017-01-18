<?php
    global $wpdb;
    $incPath = "../wp-content/plugins/exercise-menu/inc/";
    //include('..\wp-content\plugins\exercise-menu\inc\exercise-table.php');

    //include('../wp-content/plugins/exercise-menu/inc/css/myBody90_cmsforms.css');
    
    $mode = "";
    
    if( isset($_POST["mode"]))
        $mode = $_POST["mode"];
//if( $mode == "add")
//{
    //require_once('..\wp-content\plugins\exercise-menu\inc\FormGenClass.php');
    
    echo "<h2>" . __( 'Exercises', 'exercise-menu' ) . "</h2>";
    //$progValues = array("Beginner","Intermediate","Advanced");
    
    $progSelected = "";
    if(isset($_POST['prog-select']))
    {
        $progSelected = $_POST['prog-select'];
    }
    //$progSelected = 
    
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

<div class="form_container">

<!--<form action="<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']; ?>" method="post" name="select-programme">-->
<form action="<?php echo $incPath . "exercises.php?" . $_SERVER['QUERY_STRING']; ?>" method="post" name="select-programme">

    
            <div class="ex-input-row"> <!-- start input row -->
                <div class="form-cell">
                    <label class="description" for="element_2">Exercise Programme: </label>
                    <div class="input-wrapper">
                        
<!--<span class="textbox combo" style="width: 198px; height: 20px;"><span class="textbox-addon textbox-addon-right" style="right: 0px;"><a tabindex="-1" icon-index="0" class="textbox-icon combo-arrow" href="javascript:void(0)" style="width: 18px; height: 20px;"></a></span><input type="text" autocomplete="off" class="textbox-text validatebox-text" placeholder="" style="margin-left: 0px; margin-right: 18px; padding-top: 1px; padding-bottom: 1px; width: 172px;"><input type="hidden" class="textbox-value" name="ProgrammeID" value="1"></span>-->
                        
                    <select class="combo-panel" id="prog-select" name="prog-select" onChange="this.form.submit();"> 
                            <option value=""<?=$progSelected == '' ? ' selected="selected"' : '';?>>-- Please Select --</option>
                            <?php
                                foreach( $wpdb->get_results("SELECT * FROM mb90_programmes ORDER BY ID")as $key => $row)
                                { 
                            ?>
                                <option value="<?=$row->ID;?>"<?=$progSelected == $row->ID ? ' selected="selected"' : '';?>><?=$row->ProgrammeType;?></option>
                            <?php } ?>
                    </select>
                    </div> 
                </div>
            </div>
    
</form>
<br /><br />
</div>
<?php

    //$formGen = new mb90_formGen();
    //$formHTML = $formGen->getFormMarkup("exercises", $mode);
        
    //echo $formHTML;
if(isset($_POST['prog-select']) && $_POST['prog-select'] !== "" )
{
    global $recordType;
    $recordType = "Exercise";
    include($incPath . 'data-grid.php');
}


/*}
else if($mode == "edit")
{
    
}
else if($mode == "list")
{
    
}*/
    
?>
    
