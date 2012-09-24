<?php
if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php')) {
	require_once(ROOT.DS.SITE_DIR.DS.'Config'.DS.'database.php');
} else if (defined('SITE_DIR') && file_exists(ROOT.DS.SITE_DIR.DS.'Config'.DS)) {
	echo 'No database.php file in the site/'.SITE_DIR.'/Config directory.';
	break;
} 