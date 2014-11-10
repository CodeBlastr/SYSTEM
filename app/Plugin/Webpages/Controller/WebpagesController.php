<?php
/**
 * Webpages Controller
 *
 * Used to set variables used in the view files for the webpage plugin. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2012, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.webpages.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class AppWebpagesController extends WebpagesAppController {

/**
 * Name
 * 
 * @var string
 */
	public $name = 'Webpages';

/**
 * Uses
 * 
 * @var string
 */
    public $uses = array('Webpages.Webpage', 'File');

/**
 * Paginate
 * 
 * @var array
 */
	public $paginate = array('limit' => 10, 'order' => array('Webpage.lft' => 'ASC'));

/**
 * Helpers
 * 
 * @var array 
 */
    public $helpers = array('Cke');  // do we need this here anymre?? 7/27/13 RK
	
		
/**
 * Before filter
 * 
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		// $this->passedArgs['comment_view_type'] = 'flat';  11/11/RK 
		
		if (in_array('Drafts', CakePlugin::loaded()) && !empty($this->request->params['named']['draft'])) { 
			$this->Webpage->Behaviors->attach('Drafts.Draftable', array('returnVersion' => $this->request->params['named']['draft']));
		}
	}

/**
 * Index method
 *
 * @param string $type content|g|template|sub
 * @param string|int UUID or Int
 * @return void
 */
	public function index($type = 'content', $id = null) {
        $index = method_exists($this, '_index' . ucfirst($type)) ? '_index' . ucfirst($type) : '_indexContent';
        return $this->$index($type, $id);
	}
	
/**
 * Index of type Content
 * 
 * @param type $id
 * @return void
 */
    protected function _indexContent($type) {
		$this->paginate['conditions']['Webpage.type'] = $type;
		$this->paginate['conditions']['AND']['OR'][]['Webpage.parent_id'] = 0;
		$this->paginate['conditions']['AND']['OR'][]['Webpage.parent_id'] = null;
		$this->paginate['contain']['Child'] = array('order' => array('Child.lft' => 'ASC'));
		$this->set('webpages', $webpages = $this->paginate());
		$this->set('sections', $this->Webpage->find('all', array('conditions' => array('Webpage.parent_id NOT' => 0), 'group' => 'Webpage.parent_id', 'contain' => array('Parent'))));
		$this->set('displayName', 'title');
		$this->set('displayDescription', 'content');
		$this->set('page_title_for_layout', 'Pages');
		$this->set('page_types', $this->Webpage->types());
		$this->view = $this->_fileExistsCheck('index_' . $type . $this->ext) ? 'index_' . $type : 'index_content';
		return $webpages;
    }
	
/**
 * Index of type Section
 * 
 * @param type $id
 * @return void
 */
    protected function _indexSection($type, $id) {
		$this->paginate['conditions']['Webpage.parent_id'] = $id;
		$this->paginate['order'] = 'Webpage.lft'; 
		$this->set('webpage', $webpage = $this->Webpage->find('first', array('conditions' => array('Webpage.id' => $id))));
		$this->set('webpages', $webpages = $this->paginate());
		$this->set('sections', $this->Webpage->find('all', array('conditions' => array('Webpage.parent_id NOT' => 0), 'group' => 'Webpage.parent_id', 'contain' => array('Parent'))));
		$this->set('displayName', 'title');
		$this->set('page_title_for_layout', __('%s', $webpage['Webpage']['name']));
		$this->view = 'index_section';
		return $webpages;
    }
    
/**
 * Index of type Sub of Content
 * 
 * @param type $id
 * @return void
 * @throws NotFoundException
 */
    protected function _indexSub() {
		$this->paginate['conditions']['Webpage.type'] = 'content';
		//$this->paginate['fields'] = array('Webpage.id', 'Webpage.name', 'Webpage.content', 'Webpage.modified', 'Parent.id', 'Parent.name');
		$this->paginate['contain'] = array('Parent');
        $webpages = $this->paginate();
		$this->set(compact('webpages'));
		$this->set('displayName', 'title');
		$this->set('displayDescription', 'content'); 
		$this->set('page_title_for_layout', __('%s <small>Section</small>', $webpages[0]['Parent']['name']));
		$this->layout = 'default';	
		$this->view = 'index_sub';
    }
    
