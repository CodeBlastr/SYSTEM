<?php	
/**
 * Core functions for zuha 
 */
class Zuha {
    
/**
 * Is UUID
 * Checks whether a given string meets the uuid criteria (8-4-4-4-12, 36 characters).
 * 
 * Usage Zuha::is_uuid('some string, which is or isn't a uuid)
 * 
 * @param string $uuid
 * @return bool
 */
    public static function is_uuid($uuid = '') {
        return (boolean) preg_match('/^\{?[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}\}?$/i', trim((String) $uuid));
    }
	
/**
 * Date Slice 
 * When given two dates, returns an array of slices between the two dates
 * 
 * @param date $fromDate
 * @param date $toDate
 * @param array $options array('type' => 'days OR months', 'format' => 'Y-m-d') 
 */
 	public function date_slice($fromDate = '2007-07-07', $toDate = null, $options = array()) {
		$toDate = !empty($toDate) ? $toDate : date('Y-m-d'); 
		$options['type'] = !empty($options['type']) ? $options['type'] : 'days';
		$options['format'] = !empty($options['format']) ? $options['format'] : 'Y-m-d';
		if ($options['type'] == 'days') {
			$dateMonthYearArr = array();
			$fromDateTs = strtotime($fromDate);
			$toDateTs = strtotime($toDate);
			for ($currentDateTs = $fromDateTs; $currentDateTs <= $toDateTs; $currentDateTs += (60 * 60 * 24)) {
				// use date() and $currentDateTS to format the dates in between
				$currentDateStr = date($options['format'], $currentDateTs);
				$dateMonthYearArr[] = $currentDateStr;
				//print $currentDateStr.�<br />�;
			}
			return $dateMonthYearArr;
		} else {
			$time1 = strtotime($date1);
			$time2 = strtotime($date2);
			$my = date('mY', $time2);
			$months = array(date('F Y', $time1));
			while($time1 < $time2) {
				$time1 = strtotime(date('Y-m-d', $time1).' +1 month');
				if(date('mY', $time1) != $my && ($time1 < $time2)) {
					$months[] = date('F Y', $time1);
				}
			}
			$months[] = date('F Y', $time2);
			return $months;
		}
 	}
 
	
/**
 * Convenience function for finding enumerations
 *
 * @param {mixed} 		The type string (ie. PRICE_TYPE, SETTING_TYPE), if null we find all enumerations. If an integer then we return the single exact enum being called.
 * @param {mixed}		A string or an array of names to find.  If null we find all for the type, if string we find a single enum, if an array we find all which match both the type and the array of names.
 */
	public function enum($type = null, $name = null) {
		$Enum = ClassRegistry::init('Enumeration');
		if (!empty($type)) {
			if (is_numeric($type)) {
				// find a single enum because we have an id number
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.id' => $type,
						),
					));
			} else if (empty($name)) {
				// find a list of enumerations of this type
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.type' => $type,
						),
					));
			} else if (is_string($name)) {
				// find the single enum which matches the type and the name
				return $Enum->field('id', array(
					'Enumeration.type' => $type,
					'Enumeration.name' => $name,
					));
			} else {
                // find all of an array of names by type
				// note name could be an array or a string
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.type' => $type,
						'Enumeration.name' => $name,
						),
					));
			} 
		} else if (!empty($name)) {
			// find all of an array of names by type
			// note name could be an array or a string
			return $Enum->field('id', array(
				'Enumeration.name' => $name,
				));
		} else {
			// find all enumerations
			return $Enum->find('list');
		}
	}
}
	
	
/**
 * To add to the Set core utility with cake for array parsing functions.
 */
