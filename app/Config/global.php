<?php	
/**
 * Core functions for zuha 
 */
class Zuha {
	
/**
 * reverse a request from the params
 */
 	public static function reverseParams($request) {
 		 // it's annoying that there's no way to get a url from params
 		unset($request['alias']); // for backwards compatibility
 		$url = $request;
 		unset($url['pass']);
		$passed = implode('/', $request['pass']);
		$passed = !empty($passed) ? '/' . $passed : null;
 		unset($url['named']);
		$named = str_replace(array('[]', '{"', '":"', '","', '"}'), array('', '/', ':', '/', ''), json_encode($request['named']));
		return Router::normalize(implode('/', $url) . $passed . $named);
 	}
    
/**
 * Is UUID
 * Checks whether a given string meets the uuid criteria (8-4-4-4-12, 36 characters).
 * 
 * Usage Zuha::is_uuid('some string, which is or isn't a uuid)
 * 
 * @param string $uuid
 * @return boolean
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
	public function enum($key = null, $name = null, $options = array()) {
		$Enum = ClassRegistry::init('Enumeration');
		if (!empty($key)) {
			if (is_numeric($key)) {
				// find a single enum because we have an id number
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.id' => $key,
						),
					));
			} elseif (empty($name)) {
				// find a list of enumerations of this type
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.type' => $key,
						),
					) + $options);
			} elseif (is_string($name)) {
				// find the single enum which matches the type and the name
				return $Enum->field('id', array(
					'Enumeration.type' => $key,
					'Enumeration.name' => $name,
					));
			} else {
                // find all of an array of names by type
				// note name could be an array or a string
				return $Enum->find('list', array(
					'conditions' => array(
						'Enumeration.type' => $key,
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

/**
 * This function will return an array of Plugin(s), it's Controllers, and those Controllers' Actions.
 * It returns all currently loaded Plugins' Controllers' Actions by default.
 *
 * @param array $plugin Array with Plugin name(s) to return Controllers and Actions for
 * @return array an array of all [PLUGINS][CONTROLLERS][ACTIONS] that are currently loaded
 */
	public function getPluginControllerActions($plugin = array('all')) {
		$allActions = ($plugin == array('all')) ? CakePlugin::loaded() : $plugin;

		// filter out Plugins that we will never want to see here
		$hiddenPlugins = array('Utils');

		foreach ($allActions as $pKey => &$plugin) {
			if (in_array($plugin, $hiddenPlugins)) {
				unset($allActions[$pKey]);
				continue;
			}

			$pluginsControllers = array_diff(App::objects($plugin.'.Controller'), App::objects('Controller'));

			foreach ($pluginsControllers as $cKey => &$controller) {
				$controllerName = $controller;
				App::uses($controllerName, $plugin . '.Controller');

				$reflect = new ReflectionClass($controllerName);
				$actions = false;
				foreach ($reflect->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
					if (
							// filter out methods that we won't ever want to see (could be configurable at some point if needed)
							( $method->class == $controllerName || $method->class == '_'.$controllerName )
							&& $method->isPublic() // handled above in getMethods()?
							&& strstr($method->name, '_') == false
							&& strstr($method->name, '__') == false
							&& $method->name !== 'beforeFilter'
						) {
						$actions[] = $method->name;
					}
				}

				if (!$actions) {
					// remove Controllers that have no Actions
					unset($pluginsControllers[$cKey]);
				} else {
					$controller = array($controller => $actions);
				}

			}
			$plugin = array($plugin => array_values($pluginsControllers));
		}

		return array_values($allActions);
	}

}


/**
 * To add to the Set core utility with cake for array parsing functions.
 */
