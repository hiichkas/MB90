jQuery(document).ready(function($) {

   // qTip
	 $('.dt-tooltip').each(function() {
	 
		var qtipTitle = $(this).attr('data-tooltip-title');
		var qtipText = $(this).attr('data-tooltip-text');
		var qtipStyle = $(this).attr('data-tooltip-style');
		var qtipArrow = $(this).attr('data-tooltip-arrow');
		var qtipPos = $(this).attr('data-tooltip-pos');
	 
		$(this).qtip({
				content: {
				title: qtipTitle,
				text: qtipText
			},
			position: {
				my: qtipArrow,  
				at: qtipPos,
				adjust: {
					x: 10
				}
			},
			style: {
				classes: qtipStyle
			}
		});
	});

  // Zebra classes on Pricing Table
	
	$('div.dt-pricing').each(function() {
		$(this).find('li:odd').addClass('even');
	});
	
	// Progress Bar

  $('.dt-progressbar').eq(0).addClass('pb_trigger');
  
  $('.pb_trigger').waypoint(function(direction) {
	
		$( '.dt-progressbar .bar' ).each(function(pbw) {
		pbw = $( this ).attr('data-bar-width');
		$( this ).animate({
			width: 	pbw
			}, 1500, function() {
			// Animation complete.
		});
		$( this).find('.dtpb-label').delay(500).animate({
			opacity: "1",
			left: "-=50"
			}, 1500, function() {
       // Animation complete.
		}).end();
		$( this).find('.dtpb-progress').delay(500).animate({
			opacity: "1",
			}, 1500, function() {
			// Animation complete.
		});
	});

	}, {
		offset: "100%",
		triggerOnce: true
	});
	
  // Tabs
  $( '.dt-tabgroup' ).tabs();
	
	
	//Accordian

	 var icons = {
     header: "iconClosed",    // custom icon class
     activeHeader: "iconOpen" // custom icon class
   };

	$( ".dt-accordian" ).accordion({ heightStyle: "content", collapsible: true, icons: icons });

	// Toggles
	$('.dt-toggle h3.dt-trigger').click(function() {
		$(this).next().slideToggle('fast');
		return false;
  }).next().hide();

  // Close Alerts
	$( ".close-alert" ).click(function() {
		$( this ).parent().fadeTo( "fast", 0.00, function(){ //fade
			$( this ).slideUp( "normal", function() { //slide up
				$( this ).remove(); //then remove from the DOM
			});
		});
	});
	
});

