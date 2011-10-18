<?php
class GalleryImage extends GalleriesAppModel {

	var $name = 'GalleryImage';
	var $displayField = 'filename';
	var $galleryImageSmallWidth = 64;
	var $galleryImageSmallHeight = 64;
	var $galleryImageMediumWidth = 120;
	var $galleryImageMediumHeight = 90;
	var $galleryImageLargeWidth = 700;
	var $galleryImageLargeHeight = 525;
	#var $actsAs = array('Favorites.Favorite');
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Gallery' => array(
			'className' => 'Galleries.Gallery',
			'foreignKey' => 'gallery_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function __construct($id = false, $table = null, $ds = null) {
		if (defined('__APP_LOAD_APP_BEHAVIORS') && $behaviors = @unserialize(__APP_LOAD_APP_BEHAVIORS)) {
			if (!empty($behaviors[$this->name])) {
				$this->actsAs[] = $behaviors[$this->name];
			}
		}
		parent::__construct($id, $table, $ds);
	}
	
	/**
	 *
	 * @todo	We may want to check whether the gallery actually exists, instead of just trusting that the gallery_id is right.
	 */
	function add($data, $uploadFieldName) {	
		if (!empty($data['GalleryImage']['gallery_id'])) {
			# gallery id was given so check the defaults, attach the upload behavior, and perform the upload
			$uploadOptions[$uploadFieldName] = $this->_getImageOptions($data);
			$this->Behaviors->attach('MeioUpload', $uploadOptions);
			if ($this->save($data)) {
				return true;
			} else {
				$errors = '';
				foreach ($this->invalidFields() as $key => $error) :
					$errors .= $key . ' - ' . $error . ', ';
				endforeach;
				throw new Exception(__d('galleries', 'ERROR : ' . $errors, true));
			}
		} else {
			# no gallery id was given so create a gallery first using site settings and make the first image the thumb
			# note: the image save will be performed from the gallery model which calls back to this function with gallery_id filled.
			if ($this->Gallery->add($data, $uploadFieldName)) {
				return true;
			} else {
				throw new Exception(__d('galleries', 'ERROR : Gallery add failed.', true));
			}
		}
		break;
	}
	
	/** 
	 * Set Gallery Image Defaults
	 * 
	 * In conjunction with the _getImageOptions function, we 
	 * run through the various places where thumbnail sizes can be set to establish the correct size.
	 * This one uses the submitted form options if they exist if not we send it to the Image
	 * _galleryImageDefaults function
	 * 
	 * @param {array}		data array of the gallery image
	 */
	function _getImageOptions($data) {
		if (!empty($data['UploadOptions'])) {
			# ex. array('filename' => array('thumbsizes' => array('small' => array('width' => 50, 'height' => 50))));
			# if you name one, you must name them all with this function
			$uploadOptions = $data['UploadOptions']; 
		} else {
			# ex. array('filename' => array('thumbsizes' => array('small' => array('width' => 50, 'height' => 50))));
			$uploadOptions = $this->_galleryImageDefaults($data); 
		}
		return $uploadOptions;
	}
	
	
	/** 
	 * Set Gallery Image Defaults
	 * 
	 * In conjunction with the _getImageOptions function, we 
	 * run through the various places where thumbnail sizes can be set to establish the correct size.
	 * The order is... from the form submitting first using the _getImageOptions function
	 * then from the gallery defaults, then from system settings, and lastly defaults hard coded in the model.
	 * 
	 * @param {array}		data array of the gallery image
	 * @return {array} 		returns the updated data array
	 */
	function _galleryImageDefaults($data = null) {
		# this is the thumbnail used on index pages. (the lead in to an actual gallery view)
		if (!empty($data['Gallery']['medium_width'])) {
			$uploadOptions['thumbsizes']['medium']['width'] = $data['Gallery']['medium_width'];
		} else if (defined('__GALLERY_DEFAULT_THUMB_WIDTH')) {
			$uploadOptions['thumbsizes']['medium']['width'] = __GALLERY_DEFAULT_THUMB_WIDTH;
		} else {
			# standard tile ad size if nothing else is specified.
			$uploadOptions['thumbsizes']['medium']['width'] = $this->galleryImageMediumWidth;
		}
		
		# this is the thumbnail used on index pages. (the lead in to an actual gallery view)
		if (!empty($data['Gallery']['medium_height'])) {
			$uploadOptions['thumbsizes']['medium']['height'] = $data['Gallery']['medium_height'];
		} else if (defined('__GALLERY_DEFAULT_THUMB_HEIGHT')) {
			$uploadOptions['thumbsizes']['medium']['height'] = __GALLERY_DEFAULT_THUMB_HEIGHT;
		} else {
			# standard tile ad size if nothing else is specified.
			$uploadOptions['thumbsizes']['medium']['height'] = $this->galleryImageMediumHeight;
		}
		
		# this is the small thumbnail used on view pages
		if (!empty($data['Gallery']['thumb_width'])) {
			$uploadOptions['thumbsizes']['small']['width'] = $data['Gallery']['thumb_width'];
		} else if (defined('__GALLERY_IMAGE_DEFAULT_THUMB_WIDTH') && empty($data['Gallery']['thumb_width'])) {
			$uploadOptions['thumbsizes']['small']['width'] = __GALLERY_IMAGE_DEFAULT_THUMB_WIDTH;
		} else {
			# small icon size if nothing else specified
			$data['Gallery']['thumb_width'] = $this->galleryImageSmallWidth;
			$uploadOptions['thumbsizes']['small']['width'] = $this->galleryImageSmallWidth;
		}
		
		# this is the small thumbnail used on view pages
		if (!empty($data['Gallery']['thumb_height'])) {
			$uploadOptions['thumbsizes']['small']['height'] = $data['Gallery']['thumb_height'];
		} else if (defined('__GALLERY_IMAGE_DEFAULT_THUMB_HEIGHT') && empty($data['Gallery']['thumb_height'])) {
			$uploadOptions['thumbsizes']['small']['height'] = __GALLERY_IMAGE_DEFAULT_THUMB_HEIGHT;
		} else {
			# large icon size if nothing else specified
			$data['Gallery']['thumb_height'] = $this->galleryImageSmallHeight;
			$uploadOptions['thumbsizes']['small']['height'] = $this->galleryImageSmallHeight;
		}
		
		# this is the large image gallery picture
		if (!empty($data['Gallery']['full_width'])) {
			$uploadOptions['thumbsizes']['large']['width'] = $data['Gallery']['full_width'];
		} else if (defined('__GALLERY_IMAGE_DEFAULT_FULL_WIDTH') && empty($data['Gallery']['full_width'])) {
			$uploadOptions['thumbsizes']['large']['width'] = __GALLERY_IMAGE_DEFAULT_FULL_WIDTH;
		} else {
			# use slightly less than one of the smallest standard screen resolution if nothing else
			$data['Gallery']['full_width'] = $this->galleryImageLargeWidth;
			$uploadOptions['thumbsizes']['large']['width'] = $this->galleryImageLargeWidth;
		}
		
		# this is the large image gallery picture
		if (!empty($data['Gallery']['full_height'])) {
			$uploadOptions['thumbsizes']['large']['height'] = $data['Gallery']['full_height'];
		} else if (defined('__GALLERY_IMAGE_DEFAULT_FULL_HEIGHT') && empty($data['Gallery']['full_height'])) {
			$uploadOptions['thumbsizes']['large']['height'] = __GALLERY_IMAGE_DEFAULT_FULL_HEIGHT;
		} else {
			# use slightly less than one of the smallest standard screen resolutions if nothing else
			$data['Gallery']['full_height'] = $this->galleryImageLargeHeight;
			$uploadOptions['thumbsizes']['large']['height'] = $this->galleryImageLargeHeight;
		}
		return array_merge($data, $uploadOptions); 
	}
		
}
?>