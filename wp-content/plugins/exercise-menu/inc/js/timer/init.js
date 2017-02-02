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
    summaryinfo = "Exercise Day: " + exDayLocal + "<br />Exercises per round: (" + (experround / roundgroupings) + " * " + roundgroupings + ")<br />" + work + " seconds per exercise<br />" + exrest + " seconds to rest between exercises<br />" + roundrest + " seconds to rest between rounds";
else
    summaryinfo = "Exercise Day: " + exDayLocal + "<br />Exercises per round: " + experround + "<br /> " + work + " seconds per exercise<br />" + exrest + " seconds to rest between exercises<br />" + roundrest + " seconds to rest between rounds";

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

var exScrollerIndex = 0; // used to store the widths of each exercise elemenet within the scroller
var exScrollerWidthArray = [];
var totScrollDistance = 0;

//setTimeout(function(){
    
//}, 5000);
    
//alert(JSON.stringify(exScrollerWidthArray));

/*function scrollToPreviousExercise()
{
    jQuery('#ex-scroller-content').animate({
      //scrollLeft: "-=" + exScrollerWidthArray[exScrollerIndex] + "px"
      scrollLeft: "-=" + exScrollerWidthArray[exScrollerIndex]
      //scrollLeft: "-=775px"
    }, "slow");
    exScrollerIndex --;
    if( exScrollerIndex == 0 )
        exScrollerIndex = exScrollerWidthArray.length;
}

function scrollToNextExercise()
{
    alert("next ex");
    jQuery('#ex-scroller-content').animate({
      //scrollLeft: "-=" + exScrollerWidthArray[exScrollerIndex] + "px"
      scrollLeft: "-=" + exScrollerWidthArray[exScrollerIndex]
      //scrollLeft: "-=775px"
    }, "slow");
    exScrollerIndex --;
    if( exScrollerIndex == 0 )
        exScrollerIndex = exScrollerWidthArray.length;
}
    */

  setTimeout(function() {}, 3000);
  pollVisibility();

  function pollVisibility() {
      if (jQuery(".outer-timer-wrapper").css("display") == "block") {
        jQuery( ".exerciseListItem" ).each(function(){
            //exScrollerWidthArray.push(jQuery(this).css("width"));
            exScrollerWidthArray.push(jQuery(this).width() + 8); // add 4px for the padding
            totScrollDistance += jQuery(this).width() + 8;
        });  
      } else {
          setTimeout(pollVisibility, 500);
      }
  }
  
jQuery('.horizon-prev').on('click', function(event) {
    //alert("here prev");
    //alert(exScrollerWidthArray[exScrollerIndex]);
    event.preventDefault();
    jQuery('#ex-scroller-content').animate({
      scrollLeft: "-=" + (exScrollerWidthArray[exScrollerIndex]) + "px" // add 2 px for padding
      //scrollLeft: "-=" + exScrollerWidthArray[exScrollerIndex]
      //scrollLeft: "-=775px"
    }, "slow");
    exScrollerIndex --;
    if( exScrollerIndex == 0 )
        exScrollerIndex = exScrollerWidthArray.length;
});

jQuery('.horizon-next').on('click', function(event) {
    //alert("here next");
    //alert(exScrollerWidthArray[exScrollerIndex]);
    event.preventDefault();
    jQuery('#ex-scroller-content').animate({
      scrollLeft: "+=" + exScrollerWidthArray[exScrollerIndex] + "px"
      //scrollLeft: "+=" + exScrollerWidthArray[exScrollerIndex]
      //scrollLeft: "+=775px"
    }, "slow");
    
    //alert(totScrollDistance);
    
    jQuery('#ex-scroller-content').parent().css({position: 'relative'});
    //jQuery('#ex-scroller-content').css({left:-totScrollDistance});
    
    exScrollerIndex ++;
    if( exScrollerIndex == exScrollerWidthArray.length ){
        
        alert("at end");
        jQuery('#ex-scroller-content').animate({
            scrollLeft: "-=" + totScrollDistance + "px"
        }, "slow");

        exScrollerIndex = 0;
    }
});
                
//jQuery("#exlisting").html(exlistingHTML);

//jQuery(".mb90-input-form-input > input[type=text]").slider({step: 1, min: 0, max: 100});

/*jQuery(".mb90-input-form-input > input[type=text]").each(function(){
    jQuery(this).on('slide', function(slideEvt){
        alert(slideEvt.value);
        jQuery("#exerciseInputSliderDisplay").text(slideEvt.value);
    });
});*/
    
//jQuery(".mb90-input-form-input > input[id^='Result_']").slider({step: 1, min: 0, max: 100, value: 1, tooltip: 'always'});
        //.on('change', function(){
    //alert("hello");
//});

    /*jQuery(".mb90-input-form-input > input[name^='Result_']").trigger('slider-change');
    
    jQuery(".mb90-input-form-input > input[name^='Result_']").each(function(){
        alert("outside event");
        jQuery(this).on("slider-change", function(event){
            alert("in event");
            //alert("value = [" + event.value + "]")
            //alert("value = [" + jQuery(this).val() + "]");
        });
    });*/

/*jQuery(".mb90-input-form-input > input[id^='Result_']").each(function(){
    var id = "#" + this.id;
    jQuery(id).on('change', function(event){
        alert("here");
    });
    alert(this.id);
    jQuery(this).slider().on('slide', function(slideEvt){
        alert(slideEvt.value);
        jQuery("#exerciseInputSliderDisplay30").text(slideEvt.value);
    });
});*/
    /*
    var slides = document.getElementsByClassName("mb90Slider");
    var placeHolders = document.getElementsByClassName("mb90SliderPlaceHolder");
    var slideValue = 0;
    for(var i = 0; i < slides.length; i++)
    {
//        'input[type=hidden]'
       //alert("id = [" + slides[i].id + "]");
       slideValue = jQuery("#" + slides[i].id).next('input[type=hidden]').val(); //init slider with the hidden input value
       var slideID = slides[i].id;
       var idIndex = slides[i].id.split("_")[1];
       //var slider = document.getElementById('slider');
       noUiSlider.create(slides[i], {
        animate: true,
	animationDuration: 1000,
	start: slideValue,
        step: 1,
        tooltips: true,
	connect: [true, false],
            range: {
                    'min': 0,
                    'max': 100
            }
        }).on('change', function( values, handle, unencoded ){
            jQuery("#exerciseInputSliderDisplay_" + slides[i].id.split('_')[1]).text(values[handle]);
        });
    
        
    }*/
    
    /*var slides2 = document.getElementsByClassName("mb90Slider");
    for(var i = 0; i < slides2.length; i++)
    {
        var slidertemp = slides2[i];
        slidertemp.noUiSlider.on('change', function( values, handle ){
            //jQuery("#exerciseInputSliderDisplay_" + slides2[i].id.split('_')[1]).text(values[handle]);    
            alert(i);
        });
    }*/
});

jQuery(window).on('load', function() {
   jQuery("#mb90-load-cover").hide();
});

