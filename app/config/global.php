<?php
/**
 * This file is loaded by all bootstrap files and includes functions that should be available everywhere.
 */

	/**
     * calculates intersection of two arrays like array_intersect_key but recursive
     *
     * @param  array/mixed  master array
     * @param  array        array that has the keys which should be kept in the master array
     * @return array/mixed  cleand master array
     */
    function myIntersect($master, $mask) {
        if (!is_array($master)) { return $master; }
        foreach ($master as $k => $v) {
            if (!isset($mask[$k])) { unset ($master[$k]); continue; } // remove value from $master if the key is not present in $mask
            if (is_array($mask[$k])) { $master[$k] = myIntersect($master[$k], $mask[$k]); } // recurse when mask is an array
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

	
	
	function print_rReverse($in) {
   		$lines = explode("\n", trim($in));
		if (trim($lines[0]) != 'Array') {
	        // bottomed out to something that isn't an array
	        return $in;
    	} else {
        	// this is an array, lets parse it
	        if (preg_match("/(\s{5,})\(/", $lines[1], $match)) {
	            // this is a tested array/recursive call to this function
	            // take a set of spaces off the beginning
	            $spaces = $match[1];
	            $spaces_length = strlen($spaces);
	            $lines_total = count($lines);
	            for ($i = 0; $i < $lines_total; $i++) {
	                if (substr($lines[$i], 0, $spaces_length) == $spaces) {
	                    $lines[$i] = substr($lines[$i], $spaces_length);
	                }
	            }
	        }
	        array_shift($lines); // Array
	        array_shift($lines); // (
	        array_pop($lines); // )
	        $in = implode("\n", $lines);
	        // make sure we only match stuff with 4 preceding spaces (stuff for this array and not a nested one)
	        preg_match_all("/^\s{4}\[(.+?)\] \=\> /m", $in, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
	        $pos = array();
	        $previous_key = '';
	        $in_length = strlen($in);
	        // store the following in $pos:
	        // array with key = key of the parsed array's item
	        // value = array(start position in $in, $end position in $in)
	        foreach ($matches as $match) {
	            $key = $match[1][0];
	            $start = trim($match[0][1]) + strlen($match[0][0]);
	            $pos[$key] = array($start, $in_length);
	            if ($previous_key != '') $pos[$previous_key][1] = $match[0][1] - 1;
	            $previous_key = $key;
	        }
	        $ret = array();
	        foreach ($pos as $key => $where) {
	            // recursively see if the parsed out value is an array too
	            $ret[$key] = print_rReverse(substr($in, $where[0], $where[1] - $where[0]));
				if (!is_array($ret[$key])) {
					$ret[$key] = trim($ret[$key]);
				}
	        }
	        return $ret;
	    }
	}
	
	function my_array_map() {
    	$args = func_get_args();
	    $arr = array_shift($args);
   
	    foreach ($args as $fn) {
	        $nfn = create_function('&$v, $k, $fn', '$v = $fn($v);');
	        array_walk_recursive($arr, $nfn, $fn);
	    }
	    return $arr;
	}

	
	function parse_ini_ini($arg) {
		if (strpos($arg, '[')) {
			return parse_ini_string($arg, true);
		} else {
			return $arg;
		}
	}
	
?>