class ZuhaSet {
	
/**
 * manyize method
 * 
 * converts an array from
 * array (
 * 		0 => array(
 * 			Model => array(
 * 				field1 => xyz,
 * 				field2 => abc
 * 			)
 *		)
 * ) 
 * 
 * to 
 * 
 * array(
 * 		Model => array(
 * 			0 => array(
 * 				field1 => xyz,
 * 				field2 => abc
 * 			)
 * 		)
 * )
 */
	public function manyize($array) {
		// test data... left here, because it needs to be moved into a unit test
		// $array = array(
			// 0 => array(
				// 'Transaction' => array(
					// 'id' => '5241b49d-25b0-45b5-8822-44830ad25527',
					// 'name' => 'ONE',
					// 'transaction_id' => 'a043572d-9040-43c9-85b1-22d400000002',
					// 'quantity' => '1',
					// 'price' => '10',
					// 'SomeMode' => array(
							// 'some-data' => 'some-value'
							// )
				// ),
			// ),
			// 1 => array(
				// 'TransactionItem' => array(
					// 'id' => '5241b49d-25b0-45b5-8822-44830ad25527',
					// 'name' => 'TWO',
					// 'transaction_id' => 'a043572d-9040-43c9-85b1-22d400000002',
					// 'quantity' => '1',
					// 'price' => '10',
				// ),
			// ),
			// 2 => array(
				// 'TransactionItem' => array(
					// 'id' => '5241b49d-25b0-45b5-8822-44830ad25527',
					// 'name' => 'THREE',
					// 'transaction_id' => 'a043572d-9040-43c9-85b1-22d400000002',
					// 'quantity' => '1',
					// 'price' => '10',
					// 'myadd-on-field' => 'nothing'
				// ),
			// )
		// );
		if (!empty($array[0])) {
			for ($i=0; $i < count($array); $i++) {
				foreach (array_keys($array[$i]) as $key) {
					if (key($array[$i]) == $key) {
						$output[$key][$i] = $array[$i][$key];
					} else {
						$output[key($array[$i])][$i][$key] = $array[$i][$key];
					}
				}
			}
			$array = $output; // here because sometimes the array coming in is empty, and we want to return the empty array
		}
		return $array;
	}
	
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
 * Remove a value from an array and reindex (if keepKeys is false)
 */
	public function devalue($array, $unwantedValue, $keepKeys = false) {
		foreach($array as $key => $value) {
			if ($value != $unwantedValue) {
				$newArray[$key] = $value;
			}
		}
		return $keepKeys == true ? $newArray : array_values($newArray);
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
	
/**
 * Replaces the values in array_b with array_a
 * Different from PHP's array_replace_recursive because it checks to see if the values are equal.
 * 
 * @param $array_a array replacing values
 * @param $array_b array being merged with
 * 
 * @return $array_b with all the values from array_a
 */
    public function array_replace_r($array_a, $array_b) {
		foreach ($array_b as $k => $v) {
			if ($array_b[$k] != $array_a[$k]) {
				if (is_array($array_a[$k])) {
					ZuhaSet::array_replace_r($array_a[$k], $array_b[$k]);
				} else {
					$array_b[$k] = $v;
				}
			}
		}
		return $array_b;
    }

/**
 * @return array
 * @param array $src
 * @param array $in
 * @param int|string $pos
 */
	public function array_splice_after($array, $insert, $position) {
	    if(is_int($position)) {
	    	$r = array_merge(array_slice($array, 0, $position + 1), $insert, array_slice($array, $position + 1));
		} else {
	        foreach($array as $k => $v) {
	            $r[$k]=$v;
	            if($k == $position) {
	            	$r = array_merge($r, $insert);
				}
	        }
	    }
	    return $r;
	}

/**
 * @return array
 * @param array $src
 * @param array $in
 * @param int|string $pos
 */
	public function array_splice_before($array, $insert, $position) {
	    if(is_int($position)) {
	    	$r = array_merge(array_slice($array, 0, $position), $insert, array_slice($array, $position));
		} else {
	        foreach($array as $k => $v){
	            if($k == $position) {
	            	$r = array_merge($r, $insert);
				}
	            $r[$k] = $v;
	        }
	    }
	    return $r;
	}

/**
 * Recursively remove empty values from an array
 */
	public function array_filter_recursive($haystack) {
	    foreach ($haystack as $key => $value) {
	        if (is_array($value)) {
	            $haystack[$key] = ZuhaSet::array_filter_recursive($haystack[$key]);
	        }
	        if (empty($haystack[$key])) {
	            unset($haystack[$key]);
	        }
	    }
	    return is_numeric(key($haystack)) ? array_values($haystack) : $haystack; // reindex if keys are sequential instead of associative
	}

/**
 * Recursively search an array for a key, and return the value of that key
 * 
 * @param array
 * @param string
 */
 	public function find_key($array = array(), $needle) {
 		$iterator  = new RecursiveArrayIterator($array);
	    $recursive = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
	    foreach ($recursive as $key => $value) {
	        if ($key === $needle) {
	            return $value;
	        }
	    }
 	}

}
