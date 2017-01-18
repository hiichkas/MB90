<?php

class dtsc_popup {
	
	function __construct($popup) {
		$this->popup = $popup;
		$this->build_form_item();
	}
	
	function build_form_item() {
		
		require_once('config.php');
		
		$this->shortcode = $dt_shortcodes[$this->popup]['shortcode'];
		$this->title = $dt_shortcodes[$this->popup]['title'];
		$this->params = $dt_shortcodes[$this->popup]['params'];
		
		$this->append_output( "\n" . '<div id="dt-shortcode" class="hidden">' . $this->shortcode . '</div>' );
		$this->append_output( '<table class="parent-row">');
		
		foreach ($this->params as $param => $value ) {
			
			$option_type = $value['type'];
			$options = $value['options'];
			
			$row_start =  '<td class="form-item">';
			$row_start .= '<label>' . $value['label'] . '</label>';
			$row_end = '<br />';
			$row_end .= '<small>' . $value['desc'] . '</small>';
			$row_end .= '</td>';
			
			switch ($option_type) {
				case 'text':
				  $output = $row_start;
					$output .= '<input id="' . $param . '" class="option" type="text" />';
					$output .= $row_end;
					$this->append_output( $output );
					break;
				case 'select':
					$output = $row_start;
					$output .= '<select id="' . $param . '" class="option">';
					foreach ($options as $opt => $value) {
						$output .= '<option value="' . $opt . '">' . $value . '</option>';
					}
					$output .= '</select>';
					$output .= $row_end;
					$this->append_output( $output );
					break;
				case 'checkbox':
				  $output = $row_start;
					$output .= '<input id="' . $param . '" value="true" class="option checkbox" type="checkbox"> Enable/Disable';
					$output .= $row_end;
					$this->append_output( $output );
					break;
				case 'textarea':
				  $output = $row_start;
					if ($param == 'text') {
					  $output .= '<textarea id="' . $param . '" /></textarea>';
					} else {
					  $output .= '<textarea id="' . $param . '" class="option" /></textarea>';
					}
					$output .= $row_end;
					$this->append_output( $output );
					break;
			}
		}
		
		$this->append_output( '</tr></table></div>');

		if (isset( $dt_shortcodes[$this->popup]['child'] )) {
			
			$this->cshortcode = $dt_shortcodes[$this->popup]['child']['shortcode'];
			$this->cparams = $dt_shortcodes[$this->popup]['child']['params'];
			
			$this->append_output( "\n" . '<div id="dt-cshortcode" class="hidden">' . $this->cshortcode . '</div>' );
			$this->append_output( '<table class="child-row"><tr>');
			
			foreach ($this->cparams as $cparam => $cvalue ) {
				
				$coption_type = $cvalue['type'];
				$coptions = $cvalue['options'];
				
				$crow_start =  '<td class="form-item">';
				$crow_start .= '<label>' . $cvalue['label'] . '</label>';
				$crow_end = '<br />';
				$crow_end .= '<small>' . $cvalue['desc'] . '</small>';
				$crow_end .= '</td>';
				
				switch ($coption_type) {
					case 'text':
						$coutput = $crow_start;
						$coutput .= '<input id="' . $cparam . '" class="coption" type="text" />';
						$coutput .= $crow_end;
						$this->append_output( $coutput );
						break;
					case 'select':
						$coutput = $crow_start;
						$coutput .= '<select id="' . $cparam . '" class="coption">';
						foreach ($coptions as $copt => $cvalue) {
							$coutput .= '<option value="' . $copt . '">' . $cvalue . '</option>';
						}
						$coutput .= '</select>';
						$coutput .= $crow_end;
						$this->append_output( $coutput );
						break;
					case 'checkbox':
						$coutput = $crow_start;
						$coutput .= '<input id="' . $cparam . '" value="true" class="coption checkbox" type="checkbox"> Enable/Disable';
						$coutput .= $crow_end;
						$this->append_output( $coutput );
						break;
					case 'textarea':
						$coutput = $crow_start;
						if ($cparam == 'text') {
							$coutput .= '<textarea id="' . $cparam . '" /></textarea>';
						} else {
							$coutput .= '<textarea id="' . $cparam . '" class="coption" /></textarea>';
						}
						$coutput .= $crow_end;
						$this->append_output( $coutput );
						break;
				}
			}
			
		  $this->append_output( '</tr></table>');
		}
		
		$this->append_output('<div class="clearfix"><a href="javascript:ShortcodeDialog.insert(ShortcodeDialog.local_ed)" id="insert">Insert</a></div>');
	}
	
	function append_output( $output ) {
		$this->output = $this->output . $output;		
	}	
}

?>
