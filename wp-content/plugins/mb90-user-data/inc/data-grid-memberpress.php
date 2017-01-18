<?php
session_start();

//echo "user sess = [".$_SESSION["LoggedUserID"]."]";

$pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';
$pluginURL = plugins_url("mb90-user-data/");
require_once($pluginPath . 'inc/Classes/DataGridClass.php');

global $recordType;

$dgObj = new datagrid();

$hideToolBar = false;

if( $recordType == "Exercise"){
    $recordName = "Exercise";
    $getDataURL = $pluginURL . "inc/scripts/get_prog_exercise_data.php";
}
else if( $recordType == "Goal"){
    $recordName = "Goal";
    $getDataURL = $pluginURL . "inc/scripts/get_goal_data.php";
}
else if( $recordType == "UserDiet"){
    $recordName = "UserDiet";
    $getDataURL = $pluginURL . "inc/scripts/get_user_diet_data.php";
}
else if( $recordType == "UserBodyData"){
    $recordName = "UserBodyData";
    $getDataURL = $pluginURL . "inc/scripts/get_user_body_data.php?wpLoggedInUserID=$wpLoggedInUserID";
}
else if( $recordType == "User10DayChallenge"){
    $recordName = "User10DayChallenge";
    $getDataURL = $pluginURL . "inc/scripts/get_user_10daychallenge_data.php?wpLoggedInUserID=$wpLoggedInUserID";
    $hideToolBar = true;
    $challengeInputs = array();
    $challengeInputs = $dgObj->getHtmlFormInputs("User10DayChallenge", "edit");
}
else if( $recordType == "UserSelfAssessment"){
    $recordName = "UserSelfAssessment";
    $getDataURL = $pluginURL . "inc/scripts/get_user_selfassessment_data.php?wpLoggedInUserID=$wpLoggedInUserID";
    $hideToolBar = true;
    $challengeInputs = array();
    $challengeInputs = $dgObj->getHtmlFormInputs("SelfAssessment", "edit");
}

$dataGridHeader = $dgObj->getGridHeader($recordType);
$formInputs =  $dgObj->getFormInputs($recordType);


//echo "....".$challengeInputs."....";

