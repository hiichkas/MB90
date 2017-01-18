<?php
    global $wpdb;
    $incPath = "../wp-content/plugins/exercise-menu/inc/";
    
    $mode = "";
    
    if( isset($_POST["mode"]))
        $mode = $_POST["mode"];
//if( $mode == "add")
//{
    //require_once('..\wp-content\plugins\exercise-menu\inc\FormGenClass.php');
    
    //echo "<h2>" . __( 'Exercises', 'exercise-menu' ) . "</h2>";
    //$progValues = array("Beginner","Intermediate","Advanced");
    
    $progSelected = "";
    if(isset($_POST['prog-select']))
    {
        $progSelected = $_POST['prog-select'];
    }
    
    $progSelected = 1;
    
?>

<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-color.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-icons.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/easyui-black.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/data-grid.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/mb90-buttons.css">
<link rel="stylesheet" type="text/css" href="<?=$incPath?>/css/myBody90_cmsforms.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="<?=$incPath?>/js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?=$incPath?>/js/ex_mm_functions.js"></script>
<!--<script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script>-->

<!--rohea: comment out form post as only using 1 programme type for the moment-->
<!--

<div class="form_container">
<form action="<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']; ?>" method="post" name="select-programme">
    
            <div class="ex-input-row">
                <div class="form-cell">
                    <label class="description" for="element_2">Exercise Programme: </label>
                    <div class="input-wrapper">
                        
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
-->
<br /><br />
<?php

    //$formGen = new mb90_formGen();
    //$formHTML = $formGen->getFormMarkup("exercises", $mode);
        
    //echo $formHTML;

//rohea: comment out form post as only using 1 programme type for the moment
//if(isset($_POST['prog-select']) && $_POST['prog-select'] !== "" )
//{
    global $recordType;
    $recordType = "ExerciseMultimedia";
    include($incPath . 'data-grid.php');
//}


/*}
else if($mode == "edit")
{
    
}
else if($mode == "list")
{
    
}*/
    
?>
    
