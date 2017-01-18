jQuery(document).ready(function(){
    
  jQuery(function() {
    //jQuery( "#accordion" ).accordion();
    jQuery("#accordion").accordion({ header: "h3", collapsible: true, active: false, heightStyle: "content"  });
  });
  
  
  /*
    on page load ... run ajax call to get data from mb90_user_diet_translated view
    
    call with {"DayNum":DayNum, "UserID":UserID}
    Use UserID as a Session Var in the web service if possible
    
    return json with {"idlist": "<comma delim list of meal IDs>", "mealhtml":""}
    populate the #selectedIDs hidden var with the returned IDs and populate the html liks
    jQuery( "#diet-selection-table").append(outer_html);

    when user clicks save

    run ajax call to save/update and send json with
    {"idlist":"#selectedIDs","UserID":"","DayNum",""}

    Run "if exists the update else insert" where UserID=UserID etc


   */
  
    var rootDir = "";
    if( window.location.host.indexOf("localhost") !== -1)
      rootDir = "/MB90";

    var daynum = jQuery("#daynum").val();
    jQuery.ajax({
        type: 'POST',
        url: rootDir + '/wp-content/plugins/exercise-menu/inc/scripts/DietWebService.php',
        data: {'daynum': daynum},
        success: function(resultJSON) {
            //alert(resultJSON.html);
            //alert(resultJSON.idlist);
            //console.log(msg);
            jQuery( "#diet-selection-table").append(resultJSON.html);
            jQuery( "#selectedIDs").val(resultJSON.idlist);
          
            var ccNew = 0;
            jQuery( ".diet-selected-item").each(function(){
                ccNew += jQuery(this).attr("calories") * 1;
            });
            
            //alert(ccNew);
            
            var selectedCalories = 0;
            var remainingCalories = jQuery(".diet-calories-remaining").html()*1;
            jQuery(".diet-calories-remaining").html(remainingCalories - ccNew);
            jQuery("#dietSelectedCalories").val(selectedCalories + ccNew);
            jQuery( ".diet-calories").html(jQuery( "#dietSelectedCalories").val());                


            if( jQuery( "#selectedIDs").val().length > 0){
                jQuery( "#diet-selection-message").hide();
            }
        }
    });
  
  
  
  
  var dietDailyCalories = jQuery("#dietDailyCalories").val(); // set the allowed diet calories from the hidden var
  jQuery(".diet-calories-perday").html(dietDailyCalories);
  jQuery(".diet-calories-remaining").html(dietDailyCalories);
  
    //set heights 
  
  //var divHeight = jQuery(".diet-selector-wrapper").innerHeight();
  //jQuery(".diet-calories-wrapper").height(divHeight-38);   
            
  
  // ---------------
  // ADD DIET ITEM
  // ---------------
  
  jQuery( ".diet-selector-item").click(function() {
      jQuery( "#diet-selection-message").hide();
      
    id = jQuery(this).attr("id");
    idArr = jQuery("#selectedIDs").val().split(',');
    
    var idExists = jQuery.inArray( id, idArr )
    //alert(idExists);
    var remainingCalories = jQuery(".diet-calories-remaining").html()*1;
    //alert(remainingCalories);
    if( idExists == -1 ) // item not already selected
    {
        var cc = jQuery(this).attr("calories") * 1;        
        remainingCalories = remainingCalories - cc;
        
        if( remainingCalories <= 0 )
        {
            alert("You have gone over your daily allowed limit of calories");
        }
        else
        {

            var selectedCalories = jQuery( "#dietSelectedCalories").val()*1;

            jQuery(".diet-calories-remaining").html(remainingCalories);
            jQuery("#dietSelectedCalories").val(selectedCalories + cc);
            jQuery( ".diet-calories").html(jQuery( "#dietSelectedCalories").val());

            jQuery("#selectedIDs").val(function(i, v) { // add the selected item to the hidden array field selectedIDs
                var arr = v.split(',');
                arr.push(id);
                return arr.join(',');
            });

            //alert( jQuery("#selectedIDs").val());

            selectedHTML = jQuery(this).html()
            outer_html = jQuery(this).clone().wrap('<p>').parent().html();
            //alert("html = " + outer_html);
            outer_html = outer_html.replace('class="diet-selector-item', 'class="diet-selected-item');
            outer_html = outer_html.replace('<p>', '<p><div class="diet-selected-item-caption">');
            //outer_html = outer_html.replace('</p>', '</div><div class="diet-selected-item-delete">&#x274c;</div><div class="mb90-tooltip">Delete Item</div></p>');
            outer_html = outer_html.replace('</p>', '</div><div class="diet-selected-item-delete">DELETE</div></p>');
            //outer_html = outer_html.replace('class="emoji"', 'class="emoji" title="Delete"');
            //outer_html += '<input type="button" value="remove" class="diet-selector-item-delete" />'
            //&#x274c;
            //alert("html2 = " + outer_html);
            jQuery( "#diet-selection-table").append(outer_html);
            //jQuery(".diet-selected-item-delete img").attr("title", "Delete Item");

            /*jQuery('.diet-selected-item-delete').children('img').each(function(){
                jQuery(this).attr('title', 'Delete');
                alert(jQuery(this).attr('src'));
            })*/

            //alert("here");
        }
    }
    else
    {
        alert("Already Selected");
    }

  });
  
  //jQuery( ".diet-selected-item-delete").on('click', 'img', function() {
   
  // ------------------
  // DELETE DIET ITEM
  // ------------------
  
    jQuery( "body").on('click', '.diet-selected-item-delete', function() {
        //alert("ya");
        //var selectedParent = jQuery(this).closest('div[class^="diet-selected-item"]');
        var removedID = jQuery(this).closest('div[class="diet-selected-item"]').attr("id");
        var removedCalories = jQuery(this).closest('div[class="diet-selected-item"]').attr("calories")*1;
        var selectedCalories = jQuery( "#dietSelectedCalories").val()*1;
        
        var remainingCalories = jQuery(".diet-calories-remaining").html()*1;
        jQuery(".diet-calories-remaining").html(remainingCalories + removedCalories);

        jQuery("#dietSelectedCalories").val(selectedCalories - removedCalories);
        jQuery( ".diet-calories").html(jQuery( "#dietSelectedCalories").val());
      
        jQuery("#selectedIDs").val(function(i, v) {
            return jQuery.grep(v.split(','), function(value) {  
                return value != removedID;  
            }).join(',');
        })
        if( jQuery("#selectedIDs").val() == ''){
            jQuery( "#diet-selection-message").show();
        }
        //alert( jQuery("#selectedIDs").val());
      
        jQuery(this).closest('div[class="diet-selected-item"]').remove();
  });
  
  jQuery( "#dietDayDD").dblclick(function() {
      
  });
  
  jQuery( "#diet-save-button").on('click', function(){
      var errorMsg = validateForm();
      if( errorMsg !== ''){ // error occurred
          alert(errorMsg);
      }else{
          //make ajax call to save diet details
          //alert("Form Ok");
        var selectedIDList = jQuery( "#selectedIDs").val();
        jQuery.ajax({
            type: 'POST',
            url: rootDir + '/wp-content/plugins/exercise-menu/inc/scripts/DietSaveWebService.php',
            data: {'daynum': daynum, "selectedIDList": selectedIDList},
            success: function(result) {
                alert(result);
                window.open(rootDir + '/your-diet-listing','_self');
            }
        });
      }
  });
  
  jQuery( "#diet-cancel-button").on('click', function(){
        window.open(rootDir + '/your-diet-listing','_self');
  });
  
  function validateForm(){
      if( jQuery("#dietDayDD").val() == ''){
          return "Please select a day";
      }
      if( jQuery("#selectedIDs").val() == ''){
          return "Please select some meals";          
      }
      return "";
  }
  
});