?>

    <script type="text/javascript">
        
        var url;
        var formSubmitURL;
        
        function dialogHTML(caption, msg){

            $('#dlgHTML').dialog('open').dialog('setTitle',caption);
            $('#fmHTML').form('clear');
            $('#dlgHTMLContents').html(msg)
            //url = '<?=$incURL?>scripts/save_record.php?recordType=<?=$recordName?>&UserID=<?=$wpLoggedInUserID?>';
        }
        
        function customFormHTML(formName, mode, date, challengePhase, msg, caption){
//            formHTML = "";
//            formURL = '<?=$incURL?>scripts/getFormHTML.php?formName=' + formName + '&mode=' + mode;
//            $.get( formURL, function( data ) {
                //add the date to the dialog to differentuate between the multiple forms for User Assessment etc
                if( $('#dlgFormHTML_'+challengePhase).length > 0 ){
                    $('#dlgFormHTML_'+challengePhase).dialog('open').dialog('setTitle',formName);
                }else{
                    dialogHTML(caption, msg);
                }
                //$('#fmFormHTML').form('clear');
//                $('#dlgFormHTMLContents').html(data)
//            });
            formSubmitURL = '<?=$incURL?>scripts/save_form_record.php?formType='+formName+'&date=' + date + '&mode=' + mode;
        }
        
        function saveHTMLFormRecord(challengePhase){
            //alert(challengePhase);
            $('#fmFormHTML_'+challengePhase).form('submit',{
                url: formSubmitURL,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlgFormHTML_'+challengePhase).dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the data
                        location.reload(); // need to reload the page to refresh the graphs
                    }
                }
            });
        }
        
        function newRecord(){
            var currentDate = getCurrentDate();

            $('#dlg').dialog('open').dialog('setTitle','New <?=$recordName?>');
            $('#fm').form('clear');
            $('#fm').form('load', {
                InputDate: currentDate
            });
            url = '<?=$incURL?>scripts/save_record.php?recordType=<?=$recordName?>&UserID=<?=$wpLoggedInUserID?>';
        }
        function editRecord(){
            
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit <?=$recordName?>');
                $('#fm').form('load',row);
                url = '<?=$incURL?>scripts/update_record.php?id='+row.ID+'&recordType=<?=$recordName?>&UserID=<?=$wpLoggedInUserID?>';
            }
        }
        
        function editChallengeRecord(name){
            $('#dlgChallenge').dialog('open').dialog('setTitle','Edit ' + name);
            $('#fmChallenge').form('load',row);
            url = '<?=$incURL?>scripts/update_record.php?id='+row.ID+'&recordType=<?=$recordName?>&UserID=<?=$wpLoggedInUserID?>';
        }

        function saveRecord(){
            $('#fm').form('submit',{
                url: url,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the data
                        location.reload(); // need to reload the page to refresh the graphs
                    }
                }
            });
        }
        function destroyRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to delete this <?=$recordName?>?',function(r){
                    if (r){
                        $.post('<?=$incURL?>scripts/destroy_record.php?id=' +row.ID + "&ProgrammeID=<?=$progSelected?>&recordType=<?=$recordName?>",function(result){
                            if (result === 0){ // 1 = true
                                //$('#dg').datagrid('reload');    // reload the data
                                $('#dg').datagrid('loadData',[]); // clear the grid as no rows left in dbase
                                //$('#dg').datagrid({url: '<?=$getDataURL?>'});
                            } 
                            else if(result > 0){
                                $('#dg').datagrid('reload');    // reload the data
                            }
                            else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
        (function($) {
        $(document).ready(function(){
                $('#dg').datagrid({
                    <?php if( !$hideToolBar ){ ?>
                    onDblClickCell: function(index,field,value){
                        editRecord();
                    }
                    <?php } ?>
                });
/*                $('#dg').datagrid('getPager').pagination({
                    pageSize: 5, //The number of records per page, the default is 10 
                    pageList: [5, 10, 12, 14, 16] //The list can be set PageSize
                });*/

                /*$('#dg').datagrid({pagePosition:'both', pageList: [5, 10, 12, 14, 16]});                
                $('#dg').datagrid('getPager').pagination({
				layout:['list','sep','first','prev','sep','links','sep','next','last','sep','refresh']
			});*/

        });
        
})(jQuery);
    </script>
            
<?php
    //echo "ChallengeStatus = [".$_REQUEST["ChallengeStatus"]."]";
?>
    
<table id="dg" title="<?=$recordName?>" style="width:99%;height:450px"
            url= "<?=$getDataURL?>"
            toolbar="#toolbar" pagination="false" 
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <?=$dataGridHeader?>
            </tr>
        </thead>
    </table>
    <?php if( !$hideToolBar ){?>
    <div id="toolbar">

        <a href="javascript:void(0)" class="button add" onclick="newRecord()">Add</a>
        <a href="javascript:void(0)" class="button edit" onclick="editRecord()">Edit</a>
        <a href="javascript:void(0)" class="button delete" onclick="destroyRecord()">Delete</a>
        
    </div>
    <?php } ?>
    
    <div id="dlg" class="easyui-dialog" style="width:auto;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle"><?=$recordName?> Information</div>
        <form id="fm" method="post" novalidate>
            <?=$formInputs?>
        
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="button save" onclick="saveRecord()">Save</a>
        <a href="javascript:void(0)" class="button cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
    </div>

    
    <div id="dlgHTML" class="easyui-dialog" style="width:280px;height:auto;padding:10px 20px"
            closed="true" buttons="#dlgHTML-buttons">
        <div class="ftitle">My Body 90: Message</div>
        <form id="fm" method="post" novalidate>
        <div id="dlgHTMLContents" class="fcontents"></div>
        </form>
            
    </div>
    <div id="dlgHTML-buttons">
        <!--<a href="javascript:void(0)" class="button save" onclick="saveRecord()">Save</a>-->
        <a href="javascript:void(0)" class="button save" onclick="javascript:$('#dlgHTML').dialog('close')">OK</a>

    </div>
    
    <?php
    //echo "inputs = [" . count($challengeInputs) . "]";
    for($challengePhase = 0; $challengePhase < count($challengeInputs); $challengePhase ++)
    {
        ?>
    <div id="dlgFormHTML_<?=$challengePhase+1?>" class="easyui-dialog" style="text-align:center;width:28%;height:auto;padding:10px 20px"
            closed="true" buttons="#dlgFormHTML-buttons">
        <div class="ftitle">My Body 90: Input Form</div>
        <form id="fmFormHTML_<?=$challengePhase+1?>" method="post" novalidate>
        <?=$challengeInputs[$challengePhase]?>
        </form>
            
    </div>
    <div id="dlgFormHTML-buttons">
        <a href="javascript:void(0)" class="button save" onclick="saveHTMLFormRecord(<?=$challengePhase+1?>)">Save</a>
        <a href="javascript:void(0)" class="button cancel" onclick="javascript:$('#dlgFormHTML_<?=$challengePhase+1?>').dialog('close')">Cancel</a>

    </div>
    
    <?php } ?>
    
    
    
        
