
<?php if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');} ?>

<?php

    // mb90 stuff

    $pluginURL = plugins_url("mb90-user-data/");
    $pluginPath = ABSPATH . 'wp-content/plugins/mb90-user-data/';
    
    //require_once($pluginPath . 'inc/scripts/constants.php');
    require_once($pluginPath . 'inc/scripts/dbase_include.php');
    require_once($pluginPath . 'inc/Classes/DataGridClass.php');
    
    $incPath = $pluginPath . "inc/";
    $incURL = $pluginURL . "inc/";
    
    global $wpLoggedInUserID;
    $wpLoggedInUserID = get_current_user_id();
    $_SESSION["LoggedUserID"] = $wpLoggedInUserID;
    
    $userDetailsObj = new userDetails();
    $userDetailsArr = $userDetailsObj->getUserDetails($wpLoggedInUserID);
    
    $_SESSION["UserName"] = $userDetailsArr['username'];
    $_SESSION["UserProgrammeID"] = 1;
    $_SESSION["UserStartDate"] = $userDetailsArr['userstartdate'];
    
    $userDetailsExist = (count($userDetailsArr) > 0 ? true : false);
    
    if( $userDetailsExist ){
        $userRecordID = $userDetailsArr["userrecordid"];
        $userStartDate = $userDetailsArr["userstartdate"];
        $sexDropDownHTML = $userDetailsObj->getSexDropDownHTML($userDetailsArr["usersex"]);
        $activityLevelDropDownHTML = $userDetailsObj->getActivityLevelDropDownHTML($userDetailsArr["useractivitylevel"]);
        $weightInputHTML = $userDetailsObj->getWeightInputHTML($userStartDate, $wpLoggedInUserID);
        $height = $userDetailsArr["userheight"];
        $age = $userDetailsArr["userage"];
        $sex = $userDetailsArr["usersex"];
        $activityFactor = $userDetailsArr["useractivitylevel"];
        //$weightGraph = $userDetailsObj->getWeightGraph($wpLoggedInUserID);
    }else{
        $userRecordID = 0;
        $userStartDate = 0;
        $sexDropDownHTML = $userDetailsObj->getSexDropDownHTML(false);
        $activityLevelDropDownHTML = $userDetailsObj->getActivityLevelDropDownHTML(false);
        $weightInputHTML = USER_PROFILE_INCOMPLETE;
        $height = 0;
        $age = "";
        $sex = "";
        $activityFactor = 0;
    }
    
    $bmi = $userDetailsArr['userBMI'];
    $bmr = $userDetailsArr['userBMR'];
    $tdee = $userDetailsArr['userTDEE'];
    
    $_SESSION["mb90UserName"] = $userDetailsArr['username'];
    $_SESSION["mb90UserProgrammeID"] = $userDetailsArr['userprogrammeid'];
    $_SESSION["mb90UserStartDate"] = $userDetailsArr['userstartdate'];
?>


  <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
  
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
  
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<link href="<?php echo $incURL?>css/memberpress/memberpress-responsive.css" rel="stylesheet">  

  

  


  
    <!-- bootstrap -->
    <!--<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">-->
    <!--<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> -->
    <!--<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>  -->
    
    <!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->

    <!-- x-editable (bootstrap version) -->
    <!--<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.6/bootstrap-editable/js/bootstrap-editable.min.js"></script>-->
  
  <script>
  //jQuery.fn.editable.defaults.mode = 'popup';
  
