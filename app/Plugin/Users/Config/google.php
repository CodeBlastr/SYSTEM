<?php
class GOOGLE_DATABASE_CONFIG extends DATABASE_CONFIG {
   public $google = array(
     'driver' => '',
     'user' => ''
   );
   
   function __construct() {
		if (defined('__USERS_CONNECT_APPS')) {
			extract(__USERS_CONNECT_APPS);
			$this->googleClientId = !empty($googleClientId) ? $googleClientId : null; 
			$this->googleClientAPIKey = !empty($googleClientAPIKey) ? $googleClientAPIKey : null;
			$this->googleClientSecret = !empty($googleClientSecret) ? $googleRedirectUri : null;
			$this->googleRedirectUri = !empty($googleRedirectUri) ? $googleRedirectUri : null; 
		
			$this->twitterClientAPIKey = !empty($twitterClientAPIKey) ? $twitterClientAPIKey : null; 
			$this->twitterClientSecret = !empty($twitterClientSecret) ? $twitterClientAPIKey : null; 
		}
       // Or set the database path from here if you need to use any constants
       parent::__construct(); // check for parent::__construct() and call it if it exists
       $this->google['user'] = $this->googleClientId; // APP.'plugins'.DS.'cities'.DS.'cities.sqlite.db';
   }
} 