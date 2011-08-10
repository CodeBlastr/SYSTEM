<?php
/**
 * Settings Model
 *
 * This database table contains all of the settings for the site, but its important to note that it is never called on by the application.  Instead every time you create or edit a setting, it updates a static file in the config folder called settings.ini.  This is done to make performance fast, even with hundreds of settings. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.models
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Make it so that we list all of the settings available, and only if they have a value do we write it to the ini file. 
 */
class Setting extends AppModel {

	var $name = 'Setting';
	// instead of storing available settings in a database we store all of the available settings here
	var $names = array();
	

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'SettingType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'type_id',
			'conditions' => array('SettingType.type' => 'SETTING_TYPE'),
			'fields' => '',
			'order' => ''
		)
	);
	
	
	function __construct() {
		parent::__construct();
		$this->names = array(
				  'System' => array(
						array(
							'name' => 'GUESTS_USER_ROLE_ID',
							'description' => 'Defines the user role the system should use for guest access. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'5',
							),
						array(
							'name' => 'SMTP',
							'description' => 'Defines email configuration settings so that sending email is possible. Please note that these values will be encrypted during entry, and cannot be retrieved.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'smtpUsername = xyz@example.com'.PHP_EOL.'smtpPassword = "XXXXXXX"'.PHP_EOL.'smtpHost = smtp.example.com'.PHP_EOL.'smtpPort = XXX'.PHP_EOL.'from = myemail@example.com'.PHP_EOL.'fromName = "My Name"',
							),
						array(
							'name' => 'ZUHA_DB_VERSION ',
							'description' => 'Defines the current version of the database.  Used to determine if an upgrade is needed. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'0.0123',
							),
						),
				  'Orders' => array(
						array(
							'name' => 'DEFAULT_PAYMENT',
							'description' => 'Defines default payment option for the site. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'AUTHORIZE',
							),
						array(
							'name' => 'ENABLE_PAYMENT_OPTIONS',
							'description' => 'Defines the options which should be shown	in the dropdown of payment mode for the app. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'AUTHORIZE = Authorize'.PHP_EOL.'AUTHORIZEONLY = "Authorize Only"'.PHP_EOL.'PAYPAL = Paypal'.PHP_EOL.'CREDIT= Credit',
							),
						array(
							'name' => 'TRANSACTIONS_AUTHORIZENET_LOGIN_ID',
							'description' => 'Defines the login to access payment api of Authorize.net. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'463h3f98f4u89',
							),
						array(
							'name' => 'TRANSACTIONS_AUTHORIZENET_TRANSACTION_KEY',
							'description' => 'Defines the transaction key to access payment api of Authorize.net. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'48fj0j2389ur02983ur',
							),
						array(
							'name' => 'PAYPAL',
							'description' => 'Defines the credentials to Access Paypal Payment PRO : https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-api-add-direct-access.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'API_USERNAME = webpro_126328478_biz_api1.example.com'.PHP_EOL.'API_PASSWORD = 9294399233'.PHP_EOL.'API_SIGNATURE = ApJtg.JrUW0YLN.tPmmGiu-exM.va778w7f873mX29QghYJnTf'.PHP_EOL.'API_ENDPOINT = https://api-3t.sandbox.paypal.com/nvp'.PHP_EOL.'PROXY_HOST = 127.0.0.1'.PHP_EOL.'PROXY_PORT = 808'.PHP_EOL.'PAYPAL_URL = "https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token="'.PHP_EOL.'VERSION  = 51.0'.PHP_EOL.'USE_PROXY = "FALSE"',
							),
						array(
							'name' => 'PAYPAL_ADAPTIVE',
							'description' => 'Defines the credentials to Access payment api of Paypal for Adaptive payment methods.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'API_USERNAME = pro2_1306331130_biz_api1.enbake.com'.PHP_EOL.'API_PASSWORD = 1306331152'.PHP_EOL.'API_SIGNATURE = A8p31ikyPTksXuHA3gAY-vp4j5.uAaEj4E89F8jscaqMIfjpaXVNe4cJ'.PHP_EOL.'API_ENDPOINT = https://svcs.sandbox.paypal.com/AdaptivePayments'.PHP_EOL.'PROXY_HOST = 127.0.0.1'.PHP_EOL.'PROXY_PORT = 808'.PHP_EOL.'PAYPAL_URL = "https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token="'.PHP_EOL.'VERSION  = 51.0'.PHP_EOL.'USE_PROXY = "FALSE"',
							),	
						array(
							'name' => 'CHAINED_PAYMENT',
							'description' => 'Defines the values to Access chained payment of Paypal.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'returnUrl = "http://dealpops.zuha.com"'.PHP_EOL.'cancelUrl = "http://dealpops.zuha.com"'.PHP_EOL.'receiverPrimaryArray[] = ""'.PHP_EOL.'receiverInvoiceIdArray[] = ""'.PHP_EOL.'feesPayer = ""'.PHP_EOL.'ipnNotificationUrl = ""'.PHP_EOL.'memo = ""'.PHP_EOL.'pin = ""'.PHP_EOL.'preapprovalKey = ""'.PHP_EOL.'reverseAllParallelPaymentsOnError = ""'.PHP_EOL.'senderEmail = "pro2_1306331130_biz@enbake.com"',
							),
						array(
							'name' => 'LOCATIONS',
							'description' => 'Defines the users to whom the payment should divided using chained payment.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'syracuse[] =  40,syracuse@example.com'.PHP_EOL.'syracuse[] = 40,adagency@example.com',
							),
						array(
							'name' => 'ENABLE_SHIPPING',
							'description' => 'Defines the shipping option Enable/Disable for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'false',
							),
						array(
							'name' => 'SHIPPING_FEDEX_USER_CREDENTIAL',
							'description' => 'Defines the shipping fedex user credentials for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'UserCredential["Key"] = "BWw8o4cRu1z7NZZU"'.PHP_EOL.'UserCredential["Password"] = "CjV3icwSEDDpgFiTFweIkaEAc"',
							),
						array(
							'name' => 'SHIPPING_FEDEX_CLIENT_DETAIL',
							'description' => 'Defines the shipping fedex client credentials for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'AccountNumber = "510087585"'.PHP_EOL.'MeterNumber = "100061554"',
							),
						array(
							'name' => 'SHIPPING_FEDEX_VERSION',
							'description' => 'Defines the shipping fedex version.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'ServiceId = "crs"'.PHP_EOL.'Major = 9'.PHP_EOL.'Intermediate = 0'.PHP_EOL.'Minor = 0',
							),
						array(
							'name' => 'SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER',
							'description' => 'Defines the shipping fedex default ship from address for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'Address["City"] = ""'.PHP_EOL.'Address["StateOrProvinceCode"] = "CA"'.PHP_EOL.'Address["PostalCode"] = "95451"'.PHP_EOL.'Address["CountryCode"] = "US"',
							),
						array(
							'name' => 'SHIPPING_FEDEX_REQUESTED_SHIPMENT',
							'description' => 'Defines the shipping fedex settings for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'DropoffType = REGULAR_PICKUP'.PHP_EOL.'ServiceType = FEDEX_GROUND'.PHP_EOL.'PackagingType = YOUR_PACKAGING'.PHP_EOL.'RateRequestTypes = ACCOUNT'.PHP_EOL.'RateRequestTypes = LIST'.PHP_EOL.'PackageDetail = INDIVIDUAL_PACKAGES',
							),
						array(
							'name' => 'SHIPPING_FEDEX_WEIGHT_UNIT',
							'description' => 'Defines the shipping fedex weight unit for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'LB',
							),
						array(
							'name' => 'SHIPPING_FEDEX_DIMENSIONS_UNIT',
							'description' => 'Defines the shipping fedex dimension unit for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'IN',
							),
						array(
							'name' => 'SHIPPING_FEDEX_DEFAULT_WEIGHT',
							'description' => 'Defines the shipping fedex default weight if the weight is not givven for item for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'2.0',
							),				
						array(
							'name' => 'FEDEX',
							'description' => 'Define Enabled Shipping Service options the following variable defines the options which should be display	in the dropdown of shipping type for the app.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'GROUNDHOMEDELIVERY = STANDARD'.PHP_EOL.'INTERNATIONALFIRST = "INTERNATIONAL FLAT FEE"'.PHP_EOL.'FEDEX1DAYFREIGHT = "NEXT DAY"',
							),
						),
				  'App' => array(
						array(
							'name' => 'DEFAULT_USER_REGISTRATION_ROLE_ID',
							'description' => 'Defines the role users will be assigned by default when they register as a new users at yourdomain.com/users/users/register.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'3',
							),
						array(
							'name' => 'DEFAULT_LOGIN_ERROR_MESSAGE',
							'description' => 'Defines the message visitors see if they are not logged in and reach a restricted page. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'"Please become a registered user to access that feature."',
							),
						array(
							'name' => 'TEMPLATES',
							'description' => 'Defines which user roles and urls templates will be used at. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'template[] = A Serialized Array : You must use the template edit pages to set',
							),
						array(
							'name' => 'LOAD_APP_HELPERS',
							'description' => 'Defines which helpers should be loaded and when they should be loaded. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'Menu',
							),
						array(
							'name' => 'LOGIN_REDIRECT_URL',
							'description' => 'Defines the url users go to after logging in. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'/tickets/tickets/add/',
							),
						array(
							'name' => 'LOGOUT_REDIRECT_URL',
							'description' => 'Defines the url users go to after logging out. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'/goodbye/',
							),
						array(
							'name' => 'REGISTRATION_EMAIL_VERIFICATION',
							'description' => 'Defines whether registration requires email verification before the account is approved. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'anything (If this setting exists at all, then verification is required.)',
							),
						array(
							'name' => 'DEFAULT_LOGIN_REDIRECT_URL',
							'description' => 'Defines the url users go to after logging in. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'/members/members/is_member/',
							),
						array(
							'name' => 'MEMBERSHIP_CATALOG_ITEM_REDIRECT',
							'description' => 'Defines the url for new regiter members to choose a membership plan. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'/catalogs/catalog_items/view/48',
							),
						array(
							'name' => 'DEFAULT_TEMPLATE_ID',
							'description' => 'Defines the settings for default site templates. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'1',
							),		
						),	
				  'Reports' => array(
						array(
							'name' => 'ANALYTICS',
							'description' => 'Defines the Google Analytics information for tracking traffic and displaying reports.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'setAccount = UA-999999-9'.PHP_EOL.'setDomainName = .domain.com'.PHP_EOL.'userName = google@account-login.com'.PHP_EOL.'password = mySecurePassword',
							),
						),
				  'Gallery' => array(
						array(
							'name' => 'DEFAULT_TYPE', 
							'description' => 'Defines the type of gallery used if no other is specified.'.PHP_EOL.PHP_EOL.'Example value: '.PHP_EOL.'gallerific',
							),
						array(
							'name' => 'DEFAULT_THUMB_WIDTH',
							'description' => 'Defines the medium thumbnail width in pixels.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'120',
							),
						array(
							'name' => 'DEFAULT_THUMB_HEIGHT',
							'description' => 'Defines the medium thumbnail height in pixels.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'90',
							),
						array(
							'name' => 'IMAGE_DEFAULT_THUMB_WIDTH',
							'description' => 'Defines the small thumbnail width in pixels.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'50',
							),
						array(
							'name' => 'IMAGE_DEFAULT_THUMB_HEIGHT',
							'description' => 'Defines the small thumbnail height in pixels.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'50',
							),
						array(
							'name' => 'IMAGE_DEFAULT_FULL_WIDTH',
							'description' => 'Defines the full size image width in pixels.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'50',
							),
						array(
							'name' => 'IMAGE_DEFAULT_FULL_HEIGHT',
							'description' => 'Defines the full size image height in pixels.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'50',
							),
						array(
							'name' => 'RESIZE_OR_CROP',
							'description' => 'Defines whether images will be resized or cropped when uploaded.  Resize is the default.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'crop',
							),

						),
				  'Element' => array(
						array(
							'name' => 'PROJECTS_MOST_WATCHED',
							'description' => 'Defines setting variables for the most watched module.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'moduleTitle = "My Custom Title"'.PHP_EOL.'numberOfProjects = 5',
							),
						),
				  'Users' => array(
						array(
							'name' => 'PAID_EXPIRED_ROLE_ID',
							'description' => 'Defines setting variables for the expired user role id.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'3',
							),
						array(
							'name' => 'PAID_ROLE_ID',
							'description' => 'Defines setting variables for the paid user role id.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'1',
							),
						array(
							'name' => 'PAID_ROLE_REDIRECT',
							'description' => 'Defines setting variables for the paid user role redirect.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'/users/users/my',
							),		
						),		
				  );
	}
	
