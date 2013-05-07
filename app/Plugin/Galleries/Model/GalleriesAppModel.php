<?php
App::uses('AppModel', 'Model');
class GalleriesAppModel extends AppModel {
	
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
		
	public function __construct($id = false, $table = null, $ds = null) {
		parent:: __construct($id, $table, $ds);
		
		// deprecated gallery constants THESE WILL BE DELETED 12/30/2011 RK
		$galleryType = defined('__GALLERY_DEFAULT_TYPE') ? __GALLERY_DEFAULT_TYPE : null;
		$smallImageWidth = defined('__GALLERY_IMAGE_DEFAULT_THUMB_WIDTH') ? __GALLERY_IMAGE_DEFAULT_THUMB_WIDTH : null;
		$smallImageHeight = defined('__GALLERY_IMAGE_DEFAULT_THUMB_HEIGHT') ? __GALLERY_IMAGE_DEFAULT_THUMB_HEIGHT : null;
		$mediumImageWidth = defined('__GALLERY_DEFAULT_THUMB_WIDTH') ? __GALLERY_DEFAULT_THUMB_WIDTH : null;
		$mediumImageHeight = defined('__GALLERY_DEFAULT_THUMB_HEIGHT') ? __GALLERY_DEFAULT_THUMB_HEIGHT : null;
		$largeImageWidth = defined('__GALLERY_IMAGE_DEFAULT_FULL_WIDTH') ? __GALLERY_IMAGE_DEFAULT_FULL_WIDTH : null;
		$largeImageHeight = defined('__GALLERY_IMAGE_DEFAULT_FULL_HEIGHT') ? __GALLERY_IMAGE_DEFAULT_FULL_HEIGHT : null;
		$conversionType = defined('__GALLERY_RESIZE_OR_CROP') ? __GALLERY_RESIZE_OR_CROP : null;
		
		// gallery default setting constants
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
		
		# make it available to the views and to the controllers
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
		
	    // automatic upgrade the categories table 5/6/2013
	    // temporary, will be removed soon
	    	$db = ConnectionManager::getDataSource('default');
	      	$tables = $db->describe('gallery_images');
	      	if (!array_key_exists('order', $tables)) {
	        	$this->uses = false;
	        	$this->useTable = false;
	        	$this->query('ALTER TABLE  `gallery_images` ADD  `order` INT( 5 ) NULL AFTER  `gallery_id`');
	        	header('Location: ' . $_SERVER['REQUEST_URI']); // refresh the page to establish new table name
	        	break;
	    }
	}
	
	
/**
 * Takes a gallery data array and updates the settings if this gallery over write them.
 */  
	public function gallerySettings($newSettings = null) {
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
?>