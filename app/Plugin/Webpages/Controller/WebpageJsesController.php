<?php
/**
 * WebpagesJses Controller
 *
 * Used to set variables used in the view files for the webpage js plugin. 
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
 * @link          http://zuha.com Zuha� Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.webpages.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class WebpageJsesController extends WebpagesAppController {

	public $name = 'WebpageJses';
	public $uses = array('Webpages.WebpageJs');

	public function index() {
		$this->WebpageJs->syncFiles('js');
		$this->WebpageJs->recursive = 0;
		$this->paginate['fields'] = array('id', 'name', 'content', 'webpage_id', 'modified');
		
		$this->set('webpageJses', $this->paginate());
		
		$this->set('displayName', 'name');
		$this->set('displayDescription', 'content'); 
		$this->set('page_title_for_layout', 'Javascript Files');
        $this->layout = 'default';
	}

	public function view($id = null) {
		$this->WebpageJs->id = $id;
		if (!$this->WebpageJs->exists()) {
			throw new NotFoundException(__('Js not found'));
		}
		
		$this->WebpageJs->syncFiles('js');
		$webpageJs = $this->WebpageJs->read(null, $id);
		$this->set('webpageJs', $webpageJs);
		$this->set('page_title_for_layout', $webpageJs['WebpageJs']['name']);	
	}

	public function add() {
		if (!empty($this->request->data)) {
			try {
				$this->WebpageJs->add($this->request->data, $this->theme);
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		$webpages = $this->WebpageJs->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('webpages'));
		$this->set('page_title_for_layout', 'Create Javascript File');
	}

	public function edit($id = null) {
		$this->WebpageJs->id = $id;
		if (!$this->WebpageJs->exists()) {
			throw new NotFoundException(__('Js not found'));
		}
		
		if (!empty($this->request->data)) {
			if ($this->WebpageJs->update($this->request->data, $this->theme)) {
				$this->Session->setFlash(__('The webpage js has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The javascript could not be saved. Please, try again.'));
			}
		}
		
		$this->WebpageJs->syncFiles('js');
		$this->request->data = $this->WebpageJs->read(null, $id);
		$jsFileContents = $this->WebpageJs->getJsFileContents($this->request->data['WebpageJs']['name'], $this->theme);
		if($jsFileContents)	{
			$this->request->data['WebpageJs']['content'] = $jsFileContents; 
		}
		$webpages = $this->WebpageJs->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('webpages'));
		
		$this->set('page_title_for_layout', __('Edit %s', $this->request->data['WebpageJs']['name']));	
	}

	public function delete($id = null) {
		$this->WebpageJs->id = $id;
		if (!$this->WebpageJs->exists()) {
			throw new NotFoundException(__('Javascript not found'));
		}
		
		if ($this->WebpageJs->remove($id, $this->theme)) {
			$this->Session->setFlash(__('Javascript file deleted'));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Error!', true));
			$this->redirect(array('action'=>'index'));
		}
			
	}

}