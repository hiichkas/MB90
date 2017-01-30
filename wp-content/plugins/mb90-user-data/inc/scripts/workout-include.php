<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script type="text/javascript">
    jQuery( document ).ready(function() {
        jQuery("#exTimings").on('click', function(){
            alert("clicked");
            if( jQuery("#exercise-summaryinfo-wrapper").css("display") == "none"){
                jQuery("#exTimgingsCaption").html("<?php echo MB90_EXERCISE_HIDE_TIMINGS_CAPTION; ?>");
                jQuery("#exercise-summaryinfo-wrapper").slideDown(1000);
                alert("here1");
            }else{
                jQuery("#exTimgingsCaption").html("<?php echo MB90_EXERCISE_VIEW_TIMINGS_CAPTION; ?>");
                jQuery("#exercise-summaryinfo-wrapper").slideUp(1000);            
                alert("here2");
            }
        });

        jQuery(".outer-timer-wrapper").show();
    }
    
</script>