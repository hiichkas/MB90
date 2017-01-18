function formatcellImage(val,row){
    //var url = "customerView.php?id=";
    return '<img src="' + val + '" style="height:20px;width:auto;"/>';
}

/*
var origImagePath = "";
function processMMTypes(mmObj)
{
    origImagePath = mmObj.ExerciseMMPath;
    //alert(mmObj.ExerciseMMType);
    if( mmObj.ExerciseMMType == "Image"){
        $('#videorow').hide();
        //$("#ExerciseMMPathCurrImage").html(mmObj.ExerciseMMPath)
        $("#ExerciseMMPathCurrImage").val(mmObj.ExerciseMMPath);
        $('#imagerow').show();
        $('#imagerow2').show();
    }else{
        $('#imagerow').hide();
        $('#imagerow2').hide();
        //alert("here111");
        //$('input:hidden[name=ExerciseMMPathVideo]').val("test");
        $('#videorow').show();
    }
}

function processMMType(type)
{
    //alert(mmObj.ExerciseMMType);
    if( type !== "")
    {
        if( type == "Image"){
            $('#videorow').hide();
            //$("#ExerciseMMPathCurrImage").html(mmObj.ExerciseMMPath)
            $("#ExerciseMMPathCurrImage").val(mmObj.ExerciseMMPath);
            $('#imagerow').show();
            $('#imagerow2').show();
        }else{
            $('#imagerow').hide();
            $('#imagerow2').hide();
            //alert("here111");
            //$('input:hidden[name=ExerciseMMPathVideo]').val("test");
            $('#videorow').show();
        }
    }else{
            $('#imagerow').hide();
            $('#imagerow2').hide();
            //alert("here111");
            //$('input:hidden[name=ExerciseMMPathVideo]').val("test");
            $('#videorow').hide();
    }
}
*/

$( document ).ready(function() {
    
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "username", 3, 16 );
      valid = valid && checkLength( email, "email", 6, 80 );
      valid = valid && checkLength( password, "password", 5, 16 );
 
      valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
      valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
      valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
 
      if ( valid ) {
        $( "#users tbody" ).append( "<tr>" +
          "<td>" + name.val() + "</td>" +
          "<td>" + email.val() + "</td>" +
          "<td>" + password.val() + "</td>" +
        "</tr>" );
        dialog.dialog( "close" );
      }
      return valid;
    }
    
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Create an account": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
    
    $( "#upload-image" ).on( "click", function() {
      dialog.dialog( "open" );
      //alert("upload");
    });
 });