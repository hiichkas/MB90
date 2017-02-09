<script type="text/javascript">
    
function getFormHTML(phase)
{
    formOuterHTML = jQuery('<div>').append(jQuery("#fmFormHTML_" + phase + "_temp").clone()).html();
    //alert(formOuterHTML);
    var formHTML = formOuterHTML.replace("fmFormHTML_" + phase + "_temp", "fmFormHTML_" + phase ).replace('class="ftitle"', 'style="display:none"');
    return formHTML;
}

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

function customFormHTML(formName, mode, date, challengePhase, msg, caption){
    //alert(challengePhase);

    stopFormFill = false;
    if( challengePhase > 1){
        prevDateFormVal = jQuery("#Result_" + (challengePhase-2) + "0").val();
        if( prevDateFormVal == 0 || prevDateFormVal.length == 0){
            alert("<?php echo FILL_ALL_PREVIOUS_FORMS; ?>");
            stopFormFill = true;
            return;
        }
    }

    if( !stopFormFill )
    {

        var debugMode = "<?php if( '"' . MB90_DEBUG . '"' == "true" && $_SESSION["LoggedUserID"] == MB90_ADMIN_USERID ){ echo true; }else{ echo false; } ?>";
        var todaysDate = new Date();
        var todaysDateFormatted = todaysDate.yyyymmdd();
        //alert(todaysDateFormatted);
        jQuery(".graph-raiser").css("margin-top", "0px"); // lower the graphs as the timer will now be displayed
        if( (todaysDate.getTime() < new Date(date).getTime()) && debugMode == ""){ // switch off the "date is in future" check for debugging/testing
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
                //jQuery("#" + currentDisplayedFormID).show();
                //jQuery("#" + currentDisplayedFormID).css("display", "block !important");
                //alert(jQuery("#" + currentDisplayedFormID).html());

                formHTML = getFormHTML(challengePhase);
                jQuery("#exercies-inputform-wrapper").html(formHTML);

                //jQuery("#Result_31").slider({step: 1, min: 0, max: 100, value: 1, tooltip: 'always'});

                //jQuery(".mb90-input-form-input > input[type=text]")
                // show the entire timer block
                jQuery(".outer-timer-wrapper").show(); // show the timer bars and start button


                //jQuery("#user-sa-data-wrapper").show();
            }

        }
        formSubmitURL = '<?=$incURL?>scripts/save_form_record.php?formType='+formName+'&date=' + date + '&mode=' + mode + '&UserID=<?=$wpLoggedInUserID?>';
    }
}

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
    //alert(val);
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
</script>