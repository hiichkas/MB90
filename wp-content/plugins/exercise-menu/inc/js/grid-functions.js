                var programmes;
                $.get( "../wp-content/plugins/exercise-menu/inc/data-grid/data/get_dropdowns.php?mode=programmes", function( data ) {
                    programmes = [data];
                });
                var exerciseTypes;
                $.get( "../wp-content/plugins/exercise-menu/inc/data-grid/data/get_dropdowns.php?mode=exercise_types", function( data ) {
                    exerciseTypes = [data];
                });
                
		$(function(){
			$('#tt').datagrid({
				title:'Editable DataGrid',
				iconCls:'icon-edit',
				width:1050,
				height:400,
				singleSelect:true,
				idField:'ID',
				//url:'../wp-content/plugins/exercise-menu/inc/data-grid/data/datagrid_exercises.json', 
                                url:'../wp-content/plugins/exercise-menu/inc/data-grid/data/get_prog_exercise_data.php', 
                                //saveUrl: '../wp-content/plugins/exercise-menu/inc/data-grid/insert_exercise.php',
				columns:[[
					{field:'ID',title:'ID',width:40},
					{field:'ProgrammeID',title:'Programme',width:100,
						formatter:function(value){
							for(var i=0; i<programmes.length; i++){
								if (programmes[i].productid == value) return programmes[i].name;
							}
							return value;
						},
						editor:{
							type:'combobox',
							options:{
								valueField:'ID',
								textField:'name',
								data:programmes,
								required:true
							}
						}
					},
					{field:'ExerciseID',title:'Exercise',width:100,
						formatter:function(value){
							for(var i=0; i<exerciseTypes.length; i++){
								if (exerciseTypes[i].productid == value) return exerciseTypes[i].name;
							}
							return value;
						},
						editor:{
							type:'combobox',
							options:{
								valueField:'ID',
								textField:'name',
								data:exerciseTypes,
								required:true
							}
						}
					},
					{field:'ExerciseDay',title:'Exercise Day',width:100,align:'right',editor:{type:'numberbox',options:{precision:1}}},
					{field:'Reps',title:'Reps',width:60,align:'right',editor:'numberbox'},
					{field:'NumMinsForReps',title:'Minutes For Reps',width:140,editor:'text'},
					{field:'SelfAssessment',title:'Self Assessment',width:140,align:'center',
						editor:{
							type:'checkbox',
							options:{
								on: 'Y',
								off: ''
							}
						}
					},
					{field:'10DayChallenge',title:'10 Day Challenge',width:140,align:'center',
						editor:{
							type:'checkbox',
							options:{
								on: 'Y',
								off: ''
							}
						}
					},
					{field:'10DayChallengePhase',title:'10DayChallengePhase',width:150,align:'right',editor:'numberbox'},
					{field:'action',title:'Action',width:80,align:'center',
						formatter:function(value,row,index){
							if (row.editing){
								var s = '<a href="#" onclick="saverow(this)">Save</a> ';
								var c = '<a href="#" onclick="cancelrow(this)">Cancel</a>';
								return s+c;
							} else {
								var e = '<a href="#" onclick="editrow(this)">Edit</a> ';
								var d = '<a href="#" onclick="deleterow(this)">Delete</a>';
								return e+d;
							}
						}
					}
				]],
				onBeforeEdit:function(index,row){
					row.editing = true;
					updateActions(index);
				},
				onAfterEdit:function(index,row){
					row.editing = false;
					updateActions(index);
				},
				onCancelEdit:function(index,row){
					row.editing = false;
					updateActions(index);
				}
			});
		});
		function updateActions(index){
			$('#tt').datagrid('updateRow',{
				index: index,
				row:{}
			});
		}
		function getRowIndex(target){
			var tr = $(target).closest('tr.datagrid-row');
			return parseInt(tr.attr('datagrid-row-index'));
		}
		function editrow(target){
			$('#tt').datagrid('beginEdit', getRowIndex(target));
		}
		function deleterow(target){
			$.messager.confirm('Confirm','Are you sure?',function(r){
				if (r){
					$('#tt').datagrid('deleteRow', getRowIndex(target));
				}
			});
		}
		function saverow(target){
			$('#tt').datagrid('endEdit', getRowIndex(target));
		}
		function cancelrow(target){
			$('#tt').datagrid('cancelEdit', getRowIndex(target));
		}
		function insert(){
			var row = $('#tt').datagrid('getSelected');
			if (row){
				var index = $('#tt').datagrid('getRowIndex', row);
			} else {
				index = 0;
			}
			$('#tt').datagrid('insertRow', {
				index: index,
				row:{
					status:'P'
				}
			});
			$('#tt').datagrid('selectRow',index);
			$('#tt').datagrid('beginEdit',index);
		}


