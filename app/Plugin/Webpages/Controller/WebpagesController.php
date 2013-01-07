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
class WebpagesController extends WebpagesAppController {

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
    public $uses = 'Webpages.Webpage';

/**
 * Paginate
 * 
 * @var array
 */
	public $paginate = array('limit' => 10, 'order' => array('Webpage.created' => 'desc'));
	
    // public $components = array('Comments.Comments' => array('userModelClass' => 'User'));

/**
 * Helpers
 * 
 * @var array 
 */
    public $helpers = array('Cke'); 

	// This is part of the search plugin : Removed 11/11/12 RK
    // public $presetVars = array(array('field' => 'name', 'type' => 'value'));
		
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
 * @param string
 * @return void
 */
	public function index($type = 'content') {
        $index = '_index' . ucfirst($type);
        $this->$index();
	}
    
/**
 * Index of type Content
 * 
 * @param type $id
 * @return void
 * @throws NotFoundException
 */
    protected function _indexContent() {
        if ($this->Webpage->find('first', array('conditions' => array('Webpage.parent_id' => 0, 'Webpage.lft' => 0, 'Webpage.rght' => 0)))) {
            // takes care of a bad tree structure (Temporary 11/19/2012 RK)
            $this->Webpage->recover('parent');
        }
        
		$this->paginate['conditions']['Webpage.type'] = 'content';
		$this->paginate['conditions']['OR'][]['Webpage.parent_id'] = 0;
		$this->paginate['conditions']['OR'][]['Webpage.parent_id'] = null;
		$this->paginate['conditions'][] = 'Webpage.lft + 1 =  Webpage.rght'; // find leaf nodes (childless parents) only
		$this->paginate['fields'] = array('id', 'name', 'content', 'modified');
		$this->set('webpages', $this->paginate());
        
		$this->set('sections', $this->Webpage->find('all', array('conditions' => array('Webpage.parent_id NOT' => 0), 'group' => 'Webpage.parent_id', 'contain' => array('Parent'))));
		$this->set('displayName', 'title');
		$this->set('displayDescription', 'content'); 
		$this->set('page_title_for_layout', 'Pages');
		$this->view = 'index_content';
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
		$this->paginate['fields'] = array('Webpage.id', 'Webpage.name', 'Webpage.content', 'Webpage.modified', 'Parent.id', 'Parent.name');
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
    
/**
 * Index pf type Template
 * 
 * @param type $id
 * @return void
 * @throws NotFoundException
 */
    protected function _indexTemplate() {
		$this->paginate['conditions']['Webpage.type'] = 'template';
		$this->paginate['fields'] = array('id', 'name', 'content', 'modified');
		$this->set('webpages', $this->paginate());
        
		$templates = $this->Webpage->syncFiles('template');
		$this->set('displayName', 'title');
		$this->set('displayDescription', 'content'); 
		$this->set('page_title_for_layout', 'Templates');
		$this->layout = 'default';	
		$this->view = 'index_template';
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
		
		$update = $this->Webpage->syncFiles('template'); // template 
		$webpage = $this->Webpage->find("first", array(
		    "conditions" => array(
                'Webpage.id' => $id
                ),
		    'contain' => array(
				'Child'
				)
		    ));
        
		// this is here because an element uses this view function ? What element ? 
		if (!empty($webpage) && isset($this->request->params['requested'])) {
		    return $webpage;
		}
		
		if ($webpage['Webpage']['type'] == 'template') {
				
		} else {
			$userRoleId = $this->Session->read('Auth.User.user_role_id');
			$this->Webpage->parseIncludedPages ($webpage, null, null, $userRoleId, $this->request);
			$webpage['Webpage']['content'] = '<div id="webpage'.$id.'" pageid="'.$id.'">'.$webpage['Webpage']['content'].'</div>';
		}
		
		if ($_SERVER['REDIRECT_URL'] == '/app/webroot/error') {
			$webpage = $this->Webpage->handleError($webpage, $this->request);
		}
		$this->set(compact('webpage'));
		$this->set('page_title_for_layout', $webpage['Webpage']['name']);
       	$this->view = 'view_' . $webpage['Webpage']['type'];	
	}
    
	
/**
 * Add method
 *
 * @param string
 * @return void
 */
	public function add($type = 'content', $parentId = NULL) {
		if (!empty($this->request->data)) {
			try {
				$this->Webpage->saveAll($this->request->data);
				$this->Session->setFlash(__('Saved'));
				$this->redirect(array('action' => 'view', $this->Webpage->id));
			} catch(Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		if (empty($this->Webpage->types[$type])) {
			throw new NotFoundException(__('Invalid content type'));
		}
        
        $add = '_add' . ucfirst($type);
        $this->$add($parentId);
	}
    
    protected function _addContent() {
		$this->request->data['Alias']['name'] = !empty($this->request->params['named']['alias']) ? str_replace('+', '/', $this->request->params['named']['alias']) : null;
		// reuquired to have per page permissions
		$this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		$this->set('page_title_for_layout', __('Page Builder'));
		$this->layout = 'default';	
		$this->view = 'add_content';        
    }
    
    protected function _addSub($parentId) {
		$parent = $this->Webpage->find('first', array('conditions' => array('Webpage.id' => $parentId), 'contain' => array('Child')));
		$this->request->data['Alias']['name'] = !empty($parent['Alias']['name']) ? $parent['Alias']['name'] . '/' : null;
		$this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		$this->set('parent', $parent);
		$this->set('page_title_for_layout', __('<small>Create a subpage of</small> %s', $parent['Webpage']['name']));
		$this->layout = 'default';	
		$this->view = 'add_sub';      
    }
    
    protected function _addElement() {
		// reuquired to have per page permissions
		$this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		$this->set('page_title_for_layout', __('Widget/Element Builder'));
		$this->layout = 'default';	
		$this->view = 'add_element';        
    }
    
    protected function _addTemplate() {
        $this->set('userRoles', $this->Webpage->Creator->UserRole->find('list'));
		$this->set('page_title_for_layout', __('Template Builder'));
		$this->layout = 'default';	
		$this->view = 'add_template';        
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
		if (!empty($this->request->data)) {
			try {
				$this->Webpage->saveAll($this->request->data);
				$this->Session->setFlash(__('Saved'));
				$this->redirect(array('action' => 'view', $this->Webpage->id));
			} catch(Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		$templates = $this->Webpage->syncFiles('template');
		$this->request->data = $this->Webpage->find('first', array('conditions' => array('Webpage.id' => $id), 'contain' => array('Child', 'Alias')));
		$this->request->data = $this->Webpage->cleanOutputData($this->request->data);
		
		// required to have per page permissions
		$userRoles = $this->Webpage->Creator->UserRole->find('list');
		$types = $this->Webpage->types();
		$this->set(compact('userRoles', 'types'));

		if ($this->request->data['Webpage']['type'] == 'template') {
			if (defined('__WEBPAGES_DEFAULT_CSS_FILENAMES')) {
				$cssFiles = unserialize(__WEBPAGES_DEFAULT_CSS_FILENAMES);
				$cssFile = $cssFiles['all'][0];
			} else {
				$cssFile = 'screen';
			}
			$this->set('ckeSettings', array(
				'contentsCss' => '/theme/default/css/'.$cssFile.'.css',
				'buttons' => array('Source')
				));
		} else {
			$this->set('ckeSettings', null);
		}
		// 1/6/2012 rk - $this->set('templateUrls', $this->Webpage->templateUrls($this->request->data));
		$this->set('page_title_for_layout', __('%s Editor', Inflector::humanize($this->Webpage->types[$this->request->data['Webpage']['type']])));
		$this->view = 'edit_' . $this->request->data['Webpage']['type'];
        $this->layout = 'default';
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
			$this->Session->setFlash(__('Webpage deleted', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Webpage could not be deleted.', true));
			$this->redirect(array('action'=>'index'));
		}
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
            if ($this->Webpage->updateTemplateSettings($this->request->data)) {
                $this->Session->setFlash(__('Template applied'));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('Template is already applied, or could not be applied.'));
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
    				$msg = "Page saved";
    			} else {
    				$err = true;
    				$msg = "Can't save page";
    			}
    		} else {
    			$err = true;
    			$msg = 'Page not found';
    		}
    		if($this->RequestHandler->isAjax()) {
    			$this->autoRender = $this->layout = false;
    			echo json_encode(array('msg' => $msg));
    			exit;
    		}
        }
	}
	

/**
 * Parse included elements method
 * 
 * @param string
 * @return void
    public function __parseIncludedElements($content_str) {
        $this->autoRender = $this->layout = false;
        $this->set('content_str', $content_str);
        $content_str = $this->render('webpages/render_content');
        return $content_str;
    }
 */

}