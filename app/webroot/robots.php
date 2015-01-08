<?php
header("Content-Type:text/plain");
// it's a little hacky here, but we need to do this dyanmically before the actual app loads
require_once('../../sites/bootstrap.php'); 
$siteDir = str_replace('DS', '/', SITE_DIR);
if (!empty($siteDir)) {
	$file = '../../' . $siteDir . '/Locale/View/webroot/robots.txt';
	if (file_exists($file)) {
		$robots = file_get_contents($file);
	}
}
if (!empty($robots) && !file_exists('../../.stage')) {
	echo $robots;
} else {
	// block all by default (note during install a non-blocking robots.txt file is installed)
	echo "User-agent: *\n";
	echo "Disallow: /";
}
