<?php
if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'bootstrap.php')) {
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'bootstrap.php');
} else {
	
	/**
	 * Default bootstrap.php file from here down.
	 */
	
	require_once(ROOT.DS.APP_DIR.DS.'Config'.DS.'global.php');
	
	/**
	 * The settings below can be used to set additional paths to models, views and controllers.
	 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
	 *
	 */
	
	if (!defined('SITE_DIR')) {
		define('SITE_DIR', null);
	}
	if (!defined('CONFIGS')) {
		define('CONFIGS', null);
	}
	App::build(array(
		'plugins' => array(
			ROOT.DS.SITE_DIR.DS.'Plugin'.DS,
			ROOT.DS.APP_DIR.DS.'Plugin'.DS
			),
		'models' =>  array(
			//ROOT.DS.SITE_DIR.DS.'Locale'.DS.Configure::read('Config.language').DS.'Plugin'.DS.'%s'.DS.'Model'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Plugin'.DS.'%s'.DS.'Model'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Model'.DS,
			ROOT.DS.APP_DIR.DS.'Model'.DS
			),
		'views' => array(
			//ROOT.DS.SITE_DIR.DS.'Locale'.DS.Configure::read('Config.language').DS.'Plugin'.DS.'%s'.DS.'View'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Plugin'.DS.'%s'.DS.'View'.DS,
			ROOT.DS.SITE_DIR.DS.'View'.DS.'locale'.DS.Configure::read('Config.language').DS, // to be deprecated soon, 2012-11-29 RK
			ROOT.DS.SITE_DIR.DS.'View'.DS, // for the theme directory to work
			ROOT.DS.APP_DIR.DS.'View'.DS,
			),
		'controllers' => array(
			//ROOT.DS.SITE_DIR.DS.'Locale'.DS.Configure::read('Config.language').DS.'Plugin'.DS.'%s'.DS.'Controller'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Plugin'.DS.'%s'.DS.'Controller'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Controller'.DS,
			ROOT.DS.APP_DIR.DS.'Controller'.DS
			),
		'datasources' => array(
			//ROOT.DS.SITE_DIR.DS.'Locale'.DS.Configure::read('Config.language').DS.'Plugin'.DS.'%s'.DS.'Datasource'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Plugin'.DS.'%s'.DS.'Datasource'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Datasource'.DS,
			ROOT.DS.APP_DIR.DS.'Model'.DS.'Datasource'.DS
			),
		'behaviors' => array(
			//ROOT.DS.SITE_DIR.DS.'Locale'.DS.Configure::read('Config.language').DS.'Plugin'.DS.'%s'.DS.'Model'.DS.'Behavior'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Plugin'.DS.'%s'.DS.'Model'.DS.'Behavior'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Model'.DS.'Behavior',
			ROOT.DS.APP_DIR.DS.'Model'.DS.'Behavior'.DS
			),
		'components' => array(
			//ROOT.DS.SITE_DIR.DS.'Locale'.DS.Configure::read('Config.language').DS.'Plugin'.DS.'%s'.DS.'Controller'.DS.'Component'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Plugin'.DS.'%s'.DS.'Controller'.DS.'Component'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Controller'.DS.'Component',
			ROOT.DS.APP_DIR.DS.'Controller'.DS.'Component'.DS
			),
		'helpers' => array(
			//ROOT.DS.SITE_DIR.DS.'Locale'.DS.Configure::read('Config.language').DS.'Plugin'.DS.'%s'.DS.'View'.DS.'Helper'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'Plugin'.DS.'%s'.DS.'View'.DS.'Helper'.DS,
			ROOT.DS.SITE_DIR.DS.'Locale'.DS.'View'.DS.'Helper',
			ROOT.DS.APP_DIR.DS.'View'.DS.'Helper'.DS
			),
	//   'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
	//   'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
	//   'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
	));
	
    Inflector::rules('singular', array('irregular' => array('webpage_jses' => 'webpage_js')));
    Inflector::rules('plural', array('irregular' => array('webpage_js' => 'webpage_jses')));
	
	/**
	 * reads settings.ini (or defaults.ini if non-existent)
	 * and sets configurable constants that are set in the settings db table
	 */
	function __setConstants($path = null, $return = false) {
		$path = (!empty($path) ? $path : CONFIGS);
		if (file_exists($path .'defaults.ini')) {
			if (file_exists($path .'settings.ini')) {
				$path .= 'settings.ini';
			} else {
				$path .= 'defaults.ini';
			}
			$settings = parse_ini_file($path, true);
			if ($return == true) {
				$settings = ZuhaSet::array_map_r($settings, 'ZuhaSet::parse_ini_r');
				return $settings;
			} else {
				foreach ($settings as $key => $value) {
					$key = trim($key);
					if (!defined(strtoupper($key))) {
						if (is_array($value)) {
							define(strtoupper($key), serialize($value));
						} else {
							define(strtoupper($key), $value);
						}
					}
				}
			}
			#debug(get_defined_constants());
		}
	}
	
	__setConstants();
	
	/**
	 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
	 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
	 * advanced ways of loading plugins
	 *
	 */
        //debug(SITE_DIR);break;
	if (defined('__SYSTEM_LOAD_PLUGINS')) {
		//CakePlugin::loadAll();
		extract(unserialize(__SYSTEM_LOAD_PLUGINS));
		CakePlugin::load($plugins);
	} elseif (SITE_DIR === NULL){
    	CakePlugin::loadAll(); // Loads all plugins at once
    } else {
    	CakePlugin::load(array('Contacts', 'Galleries', 'Privileges', 'Users', 'Webpages')); // required plugins    
	}
	
	
	/**
	 * temporary convenience function for states options
	 *
	 * @todo 	delete this all together after making it db based in enumerations (but give default values)
	 */
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
	
	
	/**
	 * To add to the core cake utility Inflector
	 */
	class ZuhaInflector {
    
    /**
     * String to ASCII
     * Converts the given string to a no spaces, no special characters, no cases string
     * 
     * Tänk efter nu – förr'n vi föser dig bort BECOMES tank-efter-nu-forrn-vi-foser-dig-bort
	 * 
	 * Usage : ZuhaInflector::asciify('some string');
     * 
     * @param string $str
     * @param array $replace
     * @param string $delimiter
     * @return string
     */
        public static function asciify($str, $replace = array(), $delimiter = '-') {
            if(!empty($replace)) {
            	$str = str_replace((array)$replace, ' ', $str);
        	}
        
        	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        	$clean = strtolower(trim($clean, '-'));
        	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        
        	return $clean;
        }
	
	/**
	 * Function for formatting the pricing of an item.
	 *
	 * @todo 	Update to include the dollar sign, and decimal place for various languages. (and remove the dollar sign from the view files. Based on a setting that needs to be created yet.
	 */
		public function pricify($price) {
			if($price === NULL) {
				return NULL;
			} else {
				return number_format($price, 2, '.', ',');
			}
		}
	
	/**
	 * Function for formatting the pricing of an item.
	 *
	 * @todo 	Update to include the dollar sign, and decimal place for various languages. (and remove the dollar sign from the view files. Based on a setting that needs to be created yet.
	 */
		public function datify($date) {
			if($date === NULL) {
				return NULL;
			} else {
				return date('M j, Y', strtotime($date));
			}
		}
	
	/**
	 * Function for formatting dates (yes I know about the Time helper, and I don't like it.
	 * But mainly this will alos allow a default time format on a per site need (using a setting).
	 *
	 * @todo	Have options for the time, like timeAgo and/or date format string.
	 */
		public function dateize($date, $options = null) {
			return date('M j, Y', strtotime($date));
		}
	
	
	/**
	 * return a plugin name from a controller name
	 *
	 * @todo There must be a better way...
	 */
		public function pluginize($name) {
			# list of models and controllers to rename to the corresponding plugin
			$name = Inflector::singularize(Inflector::camelize($name));
			
			$allowed = array(
				'Aco' => false,
				'Activity' => 'Activities',
				'AffiliateEarning' => 'Affiliates',
				'Affiliated' => 'Affiliates',
				'Affiliate' => 'Affiliates',
				'Alias' => false,
				'Aro' => false,
				'ArosAco' => false,
				'Banner' => 'Banners',
				'BannerView' => 'Banners',
				'BannerPosition' => 'Banners',
				'BlogPost' => 'Blogs',
				'Blog' => 'Blogs',
				'CatalogItemBrand' => 'Catalogs',
				'CatalogItemPrice' => 'Catalogs',
				'CatalogItem' => 'Catalogs',
				'CatalogItemsRelationship' => 'Catalogs',
				'Catalog' => 'Catalogs',
				'Category' => 'Categories',
				'Categorized' => 'Categories',
				'CategorizedOption' => 'Categories',
				'CategoryOption' => 'Categories',
				'Comment' => 'Comments',
				'Condition' => false,
				'Connection' => 'Connections',
				'ContactAddress' => 'Contacts',
				'ContactDetail' => 'Contacts',
				'Contact' => 'Contacts',
				'ContactsContact' => 'Contacts',
				'Coupon' => 'Coupons',
				'Credit' => 'Credits',
				'Draft' => 'Drafts',
				'Enumeration' => false,
				'EstimateItem' => 'Estimates',
				'Estimated' => 'Estimates',
				'Estimate' => 'Estimates',	
				'EventSchedule' => 'Events',
				'EventSeat' => 'Events',
				'EventVenue' => 'Events',
				'Event' => 'Events',
				'EventsGuest' => 'Events',
				'Facebook' => 'Facebook',
				'Faq' => 'Faqs',
				'Favorite' => 'Favorites',
				'FormFieldset' => 'Forms',
				'FormInput' => 'Forms',
				'FormKey' => 'Forms',		
				'Form' => 'Forms',			
				'Gallery' => 'Galleries',
				'GalleryImage' => 'Galleries',
				'Invite' => 'Invites',
				'InvoiceItem' => 'Invoices',
				'InvoiceTime' => 'Invoices',
				'Invoice' => 'Invoices',
				'Location' => 'Locations',
				'Map' => 'Maps',
				'Media' => 'Media',
				'Menu' => 'Menus',
				'Message' => 'Messages',
				'Meta' => false,
				'News' => 'News',
				'NotificationTemplate' => 'Notifications',
				'Notification' => 'Notifications',
				'OrderCoupon' => 'Orders',
				'OrderItem' => 'Orders',
				'OrderPayment' => 'Orders',
				'OrderShipment' => 'Orders',
				'OrderTransaction' => 'Orders',
                'Privilege' => 'Privilege',
                'ProductBrand' => 'Products',
                'ProductPrice' => 'Products',
                'ProductOption' => 'Products',
                'ProductsProductOption' => 'Products',
                'ProductStore' => 'Products',
                'Product' => 'Products',
				'ProjectIssue' => 'Projects',
				'Project' => 'Projects',
				'ProjectsMember' => 'Projects',
				'ProjectsWatcher' => 'Projects',
				'ProjectsWiki' => 'Projects',
				'Rating' => 'Ratings',
				'Recaptcha' => 'Recaptcha',
				'Record' => 'Records',
				'Searchable' => 'Searchable',
				'Setting' => false,
				'Tagged' => 'Tags',
				'Tag' => 'Tags',
				'Task' => 'Tasks',
				'TicketDepartmentsAssignee' => 'Tickets',
				'Ticket' => 'Tickets',
				'TimesheetTime' => 'Timesheets',
				'Timesheet' => 'Timesheets',
				'TimesheetsTimesheetTime' => 'Timesheets',
				'Transaction' => 'Transactions',
				'TransactionAddress' => 'Transactions',
				'TransactionCoupon' => 'Transactions',
				'TransactionItem' => 'Transactions',
				'TransactionPayment' => 'Transactions',
				'TransactionShipment' => 'Transactions',
				'Twitter' => 'Twitter',
				'Used' => 'Users',
				'UserConnect' => 'Users',
				'UserFollower' => 'Users',
				'UserGroupWallPost' => 'Users',
				'UserGroup' => 'Users',
				'UserRole' => 'Users',
				'UserStatus' => 'Users',
				'UserWall' => 'Users',
				'User' => 'Users',
				'UsersUserGroup' => 'Users',
				'Util' => 'Utils',
				'Utils' => 'Utils',
				'WebpageCss' => 'Webpages',
				'WebpageMenu' => 'Webpages',
				'WebpageMenuItem' => 'Webpages',
				'WebpageJ' => 'Webpages',
				'WebpageJse' => 'Webpages',
				'Webpage' => 'Webpages',
				'WebpageReport' => 'Webpages',
				'WikiContentVersion' => 'Wikis',
				'WikiContent' => 'Wikis',
				'WikiPage' => 'Wikis',
				'Wiki' => 'Wikis',
				'WorkflowEvent' => 'Workflows',
				'WorkflowItemEvent' => 'Workflows',
				'WorkflowItem' => 'Workflows',
				'Workflow' => 'Workflows',
				
				// 
				
				'Question' => 'Questions',
				'QuestionAnswer' => 'Questions',
				);
			if (!empty($name) && $allowed[$name] !== null) {
				return $allowed[$name];
			} else {
				return Inflector::tableize($name);
			}
		}
        
        /**
         * invalidate method
         * 
         * parse the function $Model->invalidFields() into a string
         * 
         * @param type $invalidFields
         */
        public function invalidate($invalidField = array()) {
            $one = key($invalidField);
            $two = key($invalidField[$one]);
            $return = '';
            $three = is_array($invalidField[$one][$two]) ? $invalidField[$one][$two][0] : null;
            if ($three) {
                $four = Configure::read('debug') > 0 ? __('(Debugger field : %s.%s)', $one, $two) : '';
                $return .= __('%s', $three);
            } else {
                $four = Configure::read('debug') > 0 ? __('(Debugger field : CurrentModel.%s)', $one) : '';
                $return .= __('%s', $invalidField[$one][0]);
            }
            
            return __('%s %s', $return, $four);
        }
        
	} // end ZuhaInflector class

} // end bootstrap overwrite check