/**
 * Handles the saving of settings data to the settings.ini file
 *
 * @param {data}		An array contain the setting data
 * @param {bool}		If set to true, it will add to the value instead of replace.
 * @return {bool}		True if the settings were saved and the file was created.
 */
	function add($data, $append = false) {
		$data = $this->_cleanSettingData($data, $append);
		# save the data
		if ($this->save($data)) {
			# call all settings and write the ini file
			if($this->writeSettingsIniData()) {
				return true;
			} else {
				# roll back
				$this->delete($this->id);
				return false;
			}
		}
	}
	
	
/**
 * This function sets up the data from the settings table so that it will write a whole new file each time a setting is saved.
 *
 * return {string}		A string of data used to write to the settings.ini file.
 */
	function prepareSettingsIniData() {
		$settings = $this->find('all', array(
			'contain' => 'SettingType'
			));
		$writeData = '; Do not edit this file, instead go to /admin/settings and edit or add settings'.PHP_EOL.PHP_EOL;
		foreach ($settings as $setting) {
			if (strpos($setting['Setting']['value'], '=')) {
				$holdSettings[] = $setting;
			} else {
				$writeData .= '__';
				$writeData .= strtoupper($setting['SettingType']['name']);
				$writeData .= '_';
				$writeData .= strtoupper($setting['Setting']['name']);
				$writeData .= ' = ';
				$writeData .= $setting['Setting']['value'];
				$writeData .= PHP_EOL;
			}
		}
		
		$writeData .= !empty($holdSettings) ? $this->finishIniData($holdSettings) : '';
		return $writeData;
	}
	