jQuery(document).ready(function() {
    
    var rootDir = "";
    if( window.location.host.indexOf("localhost") !== -1)
      rootDir = "/MB90";

    
    function validateProfileForm() {
        var formValid = true;
        var idArray = [];
        if (jQuery('#userstartdate').val() === "") {
            idArray.push('#userstartdate');
        }
        
        if (jQuery('#userweight').val() === "") {
            idArray.push('#userweight');
        }
        
        if (jQuery('#userheight').val() === "") {
            idArray.push('#userheight');
        }
        
        if (jQuery('#userage').val() === "") {
            idArray.push('#userage');
        }
        
        if (jQuery('#userdob').val() === "") {
            idArray.push('#userdob');
        }
        
        if (jQuery('#usersex').val() === "-1") {
            idArray.push('#usersex');
        }
        
        if (jQuery('#useractivitylevel').val() === "-1") {
            idArray.push('#useractivitylevel');
        }
        
        if (idArray.length > 0) {
            jQuery.each(idArray, function (index, value) {
                jQuery(value).addClass("invalid_input");
            });
            return false;
        }
        return true;
    }
    
    function validateWeightsForm() {
        var formValid = true;
        var idArray = [];
        jQuery('input[id^="weight_"]').each(function(){
            //alert("here");
            if (jQuery(this).val() === "") {    
                idArray.push(jQuery(this).attr("id"));    
                //alert(jQuery(this).attr("id"));
            }
        });
        
        if (idArray.length > 0) {
            jQuery.each(idArray, function (index, value) {
                jQuery("#" + value).addClass("invalid_input");
            });
            return false;
        }
        return true;
    }
    /*
    //toggle `popup` / `inline` mode
    jQuery.fn.editable.defaults.mode = 'inline';     
    
    //make username editable
    jQuery('#username').editable();
    
    //make status editable
    jQuery('#status').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'status 1'},
            {value: 2, text: 'status 2'},
            {value: 3, text: 'status 3'}
        ]*/
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
    //});
    
  jQuery('input[id^="user"]').change(function(){
     if(jQuery(this).val() !== "" ) 
         jQuery(this).removeClass("invalid_input");
     else
         jQuery(this).addClass("invalid_input");
  });
  
  jQuery('select[id^="user"]').change(function(){
     if(jQuery(this).val() !== "" ) 
         jQuery(this).removeClass("invalid_input");
     else
         jQuery(this).addClass("invalid_input");
  });
    
  jQuery( "#saveprofile").on('click', function(){
      var formOK = validateProfileForm();
      var profileValArray = ["userstartdate", "userweight", "userheight", "userage", "userdob", "usersex", "useractivitylevel"];
      var dataString = "";
      jQuery.each(profileValArray, function (index, value) {
          //dataString += "'" + value + "':" + jQuery('#' + value).val() + ",";
          dataString += value + "=" + jQuery('#' + value).val() + "&";
      });
      //dataString.slice(0,-1); //remove leading comma
      //dataString += "'userid':<?php echo $wpLoggedInUserID; ?>,";
      //dataString += "'userrecordid':<?php echo $userRecordID; ?>";
      
      dataString += "userid=<?php echo $wpLoggedInUserID; ?>&";
      //dataString += "userstartdate=<?php echo $userStartDate; ?>&";
      dataString += "userrecordid=<?php echo $userRecordID; ?>";

      

      //alert(dataString);
      if( formOK ){ // no error occurred
        jQuery("#mp-errormessage").slideUp();

        jQuery.ajax({
            type: 'POST',
            url: rootDir + '/wp-content/plugins/exercise-menu/inc/scripts/ProfileSaveWebService.php',
            data: dataString,
            success: function(result) {
                alert(result);
                location.reload(); // refresh page
            }
        });
      }else{
          jQuery("#mp-errormessage").html("<?php echo FILL_ALL_FORM_FIELDS; ?>");
          //jQuery("#mp_errormessage").slideDown();
          jQuery('#mp-errormessage').slideDown('slow').delay(<?php echo MESSAGE_SLIDE_DELAY; ?>).slideUp('slow');
      }
  });
  
  jQuery( "#saveweights").on('click', function(){
      var formOK = validateWeightsForm();
      var weightDataString = "";
      var weightInputCount = 0; // the number of weight input boxes available
        jQuery('input[id^=weight_]').each(function(){
          weightDataString += jQuery(this).prop("id") + "=" + jQuery(this).val() + "&";
          weightInputCount ++;
        });
      weightDataString += "userid=<?php echo $wpLoggedInUserID; ?>&";
      weightDataString += "userstartdate=<?php echo $userStartDate; ?>&";
      weightDataString += "weightinputcount=" + weightInputCount;
      
      //alert(weightDataString);
      //weightDataString = weightDataString.slice(0,-1); //remove leading &
      if( formOK ){ // no error occurred
          //alert(weightDataString);

        jQuery.ajax({
            type: 'POST',
            url: rootDir + '/wp-content/plugins/exercise-menu/inc/scripts/WeightSaveWebService.php',
            data: weightDataString,
            success: function(result) {
                alert(result);
                location.reload(); // refresh page
            }
        });
      }else{
          jQuery("#mp-errormessage-weights").html("<?php echo FILL_ALL_FORM_FIELDS; ?>");
          jQuery('#mp-errormessage-weights').slideDown('slow').delay(<?php echo MESSAGE_SLIDE_DELAY; ?>).slideUp('slow');
      }
  });
  
});

  jQuery(function() {
    jQuery( "#tabs" ).tabs();
  });
  </script>
  
