function mb90ProcessInput(inputObj)
{
    if( inputObj.value.length > 0 ){
        jQuery("#" + inputObj.id).removeClass("form-control-danger");
        jQuery("#" + inputObj.id).parents().eq(1).removeClass("has-danger");
        jQuery("#" + inputObj.id).addClass("form-control-success");
        jQuery("#" + inputObj.id).parents().eq(1).addClass("has-success");
    }else{
        jQuery("#" + inputObj.id).removeClass("form-control-success");
        jQuery("#" + inputObj.id).parents().eq(1).removeClass("has-success");        
        jQuery("#" + inputObj.id).addClass("form-control-danger");
        jQuery("#" + inputObj.id).parents().eq(1).addClass("has-danger");
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode < 48 || charCode > 57) && (charCode != 8 && charCode != 46))
        return false;

    return true;
}

jQuery(document).ready(function(){
    
    jQuery( ".mb90-input-form-input" ).children('input').each(function(index) {
        mb90ProcessInput(this);
    });
    
/*jQuery('document').on('change', '.form-control', function(){
    alert(jQuery(this).val());
    if( jQuery(this).val().length > 0 ){
        alert("filled");
    }else{
        alert("blank");
    }   
});*/
    
/*jQuery('input[id^="Result_"]').each(function(index){
   jQuery(document).on('change', this, function(index){
        if( jQuery(this).val().length > 0 ){
            alert("filled");
            jQuery(this).removeClass("form-control-danger");
            jQuery(this).parents().eq(1).removeClass("has-danger");
            //jQuery(this).closest("div.form-group").removeClass("has-danger");

            jQuery(this).addClass("form-control-success");
            jQuery(this).parents().eq(1).addClass("has-success");
            //jQuery(this).closest("div.form-group").addClass("has-success");
            //jQuery(this).parentsUntil(".form-group").css( "border", "3px solid green" );
        }else{
            alert("blank");
            jQuery(this).removeClass("form-control-success");
            jQuery(this).parents().eq(1).removeClass("has-success");
            //jQuery(this).closest("div.form-group").removeClass("has-success");
            jQuery(this).addClass("form-control-danger");
            jQuery(this).parents().eq(1).addClass("has-danger");
            //jQuery(this).closest("div.form-group").addClass("has-danger");
            //jQuery(this).parentsUntil(".form-group").css( "border", "3px solid blue" );
        }    
   });
});
    */
/*    jQuery('input[id^="Result_"]').on('change', function(index){
        //jQuery(document).on('change', this, function(){
            if( jQuery(this).val().length > 0 ){
                jQuery(this).removeClass("form-control-danger");
                jQuery(this).parents().eq(1).removeClass("has-danger");
                //jQuery(this).closest("div.form-group").removeClass("has-danger");

                jQuery(this).addClass("form-control-success");
                jQuery(this).parents().eq(1).addClass("has-success");
                //jQuery(this).closest("div.form-group").addClass("has-success");
                //jQuery(this).parentsUntil(".form-group").css( "border", "3px solid green" );
            }else{
                jQuery(this).removeClass("form-control-success");
                jQuery(this).parents().eq(1).removeClass("has-success");
                //jQuery(this).closest("div.form-group").removeClass("has-success");
                jQuery(this).addClass("form-control-danger");
                jQuery(this).parents().eq(1).addClass("has-danger");
                //jQuery(this).closest("div.form-group").addClass("has-danger");
                //jQuery(this).parentsUntil(".form-group").css( "border", "3px solid blue" );
            }
        //});        
    });*/
    
// add tick mark to filled in inputs
/*
jQuery( ".mb90-input-form-input" ).children('input').each(function(index) {
    
    if( jQuery(this).val().length > 0 ){
        jQuery(this).removeClass("form-control-danger");
        jQuery(this).parentsUntil(".form-group").removeClass("has-danger");
        jQuery(this).addClass("form-control-success");
        jQuery(this).parentsUntil(".form-group").addClass("has-success");
        //jQuery(this).parentsUntil(".form-group").css( "border", "3px solid green" );
    }else{
        jQuery(this).removeClass("form-control-success");
        jQuery(this).parentsUntil(".form-group").removeClass("has-success");
        jQuery(this).addClass("form-control-danger");
        jQuery(this).parentsUntil(".form-group").addClass("has-danger");
        //jQuery(this).parentsUntil(".form-group").css( "border", "3px solid blue" );
    }*/
    
    /*
    jQuery(document).on('change', jQuery('#' + jQuery(this).attr('id')), function(){
        if( jQuery(this).val().length > 0 ){
            jQuery(this).removeClass("form-control-danger");
            jQuery(this).parentsUntil("div.form-group").removeClass("has-danger");
            jQuery(this).addClass("form-control-success");
            jQuery(this).parentsUntil("div.form-group").addClass("has-success");
            //jQuery(this).parentsUntil(".form-group").css( "border", "3px solid green" );
        }else{
            jQuery(this).removeClass("form-control-success");
            jQuery(this).parentsUntil("div.form-group").removeClass("has-success");
            jQuery(this).addClass("form-control-danger");
            jQuery(this).parentsUntil("div.form-group").addClass("has-danger");
            //jQuery(this).parentsUntil(".form-group").css( "border", "3px solid blue" );
        }
    });*/
//});

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