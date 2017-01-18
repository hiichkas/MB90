<?php

/* Quote config */

$dt_shortcodes['quote'] = array( 
	'shortcode' => '[dt_quote align="{{align}}" style="{{style}}"] {{content}} [/dt_quote]',
  'title' => 'Insert a Quote Shortcode',
	'params' => array (
		'align' => array(
			'type' => 'select',
			'label' =>  'Alignment',
			'desc'=> 'Right, Left, or Center?',
			'options' => array(
				'right' => 'Right',
				'left' => 'Left',
				'center' => 'Center',
			),
		),
		'style' => array(
			'type' => 'select',
			'label' =>  'Style',
			'desc'=> 'Light or Dark, Dude?',
			'options' => array(
				'light' => 'Light',
				'dark' => 'Dark',
			),
		),
		'content' => array(
			'type' => 'textarea',
			'label' =>  'Quote Content',
			'desc'=> 'What\'s the Quote?'
		),
	),
);

/* Alert config */

$dt_shortcodes['alert'] = array( 
	'shortcode' => '[dt_alert color="{{color}}" close="{{close}}" border="{{border}}"] {{content}} [/dt_alert]',
  'title' => 'Insert an Alert Shortcode',
	'params' => array (
		'color' => array(
			'type' => 'select',
			'label' =>  'Color',
			'desc'=> 'Color of the alert',
			'options' => array(
				'blue' => 'Blue',
				'red' => 'Red',
				'purple' => 'Purple',
				'green' => 'Green',
				'orange' => 'Orange',
				'black' => 'Black',
				'grey' => 'Grey'
			),
		),
		'close' => array(
			'type' => 'select',
			'label' =>  'Close Enabled',
			'desc'=> 'Want users to be able to close the alert?',
			'options' => array(
				'no' => 'No',
				'yes' => 'Yes',
			),
		),
		'border' => array(
			'type' => 'select',
			'label' =>  'Border',
			'desc'=> 'Want a border on the alert box?',
			'options' => array(
				'false' => 'No',
				'true' => 'Yes',
			),
		),
		'content' => array(
			'type' => 'textarea',
			'label' =>  'Alert Content',
			'desc'=> 'What\'s the alert?'
		),
	),
);

/* Button config */