/**
 * Index of type Element
 * 
 * @param type $id
 * @return void
 * @throws NotFoundException
 */
    protected function _indexElement() {
		$this->paginate['conditions']['Webpage.type'] = 'element';
		$this->paginate['fields'] = array('id', 'name', 'content', 'modified');
		$this->set('webpages', $this->paginate());
        
		$this->set('displayName', 'title');
		$this->set('displayDescription', 'content'); 
		$this->set('page_title_for_layout', 'Widgets / Elements');
		$this->layout = 'default';
		$this->view = 'index_element';
    }


    protected function _indexEmail() {
		$this->paginate['conditions']['Webpage.type'] = 'email';
		$this->set('webpages', $this->paginate());
		$this->set('displayName', 'title');
		$this->set('displayDescription', 'content');
		$this->set('page_title_for_layout', 'Email Templates');
		$this->layout = 'default';
		$this->view = 'index_email';
    }
    
/**
 * Index pf type Template
 * 
 * @param type $id
 * @return void
 * @throws NotFoundException
 */
    protected function _indexTemplate() {
    	$this->redirect('admin');
		$this->paginate['limit'] = 50;
		$this->paginate['conditions']['Webpage.type'] = 'template';
		$this->set('webpages', $this->paginate());
        
		App::uses('Template', 'Model');
		$Template = new Template;
		$this->set('templates', $templates = $Template->find('all', array('conditions' => array('Template.install NOT' => null))));
		$sync = $this->Webpage->syncFiles('template');
		$this->view = 'index_template';
		$this->set('page_title_for_layout', 'Site Templates');
		$this->set('title_for_layout', 'Site Templates');
    }
    
    

/**
 * View method
 *
 * @param string
 * @return void
 */
	public function view($id = null) {
		$this->Webpage->id = $id;
		if (!$this->Webpage->exists()) {
			throw new NotFoundException(__('Page not found'));
		}
		
		$page = $webpage = $this->Webpage->find("first", array(
		    "conditions" => array(
                'Webpage.id' => $id
                ),
		    'contain' => array(
				'Child'
				)
		    ));
		// trying router redirect instead
		//$this->aliasCheck($page);

		if ($webpage['Webpage']['type'] == 'template') {
			// do nothing, we don't need to parse template pages, because if we're viewing a template page we want to see the template tags
		} else {
			$this->Webpage->parseIncludedPages ($webpage, null, null, $this->userRoleId, $this->request);
			$webpage['Webpage']['content'] = $this->userRoleId == 1 ? '<div id="webpage'.$id.'" class="edit-box" pageid="'.$id.'">'.$webpage['Webpage']['content'].'</div>' : $webpage['Webpage']['content'];
		}

		if (!empty($this->request->params['requested'])) {
            return $webpage['Webpage']['content'];
        }

		if ($_SERVER['REDIRECT_URL'] == '/app/webroot/error') {
			$webpage = $this->Webpage->handleError($webpage, $this->request);
		}
		$this->set(compact('webpage'));
		$this->set('page_title_for_layout', $webpage['Webpage']['name']);
        $this->set('page', $page['Webpage']['content']); // an unparsed version of the page for the inline editor
       	$this->view = $this->_fileExistsCheck('view_' . $page['Webpage']['type'] . $this->ext) ? 'view_' . $page['Webpage']['type'] : 'view_content';
	}

	// lets try Router::redirect instead
	// public function aliasCheck($data = null) {
		// if (!empty($data['Alias']['name']) && $data['Alias']['name'] != $this->request->alias) {
			// $this->redirect('/' . $this->request->alias);
			// // debug($_SERVER['REQUEST_URI']);
			// // debug($this->request);
			// // debug($data);
		// }
	// }

/**
 * Add method
 *
 * @param string
 * @return void
 */
	public function add($type = 'content', $parentId = null) {
		$this->redirect('admin');
		$this->type = $type;
		if ($this->request->is('post')) {
			try {
				$this->Webpage->saveAll($this->request->data);
				$this->Session->setFlash(__('Saved'), 'flash_success');
				$redirect = !empty($this->request->data['Alias']['name']) ? __('/%s', $this->request->data['Alias']['name']) : array('action' => 'view', $this->Webpage->id);
				$this->redirect($redirect);
			} catch(Exception $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_warning');
			}
		}
		if (!$this->Webpage->types($type)) {
			throw new NotFoundException(__('Invalid content type'));
		}
		$this->set('types', $types = $this->Webpage->types());
		$this->request->data['Webpage']['type'] = $type;
        $add = method_exists($this, '_add' . ucfirst($type)) ? '_add' . ucfirst($type) : '_addContent';
        $this->$add($parentId);
	}
	
    
