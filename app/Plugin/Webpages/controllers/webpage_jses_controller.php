<?php
/**
 * WebpagesJses Controller
 *
 * Used to set variables used in the view files for the webpage js plugin. 
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
class WebpageJsesController extends WebpagesAppController {

	var $uses = array('Webpages.WebpageJs');
	var $name = 'WebpageJses';

	function index() {
		$this->WebpageJs->recursive = 0;
		$this->set('webpageJses', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid webpage js', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('webpageJs', $this->WebpageJs->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			try {
				$this->WebpageJs->add($this->data);
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		$webpages = $this->WebpageJs->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('webpages'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid webpage js', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->WebpageJs->update($this->data)) {
				$this->Session->setFlash(__('The webpage js has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The webpage js could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->WebpageJs->read(null, $id);
		}
		$webpages = $this->WebpageJs->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('webpages'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for webpage js', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WebpageJs->remove($id)) {
			$this->Session->setFlash(__('Webpage js deleted', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Error!', true));
			$this->redirect(array('action'=>'index'));
		}
			
	}


	function admin_index() {
		$this->WebpageJs->recursive = 0;
		$this->set('webpageJses', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid webpage js', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('webpageJs', $this->WebpageJs->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->WebpageJs->create();
			if ($this->WebpageJs->add($this->data)) {
				$this->Session->setFlash(__('The webpage js has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The webpage js could not be saved. Please, try again.', true));
			}
		}
		$webpages = $this->WebpageJs->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('webpages'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid webpage js', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->WebpageJs->update($this->data)) {
				$this->Session->setFlash(__('The webpage js has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The webpage js could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->WebpageJs->read(null, $id);
		}
		$webpages = $this->WebpageJs->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('webpages'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for webpage js', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WebpageJs->remove($id)) {
			$this->Session->setFlash(__('Webpage js deleted', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Error!', true));
			$this->redirect(array('action'=>'index'));
		}
			
	}
}
?>