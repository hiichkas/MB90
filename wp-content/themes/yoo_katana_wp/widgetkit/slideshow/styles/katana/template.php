<?php
/**
* @package   Katana
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	$widget_id  = $widget->id.'-'.uniqid();

	$settings  = array_merge(array(
		'index' 		=> null,
		'buttons' 		=> null,
		'navigation' 	=> null
	), $widget->settings);

	$navigation = array();
	$captions   = array();

	$i = 0;
?>

<div id="slideshow-<?php echo $widget_id; ?>" class="wk-slideshow wk-slideshow-katana" data-widgetkit="slideshow" data-options='<?php echo json_encode($settings); ?>'>

	<div>
		<ul class="slides <?php if (isset($settings['background-fullscreen']) && $settings['background-fullscreen']) : ?>tm-slideshow-fullscreen<?php endif; ?>">

			<?php foreach ($widget->items as $key => $item) : ?>
			<?php
				$navigation[] = '<li><span></span></li>';
				$captions[]   = '<li>'.(isset($item['caption']) ? $item['caption']:"").'</li>';

				/* Lazy Loading */
				$item["content"] = ($i==$settings['index']) ? $item["content"] : $this['image']->prepareLazyload($item["content"]);
			?>
			<li>
				<article class="wk-content clearfix"><?php echo $item['content']; ?></article>
			</li>
			<?php $i=$i+1;?>
			<?php endforeach; ?>
		</ul>
		<div class="uk-container uk-container-center">
			<?php if (isset($settings['buttons']) && $settings['buttons']) : ?><div class="next uk-text-center"><i class="uk-icon-chevron-right"></i></div><div class="prev uk-text-center"><i class="uk-icon-chevron-left"></i></div><?php endif; ?>
			<div class="caption uk-width-medium-1-2"></div>
			<ul class="captions"><?php echo implode('', $captions);?></ul>
		</div>
	</div>

	<?php echo ($settings['navigation'] && count($navigation)) ? '<ul class="nav">'.implode('', $navigation).'</ul>' : '';?>

</div>