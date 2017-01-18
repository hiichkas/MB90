<?php

/** 
 * Quote
 */

if (!function_exists('dt_quote')) {
	function dt_quote( $atts, $content = null ) {
		$defaults = array( 
			'align' => 'center', 
			'style' => 'light'
		);
		extract(shortcode_atts($defaults, $atts, 'dt_quote'));  	
		
		return '<blockquote class="dt-quote ' . $align . ' ' . $style . '">"' . do_shortcode($content) . ' "</blockquote>';  
	}
	add_shortcode("dt_quote", "dt_quote"); 
}

/** 
 * Alerts
 */

if (!function_exists('dt_alert')) {
	function dt_alert( $atts, $content = null ) {
		$defaults = array( 
			'color' => 'red',
			'close' => 'yes',
			'border' => "false",
		);
		extract(shortcode_atts($defaults, $atts, 'dt_alert'));
		
		if ($close == 'yes') {
			$close_enabled = 'close-enabled';
		} else {
			$close_enabled = 'close-disabled';
		}
		
		if ($border == "true") {
			$has_border = 'border';
		} else {
			$has_border = 'no-border';
		}
		
		return '<div class="dt-alert ' . $color . ' ' . $close_enabled . ' ' . $has_border . '">' . do_shortcode($content) . '<a class="close-alert"><i class="fa fa-times"></i></a></div>';  
	}
	add_shortcode("dt_alert", "dt_alert"); 
}

/**
 * Buttons
 */

if (!function_exists('dt_button')) {
	function dt_button( $atts, $content = null ) {
		$defaults = array( 
	   	'url' => '#',
			'color' => 'grey',
			'size' => 'medium',
			'display' => 'inline',
			'icon' =>  null,
			'state' => null
		);
		extract(shortcode_atts($defaults, $atts, 'dt_button'));  
		
		if ($icon != null) {
			$icon_html = '<i class="fa ' . $icon . '"></i>';
		} else {
			$icon_html = null;
		}
		
		return '<a class="dt-button ' . $color . ' ' . $size . ' ' . $state . ' ' . $display .'" href="' . $url . '">' . $icon_html . do_shortcode($content) . '</a>';  
	}
	add_shortcode("dt_button", "dt_button"); 
}

/** 
 * Font Awesome Icons
 */

if (!function_exists('dt_icon')) {
	function dt_icon( $atts) {
		$defaults = array( 
	   	'type' => 'fa-adjust',
			'color' => 'inherit',
			'size' => 'inherit'
		);
		extract(shortcode_atts($defaults, $atts, 'dt_icon'));  
		
		return '<i class=" dt-icon fa ' . $type . '" style="color:' . $color . '; font-size:' . $size . '"></i>';  
	}
	add_shortcode("dt_icon", "dt_icon"); 
}

/** 
 * Text Highlight
 */

if (!function_exists('dt_highlight')) {
	function dt_highlight( $atts, $content = null ) {
		$defaults = array( 
			'color' => 'yellow', 
		);
		extract(shortcode_atts($defaults, $atts, 'dt_highlight'));  	
		
		return '<span class="dt-highlight ' . $color . '">' . do_shortcode($content) . '</span>';  
	}
	add_shortcode("dt_highlight", "dt_highlight"); 
}

/** 
 * Accordian
 */

if (!function_exists('dt_accordian')) {
	function dt_accordian( $atts, $content = null ) {
		return '<div class="dt-accordian">' . do_shortcode($content) . '</div>';  
	}
	add_shortcode("dt_accordian", "dt_accordian"); 
}

if (!function_exists('dt_accordian_section')) {
	function dt_accordian_section( $atts, $content = null ) {
		$defaults = array( 
			'title' => 'Accordian Section', 
			'icon' => 'fa-plus-square'
		);
		extract(shortcode_atts($defaults, $atts, 'dt_accordian_section'));  	
		
		return '<h3 class="dt-accordian-section-title"><i class="fa ' . $icon . '"></i>' . $title . '</h3><div class="dt-accordian-section">' . do_shortcode($content) . '</div>';  
	}
	add_shortcode("dt_accordian_section", "dt_accordian_section"); 
}

