/*
   Tabata Timer - simple tabata timer
   Copyright (C) 2014 Pavle Jonoski

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software Foundation,
   Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301  USA
*/

(function($){
    var DEBUG = false;
  
    //$('[data-toggle="tooltip"]').tooltip()

    this.exlistingArr = $("#exlistinghidden").val().split("##,##"); // hidden var
    this.isFirstRest = true; // used to pervent the scroll from moving forward for the first countdown 
    /*
    this.exlistingHTML = "<div class='ex-scroller-center' id='ex-scroller-content'>";
    this.exlistingHTMLTemp = "";
    $.each(this.exlistingArr, function(index, value) { 
      indexInt = index*1;
      if( value.length > 0){
        exlistingHTMLTemp += '<div class="exerciseListItem ex-scroller-internal"><button class="btn mb90-nopointer">' + value + '</button></div>';
      }
    });
    this.exlistingHTML += this.exlistingHTMLTemp + "</div>"; // close the #ex-scroller-content div
    //exlistingHTML += "</div>"; // close the outer-timer-wrapper div
    $("#mb90-exercise-scroller").html(this.exlistingHTML);
    */
    //this.exScrollerIndex = 0; // used to store the widths of each exercise elemenet within the scroller
    //this.exScrollerWidthArray = [];
    
    /*$( "div.ex-scroller-internal" ).each(function(){
        //alert($(this).css("width"));
        exScrollerWidthArray.push($(this).actual("width"));
    });*/
    
    //this.scrollToNextExercise = function(){
    //function scrollToNextExercise(index, widthArray)
    function scrollToNextExercise()
    {
        $(".horizon-next").trigger('click');
    }

    function scrollToPreviousExercise()
    {
        $(".horizon-prev").trigger('click');
    }
    
    var numexercises = $("#numexercises").val();
    var exerciseCount = 0;
    var exNumber = 0; // used to display which exercise of each round
    var roundNumber = 0; // used to display which exercise of each round
    if(DEBUG){
        var console = {
            log: function(){
                var message = '';
                for(var i = 0; i < arguments.length; i++){
                    message += arguments[i] + ' ';
                }
                $('.console').html(
                    $('.console').html() + message + '\n');
            }
        };
    }else{
        var console = window.console || {log:function(){}};
    }

   var __scheduleTable = {};
   var __scheduleId = 0;
   var schedule = function(callback, table, scope, error){
      var i = 0;
      var id = __scheduleId++;
      __scheduleTable[id] = true;
      var tick = function(){
         if(!__scheduleTable[id]){
            return;
         }
         if(i < table.length){
            try{
               callback.call(scope || window, table[i], i);
               setTimeout(tick, table[i]);
               i++;
            }catch(e){
               error = error || function(){};
               if(error){
                  error(e, table[i], i);
               }
            }
         }
      };
      tick();
   };
   
   var clearSchedule = function(){
      __scheduleTable = {};
   };
   
   var convertMillis = function(ms){
      return {
         minutes: Math.floor(ms/60000),
         seconds: Math.floor(ms/1000)%60,
         millis: ms%1000
      };
   };
   
   var pad = function (n){
      return n > 9 ? n+'':'0'+n;
   };
   
   var TBTimer = function(config){
      var self = this;
      this.resolution = config.resolution || 10;
      config.specs = config.specs || {};
      this.specs = {
         rounds: config.specs.rounds || 8,
         rest: config.specs.rest || 10,
         work: config.specs.work || 20
      };
      
      var current = {};
      
      this.displayEl = $('.timer-display')[0];
      
      config.sounds = config.sounds || {};
      var sounds = {};
      var toLoad = 0;
      var loadingSounds = false;
      this.loadSounds = function(){
          if(loadingSounds){
              return;
          }
          loadingSounds = true;
          for(var sndName in config.sounds){
             if(config.sounds.hasOwnProperty(sndName)){
                var sound = new Audio(config.sounds[sndName]);
                
                sound.addEventListener('error', function failed(e) {
                // audio playback failed - show a message saying why
                // to get the source of the audio element use $(this).src
                switch (e.target.error.code) {
                 case e.target.error.MEDIA_ERR_ABORTED:
                   console.log('You aborted the video playback.');
                   break;
                 case e.target.error.MEDIA_ERR_NETWORK:
                   console.log('A network error caused the audio download to fail.');
                   break;
                 case e.target.error.MEDIA_ERR_DECODE:
                   console.log('The audio playback was aborted due to a corruption problem or because the video used features your browser did not support.');
                   break;
                 case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
                   console.log('The video audio not be loaded, either because the server or network failed or because the format is not supported.');
                   break;
                 default:
                   console.log('An unknown error occurred.');
                   break;
                }
                }, true);
                
                toLoad++;
                sound.addEventListener("canplay", function(){
                   toLoad--;
                   console.log('Some sound loaded.',  ' - ', toLoad);
                   if(toLoad == 0){
                      self.soundsLoaded();
                   }
                }, false);
                sounds[sndName] = sound;
                sound.load();
                console.log('Load sound: ', sndName, ' - ', toLoad);
                
                sound.addEventListener('playing', function(){
                    console.log('Sound', sndName, 'is playing');
                }, true);
                
             }
          }
      };
      
      $(document).click(function(){
          self.loadSounds();
      });
      
      this.sounds = {
         soundsAvailable: false,
         tracks: sounds,
         play: function(name){
            console.log('Trying to play sound', name);
            if(this.soundsAvailable && this.tracks[name]){
               console.log('Calling play() on sound', name);
               this.tracks[name].play();
               console.log(' -> track:', this.tracks[name]);
               console.log(' -> shoud start playing any minute now...');
            }else{
               console.log('Cannot play sound ', name,'. soundsAvailable=', this.soundsAvailable,'; this.tracks[name]=', this.tracks[name]);
            }
         }
      };
      
      
      this.soundsLoaded = function(){
         console.log('Sounds available');
         this.sounds.soundsAvailable = true;
      };
      
      this.getValues = function(){
         var rounds = $('.input-rounds').val();
         var rest = $('.input-rest').val();
         var work = $('.input-work').val();
         var experround = $('.input-experround').val();
         var restperround  = $('.input-restperround').val();
         
         $('.input-rounds').removeClass('state-error-mark');
         $('.input-rest').removeClass('state-error-mark');
         $('.input-work').removeClass('state-error-mark');
         $('.input-experround').removeClass('state-error-mark');
         $('.input-restperround').removeClass('state-error-mark');
         
         var correct = true;
         
         try{
            experround = parseInt(experround);
         }catch(e){
            $('.input-experround').addClass('delaystate-error-mark');
            correct =  false;
         }
         if(isNaN(experround) || experround <= 0){
            $('.input-experround').addClass('state-error-mark');
            correct =  false;
         }
         
         try{
            restperround = parseInt(restperround);
         }catch(e){
            $('.input-restperround').addClass('delaystate-error-mark');
            correct =  false;
         }
         if(isNaN(restperround) || restperround <= 0){
            $('.input-restperround').addClass('state-error-mark');
            correct =  false;
         }
         
         try{
            rounds = parseInt(rounds);
         }catch(e){
            $('.input-rounds').addClass('delaystate-error-mark');
            correct =  false;
         }
         if(isNaN(rounds) || rounds <= 0){
            $('.input-rounds').addClass('state-error-mark');
            correct =  false;
         }
         
         try{
            rest = parseFloat(rest);
         }catch(e){
            $('.input-rest').addClass('state-error-mark');
            correct =  false;
         }
         
         if( isNaN(rest) || rest <= 0){
            $('.input-rest').addClass('state-error-mark');
            correct =  false;
         }  
         
         try{
            work = parseFloat(work);
         }catch(e){
            $('.input-work').addClass('state-error-mark');
            correct =  false;
         }
         
         if( isNaN(work) || work<= 0){
            $('.input-work').addClass('state-error-mark');
            correct =  false;
         }  
         
         if(!correct){
            this.notify('Incorrect!');
            return false;
         }
         
         this.specs = {
            rounds: rounds,
            rest: rest,
            work: work,
            experround: experround,
            restperround: restperround
         };
         return this.specs;
      };
      
      this.mainprogresswidth = 0;
      this.mainprogressincrements = $("#tabata-fulltime-progressbar").width() / $("#totalworkouttime").val();
      this.totalworkouttime = $("#totalworkouttime").val();
      this.totalworkouttimeseconds = $("#totalworkouttime").val() * 1000;
      
      this.start = function(){
        /*$("#currentExercise > button").html(exlistingArr[0]);
        $("#nextExercise > button").html(exlistingArr[1]);
        $("#thirdExercise > button").html(exlistingArr[2]);*/
        $("#start-button").html($("#stop-button-html").html());
        exerciseCount = 0;
        roundNumber = 0;
        exNumber = 0;
        
         if(this.running){
             return;
         }
         this.loadSounds(); // if we haven't already 
         clearSchedule();
         var s = this.getValues();
         if(s){
            var rs = [];
            var schedules = [];
            for(var i = 0; i < s.rounds; i++){
                if( i !== 0 && i % s.experround === 0){ // end of round so push the round rest time
                    rs.push({
                       total: s.restperround * 1000,
                       round: i+1,
                       type: 'rest'
                    });
                    schedules.push(s.restperround*1000);
                }
                else{
                    rs.push({
                       total: s.rest * 1000,
                       round: i+1,
                       type: 'rest'
                    });
                    schedules.push(s.rest*1000);
                }
               
               rs.push({
                  total: s.work * 1000,
                  round: i+1,
                  type: 'work'
               });
               schedules.push(s.work*1000);
            }

            schedules.push(500);
            this.rounds = rs;
            //alert(rs.join('\n'))
            console.log('start');
            this.running = true;
            schedule(function(delay, rn){
               this._doRound(rn);
            }, schedules, this);
            
            $('.timer-start').val('Stop');
            return {s:schedules, r:rs};
         }
      };
      this.stop  = function(){
        /*$("#currentExercise > button").html(exlistingArr[0]);
        $("#nextExercise > button").html(exlistingArr[1]);
        $("#thirdExercise > button").html(exlistingArr[2]);*/
        $("#start-button").html($("#start-button-html").html());
        exerciseCount = 0;
        roundNumber = 0;
        exNumber = 0;
        
         this.running = false;
         $('.timer-start').val('Start');
         this.notifyForRound('&dash;', 'rest');
         this.notifyForExercise('&dash;');

         if(current.timerId){
            clearInterval(current.timerId);
            current.alreadyWarned = false;
            current.round.end = new Date().getTime();
         }
         this.rounds = [];
         this.updateDisplay(0);
         
      };
      this.notify = function(message){
         if( message == "Stopped!"){
             // reset all bars
             $("#total-progress-timer").progressTimer({timeLimit: 0});
             $("#rest-progress-timer").progressTimer({timeLimit: 0});
             $("#exercise-progress-timer").progressTimer({timeLimit: 0});
         }
         $('.global-notification').html(message);
         $('.overlay-container').fadeIn('slow', function(){
            $('.overlay-container').delay(1000).fadeOut('slow');
         });
      };
      this.updateDisplay = function(ms){
         var tm = convertMillis(ms);
         this.displayEl.innerHTML = 
            pad(tm.minutes) + ':' + 
            pad(tm.seconds) + ':' +
            pad(Math.floor(tm.millis/10));
            
            //mainprogresswidth = $("#tabata-fulltime-progressbarinner").width();
            //alert(this.mainprogresswidth);
            //alert(this.mainprogressincrements);
            
            //this.mainprogresswidth = this.mainprogresswidth + this.mainprogressincrements;
            //$("#tabata-fulltime-progressbarinner").css("width", this.mainprogresswidth);
      };
      
      this._doRound = function(rn){
         if(!this.running){
            return;
         }
         // stop current if running ....
         if(current.timerId){
            clearInterval(current.timerId);
            current.alreadyWarned = false;
            current.round.end = new Date().getTime();
         }
         this.updateDisplay(0);
         var self =this;
         if(this.rounds[rn]){
            var __tick = function(){
               if(!self.running){
                  return;
               }
               var currentTime = new Date().getTime();
               var elapsedTime = currentTime - self.rounds[rn].start;
               var dtm = self.rounds[rn].total - elapsedTime;
               //alert( "dtm, self.rounds[rn].total, elapsedTime = [" + dtm + "," + self.rounds[rn].total + "," + elapsedTime + "]");
               if(dtm > 0){
                  self.updateDisplay(dtm);
                  if(dtm <= 5000 && 
                        self.rounds[rn].total >= 5000 && 
                           !current.alreadyWarned){
                     self.sounds.play('warning');
                     current.alreadyWarned = true;
                  }
               }else{
                  self.updateDisplay(0);
                  if(current.timerId){
                     clearInterval(current.timerId);
                     current.alreadyWarned = false;
                     current.round.end = new Date().getTime();
                  }
               }
            }
            current.round = this.rounds[rn];
            current.round.start = new Date().getTime();
            current.timerId = setInterval(__tick, this.resolution);
            //var roundNumber = Math.floor(rn/2) + 1;

            //var exNumber = Math.floor(rn/2) + 1;
            //this.notifyForRound(roundNumber, current.round.type);
            //alert(roundNumber);
//            if( roundNumber == numexercises)
//                this.notifyForRound(roundNumber, current.round.type);
//            else{
/*                roundNumber ++;
                if( roundNumber == 0 )
                    this.notifyForRound(1, current.round.type);
                else
                    this.notifyForRound(Math.floor(roundNumber / numexercises)+1, current.round.type);
                    */
//            }
            
            if(current.round.type === 'rest'){
                if( $('.exercise-number').html() === "-" ){
                    tl = $("#tabata-exrest").val();
                }
                else
                {
                    //tl = 30; // 30 second countdown
                    tl = $("#tabata-exrest").val();
                }
            //$("#exercise-progress-timer").progressTimer({timeLimit: 0});
            $("#rest-progress-timer").progressTimer({
                    onFinish: function () {
                    },  //invoked once the timer expires
                    //completeStyle: 'progress-bar-reset',
                    timeLimit: tl,
                    showPercentage: true,
                    showHtmlSpan: true
            });
                
               //$('#rest-progress').asProgress('reset');
               //$('#rest-progress').asProgress('start');
               
               //$('#rest-progress').progressbar('reset');
               //$('#rest-progress').progressBar('start');
            
               this.notify('Rest!');
               //alert("is first rest = [" + isFirstRest + "]");
               if( isFirstRest === true ){
                   isFirstRest = false;
               }else{
                   scrollToNextExercise();
               }

               if(rn != 0){
                  this.sounds.play('end-round');
               }else{
                this.notify('Get Ready to Start!');      
               }
            }else{
                   //exScrollerIndex = scrollToNextExercise(exScrollerIndex, exScrollerWidthArray); 

                   /*$("#currentExercise > button").html(exlistingArr[exerciseCount]);
                    if( exerciseCount == numexercises-1){
                        exerciseCount = 0;
                    }else{
                        exerciseCount ++;
                    }
                    $("#nextExercise > button").html(exlistingArr[exerciseCount]);
                    if( exerciseCount == numexercises-1){
                        exerciseCount = 0;
                    }else{
                        exerciseCount ++;
                    }
                    $("#thirdExercise > button").html(exlistingArr[exerciseCount]);
                */

            exNumber ++;
            this.notifyForExercise(exNumber);
            //alert("1"+numexercises);
            //alert("2"+exNumber);
/*            if( roundNumber == 0){
                roundNumber ++;
                this.notifyForRound(roundNumber, current.round.type);
            }*/
            
                if( exNumber == 1){
                    roundNumber ++;
                    this.notifyForRound(roundNumber, current.round.type);
                }

                if( exNumber == numexercises){
                    exNumber = 0;
                }

               this.notify('Work!');
               this.sounds.play('start');
            }
         }else{
            this.notify('Well Done!!');
            this.sounds.play('end');
            this.stop();
         }
      };
      
      this.notifyForRound = function(rn, type){
          //alert("notify - type = [" + type + "]");
          
         $('.round-number').html(rn);
         //$('.round-type').html(type=='rest' ? 'REST':'WORK');
         //rountType = $('.round-type').html();
         
         if( type == "rest"){
            $('.round-type').html("REST");
            //$("#exercise-progress-timer").progressTimer({timeLimit: 0});
            $("#rest-progress-timer").progressTimer({
                    onFinish: function () {
                    },  //invoked once the timer expires
                    timeLimit: $("#tabata-roundsrest").val(),
                    showPercentage: true,
                    showHtmlSpan: true
            });
         }else{
            $('.round-type').html("WORK");
            //$('#round-progress').asProgress('reset');
            //$('#round-progress').asProgress('start');
            
            //$('#round-progress').progressbar('reset');
            //$('#round-progress').progressbar('start');
         }
      };
      
      this.notifyForExercise = function(exnum){
         $('.exercise-number').html(exnum);
            //$("#rest-progress-timer").progressTimer({timeLimit: 0});
            $("#exercise-progress-timer").progressTimer({
                    onFinish: function () {

                    },  //invoked once the timer expires
                    //completeStyle: 'progress-bar-reset',
                    timeLimit: $("#tabata-work").val(),
                    showPercentage: true,
                    showHtmlSpan: true
            });
      };

/*
    var progressbar = $( "#progressbar" ),
      progressLabel = $( ".progress-label" );
 
    progressbar.progressbar({
      value: false,
      change: function() {
        progressLabel.text( progressbar.progressbar( "value" ) + "%" );
      },
      complete: function() {
        progressLabel.text( "Complete!" );
      }
    });
 
    function progress() {
      var val = progressbar.progressbar( "value" ) || 0;
 
      progressbar.progressbar( "value", val + 2 );
 
      if ( val < 99 ) {
        setTimeout( progress, 80 );
      }
    }*/


      var self = this;
      $('body').on('click', 'i.timer-start', function() {
      //$('.timer-start').on('click', function(){
          
          //$('#total-progress').asProgress('start');
          //$('#total-progress').progressbar('reset');
          //$('#total-progress').progressbar('start');
          
        // process total time timer - START
        /*if (cFlag == undefined) {
            clearTimeout(timer);
            perc = 0;
            cFlag = true;
            animateUpdate();
        }
        else if (!cFlag) {
            cFlag = true;
            animateUpdate();
        }
        else {
            clearTimeout(timer);
            cFlag = false;
        }*/
          
          //progress();
        //setTimeout( progress, 2000 );

        $("#total-progress-timer").progressTimer({
                timeLimit: $("#totalworkouttime").val() / 1000,
                showPercentage: true,
                showHtmlSpan: true
        });
        
        // process total time timer - END
        
         if(!self.running){
            self.start();
         }else{
            self.stop();
            self.notify('Stopped!');
         }
      });
      
      $(document).keypress(function(e){
         switch(e.which){
            case 32: // space
            case 115: // s
            case 13: // return
            // these are toggle
               if(!self.running){
                  self.start();
               }else{
                  self.stop();
                  self.notify('Stopped!');
               }
               break;
            case 112: // p
               self.stop();
               self.notify('Stopped!');
               break;
            case 114: // r
               self.start();
               break;
         }
      });
      
      
   };
   
   
   
   $(document).ready(function(){
      //incPath = "http://www.mybody90.com/wp-content/plugins/exercise-menu/inc/";
      //incPath = "http://localhost:8080/MB90/wp-content/plugins/exercise-menu/inc/";
      
        //if( strpos("localhost", $_SERVER["SERVER_NAME"]) !== false){
        if( window.location.hostname.indexOf("localhost") !== -1){
            incPath = "http://localhost:8080/MB90/wp-content/plugins/exercise-menu/inc/";
        }else{
            incPath = "http://mybody90.com/wp-content/plugins/exercise-menu/inc/";
        }
      
      /*$("#currentExercise > button").html(exlistingArr[0]);
      $("#nextExercise > button").html(exlistingArr[1]);
      $("#thirdExercise > button").html(exlistingArr[2]);*/
      //exerciseCount ++;
      
      tm = new TBTimer({
         sounds: {
            'start':incPath + 'js/timer/audio/start.wav',
            'end':incPath + 'js/timer/audio/end.wav',
            'end-round':incPath + 'js/timer/audio/end-round.wav',
            'warning':incPath + 'js/timer/audio/warning.wav'
         }
      });
      $('.credits-popup-show').click(function(){
         $('.credits-popup').show();
      });
      
      $('.credits-popup-close').click(function(){
         $('.credits-popup').hide();
      });
      
   });
   
})(jQuery);
