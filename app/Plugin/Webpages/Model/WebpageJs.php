<?php
App::uses('WebpagesAppModel', 'Webpages.Model');
/**
 * WebpageJs Model
 *
 * @todo		Add url as a field and let us load remote js instead of local js if needed. (ie. googlecode.com js)
 */
class WebpageJs extends WebpagesAppModel {
	
	public $name = 'WebpageJs';
	
	public $useTable = 'webpage_js';
	
	public $displayField = 'name';
	
	public $theme = 'Default';
	
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('custom', '/^[a-z0-9\._-]*$/i'),
				'message' => 'No spaces allowed.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			'uniqueRule' => array(
			   'rule' =>'isUnique',
			   'message' => 'Js file name must be unique.'
                )
			),
		'content' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $belongsTo = array(
		'Webpage' => array(
			'className' => 'Webpages.Webpage',
			'foreignKey' => 'webpage_id',
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

/**
 * After Find
 * 
 */
 	public function afterFind($results, $primary = false) {
		return $this->_jsContentResults($results);
	}
	
/**
 * Before save callback
 * 
 */
 	public function beforeSave($options = array()) {
		$this->data = $this->_cleanData($this->data);
 		return parent::beforeSave($options);
 	}
	
/**
 * After save callback
 * 
 */
 	public function afterSave($created) {
		// then write the js file here.
		if ($this->_jsFile($this->data['WebpageJs']['name'], $this->data['WebpageJs']['content'])) {
			// then write it to settings for easy retrieval by the default layout
			if ($this->_updateSettings()) {
				return true;
			} else {;
				throw new Exception(__('webpages', 'Javascript settings update failed'));
			}
		} else {
			throw new Exception(__('webpages', 'Javascript file write failed'));
		}
 		return parent::afterSave($created);
 	}
	
	
/**
 * Add method
 * 
 * @todo  Deprecated and will be removed in future versions 9/7/2013 RK
 */
	public function add($data = null, $validate = true, $fieldList = array()) {
		return $this->save($data, $validate, $fieldList);
	}
	
/**
 * Update method
 * 
 * @todo  Deprecated and will be removed in future versions 9/7/2013 RK
 */
	public function update($data = null, $validate = true, $fieldList = array()) {
		return $this->save($data, $validate, $fieldList);
	}
	
/**
 * Js file method
 * 
 * writes a js file
 * @param string $fileName
 * @param string $content
 */
	public function _jsFile($fileName = 'all.js', $content) {
		$filePath = $this->_getJsFilePath() . $fileName;
		// file helper
		App::uses('File', 'Utility');
		$file = new File($filePath);
		$file->path = $filePath;
		if($file->write($file->prepare($content))) {
			return true;
		} else {
			return false;
		}
	}

/**
 * Get Js File Path method
 * 
 */
	protected function _getCssFilePath()	{
		//$themePath = App::themePath($this->theme);
		$themePath = App::path('View');
		// check whether this is multi-sites
		if (file_exists($themePath[2].WEBROOT_DIR)) {
			return $themePath[2].WEBROOT_DIR.DS.CSS_URL;
		}
		throw new Exception(__('Theme path does not exist'));
	}

/**
 * Get Js File Path method
 * 
 */
	public function _getJsFilePath()	{
		//$themePath = App::themePath($this->theme);
		$themePath = App::path('View');
		// check whether this is multi-sites
		if (file_exists($themePath[2].WEBROOT_DIR)) {
			return $themePath[2].WEBROOT_DIR.DS.JS_URL;
		}
		throw new Exception(__('Theme path does not exist for js.'));
	}
	
/**
 * Get Js File Contents method
 * 
 * @param string $filename
 */
	public function getJsFileContents($filename)	{
		$filePath = $this->_getJsFilePath();			
		if(file_exists($filePath.DS.$filename))	{
			return file_get_contents($filePath.DS.$filename);
		}
	}
	
/**
 * Remove method
 */
	public function remove($id) {
		// find the js file being deleted
		$webpageJs = $this->find('first', array('conditions' => array('WebpageJs.id' => $id)));
		// Get file path
		$filePath = $this->_getJsFilePath() . $webpageJs['WebpageJs']['name'];
		// import the file helper
		App::uses('File', 'Utility');
		$file = new File($filePath);
		$file->path = $filePath;
		
		if($file->delete()) {
			if ($this->delete($id)) {
				if ($this->_updateSettings()) {
					return true;
				} else {
					return false;
				}
			} else {
				// the file was deleted.  but we're not re-creating it at this point, because it would introduce 
				// a whole 'nother set of ifs that have to go here, to check whether the file was recreated.  
				// Until we start switching to the "try" and "throw" exceptions methods, that won't be very easy here.  
				// And it shouldn't be a big deal because it won't be called anymore, and it would just be over 
				// written if you created a js file with the same name.
				return false;
			}
		} else {
			return false;
		}
	}
	
	
/**
 * Removes the setting for webpage js
 * 
 * @todo Need to write some regex (system wide though) that will remove settings within settings, so that this will support multiple js files.  Adding multiple js files works.  Deleting one, deletes all. 
 */
	public function deleteSetting() {
		App::import('Model', 'Setting');
		$Setting = new Setting;
		$setting = $Setting->find('first', array('conditions' => array('Setting.name' => 'DEFAULT_JS_FILENAMES')));
		if ($Setting->delete($setting['Setting']['id'])) {
			if ($Setting->writeSettingsIniData()) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
/**
 * Update settings method
 * 
 */
	protected function _updateSettings() {
		App::import('Model', 'Setting');
		$Setting = new Setting;
		
		// find all of the dynamic js files 
		$jsFiles = $this->find('all', array('conditions' => array('WebpageJs.is_requested' => 0)));
		if (!empty($jsFiles)) {
			// write the settings using all js files in existence
			$data['Setting']['type'] = 'Webpages';
			$data['Setting']['name'] = 'DEFAULT_JS_FILENAMES';
			$data['Setting']['value'] = '';
			foreach ($jsFiles as $js) {
				if (!empty($js['WebpageJs']['webpage_id'])) {
					$data['Setting']['value'] .= @$js['WebpageJs']['type'].'text/javascript[] = '.$js['WebpageJs']['webpage_id'].','.$js['WebpageJs']['name'].PHP_EOL;
				} else {
					$data['Setting']['value'] .= 'text/javascript[] = '.$js['WebpageJs']['name'].PHP_EOL;
				}
			}
			if ($Setting->add($data)) {
				return true;
			} else {
				return false;
			}
		} else {
			// if its empty then just delete the setting
			$setting = $Setting->find('first', array('conditions' => array('Setting.name' => 'DEFAULT_JS_FILENAMES')));
			if ($Setting->delete($setting['Setting']['id'])) {
				if ($Setting->writeSettingsIniData()) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	
/**
 * Clean data method
 */
	protected function _cleanData($data) {
		$data = !empty($data) ? $data : $this->data;
		if(!strpos($data['WebpageJs']['name'], '.js')) {
			$data['WebpageJs']['name'] = $data['WebpageJs']['name'].'.js';
		}
		
		return $data;
	}
	
/**
 * Template Content Results
 * If there is a file, return the file contents instead of the db contents
 * 
 * @return array
 */
 	protected function _jsContentResults($results) { 
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		if (!empty($results[0]['WebpageJs']['name'])) {
			$dir = new Folder( $this->jsDirectory);
			$file = $dir->find($results[0]['WebpageJs']['name']);
			
			if (!empty($file[0])) {
				$file = new File($dir->path . $file[0]);
				$results[0]['WebpageJs']['content'] = $file->read();				
				$file->close(); // Be sure to close the file when you're done
			}
		}
		return $results;
	}
	
}