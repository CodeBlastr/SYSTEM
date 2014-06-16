<?php
/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
 	$debugger = isset($_GET['debugger']) ? $_GET['debugger'] : 0;
	Configure::write('debug', $debugger);
	Configure::write('Config.language', 'en');

/**
 * Session configuration.
 *
 */
	Configure::write('Session', array(
		'defaults' => 'php'
	));

/**
 * The level of CakePHP security.
 */
	Configure::write('Security.level', 'medium');

/**
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', 'DYxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxmi');

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
	Configure::write('Security.cipherSeed', '3911111111111111111111111111113');

/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a querystring parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps when debug > 0. Set to 'force' to always enable
 * timestamping regardless of debug value.
 */
	//Configure::write('Asset.timestamp', true);
/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');

/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
