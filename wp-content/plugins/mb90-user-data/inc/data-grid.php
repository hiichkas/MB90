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
    //$challengeInputs = array();
    $challengeInputs = $dgObj->getHtmlFormInputs("UserBodyData", "edit");
    $formDataAvailable = $challengeInputs[0];
    unset($challengeInputs[0]); // remove the flag
    $challengeInputs = array_values ( $challengeInputs );
}
else if( $recordType == "User10DayChallenge"){
    $recordName = "User10DayChallenge";
    $getDataURL = $pluginURL . "inc/scripts/get_user_10daychallenge_data.php?wpLoggedInUserID=$wpLoggedInUserID";
    $hideToolBar = true;
    //$challengeInputs = array();
    $challengeInputs = $dgObj->getHtmlFormInputs("User10DayChallenge", "edit");
    $formDataAvailable = $challengeInputs[0];
    unset($challengeInputs[0]); // remove the flag
    $challengeInputs = array_values ( $challengeInputs );
}
else if( $recordType == "UserSelfAssessment"){
    $recordName = "UserSelfAssessment";
    $getDataURL = $pluginURL . "inc/scripts/get_user_selfassessment_data.php?wpLoggedInUserID=$wpLoggedInUserID";
    $hideToolBar = true;
    //$challengeInputs = array();
    
    $challengeInputs = $dgObj->getHtmlFormInputs("SelfAssessment", "edit");
    //echo "[[[" . print_R($challengeInputs) . "]]]";
    $formDataAvailable = $challengeInputs[0];
    unset($challengeInputs[0]); // remove the flag
    $challengeInputs = array_values ( $challengeInputs );
}

$dataGridHeader = $dgObj->getGridHeader($recordType);
$formInputs =  $dgObj->getFormInputs($recordType);


//echo "....".$challengeInputs."....";

