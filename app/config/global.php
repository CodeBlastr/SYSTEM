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
	Configure::write('Recaptcha.publicKey', '6Lc5xsMSAAAAAAoP0DkzEcoBHvHeQ2mO506mHnRY');
	Configure::write('Recaptcha.privateKey', '6Lc5xsMSAAAAADJmj-bruuzCYXOeSg5Mf7JTyW3e');
	 
	
	/**
	 * Function for formatting the pricing of an item.
	 *
	 * @todo 	Update to include the dollar sign, and decimal place for various languages. (and remove the dollar sign from the view files. Based on a setting that needs to be created yet. 
	 */
	function formatPrice($price) {
		return number_format($price, 2);
	}
	
	
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
	
	/**
	 * Convenience function for finding enumerations
	 *
	 * @param {mixed} 		The type string (ie. PRICETYPE, SETTING_TYPE), if null we find all enumerations. If an integer then we return the single exact enum being called.
	 * @param {mixed}		A string or an array of names to find.  If null we find all for the type, if string we find a single enum, if an array we find all which match both the type and the array of names.
	 */
	function enum($type = null, $name = null) {
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
	
	
 	function pluginize($name) {
		# list of models and controllers to rename to the corresponding plugin
		$allowed = array(
			'Banner' => 'banners',
			'Category' => 'categories',
			'Categories' => 'categories',
			'Catalog' => 'catalogs',
			'Catalogs' => 'catalogs',
			'CatalogItem' => 'catalogs',
			'CatalogItems' => 'catalogs',
			'catalog_items' => 'catalogs',
			'CatalogItemBrand' => 'catalogs',
			'CatalogItemBrands' => 'catalogs',
			'catalog_item_brands' => 'catalogs',
			'Gallery' => 'galleries',
			'GalleryImage' => 'galleries',
			'GalleryImages' => 'galleries',
			'gallery_images' => 'galleries',
			'Invoice' => 'invoices',
			'InvoiceItem' => 'invoices',
			'InvoiceTime' => 'invoices',
			'Project' => 'projects',
			'Used' => 'users',
			'User' => 'users',
			'Setting' => '',
			'Settings' => '',
			'Member' => 'members',
			);
		if ($allowed[$name] !== null) {
			return $allowed[$name];
		} else {
			return Inflector::tableize($name);
		}
	}
	
	function states() {
		return array(
			'AL' => 'Alabama',
			'AK' => 'Alaska',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DE' => 'Delaware',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NE' => 'Nebraska',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PA' => 'Pennsylvania',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VT' => 'Vermont',
			'VA' => 'Virginia', 
			'WA' => 'Washington', 
			'WV' => 'West Virginia', 
			'WI' => 'Wisconsin', 
			'WY' => 'Wyoming', 	 	 	
 			);
	}

?>