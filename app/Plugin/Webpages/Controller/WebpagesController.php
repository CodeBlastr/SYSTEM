<?php
/**
 * Webpages Controller
 *
 * Used to set variables used in the view files for the webpage plugin. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.webpages.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class WebpagesController extends WebpagesAppController {

	var $name = 'Webpages';
	var $paginate = array('limit' => 10, 'order' => array('Webpage.created' => 'desc'));
	#var $components = array('Comments.Comments' => array('userModelClass' => 'User'));

	/* This is part of the search plugin */
    var $presetVars = array(array('field' => 'name', 'type' => 'value'));
	
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->passedArgs['comment_view_type'] = 'flat';
	}

	function index() {
		if (!empty($this->request->params['named']['type'])) :
			$this->paginate['conditions']['Webpage.type'] = $this->request->params['named']['type'];
		endif;
 
		$this->Webpage->recursive = 0;
		$this->set('webpages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Webpage', true), array('action'=>'index'));
		}
		
		$webpage = $this->Webpage->find("first", array("conditions" => array( "id" => $id)));
		# this is here because an element uses this view function
		if (!empty($webpage) && isset($this->request->params['requested'])) {
        	return $webpage;
        } 
		
		if(!empty($webpage) && is_array($webpage)) {
			if ($webpage['Webpage']['type'] == 'template') $webpage['Webpage']['content'] = '';
			$userRoleId = $this->Session->read('Auth.User.user_role_id');
            $this->Webpage->parseIncludedPages ($webpage, null, null, $userRoleId);
			$webpage['Webpage']['content'] = '<div id="webpage_content" pageid="'.$id.'">'.$webpage['Webpage']['content'].'</div>';
			$this->set('webpage', $webpage);
		} else {
			$this->Session->setFlash(__('Invalid Webpage', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($webpage['Webpage']['title'])) {
			$this->set('title',  $webpage['Webpage']['title']);
		}
	}
	
	function add() {	
		if (!empty($this->request->data)) {
			try {
				$this->Webpage->add($this->request->data);
				$this->Session->setFlash(__('Saved successfully', true));
				$this->redirect(array('action'=>'index'));
			} catch(Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		# reuquired to have per page permissions
		$this->request->data['Alias']['name'] = !empty($this->request->params['named']['alias']) ? $this->request->params['named']['alias'] : null;
		$this->UserRole = ClassRegistry::init('Users.UserRole');
		$userRoles = $this->UserRole->find('list');
		$types = $this->Webpage->types();
    	$this->set(compact('userRoles', 'types'));
	}
	
	function edit($id = null) {		
		if (empty($id) && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Webpage', true));
			$this->redirect(array('action'=>'index'));
		}

		if (!empty($this->request->data)) {
			try {
				$this->Webpage->update($this->request->data);
				$this->Session->setFlash(__('Saved successfully', true));
				$this->redirect(array('action'=>'index'));
			} catch(Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		if (empty($this->request->data)) {
			$this->Webpage->contain('Alias');
			$this->request->data = $this->Webpage->read(null, $id);
			$this->request->data = $this->Webpage->cleanOutputData($this->request->data);
		}
		
		# reuquired to have per page permissions
		$this->UserRole = ClassRegistry::init('Users.UserRole');
		$userRoles = $this->UserRole->find('list');
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
		
		# parse this constant for output back into the form field for editing.
		if (defined('__APP_TEMPLATES')) :
			$templates = unserialize(__APP_TEMPLATES);
			$template = !empty($templates['template'][$id]) ? unserialize(gzuncompress(base64_decode($templates['template'][$id]))): null;			
		endif;
		$templateUrls = !empty($template['urls']) && $template['urls'] != '""' ? implode(PHP_EOL, unserialize(gzuncompress(base64_decode($template['urls'])))) : null;
		$this->set(compact('templateUrls'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Webpage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Webpage->delete($id, true)) {
			$this->Session->setFlash(__('Webpage deleted', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Webpage could not be deleted.', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	

	function savePage ($id = null) {
		$msg   = "";
		$err   = false;
		$pageData =  $this->request->params['form']['pageData'];
		$this->request->data = $this->Webpage->read(null, $id);
		if (!empty($this->request->data)) {
			$this->request->data['Webpage']['content'] = $pageData;
			Inflector::variable("Webpage");
			if ($this->Webpage->save($this->request->data)) {
				$msg = "Page saved";
			}
			else {
				$err = true;
				$msg = "Can't save page";
			}
		}
		else {
			$err = true;
			$msg = 'Page not found';
		}
		if($this->RequestHandler->isAjax()) {
			$this->autoRender = $this->layout = false;
			echo json_encode(array('msg'=> $msg));
			exit;
		}
		//TODO Add response without ajax
	}

	function getRawPage ($id = null) {
		Inflector::variable("Webpage");
		$webpage = $this->Webpage->find("first", array("conditions" => array( "id" => $id)));
		if($this->RequestHandler->isAjax()) {
			$this->autoRender = $this->layout = false;
			echo json_encode(array('page'=> $webpage));
			exit;
		}
		//TODO Add response without ajax
	}
	
	function getRenderPage ($id = null) {
		Inflector::variable("Webpage");
		$webpage = $this->Webpage->find("first", array("conditions" => array( "id" => $id)));
		$userRoleId = $this->Session->read('Auth.User.user_role_id');
		$this->Webpage->parseIncludedPages ($webpage, null, null, $userRoleId);
        $webpage['Webpage']['content'] = $this->__parseIncludedElements($webpage['Webpage']['content']);
		if($this->RequestHandler->isAjax()) {
			$this->autoRender = $this->layout = false;
			echo json_encode(array('page'=> $webpage));
			exit;
		}
		//TODO Add response without ajax
	}
	

    function __parseIncludedElements($content_str) {
        $this->autoRender = $this->layout = false;
        $this->set('content_str', $content_str);
        $content_str = $this->render('webpages/render_content');
        return $content_str;
    }

}
?>