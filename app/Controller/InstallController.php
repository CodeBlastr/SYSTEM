<?php

class InstallController extends AppController {

	var $name = 'Install';
    var $uses = array();
	var $dbVersion = __SYSTEM_ZUHA_DB_VERSION;
	
	
	public function index() {
		if (!empty($this->request->data)) :
			debug($this->request->data);
			break;
		endif;
		
		$this->layout = false;
	}
	
	
	public function mysql_import($filename) {
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




<?php /*
  	if (isset($_POST['database'])) {
		$host = $_POST['host'];
		$login = $_POST['login'];
		$password = $_POST['password'];
		$database = $_POST ['database'];
		$connection = mysql_connect($host, $login, $password);
		if ($connection) {
			# connect works now lets see if we can put the data in		
			# we have the query to import db, lets run it
			mysql_select_db($database);
			# opne the sqlFile
			$sqlFile = "../../0.01.sql";	
			# put the queries into an array
####################################$sqlQuery = mysql_import($sqlFile);
			#echo '<pre>';
			#print_r($sqlQuery);
			#echo '</pre>';
			#break;
			# run the queries
			foreach ($sqlQuery as $query) {
				$result = mysql_query($query);
				if (!$result) {
					$message  = '<p>Invalid query: ' . mysql_error() . '</p>';
					$message .= '<p>Whole query: ' . $query . '</p>';
					die($message);
				}
			}
			# it must have worked it didn't die
			# successful database import lets write the db file
			$configFile = "../config/database.php";
			$fh = fopen($configFile, 'w') or die("can't open config file");
			$stringData = "<?php
class DATABASE_CONFIG {

	var \$default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '$host',
		'login' => '$login',
		'password' => '$password',
		'database' => '$database',
	);
	
	function __construct() {
		if (file_exists('../'.WEBROOT_DIR.'/install.php')) {
			require_once ('../'.WEBROOT_DIR.'/install.php'); 
		}
	}
}
?>";
			fwrite($fh, $stringData);
			fclose($fh);

			# clear the post var
			unset($_POST);
			?>
			<p>Successfully installed you must now delete the install.php file to use zuha.  Would you like us to try for you?</p>
			<form action="" method="post">
            <input type="hidden" name="finish-install" value="true">
	        <input type="submit" name="submit" value="Finish Installtion">
            </form>
            <?php
			# close the connection
			mysql_close($connection);
		
		} else {
			unset($_POST);
            echo '<p>Could not connect to the database. <a href="install.php">Try again</a>?</p>';
		}
  ?>
  <?php 
	} else if (isset($_POST['finish-install'])) {
		# try to delete this file, because installation is done
		if(unlink('install.php')) {
			header('Location: /');
		} else {
			'<p>Could not delete the install file, you must do it manually.</p>';
		}
	} else {
  ?> 
  
  
  
  
  */ ?>