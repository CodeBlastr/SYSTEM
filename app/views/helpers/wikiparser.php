<?php 

class WikiparserHelper extends AppHelper {
	
	function render($content, $wiki_id = null) {
		$parsedContent = '';
			$processMarkup = true;
			$processing = array(
				"&&&" => false, #<pre>
				"===" => false, #<h3>
				"'''" => false, #
				"!!!" => false,
				"___" => false,
				"[[[" => false,
				"]]]" => false,
				"*" => false,
				"#" => false,
			);
			$lines = explode("\n", $content);
			foreach ($lines as $line) {
				$line = trim($line);
				switch (substr($line, 0, 1)) {
					case "*" :
						if ($processMarkup) {
							if (!$processing["*"]) {
								$processing["*"] = true;
								$line = " <ul><li> " . substr($line, 1) . " </li> ";
							} else {
								$line = " <li> " . substr($line, 1) . " </li> ";
							}
						}
						break;
					case "#" :
						if ($processMarkup) {
							if (!$processing["#"]) {
								$processing["#"] = true;
								$line = " <ol><li> " . substr($line, 1) . " </li> ";
							} else {
								$line = " <li> " . substr($line, 1) . " </li> ";
							}
						}
						break;
					default :
						if ($processing["#"]) {
							$processing["#"] = false;
							$line = " </ol> " . $line;
						}
						if ($processing["*"]) {
							$processing["*"] = false;
							$line = " </ul> " . $line;
						}
						$line .= " <br /> ";
						break;
				}
				$words = explode(" ", $line);
				foreach ($words as $word) {
					$word = trim($word);
					switch (substr($word, 0, 3)) {
						case '&&&' :
							if ($processing["&&&"]) {
								$processing["&&&"] = false;
								$processMarkup = true;
								$word = '</pre>' . substr($word,3);
							} else {
								$processing["&&&"] = true;
								$processMarkup = false;
								$word = '<pre>' . substr($word,3);
							}
							break;
						case "===" :
							if ($processing["==="] && $processMarkup) {
								$processing["==="] = false;
								$word = '</h3>' . substr($word,3);
							} else {
								$processing["==="] = true;
								$word = '<h3>' . substr($word,3);
							}
							break;
						case "'''" :
							if ($processing["'''"] && $processMarkup) {
								$processing["'''"] = false;
								$word = '</i>' . substr($word,3);
							} else {
								$processing["'''"] = true;
								$word = '<i>' . substr($word,3);
							}
							break;
						case "!!!" :
							if ($processing["!!!"] && $processMarkup) {
								$processing["!!!"] = false;
								$word = '</b>' . substr($word,3);
							} else {
								$processing["!!!"] = true;
								$word = '<b>' . substr($word,3);
							}
							break;
						case "___" :
							if ($processing["___"] && $processMarkup) {
								$processing["___"] = false;
								$word = '</u>' . substr($word,3);
							} else {
								$processing["___"] = true;
								$word = '<u>' . substr($word,3);
							}
							break;
						case "[[[" :
							if ($processMarkup) {
								$processing["[[["] = true;
								$processing["]]]"] = substr($word,3);
								$word = substr($word,3);
							}
							break;
						case '---' :
							if ($processMarkup) {
								$word = '<hr />' . substr($word,3);
							}
							break;
						case 'htt' :
							if ($processMarkup && substr($word, 0,7) == "http://") {
								$word = "<a href='" . $word . "'>".$word."</a>";
							}
						default :
							if ($processMarkup) {
								if ($processing["]]]"] && substr($word, -3, 3) != "]]]") {
									$processing["]]]"] .= ' ' . $word;
									$word = '';
								}
								$processing["[[["] = false;
							}
					}
					switch (substr($word, -3, 3)) {
						case '&&&' :
							if ($processing["&&&"]) {
								$processing["&&&"] = false;
								$processMarkup = true;
								$word = substr($word,0,-3) . '</pre>';
							} else {
								$processing["&&&"] = true;
								$processMarkup = false;
								$word = substr($word,0,-3) . '<pre>';
							}
							break;
						case "===" :
							if ($processing["==="] && $processMarkup) {
								$processing["==="] = false;
								$word = substr($word,0,-3) . '</h3>';
							} else {
								$processing["==="] = true;
								$word = substr($word,0,-3) . '<h3>';
							}
							break;
						case "'''" :
							if ($processing["'''"] && $processMarkup) {
								$processing["'''"] = false;
								$word = substr($word,0,-3) . '</i>';
							} else {
								$processing["'''"] = true;
								$word = substr($word,0,-3) . '<i>';
							}
							break;
						case "!!!" :
							if ($processing["!!!"] && $processMarkup) {
								$processing["!!!"] = false;
								$word = substr($word,0,-3) . '</b>';
							} else {
								$processing["!!!"] = true;
								$word = substr($word,0,-3) . '<b>';
							}
							break;
						case "___" :
							if ($processing["___"] && $processMarkup) {
								$processing["___"] = false;
								$word = substr($word,0,-3) . '</u>';
							} else {
								$processing["___"] = true;
								$word = substr($word,0,-3) . '<u>';
							}
							break;
						case "[[[" :
							if ($processMarkup) {
								$processing["[[["] = true;
								$processing["]]]"] = substr($word,0,-3);
								$word = substr($word,0,-3);
							}
							break;
						case "]]]" :
							if ($processing["]]]"] && $processMarkup) {
								if (!$processing["[[["]) {
									$processing["]]]"] .= ' ' . substr($word,0,-3);
								} else {
									$processing["]]]"] = substr($processing["]]]"],0,-3);
								}
								if (strpos($processing["]]]"], "|")) {
									list($alink, $atitle) = explode('|', $processing["]]]"]);
								} else {
									$alink = $processing["]]]"];
									$atitle = false;
								}
								if (strpos($alink, "://")) {
									$word = "<a href='" . $alink . "'>";
								} else {
									# to do, make this more cakephpy
									#$word = $html->link(__('New Wiki Page', true), array('controller' => 'wiki_contents', 'action' => 'edit', $this->params['pass'][0]));
									if (isset($wiki_id)) {
										$word = "<a href='/admin/wiki_contents/view/" .$wiki_id."/". str_replace(" ", "_", $alink) ."'>"; 
									} else { 
										$word = "<a href='/admin/wiki_contents/view/" .$this->params['pass'][0]."/". str_replace(" ", "_", $alink) ."'>"; 
									}
								}
								if ($atitle) {
									$word .= $atitle;
								} else {
									$word .= $alink;
								}
								$word .= "</a>";
								$processing["[[["] = false;
								$processing["]]]"] = false;
							}
							break;
						case '---' :
							if ($processMarkup) {
								$word = substr($word,0,-3) . '<hr />';
							}
							break;
						default :
							if ($processMarkup && $processing[']]]']) {
								$word = '';
							}
							break;

					}
					$parsedContent .= $word . ' ';
				}
			}
			
		return $parsedContent;
			
	}
	
}
?>
	