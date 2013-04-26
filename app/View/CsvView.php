<?php
// in App/View/CsvView.php

App::uses('View', 'View');
class CsvView extends View {
	
    public function render($view = null, $layout = null) {
		$path = Inflector::tableize($this->viewPath);
		//debug($this);
		//debug(ZuhaSet::keyAsPaths($this->viewVars[$path]));
		$csv = $this->_array_to_csv($this->viewVars[$path]);
		//debug($this->viewVars);
		//break;
		//debug($csv);
		//break;
		return $csv; 
    }
	
	private function _array_to_csv($array) {
		$csv = array();
		
		//Flatten the given array
		foreach ($array as $k => $item) {
			if(is_array($item)) {
				$item = Set::flatten($item);
				$csv[$k] = $item;
			}else{
				$csv[$k] = $item;
			}
		}
		
		//Create the Column names
		//This has to be done seperate because we don't all of them beforehand
		$csvString = array('headers' => array());
		foreach($csv as $h => $lines) {
			foreach($lines as $header => $line) {
				$header = str_replace('.', '_', $header);
				//debug(array_search($header, $csvString['headers']));
				if(array_search($header, $csvString['headers']) === false) {
					//debug(array_search(key($line), $csvString['headers']));
					$csvString['headers'][] = $header; 
				}
			}
		}
		
		//Create the values this will also check for commas in the values
		foreach($csv as $c => $lines) {
			$csvString['values'][$c] = '';
			foreach($csvString['headers'] as $h) {
				$h = str_replace('_', '.', $h);
				if(isset($lines[$h])) {
					
					$csvString['values'][$c] .= is_int($lines[$h]) ? $lines[$h] . ',' : '"' . str_replace(',', '' , $lines[$h]) . '",'; 
				}else {
					$csvString['values'][$c] .= ',';
				}
			}
			
		}
			
		$output = '';
		$output .= implode(',', $csvString['headers']) . "\r\n";
		$output	.= implode("\r\n", $csvString['values']);
		
		return $output;
	}
}