<?php
class DATABASE_CONFIG {
	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'deneme',
		'database' => 'zuha',
	);
	
	function __construct() {
		if (file_exists('../'.WEBROOT_DIR.'/install.php')) {
			require_once ('../'.WEBROOT_DIR.'/install.php'); 
		}
	}
				
}
?>