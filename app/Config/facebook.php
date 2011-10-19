<?php
if (file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'facebook.php')) :
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'facebook.php');
else : 
	/**
	  * Get an api_key and secret from facebook and fill in this content.
	  * save the file to app/config/facebook.php
	  */
	$config = array(
	  'Facebook' => array(
	  	'appId' => '174466695926689',
	    'apiKey' => 'e4efb82f303ae825d4828fd7ab6e7585',
	    'secret' => '743faec5dfe17b5273301458d5ac0ed9',
	    'cookie' => true,
	  )
	);
endif;