<?php

// website details
define('MB90_DOMAIN_NAME', 'mybody90.com');

define('MB90_ADMIN_USERID', 1);

// workout pages details
define('MB90_SELF_ASSESSMENT_PAGE_SLUG', 'self-assessment');
define('MB90_SELF_ASSESSMENT_PAGE_WELCOME', 'Welcome to your self assessment ');
define('MB90_SELF_ASSESSMENT_PAGE_WELCOME_HTML', 'h1');
define('MB90_SELF_ASSESSMENT_GRAPH_ACCORDION_CAPTION', 'View your self assessment progress');

define('MB90_10_DAY_CHALLENGE_PAGE_SLUG', '10-day-challenge');
define('MB90_10_DAY_CHALLENGE_PAGE_WELCOME', 'Welcome to your 10 day challenge ');
define('MB90_10_DAY_CHALLENGE_PAGE_WELCOME_HTML', 'h1');

define('MB90_CURRENT_EXERCISE_CAPTION', 'Current Exercise');
define('MB90_NEXT_EXERCISE_CAPTION', 'Next Exercise');

define('MB90_WORKOUT_DAY_PAGE_SLUG', 'your-exercise-details');
define('MB90_WORKOUT_DAY_PAGE_WELCOME', 'Welcome to your workout ');
define('MB90_WORKOUT_DAY_PAGE_WELCOME_HTML', 'h1');

define('MB90_BODY_STATS_PAGE_SLUG', 'your-body-stats');

define('MB90_USER_DATA_IS_AVAILABLE', true); // used to tell if form data is available on workout pages
define('MB90_USER_DATA_NOT_AVAILABLE', false); // used to tell if form data is available on workout pages
//
//define('MB90_WORKOUT_DAY_PAGE_WELCOME', 'Welcome to your workout ');
//define('MB90_WORKOUT_DAY_PAGE_WELCOME_HTML', 'h1');

//define('90_DAY_COURSE_FINISHED', 'Your 90 day course has now been completed.');
define('COURSE_FINISHED', 'Your course has now been completed');
define('USER_PROFILE_INCOMPLETE', 'Please complete your user profile details before continuing');


// captions
define('BMI_BMR_STATS_CAPTION', 'Your BMI / BMR and Energy Stats');
define('BMI_BMR_ENERGY_PROGRESS_CAPTION', 'Your BMI / BMR and Energy Progression');

define('BMI_PROGRESS_CAPTION', 'BMI Progress');
define('BMR_PROGRESS_CAPTION', 'BMR Progress');
define('TDEE_PROGRESS_CAPTION', 'TDEE Progress');

define('WEIGHT_PROGRESS_CAPTION', 'Your Weight Progress (Kilograms)');

define('PROFILE_DETAILS_CAPTION', 'Your Profile Details');

define('EX_TIMER_START_CAPTION', 'Start');
define('EX_TIMER_STOP_CAPTION', 'Stop');
define('EX_TIMER_RESET_CAPTION', 'Reset');
define('EX_TIMER_ROUND_NUMBER_CAPTION', 'Round #');

// error handling

define('MSG_FILL_PROFILE', 'Please fill out your profile details before continuing');

define('FILL_ALL_FORM_FIELDS', 'Please fill in all highlighted fields');

define('FILL_ALL_PREVIOUS_FORMS', "Please fill out your results for all previous dates first");

define('MESSAGE_SLIDE_DELAY', 3000);

define('MB90_NUM_DAYS', 90);
define('MB90_NUM_PHASES', 9);
define('MB90_NUM_SELF_ASSESSMENTS', 4);
define('MB90_NUM_DAYS_BETWEEN_SELF_ASSESSMENTS', 30);
define('MB90_NUM_DAYS_BETWEEN_10_DAY_CHALLENGES', 10);
define('MB90_SELF_ASSESSMENT_DAY_NUMBER', 1); // the day of each phase that self assessment falls on
define('MB90_DOUBLEROUND_WORKOUT', 9); // the day the double round workout is assigned

define('MB90_USER_CHALLENGE_REST', 5);
define('MB90_USER_CHALLENGE_EXTIME', 10);
define('MB90_USER_CHALLENGE_NUMROUNDS', 1);
define('MB90_USER_CHALLENGE_ROUNDREST', 1);

define('MB90_SELF_ASSESSMENT_REST', 5);
define('MB90_SELF_ASSESSMENT_EXTIME', 10);
define('MB90_SELF_ASSESSMENT_NUMROUNDS', 1);
define('MB90_SELF_ASSESSMENT_ROUNDREST', 1);

