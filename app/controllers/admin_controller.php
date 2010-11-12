<?php
/**
 * Admin Dashboard Controller
 *
 * This controller will output variables used for the Admin dashboard.
 * Primarily conceived as the hub for managing the rest of the app.
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class AdminController extends AppController {

	var $name = 'Admin';
    var $uses = array();
/**
 * Loads variables from section reporting to send to the view for display. 
 *
 * Example: $this->set('topPosts', ClassRegistry::init('Post')->getTop());
 *
 * @link http://book.zuha.com/zuha-app-controllers/AdminController.html
 */
    function index () {
		$upgradesNeeded = $this->_checkIfLatestVersion();
		if (!empty($upgradesNeeded)) {
			$this->set('upgradeDB', $upgradesNeeded);
		}
		if (!empty($this->data)) {
			if($this->_upgradeDatabase($this->data)) {
				$this->Session->setFlash(__('Database Upgraded (you may still need to <a href="/admin/permissions/acores/build_acl">rebuild aco objects</a> (note : clicking this link may take a long time)', true));
			} else {
				$this->Session->setFlash(__('Invalid id for AttributeGroup', true));
			}				
		}
		
		$this->set('myVar', 'something'); 
        # $this->set('topPosts', ClassRegistry::init('Post')->getTop());
        # $this->set('recentNews', ClassRegistry::init('News')->getRecent());
        # $this->set('topEmployees', ClassRegistry::init('Employee')->getTopPerformers());
        # $this->set('topSellingProducts', ClassRegistry::init('Product')->getTopSellers());
		$this->layout = 'admin';
	}

/**
 * Upgrades the database using queries given
 * 
 * @param {queries} The queries to run
 * @return {bool}
 */
	function _upgradeDatabase($queries) {
		foreach ($queries['Query'] as $query) {
			if ($this->Setting->query($query['data'])) {
				$is_Good = true;	
			} else {
				$is_Good = false;
			}
		}
		if ($this->_updateSettingVersion() && $is_Good) {
			return true;
		} else {
			return false;
		}
	}
	

/**
 * Updates the settings table with a single uptick in the version number (goes from 0.0001 to 0.0002)
 * 
 * @todo In the future it would be good if we somehow got it to run all the update files at once, so that you didn't have to manually click the button by however many version numbers you're behind.
 * @todo We could tie this into the acos table, and have that updated as well (if necessary)
 * @return {bool}
 */
	function _updateSettingVersion() {
		App::Import('Model', 'Setting');
		$this->Setting = new Setting;
		$updateSettingVersionQuery = $this->Setting->find('first', array(
			'conditions' => array(
				'Setting.value LIKE' => '%ZUHA_DB_VERSION%',
				),
			));
		$this->data['Setting']['id'] = $updateSettingVersionQuery['Setting']['id'];
		$currentSettings = explode(';', $updateSettingVersionQuery['Setting']['value']);
		
		$this->data['Setting']['value'] = '';
		foreach ($currentSettings as $currentSetting) {
			if (!empty($currentSetting)) {
				if (strstr($currentSetting, 'ZUHA_DB_VERSION')) {
					$this->data['Setting']['value'] .= 'ZUHA_DB_VERSION:'.(__SYS_ZUHA_DB_VERSION + 0.0001).';';
				} else {
					$this->data['Setting']['value'] .= $currentSetting.';';
				}
			}
		}
		
		if ($this->Setting->save($this->data)) {
			return true;
		} else {
			return false;
		}
	}
	

/**
 * Checks to see if the the current database if up to date, and if not gets the next sql file to import
 * 
 * @return file name to import
 */
	function _checkIfLatestVersion() {
		# the directory updated sql files are stored in.
		$versionDirectory = ROOT . DS . 'version';
		# system setting for the current db version
		$databaseVersion = __SYS_ZUHA_DB_VERSION;
		# checks to see if there is a new db sql file
		$fileVersion = $this->_checkFileVersion($versionDirectory);
		if ($databaseVersion < $fileVersion) {
			# file name from file version
			$importFileName = $versionDirectory . DS . number_format(($databaseVersion + 0.0001), 4) . '.sql';
			return $this->_mysqlImport($importFileName);
		} else {
			return false;
		}
	}
	

/**
 * Gets the latest db file version by checking the /version directory for the latest sql file. Works if we always make sure that the file names are sequential, in the X.XXXX.sql format.
 * 
 * @todo For safety we should check to make sure the file name is well formatted.
 * @todo Seems there is a cake core Folder component which would make this folder reading more concise (App::Import('Core', 'File', 'Folder'); 
 * @param {versionDirectory} The queries to run
 * @return latest version number of files or false if directory is empty
 */
	function _checkFileVersion($versionDirectory) {
		# Open a known directory, and proceed to read its contents
		if (is_dir($versionDirectory)) {
		    if ($dh = opendir($versionDirectory)) {
		        while (($file = readdir($dh)) !== false) {
					$fileVersionNumber = str_replace('.sql', '', $file);
		        }
		        closedir($dh);
		    }
		}
		if (!empty($fileVersionNumber)) {
			return $fileVersionNumber;
		} else {
			return false;
		}
	}
	
/**
 * Takes a SQL file and parses it into an array of queries. Also exists in /app/webroot/install.default.php
 * 
 * @todo there is something wrong with this, because it seems like sometimes the last query in the sql file doesn't get returned in the array
 * @param {filename} the whole file name (including directory) of the sql file
 * @return latest version number of files or false if directory is empty
 */
	function _mysqlImport($filename) {
		$prefix = '';
	
		$return = false;
		$sql_start = array('INSERT', 'UPDATE', 'DELETE', 'DROP', 'GRANT', 'REVOKE', 'CREATE', 'ALTER');
		$sql_run_last = array('INSERT');
	
		if (file_exists($filename)) {
			$lines = file($filename);
			$queries = array();
			$query = '';
	
			if (is_array($lines)) {
				foreach ($lines as $line) {
					$line = trim($line);
	
					if(!preg_match("'^--'", $line)) {
						if (!trim($line)) {
							if ($query != '') {
								$first_word = trim(strtoupper(substr($query, 0, strpos($query, ' '))));
								if (in_array($first_word, $sql_start)) {
									$pos = strpos($query, '`')+1;
									$query = substr($query, 0, $pos) . $prefix . substr($query, $pos);
								}
	
								$priority = 1;
								if (in_array($first_word, $sql_run_last)) {
									$priority = 10;
								} 
	
								$queries[$priority][] = $query;
								$query = '';
							}
						} else {
							$query .= $line;
						}
					}
				}

				ksort($queries);
		
				foreach ($queries as $priority=>$to_run) {
					foreach ($to_run as $i=>$sql) {
						$sqlQueries[] = $sql;
					}
				}
				return $sqlQueries;
			}
		}
	}
}
?>