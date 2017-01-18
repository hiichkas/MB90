jQuery(document).ready(function(){
    
    jQuery("#accordion").accordion({ header: "h3", collapsible: true, active: false, heightStyle: "content" });
    
    jQuery( ".diet-edit-button").on('click', function(){
        var dow = jQuery(this).attr('dow');
          if( window.location.host.indexOf("localhost") !== -1)
            window.open('../your-diet-builder?dow=' + dow,'_self');
          else
            window.open('../your-diet-builder?dow=' + dow,'_self');
      });
  
});