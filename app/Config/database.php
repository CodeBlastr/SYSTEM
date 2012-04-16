<?php

	class DATABASE_CONFIG {
	
		public $default = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => 'localhost',
			'login' => 'root',
			'password' => '',
			'database' => 'live_opentechcontrols',
			'prefix' => '',
			//'encoding' => 'utf8',
		);

		public $test = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => 'localhost',
			'login' => 'root',
			'password' => '',
			'database' => 'test',
			'prefix' => '',
			//'encoding' => 'utf8',
		);
	}
/**<?php
if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php')) {
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php');
} else if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS)) {
	echo 'No database.php file in the site/'.SITE_DIR.'/Config directory.';
	break;
} else {
	require_once(ROOT.DS.'sites'.DS.'example.com'.DS.'Config'.DS.'database.php');
}*/