/**
 * We need to make sure that ini sections appear after all straight values in the ini file
 */
 	function finishIniData($settings) {
		$writeData = '';
		foreach ($settings as $setting) {
			$writeData .= PHP_EOL.'[__';
			$writeData .= strtoupper($setting['SettingType']['name']);
			$writeData .= '_';
			$writeData .= strtoupper($setting['Setting']['name']).']'.PHP_EOL;
			$writeData .= $setting['Setting']['value'];
			$writeData .= PHP_EOL.PHP_EOL;
		}
		return $writeData;
	}
	
	
/**
 * This function sets up the data from the settings table so that it will write a whole new file each time a setting is saved.
 *
 * return {string}		A string of data used to write to the settings.ini file.
 */
	function writeSettingsIniData() {
		# move this inside of the save fi statement 
		App::import('Core', 'File');
		$file = new File(CONFIGS.'settings.ini');
		#$file->path = CONFIGS.'settings.ini';
		$writeData = $this->prepareSettingsIniData();
		if($file->write($file->prepare($writeData))) {
			if($this->writeDefaultsIniData()) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	

/**
 * This function writes the defaults.ini file, assuming that it is because the settings.ini has been fully upgraded to the latest version. 
 *
 * return {string}		A string of data used to write to the settings.ini file.
 */
	function writeDefaultsIniData() {
		# move this inside of the save fi statement 
		App::import('Core', 'File');
		$file = new File(CONFIGS.'defaults.ini');
		#$file->path = CONFIGS.'settings.ini';
		$writeData = $this->prepareSettingsIniData();
		if($file->write($file->prepare($writeData))) {
			return true;
		} else {
			return false;
		}
	}
	
	
/**
 * Checks whether the setting already exists and cleans the data array if it does.
 * This is used mainly by outside of the model functions which don't know if the Setting exists or not.
 *
 * @param {array}		An array of Setting data
 */
	function _cleanSettingData($data, $append = false){
		#look up the type_id, if it isn't already set
		if (empty($data['Setting']['type_id'])) {
			$settingType = $this->SettingType->find('first', array(
				'conditions' => array(
					'SettingType.name' => $data['Setting']['typeName'],
					'SettingType.type' => 'SETTING_TYPE',
					),
				));
			# set the type id into the data array
			$data['Setting']['type_id'] = $settingType['SettingType']['id'];
		} 
		
		# see if the setting already exists
		$setting = $this->find('first', array(
			'conditions' => array(
				'Setting.name' => $data['Setting']['name'],
				'Setting.type_id' => $data['Setting']['type_id'],
				),
			));
		if(!empty($setting)) {
			# if it does, then set the id, so that we over write instead of creating a new setting
			$data['Setting']['id'] = $setting['Setting']['id'];
		}
		
		if (!empty($append) && !empty($setting)) {
			$data['Setting']['value'] = $setting['Setting']['value'].PHP_EOL.$data['Setting']['value'];
		}
		
		// some values need to be encrypted.  We do that here (@todo put this in its own two functions.  One for "encode" function, and one for which settings should be encoded, so that we can specify all settings which need encryption, and reuse this instead of the if (xxxx setting) thing.  And make the corresponding decode() function somehwere as well. 
		if ($data['Setting']['name'] == 'SMTP' && !parse_ini_string($data['Setting']['name'])) :
			$data['Setting']['value'] = 'smtp = "'.base64_encode(Security::cipher($data['Setting']['value'], Configure::read('Security.iniSalt'))).'"';
			#$data['Setting']['value'] = 'smtp = "'.base64_encode(gzcompress($data['Setting']['value'])).'"';
			#$data['Setting']['value'] = base64_decode($data['Setting']['value']);
			#$data['Setting']['value'] = Security::cipher($data['Setting']['value'], Configure::read('Security.iniSalt'));
		endif;
		return $data;
	}
	
	
	/** 
	 * All of the system settings possible belong here.
	 *
	 * @todo 	We need to do a much better grouping of these setting names. Settings which need to be set together should not have different constants used.  Instead they should have different values which are sub values to the constant.
	 */
	function getNames($typeId = null) {
		if (!empty($typeId)) {
			$preFix = enum($typeId);
			return $this->names[$preFix[$typeId]];
		}
	
		/* This is a really helpful piece of code, but I don't know where to put it for reuse
		 * because the $this part doesn't work in global.php.  I mean I know we could pass the 
		 * model over to it and import, I just didn't have time today.
		 * It prints out the last query run.
   		$dbo = $this->getDatasource();
	    $logs = $dbo->_queriesLog;
    	debug(end($logs)); */
	}
	
	
	/**
	 * Return the description for a particular setting
	 *
	 * @param {string}		A string of the setting type 
	 * @param {string}		A string containing the setting name
	 */
	function getDescription($typeName, $name) {
		foreach ($this->names[$typeName] as $setting) {
			if ($setting['name'] == $name) {
				$description = $setting['description'];
			}
		}
		return $description;
	}
}
?>