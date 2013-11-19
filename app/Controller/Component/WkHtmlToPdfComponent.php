<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
class WkHtmlToPdfComponent extends Component {

	/**
	 * wkhtmltopdf component class for exporting a view as pdf
	 *
	 * @author Zuha
	 *
	 * @category Components
	 */
	public function initialize(Controller $controller) {
		// generate random number to ensure file is unique
		$randomNumber = mt_rand();
		$this->randomNumber = $randomNumber;
		$this->controller = $controller;
		$this->filepath = ROOT . DS . SITE_DIR . DS . 'Locale' . DS . 'View' . DS . WEBROOT_DIR . DS . 'upload' . DS . 'pdf';
		$this->siteFolder = new Folder($this->filepath, true, 0755);
		$fileName = 'viewDump' . $randomNumber . '.html';
		$this->viewFile = new File($this->siteFolder->pwd() . DS . $fileName);
	}
	
	public function rasterizePdf() {
		
		$this->controller->autoRender = false;
		$this->controller->render();
		$view = $this->controller->View->output;
		
		if ($this->viewFile !== false) {
			$this->viewFile->delete();
		}
		// write view from memory to file and then generate the pdf
		if ($this->viewFile->write($view, 'w')) {
			
			$this->viewFile->close();
			
			$url = 'http://' . $_SERVER ['HTTP_HOST'] . '/theme/Default/upload/pdf/' . $this->viewFile->name;
			
			$output = $this->filepath . DS . "output{$this->randomNumber}.pdf";
		
			$commands = '';
		
			if (PHP_OS === 'Darwin') {
				$cmd = VENDORS . '/phantomjs/MacOS/phantomjs '.VENDORS . '/phantomjs/examples/rasterize.js '. $commands . $url . ' ' . $output;
			} else {
				switch (PHP_INT_SIZE) {
					case 4 :
						throw new Exception('32bit not installed yet', 1);
						break;
					case 8 :
						$cmd = VENDORS . 'phantomjs/nix64/phantomjs rasterize.js '. $commands . $url . ' ' . $output;
						break;
					default :
						throw new Exception('I was unable to detect which phantomjs file to use on this system.', 1);
						break;
				}
			}
			echo $cmd;
			exec($cmd);
			die();
		}
	}


	public function createPdf($autoDownload = true, $options = array()) {

		$this->controller->autoRender = false;
		$this->controller->render();
		$view = $this->controller->View->output;

		if ($this->viewFile !== false) {
			$this->viewFile->delete();
		}
		// write view from memory to file and then generate the pdf
		if ($this->viewFile->write($view, 'w')) {

			$this->viewFile->close();

			$url = 'http://' . $_SERVER ['HTTP_HOST'] . '/theme/Default/upload/pdf/' . $this->viewFile->name;

			$output = $this->filepath . DS . "output{$this->randomNumber}.pdf";

			$commands = ' "A4" ';

			if (PHP_OS === 'Darwin') {
				$cmd = VENDORS . 'phantomjs/MacOS/phantomjs '.VENDORS . 'phantomjs/examples/rasterize.js '. $commands . $url . ' ' . $output;
			} elseif (PHP_OS === 'WINNT') {
				$cmd = VENDORS . 'phantomjs\windows\phantomjs '.VENDORS . 'phantomjs\windows\examples\rasterize.ewc.js ' . $url . ' ' . $output . $commands;
			}else {
				switch (PHP_INT_SIZE) {
					case 4 :
						throw new Exception('32bit not installed yet', 1);
						break;
					case 8 :
						$cmd = VENDORS . 'phantomjs/nix64/phantomjs '.VENDORS . 'phantomjs/examples/rasterize.ttysoon.js \'' . $url . '\' ' . $output;
						break;
					default :
						throw new Exception('I was unable to detect which phantomjs file to use on this system.', 1);
						break;
				}
			}
			//debug($cmd);exit;
			exec($cmd);
			if ($autoDownload) {
				// send file to browser and trigger download dialogue box
				$this->returnFile($output, "document{$this->randomNumber}.pdf");
				// delete the PDF from the server
				$this->cleanUp();
			} else {
				// keep the PDF on the server and return it's location
				return $output;
			}
		}
	}

