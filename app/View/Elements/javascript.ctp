<?php 
if (defined('__WEBPAGES_DEFAULT_JS_FILENAMES')) { 
	$i = 0;
	foreach (unserialize(__WEBPAGES_DEFAULT_JS_FILENAMES) as $media => $files) { 
		foreach ($files as $file) {
			if (strpos($file, ',')) {
				if (strpos($file, $defaultTemplate['Webpage']['id'].',') === 0) {
					$file = str_replace($defaultTemplate['Webpage']['id'].',', '', $file);
					echo $this->Html->script($file);
				}
			} else {
				echo $this->Html->script($file);
			}
		}
		$i++;
	} 
}  ?>