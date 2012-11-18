<?php
App::uses('AppController', 'Controller');
/**
 * Conditions Controller
 *
 * Conditions are checked after each and every save operation.  The purpose
 * is so that you can automate actions that the app will take based on data 
 * that gets entered into the system.  When conditions saved through this controller
 * are triggered, a templated action is fired.  For example, notifications can have 
 * a notification template, which creates a notification from that template when 
 * the condition is triggered. 
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
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class ConditionsController extends AppController {

	public $name = 'Conditions';

	function index() {
		$this->Condition->recursive = 0;
		$this->set('conditions', $this->paginate());
	}

	public function view($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Condition not found'));
		}
		$this->set('condition', $this->Condition->read(null, $id));
	}

	public function edit() {
		$this->redirect(array('plugin' => 'workflows', 'controller' => 'workflows', 'action' => 'add'));
	}

	public function delete($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Condition not found'));
		}
		if ($this->Condition->delete($id)) {
			$this->Session->setFlash(__('Condition deleted', true));
			$this->redirect(array('action' => 'index'));
		}
	}

}