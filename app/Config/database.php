<?php	
if (defined('SITE_DIR')) {
	// we are in a site within the sites directory
  	if (@include(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php')) {
  	} else {
  		debug('Please create the file database.php '.SITE_DIR.'/Config/.  ');
		exit;
  	}
} else {
	class DATABASE_CONFIG {
		public $default = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => '[HOST]',
			'login' => '[LOGIN]',
			'password' => '[PASSWORD]',
			'database' => '[DBNAME]',
			'prefix' => '',
			//'encoding' => 'utf8',
		);
	}
}
