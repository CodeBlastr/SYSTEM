<?php
if (defined('__WEBPAGES_DEFAULT_CSS_FILENAMES')) {
	$i = 0;
	foreach (unserialize(__WEBPAGES_DEFAULT_CSS_FILENAMES) as $media => $files) { 
		foreach ($files as $file) {
			if (strpos($file, ',')) {
				if (strpos($file, $defaultTemplate['Webpage']['id'].',') === 0) {
					$file = str_replace($defaultTemplate['Webpage']['id'].',', '', $file);
					echo $this->Html->css($file, 'stylesheet', array('media' => $media)); 
				}
			} else {
				echo $this->Html->css($file, 'stylesheet', array('media' => $media)); 
			}
		}
		$i++;
	} 
} ?>