<div class="mp_wrapper">
  <div id="mepr-account-welcome-message"><?php echo MeprHooks::apply_filters('mepr-account-welcome-message', do_shortcode($welcome_message), $mepr_current_user); ?></div>

  <?php if( !empty($mepr_current_user->user_message) ): ?>
    <div id="mepr-account-user-message">
      <?php echo MeprHooks::apply_filters('mepr-user-message', wpautop(do_shortcode($mepr_current_user->user_message)), $mepr_current_user); ?>
    </div>
  <?php endif; ?>

  <?php 
    MeprView::render('/shared/errors', get_defined_vars()); 
    $msg = "";
    if( $_REQUEST["filluserdetails"] == "Y" ){
        $msg = '<tr><td colspan="2"><div class="mp_error">' . MSG_FILL_PROFILE . '</div></td></tr>';
    }
  ?>
  
<!-- start of jquery ui tabs --> 
<div id="tabs">  
  
  <ul>
    <li><a href="#ProfileTab">Your Profile</a></li>
    <!--<li><a href="#BodyStatsTab">Your Body Stats</a></li>-->
    <li><a href="#AccountTab">Account Details</a></li>
  </ul>

  
<div id="ProfileTab"><!-- start of Profile tab -->
<!-- start of mb90 profile section -->
<div class="uk-grid">
<div class="uk-width-medium-2-4">
<div class="uk-panel uk-panel-box uk-panel-box-secondary ">

        <table class="profile-fields">
                                    
                                    <tr><td colspan="2"><div class="mp_tablecaption" id="bd-profile-details"><?php echo PROFILE_DETAILS_CAPTION; ?></div></td></tr>
                                    <?php echo $msg; ?>
                                    <tr><td colspan="2"><div id="mp-errormessage"></div></td></tr>

                                    <?php // roha: 16Mar2015 - display mb90 user details
                                        
                                        //$detailsArr = array("username", "useremail", "userstartdate", "userweight", "userage", "userdob");
                                        //$captionArr = array("User Name", "Email", "Start Date", "Weight", "Age", "D.O.B.");
                                        
                                        $detailsArr = array("userstartdate", "userweight", "userheight", "userage", "userdob", "usersex", "useractivitylevel");
                                        $captionArr = array("Start Date", "Start Weight (Kg)", "Height (cm)", "Age", "D.O.B.", "Sex", "Activity Level");

                                        $dataTypeArr = array("text", "email", "date", "text", "text", "date", "select");
                                        //$readOnlyArr = array(true, true, true, false, false, false, "Fee Paid" );
                                        //$detailsArr = {"username"};
                                        $detCount = 0;
                                        foreach($detailsArr as $detail){
                                            ?>
                                            <tr>

                                                <td class="label"><div class="mp_tablesubcaption"><?=$captionArr[$detCount] ?></div></td>

                                                    <td class="data">
                                                        <?php 
                                                        if ($detailsArr[$detCount] == "userdob" || $detailsArr[$detCount] == "userstartdate"){
                                                            $dateRange = "";
                                                            if( $detailsArr[$detCount] == "userstartdate" ){
                                                                $dateRange = ',minDate: 0, maxDate: "+7D"';
                                                            }
                                                            
                                                            $dateToShow = date("d/m/Y", strtotime($userDetailsArr[$detailsArr[$detCount]]));
                                                            
                                                            if( $userDetailsExist ){
                                                                echo "<div class='mp_tablecontent'><input type='text' id='".$detailsArr[$detCount]."' value='".$dateToShow."' /></div>";
                                                            }else{
                                                                echo "<div class='mp_tablecontent'><input type='text' id='".$detailsArr[$detCount]."' value='' /></div>";
                                                            }
                                                        ?>
<script>
  jQuery(function() {
    jQuery( "#<?php echo $detailsArr[$detCount]; ?>" ).datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "<?php echo date("Y")-100 . ":" . date("Y");?>",
      dateFormat: "dd/mm/yy"
      <?php echo $dateRange; ?>
    });
    
  });