/** 
 * Toggle
 */

if (!function_exists('dt_toggle')) {
	function dt_toggle( $atts, $content = null ) {
		$defaults = array( 
			'title' => 'Toggle Section', 
			'icon' => 'fa-plus-square'
		);
		extract(shortcode_atts($defaults, $atts, 'dt_toggle'));  	
		
		return '<div class="dt-toggle"><h3 class="dt-trigger"><i class="fa ' . $icon . '"></i>' . $title . '</h3><div class="dt-toggle-content">' . do_shortcode($content) . '</div></div>';  
	}
	add_shortcode("dt_toggle", "dt_toggle"); 
}

/** 
 * Tabs
 */

if ( !function_exists( 'dt_tabgroup' ) ) {
	function dt_tabgroup( $atts, $content = null ) {

		$defaults = array(
			'style'	=> 'horizontal',
		);
		extract( shortcode_atts( $defaults, $atts ) );
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ){
		    $output .= '<div id="dt-tab-'. rand(1, 100) .'" class="dt-tabgroup ' . $style . ' clearfix">';
			$output .= '<ul class="ui-tabs-nav equalize">';
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#dt-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
	
	add_shortcode("dt_tabgroup", "dt_tabgroup"); 
}

if ( !function_exists( 'dt_tab' ) ) {
	function dt_tab( $atts, $content = null ) {
		$defaults = array(
			'title'	=> 'Tab Title',
			'class'	=> ''
		);
		extract( shortcode_atts( $defaults, $atts ) );
		return '<div id="dt-tab-' . sanitize_title( $title ) . '" class="dt-tab ' . $class . '"><span class="tab-inner equalize">' . do_shortcode( $content ) .'</span></div>';
	}
	
	add_shortcode("dt_tab", "dt_tab"); 
	
}

/**
 * Columns
 */

if (!function_exists('one_half')) {
	function one_half( $atts, $content = null ) {
		$defaults = array( 
			'pos' => null, 
		);
		extract(shortcode_atts($defaults, $atts, 'one_half')); 
		
		$clearfix = '';

		if ($pos == 'last') {
			$clearfix = '<div class="clearfix"></div>';
		}		 	
		
		return '<div class="dtsc dtsc-col-6 ' . $pos . '">' . do_shortcode($content) . '</div>' . $clearfix;  
	}
}

if (!function_exists('one_third')) {
	function one_third( $atts, $content = null ) {
		$defaults = array( 
			'pos' => null, 
		);
		extract(shortcode_atts($defaults, $atts, 'one_third'));  	
		
		return '<div class="dtsc dtsc-col-4 ' . $pos . '">' . do_shortcode($content) . '</div>';  
	}
}

if (!function_exists('one_fourth')) {
	function one_fourth( $atts, $content = null ) {
		$defaults = array( 
			'pos' => null, 
		);
		extract(shortcode_atts($defaults, $atts, 'one_fourth'));  	
		
		
		return '<div class="dtsc dtsc-col-3 ' . $pos . '">' . do_shortcode($content) . '</div>';  
	}
}

if (!function_exists('one_sixth')) {
	function one_sixth( $atts, $content = null ) {
		$defaults = array( 
			'pos' => null, 
		);
		extract(shortcode_atts($defaults, $atts, 'one_sixth')); 
		
		return '<div class="dtsc dtsc-col-2 ' . $pos . '">' . do_shortcode($content) . '</div>';  
	}
}

add_shortcode("dt_one_half", "one_half"); 
add_shortcode("dt_one_third", "one_third"); 
add_shortcode("dt_one_fourth", "one_fourth"); 
add_shortcode("dt_one_sixth", "one_sixth"); 

/** 
 * Progress Bar
 */

if (!function_exists('dt_progressbar')) {
	function dt_progressbar( $atts ) {
		$defaults = array( 
			'progress' => '0%',
			'style' => 'dark', 
			'color' => 'green',  
			'label' => '',
			'active' => 'false', 
			'striped' => 'false',   
		);
		extract(shortcode_atts($defaults, $atts, 'dt_progressbar'));  
		
		if ($active == 'true' && $striped == 'true') {
			$classes = 'animate striped';
		} else if ($active == 'false' && $striped == 'true') {
			$classes = 'striped';
		} else {
			$classes = 'solid';
		}
		
		return '<div class="dt-progressbar ' . $style . '"><div class="bar ' . $color . ' ' . $classes . ' clearfix" data-bar-width="' . $progress . '"><span class="dtpb-label">' . $label . '</span><span class="dtpb-progress">' . $progress . '</span></div></div>';  
	}
	add_shortcode("dt_progressbar", "dt_progressbar"); 
}

/** 
 * Tooltip
 */

if (!function_exists('dt_tooltip')) {
	function dt_tooltip( $atts, $content = null ) {
		$defaults = array( 
			'tooltip' => 'This is a tooltip.', 
			'title' => '', 
			'arrow' => 'left center',
			'pos' => 'right center',
			'style' => 'qtip-tipsy'
		);
		extract(shortcode_atts($defaults, $atts, 'dt_tooltip'));  	
		
		return '<span class="dt-tooltip" data-tooltip-title="' . $title . '" data-tooltip-text="' . $tooltip . '" data-tooltip-arrow="' . $arrow . '" data-tooltip-pos="' . $pos . '" data-tooltip-style="' . $style . '">' . do_shortcode($content) . '</span>';
	}
	add_shortcode("dt_tooltip", "dt_tooltip"); 
}

/** 
 * Pricing Table
 */

if (!function_exists('dt_pricing_group')) {
	function dt_pricing_group( $atts, $content = null ) {
		$defaults = array( 
	  	'columns' => 'four',
			'style' => 'spaces'
		);
		extract(shortcode_atts($defaults, $atts, 'dt_pricing_group')); 
		
		return '<div class="dt-pricing-group ' . $style . ' ' . $columns . '-col clearfix">' . do_shortcode($content) . '</div>';
	}
	add_shortcode("dt_pricing_group", "dt_pricing_group"); 
}

if (!function_exists('dt_pricing')) {
	function dt_pricing( $atts, $content = null ) {
		$defaults = array( 
			'plan' => 'Basic', 
			'price' => '$99',
			'term' => '',
			'button' => 'Button',
			'promoted' => null,
			'color' => 'blue',
			'url' => ''
		);
		extract(shortcode_atts($defaults, $atts, 'dt_pricing')); 
		
		$promoted_flag = '';
		$promoted_ribbon = '';

		if ($promoted) {
			$promoted_flag = 'promoted';
		  $promoted_ribbon = '<div class="promoted-ribbon"><span>' . $promoted . '</span></div>';
		}
		
		
		//build the table
		$pricing_table  = '';
		$pricing_table .= '<div class="dt-pricing ' . $color . ' ' . $promoted_flag .'"><div class="dt-pricing-inner">';
		$pricing_table .= '<div class="pricing-header">';
		$pricing_table .= $promoted_ribbon;
		$pricing_table .= '<div class="plan">' . $plan . '</div>';
		$pricing_table .= '<div class="price">' . $price . '</div>';
		$pricing_table .= '<div class="term">' . $term . '</div>';
		$pricing_table .= '</div>';
		$pricing_table .= do_shortcode($content);
		$pricing_table .= '<div class="take-action"><a href="' . $url . '">'. $button .'</a></div>';
		$pricing_table .= '</div></div>';
		
		return $pricing_table;
	}
	add_shortcode("dt_pricing", "dt_pricing"); 
}

/** Square Brackets **/

if (!function_exists('square_o')) {
	function square_o( $atts, $content = null ) {
		$defaults = array( );
		extract(shortcode_atts($defaults, $atts, 'square_o')); 
		
		return '&#91;';
	}
	add_shortcode("square-o", "square_o"); 
}

if (!function_exists('square_c')) {
	function square_c( $atts, $content = null ) {
		$defaults = array( );
		extract(shortcode_atts($defaults, $atts, 'square_c')); 
		
		return '&#93;';
	}
	add_shortcode("square-c", "square_c"); 
}

/** 
 *	Remove p and br tags surrounding shortcodes
 */

function dt_fix_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}

add_filter('the_content', 'dt_fix_shortcodes');
