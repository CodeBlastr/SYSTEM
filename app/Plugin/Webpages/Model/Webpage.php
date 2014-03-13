<?php
App::uses('WebpagesAppModel', 'Webpages.Model');
/** 
 * CMS Webpage Model.
 * Handles the cms data
 * 
 * @property Webpage Webpage
 * @todo Need to add custom validation for webpage types.  (like is_default and template_urls can't both have values)
 */
class AppWebpage extends WebpagesAppModel {
	
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
	
	public $urlRegEx = '';
	
	public $urlCompare = '';
	
	private $_deleteFile = '';
        
 /**
  * Acts as
  * 
  * @var array
  */
    public $actsAs = array(
        'Optimizable',
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
		'content' => 'Content',
		'email' => 'Email'
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
		    )
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
 *  Holder for tokens
 */
    
    public $tokens = array();
	
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
		if (CakePlugin::loaded('Media')) {
			$this->actsAs[] = 'Media.MediaAttachable';
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
	public function afterSave($created, $options = array()) {
        if ($this->data['Webpage']['type'] == 'template') {
            // template settings are special
            $this->_syncTemplateSettings($this->id, $this->data);
        }
		if ($created && !empty($this->data['WebpageMenuItem']['parent_id'])) {
			App::uses('WebpageMenuItem', 'Webpages.Model');
			$WebpageMenuItem = new WebpageMenuItem();
			$WebpageMenuItem->create();
			if (!$WebpageMenuItem->save($this->data)) {
				throw new Exception(__('Problem adding menu item for this page.'));
			}
		}
		return parent::afterSave($created, $options);
	}

/**
 * After Find callback
 * 
 */
 	public function afterFind($results, $primary = false) {
		$results = $this->_templateContentResults($results);
		for ($i = 0; $i < count($results); ++$i) {
			if (!empty($results[$i]['Child'][0])) {
				$results[$i]['Webpage']['type'] = 'section';
			}
		}
		return parent::afterFind($results, $primary);
	}
	
/**
 * Before delete callback
 * Used to get file name for the after Delete callback
 * 
 * @param boolean
 */
	public function beforeDelete($cascade = true) {
		$page = $this->read(null, $this->id);
		if ($page['Webpage']['type'] == 'template') {
			$this->_deleteFile = $page['Webpage']['name'];
		}
		return parent::beforeDelete($cascade);
	}

	
/**
 * After Delete
 */
	public function afterDelete() {
		// delete template settings
		$this->_syncTemplateSettings($this->id, null, true);
		// delete file 
		$this->_deleteFile();
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
        $matches = array();
        preg_match_all("/(\{page:([^\}\{]*)([0-9]*)([^\}\{]*)\})/", $webpage['Webpage']['content'], $matches);
        for ($i = 0; $i < sizeof($matches[2]); $i++) {
        	$includeTag = $matches[0][$i];
			$paths = App::path('View');
			$file = $paths[2].'Elements'.DS.trim($matches[2][$i]).'.ctp'; // we could support other paths in the future
			if ($content = @file_get_contents($file)) {
				// a lighter call (no children possible, so no contains), but I'd still like to get rid of it somehow
				$includeId = $this->field('id', array('Webpage.name' => trim($matches[2][$i])));
			} else {
				$conditions = is_numeric(trim($matches[2][$i])) ? array('Webpage.id' => trim($matches[2][$i])) : array('Webpage.name' => trim($matches[2][$i]));
				$include = $this->find('first', array(
					'conditions' => $conditions,
					'contain' => array(
						'Child' => array(
							'fields' => array(
								'Child.id',
								'Child.template_urls',
								'Child.content'
							)
						)
					),
					'fields' => array(
						'Webpage.id',
						'Webpage.content',
						),
					'callbacks' => false
					));
					
				if (empty($include) || !is_array($include)) {
					continue; // skip everything below, go back to the top of the loop (the include was not found)
				} else {
					$include = $this->_includeChildren($include, $request->url); // check the include to see if we overwrite with a child
					$includeId = $include['Webpage']['id'];
					$content = $include['Webpage']['content'];
				}
			}
			// where the replacement of the template tag happens
			if ( CakeSession::read('Auth.User.user_role_id') == '1' ) {
				$includeContainer = array('start' => __('<div id="webpage%s" pageid="%s" class="edit-box global-edit-box">', $includeId, $includeId), 'end' => '</div>');
				$tagReplace = $includeContainer['start'] . $content . $includeContainer['end'];
			} else {
				$tagReplace = $content;
			}
			$webpage['Webpage']['content'] = str_replace($includeTag, $tagReplace, $webpage['Webpage']['content']);
		}
	}

/**
 * Include children method
 * 
 * This allows us to have a parent element, with variations on that element depending on what url you're at.
 * @param array $include (the webpage data array)
 * @param string $requestUrl (the request url that is asking for parsing)
 */
	protected function _includeChildren($include, $requestUrl) {
		if(!empty($include['Child'])) {
			foreach($include['Child'] as $child) {
				$urls = unserialize(gzuncompress(base64_decode($child['template_urls'])));
				if(!empty($urls)) {
					foreach($urls as $url) {
						$urlString = str_replace('/', '\/', trim($url));
						$urlRegEx = '/'.str_replace('*', '(.*)', $urlString).'/';
						$urlRegEx = strpos($urlRegEx, '\/') === 1 ? '/'.substr($urlRegEx, 3) : $urlRegEx;
						$urlCompare = strpos($requestUrl, '/') === 0 ? substr($requestUrl, 1) : $requestUrl;
						$urlRegEx = $urlRegEx;
						$urlCompare = $urlCompare;
						if (preg_match($urlRegEx, $urlCompare)) {
							$include['Webpage'] = $child;
							break;
						}
					}
				}
			}
		}
		return $include;
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
			// deprecated, because this function is called with saveAll(), not save()
			// $data['Webpage']['user_roles'] = '';
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
 * Install template files
 * 
 * Installs more than just a single template file when given 
 * a structured array. Incluing CSS, JS, and Images
 * 
 * We require that templates are written with unique names, for every piece. 
 * So prefix elements, and css, and js, etc.
 * 
 * @param array $data
 * @param array options
 * @return boolean
 * @todo This function could be tightened up by abstracting the model name.  It's very repetitive with the only change being the model name.
 */
	public function installTemplate($data = array(), $options = array()) {
		if (!empty($data)) {
			for ($i = 0; $i < count($data); $i++) {
				if (key($data[$i]) == 'Webpage') {
					if ($data[$i]['Webpage']['type'] == 'template') {
						// put template settings in
						if ($options['type'] == 'default') {
							// add default if set in options
							$data[$i]['Webpage']['is_default'] = 1;
						}
					}
					// validate first, because we may want to save even if it fails (with some updated info)
					$this->set($data[$i]);
					if ($this->validates()) {
						$this->create();
						if ($this->save($data[$i])) {
							$data[$i]['Webpage']['type'] == 'template' ? $templateId = $this->id : null;
							continue;
						} 
        			} else {
						// we seem to be installing a template that as already been installed (or two templates have a name conflict)
						// we're going to overwrite the existing file if it is of the same type with the same name. 
   						$errors = $this->validationErrors;
						if ($errors['name'][0] == $this->validate['name']['uniqueRule']['message']) {
							$data[$i]['Webpage']['id'] = $this->field('id', array('type' => $data[$i]['Webpage']['type'], 'name' => $data[$i]['Webpage']['name']));
							$i = $i - 1; continue; // re-run the loop for the current $i
						}
					}
					throw new Exception(__('%s template file saved failed', $data[$i]['Webpage']['name']));
				}

				if (key($data[$i]) == 'WebpageCss') {
					$WebpageCss = ClassRegistry::init('Webpages.WebpageCss');
					$data[$i]['WebpageCss']['webpage_id'] = $templateId;
					// validate first, because we may want to save even if it fails (with some updated info)
					$WebpageCss->set($data[$i]);
					if ($WebpageCss->validates()) {
						$WebpageCss->create();
						if ($WebpageCss->save($data[$i])) {
							continue;
						}
					} else {
						// we seem to be installing a template that as already been installed (or two templates have a name conflict)
						// we're going to overwrite the existing file if it is of the same type with the same name. 
						$errors = $WebpageCss->validationErrors;
						if ($errors['name'][0] == $WebpageCss->validate['name']['uniqueRule']['message']) {
							$data[$i]['WebpageCss']['id'] = $WebpageCss->field('id', array('name' => $data[$i]['WebpageCss']['name']));
							$i = $i - 1; continue; // re-run the loop for the current $i
						}
					}
					throw new Exception(__('%s css save failed', $data[$i]['WebpageCss']['name']));
				}
				
				if (key($data[$i]) == 'WebpageJs') {
					$WebpageJs = ClassRegistry::init('Webpages.WebpageJs');
					$data[$i]['WebpageJs']['webpage_id'] = $templateId;
					// validate first, because we may want to save even if it fails (with some updated info)
					$WebpageJs->set($data[$i]);
					if ($WebpageJs->validates()) {
						$WebpageJs->create();
						if ($WebpageJs->save($data[$i])) {
							continue;
						}
					} else {
						// we seem to be installing a template that as already been installed (or two templates have a name conflict)
						// we're going to overwrite the existing file if it is of the same type with the same name. 
						$errors = $WebpageJs->validationErrors;
						if ($errors['name'][0] == $WebpageJs->validate['name']['uniqueRule']['message']) {
							$data[$i]['WebpageJs']['id'] = $WebpageJs->field('id', array('name' => $data[$i]['WebpageJs']['name']));
							$i = $i - 1; continue; // re-run the loop for the current $i
						}
					}
					throw new Exception(__('%s js save failed', $data[$i]['WebpageCss']['name']));
				}
			}
		} else {
			throw new Exception(__('Template data is corrupt.'));
		}
		return true;
	}

/**
 * Save Template Files
 * Note : If the name is empty that should mean that its coming from the file sync method and should not use this function
 *
 * @return bool
 * @todo put in unit testing for this name thing
 */
 	protected function _saveTemplateFiles() {
		// save template
		if (!empty($this->data['Webpage']['name']) && $this->data['Webpage']['type'] == 'template') {
			// if the name is empty that should mean that its coming from the file sync method and should not use this function
			$filename = $this->data['Webpage']['name'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9.]+/', '-', $this->data['Webpage']['name']), '-'));
			App::uses('Folder', 'Utility');
			App::uses('File', 'Utility');
			$dir = new Folder($this->templateDirectories[0], true, 0755);
			$file = new File($this->templateDirectories[0] . $filename, true, 0644);
			try {
				$file->write($this->data['Webpage']['content'], 'w', true);
				$file->close(); // Be sure to close the file when you're done
				return true;
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		
		if (!empty($this->data['Webpage']['name']) && $this->data['Webpage']['type'] == 'element') {
			// create files for elements too
			$filename = $this->data['Webpage']['name'] = strtolower(trim(preg_replace('/[^a-zA-Z0-9.]+/', '-', $this->data['Webpage']['name']), '-'));
			App::uses('Folder', 'Utility');
			App::uses('File', 'Utility');
			$dir = new Folder($this->elementsDirectory, true, 0755);
			$file = new File($this->elementsDirectory . $filename . '.ctp', true, 0644);
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
			// virtual _usage field
			for ($i = 0; $i < count($results); ++$i) {
				if ($results[$i][$this->alias]['is_default']) {
					$results[$i][$this->alias]['_usage'] = 'Default';
				} elseif (!empty($results[$i][$this->alias]['template_urls'])) {
					$results[$i][$this->alias]['_usage'] = 'Specific Pages';
				} else {
					$results[$i][$this->alias]['_usage'] = 'Not Used';
				}
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
 * @param array			An array of data to get the template, and template settings from * 
 */
    private function _syncTemplateSettings() {
        $templates = $this->find('all', array(
            'conditions' => array(
                'Webpage.type' => 'template'
                ), 
            'fields' => array(
                'Webpage.id',
                'Webpage.name',
                'Webpage.is_default',
                'Webpage.template_urls',
                'Webpage.user_roles',
                'Webpage.modified'
                ),
            'order' => array(
				'Webpage.modified' => 'DESC'
				)
            ));	
		// might need to move this to it's own function if to be used anywhere else.
		// checks for more than one default template being set
		// @todo do it on a per user_role basis, so that you can have defaults per user role
		$defaultTemplates = Set::extract('/Webpage[is_default>0]', $templates);
		if (count($defaultTemplates) > 1) {
			// note : due to order in find statement the first template is the one to keep
			for ($i = 1; $i < count($defaultTemplates); $i++) { // note that we start on one not zero
				// go through the template array and remove the one we don't want
				$templates = ZuhaSet::devalue($templates, $defaultTemplates[$i]);
				// then save the default template again to take away the default setting
				$defaultTemplates[$i]['Webpage']['is_default'] = 0;
				$defaultTemplates[$i]['Webpage']['type'] = 'template'; // database default is content, so this must be set
				$prevId = $this->id;
				$this->create();
				$this->save($defaultTemplates[$i], array('callbacks' => false)); // no callbacks so that it doesn't come back here in an endless loop
				$this->id = $prevId;
			}
			$defaultTemplates = array_values($defaultTemplates); // reset the key index
		}
		
		// now we can save the settings (we've cleaned it so that there is only one default)
        $i = 0;
        $setting['Setting']['value'] = '';
        $setting['Setting']['type'] = 'App';
        $setting['Setting']['name'] = 'TEMPLATES';
        foreach ($templates as $template) {
        	$userRoles = $this->_templateUserRoles($template['Webpage']['user_roles']);
            $value = array('templateName' => $template['Webpage']['name'], 'templateId' => $template['Webpage']['id'], 'isDefault' => $template['Webpage']['is_default'], 'urls' => $this->templateUrls($template), 'userRoles' => $userRoles);
            // deprecated this line in favor of the line right after (so that we can pull the file instead of a db call) 7/22/2013 RK
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
 * Template User Roles
 * If null user roles get all user roles and set it to all.
 * 
 * @param mixed $roles 
 */
 	protected function _templateUserRoles($roles) {
 		if ($template['Webpage']['user_roles'] === null) {
 			App::uses('UserRole', 'Users.Model');
			$UserRole = new UserRole;
			$roles = serialize(Set::extract('/UserRole/id', $UserRole->find('all', array('fields' => array('UserRole.id')))));
 		}
		return $roles;
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
	
/**
 * Placeholder method
 * Data for a placeholder page
 * 
 * @param array $data
 * @param array $options
 * @return array
 */
 	public function placeholder($data = null, $options = array()) {
 		$incoming = $data;
 		// possible options
 		// $data = array of data for a save
 		// $options['type'] = default | carousel | section | plugin; 
		// $options['create'] = true | false;
		switch ($options['type']) {
			case 'section' : 
				$data = $this->_defaultSection($data);
				break; 
			default : 
  				$data['Webpage']['type'] = 'content';
				$data = $this->_defaultContent($data);
		}
		
		if (!empty($options['create'])) {
			$this->create();
			if ($this->save($data)) {
				// saveAll was having a problem because of aliases trying to save twice, so I did this
				if (!empty($data['Child'])) {
					for ($i = 0; $i < count($data['Child']); $i++) {
						$data['Child'][$i]['parent_id'] = $this->id;
					}
					$this->create();
					if ($this->saveMany($data['Child'])) {
						// good nothing needed
					}
				}
				// good nothing needed
			} else {
				throw new Exception(__('Placeholder failed to save.'));
			}
		}
		
		return Set::merge($incoming, $data);
 	}
 	
 /**
  * Default section method
  * 
  * @return array
  */
  	protected function _defaultSection($data) {
		$data['Webpage']['content'] = '<h1>' . $data['Webpage']['name'] . ' Section</h1>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mattis dictum libero, in pretium libero fermentum ut. Ut viverra venenatis eros et ultricies. Aliquam ornare erat purus, a aliquam urna mollis quis. Maecenas eros justo, vulputate et placerat at, varius id leo. Proin rhoncus nulla sit amet leo malesuada, nec molestie ligula aliquam. Etiam nibh quam, consequat at urna ac, commodo euismod mi. Nulla convallis ut purus id tristique.</p>

<p>{element: Webpages.children}</p>';
		$data['Child'][0]['name'] = 'My First ' . $data['Webpage']['name'] . ' Item';
		$data['Child'][0]['title'] = 'My First ' . $data['Webpage']['name'] . ' Item';
		$data['Child'][0]['alias'] = $data['Alias']['name'] . '/item1';
		$data['Child'][0]['content'] = $this->_subitemContent($data, true, 'First');
		$data['Child'][1]['name'] = 'My Second ' . $data['Webpage']['name'] . ' Item';
		$data['Child'][1]['title'] = 'My Second ' . $data['Webpage']['name'] . ' Item';
		$data['Child'][1]['alias'] = $data['Alias']['name'] . '/item2';
		$data['Child'][1]['content'] = $this->_subitemContent($data, true, 'Second');
		$data['ChildMenuItem'][0]['name'] = 'My First ' . $data['Webpage']['name'] . ' Item';
		$data['ChildMenuItem'][0]['item_text'] = 'My First ' . $data['Webpage']['name'] . ' Item';
		$data['ChildMenuItem'][0]['item_url'] = '/' . $data['Alias']['name'] . '/item1';
		$data['ChildMenuItem'][1]['name'] = 'My Second ' . $data['Webpage']['name'] . ' Item';
		$data['ChildMenuItem'][1]['item_text'] = 'My Second ' . $data['Webpage']['name'] . ' Item';
		$data['ChildMenuItem'][1]['item_url'] = '/' . $data['Alias']['name'] . '/item2';
		return $data;
	}
 /**
  * Sub item method
  * 
  * @return array
  */
  	protected function _subitemContent($data, $string = false, $count = 'First') {
  		$name = 'My ' . $count . ' ' . $data['Webpage']['name'].' Item';
  		$data['Webpage']['content'] = '<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/' . $data['Alias']['name'] . '">' . $data['Webpage']['name'] . '</a></li>
	<li class="active">' . $name . '</li>
</ol>
<h1>' . $name . '</h1>

<p><img alt="' . $name . '" src="data:image/gif;base64,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" style="float: left; margin: 0 10px; width: 130px; height: 128px;" />Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non, facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam, orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus. Fusce mi pede, tempor id, cursus ac, ullamcorper nec, enim.</p>

<p>Sed tortor. Curabitur molestie. Duis velit augue, condimentum at, ultrices a, luctus ut, orci. Donec pellentesque egestas eros. Integer cursus, augue in cursus faucibus, eros pede bibendum sem, in tempus tellus justo quis ligula. Etiam eget tortor.  Duis velit augue, condimentum at, ultrices. <a class="btn btn-success btn-small btn-xs" href="/">homepage</a></p>

<h3>Site Data</h3>

<table border="1" cellpadding="1" cellspacing="1" class="table table-striped" style="width: 100%;">
	<tbody>
		<tr>
			<th style="width: 25%;"><strong>Data is Good</strong></th>
			<th><strong>No It&#39;s Not... It&#39;s Awesome!</strong></th>
		</tr>
		<tr>
			<td>10<sup>100</sup> pages</td>
			<td>Dream on.&nbsp; That many pages would be more than there are atoms in the universe.</td>
		</tr>
		<tr>
			<td>...2464195387</td>
			<td>Ha, Such a comedian.&nbsp; Like anyone doesn&#39;t know, that those are the last ten digits of the largest number ever devised and used in a mathematical proof.&nbsp; <a href="http://en.wikipedia.org/wiki/Graham%27s_number" target="_blank">Graham&#39;s Number</a></td>
		</tr>
	</tbody>
</table>

<p>Vestibulum rutrum, est ut placerat elementum, lectus nisl aliquam velit, tempor aliquam eros nunc nonummy metus. In eros metus, gravida a, gravida sed, lobortis id, turpis. Ut ultrices, ipsum at venenatis fringilla, sem nulla lacinia tellus, eget aliquet turpis mauris non enim. Nam turpis. Suspendisse lacinia. Curabitur ac tortor ut ipsum egestas elementum. Nunc imperdiet gravida mauris.</p>

<p>&nbsp;</p>';
  		return $string ? $data['Webpage']['content'] : $data;
  	}


 /**
  * Default content method
  * 
  * @return array
  */
  	protected function _defaultContent($data, $string = false) {
  		$data['Webpage']['content'] = '<h1>'.$data['Webpage']['name'].'</h1>

<p><img alt="'.$data['Webpage']['name'].'" src="data:image/gif;base64,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" style="float: left; margin: 0 10px; width: 130px; height: 128px;" />Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non, facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam, orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus. Fusce mi pede, tempor id, cursus ac, ullamcorper nec, enim.</p>

<p>Sed tortor. Curabitur molestie. Duis velit augue, condimentum at, ultrices a, luctus ut, orci. Donec pellentesque egestas eros. Integer cursus, augue in cursus faucibus, eros pede bibendum sem, in tempus tellus justo quis ligula. Etiam eget tortor.  Duis velit augue, condimentum at, ultrices. <a class="btn btn-success btn-small btn-xs" href="/">homepage</a></p>

<h3>Site Data</h3>

<table border="1" cellpadding="1" cellspacing="1" class="table table-striped" style="width: 100%;">
	<tbody>
		<tr>
			<th style="width: 25%;"><strong>Data is Good</strong></th>
			<th><strong>No It&#39;s Not... It&#39;s Awesome!</strong></th>
		</tr>
		<tr>
			<td>10<sup>100</sup> pages</td>
			<td>Dream on.&nbsp; That many pages would be more than there are atoms in the universe.</td>
		</tr>
		<tr>
			<td>...2464195387</td>
			<td>Ha, Such a comedian.&nbsp; Like anyone doesn&#39;t know, that those are the last ten digits of the largest number ever devised and used in a mathematical proof.&nbsp; <a href="http://en.wikipedia.org/wiki/Graham%27s_number" target="_blank">Graham&#39;s Number</a></td>
		</tr>
	</tbody>
</table>

<p>Vestibulum rutrum, est ut placerat elementum, lectus nisl aliquam velit, tempor aliquam eros nunc nonummy metus. In eros metus, gravida a, gravida sed, lobortis id, turpis. Ut ultrices, ipsum at venenatis fringilla, sem nulla lacinia tellus, eget aliquet turpis mauris non enim. Nam turpis. Suspendisse lacinia. Curabitur ac tortor ut ipsum egestas elementum. Nunc imperdiet gravida mauris.</p>

<p>&nbsp;</p>';
  		return $string ? $data['Webpage']['content'] : $data;
  	}


/**
 * Export method
 * 
 * Export a template to an array that can be used in the templates table
 * 
 * @param int $id
 * @todo Near the file_get_contents($templateFile), we should also validate that the template contents are good (notes about what makes a good template are in the Template model)
 */
	public function export($id) {
		$paths = App::path('View');
		$template = $this->find('first', array('conditions' => array('Webpage.id' => $id, 'Webpage.type' => 'template')));
		if (empty($template)) {
 			throw new NotFoundException(__('Page not found'));
		}
		$templateFile = ROOT.DS.SITE_DIR.DS.'Locale'.DS.'View'.DS.'Layouts'.DS.$template['Webpage']['name'];
		
		if ($templateContent = @file_get_contents($templateFile)) {
			$output[] = array(
				'Webpage' => array(
					'type' => 'template',
					'name' => $template['Webpage']['name'],
					'content' => str_replace(array("\r", "\n"), "", $templateContent)
					),
				);
		} else {
			throw new Exception(__('Cannot export missing %s template file', $template['Webpage']['name']));
		}
		// get all of the {page: some-name} data
		preg_match_all("/(\{page:([^\}\{]*)([0-9]*)([^\}\{]*)\})/", $template['Webpage']['content'], $matches);
        for ($i = 0; $i < sizeof($matches[2]); $i++) {
        	// has to be an actual file
			$file = $paths[2].'Elements'.DS.trim($matches[2][$i]).'.ctp'; // we could support other paths in the future
			if ($elementContent = @file_get_contents($file)) {
				$output[] = array(
					'Webpage' => array(
						'type' => 'element',
						'name' => trim($matches[2][$i]),
						'content' => str_replace(array("\r", "\n"), "", $elementContent)
						)
					);
			} else {
				throw new Exception(__('Cannot export missing %s element file', trim($matches[2][$i])));
			}
		}

		if (defined('__WEBPAGES_DEFAULT_CSS_FILENAMES')) {
			$i = 0;
			foreach (unserialize(__WEBPAGES_DEFAULT_CSS_FILENAMES) as $media => $files) { 
				foreach ($files as $file) {
					if (strpos($file, ',')) {
						if (strpos($file, $template['Webpage']['id'].',') === 0) {
							$name = str_replace($template['Webpage']['id'].',', '', $file);
						}
					} else {
						$name = $file;
					}
					if (!empty($name)) {
						$file = $paths[2].'webroot'.DS.'css'.DS.$name;
						if ($cssContent = file_get_contents($file)) {
							$output[] = array(
								'WebpageCss' => array(
									'type' => $media,
									'name' => $name,
									'content' => str_replace(array("\r", "\n"), "", $cssContent),
									'order' => $i
									)
								);
							unset($name);
						} else {
							throw new Exception(__('Css file %s doesn\'t exist.', $name));
						}
					}
				}
				$i++;
			} 
		}
		
		if (defined('__WEBPAGES_DEFAULT_JS_FILENAMES')) { 
			$i = 0;
			foreach (unserialize(__WEBPAGES_DEFAULT_JS_FILENAMES) as $media => $files) { 
				foreach ($files as $file) {
					if (strpos($file, ',')) {
						if (strpos($file, $template['Webpage']['id'].',') === 0) {
							$file = str_replace($template['Webpage']['id'].',', '', $file);
							$name = $file;
						}
					} else {
						$name = $file;
					}
					if (!empty($name)) {
						$file = $paths[2].'webroot'.DS.'js'.DS.$name;
						if ($jsContent = file_get_contents($file)) {
							$output[] = array(
								'WebpageJs' => array(
									'name' => $name,
									'content' => str_replace(array("\r", "\n"), "", $jsContent),
									'order' => $i
									)
								);
							unset($name);
						} else {
							throw new Exception(__('Js file %s doesn\'t exist.', $name));
						}
					}
				}
				$i++;
			} 
		} 
		
		$install = serialize($output);
		if (unserialize($install)) {
			return array(
				'Template' => array(
					'layout' => $template['Webpage']['name'],
					'is_usable' => 0,
					'install' => serialize($output),
					'icon' => '<div style="height: 0px; padding-bottom: 80%; position:relative; width: 100%; float: left;"><div style="width: 100%; height: 100%; padding: 0; top: 0; position: absolute; background: url(put image data string here) no-repeat;  background-size: cover; border: 1px solid #E3E3E3; border-radius: 1em; overflow: hidden;"></div></div>',
					'description' => 'put a template description here',
					'demo' => 'put demonstration link here',
					'_install' => $output
				)
			);
		} else {
			throw new Exception(__('Content serialization error occurred'));
		}
	}
	
/**
 * Delete File
 * Used to delete files of templates and elements
 * 
 * @param mixed $id
 */
	public function _deleteFile($id) {
		if (!empty($this->_deleteFile)) {
			App::uses('File', 'Utility');
			$file = new File($this->templateDirectories[0] . $this->_deleteFile, true, 0644);
			// Deleting this file
			if ($file->delete()) {
    			$file->close(); // Be sure to close the file when you're done
				return true;
			} else {
    			$file->close(); // Be sure to close the file when you're done
				throw new Exception(__('Template file was not deleted, but db record was, (it will return).'));
			} 
		}
	}
	
/**
 * This Builds the tokens that can be replaced in a string.
 * @param unknown $models
 * @return multitype:
 */	
	public function buildTokens($models = array(), $assoc = false) {
		foreach($models as $model) {
			App::uses($model, ZuhaInflector::pluginize($model).'.Model');
			$Model = new $model();
			$this->tokens[$Model->name] = array_keys($Model->schema());
			if($assoc) {
				$associated = $Model->listAssociatedModels();
				foreach($associated as $assocModel) {
					$this->tokens[$assocModel] = array_keys($Model->$assocModel->schema());
				}
			}
		}
		return $this->tokens;
	}
	
/**
 * Token Replacement function. This will search a string from "tokens" and replace them with the 
 * data provided
 * 
 * @param string $string
 * @param array $data
 * @throws Exception
 * @return $string with all the tokens replaced
 */
	public function replaceTokens($string, $data = array()) {
		if(!empty($tokens)) {
			$this->tokens = $tokens;
		}
		if(empty($data)) {
			throw new Exception('No Data Defined');
		}
		
		foreach($data as $model => $dat) {
			$this->count = '';
			$string = $this->_replaceTokens($string, $dat, $model);
		}
		return $string;
	}
	
/**
 * helper function replaceTokens
 * @param string $string
 * @param array $data
 */
	private function _replaceTokens($string, $data, $prefix = '', $prev = '') {
		$prev = $prefix;
		foreach ($data as $k => $v) {
			if(is_int($k)) {
				$this->count = $k;
			}
			
			if(is_array($v)) {
				$count = empty($this->count) ? '' : '.'.$this->count;
				$prefix = !empty($prefix) ? $prefix.'.'.$k.$count : '';
				$string = $this->_replaceTokens($string, $v, $prefix, $prev);
			}else {
				$pattern = '/\*\|( )('.$prev.'.'.$k.')( )\|\*/is';
				$string = preg_replace ( $pattern , $data[$k] , $string);
			}
		}
		return $string;
	}

	
}
if (!isset($refuseInit)) {
	class Webpage extends AppWebpage {}
}