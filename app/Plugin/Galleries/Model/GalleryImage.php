<?php
class GalleryImage extends GalleriesAppModel {

	public $name = 'GalleryImage';
	public $displayField = 'filename';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $belongsTo = array(
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
	
	public function __construct($id = false, $table = null, $ds = null) {
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
	public function add($data, $uploadFieldName) {	
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
	private function _getImageOptions($data) {
		if (!empty($data['UploadOptions'])) {
			# ex. array('filename' => array('thumbsizes' => array('small' => array('width' => 50, 'height' => 50))));
			# if you name one, you must name them all with this function
			$uploadOptions = $data['UploadOptions']; 
		} else {
			# ex. array('filename' => array('thumbsizes' => array('small' => array('width' => 50, 'height' => 50))));
			$uploadOptions = $this->galleryImageDefaults($data); 
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
	public function galleryImageDefaults($data = null) {
		
		$uploadOptions['thumbsizes']['medium']['width'] = $this->mediumImageWidth;
		$uploadOptions['thumbsizes']['medium']['height'] = $this->mediumImageHeight;
		
		$uploadOptions['thumbsizes']['small']['width'] = $this->smallImageWidth;
		$uploadOptions['thumbsizes']['small']['height'] = $this->smallImageHeight;
		
		$uploadOptions['thumbsizes']['large']['width'] = $this->largeImageWidth;
		$uploadOptions['thumbsizes']['large']['height'] = $this->largeImageHeight;
		
		return array_merge($data, $uploadOptions); 
	}
		
}
?>