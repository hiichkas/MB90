var ShortcodeDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ShortcodeDialog.local_ed = ed;
		
		//Find the URL parameters
		$.urlParam = function(name){
		var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (results==null) {
				return null;
			} else {
				return results[1] || 0;
			}
		}
		
		// Set some variables with the URL parameters		
		popup = $.urlParam('id');
		pwidth = $.urlParam('tbwidth');
		
		// Adjust the Thickbox height
		parent.jQuery('#TB_window,#TB_iframeContent').width(pwidth); 
		parent.jQuery('#TB_window').css('margin-left',-(pwidth/2));	
		
		// Get the selected text and shove it in the #text
		var selected_text = ShortcodeDialog.local_ed.selection.getContent();
		jQuery('textarea#content').val(selected_text);			
		
		// Some appendo magic
		$('.child-row').appendo({
			allowDelete: false,
			labelAdd: 'Add Another'
		});
	},
	insert : function insertQuote(ed) {
		
		// Get the shortcodes from hidden divs
		var shortcode = jQuery('#dt-shortcode').text();
		var cshortcode = jQuery('#dt-cshortcode').text();
		var fshortcodes = '';
		
		// Get the selected options for the parent shortcode
		$('.option').each(function() {
		  var input = jQuery(this);
			var id = input.attr('id');
			shortcode = shortcode.replace('{{'+id+'}}', input.val());
		});
		
		// Get the selected options for the child shortcodes
		$('.child-row tr').each(function() {
			
			var rshortcode = cshortcode;
					
			$('.coption', this).each(function() {
				var input = jQuery(this);
				var id = input.attr('id');
				
				rx = new RegExp('{{'+id+'}}','g');
				
				rshortcode = rshortcode.replace(rx, input.val());
			});		
			
			fshortcodes = fshortcodes + rshortcode; 
		});
		
		// Insert the child shortcodes into the parent
		shortcode = shortcode.replace('{{child}}', fshortcodes);		

		// Insert into TinyMCE
		tinyMCEPopup.execCommand('mceInsertContent', false,  shortcode);
		
		tinyMCEPopup.close();

	}
};

tinyMCEPopup.onInit.add(ShortcodeDialog.init, ShortcodeDialog);
