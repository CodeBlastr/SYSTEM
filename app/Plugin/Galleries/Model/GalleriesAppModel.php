<?php
App::uses('AppModel', 'Model');

class GalleriesAppModel extends AppModel {

	//public $useTable = false; // this is here because we have the construct which causes an error if you load this class directly, because cake tries to find a table called galleries_app_model
	public $galleryType = 'fancybox';
   	public $smallImageWidth = 50;
	public $smallImageHeight = 50;
	public $mediumImageWidth = 100;
	public $mediumImageHeight = 100;
	public $largeImageWidth = 500;
	public $largeImageHeight = 500;
	public $indexImageWidth = null;
	public $indexImageHeight = null;
	public $conversionType = 'resizeCrop';	
		
	// see note in gallerySettings()
	//public function __construct($id = false, $table = null, $ds = null) {
		// parent:: __construct($id, $table, $ds);
	// }
	
	
/**
 * Takes a gallery data array and updates the settings if this gallery over write them.
 * 
 */  
	public function gallerySettings($newSettings = null) {
		
		// START NOTE : These lines were moved from the __construct() because $this->useTable doesn't work on some pages
		// was causing an infinite redirect and breaking sites.  And because we need to tell this GalleriesAppModel
		// that there isn't a table when there is a __construct() method used, so that it doesn't break the install/client
		// page that relies on loading XXXAppModel directly to see if the menuInit() function exists.  I leave this note,
		// because I'm not sure that moving these settings here (down to where it sas // END NOTE) will not break something else.
		// gallery default setting constants  (11/27/2013 RK)
		if(!empty($instance) && defined('__GALLERIES_SETTINGS_'.$instance)) {
			extract(unserialize(constant('__GALLERIES_SETTINGS_'.$instance)));
		} else if (defined('__GALLERIES_SETTINGS')) {
			extract(unserialize(__GALLERIES_SETTINGS));
		}
		
		$galleryType = !empty($galleryType) ? $galleryType : $this->galleryType;
   		$smallImageWidth = !empty($smallImageWidth) ? $smallImageWidth : $this->smallImageWidth;
	    $smallImageHeight = !empty($smallImageHeight) ? $smallImageHeight : $this->smallImageHeight;
	    $mediumImageWidth = !empty($mediumImageWidth) ? $mediumImageWidth : $this->mediumImageWidth;
	    $mediumImageHeight = !empty($mediumImageHeight) ? $mediumImageHeight : $this->mediumImageHeight;
	    $largeImageWidth = !empty($largeImageWidth) ? $largeImageWidth : $this->largeImageWidth;
	    $largeImageHeight = !empty($largeImageHeight) ? $largeImageHeight : $this->largeImageHeight;
	    $indexImageWidth = !empty($indexImageWidth) ? $indexImageWidth : $this->indexImageWidth;
	    $indexImageHeight = !empty($indexImageHeight) ? $indexImageHeight : $this->indexImageHeight;
	    $conversionType = !empty($conversionType) ? $conversionType : $this->conversionType;
		
		// make it available to the views and to the controllers, (does this even work from models????????  11/27/2013 RK)
		$this->set(compact('galleryType', 'smallImageWidth', 'smallImageHeight', 'mediumImageWidth', 'mediumImageHeight', 'largeImageWidth', 'largeImageHeight', 'conversionType'));
		
		$this->galleryType = $galleryType;
		$this->smallImageWidth = $smallImageWidth;
		$this->smallImageHeight = $smallImageHeight;
		$this->mediumImageWidth = $mediumImageWidth;
		$this->mediumImageHeight = $mediumImageHeight;
		$this->largeImageWidth = $largeImageWidth;
		$this->largeImageHeight = $largeImageHeight;
		$this->indexImageWidth = $indexImageWidth;
		$this->indexImageHeight = $indexImageHeight;
		$this->conversionType = $conversionType;
		$this->gallerySettings = array(
			'galleryType' => $this->galleryType,
			'smallImageWidth' => $this->smallImageWidth,
			'smallImageHeight' => $this->smallImageHeight,
			'mediumImageWidth' => $this->mediumImageWidth,
			'mediumImageHeight' => $this->mediumImageHeight,
			'largeImageWidth' => $this->largeImageWidth,
			'largeImageHeight' => $this->largeImageHeight,
			'indexImageWidth' => $this->indexImageWidth,
			'indexImageHeight' => $this->indexImageHeight,
			'conversionType' => $this->conversionType,
			);
		// END NOTE 
		
		if (!empty($newSettings)) {
			$this->gallerySettings['galleryType'] = !empty($newSettings['Gallery']['type']) ?  $newSettings['Gallery']['type'] : $this->galleryType;
			$this->gallerySettings['smallImageWidth'] = !empty($newSettings['Gallery']['thumb_width']) ?  $newSettings['Gallery']['thumb_width'] : $this->smallImageWidth;
			$this->gallerySettings['smallImageHeight'] = !empty($newSettings['Gallery']['thumb_height']) ?  $newSettings['Gallery']['thumb_height'] : $this->smallImageHeight;
			$this->gallerySettings['mediumImageWidth'] = !empty($newSettings['Gallery']['medium_width']) ?  $newSettings['Gallery']['medium_width'] : $this->mediumImageWidth;
			$this->gallerySettings['mediumImageHeight'] = !empty($newSettings['Gallery']['medium_height']) ?  $newSettings['Gallery']['medium_height'] : $this->mediumImageHeight;
			$this->gallerySettings['largeImageWidth'] = !empty($newSettings['Gallery']['full_width']) ?  $newSettings['Gallery']['full_width'] : $this->largeImageWidth;
			$this->gallerySettings['largeImageHeight'] = !empty($newSettings['Gallery']['full_height']) ?  $newSettings['Gallery']['full_height'] : $this->largeImageHeight;
			$this->gallerySettings['conversionType'] = !empty($newSettings['Gallery']['conversion_type']) ?  $newSettings['Gallery']['conversion_type'] : $this->conversionType;
		}	
		return $this->gallerySettings;
	}
	
	public function conversionTypes() {
		return array(
			'resize' => 'Resize',
			'resizeCrop' => 'Resize & Crop',
			'crop' => 'Crop',
			);
	}

}