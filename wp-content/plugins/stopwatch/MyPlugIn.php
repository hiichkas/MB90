<?php
/*
Plugin Name: Stopwatch
Plugin URI: www.ipadstopwatch.com
Description: Adds a stopwatch to your site. Works on PC and mobile deivces. It continues running after user leaves the site.
Version: 1.0.2
Author: Luis Perez
Author URI: www.ipadstopwatch.com
*/
 
 
class iPadStopwatchWidget extends WP_Widget {
  function iPadStopwatchWidget() {
    $widget_ops = array('classname' => 'iPadStopwatchWidget', 'description' => 'Adds a stopwatch to your site. Works on PC and mobile deivces. It continues running after user leaves the site.' );
    $this->WP_Widget('iPadStopwatchWidget', 'Stopwatch.', $widget_ops);
  }
 
  function form($instance) {
    $instance = wp_parse_args((array) $instance, array( 'title' => '' ));
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance) {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
 ?>
<script>
(function($) {
	$(function() {
		$(".oIPadStopwatch").each(function() {
			var width = $(this).width();
			var height = (width * 180) / 391;
			$(this).height(height);
		});
	});
})(jQuery);
</script>
 
<iframe class="oIPadStopwatch" src="http://ipadstopwatch.com/wordpress-plugin.html" frameborder="0" scrolling="no" style="width:100%;height:140px;"></iframe>
<?php
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("iPadStopwatchWidget");') );?>