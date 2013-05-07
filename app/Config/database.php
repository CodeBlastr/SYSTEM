<?php	
if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php')) {
		
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php');
	
} else if ((defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS)) && @Configure::read(Install) !== true) {
	echo 'No database.php file in the site/'.SITE_DIR.'/Config directory.';
	break;
	
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
