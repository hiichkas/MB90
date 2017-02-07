function mb90ProcessInput(inputObj)
{
    /*if( inputObj.value.length > 0 ){
        jQuery("#" + inputObj.id).removeClass("form-control-danger");
        jQuery("#" + inputObj.id).parents().eq(1).removeClass("has-danger");
        jQuery("#" + inputObj.id).addClass("form-control-success");
        jQuery("#" + inputObj.id).parents().eq(1).addClass("has-success");
    }else{
        jQuery("#" + inputObj.id).removeClass("form-control-success");
        jQuery("#" + inputObj.id).parents().eq(1).removeClass("has-success");        
        jQuery("#" + inputObj.id).addClass("form-control-danger");
        jQuery("#" + inputObj.id).parents().eq(1).addClass("has-danger");
    }*/
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode < 48 || charCode > 57) && (charCode != 8 && charCode != 46))
        return false;

    return true;
}

jQuery(document).ready(function(){
    
    jQuery("input[id^=Result_]").each(function(){
        jQuery(this).next("div.noUi-base").remove(); // hack to delete duplicate sliders
    });
    
    //jQuery("#chart-container-lower").html(""); // hide the font-awesome spinning loader image
    var chartHTML = jQuery("#chart-container").html();
    jQuery("#chart-container").html(""); // reset the chart container
    // append the chart html to the bottom row
    //alert(chartHTML);
    jQuery("#chart-container-lower").append(chartHTML);
    jQuery("#chart-container").show();
    //jQuery("#hiddenExerciseForms").show(); // show the hidden form panel after processing completed
    
    //jQuery('[data-toggle="tooltip"]').tooltip();
    //jQuery('.mb90-input-form-button > button').tooltip('show');
    
    // turn on the bootstrap validation for form inputs
    //jQuery( ".mb90-input-form-input" ).children('input').each(function(index) {
        //mb90ProcessInput(this);
    //});
    

//alert(jQuery("#totalworkouttimestring").val());
jQuery("#totalworkouttimespandisplay").html(jQuery("#totalworkouttimestring").val()); // display total workout minutes and seconds
   
timeTotal = jQuery("#totalworkouttime").val() / 2;

//totalTimerDuration = jQuery("#totalTime").val(); // hidden var
exDayLocal = jQuery("#exDayLocal").val();
rounds = jQuery("#rounds").val(); // hidden var
roundsdisplay = jQuery("#roundsdisplay").val(); // hidden var
exrest = jQuery("#exrest").val(); // hidden var
work = jQuery("#work").val(); // hidden var
experround = jQuery("#numexercises").val(); // hidden var
roundrest = jQuery("#roundrest").val(); // hidden var
roundgroupings = jQuery("#roundgroupings").val(); // hidden var ... used to force repeating of rounds

if( roundgroupings > 1 )
    summaryinfo = "Exercise Day: " + exDayLocal + "<br />Number of rounds: " + roundsdisplay + "<br />Exercises per round: (" + (experround / roundgroupings) + " * " + roundgroupings + ")<br />" + work + " seconds per exercise<br />" + exrest + " seconds to rest between exercises<br />" + roundrest + " seconds to rest between rounds";
else
    summaryinfo = "Exercise Day: " + exDayLocal + "<br />Number of rounds: " + roundsdisplay + "<br />Exercises per round: " + experround + "<br /> " + work + " seconds per exercise<br />" + exrest + " seconds to rest between exercises<br />" + roundrest + " seconds to rest between rounds";

jQuery("#exercise-summaryinfo").html(summaryinfo); // display the line of summary info

exlistingArr = jQuery("#exlistinghidden").val().split("##,##"); // hidden var

/*if(roundgroupings > 1) // if we want the user to repeat a block of exercises within the same round
{
   for( rgCount = 0; rgCount < roundgroupings-1; rgCount ++) 
   {
       exlistingArr.push.apply(exlistingArr, exlistingArr);
       alert(exlistingArr);
       //exlistingArr = exlistingArr + exlistingArr;
   }
}*/

/* commented exercise scroller 
//exlistingHTML = "<div class='exercise-summary-red ex-scroller-center'  id='ex-scroller-content'>";
exlistingHTML = "<div class='ex-scroller-center'  id='ex-scroller-content'>";

jQuery.each(exlistingArr, function(index, value) { 
  indexInt = index*1;

  if( value.length > 0){
    //exlistingHTML += '<div class="exerciseListItem ex-scroller-internal"><button class="btn mb90-nopointer">' + value + '</button></div>';
    exlistingHTML += '<div class="exerciseListItem ex-scroller-internal"><button class="btn mb90-nopointer">' + value + '</button></div>';
  }
});
exlistingHTML += "</div>"; // close the #ex-scroller-content div
//exlistingHTML += "</div>"; // close the outer-timer-wrapper div
    
jQuery("#mb90-exercise-scroller").html(exlistingHTML);
    
    */

jQuery("#tabata-roundsdisplay").val(roundsdisplay);
jQuery("#round-number").val(roundsdisplay);
jQuery("#tabata-rounds").val(rounds) * roundgroupings; // total rounds = (numexercises * rounds) * roundgroupings
jQuery("#tabata-exrest").val(exrest);
jQuery("#tabata-work").val(work);
jQuery("#tabata-experround").val(experround);
jQuery("#tabata-experround-image").html(experround);
jQuery("#tabata-roundsrest").val(roundrest);


//jQuery("#tabata-rounds").prop('disabled', true);
//jQuery("#tabata-exrest").prop('disabled', true);
//jQuery("#tabata-work").prop('disabled', true);
//$exListing .= '<p style=\"text-align: right;\"><strong>' . $currentExName . '</strong></p>';
//var testButtonsHTML = '<div class="horizon horizon-prev"><<</div><div class = "horizon horizon-next">>></div>';
//jQuery("#mb90-exercise-scroller").html(exlistingHTML + testButtonsHTML);

//var scrollerItemWidth = jQuery( "div.exerciseListItem" ).first().width();


});

jQuery(window).on('load', function() {
   jQuery("#mb90-load-cover").hide();
});

