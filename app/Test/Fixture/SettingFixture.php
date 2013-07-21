<?php
/**
 * SettingFixture
 *
 */
class SettingFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string
 */
	public $name = 'Setting';
	
/**
 * Import
 *
 * @var array
 */
	public $import = array('config' => 'Setting');
	

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '00dd24cc-2c50-50c0-a96b-4cf735a3a949',
			'type' => 'System',
			'name' => 'GUESTS_USER_ROLE_ID',
			'value' => '5'
		),
		array(
			'id' => '10dd24cc-2c50-52c0-a96b-4cf745a3a949',
			'type' => 'System',
			'name' => 'LOAD_PLUGINS',
			'value' => 'plugins[] = Users
plugins[] = Webpages
plugins[] = Contacts
plugins[] = Galleries
plugins[] = Privileges
plugins[] = Activities
plugins[] = Blogs
plugins[] = Products
plugins[] = Categories
plugins[] = Comments
plugins[] = Connections
plugins[] = Credits
plugins[] = Drafts
plugins[] = Estimates
plugins[] = Forms
plugins[] = Invoices
plugins[] = Media
plugins[] = Messages
plugins[] = Transactions
plugins[] = Projects
plugins[] = Tasks
plugins[] = Timesheets
plugins[] = Workflows'
		),
		array(
			'id' => '20dd22cc-2c50-50c0-a96b-4cf735a3a949',
			'type' => 'System',
			'name' => 'SITE_NAME',
			'value' => 'Zuha Test'
		),
		array(
			'id' => '30dd22cc-2c56-50c0-a96b-4cf735a3a949',
			'type' => 'System',
			'name' => 'SMTP',
			'value' => 'K7qTTLH17Ja5XTUiHLtnNiY2i8kg0XnVvnYli5MYtZJViOL7lvlfNyoxjDQ1Myi0hiuXOIj0PGfZx3q/0RnO1bCJ6h5VTU/rMygPN5eTeNlvlOssN8qANbaOUMrl5onaNisqSPYXNzUsxNp40HnSi1Ihlog199ociufni/lEbXEOvmk6KCykhS2NI4P0KmmHiDXa7VqW6eSqtlE9ZwGmZRwuK4eILoE9nqYPKIuDK/U='
		),
		array(
			'id' => '40dd22cc-3c56-50c0-a96b-4cf735a3a949',
			'type' => 'Transactions',
			'name' => 'DEFAULT_PAYMENT',
			'value' => 'PAYSIMPLE'
		),
		array(
			'id' => '50dd22cc-2c16-50c0-a96b-4cf735a3a949',
			'type' => 'Transactions',
			'name' => 'ENABLE_PAYMENT_OPTIONS',
			'value' => 'PAYSIMPLE.CC = "Visa / Mastercard"
PAYSIMPLE.CHECK = "Echeck"'
		),
		array(
			'id' => '60dd33cc-2c16-50c0-a96b-4cf735a3a949',
			'type' => 'Transactions',
			'name' => 'PAYSIMPLE',
			'value' => 'environment = sandbox
apiUsername = APIUser66932
sharedSecret = WEg7u5wrn0213dJ86myXGoHlQApJcnLfA5uKN0e1hUhLbnxGaki6EI4KDWYQ1mFrXuGX0EeXRJ4M3HNBPCq6HNfjwBpPncMbWp2GjplQeIMAsQL0D3eGmM8IJVkGRUm0'
		),
		array(
			'id' => '70dd22cc-3c56-50c0-a96b-4cf735a3a949',
			'type' => 'App',
			'name' => 'LINK_PERMISSIONS',
			'value' => 'controller = 1,2,3,4,8762567'
		),
	);
	
}
