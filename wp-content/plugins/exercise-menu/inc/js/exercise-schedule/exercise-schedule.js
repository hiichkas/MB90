jQuery(document).ready(function(){

    var rootDir = "";
    if( window.location.host.indexOf("localhost") !== -1 || window.location.host.indexOf("127.0.0.1") !== -1)
        rootDir = "/MB90";
  
	var sourceSwap = function () {
	    var jQuerythis = jQuery(this);
	    var newSource = jQuerythis.data('alt-src');
	    jQuerythis.data('alt-src', jQuerythis.attr('src'));
	    jQuerythis.attr('src', newSource);
	}
        
        //jQuery(".exDayScheduleLink").on('click', {exDay: jQuery(this).data("exday"), exDayType: jQuery(this).data("exdaytype")}, function(event){
        jQuery(".exDayScheduleLink").on('click', function(){
            var exDaySelected = jQuery(this).data("exday");
            var exDayTypeSelected = jQuery(this).data("exdaytype");

            // now assign the form with POST values and submit the form
            jQuery("#exDay").val(exDaySelected);
            jQuery("#exDayType").val(exDayTypeSelected);
            jQuery('#exScheduleForm').submit();
            //alert(jQuery(this).data("exday"));

        });

	jQuery(function() {
	    jQuery('img[data-alt-src]').each(function() { 
	        new Image().src = jQuery(this).data('alt-src'); 
	    }).hover(sourceSwap, sourceSwap); 
	});
	
	jQuery('#exScheduleForm').submit(function (event)
	{
	    var action = '';
            var exDayType = jQuery("#exDayType").val();
            if(exDayType === "self-assessment")
            {
                action = rootDir + "/self-assessment";
            }
            else if(exDayType === "10-day-challenge")
            {
                action = rootDir + "/10-day-challenge";                
            }
            else
            {
                action = rootDir + "/your-exercise-details";
            }
	    jQuery(this).attr('action', action);
	});

});