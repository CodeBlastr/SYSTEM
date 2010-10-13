<?php 
if ($_SERVER['REQUEST_URI'] != '/install.php') {
	header('Location: /install.php');
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zuha Installation</title>
<style type="text/css"> 
<!-- 
body  {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #fff;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
.twoColFixLtHdr #container { 
	width: 780px;  /* using 20px less than a full 800px width allows for browser chrome and avoids a horizontal scroll bar */
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 1px solid #000000;
	text-align: left; /* this overrides the text-align: center on the body element. */
} 
.twoColFixLtHdr #header { 
	background: #DDDDDD; 
	padding: 0 10px 0 20px;  /* this padding matches the left alignment of the elements in the divs that appear beneath it. If an image is used in the #header instead of text, you may want to remove the padding. */
} 
.twoColFixLtHdr #header h1 {
	margin: 0; /* zeroing the margin of the last element in the #header div will avoid margin collapse - an unexplainable space between divs. If the div has a border around it, this is not necessary as that also avoids the margin collapse */
	padding: 10px 0; /* using padding instead of margin will allow you to keep the element away from the edges of the div */
}
.twoColFixLtHdr #sidebar1 {
	float: left; /* since this element is floated, a width must be given */
	width: 200px; /* the actual width of this div, in standards-compliant browsers, or standards mode in Internet Explorer will include the padding and border in addition to the width */
	background: #EBEBEB; /* the background color will be displayed for the length of the content in the column, but no further */
	padding: 15px 10px 15px 20px;
}
.twoColFixLtHdr #mainContent { 
	margin: 0 0 0 250px; /* the left margin on this div element creates the column down the left side of the page - no matter how much content the sidebar1 div contains, the column space will remain. You can remove this margin if you want the #mainContent div's text to fill the #sidebar1 space when the content in #sidebar1 ends. */
	padding: 0 20px; /* remember that padding is the space inside the div box and margin is the space outside the div box */
} 
.twoColFixLtHdr #footer { 
	padding: 0 10px 0 20px; /* this padding matches the left alignment of the elements in the divs that appear above it. */
	background:#DDDDDD; 
} 
.twoColFixLtHdr #footer p {
	margin: 0; /* zeroing the margins of the first element in the footer will avoid the possibility of margin collapse - a space between divs */
	padding: 10px 0; /* padding on this element will create space, just as the the margin would have, without the margin collapse issue */
}
.fltrt { /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class should be placed on a div or break element and should be the final element before the close of a container that should fully contain a float */
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;
}
form {
	float: left;
}
label {
	display: block;
	float: left;
	clear: both;
}
input {
	display: block;
	float: left;
	clear: both;
	font-size: 24px;
	margin: 0 0 10px 0;
}
--> 
</style><!--[if IE 5]>
<style type="text/css"> 
/* place css box model fixes for IE 5* in this conditional comment */
.twoColFixLtHdr #sidebar1 { width: 230px; }
</style>
<![endif]--><!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColFixLtHdr #sidebar1 { padding-top: 30px; }
.twoColFixLtHdr #mainContent { zoom: 1; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]--></head>

<body class="twoColFixLtHdr">

<div id="container">
  <div id="header">
    <h1>zuha 1 minute installation</h1>
  <!-- end #header --></div>
  <div id="sidebar1">
    <h3>Database Connection</h3>
    <p>For now (alpha version 0.01), the only thing we need to get you setup is a database connection.  Fill in the database details, and we'll do the rest.</p>
    <h2>Requirements</h2>
    <p>MySQL version 5.X</p>
    <p>PHP version 5.3</p>
    <p>Apache mod_rewrite</p>
  <!-- end #sidebar1 --></div>
  <div id="mainContent">
  <?php 
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
			$sqlQuery = mysql_import($sqlFile);
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
    <h1> MySQL Database Details </h1>
    <form action="" method="post">
		<label>Database Host</label>
	    <input type="text" name="host" value="localhost">
	    <label>Database Username</label>
	    <input type="text" name="login">
	    <label>Database Password</label>
	    <input type="password" name="password">
	    <label>Database Name</label>
	    <input type="text" name="database">
	    <input type="submit" name="submit" value="Install">
	</form>
  <?php 
	}
  ?>
	<!-- end #mainContent --></div>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <div id="footer">
    <p><a href="http://www.zuha.com">zuha.com</a></p>
  <!-- end #footer --></div>
<!-- end #container --></div>
</body>
</html>



<?php 
function mysql_import($filename) {
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
?>