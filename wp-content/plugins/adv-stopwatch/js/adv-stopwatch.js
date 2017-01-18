/**
 * Plugin Name: Advanced Stopwatch
 * Plugin URI:
 * Description: Creates a page with a stopwatch similar to the one at: http://www.timeanddate.com/stopwatch/
 * Version: 1.0
 * Author: Bryan Carraghan
 * Author URI: http://bryancarraghan.com
 * License: GPL2
 */

jQuery(document).ready(function( $ ) {
//  var count = 0;
//  var timer = $.timer(function() {
//    $('#timer').html(++count);
//  });
//  timer.set({ time : 100, autostart : true });


  var theTimer = new (function() {
    var rowId = 0;
    var before = new Date();
    var startElap = new Date();
    var lastTime = 0;
    // Stopwatch element on the page
    var stopwatch;
    var lapTimer;

    var justReset = false;

    // Timer speed in milliseconds
    var incrementTime = 70;

    // Current timer position in milliseconds
    var currentTime = 0;
    var currentLapTime = 0;

    var originalTime = 0;

    if($("#show-lap-time").prop('checked') == false){
      $('#adv-stopwatch .lap').hide();
    }

    if($("#show-lap-list").prop('checked') == false){
      $('#adv-stopwatch #lap-timer').hide();
      $('#adv-stopwatch table').hide();
    }

    // Start the timer
    $(function() {
      // Create a cookie
      //$.cookie('timer_cookie', '', { expires: 30 });

      var started = false;
      stopwatch = $('#timer');
      lapTimer = $('#lap-timer');

      // Hide stop button
      $('#stop').hide();
      $('#stop').width($('#start').width());

      // Reset timer
      $('#reset').click(function() {
        justReset = true;
        currentTime = 0;
        before = new Date();
        lastTime = 0;
        rowId = 0;
        theTimer.Timer.pause();
        updateTimer();
        $('.time-row').fadeOut('slow', function() {
          $(this).remove();
        });
        $('#stop').fadeOut(0, function() {
          $('#start').fadeIn(0);
        });
      });

      // Split timer
      $('#split').click(function() {
        if(theTimer.Timer.isActive) {
          currentLapTime = 0;
          if(lastTime == 0) {
            var lapTime = currentTime;
            lastTime = currentTime;
          } else {
            var lapTime = currentTime - lastTime;
            lastTime = currentTime;
          }
          lastTime = currentTime;
          addRow('Split', formatTime(lapTime), formatTime(currentTime));
        }
      });

      // Play timer
      $("#start").click(function() {
        currentLapTime = 0;
        startElap = new Date();
        originalTime = currentTime;
        before = new Date();
        if(started == false) {
          started = true;
          theTimer.Timer = $.timer(updateTimer, incrementTime, true);
        } else {
          theTimer.Timer.play();
        }
        addRow('Start', '- - - - - - - - -', '- - - - - - - - -');
        $(this).fadeOut(0, function() {
          $('#stop').fadeIn(0);
        });
      });

      // Pause timer
      $('#stop').click(function() {
        theTimer.Timer.pause();
        if(lastTime == 0) {
          var lapTime = currentTime;
          lastTime = currentTime;
        } else {
          var lapTime = currentTime - lastTime;
          lastTime = currentTime;
        }
        lastTime = currentTime;

        // update the cookie
        //var savedTimes = new Array("hello", "world");

//        if($.cookie('timer_cookie') == '') {
//          var enterTime = currentTime;
//        } else {
//          var enterTime = ','+currentTime;
//        }

        //$.cookie('timer_cookie', $.cookie('timer_cookie') + enterTime, { expires: 30 });
        addRow('Stop', formatTime(lapTime), formatTime(currentTime));
//        var savedArray = $.cookie('timer_cookie').split(',');
//        alert(savedArray[0]);

        $(this).fadeOut(0, function() {
          $('#start').fadeIn(0);
        });
      });

      // Toggle

      $('#show-lap-time').click(function() {
        $('#adv-stopwatch .lap').fadeToggle('slow');
        $('#adv-stopwatch #lap-timer').fadeToggle('slow');
      });

      $('#show-lap-list').click(function() {
        $('#adv-stopwatch table').fadeToggle('slow');
      });


      // Delete button
      // .click does not work on dynamically created elements for some reason.
      $("#adv-stopwatch").on('click', '.delete-time', function() {
        $('.'+$(this).attr("class").split(' ')[1]).fadeOut('slow', function() {
          $(this).remove();
        });
      });

    });

    // Output time and increment
    function updateTimer() {
      if(justReset != true) {
        currentTime += incrementTime;
        currentLapTime += incrementTime;
      } else {
        justReset = false;
      }

      var now = new Date();

      // If someone switches tabs the timer will stop... Lets fix that
      var elapsedTime = (now.getTime() - before.getTime());
      if(elapsedTime > currentTime) {
        currentLapTime = (elapsedTime - currentTime) + currentLapTime;
        currentTime = elapsedTime;
      }
      var timeString = formatTime(currentTime);
      stopwatch.html(timeString);
      lapTimer.html(formatTime(currentLapTime));

    }

    function addRow(type, lap, total) {
      rowId++;
      var actual = '<span class="large-date">'+$.format.date(new Date(), "dd/MM-yyyy") + ' at </span>' + moment().format('HH:mm:ss:SS');
      if($('#adv-stopwatch .lap').is(':hidden')) {
        var hideLaps = true;
      } else {
        var hideLaps = false;
      }
      if($('#adv-stopwatch table').is(':visible')) {
        $('#adv-stopwatch table').append('<tr class="time-row time-row-'+rowId+'"><td class="row-num">' + rowId + '</td><td>' + type + '</td><td class="label-insert"><input type="text" id="stwtch'+rowId+'"></td><td class="lap">' + lap + '</td><td>' + total + '</td><td>' + actual + '</td><td><input type="button" class="delete-time time-row-' + rowId + '" value="Delete" /></td></tr>').hide().fadeIn('slow');
      } else {
        $('#adv-stopwatch table').append('<tr class="time-row time-row-'+rowId+'"><td class="row-num">' + rowId + '</td><td>' + type + '</td><td class="label-insert"><input type="text" id="stwtch'+rowId+'"></td><td class="lap">' + lap + '</td><td>' + total + '</td><td>' + actual + '</td><td><input type="button" class="delete-time time-row-' + rowId + '" value="Delete" /></td></tr>').hide();
      }

      if(hideLaps) {
        $('#adv-stopwatch .lap').hide();
      }
    }
  });


});
function pad(number, length) {
  number = ''+number;
  return number.substr(0, length);
}
function formatTime(time) {
  var milliseconds = pad((time % 1000), 2); time = Math.floor(time/1000);
  var seconds = (time % 60); time = Math.floor(time/60);
  var minutes = (time % 60); time = Math.floor(time/60);
  var hours = time;

  if (hours   < 10) {hours   = "0"+hours;}
  if (minutes < 10) {minutes = "0"+minutes;}
  if (seconds < 10) {seconds = "0"+seconds;}
  if (milliseconds < 10) {milliseconds = "0"+milliseconds;}

  return  pad(hours, 2) + ":" + pad(minutes, 2) + ":" + pad(seconds, 2) + "<span>." + pad(milliseconds, 2) + "</span>";
}