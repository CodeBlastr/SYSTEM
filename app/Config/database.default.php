<?php
if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php')) {
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php');
} else {

	class DATABASE_CONFIG {
	
		public $default = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => '',
			'login' => '',
			'password' => '',
			'database' => '',
			'prefix' => '',
			//'encoding' => 'utf8',
		);

		public $test = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => '',
			'login' => '',
			'password' => '',
			'database' => '',
			'prefix' => '',
			//'encoding' => 'utf8',
		);
		
		public $install = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => $this->host,
			'login' => $this->login,
			'password' => $this->password,
			'database' => $this->database,
			'prefix' => '',
			//'encoding' => 'utf8',
		);
	}
	
}