class ZuhaSet {
	
/**
 * Recursive removal of a key from an array
 */
	public function remove(&$array, $unwantedKey) {
    	unset($array[$unwantedKey]);
	    foreach ($array as &$value) {
	        if (is_array($value)) {
	            ZuhaSet::remove($value, $unwantedKey);
	        }
	    }
		return $array;
	}
	
/**
 * Remove a value from an array and reindex
 */
	public function devalue($array, $unwantedValue) {
		foreach($array as $key => $value) {
			if ($value != $unwantedValue) {
				$newArray[$key] = $value;
			} 
		}
		return array_values($newArray);
	}
	
/**
 * parse the ini within an ini string
 */
	public function parse_ini_r($arg) {
		if (strpos($arg, '[')) {
			return parse_ini_string($arg, true);
		} else {
			return $arg;
		}
	}
	
/**
 * recursive array map
 * takes an array as the first argument, and functions as the other arguments. 
 * it applies those functions recursively to the array
 */
	public function array_map_r() {
    	$args = func_get_args();
	    $arr = array_shift($args);
   
	    foreach ($args as $fn) {
	        $nfn = create_function('&$v, $k, $fn', '$v = $fn($v);');
	        array_walk_recursive($arr, $nfn, $fn);
	    }
	    return $arr;
	}
	


/**
 * calculates intersection of two arrays like array_intersect_key but recursive
 *
 * @param  array/mixed  master array
 * @param  array        array that has the keys which should be kept in the master array
 * @return array/mixed  cleand master array
 */
    public function array_intersect_r($master, $mask) {
        if (!is_array($master)) { return $master; }
        foreach ($master as $k => $v) {
            if (!isset($mask[$k])) { unset ($master[$k]); continue; } // remove value from $master if the key is not present in $mask
            if (is_array($mask[$k])) { $master[$k] = ZuhaSet::array_intersect_r($master[$k], $mask[$k]); } // recurse when mask is an array
            // else simply keep value
			if (!is_array($v)) {
				global $finalParsedVar;
				$finalParsedVar = $v;
			}
        }
		global $finalParsedVar;
        #return $master; // returns the full associative array with the value filled in
		return $finalParsedVar;
    }
	
/**
 * Key as Paths   ZuhaSet::keyAsPaths($data, $options)
 *
 * Recursively flatten an array.  So that array('key1' => array('key2' => 'value')) becomes array(key1.key2 => value)
 * You can also parse it into html using the options array.  The default parsed output is an unordered list. 
 *
 * @var array   Any multi-dimensional array
 * @var array 	Options, separator, parse, start, startItem, betweenItem, endItem, end.  
 * @return array	When parse is false (default) you get a flattened array returned.  Where you can specifiy the separator.  $options['separator'].  The output is array(key1[$options['separator']key2 => value);
 * @return string 	When parse is true, by default you get an unordered list returned, but you can also control each piece of html surrounding the values. Default is <ul><li>key1.key2 : value</li></ul>  																																					
 */
	public function keyAsPaths($data, $options = null, $index = null) {
		$options['separator'] = empty($options['separator']) ? '.' : $options['separator'];
		$options['parse'] = empty($options['parse']) ? false : true;
		$options['start'] = empty($options['start']) ? '<ul>' : $options['start'];
		$options['startItem'] = empty($options['startItem']) ? '<li>' : $options['startItem'];
		$options['betweenItem'] = empty($options['betweenItem']) ? ' : ' : $options['betweenItem'];
		$options['endItem'] = empty($options['endItem']) ? '</li>' : $options['endItem'];
		$options['end'] = empty($options['end']) ? '</ul>' : $options['end'];
		
		if (is_array($data)) {
			// then send it back
			foreach ($data as $key => $value) {
				if (!is_array($value)) {
					$output[$index . $key] = $value;
				} else {
					$output[$index . $key . $options['separator']] = ZuhaSet::keyAsPaths($value, array('separator' => $options['separator']), $index . $key . $options['separator']);
				}
			}
		} else {
			$output[$index] = $data;
		}
		$return = array();
	    array_walk_recursive($output, function($a, $b) use (&$return) { $return[$b] = $a; });
		
		if ($options['parse']) {
			$parsed = $options['start'];
			foreach ($return as $key => $value) {
				$parsed .= $options['startItem'].$key.$options['betweenItem'].$value.$options['endItem'];
			}
			$parsed .= $options['end'];
			return $parsed;
		}
				
		return $return;
    }
	
/**
 * take a relative path used for urls and return the path from within the webroot folder
 *
 * @param string
 * @return string
 */
 	public function webrootSubPath($relativePath) {
		$path = str_replace('/', DS, $relativePath); // get webroot directory
		$path = str_replace('theme'.DS.'default'.DS, '', $path); // get webroot directory
		return $path;
	}

}
