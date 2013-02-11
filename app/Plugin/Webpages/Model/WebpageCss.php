<?php
App::uses('WebpagesAppModel', 'Webpages.Model');
/**
 * WebpageCss Model
 * 
 *
 * @todo 		Add copyright, and notes.
 * @todo		We have not yet finished making this available for "multi-templates" within a single site.  So right now all css files will be loaded for every template.
 * @todo		Create a simple interface for adding all of the template files at once. (css, js, and put html into a template)
 * @todo		We need to make webpage_css belongTo the webpages table and show template webpages in a drop down, that way we tie the js to particular templates, and don't have to load js on every page if its not needed theoretically.
 * @todo		Add url as a field and let us load remote css instead of local css if needed. (ie. googlecode.com css)
 */
class WebpageCss extends WebpagesAppModel {
	
	public $name = 'WebpageCss';
	
	public $useTable = 'webpage_css';
	
	public $displayField = 'name';
	
	public $validate = array(
		'type' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				'message' => 'No spaces allowed.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('custom', '/^[a-z0-9\._-]*$/i'),
				'message' => 'No spaces allowed.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
		return $this->_cssContentResults($results);
	}
	
	public function add($data, $theme=null) {
		$data = $this->_cleanData($data);
		
		if ($this->save($data)) {
			$webpageCssId = $this->id;
			// then write the css file here.
			if ($this->_cssFile($data['WebpageCss']['name'], $data['WebpageCss']['content'], $theme)) {
				// then write it to settings for easy retrieval by the default layout
				if ($this->_updateSettings()) {
					return true;
				} else {
					throw new Exception(__('Css file save failed'));
				}
			} else {
				// roll back, there was a problem
				throw new Exception(__('Css file write failed.'));
			}			
		} else {
			return false;
		}
	}
	
	public function update($data, $theme=null) {
		if ($this->add($data, $theme)) {
			return true;		
		} else {
			return false;
		}
	}
	
	
	protected function _cssFile($fileName = 'all.css', $content, $theme=null) {
		$filePath = $this->_getCssFilePath($theme) . $fileName;
		// file helper
		App::uses('File', 'Utility');
		$file = new File($filePath);
		$file->path = $filePath;
				
		if($file->write($file->prepare($content))) {
			return true;
		} else {
			throw new Exception('Css File Not Saved');
		}
	}
	
	protected function _getCssFilePath($theme=null)	{
		$themePath = null;
		if($theme)	{
			$themePath = App::themePath($theme);
		}
		// check whether this is multi-sites
		if (file_exists($themePath.WEBROOT_DIR)) {
			return $themePath.WEBROOT_DIR.DS.CSS_URL;
		} else {
			return ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.CSS_URL;
		}
	}
	
	
	public function getCssFileContents($filename, $theme = null)	{
		$filePath = $this->_getCssFilePath($theme);			
		if(file_exists($filePath.DS.$filename))	{
			return file_get_contents($filePath.DS.$filename);
		}
	}
	
	public function types() {
		return array(
			'all' => 'all',
			'screen' => 'screen',
			'print' => 'print',
			'handheld' => 'handheld',
			'braile' => 'braille',
			'embossed' => 'embossed',
			'projection' => 'projection',
			'speech' => 'speech',
			'tty' => 'tty',
			'tv' => 'tv'
			);
	}
	
	
	public function remove($id, $theme=null) {
		// find the css file being deleted
		$webpageCss = $this->find('first', array('conditions' => array('WebpageCss.id' => $id)));
		// Get file path
		$filePath = $this->_getCssFilePath($theme) . $webpageCss['WebpageCss']['name'];
		
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
				# the file was deleted.  but we're not re-creating it at this point, because it would introduce a whole 'nother set of ifs that have to go here, to check whether the file was recreated.  Until we start switching to the "try" and "throw" exceptions methods, that won't be very easy here.  And it shouldn't be a big deal because it won't be called anymore, and it would just be over written if you created a css file with the same name.
				return false;
			}
		} else {
			return false;
		}
	}
	

/**
 * Removes the setting for webpage css
 * 
 * @todo		Need to write some regex (system wide though) that will remove settings within settings, so that this will support multiple css files.  Adding multiple css files works.  Deleting one, deletes all. 
 */
	public function deleteSetting() {
		App::import('Model', 'Setting');
		$this->Setting = new Setting;
		$setting = $this->Setting->find('first', array('conditions' => array('Setting.name' => 'DEFAULT_CSS_FILENAMES')));
		if ($this->Setting->delete($setting['Setting']['id'])) {
			if ($this->Setting->writeSettingsIniData()) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	protected function _updateSettings() {
		App::import('Model', 'Setting');
		$this->Setting = new Setting;
		
		// find all of the css files that have been created
		$cssFiles = $this->find('all');
		if (!empty($cssFiles)) {
			// write the settings using all css files in existence
			$data['Setting']['type'] = 'Webpages';
			$data['Setting']['name'] = 'DEFAULT_CSS_FILENAMES';
			$data['Setting']['value'] = '';
			foreach ($cssFiles as $css) {
				if (!empty($css['WebpageCss']['webpage_id'])) {
					$data['Setting']['value'] .= $css['WebpageCss']['type'].'[] = '.$css['WebpageCss']['webpage_id'].','.$css['WebpageCss']['name'].PHP_EOL;
				} else {
					$data['Setting']['value'] .= $css['WebpageCss']['type'].'[] = '.$css['WebpageCss']['name'].PHP_EOL;
				}
			}
			if ($this->Setting->add($data)) {
				return true;
			} else {
				return false;
			}
		} else {
			// if its empty then just delete the setting
			$setting = $this->Setting->find('first', array('conditions' => array('Setting.name' => 'DEFAULT_CSS_FILENAMES')));
			if ($this->Setting->delete($setting['Setting']['id'])) {
				if ($this->Setting->writeSettingsIniData()) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	protected function _cleanData($data) {
		if(!strpos($data['WebpageCss']['name'], '.css')) {
			$data['WebpageCss']['name'] = $data['WebpageCss']['name'].'.css';
                }
			
		return $data;
	}
	
/**
 * Template Content Results
 * If there is a file, return the file contents instead of the db contents
 * 
 * @return array
 */
 	protected function _cssContentResults($results) { 
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		if (!empty($results[0]['WebpageCss']['name'])) {
			$dir = new Folder( $this->cssDirectory);
			$file = $dir->find($results[0]['WebpageCss']['name']);
			
			if (!empty($file[0])) {
				$file = new File($dir->path . $file[0]);
				$results[0]['WebpageCss']['content'] = $file->read();				
				$file->close(); // Be sure to close the file when you're done
			}
		}
		return $results;
	}
	
}