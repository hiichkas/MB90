(function() {
	tinymce.PluginManager.add('dtsc_tinymce_button', function( editor, url ) {
	  editor.addButton( 'dtsc_tinymce_button', {
      title: 'DT Shortcodes',
      type: 'menubutton',
      icon: 'icon dt-shortcodes',
			menu: [
				{
      		text : 'DT Quote',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=quote', width : 400, height : 460 });
					}
     		},
				{
      		text : 'DT Alert',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=alert', width : 400, height : 540 });
					}
     		},
     		{
      		text : 'DT Button',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=button', width : 400, height : 400 });
					}
     		},
     		{
      		text : 'DT Icon',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=icon', width : 400, height : 375 });
					}
     		},
     		{
      		text : 'DT Highlight',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=highlight', width : 400, height : 375 });
					}
     		},
     		{
      		text : 'DT Tooltip',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=tooltip', width : 400, height : 400 });
					}
     		},
     		{
      		text : 'DT Toggle',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=toggle', width : 400, height : 450 });
					}
     		},
     		{
      		text : 'DT Accordian',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=accordian', width : 400, height : 400 });
					}
     		},
     		{
      		text : 'DT Tabs',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=tabs', width : 400, height : 400 });
					}
     		},
     		{
      		text : 'DT Progress Bar',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=progressbar', width : 400, height : 400 });
					}
     		},
     		{
      		text : 'DT Pricing Table',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=pricing', width : 400, height : 400 });
					}
     		},
     		{
      		text : 'DT Columns',
					onclick : function() {
				    editor.windowManager.open( { file : url + '/dt_popup.php?id=columns', width : 400, height : 400 });
					}
     		},
      ]
    });
	});
})();