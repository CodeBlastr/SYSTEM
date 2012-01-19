<?php
/* Setting Fixture generated on: 2012-01-13 13:25:58 : 1326461158 */

/**
 * SettingFixture
 *
 */
class SettingFixture extends CakeTestFixture {
/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'Setting', 'connection' => 'test');


/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '4',
			'type' => 'System',
			'name' => 'ZUHA_DB_VERSION',
			'value' => '0.016',
			'description' => '',
			'plugin' => '',
			'model' => '',
			'created' => '2011-01-17 01:33:28',
			'modified' => '2011-12-31 18:29:38'
		),
		array(
			'id' => '5',
			'type' => 'System',
			'name' => 'GUESTS_USER_ROLE_ID',
			'value' => '5',
			'description' => '',
			'plugin' => '',
			'model' => '',
			'created' => '2011-01-17 01:33:57',
			'modified' => '2011-01-17 01:33:57'
		),
		array(
			'id' => '19',
			'type' => 'Orders',
			'name' => 'SHIP_DROP_OFF_TYPE',
			'value' => 'REGULARPICKUP',
			'description' => '',
			'plugin' => '',
			'model' => '',
			'created' => '2011-03-28 02:42:38',
			'modified' => '2011-03-28 02:42:38'
		),
		array(
			'id' => '20',
			'type' => 'Orders',
			'name' => 'SHIP_SERVICE',
			'value' => 'GROUNDHOMEDELIVERY',
			'description' => '',
			'plugin' => '',
			'model' => '',
			'created' => '2011-03-28 02:44:37',
			'modified' => '2011-03-28 02:44:37'
		),
		array(
			'id' => '21',
			'type' => 'App',
			'name' => 'TEMPLATES',
			'value' => 'template[5] = "eJw9jtsKgkAURf/lfMHMeMGO+FAYZSldNN8HHMGYMGfGUKJ/z0kJDuzFfjhrc3TxrZESBCMeT8mNSCoIpwbBs7lCaHQsat5Ls/TEpovQK6kt+gwBxGFITXwknfZJpta9uSejKZOuIKTLt8M5rfg+C9rxFrxoUeel2ulNyoJTcokiWES9FuraSvH76k0Gbtc1SGYvhbBBOjOzzGZ2LDv/zZ/pvlpHPqE="
template[6] = "eJw9jUsKgDAMRO+SE7T1A45bN269QcEIhYrSz0q8u40VQ2Aekxli0eKK0AqUeD+9TTyvNBYH1IsOIBcn3mz26fO1aAvKwUdBAypTszlyWA7P76ErISsPHNRfddCVjbCp3Ag3lTsa77IPavIqew=="
',
			'description' => '',
			'plugin' => NULL,
			'model' => NULL,
			'created' => '2011-06-24 03:55:29',
			'modified' => '2011-12-14 15:30:54'
		),
		array(
			'id' => '22',
			'type' => 'Webpages',
			'name' => 'DEFAULT_CSS_FILENAMES',
			'value' => 'all[] = all
all[] = temp
',
			'description' => '',
			'plugin' => NULL,
			'model' => NULL,
			'created' => '2011-06-24 15:33:34',
			'modified' => '2011-10-26 21:16:16'
		),
		array(
			'id' => '23',
			'type' => 'Orders',
			'name' => 'DEFAULT_PAYMENT',
			'value' => 'AUTHORIZE',
			'description' => 'Defines default payment option for the site. 

Example value : 
AUTHORIZE',
			'plugin' => NULL,
			'model' => NULL,
			'created' => '2011-07-14 15:38:59',
			'modified' => '2011-08-09 18:07:30'
		),
		array(
			'id' => '24',
			'type' => 'Orders',
			'name' => 'ENABLE_PAYMENT_OPTIONS',
			'value' => 'AUTHORIZE = "Visa/Mastercard/Amex/Discover"',
			'description' => 'Defines the options which should be shown	in the dropdown of payment mode for the app. 

Example value : 
AUTHORIZE = Authorize
AUTHORIZEONLY = "Authorize Only"
PAYPAL = Paypal
CREDIT= Credit',
			'plugin' => NULL,
			'model' => NULL,
			'created' => '2011-07-14 15:57:09',
			'modified' => '2011-08-09 18:09:22'
		),
		array(
			'id' => '32',
			'type' => 'Reports',
			'name' => 'ANALYTICS',
			'value' => 'setAccount = UA-999993-1
setDomainName = .babyriddle.com',
			'description' => 'Defines the Google Analytics information for tracking traffic and displaying reports.

Example value : 
setAccount = UA-999999-9
setDomainName = .domain.com
userName = google@account-login.com
password = mySecurePassword',
			'plugin' => NULL,
			'model' => NULL,
			'created' => '2011-07-25 09:39:46',
			'modified' => '2011-07-25 09:39:46'
		),
		array(
			'id' => '35',
			'type' => 'Orders',
			'name' => 'ENABLE_SHIPPING',
			'value' => 'true',
			'description' => 'Defines the shipping option Enable/Disable for the site.

Example value : 
false',
			'plugin' => NULL,
			'model' => NULL,
			'created' => '2011-08-03 21:55:28',
			'modified' => '2011-08-03 21:55:28'
		),
	);
}
