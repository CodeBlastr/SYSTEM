<?php	
/**
 * Core functions for zuha 
 */
class Zuha {
	
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
				# find a single enum because we have an id number
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.id' => $type,
						),
					));
			} else if (empty($name)) {
				# find a list of enumerations of this type
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.type' => $type,
						),
					));
			} else if (is_string($name)) {
				# find the single enum which matches the type and the name
				return $Enum->field('id', array(
					'Enumeration.type' => $type,
					'Enumeration.name' => $name,
					));
			} else {
				# find all of an array of names by type
				# note name could be an array or a string
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.type' => $type,
						'Enumeration.name' => $name,
						),
					));
			} 
		} else if (!empty($name)) {
			# find all of an array of names by type
			# note name could be an array or a string
			return $Enum->field('id', array(
				'Enumeration.name' => $name,
				));
		} else {
			# find all enumerations
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
}