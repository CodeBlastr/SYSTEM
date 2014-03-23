<?php
// in App/View/CsvView.php

App::uses('View', 'View');
class CsvView extends View {

    public function render($view = null, $layout = null) {
		$path = Inflector::tableize($this->viewPath);
		$arr = (isset($this->viewVars[$path])) ? $this->viewVars[$path] : $this->request->data;
		if (empty($arr)) {
			return '';
		}

		$csv = $this->_array_to_csv($arr);
		return $csv;
    }

	private function _array_to_csv($array) {
		$csv = array();

		// Flatten the given array
		foreach ($array as $k => $item) {
			$csv[$k] = (is_array($item)) ? Set::flatten($item) : $item;
		}

		// Create the Column names.
		// This has to be done seperate because we don't have all of them beforehand.
		$csvString = array('headers' => array());
		foreach ($csv as $h => $lines) {
			foreach ($lines as $header => $line) {
				if (array_search($header, $csvString['headers']) === false && !empty($header)) {
					$csvString['headers'][] = $header;
				}
			}
		}

		// Create the values this will also check for commas in the values
		foreach ($csv as $c => $lines) {
			$csvString['values'][$c] = '';
			foreach ($csvString['headers'] as $h) {
				if (isset($lines[$h])) {
					$csvString['values'][$c] .= is_int($lines[$h]) ? $lines[$h] . ',' : '"' . str_replace(',', '' , $lines[$h]) . '",';
				} else {
					$csvString['values'][$c] .= ',';
				}
			}
		}
		$output = '';
		$output .= implode(',', str_replace('.', '_' ,$csvString['headers'])) . "\r\n";
		$output	.= implode("\r\n", $csvString['values']);
		return $output;
	}
}
