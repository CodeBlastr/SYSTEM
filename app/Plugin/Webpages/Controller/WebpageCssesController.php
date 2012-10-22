<?php
App::uses('WebpagesAppController', 'Webpages.Controller');
/**
 * WebpagesCsses Controller
 *
 * Used to set variables used in the view files for the webpage css plugin. 
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
class WebpageCssesController extends WebpagesAppController {

	public $name = 'WebpageCsses';
	
	public $uses = 'Webpages.WebpageCss';


/**
 * Edit method
 *
 * @return void
 */
	public function index() {
		$this->WebpageCss->syncFiles('css');
		$this->WebpageCss->recursive = 0;
		$this->paginate['fields'] = array('id', 'name', 'content', 'webpage_id', 'modified');
		
		$this->set('webpageCsses', $this->paginate());
		
		$this->set('displayName', 'name');
		$this->set('displayDescription', 'content'); 
		$this->set('page_title_for_layout', 'Css Files');	
	}


/**
 * Edit method
 *
 * @param string
 * @return void
 */
	public function view($id = null) {
		$this->WebpageCss->id = $id;
		if (!$this->WebpageCss->exists()) {
			throw new NotFoundException(__('Page not found'));
		}
		$this->WebpageCss->syncFiles('css');
		$this->set('webpageCss', $this->WebpageCss->read(null, $id));
		$this->set('page_title_for_layout', $webpageJs['WebpageCss']['name']);	
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		if (!empty($this->request->data)) {
			$this->WebpageCss->create();
			try {
				$this->WebpageCss->add($this->request->data, $this->theme);
				header("Pragma: no-cache"); 
				$this->Session->setFlash(__('The webpage css has been saved', true));
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		$types = $this->WebpageCss->types();
		$webpages = $this->WebpageCss->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('types', 'webpages'));
	}

/**
 * Edit method
 *
 * @param string
 * @return void
 */
	public function edit($id = null) {
		$this->WebpageCss->id = $id;
		if (!$this->WebpageCss->exists()) {
			throw new NotFoundException(__('Css not found'));
		}
		
		if (!empty($this->request->data)) {
			try {
				$this->WebpageCss->update($this->request->data, $this->theme);
				$this->Session->setFlash(__('The webpage css has been saved'));
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		
		$this->WebpageCss->syncFiles('css');
		$this->request->data = $this->WebpageCss->read(null, $id);	
		$cssFileContents = $this->WebpageCss->getCssFileContents($this->request->data['WebpageCss']['name'], $this->theme);
		if($cssFileContents) {
			$this->request->data['WebpageCss']['content'] = $cssFileContents; 
		}
		
		
		$this->set('types', $this->WebpageCss->types());
		$this->set('webpages', $this->WebpageCss->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template'))));
		$this->set('page_title_for_layout', $this->request->data['WebpageCss']['name']);	
	}


/**
 * Delete method
 *
 * @param string
 * @return void
 */
	public function delete($id = null) {
		$this->WebpageCss->id = $id;
		if (!$this->WebpageCss->exists()) {
			throw new NotFoundException(__('Page not found'));
		}
		
		if ($this->WebpageCss->remove($id, $this->theme)) {
			$this->Session->setFlash(__('Webpage css deleted', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Error!', true));
			$this->redirect(array('action'=>'index'));
		}
			
	}
	
}