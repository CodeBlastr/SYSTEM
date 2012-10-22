<?php
/**
 * WebpageJs Model
 * 
 *
 * @todo 		Add copyright, and notes.
 * @todo		We have not yet finished making this available for "multi-templates" within a single site.  So right now all Js files will be loaded for every template.
 * @todo		Create a simple interface for adding all of the template files at once. (css, js, and put html into a template)
 * @todo		We need to make webpage_js belongTo the webpages table and show template webpages in a drop down, that way we tie the js to particular templates, and don't have to load js on every page if its not needed theoretically.
 * @todo		Add url as a field and let us load remote js instead of local js if needed. (ie. googlecode.com js)
 */
class WebpageJs extends WebpagesAppModel {
	
	public $name = 'WebpageJs';
	public $useTable = 'webpage_js';
	public $displayField = 'name';
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
	
	public function add($data, $theme=null) {
		$data = $this->_cleanData($data);
		
		if ($this->save($data)) {
			$webpageJsId = $this->id;
			// then write the js file here.
			if ($this->_jsFile($data['WebpageJs']['name'], $data['WebpageJs']['content'], $theme)) {
				// then write it to settings for easy retrieval by the default layout
				if ($this->_updateSettings()) {
					return true;
				} else {;
					throw new Exception(__('webpages', 'Javascript settings update failed'));
				}
			} else {
				throw new Exception(__('webpages', 'Javascript file write failed'));
			}			
		} else {
			throw new Exception(__('webpages', 'Javascript add failed'));
		}
	}
	
	public function update($data, $theme=null) {
		if ($this->add($data, $theme)) {
			return true;		
		} else {
			return false;
		}
	}
	
	
	public function _jsFile($fileName = 'all.js', $content, $theme=null) {

		$filePath = $this->_getJsFilePath($theme) . $fileName;
		# file helper
		App::uses('File', 'Utility');
		$file = new File($filePath);
		$file->path = $filePath;
		if($file->write($file->prepare($content))) {
			return true;
		} else {
			return false;
		}
	}
		
	public function _getJsFilePath($theme=null)	{
		$themePath = null;
		if($theme)	{
			$themePath = App::themePath($theme);
		}
		# check whether this is multi-sites
		if (file_exists($themePath.WEBROOT_DIR)) {
			return $themePath.WEBROOT_DIR.DS.JS_URL;
		} else {
			return ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.JS_URL;
		}
	}	
	
	public function getJsFileContents($filename, $theme=null)	{
		$filePath = $this->_getJsFilePath($theme);			
		if(file_exists($filePath.DS.$filename))	{
			return file_get_contents($filePath.DS.$filename);
		}
	}
	
	
	public function remove($id, $theme=null) {
		# find the js file being deleted
		$webpageJs = $this->find('first', array('conditions' => array('WebpageJs.id' => $id)));
		# Get file path
		$filePath = $this->_getJsFilePath($theme) . $webpageJs['WebpageJs']['name'];
		#import the file helper
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
				# the file was deleted.  but we're not re-creating it at this point, because it would introduce a whole 'nother set of ifs that have to go here, to check whether the file was recreated.  Until we start switching to the "try" and "throw" exceptions methods, that won't be very easy here.  And it shouldn't be a big deal because it won't be called anymore, and it would just be over written if you created a js file with the same name.
				return false;
			}
		} else {
			return false;
		}
	}
	
	
/**
 * Removes the setting for webpage js
 * 
 * @todo		Need to write some regex (system wide though) that will remove settings within settings, so that this will support multiple js files.  Adding multiple js files works.  Deleting one, deletes all. 
 */
	public function deleteSetting() {
		App::import('Model', 'Setting');
		$this->Setting = new Setting;
		$setting = $this->Setting->find('first', array('conditions' => array('Setting.name' => 'DEFAULT_JS_FILENAMES')));
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
		
		# find all of the js files that have been created
		$jsFiles = $this->find('all');
		if (!empty($jsFiles)) {
			# write the settings using all js files in existence
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
			if ($this->Setting->add($data)) {
				return true;
			} else {
				return false;
			}
		} else {
			# if its empty then just delete the setting
			$setting = $this->Setting->find('first', array('conditions' => array('Setting.name' => 'DEFAULT_JS_FILENAMES')));
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
		if(!strpos($data['WebpageJs']['name'], '.js')) :
			$data['WebpageJs']['name'] = $data['WebpageJs']['name'].'.js';
		endif;
			
		return $data;
	}
	
}