<?php
/** 
 * CMS Webpage Model.
 * Handles the cms data 
 *
 * @todo		Need to add custom validation for webpage types.  (like is_default and template_urls can't both have values)
 */
class Webpage extends WebpagesAppModel {
	
/**
 * Name
 */
	public $name = 'Webpage';

/**
 * Full Name
 */
	public $fullName = "Webpages.Webpage";
	
/**
 * Displayfield
 */
	public $displayField = 'name';
	
/** 
 * Validate
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Name field is required.',
				)
			)
		);
	
/**
 * Types
 */
	public $types = array(
		'template' => 'Template',
		'element' => 'Element',
		'content' => 'Content'
		);
	
/**
 * Has One
 */
 	public $hasOne = array(
		'Alias' => array(
			'className' => 'Alias',
			'foreignKey' => 'value',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		    ),
	    );
	
/**
 * Has Many
 */
	public $hasMany = array(
		'Child' => array(
			'className' => 'Webpages.Webpage',
			'foreignKey' => 'parent_id',
		        'conditions' => '',
		    ),
	    );
	
/**
 * Belongs To
 */
	public $belongsTo = array(
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
		    ),
	    'Parent' => array(
			'className' => 'Webpages.Webpage',
			'foreignKey' => 'parent_id',
			'conditions' => ''
		    ),
	    );
	
/** 
 * Filter Args
 */
    public $filterArgs = array(
        array('name' => 'name', 'type' => 'like'),
        array('name' => 'filter', 'type' => 'query', 'method' => 'orConditions'),
   		);
	
/**
 * Constructor
 */
	public function __construct($id = false, $table = null, $ds = null) {
		if (in_array('Search', CakePlugin::loaded())) { 
			$this->actsAs[] = 'Search.Searchable';
		}
		if (in_array('Drafts', CakePlugin::loaded())) {
			$this->actsAs['Drafts.Draftable'] = array('conditions' => array('type' => 'content'));
		}
				
		parent::__construct($id, $table, $ds);
	}

/**
 * Before Save
 *
 * @param boolean $created
 * @return boolean
 * @access public
 */
	public function beforeSave($options) {
		$this->data = $this->cleanInputData($this->data);
		$this->_saveTemplateFiles();		
		return true;
	}

/**
 * After Save
 *
 * @param boolean $created
 * @return boolean
 * @access public
 */
	public function afterSave($created) {
        if ($this->data['Webpage']['type'] == 'template') {
            // template settings are special
            $this->_saveTemplateSettings($this->id, $this->data);
        }
	}

/**
 * After Find
 * 
 */
 	public function afterFind($results, $primary) {
		return $this->_templateContentResults($results);
	}

	
/**
 * After Delete
 */
	public function afterDelete() {
		// delete template settings
		$this->_saveTemplateSettings($this->id, null, true);
	}

	
/**
 * Delete this if commenting it out doesn't cause a problem 10/21/2012 RK
    public function orConditions($data = array()) {
        $filter = $data['filter'];
		debug($filter);
        $cond = array(
            'OR' => array(
                $this->alias . '.name LIKE' => '%' . $filter . '%',
                $this->alias . '.content LIKE' => '%' . $filter . '%',
				$this->alias . '.type' => $filter,
            ));
        return $cond;
    }
 */
	
/**
 * Add function
 *
 * @param array
 * @return bool	
 */
	public function add($data = array()) {
		$data = $this->cleanInputData($data);
        
		if ($this->saveAll($data)) {
			return true;
		} else {
			throw new Exception(ZuhaInflector::invalidate($this->invalidFields()));
		}
		//Revisit this because I could not find where the function is, and it could be made better 
		//with having it possible to restrict user roles or available to only certain user roles
		// if permissions are set, restrict them
		//if (!empty($this->request->data['ArosAco']['aro_id'])) {
		//	$this->__restrictGroupPermissions($acoParent, $this->Webpage->id, $this->request->data['ArosAco']['aro_id'], true);
		//}
	}
    
    
/**
 * When a page is a template we have to save the settings for that template, so that we know when to show it.
 *
 * @param int			The id of the page we're making settings for
 * @param array			An array of data to get the template, and template settings from
 */
	private function _saveTemplateSettings($pageId, $data = null, $delete = false) {
		if(!empty($data['Webpage']['is_default']) || !empty($data['Webpage']['template_urls'])) {
			$settings = array(
				'templateId' => $pageId,
				'isDefault' => $data['Webpage']['is_default'],
				'urls' => '"'.$data['Webpage']['template_urls'].'"',
				'userRoles' => $data['Webpage']['user_roles'],
				);
		
            if (defined('__APP_TEMPLATES')) {
                @extract(unserialize(__APP_TEMPLATES));
            }

            $template[$pageId] = !empty($settings) ? base64_encode(gzcompress(serialize($settings))) : null;

            $data['Setting']['value'] = '';
            $data['Setting']['type'] = 'App';
            $data['Setting']['name'] = 'TEMPLATES';
            foreach ($template as $key => $value) {
                // merge existing values here
                if ($delete && $key == $pageId) {
                    // doing nothing should remove the value from the settings
                } else {
                    $data['Setting']['value'] .= 'template['.$key.'] = "'.$value.'"'.PHP_EOL;
                }
            }

            $this->Setting = ClassRegistry::init('Setting');
            if ($this->Setting->add($data)) {
                return true;
            } else {
                return false;
            }
		}
	}
		
