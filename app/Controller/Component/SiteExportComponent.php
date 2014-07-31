<?php

App::uses('Component', 'Controller');

class SiteExportComponent extends Component {

	public $components = array('Session');

	public function _exportSite() {
		$tmpdir = TMP . 'backup';
		$plugins = CakePlugin::loaded();
		$includes = array();
		foreach ($plugins as $plugin) {
			$includes['app']['Plugin'][$plugin] = true;
		}
		$includes['app']['*'] = true;
		$includes['*'] = true;
		$includes['tmp'] = false;
		$includes['sites'] = false;
		$includes['vendors'] = false;
		$includes['sites.default'] = false;

		$filename = strtolower(str_replace(' ', '_', __SYSTEM_SITE_NAME));

		try {
			//Create backup directory
			mkdir($tmpdir, 0777);
			chmod($tmpdir, 0777);
			// copy root folder without sites and plugins
			$this->copyr(ROOT, $tmpdir, $includes);
			//Copy the site seperate
			$sourcefolder = basename(ROOT);
			$this->copyr(ROOT . DS . SITE_DIR, $tmpdir . DS . $sourcefolder . DS . 'sites', array('*' => true, 'Config' => array('defaults.ini' => true, 'database.php' => false, 'core.php' => true, 'settings.ini' => true), 'tmp' => false));
			//dump the database
			$db = ConnectionManager::getDataSource('default');
			$dbname = $db->config['database'];
			$dbuser = $db->config['login'];
			$dbpass = $db->config['password'];
			exec('mysql dump -u ' . $dbuser . ' -p"' . $dbpass . '" ' . $dbname . ' > ' . $tmpdir . DS . $sourcefolder . DS . $filename . '.sql');
		} catch (Exception $e) {
			$this->Session->setFlash('Error: ' . $e->getMessage(), 'flash_danger');
		}

		exec('cd ' . $tmpdir . DS . $sourcefolder . ';zip -r ' . $tmpdir . DS . $filename . '.zip *');

		try {
			$this->returnFile($tmpdir . DS . $filename . '.zip', $filename . '.zip', 'zip');
		} catch (Exception $e) {
			$this->Session->setFlash('Error: ' . $e->getMessage(), 'flash_danger');
		}

		//remove the backup folder
		exec('rm -R ' . $tmpdir);
	}

/**
 * Recursive Copy method
 *
 * Copys and entire directory tree
 * Allow you to pass an array of includes and excludes
 *
 * ex: $includes = array(
 * 		'*' => true //This makes all files not specified true
 * 		'path1' => true
 * 		'path2' => false
 * 		'path3' => array(
 * 			'subpath1' => true,
 * 			'subpath2' => false
 * 		)
 *
 * @param unknown $source
 * @param unknown $dest
 * @param string $includes
 * @throws Exception
 */
	static public function copyr($source, $dest, $includes = false) {
		if (is_array($includes)) {
			$allfiles = isset($includes['*']) ? $includes['*'] : false;
		} else {
			$allfiles = true;
		}
		// recursive function to copy
		// all subdirectories and contents:
		if (is_dir($source)) {
			$dir_handle = opendir($source);
			$sourcefolder = basename($source);
			mkdir($dest . DS . $sourcefolder, 0777, true);
			while ($file = readdir($dir_handle)) {
				if ($file != "." && $file != "..") {
					$check = false;
					if (isset($includes[$file])) {
						$check = is_array($includes[$file]) ? true : $includes[$file];
					} else {
						$check = $allfiles;
					}

					if ($check) {
						if (is_dir($source . DS . $file)) {
							if ($file[0] != '.') {
								$inc = false;
								if (is_array($includes[$file])) {
									$inc = $includes[$file];
								} elseif (is_bool($includes[$file])) {
									$inc = $includes[$file];
								}
								self::copyr($source . DS . $file, $dest . DS . $sourcefolder, $inc);
							}
						} else {
							if ($file[0] != '.' || $file == '.htaccess') {
								if (!copy($source . DS . $file, $dest . DS . $sourcefolder . DS . $file)) {
									throw new Exception('Error Copying File');
								}
							}
						}
					}
				}
			}
			closedir($dir_handle);
		} else {
			// can also handle simple copy commands
			copy($source, $dest);
		}
	}

/**
 *
 * Funtion to load a file and send it to the browser.
 *
 * @todo This should be moved to a more global scope
 *
 *
 * @param string $file - Filepath
 * @param string $name - Name of output file
 * @param string $mime_type - Mime Type
 * @throws Exception
 */
	private function returnFile($file, $name, $mime_type = '') {
		/*
		 * This function takes a path to a file to output ($file), the filename that the browser will see ($name) and the MIME type of the file ($mime_type, optional). If you want to do something on download abort/finish, register_shutdown_function('function_name');
		 */

		$i = 0;
		while (!file_exists($file)) {
			++$i;
			if ($i > 10000000) {
				throw new Exception('I can\'t find the file.', 1);
			}
		}

		if (!is_readable($file)) {
			throw new Exception('file cannot found or is inaccessible!', 1);
		}

		$size = filesize($file);
		$name = rawurldecode($name);

		/* Figure out the MIME type (if not specified) */
		$known_mime_types = array(
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html" => "text/html",
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"png" => "image/png",
			"jpeg" => "image/jpg",
			"jpg" => "image/jpg",
			"php" => "text/plain"
		);

		if ($mime_type == '') {
			$file_extension = strtolower(substr(strrchr($file, "."), 1));

			if (array_key_exists($file_extension, $known_mime_types)) {
				$mime_type = $known_mime_types [$file_extension];
			} else {
				$mime_type = "application/force-download";
			}
		}

		// @ob_end_clean(); //turn off output buffering to decrease cpu usage
		// required for IE, otherwise Content-Disposition may be ignored
		if (ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}

		header('Content-Type: ' . $mime_type);
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');

		/* The three lines below basically make the download non-cacheable */
		header('Cache-control: private');
		header('Pragma: private');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

		// multipart-download and download resuming support
		if (isset($_SERVER ['HTTP_RANGE'])) {
			list ( $a, $range ) = explode('=', $_SERVER ['HTTP_RANGE'], 2);
			list ( $range ) = explode(',', $range, 2);
			list ( $range, $range_end ) = explode('-', $range);

			$range = intval($range);

			$range_end = (!$range_end) ? $size - 1 : intval($range_end);
			$new_length = $range_end - $range + 1;

			header('HTTP/1.1 206 Partial Content');
			header('Content-Length: ' . $new_length);
			header('Content-Range: bytes ' . ($range - $range_end / $size));
		} else {
			$new_length = $size;

			header('Content-Length: ' . $size);
		}

		/* output the file itself */
		$chunksize = 1 * (2048 * 2048); // you may want to change this
		$bytes_send = 0;

		if ($file = fopen($file, 'r')) {
			if (isset($_SERVER ['HTTP_RANGE'])) {
				fseek($file, $range);
			}

			while (!feof($file) && (!connection_aborted()) && ($bytes_send < $new_length)) {
				$buffer = fread($file, $chunksize);

				print($buffer);
				flush();

				$bytes_send += strlen($buffer);
			}

			fclose($file);
		} else {
			die('Error - can not open file.');
		}
	}

}
