<?php
if (file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php')) :
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php');
else : 

	class DATABASE_CONFIG {
	
		public $default = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => 'mysql.92rm.com',
			'login' => 'root',
			'password' => '',
			'database' => 'live_razorit',
			'prefix' => '',
			//'encoding' => 'utf8',
		);

		public $test = array(
			'datasource' => 'Database/Mysql',
			'persistent' => false,
			'host' => 'localhost',
			'login' => 'user',
			'password' => 'password',
			'database' => 'test_database_name',
			'prefix' => '',
			//'encoding' => 'utf8',
		);
	}

	#used to add an extra level of security to certain settings
	#Configure::write('Security.iniSalt', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

endif;