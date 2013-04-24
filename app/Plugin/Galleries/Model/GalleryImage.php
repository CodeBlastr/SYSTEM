<?php
App::uses('GalleriesAppModel', 'Galleries.Model');
/**
 * Gallery Image Model Class
 *
 * @todo Add more documentation
 */
class GalleryImage extends GalleriesAppModel {

/**
 * var string
 */
	public $name = 'GalleryImage';

/**
 * var string
 */
	public $displayField = 'filename';

/**
 * var string
 */
	public $rootPath = '';
	
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
		$this->rootPath = ROOT . DS . SITE_DIR . DS . 'Locale'.DS.'View' . DS . 'webroot';
		parent::__construct($id, $table, $ds);
	}
	
/**
 * After save method
 *
 * @param bool
 */
	public function afterSave($created) {
		if (!empty($this->data['GalleryImage']['is_thumb'])) {
			try {
				$data['Gallery']['id'] = $this->data['GalleryImage']['gallery_id'];
				$data['GalleryImage']['id'] = $this->data['GalleryImage']['id'];
				$this->Gallery->makeThumb($data);
				return true;				
			} catch (Exception $e) {
				throw new Exception(__d('galleries', 'Gallery thumb update failed : ' . $e->getMessage(), true));
			}
		}
	}
	
	
