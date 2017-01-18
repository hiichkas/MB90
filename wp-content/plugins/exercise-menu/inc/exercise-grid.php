<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$recordType = $_REQUEST["recordType"];
if( $recordType == "programmeExercise"){
    $recordName = "Exercise";
}

?>

    <script type="text/javascript">
        var url;
        function newRecord(){
            $('#dlg').dialog('open').dialog('setTitle','New <?=$recordName?>');
            $('#fm').form('clear');
            url = 'save_record.php';
        }
        function editRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit Exercise');
                $('#fm').form('load',row);
                url = 'update_record.php?id='+row.id;
            }
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
                    }
                }
            });
        }
        function destroyRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to delete this Exercise?',function(r){
                    if (r){
                        $.post('destroy_record.php',{id:row.id},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the data
                            } else {
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
    </script>
    <style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
        .fitem input{
            width:160px;
        }
        
        .panel{height:550px}
        #dlg{height:470px !important}
    </style>

<table id="dg" title="Programme Exercises" class="easyui-datagrid" style="width:1050px;height:350px"
            url="../wp-content/plugins/exercise-menu/inc/data-grid/data/get_prog_exercise_data.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="ProgrammeID" width="50">Programme</th>
                <th field="ExerciseID" width="50">Exercise</th>
                <th field="ExerciseDay" width="50">Exercise Day</th>
                <th field="Reps" width="50">Reps</th>
                <th field="NumMinsForReps" width="50">Minutes for Reps</th>
                <th field="SelfAssessment" width="50" >Self Assessment</th>
                <th field="SelfAssessmentPhase" width="50">Self Assessment Phase</th>
                <th field="10DayChallenge" width="50" >10 Day Challenge</th>
                <th field="10DayChallengePhase" width="50">10 Day Challenge Phase</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">New Exercise</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Edit Exercise</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyRecord()">Remove Exercise</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle"><?=$recordName?> Information</div>
        <form id="fm" method="post" novalidate enctype="multipart/form-data">
            <div class="fitem">
                <label>Programme:</label>
                <input name="ProgrammeID" class="easyui-textbox" required="true">
            </div>
            <div class="fitem">
                <label>Exercise:</label>
                <input name="ExerciseID " class="easyui-textbox" required="true">
            </div>
            <div class="fitem">
                <label>Exercise Day:</label>
                <input name="ExerciseDay" class="easyui-textbox">
            </div>
            <div class="fitem">
                <label>Reps:</label>
               <!--!<input name="Reps" class="easyui-textbox" validType="email">-->
                 <input name="Reps" class="easyui-textbox" required="true">
            </div>
            
            <div class="fitem">
                <label>Minutes for Reps:</label>
                 <input name="NumMinsForReps" class="easyui-textbox" required="true">
            </div>
            <div class="fitem">
                <label>Self Assessment:</label>
                 <input type="checkbox" name="SelfAssessment" class="easyui-checkbox" required="true">
            </div>
            <div class="fitem">
                <label>10 Day Challenge:</label>
                 <input type="checkbox" name="10DayChallenge" class="easyui-checkbox" required="true">
            </div>

            <div class="fitem">
                <label>10 Day Challenge Phase:</label>
                 <input name="10DayChallengePhase" class="easyui-checkbox" required="true">
            </div>
            <div class="fitem">
                <label>10 Day Challenge:</label>
                 <input name="10DayChallenge" class="easyui-textbox" required="true">
            </div>
            
            <div class="fitem">
                <label>Message:</label>
                 <textarea name="Message" class="easyui-textarea" required="true"></textarea>
            </div>
            
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRecord()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    </form>