$dt_shortcodes['button'] = array( 
	'shortcode' => '[dt_button url="{{url}}" color="{{color}}" size="{{size}}" display="{{display}}" icon="{{icon}}"] {{content}} [/dt_button]',
  'title' => 'Insert a Button Shortcode',
	'params' => array (
		'url' => array(
			'type' => 'text',
			'label' =>  'Url',
			'desc'=> 'What\'s your URL?'
		),
		'color' => array(
			'type' => 'select',
			'label' =>  'Color',
			'desc'=> 'What color do you want your button to be?',
			'options' => array(
				'blue' => 'Blue',
				'red' => 'Red',
				'purple' => 'Purple',
				'green' => 'Green',
				'orange' => 'Orange',
				'black' => 'Black',
				'grey' => 'Grey'
			),
		),
		'size' => array(
			'type' => 'select',
			'label' =>  'Size',
			'desc'=> 'What size do you want your button to be?',
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		'display' => array(
			'type' => 'select',
			'label' =>  'Display',
			'desc'=> 'Button Display',
			'options' => array(
				'inline' => 'Inline',
				'block' => 'Block',
			),
		),
		'icon' => array(
			'type' => 'text',
			'label' =>  'Icon (Optional)',
			'desc'=> 'Enter the icon class.  Check out the full list <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here.</a>'
		),
		'content' => array(
			'type' => 'textarea',
			'label' =>  'Button Text',
			'desc'=> 'Enter the text for the button.'
		),
	),
);

/* Icon config */

$dt_shortcodes['icon'] = array( 
	'shortcode' => '[dt_icon type="{{type}}" color="{{color}}" color="{{size}}"]',
  'title' => 'Insert an Icon',
	'params' => array (
		'type' => array(
			'type' => 'text',
			'label' =>  'Icon Type',
			'desc'=> 'Enter the icon class.  Check out the full list <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here.</a>'
		),
		'color' => array(
			'type' => 'text',
			'label' =>  'Icon Color',
			'desc'=> 'Enter a hex or color name.'
		),
		'size' => array(
			'type' => 'text',
			'label' =>  'Icon Size',
			'desc'=> 'Enter size in pixels (Example: 14px)'
		),
	),
);

/* Highlight config */

$dt_shortcodes['highlight'] = array( 
	'shortcode' => '[dt_highlight color="{{color}}"] {{content}} [/dt_highlight]',
  'title' => 'Insert Highlighted Text',
	'params' => array (
		'color' => array(
			'type' => 'select',
			'label' =>  'Color',
			'desc'=> 'What color do you want your button to be?',
			'options' => array(
				'blue' => 'Blue',
				'red' => 'Red',
				'purple' => 'Purple',
				'green' => 'Green',
				'yellow' => 'Yellow',
				'black' => 'Black',
				'grey' => 'Grey'
			),
		),
		'content' => array(
			'type' => 'textarea',
			'label' =>  'Highlight content',
			'desc'=> 'Enter the text you want to be highlighted.'
		),
	),
);

/* Tooltip config */

$dt_shortcodes['tooltip'] = array( 
  'title' => 'Insert Tooltip',
	'shortcode' => '[dt_tooltip title="{{title}}" style="{{style}}" pos="{{pos}}" arrow="{{arrow}}" tooltip="{{tooltip}}"] {{content}} [/dt_tooltip]',
	'params' => array (
		'title' => array(
			'type' => 'text',
			'label' =>  'Tooltip Title (Optional)',
			'desc'=> 'Enter an optional title for the tooltip.'
		),
		'style' => array(
			'type' => 'select',
			'label' =>  'Style',
			'desc'=> 'What style do you want to use?',
			'options' => array(
				'qtip-tipsy' => 'Tipsy',
				'qtip-shadow' => 'Shadow',
				'qtip-rounded' => 'Rounded',
				'qtip-bootstrap' => 'Bootstrap',
				'qtip-youtube' => 'YouTube',
				'qtip-jtools' => 'jTools',
				'qtip-cluetip' => 'Cluetip',
				'qtip-tipped' => 'tipped',
				'qtip-plain' => 'Plain',
				'qtip-light' => 'Light',
				'qtip-dark' => 'Dark',
				'qtip-red' => 'Red',
				'qtip-green' => 'Green',
				'qtip-blue' => 'Blue',
			),
		),
		'pos' => array(
			'type' => 'select',
			'label' =>  'Tooltip Postion',
			'desc'=> 'Where do you want the tooltip to appear in relation to the content?',
			'options' => array(
				'top center' => 'Top',
				'right center' => 'Right',
				'bottom center' => 'Bottom',
				'left center' => 'Left',
			),
		),
		'arrow' => array(
			'type' => 'select',
			'label' =>  'Arrow Postion',
			'desc'=> 'Where do you want the direction arrow to appear on the tooltip?',
			'options' => array(
				'top center' => 'Top',
				'right center' => 'Right',
				'bottom center' => 'Bottom',
				'left center' => 'Left',
			),
		),
		'tooltip' => array(
			'type' => 'textarea',
			'label' =>  'Tooltip content',
			'desc'=> 'Enter the tooltip content.'
		),
		'content' => array(
			'type' => 'textarea',
			'label' =>  'Associated Content',
			'desc'=> 'Enter the content you want to be associated with the tooltip.'
		),
	),
);

/* Toggle config */

$dt_shortcodes['toggle'] = array( 
	'shortcode' => '[dt_toggle title="{{title}}" icon="{{icon}}"] {{content}} [/dt_toggle]',
  'title' => 'Insert Toggle',
	'params' => array (
		'title' => array(
			'type' => 'text',
			'label' =>  'Toggle Title',
			'desc'=> 'Enter Toggle\'s title.'
		),
		'icon' => array(
			'type' => 'text',
			'label' =>  'Icon (Optional)',
			'desc'=> 'Enter the icon class.  Check out the full list <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here.</a>'
		),
		'content' => array(
			'type' => 'textarea',
			'label' =>  'Toggle content',
			'desc'=> 'Enter the text you want to be highlighted.'
		),
	),
);

/* Progressbar config */

$dt_shortcodes['progressbar'] = array( 
	'shortcode' => '[dt_progressbar label="{{label}}" progress="{{progress}}" color="{{color}}" style="{{style}}" active="{{active}}" striped="{{striped}}"]',
  'title' => 'Insert Progress Bar',
	'params' => array (
		'label' => array(
			'type' => 'text',
			'label' =>  'Progress Bar Label',
			'desc'=> 'What\'s this all about?'
		),
		'progress' => array(
			'type' => 'text',
			'label' =>  'Progress/Percentage',
			'desc'=> 'Enter a percentage (For example: 30%)'
		),
		'color' => array(
			'type' => 'select',
			'label' =>  'Color',
			'desc'=> 'What color do you want your bar to be?',
			'options' => array(
				'blue' => 'Blue',
				'red' => 'Red',
				'purple' => 'Purple',
				'green' => 'Green',
				'orange' => 'Orange',
				'black' => 'Black',
				'grey' => 'Grey'
			),
		),
		'style' => array(
			'type' => 'select',
			'label' =>  'Style',
			'desc'=> 'Light recommended for light backgrounds, dark for dark.',
			'options' => array(
				'light' => 'Light',
				'dark' => 'Dark',
			),
		),
		'active' => array(
			'type' => 'select',
			'label' =>  'Active',
			'desc'=> 'Add subtle animation to the bar.',
			'options' => array(
				'false' => 'Disabled',
				'true' => 'Enabled',
			),
		),
		'striped' => array(
			'type' => 'select',
			'label' =>  'Stripes',
			'desc'=> 'Add stripes to the bar.',
			'options' => array(
				'false' => 'Disabled',
				'true' => 'Enabled',
			),
		),
	),
);

/* Accordian config */

$dt_shortcodes['accordian'] = array( 
	'shortcode' => '[dt_accordian] {{child}} [/dt_accordian]',
  'title' => 'Insert Accordian',
	'child' => array (
    'shortcode' => '[dt_accordian_section title="{{title}}" icon="{{icon}}"] {{content}} [/dt_accordian_section]',
		'params' => array (
			'title' => array(
				'type' => 'text',
				'label' =>  'Title',
				'desc'=> 'Enter the title.'
			),
			'icon' => array(
				'type' => 'text',
				'label' =>  'Icon (Optional)',
				'desc'=> 'Enter the icon class.  Check out the full list <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here.</a>'
			),
			'content' => array(
				'type' => 'textarea',
				'label' =>  'Accordian content',
				'desc'=> 'Enter the text you want to be highlighted.'
			),
		),
	),
);


/* Tabs config */

$dt_shortcodes['tabs'] = array( 
	'shortcode' => '[dt_tabgroup style="{{style}}"] {{child}} [/dt_tabgroup]',
  'title' => 'Insert Tab',
	'params' => array (
		'style' => array(
		'type' => 'select',
		'label' =>  'Style',
		'desc'=> 'Vertical or Horizontal?',
			'options' => array(
				'horizontal' => 'Horizontal',
				'vertical' => 'Vertical',
			),
		),
	),
	'child' => array (
    'shortcode' => '[dt_tab title="{{title}}"] {{content}} [/dt_tab]',
		'params' => array (
			'title' => array(
				'type' => 'text',
				'label' =>  'Title',
				'desc'=> 'Enter the tab title.'
			),
			'content' => array(
				'type' => 'textarea',
				'label' =>  'Tab content',
				'desc'=> 'Enter the tab content.'
			),
		),
	),
);

/* Tabs config */

$dt_shortcodes['pricing'] = array( 
	'shortcode' => '[dt_pricing_group style="{{style}}" columns="{{columns}}"] {{child}} [/dt_pricing_group]',
  'title' => 'Insert Pricing Table',
	'params' => array (
		'columns' => array(
			'type' => 'select',
			'label' =>  'Columns',
			'desc'=> 'Number of Columns',
			'options' => array(
				'two' => 'Two',
				'three' => 'Three',
				'four' => 'Four',
				'five' => 'Five',
			),
		),
		'style' => array(
			'type' => 'select',
			'label' =>  'Style',
			'desc'=> 'Spaces between the tables?',
			'options' => array(
				'spaces' => 'Spaces',
				'no-spaces' => 'No Spaces',
			),
		),
	),
	'child' => array (
    'shortcode' => '[dt_pricing plan="{{plan}}" price="{{price}}" term="{{term}}" button="{{button}}" url="{{url}}" color="{{color}}"] {{content}} [/dt_pricing]',
		'params' => array (
			'plan' => array(
				'type' => 'text',
				'label' =>  'Plan',
				'desc'=> 'Enter the name of the plan/subscription/product.'
			),
			'price' => array(
				'type' => 'text',
				'label' =>  'Price',
				'desc'=> 'Enter the price of the plan/subscription/product.'
			),
			'term' => array(
				'type' => 'text',
				'label' =>  'Terms',
				'desc'=> 'Enter the terms of the purchase. (i.e. per month, per year)'
			),
			'button' => array(
				'type' => 'text',
				'label' =>  'Button Text',
				'desc'=> 'Enter the text for the button.'
			),
			'url' => array(
				'type' => 'text',
				'label' =>  'Button URL',
				'desc'=> 'Where does your button lead?'
			),
			'color' => array(
					'type' => 'select',
					'label' =>  'Color',
					'desc'=> 'Table Color',
					'options' => array(
						'blue' => 'Blue',
						'red' => 'Red',
						'orange' => 'Orange',
						'green' => 'Green',
						'pruple' => 'Purple',
						'black' => 'Black',
					),
				),
			'content' => array(
				'type' => 'textarea',
				'label' =>  'Pricing table content',
				'desc'=> 'Enter the pricing content. (list format recommented)'
			),
		),
	),
);

/* Toggle config */

$dt_shortcodes['columns'] = array( 
	'shortcode' => '{{child}}',
  'title' => 'Insert Toggle',
	'child' => array(
  	'shortcode' => '[{{col}} pos="{{pos}}"] {{content}} [/{{col}}]',
		'params' => array (
			'col' => array(
				'type' => 'select',
				'label' =>  'Column Width',
				'desc'=> 'Select the width of the column',
				'options' => array (
					'dt_one_half' => 'One Half',
					'dt_one_third' => 'One Third',
					'dt_one_fourth' => 'One Fourth',
					'dt_one_sixth' => 'One Sixth'
				),
			),
			'pos' => array(
				'type' => 'select',
				'label' =>  'Position in Row',
				'desc'=> 'If the column is first in the row, select First.  If last in the row, select Last.',
				'options' => array (
					'na' => 'N/A',
					'first' => 'First',
					'last' => 'Last'
				),
			),
			'content' => array(
				'type' => 'textarea',
				'label' =>  'Toggle content',
				'desc'=> 'Enter the text you want to be highlighted.'
			),
		),
	),
);


	

			 
		 
?>
