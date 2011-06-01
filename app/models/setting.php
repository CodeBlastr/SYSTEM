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
 * @link          http://zuha.com Zuha™ Project
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
							'description' => 'Defines the credentials to Access payment api of Paypal.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'API_USERNAME = webpro_126328478_biz_api1.example.com'.PHP_EOL.'API_PASSWORD = 9294399233'.PHP_EOL.'API_SIGNATURE = ApJtg.JrUW0YLN.tPmmGiu-exM.va778w7f873mX29QghYJnTf'.PHP_EOL.'API_ENDPOINT = https://api-3t.sandbox.paypal.com/nvp'.PHP_EOL.'PROXY_HOST = 127.0.0.1'.PHP_EOL.'PROXY_PORT = 808'.PHP_EOL.'PAYPAL_URL = "https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token="'.PHP_EOL.'VERSION  = 51.0'.PHP_EOL.'USE_PROXY = "FALSE"',
							),
						array(
							'name' => 'ENABLE_SHIPPING',
							'description' => 'Defines the shipping option Enable/Disable for the site.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'false',
							),
						array(
							'name' => 'SHIPPING_FEDEX_ACCOUNT_NO',
							'description' => 'Defines the account number for access Fedex api for shipping.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'510087526',
							),
						array(
							'name' => 'SHIPPING_FEDEX_METER_NO',
							'description' => 'Defines the meter number to access Fedex api for shipping.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'118538458',
							),
						array(
							'name' => 'SHIP_DROP_OFF_TYPE',
							'description' => 'Defines the default shipping type, drop off type'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'REGULARPICKUP',
							),
						array(
							'name' => 'SHIP_SERVICE',
							'description' => 'Defines the default shipping service'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'GROUNDHOMEDELIVERY',
							),
						array(
							'name' => 'SHIP_FROM_STATE',
							'description' => 'Defines the from address, the shipping will calculate.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'CA',
							),
						array(
							'name' => 'SHIP_FROM_ZIP',
							'description' => 'Defines the from address, the shipping will calculate.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'95451',
							),
						array(
							'name' => 'SHIP_FROM_COUNTRY',
							'description' => 'Defines the from address, the shipping will calculate.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'US',
							),
						array(
							'name' => 'FEDEX',
							'description' => 'Define Enabled Shipping Service options the following variable defines the options which should be display	in the dropdown of shipping type for the app.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'GROUNDHOMEDELIVERY = STANDARD'.PHP_EOL.'INTERNATIONALFIRST = "INTERNATIONAL FLAT FEE"'.PHP_EOL.'FEDEX1DAYFREIGHT = "NEXT DAY"',
							),
						),
				  'App' => array(
						array(
							'name' => 'DEFAULT_LOGIN_ERROR_MESSAGE',
							'description' => 'Defines the message visitors see if they are not logged in and reach a restricted page. '.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'message = "Please become a registered user to access that feature."',
							),
						),
				  'Reports' => array(
						array(
							'name' => 'ANALYTICS',
							'description' => 'Defines the Google Analytics information for tracking traffic and displaying reports.'.PHP_EOL.PHP_EOL.'Example value : '.PHP_EOL.'setAccount = UA-999999-9'.PHP_EOL.'setDomainName = .domain.com'.PHP_EOL.'userName = google@account-login.com'.PHP_EOL.'password = mySecurePassword',
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
		
		$writeData .= $this->finishIniData($holdSettings);
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
			return true;
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