/**
 * Parse Included Pages 
 * Used to combine multiple pages into a single page using standardized template tags
 * 
 * @param object
 * @param array
 * @param string
 * @param string
 * @param object
 * @return string
 */
	public function parseIncludedPages(&$webpage, $parents = array(), $action = 'page', $userRoleId = null, $request = null) {
	    $requestUrl = $request->url;
	    if(isset($request->params['alias'])) {
			$aliasName = $request->params['alias'];
	    } else {
			$aliasName = '';
	    }

	    if(isset($webpage['Alias'])) {
			if(!empty($webpage['Alias']['name']) && empty($aliasName)) {
			    $aliasName = $webpage['Alias']['name'];
			}
	    }
	    
	    $matches = array();
	    $parents[] = $webpage['Webpage']['id'];
	    preg_match_all("/(\{page:([^\}\{]*)([0-9]*)([^\}\{]*)\})/", $webpage["Webpage"]["content"], $matches);
	    for ($i = 0; $i < sizeof($matches[2]); $i++) {
			if (in_array($matches[2][$i], $parents)) {
		   		$webpage["Webpage"]["content"] = str_replace($matches[0][$i], "", $webpage['Webpage']['content']);
		    	continue;
			}
			switch ($action) {
				case 'site_edit':
				$include_container = array('start' => '<div contenteditable="false" id="edit_webpage_include' . $matches[2][$i] . '" pageid="' . trim($matches[2][$i]) . '" class="global_edit_area">', 'end' => '</div>');
				break;
				default:
				$include_container = array('start' => '<div id="edit_webpage_include' . trim($matches[2][$i]) . '" pageid="' . trim($matches[2][$i]) . '" class="global_edit_area">', 'end' => '</div>');
			}

		// remove the div.global_edit_area's if this user is not userRoleId = 1
		if ($userRoleId !== '1') {
		    $include_container = array('start' => '', 'end' => '');
		}

		$webpage2 = $this->find("first", array(
		    "conditions" => array("Webpage.id" => trim($matches[2][$i])),
		    'contain' => array('Child'),
		    ));

		/** @todo Find out WTF this was for **/
		if (empty($webpage2) || !is_array($webpage2)) {
		    continue;
		}

		if(!empty($webpage2['Child'])) {
		    foreach($webpage2['Child'] as $child) {
				$urls = unserialize(gzuncompress(base64_decode($child['template_urls'])));
				if(!empty($urls)) {
					foreach($urls as $url) {
						$urlString = str_replace('/', '\/', trim($url));
						$urlRegEx = '/'.str_replace('*', '(.*)', $urlString).'/';
						$urlRegEx = strpos($urlRegEx, '\/') === 1 ? '/'.substr($urlRegEx, 3) : $urlRegEx;
						$urlCompare = strpos($requestUrl, '/') === 0 ? substr($requestUrl, 1) : $requestUrl;
		
						if (preg_match($urlRegEx, $urlCompare)) {
							$webpage2['Webpage'] = $child;
							break;
						}
	
						if(!empty($aliasName)) {
							if($aliasName[strlen($aliasName)-1] !== '/') {
								$aliasName .= '/';
							}
							
							$urlCompare = strpos($aliasName, '/') === 0 ? substr($aliasName, 1) : $aliasName;
							
							if (preg_match($urlRegEx, $urlCompare)) {
								$webpage2['Webpage'] = $child;
								break;
							}
						}
					}
				}
		    }
		}
			
		$this->parseIncludedPages($webpage2, $parents, $action, $userRoleId, $request);
		
			if ($webpage['Webpage']['type'] == 'template') {
				$webpage["Webpage"]["content"] = str_replace($matches[0][$i], $include_container['start'] . $webpage2["Webpage"]["content"] . $include_container['end'], $webpage["Webpage"]["content"]);
			} else {
				$webpage["Webpage"]["content"] = str_replace($matches[0][$i], $webpage2["Webpage"]["content"], $webpage["Webpage"]["content"]);
			}
	    }
	}
	