/**
 * add content page
 */
    protected function _addContent($type = 'content', $parentId = null) {
		$this->request->data['Alias']['name'] = !empty($this->request->params['named']['alias']) ? rtrim(str_replace('+', '/', $this->request->params['named']['alias']), '/') : null;
		// auto add to a webpage menu
		App::uses('WebpageMenu', 'Webpages.Model');
		$WebpageMenu = new WebpageMenu();
		$this->set('parent', $parent = $this->Webpage->find('first', array('conditions' => array('Webpage.id' => $parentId), 'contain' => array('Child'))));
		$this->set('parents', $WebpageMenu->generateTreeList(null, null, null, ' - - '));
		$this->set('menus', $WebpageMenu->find('list', array('fields' => array('WebpageMenu.code', 'WebpageMenu.name'), 'conditions' => array('WebpageMenu.parent_id' => null))));
		// used for converting individual pages to subs of sections
		$this->set('sections', $this->Webpage->find('list', array('conditions' => array('Webpage.parent_id' => null, 'Webpage.type' => array('content', 'section')))));
		// required to have per page permissions
		$this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		// required to have easy template settings
		$this->set('templates', $this->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template', 'Webpage.is_default' => 0))));
		$this->set('page_title_for_layout', __('Page Builder'));
		$this->view = $this->_fileExistsCheck('add_' . $this->type . $this->ext) ? 'add_' . $this->type : 'add_content';       
    }
	
/**
 * add sub page
 * 
 * @param string $parentId
 */
    protected function _addSub($parentId) {
		//Set Parent Properties if parentID is given else creat a new Page Type
		$this->set('parent', $parent = $this->Webpage->find('first', array('conditions' => array('Webpage.id' => $parentId), 'contain' => array('Child'))));
		$this->request->data['Alias']['name'] = !empty($parent['Alias']['name']) ? $parent['Alias']['name'] . '/' : null;
		$this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		$this->set('page_title_for_layout', __('<small>Create a subpage of</small> %s', $parent['Webpage']['name']));
		$this->view = 'add_sub';      
    }
    
/**
 * add element
 */
    protected function _addElement() {
		// reuquired to have per page permissions
		$this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		$this->set('page_title_for_layout', __('Widget/Element Builder'));
		$this->view = $this->request->query['advanced'] ? 'add_element_advanced' : 'add_element';    
    }
    
/**
 * add template
 */
    protected function _addTemplate() {
        $this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		$this->set('page_title_for_layout', __('Template Builder'));
		$this->view = 'add_template';        
    }

    protected function _addEmail() {
        $this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		$this->set('page_title_for_layout', __('Email Builder'));
		$this->view = 'add_email';
    }

/**
 * Edit method
 * 
 * @param string
 * @return void
 */
	public function edit($id = null) {
        $this->Webpage->id = $id;
		if (!$this->Webpage->exists()) {
			throw new NotFoundException(__('Page not found'));
		}
		// save the data
		if ($this->request->is('post') || $this->request->is('put')) {
			try {
				$this->Webpage->saveAll($this->request->data);
				$this->Session->setFlash(__('Saved'), 'flash_success');
				$redirect = !empty($this->request->data['Alias']['name']) ? '/' . $this->request->data['Alias']['name'] : array('admin' => false, 'action' => 'view', $this->Webpage->id);
				$this->request->data['Webpage']['type'] == 'template' ? null : $this->redirect($redirect);
			} catch(Exception $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_warning');
			}
		}
		// how do we move what's contained into the _edit[Type] methods???
		$this->request->data = $this->Webpage->find('first', array(
			'conditions' => array(
				'Webpage.id' => $id
				), 
			'contain' => array(
				'Child',
				'Alias',
				'Parent'
			)));
		$this->request->data = $this->Webpage->cleanOutputData($this->request->data); // this should be specific to the type, and/or afterFind()
		
		// required to have per page permissions
		$this->set('userRoles', $userRoles = $this->Webpage->Creator->UserRole->find('list'));
		$this->set('types', $types = $this->Webpage->types());
		$this->set('type', $type = $this->request->data['Webpage']['type']);
		// defaults (can be over ridden in _edit[Type] method)
		$this->set('page_title_for_layout', __('Edit %s', $this->request->data['Webpage']['name']));
		$this->set('title_for_layout', __('Edit %s', $this->request->data['Webpage']['name']));
		$this->view = $this->_fileExistsCheck('edit_' . $type . $this->ext) ? 'edit_' . $type : 'edit_content';
		// run the type method
        $edit = method_exists($this, '_edit' . ucfirst($type)) ? '_edit' . ucfirst($type) : '_editContent';
        $this->$edit($id);
	}

	public function _editElement($id) {
		if ($this->request->query['advanced']) {
			$this->view = 'edit_element_advanced';
		} else {
			if (strpos($this->request->data['Webpage']['content'], '<?php')) {
				// force the advanced editor
				$this->redirect(array('action' => 'edit', $id, '?' => array('advanced' => true)));
			}
		}
	}

	public function _editTemplate($id) {
		$templates = $this->Webpage->syncFiles('template');
	}

	public function _editContent($id) {
		App::uses('WebpageMenu', 'Webpages.Model');
		$WebpageMenu = new WebpageMenu();
		$this->set('menus', $WebpageMenu->find('list', array('fields' => array('WebpageMenu.code', 'WebpageMenu.name'), 'conditions' => array('WebpageMenu.parent_id' => null))));
		$this->set('parents', $this->Webpage->find('list', array('conditions' => array('Webpage.parent_id' => null, 'Webpage.type' => array('content', 'section')))));
		// required to have easy template settings
		$this->set('templates', $this->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template', 'Webpage.is_default' => 0))));
	}
	
/**
 * Delete method
 * 
 * @param string
 * @return void
 */
	
	public function delete($id = null) {
		$this->Webpage->id = $id;
		if (!$this->Webpage->exists()) {
			throw new NotFoundException(__('Page not found'));
		}
		if ($this->Webpage->delete($id, true)) {
			$this->Session->setFlash(__('Deleted'), 'flash_success');
		} else {
			$this->Session->setFlash(__('Error, could not be deleted.'), 'flash_warning');
		}
		$this->redirect(array('action'=>'index'));
	}
	
	public function delete_element($id = null) {
		$this->request->data['Override']['redirect'] = array('action' => 'index', 'element');
		return $this->delete($id);
	}
	
/**
 * Move a webpage up in the tree (lft = 4, rght = 5  ...  becomes lft = 2, rght = 3)
 */
	public function moveup($id = null, $delta = null) {
	    $this->Webpage->id = $id;
	    if (!$this->Webpage->exists()) {
	       throw new NotFoundException(__('Invalid webpage'));
	    }
	
	    if ($delta > 0) {
	        if ($this->Webpage->moveUp($this->Webpage->id, abs($delta))){
	        	$this->Session->setFlash('Moved up');
	        } else {
	        	$this->Session->setFlash('Error moving, please try again.');
	        }
	    } else {
	        $this->Session->setFlash('Please provide the number of positions the field should be moved down.');
	    }
	
	    return $this->redirect($this->referer());
	}
	
/**
 * Move a webpage down in the tree (lft = 4, rght = 5  ...  becomes lft = 6, rght = 7)
 */
	public function movedown($id = null, $delta = null) {
	    $this->Webpage->id = $id;
	    if (!$this->Webpage->exists()) {
	       throw new NotFoundException(__('Invalid webpage'));
	    }
	
	    if ($delta > 0) {
	        if ($this->Webpage->moveDown($this->Webpage->id, abs($delta))){
	        	$this->Session->setFlash('Moved down');
	        } else {
	        	$this->Session->setFlash('Error moving, please try again.');
	        }
	    } else {
	        $this->Session->setFlash('Please provide the number of positions the field should be moved down.');
	    }
	
	    return $this->redirect($this->referer());
	}
	
/**
 * Save method
 * 
 * Special use case for saving content, widgets, and templates via the admin navbar.  
 * 
 * @param mixed $id - String or integer
 * @return void - Always redirect to the referring page
 */
	public function save($id = null) {
        if (empty($id) && !empty($this->request->data['Webpage']['url'])) {
            if (!empty($this->request->data['Webpage']['id']) && $this->Webpage->updateTemplateSettings($this->request->data)) {
                $this->Session->setFlash(__('Template applied'), 'flash_success');
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('Template is already applied, or could not be applied.'), 'flash_warning');
                $this->redirect($this->referer());
            }
        } else {
            // saves a regular content or widget page
    		$this->render(false);
    		$msg   = "";
    		$err   = false;
    		$pageContent=  $this->request->data;
    		$this->request->data = $this->Webpage->read(null, $id);
    		if (!empty($this->request->data)) {
    			$this->request->data['Webpage']['content'] = $pageContent;
    			if ($this->Webpage->save($this->request->data)) {
    				$msg = __('Page %s saved', $this->request->data['Webpage']['id']);
    			} else {
    				$err = true;
    				$msg = __('Cannot save page id #%s', $this->request->data['Webpage']['id']);
    			}
    		} else {
    			$err = true;
    			$msg = __('Page %s not found', $this->request->data['Webpage']['id']);
    		}
    		if($this->RequestHandler->isAjax()) {
    			$this->autoRender = $this->layout = false;
    			echo json_encode(array('msg' => $msg));
    			exit;
    		}
        }
	}

/**
 * Export method
 * 
 * Export a template to an array that can be used in the templates table
 * 
 * @param int $id
 */
 	public function export($id) {
 		try {
 			$data = $form = $this->Webpage->export($id);
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect($this->referer());
		}
		$form['Template']['install'] = substr($form['Template']['install'], 0, 500);
		if (!unserialize($data['Template']['install'])) {
			debug('data not serialized properly');
			exit;
		}
		
 		if ($this->request->is('post') || $this->request->is('push')) {
 			if (!unserialize($data['Template']['install'])) {
 				debug('serialization error');
				debug($data['Template']['install']);
				exit;
 			}
			$this->request->data['Template']['install'] = $data['Template']['install'];
			debug('Copy and paste this into the app/Config/Schema/schema.php file in the appropriate spot.');
			debug($this->request->data);
			exit;
 		}
		$this->request->data = $form;
		$this->set('page_title_for_layout', __('Export %s', $this->request->data['Template']['layout']));
		$this->set('title_for_layout', __('Export %s', $this->request->data['Template']['layout']));
 	}

/**
 * Copy a page
 */
 	public function copy($id) {
 		$record = $this->Webpage->find('first', array('conditions' => array('Webpage.id' => $id)));
		$newName = $record['Webpage']['name'] . ' (copy)';
		$newAlias = $record['Alias']['name'] . '-copy';
		$fields = array('id', 'name', 'lft', 'rght', 'created', 'modified');
		$record['Webpage'] = $this->_stripFields($record['Webpage'], $fields);
		$record['Alias'] = $this->_stripFields($record['Alias'], $fields);
		$record['Webpage']['name'] = $newName;
		$record['Alias']['name'] = $newAlias;
		if ($this->Webpage->save($record)) {
			$this->Session->setFlash(__('Copied'), 'flash_success');
		} else {
			$this->Session->setFlash(__('Copy failed, please try again.'), 'flash_success');
		}
		$this->redirect($this->referer()); 
 	}

/**
 * Strips unwanted fields from $record, taken from
 * the 'stripFields' setting.
 *
 * @param object $Model Model object
 * @param array $record
 * @return array
 */
	protected function _stripFields($record, $fields) {
		foreach ($fields as $field) {
			if (array_key_exists($field, $record)) {
				unset($record[$field]);
			}
		}

		return $record;
	}

 
 /**
  * Convience Function checks if files exists in sites pat.
  * or in App path this could be moved to the AppController
  * 
  * Probably a better way to do this. 
  * 
  * @param string
  * @return bool
  */
 
	protected function _fileExistsCheck($filename) {
		App::uses('File', 'Utility');
		$return = false;
		if(isset($filename)) {
		 	$path = ROOT . '/' . SITE_DIR . '/Locale/Plugin/' . $this->plugin . '/View/' . $this->viewPath . '/';
			$file = new File($path . $filename);
			$return =  $file->exists();
		}
		if($return == false) {
		 	$path = App::pluginPath($this->plugin) . '/View/' . $this->viewPath . '/';
			$file = new File($path . $filename);
			$return = $file->exists();
		}
	 	return $return;
	}

}

if(!isset($refuseInit)) {
	class WebpagesController extends AppWebpagesController {}
}