	public function createPdf($autoDownload = true, $options = array()) {

		$defaults = array(
			'grayscale' => false, // boolean
			'lowquality' => false, // boolean
			'orientation' => 'Portrait', // Landscape
			'pagesize' => 'Letter', // Letter, Legal, A3, A4, etc
			'javascriptdelay' => 200,
			'windowstatus' => false // if provided, it will wait until window.status = 'someString' to generate the PDF
		);
		$options = array_merge($defaults, $options);

		// prevent view from rendering normally
		$this->controller->autoRender = false;
		// $this->controller->output = '';
		// $this->controller->layout = $layout;
		// render view to memory with optional layout specified
		$this->controller->render();
		$view = $this->controller->View->output;

		if ($this->viewFile !== false) {
			$this->viewFile->delete();
		}
		// write view from memory to file and then execute wkhtmltopdf externally to generate the pdf
		if ($this->viewFile->write($view, 'w')) {

			$this->viewFile->close();

			$url = 'http://' . $_SERVER ['HTTP_HOST'] . '/theme/Default/upload/pdf/' . $this->viewFile->name;

			$output = $this->filepath . DS . "output{$this->randomNumber}.pdf";

			$commands = '';
			$commands .= '-s '.$options['pagesize'] . ' ';
			$commands .= '-O '.$options['orientation'] . ' ';
			if ($options['grayscale']) {
				$commands .= '-g ';
			}
			if ($options['lowquality']) {
				$commands .= '-l ';
			}
			if ($options['javascriptdelay']) {
				$commands .= '--javascript-delay ' . $options['javascriptdelay'] . ' ';
			}

			if ($options['nostopslowscripts']) {
				$commands .= '--no-stop-slow-scripts ';
			}
			if ($options['windowstatus']) {
				$commands .= '--window-status "' . $options['windowstatus'] . '" ';
			}

			//For windows debugging on localhost
			//For this to work install
			//https://code.google.com/p/wkhtmltopdf/downloads/detail?name=libwkhtmltox-0.11.0_rc1.zip&can=2&q=
			if (PHP_OS === 'WINNT') {
				$cmd = 'C:\"Program Files (x86)"\wkhtmltopdf\wkhtmltopdf.exe '. $commands . $url . ' ' . $output;
			} elseif (PHP_OS === 'Darwin') {
				$cmd = VENDORS . 'wkhtmltopdf/MacOS/wkhtmltopdf.app/Contents/MacOS/wkhtmltopdf '. $commands . $url . ' ' . $output;
			} else {
				switch (PHP_INT_SIZE) {
					case 4 :
						$cmd = VENDORS . 'wkhtmltopdf/32bit/wkhtmltopdf '. $commands . $url . ' ' . $output;
						break;
					case 8 :
						$cmd = VENDORS . 'wkhtmltopdf/64bit/wkhtmltopdf '. $commands . $url . ' ' . $output;
						break;
					default :
						throw new Exception('32/64? no found', 1);
						break;
				}
			}

			exec($cmd);
		}

		if ($autoDownload) {
			// send file to browser and trigger download dialogue box
			$this->returnFile($output, "document{$this->randomNumber}.pdf");
			// delete the PDF from the server
			$this->cleanUp();
		} else {
			// keep the PDF on the server and return it's location
			return $output;
		}
	}

	public function getViewDump($fileName) {
		// prevent view from rendering normally
		$this->controller->autoRender = false;
		$this->controller->output = '';

		print_r($this->viewFile->read());
	}

	public function cleanUp() {
		// delete viewDump
		$this->viewFile->delete();

		// delete outputPdf
		$file = new File($this->filepath . DS . 'output' . $this->randomNumber . '.pdf');
		$file->delete();
	}

	private function returnFile($file, $name, $mime_type = '') {
		/*
		 * This function takes a path to a file to output ($file), the filename that the browser will see ($name) and the MIME type of the file ($mime_type, optional). If you want to do something on download abort/finish, register_shutdown_function('function_name');
		 */
		 
		 $i = 0;
		 while (!file_exists($file)) {
		 	++$i;
			 if ($i > 10000000) {
			 	throw new Exception('I can\'t find the generated PDF file.', 1);
			 }
		 }

		if (!is_readable($file)) {
			throw new Exception('PDF file cannot found or is inaccessible!', 1);
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
		$chunksize = 1 * (1024 * 1024); // you may want to change this
		$bytes_send = 0;

		if ($file = fopen($file, 'r')) {
			if (isset($_SERVER ['HTTP_RANGE'])) {
				fseek($file, $range);
			}

			while ( !feof($file) && (!connection_aborted()) && ($bytes_send < $new_length) ) {
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