define('MB90_EXERCISE_VIEW_TIMINGS_CAPTION', 'Click here to view exercise timings');
define('MB90_EXERCISE_HIDE_TIMINGS_CAPTION', 'Click here to hide exercise timings');
define('MB90_EXERCISE_VIEW_TIMINGS_STATIC_CAPTION', 'The following are your exercise timings');


// chart options
define('MB90_WEIGHTGRAPH_DATANUM_FORBARCHART', 5);
define('MB90_CHARTS_PER_ROW', 3);

/* Membership Subscription IDs */
if( strpos("localhost", $_SERVER["SERVER_NAME"]) !== false){
    define('MB90_90_DAY_COURSE_ID', 1470);
}else{
    define('MB90_90_DAY_COURSE_ID', 1416);
}


/* memberpress captions */
define('MB90_90_DAY_COMPLETE_PURCHASE_REMINDER', 'Please complete your 90 day course purchase.');

// file path options
define('MB90_90_EX_MENU_INC_FOLDER_PATH', '/wp-content/plugins/exercise-menu/inc/');
define('MB90_90_USER_DATA_INC_FOLDER_PATH', '/wp-content/plugins/mb90-user-data/inc/');
define('MB90_90_EX_SCHEDULE_FOLDER_PATH', '/exercise-schedule/');
define('MB90_90_EX_MENU_FOLDER', 'exercise-menu/');
define('MB90_90_USER_DATA_FOLDER', 'mb90-user-data/');
define('MB90_90_PLUGIN_FOLDER_PATH', '/wp-content/plugins/');

define('MB90_90_EX_MENU_PLUGIN_URL', get_site_url() . MB90_90_PLUGIN_FOLDER_PATH . MB90_90_EX_MENU_FOLDER);
define('MB90_90_USER_DATA_PLUGIN_URL', get_site_url() . MB90_90_PLUGIN_FOLDER_PATH . MB90_90_USER_DATA_FOLDER);


// css colours and classes

define('MB90_NAVY_GREY', 'rgb(52, 73, 94)');
define('MB90_ORANGE', 'rgb(227, 58, 12)');
define('MB90_SKYBLUE', 'rgb(63, 175, 212)');
define('MB90_WHITE', 'rgb(0, 0, 0)');

define('MB90_LIGHT_GREEN', '#8cc63f');

//define('MB90_SCHEDULE_PAST_CSS', 'mb90-schedule-day-number-circle-past');
//define('MB90_SCHEDULE_FUTURE_CSS', 'mb90-schedule-day-number-circle');
define('MB90_HALF_OPACITY_CSS', 'mb90-half-opacity');


define('MB90_EX_GRAPH_FILL_COLOR', '#23b7e5');
define('MB90_EX_GRAPH_POINT_COLOR', '#337ab7');
define('MB90_EX_GRAPH_STROKE_COLOR', '#337ab7');
define('MB90_EX_GRAPH_HIGHLIGHT_STROKE_COLOR', '#337ab7');
define('MB90_EX_GRAPH_HIGHLIGHT_FILL_COLOR', '#337ab7');

define('MB90_EX_GRAPH_GRID_LINE_COLOR', 'rgb(52, 73, 94)');
define('MB90_EX_GRAPH_SCALE_FONT_COLOR', 'rgb(52, 73, 94)');

// input sliders
define('MB90_INPUT_SLIDER_MIN', 0);
define('MB90_INPUT_SLIDER_MAX', 100);
define('MB90_INPUT_SLIDER_TOOLTIPS', "false");
define('MB90_INPUT_SLIDER_DEFAULT_STARTVALUE', 0);
define('MB90_INPUT_SLIDER_BORDER_STYLE', "1px solid rgba(51, 51, 51, 0.45)");
define('MB90_INPUT_SLIDER_BORDER_STYLE_ERROR', "1px solid red");
define('MB90_INPUT_SLIDER_CIRCLE_CLASS', "mb90-slider-circle-wrapper");
define('MB90_INPUT_SLIDER_BAR_CLASS', "mb90-sliderbar-wrapper");

/* buttons */
define('MB90_INPUT_SLIDER_SAVE_BUTTON_CAPTION', "Save Details");

// exercise scroller
define('MB90_EX_SCROLLER_ITEM_WIDTH', "400px");


/* debugging and dev work */
define('MB90_DEBUG', "true");

?>