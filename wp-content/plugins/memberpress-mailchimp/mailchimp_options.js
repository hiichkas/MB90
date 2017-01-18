jQuery(document).ready(function($) {
  // Mailchimp API stuff
  var mepr_check_mailchimp_apikey = function( apikey, wpnonce ) {
    if(apikey == '') { return; }

    var args = {
      action: 'mepr_mailchimp_ping_apikey',
      apikey: apikey,
      wpnonce: wpnonce
    };

    $.post( ajaxurl, args, function(res) {
      if('error' in res) {
        $('#mepr-mailchimp-valid').hide();
        $('#mepr-mailchimp-invalid').html( res.error );
        $('#mepr-mailchimp-invalid').fadeIn();
        $('select#meprmailchimp_list_id').html('');
      }
      else {
        $('#mepr-mailchimp-invalid').hide();
        $('#mepr-mailchimp-valid').html( res.msg );
        $('#mepr-mailchimp-valid').fadeIn();
        mepr_load_mailchimp_lists_dropdown('select#meprmailchimp_list_id', apikey, wpnonce);
      }
    }, 'json' );
  }

  //MailChimp enabled/disable checkbox
  if($('#meprmailchimp_enabled').is(":checked")) {
    mepr_check_mailchimp_apikey( $('#meprmailchimp_api_key').val(), MeprMailChimp.wpnonce );
    $('div#mailchimp_hidden_area').show();
  } else {
    $('div#mailchimp_hidden_area').hide();
  }
  $('#meprmailchimp_enabled').click(function() {
    if($('#meprmailchimp_enabled').is(":checked")) {
      mepr_check_mailchimp_apikey( $('#meprmailchimp_api_key').val(), MeprMailChimp.wpnonce );
    }
    $('div#mailchimp_hidden_area').slideToggle('fast');
  });

  var action = ($('#meprmailchimp_optin').is(":checked")?'show':'hide');

  $('#meprmailchimp-optin-text')[action]();
  $('#meprmailchimp_optin').click(function() {
    $('#meprmailchimp-optin-text')['slideToggle']('fast');
  });

  // Mailchimp Actions
  if($('#meprmailchimp_enabled').is(':checked')) {
    mepr_check_mailchimp_apikey( $('#meprmailchimp_api_key').val(), MeprMailChimp.wpnonce );
  }

  $('#meprmailchimp_api_key').blur( function(e) {
    mepr_check_mailchimp_apikey( $(this).val(), MeprMailChimp.wpnonce );
  });
}); //End main document.ready func

