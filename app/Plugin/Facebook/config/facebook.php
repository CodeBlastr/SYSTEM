<?php
/**
  * Get an api_key and secret from facebook and fill in this content.
  * save the file to app/config/facebook.php
  */
$config = array(
  'Facebook' => array(
  	'appId' => __FACEBOOK_APP_ID,
    'apiKey' => __FACEBOOK_APP_KEY,
    'secret' => __FACEBOOK_APP_SECRET,
    'cookie' => true,
  )
);
?>