/**
 * Add method
 * 
 * @access public
 * @param array
 * @param string
 * @return bool
 */
	public function add($data, $uploadFieldName) {
		$data = $this->_cleanData($data);
		if (isset($data['GalleryImage']['filename'][0]) && is_array($data['GalleryImage']['filename'])) {
			try {
				$image = $data;
				foreach ($data['GalleryImage']['filename'] as $f) {
					$image['GalleryImage']['filename'] = $this->_fileName($f);
					$this->_add($image, $uploadFieldName);
				}
				return true;
			} catch(Exception $e) {
				throw new Exception($e->getMessage());
			}
		} else {
			try {
				return $this->_add($data, $uploadFieldName);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
	}
	
/**
 * Protected add method
 *
 * If a gallery id is given, check the defaults, attach the upload behavior, and perform the upload.
 * If no gallery id is given, create a gallery first using site settings, and make the submitted image the th
 * The gallery add() function calls back to this function to perform the upload.
 * 
 * This protected version of the add function was pushed down so that it could be called multiple times.
 * 
 * @access protected
 * @param array
 * @param string
 * @return bool
 */
	protected function _add($data, $uploadFieldName) {
        $data = $this->checkForGallery($data);
		if (!empty($data['GalleryImage']['gallery_id'])) {
			// existing gallery
			$uploadOptions[$uploadFieldName] = $this->_getImageOptions($data);
			$this->Behaviors->attach('Galleries.MeioUpload', $uploadOptions);
			$this->create();
			if ($this->save($data)) {
				return true;
			} else {
				throw new Exception(__('ERROR : %s', ZuhaInflector::flatten($this->invalidFields())));
			}
		} else {
			// new gallery			
			if ($this->Gallery->add($data, $uploadFieldName)) {
				return true;
			} else {
				throw new Exception(__d('galleries', 'ERROR : Gallery add failed.', true));
			}
		}
	}
    
/**
 * Check for Gallery
 * Used to fill in the gallery id, if it exists
 * 
 * NOTE : Use $data['Gallery']['create'] = 1, and an empty GalleryImage.gallery_id to force a creation
 * @param array $data
 * @return array
 */
    public function checkForGallery($data) {
        if (empty($data['Gallery']['create']) && empty($data['GalleryImage']['gallery_id']) && (!empty($data['Gallery']['model']) && !empty($data['Gallery']['foreign_key']))) {
            $gallery = $this->Gallery->find('first', array('conditions' => array('Gallery.model' => $data['Gallery']['model'], 'Gallery.foreign_key' => $data['Gallery']['foreign_key'])));
            if (!empty($gallery)) {
                $data['GalleryImage']['gallery_id'] = $gallery['Gallery']['id'];
                $data['Gallery']['id'] = $gallery['Gallery']['id'];
            }
        }
        return $data;
    }
		
/**
 * Clean data method
 * 
 * Used to standardize data before creating or editing a gallery
 * 
 * @access protected
 * @param array
 * @return array
 */
	protected function _cleanData($data) {
		if (empty($data['GalleryImage']['gallery_id']) && !empty($data['GalleryImage']['model']) && !empty($data['GalleryImage']['foreign_key'])) {
			$gallery = $this->Gallery->find('first', array(
				'conditions' => array(
					'Gallery.model' => $data['GalleryImage']['model'],
					'Gallery.foreign_key' => $data['GalleryImage']['foreign_key'],
					),
				));
			if (!empty($gallery)) {
				$data['GalleryImage']['gallery_id'] = $gallery['Gallery']['id'];
			}
		}
		
		if (!empty($data['GalleryImage']['serverfile'])) {
			if (!empty($data['GalleryImage']['filename']['name'])) {
				$filename = $data['GalleryImage']['filename'];
				unset($data['GalleryImage']['filename']);
				$data['GalleryImage']['filename'][] = $filename;
			} else {
				unset($data['GalleryImage']['filename']);
			}
			$serverFiles = explode(',', $data['GalleryImage']['serverfile']);
			foreach ($serverFiles as $serverFile) {
				if (!empty($serverFile)) {
					$data['GalleryImage']['filename'][] = array(
						'tmp_name' => array(
							'_bypassUploadFileCheck',
							$serverFile,
							),
						);
				}
			}
		}
		return $data;
	}
	
/**
 * Filename method
 *
 * Fill out the filename array as though it was a submitted file when it was really an existing file on the server.
 *
 * @param string
 */
 	protected function _fileName($fileName) {
		if (is_array($fileName['tmp_name'])) {
			App::uses('File', 'Utility');
			$fileName['tmp_name'][1] = $this->rootPath . ZuhaSet::webrootSubPath($fileName['tmp_name'][1]);
			$File = new File($fileName['tmp_name'][1]);
			$file = $File->info(); // get the file info (basename, extension, from Cake File class)
			$file['type'] = $file['extension'] == 'jpg' ? 'image/jpeg' : 'image/' . $file['extension'];
			return $fileName = array(
				'name' => $file['basename'], 
				'type' => $file['type'],
				'tmp_name' => $fileName['tmp_name'],
				'error' => 0,
				'size' => $file['filesize'],
				);
		} else {
			return $fileName;
		}
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
			// ex. array('filename' => array('thumbsizes' => array('small' => array('width' => 50, 'height' => 50))));
			// if you name one, you must name them all with this function
			$uploadOptions = $data['UploadOptions']; 
		} else {
			// ex. array('filename' => array('thumbsizes' => array('small' => array('width' => 50, 'height' => 50))));
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
	
/**
 * Delete method
 * 
 * Delete both the record and the file on the server
 * 
 * @access public
 * @param string
 * @return bool
 */
 	public function delete($id) {
		$this->id = $id;
		if (!$this->exists()) {
			throw new Exception(__('Invalid file'));
		}
		$image = $this->read(null, $id);
		$fileName = $image['GalleryImage']['filename'];
		$file = $this->rootPath . ZuhaSet::webrootSubPath($image['GalleryImage']['dir']) . $fileName;
		
		
		if (parent::delete($id)) {
			if (file_exists($file)) {
				unlink($file); // delete the largest file
			}
			$small = str_replace($fileName, 'thumb' . DS . 'small' . DS . $fileName, $file);
			if (file_exists($small)) {
				unlink($small); // delete the small thumb
			}
			$medium = str_replace($fileName, 'thumb' . DS . 'medium' . DS . $fileName, $file);
			if (file_exists($medium)) {
				unlink($medium); // delete the medium thumb
			}
			$large = str_replace($fileName, 'thumb' . DS . 'large' . DS . $fileName, $file);
			if (file_exists($large)) {
				unlink($large); // delete the medium thumb
			}
			return true;
		} else {
			throw new Exception(__('Delete failed'));
		}
	}
		
}
