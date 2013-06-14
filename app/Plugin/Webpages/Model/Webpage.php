<?php
App::uses('WebpagesAppModel', 'Webpages.Model');
/** 
 * CMS Webpage Model.
 * Handles the cms data 
 *
 * @todo		Need to add custom validation for webpage types.  (like is_default and template_urls can't both have values)
 */
class Webpage extends WebpagesAppModel {
	
/**
 * Name
 * 
 * @var string 
 */
	public $name = 'Webpage';

/**
 * Full name
 * 
 * @var string 
 */
	public $fullName = 'Webpages.Webpage';
	
/**
 * Display Field
 * 
 * @var string 
 */
	public $displayField = 'name';
	
        
 /**
  * Acts as
  * 
  * @var array
  */
    public $actsAs = array(
        'Alias',
        'Tree', 
        'AclExtra', 
        'Galleries.Mediable' => array('modelAlias' => 'Webpage'),
     	'Metable',
		);
	
/**
 * Validate
 * 
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Page name is required.',
				),
			'uniqueRule' => array(
			   'rule' =>'isUnique',
			   'message' => 'Page name must be unique.'
                )
			)
		);

/**
 * Types
 * 
 * @var array 
 */
	public $types = array(
		'template' => 'Template',
		'element' => 'Element',
		'section' => 'Section',
		'sub' => 'Sub',
		'content' => 'Content'
		);
	
/**
 * Has Many
 * 
 * @var array
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
 * 
 * @var array
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
        
		if (CakePlugin::loaded('Search')) { 
			$this->actsAs[] = 'Search.Searchable';
		}
		if (CakePlugin::loaded('Drafts')) {
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
	public function beforeSave($options = array()) {
		$this->_saveTemplateFiles(); // does not save to the database, so doesn't come back to this beforeSave()
		return parent::beforeSave($options);
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
            $this->_syncTemplateSettings($this->id, $this->data);
        }
		return parent::afterSave($created);
	}

/**
 * After Find
 * 
 */
 	public function afterFind($results, $primary = false) {
		$results = $this->_templateContentResults($results);
		$results = parent::afterFind($results, $primary);
		return $results;
	}

	
/**
 * After Delete
 */
	public function afterDelete() {
		// delete template settings
		$this->_syncTemplateSettings($this->id, null, true);
		return parent::afterDelete();
	}

/**
 * Save All
 * 
 * @param array $data
 * @param array $options
 * @return array
 */
    public function saveAll($data = null, $options = array()) {
        $data = $this->cleanInputData($data); // this has to be here (don't try putting it in beforeValidate() and beforeSave() again)
        if (parent::saveAll($data, $options)) {
            return true;
        } else {
            throw new Exception(ZuhaInflector::invalidate($this->invalidFields()));
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
 * @todo This really needs to be redone, and cleaned.
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
				$include_container = array('start' => '<div id="webpage' . $matches[2][$i] . '" pageid="' . trim($matches[2][$i]) . '" class="edit-box global-edit-box">', 'end' => '</div>');
				break;
				default:
				$include_container = array('start' => '<div id="webpage' . trim($matches[2][$i]) . '" pageid="' . trim($matches[2][$i]) . '" class="edit-box global-edit-box">', 'end' => '</div>');
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
 * Clean Input Data
 * Before saving we need to check the data for consistency.
 *
 * @param array
 * @return array
 * @todo Clean out alias data for templates and elements.
 */
	public function cleanInputData($data) {

		if (!empty($data['Webpage']['user_roles']) && is_array($data['Webpage']['user_roles'])) {
			// serialize user roles
			$data['Webpage']['user_roles'] = serialize($data['Webpage']['user_roles']);
		}
		
		if (!empty($data['Webpage']['type']) && $data['Webpage']['type'] == 'template') {
			// correct the fiLEName to filename.ctp for templates
			$data['Webpage']['name'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9.]+/', '-', $data['Webpage']['name']), '-'));
			if (!strpos($data['Webpage']['name'], '.ctp', strlen($data['Webpage']['name']) - 4)) {
				$data['Webpage']['name'] = $data['Webpage']['name'] . '.ctp';
			}
			
		}
        
		if (empty($data['RecordLevelAccess']['UserRole'])) {
			unset($data['RecordLevelAccess']);
		} else {
			$data['Webpage']['user_roles'] = serialize($data['RecordLevelAccess']['UserRole']);
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
		
		// might not need this anymore 1/6/2012 rk, because of updates to how we handle template_urls
		// Updated to probably only decode those that are encoded ^JB  (NOPE YOU WERE WRONG, STILL OVERWRITING NON-ENCODED, BECAUSE strpos can equal zero, and the string is still there)
		// Updated to look for '==', because serialized strings should always end in '=='.  (I think, 4/21/2013)
        if (!empty($data['Webpage']['template_urls']) && strpos($data['Webpage']['template_urls'], '==')) {
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
    
/**
 * Parse a serialized template url from $this->request
 * 
 * @param string $request - A serialized $this->request->params string.
 */
    public function serializedTemplateRequest($request) {
        $request = unserialize($request['Webpage']['url']);
        $request = array('plugin' => $request['plugin'], 'controller' => $request['controller'], 'action' => $request['action'], 'named' => $request['named'], 'pass' => $request['pass']);
        if ($request['plugin'] == 'webpages' && $request['controller'] == 'webpages' && $request['action'] == 'view') {
            // webpages get special treatment
            $url = @Router::reverse($request);
            $url = strpos($url, '/') === 0 ? substr($url, 1) . '/' : $url . '/';
        } elseif ($request['action'] ==  'index') {
            $url = $request['plugin'] . '/' . $request['controller'] . '/' . $request['action'] . '*';
        } else {
            unset($request['pass']);
            unset($request['named']);
            $url = @Router::reverse($request) . '/*';
        }
        return $url;
    }

/**
 * Update template settings
 * 
 * Runs the remove and add settings as needed for a template url change
 * 
 * @params array $data
 */
    public function updateTemplateSettings($data) {
        $data = Set::merge($this->find('first', array('conditions' => array('Webpage.id' => $data['Webpage']['id']))), $data);
        $remove['Webpage']['id'] = $data['Webpage']['template_id'];
        $remove['Webpage']['url'] = $this->serializedTemplateRequest($data);
        if ($this->removeTemplateSetting($remove)) {
            // good
        } else {
            throw new Exception(__('Removal of previous template setting failed'));
        }
        if (empty($data['Webpage']['is_default'])) {
            $data['Webpage']['url'] = $this->serializedTemplateRequest($data);
            if ($this->addTemplateSetting($data)) {
                // good
            } else {
                throw new Exception(__('Adding template setting failed'));
            }
        }
        return true;
    }
    
    
/**
 * Add template setting 
 * 
 * Looks for a template, given with $data[Webpage][id]
 * And add the url given by $data[Webpage][url] to it.
 * 
 * @param array $data
 */
    public function addTemplateSetting($data) {
        $template = Set::merge($this->find('first', array('conditions' => array('Webpage.id' => $data['Webpage']['id']))), $data);
        $urls = $this->templateUrls($template, true);
        $cleaned['Webpage']['template_urls'] = !empty($urls) ? $urls . PHP_EOL . $template['Webpage']['url'] : $template['Webpage']['url'];
        $page['Webpage'] = Set::merge($template['Webpage'], $cleaned['Webpage']);                
        if ($this->save($page)) {
            return true;
        } else {
            return false;
        }
    }
    
    
/**
 * Remove template setting 
 * 
 * Looks for a template, given with $data[Webpage][id]
 * And removes the url given by $data[Webpage][url] from it.
 * 
 * @param array $data
 */
    public function removeTemplateSetting($data) {
        $template = $this->find('first', array('conditions' => array('Webpage.id' => $data['Webpage']['id'])));
        $urls = $this->templateUrls($template, true);
        $cleaned['Webpage']['template_urls'] = str_replace("\r\n", '', trim(str_replace($data['Webpage']['url'], '', $urls)));
        $page['Webpage'] = Set::merge($template['Webpage'], $cleaned['Webpage']);
        if ($this->save($page)) {
            return true;
        } else {
            return false;
        }
    }

    
/**
 * Sync the template settings.  Usually when a template is updated.
 *
 * @param int        	The id of the page we're making settings for
 * @param array			An array of data to get the template, and template settings from
 */
    private function _syncTemplateSettings() {
        $templates = $this->find('all', array(
            'conditions' => array(
                'Webpage.type' => 'template'
                ), 
            'fields' => array(
                'Webpage.id',
                'Webpage.is_default',
                'Webpage.template_urls',
                'Webpage.user_roles'
                )
            ));
        $i = 0;
        $setting['Setting']['value'] = '';
        $setting['Setting']['type'] = 'App';
        $setting['Setting']['name'] = 'TEMPLATES';
        foreach ($templates as $template) {
            $value = array('templateId' => $template['Webpage']['id'], 'isDefault' => $template['Webpage']['is_default'], 'urls' => $this->templateUrls($template), 'userRoles' => $template['Webpage']['user_roles']);
            $setting['Setting']['value'] .= 'template['.$template['Webpage']['id'].'] = "' . base64_encode(gzcompress(serialize($value))) . '"' . PHP_EOL;
            $i++;
        }
        $Setting = ClassRegistry::init('Setting');
        if ($Setting->add($setting)) {
            return true;
        } else {
            return false;
        }
    }

/**
 * Template Urls
 * Returns an compressed version of the template urls field
 * 
 * @params array
 * @return array
 */
	public function templateUrls($data = null, $sanitized = false) {
		if (!empty($data['Webpage']['template_urls'])) {
			// cleaning the string for common user entry differences
			$urls = str_replace(PHP_EOL, ',', $data['Webpage']['template_urls']);
			$urls = str_replace(' ', '', $urls);
			$urls = explode(',', $urls);
			foreach ($urls as $url) {
				$url = str_replace('/*', '*', $url);
				$url = str_replace(' ', '', $url);
				$url = str_replace(',/', ',', $url);
				$out[] = strpos($url, '/') == 0 ? substr($url, 1) : $url;
			} // end url loop
			$data['Webpage']['template_urls'] = $sanitized ? implode(Set::filter($out), PHP_EOL) : base64_encode(gzcompress(serialize(Set::filter($out))));
		}
		return $data['Webpage']['template_urls'];		
	}
	
    
/**
 * Types function
 * An array of options for select inputs
 * 
 * @return array
 */
	public function types($name = null) {
	    foreach (Zuha::enum('WEBPAGES_PAGE_TYPE') as $type) {
			$types[Inflector::underscore($type)] = $type;
	    }
		$this->types = Set::merge($this->types, $types);
		
		if (!empty($name)) {
			return $this->types[$name];
		} else {
	    	return $this->types;
		}
	}
}