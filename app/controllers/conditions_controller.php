<?php
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
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuhafoundation.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
class ConditionsController extends AppController {

	var $name = 'Conditions';

	function admin_index() {
		$this->Condition->recursive = 0;
		$this->set('conditions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Condition.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('condition', $this->Condition->read(null, $id));
	}

	function admin_edit($id = null) {
		if (!empty($this->data)) {
			if ($this->Condition->save($this->data)) {
				$this->Session->setFlash(__('The Condition has been saved', true));
				$this->redirect(array('plugin' => null, 'controller' => 'conditions', 'action'=>'view', $this->Condition->id));
			} else {
				$this->Session->setFlash(__('The Condition could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Condition->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Condition', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Condition->delete($id)) {
			$this->Session->setFlash(__('Condition deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>