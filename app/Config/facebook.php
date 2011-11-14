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
	  	'appId' => '315141015179110',
	    'apiKey' => '315141015179110',
	    'secret' => 'd478fd08b4096607dc68d8b803fc9ef5',
	    'cookie' => true,
	  )
	);
endif; // todo: arpan: move over to settings