<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once('Classes/DataGridClass.php');

global $recordType;

$dgObj = new datagrid();

if( $recordType == "Exercise"){
    $recordName = "Exercise";
    $getDataURL = $incPath . "scripts/get_prog_exercise_data.php";
}
else if( $recordType == "ExerciseListing"){
    $recordName = "Goal";
    $getDataURL = $incPath . "scripts/get_exercise_listing_data.php";
}
else if( $recordType == "ExerciseMultimedia"){
    $recordName = "ExerciseMultimedia";
    $getDataURL = $incPath . "scripts/get_ex_multimedia_data.php";
}
else if( $recordType == "ExerciseVideos"){
    $recordName = "ExerciseVideos";
    $getDataURL = $incPath . "scripts/get_ex_video_data.php";
}
else if( $recordType == "ExerciseImages"){
    $recordName = "ExerciseImages";
    $getDataURL = $incPath . "scripts/get_ex_image_data.php";
}
else if( $recordType == "Goal"){
    $recordName = "Goal";
    $getDataURL = $incPath . "scripts/get_goal_data.php";
}
else if( $recordType == "Diet"){
    $recordName = "Diet";
    $getDataURL = $incPath . "scripts/get_diet_data.php";
}

$dataGridHeader = $dgObj->getGridHeader($recordType);
$formInputs =  $dgObj->getFormInputs($recordType);


?>

    <script type="text/javascript">
        var url;
        function newRecord(){
            $('#dlg').dialog('open').dialog('setTitle','New <?=$recordName?>');
            $('#fm').form('clear');
            url = '<?=$incPath?>scripts/save_record.php?recordType=<?=$recordName?>';
        }
        function editRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                //onLoadSuccess
                $('#dlg').dialog('open').dialog('setTitle','Edit <?=$recordName?>');
                
/*                $('#fm').form({
                        onLoadSuccess:function(data){
                            //console.log(data);
                            //alert("here111");
                                processMMTypes(data);
                                //alert($('#fm input:hidden[name=ExerciseMMType]').val());
                        }
                });*/
                
                $('#fm').form('load',row);
                url = '<?=$incPath?>scripts/update_record.php?id='+row.ID+'&recordType=<?=$recordName?>';
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            }
        }
        function saveRecord(){
            //alert("saveurl = [" + url + "]");
            $('#fm').form('submit',{
                url: url,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    //alert(result);
                    var result = eval('('+result+')');
                    //alert(result);
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                        //alert(msg);
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the data
                    }
                },
                error: function (data) {
                        //alert("error");
                       var r = jQuery.parseJSON(data.responseText);
                       alert("Message: " + r.Message);
                       alert("StackTrace: " + r.StackTrace);
                       alert("ExceptionType: " + r.ExceptionType);
                }
            });
        }
        function destroyRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to delete this <?=$recordName?>?',function(r){
                    if (r){
                        $.post('<?=$incPath?>scripts/destroy_record.php?id=' +row.ID + "&ProgrammeID=<?=$progSelected?>&recordType=<?=$recordName?>",function(result){
                            if (result === 0){ // 1 = true
                                //$('#dg').datagrid('reload');    // reload the data
                                $('#dg').datagrid('loadData',[]); // clear the grid as no rows left in dbase
                                //$('#dg').datagrid({url: '<?=$getDataURL?>?progSelected=<?=$progSelected?>'});
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
                    onDblClickCell: function(index,field,value){
                    /*$(this).datagrid('beginEdit', index);
                    var ed = $(this).datagrid('getEditor', {index:index,field:field});
                    $(ed.target).focus();*/
                    editRecord();
                    }
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
            
<table id="dg" title="Programme <?=$recordName?>" style="width:99%;height:auto"
            url= "<?=$getDataURL?>?progSelected=<?=$progSelected?>"
            toolbar="#toolbar" pagination="false" 
            rownumbers="false" fitColumns="true" singleSelect="true" fitRows="true">
        <thead>
            <tr>
                <?=$dataGridHeader?>
            </tr>
        </thead>
    </table>
    <div id="toolbar">

        <a href="javascript:void(0)" class="button add" onclick="newRecord()">Add</a>
        <a href="javascript:void(0)" class="button edit" onclick="editRecord()">Edit</a>
        <a href="javascript:void(0)" class="button delete" onclick="destroyRecord()">Delete</a>
        
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:auto;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle"><?=$recordName?> Information</div>
        <form id="fm" method="post" novalidate enctype="multipart/form-data">
            <?=$formInputs?>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="button save" onclick="saveRecord()">Save</a>
        <a href="javascript:void(0)" class="button cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>

        <!--
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRecord()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
        -->
    </div>
    </form>