/**
 * Types function
 * 
 * @return array
 */
	public function types() {
		return $this->types;
	}
	
/**
 * Clean Input Data
 * Before saving we need to check the data for consistency.
 *
 * @param array
 * @return array
 * @todo Clean out alias data for templates and elements.
 */
	public function cleanInputData($data) {
		if (!empty($data['Webpage']['user_roles']) && is_array($data['Webpage']['user_roles'])) {
			# serialize user roles
			$data['Webpage']['user_roles'] = serialize($data['Webpage']['user_roles']);
		}
		
		if (!empty($data['Webpage']['template_urls'])) {
			# cleaning the string for common user entry differences
			$urls = str_replace(PHP_EOL, ',', $data['Webpage']['template_urls']);
			$urls = str_replace(' ', '', $urls);
			$urls = explode(',', $urls);
			foreach ($urls as $url) {
				$url = str_replace('/*', '*', $url);
				$url = str_replace(' ', '', $url);
				$url = str_replace(',/', ',', $url);
				$out[] = strpos($url, '/') == 0 ? substr($url, 1) : $url;
			} // end url loop
			$data['Webpage']['template_urls'] = base64_encode(gzcompress(serialize($urls)));
		}		
		
		if (empty($data['Alias']['name'])) {
			// remove the alias if the name is blank
			unset($data['Alias']);
		}
		
		if ($data['Webpage']['type'] == 'template') {
			// correct the fiLEName to filename.ctp for templates
			$data['Webpage']['name'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9.]+/', '-', $data['Webpage']['name']), '-'));
			if (!strpos($data['Webpage']['name'], '.ctp', strlen($data['Webpage']['name']) - 4)) {
				$data['Webpage']['name'] = $data['Webpage']['name'] . '.ctp';
			}
			
		}
		
		return $data;
	}
	
	
/**
 * Clean Output Data
 *
 * @param array
 * @return array
 * @todo Clean out alias data for templates and elements.
 */
	public function cleanOutputData($data) {
		if (!empty($data['Webpage']['user_roles'])) {
			$data['Webpage']['user_roles'] = unserialize($data['Webpage']['user_roles']);
		}
		
		if (!empty($data['Webpage']['template_urls'])) {
			$data['Webpage']['template_urls'] = implode(PHP_EOL, unserialize(gzuncompress(base64_decode($data['Webpage']['template_urls']))));
		}		
		
		return $data;
	}
	
/**
 * Handle Error
 * 
 * @param array
 * @param object
 * @return array
 */
	public function handleError($webpage, $request) {
		$userRole = CakeSession::read('Auth.User.user_role_id');
		$addLink = $userRole == 1 ? '<p class="message">Page Not Found : <a href="/webpages/webpages/add/content/alias:' . str_replace('/', '+', $_GET['referer']) . '"> Click here to add a page at http://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['referer'] . '</a>. <br /><br /><small>Because you are the admin you can add the page you requested.  After you add the page, you can visit http://' . $_SERVER['HTTP_HOST'] . '/' . $_GET['referer'] . ' again and it will be a working page.</small></p><br />' : '';
		$webpage['Webpage']['content'] = $addLink . $webpage['Webpage']['content'];
		return $webpage;
	}

/**
 * Save Template Files
 * Note : If the name is empty that should mean that its coming from the file sync method and should not use this function
 *
 * @return bool
 * @todo put in unit testing for thie name thing
 */
 	protected function _saveTemplateFiles() {
		if (!empty($this->data['Webpage']['name']) && $this->data['Webpage']['type'] == 'template') {
			// if the name is empty that should mean that its coming from the file sync method and should not use this function
			App::uses('Folder', 'Utility');
			App::uses('File', 'Utility');
			$dir = new Folder($this->templateDirectories[0], true, 0755);
			$file = new File($this->templateDirectories[0] . $this->data['Webpage']['name'], true, 0644);
			try {
				$file->write($this->data['Webpage']['content'], 'w', true);
				$file->close(); // Be sure to close the file when you're done
				return true;
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
	}
	
/**
 * Template Content Results
 * If there is a file, return the file contents instead of the db contents
 * 
 * @return array
 */
 	protected function _templateContentResults($results) { 
		if (!empty($results[0]['Webpage']['type']) && $results[0]['Webpage']['type'] == 'template') {
			App::uses('Folder', 'Utility');
			App::uses('File', 'Utility');
			
			foreach($this->templateDirectories as $directory) {
				$dir = new Folder( $directory);
				$file = $dir->find($results[0]['Webpage']['name']);
				break;
			}
			
			if (!empty($file[0])) {
				$file = new File($dir->path . $file[0]);
				$results[0]['Webpage']['content'] = $file->read();				
				$file->close(); // Be sure to close the file when you're done
			}
		}
		return $results;
	}
	
}