</script>
                                                        
                                                        <?php
                                                        }
                                                        elseif($detailsArr[$detCount] == "userstartdate"){
                                                            if( $userDetailsExist ){
                                                                $dateToShow = date("d/m/Y", strtotime($userDetailsArr[$detailsArr[$detCount]]));
                                                                echo "<div class='mp_tablecontent'><input type='text' id='".$detailsArr[$detCount]."' value='".$dateToShow."' /></div>";
                                                            }else{
                                                                echo "<div class='mp_tablecontent'><input type='text' id='".$detailsArr[$detCount]."' value='' /></div>";
                                                            }
                                                        }
                                                        elseif($detailsArr[$detCount] == "usersex"){
                                                            echo "<div class='mp_tablecontent'>" . $sexDropDownHTML . "</div>";
                                                        }
                                                        elseif($detailsArr[$detCount] == "useractivitylevel"){
                                                            echo "<div class='mp_tablecontent'>" . $activityLevelDropDownHTML . "</div>";
                                                        }
                                                        else{
                                                            if( $userDetailsExist ){
                                                                echo "<div class='mp_tablecontent'><input type='text' id='".$detailsArr[$detCount]."' value='".$userDetailsArr[$detailsArr[$detCount]]."' /></div>";
                                                            }else{
                                                                echo "<div class='mp_tablecontent'><input type='text' id='".$detailsArr[$detCount]."' value='' /></div>";
                                                            }
                                                        }
                                                        ?>
                                                    </td>

                                            </tr>
                                            <?php
                                            $detCount = $detCount + 1;
                                        }
                                   
                                     ?>
                                     
                                            <tr><td colspan="2"><div class='mp_tablecontent'><input type="button" id="saveprofile" value="Save Profile" /></div></td></tr>

                                            <!--<tr>
                                                <td><span>Username:</span></td>
                                                <td><a href="#" id="username" data-type="text" data-placement="right" data-title="Enter username">superuser</a></td>
                                            </tr>
                                            <tr>
                                                <td><span>Status:</span></td>
                                                <td><a href="#" id="status"></a></td>
                                            </tr>   -->   
        </table>


<!--<div class="uk-progress">
<div class="uk-progress-bar" style="width: 70%;">40%</div>
</div>
<div class="uk-panel uk-panel-box uk-panel-box-secondary ">
<h1 class=" align-centre">26</h1>
</div>-->
</div>
    
<div class="uk-panel uk-panel-box uk-panel-box-secondary ">
<div id="bd-profile-weight-stats"></div>
    <?php 
       echo $weightInputHTML; 
    ?>
</div>
    
</div>


<div class="uk-width-medium-2-4">
<div class="uk-panel uk-panel-box uk-panel-box-secondary ">
<div class="mp_tablecaption" id="bd-profile-bmi-stats"><?php echo BMI_BMR_STATS_CAPTION; ?></div>
<?php
    if( $userDetailsExist === false){
        echo USER_PROFILE_INCOMPLETE;
    }
    else{
        ?>
<div class="mp_tablesubcaption">BMR</div>
<div class="mp_tablecontent">For your age, height and weight your Resting Metabolic Rate or Basal Metabolic Rate requires <strong><?=$bmr?></strong> calories per day.</div>
<div class="mp_tablesubcaption">BMI</div>
<div class="mp_tablecontent">For your height and weight your Body Mass Index is <strong><?=$bmi?></strong></div>
<div class="mp_tablesubcaption">TDEE</div>
<div class="mp_tablecontent">For your age, height and weight your Total Daily Energy Expenditure requires <strong><?=$tdee?></strong> calories per day.</div>
    <?php
    }
    ?>


