<?php
if (file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'generic_auth.php')) : // remove this line for sites/[your-site]/Config/generic_auth.php
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'generic_auth.php'); // remove this line for sites/[your-site]/Config/generic_auth.php
else : // remove this line for sites/[your-site]/Config/generic_auth.php
	$config = array('GenericAuthConfig' => array(
			"base_url" => Router::url(array(
				'controller' => 'social_auth',
				'action' => 'index'
			), true),
			"providers" => array(
				// openid providers
				"OpenID" => array("enabled" => true),
				"AOL" => array("enabled" => true),
				"Yahoo" => array(
					"enabled" => true,
					"keys" => array(
						"id" => "",
						"secret" => ""
					)
				),
				"Google_openid" => array(
					"enabled" => true,
					"wrapper" => array(
						"path" => "Providers/hybridauth-additional-providers/hybridauth-google-openid/Providers/Google.php",
						"class" => "Hybrid_Providers_Google"
					)
				),
				"Google" => array(
					'enabled' => true,
					'keys' => array(
						'id' => 'Xxxxxx-txxxxxxxxxxxxxxxxxxxxf.apps.googleusercontent.com',
						'secret' => 'sb3zxxxxxxxxxxxxxxxxxxxuw'
					),
					'contacts_param' => array('max-results' => 10000)
				),
				"Facebook" => array(
					"enabled" => true,
					"keys" => array(
						"id" => "1xxxxxxxxxxxxxxxxx52",
						"secret" => "adxxxxxxxxxxxxxxxxxxxxxxxxxxf6"
					),
					'scope' => 'email, user_about_me, user_hometown, user_photos, user_location'
				),
				"Twitter" => array(
					"enabled" => true,
					"keys" => array(
						"key" => "cECxxxxxxxxxxxxxxxxxxxxxJg",
						"secret" => "S2qxxxxxxxxxxxxxxxxxxxxxxxxxxxx0o"
					)
				),
				// windows live
				"Live" => array(
					"enabled" => true,
					"keys" => array(
						"id" => "",
						"secret" => ""
					)
				),
				"MySpace" => array(
					"enabled" => true,
					"keys" => array(
						"key" => "",
						"secret" => ""
					)
				),
				"LinkedIn" => array(
					"enabled" => true,
					"keys" => array(
						"key" => "77xxxxxxxxxxxxxxxxx8",
						"secret" => "UmxxxxxxxxxxxxxxxxxS",
						// 'not asked for' => '371xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx8' // labeled as OAuth User Token: on Linkedin
						// 'not asked for' => 'a3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxb' // labeled as OAuth User Secret: on Linkedin
					)
				),
				"Foursquare" => array(
					"enabled" => true,
					"keys" => array(
						"id" => "",
						"secret" => ""
					)
				),
			),
			// if you want to enable logging, set 'debug_mode' to true  then provide a
			// writable file by the web server on "debug_file"
			"debug_mode" => false,
			"debug_file" => ""
		));
endif; // remove this line for sites/[your-site]/Config/generic_auth.php