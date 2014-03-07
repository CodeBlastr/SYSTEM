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
		$this->redirect('admin');
		$this->WebpageCss->syncFiles('css');
		$this->paginate['contain'][] = 'Webpage';
		$this->paginate['order']['WebpageCss.webpage_id'] = 'DESC';
		$this->set('webpageCsses', $this->request->data = $this->paginate());
		$this->set('page_title_for_layout', 'CSS Files');
		$this->set('title_for_layout', 'CSS Files');
		return $this->request->data;
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
		$webpageCss = $this->WebpageCss->read(null, $id);
		$this->set('webpageCss', $webpageCss);
		$this->set('page_title_for_layout', $webpageCss['WebpageCss']['name']);
		$this->set('title_for_layout', $webpageCss['WebpageCss']['name']);
		$this->layout = 'default';
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->WebpageCss->create();
			try {
				$this->WebpageCss->theme = $this->theme;
				if ($this->WebpageCss->save($this->request->data)) {
					header("Pragma: no-cache");
					$this->Session->setFlash(__('CSS file created.'), 'flash_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('Error, please try again.', 'flash_warning');
				}
			} catch (Exception $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		$types = $this->WebpageCss->types();
		$webpages = $this->WebpageCss->Webpage->find('list', array('conditions' => array('Webpage.type' => 'template')));
		$this->set(compact('types', 'webpages'));
		$this->layout = 'default';
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
			throw new NotFoundException(__('CSS file not found'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			try {
				$this->WebpageCss->theme = $this->theme;
				if ($this->WebpageCss->save($this->request->data)) {
					$this->Session->setFlash(__('CSS file saved'), 'flash_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('Error, please try again.', 'flash_warning');
				}
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
		$this->set('page_title_for_layout', __('Edit %s', $this->request->data['WebpageCss']['name']));
		$this->set('title_for_layout', __('Edit %s', $this->request->data['WebpageCss']['name']));
		$this->layout = 'default';
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
			throw new NotFoundException(__('Css file not found'));
		}

		if ($this->WebpageCss->remove($id, $this->theme)) {
			$this->Session->setFlash(__('Webpage CSS deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Error!', true), 'flash_danger');
			$this->redirect(array('action'=>'index'));
		}

	}

}