jQuery(document).ready(function(){
    
// add tick mark to filled in inputs
jQuery( ".mb90-input-form-input" ).children('input').each(function(index) {
    
    if( jQuery(this).val().length > 0 ){
        jQuery(this).removeClass("form-control-danger");
        jQuery(this).addClass("form-control-success");
        jQuery(this).parents().addClass("has-success")
        jQuery(this).parents().removeClass("has-danger")
    }else{
        jQuery(this).removeClass("form-control-success");
        jQuery(this).addClass("form-control-danger");
        jQuery(this).parents().addClass("has-danger")
        jQuery(this).parents().removeClass("has-success")
    }
        
    jQuery(this).on("change", function(){
        //var boolKey = jQuery(this).data('selected');
        if( jQuery(this).val().length > 0 ){
            jQuery(this).removeClass("form-control-danger");
            jQuery(this).addClass("form-control-success");
            jQuery(this).parents().addClass("has-success");
            jQuery(this).parents().removeClass("has-danger");
        }else{
            jQuery(this).removeClass("form-control-success");
            jQuery(this).addClass("form-control-danger");
            jQuery(this).parents().addClass("has-danger");
            jQuery(this).parents().removeClass("has-success");
        }
    });
});

jQuery("#totalworkouttimespan").html(jQuery("#totalworkouttimestring").val()); // display total workout minutes and seconds
   
timeTotal = jQuery("#totalworkouttime").val() / 2;

//totalTimerDuration = jQuery("#totalTime").val(); // hidden var
rounds = jQuery("#rounds").val(); // hidden var
roundsdisplay = jQuery("#roundsdisplay").val(); // hidden var
exrest = jQuery("#exrest").val(); // hidden var
work = jQuery("#work").val(); // hidden var
experround = jQuery("#numexercises").val(); // hidden var
roundrest = jQuery("#roundrest").val(); // hidden var
roundgroupings = jQuery("#roundgroupings").val(); // hidden var ... used to force repeating of rounds

if( roundgroupings > 1 )
    summaryinfo = experround + " Exercises per round (" + (experround / roundgroupings) + " * " + roundgroupings + ")<br />" + work + " seconds per exercise<br />" + exrest + " seconds to rest between exercises<br />" + roundrest + " seconds to rest between rounds";
else
    summaryinfo = experround + " Exercises per round<br /> " + work + " seconds per exercise<br />" + exrest + " seconds to rest between exercises<br />" + roundrest + " seconds to rest between rounds";

jQuery("#exercise-summaryinfo").html(summaryinfo); // display the line of summary info

exlistingHTML = "<div class='exercise-summary-red'>";
exlistingArr = jQuery("#exlistinghidden").val().split("##,##") // hidden var

/*if(roundgroupings > 1) // if we want the user to repeat a block of exercises within the same round
{
   for( rgCount = 0; rgCount < roundgroupings-1; rgCount ++) 
   {
       exlistingArr.push.apply(exlistingArr, exlistingArr);
       alert(exlistingArr);
       //exlistingArr = exlistingArr + exlistingArr;
   }
}*/

jQuery.each(exlistingArr, function(index, value) { 
  indexInt = index*1;

  if( value.length > 0){
    exlistingHTML += '<div class="exerciseListItem"><button class="btn btn-danger mb90-nopointer">' + value + '</button></div>';
  }
});
exlistingHTML += "</div>";

jQuery("#tabata-roundsdisplay").val(roundsdisplay);
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

jQuery("#exlisting").html(exlistingHTML);



});