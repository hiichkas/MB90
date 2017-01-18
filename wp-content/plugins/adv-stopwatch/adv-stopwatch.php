<?php
/**
 * Plugin Name: Adv Stopwatch
 * Plugin URI: http://www.findhold.dk/adv-stopwatch-a-wordpress-stopwatch-plugin/
 * Description: Creates a page with a stopwatch similar to the one at http://www.findhold.dk/stopur/
 * Version: 1.0
 * Author: Bryan Carraghan
 * Author URI: http://bryancarraghan.com
 * License: GPL2
 */

// Runs when the plugin is activated

function activate() {
  // Create page that will hold the stopwatch
  $page = array(
    'post_title' => 'Stopwatch',
    'post_content' => '[stopwatch]',
    'post_status' => 'publish',
    'post_type' => 'page'
  );

  $post_id = wp_insert_post($page);

  add_option('stwtch_post_id', $post_id);
}
register_activation_hook( __FILE__, 'activate' );

// Runs when the plugin is deactivated

function deactivate() {
  wp_delete_post(get_option('stwtch_post_id'), TRUE);
  delete_option('stwtch_post_id');
}

register_deactivation_hook( __FILE__, 'deactivate' );

function display_stopwatch($atts) {
  if ($overridden_template = locate_template('adv-stopwatch.php')) {
    require_once($overridden_template);
  } else {
    require_once(dirname(__FILE__) . '/templates/adv-stopwatch.php');
  }
}
add_shortcode('stopwatch', 'display_stopwatch');

// Add CSS and JS files

function check_for_shortcode($posts) {
  if ( empty($posts) )
    return $posts;

  // false because we have to search through the posts first
  $found = false;

  // search through each post
  foreach ($posts as $post) {

    // check the post content for the short code
    if ( strpos($post->post_content, '[stopwatch') !== false )
      // we have found a post with the short code
      $found = true;
    // stop the search
    break;
  }

  if ($found){
    // $url contains the path to your plugin folder
    $url = plugin_dir_url( __FILE__ );
    wp_enqueue_style('adv-stopwatch', plugins_url('/css/adv-stopwatch.css', __FILE__));
    // Load jQuery if WordPress does not already have it loaded
    wp_enqueue_script('jquery-moment',  plugins_url('/js/moment.min.js',__FILE__), array('jquery'), '2.5.0', true);
    wp_enqueue_script('jquery-timer', plugins_url('/js/jquery.timer.js',__FILE__), array('jquery'), '1.0.0', true);
    wp_enqueue_script('jquery-dateFormat', plugins_url('/js/jquery-dateFormat.min.js',__FILE__), array('jquery'), '1.0.0', true);
    wp_enqueue_script('adv-stopwatch', plugins_url('/js/adv-stopwatch.js',__FILE__), array('jquery', 'jquery-dateFormat', 'jquery-timer', 'jquery-moment'), '1.0.0', true);

  }
  return $posts;
}
// perform the check when the_posts() function is called
add_action('the_posts', 'check_for_shortcode');