        function myformatter(dateVal){
            var date = new Date(dateVal);
            //date.setMonth( date.getMonth() - 1 );
            var y = date.getFullYear();
            var m = date.getMonth();
            var d = date.getDate();
            return (d<10?('0'+d):d) + '/' + (m<10?('0'+m):m)+'/'+y;
        }
        function myparser(s){
            if (!s) return new Date();
            if( s.indexOf("-") !== -1){
                var ss = (s.split('-'));
                var y = parseInt(ss[0],10);
                var m = parseInt(ss[1],10);
                var d = parseInt(ss[2],10);
            }
            else{
                var ss = (s.split('/'));                
                var y = parseInt(ss[2],10);
                var m = parseInt(ss[1],10);
                var d = parseInt(ss[0],10);
            }
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                out = new Date(y,m-1,d);
                return new Date(y,m,d);
            } else {
                return new Date();
            }
        }
        
        $.fn.datebox.defaults.formatter = function(date){
                var y = date.getFullYear();
                var m = date.getMonth()+1;
                var d = date.getDate();
                return (d<10?('0'+d):d) + '/' + (m<10?('0'+m):m)+'/'+y;
        }
        
        $.fn.datebox.defaults.parser = function(s){
                var t = Date.parse(s);
                
                if (!isNaN(t)){
                    if( s.indexOf("-") !== -1){
                        var ss = (s.split('-'));
                        var y = parseInt(ss[0],10);
                        var m = parseInt(ss[1],10);
                        var d = parseInt(ss[2],10);
                    }
                    else{
                        var ss = (s.split('/'));                
                        var y = parseInt(ss[2],10);
                        var m = parseInt(ss[1],10);
                        var d = parseInt(ss[0],10);
                    }
                    return new Date(y,m-1,d);
                } else {
                        return new Date();
                }
        }
        
        $.updateExerciseMeasurement = function(val){
            alert(val);
            $selectedExerciseID = $("#ExerciseID").val();
            
            //$measurementType = $("#MeasurementTypeExerciseID").val($measurementType).text();
            $("#MeasurementTypeExerciseID").val($selectedExerciseID);
            
            $("#Result").html($measurementType);
        }

        $.fn.combo.defaults.onSelect = function(s){
            $('#MeasurementTypeExerciseID').combobox('setValue', s.value);
            
            var selectedText = $('#MeasurementTypeExerciseID').combobox('getText');
            
            $('#MeasurementType').textbox('setValue', selectedText);
            //$("#Result").html(selectedText + ":");
            //alert($("#MeasurementTypeExerciseID").val());
        }
        
        function updateMeasurementType(value,row)
        {
            $.fn.combo.defaults.onSelect(value);
        }
        
        function formatDate(value,row){
          var d = new Date(value);
          var out = $.fn.datebox.defaults.formatter(d);
          return out;
        }
        
        function parseDate(value,row){
          var d = new Date(value);
          var out = $.fn.datebox.defaults.parser(value);
          return out;
        }

        function getCurrentDate()
        {
            var date = new Date();
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d) + '/' + (m<10?('0'+m):m)+'/'+y;
        }