</div>
    
<div class="uk-panel uk-panel-box uk-panel-box-secondary ">
<div class="mp_tablecaption" id="bd-profile-bmi-energy-stats"><?php echo BMI_BMR_ENERGY_PROGRESS_CAPTION; ?></div>
<?php
    if( $userDetailsExist === false){
        echo USER_PROFILE_INCOMPLETE;
    }
    else{
        ?>

        <div class="mp_tablesubcaption white"><?php echo BMI_PROGRESS_CAPTION; ?></div>
        <div class="mp_tablecontent white-row"><canvas id="bmiGraphCanvas" ></canvas></div>
        <div class="mp_tablesubcaption"><?php echo BMR_PROGRESS_CAPTION; ?></div>
        <div class="mp_tablecontent white-row"><canvas id="bmrGraphCanvas" ></canvas></div>
        <div class="mp_tablesubcaption"><?php echo TDEE_PROGRESS_CAPTION; ?></div>
        <div class="mp_tablecontent white-row"><canvas id="tdeeGraphCanvas" ></canvas></div>
        
        <?php
    }
    ?>


</div>
    
</div>
    


</div>
<!-- end of mb90 profile section -->
</div> <!-- end of profile tab -->
  

<!-- start of Account tab -->
<div id="AccountTab">

  <form class="mepr-account-form mepr-form" id="mepr_account_form" action="" method="post" novalidate>
    <input type="hidden" name="mepr-process-account" value="Y" />
    <div class="mp-form-row mepr_first_name">
      <div class="mp-form-label">
        <label for="user_first_name"><?php _e('First Name:', 'memberpress'); echo ($mepr_options->require_fname_lname)?'*':''; ?></label>
        <span class="cc-error"><?php _e('First Name Required', 'memberpress'); ?></span>
      </div>
      <input type="text" name="user_first_name" id="user_first_name" class="mepr-form-input" value="<?php echo $mepr_current_user->first_name; ?>" <?php echo ($mepr_options->require_fname_lname)?'required':''; ?> />
    </div>
    <div class="mp-form-row mepr_last_name">
      <div class="mp-form-label">
        <label for="user_last_name"><?php _e('Last Name:', 'memberpress'); echo ($mepr_options->require_fname_lname)?'*':''; ?></label>
        <span class="cc-error"><?php _e('Last Name Required', 'memberpress'); ?></span>
      </div>
      <input type="text" id="user_last_name" name="user_last_name" class="mepr-form-input" value="<?php echo $mepr_current_user->last_name; ?>" <?php echo ($mepr_options->require_fname_lname)?'required':''; ?> />
    </div>
    <div class="mp-form-row mepr_email">
      <div class="mp-form-label">
        <label for="user_email"><?php _e('Email:*', 'memberpress');  ?></label>
        <span class="cc-error"><?php _e('Invalid Email', 'memberpress'); ?></span>
      </div>
      <input type="email" id="user_email" name="user_email" class="mepr-form-input" value="<?php echo $mepr_current_user->user_email; ?>" required />
    </div>
    <?php
      MeprUsersHelper::render_custom_fields();
      MeprHooks::do_action('mepr-account-home-fields', $mepr_current_user);
    ?>

    <div class="mepr_spacer">&nbsp;</div>

    <input type="submit" name="mepr-account-form" value="<?php _e('Save Profile', 'memberpress'); ?>" class="mepr-submit mepr-share-button" />
    <img src="<?php echo admin_url('images/loading.gif'); ?>" style="display: none;" class="mepr-loading-gif" />
    <?php MeprView::render('/shared/has_errors', get_defined_vars()); ?>
  </form>

  <div class="mepr_spacer">&nbsp;</div>

  <a href="<?php echo $account_url.$delim.'action=newpassword'; ?>"><?php _e('Change Password', 'memberpress'); ?></a>

  <?php MeprHooks::do_action('mepr_account_home', $mepr_current_user); ?>
  
