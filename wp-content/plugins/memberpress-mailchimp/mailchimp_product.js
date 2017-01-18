jQuery(document).ready(function($) {
  //trial period
  if($('#meprmailchimp_list_override').is(":checked")) {
    mepr_load_mailchimp_lists_dropdown( '#meprmailchimp_list_override_id',
                                        $('#meprmailchimp_list_override').data('apikey'),
                                        MeprProducts.wpnonce );
    $('div#meprmailchimp_override_area').show();
  } else {
    $('div#meprmailchimp_override_area').hide();
  }
  $('#meprmailchimp_list_override').click(function() {
    if($('#meprmailchimp_list_override').is(":checked")) {
      mepr_load_mailchimp_lists_dropdown( '#meprmailchimp_list_override_id',
                                          $('#meprmailchimp_list_override').data('apikey'),
                                          MeprProducts.wpnonce );
    }
    $('div#meprmailchimp_override_area').slideToggle();
  });
}); //End main document.ready func
