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

/**
 * Index method
 * 
 */
	public function index() {
		$this->WebpageJs->syncFiles('js');
		$this->WebpageJs->recursive = 0;
		$this->paginate['fields'] = array('id', 'name', 'content', 'webpage_id', 'modified');
		
		$this->set('webpageJses', $this->paginate());
		
		$this->set('displayName', 'name');
		$this->set('displayDescription', 'content'); 
		$this->set('page_title_for_layout', 'Javascript Files');
		$this->set('title_for_layout', 'Javascript Files');
        $this->layout = 'default';
	}

/**
 * View method
 * 
 * @param uuid $id
 */
	public function view($id = null) {
		$this->WebpageJs->id = $id;
		if (!$this->WebpageJs->exists()) {
			throw new NotFoundException(__('Js not found'));
		}
		
		$this->WebpageJs->syncFiles('js');
		$this->set('webpageJs', $webpageJs = $this->WebpageJs->read(null, $id));
		$this->set('page_title_for_layout', $webpageJs['WebpageJs']['name']);
		$this->set('title_for_layout', $webpageJs['WebpageJs']['name']);
		$this->layout = 'default';
	}

/**
 * Add method
 * 
 */
	public function add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			try {
				$this->WebpageJs->theme = $this->theme;
				if ($this->WebpageJs->save($this->request->data)) {
					$this->Session->setFlash('Javascript file created.');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('Error, please try again.');
				}
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		$this->set('webpages', $webpages = $this->WebpageJs->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template'))));
		$this->set('page_title_for_layout', 'Create Javascript File');
		$this->set('title_for_layout', 'Create Javascript File');
		$this->layout = 'default';
	}

/**
 * Edit method
 * 
 * @param uuid $id
 */
	public function edit($id = null) {
		$this->WebpageJs->id = $id;
		if (!$this->WebpageJs->exists()) {
			throw new NotFoundException(__('Js not found'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			try {
				$this->WebpageJs->theme = $this->theme;
				if ($this->WebpageJs->save($this->request->data)) {
					$this->Session->setFlash('Javascript file saved.');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('Error, please try again.');
				}
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		$this->WebpageJs->syncFiles('js');
		$this->request->data = $this->WebpageJs->read(null, $id);
		$jsFileContents = $this->WebpageJs->getJsFileContents($this->request->data['WebpageJs']['name'], $this->theme);
		if($jsFileContents)	{
			$this->request->data['WebpageJs']['content'] = $jsFileContents; 
		}
		$this->set('webpages', $webpages = $this->WebpageJs->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template'))));
		$this->set('page_title_for_layout', __('Edit %s', $this->request->data['WebpageJs']['name']));
		$this->set('title_for_layout', __('Edit %s', $this->request->data['WebpageJs']['name']));
		$this->layout = 'default';
	}

/**
 * Delete method
 * 
 * @param uuid $id
 */
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