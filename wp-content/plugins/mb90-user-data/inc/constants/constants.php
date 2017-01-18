<?php

// website details
define('MB90_DOMAIN_NAME', 'mybody90.com');

// workout pages details
define('MB90_SELF_ASSESSMENT_PAGE_SLUG', 'self-assessment');
define('MB90_SELF_ASSESSMENT_PAGE_WELCOME', 'Welcome to your self assessment ');
define('MB90_SELF_ASSESSMENT_PAGE_WELCOME_HTML', 'h1');

define('MB90_10_DAY_CHALLENGE_PAGE_SLUG', '10-day-challenge');
define('MB90_10_DAY_CHALLENGE_PAGE_WELCOME', 'Welcome to your 10 day challenge ');
define('MB90_10_DAY_CHALLENGE_PAGE_WELCOME_HTML', 'h1');

define('MB90_WORKOUT_DAY_PAGE_SLUG', 'your-exercise-details');
define('MB90_WORKOUT_DAY_PAGE_WELCOME', 'Welcome to your workout ');
define('MB90_WORKOUT_DAY_PAGE_WELCOME_HTML', 'h1');

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


// error handling

define('MSG_FILL_PROFILE', 'Please fill out your profile details before continuing');

define('FILL_ALL_FORM_FIELDS', 'Please fill in all highlighted fields');

define('MESSAGE_SLIDE_DELAY', 3000);

define('MB90_NUM_PHASES', 9);

define('MB90_USER_CHALLENGE_REST', 5);
define('MB90_USER_CHALLENGE_EXTIME', 10);
define('MB90_USER_CHALLENGE_NUMROUNDS', 1);
define('MB90_USER_CHALLENGE_ROUNDREST', 1);

define('MB90_SELF_ASSESSMENT_REST', 5);
define('MB90_SELF_ASSESSMENT_EXTIME', 10);
define('MB90_SELF_ASSESSMENT_NUMROUNDS', 1);
define('MB90_SELF_ASSESSMENT_ROUNDREST', 1);

define('MB90_WEIGHTGRAPH_DATANUM_FORBARCHART', 5);

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

/* debugging and dev work */
define('MB90_90_DEBUG', true);

?>