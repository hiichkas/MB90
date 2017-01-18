var mepr_load_mailchimp_lists_dropdown = function (id, apikey, wpnonce) {
  (function($) {
    if( apikey == '' ) { return; }

    var list_id = $(id).data('listid');

    var args = {
      action: 'mepr_mailchimp_get_lists',
      apikey: apikey,
      wpnonce: wpnonce
    };

    $.post( ajaxurl, args, function(res) {
      if( res.total > 0 ) {
        var options = '';
        var selected = '';

        $.each( res.data, function( index, list ) {
          selected = ( ( list_id == list.id ) ? ' selected' : '' );
          options += '<option value="' + list.id + '"' + selected + '>' + list.name + '</option>';
        });

        $(id).html(options);
      }
    }, 'json' );
  })(jQuery);
};