</div> <!-- end of Account tab -->

<div id="BodyStatsTab">
    
<!-- files moved from user-data-memberpress.php START-->

<!-- files moved from user-data-memberpress.php END -->
    <?php
        $incPath = "inc/";
        global $recordType;
        $recordType = "UserBodyData";
        //include($pluginPath . $incPath . 'user-data-memberpress.php'); //switched off as causing issues with other graphs
    ?>
        
</div>
  
</div> <!-- end of tabs -->
       
</div>
<?php 

    $chartObj = new chartFunctions();
    $weightChartArray = $chartObj->getBarChartBodyStatValuesSpecific("Weight", $wpLoggedInUserID, $height, $age, $sex, $activityFactor);
    //echo "$wpLoggedInUserID, $height, $age, $sex, $activityFactor";
?>
<script>
    var weights = document.getElementById('weights').getContext('2d');
    
    var weightData = {
            labels : [<?php echo $weightChartArray[0]; ?>],
            datasets : [
                    {
                            fillColor : "rgba(227,58,12,0.4)",
                            strokeColor : "#e33a0c",
                            pointColor : "#fff",
                            pointStrokeColor : "e33a0c",
                            data : [<?php echo $weightChartArray[1]; ?>]
                    }
            ]
    }
    var chartOptions = { 
               scaleShowGridLines : true,     
               responsive : false, 
               pointDotRadius : 6,
               //scaleFontStyle: 10,
               tooltipFillColor: "rgba(15,162,230,0.8)",
               //scaleLabel: "<%= value%> Kg",
    } 

    if( weightData.datasets[0].data.length == 1) // if only 1 data record then use a bar chart else a line graph
        new Chart(weights).Bar(weightData, chartOptions);
    else
        new Chart(weights).Line(weightData, chartOptions);
    
    
    var bmiGraph = document.getElementById("bmiGraphCanvas").getContext("2d");
    var bmrGraph = document.getElementById("bmrGraphCanvas").getContext("2d");
    var tdeeGraph = document.getElementById("tdeeGraphCanvas").getContext("2d");
    
    var bmiBarData = {
            labels : [<?php echo $weightChartArray[0]; ?>],
            datasets : [
                    {
                            fillColor : "#0fa2e6",
                            strokeColor : "#fff",
                            data : [<?php echo $weightChartArray[2]; ?>]
                    }
            ]
    }
    
    var bmrBarData = {
            labels : [<?php echo $weightChartArray[0]; ?>],
            datasets : [
                    {
                            fillColor : "#e33a0c",
                            strokeColor : "#fff",
                            data : [<?php echo $weightChartArray[3]; ?>]
                    }
            ]
    }
    
    var tdeeBarData = {
            labels : [<?php echo $weightChartArray[0]; ?>],
            datasets : [
                    {
                            fillColor : "#48A497",
                            strokeColor : "#fff",
                            data : [<?php echo $weightChartArray[4]; ?>]
                    }
            ]
    }

    var bmiChartOptions = { 
               scaleShowGridLines : true,     
               responsive : false, 
               pointDotRadius : 6,
               //scaleFontStyle: 10,
               tooltipFillColor: "#e33a0c"
               //scaleLabel: "<%= value%> Kg",
    } 
    
    var bmrChartOptions = { 
               scaleShowGridLines : true,     
               responsive : false, 
               //scaleFontStyle: 10,
               tooltipFillColor: "#0fa2e6"
               //scaleLabel: "<%= value%> Kg",
    } 
    
    var tdeeChartOptions = { 
               scaleShowGridLines : true,     
               responsive : false, 
               //scaleFontStyle: 10,
               tooltipFillColor: "#000",
               tooltipFontColor: "#fff"
               //scaleLabel: "<%= value%> Kg",
    } 
    new Chart(bmiGraph).Bar(bmiBarData, bmiChartOptions);
    new Chart(bmrGraph).Bar(bmrBarData, bmrChartOptions);
    new Chart(tdeeGraph).Bar(tdeeBarData, tdeeChartOptions);
</script>