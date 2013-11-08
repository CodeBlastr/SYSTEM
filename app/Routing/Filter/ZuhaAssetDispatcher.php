<?php
App::uses('AssetDispatcher', 'Routing/Filter');

class ZuhaAssetDispatcher extends AssetDispatcher {


/**
 * Builds asset file path based off url
 *
 * @param string $url
 * @return string Absolute path for asset file
 */
	protected function _getAssetFile($url) {
		$parts = explode('/', $url);
		// start zuha addition
		$path = App::themePath($parts[1]) . 'webroot' . DS;
		$fileFragment = urldecode(implode(DS, $parts));
		if (file_exists($path . $fileFragment)) {
			return $path . $fileFragment;
		}
		
		// copied directly from Cake/Routing/Filter/AssetDispatcher.php
		$parts = explode('/', $url);
		if ($parts[0] === 'theme') {
			$themeName = $parts[1];
			unset($parts[0], $parts[1]);
			$fileFragment = implode(DS, $parts);
			$path = App::themePath($themeName) . 'webroot' . DS;
			return str_replace('//', '/', $path . $fileFragment); // and added this one fix
		}
		
		return parent::_getAssetFile($url);
	}

}