?>

    <script type="text/javascript">
        
        var url;
        var formSubmitURL;
        var currentDisplayedFormID;
        
        function dialogHTML(caption, msg){

            //jQuery('#dlgHTML').dialog('open').dialog('setTitle',caption);
            //jQuery('#fmHTML').form('clear');
            msgHTML = '<div class="vc_row wpb_row vc_row-fluid"><div class="vc_col-sm-12 wpb_column vc_column_container">';
            msgHTML += "<div class='exercise-input-msg'>";
            msgHTML += "<h2>" + caption + "</h2>";
            msgHTML += "<div class=''>" + msg + "</div>";
            msgHTML += "</div></div></div>";
            return msgHTML;
            
        }
        
        function dialogHTMLClose(id)
        {
            jQuery('#' + id).dialog('close');
            jQuery("#exercies-inputform-wrapper").css("height", 0);    
        }
        
        function getFormHTML(phase)
        {
            var formHTML = jQuery("#dlgFormHTML_" + phase).html().replace("fmFormHTML_" + phase + "_temp", "fmFormHTML_" + phase ).replace('class="ftitle"', 'style="display:none"');
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
            jQuery(".graph-raiser").css("margin-top", "0px"); // lower the graphs as the timer will now be displayed
            if( (todaysDate.getTime() < new Date(date).getTime()) && debugMode === false){ // switch off the "date is in future" check for debugging/testing
                jQuery("#start-button").hide();
                msgHTML = dialogHTML(caption, msg);
                jQuery("#exercies-inputform-wrapper").html(msgHTML);
                // hide the entire timer block
                jQuery(".outer-timer-wrapper").hide();
            }else{
                if( jQuery('#dlgFormHTML_'+challengePhase).length > 0 ){
                    jQuery("#start-button").show();
                    jQuery(".timer-start").show();
                    jQuery("#exercies-inputform-wrapper").html(""); // reset form content
                    currentDisplayedFormID = "dlgFormHTML_"+challengePhase;
                    
                    jQuery('div[id^="dlgFormHTML_"]').hide();
                    jQuery("#" + currentDisplayedFormID).show();
                    //jQuery("#" + currentDisplayedFormID).css("display", "block !important");
                    //alert(jQuery("#" + currentDisplayedFormID).html());
                    
                    //formHTML = getFormHTML(challengePhase);
                    //jQuery("#exercies-inputform-wrapper").html(formHTML);
                    
                    //jQuery("#Result_31").slider({step: 1, min: 0, max: 100, value: 1, tooltip: 'always'});
                    
                    //jQuery(".mb90-input-form-input > input[type=text]")
                    // show the entire timer block
                    jQuery(".outer-timer-wrapper").show();
                    //jQuery("#user-sa-data-wrapper").show();
                }
                
            }
            formSubmitURL = '<?=$incURL?>scripts/save_form_record.php?formType='+formName+'&date=' + date + '&mode=' + mode + '&UserID=<?=$wpLoggedInUserID?>';
        }
        
        function ValidateForm(formID)
        {
            var errorCount = 0;
            jQuery("form" + formID + " input[id^=Result_]").each(function(){
                if(jQuery(this).val().length == 0 || jQuery(this).val() == 0){
                    errorCount ++;
                    jQuery(this).parent().css("border", "1px solid red");
                }else{
                    jQuery(this).parent().css("border", "1px solid rgba(51, 51, 51, 0.45)");
                }
            });
            if( errorCount > 0 ){
                return false;
            }
            return true;
        }
        
        function saveHTMLFormRecord(e, challengePhase){
            //e.preventDefault();
            //var formOK = ValidateForm("fmFormHTML_"+challengePhase);
            //formOK
            //jQuery('#fmFormHTMLEmbedded_'+challengePhase).form('submit',{
            jQuery('#fmFormHTML_'+challengePhase+'_temp').form('submit',{
                url: formSubmitURL,
                onSubmit: function(){
                    //return jQuery(this).form('validate');
                    ok = ValidateForm('#fmFormHTML_'+challengePhase+'_temp');
                    if( !ok ){
                        e.preventDefault();
                        jQuery("#mb90ExerciseFormMessage").addClass("mb90ErrorMessage");
                        jQuery("#mb90ExerciseFormMessage").html("<?php echo FILL_ALL_FORM_FIELDS?>").slideDown(1000);
                    }else{
                        e.preventDefault();
                        jQuery("#mb90ExerciseFormMessage").removeClass("mb90ErrorMessage");
                        jQuery("#mb90ExerciseFormMessage").html("").slideUp(1000);
                    }
                    return ok; // check that all values were entered
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        /*jQuery.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });*/
                        alert("Error: " + result.errorMsg);
                    } else {
                        alert("Data saved. Click Ok to reload the page")
                        //location.reload(); // need to reload the page to refresh the graphs
                        //location.href = window.location.href;
                        var form = document.createElement("form");
                        form.setAttribute("method", "POST");
                        form.setAttribute("action", window.location.href );
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", "exDay");
                        hiddenField.setAttribute("value", jQuery("#exDayLocal").val());
                        form.appendChild(hiddenField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            });
        }
        
        function newRecord(){
            var currentDate = getCurrentDate();

            jQuery('#dlg').dialog('open').dialog('setTitle','New <?=$recordName?>');
            jQuery('#fm').form('clear');
            jQuery('#fm').form('load', {
                InputDate: currentDate
            });
            url = '<?=$incURL?>scripts/save_record.php?recordType=<?=$recordName?>&UserID=<?=$wpLoggedInUserID?>';
        }
        function editRecord(){
            
            var row = jQuery('#dg').datagrid('getSelected');
            if (row){
                jQuery('#dlg').dialog('open').dialog('setTitle','Edit <?=$recordName?>');
                jQuery('#fm').form('load',row);
                url = '<?=$incURL?>scripts/update_record.php?id='+row.ID+'&recordType=<?=$recordName?>&UserID=<?=$wpLoggedInUserID?>';
            }
        }
        
        function editChallengeRecord(name){
            jQuery('#dlgChallenge').dialog('open').dialog('setTitle','Edit ' + name);
            jQuery('#fmChallenge').form('load',row);
            url = '<?=$incURL?>scripts/update_record.php?id='+row.ID+'&recordType=<?=$recordName?>&UserID=<?=$wpLoggedInUserID?>';
        }

        function saveRecord(){
            jQuery('#fm').form('submit',{
                url: url,
                onSubmit: function(){
                    return jQuery(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        jQuery.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        jQuery('#dlg').dialog('close');        // close the dialog
                        jQuery('#dg').datagrid('reload');    // reload the data
                        location.reload(); // need to reload the page to refresh the graphs
                    }
                }
            });
        }
        function destroyRecord(){
            var row = jQuery('#dg').datagrid('getSelected');
            if (row){
                jQuery.messager.confirm('Confirm','Are you sure you want to delete this <?=$recordName?>?',function(r){
                    if (r){
                        jQuery.post('<?=$incURL?>scripts/destroy_record.php?id=' +row.ID + "&ProgrammeID=<?=$progSelected?>&recordType=<?=$recordName?>",function(result){
                            if (result === 0){ // 1 = true
                                //jQuery('#dg').datagrid('reload');    // reload the data
                                jQuery('#dg').datagrid('loadData',[]); // clear the grid as no rows left in dbase
                                //jQuery('#dg').datagrid({url: '<?=$getDataURL?>'});
                            } 
                            else if(result > 0){
                                jQuery('#dg').datagrid('reload');    // reload the data
                            }
                            else {
                                jQuery.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
        
    jQuery( document ).ready(function() {
        
        jQuery.extend(jQuery.fn.dialog.methods, {
            mymove: function(jq, newposition){
                return jq.each(function(){
                    jQuery(this).dialog('move', newposition);
                });
            }
        });


        
        //jQuery(document).ready(function(){
                //jQuery('[data-toggle="tooltip"]').tooltip()
                /*jQuery(".mb90-input-form-input > input[type=text]").slider({step: 1, min: 0, max: 100, value: 1, tooltip: 'always'});
                jQuery(".mb90-input-form-input > input[type=text]").each(function(){
                    jQuery(this).on('slide', function(slideEvt){
                        alert(slideEvt.value);
                        jQuery("#exerciseInputSliderDisplay").text(slideEvt.value);
                    });
                });*/
                /*jQuery(".mb90-input-form-input > input[id^='Result_']").slider({step: 1, min: 0, max: 100, value: 1, tooltip: 'always'});
                jQuery(".mb90-input-form-input > input[id^='Result_']").each(function(){
                    var id = "#" + this.id;
                    jQuery("body").on('change', "'" + id + "'", function(event){
                        alert("here");
                    });
                    alert(this.id);
                    jQuery(this).slider().on('slide', function(slideEvt){
                        alert(slideEvt.value);
                        jQuery("#exerciseInputSliderDisplay30").text(slideEvt.value);
                    });
                });*/
                
                jQuery('#dg').datagrid({
                    <?php if( !$hideToolBar ){ ?>
                    onDblClickCell: function(index,field,value){
                        editRecord();
                    }
                    <?php } ?>
                });
/*                jQuery('#dg').datagrid('getPager').pagination({
                    pageSize: 5, //The number of records per page, the default is 10 
                    pageList: [5, 10, 12, 14, 16] //The list can be set PageSize
                });*/

                /*jQuery('#dg').datagrid({pagePosition:'both', pageList: [5, 10, 12, 14, 16]});                
                jQuery('#dg').datagrid('getPager').pagination({
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
    <div id="toolbar" style="display:none !important">

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
    echo '<div id="hiddenExerciseForms">';
    for($challengePhase = 0; $challengePhase < count($challengeInputs); $challengePhase ++)
    {
        ?>
    <!--<div class="input-form-hidden" id="dlgFormHTML_<?=$challengePhase+1?>" style="text-align:center;width:28%;height:auto;padding:10px 20px;">-->
    <div id="dlgFormHTML_<?=$challengePhase+1?>" class="mb90ExerciseInputFormHTML">
        <div class="ftitle">My Body 90: Input Form</div>
        <form id="fmFormHTML_<?=$challengePhase+1?>_temp" method="post">
        <?=$challengeInputs[$challengePhase]?>
        <div id="dlgFormHTML-buttons">
        <div class="vc_row wpb_row vc_row-fluid">
            <div class="vc_col-sm-12 wpb_column vc_column_container">
                <div class="mb90-input-form-button">
                    <!--<a href="javascript:void(0)" class="button fullwidth bluebutton" onclick="saveHTMLFormRecord(<?=$challengePhase+1?>)">Save</a>-->
                    <!--<button data-toggle="tooltip" data-placement="top" title="Please fill all fields" class="btn btn-primary" onclick="saveHTMLFormRecord(event, <?=$challengePhase+1?>)">Save Details</button>-->
                    <button class="btn btn-primary" onclick="saveHTMLFormRecord(event, <?=$challengePhase+1?>)">Save Details</button>
                </div>
                <div class="mb90-input-form-message-wrapper">
                    <div class="mb90FormMessage" id="mb90ExerciseFormMessage"></div>
                </div>
            </div>
        </div>
        </div>
            
        </form>
            
    </div>    
    <?php } ?>
    </div> <!-- close off the hidden forms div ... these are only used for data ... not displayed -->
    </div>   
    </div>   
    <?php
    //echo "challenge inputs = [" . $formDataAvailable . "]";
    if( !$formDataAvailable ){
        //echo '</div>' . "\r\n" . '</div>' . "\r\n" . '</div>' . "\r\n" . '</div>' . "\r\n";
        echo '</div>' . "\r\n";
    }else{
        echo '</div>' . "\r\n" . '</div>' . "\r\n";
    }
    ?>

    
    
    
        
