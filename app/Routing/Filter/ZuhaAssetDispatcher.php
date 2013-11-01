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
		return parent::_getAssetFile($url);
	}

}
