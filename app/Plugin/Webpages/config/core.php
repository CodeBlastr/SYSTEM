<?php 
class WebpagesConfig {

	/**
	 * Current version: [insert url here]
	 *
	 * @access public
	 * @var string
	 */
	var $version = '0.06';

	/**
	 * Settings.
	 *
	 * @access public
	 * @var array
	 */
	var $settings = array();

	/**
	 * Singleton Instance.
	 *
	 * @access private
	 * @var array
	 * @static
	 */
	private static $__instance;

	
	/**
	 * Load the settings from the ini file.
	 *
	 * @access private
	 * @return void
	 */
	function __construct() {
		if (empty($this->settings)) {
			if (defined('__WEBPAGES_SETTINGS_PATH')) {
				$settingsPath = APP_DIR.__WEBPAGES_SETTINGS_PATH;
			} else {
				define('__WEBPAGES_SETTINGS_PATH', dirname(__FILE__) . DS);
				$settingsPath = __WEBPAGES_SETTINGS_PATH;
			}
			$this->settings = __setConstants($settingsPath, true);
		}
	}

	/**
	 * Grab the current object instance.
	 * 
	 * @access public
	 * @return object
	 * @static
	 */
	public static function getInstance() {
		if (empty(self::$__instance)) {
			self::$__instance = new WebpagesConfig();
		}
		
		return self::$__instance;
	}

}
