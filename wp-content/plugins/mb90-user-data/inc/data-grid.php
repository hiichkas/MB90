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
    $hideToolBar = true;
    $challengeInputs = array();
    $challengeInputs = $dgObj->getHtmlFormInputs("UserBodyData", "edit");
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
        
        $.extend($.fn.dialog.methods, {
            mymove: function(jq, newposition){
                return jq.each(function(){
                    $(this).dialog('move', newposition);
                });
            }
        });

        var url;
        var formSubmitURL;
        var currentDisplayedFormID;
        
        function dialogHTML(caption, msg){

            //$('#dlgHTML').dialog('open').dialog('setTitle',caption);
            //$('#fmHTML').form('clear');
            msgHTML = '<div class="vc_row wpb_row vc_row-fluid"><div class="vc_col-sm-12 wpb_column vc_column_container">';
            msgHTML += "<div class='exercise-input-msg'>";
            msgHTML += "<h2>" + caption + "</h2>";
            msgHTML += "<div class=''>" + msg + "</div>";
            msgHTML += "</div></div></div>";
            return msgHTML;
            
        }
        
        function dialogHTMLClose(id)
        {
            $('#' + id).dialog('close');
            $("#exercies-inputform-wrapper").css("height", 0);    
        }
        
        function getFormHTML(phase)
        {
            var formHTML = $("#dlgFormHTML_" + phase).html().replace("fmFormHTML_" + phase + "_temp", "fmFormHTML_" + phase ).replace('class="ftitle"', 'style="display:none"');
            return formHTML;
        }
        
        Date.prototype.yyyymmdd = function() {
            var yyyy = this.getFullYear().toString();
            var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = this.getDate().toString();
            return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
        };
        
        function customFormHTML(formName, mode, date, challengePhase, msg, caption){
            var debugMode = <?php echo MB90_90_DEBUG; ?>;
            var todaysDate = new Date();
            var todaysDateFormatted = todaysDate.yyyymmdd();
            //alert(todaysDateFormatted);
            $(".graph-raiser").css("margin-top", "0px"); // lower the graphs as the timer will now be displayed
            if( (todaysDate.getTime() < new Date(date).getTime()) && debugMode === false){ // switch off the "date is in future" check for debugging
                $("#start-button").hide();
                msgHTML = dialogHTML(caption, msg);
                $("#exercies-inputform-wrapper").html(msgHTML);
                // hide the entire timer block
                $(".outer-timer-wrapper").hide();
            }else{
                
                if( $('#dlgFormHTML_'+challengePhase).length > 0 ){
                    $("#start-button").show();
                    $(".timer-start").show();
                    $("#exercies-inputform-wrapper").html(""); // reset form content
                    currentDisplayedFormID = "dlgFormHTML_"+challengePhase;
                    formHTML = getFormHTML(challengePhase);
                    $("#exercies-inputform-wrapper").html(formHTML);
                    // show the entire timer block
                    $(".outer-timer-wrapper").show();

                }
                
            }
            formSubmitURL = '<?=$incURL?>scripts/save_form_record.php?formType='+formName+'&date=' + date + '&mode=' + mode + '&UserID=<?=$wpLoggedInUserID?>';
        }
        
        function ValidateForm(formID)
        {
            var errorCount = 0;
            $("form#" + formID + " input[type=text]").each(function(){
                //alert($(this).prop("id"));
                if($(this).val().length === 0){
                    errorCount ++;
                    //$(this).css("border", "1px solid red");
                }else{
                    //$(this).css("border", "1px solid #0fa2e6");                    
                }
            });
            if( errorCount > 0 ){
                return false;
            }
            return true;
        }
        
        function saveHTMLFormRecord(challengePhase){
            //$('#fmFormHTMLEmbedded_'+challengePhase).form('submit',{
            $('#fmFormHTML_'+challengePhase).form('submit',{
                url: formSubmitURL,
                onSubmit: function(){
                    //return $(this).form('validate');
                    return ValidateForm("fmFormHTML_"+challengePhase); // check that all values were entered
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        /*$.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });*/
                        alert("Error: " + result.errorMsg);
                    } else {
                        alert("Data saved. Click Ok to reload the page")
                        //location.reload(); // need to reload the page to refresh the graphs
                        location.href = window.location.href;
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
    </script>
            
<?php
    //echo "ChallengeStatus = [".$_REQUEST["ChallengeStatus"]."]";
//if( $recordType == "UserBodyData"){
if( false ){
    
?>
    
<table id="dg" title="<?=$recordName?>" style="width:99%;height:450px;"
            url= "<?=$getDataURL?>"
            toolbar="#toolbar" pagination="false" 
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <?=$dataGridHeader?>
            </tr>
        </thead>
    </table>
    
<?php } ?>
    
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
    //echo "inputs length = [" . count($challengeInputs) . "]";
    //echo "challengePhase = [" . $challengePhase . "]";
    
    for($challengePhase = 0; $challengePhase < count($challengeInputs); $challengePhase ++)
    {
        ?>
    <div class="input-form-hidden" id="dlgFormHTML_<?=$challengePhase+1?>" style="text-align:center;width:28%;height:auto;padding:10px 20px;">
        <div class="ftitle">My Body 90: Input Form</div>
        <form id="fmFormHTML_<?=$challengePhase+1?>_temp" method="post">
        <?=$challengeInputs[$challengePhase]?>
        <div id="dlgFormHTML-buttons">
        <div class="vc_row wpb_row vc_row-fluid">
            <div class="vc_col-sm-12 wpb_column vc_column_container">
                <div class="mb90-input-form-button">
                    <a href="javascript:void(0)" class="button fullwidth bluebutton" onclick="saveHTMLFormRecord(<?=$challengePhase+1?>)">Save</a>
                </div>
            </div>
        </div>
        </div>
            
        </form>
            
    </div>    
    <?php } ?>
    
    
    
        
